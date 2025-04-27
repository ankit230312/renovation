<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -----------------------------------------------------
| PRODUCT NAME:     Grocistore
| -----------------------------------------------------
| AUTHOR:           SUNIL THAKUR (http://sunilthakur.in)
| -----------------------------------------------------
| EMAIL:            sunil.thakur@teknikoglobal.in
| -----------------------------------------------------
| COPYRIGHT:        RESERVED BY TEKNIKOGLOBAL
| -----------------------------------------------------
| WEBSITE:          http://teknikoglobal.com
| -----------------------------------------------------
*/

class Webservice extends CI_Controller{

    function __construct () {
        parent::__construct();
        $this->load->model("webservice_m");
    }

    public function index()
    {
        echo "<h4>RESTRICTED ACCESS</h4>";
    }

    public function generate_random_password($length = 10) {
        $numbers = range('0','9');
        $alphabets = range('A','Z');
        
        //$additional_characters = array('_','.');
        $final_array = array_merge($alphabets,$numbers);
        //$final_array = array_merge($numbers);
        $password = '';      
        while($length--) {
          $key = array_rand($final_array);
          $password .= $final_array[$key];
        }
      
        return $password;
    }

    public function send_otp()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $mobile = $data['mobile'];
        $otp = $data['otp'];
        
        $message = $otp." is your authentication code to register.";

        $message = urlencode($message);
        $this->send_sms($mobile,$message);

        $check_mobile = $this->webservice_m->get_single_table("users",array('mobile'=>$mobile));
        if(!empty($check_mobile))
        {
            $response[] = array('result'=>'success','message'=>'SMS Send Successfully', 'otp'=>$otp);
        } else {
            $response[] = array('result'=>'new','message'=>'SMS Send Successfully', 'otp'=>$otp);
        }
        //send sms for otp
        
        echo json_encode($response);
    }

    public function send_sms($mobile, $message){
        $sender = "EZYTOM";
        $message = urlencode($message);
    
        $msg = "sender=".$sender."&route=4&country=91&message=".$message."&mobiles=".$mobile."&authkey=284738AIuEZXRVCDfj5d26feae";
           
        $ch = curl_init('http://api.msg91.com/api/sendhttp.php?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
            //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        $result = curl_close($ch);
        return $res;
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $mobile = $data['mobile'];
        
        $deviceID = $data['deviceID'];
        $device_token = $data['device_token'];
        $device_type = $data['device_type'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $path = base_url('uploads/');
        
        $user = $this->webservice_m->get_single_table('users',array('mobile'=>$mobile));
        if(!empty($user))
        {   $userID = $user->ID;
            $img = $path.$user->image;   

            if($user->status == 'Y')
            {
                $response[] = array(
                    'result'=>'success',
                    'message'=>'Successful Login',
                    'userID'=>(string)$userID, 
                    "name"=>$user->name, 
                    "mobile"=>$user->mobile, 
                    "email"=>$user->email, 
                    "image"=>$img,
                    "wallet" => $user->wallet,
                    "referral_code"=>$user->referral_code
                    
                );
            } else {
                $response[] = array(
                    "result" => 'verify',
                    "message" => "Your Account is disabled. Please Contact Administrator."
                );
            }

            
        } else {
            $response[] = array('result'=>'failure', 'message'=>'Invalid Login Credential..');
        }
        echo json_encode($response); 
    }

    public function signup()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'];
        $email = $data['email'];
        $mobile = $data['mobile'];
        
        $deviceID = $data['deviceID'];
        $device_token = $data['device_token'];
        $device_type = $data['device_type'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $img = base_url('uploads/user.png');
        $created_on = date('Y-m-d H:i:s');
        $referral_code = strtoupper(substr($name, 0,2)).$this->generate_random_password(6);
        
        $check_email = $this->webservice_m->get_single_table("users",array('email'=>$email));
        if(count($check_email)>0)
        {
            $response[] = array('result'=>'failure','message'=>'Email ID Already Exist');
        
        } else {
            $referral_userID ='0';
            $array = array(
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile,
                'image' => 'user.png',
                'referral_code' => $referral_code,
                'referral_userID' => $referral_userID,
                'wallet' => '0',
                'status' => 'Y',
                'added_on' => $created_on
            );
            $userID = $this->webservice_m->table_insert('users',$array);

            $this->webservice_m->update_device($userID,$ip_address,$deviceID,$device_token,$device_type);
            //send email & sms
            $this->signup_email($to,$message,$subject,$referral_code);
            $response[] = array('result'=>'success','message'=>'Successful Signup','userID'=>(string)$userID, "name"=>$name, "mobile"=>$mobile, "email"=>$email, "image"=>$img, "referral_code"=>$referral_code);
        }
            
        
        echo json_encode($response);
    }

   
 public function test_send_email($subject = 'Test Email',$referral_code = 'GTR45U', $message='test', $to = 'anisha@teknikoglobal.com')
    {
        $this->load->library('email');
        $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
            <title>' . html_escape($subject) . '</title>
            <style type="text/css">
                body {
                    font-family: Arial, Verdana, Helvetica, sans-serif;
                    font-size: 16px;
                }
            </style>
        </head>
        <body>
        ' . $query . '
        </body>
        </html>';
        $result = $this->email
            ->from('anisha@teknikoglobal.com')
            ->reply_to('anisha@teknikoglobal.com')    // Optional, an account where a human being reads.
            ->to($to)
            ->subject($subject)
            ->message($body)
            ->send();

        return $result;
    }
    public function apply_referral_code()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $code = $data['code'];
        $get_user = $this->webservice_m->get_single_table("users",array('referral_code'=>$code));
        if(count($get_user))
        {
            $get_user_r = $this->webservice_m->get_single_table("users",array('referral_code'=>$code));
            $referral_userID = $get_user_r->userID;
            $this->db->query("UPDATE `users` SET `referral_userID`='$referral_userID' WHERE `userID`='$userID'");
            $response[] = array('result'=>'success', 'message'=>'Valid Referral Code');
        } else {
            $response[] = array('result'=>'failure','message'=>'Invalid Referral Code');
        }
        echo json_encode($response);
    }

    public function home()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $path = base_url('admin/uploads/banners/');
        $this->db->select('sum(qty) as count');
        $cart_item_count = $this->db->get_where('product_cart',array('userID'=>$userID))->row();
        $user = $this->webservice_m->get_user(array('ID'=>$userID));
        $banners = $this->webservice_m->get_all_data_where('app_banners',array('status'=>'Y'),'priority','desc');
        foreach($banners as $b)
        {
            $b->banner = $path.$b->banner;
        }
        $response[] = array('result'=>'success', 'banners'=>$banners, 'cart_count'=>$cart_item_count->count);
        echo json_encode($response);
    }

    public function get_product($productID)
    {
        $product = $this->webservice_m->get_single_table('products',array('productID'=>$productID));
        return $product;
    }

    public function get_brand($brandID)
    {
        $brand = $this->webservice_m->get_single_table('brand',array('brandID'=>$brandID));
        return $brand;
    }

    public function get_categories()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $path1 = base_url('admin/uploads/category/');
        $category = $this->webservice_m->get_all_data_where('category',array('parent'=>'0', 'status'=>'Y'));
        foreach($category as $c)
        {
            $c->icon = $path1.$c->icon;
            $c->image = $path1.$c->image;
            $c->subcategories = $this->subcategory($c->categoryID);
        }
        $response[] = array('result'=>'success', 'category'=>$category);
        echo json_encode($response);
    }

    public function subcategory($categoryID)
    {
        $path1 = base_url('admin/uploads/category/');
        $subcategory = $this->webservice_m->get_all_table_query("SELECT `categoryID`, `title` FROM `category` WHERE `parent`='$categoryID' AND `status`='Y'");
        
        return $subcategory;
    }

    public function get_subcategories()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $categoryID = $data['categoryID'];
        $path1 = base_url('admin/uploads/category/');
        $subcategory = $this->webservice_m->get_all_data_where('category',array('parent'=>$categoryID, 'status'=>'Y'));
        foreach($subcategory as $c)
        {
            $c->icon = $path1.$c->icon;
            $c->image = $path1.$c->image;
        }
        $response[] = array('result'=>'success', 'subcategory'=>$subcategory);
        echo json_encode($response);
    }

    public function feature_banners()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $path = base_url('admin/uploads/banners/');
        $feature_banners = $this->webservice_m->get_all_data_where('featured_banner',array('status'=>'Y'),'priority','desc');
        foreach($feature_banners as $fb)
        {
            $fb->banner = $path.$fb->banner;
        }
        $response[] = array('result'=>'success', 'feature_banners'=>$feature_banners);
        echo json_encode($response);
    }

    public function deals()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $d = date('Y-m-d');
        $products = array();
        $path2 = base_url('admin/uploads/products/');
        $deal_banner = $this->webservice_m->get_single_table("deal_banner",array("status"=>"Y"));
        if(!empty($deal_banner))
        {
            $deal_banner->banner = base_url('admin/uploads/banners/').$deal_banner->banner;
        }
        $deals = $this->db->query("SELECT * FROM `deals` WHERE (`start_date` <= '$d' AND `end_date`>='$d') AND `status`='Y'")->result();
        foreach($deals as $d)
        {
            $product = $this->get_product($d->productID);
            $brand = $this->get_brand($product->brand_id);
            $products[] = array(
                'productID' => $product->productID,
                'product_name' => $product->product_name,
                'product_image' => $path2.$product->product_image,
                'brand' => $brand->brand,
                'category_id' => $product->category_id,
                'retail_price' => $product->retail_price,
                'price' => $d->deal_price,
                'unit_value' => $product->unit_value,
                'unit' => $product->unit,
                'in_stock' => $product->in_stock,
                'featured' => $product->featured,
                'vegtype' => $product->vegtype
            );
            
        }
        $response[] = array('result'=>'success', 'products'=>$products, "deal_banner"=>$deal_banner);
        echo json_encode($response);

    }

    public function deals_all_product()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $d = date('Y-m-d');
        $products = array();
        $path2 = base_url('admin/uploads/products/');
        $deals = $this->db->query("SELECT * FROM `deals` WHERE (`start_date` <= '$d' AND `end_date`>='$d') AND `status`='Y'")->result();
        foreach($deals as $d)
        {
            $product = $this->get_product($d->productID);
            $brand = $this->get_brand($product->brand_id);
            $products[] = array(
                'productID' => $product->productID,
                'product_name' => $product->product_name,
                'product_image' => $path2.$product->product_image,
                'brand' => $brand->brand,
                'category_id' => $product->category_id,
                'retail_price' => $product->retail_price,
                'price' => $d->deal_price,
                'unit_value' => $product->unit_value,
                'unit' => $product->unit,
                'in_stock' => $product->in_stock,
                'featured' => $product->featured,
                'vegtype' => $product->vegtype
            );
            
        }
        $response[] = array('result'=>'success', 'products'=>$products);
        echo json_encode($response);

    }

    public function gift_banner()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $gift_banner = $this->webservice_m->get_single_table("gift_banner",array("status"=>"Y"));
        if(!empty($gift_banner))
        {
            $gift_banner->banner = base_url('admin/uploads/banners/').$gift_banner->banner;
        }
        $response[] = array('result'=>'success', 'gift_banner'=>$gift_banner);
        echo json_encode($response);
    }

    public function products()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $categoryID = $data['categoryID'];
        $products = $this->db->query("SELECT * FROM `products` WHERE FIND_IN_SET($categoryID,category_id) AND in_stock = 'Y'")->result();
        if(!empty($products))
        {
            foreach($products as $p)
            {
                $brand = $this->get_brand($p->brand_id);
                $p->product_image = base_url('admin/uploads/products/').$p->product_image;
                //$p->brand = $brand->brand;
                $p->brand = '';
                $p->cart_count = $this->product_cart_count($userID,$p->productID);
                $p->price = $this->check_deal($p->productID,$p->price);
            }
        }
        $response[] = array('result'=>'success', 'products'=>$products);
        echo json_encode($response);
    }

    private function check_deal($productID,$price)
    {
        $check = $this->webservice_m->get_single_table('deals',array('productID'=>$productID),$select='*');
        if(!empty($check) && strtotime($check->end_date) > time() && strtotime($check->start_date) < time())
        {
            $price = $check->deal_price;
        }
        return $price;
    }

    private function product_cart_count($userID,$productID)
    {
        $this->db->select('COALESCE(sum(qty),0) as count');
        $cart_item_count = $this->db->get_where('product_cart',array('userID'=>$userID,'productID'=>$productID))->row();
        return $cart_item_count->count;
    }

    public function coupons()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $d = date('Y-m-d');
        $offers = $this->webservice_m->get_all_table_query("SELECT * FROM `offers` WHERE `start_date` <='$d' AND `end_date` >='$d'");
        
        $response[] = array('result'=>'success', 'products'=>$offers);
        echo json_encode($response);
    }

    public function search_product()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $key = $data['key'];
        $products = $this->webservice_m->get_all_table_query("SELECT * FROM `products` WHERE `product_name` LIKE '%$key%'");
        if(!empty($products))
        {
            foreach($products as $p)
            {
                $brand = $this->get_brand($p->brand_id);
                $p->product_image = base_url('admin/uploads/products/').$p->product_image;
                //$p->brand = $brand->brand;
                $p->brand = '';
                $p->cart_count = $this->product_cart_count($userID,$p->productID);
                $p->price = $this->check_deal($p->productID,$p->price);
            }
        }
        $response[] = array('result'=>'success', 'products'=>$products);
        echo json_encode($response);
    }

    public function search()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $key = $data['key'];
        $products = $this->webservice_m->get_all_table_query("SELECT `productID`,`product_name` FROM `products` WHERE `product_name` LIKE '%$key%'");
        $response[] = array('result'=>'success', 'products'=>$products);
        echo json_encode($response);
    }

    public function product_detail()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $productID = $data['productID'];
        $product = $this->webservice_m->get_single_table("products",array("productID"=>$productID));
        if(!empty($product))
        {
            $brand = $this->get_brand($product->brand_id);
            $product->product_image = base_url('admin/uploads/products/').$product->product_image;
            $product->brand = "";
            if (!empty($brand)) {
                $product->brand = $brand->brand;
            }
            $product->cart_count = $this->product_cart_count($userID,$product->productID);
            $product->price = $this->check_deal($product->productID,$product->price);
        }
        $response[] = array('result'=>'success', 'product'=>$product);
        echo json_encode($response);
    }

    public function similar_products()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $productID = $data['productID'];
        $products = $this->webservice_m->get_all_data_where("products",array("productID !="=>$productID));
        if(!empty($products))
        {
            foreach($products as $product)
            {
                $brand = $this->get_brand($product->brand_id);
                $product->product_image = base_url('admin/uploads/products/').$product->product_image;
                //$product->brand = $brand->brand;
                $product->brand = '';
                $product->cart_count = $this->product_cart_count($userID,$product->productID);
                $product->price = $this->check_deal($product->productID,$product->price);
            }
        }
        $response[] = array('result'=>'success', 'products'=>$products);
        echo json_encode($response);

    }

    public function update_cart()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $productID = $data['productID'];
        $qty = $data['qty'];
        $check = $this->webservice_m->get_single_table("product_cart",array('userID'=>$userID, 'productID'=>$productID));
        $a = array('userID'=>$userID,'productID'=>$productID,'qty'=>$qty,'added_on'=>date('Y-m-d H:i:s'));
        if(!empty($check))
        {
            //update
            if($qty == '0')
            {
                $this->db->where(array('cartID'=>$check->cartID));
                $this->db->delete('product_cart');
            } else {
                $this->db->where(array('cartID'=>$check->cartID));
                $this->db->update('product_cart',$a);
            }

        } else {
            //insert
            $this->webservice_m->table_insert('product_cart',$a);
        }
        $this->db->select('sum(qty) as count');
        $cart_item_count = $this->db->get_where('product_cart',array('userID'=>$userID))->row();
        $response[] = array('result'=>'success','cart_count'=>$cart_item_count->count);
        echo json_encode($response);
    }

    public function list_user_cart()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $carts = $this->webservice_m->get_all_data_where('product_cart',array('userID'=>$userID));
        $products = array();
        if(!empty($carts))
        {
            foreach($carts as $c)
            {
                $product = $this->webservice_m->get_single_table("products",array("productID"=>$c->productID));
                if(!empty($product))
                {
                    $brand = $this->get_brand($product->brand_id);
                    $product->product_image = base_url('admin/uploads/products/').$product->product_image;
                    //$product->brand = $brand->brand;
                    $product->brand = '';
                    $product->qty = $c->qty;
                    $product->net_price = $c->qty * $product->price;
                    $product->price = $this->check_deal($product->productID,$product->price);
                }
                array_push($products, $product);
            }
            $response[] = array('result'=>'success','products'=>$products);
        } else {
            $response[] = array('result'=>'success');
        }
        echo json_encode($response);
    }

    public function delivery_charges()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $delivery_charges = 0;
        $min_order_amount = 0;
        $max_order_amount = 0;
        $free_delivery_amount = 0;
        $settings = $this->webservice_m->get_single_table('settings',array('ID'=>1),$select='*');
        $user = $this->db->get_where('users',array('ID'=>$userID))->row();
        $wallet_amount = $user->wallet;
        if (!empty($settings)){
            $delivery_charges = $settings->delivery_charge;
            $min_order_amount = $settings->min_order_amount;
            $max_order_amount = $settings->max_order_amount;
            $free_delivery_amount = $settings->free_delivery_amount;
        }
        $response[] = array('result'=>'success','delivery_charges'=>$delivery_charges,'min_order_amount'=>$min_order_amount,'max_order_amount'=>$max_order_amount,'free_delivery_amount'=>$free_delivery_amount,'wallet_amount'=>$wallet_amount,'gst'=>0);
        echo json_encode($response);
    }

    public function place_order()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $addressID = $data['addressID'];
        $coupon_code = $data['coupon_code'];
        $coupon_amt = str_replace(',','',$data['coupon_amt']);
        $order_amt = str_replace(',','',$data['order_amt']);
        $total_amount = str_replace(',','',$data['total_amount']);
        $payment_method = $data['payment_method']; //'cod' or 'online'
        $delivery_date = date('Y-m-d',strtotime($data['delivery_date']));
        $delivery_slot = $data['delivery_slot'];
        $instruction = $data['instruction'];
        $transactionID = $data['transactionID'];
        $delivery_charges = 0;
        $online_payment_amount = 0;
        $wallet_payment_amount = 0;
        $user = $this->db->get_where('users',array('ID'=>$userID))->row();
        $user_wallet = $user->wallet;
        if (!empty($data['delivery_charges'])){
            $delivery_charges = $data['delivery_charges'];
            $online_payment_amount = $data['online_amount'];
            $wallet_payment_amount = $data['wallet_amount'];
        }
        $items = json_decode($data['items']);
        $address = $this->webservice_m->get_single_table('user_address',array('addressID'=>$addressID));
        $array = array(
            'userID' => $userID,
            'customer_name' => $address->contact_person_name,
            'contact_no' => $address->contact_person_mobile,
            'house_no' => $address->flat_no,
            'apartment' => $address->building_name,
            'landmark' => $address->landmark,
            'location' => $address->location,
            'latitude' => $address->latitude,
            'longitude' => $address->longitude,
            'address_type' => $address->address_type,
            'coupon_code' => $coupon_code,
            'coupon_discount' => $coupon_amt,
            'order_amount' => $order_amt,
            'total_amount' => $total_amount,
            'payment_method' => $payment_method,
            'delivery_date' => $delivery_date,
            'delivery_slot' => $delivery_slot,
            'delivery_charges' => $delivery_charges,
            'instruction' => $instruction,
            'status' => 'PLACED',
            'added_on' => date('Y-m-d H:i:s'),
            'updated_on' => date('Y-m-d H:i:s')
        );
        if ($payment_method == 'online'){
            if ($online_payment_amount > 0)
            {
                $success = false;
                $error = '';
                try {
                    $ch = $this->get_curl_handle($transactionID, $online_payment_amount * 100);
                    //execute post
                    $result = curl_exec($ch);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($result === false) {
                        $success = false;
                        $error = 'Curl error: '.curl_error($ch);
                    } else {
                        $txn_description = $result;
                        $response_array = json_decode($result, true);
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                    }
                    //close connection
                    curl_close($ch);
                } catch (Exception $e) {
                    $success = false;
                    $response = array('result'=>'failure','msg'=>'Something Went Wrong. If your Payment is deducted it will be rolled back within 12 days. ');
                    $error = 'OPENCART_ERROR:Request to Razorpay Failed';
                }
            }else{
                $success = true;
            }

            if ($success === true) {
                if(!empty($this->session->userdata('ci_subscription_keys'))) {
                    $this->session->unset_userdata('ci_subscription_keys');
                }
                if ($online_payment_amount > 0){
                    $txn_array = array(
                        'userID'=>$userID,
                        'txn_no' => $transactionID,
                        'amount' => $online_payment_amount,
                        'type'=>'CREDIT',
                        'note'=>'',
                        'against_for' => 'order',
                        'paid_by'=>'online',
                        'orderID'=>0,
                        'transaction_at' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('transactions', $txn_array);
                    $user_wallet += $online_payment_amount;
                    $this->db->where(array('ID'=>$userID));
                    $this->db->update('users',array('wallet'=>$user_wallet));
                }
                $total_amount_order = $online_payment_amount + $wallet_payment_amount;
                $txn_array = array(
                    'userID'=>$userID,
                    'txn_no' => $transactionID,
                    'amount' => $total_amount_order,
                    'type'=>'DEBIT',
                    'note'=>'',
                    'against_for' => 'order',
                    'paid_by'=>'wallet',
                    'orderID'=>0,
                    'transaction_at' => date("Y-m-d H:i:s")
                );
                $this->db->insert('transactions', $txn_array);
                $txnID = $this->db->insert_id();
                $user_wallet -= $total_amount_order;
                $this->db->where(array('ID'=>$userID));
                $this->db->update('users',array('wallet'=>$user_wallet));
                $id = $this->webservice_m->table_insert('orders',$array);
                $this->db->delete('product_cart',array('userID'=>$userID));
                $this->db->where(array('transactionID'=>$txnID));
                $this->db->update('transactions',array('orderID'=>$id));
                if(!empty($items))
                {
                    foreach($items as $i)
                    {
                        $p = $this->db->get_where('products',array('productID'=>$i->productID))->row();
                        $p->price = $this->check_deal($p->productID,$p->price);
                        $b = array(
                            'orderID' => $id,
                            'productID' => $i->productID,
                            'qty' => $i->quantity,
                            'price' => $p->price,
                            'net_price' => $p->price * $i->quantity,
                            'status' => 'PLACED',
                            'added_on' => date('Y-m-d H:i:s'),
                            'updated_on' => date('Y-m-d H:i:s')
                        );
                        $itemID = $this->webservice_m->table_insert('order_items',$b);
                        $c = array(
                            'itemID'=>$itemID,
                            'orderID'=>$id,
                            'agentID'=>0,
                            'is_visible'=>'Y',
                            'status'=>'PLACED',
                            'added_on' => date('Y-m-d H:i:s')
                        );
                        $this->webservice_m->table_insert('order_status',$c);
                    }
                }
                if($id)
                {
                    $message = "Your order is successfully placed. Your can further track using order#".$id;
                    $this->send_sms($user->mobile,$message);
                }
                $response[] = array('result'=>'success','orderID'=>$id);
            }else{
                $response[] = array('result'=>'failure','orderID'=>0);
            }

        }else{

            $id = $this->webservice_m->table_insert('orders',$array);
            $this->db->delete('product_cart',array('userID'=>$userID));
            if(!empty($items))
            {
                foreach($items as $i)
                {
                    $p = $this->db->get_where('products',array('productID'=>$i->productID))->row();
                    $p->price = $this->check_deal($p->productID,$p->price);
                    $b = array(
                        'orderID' => $id,
                        'productID' => $i->productID,
                        'qty' => $i->quantity,
                        'price' => $p->price,
                        'net_price' => $p->price * $i->quantity,
                        'status' => 'PLACED',
                        'added_on' => date('Y-m-d H:i:s'),
                        'updated_on' => date('Y-m-d H:i:s')
                    );
                    $itemID = $this->webservice_m->table_insert('order_items',$b);
                    $c = array(
                        'itemID'=>$itemID,
                        'orderID'=>$id,
                        'agentID'=>0,
                        'is_visible'=>'Y',
                        'status'=>'PLACED',
                        'added_on' => date('Y-m-d H:i:s')
                    );
                    $this->webservice_m->table_insert('order_status',$c);
                }
            }
            if($id)
            {
                $message = "Your order is successfully placed. Your can further track using order#".$id;
                $this->send_sms($user->mobile,$message);
            }
            $response[] = array('result'=>'success','orderID'=>$id);
        }

        echo json_encode($response);

    }

    private function get_curl_handle($payment_id, $amount)  {

        $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $key_id = 'rzp_test_eMqq4gLU5x1gWa';
        $key_secret = 'z6sLP3TM0g0vGq5Ei1UvbGlZ';

        $fields_string = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/ca-bundle.crt');
        return $ch;

    }
    
    public function add_user_location()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $address_type = $data['address_type'];
        $location = $data['location'];
        $flat_no = $data['flat_no'];
        $building_name = $data['building_name'];
        $landmark = $data['landmark'];
        $contact_person_name = $data['contact_person_name'];
        $contact_person_mobile = $data['contact_person_mobile'];
        $note = $data['note'];
        $pincode = $data['pincode'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];

        $array = array(
            'userID' => $userID,
            'location' => $location,
            'flat_no' => $flat_no,
            'building_name' => $building_name,
            'landmark' => $landmark,
            'address_type' => $address_type,
            'pincode' => $pincode,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'contact_person_name' => $contact_person_name,
            'contact_person_mobile' => $contact_person_mobile,
            'note' => $note,
            'is_active' => 'Y',
            'is_default' => 'N',
            'added_on' => date('Y-m-d H:i:s')
        );

        $addressID = $this->webservice_m->table_insert('user_address',$array);
        
        $response[] = array('result'=>'success','addressID'=>$addressID);
        echo json_encode($response);
    }

    public function edit_user_location()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $addressID = $data['addressID'];
        $address_type = $data['address_type'];
        $location = $data['location'];
        $flat_no = $data['flat_no'];
        $building_name = $data['building_name'];
        $landmark = $data['landmark'];
        $pincode = $data['pincode'];
        $contact_person_name = $data['contact_person_name'];
        $contact_person_mobile = $data['contact_person_mobile'];
        $note = $data['note'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];

        $array = array(
            'location' => $location,
            'flat_no' => $flat_no,
            'building_name' => $building_name,
            'landmark' => $landmark,
            'address_type' => $address_type,
            'pincode' => $pincode,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'contact_person_name' => $contact_person_name,
            'contact_person_mobile' => $contact_person_mobile,
            'note' => $note
            
        );

        $address = $this->webservice_m->table_update('user_address',$array,array('addressID'=>$addressID));
        
        $response[] = array('result'=>'success','addressID'=>$addressID);
        echo json_encode($response);
    }

    public function delete_address()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $addressID = $data['addressID'];
        $this->db->where(array('addressID'=>$addressID));
        $this->db->delete('user_address');
        $response[] = array('result'=>'success','message'=>'Successfully Delete');
        echo json_encode($response);
    }

    public function list_location()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $address = $this->webservice_m->get_all_data_where('user_address',array('userID'=>$userID,'is_active'=>'Y'));
        $response[] = array('result'=>'success','address'=>$address);
        echo json_encode($response);

    }

    public function apply_coupon()
    {
        $path = base_url().'uploads/';
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $offer_code = $data['offer_code'];
        $get_coupon = $this->webservice_m->get_single_table('offers',array('offer_code'=> $offer_code));
        if($get_coupon->allowed_user_times == 0)
        {
            $response[] = array('result'=>'success');
        } else {
            $check = $this->db->get_where('orders',array('userID'=>$userID,'discount_code'=> $offer_code))->result();
            if(sizeof($check) < $get_coupon->allowed_user_times)
            {
                $response[] = array('result'=>'success');
            } else {
                $response[] = array('result'=>'failure');
            }
        }
        
        echo json_encode($response);
    }
    
    public function slot()
    {
        $data = json_decode(file_get_contents('php://input'), true);
       // $booking_date = date('Y-m-d',strtotime($data['booking_date']));


        //$delivery_type = $data['delivery_type'];
        $date = date("Y-m-d",strtotime($data['booking_date']));
                    
        $time = date("H:i:s");
                            
        $this->load->model("time_model");

        $time_slot = $this->time_model->get_time_slot();

        $cloasing_hours =  $this->time_model->get_closing_hours($date);
                    
        $begin = new DateTime($time_slot->opening_time);

        $end   = new DateTime($time_slot->closing_time);
        
        $interval = DateInterval::createFromDateString($time_slot->time_slot.' min');
        
        $times    = new DatePeriod($begin, $interval, $end);
        
        $time_array = array();

        foreach ($times as $time) {
            if(!empty($cloasing_hours)){
                foreach($cloasing_hours as $c_hr){
                    if($date == date("Y-m-d")){
                        if(strtotime($time->format('h:i A')) > strtotime(date("h:i A")) &&  strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){
                            
                        }else{
                            $t1 = $time->format('h:i A'). ' - '. 
                            $time->add($interval)->format('h:i A')
                             ;
                            $time_array[] =  $time->format('h:i A'). ' - '. 
                            $time->add($interval)->format('h:i A')
                             ;
                        }
                    
                    }else{
                        if(strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){
                            
                        }else{
                            $t1 =$time->format('h:i A'). ' - '. 
                            $time->add($interval)->format('h:i A')
                             ;
                            $time_array[] =  $time->format('h:i A'). ' - '. 
                            $time->add($interval)->format('h:i A')
                             ;
                        }
                    }   
                    $slot[] = array(
                        'period' => $t1,
                        'available' => '1' ,
                        "delivery_price" => '30'             
                    );             
                }
            }else{
                if(strtotime($date) == strtotime(date("Y-m-d"))){
                    if(strtotime($time->format('h:i A')) > strtotime(date("h:i A"))){
                        $t1 =  $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');
                        $time_array[] =  $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');
                        $slot[] = array(
                            'period' => $t1,
                            'available' => '1',
                            "delivery_price" => '30'           
                        );  
                    } 
                }else{
                   $t1 = $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');
                   $time_array[] =  $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');
                   $slot[] = array(
                    'period' => $t1,
                    'available' => '1',
                    "delivery_price" => '30'              
                );  
                }
                

            }


        }
        $response[] = array('result'=>'success', 'slot'=>$slot);
        echo json_encode($response);
    }

    public function add_wallet()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $amount = $data['amount'];
        $txn_no = $data['transactionID'];
        $response = array();
        $success = false;
        $error = '';
        try {
            $ta = $amount * 100;
            $ch = $this->get_curl_handle($txn_no, $ta);
            //execute post
            $result = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($result === false) {
                $success = false;
                $error = 'Curl error: '.curl_error($ch);
            } else {
                $txn_description = $result;
                $response_array = json_decode($result, true);
                if ($http_status === 200 and isset($response_array['error']) === false) {
                    $success = true;
                } else {
                    $success = false;
                    if (!empty($response_array['error']['code'])) {
                        $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                    } else {
                        $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                    }
                }
            }
            //close connection
            curl_close($ch);
        } catch (Exception $e) {
            $success = false;
            $response[] = array('result'=>'failure','msg'=>'Something Went Wrong. If your Payment is deducted it will be rolled back within 12 days. ');
            $error = 'OPENCART_ERROR:Request to Razorpay Failed';
        }

        if($success == true)
        {
            $array = array(
                'userID' => $userID,
                'txn_no' => $txn_no,
                'amount' => $amount,
                'type' => 'CREDIT',
                'note' => '',
                'against_for' => 'wallet',
                'paid_by' => 'online',
                'orderID' => 0,
                'transaction_at' => date('Y-m-d H:i:s')
            );
            $id = $this->webservice_m->table_insert('transactions',$array);
            $user = $this->webservice_m->get_user(array('ID'=>$userID));
            $wallet = $amount + $user->wallet;

            $this->webservice_m->table_update('users',array('wallet'=>$wallet),array('ID'=>$userID));
            $response[] = array('result'=>'success','message'=>'successfully amount added to wallet','wallet'=>$wallet, 'error'=>$error);
        } else {
            $response[] = array('result'=>'failure','msg'=>'Something Went Wrong. If your Payment is deducted it will be rolled back within 12 days. ', 'error'=>$error);
        }
        echo json_encode($response); 
    }

    public function wallet_history()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $user = $this->webservice_m->get_user(array('ID'=>$userID));
        $history = $this->webservice_m->get_all_data_where('transactions',array('userID'=>$userID),'transactionID','DESC');
        $response[] = array('result'=>'success','message'=>'successfully amount added to wallet','wallet'=>$user->wallet,'history'=>$history);
        echo json_encode($response); 
    }

    public function my_orders()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $ordered_products = array();
        $orders = $this->webservice_m->get_all_table_query("SELECT `orderID`, `location`, DATE_FORMAT(DATE(`delivery_date`),'%d-%M-%Y') as delivery_date, `delivery_slot`, `status`, DATE_FORMAT(`added_on`,'%d-%M-%Y') as order_at, `total_amount` FROM `orders` WHERE `userID`='$userID' order by `orderID` DESC");
        foreach($orders as $o)
        {
            $order_products = $this->get_ordered_products($o->orderID,$o->total_amount,$o->status,$o->order_at);
            foreach ($order_products as $product){
                $ordered_products[] = $product;
            }
        }

        $response[] = array("result"=>"success","ordered_products"=>$ordered_products);
        echo json_encode($response);
    }

    public function get_ordered_products($orderID,$total_amount,$status,$date)
    {
        $query = $this->webservice_m->get_all_table_query("SELECT `itemID`, `productID`, `qty`, `price`, `net_price` FROM `order_items` WHERE `orderID`='$orderID'");
        if(!empty($query))
        {
            foreach($query as $q)
            {
                $p_detail = $this->get_product_name($q->productID);
                $q->unit = $p_detail['unit'];
                $q->product_name = $p_detail['name'];
                $q->product_image = base_url('admin/uploads/products/').$p_detail['image'];
                $q->total_order_amount = $total_amount;
                $q->status = $status;
                $q->orderID = $orderID;
                $product_status = $this->get_order_status($q->itemID);
                if (!empty($product_status)) {
                    $q->status = $product_status->status;
                }
                $q->order_date = $date;
            }
        }
        return $query;
    }

    public function get_product_name($productID)
    {
        $query = $this->webservice_m->get_single_table('products',array('productID'=>$productID));
        $name =  (!empty($query->product_name))?$query->product_name:'';
        $image = (!empty($query->product_image))?$query->product_image:'product.png';
        $unit = (!empty($query->unit))?$query->unit:'piece';
        return array('name'=>$name,'image'=>$image,'unit'=>$unit);
    }

    public function get_order_status($itemID)
    {
        $status = $this->db->query("SELECT * FROM order_status WHERE itemID = '$itemID' ORDER BY statusID DESC LIMIT 1")->row();
        return $status;
    }

    public function change_user_image()
    {
        if ($_POST)
        {
            $userID = $this->input->post('userID');
            $path = base_url('uploads/');
            if (!empty($_FILES['image']['name'])){
                $target_path = "uploads/";
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = 'user_image'.time().".".$extension;
                move_uploaded_file($_FILES["image"]["tmp_name"],$target_path.$actual_image_name);
                $this->db->where(array('ID'=>$userID));
                $this->db->update('users',array('image'=>$actual_image_name,'updated_on'=>date("Y-m-d H:i:s")));
                $result[] = array("result"=>"success","message"=>"Successfully Updated","image"=>$path.$actual_image_name);
            }else{
                $result[] = array("result"=>"failure","message"=>"Please Upload a Valid Image","image"=>'');
            }
        }else{
            $result[] = array("result"=>"failure","message"=>"Action Not Allowed","image"=>'');
        }
        echo json_encode($result);

    }

    public function my_profile()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $path = base_url('uploads/');
        $user_info = $this->db->get_where('users',array('ID'=>$userID))->row();
        if (!empty($user_info)){
            $user_info->image = $path.$user_info->image;
            $result[] = array("result"=>"success","message"=>"Successfully Retrieved","profile"=>$user_info,'refer_text'=>'Hey user, Please use my referral code to register to Grocery. My Code is '.$user_info->referral_code.'.Download latest Grocery App from play store');
        }else{
            $result[] = array("result"=>"failure","message"=>"User Not Found","profile"=>null,'refer_text'=>'');
        }
        echo json_encode($result);
    }

    public function update_user_profile()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $name = $data['name'];
        $email = $data['email'];
        $path = base_url('uploads/');
        $update_array = array(
            "name"=>$name,
            "email"=>$email,
            "updated_on"=>date("Y-m-d H:i:s")
        );
        $this->db->where(array('ID'=>$userID));
        $this->db->update('users',$update_array);
        $user_info = $this->db->get_where('users',array('ID'=>$userID))->row();
        if (!empty($user_info)){
            $user_info->image = $path.$user_info->image;
            $result[] = array("result"=>"success","message"=>"Successfully Updated","profile"=>$user_info);
        }else{
            $result[] = array("result"=>"failure","message"=>"User Not Found","profile"=>null);
        }
        echo json_encode($result);
    }

    public function update_mobile()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $mobile = $data['mobile'];
        $check = $this->db->get_where('users',array('mobile'=>$mobile))->row();
        if (empty($check)){
            $update_array = array(
                "mobile"=>$mobile,
                "updated_on"=>date("Y-m-d H:i:s")
            );
            $this->db->where(array('ID'=>$userID));
            $this->db->update('users',$update_array);
            $result[] = array("result"=>"success","message"=>"Successfully Updated");
        }elseif($check->ID == $userID){
            $result[] = array("result"=>"success","message"=>"Same Number");
        }else{
            $result[] = array("result"=>"failure","message"=>"This Mobile Number is Already Registered with Use.");
        }
        echo json_encode($result);
    }

    public function cms_pages()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $type = $data['type']; //type = 'about_us','privacy_policy','terms_condition'
        $type_array = array('about_us','privacy_policy','terms_condition');
        $page = "";
        if (in_array($type,$type_array)){
            $this->db->select($type);
            $content = $this->db->get_where('settings',array('ID'=>1))->row();
            $page = $content->$type;
        }
        $result[] = array("result"=>"success","message"=>"","data"=>$page);
        echo json_encode($result);
    }
    public function about_us()
    {
        $this->db->select('about_us');
        $data = $this->db->get_where('settings',array('ID'=>1))->row();
        $result[] = array("result"=>"success","message"=>"","data"=>$data->about_us);
        echo json_encode($result);
    }

    public function privacy_policy()
    {
        $this->db->select('privacy_policy');
        $data = $this->db->get_where('settings',array('ID'=>1))->row();
        $result[] = array("result"=>"success","message"=>"","data"=>$data->privacy_policy);
        echo json_encode($result);
    }

    public function terms_condition()
    {
        $this->db->select('terms_condition');
        $data = $this->db->get_where('settings',array('ID'=>1))->row();
        $result[] = array("result"=>"success","message"=>"","data"=>$data->terms_condition);
        echo json_encode($result);
    }

    public function contact_us()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $array = array(
            'name'=>$data['name'],
            'email'=>$data['email'],
            'mobile'=>$data['mobile'],
            'message'=>$data['message'],
            'status'=>'NEW',
            'added_on'=>date("Y-m-d H:i:s"),
            'updated_on'=>date("Y-m-d H:i:s")
        );
        $this->db->insert('enquiry',$array);
        $result[] = array("result"=>"success","message"=>"Successfully Submitted.");
        echo json_encode($result);
    }

    public function cancel_order_item()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $itemID = $data['itemID'];
        $this->db->select('order_items.*,orders.userID');
        $this->db->join('orders','order_items.orderID = orders.orderID','LEFT');
        $check = $this->db->get_where('order_items',array('order_items.itemID'=>$itemID,'orders.userID'=>$userID))->row();
        if (!empty($check))
        {
            if ($check->status == 'PLACED' || $check->status == 'CONFIRM')
            {
                $this->db->where(array('itemID'=>$check->itemID));
                $this->db->update('order_items',array('status'=>'CANCEL'));
                $this->db->insert('order_status',array(
                    'itemID'=>$check->itemID,
                    'orderID'=>$check->orderID,
                    'agentID'=>0,
                    'is_visible'=>'Y',
                    'status'=>'CANCEL',
                    'added_on'=>date("Y-m-d H:i:s")
                ));
                $response[] = array('result'=>'success','msg'=>'Successfully Cancelled');
            }else{
                $response[] = array('result'=>'failure','msg'=>'You Cannot cancel this order.');
            }
        }else{
            $response[] = array('result'=>'failure','msg'=>'You Cannot cancel this order.');
        }
        echo json_encode($response);
    }

    private function hash($string) {
        return hash("sha512", $string . config_item("encryption_key"));
    }

    public function agent_login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];
        $password = $this->hash($data['password']);
        $deviceID = $data['deviceID'];
        $device_token = $data['device_token'];
        $device_type = $data['device_type'];
        $check = $this->db->get_where('delivery_agent',array('email'=>$email,'password'=>$password,'is_active'=>'Y'))->row();
        if(!empty($check))
        {
            $result[] = array('result'=>'success','agent'=>$check);
        }else{
            $result[] = array('result'=>'failure','agent'=>NULL);
        }
        echo json_encode($result);
    }

    public function get_pending_order_list()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $agentID = $data['agentID'];
        $status = array(
            'PLACED',
            'CONFIRM',
            'OUT_FOR_DELIVERY'
        );
        $this->db->where_in($status);
        //$orders = $this->db->get_where('orders',array('agentID'=>$agentID))->result();
        $orders = $this->db->query("SELECT * FROM `orders` WHERE `agentID`='$agentID' AND (`status`='PLACED' OR `status`='CONFIRM' OR `status`='OUT_FOR_DELIVERY')")->result();
        $result[] = array('result'=>'success','orders'=>$orders, "query"=>$this->db->last_query());
        echo json_encode($result);
    }

    public function get_completed_order_list()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $agentID = $data['agentID'];
        $status = array(
            'DELIVERED'
        );
        $this->db->where_in($status);
        $orders = $this->db->get_where('orders',array('agentID'=>$agentID))->result();
        $result[] = array('result'=>'success','orders'=>$orders);
        echo json_encode($result);
    }

    public function get_order_details()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $image_path = base_url('uploads/products/');
        $agentID = $data['agentID'];
        $orderID = $data['orderID'];
        $order = $this->db->get_where('orders',array('agentID'=>$agentID,'orderID'=>$orderID))->row();
        $this->db->select("order_items.*,products.product_name,products.product_image");
        $this->db->join('products','order_items.productID = products.productID','LEFT');
        $items = $this->db->get_where('order_items',array('order_items.orderID'=>$orderID))->result();
        foreach ($items as $i)
        {
            $i->product_image = $image_path.$i->product_image;
        }
        $result[] = array('result'=>'success','orders'=>$order,'items'=>$items);
        echo json_encode($result);
    }

    public function deliver_order()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $agentID = $data['agentID'];
        $orderID = $data['orderID'];
        $items = $this->db->get_where('order_items',array('orderID'=>$orderID))->result();
        foreach ($items as $item)
        {
            if ($item->status != 'DELIVERED' || $item->status != 'CANCEL')
            {
                $status_insert = array(
                    'itemID'=>$item->itemID,
                    'orderID'=>$orderID,
                    'agentID'=>$agentID,
                    'is_visible'=>'Y',
                    'status'=>'DELIVERED',
                    'added_on'=>date("Y-m-d H:i:s")
                );
                $this->db->insert('order_status',$status_insert);
                $this->db->where(array('itemID'=>$item->itemID));
                $this->db->update('order_items',array('status'=>'DELIVERED','updated_on'=>date("Y-m-d H:i:s")));
            }
            $this->db->where(array('orderID'=>$orderID));
            $this->db->update('orders',array('status'=>'DELIVERED','updated_on'=>date("Y-m-d H:i:s")));
        }
        $result[] = array('result'=>'success','message'=>'successfully updated');
        echo json_encode($result);
    }

    public function agent_logout()
    {

    }
}