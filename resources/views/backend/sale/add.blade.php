@extends('backend.layout.app')

@push('page_style')
<link rel="stylesheet" href="{{ asset('public') }}/master-assets/bs-datepicker/css/bootstrap-datepicker3.min.css"/>
@endpush

@section('page_header', 'Sale Management')
@section('page_breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sale.index') }}">Sale Management</a></li>
    <li class="breadcrumb-item active">Create Sale</li>
@endsection

@section('content_title', 'Add New Sale & Stock Out')
@section('content_buttons')
    <button type="button" class="btn btn-success btn-sm cart-reload-btn d-none"><i class="fas fa-sync"></i></button>
    <button type="button" class="btn btn-danger btn-sm d-none" id="cancleSaleBtn"><i class="fas fa-ban"></i> Cancel Sale </button>
    <a href="{{ route('sale.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-cubes"></i> All Sales</a>
@endsection

@section('content_body')
<span class="placeholder col-6"></span>
<form name="frm" id="frmx" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="invoiceNo" class="onex-form-label">Sale Invoice / Bill No:</label>
            <input type="text" name="invoice_no" id="invoiceNo" class="form-control" placeholder="Invoice / Bill" readonly="readonly" required="required" value="{{ !empty($invoice_no) ? $invoice_no : '' }}" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group" id="bsDatePickerContainer">
            <label for="saleDate" class="onex-form-label">Sale Date: <em>*</em></label>
            <input type="text" name="sale_date" id="saleDate" class="form-control onex-datepicker" readonly="readonly" placeholder="Date" required="required" />
            <input type="hidden" id="todayDateHidden" value="@if(Session::has('cart_info') && !empty(Session::get('cart_info'))) {{ date('Y/m/d', strtotime(Session::get('cart_info')['sale_date'])) }} @else {{ date('Y/m/d') }} @endif"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="customerId" class="onex-form-label">Select Customer: <em>*</em></label>
            <select name="customer_id" class="form-control onex-select2" id="customerId" required="required" data-placeholder="Select a customer" @if(Session::has('cart_info') && !empty(Session::get('cart_info'))) readonly="readonly" style="pointer-events: none;" @endif>
                <option value=""></option>
                @if(!empty($customers) && count($customers))
                    @foreach($customers as $k => $v)
                        <option value="{{ $v->hash_id }}" @if(Session::has('cart_info') && !empty(Session::get('cart_info')) && Session::get('cart_info')['customer']->hash_id == $v->hash_id) selected="selected" @endif>{{ $v->first_name }} {{ $v->last_name }} - {{ $v->phone_number }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="productId" class="onex-form-label">Product: <em>*</em></label>
            <select name="product_id" class="form-control onex-select2" id="productId" required="required" data-placeholder="Select a product">
                <option value=""></option>
                @if(!empty($productVariants) && count($productVariants))
                    @foreach($productVariants as $k => $v)
                        <option 
                            value="{{ $v->id }}"
                            data-hsn-code="{{ $v->hsn_code }}"
                            data-gst-rate="{{ $v->gst_rate }}"
                            data-price="{{ $v->price }}"
                            data-unit-id="{{ $v->unit_id }}">{{ $v->name }} ({{ $v->sku }}) - {{ $v->barcode_no }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="batchId" class="onex-form-label">Batch No: <em>*</em></label>
            <select name="batch_id" class="form-control onex-select2" id="batchId" required="required" data-placeholder="Select a batch">
                <option value=""></option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="salePrice" class="onex-form-label">Unit Price: <em>*</em></label>
            <input type="number" name="sale_price" id="salePrice" class="form-control" placeholder="Price" required="required" />
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
    <div class="col-md-4">
        <button type="button" class="btn btn-primary btn-sm" id="addItemBtn"><i class="fas fa-plus"></i> Add Item</button>
        <button type="button" class="btn btn-success btn-sm cart-reload-btn d-none"><i class="fas fa-sync"></i></button>
    </div>
    <div class="col-md-8" style="text-align:right;">
        <div style="color: #a5a5a5; margin-top: 12px; margin-right: 2px; font-weight: 600;">Items: <span id="cartItemCount">({{ !empty(Session::get('cart')) ? count(Session::get('cart')) : 0 }})</span></div>
    </div>
</div>

<!-- For Item Entry In Add To Cart Table -->
<input type="hidden" name="hidden_current_stock" id="currentStock" />
<input type="hidden" name="hidden_purchase_product_id" id="purchaseProductId" />
<input type="hidden" name="hidden_batch_product_id" id="batchProductId" />
<input type="hidden" name="hidden_batch_purchase_price" id="batchPurchasePrice" />
<input type="hidden" name="hidden_batch_sale_price" id="batchSalePrice" />
<input type="hidden" name="hidden_batch_quantity" id="batchQuantity" />
</form>


<!-- Cart Table JSON From SESSION -->
<input type="hidden" id="cartTableJson" @if(Session::has('cart') && !empty(Session::get('cart'))) value="{{ json_encode(Session::get('cart')) }}" @endif />

<div class="row mt-2">
    <div class="col-md-12">
        <table class="table table-sm table-striped table-bordered table-hover" id="addToCartTable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>PRODUCT</th>
                    <th>HSN</th>
                    <th>QTY</th>
                    <th>UNIT PRICE</th>
                    <th>GST</th>
                    <th>CGST</th>
                    <th>SGST</th>
                    <th>IGST</th>
                    <th style="width:100px;">TOTAL</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9" style="text-align:right;"><strong>Total Amount:</strong></td>
                    <td colspan="2" id="totalCartAmount">0.00</td>
                </tr>
                <tr>
                    <td colspan="9" style="text-align:right;"><strong>Discount:</strong></td>
                    <td colspan="2" style="width:100px;">
                        <input type="number" id="totalCartDiscount" min="0" value="0.00" style="width:100px;" />
                    </td>
                </tr>
                <tr>
                    <td colspan="9" style="text-align:right;"><strong>Total Payable Amount:</strong></td>
                    <td colspan="2" id="totalPayableCartAmount" style="font-weight: 600;">0.00</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@include('backend.sale.add-customer-modal')
@endsection

@section('content_footer')
<div class="row">
    <div class="col-md-6">
        
    </div>
    <div class="col-md-6" style="text-align: right;">
        <button type="button" class="btn btn-success" id="createSaleBtn"><i class="fas fa-check"></i> Create Sale</button>
    </div>
</div>
@endsection

@push('page_script')
<script src="{{ asset('public') }}/master-assets/bs-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
@endpush

@push('page_js')
    @include('backend.sale.add-sale-script')
@endpush