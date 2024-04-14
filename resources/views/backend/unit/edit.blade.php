@extends('backend.layout.app')

@section('page_header', 'Unit Management')
@section('page_breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('unit.index') }}">Unit Management</a></li>
    <li class="breadcrumb-item active">Edit Unit</li>
@endsection

@section('content_title', 'Edit Unit')
@section('content_buttons')
    <a href="{{ route('unit.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-balance-scale"></i> All Units</a>
@endsection

@section('content_body')
<form name="frm" id="frmx" action="{{ route('unit.update', array('id' => $unit->id)) }}" method="POST">
@csrf
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="unitStatus" class="onex-form-label">Status: <em>*</em></label>
            <select name="status" class="form-control" id="unitStatus">
                <option value="1" @if($unit->status == 1) selected="selected" @endif>Active</option>
                <option value="0" @if($unit->status == 0) selected="selected" @endif>Inactive</option>
            </select>
        </div>
    </div>
    <div class="col-md-9"></div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="unitName" class="onex-form-label">Unit Name: <em>*</em></label>
            <input type="text" name="name" id="unitName" class="form-control" placeholder="Enter Unit Name" required="required" value="{{ $unit->name }}"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="shortName" class="onex-form-label">Product SKU: <em>*</em></label>
            <input type="text" name="short_name" id="shortName" class="form-control" placeholder="Enter Short Name" required="required" value="{{ $unit->short_name }}"/>
        </div>
    </div>
    <div class="col-md-6"></div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="unitDescription" class="onex-form-label">Unit Description: </label>
            <textarea name="description" id="unitDescription" class="form-control" placeholder="Enter Unit Description..."/>{{ $unit->description }}</textarea>
        </div>
    </div>
    <div class="col-md-6"></div>
</div>
</form>
@endsection

@section('content_footer')
<div class="row">
    <div class="col-md-6">
        <button type="button" class="btn btn-success" id="updateUnitBtn"><i class="fas fa-save"></i> Save Changes</button>
    </div>
    <div class="col-md-6"></div>
</div>
@endsection

@push('page_script')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
@endpush

@push('page_js')
<script>
$(document).ready(function() {
    $("#frmx").validate({
        errorClass: 'onex-error',
        errorElement: 'div',
        rules: {
            name: {
                required: true,
                maxlength: 20
            },
            short_name: {
                required: true,
                maxlength: 10
            }
        },
        messages: {
            name: {
                required: 'Please enter unit name',
                maxlength: 'Maximum 20 chars accepted'
            },
            short_name: {
                required: 'Please enter short name',
                maxlength: 'Maximum 10 chars accepted'
            }
        },
        errorPlacement: function (error, element) {
            if(element.hasClass('onex-select2')) {
                error.insertAfter(element.parent().find('span.select2-container'));
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
    $('#updateUnitBtn').on('click', function() {
        if($("#frmx").valid()) {
            displayLoading();
            $('#updateUnitBtn').attr('disabled', 'disabled');
            $("#frmx").submit();
        }
    });
});
</script>
@endpush