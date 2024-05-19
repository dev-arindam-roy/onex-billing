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
use Session;
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

    public function addItem(Request $request)
    {
        $invoiceNo = $request->input('invoice_no');
        $saleDate = !empty($request->input('sale_date')) ? date('Y-m-d', strtotime($request->input('sale_date'))) : date('Y-m-d');
        $customerHash = $request->input('customer_id');
        $productId = $request->input('product_id');
        $batchId = $request->input('batch_id');
        $salePrice = $request->input('sale_price');
        $productQty = $request->input('product_qty');
        $unitId = $request->input('unit_id');
        $gstRate = $request->input('gst_rate');
        $gstAmount = $request->input('gst_amount');
        $totalAmount = $request->input('total_amount');
        $isIgst = ($request->has('is_igst') && !empty($request->input('is_igst'))) ? true : false;

        $batchProductTabId = $request->input('hidden_batch_product_id');
        $purchaseProductTabId = $request->input('hidden_purchase_product_id');

        $cartProduct = ProductVariants::select(
                'id',
                'brand_id',
                'name',
                'sku',
                'barcode_no',
                'hsn_code'
            )
            ->with(['productBrand'])
            ->where('id', $productId)
            ->first();

        $cartCustomer = User::select(
                'id',
                'hash_id',
                'first_name',
                'last_name',
                'email_id',
                'phone_number'
            )
            ->where('hash_id', $customerHash)
            ->first();

        $priceInfo = array();
        $priceInfo['unit_price'] = $salePrice;
        $priceInfo['item_qty'] = $productQty;
        
        $priceInfo['gst_rate'] = $gstRate;
        $priceInfo['sgst_rate'] = !empty($gstRate) ? round($gstRate / 2) : 0;
        $priceInfo['cgst_rate'] = !empty($gstRate) ? round($gstRate / 2) : 0;
        $priceInfo['igst_rate'] = ($isIgst && !empty($gstRate)) ? round($gstRate / 2) : 0;

        $priceInfo['unit_price_with_gst'] = round($salePrice + (($salePrice * $gstRate) / 100));
        if ($isIgst) {
            $priceInfo['unit_price_with_gst'] = round($priceInfo['unit_price_with_gst'] + $salePrice + (($salePrice * $isIgst) / 100));
        }
        $priceInfo['total_amount'] = round($priceInfo['unit_price_with_gst'] * $productQty);
        $priceInfo['total_gst_amount'] = round($priceInfo['total_amount'] - ($salePrice * $productQty));

        $priceInfo['total_sgst_amount'] = !empty($priceInfo['sgst_rate']) ? round((($salePrice * $priceInfo['sgst_rate']) / 100) * $productQty) : 0;
        $priceInfo['total_cgst_amount'] = !empty($priceInfo['cgst_rate']) ? round((($salePrice * $priceInfo['cgst_rate']) / 100) * $productQty) : 0;
        $priceInfo['total_igst_amount'] = ($isIgst && !empty($priceInfo['igst_rate'])) ? round((($salePrice * $priceInfo['igst_rate']) / 100) * $productQty) : 0;

        $cart = !empty(Session::get('cart')) ? Session::get('cart') : [];
        $cart[$productId] = array(
            'product_info' => $cartProduct,
            'customer_info' => $cartCustomer,
            'price_info' => $priceInfo,
            'quantity' => $productQty,
            'price' => $salePrice,
            'invoice_no' => $invoiceNo,
            'sale_date' => $saleDate,
            'batch_id' => $batchId,
            'unit_id' => $unitId,
            'batch_product_table_id' => $batchProductTabId,
            'purchase_product_table_id' => $purchaseProductTabId
        );
        Session::put('cart', $cart);

        return response()->json(array('isSuccess' => true, 'message' => 'Item has been added to cart successfully', 'data' => $cart));
    }

    public function cancelNewSale(Request $request)
    {
        Session::forget('cart');
        return redirect()
            ->back()
            ->with('message_type', 'success')
            ->with('message_title', 'Done!')
            ->with('message_text', 'Sale has been cancelled successfully');
    }

    public function removeItem(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = !empty(Session::get('cart')) ? Session::get('cart') : [];
        if (!empty($cart)) {
            if (isset($cart[$productId]) && !empty($cart[$productId])) {
                unset($cart[$productId]);
            }
        }
        Session::put('cart', $cart);
        if (Session::has('cart') && (empty(Session::get('cart')) || count(Session::get('cart')) == 0)) {
            Session::forget('cart');
            $cart = !empty(Session::get('cart')) ? Session::get('cart') : [];
        }

        return response()->json(array('isSuccess' => true, 'message' => 'Item has been removed from cart successfully', 'data' => $cart));
    }
}
