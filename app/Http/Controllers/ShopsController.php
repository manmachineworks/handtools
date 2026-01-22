<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Seshac\Shiprocket\Shiprocket;
use App\Models\Order;
/*
use App\Models\Address;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\CombinedOrder;
use App\Models\Product;
*/
use Auth;
use DB;


class ShopsController extends Controller
{
    public function shipped_order($id){             
        
        
      $order = Order::findOrFail($id);
        
                        $product_name = array();
        
                        foreach($order->orderDetails as $key => $orderDetail){

                                if ($orderDetail->product != null && $orderDetail->product->auction_product == 0){
                                        $product_name[] = ($orderDetail->product->getTranslation('name')); 
                                        
                                }else if ($orderDetail->product != null && $orderDetail->product->auction_product == 1){
                                        $product_name[] =($orderDetail->product->getTranslation('name'));
                                }else{
                                        $product_name[] = 'Product Unavailable';
                                }
                                    
                                        $product_name[] =  (single_price($orderDetail->price));
                                }
            
        $product_n = implode(" , ",$product_name);
        $prod = count($order->orderDetails);
                
        $resultt = DB::table('shiprocket_token')->select('token')->where('id',1)->first();
        $token = $resultt->token;
        $payment_status = ($order->payment_status);
        
        $code = ($order->code);
        $created_at = date('d-m-Y h:i A', $order->date);
        $length = ($order->length);
        $breadth = ($order->breadth);
        $height = ($order->height);
        $weight = ($order->weight);
        $delloc = ($order->delloc);
        //$quantity = ($orderDetail->quantity);
        $priceq = ($order->orderDetails->sum('price'));
        $grand_total = ($order->grand_total);
        $name = json_decode($order->shipping_address)->name;
        $email = json_decode($order->shipping_address)->email;
        $phone = json_decode($order->shipping_address)->phone;
        $postal_code = json_decode($order->shipping_address)->postal_code;
        $state = json_decode($order->shipping_address)->state;
        $city = json_decode($order->shipping_address)->city;
        $address = json_decode($order->shipping_address)->address;
        $country = json_decode($order->shipping_address)->country;
        

$curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>'{"order_id": "'.$code.'",
  "order_date": "'.$created_at.'",
  "pickup_location": "'.$delloc.'",
  "billing_customer_name": "'.$name.'",
  "billing_last_name": "",
  "billing_address": "'.$address.'",
  "billing_address_2": "",
  "billing_city": "'.$city.'",
  "billing_pincode": "'.$postal_code.'",
  "billing_state": "'.$state.'",
  "billing_country": "'.$country.'",
  "billing_email": "'.$email.'",
  "billing_phone": "'.$phone.'",
  "shipping_is_billing": true,
  "shipping_customer_name": "",
  "shipping_last_name": "",
  "shipping_address": "",
  "shipping_address_2": "",
  "shipping_city": "",
  "shipping_pincode": "",
  "shipping_country": "",
  "shipping_state": "",
  "shipping_email": "",
  "shipping_phone": "",
  "order_items": [
    {
      "name": "'.$product_n.'",
      "sku": "tshirt",
      "units": "'.$prod.'",
      "selling_price": "'.$priceq.'",
      "discount": "",
      "tax": "",
      "hsn": 441122
    }
  ],
  "payment_method": "paid",
  "shipping_charges": 0,
  "giftwrap_charges": 0,
  "transaction_charges": 0,
  "total_discount": 0,
  "sub_total": "'.$grand_total.'",
  "length": "'.$length.'",
  "breadth": "'.$breadth.'",
  "height": "'.$height.'",
  "weight": "'.$weight.'"
	}',
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
	   "Authorization: Bearer $token"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
    curl_close($curl);
    $SR_login_Response_out = json_decode($SR_login_Response);
  $ship_order_id=$SR_login_Response_out->order_id;
  $ship_shipment_id=$SR_login_Response_out->shipment_id;
  
      DB::table('orders')->where('id',$id)->update(
    array('ship_order_id'=>"$ship_order_id",'ship_shipment_id'=>"$ship_shipment_id"));
    
  //echo "Order id:-".$ship_order_id.'<br/>';
  //echo "Shipment id:-".$ship_shipment_id.'<br/>';
  return redirect()->back();
}

   public function track_order($id){
        
          $resultt = DB::table('shiprocket_token')->select('token')->where('id',1)->first();
        $token = $resultt->token;
         $order = Order::findOrFail($id);
        $ship = ($order->ship_order_id);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/courier/track/shipment/$ship",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
	   "Authorization: Bearer $token"
    ),
));

$response = curl_exec($curl);

curl_close($curl);
$Response_out = json_decode($response);
$tracking_data=$Response_out->tracking_data;
$track_status = $tracking_data->track_status;
if($track_status!==0){
$shipment_track=$tracking_data->shipment_track;
$Response_data=$shipment_track[0];
$awb_code=$Response_data->awb_code;
//$courier_agent_details=$Response_data->courier_agent_details;
//$packages=$Response_data->packages;
//$idd=$Response_data->id;
$current_status=$Response_data->current_status;

    DB::table('orders')->where('id',$id)->update(
    array('delivery_status'=>"$current_status",'tracking_code'=>"$awb_code"));
    DB::table('order_details')->where('order_id',$id)->update(
    array('delivery_status'=>"$current_status"));
    return redirect()->back();
  
}else{
        $current_status='processing'; 
       DB::table('orders')->where('id',$id)->update(
    array('delivery_status'=>"$current_status"));
           DB::table('order_details')->where('order_id',$id)->update(
    array('delivery_status'=>"$current_status"));
    
    
    //return redirect()->back();
}
	date_default_timezone_set('Asia/Kolkata');
	$curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/auth/login",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>"{\n    \"email\": \"info@dealtaz.in\",\n    \"password\": \"Itadmin@#1608\"\n}",
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  $SR_login_Response_out = json_decode($SR_login_Response);
  print_r($SR_login_Response_out);

  $token = $SR_login_Response_out->{'token'};
  $added_on=date('Y-m-d h:i:s');
    DB::table('shiprocket_token')->where('id',1)->update(
    array('token'=>"$token",'added_on'=>"$added_on"));
    
    return redirect()->back();
}

public function token_r() {
 // echo "hello";

  date_default_timezone_set('Asia/Kolkata');
	$curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/auth/login",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>"{\n    \"email\": \"akanksharajput2208@gmail.com\",\n    \"password\": \"FLEtmaDwzT9j@#k3\"\n}",
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
    ),
  ));

  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  $SR_login_Response_out = json_decode($SR_login_Response);

  $token = $SR_login_Response_out->{'token'};
  //$added_on=date('Y-m-d h:i:s');
  
  print_r($token);
}
    
/*    
public function token_r() {
	date_default_timezone_set('Asia/Kolkata');
	$curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/auth/login",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>"{\n    \"email\": \"info@dealtaz.in\",\n    \"password\": \"Itadmin@#1608\"\n}",
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  $SR_login_Response_out = json_decode($SR_login_Response);

  $token = $SR_login_Response_out->{'token'};
  $added_on=date('Y-m-d h:i:s');
    print_r($token);
  
    DB::table('shiprocket_token')->where('id',1)->update(
    array('token'=>"$token",'added_on'=>"$added_on"));
    
    return redirect()->back();
}
*/
/*
function cancelShipRocketOrder(){
	$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/cancel",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n  \"ids\": [".$ship_order_id."]\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer $token"
  ),
));
	$response = curl_exec($curl);
	curl_close($curl);
	echo $response;
	
}*/

   
}
