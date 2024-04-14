@php
    $indexUrl = route('user.index');
    $pageKey = 'User';
    $allPageKeys = ['vendor', 'sales-man', 'customer', 'procurement-associate', 'delivery-man'];
    $specificRoleId = '';
    if(isset($_GET['user']) && !empty($_GET['user'])) {
        if (in_array($_GET['user'], $allPageKeys)) {
            $pageKey = ucwords(str_replace('-', ' ', $_GET['user']));
            if ($_GET['user'] == 'vendor') {
                $specificRoleId = 5;
                $indexUrl = route('user.vendor.allVendors');
            } else if ($_GET['user'] == 'sales-man') {
                $specificRoleId = 4;
                $indexUrl = route('user.salesman.allSalesman');
            } else if ($_GET['user'] == 'customer') {
                $specificRoleId = 6;
                $indexUrl = route('user.customer.allCustomer');
            } else if ($_GET['user'] == 'procurement-associate') {
                $specificRoleId = 7;
                $indexUrl = route('user.procurementAssociate.allProcurementAssociate');
            } else if ($_GET['user'] == 'delivery-man') { 
                $specificRoleId = 8;
                $indexUrl = route('user.deliveryman.allDeliveryBoys');
            } else {
                $specificRoleId = '';
            }
        }
    }

    $isResetEnabled = false;
    if($user->is_crm_access == 1 || ($user->is_crm_access == 0 && in_array('customer', Helper::userRoles($user->id)))) {
        $isResetEnabled = true;
    }
@endphp

@extends('backend.layout.app')

@section('page_header', 'Account Settings')
@section('page_breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ $indexUrl }}">{{ $pageKey }} Management</a></li>
    <li class="breadcrumb-item active">Account Settings</li>
@endsection

@section('content_title', $pageKey . ' Account Settings')

@section('content_buttons')
    <a href="{{ route('user.edit', array('id' => $user->id)) }}" class="btn btn-success btn-sm"><i class="far fa-user"></i> Edit Account</a>
    <a href="{{ $indexUrl }}" class="btn btn-primary btn-sm"><i class="fas fa-users"></i> All {{ $pageKey . 's' }}</a>
@endsection

@section('content_body')

@if($isResetEnabled)
<form name="frm" id="frmx" action="{{ route('user.resetSavePassword', array('id' => $user->id)) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
@csrf
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="password" class="onex-form-label">New Password: <em>*</em></label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required="required" autocomplete="new-password"/>
        </div>
    </div>
    <div class="col-md-8"></div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="confirmPassword" class="onex-form-label">Confirm Password: <em>*</em></label>
            <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Enter confirm Password" required="required" autocomplete="new-password"/>
        </div>
    </div>
    <div class="col-md-8"></div>
</div>
</form>
@else
<div class="row">
    <div class="col-md-8">
        <div class="alert alert-danger">
            <h5><i class="icon fas fa-ban"></i> Oops!</h5>
            Sorry! Reset password not applicable for this user as the CRM access is disabled already.
            <br/> Please enable the CRM access settings from the edit account section.
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
@endif
@endsection

@section('content_footer')
<div class="row">
    <div class="col-md-6">
        @if($isResetEnabled)
            <button type="button" class="btn btn-success" id="saveChangesBtn"><i class="fas fa-key"></i> Reset Password</button>
        @endif
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
        ignore: '.ignore',
        rules: {
            password: {
                required: true,
                minlength: 8,
                maxlength: 16
            },
            confirm_password: {
                required: true,
                equalTo: '#password'
            }
        },
        messages: {
            password: {
                required: 'Please enter new password',
                minlength: 'Minimum 8 chars require',
                maxlength: 'Maximum 16 chars accepted'
            },
            confirm_password: {
                required: 'Please enter confirm password',
                equalTo: 'Confirm password not match with password'
            }
        }
    });
    $('#saveChangesBtn').on('click', function() {
        if($("#frmx").valid()) {
            displayLoading();
            $('#saveChangesBtn').attr('disabled', 'disabled');
            $("#frmx").submit();
        }
    });
});
</script>
@endpush