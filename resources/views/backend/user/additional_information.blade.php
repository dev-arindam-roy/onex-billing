@php
    $authId = auth()->user()->id;
    $authRoles = Helper::authRoles();
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
    $isCustomer = false;
    if (!empty($user->userRoles) && count($user->userRoles)) {
        foreach($user->userRoles as $uRole) {
            if(!empty($uRole->role) && !empty($uRole->role->key_name) && $uRole->role->key_name == 'customer') {
                $isCustomer = true;
            }
        }
    }
@endphp

@extends('backend.layout.app')

@section('page_header', 'Profile Management')
@section('page_breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ $indexUrl }}">{{ $pageKey }} Management</a></li>
    <li class="breadcrumb-item active">Profile Management</li>
@endsection

@section('content_title', $pageKey . ' Additional Informations')

@section('content_buttons')
    <a href="{{ route('user.edit', array('id' => $user->hash_id)) }}@if((isset($isCustomer) && $isCustomer)){{ '?user=customer' }}@endif" class="btn btn-success btn-sm"><i class="far fa-user"></i> Edit Account</a>
    <a href="{{ $indexUrl }}" class="btn btn-primary btn-sm"><i class="fas fa-users"></i> All {{ $pageKey . 's' }}</a>
@endsection

@section('content_body')
<form name="frm" id="frmx" action="{{ route('user.saveProfileInformation', array('id' => $user->id)) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
@csrf
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="profileImage">Profile Image:</label>
            <div class="custom-file">
                <input type="file" name="image" accept="image/*" class="custom-file-input" id="profileImage">
                <label class="custom-file-label" for="profileImage">Choose file</label>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
@if(!empty($user->userProfile) && !empty($user->userProfile->image))
<div class="row">
    <div class="col-md-3">
        <div class="onex-preview-imgbox">
            <image src="{{ asset('public/uploads/images/users/thumbnail/' . $user->userProfile->image) }}" class="img-thumbnail"/>
            <a href="javascript:void(0);" class="table-image-remove" title="Remove Image" 
                data-table-row-id="{{ $user->userProfile->id }}" 
                data-table-name="users_profile"
                data-table-field="image"><i class="fas fa-trash-alt text-danger"></i></a>
        </div>
    </div>
    <div class="col-md-9"></div>
</div>
@endif
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="userAddress" class="onex-form-label">Full Address: <em>*</em></label>
            <textarea name="full_address" id="userAddress" class="form-control" required="required" autocomplete="false">@if(!empty($user->userProfile)){{ $user->userProfile->full_address }}@endif</textarea>
            <input type="hidden" name="geo_address" id="geoAddress" value="@if(!empty($user->userProfile)){{ $user->userProfile->geo_address }}@endif"/>
            <input type="hidden" name="latitude" id="latitude" value="@if(!empty($user->userProfile)){{ $user->userProfile->latitude }}@endif"/>
            <input type="hidden" name="longitude" id="longitude" value="@if(!empty($user->userProfile)){{ $user->userProfile->longitude }}@endif"/> 
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label for="userPincode" class="onex-form-label">Pincode: <em>*</em></label>
            <input type="text" maxlength="10" name="pincode" id="userPincode" class="form-control" required="required" value="@if(!empty($user->userProfile)){{ $user->userProfile->pincode }}@endif"/>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="userCity" class="onex-form-label">City: <em>*</em></label>
            <input type="text" name="city" id="userCity" class="form-control" required="required" value="@if(!empty($user->userProfile)){{ $user->userProfile->city }}@endif"/>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="userState" class="onex-form-label">State: <em>*</em></label>
            <input type="text" name="state" id="userState" class="form-control" required="required" value="@if(!empty($user->userProfile)){{ $user->userProfile->state }}@endif"/>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="userCountry" class="onex-form-label">Country: <em>*</em></label>
            <input type="text" name="country" id="userCountry" class="form-control" required="required" value="IND"/>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="userLandmark" class="onex-form-label">Address Landmark: </label>
            <input type="text" name="land_mark" id="userLandmark" class="form-control" value="@if(!empty($user->userProfile)){{ $user->userProfile->land_mark }}@endif">
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
</form>
@endsection

@section('content_footer')
<div class="row">
    <div class="col-md-6">
        <button type="button" class="btn btn-success" id="saveChangesBtn"><i class="fas fa-save"></i> Save Changes</button>
    </div>
    <div class="col-md-6"></div>
</div>
@endsection

@push('page_script')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&sensor=false&libraries=places"></script>
@endpush

@push('page_js')
<script>
$(document).ready(function() {
    $("#frmx").validate({
        errorClass: 'onex-error',
        errorElement: 'div',
        ignore: '.ignore',
        rules: {
            full_address: {
                required: true
            },
            city: {
                required: true,
                maxlength: 90,
            },
            pincode: {
                required: true,
                maxlength: 10
            },
            state: {
                required: true,
                maxlength: 90
            },
            country: {
                required: true,
                maxlength: 30
            }
        },
        messages: {
            full_address: {
                required: 'Please enter address'
            },
            city: {
                required: 'Please enter city',
                maxlength: 'Maximum 90 chars accepted'
            },
            pincode: {
                required: 'Please enter pincode',
                maxlength: 'Maximum 10 digits accepted'
            },
            state: {
                required: 'Please enter state',
                maxlength: 'Maximum 90 chars accepted'
            },
            country: {
                required: 'Please enter country',
                maxlength: 'Maximum 90 chars accepted'
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
    google.maps.event.addDomListener(window, 'load', function () {
        var places = new google.maps.places.Autocomplete(document.getElementById('userAddress'));
        google.maps.event.addListener(places, 'place_changed', function () {
            var place = places.getPlace();
            var address = place.formatted_address;
            var componentForm = {
                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'short_name',
                country: 'long_name',
                postal_code: 'short_name'
            };

            var geoInfo = [];
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    geoInfo.push({ type: addressType, name: place.address_components[i][componentForm[addressType]]});
                }
            }
            let geoAddress = '';
            if(geoInfo.length) {
                for(var j = 0; j < geoInfo.length; j++) {
                    geoAddress += geoInfo[j].name + ', ';
                    if(geoInfo[j].type == 'locality') {
                        document.getElementById('userCity').value = geoInfo[j].name;
                        document.getElementById('userCity').classList.add('valid');
                        document.getElementById('userCity').classList.remove('onex-error');
                        if(document.getElementById('userCity-error')) {
                            document.getElementById('userCity-error').remove();
                        }
                    }
                    if(geoInfo[j].type == 'administrative_area_level_1') {
                        document.getElementById('userState').value = geoInfo[j].name;
                        document.getElementById('userState').classList.add('valid');
                        document.getElementById('userState').classList.remove('onex-error');
                        if(document.getElementById('userState-error')) {
                            document.getElementById('userState-error').remove();
                        }
                    }
                    if(geoInfo[j].type == 'country') {
                        document.getElementById('userCountry').value = geoInfo[j].name;
                        document.getElementById('userCountry').classList.add('valid');
                        document.getElementById('userCountry').classList.remove('onex-error');
                        if(document.getElementById('userCountry-error')) {
                            document.getElementById('userCountry-error').remove();
                        }
                    }
                    if(geoInfo[j].type == 'postal_code') {
                        document.getElementById('userPincode').value = geoInfo[j].name;
                        document.getElementById('userPincode').classList.add('valid');
                        document.getElementById('userPincode').classList.remove('onex-error');
                        if(document.getElementById('userPincode-error')) {
                            document.getElementById('userPincode-error').remove();
                        }
                    }
                }
            }
            //console.log(geoInfo);
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;
            geoAddress += latitude + ', ' + longitude;
            //console.log(geoAddress);
            document.getElementById('geoAddress').value = geoAddress;
        });
    });
});
</script>
@endpush