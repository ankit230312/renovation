<?php

class Orders extends CI_Controller

{

    function __construct()

    {

        parent::__construct();

        $this->_check_auth();

        $this->load->model("home_m");

     

    }



    private function _check_auth()

    {

        if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'vendor' && $this->session->userdata('role') != 'subadmin' && $this->session->userdata('role') != 'order_manager') {

            $this->session->sess_destroy();

            redirect(base_url("login"));

        }

    }



    public function index()

    {

        $this->new_orders();

    }

     

    public function new_orders($param1 = '', $param2 = '', $param3 = '')

    {

        $cityID = $this->session->userdata('cityID');

        $adminID = $this->session->userdata('adminID');



        if ($param1 == 'profile' && $param2 != '' && $param3 != '' && $param3 = md5($param2)) {

            $userID = $param2;

        } else {

            $select = 'orders.*,users.name as user_name';

            $join = array();

            $join[] = array(

                'table' => 'users',

                'parameter' => 'orders.userID = users.ID',

                'position' => 'LEFT'

            );

            if($this->session->userdata('role') == 'vendor'){

            $this->data['new_orders'] = $this->db->query("SELECT * FROM `orders` WHERE  `status` IN ('ALLOCATED','CONFIRM','PACKED') AND cityID = '$cityID' AND vendorID = '$adminID'")->result();

                // echo $this->db->last_query();die();

            }elseif($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'order_manager'){

                $this->data['new_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `status` IN ('PLACED')")->result();

                

            }

            $this->data['delivery_agent'] = $this->home_m->get_all_row_where('delivery_agent',array(),$select='*');

            $this->data['sub_view'] = 'orders/new_orders';

            $this->data['title'] = 'New Orders';

            $this->load->view("_layout", $this->data);

        }

    }
    public function monthly_orders($param1 = '', $param2 = '', $param3 = '')

    {

        $cityID = $this->session->userdata('cityID');

        $adminID = $this->session->userdata('adminID');



        if ($param1 == 'profile' && $param2 != '' && $param3 != '' && $param3 = md5($param2)) {

            $userID = $param2;

        } else {

            $select = 'orders.*,users.name as user_name';

            $join = array();

            $join[] = array(

                'table' => 'users',

                'parameter' => 'orders.userID = users.ID',

                'position' => 'LEFT'

            );
        $month = date('m');
        $year = date('Y');
       
           if($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'order_manager'|| $this->session->userdata('role') == 'vendor'){

                $this->data['monthly_orders'] = $this->db->query("SELECT * FROM `orders` WHERE MONTH(`added_on`)='$month' AND  YEAR(`added_on`)='$year' ")->result();

                

            }

            $this->data['delivery_agent'] = $this->home_m->get_all_row_where('delivery_agent',array(),$select='*');

            $this->data['sub_view'] = 'orders/monthly_orders';

            $this->data['title'] = ',Monthly Orders';

            $this->load->view("_layout", $this->data);

        }

    }
     public function today_orders($param1 = '', $param2 = '', $param3 = '')

    {

        $cityID = $this->session->userdata('cityID');

        $adminID = $this->session->userdata('adminID');



        if ($param1 == 'profile' && $param2 != '' && $param3 != '' && $param3 = md5($param2)) {

            $userID = $param2;

        } else {

            $select = 'orders.*,users.name as user_name';

            $join = array();

            $join[] = array(

                'table' => 'users',

                'parameter' => 'orders.userID = users.ID',

                'position' => 'LEFT'

            );
            $d = date('Y-m-d');
        $month = date('m');
        $year = date('Y');
       
           if($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'order_manager'|| $this->session->userdata('role') == 'vendor'){

                $this->data['today_orders'] = $this->db->query("SELECT * FROM `orders` WHERE DATE(`added_on`)='$d'")->result();
            }

            $this->data['delivery_agent'] = $this->home_m->get_all_row_where('delivery_agent',array(),$select='*');

            $this->data['sub_view'] = 'orders/today_orders';

            $this->data['title'] = 'Today Orders';

            $this->load->view("_layout", $this->data);

        }

    }
 public function total_orders($param1 = '', $param2 = '', $param3 = '')

    {

        $cityID = $this->session->userdata('cityID');

        $adminID = $this->session->userdata('adminID');



        if ($param1 == 'profile' && $param2 != '' && $param3 != '' && $param3 = md5($param2)) {

            $userID = $param2;

        } else {

            $select = 'orders.*,users.name as user_name';

            $join = array();

            $join[] = array(

                'table' => 'users',

                'parameter' => 'orders.userID = users.ID',

                'position' => 'LEFT'

            );
        $month = date('m');
        $year = date('Y');
       
           if($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'order_manager'|| $this->session->userdata('role') == 'vendor'){

                $this->data['total_orders'] = $this->db->query("SELECT * FROM `orders`  ")->result();

                

            }

            $this->data['delivery_agent'] = $this->home_m->get_all_row_where('delivery_agent',array(),$select='*');

            $this->data['sub_view'] = 'orders/total_orders';

            $this->data['title'] = 'Total Orders';

            $this->load->view("_layout", $this->data);

        }

    }
public function pending_orders($param1 = '', $param2 = '', $param3 = '')

    {

        $cityID = $this->session->userdata('cityID');

        $adminID = $this->session->userdata('adminID');



        if ($param1 == 'profile' && $param2 != '' && $param3 != '' && $param3 = md5($param2)) {

            $userID = $param2;

        } else {

            $select = 'orders.*,users.name as user_name';

            $join = array();

            $join[] = array(

                'table' => 'users',

                'parameter' => 'orders.userID = users.ID',

                'position' => 'LEFT'

            );

            if($this->session->userdata('role') == 'vendor'){

            $this->data['pending_orders'] = $this->db->query("SELECT * FROM `orders` WHERE  `status` IN ('PLACED','ALLOCATED','CONFIRM','PACKED','OUT_FOR_DELIVERY') AND cityID = '$cityID' AND vendorID = '$adminID'")->result();

                // echo $this->db->last_query();die();

            }elseif($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'order_manager'){

                $this->data['pending_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `status` IN ('PLACED','ALLOCATED','CONFIRM','PACKED','OUT_FOR_DELIVERY')")->result();

                 $d = date('Y-m-d');
                $this->data['new_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `status` IN ('PLACED') AND DATE(`added_on`)='$d'")->result();

                  $this->data['allocated_orders'] = $this->db->query("SELECT * FROM `orders` WHERE `status` IN ('ALLOCATED')")->result();

            }

            $this->data['delivery_agent'] = $this->home_m->get_all_row_where('delivery_agent',array(),$select='*');

            $this->data['sub_view'] = 'orders/pending_orders';

            $this->data['title'] = 'Pending Orders';

            $this->load->view("_layout", $this->data);

        }

    }

    public function ongoing_orders($param1 = '', $param2 = '', $param3 = '')

    {

    	$cityID = $this->session->userdata('cityID');

     	$adminID = $this->session->userdata('adminID');

        if ($param1 == 'profile' && $param2 != '' && $param3 != '' && $param3 = md5($param2)) {

            $userID = $param2;



        } else {

            $select = 'orders.*,users.name as user_name';

            $join = array();

            $join[] = array(

                'table' => 'users',

                'parameter' => 'orders.userID = users.ID',

                'position' => 'LEFT'

            );

            if($this->session->userdata('role') == 'vendor'){

            	$this->data['new_orders'] = $this->home_m->get_all_row_where_join('orders', array('orders.status' => 'OUT_FOR_DELIVERY','orders.cityID'=>$cityID,'orders.vendorID'=>$adminID), $join, $select);

            }elseif($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'order_manager' || $this->session->userdata('role') == 'subadmin'){

            	$this->data['new_orders'] = $this->home_m->get_all_row_where_join('orders', array('orders.status' => 'OUT_FOR_DELIVERY'), $join, $select);

            }

            $this->data['sub_view'] = 'orders/ongoing_orders';

            $this->data['title'] = 'Ongoing Orders';

            $this->load->view("_layout", $this->data);

        }

    }



    public function completed_orders($param1 = '', $param2 = '', $param3 = '')

    {

    	$cityID = $this->session->userdata('cityID');

     	$adminID = $this->session->userdata('adminID');

        if ($param1 == 'profile' && $param2 != '' && $param3 != '' && $param3 = md5($param2)) {

            $userID = $param2;



        } else {

            $select = 'orders.*,users.name as user_name';

            $join = array();

            $join[] = array(

                'table' => 'users',

                'parameter' => 'orders.userID = users.ID',

                'position' => 'LEFT'

            );

            if($this->session->userdata('role') == 'vendor'){

            	$this->data['new_orders'] = $this->home_m->get_all_row_where_join('orders', array('orders.status' => 'DELIVERED','orders.cityID'=>$cityID,'orders.vendorID'=>$adminID), $join, $select);

            }elseif($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'order_manager' || $this->session->userdata('role') == 'subadmin'){

            	$this->data['new_orders'] = $this->home_m->get_all_row_where_join('orders', array('orders.status' => 'DELIVERED'), $join, $select);

            }

            $this->data['sub_view'] = 'orders/completed_orders';

            $this->data['title'] = 'Completed Orders';

            $this->load->view("_layout", $this->data);

        }

    }



    public function cancelled_orders($param1 = '', $param2 = '', $param3 = '')

    {

    	$cityID = $this->session->userdata('cityID');

     	$adminID = $this->session->userdata('adminID');

        if ($param1 == 'profile' && $param2 != '' && $param3 != '' && $param3 = md5($param2)) {

            $userID = $param2;



        } else {

            $select = 'orders.*,users.name as user_name';

            $join = array();

            $join[] = array(

                'table' => 'users',

                'parameter' => 'orders.userID = users.ID',

                'position' => 'LEFT'

            );

            if($this->session->userdata('role') == 'vendor'){

            	$this->data['new_orders'] = $this->home_m->get_all_row_where_join('orders', array('orders.status' => 'CANCEL', 'orders.cityID' => $cityID,'orders.vendorID' => $adminID ), $join, $select);

            }elseif($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'order_manager' || $this->session->userdata('role') == 'subadmin'){

            	$this->data['new_orders'] = $this->home_m->get_all_row_where_join('orders', array('orders.status' => 'CANCEL'), $join, $select);

            }

            

            $this->data['sub_view'] = 'orders/cancelled_orders';

            $this->data['title'] = 'Cancelled Orders';

            $this->load->view("_layout", $this->data);

        }

    }



    public function update_status()

    {

        if ($_POST) {

            /*var_dump($_POST);*/

            $status = $this->input->post('status');



            $id = $this->input->post('id');

            $delivery_agentID = $this->input->post('delivery_agent');

            $items = $this->db->get_where('order_items',array("orderID"=>$id))->result();

            $agent = $this->home_m->get_single_row_where('delivery_agent', array('delivery_agentID' => $delivery_agentID));

            $order = $this->home_m->get_single_row_where('orders', array('orderID' => $id));



            $user_token = $this->home_m->get_all_row_where('user_login',array('userID'=>$order->userID),'device_token');

            $userID = $order->userID;

            $user = $this->home_m->get_single_row_where('users', array('ID' => $userID));



            if ($status == 'ALLOCATED') {

                $status = 'OUT_FOR_DELIVERY';

                $a['agentID'] = $delivery_agentID;

                /*$title = 'Delivery Agent Allocated';

                $body = $agent->name . ' will deliver your order soon.';



                foreach ($user_token as $u) {

                    $this->send_notification($title, $body, $u->deviceToken);

                }

                $this->store_notification($userID, $title, $body);

                $title1 = 'Order Allocated';

                $body1 = 'A New Order is allocate to Order #' . $id;

                $this->send_notification($title1, $body1, $agent->deviceToken);*/

            }



            if ($status == 'CONFIRM') {





                $title = 'Order Confirmed';

                $body = 'Your Order is confirmed and We will allocate delivery agent to deliver your order.';

                /*foreach ($user_token as $u) {

                    $this->send_notification($title, $body, $u->deviceToken);

                }*/

                $this->store_notification($userID, $title, $body);

            }

            //order delivered
            if ($status == 'DELIVERED') {
                $message = "Hi $user->name ,\nAs promised your order # $id has been delivered .\n For More info visit our APP\nCheers,\nTeam GowiseKart";
             $this->send_sms($user->mobile,$message);
             
             //referal amount update
            $totalOrder = $this->db->query("select * from orders where userID='$user->ID'")->result();
            if(!empty($totalOrder)){
                if(count($totalOrder) == 1){
                    if(!empty($user->referral_userID)){
                      $settings = $this->db->get_where('settings',array('id'=>1))->row();

                      $refer_amount = isset($settings->refer_earn) ? $settings->refer_earn :0;

                        //amount update referal user
                      $referalUser =  $this->db->query("select * from users where ID='$user->referral_userID'")->row();
                     


                      $txn_array = array(
                        'userID'=>$referalUser->ID,
                        'txn_no' => 'RFR'.time().rand(99,999),
                        'amount' => $refer_amount,
                        'type'=>'CREDIT',
                        'note'=>'',
                        'against_for' => 'referal_bonus',
                        'paid_by'=>$order->payment_method,
                        'orderID'=>$id,
                        'transaction_at' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('transactions', $txn_array);




                    $txn_array1 = array(
                        'user_id'=>$referalUser->ID,
                        'previous_wallet' => $referalUser->wallet,
                        'added_amount' => $refer_amount,
                        'created_at' => date("Y-m-d H:i:s"),
                        'expired_on' => date('Y-m-d H:i:s', strtotime($today. ' + 2 days')) ,

                    );






                    $this->db->insert('refer_earn_new', $txn_array1);

                     $this->db->where(array('ID'=>$referalUser->ID));
                     $this->db->update('users',array('wallet'=>$referalUser->wallet+$refer_amount));


                    $message = 'Gowisekart is delivering handpicked farm fresh fruits, vegetables, grocery & household items.Instant Cash Amount Rs'.$refer_amount.' will be added in your Gowisekart Wallet due to Successful Referal and that will expire in 2 days.';

                    $notification_insert = array(

                    "title"=>'Refer & Earn',

                    "image"=>'',

                    "text"=>$message,

                    "userID"=>$referalUser->ID,

                    "status"=>'sent',

                    "added_on"=>date("Y-m-d H:i:s"),

                    "updated_on"=>date("Y-m-d H:i:s"),

                );

                $this->db->insert('notifications',$notification_insert);



                $user_login = $this->db->get_where('user_login',array('userID'=>$referalUser->ID))->result();

                foreach ($user_login as $login)

                {

                    if (strtolower($login->device_type) == 'android'){

                        $this->send_notification('Refer & Earn', $message , $login->device_token,'');

                    }

                }







                      //amount update main user
                      /*$this->db->where(array('ID'=>$user->ID));
                      $this->db->update('users',array('wallet'=>$user->wallet+10));

                      $txn_array = array(
                        'userID'=>$user->ID,
                        'txn_no' => 'RFR'.time().rand(99,999),
                        'amount' => 10,
                        'type'=>'CREDIT',
                        'note'=>'',
                        'against_for' => 'order',
                        'paid_by'=>$order->payment_method,
                        'orderID'=>$id,
                        'transaction_at' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('transactions', $txn_array);*/

                    
                    }
                }
            }

            //get coupon
            $cashbackAmount ='0.00'; 
           $couponDetail =  $this->db->query("select * from offers where offer_code='$order->coupon_code'")->row();
           if(!empty($couponDetail)){
            if($couponDetail->offer_type=='CASHBACK'){
               $cashbackAmount = $couponDetail->offer_value;
            }
             if($couponDetail->offer_type=='CASHBACK_PERCENTAGE'){
            	 $cashbackAmount = $order->coupon_discount;

            }
            //update user wallet
            $this->db->where(array('ID'=>$user->ID));
            $this->db->update('users',array('cashback_wallet'=>$user->cashback_wallet+$cashbackAmount,'updated_on'=>date("Y-m-d H:i:s")));
             $message =  "Congratulations ! You just received a cashback of Rs.".$cashbackAmount." in your cashback wallet. Happy Shopping. Team Gowisekart.";
              $this->send_sms($user->mobile,$message);


           }

           // //update user wallet
           //  $this->db->where(array('ID'=>$user->ID));
           //  $this->db->update('users',array('cashback_wallet'=>$user->cashback_wallet+$cashbackAmount));
           
           

        }



            if ($status == 'CANCEL') {

                foreach ($items as $i){

                    $productID = $i->productID;

                    $products_detail = $this->home_m->get_single_row_where('products_detail', array('city_id' => $order->cityID, 'product_id' => $productID));

                    $stock_count =  $products_detail->stock_count - $i->qty;

                    $this->db->where(array('product_id'=>$productID));

                    $this->db->where(array('city_id'=>$order->cityID));

                    $this->db->update('products_detail',array('stock_count'=>$stock_count));

                }



                $msg = 'Dear '.$user->name.'/nDue to recent advisories, safety measures and restrictions announced by Government, your order#'.$id.' has been Cancelled. Your Inconvenience is regretted. Thank You for your coorperation.';

                /*foreach ($user_token as $u) {

                    $this->send_notification($title, $body, $u->deviceToken);

                }*/

                $this->send_sms($user->mobile,$msg);

            }

            if($status == 'ALLOCATED_VENDOR'){

                $status = 'ALLOCATED';

                $a['vendorID'] = $delivery_agentID;

            }

            $a['status'] = $status;

            foreach ($items as $i)

            {

                if($i->status != 'CANCEL')

                {

                    $this->home_m->update_data('order_items',array('itemID'=>$i->itemID),array('status'=>$status));

                    if($status != 'ALLOCATED_VENDOR'){

                        $this->home_m->insert_data('order_status',array('itemID'=>$i->itemID,'orderID'=>$id,'status'=>$status,'agentID'=>$delivery_agentID,'added_on'=>date('Y-m-d H:i:s')));

                    }

                }

            }



            $this->home_m->update_data('orders',array('orderID'=>$id),$a);

            echo '0';

        } else {

            echo "1";

        }

    }



    public function send_sms($mobile, $message){

        $sender = "GROCST";

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



    private function store_notification($userID, $title, $message)

    {

        $array = array(

            "userID" => $userID,

            "title" => $title,

            "text" => $message,

            "image" => '',

            "added_on" => date("Y-m-d H:i:s")

        );

        $this->db->insert('notifications', $array);

    }



    public function send_notification()

    {

        return true;

    }



    public function order_detail($orderID = '')

    {

        if ($orderID != '') {

            $this->db->select('orders.*,delivery_agent.name as agent_name,delivery_agent.phone as agent_phone,delivery_agent.email as agent_email,delivery_agent.alternate_phone as agent_alternate_number');

            $this->db->join('delivery_agent', 'orders.agentID = delivery_agent.delivery_agentID', 'LEFT');

            $order_info = $this->db->get_where('orders', array('orderID' => $orderID))->row();

            if (!empty($order_info)) {

                $user_info = $this->db->get_where('users', array('ID' => $order_info->userID))->row();

                // $this->db->select('order_items.*,products.product_name,products.unit_value,products.unit,products.product_image,products.category_id as product_categories,brand.brand as brand_name');

                // $this->db->join('products', 'order_items.productID = products.productID', 'LEFT');

                // $this->db->join('brand', 'products.brand_id = brand.brandID', 'LEFT');
                
                 $this->db->select('order_items.*,products.product_name,products_variant.unit_value ,products_variant.unit,products_variant.variant_image as product_image,products.category_id as product_categories,brand.brand as brand_name');
                $this->db->join('products', 'order_items.productID = products.productID', 'LEFT');
                $this->db->join('products_variant', 'order_items.variantID = products_variant.id', 'LEFT');
                $this->db->join('brand', 'products.brand_id = brand.brandID', 'LEFT');

                $order_items = $this->db->get_where('order_items', array('orderID' => $orderID))->result();

                foreach ($order_items as $ot) {

                    $ot->category_name = $this->get_subcategory_name($ot->product_categories);

                }
               // print_r($order_items); exit;

                $this->data['user'] = $user_info;

                $this->data['order'] = $order_info;

                $this->data['order_items'] = $order_items;

                $this->data['sub_view'] = 'orders/order_detail';

                $this->data['title'] = 'Order Detail';

                $this->load->view("_layout", $this->data);

            } else {

                redirect('orders/new_orders');

            }

        } else {

            redirect('orders/new_orders');

        }

    }



    private function get_subcategory_name($categories)

    {

        $category = $this->db->query("SELECT title FROM `category` WHERE `categoryID` IN ($categories)")->result();

        $category_array = array();

        foreach ($category as $c)

        {

            $category_array[] = $c->title;

        }

        return implode('<br>',$category_array);

    }

    public function report($param1 = '', $param2 = '', $param3 = ''){



            $select = 'orders.*,users.name as user_name';

            $join = array();

            $join[] = array(

                'table' => 'users',

                'parameter' => 'orders.userID = users.ID',

                'position' => 'LEFT'

            );

            $this->data['new_orders'] = $this->home_m->get_all_row_where_join('orders', array('orders.status' => 'DELIVERED'), $join, $select);

            $this->data['sub_view'] = 'orders/report';

            $this->data['title'] = 'Order  Report';

            $this->load->view("_layout", $this->data);

    }

    public function vendor($param1 = '', $param2 = '', $param3 = ''){

            

            $this->data['new_orders'] = $this->db->query("SELECT *,count(orderID) as order_count  FROM `orders` WHERE `status` = 'DELIVERED' group by vendorID")->result();

            $this->data['sub_view'] = 'orders/vendor';

            $this->data['title'] = 'Vendor Report';

            $this->load->view("_layout", $this->data);

    }

    public function generate_report(){



       $filename = 'order_report'.date('d-m-Y').'.csv'; 

       header("Content-Description: File Transfer"); 

       header("Content-Disposition: attachment; filename=$filename"); 

       header("Content-Type: application/csv; ");



       $d =     date('Y-m-d',strtotime($this->input->post('start_date')));

       $ed =    date('Y-m-d',strtotime($this->input->post('end_date')));

        $new_orders = $this->db->query("SELECT orders.orderID,users.name as user_name,orders.total_amount,orders.delivery_charges,orders.payment_method,orders.delivery_date,orders.status,orders.cityID,orders.vendorID FROM orders LEFT JOIN users ON orders.userID = users.ID where orders.delivery_date BETWEEN '$d' AND '$ed' AND orders.status = 'DELIVERED'")->result_array();

       // file creation 

       $file = fopen('php://output', 'w');

       $header = array("orderID,UserName,TotalAmount,DeliveryCharges,PaymentMethod,DeliveryDate,Status,CityName,VendorName");

       fputcsv($file, $header);

       foreach ($new_orders as $key=>$line){

            $city = $this->db->get_where('city',array('ID'=>$line['cityID']))->row_array();  

            $vendor = $this->db->get_where('admin',array('ID'=>$line['vendorID']))->row_array(); 

            $line['cityID'] = $city['title'];

            $line['vendorID'] = $vendor['name'];

         fputcsv($file,$line); 

       }

       fclose($file); 

       exit; 

    }

    public function generate_vendor_report(){



       $filename = 'order_report'.date('d-m-Y').'.csv'; 

       header("Content-Description: File Transfer"); 

       header("Content-Disposition: attachment; filename=$filename"); 

       header("Content-Type: application/csv; ");



       $d =     date('Y-m-d',strtotime($this->input->post('start_date')));

       $ed =    date('Y-m-d',strtotime($this->input->post('end_date')));

        $new_orders = $this->db->query("SELECT orderID,cityID,vendorID,count(orderID) as order_count,status,delivery_date  FROM `orders` where delivery_date BETWEEN '$d' AND '$ed' AND `status` = 'DELIVERED' group by vendorID")->result_array();

       // file creation 

       $file = fopen('php://output', 'w');

       $header = array("orderID,CityName,VendorName,TotalOrder,Status,DeliveryDate");

       fputcsv($file, $header);

       foreach ($new_orders as $key=>$line){

            $city = $this->db->get_where('city',array('ID'=>$line['cityID']))->row_array();  

            $vendor = $this->db->get_where('admin',array('ID'=>$line['vendorID']))->row_array(); 

            $line['cityID'] = $city['title'];

            $line['vendorID'] = $vendor['name'];

         fputcsv($file,$line); 

       }

       fclose($file); 

       exit; 

    }

    //generate order detail
  public function sample_product_export(){ 
   $orderID = $this->uri->segment(3);
   $orderDetail =  $this->db->select('coupon_discount,delivery_charges,order_amount,total_amount,location')->get_where('orders',array('orderID'=>$orderID))->row();
   //print_r($orderDetail); exit;
    // file name 
    $filename = 'order_detail_'.date('d-m-Y').'.csv'; 
    header("Content-Description: File Transfer"); 
    header("Content-Disposition: attachment; filename=$filename"); 
    header("Content-Type: application/csv; ");
   
    
    $order_items = $this->db->select('itemID,orderID,ProductID,variantID,status,qty,price,net_price')->get_where('order_items',array('orderID'=>$orderID))->result_array();
    // file creation 
    $file = fopen('php://output', 'w');
    $header = array('itemID','orderID','productID','variantID','status','qty','price','net_price','unit','product_name');
    fputcsv($file, $header);
     $i= 1; foreach  ($order_items as $key=>$line){ 
    $ser = $i++;
    $line['qty'] =  $line['qty'] .'X'.  $line['price'] ;
    $line['itemID'] = $ser;
     $line['unit']=$this->get_unit($line['variantID']);  
     $line['product_name']=$this->get_product_name($line['ProductID']);
      fputcsv($file,$line); 
  }
  fclose($file); 
  exit; 
}


public function  get_product_name($productID){
  $product =  $this->db->query("select * from products where productID='$productID'")->row();
  if(!empty($product)){
    return $product->product_name;
  }else{
   return '';
  }
}

public function  get_unit($variantID){
  $variant =  $this->db->query("select * from products_variant where id='$variantID'")->row();
  if(!empty($variant)){
    return $variant->unit_value.'/'.$variant->unit;
  }else{
   return '';
  }

}

    

}