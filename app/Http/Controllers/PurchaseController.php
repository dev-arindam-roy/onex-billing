<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProductVariants;
use App\Models\Batch;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\BatchProducts;
use App\Models\User;
use App\Models\Unit;
use Helper;

class PurchaseController extends Controller
{

    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        $dataBag = [];
        $dataBag['sidebar_parent'] = 'purchase_management';
        $dataBag['sidebar_child'] = 'all-purchases';
        $pagination = !empty($request->get('pagination')) ? $request->get('pagination') : 25;
        $searchText = ($request->has('search_text') && !empty($request->get('search_text'))) ? $request->get('search_text') : null;  
        $dataBag['data'] = Purchase::with([
                'batchInfo',
                'vendorInfo',
                'purchaseProducts'
            ])
            ->when(!empty($searchText), function ($query) use ($searchText) {
                $query->whereHas('batchInfo', function ($batchQry) use ($searchText) {
                    $batchQry->where('batch_no', $searchText)
                        ->orWhere('name', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('bill_no', $searchText);
                });
                $query->orWhereHas('vendorInfo', function ($vendorQry) use ($searchText) {
                    $vendorQry->where('first_name', 'like', '%' . $searchText . '%')
                        ->orWhere('last_name', 'like', '%' . $searchText . '%');
                });
                return $query;
            })
            ->where('status', '!=', 3)
            ->orderBy('id', 'desc')
            ->paginate($pagination);

        if ($request->ajax()) {
            return view('backend.purchase.all-purchase-render', $dataBag);
        }

        return view('backend.purchase.index', $dataBag);
    }

    public function add(Request $request)
    {
        $dataBag = [];
        $dataBag['sidebar_parent'] = 'purchase_management';
        $dataBag['sidebar_child'] = 'add-purchase';

        $dataBag['batches'] = Batch::where('status', '!=', 3)->orderBy('id', 'desc')->get();
        $dataBag['vendors'] = User::where('user_category', 2)->where('status', '!=', 3)->orderBy('first_name', 'asc')->get();
        $dataBag['units'] = Unit::where('status', '!=', 3)->orderBy('id', 'desc')->get();
        $dataBag['productVariants'] = ProductVariants::select(
                'id', 
                'name', 
                'sku', 
                'barcode_no', 
                'unit_id', 
                'price', 
                'old_price', 
                'hsn_code', 
                'gst_rate'
            )
            ->where('status', '!=', 3)
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.purchase.add', $dataBag);
    }

    public function addPurchaseProduct(Request $request, $id)
    {
        $isPurchase = Purchase::where('hash_id', $id)->first();
        if (empty($isPurchase)) {
            return back()
                ->with('message_type', 'error')
                ->with('message_title', 'Server Error!')
                ->with('message_text', 'Something Went Wrong!');
        }

        $dataBag = [];
        $dataBag['sidebar_parent'] = 'purchase_management';
        $dataBag['sidebar_child'] = 'add-purchase';

        $dataBag['batches'] = Batch::where('status', '!=', 3)->orderBy('id', 'desc')->get();
        $dataBag['vendors'] = User::where('user_category', 2)->where('status', '!=', 3)->orderBy('first_name', 'asc')->get();
        $dataBag['units'] = Unit::where('status', '!=', 3)->orderBy('id', 'desc')->get();
        $dataBag['productVariants'] = ProductVariants::select(
                'id', 
                'name', 
                'sku', 
                'barcode_no', 
                'unit_id', 
                'price', 
                'old_price', 
                'hsn_code', 
                'gst_rate'
            )
            ->where('status', '!=', 3)
            ->orderBy('id', 'desc')
            ->get();

        $dataBag['purchase'] = Purchase::findOrFail($isPurchase->id);

        return view('backend.purchase.add-purchase-product', $dataBag);
    }

