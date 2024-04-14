@php
    $authId = auth()->user()->id;
    $authRoles = Helper::authRoles();
    $managementKey = 'User Management';
    $allKey = 'All Users';
    $addKey = 'Add User';
    $addEditUserUrlKey = '';
    $allPageKeys = ['Vendor', 'Sales Man', 'Customer', 'Procurement Associate', 'Delivery Man'];
    if (isset($page_key) && !empty($page_key)) {
        if (in_array($page_key, $allPageKeys)) {
            $managementKey = $page_key . ' Management';
            $allKey = 'All ' . $page_key . 's';
            $addKey = 'Add ' . $page_key;
            $addEditUserUrlKey = str_replace(' ', '-', strtolower($page_key));
        }
    }
@endphp

@extends('backend.layout.app')

@push('page_style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css" />
@endpush

@section('page_header', $managementKey)
@section('page_breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0);" class="btn-reload">{{ $managementKey }} </a></li>
    <li class="breadcrumb-item active">{{ $allKey }}</li>
@endsection

@section('content_title', $allKey)

@section('content_buttons')
    <a href="{{ route('user.add') }}@if(!empty($addEditUserUrlKey)){{ '?user=' . $addEditUserUrlKey }}@endif" class="btn btn-primary btn-sm"><i class="fas fa-user-plus"></i> {{ $addKey }}</a>
@endsection

@section('content_body')
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover onex-datatable nowrap" id="dataTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 50px;">SL</th>
                        @if((isset($page_key) && !empty($page_key) && $page_key == 'Customer') || !isset($page_key))
                        <th style="width: 15%;">Agent Name</th>
                        @endif
                        <th style="width: 15%;">@if(isset($page_key) && !empty($page_key)){{ $page_key }} @endif Name</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 10%;">Mobile</th>
                        <th style="width: 15%;">Role</th>
                        <th class="text-center">CRM Access</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created</th>
                        <th style="width: 65px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @if(!empty($all_users) && count($all_users))
                    @php $sl = 1; @endphp
                    @foreach($all_users as $key => $value)
                        <tr>
                            <td>{{ $sl }}</td>
                            @if((isset($page_key) && !empty($page_key) && $page_key == 'Customer') || !isset($page_key))
                            <td>
                                @if(!empty($value->customerAgent))
                                    {{ $value->customerAgent->first_name . ' ' . $value->customerAgent->last_name }}
                                @endif
                            </td>
                            @endif
                            <td>{{ $value->first_name . ' ' . $value->last_name }}<br/><span class="td-unique-id">{{ $value->unique_id }}</span></td>
                            <td>{{ $value->email_id }}</td>
                            <td>
                                <i class="fas fa-mobile-alt"></i> {{ $value->phone_number }}
                                @if(!empty($value->whatsapp_number))
                                    <br/><span>
                                    <i class="fab fa-whatsapp text-success"></i>
                                    {{ $value->whatsapp_number }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @php $isCustomer = false; @endphp
                                @if(!empty($value->userRoles) && count($value->userRoles))
                                    @foreach($value->userRoles as $uRole)
                                        @if(!empty($uRole->role) && !empty($uRole->role->name))
                                            <span class="role-tag">{{$uRole->role->name}}</span>
                                            @if(!empty($uRole->role->key_name) && $uRole->role->key_name == 'customer')
                                               @php $isCustomer = true; @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                                @if($isCustomer)<br/><span><strong>{{ $value->login_id }}</strong></span>@endif
                            </td>
                            <td class="text-center">
                                {!! ($value->is_crm_access == 1) ? '<span class="text-success">YES</span>' : '<span class="text-danger">NO</span>' !!}
                            </td>
                            <td class="text-center">
                                @if($value->status == 1) 
                                    <a href="{{ route('user.lockUnlock', array('id' => $value->hash_id, 'statusId' => 0)) }}" class="lock-unlock-user" title="Lock user"><i class="fas fa-unlock-alt text-success" style="font-size: 22px;"></i></a>
                                @endif
                                @if($value->status == 0) 
                                    <a href="{{ route('user.lockUnlock', array('id' => $value->hash_id, 'statusId' => 1)) }}" class="lock-unlock-user" title="Unlock user"><i class="fas fa-lock text-danger" style="font-size: 22px;"></i></a>
                                @endif
                            </td>
                            <td class="text-center">{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                            <td class="action-col">
                                <div class="btn-group">
                                    <a href="{{ route('user.edit', array('id' => $value->hash_id)) }}@if(!empty($addEditUserUrlKey)){{ '?user=' . $addEditUserUrlKey }}@elseif((isset($isCustomer) && $isCustomer)){{ '?user=customer' }}@endif" class="btn edit-user-btn"><i class="far fa-edit text-success"></i></a>
                                    <a href="{{ route('user.delete', array('id' => $value->hash_id)) }}" class="btn remove-user-btn"><i class="far fa-trash-alt text-danger"></i></a>
                                    <div class="btn-group dt-action-dropdown">
                                        <a href="javascript:void(0);" id="dLabel{{$value->hash_id}}" class="btn dropdown-toggle" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v text-navy"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel{{$value->hash_id}}">
                                            <a class="dropdown-item" href="{{ route('user.profileInformation', array('id' => $value->hash_id)) }}@if(!empty($addEditUserUrlKey)){{ '?user=' . $addEditUserUrlKey }}@endif">View Profile</a>
                                            <h5 class="dropdown-header">Settings</h5>
                                            <a class="dropdown-item" href="{{ route('user.resetUsername', array('id' => $value->hash_id)) }}@if(!empty($addEditUserUrlKey)){{ '?user=' . $addEditUserUrlKey }}@endif">Reset Username</a>
                                            <a class="dropdown-item" href="{{ route('user.resetPassword', array('id' => $value->hash_id)) }}@if(!empty($addEditUserUrlKey)){{ '?user=' . $addEditUserUrlKey }}@endif">Reset Password</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @php $sl++; @endphp
                    @endforeach
                @else
                    <tr>
                        <td style="display: none;"></td>
                        @if((isset($page_key) && !empty($page_key) && $page_key == 'Customer') || !isset($page_key))
                        <td style="display: none;"></td>
                        @endif
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td colspan="@if((isset($page_key) && !empty($page_key) && $page_key == 'Customer') || !isset($page_key)) 10 @else 9 @endif">No user found. Please create users</td>
                    </tr>
                @endif
                </tbody>
            </table> 
        </div>
    </div>
</div>
@endsection

@section('content_footer')
@endsection

@push('page_script')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<!--script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script-->
@endpush

@push('page_js')
<script>
$(document).ready( function () {
    @if((isset($page_key) && !empty($page_key) && $page_key == 'Customer') || !isset($page_key))
    var onexDataTable = $('#dataTable').DataTable({
        //fixedColumns: true,
        //responsive: true,
        autoWidth: true,
        scrollX: true,
        //scrollCollapse: true,
        order: [[0, 'asc']],
        'columnDefs': [{
            'targets': [6, 9],
            'orderable': false
        }],
        /*
        fixedColumns:   {
            leftColumns: 0,
            rightColumns: 1
        }
        */
    });
    @else
    var onexDataTable = $('#dataTable').DataTable({
        //fixedColumns: true,
        //responsive: true,
        autoWidth: true,
        scrollX: true,
        //scrollCollapse: true,
        order: [[0, 'asc']],
        'columnDefs': [{
            'targets': [6, 8],
            'orderable': false
        }],
        /*
        fixedColumns:   {
            leftColumns: 0,
            rightColumns: 1
        }
        */
    });
    @endif
    setTimeout( function () {
        onexDataTable.columns.adjust();
    }, 500);
    $('body').on('click', '.remove-user-btn', function(e) {
        e.preventDefault();
        let deleteUrl = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this @if(isset($page_key) && !empty($page_key)){{ strtolower($page_key) }}@else user @endif",
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
    $('body').on('click', '.lock-unlock-user', function(e) {
        e.preventDefault();
        let actionUrl = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change the @if(isset($page_key) && !empty($page_key)){{ strtolower($page_key) }}@else user @endif status",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, do it!'
        }).then((result) => {
            if(result.isConfirmed) {
                displayLoading();
                window.location.href = actionUrl;
            }
        });
    });
});
</script>
@endpush