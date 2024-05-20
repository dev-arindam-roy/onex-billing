<div class="table-responsive">
    <table class="table table-sm table-bordered table-striped table-hover onex-datatable nowrap" id="dataTable" style="width: 100%;">
        <thead>
            <tr>
                <th style="min-width:60px;">SL</th>
                <th style="min-width:150px;">Invoice No</th>
                <th style="min-width:150px;">Customer Name</th>
                <th style="min-width:150px;">Pay Amount</th>
                <th style="min-width:130px;">GST</th>
                <th style="min-width:100px;">Payment Status</th>
                <th style="min-width:100px;">Payment Mode</th>
                <th style="min-width:80px;">Products</th>
                <th style="min-width:100px;">Sale At</th>
                <th style="min-width:100px;">Created At</th>
                <th style="min-width:100px;">Modified At</th>
                <th style="min-width:100px;">Action</th>
            </tr>
        </thead>
        <tbody>
        @if(!empty($data) && count($data))
            @php $sl = 1; @endphp
            @foreach($data as $key => $value)
                <tr>
                    <th>{{ $sl }}</th>
                    <td>{{ $value->invoice_no }}</td>
                    <td>
                        @if(!empty($value->customerInfo->first_name)){{ $value->customerInfo->first_name }}@endif 
                        @if(!empty($value->customerInfo->last_name)){{ $value->customerInfo->last_name }}@endif<br/>
                        @if(!empty($value->customerInfo->phone_number)){{ $value->customerInfo->phone_number }}@endif
                        @if(!empty($value->customerInfo->email_id))<br/>{{ $value->customerInfo->email_id }}@endif
                    </td>
                    <td>
                        <span class="text-success" style="font-weight: 600;">Bill: {{ $value->payable_amount }}</span><br/>
                        <span class="text-danger" style="font-weight: 600;">Due: {{ $value->due_amount }}</span>
                    </td>
                    <td>
                        <span style="font-weight: 600;">{{ $value->total_gst_amount }}</span><br/>
                        <span><small>SGST: {{ $value->total_sgst_amount }}</small></span><br/>
                        <span><small>CGST: {{ $value->total_cgst_amount }}</small></span><br/>
                        <span><small>IGST: {{ $value->total_igst_amount }}</small></span>
                    </td>
                    <td>
                        @if($value->payment_status == 0)
                            <span class="text-danger">Pending</span>
                        @endif
                        @if($value->payment_status == 1)
                            <span class="text-success">Completed</span>
                        @endif
                    </td>
                    <td>
                        @if(!empty($value->payment_mode))
                            @if($value->payment_mode == 0)
                                <span class="text-primary">CASH</span>
                            @elseif($value->payment_mode == 1)
                                <span class="text-primary">UPI</span>
                            @elseif($value->payment_mode == 2)
                                <span class="text-primary">BANK TRANS</span>
                            @else
                                <span class="text-primary">CHEQUE</span>
                            @endif
                        @endif                        
                    </td>
                    <td>{{ count($value->saleProducts) }}</td>
                    <td>{{ date('d-m-Y', strtotime($value->sale_date)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                    <td>{{ !empty($value->updated_at) ? date('d-m-Y', strtotime($value->updated_at)) : date('d-m-Y', strtotime($value->created_at)) }}</td>
                    <td>
                        {{-- <a href="{{ route('purchase.edit-batch', array('id' => $value->hash_id)) }}" class="btn edit-batch-btn"><i class="far fa-edit text-success"></i></a> --}}
                        <a href="{{ route('purchase.delete-purchase', array('id' => $value->hash_id)) }}" class="btn remove-purchase-btn"><i class="far fa-trash-alt text-danger"></i></a>
                    </td>
                </tr>
                @php $sl++; @endphp
            @endforeach
        @else
            <tr>
                <td colspan="12">No purchase found. Please create purchase and stock entry</td>
            </tr>
        @endif
        </tbody>
    </table> 
</div>
@if(!empty($data) && count($data))
    <div class="onex-pagination">{!! $data->withQueryString()->links() !!}</div>
@endif