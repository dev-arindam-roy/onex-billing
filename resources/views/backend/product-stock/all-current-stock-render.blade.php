<div class="table-responsive">
    <table class="table table-sm table-bordered table-striped table-hover onex-datatable nowrap" id="dataTable" style="width: 100%;">
        <thead>
            <tr>
                <th class="onex-xxs">SL</th>
                <th class="onex-md">Brand</th>
                <th class="onex-xl">Barcode No</th>
                <th class="onex-xl">Name</th>
                <th class="onex-md">Current Stock</th>
                <th class="onex-sm">HSN</th>
                <th class="onex-sm">GST</th>
                <th class="onex-sm">Status</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
        @if(!empty($data) && count($data))
            @php $sl = 1; @endphp
            @foreach($data as $key => $value)
                <tr>
                    <td>{{ $sl }}</td>
                    <td>@if(!empty($value->productBrand) && !empty($value->productBrand->name)){{ $value->productBrand->name }}@endif</td>
                    <td>{{ $value->barcode_no }}</td>
                    <td>{{ $value->name }}</td>
                    <td style="font-weight: 600;">@if(round($value->available_stock) > 10)<span class="text-success">{{ round($value->available_stock) }}</span>@else<span class="text-danger">{{ round($value->available_stock) }}</span>@endif</td>
                    <td>{{ $value->hsn_code }}</td>
                    <td>{{ round($value->gst_rate) }} %</td>
                    <td>{!! ($value->status == 1) ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>' !!}</td>
                    <td></td>
                </tr>
                @php $sl++; @endphp
            @endforeach
        @else
            <tr>
                <td colspan="9">No product found, Please add product & add stock by purchase</td>
            </tr>
        @endif
        </tbody>
    </table> 
</div>
@if(!empty($data) && count($data))
    <div class="onex-pagination">{!! $data->withQueryString()->links() !!}</div>
@endif