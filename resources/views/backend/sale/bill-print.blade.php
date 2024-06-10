@extends('backend.layout.app')

@push('page_style')
@endpush

@section('page_header', 'Sale Management')
@section('page_breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sale.index') }}">Sale Management</a></li>
    <li class="breadcrumb-item active">Print Bill</li>
@endsection

@section('content_title', 'Print Bill')
@section('content_buttons')
    <a href="{{ route('sale.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-cubes"></i> All Sales</a>
@endsection

@section('content_body')
<input type="hidden" id="downloadFileName" value="{{ $data->invoice_no }}_{{ date('m-d-Y_h:i:s') }}" />
<div class="row mt-2" id="printContentArea">
    <div class="col-md-12">
        <table class="print-table" style="width: 100%; font-family: Arial, Helvetica, sans-serif;">
            <thead>
                <tr>
                    <th style="width: 120px; vertical-align: middle; text-align: left;">
                        <img src="{{ asset('public/images/client_logo_bill.jpeg') }}" style="border-radius: 5px;"/>
                    </th>
                    <th style="width: 400px; vertical-align: middle; text-align: left; word-wrap: break-word;">
                        <p style="line-height: 0px;"><label style="font-size: 18px; color:#000099; text-transform: uppercase; font-weight: 600; letter-spacing: 1px; word-spacing: 6px;">{{ $company_information->company_name }}<sup>&reg;</sup></label></p>
                        <p style="margin-top: -10px; line-height: 16px;"><span style="font-size: 12px; font-weight: normal;">{{ $company_information->full_address }}</span></p>
                        @if (!empty($company_information->cin_no))
                            <p style="line-height: 0px;"><span style="font-size: 12px; font-weight: 600;">CIN:</span> <span style="font-size: 12px; font-weight: normal;">{{ $company_information->cin_no }}</span></p>
                        @endif
                        <p style="line-height: 0px;"><span style="font-size: 12px; font-weight: 600;">Website:</span> <span style="font-size: 12px; font-weight: normal;">{{ $company_information->website_url }}</span></p>
                    </th>
                    <th style="vertical-align: middle; text-align: right;">
                        <p style="line-height: 1px;"><span style="font-size: 12px; font-weight: 600;">Mobile:</span> <span style="font-size: 12px; font-weight: normal;">{{ $company_information->contact_number }}</span></p>
                        <p style="line-height: 1px;"><span style="font-size: 12px; font-weight: 600;">Whatsapp:</span> <span style="font-size: 12px; font-weight: normal;">{{ $company_information->whatsapp_number }}</span></p>
                        <p style="line-height: 1px;"><span style="font-size: 12px; font-weight: 600;">Email:</span> <span style="font-size: 12px; font-weight: normal;">{{ $company_information->contact_email }}</span></p>
                        <p style="line-height: 0px;"><span style="font-size: 12px; font-weight: 600;">GSTN:</span> <span style="font-size: 12px; font-weight: normal;">{{ $company_information->gst_no }}</span></p>
                    </th>
                </tr>
                <tr>
                    <th colspan="3"><hr/></th>
                </tr>
            </thead>
        </table>
        <table class="print-table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="vertical-align: middle; text-align: left;">
                        <p style="line-height: 0px;"><span style="font-size: 12px; font-weight: 600;">Customer Name:</span> <span style="font-size: 12px; font-weight: normal;">{{ $data->customerInfo->first_name }} {{ $data->customerInfo->last_name }}</span></p>
                        <p style="line-height: 0px;"><span style="font-size: 12px; font-weight: 600;">Mobile No:</span> <span style="font-size: 12px; font-weight: normal;">{{ $data->customerInfo->phone_number }}</span></p>
                        @if(!empty($data->customerInfo->email_id))
                            <p style="line-height: 0px;"><span style="font-size: 12px; font-weight: 600;">Email Id:</span> <span style="font-size: 12px; font-weight: normal;">{{ $data->customerInfo->email_id }}</span></p>
                        @endif
                        @if(!empty($data->customerInfo->userProfile->full_address))
                            <p style="line-height: 0px;"><span style="font-size: 12px; font-weight: 600;">Address:</span> <span style="font-size: 12px; font-weight: normal;">{{ $data->customerInfo->userProfile->full_address }}</span></p>
                        @endif
                        @if(!empty($data->customerInfo->userProfile->gst_no))
                            <p style="line-height: 0px;"><span style="font-size: 12px; font-weight: 600;">GSTN:</span> <span style="font-size: 12px; font-weight: normal;">{{ $data->customerInfo->userProfile->gst_no }}</span></p>
                        @endif
                    </th>
                    <th style="vertical-align: middle; text-align: right;">
                        <p style="line-height: 1px;"><span style="font-size: 12px; font-weight: 600;">Invoice/Bill No:</span> <span style="font-size: 12px; font-weight: normal;">{{ $data->invoice_no }}</span></p>
                        <p style="line-height: 1px;"><span style="font-size: 12px; font-weight: 600;">Invoice Date:</span> <span style="font-size: 12px; font-weight: normal;">{{ date('m-d-Y', strtotime($data->sale_date)) }}</span></p>
                        <p style="line-height: 1px;"><span style="font-size: 12px; font-weight: 600;">Payable Amount:</span> <span style="font-size: 12px; font-weight: normal;">{{ $data->payable_amount }}</span></p>
                    </th>
                </tr>
            </thead>
        </table>
        
        <table class="print-table" style="width: 100%; border-collapse: collapse; margin-top: 60px;">
            <tr>
                <th style="width: 60px; padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">SL NO</label></th>
                <th style="width: 35%; padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">PRODUCT</label></th>
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">SIZE</label></th>
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">COLOR</label></th>
                <!--th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">HSN</label></th-->
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">QTY</label></th>
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">PRICE</label></th>
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">GST</label></th>
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">SGST</label></th>
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">CGST</label></th>
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">IGST</label></th>
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left;"><label style="font-size: 12px;">TOTAL</label></th>
            </tr>
            @if(!empty($data->saleProducts) && count($data->saleProducts))
                @php 
                    $sl = 1; 
                @endphp
                @foreach($data->saleProducts as $v)
                    @if(!empty($v->productInfo) && !empty($v->unitInfo))
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">{{ $sl }}.</td>
                            <td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px; word-wrap: break-word;">
                                <p style="line-height: 5px;"><span style="font-size: 12px; font-weight: 600;">{{ $v->productInfo->name }}</span></p>
                                <p style="line-height: 5px;"><span style="font-size: 12px; font-weight: normal;"><span style="font-weight: 600;">Item No:</span> {{ $v->productInfo->sku }}</span></p>
                                @if(!empty($v->productInfo->short_description))
                                    <p style="line-height: 2px;"><span style="font-size: 12px; font-style: italic; font-weight: normal;">{{ $v->productInfo->short_description }}</span></p>
                                @endif
                                @if(!empty($v->productInfo->productBrand->name))
                                    <p style="line-height: 1px;"><span style="font-size: 12px; font-weight: 600;">{{ $v->productInfo->productBrand->name }}</span></p>
                                @endif
                            </td>
                            <td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">{{ $v->productInfo->size }}</td>
                            <td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">{{ $v->productInfo->color }}</td>
                            {{--<td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">{{ $v->productInfo->hsn_code }}</td>--}}
                            <td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">
                                {{ str_replace(".00","", $v->product_qty) }}
                                {{ $v->unitInfo->short_name }}
                            </td>
                            <td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">{{ number_format($v->sale_price, 2) }}</td>
                            <td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">{{ str_replace(".00","", $v->gst_rate) }} %</td>
                            <td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">{{ number_format($v->sgst_amount, 2) }}</td>
                            <td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">{{ number_format($v->cgst_amount, 2) }}</td>
                            <td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">{{ number_format($v->igst_amount, 2) }}</td>
                            <td style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">{{ number_format($v->unit_total_amount, 2) }}</td>
                        </tr>
                        @php $sl++; @endphp
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="11" style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;">No records found!</td>
                </tr>
            @endif
            <tr>
                <th colspan="10" style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: right; font-size: 12px;"><label>Total Amount</label></th>
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;"><label>{{ number_format($data->total_amount, 2) }}</label></th>
            </tr>
            <tr>
                <th colspan="10" style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: right; font-size: 12px;"><label>Discount</label></th>
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;"><label>{{ number_format($data->total_discount, 2) }}</label></th>
            </tr>
            <tr>
                <th colspan="10" style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: right; font-size: 12px;"><label>Total Payable Amount</label></th>
                <th style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 12px;"><label>{{ number_format($data->payable_amount, 2) }}</label></th>
            </tr>
            <tr>
                <td colspan="11" style="padding: 8px; border: 1px solid #ddd; vertical-align: middle; text-align: left; font-size: 13px;">
                    <label><b>In Words: </b></label>
                    <p style="line-height: 5px;">
                        Your payable amount is <strong>{{ ucwords(Helper::spellNumber(round($data->payable_amount))) }}</strong>
                    </p>
                    <p style="line-height: 5px;">Thankyou!</p>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection

@section('content_footer')
<div class="row">
    <div class="col-md-6">
        
    </div>
    <div class="col-md-6" style="text-align: right;">
        <button type="button" class="btn btn-success print-btn"><i class="fas fa-print"></i> Print Bill</button>
    </div>
</div>
@endsection

@push('page_script')

@endpush

@push('page_js')
<script>
$(function() {
    $('.print-btn').on('click', function() {
        PrintElem();
    });

    function PrintElem(){
        var mywindow = window.open('', 'Print-Window', 'height=600,width=800');
        var downloadFileName = document.getElementById('downloadFileName').value;
        mywindow.document.write('<html><head><title>' + downloadFileName + '</title>');
        mywindow.document.write('</head><body>');
        mywindow.document.write(document.getElementById('printContentArea').innerHTML);
        mywindow.document.write('</body></html>');
        //mywindow.document.getElementById('barcodeImg').style.width = "270px";
        //mywindow.document.getElementById('ttx').style.marginBottom = '10px';
        //mywindow.document.getElementById('signatureBox').style.display = 'block';
        mywindow.document.close(); // necessary for IE >= 10
        setTimeout(function () {
            mywindow.print();
            mywindow.focus(); // necessary for IE >= 10*/
            mywindow.close();
        }, 1000);
        return false;
    }
});
</script>
@endpush