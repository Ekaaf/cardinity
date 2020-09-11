<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaymentPost;
use App\Models\Product;
use Cardinity\Client;
use Cardinity\Method\Payment;
use App\Services\ProductService;

class ProductController extends Controller
{   

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request){
        // dd($request->session()->get('sessionData')['totalPrice']);
        // dd(session('items'));
        $products = Product::all();
        return view('index',compact(['products']));
    }

    public function updateCart(Request $request){
        $result = $this->productService->updateCartService($request);
        return response()->json($result);
    }


    public function cart(Request $request){
        $sessionData = session('sessionData');
        return view('cart',compact(['sessionData']));
    }


    public function cardinfo(Request $request){
        return view('cardinfo');
    }


    public function payment(PaymentPost $request){
        if(is_null($request->session()->get('sessionData'))){
            return redirect('/');
        }
        $response = $this->productService->paymentService($request);
        $total = $request->session()->get('sessionData')['totalPrice'];
        if($response['success'] == true){
            $request->session()->forget('sessionData');
        }
        return view('payment',compact(['response', 'total']));
    }
}	
