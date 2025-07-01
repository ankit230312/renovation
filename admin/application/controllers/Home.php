<?php

/**

 * Created by PhpStorm.

 * User: kshit

 * Date: 2019-05-13

 * Time: 11:37:15

 */



class Home extends MY_Controller

{

    function __construct()
    {

        parent::__construct();

        $this->load->model("home_m");
    }



    public function logout()
    {
        session_destroy();
        redirect("login");
    }



    public function index()
    {
        $d = date('Y-m-d');
        $month = date('m');
        $id = $_SESSION['adminID'];
        $cityID = $this->session->userdata('cityID');
        $start_date = date('Y-m-d', strtotime('monday this week'));
        $end_date = date('Y-m-d', strtotime('sunday this week'));
        $this->data['orders'] = $this->db->query("SELECT * FROM `orders` WHERE `status` IN ('PLACED','CONFIRM','ALLOCATED')")->result();
        $this->data['confirmed'] = $this->db->query("SELECT * FROM `orders` WHERE `status` IN ('CONFIRM')")->result();
        $this->data['allocated'] = $this->db->query("SELECT * FROM `orders` WHERE `status` IN ('ALLOCATED')")->result();
        $this->data['delivery_agent'] = $this->home_m->get_all_row_where('delivery_agent', array(), $select = '*');
        $this->data['today_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE DATE(`added_on`)='$d' AND (`status` = 'PLACED')");
        $this->data['place_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE `status` = 'PLACED'");
        $this->data['ongoing_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE `status` = 'OUT_FOR_DELIVERY'");
        $this->data['complete_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE `status` = 'DELIVERED'");

        $this->data['pending_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE `status` IN ('PLACED','ALLOCATED','CONFIRM','PACKED','OUT_FOR_DELIVERY') ");

        $this->data['cancel_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE `status` = 'CANCEL'");
        //print_r( $this->data['cancel_orders']); exit;

        $this->data['weekly_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE DATE(`added_on`) BETWEEN '$start_date' AND '$end_date' AND (`status` = 'PLACED') ");

        // $this->data['weekly_users'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`ID`),0) as user_count FROM `users` WHERE WEEK(`added_on`)='$week'");

        // $this->data['weekly_users'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE WEEK(`added_on`)='$week' AND (`status` = 'PLACED')");

        $this->data['monthly_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE MONTH(`added_on`)='$month'");
        $this->data['m_orders'] = $this->db->query("SELECT * FROM `orders` WHERE MONTH(`added_on`)='$month' ")->result();

        $this->data['total_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE DATE(`added_on`)");


        $this->data['monthly_users'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`ID`),0) as user_count FROM `users` WHERE MONTH(`added_on`)='$month'");

        $this->data['monthly_revenue'] = $this->home_m->get_single_table_query("SELECT COALESCE(SUM(`total_amount`),0) as monthly_revenue FROM `orders` WHERE  MONTH(`added_on`)='$month' AND `status` != 'CANCEL'");


        $this->data['today_revenue'] = $this->home_m->get_single_table_query("SELECT COALESCE(SUM(`total_amount`),0) as today_revenue FROM `orders` WHERE DATE(`added_on`) ='$d' AND `status` != 'CANCEL'");

        $this->data['total_revenue'] = $this->home_m->get_single_table_query("SELECT COALESCE(SUM(`total_amount`),0) as total_revenue FROM `orders` WHERE DATE(`added_on`) AND `status` != 'CANCEL'");

        $this->data['today_users'] = $this->db->query("SELECT COALESCE(COUNT(`ID`),0) as today_users FROM `users` WHERE DATE(`added_on`) = '$d'")->row();

        $this->data['total_users'] = $this->db->query("SELECT COALESCE(COUNT(`ID`),0) as order_count FROM `users`")->row();

        $this->data['vendor_today_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE `status` = 'PLACED' AND vendorID ='$id' AND cityID = '$cityID' ");

        $this->data['vendor_complete_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE `status` = 'DELIVERED' AND vendorID ='$id'  AND cityID = '$cityID' ");

        $this->data['vendor_pending_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE `status` != 'DELIVERED' OR `status` != 'CANCEL' AND vendorID ='$id' AND cityID = '$cityID' ");

        $this->data['vendor_cancel_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE `status` = 'CANCEL' AND vendorID ='$id' AND cityID = '$cityID' ");

        $this->data['vendor_allocated_orders'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE   `status` = 'ALLOCATED' AND `status` != 'DELIVERED' AND `status` != 'CANCEL' AND vendorID ='$id' AND cityID = '$cityID'");

        $this->data['vendor_allocated'] = $this->home_m->get_all_table_query("SELECT  * FROM `orders` WHERE   `status` = 'ALLOCATED' AND `status` != 'DELIVERED' AND `status` != 'CANCEL' AND vendorID ='$id' AND cityID = '$cityID'");

        $this->data['product_stock'] = $this->home_m->get_all_table_query("SELECT distinct products_variant.product_id,products.* from products_variant left join products on products_variant.product_id=products.productID where products_variant.stock_count= '0' ");

        $this->data['pending'] = $this->home_m->get_single_table_query("SELECT COALESCE(COUNT(`orderID`),0) as order_count FROM `orders` WHERE `status` = 'CONFIRM' OR `status` = 'ALLOCATED' OR `status` = 'PACKED' ");

        //  $this->data['ongoing_orders'] = $this->home_m->get_all_table_query("select * from orders where status='OUT_FOR_DELIVERED'");
        //  $this->data['cancel_orders'] = $this->home_m->get_all_table_query("select * from orders where status='CANCEL'");
        // $this->data['complete_orders'] = $this->home_m->get_all_table_query("select * from orders where status='DELIVERED'");   









        $this->data['sub_view'] = 'home/dashboard';

        $this->data['title'] = 'Home';

        $this->load->view("_layout", $this->data);
    }



    public function send_sms($mobile, $message)
    {

        $sender = "GROCST";

        $message = urlencode($message);



        $msg = "sender=" . $sender . "&route=4&country=91&message=" . $message . "&mobiles=" . $mobile . "&authkey=284738AIuEZXRVCDfj5d26feae";



        $ch = curl_init('http://api.msg91.com/api/sendhttp.php?');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);

        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($ch);

        $result = curl_close($ch);

        return $res;
    }



    public function reset_admin_psw()

    {

        if ($_SESSION['role'] == 'admin' && $_POST) {

            $id = $this->input->post('userID');

            $password = $this->input->post('pass');

            $confirm_password = $this->input->post('cpass');

            if (trim($password) != '' && trim($confirm_password) != '') {

                if ($password == $confirm_password) {

                    $password = $this->home_m->hash($password);

                    $this->home_m->update_data('admin', array('id' => $id), array('password' => $password));

                    echo json_encode(array('result' => 'success', 'msg' => 'Password updated Successfully'));
                } else {

                    echo json_encode(array('result' => 'failure', 'msg' => 'Password and Confirm Password Must be Same'));
                }
            } else {

                echo json_encode(array('result' => 'failure', 'msg' => 'Password and Confirm Password Both are required'));
            }
        } else {

            echo json_encode(array('result' => 'failure', 'msg' => 'Permission Denied'));
        }
    }



    public function admin($param1 = '', $param2 = '', $param3 = '')

    {

        if ($param1 == 'edit' && $param2 != "" && $param3 == md5($param2)) {

            $id = $param2;

            if ($_POST) {

                $category_id = array();

                $username = $this->input->post('username');

                $check = $this->home_m->get_single_row_where('admin', array('username' => $username, 'id !=' => $id), $select = 'id');

                if (empty($check)) {

                    $target_path = 'uploads/';

                    $password = $this->input->post('password');

                    $insert = $_POST;

                    unset($insert['password']);

                    if (trim($password) != '') {

                        $insert['password'] = $this->home_m->hash($password);
                    }

                    $insert['updated_at'] = date("Y-m-d H:i:s");

                    //$insert['category_id'] = implode(",",$_POST['category_id']);

                    $insert['status'] = 'Y';



                    $category_id = '';

                    if (isset($_POST['category_id'])) {
                        if (is_array($_POST['category_id']) && count($_POST['category_id']) > 0) {
                            // Filter out empty values
                            $filtered = array_filter($_POST['category_id'], function ($val) {
                                return $val !== "";
                            });

                            $category_id = implode(',', $filtered);
                        } else {
                            // It's a single value (not an array)
                            $category_id = $_POST['category_id'];
                        }
                    }

                    $insert['category_id'] = $category_id;


                    if (!empty($_FILES['photo']['name'])) {

                        $extension = substr(strrchr($_FILES['photo']['name'], '.'), 1);

                        $actual_image_name = 'image' . time() . "." . $extension;

                        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_path . $actual_image_name);

                        $insert['photo'] = $actual_image_name;

                        if ($id == $_SESSION['adminID']) {

                            $_SESSION['image'] = $actual_image_name;
                        }
                    }

                    if ($id == $_SESSION['adminID']) {

                        $_SESSION['name'] = $_POST['name'];

                        $_SESSION['username'] = $_POST['username'];

                        $_SESSION['email'] = $_POST['email'];

                        $_SESSION['mobile'] = $_POST['mobile'];
                    }

                    // $pincode ='';

                    // if(sizeof($_POST['pincode']) > 0){

                    //     foreach ($_POST['pincode'] as $row) {

                    //         if ($row != "") {

                    //             $pincode = implode(',', $_POST['pincode']);

                    //         }

                    //     }

                    // }else{

                    //     $pincode = $_POST['pincode'];

                    // }

                    // $insert['pincode'] = $pincode;

                    $this->home_m->update_data('admin', array('id' => $id), $insert);

                    redirect(base_url("home/admin"));
                } else {

                    $this->data['admin_info'] = $this->home_m->get_single_row_where('admin', array('id' => $id));

                    $this->data['category'] = $this->home_m->get_all_row_where('category', array('parent' => '0', 'status' => 'Y'));

                    $this->data['error'] = '! This username is already in use.';

                    $this->data['sub_view'] = 'admin/edit';

                    $this->data['title'] = 'Edit Admin';

                    $this->load->view("_layout", $this->data);
                }
            } else {

                $this->data['admin_info'] = $this->home_m->get_single_row_where('admin', array('id' => $id));

                $this->data['category'] = $this->home_m->get_all_row_where('category', array('parent' => '0', 'status' => 'Y'));

                $this->data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

                $this->data['sub_view'] = 'admin/edit';

                $this->data['title'] = 'Edit Admin';

                $this->load->view("_layout", $this->data);
            }
        } elseif ($param1 == 'add') {

            if ($_POST) {

                $username = $this->input->post('username');

                $mobile = $this->input->post('mobile');

                $check = $this->home_m->get_single_row_where('admin', array('username' => $username), $select = 'id');

                if (empty($check)) {

                    $target_path = 'uploads/';

                    $password = $this->input->post('password');

                    $insert = $_POST;

                    $insert['photo'] = 'user.png';

                    $insert['password'] = $this->home_m->hash($password);

                    $insert['created_at'] = date("Y-m-d H:i:s");

                    $insert['updated_at'] = date("Y-m-d H:i:s");

                    $insert['remember_token'] = '';

                    $insert['status'] = 'Y';

                    $insert['category_id'] = implode(",", $_POST['category_id']);

                    if (!empty($_FILES['photo']['name'])) {

                        $extension = substr(strrchr($_FILES['photo']['name'], '.'), 1);

                        $actual_image_name = 'image' . time() . "." . $extension;

                        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_path . $actual_image_name);

                        $insert['photo'] = $actual_image_name;
                    }



                    // $pincode ='';

                    // if(sizeof($_POST['pincode']) > 0){

                    //     foreach ($_POST['pincode'] as $row) {

                    //         if ($row != "") {

                    //             $pincode = implode(',', $_POST['pincode']);

                    //         }

                    //     }

                    // }else{

                    //     $pincode = $_POST['pincode'];

                    // }

                    // $insert['pincode'] = $pincode;

                    if ($insert['role'] == 'vendor') {

                        $message = "Your have successfully registered as GowiseKart vendor.\nUsername: " . $username . "\nPassword: " . $password . " ";

                        $this->send_sms($mobile, $message);
                    }

                    $this->home_m->insert_data('admin', $insert);

                    redirect(base_url("home/admin"));
                } else {

                    $this->data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

                    $this->data['category'] = $this->home_m->get_all_row_where('category', array('parent' => '0', 'status' => 'Y'));

                    $this->data['error'] = '! This username is already in use.';

                    $this->data['sub_view'] = 'admin/add';

                    $this->data['title'] = 'Add Admin';

                    $this->load->view("_layout", $this->data);
                }
            } else {

                $this->data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

                $this->data['category'] = $this->home_m->get_all_row_where('category', array('parent' => '0', 'status' => 'Y'));

                $this->data['sub_view'] = 'admin/add';

                $this->data['title'] = 'Add Admin';

                $this->load->view("_layout", $this->data);
            }
        } else {

            $select = "id,name,username,email,mobile,role,category_id,photo,status";
            $where = '(role="admin" or role = "subadmin" or role = "order_manager")';

            $this->data['admin'] = $this->home_m->get_all_row_where('admin', $where, $select);

            $this->data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

            $this->data['category'] = $this->home_m->get_all_row_where('category', array('parent' => '0', 'status' => 'Y'));

            $this->data['sub_view'] = 'admin/list';

            $this->data['title'] = 'Admin';

            $this->load->view("_layout", $this->data);
        }
    }

    public function vendor($param1 = '', $param2 = '', $param3 = '')

    {

        if ($param1 == 'edit' && $param2 != "" && $param3 == md5($param2)) {

            $id = $param2;

            if ($_POST) {

                $category_id = array();

                $username = $this->input->post('username');

                $check = $this->home_m->get_single_row_where('admin', array('username' => $username, 'id !=' => $id), $select = 'id');

                if (empty($check)) {

                    $target_path = 'uploads/';

                    $password = $this->input->post('password');

                    $insert = $_POST;

                    unset($insert['password']);

                    if (trim($password) != '') {

                        $insert['password'] = $this->home_m->hash($password);
                    }

                    $insert['updated_at'] = date("Y-m-d H:i:s");

                    $insert['status'] = 'Y';

                    if (sizeof($_POST['category_id']) > 0) {

                        foreach ($_POST['category_id'] as $row) {

                            if ($row != "") {

                                $category_id = implode(',', $_POST['category_id']);
                            }
                        }
                    } else {

                        $category_id = $_POST['category_id'];
                    }

                    $insert['category_id'] = $category_id;

                    if (!empty($_FILES['photo']['name'])) {

                        $extension = substr(strrchr($_FILES['photo']['name'], '.'), 1);

                        $actual_image_name = 'image' . time() . "." . $extension;

                        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_path . $actual_image_name);

                        $insert['photo'] = $actual_image_name;

                        if ($id == $_SESSION['adminID']) {

                            $_SESSION['image'] = $actual_image_name;
                        }
                    }

                    if ($id == $_SESSION['adminID']) {

                        $_SESSION['name'] = $_POST['name'];

                        $_SESSION['username'] = $_POST['username'];

                        $_SESSION['email'] = $_POST['email'];

                        $_SESSION['mobile'] = $_POST['mobile'];
                    }

                    $pincode = array();

                    if (sizeof($_POST['pincode']) > 0) {

                        foreach ($_POST['pincode'] as $row) {

                            if ($row != "") {

                                $pincode = implode(',', $_POST['pincode']);
                            }
                        }
                    } else {

                        $pincode = $_POST['pincode'];
                    }

                    $insert['pincode'] = $pincode;

                    $this->home_m->update_data('admin', array('id' => $id), $insert);

                    redirect(base_url("home/vendor"));
                } else {

                    $this->data['admin_info'] = $this->home_m->get_single_row_where('admin', array('id' => $id));

                    $this->data['category'] = $this->home_m->get_all_row_where('category', array('parent' => '0', 'status' => 'Y'));

                    $this->data['error'] = '! This username is already in use.';

                    $this->data['sub_view'] = 'vendor/edit';

                    $this->data['title'] = 'Edit Vendor';

                    $this->load->view("_layout", $this->data);
                }
            } else {

                $this->data['admin_info'] = $this->home_m->get_single_row_where('admin', array('id' => $id));

                $this->data['category'] = $this->home_m->get_all_row_where('category', array('parent' => '0', 'status' => 'Y'));

                $this->data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

                $this->data['sub_view'] = 'vendor/edit';

                $this->data['title'] = 'Edit Vendor';

                $this->load->view("_layout", $this->data);
            }
        } elseif ($param1 == 'add') {

            if ($_POST) {

                $username = $this->input->post('username');



                $check = $this->home_m->get_single_row_where('admin', array('username' => $username), $select = 'id');

                if (empty($check)) {

                    $target_path = 'uploads/';

                    $mobile = $this->input->post('mobile');

                    $password = $this->input->post('password');

                    $insert = $_POST;

                    $insert['photo'] = 'user.png';

                    $insert['password'] = $this->home_m->hash($password);

                    $insert['created_at'] = date("Y-m-d H:i:s");

                    $insert['updated_at'] = date("Y-m-d H:i:s");

                    $insert['remember_token'] = '';

                    $insert['status'] = 'Y';

                    $insert['category_id'] = implode(",", $_POST['category_id']);



                    if (!empty($_FILES['photo']['name'])) {

                        $extension = substr(strrchr($_FILES['photo']['name'], '.'), 1);

                        $actual_image_name = 'image' . time() . "." . $extension;

                        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_path . $actual_image_name);

                        $insert['photo'] = $actual_image_name;
                    }

                    $pincode = array();

                    if (sizeof($_POST['pincode']) > 0) {

                        foreach ($_POST['pincode'] as $row) {

                            if ($row != "") {

                                $pincode = implode(',', $_POST['pincode']);
                            }
                        }
                    } else {

                        $pincode = $_POST['pincode'];
                    }

                    $insert['pincode'] = $pincode;



                    $this->home_m->insert_data('admin', $insert);

                    $message = "Your have successfully registered as GowiseKart vendor.\nUsername: " . $username . "\nPassword: " . $password . " ";

                    $this->send_sms($mobile, $message);

                    redirect(base_url("home/vendor"));
                } else {

                    $this->data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

                    $this->data['error'] = '! This username is already in use.';

                    $this->data['sub_view'] = 'vendor/add';

                    $this->data['title'] = 'Add Vendor';

                    $this->load->view("_layout", $this->data);
                }
            } else {

                $this->data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

                $this->data['category'] = $this->home_m->get_all_row_where('category', array('parent' => '0', 'status' => 'Y'));

                $this->data['sub_view'] = 'vendor/add';

                $this->data['title'] = 'Add Vendor';

                $this->load->view("_layout", $this->data);
            }
        } else {

            $select = "*";

            $this->data['admin'] = $this->home_m->get_all_row_where('admin', array('role' => 'vendor'), $select);

            $this->data['category'] = $this->home_m->get_all_row_where('category', array('parent' => '0', 'status' => 'Y'));

            $this->data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

            $this->data['sub_view'] = 'vendor/list';

            $this->data['title'] = 'Vendor';

            $this->load->view("_layout", $this->data);
        }
    }



    public function delivery_agent($param1 = '', $param2 = '', $param3 = '')

    {



        if ($param1 == 'edit' && $param2 != '') {

            if ($_POST) {

                $update_array = array(

                    'name' => $_POST['name'],

                    'city_id' => $_POST['city_id'],

                    'email' => $_POST['email'],

                    'phone' => $_POST['phone'],

                    'alternate_phone' => $_POST['alternate_phone'],

                    'is_active' => $_POST['is_active']

                );

                if (!empty($_POST['password'])) {

                    $update_array['password'] = $this->home_m->hash($_POST['password']);
                }

                $this->home_m->update_data('delivery_agent', array('delivery_agentID' => $param2), $update_array);

                redirect(base_url('home/delivery_agent/list'));
            } else {

                $data['delivery_agent'] = $this->home_m->get_single_row_where('delivery_agent', array('delivery_agentID' => $param2), $select = '*');

                $data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

                $data['title'] = "Edit Delivery Agents";

                $data['sub_view'] = "delivery_agent/edit";

                $this->load->view('_layout', $data);
            }
        } elseif ($param1 == 'add') {

            if ($_POST) {

                $name = $this->input->post('name');

                $check = $this->home_m->get_single_row_where('delivery_agent', array('name' => $name), $select = 'delivery_agentID');

                if (empty($check)) {

                    $password = $this->input->post('password');

                    $insert = $_POST;

                    $insert['password'] = $this->home_m->hash($password);

                    $this->home_m->insert_data('delivery_agent', $insert);



                    redirect(base_url("home/delivery_agent"));
                } else {

                    $this->data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

                    $this->data['error'] = '! This name is already in use.';

                    $this->data['sub_view'] = 'delivery_agent/add';

                    $this->data['title'] = 'Add Delivery Agent';

                    $this->load->view("_layout", $this->data);
                }
            } else {

                $this->data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

                $this->data['sub_view'] = 'delivery_agent/add';

                $this->data['title'] = 'Add Delivery Agent';

                $this->load->view("_layout", $this->data);
            }
        } else {

            $this->data['delivery_agent'] = $this->home_m->get_all_row_where('delivery_agent', array(), '*');

            $this->data['city'] = $this->home_m->get_all_row_where('city', array('status' => 'Y'));

            $this->data['sub_view'] = 'delivery_agent/list';

            $this->data['title'] = 'Delivery Agent';

            $this->load->view("_layout", $this->data);
        }
    }



    public function reset_delivery_psw()

    {

        if ($_SESSION['role'] == 'admin' && $_POST) {

            $id = $this->input->post('userID');

            $password = $this->input->post('pass');

            $confirm_password = $this->input->post('cpass');

            if (trim($password) != '' && trim($confirm_password) != '') {

                if ($password == $confirm_password) {

                    $password = $this->home_m->hash($password);

                    $this->home_m->update_data('delivery_agent', array('delivery_agentID' => $id), array('password' => $password));

                    echo json_encode(array('result' => 'success', 'msg' => 'Password updated Successfully'));
                } else {

                    echo json_encode(array('result' => 'failure', 'msg' => 'Password and Confirm Password Must be Same'));
                }
            } else {

                echo json_encode(array('result' => 'failure', 'msg' => 'Password and Confirm Password Both are required'));
            }
        } else {

            echo json_encode(array('result' => 'failure', 'msg' => 'Permission Denied'));
        }
    }



    public function delete_delivery_agent()

    {

        $delivery_agentID =  htmlentities(trim($this->uri->segment(3)));

        if ((int)$delivery_agentID) {

            $this->home_m->delete_data(' delivery_agent', array('delivery_agentID' => $delivery_agentID));

            $this->session->set_flashdata('success', 'Succesfully  Delivery Agent Deleted');
        }

        redirect(base_url("home/delivery_agent"));
    }

    public function agent_pending_order()
    {

        $delivery_agentID = $this->uri->segment('3');

        $this->data['orders'] = $this->home_m->get_all_table_query("SELECT * FROM `orders` WHERE `agentID`='$delivery_agentID'");

        $this->data['delivery_agent'] = $this->home_m->get_all_row_where('delivery_agent', array(), $select = '*');

        $this->data['title'] = "Agent Pending Orders";

        $this->data['sub_view'] = "delivery_agent/list";

        $this->load->view('_layout');
    }



    public function stock_report()
    {

        $this->data['sub_view'] = 'report/stock_report';

        $this->data['title'] = 'Manage Stock Purchase';

        $this->load->view("_layout", $this->data);
    }



    public function generate_stock_report()
    {



        $filename = 'stock_products_' . date('d-m-Y') . '.csv';

        header("Content-Description: File Transfer");

        header("Content-Disposition: attachment; filename=$filename");

        header("Content-Type: application/csv; ");



        $d = $this->input->post('start_date');



        // file creation 

        $file = fopen('php://output', 'w');

        $header = array("productID", "product_name", "unit_value", "unit", "qty");

        fputcsv($file, $header);

        // foreach ($products as $key=>$line){ 

        //   fputcsv($file,$line); 

        // }

        fclose($file);

        exit;
    }

    /*public function get_pincode(){ 

        $cityID = $this->input->post('city_id');  

        $locality = $this->home_m->get_all_row_where('locality',array('locality'=>$cityID));

        if(!empty($locality))

        {

           echo json_encode($locality);

        }

        

    }*/

    public function get_pincode($city_id)

    {

        $this->db->select('ID,pin');

        $locality = $this->db->get_where('locality', array('locality' => $city_id))->result();

        echo json_encode($locality);
    }

    public function report()
    {
        $to_date = date("Y-m-d");
        $from_date = date("Y-m-d");
        if ($_POST) {
            if ($this->input->post("from_date") != '') {
                $from_date = date("Y-m-d", strtotime($this->input->post("from_date")));
            }
            if ($this->input->post("to_date") != '') {
                $to_date = date("Y-m-d", strtotime($this->input->post("to_date")));
            }
            if ($this->input->post("delivery_agentID") != '') {
                $delivery_agentID = $this->input->post("delivery_agentID");
            }
        }

        $this->data['report'] = $this->sales_report($from_date, $to_date, $delivery_agentID);
        $this->data['delivery_agentID'] = $delivery_agentID;
        $this->data['delivery_agent'] = $this->db->query("select * from delivery_agent where is_active = 'Y' ")->result();
        $this->data['sub_view'] = 'report/sales_report';
        $this->data['title'] = 'Sales Report';
        $this->load->view("_layout", $this->data);
    }
    private function sales_report($to_date, $from_date, $delivery_agentID)
    {

        $query = $this->db->query("SELECT order_items.orderID,products.product_name,products.unit_value,products.unit,order_items.qty,order_items.price,order_items.net_price,orders.order_amount,orders.delivery_charges,orders.coupon_code,orders.delivery_slot,orders.coupon_discount,orders.total_amount as paid_amount,orders.updated_on, products.category_id from order_items LEFT JOIN products ON order_items.productID = products.productID LEFT JOIN orders ON order_items.orderID = orders.orderID WHERE order_items.`status` = 'DELIVERED' AND DATE(orders.updated_on) BETWEEN '$to_date' AND '$from_date' AND orders. `agentID` = '$delivery_agentID' ");
        return $query->result();
    }




    public function change_order_status()
    {
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
        $item_id = isset($_POST['item_id']) ? $_POST['item_id'] : 0;
        $order_status = isset($_POST['order_status']) ? $_POST['order_status'] : '';

        if (!empty($order_id)) {
            if (!empty($item_id)) {

                $this->home_m->update_data('order_items', array('itemID' => $item_id, 'orderID' => $order_id), array('status' => $order_status));
                $response = array('status' => true, 'message' => 'Status Updated successfully');
            } else {
                $response = array('status' => false, 'message' => 'Item ID required');
            }
        } else {
            $response = array('status' => false, 'message' => 'Order ID required');
        }


        echo json_encode($response);
    }
}
