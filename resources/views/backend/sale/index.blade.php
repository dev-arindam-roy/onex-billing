@extends('backend.layout.app')

@push('page_style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" />
@endpush

@section('page_header', 'Sale Management')
@section('page_breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Sale Management</a></li>
    <li class="breadcrumb-item active">All Sales</li>
@endsection

@section('content_title', 'All Sales')
@section('content_buttons')
    <a href="{{ route('sale.add') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Sale</a>
@endsection

@section('content_body')
<form name="search_frm" id="searchFrm" action="" method="GET">
    <div class="row mb-2">
        <div class="col-md-3">
            <input type="text" name="search_text" id="searchText" class="form-control" placeholder="Invoice/Customer" required="required" value="{{ (request()->has('search_text')) ? request()->get('search_text') : '' }}"/>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success">Search</button>
            <a href="{{ route('sale.index') }}" class="btn btn-danger">Clear</a>
        </div>
        <div class="col-md-7" style="text-align: right;">
            <span><strong>Total: {{ count($data) }}</strong></span>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12" id="displayData">
        @include('backend.sale.all-sale-render', array('data' => $data))
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
<script>
$(document).ready( function () {
    $('body').on('click', '.remove-purchase-btn', function(e) {
        e.preventDefault();
        let deleteUrl = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this sale entry",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.isConfirmed) {
                displayLoading();
                window.location.href = deleteUrl;
            }
        });
    });
});
</script>
@endpush