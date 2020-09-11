<?php

namespace App\Services;

use App\Models\Product;
use Cardinity\Client;
use Cardinity\Method\Payment;
use Cardinity\Exception;
use DB;


class ProductService
{
    public function updateCartService($request){      
        $result = [];
        $productsCart = [];
        $valid = true;
        $totalPrice = 0;
        $totalNumber = 0;
        $items = $request->input('items');
        if(!is_null($items)){
            $product_ids = array_keys($items);
            $products = Product::whereIn('id',$product_ids)->get();
            foreach ($products as $product) {
                $data = [];
                if($items[$product->id]>2){
                    $valid = false;
                    break;
                }
                else{
                    $data['id'] = $product->id;
                    $data['quantity'] = $items[$product->id];
                    $data['name'] = $product->name;
                    $data['price'] = $product->price;
                    $data['itemTotalPrice'] = $items[$product->id]*$product->price. ' '.$product->currency;
                    array_push($productsCart, $data);
                    $totalPrice += ($items[$product->id]*$product->price);
                    $totalNumber += $data['quantity'];
                }
            }
        }
        if($valid){
            $result['success'] = true;
            $result['data'] = $productsCart;
            $sessionData['productsCart'] = $productsCart;
            $sessionData['totalPrice'] = $totalPrice;
            $sessionData['totalNumber'] = $totalNumber;
            $sessionData['items'] =  json_encode($items);
            if(is_null($items)){
                $request->session()->forget('sessionData');
                $result['message'] = "Cart is empty";
            }
            else{
                $request->session()->put('sessionData', $sessionData);   
            }
        }
        else{
            $result['success'] = false;
            $result['message'] = "You cannot select more than 2 of same product";
        }
        return $result;
    }


    public function paymentService($request){
        $response=[];
        $cardholder_name = $request->input('cardholder_name');
        $pan_number = $request->input('pan_number');
        $exp_data = explode("/", $request->input('exp_data'));
        $year = "20".$exp_data[1];
        $year = (int) $year;
        $month = (int) $exp_data[0];
        $cvv = $request->input('cvv');
        $amount = session('sessionData')['totalPrice'];

        try {
        // dd($year);
            $client = Client::create([
                'consumerKey' => 'test_xwtk3yqf1xfjw4o0yi3gc45bccfuoa',
                'consumerSecret' => 'hntcg2mri0a9ghvaigtoyplm8acjbnd1hkyoudhbs0pdtd6qch',
            ]);

            $method = new Payment\Create([
                'amount' => $amount,
                'currency' => 'EUR',
                'settle' => false,
                'description' => 'some description',
                'order_id' => '1234567811',
                'country' => 'LT',
                'payment_method' => Payment\Create::CARD,
                'payment_instrument' => [
                    'pan' => $pan_number,
                    'exp_year' => $year,
                    'exp_month' => $month,
                    'cvc' => $cvv,
                    'holder' => $cardholder_name
                ],
            ]);

            
            /** @type Cardinity\Method\Payment\Payment */
            $payment = $client->call($method);
            $status = $payment->getStatus();

            
            if($status == 'pending') {
              // Retrieve information for 3D-Secure authorization
              $url = $payment->getAuthorizationInformation()->getUrl();
              $data = $payment->getAuthorizationInformation()->getData();
              $status = $data;
            }
            $response['success'] = true;
            $response['status'] = $status;
        } catch (Exception\Declined $exception) {
            /** @type Cardinity\Method\Payment\Payment */
            $payment = $exception->getResult();
            $response['status'] = $payment->getStatus(); // value will be 'declined'
            $errors = $exception->getErrors(); // list of errors occured
            $response['success'] = false;
            $response['message'] = "Payment decliend for limit issue";
        } catch (Exception\ValidationFailed $exception) {
            /** @type Cardinity\Method\Payment\Payment */
            $payment = $exception->getResult();
            $response['status'] = $payment->getStatus(); // value will be 'declined'
            $errors = $exception->getErrors(); // list of errors occured
            $response['success'] = false;
            $response['message'] = "Payment decliend for validation error";
        } catch (Exception\InvalidAttributeValue $exception) {
            /** @type Cardinity\Method\Payment\Payment */
            $response['success'] = false;
            $response['status'] = "invalid";
            $response['message'] = "Card Information Error";
        }
        return $response;
    }
}