    public function savePurchaseProduct(Request $request, $id)
    {

        $isPurchaseExist = Purchase::findOrFail($id);

        $productId = $request->input('product_id');
        $batchId = $request->input('batch_id');
        $vendorId = $request->input('vendor_id');
        $billNo = !empty($request->input('bill_no')) ? $request->input('bill_no') : null;
        $receivedDate = date('Y-m-d', strtotime($request->input('received_date')));

        /** purchase entry */
        $purchaseId = self::doPurchase($request, $isPurchaseExist);

        if (!empty($purchaseId)) {
            /** purchase product entry */
            $purchaseProduct = new PurchaseProduct();
            $purchaseProduct->purchase_id = $purchaseId;
            $purchaseProduct->batch_id = $request->input('batch_id');
            $purchaseProduct->vendor_id = $request->input('vendor_id');
            $purchaseProduct->product_id = $request->input('product_id');
            $purchaseProduct->product_qty = $request->input('product_qty');
            $purchaseProduct->unit_id = $request->input('unit_id');
            $purchaseProduct->purchase_price = $request->input('purchase_price');
            $purchaseProduct->sale_price = $request->input('sale_price');
            $purchaseProduct->gst_rate = $request->input('gst_rate');
            $purchaseProduct->gst_amount = $request->input('gst_amount');
            $purchaseProduct->total_amount = $request->input('total_amount');
            if ($purchaseProduct->save()) {
                
                /** check purchase batch with product combination */
                $isBatchProductsExist = BatchProducts::where('batch_id', $batchId)
                    ->where('product_id', $productId)
                    ->first();

                /** purchase batch product add or update */
                $batchEntry = self::batchWiseProduct($request, $isBatchProductsExist);

                /** product variant master table final current stock */
                if (!empty($batchEntry)) {
                    ProductVariants::where('id', $batchEntry->product_id)
                        ->increment('available_stock', $batchEntry->product_qty);
                }

                return redirect()->back()
                    ->with('message_type', 'success')
                    ->with('message_title', 'Done!')
                    ->with('message_text', 'New purchase entry has been created successfully');
            }
        }

        return back()
            ->with('message_type', 'error')
            ->with('message_title', 'Server Error!')
            ->with('message_text', 'Something Went Wrong!');
    }

    public function save(Request $request)
    {
        $productId = $request->input('product_id');
        $batchId = $request->input('batch_id');
        $vendorId = $request->input('vendor_id');
        $billNo = !empty($request->input('bill_no')) ? $request->input('bill_no') : null;
        $receivedDate = date('Y-m-d', strtotime($request->input('received_date')));

        $receivedDateStart = $receivedDate . '00:00:00';
        $receivedDateEnd = $receivedDate . '23:59:59';

        /** check already purchase exist or not with below condition */
        $isPurchaseExist = Purchase::where('batch_id', $batchId)
            ->where('bill_no', $billNo)
            ->where('vendor_id', $vendorId)
            ->whereDate('received_date', $receivedDate)
            ->first();

        /** purchase entry */
        $purchaseId = self::doPurchase($request, $isPurchaseExist);

        if (!empty($purchaseId)) {
            /** purchase product entry */
            $purchaseProduct = new PurchaseProduct();
            $purchaseProduct->purchase_id = $purchaseId;
            $purchaseProduct->batch_id = $request->input('batch_id');
            $purchaseProduct->vendor_id = $request->input('vendor_id');
            $purchaseProduct->product_id = $request->input('product_id');
            $purchaseProduct->product_qty = $request->input('product_qty');
            $purchaseProduct->unit_id = $request->input('unit_id');
            $purchaseProduct->purchase_price = $request->input('purchase_price');
            $purchaseProduct->sale_price = $request->input('sale_price');
            $purchaseProduct->gst_rate = $request->input('gst_rate');
            $purchaseProduct->gst_amount = $request->input('gst_amount');
            $purchaseProduct->total_amount = $request->input('total_amount');
            if ($purchaseProduct->save()) {
                
                /** check purchase batch with product combination */
                $isBatchProductsExist = BatchProducts::where('batch_id', $batchId)
                    ->where('product_id', $productId)
                    ->first();

                /** purchase batch product add or update */
                $batchEntry = self::batchWiseProduct($request, $isBatchProductsExist);

                /** product variant master table final current stock */
                if (!empty($batchEntry)) {
                    ProductVariants::where('id', $batchEntry->product_id)
                        ->increment('available_stock', $batchEntry->product_qty);
                }

                return redirect()->back()
                    ->with('message_type', 'success')
                    ->with('message_title', 'Done!')
                    ->with('message_text', 'New purchase entry has been created successfully')
                    ->withInput($request->only(['bill_no', 'received_date', 'batch_id', 'vendor_id']));
            }
        }

        return back()
            ->with('message_type', 'error')
            ->with('message_title', 'Server Error!')
            ->with('message_text', 'Something Went Wrong!');

    }

