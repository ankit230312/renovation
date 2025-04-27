<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Home extends CI_Controller
{



    function __construct()
    {

        parent::__construct();

        $this->load->model("home_m");
        $this->load->helper("common_helper");
        $skey   = "SuPerEncKey2010";
        $this->load->library('encryption');
        $this->load->model("webservice_m");
        $this->load->library("pagination");
    }

    /////////////////////////Encrypt Decrypt

    ////////////////////////////



    public function backup($fileName = 'db_backup.zip')
    {
        // Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $backup = &$this->dbutil->backup();

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file(FCPATH . '/downloads/' . $fileName, $backup);

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download($fileName, $backup);
    }





    public function index()
    {
        // if (empty($this->session->userdata('cityID'))) {
        //     $cityID = 1;
        // } else {
        //     $cityID = $this->session->userdata('cityID');
        // }
        // if (empty($this->session->userdata('loginUserID'))) {

        //     $userID = 0;
        // } else {
        //     $userID = $this->session->userdata('loginUserID');
        // }

        $cityID = 0;
        $userID = 0;
        $date = date('Y-m-d');
        $products = array();
        $deals = $this->db->query("  SELECT * FROM `deals` WHERE  cityID='1' AND start_date <= '$date' AND end_date >= '$date' AND cityID = '$cityID' AND status = 'Y' LIMIT 4 ")->result();
        //echo $this->db->last_query();
        $profile = $this->db->get_where('users', array('ID' => $userID))->row_array();

        $this->data['myprofile'] = $profile;



        //print_r($deals);
        foreach ($deals as $d) {

            $product = $this->get_product($d->variantID);
            //echo $this->db->last_query();
            //$product = $this->get_product($d->variantID);
            // var_dump($product);
            if (!empty($product)) {
                $products_details[] = array(
                    'productID' => isset($product->product_id) ? $product->product_id : '',
                    'variantID' => isset($product->id) ? $product->id : '',
                    'max_quantity' => isset($product->max_quantity) ? $product->max_quantity : '',
                    'product_name' => isset($product->product_name) ? $product->product_name : '',
                    'product_image' => isset($product->product_image) ? $product->product_image : '',
                    'brand' => 'Gowisekart',
                    'retail_price' => isset($product->retail_price) ? $product->retail_price : '',
                    'price' => isset($d->deal_price) ? $d->deal_price : '',
                    'unit_value' => isset($product->unit_value) ? $product->unit_value : '',
                    'unit' => isset($product->unit) ? $product->unit : '',
                    'in_stock' => isset($product->in_stock) ? $product->in_stock : '',
                    'stock_count' => isset($product->stock_count) ? $product->stock_count : '',
                    'vegtype' => isset($product->vegtype) ? $product->vegtype : '',
                    'cart_qty' => ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $product->product_id, $product->id)
                );
                //print_r($products_details);
            } else {
                /* $products = [];*/
                $products_details = [];
            }
            array_push($products, $products_details);
        }
        $featured = $this->db->query("SELECT * FROM `products` WHERE `featured`='Y' AND `in_stock`='Y' limit 10,4")->result();
        foreach ($featured as $p) {
            $p->variants = $this->all_variants($p->productID, $cityID, $userID);
            $defaultVariant = $this->get_default_variant($p->productID, $cityID);
            if (!empty($defaultVariant)) {
                $p->unit_value =  $defaultVariant->unit_value;
                $p->unit =  $defaultVariant->unit;
                $p->stock_count =  $defaultVariant->stock_count;
                $p->retail_price =  $defaultVariant->retail_price;
                $p->price =  $defaultVariant->price;
                $p->cost_price =  $defaultVariant->cost_price;
                $p->variantID =  $defaultVariant->id;
                $p->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $p->productID, $defaultVariant->id);
            }
            $p->totalVariants = count($p->variants);
            //$p->cart_qty = ($userID == 0)?0:$this->get_product_qty_cart($userID,$p->productID,$defaultVariant->id);


        }
        //print_r($featured); exit;

        ////////Fruits Category Products
        $categoryID =   1;
        $subCategory_products = $this->db->query("select * from category where parent='$categoryID' and status='Y'")->result();
        if (!empty($subCategory_products)) {
            foreach ($subCategory_products as $sub) {
                $sub->products = $this->all_products($sub->categoryID, $cityID, $userID);
            }
        }
        $this->data['subCategory_products'] = $subCategory_products;
        ////////Fruits Category Products
        //////////////////////Grocery Products
        $categoryID =   3;
        $grocery_products = $this->db->query("select * from category where parent='$categoryID' and status='Y'")->result();
        if (!empty($grocery_products)) {
            foreach ($grocery_products as $sub) {
                $sub->products = $this->all_products($sub->categoryID, $cityID, $userID);
            }
        }
        $this->data['grocery_products'] = $grocery_products;



        ///////Vegitable Products 

        $categoryID =   2;
        $vegitable_products = $this->db->query("select * from category where parent='$categoryID' and status='Y'")->result();
        if (!empty($vegitable_products)) {
            foreach ($vegitable_products as $sub) {
                $sub->products = $this->all_products($sub->categoryID, $cityID, $userID);
            }
        }
        $this->data['vegitable_products'] = $vegitable_products;


        $featured_banner = $this->db->query("select * from featured_banner where status='Y' ORDER BY priority desc")->result();

        //echo $this->db->last_query();
        //////////////////End-----------------------

        ////////TOP Selling Product
        $best_selling_pro = array();

        $best_selling_pro = $this->db->query("SELECT * FROM order_items GROUP BY productID ORDER BY SUM(qty) DESC  LIMIT 10 ")->result();




        //print_r($best_selling_pro);
        if (!empty($best_selling_pro)) {
            foreach ($best_selling_pro  as $best) {
                $products = $this->db->query("SELECT * FROM `products` WHERE productID='$best->productID' AND in_stock = 'Y' ")->result();
                if (!empty($products)) {
                    foreach ($products as $p) {
                        $p->variants = $this->all_variants($p->productID, $cityID, $userID);
                        $defaultVariant = $this->get_default_variant($p->productID, $cityID);
                        if (!empty($defaultVariant)) {
                            $p->unit_value =  $defaultVariant->unit_value;
                            $p->unit =  $defaultVariant->unit;
                            $p->stock_count =  $defaultVariant->stock_count;
                            $p->retail_price =  $defaultVariant->retail_price;
                            $p->price =  $defaultVariant->price;
                            $p->cost_price =  $defaultVariant->cost_price;
                            $p->variantID =  $defaultVariant->id;
                            $variantID =   $defaultVariant->id;
                        }
                        $p->totalVariants = count($p->variants);
                        $productID =  $p->productID;

                        $p->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $productID, $variantID);
                    }
                }
            }
        }


        ////////Recent Purchase
        $recent_purchase = array();
        $userID = $this->session->userdata('loginUserID');
        if (!empty($this->session->userdata('loginUserID'))) {

            $orders = $this->db->query("SELECT * FROM orders where userID='$userID' ORDER BY orderID DESC  LIMIT 15 ")->result();
            $orderIds = [];
            if (!empty($orders)) {
                foreach ($orders as $or) {
                    $orderIds[] = $or->orderID;
                }
            }

            $orderIds  = implode(",", $orderIds);

            if (!empty($orderIds)) {
                $recent_purchase = $this->db->query("SELECT * FROM order_items where orderID IN($orderIds) GROUP BY productID ORDER BY SUM(qty) DESC  LIMIT 15  ")->result();
            }
        }
        //print_r($recent_purchase);

        if (!empty($recent_purchase)) {
            foreach ($recent_purchase  as $best) {
                $products = $this->db->query("SELECT * FROM `products` WHERE productID='$best->productID' AND in_stock = 'Y' GROUP BY productID ")->result();
                if (!empty($products)) {
                    foreach ($products as $p) {
                        $p->variants = $this->all_variants($p->productID, $cityID, $userID);
                        $defaultVariant = $this->get_default_variant($p->productID, $cityID);
                        if (!empty($defaultVariant)) {
                            $p->unit_value =  $defaultVariant->unit_value;
                            $p->unit =  $defaultVariant->unit;
                            $p->stock_count =  $defaultVariant->stock_count;
                            $p->retail_price =  $defaultVariant->retail_price;
                            $p->price =  $defaultVariant->price;
                            $p->cost_price =  $defaultVariant->cost_price;
                            $p->variantID =  $defaultVariant->id;
                            $variantID =   $defaultVariant->id;
                        }
                        $p->totalVariants = count($p->variants);
                        $productID =  $p->productID;
                        /*$variantID =   $defaultVariant->id;*/
                        $p->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $productID, $variantID);
                    }
                }
            }
        }




        //////////////





        $this->data['best_selling_pro'] = $best_selling_pro;
        $this->data['recent_purchase'] = $recent_purchase;

        $this->data['userID'] = $userID;
        $this->data['cityID'] = $cityID;


        $this->data['page_name'] = 'home';

        $this->data['featured_banner'] = $featured_banner;

        $this->data['deal_product'] = $products;
        $this->data['deals'] = $deals;
        $this->data['featured'] = $featured;
        $this->data['web_banners'] = $this->home_m->get_all_table_query("SELECT * FROM web_banners WHERE status= 'Y' order by priority desc");
        $this->data['other_banners'] = $this->home_m->get_all_table_query("SELECT * FROM web_other_banners WHERE status= 'Y' AND section_no = '1' order by priority asc");
        $this->data['other_section_banners'] = $this->home_m->get_all_table_query("SELECT * FROM web_other_banners WHERE status= 'Y' AND section_no = '2' order by priority asc");
        $this->data['last_section_banners'] = $this->home_m->get_all_table_query("SELECT * FROM web_other_banners WHERE status= 'Y' AND section_no = '3' order by priority asc");
        $this->data['final_section_banners'] = $this->home_m->get_all_table_query("SELECT * FROM web_other_banners WHERE status= 'Y' AND section_no = '4' order by priority asc");

        $parentCategory = $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '0' && status= 'Y' limit 6");
        if (!empty($parentCategory)) {
            foreach ($parentCategory as $category) {
                $category->subCategory = $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '$category->categoryID' && status= 'Y'");
            }
        }
        $this->data['parentCategory'] =  $parentCategory;
        $this->load->view('index', $this->data);
    }

    public function index_old()
    {
        if (empty($this->session->userdata('cityID'))) {
            $cityID = 1;
        } else {
            $cityID = $this->session->userdata('cityID');
        }
        if (empty($this->session->userdata('loginUserID'))) {
            $userID = 0;
        } else {
            $userID = $this->session->userdata('loginUserID');
        }
        $date = date('Y-m-d');
        $products = array();
        $deals = $this->db->query("SELECT * FROM `deals` WHERE (`start_date` <= '$date' AND `end_date`>='$date') AND `status`='Y' AND cityID='$cityID' limit 10")->result();
        //print_r($deals);
        foreach ($deals as $d) {
            //echo $d->variantID; exit;
            $product = $this->get_product($d->variantID);
            if (!empty($product)) {
                $products[] = array(
                    'productID' => isset($product->product_id) ? $product->product_id : '',
                    'variantID' => $product->id,
                    'max_quantity' => $product->max_quantity,
                    'product_name' => $product->product_name,
                    'product_image' => $product->product_image,
                    'brand' => 'Gowisekart',
                    'retail_price' => $product->retail_price,
                    'price' => $d->deal_price,
                    'unit_value' => $product->unit_value,
                    'unit' => $product->unit,
                    'in_stock' => $product->in_stock,
                    'stock_count' => $product->stock_count,
                    'vegtype' => $product->vegtype,
                    'cart_qty' => ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $product->product_id, $product->id)
                );
            } else {
                $products = [];
            }
        }


        $featured = $this->db->query("SELECT * FROM `products` WHERE `featured`='Y' AND `in_stock`='Y' limit 10,4")->result();
        foreach ($featured as $p) {
            $p->variants = $this->all_variants($p->productID, $cityID, $userID);
            $defaultVariant = $this->get_default_variant($p->productID, $cityID);
            if (!empty($defaultVariant)) {
                $p->unit_value =  $defaultVariant->unit_value;
                $p->unit =  $defaultVariant->unit;
                $p->stock_count =  $defaultVariant->stock_count;
                $p->retail_price =  $defaultVariant->retail_price;
                $p->price =  $defaultVariant->price;
                $p->cost_price =  $defaultVariant->cost_price;
                $p->variantID =  $defaultVariant->id;
            }
            $p->totalVariants = count($p->variants);
            $p->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $p->productID, $defaultVariant->id);
        }
        //print_r($featured); exit;

        ////////Fruits Category Products
        $categoryID =   1;
        $subCategory_products = $this->db->query("select * from category where parent='$categoryID' and status='Y'")->result();
        if (!empty($subCategory_products)) {
            foreach ($subCategory_products as $sub) {
                $sub->products = $this->all_products($sub->categoryID, $cityID, $userID);
            }
        }
        $this->data['subCategory_products'] = $subCategory_products;
        ////////Fruits Category Products
        //////////////////////Grocery Products
        $categoryID =   3;
        $grocery_products = $this->db->query("select * from category where parent='$categoryID' and status='Y'")->result();
        if (!empty($grocery_products)) {
            foreach ($grocery_products as $sub) {
                $sub->products = $this->all_products($sub->categoryID, $cityID, $userID);
            }
        }
        $this->data['grocery_products'] = $grocery_products;



        ///////Vegitable Products 

        $categoryID =   2;
        $vegitable_products = $this->db->query("select * from category where parent='$categoryID' and status='Y'")->result();
        if (!empty($vegitable_products)) {
            foreach ($vegitable_products as $sub) {
                $sub->products = $this->all_products($sub->categoryID, $cityID, $userID);
            }
        }
        $this->data['vegitable_products'] = $vegitable_products;


        //////////////////End-----------------------

        $this->data['page_name'] = 'home';
        $this->data['deal_product'] = $products;
        $this->data['featured'] = $featured;
        $this->data['web_banners'] = $this->home_m->get_all_table_query("SELECT * FROM web_banners WHERE status= 'Y'");
        $parentCategory = $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '0' && status= 'Y' limit 6");
        if (!empty($parentCategory)) {
            foreach ($parentCategory as $category) {
                $category->subCategory = $this->home_m->get_all_table_query("SELECT * FROM category WHERE  parent= '$category->categoryID' && status= 'Y'");
            }
        }
        $this->data['parentCategory'] =  $parentCategory;
        $this->load->view('index', $this->data);
    }

    public function get_default_variant($productID, $cityID, $min_price = 0, $max_price = 0)
    {
        $variant = $this->db->query("SELECT * from products_variant where product_id='$productID' && city_id='$cityID' AND is_default='1' AND in_stock='Y'")->row();
        if ($min_price > 0 && $max_price > 0) {
            $variant = $this->db->query("SELECT * from products_variant where  product_id='$productID' &&  city_id='$cityID' && is_default='1' && price >='$min_price' && price <='$max_price' && in_stock='Y' ")->row();
        }
        if (!empty($variant)) {
            return $variant;
        }
    }


    public function city()
    {
        $cityID =  $_POST['cityID'];
        $this->session->set_userdata('cityID', $cityID);
        echo  $cityID;
    }

    /*public function city_pincode(){
    $pincode = $this->input->post('pincode');
    $exist = $this->db->get_where('locality',array('pin'=>$pincode))->row();
    if(empty($exist)){
        $message = 'We Dont Serve Your Area';
    }else{
        $this->session->set_userdata('cityID',$exist->locality);
        $message = '';
    }

    if (empty($this->session->userdata('loginUserID'))) {
       $this->session->set_userdata('pincode',$pincode);


   }else{
    $userID = $this->session->userdata('loginUserID');
    $this->db->set('pincode', $pincode);
    $this->db->where('ID',$userID);
    $this->db->update('users');
} 
echo json_encode(array('status'=>true,'pincode'=>$pincode,'message'=>$message));

}*/
    public function pin()
    {
        if ($_POST) {
            $pincode = $this->input->post('pincode');
            $exist = $this->db->get_where('locality', array('pin' => $pincode))->row();
            if (!empty($exist)) {
                $userID = $this->session->userdata('loginUserID');
                if (empty($this->session->userdata('loginUserID'))) {
                    $this->session->set_userdata('pincode', $pincode);
                    redirect(base_url("home"));
                } else {
                    $userID = $this->session->userdata('loginUserID');
                    var_dump($userID);
                    $this->db->set('pincode', $pincode);
                    $this->db->where('ID', $userID);
                    $this->db->update('users');
                    $this->session->set_userdata('pincode', $pincode);
                    //echo $this->db->last_query();
                    //$message ='Pincode Updated';
                    // echo json_encode(array('result'=>'success','pincode'=>$pincode,'msg'=>$message)); 
                    redirect(base_url("home"));
                }
            } else {
                $this->session->set_userdata('pincode', $pincode);
                echo json_encode(array('result' => 'failure', 'pincode' => '', 'msg' => 'We will be coming soon to this area.'));
                redirect(base_url("home/location"));
            }
        } else {
            echo json_encode(array('result' => 'success', 'pincode' => '', 'msg' => 'Permission Denied'));
        }
    }
    public function location()
    {
        $this->data['page_name'] = 'location';
        $this->load->view('index', $this->data);
    }

    public function shopping_cart()
    {
        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }

        if (empty($this->session->userdata('cityID'))) {
            $cityID = 0;
        } else {
            $cityID = $this->session->userdata('cityID');
        }

        if (empty($this->session->userdata('loginUserID'))) {
            $userID = 0;
        } else {
            $userID = $this->session->userdata('loginUserID');
        }
        $date = date('Y-m-d');
        $userInfo =  $this->db->query("select * from users where ID='$userID' and status='Y'")->row();
        $carts = array();
        if ($userID != 0) {
            $carts = $this->db->query("SELECT * FROM `product_cart` WHERE `userID`='$userID'")->result();
        }
        $this->data['carts'] = $carts;
        $this->data['page_name'] = 'shopping_cart';

        $this->data['myprofile'] = $this->my_profile($userID);
        $this->data['offers'] = $this->home_m->get_all_table_query("SELECT * FROM offers WHERE is_active= 'Y' and end_date>$date");
        //print_r($this->data['offers']); exit;

        $this->load->view('index', $this->data);
    }

    public function delete_item()
    {
        if (empty($this->session->userdata('loginUserID'))) {
            $userID = 0;
        } else {
            $userID = $this->session->userdata('loginUserID');
        }
        $cartID =  $this->uri->segment(3);
        $result = $this->home_m->delete_data('product_cart', array('cartID' => $cartID));
        if ($result) {
            redirect(redirect(base_url("home/shopping_cart")));
        }
    }


    public function all_cart_items()
    {
        if (empty($this->session->userdata('loginUserID'))) {
            $userID = 0;
        } else {
            $userID = $this->session->userdata('loginUserID');
        }
        $cartID =   $_POST['cartID'];
        $html = '';
        $result = $this->home_m->delete_data('product_cart', array('cartID' => $cartID));
        if ($result) {
            $carts = $this->db->query("SELECT `users`.`ID` as userID, COALESCE(SUM(`qty`),0) as items FROM `product_cart` LEFT JOIN `users` ON `product_cart`.`userID` = `users`.`ID` WHERE `product_cart`.`userID`='$userID'")->row();

            if (!empty($carts)) {

                if (!empty($_SESSION['loginUserID'])) {

                    $cart_products = $this->db->query("SELECT `product_cart`.`cartID`, `product_cart`.`productID`,`product_cart`.`variantID`, `product_cart`.`qty`, `products_variant`.`price`, `products_variant`.`retail_price`,`products_variant`.`unit`, `products_variant`.`unit_value`,`products_variant`.`variant_image`,`products`.`product_name`,`products`.`product_image`

                    FROM `product_cart` LEFT JOIN `products_variant` 

                    ON  `product_cart`.`variantID` = `products_variant`.`id` join `products`

                    ON `products`.`productID`=`product_cart`.`productID`

                    WHERE `product_cart`.`userID`='$userID'")->result();
                } else {

                    $cart_products = $this->db->query("SELECT `product_cart`.`cartID`, `product_cart`.`productID`,`product_cart`.`variantID`, `product_cart`.`qty`, `products_variant`.`price`, `products_variant`.`retail_price`,`products_variant`.`unit`, `products_variant`.`unit_value`,`products_variant`.`variant_image`,`products`.`product_name`,`products`.`product_image` FROM `product_cart` LEFT JOIN `products_variant` ON  `product_cart`.`variantID` = `products_variant`.`id` join `products` on `product_cart`.`productID`=`products`.`productID` WHERE `product_cart`.`userID`='$userID'")->result();
                }

                $carts->products = $cart_products;


                $html .= ' <table class="table">
            <thead>
            <tr>
            <th scope="col" class="border-0 bg-light">
            <div class="p-2 px-3 text-uppercase">Product</div>
            </th>
            <th scope="col" class="border-0 bg-light">
            <div class="py-2 text-uppercase">Weight</div>
            </th>
            <th scope="col" class="border-0 bg-light">
            <div class="py-2 text-uppercase">Price</div>
            </th>

            <th scope="col" class="border-0 bg-light">
            <div class="py-2 text-uppercase">Quantity</div>
            </th>
            <th scope="col" class="border-0 bg-light">
            <div class="py-2 text-uppercase">Remove</div>
            </th>
            </tr>
            </thead>
            <tbody id="item_set">';
                $sub_total = 0.00;
                if (!empty($carts->products)) {
                    //print_r( $carts->products); exit;
                    foreach ($carts->products as $p) {
                        $sub_total = + ($p->price * $p->qty);

                        $html .= '

                <tr>
                <th scope="row" class="border-0">
                <div class="p-2">
                <img src="' . base_url('admin/uploads/products/') . $p->product_image . '" alt="" width="70" class="img-fluid rounded shadow-sm">
                <div class="ml-3 d-inline-block align-middle">
                <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">' . $p->product_name . '</a></h5>
                </div>
                </div>
                </th>
                <td class="border-0 align-middle"><strong>' . $p->unit_value . '/' . $p->unit . '<strong></td>
                <td class="border-0 align-middle"><strong>₹' . $p->price . '</strong></td>
                <td class="border-0 align-middle"><strong>' . $p->qty . '</strong></td>
                <td class="border-0 align-middle"><i class="fa fa-trash remove_item" id="' . $p->cartID . '></i></td>
                </tr>';
                    }
                }

                $html .= '</tbody>
        </table>';
                echo $html;
            }
        }
    }


    public function category_products()
    {



        if (empty($this->session->userdata('cityID'))) {
            $cityID = 1;
        } else {
            $cityID = $this->session->userdata('cityID');
        }
        if (empty($this->session->userdata('loginUserID'))) {
            $userID = 0;
        } else {
            $userID = $this->session->userdata('loginUserID');
        }
        $select_brand = (isset($_REQUEST['select_brand']) ? $_REQUEST['select_brand'] : '');
        $search_key = (isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '');
        $min_price = (isset($_REQUEST['min_price']) ? $_REQUEST['min_price'] : '');
        $max_price = (isset($_REQUEST['max_price']) ? $_REQUEST['max_price'] : '');
        $disc_min = (isset($_REQUEST['disc_min']) ? $_REQUEST['disc_min'] : '');
        $disc_max = (isset($_REQUEST['disc_max']) ? $_REQUEST['disc_max'] : '');
        $brand_array = array();
        $where = '1';

        $select_category = '';
        /*$where = "`in_stock` = 'Y'";*/
        if (!empty($search_key)) {
            $where = $where . " AND `product_name` LIKE '%$search_key%' AND `in_stock` = 'Y'";
        }
        if (!empty($select_category)) {
            $category_array = explode('--', $select_category);
            $where = $where . ' AND (';
            foreach ($category_array as $c) {
                $where = $where . ' category_id IN (SELECT categoryID FROM category WHERE `categoryID`=' . $c . ') OR';
            }
            if (!empty($category_array)) {
                $where = substr($where, 0, -3);
            }
            $where = $where . ' )';
        }
        if (!empty($select_brand)) {
            $brand_array = explode('--', $select_brand);
            $where = $where . ' AND (';
            foreach ($brand_array as $c) {
                $where = $where . ' brand_id IN (SELECT brandID FROM brand WHERE `brandID`=' . $c . ') OR';
            }
            if (!empty($brand_array)) {
                $where = substr($where, 0, -3);
            }
            $where = $where . ' )';
        }
        if (!empty($min_price)) {
            $where = $where . " AND `price` >= '$min_price'";
        }
        if (!empty($max_price)) {
            $where = $where . " AND `price` <= '$max_price' ";
        }
        $count_product = $this->db->query("SELECT * FROM `products` WHERE $where AND in_stock = 'Y'")->result();
        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 12;
        $limit = $no_of_records_per_page;
        $offset = ($pageno - 1) * $no_of_records_per_page;
        $total_pages_sql = count($count_product);
        $total_pages = ceil($total_pages_sql / $no_of_records_per_page);

        // $this->db->group_by('productID');
        $products = $this->db->query("SELECT * FROM `products` WHERE $where AND in_stock = 'Y' GROUP BY (`productID`) LIMIT $limit OFFSET  $offset")->result();

        /*    $product_data = $this->db->query("SELECT MIN(`price`) as min_price, MAX(`price`) as max_price FROM `products` WHERE `product_name` LIKE '%$search_key%' AND 'in_stock'= 'Y'")->row();
*/
        $product_data = $this->db->query("SELECT  MIN(`price`) as min_price, MAX(`price`) as max_price FROM `products_variant`WHERE 'in_stock'= 'Y'")->row();

        foreach ($products as $p) {
            $defaultVariant = $this->get_default_variant($p->productID, $cityID);
            if ($min_price > 0 && $max_price > 0) {
                $defaultVariant = $this->get_default_variant($p->productID, $cityID, $min_price, $max_price);
            }
            $p->variants = $this->all_variants($p->productID, $cityID, $userID);
            //$defaultVariant = $this->get_default_variant($p->productID, $cityID);
            if (!empty($defaultVariant)) {
                $p->unit_value =  $defaultVariant->unit_value;
                $p->unit =  $defaultVariant->unit;
                $p->stock_count =  $defaultVariant->stock_count;
                $p->retail_price =  $defaultVariant->retail_price;
                $p->price =  $defaultVariant->price;
                $p->cost_price =  $defaultVariant->cost_price;
                $p->variantID =  $defaultVariant->id;
            }
            $p->totalVariants = count($p->variants);
            $varient_id = isset($defaultVariant->id) ? $defaultVariant->id : '';
            $p->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $p->productID, $varient_id);
        }
        $carts = $this->db->query("SELECT * FROM `product_cart` WHERE userID='$userID'")->result();
        $brands = $this->db->query("SELECT * FROM `brand` WHERE is_active='Y'")->result_array();



        $categoryID =   $this->uri->segment(3);
        $subCategory_products = $this->db->query("select * from category where parent='$categoryID' and status='Y' LIMIT 3 ")->result();
        if (!empty($subCategory_products)) {
            foreach ($subCategory_products as $sub) {
                $sub->products = $this->all_products($sub->categoryID, $cityID, $userID, $pageno, $offset, $no_of_records_per_page);
            }
        }
        $this->data['carts'] = $carts;
        $this->data['total_pages'] = $total_pages;
        $this->data['pageno'] = $pageno;
        $this->data['products'] = $products;
        $this->data['brands'] = $brands;
        $this->data['brand_ids'] = $brand_array;
        $this->data['product_data'] = $product_data;
        $this->data['search_key'] = $search_key;
        $this->data['min_price'] = empty($min_price) ? $product_data->min_price : $min_price;
        $this->data['max_price'] = empty($max_price) ? $product_data->max_price : $max_price;
        $this->data['disc_min'] = $disc_min;
        $this->data['disc_max'] = $disc_max;
        $this->data['page_name'] = 'category_products';
        $this->data['subCategory_products'] = $subCategory_products;
        $this->load->view('index', $this->data);
    }

    public function sub_category_products()
    {
        if (empty($this->session->userdata('cityID'))) {
            $cityID = 1;
        } else {
            $cityID = $this->session->userdata('cityID');
        }
        if (empty($this->session->userdata('loginUserID'))) {
            $userID = 0;
        } else {
            $userID = $this->session->userdata('loginUserID');
        }
        $select_brand = (isset($_REQUEST['select_brand']) ? $_REQUEST['select_brand'] : '');
        $search_key = (isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '');
        $min_price = (isset($_REQUEST['min_price']) ? $_REQUEST['min_price'] : '');
        $max_price = (isset($_REQUEST['max_price']) ? $_REQUEST['max_price'] : '');
        $disc_min = (isset($_REQUEST['disc_min']) ? $_REQUEST['disc_min'] : '');
        $disc_max = (isset($_REQUEST['disc_max']) ? $_REQUEST['disc_max'] : '');

        $brand_array = array();
        $where = '1';

        $select_category = '';
        /*$where = "`in_stock` = 'Y'";*/
        if (!empty($search_key)) {
            $where = $where . " AND `product_name` LIKE '%$search_key%' AND `in_stock` = 'Y'";
        }
        if (!empty($select_category)) {
            $category_array = explode('--', $select_category);
            $where = $where . ' AND (';
            foreach ($category_array as $c) {
                $where = $where . ' category_id IN (SELECT categoryID FROM category WHERE `categoryID`=' . $c . ') OR';
            }
            if (!empty($category_array)) {
                $where = substr($where, 0, -3);
            }
            $where = $where . ' )';
        }
        if (!empty($select_brand)) {
            $brand_array = explode('--', $select_brand);
            $where = $where . ' AND (';
            foreach ($brand_array as $c) {
                $where = $where . ' brand_id IN (SELECT brandID FROM brand WHERE `brandID`=' . $c . ') OR';
            }
            if (!empty($brand_array)) {
                $where = substr($where, 0, -3);
            }
            $where = $where . ' )';
        }
        if (!empty($min_price)) {
            $where = $where . " AND `price` >= '$min_price'";
        }
        if (!empty($max_price)) {
            $where = $where . " AND `price` <= '$max_price' ";
        }
        $count_product = $this->db->query("SELECT * FROM `products` WHERE $where AND in_stock = 'Y'")->result();

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 12;
        $limit = $no_of_records_per_page;
        $offset = ($pageno - 1) * $no_of_records_per_page;
        $total_pages_sql = count($count_product);
        $total_pages = ceil($total_pages_sql / $no_of_records_per_page);


        $products = $this->db->query("SELECT * FROM `products` WHERE $where AND in_stock = 'Y' LIMIT $limit OFFSET  $offset ")->result();

        $product_data = $this->db->query("SELECT  MIN(`price`) as min_price, MAX(`price`) as max_price FROM `products_variant`WHERE 'in_stock'= 'Y'")->row();

        foreach ($products as $p) {
            $defaultVariant = $this->get_default_variant($p->productID, $cityID);
            if ($min_price > 0 && $max_price > 0) {
                $defaultVariant = $this->get_default_variant($p->productID, $cityID, $min_price, $max_price);
            }
            $p->variants = $this->all_variants($p->productID, $cityID, $userID);
            //$defaultVariant = $this->get_default_variant($p->productID, $cityID);
            if (!empty($defaultVariant)) {
                $p->unit_value =  $defaultVariant->unit_value;
                $p->unit =  $defaultVariant->unit;
                $p->stock_count =  $defaultVariant->stock_count;
                $p->retail_price =  $defaultVariant->retail_price;
                $p->price =  $defaultVariant->price;
                $p->cost_price =  $defaultVariant->cost_price;
                $p->variantID =  $defaultVariant->id;
            }
            $p->totalVariants = count($p->variants);
            $varient_id = isset($defaultVariant->id) ? $defaultVariant->id : '';
            $p->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $p->productID, $varient_id);
        }
        $carts = $this->db->query("SELECT * FROM `product_cart` WHERE userID='$userID'")->result();
        $brands = $this->db->query("SELECT * FROM `brand` WHERE is_active='Y'")->result_array();

        $subcategoryID =   $this->uri->segment(3);
        $subCategory_products = $this->db->query("select * from category where categoryID='$subcategoryID' and status='Y'")->result();
        if (!empty($subCategory_products)) {
            foreach ($subCategory_products as $sub) {
                $sub->products = $this->all_products($sub->categoryID, $cityID, $userID, $pageno, $offset, $no_of_records_per_page, $limit);
            }
        }
        // print_r($subCategory_products);
        // die;
        $this->data['carts'] = $carts;
        $this->data['total_pages'] = $total_pages;
        $this->data['pageno'] = $pageno;
        $this->data['products'] = $products;
        $this->data['brands'] = $brands;
        $this->data['brand_ids'] = $brand_array;
        $this->data['product_data'] = $product_data;
        $this->data['search_key'] = $search_key;
        $this->data['min_price'] = empty($min_price) ? $product_data->min_price : $min_price;
        $this->data['max_price'] = empty($max_price) ? $product_data->max_price : $max_price;
        $this->data['disc_min'] = $disc_min;
        $this->data['disc_max'] = $disc_max;
        $this->data['page_name'] = 'sub_category_products';
        $this->data['subCategory_products'] = $subCategory_products;
        $this->load->view('index', $this->data);
    }

    public function privacy_policy()
    {
        $this->data['page_name'] = 'privacy';
        $this->data['all_data'] = $this->db->query("select * from settings")->row();
        $this->load->view('index', $this->data);
    }

    public function about()
    {
        $this->data['page_name'] = 'about';
        $this->data['all_data'] = $this->db->query("select * from settings")->row();
        $this->load->view('index', $this->data);
    }

    public function faqs()
    {
        $this->data['page_name'] = 'faqs';
        $this->data['all_data'] = $this->db->query("select * from settings")->row();
        $this->load->view('index', $this->data);
    }

    public function terms_condition()
    {
        $this->data['page_name'] = 'terms_condition';
        $this->data['all_data'] = $this->db->query("select * from settings")->row();
        $this->load->view('index', $this->data);
    }




    public function get_products()
    {
        if (empty($this->session->userdata('cityID'))) {
            $cityID = 1;
        } else {
            $cityID = $this->session->userdata('cityID');
        }
        if (empty($this->session->userdata('loginUserID'))) {
            $userID = 0;
        } else {
            $userID = $this->session->userdata('loginUserID');
        }
        $categoryID =   $this->uri->segment(3);
        $categoryInfo =  $this->db->query("select * from category where categoryID='$categoryID' and status='Y'")->row();
        if (!empty($categoryInfo)) {
            $title =  $categoryInfo->title;
        } else {
            $title = '';
        }
        $this->data['category_name'] = $title;
        $this->data['page_name'] = 'products';
        $this->data['products'] =  $this->all_products($categoryID, $cityID, $userID);
        $this->load->view('index', $this->data);
    }

    public function all_products($categoryID, $cityID, $userID, $pageno = 1, $offset = 0, $no_of_records_per_page = 6, $limit = 6)
    {

        // $count_product = $this->db->query("SELECT * FROM `products` WHERE category_id='$categoryID' and in_stock='Y'")->result();
        // $total_pages_sql = count($count_product);
        // $total_pages = ceil($total_pages_sql / $no_of_records_per_page);

        //$products =   $this->db->query("select * from products where category_id='$categoryID' and in_stock='Y' LIMIT $offset, $no_of_records_per_page")->result();

        //$products =   $this->db->query("select * from products where category_id='$categoryID' and in_stock='Y' ")->result();

        $products =   $this->db->query("SELECT * from products where FIND_IN_SET($categoryID,category_id) AND in_stock='Y' GROUP BY (`productID`) LIMIT $limit OFFSET $offset ")->result();
        if (!empty($products)) {
            foreach ($products as $p) {
                $p->variants = $this->all_variants($p->productID, $cityID, $userID);
                $defaultVariant = $this->get_default_variant($p->productID, $cityID);
                if (!empty($defaultVariant)) {
                    $p->unit_value =  $defaultVariant->unit_value;
                    $p->unit =  $defaultVariant->unit;
                    $p->stock_count =  $defaultVariant->stock_count;
                    $p->retail_price =  $defaultVariant->retail_price;
                    $p->price =  $defaultVariant->price;
                    $p->cost_price =  isset($defaultVariant->cost_price) ? $defaultVariant->cost_price : 0;
                    $p->variantID =  isset($defaultVariant->id) ? $defaultVariant->id : 0;
                }
                $p->totalVariants = count($p->variants);
                $varient_id = isset($defaultVariant->id) ? $defaultVariant->id : 0;

                $p->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $p->productID, $varient_id);
            }
        }

        // $products['pageno']= isset($pageno) ? $pageno :1;
        //     $products['total_pages'] = isset($total_pages) ? $total_pages :1;
        return  $products;
    }

    public function all_variants($productID, $cityID, $userID)
    {
        $variants = $this->db->query("SELECT * from products_variant where product_id='$productID' AND in_stock='Y' and city_id='$cityID' order by id")->result();
        foreach ($variants as $v) {
            $v->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $productID, $v->id);
        }
        return  $variants;
    }



    public function get_product($variantID)
    {
        $product =  $this->db->query("SELECT products_variant.*,products.product_name,products.product_image,products.max_quantity from products_variant inner join products on products_variant.product_id=products.productID WHERE products_variant.id='$variantID' AND products_variant.in_stock='Y'")->row();
        return $product;
    }

    public function product_detail()
    {
        if (empty($this->session->userdata('cityID'))) {
            $cityID = 1;
        } else {
            $cityID = $this->session->userdata('cityID');
        }
        if (empty($this->session->userdata('loginUserID'))) {
            $userID = 0;
        } else {
            $userID = $this->session->userdata('loginUserID');
        }
        $productID =  $this->uri->segment(3);
        $product =  $this->db->query("select * from products where productID='$productID'")->row();
        if (!empty($product)) {
            $product->variants = $this->all_variants($product->productID, $cityID, $userID);
            $defaultVariant = $this->get_default_variant($product->productID, $cityID);
            if (!empty($defaultVariant)) {
                $product->unit_value =  $defaultVariant->unit_value;
                $product->unit =  $defaultVariant->unit;
                $product->stock_count =  $defaultVariant->stock_count;
                $product->retail_price =  $defaultVariant->retail_price;
                $product->price =  $defaultVariant->price;
                $product->cost_price =  $defaultVariant->cost_price;
                $product->variantID =  $defaultVariant->id;
            }
            $product->totalVariants = count($product->variants);;
            $product->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $product->productID, $defaultVariant->id);
        }

        //related products
        $sql = "SELECT * FROM `products` WHERE `productID`!='$productID'AND `in_stock` = 'Y' AND (";
        $cat = explode(',',  $product->category_id);
        if (!empty($cat)) {
            foreach ($cat as $c) {
                $sql .= " FIND_IN_SET($c,`category_id`) OR ";
            }
            $sql = substr($sql, 0, -3);
        } else {

            $sql .= " 1";
        }
        $sql .= " ) limit 4";

        $related_products = $this->db->query($sql)->result();
        if (!empty($related_products)) {
            foreach ($related_products as $p) {
                $p->variants = $this->all_variants($p->productID, $cityID, $userID);
                $defaultVariant = $this->get_default_variant($p->productID, $cityID);
                if (!empty($defaultVariant)) {
                    $p->unit_value =  $defaultVariant->unit_value;
                    $p->unit =  $defaultVariant->unit;
                    $p->stock_count =  $defaultVariant->stock_count;
                    $p->retail_price =  $defaultVariant->retail_price;
                    $p->price =  $defaultVariant->price;
                    $p->cost_price =  $defaultVariant->cost_price;
                    $p->variantID =  $defaultVariant->id;
                }
                $variant_id = isset($defaultVariant->id) ? $defaultVariant->id : '';
                $p->totalVariants = count($p->variants);;
                $p->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $p->productID, $variant_id);
            }
        }
        //print_r($related_products); exit;

        $this->data['page_name'] = 'product_detail';
        $this->data['related_products'] = $related_products;
        $this->data['product'] =  $product;
        $this->load->view('index', $this->data);
    }



    /*public function product_search()

{

    if (empty($this->session->userdata('cityID'))) {
        $cityID = 1;
    }else{
        $cityID = $this->session->userdata('cityID');
    }
    if (empty($this->session->userdata('loginUserID'))) {
        $userID = 0;
    }else{
        $userID = $this->session->userdata('loginUserID');
    }
    $search_key = $this->input->post('search_key');

    


    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }


    $no_of_records_per_page = 16;
    $offset = ($pageno-1) * $no_of_records_per_page;



    $select_category = '';


    // $where = '1';

    // $category_array = array();
    // if(empty($search_key)){
    //     redirect('/home');
    // }

    $where = "`in_stock` = 'Y'";
    if(!empty($search_key))

    {

        $where = $where." AND `product_name` LIKE '%$search_key%'";

    }



    if(!empty($select_category))

    {


        $category_array = explode('--', $select_category);

        $where = $where.' AND (';


        foreach($category_array as $c)

        {

            $where = $where.' category_id IN (SELECT categoryID FROM category WHERE `categoryID`='.$c.') OR';

        }

        if(!empty($category_array))

        {

            $where = substr($where, 0, -3);

        }

        $where = $where.' )';

    }



    if(!empty($min_price))

    {

        $where = $where." AND `price` >= '$min_price'";

    }



    if(!empty($max_price))

    {

        $where = $where." AND `price` <= '$max_price' ";

    }
    $count_product = $this->db->query("SELECT * FROM `products` WHERE $where")->result();

    $total_pages_sql = count($count_product);

    $total_pages = ceil($total_pages_sql / $no_of_records_per_page);


    //$products = $this->db->query("SELECT * FROM `products` WHERE $where LIMIT $offset, $no_of_records_per_page")->result();

    $products = $this->db->query("SELECT * FROM `products` WHERE $where")->result();

    

    // $per_page = 15;
    // $count = count($products);
    // $html = '';
    // if($count>$per_page){
    //     $total_page = ceil($count/$per_page);
    //     $html.='<ul class="pagination modal-4"><li><a href="#" class="prev">
    //         <i class="fa fa-chevron-left"></i>
    //         Previous
    //         </a>
    //         </li>';
    //     for($i = 1;$i<=$total_page;$i++){
    //         $html.='

    //         <li><a href="#">'.$i.'</a></li>
    //         ';
    //     }
    //     $html.='<li><a href="#" class="next"> Next 
    //         <i class="fa fa-chevron-right"></i>
    //         </a></li>
    //         </ul>';
    // }else{
    //     $html.='';
    // }

    // $this->data['pagination'] = $html;
    
    


    $product_data = $this->db->query("SELECT MIN(`price`) as min_price, MAX(`price`) as max_price FROM `products` WHERE `product_name` LIKE '%$search_key%' AND 'in_stock'= 'Y'")->row();

    foreach ($products as $p) {
        $p->variants = $this->all_variants($p->productID, $cityID,$userID);
        $defaultVariant = $this->get_default_variant($p->productID, $cityID);
        if(!empty($defaultVariant)){
            $p->unit_value =  $defaultVariant->unit_value;
            $p->unit =  $defaultVariant->unit;
            $p->stock_count =  $defaultVariant->stock_count;
            $p->retail_price =  $defaultVariant->retail_price;
            $p->price =  $defaultVariant->price;
            $p->cost_price =  $defaultVariant->cost_price;
            $p->variantID =  $defaultVariant->id;    
        }
        $p->totalVariants = count($p->variants);    
        $varient_id = isset($defaultVariant->id) ? $defaultVariant->id :'';
        $p->cart_qty = ($userID == 0)?0:$this->get_product_qty_cart($userID,$p->productID,$varient_id);

    }

    //pagination


    $carts = $this->db->query("SELECT * FROM `product_cart` WHERE userID='$userID'")->result();

// print_r($carts);
    //////////End Pagination

    $this->data['carts'] = $carts;

    $this->data['total_pages'] = $total_pages;
    $this->data['pageno'] = $pageno;


    $this->data['page_name'] = 'products_search';

    $this->data['products'] = $products;


    $this->data['product_data'] = $product_data;

    $this->data['search_key'] = $search_key;

    
    $this->data['title'] = 'Products';

    $this->load->view('index',$this->data);





}

*/
    public function product_search()
    {
        if (empty($this->session->userdata('cityID'))) {
            $cityID = 1;
        } else {
            $cityID = $this->session->userdata('cityID');
        }
        if (empty($this->session->userdata('loginUserID'))) {
            $userID = 0;
        } else {
            $userID = $this->session->userdata('loginUserID');
        }
        /*$search_key = $this->input->post('search_key');*/
        $select_brand = (isset($_REQUEST['select_brand']) ? $_REQUEST['select_brand'] : '');
        $search_key = (isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '');
        $min_price = (isset($_REQUEST['min_price']) ? $_REQUEST['min_price'] : '');
        $max_price = (isset($_REQUEST['max_price']) ? $_REQUEST['max_price'] : '');
        $disc_min = (isset($_REQUEST['disc_min']) ? $_REQUEST['disc_min'] : '');
        $disc_max = (isset($_REQUEST['disc_max']) ? $_REQUEST['disc_max'] : '');


        $brand_array = array();
        $where = '1';
        $where1 = "`in_stock` = 'Y'";
        $select_category = '';
        if (!empty($search_key)) {
            $where = $where . " AND `product_name` LIKE '%$search_key%' AND `in_stock` = 'Y'";
        }
        if (!empty($select_category)) {
            $category_array = explode('--', $select_category);
            $where = $where . ' AND (';
            foreach ($category_array as $c) {
                $where = $where . ' category_id IN (SELECT categoryID FROM category WHERE `categoryID`=' . $c . ') OR';
            }
            if (!empty($category_array)) {
                $where = substr($where, 0, -3);
            }
            $where = $where . ' )';
        }
        if (!empty($select_brand)) {
            $brand_array = explode('--', $select_brand);
            $where = $where . ' AND (';
            foreach ($brand_array as $c) {
                $where = $where . ' brand_id IN (SELECT brandID FROM brand WHERE `brandID`=' . $c . ') OR';
            }
            if (!empty($brand_array)) {
                $where = substr($where, 0, -3);
            }
            $where = $where . ' )';
        }
        if (!empty($min_price)) {
            $where = $where . " AND `price` >= '$min_price'";
        }
        if (!empty($max_price)) {
            $where = $where . " AND `price` <= '$max_price' ";
        }
        $count_product = $this->db->query("SELECT * FROM `products` WHERE $where AND in_stock = 'Y'")->result();

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 12;
        $limit = $no_of_records_per_page;
        $offset = ($pageno - 1) * $no_of_records_per_page;
        $total_pages_sql = count($count_product);
        $total_pages = ceil($total_pages_sql / $no_of_records_per_page);


        $products = $this->db->query("SELECT * FROM `products` WHERE $where AND in_stock = 'Y' LIMIT $limit OFFSET  $offset")->result();
        $product_data = $this->db->query("SELECT  MIN(`price`) as min_price, MAX(`price`) as max_price FROM `products_variant`WHERE 'in_stock'= 'Y'")->row();

        foreach ($products as $p) {
            $defaultVariant = $this->get_default_variant($p->productID, $cityID);
            if ($min_price > 0 && $max_price > 0) {
                $defaultVariant = $this->get_default_variant($p->productID, $cityID, $min_price, $max_price);
            }
            $p->variants = $this->all_variants($p->productID, $cityID, $userID);
            if (!empty($defaultVariant)) {
                $p->unit_value =  $defaultVariant->unit_value;
                $p->unit =  $defaultVariant->unit;
                $p->stock_count =  $defaultVariant->stock_count;
                $p->retail_price =  $defaultVariant->retail_price;
                $p->price =  $defaultVariant->price;
                $p->cost_price =  $defaultVariant->cost_price;
                $p->variantID =  $defaultVariant->id;
            }
            $p->totalVariants = count($p->variants);
            $varient_id = isset($defaultVariant->id) ? $defaultVariant->id : '';
            $p->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $p->productID, $varient_id);
        }
        $carts = $this->db->query("SELECT * FROM `product_cart` WHERE userID='$userID'")->result();
        $brands = $this->db->query("SELECT * FROM `brand` WHERE is_active='Y'")->result_array();


        $this->data['carts'] = $carts;
        $this->data['total_pages'] = $total_pages;
        $this->data['pageno'] = $pageno;
        $this->data['page_name'] = 'products_search';
        $this->data['products'] = $products;
        $this->data['brands'] = $brands;
        $this->data['brand_ids'] = $brand_array;
        $this->data['product_data'] = $product_data;
        $this->data['search_key'] = $search_key;
        $this->data['min_price'] = empty($min_price) ? $product_data->min_price : $min_price;
        $this->data['max_price'] = empty($max_price) ? $product_data->max_price : $max_price;
        $this->data['disc_min'] = $disc_min;
        $this->data['disc_max'] = $disc_max;
        $this->data['title'] = 'Products';
        $this->load->view('index', $this->data);
    }
    public function cart()

    {

        $userID = 0;

        if (!empty($_SESSION['loginUserID'])) {

            $userID = $_SESSION['loginUserID'];
        }

        if ($userID != 0) {

            //$cart = $this->db->query("SELECT `product_cart`.*, `products`.`product_name`,`products`.`product_image`,`products`.`price`,`products`.`retail_price` FROM `product_cart` LEFT JOIN `products` ON `product_cart`.`productID` = `products`.`productID` WHERE `userID` = '$userID'")->result();

            $cart = $this->db->query("SELECT `product_cart`.`cartID`, `product_cart`.`productID`,`product_cart`.`variantID`, `product_cart`.`qty`, `products_variant`.`price`, `products_variant`.`retail_price`,`products_variant`.`unit`, `products_variant`.`quantity`,`products_variant`.`variant_image`,`products`.`product_name` FROM `product_cart` LEFT JOIN `products_variant` ON  `product_cart`.`variantID` = `products_variant`.`id` join `products` on `product_cart`.`productID`=`products`.`productID` WHERE `product_cart`.`userID`='$userID'")->result();

            foreach ($cart as $p) {

                //get product name

                // $products = $this->db->query("SELECT * FROM `products` WHERE `productID`=$p->productID")->row();

                // $p->product_name =  $products->product_name;

                $p->price = $this->check_deal($p->productID, $p->price);
            }

            $this->data['page_name'] = 'shopping_cart';

            $this->data['cart'] = $cart;

            $this->data['title'] = 'Cart';

            $this->data['offers'] = $this->home_m->get_all_row_where('offers', array('is_active' => 'Y'));



            $this->data['category'] = $this->home_m->get_category();

            $this->load->view('index', $this->data);
        } else {

            echo 0;
        }
    }

    public function delete_cart()

    {

        $cartID =  $_POST['cartID'];

        if (!empty($cartID)) {

            $this->home_m->delete_data(' product_cart', array('cartID' => $cartID));
            echo json_encode(array('status' => true, 'message' => 'Remove Successfully'));
        } else {
            echo json_encode(array('status' => false, 'message' => 'Something Went wrong'));
        }
    }

    public function remove_cart()

    {

        $cartID =  htmlentities(trim($this->uri->segment(3)));

        if ((int)$cartID) {

            $this->home_m->delete_data(' product_cart', array('cartID' => $cartID));

            $this->session->set_flashdata('success', 'Succesfully Deleted');
        }

        redirect(base_url("home"));
    }





    public function cart_count_total()

    {

        $userID = 27;

        // if (!empty($_SESSION['loginUserID'])){

        //     $userID = $_SESSION['loginUserID'];

        // }

        if ($userID != 0) {

            $this->db->select('sum(qty) as total_qty');

            $cart_count = $this->db->get_where('product_cart', array('userID' => $userID))->row();

            echo $cart_count->total_qty;
        } else {

            echo 0;
        }
    }







    public function add_to_cart()

    {

        $userID = 0;

        if (!empty($_SESSION['loginUserID']) && !empty($this->session->userdata('user_login'))) {

            $userID = $_SESSION['loginUserID'];
        }

        if ($userID != 0) {

            $new_qty = '';
            $productID = $this->input->post('productID');
            $variantID = $this->input->post('variantID');

            $qty = $this->input->post('qty');

            $variantDetail = $this->db->get_where('products_variant', array('id' => $variantID))->row();

            $check = $this->db->get_where('product_cart', array('userID' => $userID, 'productID' => $productID, 'variantID' => $variantID))->row();

            if ($variantDetail->stock_count <= $qty) {

                $new_qty = $variantDetail->stock_count;
            } else {

                $new_qty = $qty;
            }



            if (!empty($check)) {

                $cartID = $check->cartID;

                $insert_array = array(

                    'qty' => $new_qty,

                    'added_on' => date('Y-m-d H:i:s')

                );

                $this->db->where(array('cartID' => $cartID));

                $this->db->update('product_cart', $insert_array);
            } else {

                $insert_array = array(

                    'userID' => $userID,

                    'productID' => $productID,

                    'variantID' => $variantID,

                    'qty' => $new_qty,

                    'added_on' => date('Y-m-d H:i:s')

                );

                $this->db->insert('product_cart', $insert_array);
            }
            $cart_array = array();
            $this->db->select('sum(qty) as total_qty');

            $cart_count = $this->db->get_where('product_cart', array('userID' => $userID))->row();

            //echo $cart_count->total_qty;
            $get_update_qty = $this->db->get_where('product_cart', array('userID' => $userID, 'variantID' => $variantID))->row();

            array_push($cart_array, $cart_count->total_qty);
            array_push($cart_array, $get_update_qty->qty);

            echo json_encode($cart_array);
        } else {

            echo 0;
        }
    }

    public function add_to_cart_type()

    {

        $userID = 0;

        if (!empty($_SESSION['loginUserID'])) {

            $userID = $_SESSION['loginUserID'];
        }

        if ($userID != 0) {

            $new_qty = '';
            $productID = $this->input->post('productID');
            $variantID = $this->input->post('variantID');

            $qty = $this->input->post('qty');
            $type = $this->input->post('type');
            //echo  'qty: '.$qty; exit;

            $variantDetail = $this->db->get_where('products_variant', array('id' => $variantID))->row();

            $check = $this->db->get_where('product_cart', array('userID' => $userID, 'variantID' => $variantID))->row();

            if ($variantDetail->stock_count <= $qty) {

                $new_qty = $variantDetail->stock_count;
            } else {

                $new_qty = $qty;
            }



            if (!empty($check)) {

                $cartID = $check->cartID;
                if ($type == '1') {
                    $insert_array = array(

                        'qty' => $new_qty + 1,

                        'added_on' => date('Y-m-d H:i:s')

                    );
                } else {
                    $insert_array = array(

                        'qty' => $new_qty - 1,

                        'added_on' => date('Y-m-d H:i:s')

                    );
                }



                $this->db->where(array('cartID' => $cartID));

                $this->db->update('product_cart', $insert_array);
            } else {


                $insert_array = array(

                    'userID' => $userID,

                    'productID' => $productID,

                    'variantID' => $variantID,

                    'qty' => $new_qty,

                    'added_on' => date('Y-m-d H:i:s')

                );

                $this->db->insert('product_cart', $insert_array);
            }

            $cart_array = array();

            $this->db->select('sum(qty) as total_qty');
            $cart_count = $this->db->get_where('product_cart', array('userID' => $userID))->row();

            $get_update_qty = $this->db->get_where('product_cart', array('userID' => $userID, 'variantID' => $variantID))->row();

            array_push($cart_array, $cart_count->total_qty);
            array_push($cart_array, $get_update_qty->qty);

            echo json_encode($cart_array);
        } else {

            echo 0;
        }
    }


    public function sub_to_cart()

    {

        $userID = 0;

        if (!empty($_SESSION['loginUserID'])) {

            $userID = $_SESSION['loginUserID'];
        }

        if ($userID != 0) {

            $new_qty = '';

            $variantID = $this->input->post('variantID');

            $qty = $this->input->post('qty');

            $check = $this->db->get_where('product_cart', array('userID' => $userID, 'variantID' => $variantID))->row();

            $product_stock = $this->db->get_where('products_variant', array('id' => $variantID))->row();

            $productID = $product_stock->product_id;



            if ($product_stock->stock_count <= $qty) {

                $new_qty = $product_stock->stock_count;
            } else {

                $new_qty = $qty - 1;
            }



            if (!empty($check)) {

                $cartID = $check->cartID;

                $insert_array = array(

                    'qty' => $new_qty,

                    'added_on' => date('Y-m-d H:i:s')

                );

                $this->db->where(array('cartID' => $cartID));

                $this->db->update('product_cart', $insert_array);
            }

            $this->db->select('sum(qty) as total_qty');

            $cart_count = $this->db->get_where('product_cart', array('userID' => $userID))->row();

            echo $cart_count->total_qty;
        } else {

            echo 0;
        }

        $this->home_m->delete_data('product_cart', array('qty' => 0));
    }



    public function add_to_cart_re1()

    {

        $userID = 0;

        if (!empty($_SESSION['loginUserID'])) {

            $userID = $_SESSION['loginUserID'];
        }

        if ($userID != 0) {

            $productID = $this->input->post('productID');

            $qty = $this->input->post('qty');

            $variantID = $this->input->post('variantID');

            $check = $this->db->get_where('product_cart', array('userID' => $userID, 'productID' => $productID))->row();

            $product_stock = $this->db->get_where('products', array('productID' => $productID))->row();

            if ($product_stock->stock_count <= $qty) {

                $new_qty = $product_stock->stock_count;
            } else {

                $new_qty = $qty;
            }



            if (!empty($check)) {

                $cartID = $check->cartID;

                $insert_array = array(

                    'qty' => $new_qty,

                    'variantID' => $variantID,

                    'added_on' => date('Y-m-d H:i:s')

                );

                $this->db->where(array('cartID' => $cartID));

                $this->db->update('product_cart', $insert_array);
            } else {

                $insert_array = array(

                    'userID' => $userID,

                    'productID' => $productID,

                    'qty' => $new_qty,

                    'variantID' => $variantID,

                    'added_on' => date('Y-m-d H:i:s')

                );

                $this->db->insert('product_cart', $insert_array);
            }

            $this->db->select('sum(qty) as total_qty');

            $cart_count = $this->db->get_where('product_cart', array('userID' => $userID))->row();

            echo $cart_count->total_qty;
        } else {

            echo 0;
        }
    }

    public function delete_checkout_cart()

    {

        $cartID =  htmlentities(trim($this->uri->segment(3)));

        if ((int)$cartID) {

            $this->home_m->delete_data(' product_cart', array('cartID' => $cartID));

            $this->session->set_flashdata('success', 'Succesfully Deleted');
        }

        redirect(base_url("home/checkout"));
    }



    public function apply_coupon_old()

    {



        $userID = $_SESSION['loginUserID'];

        $offer_code = strtoupper($_POST['offer_code']);

        $id = $_POST['id'];

        $carts = $this->db->query("SELECT `users`.`ID` as userID, COALESCE(SUM(`qty`),0) as items FROM `product_cart` LEFT JOIN `users` ON `product_cart`.`userID` = `users`.`ID` WHERE `product_cart`.`userID`='$userID'")->row();

        if (!empty($carts)) {

            $cart_products = $this->db->query("SELECT `product_cart`.`cartID`, `product_cart`.`productID`, `product_cart`.`qty`, `products`.`price`, `products`.`retail_price`, `products`.`product_image`, `products`.`product_name` FROM `product_cart` LEFT JOIN `products` ON  `product_cart`.`productID` = `products`.`productID` WHERE `product_cart`.`userID`='$userID'")->result();

            $carts->products = $cart_products;
        }

        $order_amount = 0;

        $total_qty = 0;

        foreach ($carts->products as $p) {

            $total_qty += $p->qty;

            $order_amount += $p->qty * $p->price;
        }

        $total_amount = $order_amount - $coupon_discount;



        $cart_amount = $total_amount;

        $d = date('Y-m-d');

        //also check date 

        $get_coupon = $this->db->query("SELECT * FROM `offers` WHERE `offer_code`='$offer_code' AND `is_active`='Y' AND date(`start_date`) <= '$d' AND date(`end_date`) >= '$d'")->row();



        if (!empty($get_coupon)) {



            if ($get_coupon->allowed_user_times == 0) {

                if ($cart_amount >= $get_coupon->min_cart_value) {

                    if ($get_coupon->offer_type == 'FIXED') {

                        $discount_amt = $get_coupon->offer_value;
                    } else {

                        $amt = ceil($get_coupon->offer_value * ($cart_amount / 100));

                        if ($amt > $get_coupon->max_discount) {

                            $discount_amt = $get_coupon->max_discount;
                        } else {

                            $discount_amt = $amt;
                        }
                    }

                    $couponData = array(

                        'coupon_code' => $offer_code,

                        'discount_amt' => $discount_amt

                    );

                    $this->session->set_userdata($couponData);



                    echo 1;
                } else {

                    echo 2;
                }
            } else {

                $check = $this->home_m->get_all_row_where('orders', array('userID' => $userID, 'coupon_code' => $offer_code));

                if (sizeof($check) < $get_coupon->allowed_user_times) {

                    if ($cart_amount >= $get_coupon->min_cart_value) {

                        echo 1;
                    } else {

                        echo 2;
                    }
                } else {

                    echo 0;
                }
            }
        } else {

            echo 0;
        }
    }

    public function remove_coupon()

    {



        unset($_SESSION['coupon_code']);

        unset($_SESSION['discount_amt']);

        echo "success";
    }





    public function product_details($productID)

    {

        //echo $productID;exit();

        $product_variant = '';

        if (empty($this->session->userdata('loginUserID'))) {

            $userID = 0;
        } else {

            $userID = $this->session->userdata('loginUserID');
        }

        // $productID = $this->uri->segment(3);

        $products = $this->db->get_where('products', array('productID' => $productID))->row();



        $variants = $this->db->query("select * from products_variant where is_default='1' AND product_id='$products->productID'")->row();

        $variantID =  $variants->id;



        $sql = "SELECT * FROM `products` WHERE `productID`!='$productID'AND `in_stock` = 'Y' AND (";

        $cat = explode(',', $products->category_id);

        if (!empty($cat)) {

            foreach ($cat as $c) {

                $sql .= " FIND_IN_SET($c,`category_id`) OR ";
            }

            $sql = substr($sql, 0, -3);
        } else {

            $sql .= " 1";
        }

        $sql .= " )";
        $related_products = $this->db->query($sql)->result();

        //add favourite

        foreach ($related_products as $p) {

            $query = $this->db->query("SELECT * FROM wish_list where userID = '$userID' AND productID = '$p->productID'");

            if ($query->num_rows() >= 1) {

                $p->favourite = 'Y';
            } else {

                $p->favourite = 'N';
            }



            //cart qty

            $variants = $this->db->query("select * from products_variant where is_default='1' AND product_id='$p->productID'")->row();

            $r_variantID =  $variants->id;

            $p->cart_qty = $this->get_product_qty_cart($userID, $p->productID, $r_variantID);
        }



        //$related_products = $this->db->query("SELECT * FROM `products` WHERE `category_id`='$products->category_id' AND `productID`!='$productID'AND `in_stock` = 'Y'")->result();

        //$product_variant = $this->db->query("SELECT * FROM `products_variant` WHERE `product_id`='$productID'")->result();

        if (!empty($this->session->userdata('loginUserID'))) {

            $cityID = $this->session->userdata('cityID');

            $product_variant = $this->db->query("select products_detail.*,products_variant.product_id as productID,products_variant.variant_image,products_variant.quantity,products_variant.unit from products_detail inner join products_variant on products_detail.variant_id=products_variant.id where products_detail.city_id='$cityID' and products_detail.product_id='$productID' GROUP by products_detail.variant_id ORDER BY products_detail.product_id")->result();
        } else {

            $product_variant = $this->db->query("select id as variant_id,retail_price,price,quantity,unit,stock_count,cost_price,variant_image from products_variant where product_id='$productID'")->result();
        }

        $products->cart_qty = $this->get_product_qty_cart($userID, $products->productID, $variantID);

        $this->data['product'] = $products;

        $this->data['product_variant'] = $product_variant; //new

        $this->data['related_products'] = $related_products;

        $this->data['title'] = 'Product Detail';

        $this->data['page_name'] = 'product_details';

        $this->data['category'] = $this->home_m->get_category();

        $this->load->view('index', $this->data);
    }

    public function get_product_qty_cart($userID, $productID, $variantID)

    {
        //echo 'p: '.$productID.'V:'.$variantID; exit;
        $sql = "SELECT * FROM `product_cart` WHERE `userID`='$userID'";
        if (!empty($productID)) {
            $sql .= " AND `productID`='$productID'";
        }
        if (!empty($variantID)) {
            $sql .= " AND `variantID` = '$variantID'";
        }

        $query = $this->db->query($sql)->row();
        //print_r($query); exit;
        if (empty($query)) {

            return 0;
        }

        return $query->qty;
    }



    //new function

    public function get_product_qty_cart_new()

    {
        $new_data = array();
        $qty = '0';
        $userID =  $_POST['userID'];

        $productID =  $_POST['productID'];

        $variantID =  $_POST['variantID'];

        $query = $this->db->query("SELECT * FROM `product_cart` WHERE `userID`='$userID' AND `productID`='$productID' AND `variantID` = '$variantID' ")->row();

        $variantDetail = $this->db->query("SELECT * FROM `products_variant` WHERE  `id` = '$variantID' AND `status`='Y' ")->row();

        if (empty($query)) {

            //echo 
            $qty = '0';
        } else {
            $qty =  $query->qty;
            //echo  $query->qty;
        }

        if (!empty($variantDetail)) {
            $variantDetail->qty = $qty;
            echo json_encode($variantDetail);

            //$array_push($new_data)

        }
    }



    public function myorders($userID)

    {

        $orders = $this->home_m->get_all_table_query("SELECT `orderID`, `location`, DATE_FORMAT(DATE(`delivery_date`),'%d-%M-%Y') as delivery_date, `delivery_slot`, `status`, DATE_FORMAT(`added_on`,'%d-%M-%Y') as order_at, `total_amount` FROM `orders` WHERE `userID`='$userID' order by `orderID` DESC");

        foreach ($orders as $o) {

            $order_products = $this->get_ordered_products($o->orderID, $o->total_amount, $o->status, $o->order_at);

            foreach ($order_products as $product) {

                $ordered_products[] = $product;
            }
        }

        return json_encode($orders);
    }

    public function profile()
    {


        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }

        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {
            $userID = $_SESSION['loginUserID'];
            $this->data['myprofile'] =   $this->my_profile($userID);

            $this->data['orders'] = $this->home_m->get_all_row_where('orders', array('userID' => $userID), $select = '*');
            $this->data['addresses'] = $this->home_m->get_all_row_where('user_address', array('userID' => $userID), $select = '*');
            $this->data['page_name'] = 'profile';
            $this->data['title'] = 'My Account';
            $this->load->view('index', $this->data);
        } else {

            $this->index();
        }
    }

    public function order()

    {
        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {
            $userID = $_SESSION['loginUserID'];
            $this->data['myprofile'] = $this->my_profile($userID);

            $this->db->order_by("orderID", "desc");
            $this->data['orders'] = $this->home_m->get_all_row_where('orders', array('userID' => $userID), $select = '*');
            $this->data['page_name'] = 'my_orders';
            $this->data['title'] = 'My Orders';
            $this->load->view('index', $this->data);
        } else {
            $this->index();
        }
    }


    //order details

    public function order_detail($orderID = '')

    {

        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            $userID = $_SESSION['loginUserID'];

            if ($orderID != '') {

                $this->db->select('orders.*,delivery_agent.name as agent_name,delivery_agent.phone as agent_phone,delivery_agent.email as agent_email,delivery_agent.alternate_phone as agent_alternate_number');

                $this->db->join('delivery_agent', 'orders.agentID = delivery_agent.delivery_agentID', 'LEFT');

                $order_info = $this->db->get_where('orders', array('orderID' => $orderID))->row();

                if (!empty($order_info)) {

                    $user_info = $this->db->get_where('users', array('ID' => $order_info->userID))->row();

                    $this->db->select('order_items.*,products.product_name,products_variant.quantity as unit_value,products_variant.unit,products.product_image,products.category_id as product_categories,brand.brand as brand_name');

                    $this->db->join('products', 'order_items.productID = products.productID', 'LEFT');

                    $this->db->join('products_variant', 'order_items.variantID = products_variant.id', 'LEFT');

                    $this->db->join('brand', 'products.brand_id = brand.brandID', 'LEFT');

                    $order_items = $this->db->get_where('order_items', array('orderID' => $orderID))->result();

                    foreach ($order_items as $ot) {

                        $ot->category_name = $this->get_subcategory_name($ot->product_categories);
                    }

                    $this->data['user'] = $user_info;

                    $this->data['order'] = $order_info;

                    $this->data['order_items'] = $order_items;

                    $this->data['myprofile'] = $this->my_profile($userID);

                    $this->data['orders'] = $this->my_orders($userID);

                    $this->data['orders'] = $this->home_m->get_all_row_where('orders', array('userID' => $userID), $select = '*');

                    $this->data['page_name'] = 'order_detail';

                    $this->data['title'] = 'order_detail';

                    $this->load->view('index', $this->data);
                }
            }
        } else {

            $this->index();
        }
    }



    private function get_subcategory_name($categories)

    {

        $category = $this->db->query("SELECT title FROM `category` WHERE `categoryID` IN ($categories)")->result();

        $category_array = array();

        foreach ($category as $c) {

            $category_array[] = $c->title;
        }

        return implode('<br>', $category_array);
    }



    //order details end

    public function address()
    {

        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }

        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            $userID = $_SESSION['loginUserID'];

            $this->data['myprofile'] = $this->my_profile($userID);

            $this->data['addresses'] = $this->home_m->get_all_row_where('user_address', array('userID' => $userID), $select = '*');

            //$this->data['category'] = $this->home_m->get_category();

            $this->data['page_name'] = 'address';

            $this->data['title'] = 'My Address';

            $this->load->view('index', $this->data);
        } else {

            $this->index();
        }
    }

    //edit address
    public function edit_address()
    {
        $addressID =  $this->uri->segment(3);
        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            if ($_POST) {
                $update_array = $_POST;

                $userID = $_SESSION['loginUserID'];

                $update_array['userID'] = $userID;
                $pincode = $_POST['pincode'];
                $check = $this->db->get_where('locality', array('pin' => $pincode, 'status' => 'Y'))->row();
                if (!empty($check)) {
                    $update_array['added_on'] = date("Y-m-d H:i:s");
                    $this->db->where(array('addressID' => $addressID));
                    $this->db->update('user_address', $update_array);
                    if ($_GET) {

                        $url = $_GET['url'];

                        redirect(base_url("home/$url"));
                    } else {

                        redirect(base_url("home/profile"));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Currently !! We are not serving in that location.');
                    redirect(base_url("home/edit_address/" . $addressID));
                }
            } else {
                $address = $this->db->query("select * from user_address where addressID='$addressID'")->row();
                $this->data['address'] = $address;
                $this->data['page_name'] = 'edit_address';
                $this->data['title'] = 'Edit Address';
                $this->data['category'] = $this->home_m->get_category();
                $this->load->view('index', $this->data);
            }
        } else {
            $this->index();
        }
    }

    public function address_delete()
    {
        $addressId = $_POST['addressId'];
        $this->db->where(array('addressId' => $addressId));
        $this->db->delete('user_address');
        echo "success";
    }

    public function check_pincode()
    {
        $pincode = $_POST['pincode'];
        $check = $this->db->get_where('locality', array('pin' => $pincode, 'status' => 'Y'))->row();
        if (empty($check)) {
            echo "Currently !! We are not serving in that location.";
        } else {
            echo '';
        }
    }

    private function my_profile($userID)

    {

        $user_info = $this->db->get_where('users', array('ID' => $userID))->row_array();

        return $user_info;
    }

    private function my_orders($userID)

    {

        $orders = $this->home_m->get_all_table_query("SELECT  *, `orderID`, `location`, DATE_FORMAT(DATE(`delivery_date`),'%d-%M-%Y') as delivery_date, `delivery_slot`, `status`, DATE_FORMAT(`added_on`,'%d-%M-%Y') as order_at, `total_amount` FROM `orders` WHERE `userID`='$userID' order by `orderID` DESC");

        $this->data['quantity'] = $this->home_m->get_all_table_query("SELECT orders.orderID, order_items.qty FROM order_items INNER JOIN orders");



        return $orders;
    }

    public function validate_coupon()

    {

        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {
            $userID = $_SESSION['loginUserID'];
            $couponID = $_POST['couponID'];
            $cart_value = $_POST['cart_value'];
            $coupon_info = $this->db->get_where('offers', array('offerID' => $couponID, 'is_active' => 'Y'))->row();



            if (!empty($coupon_info) && $cart_value >= $coupon_info->min_cart_value) {

                $today = strtotime(date("Y-m-d"));

                $start_date = strtotime($coupon_info->start_date);

                $end_date = strtotime($coupon_info->end_date);

                if ($today >= $start_date && $today <= $end_date) {

                    if ($coupon_info->allowed_user_times > 0) {

                        $this->db->select("count(*) as count");

                        $coupon_count = $this->db->get_where('orders', array('userID' => $userID, 'coupon_code' => $coupon_info->offer_code))->row();

                        if ($coupon_count->count < $coupon_info->allowed_user_times) {

                            if ($coupon_info->offer_type == 'FIXED') {
                                $dis = $coupon_info->offer_value;
                            } elseif ($coupon_info->offer_type == 'PERCENTAGE') {
                                $dis = ($coupon_info->offer_value * $cart_value) / 100;
                                if ($dis > $coupon_info->max_discount) {
                                    $dis = $coupon_info->max_discount;
                                }
                            } else {
                                $dis = $coupon_info->offer_value;
                            }
                            $_SESSION['coupon_code'] = $coupon_info->offer_code;
                            $_SESSION['discount_amt'] = $dis;
                            $result = array('result' => 'success', 'dis' => $dis, 'coupon_code' => $coupon_info->offer_code);
                        } else {

                            $result = array('result' => 'failure', 'dis' => 0);
                        }
                    } else {

                        if ($coupon_info->offer_type == 'FIXED') {

                            $dis = $coupon_info->offer_value;
                        } else {

                            $dis = ($coupon_info->offer_value * $cart_value) / 100;

                            if ($dis > $coupon_info->max_discount) {

                                $dis = $coupon_info->max_discount;
                            }
                        }
                        $_SESSION['coupon_code'] = $coupon_info->offer_code;
                        $_SESSION['discount_amt'] = $dis;
                        $result = array('result' => 'success', 'dis' => $dis, 'coupon_code' => $coupon_info->offer_code);
                    }
                } else {
                    $result = array('result' => 'failure', 'dis' => 0);
                }
            } else {
                $result = array('result' => 'failure', 'dis' => 0);
            }
        } else {

            $result = array('result' => 'failure', 'dis' => 0);
        }

        echo json_encode($result);
    }

    public function add_address_old()

    {

        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            if ($_POST) {

                $insert = $_POST;

                $userID = $_SESSION['loginUserID'];

                $insert['userID'] = $userID;
                $pincode = $_POST['pincode'];
                $check = $this->db->get_where('locality', array('pin' => $pincode, 'status' => 'Y'))->row();
                if (!empty($check)) {
                    $insert['added_on'] = date("Y-m-d H:i:s");

                    $this->db->insert('user_address', $insert);

                    if ($_GET) {

                        $url = $_GET['url'];

                        redirect(base_url("home/$url"));
                    } else {

                        redirect(base_url("home/profile"));
                    }
                } else {
                    $this->session->set_flashdata('message', 'Currently !! We are not serving in that location.');
                    redirect(base_url("home/add_address"));
                }
            } else {

                $this->data['page_name'] = 'add_address';

                $this->data['title'] = 'Add Address';

                $this->data['category'] = $this->home_m->get_category();

                $this->load->view('index', $this->data);
            }
        } else {

            $this->index();
        }
    }

    public function checkout_old()

    {

        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            $userID = $_SESSION['loginUserID'];

            $carts = $this->home_m->get_single_table_query("SELECT `users`.`ID` as userID, COALESCE(SUM(`qty`),0) as items FROM `product_cart` LEFT JOIN `users` ON `product_cart`.`userID` = `users`.`ID` WHERE `product_cart`.`userID`='$userID'");

            //print_r($carts); exit;

            if (!empty($carts)) {

                $carts->products = $this->cart_products($userID);
            }

            $today = date("Y-m-d");

            //echo $today; exit;



            $this->data['myprofile'] = $this->my_profile($userID);

            $this->data['addresses'] = $this->home_m->get_all_row_where('user_address', array('userID' => $userID), $select = '*');

            $this->data['offers'] = $this->home_m->get_all_table_query("SELECT * FROM `offers` WHERE date(`start_date`) <= '$today' AND date(`end_date`) >= '$today' AND `is_active` = 'Y'");

            //print_r($this->data['offers']); exit;

            $this->data['cart'] = $carts;

            $this->data['title'] = 'Checkout';

            $this->data['page_name'] = 'checkout';

            $this->load->view('index', $this->data);
        } else {

            redirect('home');
        }
    }

    private function cart_products($userID)

    {

        // $query = $this->home_m->get_all_table_query("SELECT `product_cart`.`cartID`, `product_cart`.`productID`, `product_cart`.`qty`, `products`.`price`, `products`.`retail_price`, `products`.`product_image`, `products`.`product_name` FROM `product_cart` LEFT JOIN `products` ON  `product_cart`.`productID` = `products`.`productID` WHERE `product_cart`.`userID`='$userID'");

        $query = $this->home_m->get_all_table_query("SELECT `product_cart`.`cartID`, `product_cart`.`productID`, `product_cart`.`variantID`, `product_cart`.`qty`, `products_variant`.`price`, `products_variant`.`retail_price`, `products_variant`.`variant_image` FROM `product_cart` LEFT JOIN `products_variant` ON  `product_cart`.`variantID` = `products_variant`.`id` WHERE `product_cart`.`userID`='$userID'");

        foreach ($query as $p) {

            //get product name

            $products = $this->db->query("SELECT * FROM `products` WHERE `productID`=$p->productID")->row();

            $p->product_name =  $products->product_name;

            $p->price = $this->check_deal($p->productID, $p->price);
        }

        return $query;
    }

    private function get_curl_handle($payment_id, $amount)
    {

        $url = 'https://api.razorpay.com/v1/payments/' . $payment_id . '/capture';

        $key_id = "rzp_live_yo1Zk1DpWMFtWZ";

        $key_secret = "APvHyUDzKYf6UcxkAmwNqbE4";

        // $key_id = "rzp_test_LZtPoi5XGtLWlT";
        // $key_secret = "ih3W6ZeEYJEz2j3IUCaMABjt";

        $fields_string = "amount=$amount";

        //cURL Request

        $ch = curl_init();

        //set the url, number of POST vars, POST data

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);

        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/ca-bundle.crt');

        return $ch;
    }

    public function place_order_old()

    {

        $orderID = 0;

        if ($_POST) {

            $payment_method = $_POST['payment_method'];

            $razorpay_num = $_POST['razorpay_num'];

            $delivery_date = $_POST['delivery_date'];

            $slot = $_POST['slot'];

            $addressID = $_POST['addressID'];

            $cart_checkout_notes = json_decode($_POST['cart_checkout_notes'], true);

            $userID = $cart_checkout_notes['user'];

            $cart_items = $cart_checkout_notes['items'];

            $cart_amount = $_POST['cart_amount'];

            $coupon_code = $_POST['coupon_code'];

            $coupon_disc = $_POST['coupon_disc'];

            $delivery_charges = $_POST['delivery_charges'];

            //check cash back
            $cashBack_amount = '';
            if ($coupon_disc != '0.00') {
                $cashBack_amount = '0.00';
            } else {
                $cashBack_amount = $_POST['cashBack_amount'];
            }

            $payable_amount = $_POST['payable_amount'];

            $sub_total_amount = $cart_amount + $delivery_charges - $coupon_disc;

            $user_info = $this->db->get_where("users", array('ID' => $userID))->row();

            $user_wallet = $user_info->wallet;

            $success = true;

            if ($payment_method == 'online' && $payable_amount > 0) {

                $success = false;

                $error = '';

                try {

                    $ch = $this->get_curl_handle($razorpay_num, $payable_amount * 100);

                    //execute post

                    $result = curl_exec($ch);

                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    if ($result === false) {

                        $success = false;

                        $error = 'Curl error: ' . curl_error($ch);
                    } else {

                        $txn_description = $result;

                        $response_array = json_decode($result, true);

                        if ($http_status === 200 and isset($response_array['error']) === false) {

                            $success = true;
                        } else {

                            $success = false;

                            if (!empty($response_array['error']['code'])) {

                                $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
                            } else {

                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
                            }
                        }
                    }

                    //close connection

                    curl_close($ch);
                } catch (Exception $e) {

                    $success = false;
                }

                if ($success === true) {

                    $txn_insert_array = array(

                        "userID" => $userID,

                        "txn_no" => $razorpay_num,

                        "amount" => $payable_amount,

                        "type" => 'CREDIT',

                        "against_for" => 'wallet',

                        "paid_by" => 'online',

                        "orderID" => 0,

                        "transaction_at" => date("Y-m-d H:i:s")

                    );

                    $this->db->insert('transactions', $txn_insert_array);

                    $user_wallet += $payable_amount;

                    $this->db->where(array('ID' => $userID));

                    $this->db->update('users', array('wallet' => $user_wallet));
                }
            }

            if ($success === true) {

                $address = $this->db->get_where("user_address", array('addressID' => $addressID))->row();

                //get cityid

                $pinCode = $address->pincode;

                $city_detail = $this->db->query("select city.id,city.title as cityName,locality.locality from city join locality on city.id = locality.locality WHERE locality.status='Y' and locality.pin = '$pinCode'")->row();

                //$city_detail = $this->webservice_m->get_single_table_query(" select * from locality where pin = '$pinCode'");

                //print_r($city_detail); exit;



                // $cityID = $city_detail->locality;

                $cityID = 1;

                //echo $cityID; exit;

                $order_insert = array(

                    "userID" => $userID,

                    "cityID" => $cityID,

                    "customer_name" => $address->contact_person_name,

                    "contact_no" => $address->contact_person_mobile,

                    "house_no" => $address->flat_no,

                    "apartment" => $address->building_name,

                    "landmark" => $address->landmark,

                    "location" => $address->location,

                    'latitude' => $address->latitude,

                    "longitude" => $address->longitude,

                    "address_type" => $address->address_type,

                    "agentID" => 0,

                    "coupon_code" => $coupon_code,

                    "coupon_discount" => $coupon_disc,

                    "delivery_charges" => $delivery_charges,

                    "order_amount" => $cart_amount,

                    "total_amount" => $sub_total_amount,

                    "cashback_amount" => $cashBack_amount,

                    "payment_method" => $payment_method,

                    "instruction" => '',

                    "delivery_date" => date("Y-m-d", strtotime($delivery_date)),

                    "delivery_slot" => $slot,

                    "status" => "PLACED",

                    "added_on" => date("Y-m-d H:i:s"),

                    "updated_on" => date("Y-m-d H:i:s")

                );

                $this->db->insert('orders', $order_insert);

                $orderID = $this->db->insert_id();

                //update user cashback

                $this->db->where(array('ID' => $userID));

                $this->db->update('users', array('cashback_wallet' => $user_info->cashback_wallet + $cashBack_amount));



                foreach ($cart_items as $items) {

                    $insert_array_cart = array(

                        "orderID" => $orderID,

                        "productID" => $items['productID'],

                        "variantID" => $items['variantID'],

                        "qty" => $items['qty'],

                        "price" => $items['price'],

                        "net_price" => $items['qty'] * $items['price'],

                        "status" => 'PLACED',

                        "added_on" => date("Y-m-d H:i:s"),

                        "updated_on" => date("Y-m-d H:i:s")

                    );

                    $this->db->insert('order_items', $insert_array_cart);

                    $itemID = $this->db->insert_id();

                    $order_status_array = array(

                        "itemID" => $itemID,

                        "orderID" => $orderID,

                        "agentID" => 0,

                        "is_visible" => 'Y',

                        "status" => 'PLACED',

                        "added_on" => date("Y-m-d H:i:s")

                    );

                    $this->db->insert('order_status', $order_status_array);
                }

                if ($payment_method == 'online') {

                    $txn_insert_array = array(

                        "userID" => $userID,

                        "txn_no" => $razorpay_num,

                        "amount" => $sub_total_amount,

                        "type" => 'DEBIT',

                        "against_for" => 'order',

                        "paid_by" => 'wallet',

                        "orderID" => 0,

                        "transaction_at" => date("Y-m-d H:i:s")

                    );

                    $this->db->insert('transactions', $txn_insert_array);

                    $user_wallet -= $sub_total_amount;

                    $this->db->where(array('ID' => $userID));

                    $this->db->update('users', array('wallet' => $user_wallet));
                }

                //wallet payment method
                if ($payment_method == 'wallet') {
                    $user_wallet -= $sub_total_amount;
                    $this->db->where(array('ID' => $userID));
                    $this->db->update('users', array('wallet' => $user_wallet));
                }

                $this->db->where(array('userID' => $userID));

                $this->db->delete('product_cart');

                $response = array('result' => 'success', 'msg' => 'Your Order Has been successfully Placed with orderID #' . $orderID);
            } else {

                $response = array('result' => 'failure', 'msg' => 'Sorry ! There is an error while placing your order. Please Try Again Later');
            }
        } else {

            $response = array('result' => 'failure', 'msg' => 'Something Went Wrong. Please Try Again Later');
        }

        echo json_encode($response);
    }

    public function order_summary($param1 = '', $param2 = '')

    {

        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '' && $param1 != '' && $param2 != '' && $param2 == md5($param1)) {

            $select = "orders.orderID,orders.customer_name,orders.contact_no,orders.house_no,orders.apartment,orders.landmark,orders.location,orders.latitude,orders.longitude,orders.address_type,orders.agentID,orders.coupon_code,orders.coupon_discount,orders.order_amount,orders.total_amount,orders.payment_method,orders.instruction,orders.delivery_date,orders.delivery_slot,orders.status,orders.added_on,users.name as user";

            $join = array();

            $join[] = array(

                'table' => 'users',

                'parameter' => 'orders.userID = users.ID',

                'position' => 'LEFT'

            );

            $join[] = array(

                'table' => 'users as user',

                'parameter' => 'orders.userID = users.ID',

                'position' => 'LEFT'

            );

            $this->data['order_info'] = $this->home_m->get_single_row_where_join('orders', array('orderID' => $param1), $join, $select);

            $select = "order_items.*,products.product_name";

            $join = array();

            $join[] = array(

                'table' => 'products',

                'parameter' => 'order_items.productID = products.productID',

                'position' => 'LEFT'

            );

            $this->data['orders'] = $this->home_m->get_all_row_where_join('order_items', array('orderID' => $param1), $join, $select);

            $this->data['title'] = 'Order Summary';

            $this->data['page_name'] = 'orders';

            $this->load->view('index', $this->data);
        } else {

            $this->index();
        }
    }




    public function get_slot($booking_date, $cityID)
    {
        $curl = curl_init();

        // ,$cityID='5'
        $data = array(
            'booking_date' => $booking_date,
            'cityID' => $cityID,
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gowisekart.com/webservice/slot',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),

            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Cookie: ci_session=ql9k7r6ii5bhpk8u4smq7c9e8hpbasbe'
            ),
        ));

        $response = curl_exec($curl);

        //curl_close($curl);
        return json_decode($response);
        // echo json_decode($response);
    }




    public function getProductName()
    {



        $ch = $this->input->post('onechar');

        $products = $this->db->query("SELECT * FROM products WHERE product_name LIKE '$ch%'AND `in_stock` = 'Y'")->result();

        echo json_encode($products);
    }

    //purchase plan
    // public function purchase_membership(){
    //     $orderID='1';
    //     $response = array('result'=>'success','msg'=>'Your Order Has been successfully Placed with orderID #'.$orderID);
    //     echo json_encode($response);
    // }

    public function slot()
    {
        $date = date("d-m-Y", strtotime($this->input->post('booking_date')));


        $cityID = 5;
        $response = array();
        $booking_date = $date;
        $cityID = '5';
        $slot1 =  $this->get_slot($booking_date, $cityID);
        $html = '';
        //print_r($slot1);
        //$slot1 = json_decode($data);
        $slot_time = '';
        if (!empty($slot1)) {

            foreach ($slot1 as $slo) {
                //$slot_time = isset($slo->slot[0]['period']) ? $slo->slot[0]['period'] :'';

                $xyz = 1;
                foreach ($slo->slot as $slottt) {
                    $check = '';
                    if ($xyz == 1) {
                        $check = 'checked';
                        $slot_time = isset($slottt->period) ? $slottt->period : '';
                    }
                    $html .= '<div class="radio mb-10 option_chosse">
        <label >
        <input class="mr-3"  type="radio" ' . $check . ' onchange="getValue(this)" value="' . $slottt->period . '" name="slot_time" id="slot_time">' . $slottt->period . '</label>
        </div>';
                    ++$xyz;
                }
            }
            $response[] = array('status' => true, 'slot' => $slot1, 'html' => $html, 'date' => $date, 'slot_time' => $slot_time);
        } else {

            $html .= '<p>No Slot Available</p>';

            $response[] = array('status' => true, 'slot' => array(), 'html' => $html, 'date' => $date, 'slot_time' => '');
        }





        // $html = '';
        // $slot_time = isset($slot1[0]['period']) ? $slot1[0]['period'] :'';
        //    if(!empty($slot1)){
        //        $xyz=1;
        //        foreach($slot1 as $slo){
        //            $check = '';

        //            if($xyz==1){
        //                $check = 'checked';
        //            }

        //            $html.='<div class="radio mb-10 option_chosse">
        //            <label >
        //            <input class="mr-3"  type="radio" '.$check.' onchange="getValue(this)" value="'.$slo['period'].'" name="slot_time" id="slot_time">'.$slo['period'].'</label>
        //            </div>';
        //            ++$xyz;
        //        }
        //    }



        //    $response[] = array('status'=>true, 'slot'=>$slot1,'html'=>$html,'date'=>$date,'slot_time'=>$slot_time);




        //print_r($slots);


        echo json_encode($response);
    }



    private function check_slot_availabilty($s, $cityID, $d, $max_order)

    {

        $sql = $this->db->query("SELECT COALESCE(COUNT(*),0) as order_count FROM `orders` WHERE `cityID`='$cityID' AND `delivery_slot`='$s' AND `delivery_date`='$d'")->row();



        return $max_order - $sql->order_count;
    }


    public function slot_old()



    {


        $html = '';
        $date = date("Y-m-d", strtotime($this->input->post('booking_date')));
        //echo $date;
        //$date = '2021-04-04';          

        $time = date("H:i:s");



        $this->load->model("time_model");



        $time_slot = $this->time_model->get_time_slot();



        $cloasing_hours =  $this->time_model->get_closing_hours($date);



        $begin = new DateTime($time_slot->opening_time);



        $end   = new DateTime($time_slot->closing_time);



        $interval = DateInterval::createFromDateString($time_slot->time_slot . ' min');



        $times    = new DatePeriod($begin, $interval, $end);



        $time_array = array();



        foreach ($times as $time) {

            if (!empty($cloasing_hours)) {

                foreach ($cloasing_hours as $c_hr) {

                    if ($date == date("Y-m-d")) {

                        if (strtotime($time->format('h:i A')) > strtotime(date("h:i A")) &&  strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time)) {
                        } else {

                            $t1 = $time->format('h:i A') . ' - ' .

                                $time->add($interval)->format('h:i A');

                            $time_array[] =  $time->format('h:i A') . ' - ' .

                                $time->add($interval)->format('h:i A');
                        }
                    } else {

                        if (strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time)) {
                        } else {

                            $t1 = $time->format('h:i A') . ' - ' .

                                $time->add($interval)->format('h:i A');

                            $time_array[] =  $time->format('h:i A') . ' - ' .

                                $time->add($interval)->format('h:i A');
                        }
                    }

                    $slot[] = array(

                        'period' => $t1,

                        'available' => '1',

                        "delivery_price" => '30'

                    );
                }
            } else {

                if (strtotime($date) == strtotime(date("Y-m-d"))) {

                    if (strtotime($time->format('h:i A')) > strtotime(date("h:i A"))) {

                        $t1 =  $time->format('h:i A') . ' - ' . $time->add($interval)->format('h:i A');

                        $time_array[] =  $time->format('h:i A') . ' - ' . $time->add($interval)->format('h:i A');

                        $slot[] = array(

                            'period' => $t1,

                            'available' => '1',

                            "delivery_price" => '30'

                        );
                    }
                } else {

                    $t1 = $time->format('h:i A') . ' - ' . $time->add($interval)->format('h:i A');

                    $time_array[] =  $time->format('h:i A') . ' - ' . $time->add($interval)->format('h:i A');

                    $slot[] = array(

                        'period' => $t1,

                        'available' => '1',

                        "delivery_price" => '30'

                    );
                }
            }
        }





        if ($date > date('Y-m-d')) {

            $slot1[] = array(

                'period' => "06:00 AM - 11:00 AM",

                'available' => '1',

                "delivery_price" => '30'

            );

            $slot1[] = array(

                'period' => "02:00 PM  - 05:00 PM",

                'available' => '1',

                "delivery_price" => '30'

            );
            $slot_time = isset($slot1[0]['period']) ? $slot1[0]['period'] : '';
            if (!empty($slot1)) {
                $xyz = 1;
                foreach ($slot1 as $slo) {
                    $check = '';

                    if ($xyz == 1) {
                        $check = 'checked';
                    }

                    $html .= '<div class="radio mb-10 option_chosse">
            <label >
            <input class="mr-3"  type="radio" ' . $check . ' onchange="getValue(this)" value="' . $slo['period'] . '" name="slot_time" id="slot_time">' . $slo['period'] . '</label>
            </div>';
                    ++$xyz;
                }
            }



            $response[] = array('status' => true, 'slot' => $slot1, 'html' => $html, 'date' => $date, 'slot_time' => $slot_time);
        } else {

            $html .= '<p>No Slot Available</p>';

            $response[] = array('status' => true, 'slot' => array(), 'html' => $html, 'date' => $date, 'slot_time' => '');
        }


        // print_r($response);
        // $response[] = array('result'=>'success', 'slot'=>$slot);

        echo json_encode($response);
    }



    public function cancel_order_old()

    {

        $orderID =  $_POST['id'];

        $status = "CANCEL";

        if ((int)$orderID) {

            $check_status = $this->home_m->get_single_table_query("select status from orders where orderID='$orderID'");

            if ($check_status->status != 'DELIVERED') {

                $this->db->where(array('orderID' => $orderID));

                $this->db->update('orders', array('status' => $status));

                $this->db->insert('order_status', array('orderID' => $orderID, 'status' => $status, 'added_on' => date("Y-m-d H:i:s")));
            } else {

                echo "DELIVERED";
            }
        }

        //redirect(base_url("home/order"));

    }



    // NEW VERSION TEST



    public function test_home()

    {

        if (empty($this->session->userdata('loginUserID'))) {

            $userID = 0;
        } else {

            $userID = $this->session->userdata('loginUserID');
        }

        $date = date('Y-m-d');

        $products = array();

        $deals = $this->db->query("SELECT * FROM `deals` WHERE (`start_date` <= '$date' AND `end_date`>='$date') AND `status`='Y'")->result();

        foreach ($deals as $d) {

            $product = $this->get_product($d->productID);



            $variants = $this->db->query("select * from products_variant where is_default='1' AND product_id='$product->productID'")->row();

            $variantID =  $variants->id;

            $brand = $this->get_brand($product->brand_id);

            $products[] = array(

                'productID' => $product->productID,

                'product_name' => $product->product_name,

                'product_image' => $product->product_image,

                'brand' => 'Grogry',

                'category_id' => $product->category_id,

                'retail_price' => $product->retail_price,

                'price' => $d->deal_price,

                'unit_value' => $product->unit_value,

                'unit' => $product->unit,

                'in_stock' => $product->in_stock,

                'stock_count' => $product->stock_count,

                'featured' => $product->featured,

                'vegtype' => $product->vegtype,

                'cart_qty' => ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $product->productID, $variantID)

            );
        }



        $featured = $this->db->query("SELECT * FROM `products` WHERE `featured`='Y' AND `in_stock`='Y' AND `productID` NOT IN (SELECT `productID` FROM `deals` WHERE (`start_date` <= '$date' AND `end_date`>='$date') AND `status`='Y')")->result();

        foreach ($featured as $p) {

            $variants = $this->db->query("select * from products_variant where is_default='1' AND product_id='$p->productID'")->row();

            $variantID =  $variants->id;

            $check = $this->db->get_where('deals', array('productID' => $p->productID))->row();

            if (!empty($check) && strtotime($check->end_date) > time() && strtotime($check->start_date) < time()) {

                $p->price = $check->deal_price;
            }



            if ($userID == 0) {

                $p->cart_qty = 0;
            } else {

                $p->cart_qty = $this->get_product_qty_cart($userID, $p->productID, $variantID);
            }
        }

        $this->data['page_name'] = 'home';

        $this->data['banners'] = $this->home_m->get_banners();

        $this->data['products'] = $products;

        $this->data['featured'] = $featured;

        /*$this->data['all_products'] = $this->home_m->get_products();*/

        $this->data['gift_banner'] = $this->webservice_m->get_single_table("gift_banner", array("status" => "Y"));

        $this->data['deal_banner'] = $this->home_m->get_deal_banner();

        $this->data['category'] = $this->home_m->get_category();

        $this->load->view('test', $this->data);
    }




    public function set_city()
    {

        $cityID = $_POST['cityID'];

        $data = array("cityID" =>  $cityID);

        $this->session->set_userdata($data);

        return true;
    }



    public function update_products_variants()
    {

        $products = $this->db->get_where('products', array())->result();

        foreach ($products as $p) {

            $a = array(

                'product_id' => $p->productID,

                'cost_price' => $p->cost_price,

                'stock_count' => $p->stock_count,

                'price' => $p->price,

                'retail_price' => $p->retail_price,

                'quantity' => $p->unit_value,

                'unit' => $p->unit,

                'is_default' => '1',

                'vegtype' => 'V',

                'in_stock' => 'Y',

                'variant_image' => $p->product_image,

                'created_at' => date('Y-m-d H:i:s'),

                'updated_at' => date('Y-m-d H:i:s')

            );



            $this->db->insert('products_variant', $a);



            $b = array(

                'product_id' => $p->productID,

                'cost_price' => $p->cost_price * 2,

                'stock_count' => $p->stock_count,

                'price' => $p->price * 2,

                'retail_price' => $p->retail_price * 2,

                'quantity' => $p->unit_value,

                'unit' => $p->unit,

                'is_default' => '0',

                'vegtype' => 'V',

                'in_stock' => 'Y',

                'variant_image' => $p->product_image,

                'created_at' => date('Y-m-d H:i:s'),

                'updated_at' => date('Y-m-d H:i:s')

            );



            $this->db->insert('products_variant', $b);
        }

        echo json_encode('ok');
    }



    //update product details

    public function update_products_details()
    {



        $products = $this->db->get_where('products_variant', array())->result();

        foreach ($products as $p) {

            $all_city = $this->db->get_where('city', array('status' => 'Y'))->result();

            foreach ($all_city as $city) {

                $a = array(

                    'product_id' => $p->product_id,

                    'variant_id' => $p->id,

                    'city_id' => $city->id,

                    'cost_price' => $p->cost_price,

                    'stock_count' => $p->stock_count,

                    'price' => $p->price,

                    'retail_price' => $p->retail_price,

                    'vegtype' => $p->vegtype,

                    'created_at' => date('Y-m-d H:i:s'),

                    'updated_at' => date('Y-m-d H:i:s')

                );



                $this->db->insert('products_detail', $a);
            }
        }



        echo json_encode('ok');



        //update product details  

    }



    //get membership price

    public function get_membershipPrice()
    {

        $userID = $_POST['userID'];

        $variantID = $_POST['variantID'];

        $variant = $this->db->query("select * from products_variant where id='$variantID'")->row();

        echo $variant->membershipPrice;
    }



    public function all_brands()
    {

        $this->data['all_brands'] = $this->db->query("SELECT * FROM `brand` WHERE `is_active`= 'Y'")->result();

        $this->data['page_name'] = 'all_brands';

        $this->load->view('index', $this->data);
    }







    //all memberShip Plans

    public function membership_plans()

    {

        $Membership_plans = $this->db->query("select * from membership_plans")->result();

        $this->data['page_name'] = 'membership_plans';

        $this->data['membership_plans'] = $Membership_plans;

        $this->load->view('index', $this->data);
    }


    public function get_order_count()
    {
        $userID = $_POST['userID'];
        $variantID = $_POST['variantID'];
        $variant = $this->db->query("select * from products_variant where id='$variantID'")->row();
        echo $variant->order_count;
    }

    public function get_variant_detail()
    {
        $userID = $_POST['userID'];
        $variantID = $_POST['variantID'];
        $variant = $this->db->query("select * from products_variant where id='$variantID'")->row();
        echo json_encode($variant);
        //echo json_$variant->variant_image;
    }




    public function plan_purchase()
    {


        //$orderID = 0;

        if ($_POST) {

            $payment_method = $_POST['payment_method'];
            $razorpay_num = $_POST['razorpay_num'];
            $userID = $_POST['userID'];
            $planID = $_POST['planID'];
            $payable_amount = $_POST['payable_amount'];
            $discount = '0.00';
            $user_info = $this->db->get_where("users", array('ID' => $userID))->row();
            //plan detail
            $endDate = '';
            $start_date = Date('Y-m-d h:i:s');
            // $sixmonth = date("Y-m-d h:i:s", strtotime(date("Y-m-d h:i:s", strtotime($start_date)) . " +6 month"));
            $oneyear  = date("Y-m-d h:i:s", strtotime(date("Y-m-d h:i:s", strtotime($start_date)) . " + 365 day"));
            $planInfo =  $this->webservice_m->get_single_table("membership_plans", array("status" => "Y", "id" => $planID));
            if (!empty($planInfo)) {
                if ($planInfo->duration == 'month') {
                    $months = date("Y-m-d h:i:s", strtotime(date("Y-m-d h:i:s", strtotime($start_date)) . " +" . $planInfo->count . " month"));
                    $endDate = $months;
                } else {
                    $endDate = $oneyear;
                }
            }



            $success = true;

            if ($payment_method == 'online' && $payable_amount > 0) {

                $success = false;

                $error = '';

                try {

                    $ch = $this->get_curl_handle($razorpay_num, $payable_amount * 100);

                    //execute post

                    $result = curl_exec($ch);

                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    if ($result === false) {

                        $success = false;

                        $error = 'Curl error: ' . curl_error($ch);
                    } else {

                        $txn_description = $result;

                        $response_array = json_decode($result, true);

                        if ($http_status === 200 and isset($response_array['error']) === false) {

                            $success = true;
                        } else {

                            $success = false;

                            if (!empty($response_array['error']['code'])) {

                                $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
                            } else {

                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
                            }
                        }
                    }

                    //close connection

                    curl_close($ch);
                } catch (Exception $e) {

                    $success = false;
                }

                if ($success === true) {

                    $txn_insert_array = array(

                        "userID" => $userID,
                        "planID" => $planID,
                        "txn_no" => $razorpay_num,
                        "amount" => $payable_amount,
                        "discount" => $discount,
                        "paid_amount" => $payable_amount,
                        "txn_mode" => 'online',
                        "start_date" => $start_date,
                        "end_date" => $endDate
                    );
                    $lastID = $this->db->insert('plan_transaction', $txn_insert_array);
                    if ($lastID) {
                        $this->db->where(array('ID' => $userID));
                        $this->db->update('users', array('membership' => $planID));
                    }
                }
            }

            if ($success === true) {

                // if ($payment_method == 'online')

                // {

                //     $txn_insert_array = array(

                //         "userID"=>$userID,

                //         "txn_no"=>$razorpay_num,

                //         "amount"=>$payable_amount,

                //         "type"=>'DEBIT',

                //         "against_for"=>'purchase plan',

                //         "paid_by"=>'online',

                //         "orderID"=>0,

                //         "transaction_at"=>date("Y-m-d H:i:s")

                //     );

                //     $this->db->insert('transactions',$txn_insert_array);

                // }

                $response = array('result' => 'success', 'msg' => 'Your Plan Has been successfully Purchased');
            } else {

                $response = array('result' => 'failure', 'msg' => 'Sorry ! There is an error while purchasing your Plan. Please Try Again Later');
            }
        } else {

            $response = array('result' => 'failure', 'msg' => 'Something Went Wrong. Please Try Again Later');
        }

        echo json_encode($response);
    }

    public function brands($brandID)

    {

        if (empty($this->session->userdata('loginUserID'))) {

            $userID = 0;
        } else {

            $userID = $this->session->userdata('loginUserID');
        }



        $brands = $this->db->get_where('brand', array('brandID' => $brandID))->row();



        if (!empty($brands)) {

            $products = $this->home_m->get_all_table_query("SELECT * FROM `products` WHERE `brand_id`='$brandID' AND `in_stock`= 'Y'  ");
        }

        foreach ($products as $p) {

            $query = $this->db->query("SELECT * FROM wish_list where userID = '$userID' AND productID = '$p->productID'");

            if ($query->num_rows() >= 1) {

                $p->favourite = 'Y';
            } else {

                $p->favourite = 'N';
            }

            $p->price = $this->check_deal($p->productID, $p->price);
        }



        $product_data = $this->db->query("SELECT MIN(`price`) as min_price, MAX(`price`) as max_price FROM `products` WHERE `product_name`AND 'in_stock'= 'Y'")->row();



        foreach ($products as $p) {

            $variants = $this->db->query("select * from products_variant where is_default='1' AND product_id='$p->productID'")->row();

            $variantID =  $variants->id;

            if ($userID == 0) {

                $p->cart_qty = 0;
            } else {

                $p->cart_qty = $this->get_product_qty_cart($userID, $p->productID, $variantID);
            }
        }

        $this->data['category'] = $this->home_m->get_category();

        $this->data['page_name'] = 'products_search';

        $this->data['products'] = $products;/*

    $this->data['category_ids'] = $category_array;*/

        $this->data['product_data'] = $product_data;

        $this->data['title'] = 'Products';

        $this->load->view('index', $this->data);
    }

    // public function test_check(){
    //     $count = 0;
    //     $new_array = array();
    //    $data =  $this->db->query("select distinct user_id from test")->result();
    //    foreach($data as $val){
    //      $records =  $this->db->query("select * from test where user_id='$val->user_id' order by id")->result();
    //       foreach($records as $r){
    //           if($count==3){
    //             array_push( $new_array,$r);
    //           }
    //           $count++;


    //       }
    //    }
    //    print_r($new_array ); exit;
    // }

    // SATYA
    // --------------------------------------------------------------------------
    // ========================================================================


    public function update_profile()

    {

        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }


        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            $userID = $_SESSION['loginUserID'];
            $name =  $this->input->post('name');
            $email = $this->input->post('email');
            $data = array(
                'name' => $name,
                'email' => $email
            );
            $this->db->where('ID', $userID);
            $this->db->update('users', $data);
            $this->session->set_flashdata('message', 'Profile Updated Successfully');
            redirect('home/profile');
        } else {

            $this->index();
        }
    }


    public function add_address()
    {

        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }
        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            if ($_POST) {

                $insert = $_POST;

                $userID = $_SESSION['loginUserID'];

                $insert['userID'] = $userID;
                $pincode = $_POST['pincode'];
                $check = $this->db->get_where('locality', array('pin' => $pincode, 'status' => 'Y'))->row();
                if (!empty($check)) {
                    $insert['added_on'] = date("Y-m-d H:i:s");
                    $this->session->set_flashdata('message', 'Address Added Successfully.');
                    $this->db->insert('user_address', $insert);
                    redirect(base_url("home/address"));
                } else {
                    $this->session->set_flashdata('message', 'Currently !! We are not serving in that location.');
                    redirect(base_url("home/add_address"));
                }
            } else {

                redirect(base_url("home/address"));
            }
        } else {

            $this->index();
        }
    }

    public function delete_addr()
    {
        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }
        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            if ($_POST) {

                $id = $_POST['add_id'];
                $this->db->where('addressID', $id);
                $this->db->delete('user_address');
                $this->session->set_flashdata('message', 'Address Deleted Successfully.');
                redirect(base_url("home/address"));
            } else {
                redirect(base_url("home/address"));
            }
        } else {

            $this->index();
        }
    }

    public function wallet()
    {
        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }

        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {
            $userID = $_SESSION['loginUserID'];
            $this->data['myprofile'] = $this->my_profile($userID);
            $this->data['orders'] = $this->home_m->get_all_row_where('orders', array('userID' => $userID), $select = '*');
            $this->data['addresses'] = $this->home_m->get_all_row_where('user_address', array('userID' => $userID), $select = '*');
            $this->data['page_name'] = 'wallet';
            $this->data['title'] = 'Wallet History';
            $this->load->view('index', $this->data);
        } else {

            $this->index();
        }
    }



    public function transaction()
    {
        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }

        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            $userID = $_SESSION['loginUserID'];

            $this->data['myprofile'] = $this->my_profile($userID);
            $this->data['orders'] = $this->home_m->get_all_row_where('orders', array('userID' => $userID), $select = '*');
            $this->data['transactions'] = $this->home_m->get_all_row_where('transactions', array('userID' => $userID, 'orderID !=' => 0), $select = '*');
            $this->data['page_name'] = 'transaction';
            $this->data['title'] = 'Wallet History';
            $this->load->view('index', $this->data);
        } else {

            $this->index();
        }
    }


    public function upload()
    {
        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }
        $this->load->helper("file");

        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            $userID = $_SESSION['loginUserID'];


            if (!empty($_FILES['photo'])) {

                $users = $this->home_m->get_single_row_where('users', array('ID' => $userID));

                if (!empty($users->image)) {
                    unlink("./uploads/users/" . $users->image);
                }


                $config['upload_path'] = './uploads/users/';


                $config['allowed_types'] = 'jpg|jpeg|png|pdf';


                $config['max_size'] = '2024';

                $config['max_width'] = '1024';
                $config['max_height'] = '768';


                $this->load->library('upload', $config);

                if ($this->upload->do_upload('photo')) {

                    $data = $this->upload->data();
                    $image = $data['file_name'];

                    $this->db->set(array('image' => $image));
                    $this->db->where('id', $userID);
                    $update = $this->db->update('users');
                    $this->session->set_flashdata('message', 'Profile Image Updated Successfully.');
                    $this->data['myprofile'] = $this->my_profile($userID);
                    redirect('home/profile');
                } else {
                    $this->data['myprofile'] = $this->my_profile($userID);
                    $this->session->set_flashdata('message', 'Something Went Wrong.');
                    redirect('home/profile');
                }
            }


            redirect('home/profile');
        } else {

            $this->index();
        }
    }


    public function order_details($order_id)
    {
        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }
        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            $userID = $_SESSION['loginUserID'];

            $this->data['myprofile'] = $this->my_profile($userID);

            $orders = $this->home_m->get_single_row_where('orders', array('userID' => $userID, 'orderID' => $order_id), $select = '*');
            $items = $this->home_m->get_all_row_where('order_items', array('orderID' => $order_id));
            // $productArr = [];
            // if(!empty($items)){
            //     foreach($items as $it){
            //          $products = $this->home_m->get_all_row_where('products',array('productID'=>$it->productID));
            //          // $productArr[] = $products;
            //          array_push($productArr, $products);
            //     }
            // }
            $this->data['orders'] = $orders;
            $this->data['items'] =  $items;
            // $this->data['products'] = $productArr;
            $this->data['page_name'] = 'order_details';

            $this->data['title'] = 'Order Detail';
            $this->load->view('index', $this->data);
        } else {

            $this->index();
        }
    }

    public function get_cart()
    {
        if (empty($this->session->userdata('cityID'))) {

            $cityID = 0;
        } else {

            $cityID = $this->session->userdata('cityID');
        }

        if (empty($this->session->userdata('loginUserID'))) {

            $userID = 0;
        } else {

            $userID = $this->session->userdata('loginUserID');
        }
        $date = date('Y-m-d');
        $userInfo =  $this->db->query("select * from users where ID='$userID' and status='Y'")->row();
        $carts = array();
        $html = '';
        $total = 0;
        if ($userID != 0) {
            $carts = $this->db->query("SELECT * FROM `product_cart` WHERE `userID`='$userID'")->result();

            if (!empty($carts)) {
                $i = 1;
                $total = 0;
                $html .= '<div class="row">
            <div class="col-lg-12 bg-white rounded shadow-sm mb-5">
            <div class="table-responsive" id="set_items">
            <table class="table">
            <thead>
            <tr>
            <th scope="col" class="border-0 bg-light">
            <div class="p-2 px-3 text-uppercase">Sl No</div>
            </th>
            <th scope="col" class="border-0 bg-light">
            <div class="p-2 px-3 text-uppercase">Product</div>
            </th>
            <th scope="col" class="border-0 bg-light">
            <div class="py-2 text-uppercase">Weight</div>
            </th>
            <th scope="col" class="border-0 bg-light">
            <div class="py-2 text-uppercase">Price</div>
            </th>

            <th scope="col" class="border-0 bg-light">
            <div class="py-2 text-uppercase">Quantity</div>
            </th>
            <th scope="col" class="border-0 bg-light">
            <div class="py-2 text-uppercase">Remove</div>
            </th>
            </tr>
            </thead>';

                foreach ($carts as $cart) {


                    $product = $this->db->query("SELECT * FROM `products` WHERE `productID`='$cart->productID' AND in_stock = 'Y' ")->row();
                    $pr_price = $product->price;
                    if (!empty($product)) {
                        $variant_ids = isset($cart->variantID) ? $cart->variantID : '';
                        if ($variant_ids != '') {
                            $products_variant = $this->db->query("SELECT * FROM `products_variant` WHERE `product_id`='$cart->productID' AND `id`='$variant_ids'")->row();
                            if (!empty($products_variant)) {
                                $pr_price = $products_variant->price;
                            }
                        }
                    }

                    $price = $cart->qty * $pr_price;
                    $total += $price;
                    $html .= '<tr>
                <td data-label="Sl No" class="border-0 align-middle">' . $i++ . '</td>
                <td data-label="Product" scope="row" class="border-0">
                <div class="p-2" >
                <a href=' . base_url('home/product_detail/') . $product->productID . ' class="text-dark p-name-font d-inline-block align-middle">
                <img src=' . base_url('admin/uploads/products/') . $product->product_image . ' alt="" width="70" class="img-fluid rounded shadow-sm">
                </a>
                <a href=' . base_url('home/product_detail/') . $product->productID . ' class="text-dark p-name-font d-inline-block align-middle">
                <div class="ml-3 d-inline-block align-middle">
                <h5 class="mb-0">' . $product->product_name . '</h5>
                </a>
                </div>
                </div>
                </td>


                <td data-label="Weight" class="border-0 align-middle"><strong>' . $product->unit_value . '/' . $product->unit . '<strong></td>
                <td data-label="Price" class="border-0 align-middle"><strong>₹' . $pr_price . '</strong></td>

                <td  data-label="Quantity" class="border-0 align-middle"><div class="quantity buttons_added">
                <input type="button" value="-" class="minus" onclick="minus_count(' . $cart->cartID . ',' . $product->max_quantity . ')"><input type="number" step="1" min="1" max=' . $product->max_quantity . ' name="quantity" id="manage_qty' . $cart->cartID . '" readonly value=' . $cart->qty . ' title="Qty" class="input-text qty text" size="4" pattern="" inputmode=""><input type="button"onclick="plus_count(' . $cart->cartID . ',' . $product->max_quantity . ')" value="+" class="plus"></td>




                <td data-label="Remove" class="border-0 align-middle"><a style = "cursor: pointer;" onclick="delete_item(' . $cart->cartID . ')"><i class="fa fa-trash remove_item" id=' . $cart->cartID . '</i></a></td>

                </tr>';
                }


                $html .= "</table>
            </div>
            </div>
            </div>";
            } else {
                $html .= '<div class="row mb-3">
         <div class="col-sm-2">

         </div>
         <div class="col-sm-8 text-center">
         <h3 class="text-danger"><strong> Looks Like There is no Product in Your Shopping Cart </strong></h3>
         <div>
         <img src=' . base_url("assets/emptycart.jpg") . ' width="100%">
         </div>
         <a class="btn btn-primary btn-lg" href=' . base_url() . '> Start Shopping Now </a>
         </div>
         </div>';
            }
        }

        echo json_encode(array(
            'html' => $html,
            'carts' => $carts,
            'total' => $total,
        ));
    }

    public function minus_cart_qty()
    {
        $cart_id = $this->input->post('cartId');
        // echo $cart_id;
        $carts = $this->db->query("SELECT * FROM `product_cart` WHERE `cartID`='$cart_id'")->row();
        $dbArray = [];
        $userID = $this->session->userdata('loginUserID');
        $qty = $carts->qty;

        if ($carts->qty == 1) {
            echo json_encode(array('status' => true, 'cart' => 1, 'message' => ''));
        } else {
            $this->db->set('qty', $qty - 1);
            $this->db->where('cartID', $cart_id);
            $this->db->update('product_cart');
            echo json_encode(array('status' => true, 'cart' => $qty - 1, 'message' => ''));
        }
    }

    public function plus_cart_qty()
    {

        $cart_id = $this->input->post('cartId');
        $max_qty = $this->input->post('max_qty');
        $carts = $this->db->query("SELECT * FROM `product_cart` WHERE `cartID`='$cart_id'")->row();
        $dbArray = [];
        $userID = $this->session->userdata('loginUserID');
        $qty = $carts->qty;

        if ($carts->qty > $max_qty) {
            echo json_encode(array('status' => true, 'cart' => $max_qty, 'message' => ''));
        } else {
            $this->db->set('qty', $qty + 1);
            $this->db->where('cartID', $cart_id);
            $this->db->update('product_cart');
            echo json_encode(array('status' => true, 'cart' => $qty + 1, 'message' => ''));
        }
    }

    //////Checkout
    public function checkout()
    {
        if (!$this->session->userdata('user_login')) {
            redirect('home');
        } else {
            $userID = $this->session->userdata('loginUserID');
            $this->data['carts'] =  $carts = $this->db->query("SELECT * FROM `product_cart` WHERE `userID`='$userID'")->result();
            $date = date('Y-m-d');
            $user = $this->db->query("SELECT * FROM `users` WHERE `ID`='$userID'")->row();
            $coupons = $this->db->query("SELECT * FROM `offers` WHERE `end_date` >='$date' AND `is_active`= 'Y' ")->result();

            $this->data['page_name'] = 'checkout';
            $this->data['user'] = $user;
            $this->data['coupons'] = $coupons;

            $this->data['title'] = 'Checkout';
            $this->load->view('index', $this->data);
        }
    }
    ///////////////End Checkout
    public function get_user_address()
    {
        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }
        $html = '';
        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {
            $userID = $_SESSION['loginUserID'];

            $addresses = $this->db->get_where('user_address', array('userID' => $userID))->result();

            if (!empty($addresses)) {
                $i = 1;
                $check = '';

                foreach ($addresses as $add) {
                    if ($i == 1) {
                        $check = 'checked';
                    } else {
                        $check = '';
                    }
                    $add_type = $add->address_type;
                    $add_type_name = 'Home';
                    if ($add_type == 'home' || $add_type == 'Home') {
                        $add_type_name = 'Home';
                    }
                    if ($add_type == 'office' || $add_type == 'Office') {
                        $add_type_name = 'Office';
                    }
                    if ($add_type == 'others' || $add_type == 'Others') {
                        $add_type_name = 'Others';
                    }
                    $html .= '<div class="col-sm-6 col-xs-12 mb-2" >

    <div class="p-3" style="border: 1px solid teal; width: auto;">

    <input class="option-input p-2 rButton" onclick="get_address_id(' . $add->addressID . ')"  value=' . $add->addressID . ' id="user_address' . $add->addressID . '" type="radio" name="user_address" ' . $check . '><label class="option" for="user_address' . $add->addressID . '"><ul><li><b>' . $add->contact_person_name . ' </b></li><li>Contact :' . $add->contact_person_mobile . '</li><li>Location :' . $add->location . '</li><li>Landmark :' . $add->landmark . '</li><li>Address Type :' . $add_type_name . '</li><li>Pin : ' . $add->pincode . '</li>
    </ul></label>

    </div>
    </div>';
                    ++$i;
                }



                echo json_encode(array('status' => true, 'html' => $html, 'message' => 'All Address.', 'address_id' => $addresses[0]->addressID));
            } else {
                echo json_encode(array('status' => false, 'html' => $html, 'message' => 'We Dont Serve Your Area', 'address_id' => $addresses[0]->addressID));
            }
        } else {

            echo json_encode(array('status' => false, 'html' => $html, 'message' => 'Something Went Wrong', 'address_id' => $addresses[0]->addressID));
        }
    }
    public function add_address_order()
    {
        if (!$this->session->userdata('user_login')) {
            redirect('home');
        }
        if ($_SESSION['user_login'] == TRUE && $_SESSION['loginUserID'] != '') {

            if ($_POST) {

                $insert = $_POST;
                $userID = $_SESSION['loginUserID'];
                $insert['userID'] = $userID;
                $pincode = $_POST['pincode'];
                // $insert['pincode'] = $_POST['pincode'];
                $check = $this->db->get_where('locality', array('pin' => $pincode, 'status' => 'Y'))->row();
                if (!empty($check)) {
                    $insert['added_on'] = date("Y-m-d H:i:s");
                    $this->db->insert('user_address', $insert);
                    echo json_encode(array('status' => true, 'message' => 'Address Added Successfully.'));
                } else {
                    echo json_encode(array('status' => false, 'message' => 'We Dont Serve Your Area'));
                }
            } else {

                echo json_encode(array('status' => false, 'message' => 'Something Went Wrong'));
            }
        } else {

            echo json_encode(array('status' => false, 'message' => 'Something Went Wrong'));
        }
    }

    public function send_sms()
    {
        //$mobile,$message
        $mobile = '916370371406';
        $message = 'Dear {#var#},\nYour order {#var#} is placed successfully.  It will be delivered on {#var#} between {#var#}.\nHappy Shopping!\nTeam Gowisekart ';
        $sender = "GOWKRT";

        $message = urlencode($message);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.msg91.com/api/sendhttp.php?sender=GOWKRT&route=4&country=91&message=' . $message . '&mobiles=' . $mobile . '&authkey=371792AiSdLSzp61dd714fP1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: PHPSESSID=2984i98tdm4rd3bg0v84iqvah4'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // return ;
        print_r($response);
    }



    public function place_order()
    {

        $userID = $_SESSION['loginUserID'];


        $coupon_discount_new = '';
        $carts = json_decode(base64_decode($_POST['carts']));
        $user_id = $this->input->post('user_id');
        $coup_code = $this->input->post('coupon_code');
        $type = $this->check_coupon_type($coup_code);
        $coupon_discount = $this->input->post('cashback_amount');
        $delivery_charges = $this->input->post('delivery_charges');
        $get_cashback_amount = $this->input->post('get_cashback');
        $user = $this->db->get_where('users', array('ID' => $userID))->row();
        $user_wallet = $user->wallet;
        $wallet_apply = $this->input->post('wallet_apply');

        if ($type == 'CASHBACK') {
            $coupon_discount_new =  $this->input->post('get_cashback');
        }

        $discount_amount =  $this->input->post('discount_amount');

        if ($discount_amount != '') {
            $coupon_discount_new =  $discount_amount;
        }
        $coupon_discount1 =  $this->input->post('coupon_discount');

        if ($coupon_discount != '') {
            $coupon_discount_new = $coupon_discount1;
        }

        $cashback_apply = $this->input->post('cashback_apply');
        $sub_total = $this->input->post('subtotal');
        $subtotal = $sub_total;
        $transaction_id = $this->input->post('transaction_id');
        $cart_total = $this->input->post('cart_total');
        $address_id = $this->input->post('address_id');
        $delivery_date = $this->input->post('delivery_date');
        $delivery_time = $this->input->post('delivery_time');


        if ($wallet_apply == 'yes') {
            if ($user_wallet < $subtotal) {
                $user_wallet = 0;
            } else {

                $user_wallet = $user_wallet - $cart_total;
            }
            $this->db->where(array('ID' => $userID));
            $this->db->update('users', array('wallet' => $user_wallet));
            echo $this->db->last_query();
            $this->db->where(array('userID' => $userID));
            $this->db->delete('product_cart');
            echo $this->db->last_query();
        }




        if ($delivery_time == '') {
            $this->session->set_flashdata('message', 'Delivery Slot Required');
            redirect('home/checkout');
        }

        if ($address_id == '') {
            $this->session->set_flashdata('message', 'Address  Required');
            redirect('home/checkout');
        }

        $payment_method = $this->input->post('payment_method');
        $total = $this->input->post('total');

        $users = $this->db->get_where('users', array('ID' => $user_id))->row();
        $address = $this->db->get_where('user_address', array('userID' => $user_id))->row();


        if ($cashback_apply == 'no') {

            $dbArray = [];
            $dbArray['cityID'] = $users->cityID;
            $dbArray['coupon_code'] = $coup_code;
            if ($users->cashback_wallet < $subtotal) {
                $dbArray['coupon_discount'] = $coupon_discount;
            } else {
                $dbArray['coupon_discount'] = $subtotal;
            }
            $coupon = $this->db->get_where('offers', array('offer_code' => $coup_code))->row();
            if (!empty($coupon)) {
                $dbArray['type'] = $coupon->offer_type;
            }
            ///----------without discount--------------
            $dbArray['userID'] = $user_id;
            $dbArray['customer_name'] = $address->contact_person_name;
            $dbArray['contact_no'] = $address->contact_person_mobile;
            $dbArray['house_no'] = $address->flat_no;
            $dbArray['apartment'] = $address->building_name;
            $dbArray['landmark'] = $address->landmark;
            $dbArray['location'] = $address->location;
            $dbArray['latitude'] = $address->latitude;
            $dbArray['longitude'] = $address->longitude;
            $dbArray['address_type'] = $address->address_type;
            $dbArray['order_amount'] = $subtotal;
            $dbArray['total_amount'] = $total;
            $dbArray['payment_method'] =  $payment_method;
            $dbArray['delivery_date'] =  $delivery_date;
            $dbArray['delivery_slot'] =  $delivery_time;
            //$dbArray['coupon_discount'] = $coupon_discount;
            $dbArray['coupon_discount'] = $discount_amount;
            $dbArray['delivery_charges'] = $delivery_charges;
            $dbArray['status'] =  'PLACED';
            $dbArray['order_from'] =  'WEBSITE';
            $dbArray['added_on'] =  date('Y-m-d H:i:s');
            $dbArray['updated_on'] = date('Y-m-d H:i:s');

            /* print_r($dbArray);
    echo "yes";
    exit();*/
            $this->db->insert('orders', $dbArray);
            $orderID = $this->db->insert_id();
            if ($cashback_apply == 'yes') {
                if ($users->cashback_wallet < $subtotal) {
                    $wallet_amount = 0;
                } else {
                    //$wallet_amount = $users->cashback_wallet - $subtotal;
                    $wallet_amount = $users->cashback_wallet - ($subtotal + $delivery_charges);
                }
                $this->db->where('ID', $user_id);
                $this->db->update('users', array('cashback_wallet' => $wallet_amount));
            }
            $transArr = [];
            $transArr['userID'] = $user_id;
            $transArr['txn_no'] =  isset($transaction_id) ? $transaction_id : $orderID;
            $transArr['amount'] = $subtotal;
            $transArr['type'] = 'DEBIT';
            $transArr['against_for'] = 'order';
            $transArr['paid_by'] = 'wallet';
            $transArr['orderID'] = $orderID;
            $transArr['transaction_at'] = date('Y-m-d h:i:s');
            $this->db->insert('transactions', $transArr);
            if (!empty($carts)) {
                foreach ($carts as $cart) {
                    $product = $this->db->get_where('products', array('productID' => $cart->productID))->row();

                    $orderItemArr = [];
                    $orderItemArr['orderID'] = $orderID;
                    $orderItemArr['productID'] = $cart->productID;
                    $orderItemArr['variantID'] = $cart->variantID;
                    $orderItemArr['qty'] = $cart->qty;
                    $orderItemArr['price'] = $product->price;
                    $orderItemArr['net_price'] = ($product->price * $cart->qty);
                    $orderItemArr['status'] = 'PLACED';
                    $orderItemArr['added_on'] =  date('Y-m-d H:i:s');
                    $orderItemArr['updated_on'] = date('Y-m-d H:i:s');
                    $this->db->insert('order_items', $orderItemArr);
                    $item_id = $this->db->insert_id();

                    $statusArr = [];
                    $statusArr['itemID'] = $item_id;
                    $statusArr['orderID'] = $orderID;
                    $statusArr['agentID'] = 0;
                    $statusArr['is_visible'] = 'Y';
                    $statusArr['status'] = 'PLACED';
                    $this->db->insert('order_status', $statusArr);
                    $item_id = $this->db->insert_id();
                    $this->db->delete('product_cart', array('userID' => $user_id, 'productID' => $cart->productID));
                }
            }
        } else {
            // print_r($_POST);
            $dbArray = [];
            $dbArray['cityID'] = $users->cityID;
            $dbArray['coupon_code'] = $coup_code;

            $coupon = $this->db->get_where('offers', array('offer_code' => $coup_code))->row();
            if (!empty($coupon)) {
                $dbArray['type'] = $coupon->offer_type;
                //if($coupon->type == 'CASHBACK' || $coupon->type == 'CASHBACK_PERCENTAGE'){
                $dbArray['coupon_discount'] = $discount_amount;
                $dbArray['cashback_amount'] = $get_cashback_amount;

                //}

            }
            if (!empty($coup_code)) {
                if ($type == 'CASHBACK') {
                    $dbArray['coupon_discount'] = '';
                } else {
                    if ($total < $coupon_discount) {
                        $dbArray['coupon_discount'] = $subtotal + $delivery_charges;
                    } else {
                        $dbArray['coupon_discount'] = $coupon_discount;
                    }
                }
            } else {


                if ($cashback_apply == 'yes') {
                    if ($type == 'CASHBACK') {
                        $dbArray['coupon_discount'] = '';
                    }
                    if ($users->cashback_wallet < $subtotal) {
                        $dbArray['coupon_discount'] = $coupon_discount;
                    } else {
                        $dbArray['coupon_discount'] = $subtotal + $delivery_charges;
                    }
                } else {
                    $dbArray['coupon_discount'] = '';
                }
            }

            ///----------discount--------------

            $dbArray['userID'] = $user_id;
            $dbArray['customer_name'] = $address->contact_person_name;
            $dbArray['contact_no'] = $address->contact_person_mobile;
            $dbArray['house_no'] = $address->flat_no;
            $dbArray['apartment'] = $address->building_name;
            $dbArray['landmark'] = $address->landmark;
            $dbArray['location'] = $address->location;
            $dbArray['latitude'] = $address->latitude;
            $dbArray['longitude'] = $address->longitude;
            $dbArray['address_type'] = $address->address_type;
            $dbArray['order_amount'] = $subtotal;
            $dbArray['total_amount'] = $total;
            $dbArray['payment_method'] =  $payment_method;
            $dbArray['delivery_date'] =  $delivery_date;
            $dbArray['delivery_slot'] =  $delivery_time;
            $dbArray['delivery_charges'] =  $delivery_charges;
            $dbArray['status'] =  'PLACED';
            $dbArray['order_from'] =  'WEBSITE';
            $dbArray['added_on'] =  date('Y-m-d H:i:s');
            $dbArray['updated_on'] = date('Y-m-d H:i:s');

            $this->db->insert('orders', $dbArray);
            $orderID = $this->db->insert_id();

            /* -------Apply wallet--------------- */

            if ($payment_method == 'wallet') {

                if ($wallet_apply == 'yes') {
                    if ($users->wallet < $subtotal) {
                        $user_wallet = 0;
                    } else {

                        $user_wallet = $users->wallet - ($subtotal + $delivery_charges);
                    }
                    $this->db->where(array('ID' => $userID));
                    $this->db->update('users', array('wallet' => $user_wallet));
                }

                $this->db->where(array('userID' => $userID));
                $this->db->delete('product_cart');
                $response = array('result' => 'success', 'msg' => 'Your Order Has been successfully Placed with orderID #' . $orderID);
            } else {
                $response = array('result' => 'failure', 'msg' => 'Sorry ! There is an error while placing your order. Please Try Again Later');
            }



            if ($cashback_apply == 'yes') {
                if ($users->cashback_wallet < $subtotal) {
                    $wallet_amount = 0;
                } else {
                    $wallet_amount = $users->cashback_wallet - ($subtotal + $delivery_charges);
                }
                $this->db->where('ID', $user_id);
                $this->db->update('users', array('cashback_wallet' => $wallet_amount));
            }
            $transArr = [];
            $transArr['userID'] = $user_id;
            $transArr['txn_no'] =  isset($transaction_id) ? $transaction_id : $orderID;
            $transArr['amount'] = $subtotal;
            $transArr['type'] = 'DEBIT';
            $transArr['against_for'] = 'order';
            $transArr['paid_by'] = 'wallet';
            $transArr['orderID'] = $orderID;
            $transArr['transaction_at'] = date('Y-m-d h:i:s');
            $this->db->insert('transactions', $transArr);
            if (!empty($carts)) {
                foreach ($carts as $cart) {
                    $product = $this->db->get_where('products', array('productID' => $cart->productID))->row();

                    $orderItemArr = [];
                    $orderItemArr['orderID'] = $orderID;
                    $orderItemArr['productID'] = $cart->productID;
                    $orderItemArr['variantID'] = $cart->variantID;
                    $orderItemArr['qty'] = $cart->qty;
                    $orderItemArr['price'] = $product->price;
                    $orderItemArr['net_price'] = ($product->price * $cart->qty);
                    $orderItemArr['status'] = 'PLACED';
                    $orderItemArr['added_on'] =  date('Y-m-d H:i:s');
                    $orderItemArr['updated_on'] = date('Y-m-d H:i:s');
                    $this->db->insert('order_items', $orderItemArr);
                    $item_id = $this->db->insert_id();

                    $statusArr = [];
                    $statusArr['itemID'] = $item_id;
                    $statusArr['orderID'] = $orderID;
                    $statusArr['agentID'] = 0;
                    $statusArr['is_visible'] = 'Y';
                    $statusArr['status'] = 'PLACED';
                    $this->db->insert('order_status', $statusArr);
                    $item_id = $this->db->insert_id();
                    $this->db->delete('product_cart', array('userID' => $user_id, 'productID' => $cart->productID));
                }
            }
        }

        // $address = $this->db->get_where('user_address',array('userID'=>$user_id))->row();
        // $mobile = $address->contact_person_mobile;
        // $message = 'Dear '.$address->contact_person_name.',\nYour order #'.$orderID.' is placed successfully.  It will be delivered on '.$delivery_date.' between '.$delivery_time.'.\nHappy Shopping!\nTeam Gowisekart';
        // $this->send_sms($mobile,$message);
        redirect('home/order');

        //redirect('home');
    }



    public function place_order11()
    {

        $coupon_discount_new = '';
        $carts = json_decode(base64_decode($_POST['carts']));
        $user_id = $this->input->post('user_id');
        $coup_code = $this->input->post('coupon_code');
        $type = $this->check_coupon_type($coup_code);
        $coupon_discount = $this->input->post('cashback_amount');
        //new
        $get_cashback_amount = $this->input->post('get_cashback');
        if ($type == 'CASHBACK') {
            $coupon_discount_new =  $this->input->post('get_cashback');
        }
        $discount_amount =  $this->input->post('discount_amount');

        if ($discount_amount != '') {
            $coupon_discount_new =  $discount_amount;
        }
        $coupon_discount1 =  $this->input->post('coupon_discount');
        if ($coupon_discount != '') {
            $coupon_discount_new = $coupon_discount1;
        }

        $cashback_apply = $this->input->post('cashback_apply');
        $sub_total = $this->input->post('subtotal');


        if ($sub_total >= 1000) {
            $delivery_charges = 30;
            $subtotal = $sub_total + $delivery_charges;
        } else {
            $delivery_charges = 50;
            $subtotal = $sub_total + $delivery_charges;
        }
        $transaction_id = $this->input->post('transaction_id');
        $cart_total = $this->input->post('cart_total');

        // print_r($_POST);
        // die;

        //$get_cashback = $this->input->post('get_cashback');

        $address_id = $this->input->post('address_id');
        $delivery_date = $this->input->post('delivery_date');
        $delivery_time = $this->input->post('delivery_time');

        if ($delivery_time == '') {
            $this->session->set_flashdata('message', 'Delivery Slot Required');
            redirect('home/checkout');
        }
        if ($address_id == '') {
            $this->session->set_flashdata('message', 'Address  Required');
            redirect('home/checkout');
        }
        $payment_method = $this->input->post('payment_method');
        $total = $this->input->post('total');
        if ($sub_total >= 1000) {
            $delivery_charges = 30;
        } else {
            $delivery_charges = 50;
        }
        /*$this->input->post('delivery_charges');*/
        $users = $this->db->get_where('users', array('ID' => $user_id))->row();
        $address = $this->db->get_where('user_address', array('userID' => $user_id))->row();

        //echo $coup_code;
        if ($coup_code == '' || empty($coup_code)) {
            $dbArray = [];
            $dbArray['cityID'] = $users->cityID;
            $dbArray['coupon_code'] = $coup_code;
            if ($users->cashback_wallet < $subtotal) {
                $dbArray['coupon_discount'] = $coupon_discount;
            } else {
                $dbArray['coupon_discount'] = $subtotal;
            }
            $dbArray['userID'] = $user_id;
            $dbArray['customer_name'] = $address->contact_person_name;
            $dbArray['contact_no'] = $address->contact_person_mobile;
            $dbArray['house_no'] = $address->flat_no;
            $dbArray['apartment'] = $address->building_name;
            $dbArray['landmark'] = $address->landmark;
            $dbArray['location'] = $address->location;
            $dbArray['latitude'] = $address->latitude;
            $dbArray['longitude'] = $address->longitude;
            $dbArray['address_type'] = $address->address_type;
            $dbArray['order_amount'] = $total;
            $dbArray['total_amount'] = $subtotal;
            $dbArray['payment_method'] =  $payment_method;
            $dbArray['delivery_date'] =  $delivery_date;
            $dbArray['delivery_slot'] =  $delivery_time;
            $dbArray['coupon_discount'] = $coupon_discount;
            $dbArray['delivery_charges'] = $delivery_charges;
            $dbArray['status'] =  'PLACED';
            $dbArray['order_from'] =  'WEBSITE';
            $dbArray['added_on'] =  date('Y-m-d H:i:s');
            $dbArray['updated_on'] = date('Y-m-d H:i:s');
            $this->db->insert('orders', $dbArray);
            $orderID = $this->db->insert_id();
            if ($cashback_apply == 'yes') {
                if ($users->cashback_wallet < $subtotal) {
                    $wallet_amount = 0;
                } else {
                    $wallet_amount = $users->cashback_wallet - $subtotal;
                }
                $this->db->where('ID', $user_id);
                $this->db->update('users', array('cashback_wallet' => $wallet_amount));
            }
            $transArr = [];
            $transArr['userID'] = $user_id;
            $transArr['txn_no'] =  isset($transaction_id) ? $transaction_id : $orderID;
            $transArr['amount'] = $subtotal;
            $transArr['type'] = 'DEBIT';
            $transArr['against_for'] = 'order';
            $transArr['paid_by'] = 'wallet';
            $transArr['orderID'] = $orderID;
            $transArr['transaction_at'] = date('Y-m-d h:i:s');
            $this->db->insert('transactions', $transArr);
            if (!empty($carts)) {
                foreach ($carts as $cart) {
                    $product = $this->db->get_where('products', array('productID' => $cart->productID))->row();

                    $orderItemArr = [];
                    $orderItemArr['orderID'] = $orderID;
                    $orderItemArr['productID'] = $cart->productID;
                    $orderItemArr['variantID'] = $cart->variantID;
                    $orderItemArr['qty'] = $cart->qty;
                    $orderItemArr['price'] = $product->price;
                    $orderItemArr['net_price'] = ($product->price * $cart->qty);
                    $orderItemArr['status'] = 'PLACED';
                    $orderItemArr['added_on'] =  date('Y-m-d H:i:s');
                    $orderItemArr['updated_on'] = date('Y-m-d H:i:s');
                    $this->db->insert('order_items', $orderItemArr);
                    $item_id = $this->db->insert_id();

                    $statusArr = [];
                    $statusArr['itemID'] = $item_id;
                    $statusArr['orderID'] = $orderID;
                    $statusArr['agentID'] = 0;
                    $statusArr['is_visible'] = 'Y';
                    $statusArr['status'] = 'PLACED';
                    $this->db->insert('order_status', $statusArr);
                    $item_id = $this->db->insert_id();
                    $this->db->delete('product_cart', array('userID' => $user_id, 'productID' => $cart->productID));
                }
            }
        } else {
            // print_r($_POST);
            $dbArray = [];
            $dbArray['cityID'] = $users->cityID;
            $dbArray['coupon_code'] = $coup_code;

            $coupon = $this->db->get_where('offers', array('offer_code' => $coup_code))->row();
            if (!empty($coupon)) {
                $dbArray['type'] = $coupon->offer_type;
                //if($coupon->type == 'CASHBACK' || $coupon->type == 'CASHBACK_PERCENTAGE'){
                $dbArray['coupon_discount'] = $discount_amount;
                $dbArray['cashback_amount'] = $get_cashback_amount;

                //}

            }


            // if($users->cashback_wallet < $subtotal){
            //     $dbArray['coupon_discount'] = $coupon_discount;

            // }else{
            //     $dbArray['coupon_discount'] = $subtotal;
            // }

            $dbArray['userID'] = $user_id;
            $dbArray['customer_name'] = $address->contact_person_name;
            $dbArray['contact_no'] = $address->contact_person_mobile;
            $dbArray['house_no'] = $address->flat_no;
            $dbArray['apartment'] = $address->building_name;
            $dbArray['landmark'] = $address->landmark;
            $dbArray['location'] = $address->location;
            $dbArray['latitude'] = $address->latitude;
            $dbArray['longitude'] = $address->longitude;
            $dbArray['address_type'] = $address->address_type;
            $dbArray['order_amount'] = $total;
            $dbArray['total_amount'] = $subtotal;
            $dbArray['payment_method'] =  $payment_method;
            $dbArray['delivery_date'] =  $delivery_date;
            $dbArray['delivery_slot'] =  $delivery_time;
            $dbArray['delivery_charges'] =  $delivery_charges;
            $dbArray['status'] =  'PLACED';
            $dbArray['order_from'] =  'WEBSITE';
            $dbArray['added_on'] =  date('Y-m-d H:i:s');
            $dbArray['updated_on'] = date('Y-m-d H:i:s');
            // print_r($dbArray);
            $this->db->insert('orders', $dbArray);
            $orderID = $this->db->insert_id();
            if ($cashback_apply == 'yes') {
                if ($users->cashback_wallet < $subtotal) {
                    $wallet_amount = 0;
                } else {
                    $wallet_amount = $users->cashback_wallet - $subtotal;
                }
                $this->db->where('ID', $user_id);
                $this->db->update('users', array('cashback_wallet' => $wallet_amount));
            }
            $transArr = [];
            $transArr['userID'] = $user_id;
            $transArr['txn_no'] =  isset($transaction_id) ? $transaction_id : $orderID;
            $transArr['amount'] = $subtotal;
            $transArr['type'] = 'DEBIT';
            $transArr['against_for'] = 'order';
            $transArr['paid_by'] = 'wallet';
            $transArr['orderID'] = $orderID;
            $transArr['transaction_at'] = date('Y-m-d h:i:s');
            $this->db->insert('transactions', $transArr);
            if (!empty($carts)) {
                foreach ($carts as $cart) {
                    $product = $this->db->get_where('products', array('productID' => $cart->productID))->row();

                    $orderItemArr = [];
                    $orderItemArr['orderID'] = $orderID;
                    $orderItemArr['productID'] = $cart->productID;
                    $orderItemArr['variantID'] = $cart->variantID;
                    $orderItemArr['qty'] = $cart->qty;
                    $orderItemArr['price'] = $product->price;
                    $orderItemArr['net_price'] = ($product->price * $cart->qty);
                    $orderItemArr['status'] = 'PLACED';
                    $orderItemArr['added_on'] =  date('Y-m-d H:i:s');
                    $orderItemArr['updated_on'] = date('Y-m-d H:i:s');
                    $this->db->insert('order_items', $orderItemArr);
                    $item_id = $this->db->insert_id();

                    $statusArr = [];
                    $statusArr['itemID'] = $item_id;
                    $statusArr['orderID'] = $orderID;
                    $statusArr['agentID'] = 0;
                    $statusArr['is_visible'] = 'Y';
                    $statusArr['status'] = 'PLACED';
                    $this->db->insert('order_status', $statusArr);
                    $item_id = $this->db->insert_id();
                    $this->db->delete('product_cart', array('userID' => $user_id, 'productID' => $cart->productID));
                }
            }
        }


        redirect('home/order');

        //redirect('home');
    }


    private function check_coupon_type($couponCode)
    {
        if (!empty($couponCode)) {
            $coupon =   $this->db->query("select * from offers where offer_code='$couponCode'")->row();
            if (!empty($coupon)) {
                if ($coupon->offer_type == 'CASHBACK' || $coupon->offer_type == 'CASHBACK_PERCENTAGE') {
                    return 'CASHBACK';
                }
            } else {
                return '';
            }
        } else {
            return '';
        }
    }









    public function cancel_order()

    {

        $orderID =  $_POST['orderID'];

        $status = "CANCEL";

        if ((int)$orderID) {

            $check_status = $this->home_m->get_single_table_query("select status from orders where orderID='$orderID'");

            if ($check_status->status != 'DELIVERED') {

                $this->db->where(array('orderID' => $orderID));

                $this->db->update('orders', array('status' => $status));

                $this->db->insert('order_status', array('orderID' => $orderID, 'status' => $status, 'added_on' => date("Y-m-d H:i:s")));

                echo json_encode(array('status' => true, 'message' => 'Order Cancelled Successfully'));
            } else {

                echo json_encode(array('status' => false, 'message' => 'Product Already Delivered'));
            }
        }

        echo json_encode(array('status' => false, 'message' => 'Something Went Wrong'));
        //redirect(base_url("home/order"));

    }


    public function apply_coupon()

    {


        $userID = $_SESSION['loginUserID'];

        $offer_code = strtoupper($_POST['coup_code']);
        $response = [];

        $carts = $this->db->query("SELECT * FROM `product_cart`  WHERE `userID`='$userID'")->result();
        $date = date('Y-m-d');
        if (!empty($carts)) {
            $offers =  $this->db->query("SELECT * FROM `offers`  WHERE `offer_code`='$offer_code' AND `is_active`='Y' AND date(`start_date`) <= '$date' AND date(`end_date`) >= '$date'")->row();
            //echo $this->db->last_query();

            if (!empty($offers)) {
                if ($offers->end_date > $date) {
                    $order_amount = 0;

                    $total_qty = 0;
                    $cart_products = $this->db->query("SELECT `product_cart`.`cartID`, `product_cart`.`productID`, `product_cart`.`qty`, `products`.`price`, `products`.`retail_price`, `products`.`product_image`, `products`.`product_name` FROM `product_cart` LEFT JOIN `products` ON  `product_cart`.`productID` = `products`.`productID` WHERE `product_cart`.`userID`='$userID'")->result();
                    foreach ($cart_products as $p) {
                        $total_qty += $p->qty;
                        $order_amount += $p->qty * $p->price;
                    }
                    if ($offers->allowed_user_times > 0) {
                        $check = $this->home_m->get_all_row_where('orders', array('userID' => $userID, 'coupon_code' => $offer_code));
                        if (sizeof($check) < $offers->allowed_user_times) {
                            if ($order_amount >= $offers->min_cart_value) {
                                if ($offers->offer_type == 'FIXED') {
                                    $discount_amt = $offers->offer_value;
                                    $type = 'discount';
                                } elseif ($offers->offer_type == 'PERCENTAGE') {
                                    $amt = ceil($offers->offer_value * ($order_amount / 100));
                                    if ($amt > $offers->max_discount) {
                                        $discount_amt = $offers->max_discount;
                                        $type = 'discount';
                                    } else {
                                        $discount_amt = $amt;
                                        $type = 'discount';
                                    }
                                } elseif ($offers->offer_type == 'CASHBACK') {
                                    $discount_amt = $offers->offer_value;
                                    $type = 'cashback';
                                } elseif ($offers->offer_type == 'CASHBACK_PERCENTAGE') {
                                    $amt = ceil($offers->offer_value * ($order_amount / 100));
                                    if ($amt > $offers->max_discount) {
                                        $discount_amt = $offers->max_discount;
                                        $type = 'cashback';
                                    } else {
                                        $discount_amt = $amt;
                                        $type = 'cashback';
                                    }
                                }


                                $response = array('status' => true, 'message' => 'Coupon Applied Successfully', 'coup_code' => $offer_code, 'discount' => $discount_amt, 'type' => $type, 'description' => $offers->description);
                            } else {
                                $response = array('status' => false, 'message' => "Minimum cart Value '$offers->min_cart_value'");
                            }
                        } else {
                            $response = array('status' => false, 'message' => 'You Have Already Apply Maximum Times');
                        }
                    } else {
                        $response = array('status' => false, 'message' => 'Coupon Apply Maximum No of Time
                    ');
                    }
                } else {
                    $response = array('status' => false, 'message' => 'Coupon Code Expired');
                }
            } else {
                $response = array('status' => false, 'message' => 'Coupon Code Not exist');
            }
        } else {
            $response = array('status' => false, 'message' => 'Cart is empty');
        }



        echo json_encode($response);
    }

    public function deal_products()
    {
        if (empty($this->session->userdata('cityID'))) {
            $cityID = 1;
        } else {
            $cityID = $this->session->userdata('cityID');
        }
        if (empty($this->session->userdata('loginUserID'))) {
            $userID = 0;
        } else {
            $userID = $this->session->userdata('loginUserID');
        }
        $date = date('Y-m-d');
        //$products = array();
        $deals = $this->db->query("SELECT * FROM `deals` WHERE (`start_date` <= '$date' AND `end_date`>='$date') AND `status`='Y' AND cityID='$cityID' ")->result();
        //echo $this->db->last_query();
        foreach ($deals as $d) {
            $product = $this->get_deals_product($d->productID, $d->variantID);
        }

        $this->data['userID'] = $userID;
        $this->data['cityID'] = $cityID;
        $this->data['page_name'] = 'deal_product';
        $this->data['deal_product'] = $product;
        $this->data['deals'] = $deals;
        $this->load->view('index', $this->data);
    }
    public function get_deals_product($productID, $variantID)
    {
        $product =  $this->db->query("SELECT products_variant.*,products.product_name,products.product_image,products.max_quantity from products_variant inner join products on products_variant.product_id=products.productID WHERE products_variant.id='$variantID' AND products_variant.product_id= '$productID' AND products_variant.in_stock='Y'")->row();
        return $product;
    }

    public function top_selling_products()
    {
        if (empty($this->session->userdata('cityID'))) {
            $cityID = 1;
        } else {
            $cityID = $this->session->userdata('cityID');
        }
        if (empty($this->session->userdata('loginUserID'))) {
            $userID = 0;
        } else {
            $userID = $this->session->userdata('loginUserID');
        }
        $date = date('Y-m-d');
        $products = array();






        $table = 'order_items';
        $where = array();
        //$best_selling_pro = $this->db->query("SELECT * FROM order_items GROUP BY productID ORDER BY SUM(qty) DESC LIMIT 100")->result();
        $config = array();
        $config["base_url"] = base_url() . "home/top_selling_products";
        $config["total_rows"] = $this->home_m->record_count($table, $where);
        $config["per_page"] = 16;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $config["total_rows"];
        //    $config['cur_tag_open'] = '&nbsp;<a class="cdp_i">';
        //    $config['cur_tag_close'] = '</a>';
        //    $config['next_link'] = 'Next';
        //    $config['prev_link'] = 'Previous';

        $config['num_links'] = 4;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';



        $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Previous Page';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';


        $config['next_link'] = 'Next Page<i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';




        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $limit =  $config["per_page"];
        $start =  $page;



        $best_selling_pro = $this->home_m->fetch_products($table, $where, $limit, $start);





        //$this->data["links"] = $this->pagination->create_links();

        //    $str_links = $this->pagination->create_links();
        $this->data["links"] = $this->pagination->create_links();






        if (!empty($best_selling_pro)) {
            foreach ($best_selling_pro  as $best) {
                $products = $this->db->query("SELECT * FROM `products` WHERE productID='$best->productID' AND in_stock = 'Y' ")->result();
                if (!empty($products)) {
                    foreach ($products as $p) {
                        $p->variants = $this->all_variants($p->productID, $cityID, $userID);
                        $defaultVariant = $this->get_default_variant($p->productID, $cityID);
                        if (!empty($defaultVariant)) {
                            $p->unit_value =  $defaultVariant->unit_value;
                            $p->unit =  $defaultVariant->unit;
                            $p->stock_count =  $defaultVariant->stock_count;
                            $p->retail_price =  $defaultVariant->retail_price;
                            $p->price =  $defaultVariant->price;
                            $p->cost_price =  $defaultVariant->cost_price;
                            $p->variantID =  $defaultVariant->id;
                            $variantID =   $defaultVariant->id;
                        }
                        $p->totalVariants = count($p->variants);
                        $p->cart_qty = ($userID == 0) ? 0 : $this->get_product_qty_cart($userID, $p->productID, $variantID);
                    }
                }
            }
        }


        $this->data['best_selling_pro'] = $best_selling_pro;
        $this->data['userID'] = $userID;
        $this->data['cityID'] = $cityID;
        $this->data['page_name'] = 'top_selling';
        $this->data['deal_product'] = $products;
        $this->data['best_selling_pro'] = $best_selling_pro;
        $this->load->view('index', $this->data);
    }



    public function contactus()
    {

        $this->data['page_name'] = 'contactus';
        $this->data['title'] = 'Wallet History';
        $this->load->view('index', $this->data);
    }


    public function search_pro()
    {
        $search_key =   $_POST['search_key'];
        $products = $this->db->query("SELECT product_name FROM `products` WHERE product_name LIKE  '%$search_key%' AND in_stock = 'Y' ")->result();
        $product_name_array = [];
        if (!empty($products)) {
            foreach ($products as $pro) {
                $product_name_array[] = $pro->product_name;
            }
        }


        echo json_encode($product_name_array);
    }
}
