@extends('layouts.master')
@section('title')
    تفاصيل الفاتورة
@stop
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتورة</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
	
@if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

	@if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


@if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
				<!-- row -->
				<div class="row">
				<div class="d-md-flex">
					<div class="">
						<div class="panel panel-primary tabs-style-4">
							<div class="tab-menu-heading">
								<div class="tabs-menu ">
									<!-- Tabs -->
									<ul class="nav panel-tabs">
										<li class=""><a href="#tab21" class="active" data-toggle="tab"><i class="fa fa-laptop"></i> بيانات الفاتورة  </a></li>
										<li><a href="#tab22" data-toggle="tab"><i class="fa fa-cube"></i> حالات الدفع  </a></li>
										<li><a href="#tab23" data-toggle="tab"><i class="fa fa-cogs"></i> مرفقـات الفاتورة  </a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="tabs-style-4">
						<div class="panel-body tabs-menu-body">
							<div class="tab-content">
								<div class="tab-pane active" id="tab21">
								<div class="table-responsive mt-15">

									<table class="table table-striped" style="text-align:center">
										<tbody>
											<tr>
												<th scope="row">رقم الفاتورة</th>
												<td>{{ $invoices->invoice_number }}</td>
												<th scope="row">تاريخ الاصدار</th>
												<td>{{ $invoices->invoice_Date }}</td>
												<th scope="row">تاريخ الاستحقاق</th>
												<td>{{ $invoices->Due_date }}</td>
												<th scope="row">القسم</th>
												<td>{{ $invoices->sections->section_name }}</td>
											</tr>

											<tr>
												<th scope="row">المنتج</th>
												<td>{{ $invoices->product }}</td>
												<th scope="row">مبلغ التحصيل</th>
												<td>{{ $invoices->Amount_collection }}</td>
												<th scope="row">مبلغ العمولة</th>
												<td>{{ $invoices->Amount_Commission }}</td>
												<th scope="row">الخصم</th>
												<td>{{ $invoices->Discount }}</td>
											</tr>


											<tr>
												<th scope="row">نسبة الضريبة</th>
												<td>{{ $invoices->Rate_VAT }}</td>
												<th scope="row">قيمة الضريبة</th>
												<td>{{ $invoices->Value_VAT }}</td>
												<th scope="row">الاجمالي مع الضريبة</th>
												<td>{{ $invoices->Total }}</td>
												<th scope="row">الحالة الحالية</th>

												@if ($invoices->Value_Status == 1)
													<td><span
															class="badge badge-pill badge-success">{{ $invoices->Status }}</span>
													</td>
												@elseif($invoices->Value_Status ==2)
													<td><span
															class="badge badge-pill badge-danger">{{ $invoices->Status }}</span>
													</td>
												@else
													<td><span
															class="badge badge-pill badge-warning">{{ $invoices->Status }}</span>
													</td>
												@endif
											</tr>

											<tr>
												<th scope="row">ملاحظات</th>
												<td>{{ $invoices->note }}</td>
											</tr>
										</tbody>
									</table>
									
								</div>

								</div>
								<div class="tab-pane" id="tab22">
								<div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table-hover"
                                                    style="text-align:center">
                                                    <thead>
                                                        <tr class="text-dark">
                                                            <th>#</th>
                                                            <th>رقم الفاتورة</th>
                                                            <th>نوع المنتج</th>
                                                            <th>القسم</th>
                                                            <th>حالة الدفع</th>
                                                            <th>تاريخ الدفع </th>
                                                            <th>ملاحظات</th>
                                                            <th>تاريخ الاضافة </th>
                                                            <th>المستخدم</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0; ?>
                                                        @foreach ($deatils as $x)
                                                            <?php $i++; ?>
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>{{ $x->invoice_number }}</td>
                                                                <td>{{ $x->product }}</td>
                                                                <td>{{ $invoices->sections->section_name }}</td>
                                                                @if ($x->Value_Status == 1)
                                                                    <td><span
                                                                            class="badge badge-pill badge-success">{{ $x->Status }}</span>
                                                                    </td>
                                                                @elseif($x->Value_Status ==2)
                                                                    <td><span
                                                                            class="badge badge-pill badge-danger">{{ $x->Status }}</span>
                                                                    </td>
                                                                @else
                                                                    <td><span
                                                                            class="badge badge-pill badge-warning">{{ $x->Status }}</span>
                                                                    </td>
                                                                @endif
                                                                <td>{{ $x->Payment_Date }}</td>
                                                                <td>{{ $x->note }}</td>
                                                                <td>{{ $x->created_at }}</td>
                                                                <td>{{ $x->user }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>


                                            </div>
								</div>
								<div class="tab-pane" id="tab23">
								<!-- اضافة مرفقات  -->
								<div class="card-body">
                                                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                        <h5 class="card-title">اضافة مرفقات</h5>
                                                        <form method="post" action="{{ route('InvoiceAttachments.store') }}"
                                                            enctype="multipart/form-data">
                                                            {{ csrf_field() }}
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile"
                                                                    name="file_name" required>
                                                                <input type="hidden" id="customFile" name="invoice_number"
                                                                    value="{{ $invoices->invoice_number }}">
                                                                <input type="hidden" id="invoice_id" name="invoice_id"
                                                                    value="{{ $invoices->id }}">
                                                                <label class="custom-file-label" for="customFile">حدد
                                                                    المرفق</label>
                                                            </div><br><br>
                                                            <button type="submit" class="btn btn-primary btn-sm "
                                                                name="uploadedFile">تاكيد</button>
                                                        </form>
                                                    </div>
			        <!-- اضافة مرفقات  -->

								<table class="table center-aligned-table mb-0 table table-hover"
                                                        style="text-align:center">
                                                        <thead>
                                                            <tr class="text-dark">
                                                                <th scope="col">م</th>
                                                                <th scope="col">اسم الملف</th>
                                                                <th scope="col">قام بالاضافة</th>
                                                                <th scope="col">تاريخ الاضافة</th>
                                                                <th scope="col">العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; ?>
                                                            @foreach ($attachments as $attachment)
                                                                <?php $i++; ?>
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $attachment->file_name }}</td>
                                                                    <td>{{ $attachment->Created_by }}</td>
                                                                    <td>{{ $attachment->created_at }}</td>
                                                                    <td colspan="3">

                                                                        <a class="btn btn-outline-success btn-sm"
                                                                            href="{{ url('View_file') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                            role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                            عرض</a>

                                                                        <a class="btn btn-outline-info btn-sm"
                                                                            href="{{ url('download') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                            role="button"><i
                                                                                class="fas fa-download"></i>&nbsp;
                                                                            تحميل</a>
																			<button class="btn btn-outline-danger btn-sm" type="button" 
																			    data-toggle="modal"
                                                                                data-target="#delete_file{{ $attachment->id}}">
																						حذف
                                                                    </td>
                                                                </tr>
																   <!-- delete -->
																	<div class="modal fade" id="delete_file{{ $attachment->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
																		aria-hidden="true">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
																					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																						<span aria-hidden="true">&times;</span>
																					</button>
																				</div>
																				<form action="route{{'delete_file'}}" method="post">
																				{{method_field('Delete')}}
															                      @csrf
																					<!-- {{ csrf_field() }} -->
																					<div class="modal-body">
																						<p class="text-center">
																						<h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
																						</p>

																						<input type="hidden" name="id_file" id="id_file" value="{{$attachment->id}}">
																						<input type="text" readonly name="file_name" id="file_name" value="{{$attachment->file_name}}">
																						<input type="hidden" name="invoice_number" id="invoice_number" value="{{ $attachment->invoice_number }}">

																					</div>
																					<div class="modal-footer">
																						<button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
																						<button type="submit" class="btn btn-danger">تاكيد</button>
																					</div>
																				</form>
																			</div>
																		</div>
																	</div>
																	   <!-- delete -->

                                                            @endforeach
                                                        </tbody>
                                                        </tbody>
                                                    </table>
								</div>
								
							</div>
						</div>
					</div>
				</div>


				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection