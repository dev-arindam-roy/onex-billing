@extends('backend.layout.app')

@push('page_style')
<link rel="stylesheet" href="{{ asset('public') }}/master-assets/bs-datepicker/css/bootstrap-datepicker3.min.css"/>
@endpush

@section('page_header', 'Purchase Management')
@section('page_breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('purchase.all-purchases') }}">Purchase Management</a></li>
    <li class="breadcrumb-item active">Add Purchase</li>
@endsection

@section('content_title', 'Add New Purchase & Stock Entry')
@section('content_buttons')
    @if(!empty(old('batch_id')) && !empty(old('vendor_id'))) 
        <a href="{{ route('purchase.add-purchase') }}" class="btn btn-warning btn-sm"><i class="fas fa-sync"></i> Reset - New Entry</a>
    @endif
    <a href="{{ route('purchase.all-purchases') }}" class="btn btn-primary btn-sm"><i class="fas fa-cubes"></i> All Purchases</a>
@endsection

@section('content_body')
<form name="frm" id="frmx" action="{{ route('purchase.save-purchase') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="billNo" class="onex-form-label">Purchase Invoice / Bill No:</label>
            <input type="text" name="bill_no" id="billNo" class="form-control" placeholder="Invoice / Bill" value="{{ old('bill_no') }}" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group" id="bsDatePickerContainer">
            <label for="receivedDate" class="onex-form-label">Received Date: <em>*</em></label>
            <input type="text" name="received_date" id="receivedDate" class="form-control onex-datepicker" readonly="readonly" placeholder="Date" required="required" />
            <input type="hidden" id="todayDateHidden" value="{{ !empty(old('received_date')) ? old('received_date') : date('Y/m/d') }}"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="batchId" class="onex-form-label">Batch No: <em>*</em></label>
            <select name="batch_id" class="form-control onex-select2" id="batchId" required="required" data-placeholder="Select a batch">
                <option value=""></option>
                @if(!empty($batches) && count($batches))
                    @foreach($batches as $k => $v)
                        <option value="{{ $v->id }}" @if(!empty(old('batch_id')) && old('batch_id') == $v->id) selected="selected" @endif>{{ $v->batch_no }} @if(!empty($v->name)) ({{ $v->name }}) @endif</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="vendorId" class="onex-form-label">Vendor/Supplier: <em>*</em></label>
            <select name="vendor_id" class="form-control onex-select2" id="vendorId" required="required" data-placeholder="Select a vendor">
                <option value=""></option>
                @if(!empty($vendors) && count($vendors))
                    @foreach($vendors as $k => $v)
                        <option value="{{ $v->id }}" @if(!empty(old('vendor_id')) && old('vendor_id') == $v->id) selected="selected" @endif>{{ $v->first_name . ' ' . $v->last_name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-md-4">
        
    </div>
    <div class="col-md-2">
        
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="productId" class="onex-form-label">Product: <em>*</em></label>
            <select name="product_id" class="form-control" id="productId" required="required" data-placeholder="Select a product">
                <option value=""></option>
                @if(!empty($productVariants) && count($productVariants))
                    @foreach($productVariants as $k => $v)
                        <option 
                            value="{{ $v->id }}"
                            data-hsn-code="{{ $v->hsn_code }}"
                            data-gst-rate="{{ $v->gst_rate }}"
                            data-price="{{ $v->price }}"
                            data-unit-id="{{ $v->unit_id }}"
                            data-size="{{ $v->size }}"
                            data-color="{{ $v->color }}"
                            data-sku="{{ $v->sku }}">{{ $v->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="productQty" class="onex-form-label">QTY: <em>*</em></label>
            <input type="number" name="product_qty" id="productQty" class="form-control" placeholder="QTY" required="required" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="unitId" class="onex-form-label">Unit: <em>*</em></label>
            <select name="unit_id" class="form-control" id="unitId" required="required" readonly="readonly" style="pointer-events: none;">
                <option value="">Unit</option>
                @if(!empty($units) && count($units))
                    @foreach($units as $k => $v)
                        <option value="{{ $v->id }}">{{ $v->short_name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <blockquote>
            <p>Product Purchase <br/> Price Information</p>
        </blockquote>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="purchasePrice" class="onex-form-label">Purchase Unit Price: <em>*</em></label>
            <input type="number" name="purchase_price" id="purchasePrice" class="form-control" placeholder="Price" required="required" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="gstRate" class="onex-form-label">GST Rate: <em>*</em></label>
            <input type="number" name="gst_rate" id="gstRate" class="form-control" readonly="readonly" placeholder="GST" required="required" value="0.00" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="gstAmount" class="onex-form-label">GST Amount: <em>*</em></label>
            <input type="number" name="gst_amount" id="gstAmount" class="form-control" readonly="readonly" placeholder="Amount" required="required" value="0.00" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="totalAmount" class="onex-form-label">Total Amount: <em>*</em></label>
            <input type="number" name="total_amount" id="totalAmount" class="form-control" readonly="readonly" placeholder="Total" required="required" value="0.00" />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr/>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <blockquote>
            <p>Product Selling <br/> Price Information</p>
        </blockquote>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="salePrice" class="onex-form-label">Sale Unit Price: <em>*</em></label>
            <input type="number" name="sale_price" id="salePrice" class="form-control" placeholder="Price" required="required" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="saleGstRate" class="onex-form-label">GST Rate: <em>*</em></label>
            <input type="number" name="sale_gst_rate" id="saleGstRate" class="form-control" readonly="readonly" placeholder="GST" required="required" value="0.00" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="saleGstAmount" class="onex-form-label">GST Amount: <em>*</em></label>
            <input type="number" name="sale_gst_amount" id="saleGstAmount" class="form-control" readonly="readonly" placeholder="Amount" required="required" value="0.00" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="saleTotalAmount" class="onex-form-label">Total Amount: <em>*</em></label>
            <input type="number" name="sale_total_amount" id="saleTotalAmount" class="form-control" readonly="readonly" placeholder="Total" required="required" value="0.00" />
        </div>
    </div>
</div
</form>
@endsection

@section('content_footer')
<div class="row">
    <div class="col-md-6">
        <button type="button" class="btn btn-success" id="addBtn"><i class="fas fa-plus"></i> Add Purchase</button>
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
    $('#productId').select2({
        width: '100%',
        allowClear: true,
        dropdownPosition: 'below',
        templateResult: format,
        escapeMarkup: function(m) {
            return m;
        }
    });
    function format(data) {
        if (typeof data.id == "undefined" || !data.id) return data.text;
        var _optSize = $(data.element).data('size') ?? '';
        var _optColor = $(data.element).data('color') ?? '';
        var _optSku = $(data.element).data('sku') ?? ''; 
        var $container = $(`<div class="select2-result-repository clearfix">
                <div class="select2-result-repository__meta">
                    <div class="select2-result-repository__title">${data.text}</div>
                    <div class="select2-result-repository__description">SKU:${_optSku} | Size:${_optSize} | Color:${_optColor}</div>
                </div>
            </div>`
        );
        
        return $container;
    }
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
            },
            product_id: {
                required: true,
                digits: true
            },
            unit_id: {
                required: true,
                digits: true
            },
            product_qty: {
                required: true,
                number: true
            },
            purchase_price: {
                required: true,
                number: true
            },
            gst_rate: {
                required: true,
                number: true
            },
            gst_amount: {
                required: true,
                number: true
            },
            total_amount: {
                required: true,
                number: true
            },
            sale_price: {
                required: true,
                number: true
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
            },
            product_id: {
                required: 'Please select a product',
                digits: 'Invalid product id'
            },
            unit_id: {
                required: 'Please select unit',
                digits: 'Invalid unit id'
            },
            product_qty: {
                required: 'Please enter quantity',
                number: 'Accept only number'
            },
            purchase_price: {
                required: 'Please enter purchase price',
                number: 'Accept only number'
            },
            gst_rate: {
                required: 'Please enter GST rate',
                number: 'Accept only number'
            },
            gst_amount: {
                required: 'Please enter GST amount',
                number: 'Accept only number'
            },
            total_amount: {
                required: 'Please enter total amount',
                number: 'Accept only number'
            },
            sale_price: {
                required: 'Please enter sale price',
                number: 'Accept only number'
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
    $('#unitId').on('change', function() {
        if($(this).val() != '') {
            $('#' + $(this).attr('id') + '-error').hide();
        }
        $('#unitId').valid();
    })
    $('body').on('change', '#productId', function () {
        if($(this).val() != '') {
            let productVariantId = $(this).val();
            let gstRate = $("#productId").find(":selected").data("gst-rate");
            let hsnCode = $("#productId").find(":selected").data('hsn-code');
            let price = $("#productId").find(":selected").data('price');
            let unitId = $("#productId").find(":selected").data('unit-id');
            //console.log(productVariantId, gstRate, hsnCode, price, unitId);
            $('#gstRate').val(gstRate);
            $('#saleGstRate').val(gstRate);
            $('#unitId').val(unitId).valid();
            purchasePriceCalculate();
            sellingPriceCalculate();
        }
    });
    $('#productQty').on('blur', function() {
        purchasePriceCalculate();
    });
    $('#purchasePrice').on('blur', function() {
        purchasePriceCalculate();
    });
    $('#salePrice').on('blur', function() {
        sellingPriceCalculate();
    });

    function purchasePriceCalculate() {
        let productQty = ($('#productQty').val() != "" && !isNaN($('#productQty').val())) ? parseFloat($('#productQty').val()) : 0;
        let purchasePrice = ($('#purchasePrice').val() != "" && !isNaN($('#purchasePrice').val())) ? parseFloat($('#purchasePrice').val()) : 0;
        let gstRate = ($('#gstRate').val() != "" && !isNaN($('#gstRate').val())) ? parseFloat($('#gstRate').val()) : 0;
        let unitTotal = productQty * purchasePrice;
        let totalGst = (unitTotal * gstRate) / 100;
        let totalAmount = unitTotal + totalGst;

        $('#gstAmount').val(totalGst.toFixed(2));
        $('#totalAmount').val(totalAmount.toFixed(2));
    }

    function sellingPriceCalculate() {
        let saleGstRate = ($('#saleGstRate').val() != "" && !isNaN($('#saleGstRate').val())) ? parseFloat($('#saleGstRate').val()) : 0;
        let salePrice = ($('#salePrice').val() != "" && !isNaN($('#salePrice').val())) ? parseFloat($('#salePrice').val()) : 0;
        let totalGst = (salePrice * saleGstRate) / 100;
        let totalAmount = salePrice + totalGst;
        $('#saleGstAmount').val(totalGst.toFixed(2));
        $('#saleTotalAmount').val(totalAmount.toFixed(2));
    }

    function checkPurchaseSalePrice()
    {
        if (parseFloat($('#salePrice').val()) >= parseFloat($('#purchasePrice').val())) {
            return true;
        } else {
            return false;
        }
    }

    $('#addBtn').on('click', function() {
        if($("#frmx").valid()) {
            if(!checkPurchaseSalePrice()) {
                displayAlert('error', 'Wrong Pricing', 'Please check the sale price & purchase unit price');
            } else {
                displayLoading();
                $('#addBtn').attr('disabled', 'disabled');
                $("#frmx").submit();
            }
        } else {
            displayAlert('error', 'Oops!', 'Please check all the required fields');
        }
    });
});
</script>
@endpush