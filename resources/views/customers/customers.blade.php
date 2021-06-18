@extends('layouts.master')
@section('title')
   شاشة العملاء
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">  العملاء</span>
						</div>
					</div>
				
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
	<!-- row -->
				<div class="row">
				@if(session()->has('Add'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
				   <strong>{{ session()->get('Add') }}</strong>
				   <button type="button" class="close" data-dismiss="alert" aria-label="close">
				      <!-- <span aria-hidden="true">$times;</span> -->
				   </button>
				</div>
				@endif

				@if(session()->has('Error'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
				   <strong>{{ session()->get('Error') }}</strong>
				   <button type="button" class="close" data-dismiss="alert" aria-label="close">
				      <!-- <span aria-hidden="true">$times;</span> -->
				   </button>
				</div>
				@endif

				@if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                          </ul>
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                           </button>
                           </div>
                @endif
				<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
								<a class="btn ripple btn-primary" style="width:100%"  data-target="#modaldemo1" data-toggle="modal" href="">اضافة قسم</a>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1">
										<thead>
											<tr>
											    <th class="wd-15p border-bottom-0">#</th>
												<th class="wd-15p border-bottom-0">اسم العميل</th>
												<th class="wd-15p border-bottom-0"> تليفون 1 </th>
												<th class="wd-15p border-bottom-0"> تليفون 2 </th>
												<th class="wd-15p border-bottom-0"> رقم البطاقة </th>
												<th class="wd-15p border-bottom-0"> الإيميل </th>
												<th class="wd-15p border-bottom-0"> العنوان </th>
												<th class="wd-15p border-bottom-0"> ملاحظات </th>
											</tr>
										</thead>
										<tbody>
										<?php $i=0 ?>
										@foreach($customers as $customers)
										    <?php $i++ ?>
											<tr>
												<td>{{$i}}</td>
												<td>{{$customers->Customer_name}}</td>
												<td>{{$customers->PhoneNumber1}}</td>
												<td>{{$customers->PhoneNumber2}}</td>
												<td>{{$customers->email}}</td>
												<td>{{$customers->idnumber}}</td>
												<td>{{$customers->Customer_Address}}</td>
												<td>{{$customers->description}}</td>
												<td>
												<!-- <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
												   data-id="{{$section->id}}" data-section_name="{{$section->section_name}}"
												   data-description="{{$section->description}}" data-toggle="modal" href="#editsectionmodal"
												   title="تعديل"><i class="las la-pen"></i></a>
												 </a> -->
											 <button type="button" class="modal-effect btn btn-sm btn-info" data-effect="effect-scale" data-toggle="modal"
                                                     data-target="#editsectionmodal{{ $customers->id }}"
                                                     title="تعديل"><i class="las la-pen"></i>
												</button>
												<button type="button" class="modal-effect btn btn-danger btn-sm" data-effect="effect-scale" data-toggle="modal"
                                                     data-target="#deletesectionmodal{{ $customers->id }}"
                                                     title="حذف"><i class="las la-trash"></i>
												</button>
												
												</td>
											</tr>

										
											<!-- editsectionmodal -->
											<div class="modal" id="editsectionmodal{{ $customers->id }}">
												<div class="modal-dialog" role="document">
													<div class="modal-content modal-content-demo">
														<div class="modal-header">
															<h6 class="modal-title">تعديل بيانات العميل</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
														</div>
														
															<form action="{{route('','test')}}" method="post">
															{{method_field('patch')}}
															@csrf
															<div class="modal-body">
																<div class="form-group">
																	<label>إسم القسم</label>
																	<input type="text" class="form-control" id="section_name" name="sectionname"  value="{{ $section->section_name }}"
																			autocomplete="off" required>
																	<input type="hidden" class="form-control" id="sectionid" name="sectionid"  value="{{ $section->id }}"
																			autocomplete="off" required>
																</div>
														
																<div class="form-group">
																	<label>ملاحظات</label>
																	<textarea  class="form-control" id="description1" name="description1" rows="3" >{{ $section->description }}</textarea>
																</div>
																</div>
																<div class="modal-footer">
																<button class="btn ripple btn-primary" type="submit">حفظ القسم</button>
																<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
															</div>
															</form>
														
													</div>
												</div>
											</div>
											<!-- editsectionmodal -->

											<!-- deletesectionmodal -->
											<div class="modal" id="deletesectionmodal{{ $section->id }}">
												<div class="modal-dialog" role="document">
													<div class="modal-content modal-content-demo">
														<div class="modal-header">
															<h6 class="modal-title">حذف قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
														</div>
														
															<form action="{{route('sections.destroy','test')}}" method="post">
															{{method_field('Delete')}}
															@csrf
															<div class="modal-body">
																<div class="form-group">
																	<label>إسم القسم</label>
																	<input type="text" class="form-control" id="section_name" name="sectionname"  value="{{ $section->section_name }}"
																			autocomplete="off" disabled>
																	<input type="hidden" class="form-control" id="sectionid" name="sectionid"  value="{{ $section->id }}"
																			autocomplete="off" required>
																</div>
																</div>
																<div class="modal-footer">
																<button class="btn ripple btn-primary" type="submit">حذف القسم</button>
																<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
															</div>
															</form>
														
													</div>
												</div>
											</div>
											<!--deletesectionmodal -->

										@endforeach;
										</tbody>
									</table>
								</div>
							</div>
						</div>
			
				</div>

                
		<!-- Add Section modal -->

		<div class="modal" id="modaldemo1">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					
						<form action="{{route('sections.store')}}" method="post">
						   {{csrf_field()}}
						   <div class="modal-body">
						      <div class="form-group">
							     <label>إسم القسم</label>
								 <input type="text" class="form-control" id="section_name" name="section_name"  autocomplete="off" required>
							  </div>
					
							  <div class="form-group">
							     <label>ملاحظات</label>
								 <textarea  class="form-control" id="description" name="description" rows="3"></textarea>
							  </div>
				        	</div>
							<div class="modal-footer">
					    	<button class="btn ripple btn-primary" type="submit">حفظ القسم</button>
					    	<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
					       </div>
						</form>
					
				</div>
			</div>
		</div>
		<!-- Add Section modal -->
	  </div>
		<!-- row closed -->
		</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>

<!-- Internal Modal js-->

<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<!-- <script>
  $('#editsectionmodal').on('show.bs.modal',function(event){
	  var button=$(event.relatedTarget)
	  var id=button.data('id')
	  var sname=button.data('section_name')
	  var descrpt=button.data('description')
	  var modal=$(this)
	  modal.find('.modal-body #id').val(id);
	  modal.find('.modal-body #section_name').val(section_name);
	  modal.find('.modal-body #note').val(note);

  })
</script> -->
@endsection