    public function edit(Request $request, $id)
    {
        $isPurchase = Purchase::where('hash_id', $id)->first();
        if (empty($isPurchase)) {
            return back()
                ->with('message_type', 'error')
                ->with('message_title', 'Server Error!')
                ->with('message_text', 'Something Went Wrong!');
        }
        
        $dataBag = [];
        $dataBag['sidebar_parent'] = 'purchase_management';
        $dataBag['sidebar_child'] = 'add-purchase';

        $dataBag['batches'] = Batch::where('status', '!=', 3)->orderBy('id', 'desc')->get();
        $dataBag['vendors'] = User::where('user_category', 2)->where('status', '!=', 3)->orderBy('first_name', 'asc')->get();
        $dataBag['units'] = Unit::where('status', '!=', 3)->orderBy('id', 'desc')->get();
        $dataBag['productVariants'] = ProductVariants::select(
                'id', 
                'name', 
                'sku', 
                'barcode_no', 
                'unit_id', 
                'price', 
                'old_price', 
                'hsn_code', 
                'gst_rate'
            )
            ->where('status', '!=', 3)
            ->orderBy('id', 'desc')
            ->get();

        $dataBag['purchase'] = Purchase::with([
                'purchaseProducts' => function ($purchaseProductQry) {
                    $purchaseProductQry->with([
                        'productVariantInfo',
                        'unitInfo'
                    ])
                    ->where('status', '!=', 3);
                },
                'batchInfo',
                'vendorInfo'
            ])
            ->findOrFail($isPurchase->id);

        return view('backend.purchase.edit', $dataBag);
    }

    public function update(Request $request, $id)
    {
        $batchId = $request->input('disabled_batch_id_value') ?? null;
        $vendorId = $request->input('disabled_vendor_id_value') ?? null;
        $billNo = !empty($request->input('bill_no')) ? $request->input('bill_no') : null;
        $receivedDate = date('Y-m-d', strtotime($request->input('disabled_received_date_value')));

        $receivedDateStart = $receivedDate . '00:00:00';
        $receivedDateEnd = $receivedDate . '23:59:59';

        /** check already purchase exist or not with below condition */
        $isPurchaseExist = Purchase::where('batch_id', $batchId)
            ->where('bill_no', $billNo)
            ->where('vendor_id', $vendorId)
            ->whereDate('received_date', $receivedDate)
            ->where('id', '!=', $id)
            ->first();

        if (!empty($isPurchaseExist)) {
            return back()
                ->with('message_type', 'error')
                ->with('message_title', 'Purchase already exist')
                ->with('message_text', 'This purchase all ready exist with this combination');
        }

        $purchase = Purchase::findOrFail($id);
        $purchase->bill_no = $billNo;
        $purchase->note = $request->input('note') ?? null;
        $purchase->save();

        return back()
            ->with('message_type', 'success')
            ->with('message_title', 'Success!')
            ->with('message_text', 'Purchase information has been updated successfully');
    }

    public static function doPurchase($requestObj, $purchase)
    {
        if (!empty($purchase)) {
            $purchase->bill_amount = $purchase->bill_amount + $requestObj->input('total_amount');
            $purchase->due_amount = $purchase->due_amount + $requestObj->input('total_amount');
            $purchase->save();
            return $purchase->id;
        }

        $purchase = new Purchase();
        $purchase->hash_id = (string) Str::uuid();
        $purchase->batch_id = $requestObj->input('batch_id');
        $purchase->vendor_id = $requestObj->input('vendor_id');
        $purchase->bill_amount = $requestObj->input('total_amount');
        $purchase->due_amount = $requestObj->input('total_amount');
        $purchase->bill_no = !empty($requestObj->input('bill_no')) ? $requestObj->input('bill_no') : null;
        $purchase->received_date = date('Y-m-d', strtotime($requestObj->input('received_date')));
        $purchase->save();
        return $purchase->id;
    }

    public static function batchWiseProduct($requestObj, $batchProducts) {

        if (!empty($batchProducts)) {
            $batchProducts->product_qty = $batchProducts->product_qty + $requestObj->input('product_qty');
            $batchProducts->purchase_price = $requestObj->input('purchase_price');
            $batchProducts->sale_price = $requestObj->input('sale_price');
            $batchProducts->status = 1;
            $batchProducts->save();
            Batch::where('id', $requestObj->input('batch_id'))->update(['status' => 1]);
            return $batchProducts;
        }

        $batchProductsEntry = new BatchProducts();
        $batchProductsEntry->batch_id = $requestObj->input('batch_id');
        $batchProductsEntry->product_id = $requestObj->input('product_id');
        $batchProductsEntry->product_qty = $requestObj->input('product_qty');
        $batchProductsEntry->purchase_price = $requestObj->input('purchase_price');
        $batchProductsEntry->sale_price = $requestObj->input('sale_price');
        $batchProductsEntry->status = 1;
        $batchProductsEntry->save();
        Batch::where('id', $requestObj->input('batch_id'))->update(['status' => 1]);
        return $batchProductsEntry;

    }

