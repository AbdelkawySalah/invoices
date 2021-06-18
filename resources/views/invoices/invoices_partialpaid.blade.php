@extends('layouts.master')
@section('title')
قائمة الفواتير المدفوعة جزئيا
@stop

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

<!--Internal   Notify -->
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير المدفوعة جزئيا</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

@if (session()->has('update_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تحديث حالة الفاتورة بنجاح",
                    type: "success"
                })
            }

        </script>
@endif
@if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }

        </script>
@endif

@if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

	@if (session()->has('Edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
				<!-- row -->
				<div class="row">
				<div class="col-xl-12">
						<div class="card">
						<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<!-- <a class="btn btn-outline-primary btn-block"   href="{{route('invoices.create')}}">اضافة فاتورة</a> -->
									<!-- <a href="{{route('invoices.create')}}" class="modal-effect btn btn-md btn-primary" style="color:white"><i -->
									<a href="invoices/create" class="modal-effect btn btn-md btn-primary" style="color:white"><i
										class="fas fa-plus"></i>
										&nbsp; اضافة فاتورة
									</a>
								</div>
						</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1">
										<thead>
											<tr>
											    <th class="wd-15p border-bottom-0">#</th>
												<th class="wd-15p border-bottom-0">رقم القاتورة</th>
												<th class="wd-15p border-bottom-0">تاريخ الفاتورة</th>
												<th class="wd-20p border-bottom-0">تاريخ الاستحقاق</th>
												<th class="wd-15p border-bottom-0">المنتج</th>
												<th class="wd-10p border-bottom-0">القسم</th>
												<th class="wd-25p border-bottom-0">مبلغ الفاتورة</th>
												<th class="wd-25p border-bottom-0">العموله </th>
												<th class="wd-25p border-bottom-0">الخصم</th>
												<th class="wd-25p border-bottom-0">نسبة الضريبة</th>
												<th class="wd-25p border-bottom-0">قيمة الضريبة</th>
												<th class="wd-25p border-bottom-0">الاجمالي</th>
												<th class="wd-25p border-bottom-0">الحالة</th>
												<th class="wd-25p border-bottom-0">ملاحظات</th>
												<th class="wd-25p border-bottom-0">العمليات</th>
											</tr>
										</thead>
										<tbody>
										@php
										$i=0
										@endphp
										@foreach($invoices as $invoice)
										<?php $i++ ?>
											<tr>
												<td>{{$i}}</td>
												<td>
												  <a href="{{url('invoicesDetails')}}/{{$invoice->id}}">
										      		{{$invoice->invoice_number}}
												</a>
												</td>
												<td>{{$invoice->invoice_Date}}</td>
												<td>{{$invoice->Due_date}}</td>
												<td>{{$invoice->product}}</td>
												<td>{{$invoice->sections->section_name}}</td>
												<td>{{$invoice->Amount_collection}}</td>
												<td>{{$invoice->Amount_Commission}}</td>
												<td>{{$invoice->Discount}}</td>
												<td>{{$invoice->Rate_VAT}}</td>
												<td>{{$invoice->Value_VAT}}</td>
												<td>{{$invoice->Total}}</td>
												<td>
												@if ($invoice->Value_Status == 1)
                                                <span class="text-success">{{ $invoice->Status }}</span>
                                                @elseif($invoice->Value_Status == 2)
                                                <span class="text-danger">{{ $invoice->Status }}</span>
                                                @else
                                                <span class="text-warning">{{ $invoice->Status }}</span>
                                                @endif
												</td>
												<td>{{$invoice->note}}</td>
												<td>
												<div class="row row-xs wd-xl-80p">
												<div class="col-sm-6 col-md-3">
													<button data-toggle="dropdown" class="btn btn-indigo btn-block"> <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
													<div class="dropdown-menu">
														<a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
														 data-toggle="modal" data-target="#delete_invoice"><i
														 class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
														  الفاتورة</a>
														<div class="dropdown-divider"></div>
												  	<!-- <a class="btn btn-outline-success btn-block" href="{{url('PaymentstatusChange')}}/{{$invoice->id}}">تغيير حالة الدفع</a> -->
													<!-- <a class="btn btn-outline-success btn-block" href="{{ url('Status_update')}}/{{$invoice->id}}">تغيير حالة الدفع</a> -->
														<a class="dropdown-item" href="{{ route('Status_show',[$invoice->id]) }}">تغيير حالة الدفع</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" href="{{url('edit_invoice')}}/{{$invoice->id}}"><i
														 class="text-danger fas fa-pen-alt"></i>&nbsp;&nbsp;تعديل فاتورة</a>

														</div>
                                                          </div>
                                                        </div>
												</div>
													<!-- </div> -->
													
												</div>
												</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
				</div>
				<!--/div-->
					
					<!-- حذف الفاتورة -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الحذف ؟
                    <input type="text" name="invoice_id" id="invoice_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>
						<!-- حذف الفاتورة -->

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

 <!--Internal  Notify js -->
 <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
 <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

<!--Delete Script -->
<!-- كود ده مسئول عن وضع قيمه الفاتورة في ميدولا بتاعتي -->

<script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })

    </script>
@endsection