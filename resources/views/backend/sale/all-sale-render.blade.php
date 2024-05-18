<div class="table-responsive">
    <table class="table table-sm table-bordered table-striped table-hover onex-datatable nowrap" id="dataTable" style="width: 100%;">
        <thead>
            <tr>
                <th style="min-width:60px;">SL</th>
                <th style="min-width:150px;">Batch</th>
                <th style="min-width:150px;">Vendor</th>
                <th style="min-width:100px;">Bill No</th>
                <th style="min-width:100px;">Amount</th>
                <th style="min-width:100px;">Payment Status</th>
                <th style="min-width:100px;">Payment Mode</th>
                <th style="min-width:80px;">Entries</th>
                <th style="min-width:100px;">Received At</th>
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
                    <td>
                        @if(!empty($value->batchInfo->batch_no)){{ $value->batchInfo->batch_no }}@endif
                        @if(!empty($value->batchInfo->name))<br/><span><small>{{ $value->batchInfo->name }}</small></span>@endif
                    </td>
                    <td>@if(!empty($value->vendorInfo->first_name)){{ $value->vendorInfo->first_name }}@endif @if(!empty($value->vendorInfo->last_name)){{ $value->vendorInfo->last_name }}@endif</td>
                    <td>{{ $value->bill_no }}</td>
                    <td><span class="text-success">Bill: {{ $value->bill_amount }}</span><br/><span class="text-danger">Due: {{ $value->due_amount }}</span></td>
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
                    <td>{{ count($value->purchaseProducts) }}</td>
                    <td>{{ date('d-m-Y', strtotime($value->received_date)) }}</td>
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