    public function deletePurchase(Request $request, $id)
    {
        $check = Purchase::where('hash_id', $id)->first();
        if (empty($check)) {
            return back()
                ->with('message_type', 'error')
                ->with('message_title', 'Server Error!')
                ->with('message_text', 'Something Went Wrong!');
        }
        $purchase = Purchase::findOrFail($check->id);
        $purchase->status = 3;
        if ($purchase->save()) {
            $purchaseProducts = PurchaseProduct::where('purchase_id', $purchase->id)->where('status', 1)->get();
            if (count($purchaseProducts)) {
                foreach ($purchaseProducts as $k => $v) {
                    
                    BatchProducts::where('batch_id', $v->batch_id)
                        ->where('product_id', $v->product_id)
                        ->where('status', 1)
                        ->where('product_qty', '>=', $v->product_qty)
                        ->decrement('product_qty', $v->product_qty);
                    
                    ProductVariants::where('id', $v->product_id)
                        ->where('available_stock', '>=', $v->product_qty)
                        ->decrement('available_stock', $v->product_qty);
                }
                PurchaseProduct::where('purchase_id', $purchase->id)->update(['status' => 3]);
                BatchProducts::where('status', 1)->where('product_qty', '<=', 0)->update(['status' => 3]);
            }
        }
        return redirect()->back()
            ->with('message_type', 'success')
            ->with('message_title', 'Done!')
            ->with('message_text', 'Purchase entry has been deleted successfully');
    }

    /**
     * Batches
     */
    public function batchIndex(Request $request)
    {
        $dataBag = [];
        $dataBag['sidebar_parent'] = 'purchase_management';
        $dataBag['sidebar_child'] = 'all-batches';
        $pagination = !empty($request->get('pagination')) ? $request->get('pagination') : 25; 
        $batchSearchText = ($request->has('batch_search_text') && !empty($request->get('batch_search_text'))) ? $request->get('batch_search_text') : null; 
        $dataBag['data'] = Batch::where('status', '!=', 3)
            ->when(!empty($batchSearchText), function ($query) use ($batchSearchText) {
                return $query->where('batch_no', $batchSearchText)
                    ->orWhere('name', 'like', '%' . $batchSearchText . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($pagination);
        
        if ($request->ajax()) {
            return view('backend.purchase.all-batches-render', $dataBag);
        }
        return view('backend.purchase.all-batches', $dataBag);
    }

    public function addBatch(Request $request)
    {
        $dataBag = [];
        $dataBag['sidebar_parent'] = 'purchase_management';
        $dataBag['sidebar_child'] = 'all-batches';
        $dataBag['batch_no'] = Helper::createBatchNo(); 
        return view('backend.purchase.add-batch', $dataBag);
    }

    public function saveBatch(Request $request)
    {
        $batchNo = $request->input('batch_no');
        $checkBatch = Batch::where('batch_no', $batchNo)->where('status', '!=', 3)->exists();

        if ($checkBatch) {
            return back()
                ->with('message_type', 'error')
                ->with('message_title', 'Sorry!')
                ->with('message_text', 'Batch No is already exist');
        }

        $batch = new Batch();
        $batch->batch_no = $request->input('batch_no');
        $batch->name = $request->input('name') ?? '';
        $batch->description = $request->input('description') ?? null;
        $batch->status = $request->input('status');
        if ($batch->save()) {
            return redirect()->back()
                ->with('message_type', 'success')
                ->with('message_title', 'Done!')
                ->with('message_text', 'New Batch has been created successfully');
        }
        return back()
            ->with('message_type', 'error')
            ->with('message_title', 'Server Error!')
            ->with('message_text', 'Something Went Wrong!');
    }

    public function editBatch(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);
        $dataBag = [];
        $dataBag['sidebar_parent'] = 'purchase_management';
        $dataBag['sidebar_child'] = 'all-batches';
        $dataBag['data'] = $batch; 
        return view('backend.purchase.edit-batch', $dataBag);
    }

    public function updateBatch(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        $batchNo = $request->input('batch_no');
        $checkBatch = Batch::where('batch_no', $batchNo)
            ->where('id', '!=', $id)
            ->where('status', '!=', 3)
            ->exists();

        if ($checkBatch) {
            return back()
                ->with('message_type', 'error')
                ->with('message_title', 'Sorry!')
                ->with('message_text', 'Batch No is already exist');
        }

        //$batch->batch_no = $request->input('batch_no');
        $batch->name = $request->input('name') ?? '';
        $batch->description = $request->input('description') ?? null;
        $batch->status = $request->input('status');
        if ($batch->save()) {
            return redirect()->back()
                ->with('message_type', 'success')
                ->with('message_title', 'Done!')
                ->with('message_text', 'Batch has been updated successfully');
        }
        return back()
            ->with('message_type', 'error')
            ->with('message_title', 'Server Error!')
            ->with('message_text', 'Something Went Wrong!');
    }

    public function deleteBatch(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);
        $batch->status = 3;
        $batch->save();
        return redirect()->back()
                ->with('message_type', 'success')
                ->with('message_title', 'Done!')
                ->with('message_text', 'Batch has been deleted successfully');
    }
}
