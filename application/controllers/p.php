 public function place_order( $addressID="" )
    {

        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != ''  && $addressID != "" && $_GET) {
            $userID = $_SESSION['loginUserID'];
            $payment_method = 'COD';
            $items = $_GET['items'];
            $items_array = explode('@', $items);
            $address = $this->home_m->get_all_row_where('user_address', array('addressID' => $addressID), $select = '*');
            foreach ($address as $value) {
            $order_table = array(
            'userID' => $userID,
            'customer_name' => $value->contact_person_name,
            'contact_no' => $value->contact_person_mobile,
            'house_no' => $value->flat_no,
            'apartment' =>$value->building_name,
            'landmark' => $value->landmark,
            'location' => $value->location,
            'address_type' => $value->address_type,
            'agentID' => 1,
            'order_amount' => 0,
            'total_amount' => 0,
            'payment_method' => $payment_method,
            'delivery_date' => date("Y-m-d H:i:s"),
            'instruction' => '',
            'status' => 'PLACED',
            'coupon_discount' => 0,
            'added_on' => date('Y-m-d H:i:s')
            );
            }
            $orderID = $this->home_m->insert_data('orders', $order_table);
            $order_amount = 0;
            $total_amount = 0;
            foreach ($items_array as $p) {
                $single = explode(':', $p);
                $productID = $single[0];
                $qty = $single[1];
                $product_detail = $this->home_m->get_all_row_where('products', array('productID' => $productID), $select = 'retail_price,coupon_amount');
                $retail_price = $product_detail->retail_price * $qty; 
                $product_coupon_discount= ($product_detail->retail_price * $product_detail->coupon_discount) - $coupon_discount;  
                $product_price = $product_detail->retail_price - $product_coupon_discount;
                $coupon_discount = ($retail_price * $product_detail->coupon_discount) -$coupon_discount;
                $order_amount = $order_amount + $retail_price;
                $total_amount = $total_amount + $retail_price - $coupon_discount;

               /* $retail_price = $product_detail->retail_price;
                $order_amount = $product_detail->order_amount;
                $total_amount = $product_detail->total_amount * qty ;*/
                $insert_order_list = array(
                    'orderID' => $orderID,
                    'productID' => $productID,
                    'qty' => $qty,
                    'price' => 0,
                    'net_price' => 0
                );
            $this->home_m->insert_data('order_items', $insert_order_list);
            }
            
            $this->db->where(array('userID' => $userID));
            redirect(base_url("home/order_summary/$orderID/").md5($orderID));
        }else{
            $this->index();
        }
    }