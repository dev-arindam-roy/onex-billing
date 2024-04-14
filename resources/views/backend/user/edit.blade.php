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
    $addTitle = 'Add ' . $pageKey;
    $addNewTitle = 'Add New ' . $pageKey;
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

@section('page_header', $pageKey . ' Management')
@section('page_breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ $indexUrl }}">{{ $pageKey }} Management</a></li>
    <li class="breadcrumb-item active">Edit {{ $pageKey }}</li>
@endsection

@section('content_title', 'Edit ' . $pageKey)
@section('content_buttons')
    <a href="{{ $indexUrl }}" class="btn btn-primary btn-sm"><i class="fas fa-users"></i> All {{ $pageKey . 's'}}</a>
@endsection

@section('content_body')
<form name="frm" id="frmx" action="{{ route('user.update', array('id' => $user->id)) }}" method="POST">
@csrf

@php
    $editUserRoleIds = [];
    if (!empty($user->userRoles) && count($user->userRoles)) {
        foreach ($user->userRoles as $v) {
            array_push($editUserRoleIds, $v->role_id);
        }
    }
@endphp

<div class="row">
    @if(!empty($specificRoleId))
    <input type="hidden" name="role_id" id="userRole" value="{{ $specificRoleId }}"/>
    @else
    <div class="col-md-4">
        <div class="form-group">
            <label for="userRole" class="onex-form-label">User Role: <em>*</em></label>
            <select name="role_id" id="userRole" class="form-control onex-select2" required="required">
                @if(!empty($roles) && count($roles))
                    @foreach($roles as $k => $v)
                        <option value="{{ $v->id }}" @if(in_array($v->id, $editUserRoleIds)) selected="selected" @endif>{{ $v->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    @endif
    <div class="col-md-4">
        <div class="form-group" id="agentIdBox" @if($specificRoleId != '6') style="display: none;" @endif>
            <label for="agentId" class="onex-form-label">Salesman/Agent: <em>*</em></label>
            <select name="agent_id" id="agentId" class="form-control onex-select2 ignore" required="required" 
                @if(!empty($authRoles) && in_array('sales-man', $authRoles)) disabled="disabled" @endif>
                @if(!empty($agents) && count($agents))
                    @foreach($agents as $k => $v)
                        <option value="{{ $v->id }}" 
                            @if($user->agent_id == $v->id) selected="selected" @endif>{{ $v->first_name . ' ' . $v->last_name }}</option>
                    @endforeach
                @endif
            </select>
            <!-- when a sales man logged in and create customer and as the select2 is disabled -->
            @if($specificRoleId == 6 && $isCustomer && !empty($authRoles) && in_array('sales-man', $authRoles))
                <input type="hidden" name="agent_id" id="agentId" value="{{ !empty($user->agent_id) ? $user->agent_id : $authId }}"/>
            @endif
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="firstName" class="onex-form-label">First Name: <em>*</em></label>
            <input type="text" name="first_name" id="firstName" class="form-control" placeholder="Enter First Name" required="required" value="{{ $user->first_name }}"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="lastName" class="onex-form-label">Last Name: <em>*</em></label>
            <input type="text" name="last_name" id="lastName" class="form-control" placeholder="Enter Last Name" required="required" value="{{ $user->last_name }}"/>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="phoneNumber" class="onex-form-label">Phone Number: <em>*</em></label>
            <input type="number" name="phone_number" id="phoneNumber" class="form-control" placeholder="Enter Mobile Number" required="required" autocomplete="new-phone-number" value="{{ $user->phone_number }}"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="whatsappNumber" class="onex-form-label">Whatsapp Number:</label>
            <input type="number" name="whatsapp_number" id="whatsappNumber" class="form-control" placeholder="Enter Whatsapp Number" value="{{ $user->whatsapp_number }}"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="emailId" class="onex-form-label">Email Id: <em>*</em></label>
            <input type="email" name="email_id" id="emailId" class="form-control" placeholder="Enter Email Id" required="required" autocomplete="new-email" value="{{ $user->email_id }}"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            @if($specificRoleId == 6)
                <label for="loginId" class="onex-form-label">Login ID: <em>*</em></label>
                <input type="text" name="login_id" id="loginId" class="form-control" placeholder="Enter Login Id" value="{{ $user->login_id }}" required="required" @if(!empty($authRoles) && !in_array('super-admin', $authRoles)) readonly @endif autocomplete="new-login-id"/>
            @else
                <label class="onex-form-label">System Access:</label>
                <div class="form-check">
                    <input name="is_crm_access" id="isCrmAccess" class="form-check-input" type="checkbox" @if($user->is_crm_access == 1) checked="checked" @endif/>
                    <label class="form-check-label" for="isCrmAccess">Is able to access the CRM?</label>
                    <input type="hidden" name="crm_access_value" id="crmAccessValue" value="{{ $user->is_crm_access }}"/>
                </div>
            @endif
        </div>
    </div>
</div>
@if($specificRoleId == 6)
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
            <input type="text" name="country" id="userCountry" class="form-control" required="required" value="IND" value="@if(!empty($user->userProfile)){{ $user->userProfile->country }}@endif"/>
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
@endif
</form>
@endsection

@section('content_footer')
<div class="row">
    <div class="col-md-6">
        <button type="button" class="btn btn-success" id="updateUserBtn"><i class="fas fa-save"></i> Save Changes</button>
        <a href="javascript:void(0);" class="btn btn-danger btn-reload">Cancel</a>
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
            role_id: {
                required: true,
                digits: true
            },
            agent_id: {
                required: {
                    depends: function(element) {
                        if($('#userRole').val() == '6') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                digits: true
            },
            first_name: {
                required: true,
                maxlength: 30
            },
            last_name: {
                required: true,
                maxlength: 20
            },
            email_id: {
                required: true,
                email: true,
                maxlength: 60
            },
            phone_number: {
                required: true,
                digits: true,
                maxlength: 10,
                minlength: 10
            },
            whatsapp_number: {
                digits: true,
                maxlength: 10,
                minlength: 10
            },
            crm_access_value: {
                required: true,
                digits: true
            },
            full_address: {
                required: {
                    depends: function(element) {
                        if($('#userRole').val() == '6') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            },
            city: {
                required: {
                    depends: function(element) {
                        if($('#userRole').val() == '6') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                maxlength: 90,
            },
            pincode: {
                required: {
                    depends: function(element) {
                        if($('#userRole').val() == '6') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                maxlength: 10
            },
            state: {
                required: {
                    depends: function(element) {
                        if($('#userRole').val() == '6') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                maxlength: 90
            },
            country: {
                required: {
                    depends: function(element) {
                        if($('#userRole').val() == '6') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                maxlength: 30
            }
        },
        messages: {
            role_id: {
                required: 'Please select user role',
                digits: 'Invalid user role'
            },
            agent_id: {
                required: 'Please select an agent',
                digits: 'Invalid agent id'
            },
            first_name: {
                required: 'Please enter first name',
                maxlength: 'Maximum 30 chars accepted'
            },
            last_name: {
                required: 'Please enter last name',
                maxlength: 'Maximum 20 chars accepted'
            },
            email_id: {
                required: 'Please enter email',
                email: 'Please enter valid email',
                maxlength: 'Maximum 60 chars accepted'
            },
            phone_number: {
                required: 'Please enter mobile number',
                digits: 'Please enter valid mobile number',
                maxlength: '10 digitis mobile number required',
                minlength: '10 digitis mobile number required'
            },
            whatsapp_number: {
                digits: 'Please enter valid mobile number',
                maxlength: '10 digitis mobile number required',
                minlength: '10 digitis mobile number required'
            },
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
    $('#updateUserBtn').on('click', function() {
        if($("#frmx").valid()) {
            displayLoading();
            $('#updateUserBtn').attr('disabled', 'disabled');
            $("#frmx").submit();
        }
    });
    $('#isCrmAccess').on('change', function() {
        if($(this).is(':checked')) {
            $('#crmAccessValue').val(1);
        } else {
            $('#crmAccessValue').val(0);
        } 
    });
    $('#userRole').on('change', function() {
        if($(this).val() == '1' || $(this).val() == '3') {
            $('#isCrmAccess').prop('checked', true);
            $('#isCrmAccess').attr('checked');
            $('#isCrmAccess').attr('disabled', 'disabled');
            $('#agentId').addClass('ignore');
            $('#agentIdBox').hide();
        } else if($(this).val() == '6') {
            $('#isCrmAccess').prop('checked', false);
            $('#isCrmAccess').removeAttr('checked');
            $('#isCrmAccess').attr('disabled', 'disabled');
            $('#agentId').removeClass('ignore');
            $('#agentIdBox').show();
        } else {
            $('#isCrmAccess').prop('checked', true);
            $('#isCrmAccess').attr('checked');
            $('#isCrmAccess').removeAttr('disabled');
            $('#agentId').addClass('ignore');
            $('#agentIdBox').hide();
        }
        $('#isCrmAccess').trigger('change');
    });
    if($('#userRole').val() == '6') {
        $('#isCrmAccess').prop('checked', false);
        $('#isCrmAccess').removeAttr('checked');
        $('#isCrmAccess').attr('disabled', 'disabled');
        $('#isCrmAccess').trigger('change');
        $('#agentId').removeClass('ignore');
        $('#agentIdBox').show();
    }
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