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

class SaleController extends Controller
{

    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        $dataBag = [];
        $dataBag['sidebar_parent'] = 'sale_management';
        $dataBag['sidebar_child'] = 'all-sales';
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

        return view('backend.sale.index', $dataBag);
    }

    public function createNewSale(Request $request)
    {
        $dataBag = [];
        $dataBag['sidebar_parent'] = 'sale_management';
        $dataBag['sidebar_child'] = 'add-sale';

        $dataBag['invoice_no'] = Helper::createSaleInvoiceNo();
        $dataBag['customers'] = User::select(
                'id',
                'hash_id',
                'unique_id',
                'first_name',
                'last_name',
                'email_id',
                'phone_number'
            )
            ->where('user_category', 5)
            ->where('status', '!=', 3)
            ->orderBy('first_name', 'asc')
            ->get();
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

        return view('backend.sale.add', $dataBag);
    }

    public function getProductBatches(Request $request)
    {
        $productId = $request->input('product_id');

        $batchProducts = BatchProducts::with([
                'batchInfo' => function ($selectColQry) {
                    $selectColQry->select('id', 'name', 'batch_no');
                }
            ])
            ->where('product_id', $productId)
            ->where('status', 1)
            ->where('product_qty', '>', 0)
            ->whereHas('batchInfo', function($query) {
                $query->where('status', 1);
            })
            ->get();

        if (count($batchProducts) == 0) {
            return response()->json(array('isSuccess' => false, 'message' => 'No active batches found for this product'));
        }
        
        return response()->json(array('isSuccess' => true, 'message' => 'Product batches are available', 'data' => $batchProducts));
    }

    public function getPurchaseProduct(Request $request)
    {
        $productId = $request->input('product_id');
        $batchId = $request->input('batch_id');

        $purchaseProduct = PurchaseProduct::with([
                'productVariantInfo' => function ($selectColQry) {
                    $selectColQry->select('id', 'price', 'unit_id', 'gst_rate', 'available_stock');
                }
            ])
            ->where('batch_id', $batchId)
            ->where('product_id', $productId)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();
        
        if (empty($purchaseProduct)) {
            return response()->json(array('isSuccess' => false, 'message' => 'No purchase information found for this product'));
        }

        $batchProducts = BatchProducts::select(
                'id',
                'batch_id',
                'product_id',
                'product_qty',
                'purchase_price',
                'sale_price'
            )
            ->where('batch_id', $batchId)
            ->where('product_id', $productId)
            ->where('status', 1)
            ->first();

        $purchaseProduct->batch_product_info = $batchProducts;
        
        return response()->json(array('isSuccess' => true, 'message' => 'Purchase information found', 'data' => $purchaseProduct));
    }
}
