@extends('backend.layout.app')

@push('page_style')
<link rel="stylesheet" href="{{ asset('public') }}/master-assets/bs-datepicker/css/bootstrap-datepicker3.min.css"/>
@endpush

@section('page_header', 'Purchase Management')
@section('page_breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('purchase.all-purchases') }}">Purchase Management</a></li>
    <li class="breadcrumb-item active">Edit Purchase</li>
@endsection

@section('content_title', 'Edit Purchase & Stock Adjust')
@section('content_buttons')
    <a href="{{ route('purchase.all-purchases') }}" class="btn btn-primary btn-sm"><i class="fas fa-cubes"></i> All Purchases</a>
@endsection

@section('content_body')
<form name="frm" id="frmx" action="{{ route('purchase.update-purchase', array('id' => $purchase->id)) }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="billNo" class="onex-form-label">Purchase Invoice / Bill No:</label>
            <input type="text" name="bill_no" id="billNo" class="form-control" placeholder="Invoice / Bill" value="{{ $purchase->bill_no }}" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group" id="bsDatePickerContainer">
            <label for="receivedDate" class="onex-form-label">Received Date: <em>*</em></label>
            <input type="text" name="received_date" id="receivedDate" class="form-control onex-datepicker" readonly="readonly" placeholder="Date" required="required" disabled="disabled" />
            <input type="hidden" id="todayDateHidden" value="{{ !empty($purchase->received_date) ? date('Y/m/d', strtotime($purchase->received_date)) : date('Y/m/d') }}"/>
            <input type="hidden" name="disabled_received_date_value" value="{{ !empty($purchase->received_date) ? date('Y/m/d', strtotime($purchase->received_date)) : date('Y/m/d') }}"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="batchId" class="onex-form-label">Batch No: <em>*</em></label>
            <select name="batch_id" class="form-control onex-select2" id="batchId" required="required" data-placeholder="Select a batch" disabled="disabled">
                <option value=""></option>
                @if(!empty($batches) && count($batches))
                    @foreach($batches as $k => $v)
                        <option value="{{ $v->id }}" @if(!empty($purchase->batch_id) && $purchase->batch_id == $v->id) selected="selected" @endif>{{ $v->batch_no }} @if(!empty($v->name)) ({{ $v->name }}) @endif</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="disabled_batch_id_value" value="{{ $purchase->batch_id }}"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="vendorId" class="onex-form-label">Vendor/Supplier: <em>*</em></label>
            <select name="vendor_id" class="form-control onex-select2" id="vendorId" required="required" data-placeholder="Select a vendor" disabled="disabled">
                <option value=""></option>
                @if(!empty($vendors) && count($vendors))
                    @foreach($vendors as $k => $v)
                        <option value="{{ $v->id }}" @if(!empty($purchase->vendor_id) && $purchase->vendor_id == $v->id) selected="selected" @endif>{{ $v->first_name . ' ' . $v->last_name }}</option>
                    @endforeach
                @endif
            </select>
            <input type="hidden" name="disabled_vendor_id_value" value="{{ $purchase->vendor_id }}"/>
        </div>
    </div>
    <div class="col-md-4"></div>
    <div class="col-md-2"></div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="note" class="onex-form-label">Any Note:</label>
            <textarea name="note" id="note" class="form-control" placeholder="Any Note...">{{ $purchase->note }}</textarea> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover onex-datatable nowrap" id="dataTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>QTY</th>
                        <th>Purchase Price</th>
                        <th>Sale Price</th>
                        <th>GST</th>
                        <th>Total</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($purchase->purchaseProducts) && count($purchase->purchaseProducts))
                        @php $sl = 1; @endphp
                        @foreach ($purchase->purchaseProducts as $v)
                            <tr>
                                <td>{{ $sl }}</td>
                                <td>
                                    @if (!empty($v->productVariantInfo))
                                        <span>{{ $v->productVariantInfo->name }}</span><br/>
                                        <span style="font-size:13px;"><strong>{{ $v->productVariantInfo->sku }}</strong></span>
                                    @endif
                                </td>
                                <td>{{ $v->productVariantInfo->size }}</td>
                                <td>{{ $v->productVariantInfo->color }}</td>
                                <td>
                                    {{ str_replace(".00","", $v->product_qty) }}
                                    @if (!empty($v->unitInfo))
                                        {{ $v->unitInfo->short_name }}
                                    @endif
                                </td>
                                <td>{{ number_format($v->purchase_price, 2) }}</td>
                                <td>{{ number_format($v->sale_price, 2) }}</td>
                                <td>{{ str_replace(".00","", $v->gst_rate) }} %</td>
                                <td>{{ number_format($v->total_amount, 2) }}</td>
                                <td>#</td>
                            </tr>
                            @php $sl++; @endphp
                        @endforeach
                            <tr style="background-color: rgba(0, 0, 0, .05);">
                                <td colspan="8" style="text-align: right; font-weight: 600;">Total Bill Amount:</td>
                                <td colspan="2" style="text-align: left; font-weight: 600;"><strong>{{ number_format($purchase->bill_amount, 2) }}</strong></td>
                            </tr>
                            <tr style="background-color: rgba(0, 0, 0, .05);">
                                <td colspan="8" style="text-align: right; font-weight: 600;">Due Amount:</td>
                                <td colspan="2" style="text-align: left; font-weight: 600;"><strong>{{ number_format($purchase->due_amount, 2) }}</strong></td>
                            </tr>
                    @else
                        <tr>
                            <td colspan="9">No purchase items found!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
</form>
@endsection

@section('content_footer')
<div class="row">
    <div class="col-md-6">
        <button type="button" class="btn btn-success" id="updateBtn"><i class="fas fa-plus"></i> Update Purchase</button>
    </div>
    <div class="col-md-6"></div>
</div>
@endsection

@push('page_script')
<script src="{{ asset('public') }}/master-assets/bs-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
@endpush

@push('page_js')
<script>
$(document).ready(function() {
    $('.onex-datepicker').datepicker({
        container: '#bsDatePickerContainer',
        format: 'yyyy/mm/dd',
        endDate: '+0d',
        todayHighlight: true,
        autoclose:true
    });
    $('#receivedDate').datepicker('setDate', $('#todayDateHidden').val());
    $("#frmx").validate({
        errorClass: 'onex-error',
        errorElement: 'div',
        rules: {
            received_date: {
                required: true
            },
            batch_id: {
                required: true,
                digits: true
            },
            vendor_id: {
                required: true,
                digits: true
            }
        },
        messages: {
            received_date: {
                required: 'Please select date'
            },
            batch_id: {
                required: 'Please select batch id',
                digits: 'Invalid batch id'
            },
            vendor_id: {
                required: 'Please select a vendor',
                digits: 'Invalid vendor id'
            }
        },
        errorPlacement: function (error, element) {
            if(element.hasClass('onex-select2')) {
                error.insertAfter(element.parent().find('span.select2-container'));
            } else if(element.parent().hasClass('input-group')) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    $('body').on('select2:select', '.onex-select2', function (e) { 
        if($(this).val() != '') {
            $('#' + $(this).attr('id') + '-error').hide();
            $(this).next('span.select2-container').removeClass('select2-custom-error');
            $(this).parent().find('.onex-form-lebel').removeClass('onex-error-label');
        }
    });

    $('#updateBtn').on('click', function() {
        if($("#frmx").valid()) {
            displayLoading();
            $('#updateBtn').attr('disabled', 'disabled');
            $("#frmx").submit();
        } else {
            displayAlert('error', 'Oops!', 'Please check all the required fields');
        }
    });
});
</script>
@endpush