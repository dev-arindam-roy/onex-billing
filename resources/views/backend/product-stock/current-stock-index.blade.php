@extends('backend.layout.app')

@push('page_style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" />
@endpush

@section('page_header', 'Stock Management')
@section('page_breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Stock Management</a></li>
    <li class="breadcrumb-item active">Current Product Stock</li>
@endsection

@section('content_title', 'Current Product Stock')
@section('content_buttons')
    
@endsection

@section('content_body')
<form name="search_frm" id="searchFrm" action="" method="GET">
    <div class="row mb-2">
        <div class="col-md-4">
            <input type="text" name="search_text" id="searchText" class="form-control" placeholder="Name/Barcode/Item-No/HSN" value="{{ (request()->has('search_text')) ? request()->get('search_text') : '' }}"/>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success">Search</button>
            <a href="{{ route('stock.current') }}" class="btn btn-danger">Clear</a>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12" id="displayData">
        @include('backend.product-stock.all-current-stock-render', array('data' => $data))
    </div>
</div>
@endsection

@section('content_footer')
    
@endsection

@push('page_script')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endpush

@push('page_js')
@endpush