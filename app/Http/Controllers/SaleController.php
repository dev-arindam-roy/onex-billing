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
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\CompanyInformation;
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
        $dataBag['data'] = Sale::with([
                'customerInfo',
                'saleProducts'
            ])
            ->when(!empty($searchText), function ($query) use ($searchText) {
                $query->where('invoice_no', $searchText);
                $query->orWhereHas('customerInfo', function ($batchQry) use ($searchText) {
                    $batchQry->where('phone_number', $searchText)
                        ->orWhere('first_name', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('email_id', 'LIKE', '%' . $searchText . '%');
                });
                return $query;
            })
            ->where('status', '!=', 3)
            ->orderBy('id', 'desc')
            ->paginate($pagination);

        if ($request->ajax()) {
            return view('backend.sale.all-sale-render', $dataBag);
        }

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
                'gst_rate',
                'available_stock'
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
        $cartInfo = !empty(Session::get('cart_info')) ? Session::get('cart_info') : [];
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
        $cartInfo['customer'] = $cartCustomer;
        $cartInfo['sale_date'] = $saleDate;
        $cartInfo['invoice_no'] = $invoiceNo;

        Session::put('cart', $cart);
        Session::put('cart_info', $cartInfo);

        return response()->json(array('isSuccess' => true, 'message' => 'Item has been added to cart successfully', 'data' => $cart));
    }

    public function cancelNewSale(Request $request)
    {
        Session::forget('cart');
        Session::forget('cart_info');
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
            Session::forget('cart_info');
            $cart = !empty(Session::get('cart')) ? Session::get('cart') : [];
        }

        return response()->json(array('isSuccess' => true, 'message' => 'Item has been removed from cart successfully', 'data' => $cart));
    }

    public function createSave(Request $request)
    {
        if (!Session::has('cart') || empty(Session::get('cart'))) {
            Session::forget('cart');
            Session::forget('cart_info');
            return response()->json(array('isSuccess' => false, 'message' => 'Empty sale list'));
        }
        if (!Session::has('cart_info') || empty(Session::get('cart_info'))) {
            Session::forget('cart');
            Session::forget('cart_info');
            return response()->json(array('isSuccess' => false, 'message' => 'Empty sale list'));
        }

        $cart = !empty(Session::get('cart')) ? Session::get('cart') : [];
        $cartInfo = !empty(Session::get('cart_info')) ? Session::get('cart_info') : [];

        if (empty($cartInfo['customer'])) {
            return response()->json(array('isSuccess' => false, 'message' => 'Customer information not found'));
        }

        $customer = User::where('hash_id', $cartInfo['customer']->hash_id)->first();

        if (empty($customer)) {
            return response()->json(array('isSuccess' => false, 'message' => 'Customer information not found'));
        }

        $totalDiscount = !empty($request->input('total_discount')) ? $request->input('total_discount') : 0;

        $isSaleSave = $isSaleProductSave = false;
        $saleId = null;

        $sale = new Sale();
        $sale->invoice_no = Helper::createSaleInvoiceNo();
        $sale->hash_id = (string) Str::uuid();
        $sale->customer_id = $customer->id;
        $sale->sale_date = !empty($cartInfo['sale_date']) ? date('Y-m-d', strtotime($cartInfo['sale_date'])) : date('Y-m-d');
        $sale->total_discount = $totalDiscount;

        $payableAmount = $totalAmount = $totalGstAmount = $totalSgstAmount = $totalCgstAmount = $totalIgstAmount = 0;

        foreach ($cart as $productId => $v) {
            if (is_array($v['price_info']) && !empty($v['price_info']) && count($v['price_info'])) {
                $totalAmount = $totalAmount + (!empty($v['price_info']['total_amount']) ? $v['price_info']['total_amount'] : 0); 
                $totalGstAmount = $totalGstAmount + (!empty($v['price_info']['total_gst_amount']) ? $v['price_info']['total_gst_amount'] : 0);
                $totalSgstAmount = $totalSgstAmount + (!empty($v['price_info']['total_sgst_amount']) ? $v['price_info']['total_sgst_amount'] : 0);
                $totalCgstAmount = $totalCgstAmount + (!empty($v['price_info']['total_cgst_amount']) ? $v['price_info']['total_cgst_amount'] : 0);
                $totalIgstAmount = $totalIgstAmount + (!empty($v['price_info']['total_igst_amount']) ? $v['price_info']['total_igst_amount'] : 0); 
            }
        }

        $payableAmount = $totalAmount - $totalDiscount;

        $sale->total_amount = $totalAmount;
        $sale->total_gst_amount = $totalGstAmount;
        $sale->total_sgst_amount = $totalSgstAmount;
        $sale->total_cgst_amount = $totalCgstAmount;
        $sale->total_igst_amount = $totalIgstAmount;
        $sale->payable_amount = $payableAmount;
        $sale->due_amount = $payableAmount;

        if ($sale->save()) {
            $isSaleSave = true;
            $saleId = $sale->id;
            foreach ($cart as $productId => $v) {
                $saleProduct = new SaleProduct();
                $saleProduct->sale_id = $saleId;
                $saleProduct->invoice_no = $sale->invoice_no;
                $saleProduct->customer_id = $sale->customer_id;
                $saleProduct->product_id = $productId;
                $saleProduct->batch_id = $v['batch_id'];
                $saleProduct->product_qty = $v['quantity'];
                $saleProduct->unit_id = $v['unit_id'];
                if (is_array($v['price_info']) && !empty($v['price_info']) && count($v['price_info'])) {
                    $saleProduct->sale_price = $v['price_info']['unit_price'];
                    $saleProduct->gst_rate = $v['price_info']['gst_rate'];
                    $saleProduct->sgst_amount = $v['price_info']['total_sgst_amount'];
                    $saleProduct->cgst_amount = $v['price_info']['total_cgst_amount'];
                    $saleProduct->igst_amount = $v['price_info']['total_igst_amount'];
                    $saleProduct->unit_total_amount = $v['price_info']['total_amount'];
                    $saleProduct->total_gst_amount = $v['price_info']['total_gst_amount'];
                }

                if (!empty($v['purchase_product_table_id'])) {
                    $purchaseProduct = PurchaseProduct::find($v['purchase_product_table_id']);
                    if (!empty($purchaseProduct)) {
                        $saleProduct->purchase_id = $purchaseProduct->purchase_id;
                        $saleProduct->vendor_id = $purchaseProduct->vendor_id;
                    }
                }

                if ($saleProduct->save()) {
                    $isSaleProductSave = true;
                }
            }

            if ($isSaleSave && $isSaleProductSave && !empty($saleId)) {
                if (self::stockOutCalculation($saleId)) {
                    Session::forget('cart');
                    Session::forget('cart_info');
                    return response()->json(array('isSuccess' => true, 'message' => 'Sale has been created successfully', 'data' => $sale));
                } else {
                    Sale::find($saleId)->delete();
                    SaleProduct::where('sale_id', $saleId)->delete();
                    self::stockOutCalculationRevert($saleId);
                    return response()->json(array('isSuccess' => false, 'message' => 'Something went wrong. Stock dispute found by system'));
                }
            } else {
                Sale::find($saleId)->delete();
                SaleProduct::where('sale_id', $saleId)->delete();
                return response()->json(array('isSuccess' => false, 'message' => 'Something went wrong. Contact to administrator'));
            }
        }

        return response()->json(array('isSuccess' => false, 'message' => 'Something went wrong. Contact to administrator'));
    }

    public static function stockOutCalculation($saleId)
    {
        $isAllOperationDone = false;
        $cart = !empty(Session::get('cart')) ? Session::get('cart') : [];
        foreach ($cart as $productId => $v) {
            if (!empty($v['quantity']) && !empty($v['batch_product_table_id'])) {
                $batchProducts = BatchProducts::find($v['batch_product_table_id']);
                if (!empty($batchProducts)) {
                    if ($batchProducts->product_qty >= $v['quantity']) {
                        $restQty = $batchProducts->product_qty - $v['quantity'];
                    } else {
                        $restQty = 0;
                    }
                    $batchProducts->product_qty = $restQty;
                    if ($batchProducts->save()) {
                        BatchProducts::where('status', 1)->where('product_qty', '<=', 0)->update(['status' => 3]);
                        $productVariants = ProductVariants::find($productId);
                        if (!empty($productVariants)) {
                            if ($productVariants->available_stock >= $v['quantity']) {
                                $restQty = $productVariants->available_stock - $v['quantity'];
                            } else {
                                $restQty = 0;
                            }
                            $productVariants->available_stock = $restQty;
                            $productVariants->save();
                            $isAllOperationDone = true;
                        }
                    }
                }
            }
        }
        return $isAllOperationDone;
    }

    public static function stockOutCalculationRevert($saleId)
    {
        //revert calculatuon here
        //or
        //need to use DB Transaction
        return true;
    }

    public function billPrint(Request $request, $id)
    {
        $dataBag = [];
        $dataBag['sidebar_parent'] = 'sale_management';
        $dataBag['sidebar_child'] = 'all-sales';

        $dataBag['data'] = Sale::with([
            'customerInfo' => function ($userInfoQry) {
                $userInfoQry->with(['userProfile']);
            },
            'saleProducts' => function ($saleProductsQry) {
                $saleProductsQry->with([
                    'unitInfo',
                    'productInfo' => function ($productInfoQry) {
                        $productInfoQry->with(['productBrand']);
                    } 
                ]);
            }
        ])
        ->where('hash_id', $id)
        ->where('status', '!=', 3)
        ->first();

        if (empty($dataBag['data'])) {
            abort(404);
        }
        
        $dataBag['company_information'] = CompanyInformation::first();

        if (empty($dataBag['company_information'])) {
            return back()
                ->with('message_type', 'error')
                ->with('message_title', 'Company Information Not Found')
                ->with('message_text', 'Please add company information first, thankyou!');
        }
        
        return view('backend.sale.bill-print', $dataBag);
    }
}
