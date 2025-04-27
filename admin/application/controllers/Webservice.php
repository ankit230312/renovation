<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

class Webservice extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("webservice_m");
        $this->load->model("home_m");
    }

    public function index()
    {
        echo "<h4>RESTRICTED ACCESS</h4>";
    }

    public function generate_random_password($length = 10)
    {
        $numbers = range('0', '9');
        $alphabets = range('A', 'Z');

        //$additional_characters = array('_','.');
        $final_array = array_merge($alphabets, $numbers);
        //$final_array = array_merge($numbers);
        $password = '';
        while ($length--) {
            $key = array_rand($final_array);
            $password .= $final_array[$key];
        }

        return $password;
    }

    // public function send_otp()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $mobile = $data['mobile'];
    //     //  $otp = $data['otp'];
    //     $otp = "123456";

    //     $message = $otp . " is your authentication code to register.";

    //     $message = urlencode($message);
    //     $this->send_sms($mobile, $message);
    //     // $this->webservice_m->table_insert('users',$mobile);
    //     $insert_data = array(
    //         'mobile' => $mobile,
    //         'otp' => $otp,
    //         'added_on' => date("Y-m-d H:i:s"),
    //         'updated_on' => date("Y-m-d H:i:s")
    //     );


    //     $userID = $this->webservice_m->table_insert('users', $insert_data);
    //     $check_mobile = $this->webservice_m->get_single_table("users", array('mobile' => $mobile));
    //     if (!empty($check_mobile)) {

    //         // $insert_data = array(
    //         //     'mobile' => $mobile,
    //         //     'otp' => $otp,
    //         //     'device_id' => $device_id ?? '',
    //         //     'device_token' => $device_token ?? '',
    //         //     'device_type' => $device_type ?? '',
    //         //     'lat' => '28.61736197339471',
    //         //     'lng' => '77.3811462257868',
    //         //     'created_at' => date("Y-m-d H:i:s"),
    //         //     'updated_at' => date("Y-m-d H:i:s")
    //         // );





    //         $response = array('result' => 'success', 'message' => 'SMS Send Successfully');
    //     } else {
    //         $response = array('result' => 'new', 'message' => 'SMS Not Send Successfully');
    //     }
    //     //send sms for otp

    //     echo json_encode($response);
    // }


    // public function send_otp()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $mobile = $data['mobile'];
    //     $otp = "123456"; // You already have this OTP

    //     // Generate a random token for authorization
    //     // Generates a 32-character hexadecimal token
    //     $token = bin2hex(random_bytes(16));
    //     $message = $otp . " is your authentication code to register.";
    //     $message = urlencode($message);

    //     $this->send_sms($mobile, $otp);

    //     $insert_data = array(
    //         'mobile' => $mobile,
    //         'otp' => $otp,
    //         'token' => $token, // Store the generated token in the database
    //         'added_on' => date("Y-m-d H:i:s"),
    //         'updated_on' => date("Y-m-d H:i:s")
    //     );
    //     // print_r($insert_data);
    //     // die();

    //     $userID = $this->webservice_m->table_insert('users', $insert_data);
    //     $check_mobile = $this->webservice_m->get_single_table("users", array('mobile' => $mobile));

    //     if (!empty($check_mobile)) {
    //         $response = array('result' => 'success', 'message' => 'SMS Sent Successfully');
    //     } else {
    //         $response = array('result' => 'new', 'message' => 'SMS Not Sent Successfully');
    //     }

    //     echo json_encode($response);
    // }

    public function send_otp()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $mobile = $data['mobile'];
        $otp = "123456"; // You already have this OTP

        // Generate a random token for authorization
        // Generates a 32-character hexadecimal token
        $token = bin2hex(random_bytes(16));
        $message = $otp . " is your authentication code to register.";
        $message = urlencode($message);

        // Check if the user with the given mobile number already exists
        $check_mobile = $this->webservice_m->get_single_table("users", array('mobile' => $mobile));

        if (!empty($check_mobile)) {
            // User exists, update their data
            $update_data = array(
                'otp' => $otp,
                'updated_on' => date("Y-m-d H:i:s")
            );

            $this->webservice_m->table_update('users', $update_data, array('mobile' => $mobile));

            $response = array('result' => 'success', 'message' => 'User updated. SMS Sent Successfully');
        } else {
            // User does not exist, create a new user
            $insert_data = array(
                'mobile' => $mobile,
                'otp' => $otp,
                'token' => $token,
                'added_on' => date("Y-m-d H:i:s"),
                'updated_on' => date("Y-m-d H:i:s")
            );

            $userID = $this->webservice_m->table_insert('users', $insert_data);

            if (!empty($userID)) {
                $response = array('result' => 'new', 'message' => 'New user created. SMS Sent Successfully');
            } else {
                $response = array('result' => 'error', 'message' => 'Failed to create a new user.');
            }
        }

        // Send the OTP via SMS
        $this->send_sms($mobile, $otp);

        echo json_encode($response);
    }


    public function send_sms($mobile, $otp)
    {
        // $mb = "91".$mobile;
        // dd($mobile);
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"61e559bdd8caa36a6b0d0c53\",\n  \"sender\": \"DILLI 7 PHARMACY\",\n  \"mobiles\": \"91$mobile\",\n  \"otp\": \"$otp\",\n  \"tekniko\": \"Tekniko\"\n}",
            CURLOPT_HTTPHEADER => [
                "authkey: 285140ArLurg2KnR61e3d660P1",
                "content-type: application/JSON"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        //echo  $response;
        return $response;
    }

    // public function login()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $mobile = $data['mobile'];

    //     $deviceID = $data['deviceID'];
    //     $device_token = $data['device_token'];
    //     $device_type = $data['device_type'];
    //     $ip_address = $_SERVER['REMOTE_ADDR'];
    //     $path = base_url('uploads/');

    //     $user = $this->webservice_m->get_single_table('users', array('mobile' => $mobile));
    //     print_r($user);
    //     die();
    //     if (!empty($user)) {
    //         $userID = $user->ID;
    //         $token = generate_token($userID);
    //         // print_r($userID);die;
    //         $img = $path . $user->image;

    //         if ($user->status == 'Y') {
    //             $response[] = array(
    //                 'result' => 'success',
    //                 'message' => 'Successful Login',
    //                 'userID' => (string)$userID,
    //                 "name" => $user->name,
    //                 "mobile" => $user->mobile,
    //                 "email" => $user->email,
    //                 "image" => $img,
    //                 "wallet" => $user->wallet,
    //                 "referral_code" => $user->referral_code

    //             );
    //         } else {
    //             $response[] = array(
    //                 "result" => 'verify',
    //                 "message" => "Your Account is disabled. Please Contact Administrator."
    //             );
    //         }
    //     } else {
    //         $response[] = array('result' => 'failure', 'message' => 'Invalid Login Credential..');
    //     }
    //     echo json_encode($response);
    // }


    public function verify_otp()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $mobile = $data['mobile'];
        $inputOTP = $data['otp'];
        // Fetch user records sorted by a timestamp column in descending order
        $this->db->order_by('ID', 'DESC');
        $query = $this->db->get_where('users', array('mobile' => $mobile));
        $user = $query->row();
        if ($query->num_rows() > 0) {
            if ($user->otp == $inputOTP) {
                $response = array(
                    'result' => 'success',
                    'message' => 'OTP verification successful',
                    'user' => $user,
                );
            } else {
                // OTP didn't match
                $response = array('result' => 'failure', 'message' => 'OTP verification failed');
            }
        } else {
            // User not found
            $response = array('result' => 'failure', 'message' => 'User not found');
        }

        echo json_encode($response);
    }



    private function calculate_product_price($productID, $basePrice, $cartQty)
    {
        // Fetch the product details from the database
        $product = $this->db->query("SELECT * FROM `products` WHERE `productID` = $productID")->row();

        if ($product) {
            // Calculate the total price based on the quantity in the cart
            $totalPrice = $basePrice * $cartQty;

            // Additional calculations or discounts can be applied here if needed

            return $totalPrice;
        } else {
            // Return the base price if the product is not found
            return $basePrice;
        }
    }
    private function product_cart_count($userID, $productID)
    {
        $query = $this->db->query("SELECT * FROM product_cart WHERE userID = $userID AND productID = $productID ORDER BY added_on DESC LIMIT 1");
        $result = $query->row();

        return isset($result->qty) ? $result->qty : "0";
    }


    // public function products()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];
    //     $categoryID = $data['categoryID'];
    //     $path3 = base_url('uploads/category');


    //     $category = $this->db->query("SELECT * FROM `category` WHERE `parent`=$categoryID AND status = 'Y'")->result();
    //     print_r($category);
    //     die();
    //     $products = $this->db->query("SELECT * FROM `products` WHERE `category_id`=$category AND in_stock = 'Y'")->result();

    //     if (!empty($products)) {
    //         foreach ($products as $p) {
    //             $brand = $this->get_brand($p->brand_id);
    //             $p->product_image = base_url('uploads/products/') . $p->product_image;
    //             $p->brand = $brand->brand;
    //             // Calculate the cart count for the product
    //             // Calculate the cart count for the product
    //             $p->cart_count = strval($this->product_cart_count($userID, $p->productID));

    //             $p->price = $this->check_deal($p->productID, $p->price);
    //         }
    //     }

    //     // If the user is new and hasn't added any items to the cart, set cart count to 0
    //     if (!isset($data['userID'])) {
    //         foreach ($products as $p) {
    //             $p->cart_count = 0;
    //         }
    //     }

    //     $sub_cat = $this->webservice_m->get_all_table_query("SELECT *  FROM `category` WHERE `parent` = $categoryID AND `status`='Y'");

    //     foreach ($sub_cat as $sc) {
    //         $sc->title =  $sc->title;
    //         $sc->image = $path3 . $sc->image;
    //     }

    //     $response = array('result' => 'success', 'products' => $products, 'sub_cat' => $sub_cat);
    //     echo json_encode($response);
    // }


    public function get_total_count_and_amount()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        if (!empty($userID)) {
            $total_cart = $this->db->query("SELECT COUNT(cartID) as count FROM product_cart WHERE userID = $userID")->result();

            if (!empty($total_cart)) {
                // Access the value using the key as an object property
                $count = $total_cart['0'];
            } else {
                echo "No cart items found.";
            }
            $total_amount = $this->db->query("SELECT SUM(amount) as amount FROM `product_cart` where userID = $userID")->result();
            $total_amount = $total_amount ? $total_amount[0]->amount : "0";

            // Check if the query returned any results

            $response = array(

                'total_cart' => $count,
                'total_amount' => $total_amount ?? "0"

            );

            echo json_encode($response);
        } else {
        }
    }


    // public function because_you_bought()
    // {
    //     // Assuming you're receiving a JSON POST request with 'userID' in the request body.
    //     $data = json_decode(file_get_contents('php://input'), true);

    //     if (isset($data['userID'])) {
    //         $userID = $data['userID'];

    //         // You should consider using prepared statements to prevent SQL injection.
    //         $query = "SELECT * FROM `product_cart` WHERE `userID` = $userID";

    //         // Assuming you have a database connection established.
    //         $order_items = $this->db->query($query)->result();

    //         $order_items_array = [];
    //         $productIDs = []; // To keep track of unique product IDs

    //         foreach ($order_items as $item) {
    //             // Append each item to the result array only if it's not a duplicate productID.
    //             if (!in_array($item->productID, $productIDs)) {
    //                 $order_items_array[] = $item;
    //                 $productIDs[] = $item->productID;
    //             }
    //         }

    //         $order_details = []; // Initialize the array for product details

    //         foreach ($order_items_array as $ord) {
    //             $query1 = "SELECT * FROM `products` WHERE `productID` = $ord->productID";

    //             // Assuming you have a database connection established.
    //             $order_details = $this->db->query($query1)->result();

    //             foreach($order_details as $ord1){
    //                 $ord1->product_image = base_url('uploads/products/') . $ord1->product_image;
    //                 // $p->product_image = base_url('uploads/products/') . $p->product_image;
    //             }

    //             // print_r($ord->product_image);
    //             // die();
    //         }

    //         $total_amount = $this->db->query("SELECT SUM(amount) as amount FROM `product_cart` where userID = $userID")->result();

    //         $total_amount = $total_amount ? $total_amount[0]->amount : "0";

    //         $total_cart = $this->db->query("SELECT COUNT(cartID) FROM product_cart WHERE userID = $userID")->result();

    //         // Check if the query returned any results
    //         if (!empty($total_cart)) {
    //             // Access the value using the key as an object property
    //             $count = $total_cart[0]->{'COUNT(cartID)'};
    //         } else {
    //             echo "No cart items found.";
    //         }

    //         $response = array(
    //             'order_items' => $order_items_array,
    //             'product_you_bought' => $order_details,
    //             'total_cart' => $count,
    //             'total_amount' => $total_amount ?? "0"
    //         );

    //         echo json_encode($response);
    //     } else {
    //         // Handle the case where 'userID' is not provided in the request.
    //         echo json_encode(array('error' => 'Missing userID'));
    //     }
    // }

    public function because_you_bought()
    {
        // Assuming you're receiving a JSON POST request with 'userID' in the request body.
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['userID'])) {
            $userID = $data['userID'];

            // You should consider using prepared statements to prevent SQL injection.
            $query = "SELECT * FROM `product_cart` WHERE `userID` = $userID";

            // Assuming you have a database connection established.
            $order_items = $this->db->query($query)->result();

            $order_items_array = [];
            $productIDs = []; // To keep track of unique product IDs

            foreach ($order_items as $item) {
                // Append each item to the result array only if it's not a duplicate productID.
                if (!in_array($item->productID, $productIDs)) {
                    $order_items_array[] = $item;
                    $productIDs[] = $item->productID;
                }
            }

            $order_details = [];
            $qty = []; // Initialize the array for product details

            foreach ($order_items_array as $ord) {
                $query1 = "SELECT * FROM `products` WHERE `productID` = $ord->productID";

                // Assuming you have a database connection established.
                $product_detail = $this->db->query($query1)->result();

                $query2 = "SELECT qty FROM `product_cart` WHERE `productID` = $ord->productID";
                $product_qty = $this->db->query($query2)->result();

                foreach ($product_qty as $pro_qty) {
                    $qty = $pro_qty->qty;
                }
                foreach ($product_detail as $ord1) {
                    $ord1->product_image = base_url('uploads/products/') . $ord1->product_image;
                    $ord1->cart_qty = $qty ?? "0";
                }

                $order_details[] = $product_detail[0]; // Add product detail to the array
            }

            $total_amount = $this->db->query("SELECT SUM(amount) as amount FROM `product_cart` where userID = $userID")->result();

            $total_amount = $total_amount ? $total_amount[0]->amount : "0";

            $total_cart = $this->db->query("SELECT COUNT(cartID) as count FROM product_cart WHERE userID = $userID")->result();

            // Check if the query returned any results
            if (!empty($total_cart)) {
                // Access the value using the key as an object property
                $count = $total_cart[0]->count;
            } else {
                echo "No cart items found.";
            }

            $response = array(
                'order_items' => $order_items_array,
                'product_you_bought' => $order_details,
                'total_cart' => $count,
                'total_amount' => $total_amount ?? "0"
            );

            echo json_encode($response);
        } else {
            // Handle the case where 'userID' is not provided in the request.
            echo json_encode(array('error' => 'Missing userID'));
        }
    }


    public function products()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $categoryID = $data['categoryID'];
        $path3 = base_url('uploads/category/');
        $baner_apth = base_url('uploads/banners/');

        $categories = $this->db->query("SELECT * FROM `category` WHERE `parent`=$categoryID AND status = 'Y'")->result();

        $response = array();
        foreach ($categories as $category) {
            $categoryID = $category->categoryID;
            $category->icon = $path3 . $category->icon;
            $category->image = $path3 . $category->image;

            $app_banners = $this->db->get_where("app_banners", array("categoryID" => $category->categoryID))->result();

            if (isset($app_banners[0])) {
                // Process the non-empty array here
                foreach ($app_banners as $banner_app) {
                    $banner_app->banner = $baner_apth . $banner_app->banner;
                    $banner_apps = $banner_app;
                }
            } elseif ($app_banners[0] > 0) {
                $app_banners = [];
            } else {
                $app_banners = [];
            }

            $products = $this->db->query("SELECT * FROM `products` WHERE `category_id`=$categoryID  AND in_stock = 'Y'")->result();
            usort($products, function ($a, $b) {
                return $b->stock_count - $a->stock_count;
            });

            $total_amount = 0;
            if (!empty($products)) {
                foreach ($products as $p) {
                    $brand = $this->get_brand($p->brand_id);
                    $p->product_image = base_url('uploads/products/') . $p->product_image;
                    $p->brand = $brand->brand ?? "0";
                    $p->cart_count = strval($this->product_cart_count($userID, $p->productID));
                    $p->price = $this->check_deal($p->productID, $p->price);
                    // $p->price = strval($this->calculate_product_price($p->productID, $p->price, $p->cart_count));
                    $total_amount += $p->price;
                }
            }


            $total_cart = $this->db->query("SELECT COUNT(cartID) FROM product_cart WHERE userID = $userID")->result();
            if (!empty($total_cart)) {
                // Access the value using the key as an object property
                $count = $total_cart[0]->{'COUNT(cartID)'};
            } else {
                echo "No cart items found.";
            }
            $total_amount = $this->db->query("SELECT SUM(amount) as amount FROM `product_cart` where userID = $userID")->result();
            $total_amount = $total_amount ? $total_amount[0]->amount : "0";

            // Check if the query returned any results

            $response[] = array(
                'category' => $category,
                'products' => $products,
                'banner' => $banner_apps ?? [],
                'total_cart' => $count,
                'total_amount' => $total_amount ?? "0"

            );
        }

        $final_response = array('result' => 'success', 'categories' => $response);
        echo json_encode($final_response);
    }




    public function products_by_brand()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $brandID = $data['brandID']; // Remove the extra space here
        $path3 = base_url('uploads/brand/');

        $query = $this->db->query("SELECT * FROM `brand` WHERE `brandID` = ?", array($brandID));

        if ($query !== FALSE) {
            $brands = $query->result(); // Fetch all brands as an array
            $response = array();

            foreach ($brands as $brand) {
                $brandID = $brand->brandID; // Use a different variable name to avoid conflict
                $brand->icon = $path3 . $brand->icon;
                $brand->image = $path3 . $brand->image;

                // $products = $this->db->query("SELECT * FROM `products` WHERE `brand_id` = $brandID AND in_stock = 'Y'")->result();
                $products = $this->db->query("SELECT * FROM `products` WHERE `brand_id` = $brandID AND in_stock = 'Y' ORDER BY stock_count DESC")->result();

                if (!empty($products)) {
                    foreach ($products as $p) {
                        $brandInfo = $this->get_brand($p->brand_id);
                        $p->product_image = base_url('uploads/products/') . $p->product_image;
                        $p->brand = $brandInfo->brand ?? "0"; // Use a different variable for brand info
                        $p->cart_count = strval($this->product_cart_count($userID, $p->productID)) ?? "0";
                        $p->cart_qty = $p->cart_qty ?? "0";
                        $p->price = $this->check_deal($p->productID, $p->price);
                    }
                }

                $total_amount = $this->db->query("SELECT SUM(amount) as amount FROM `product_cart` where userID = $userID")->result();
                // print_r($total_amount['0']->amount);
                // die();
                $total_amount = $total_amount ? $total_amount[0]->amount : "0";

                $total_cart = $this->db->query("SELECT COUNT(cartID) FROM product_cart WHERE userID = $userID")->result();

                // Check if the query returned any results
                if (!empty($total_cart)) {
                    // Access the value using the key as an object property
                    $count = $total_cart[0]->{'COUNT(cartID)'};
                } else {
                    echo "No cart items found.";
                }


                $response[] = array(
                    'brand' => $brand,
                    'products' => $products,
                    'total_cart' => $count,
                    'total_amount' => $total_amount ?? "0"
                );
            }

            $final_response = array('result' => 'success', 'brandList' => $response);
            echo json_encode($final_response);
        } else {
            // Handle the database error here
            echo "Database error: " . $this->db->error(); // Replace with appropriate error handling
        }
    }



    private function user_exists($userID)
    {
        $query = $this->db->get_where('users', array('ID' => $userID));
        return $query->num_rows() > 0;
    }


    

    // public function add_cart()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];
    //     $productID = $data['productID'];
    //     $variantID = $data['variantID'];
    //     $qty = $data['qty'];

    //     // Check if the same item already exists in the user's cart
    //     $existingCartItem = $this->db->query("SELECT * FROM product_cart WHERE userID = $userID AND productID = $productID")->row();
    //     if (empty($variantID)) {
    //         // If variantID is empty, retrieve the first product variant
    //         $firstProductVariant = $this->db->query("SELECT * FROM products_variant WHERE product_id = $productID LIMIT 1")->row();

    //         if (!$firstProductVariant) {
    //             // If no product variant is found, return an error response
    //             $response = array(
    //                 'result' => 'error',
    //                 'message' => 'No product variant found for the specified product.',
    //             );
    //             echo json_encode($response);
    //             return;
    //         }

    //         $variantID = $firstProductVariant->id;
    //     }
    //     if ($existingCartItem) {
    //         $product = $this->db->query("SELECT * FROM products_variant WHERE product_id = $existingCartItem->productID && id = $variantID")->row();
            
    //         // Update the quantity of the existing item
    //         $newQty = $existingCartItem->qty + $qty;

    //         // Check if the stock is available
    //         if ($newQty <= $product->stock_count) {

    //             $existingCartItem->amount += $product->price;
    //             $this->db->where('cartID', $existingCartItem->cartID);
    //             $this->db->update('product_cart', array('qty' => $newQty, 'amount' => $existingCartItem->amount));

    //             // Calculate the amount for this product based on the new quantity
    //             $totalAmount = strval($existingCartItem->amount);

    //             $message = 'Item quantity updated in the cart.';
    //         } else {

    //             $total_cart = $this->db->query("SELECT COUNT(cartID) as count FROM product_cart WHERE userID = $userID")->row();
    //             $count = $total_cart->count;
    //             $totalAmount = strval($existingCartItem->amount); // Use the existing totalAmount
    //             $message = 'Item quantity not updated. Stock is not available.';
    //             $response = array(
    //                 'result' => 'false',
    //                 'message' => $message,
    //                 'total_cart' => $count,
    //                 'total_amount' => strval($totalAmount),
    //             );
    //             echo json_encode($response);
    //             return; // Stop execution
    //         }
    //     } else {
    //         $product = $this->db->query("SELECT * FROM products WHERE productID = $productID")->row();
    //         $total_cart = $this->db->query("SELECT COUNT(cartID) as count FROM product_cart WHERE userID = $userID")->row();
    //         $count = $total_cart->count;
    //         // Check if the stock is available
    //         if ($qty <= $product->stock_count) {
    //             // Insert the new cart item
    //             $insertData = array(
    //                 'userID' => $userID,
    //                 'productID' => $productID,
    //                 'variantID' => $variantID,
    //                 'qty' => $qty,
    //                 'amount' => $product->price,
    //                 'added_on' => date("Y-m-d H:i:s")
    //             );
    //             $this->db->insert('product_cart', $insertData);
    //             $totalAmount = $_SESSION['totalAmount'] + $qty * $product->price;
    //             $message = 'Item added to cart successfully.';
    //         } else {
    //             $total_cart = $this->db->query("SELECT COUNT(cartID) as count FROM product_cart WHERE userID = $userID")->row();
    //             $count = $total_cart->count;
    //             // $totalAmount = $_SESSION['totalAmount']; // Use the existing totalAmount
    //             $message = 'Item not added to cart. Stock is not available.';
    //             $response = array(
    //                 'result' => 'false',
    //                 'message' => $message,
    //                 'total_cart' => $count,
    //                 // 'total_amount' => strval($totalAmount),
    //             );
    //             echo json_encode($response);
    //             return; // Stop execution
    //         }
    //     }

    //     // Store the new total amount in session
    //     $_SESSION['totalAmount'] = $totalAmount;
    //     // Retrieve the total cart count
    //     $total_cart = $this->db->query("SELECT COUNT(cartID) as count FROM product_cart WHERE userID = $userID")->row();

    //     // Check if the query returned any results
    //     $count = $total_cart->count;

    //     $response = array(
    //         'result' => 'true',
    //         'message' => $message,
    //         'total_cart' => $count,
    //         'total_amount' => $totalAmount,
    //     );
    //     echo json_encode($response);
    // }


    public function add_cart()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $productID = $data['productID'];
        $variantID = $data['variantID'];
        $qty = $data['qty'];

        // Check if the same item already exists in the user's cart
        $existingCartItem = $this->db->query("SELECT * FROM product_cart WHERE userID = $userID AND productID = $productID")->row();
        if (empty($variantID)) {
            // If variantID is empty, retrieve the first product variant
            $firstProductVariant = $this->db->query("SELECT * FROM products_variant WHERE product_id = $productID LIMIT 1")->row();

            if (!$firstProductVariant) {
                // If no product variant is found, return an error response
                $response = array(
                    'result' => 'error',
                    'message' => 'No product variant found for the specified product.',
                );
                echo json_encode($response);
                return;
            }

            $variantID = $firstProductVariant->id;
        }
        if ($existingCartItem) {
            $product = $this->db->query("SELECT * FROM products_variant WHERE product_id = $existingCartItem->productID && id = $variantID")->row();
            
            // Update the quantity of the existing item
            $newQty = $existingCartItem->qty + $qty;

            // Check if the stock is available
            if ($newQty <= $product->stock_count) {

                $existingCartItem->amount += $product->price;
                $this->db->where('cartID', $existingCartItem->cartID);
                $this->db->update('product_cart', array('qty' => $newQty, 'amount' => $existingCartItem->amount));
                
                // Calculate the amount for this product based on the new quantity
                $totalAmount = strval($existingCartItem->amount);

                $message = 'Item quantity updated in the cart.';
            } else {

                $total_cart = $this->db->query("SELECT COUNT(cartID) as count FROM product_cart WHERE userID = $userID")->row();
                $count = $total_cart->count;
                $totalAmount = strval($existingCartItem->amount); // Use the existing totalAmount
                $message = 'Item quantity not updated. Stock is not available.';
                $response = array(
                    'result' => 'false',
                    'message' => $message,
                    'total_cart' => $count,
                    'total_amount' => strval($totalAmount),
                );
                echo json_encode($response);
                return; // Stop execution
            }
        } else {
            $product = $this->db->query("SELECT * FROM products WHERE productID = $productID")->row();
            $total_cart = $this->db->query("SELECT COUNT(cartID) as count FROM product_cart WHERE userID = $userID")->row();
            $count = $total_cart->count;
            // Check if the stock is available
            if ($qty <= $product->stock_count) {
                // Insert the new cart item
                $insertData = array(
                    'userID' => $userID,
                    'productID' => $productID,
                    'variantID' => $variantID,
                    'qty' => $qty,
                    'amount' => $product->price,
                    'added_on' => date("Y-m-d H:i:s")
                );
                $this->db->insert('product_cart', $insertData);
                $totalAmount = $_SESSION['totalAmount'] + $qty * $product->price;
                $message = 'Item added to cart successfully.';
            } else {
                $total_cart = $this->db->query("SELECT COUNT(cartID) as count FROM product_cart WHERE userID = $userID")->row();
                $count = $total_cart->count;
                // $totalAmount = $_SESSION['totalAmount']; // Use the existing totalAmount
                $message = 'Item not added to cart. Stock is not available.';
                $response = array(
                    'result' => 'false',
                    'message' => $message,
                    'total_cart' => $count,
                    // 'total_amount' => strval($totalAmount),
                );
                echo json_encode($response);
                return; // Stop execution
            }
        }

        // Store the new total amount in session
        $_SESSION['totalAmount'] = $totalAmount;
        // Retrieve the total cart count
        $total_cart = $this->db->query("SELECT COUNT(cartID) as count FROM product_cart WHERE userID = $userID")->row();

        // Check if the query returned any results
        $count = $total_cart->count;

        $response = array(
            'result' => 'true',
            'message' => $message,
            'total_cart' => $count,
            'total_amount' => $totalAmount,
        );
        echo json_encode($response);
    }




    // public function decrease_cart_item()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];
    //     $productID = $data['productID'];

    //     // Check if the user exists (pseudo code to demonstrate the concept)
    //     if ($this->user_exists($userID)) {
    //         // Check if the item exists in the user's cart
    //         $existingCartItem = $this->db->query("SELECT * FROM product_cart WHERE userID = $userID AND productID = $productID")->row();

    //         if ($existingCartItem) {
    //             // Decrease the quantity of the existing item by 1
    //             $newQty = max(0, $existingCartItem->qty - 1);
    //             $this->db->where('cartID', $existingCartItem->cartID);
    //             $this->db->update('product_cart', array('qty' => $newQty));

    //             // Retrieve updated cart item details
    //             $updatedCartItem = $this->db->get_where('product_cart', ['cartID' => $existingCartItem->cartID])->row();
    //             $total_cart = $this->db->query("SELECT COUNT(cartID) FROM product_cart WHERE userID = $userID")->result();

    //             // Check if the query returned any results
    //             if (!empty($total_cart)) {
    //                 // Access the value using the key as an object property
    //                 $count = $total_cart[0]->{'COUNT(cartID)'};
    //             } else {
    //                 echo "No cart items found.";
    //             }

    //             $response = array(
    //                 'result' => 'success',
    //                 'message' => 'Item quantity decreased',
    //                 'updatedCartItem' => $updatedCartItem,
    //                 'total_cart' => $count
    //             );
    //         } else {
    //             $response = array(
    //                 'result' => 'failure',
    //                 'message' => 'Item not found in cart'
    //             );
    //         }
    //     } else {
    //         $response = array(
    //             'result' => 'failure',
    //             'message' => 'User does not exist'
    //         );
    //     }

    //     echo json_encode($response);
    // }

    // public function decrease_cart_item()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];
    //     $productID = $data['productID'];

    //     // Check if the user exists (pseudo code to demonstrate the concept)
    //     if ($this->user_exists($userID)) {
    //         // Check if the item exists in the user's cart
    //         $existingCartItem = $this->db->query("SELECT * FROM product_cart WHERE userID = $userID AND productID = $productID")->row();

    //         if ($existingCartItem) {
    //             // Decrease the quantity of the existing item by 1
    //             $newQty = max(0, $existingCartItem->qty - 1);

    //             if ($newQty == 0) {
    //                 // If the new quantity is 0, delete the record
    //                 $this->db->where('productID', $existingCartItem->productID);
    //                 $this->db->delete('product_cart');
    //             } else {
    //                 // Update the quantity
    //                 $this->db->where('cartID', $existingCartItem->cartID);
    //                 $this->db->update('product_cart', array('qty' => $newQty));
    //             }

    //             // Retrieve updated cart item details
    //             $updatedCartItem = $this->db->get_where('product_cart', ['cartID' => $existingCartItem->cartID])->row();
    //             $total_cart = $this->db->query("SELECT COUNT(cartID) FROM product_cart WHERE userID = $userID")->result();

    //             // Check if the query returned any results
    //             if (!empty($total_cart)) {
    //                 // Access the value using the key as an object property
    //                 $count = $total_cart[0]->{'COUNT(cartID)'};
    //             } else {
    //                 echo "No cart items found.";
    //             }

    //             $response = array(
    //                 'result' => 'success',
    //                 'message' => 'Item quantity decreased',
    //                 'updatedCartItem' => $updatedCartItem,
    //                 'total_cart' => $count
    //             );
    //         } else {
    //             $response = array(
    //                 'result' => 'failure',
    //                 'message' => 'Item not found in cart'
    //             );
    //         }
    //     } else {
    //         $response = array(
    //             'result' => 'failure',
    //             'message' => 'User does not exist'
    //         );
    //     }

    //     echo json_encode($response);
    // }

    // public function decrease_cart_item()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];
    //     $productID = $data['productID'];

    //     // Check if the user exists (pseudo code to demonstrate the concept)
    //     if ($this->user_exists($userID)) {
    //         // Check if the item exists in the user's cart
    //         $existingCartItem = $this->db->query("SELECT * FROM product_cart WHERE userID = $userID AND productID = $productID")->row();

    //         if ($existingCartItem) {
    //             // Decrease the quantity of the existing item by 1
    //             $newQty = max(0, $existingCartItem->qty - 1);
    //             $update_amount = $this->db->query("SELECT * FROM products WHERE productID = $productID")->row();
    //             print_r($update_amount->price);
    //             die();

    //             if ($newQty == 0) {
    //                 // If the new quantity is 0, delete the record
    //                 $this->db->where('cartID', $existingCartItem->cartID);
    //                 $this->db->delete('product_cart');
    //             } else {
    //                 // Update the quantity
    //                 $this->db->where('cartID', $existingCartItem->cartID);
    //                 $this->db->update('product_cart', array('qty' => $newQty));
    //             }

    //             // Calculate the total amount for the remaining items in the cart
    //             $totalAmount = $this->calculateTotalAmount($userID);

    //             // Retrieve updated cart item details
    //             $updatedCartItem = $this->db->get_where('product_cart', ['cartID' => $existingCartItem->cartID])->row();
    //             $total_cart = $this->db->query("SELECT COUNT(cartID) FROM product_cart WHERE userID = $userID")->result();

    //             // Check if the query returned any results
    //             if (!empty($total_cart)) {
    //                 // Access the value using the key as an object property
    //                 $count = $total_cart[0]->{'COUNT(cartID)'};
    //             } else {
    //                 echo "No cart items found.";
    //             }

    //             $response = array(
    //                 'result' => 'success',
    //                 'message' => 'Item quantity decreased',
    //                 'updatedCartItem' => $updatedCartItem,
    //                 'total_cart' => $count,
    //                 'total_amount' => $totalAmount, // Include the total amount in the response
    //             );
    //         } else {
    //             $response = array(
    //                 'result' => 'failure',
    //                 'message' => 'Item not found in cart'
    //             );
    //         }
    //     } else {
    //         $response = array(
    //             'result' => 'failure',
    //             'message' => 'User does not exist'
    //         );
    //     }

    //     echo json_encode($response);
    // }
    public function decrease_cart_item()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $productID = $data['productID'];

        // Check if the user exists (pseudo code to demonstrate the concept)
        if ($this->user_exists($userID)) {
            // Check if the item exists in the user's cart
            $existingCartItem = $this->db->query("SELECT * FROM product_cart WHERE userID = $userID AND productID = $productID")->row();

            if ($existingCartItem) {
                // Get the current quantity and price of the item
                $currentQty = $existingCartItem->qty;
                $itemPrice = $existingCartItem->amount / $currentQty;

                // Decrease the quantity of the existing item by 1
                $newQty = max(0, $currentQty - 1);

                if ($newQty == 0) {
                    // If the new quantity is 0, delete the record
                    $this->db->where('cartID', $existingCartItem->cartID);
                    $this->db->delete('product_cart');
                } else {
                    // Update the quantity and amount
                    $newAmount = $itemPrice * $newQty;
                    $this->db->where('cartID', $existingCartItem->cartID);
                    $this->db->update('product_cart', array('qty' => $newQty, 'amount' => $newAmount));
                }

                // Calculate the total amount for the remaining items in the cart
                $totalAmount = $this->calculateTotalAmount($userID);

                // Retrieve updated cart item details
                $updatedCartItem = $this->db->get_where('product_cart', ['cartID' => $existingCartItem->cartID])->row();
                $total_cart = $this->db->query("SELECT COUNT(cartID) FROM product_cart WHERE userID = $userID")->result();

                // Check if the query returned any results
                if (!empty($total_cart)) {
                    // Access the value using the key as an object property
                    $count = $total_cart[0]->{'COUNT(cartID)'};
                } else {
                    echo "No cart items found.";
                }

                $response = array(
                    'result' => 'success',
                    'message' => 'Item quantity decreased',
                    'updatedCartItem' => $updatedCartItem,
                    'total_cart' => $count,
                    'total_amount' => $totalAmount, // Include the total amount in the response
                );
            } else {
                $response = array(
                    'result' => 'failure',
                    'message' => 'Item not found in cart'
                );
            }
        } else {
            $response = array(
                'result' => 'failure',
                'message' => 'User does not exist'
            );
        }

        echo json_encode($response);
    }


    // Function to calculate the total amount for the user's cart
    private function calculateTotalAmount($userID)
    {
        // Query to calculate the total amount based on the items in the cart
        $query = "SELECT SUM(amount) AS total_amount 
        FROM product_cart 
        WHERE userID = $userID";

        $result = $this->db->query($query)->row();

        return ($result) ? $result->total_amount : 0;
    }



    // public function get_cart()
    // {
    //     // Retrieve user ID from request
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];

    //     // Retrieve cart items from the database based on user ID
    //     $query = $this->db->query("
    //     SELECT pc.*, p.*
    //     FROM product_cart pc
    //     JOIN products p ON pc.productID = p.productID
    //     WHERE pc.userID = $userID AND pc.qty > 0
    //     ORDER BY pc.added_on DESC   ");

    //     $cartData = $query->result_array();





    //     // print_r($cartData);
    //     // die();
    //     $path2 = base_url('uploads/products/');

    //     foreach ($cartData as $item) {

    //         $item['product_image'] = $path2 . $item['product_image'];
    //         $img[] = $item['product_image'];
    //     }

    //     if (!empty($cartData)) {
    //         $response = array(
    //             'result' => 'success',
    //             'message' => 'Cart items retrieved successfully',
    //             'cartData' => $cartData,
    //             "path" => $img
    //         );
    //     } else {
    //         $response = array(
    //             'result' => 'failure',
    //             'message' => 'No cart items found',
    //             'cartData' => [],
    //             "path" => []
    //         );
    //     }

    //     echo json_encode($response);
    // }



    // public function get_cart()
    // {
    //     // Retrieve user ID from request
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];

    //     // Retrieve cart items from the database based on user ID
    //     $query = $this->db->query("
    //     SELECT pc.*, p.*
    //     FROM product_cart pc
    //     JOIN products p ON pc.productID = p.productID
    //     WHERE pc.userID = $userID AND pc.qty > 0
    //     ORDER BY pc.added_on DESC");

    //     $cartData = $query->result_array();

    //     $path2 = base_url('uploads/products/');
    //     $totalAmount = 0; // Initialize total amount
    //     $billDetails = array(); // Initialize bill details array

    //     foreach ($cartData as &$item) { // Use & to modify $item in place
    //         $item['product_image'] = $path2 . $item['product_image'];
    //         $item['subtotal'] = $item['price'] * $item['qty']; // Calculate subtotal
    //         $totalAmount += $item['subtotal']; // Add subtotal to total amount
    //         $item['product_image'] = $path2 . $item['product_image'];
    //         $img[] = $item['product_image'];
    //         // Add product details to bill details array
    //         $billDetails[] = array(
    //             'product_name' => $item['product_name'],

    //             'quantity' => $item['qty'],
    //             'price' => $item['price'],
    //             'subtotal' => $item['subtotal'],
    //         );
    //     }

    //     $discountAvailable = 'N'; // Assume no discount by default

    //     // Check if a discount is available (you can add your logic here)

    //     if ($discountAvailable === 'Y') {
    //         // If a discount is available, set the flag to 'Y'
    //         $discountAvailable = 'Y';
    //     }

    //     if (!empty($cartData)) {
    //         $response = array(
    //             'result' => 'success',
    //             'message' => 'Cart items retrieved successfully',
    //             'cartData' => $cartData,
    //             'path' => $img,
    //             'bill_details' => $billDetails, // Include bill details
    //             'discount_available' => $discountAvailable, // Include discount flag
    //             'totalAmount' => $totalAmount // Include total amount in response
    //         );
    //     } else {
    //         $response = array(
    //             'result' => 'failure',
    //             'message' => 'No cart items found',
    //             'cartData' => [],
    //             'path' => [],
    //             'bill_details' => [], // Initialize bill details array when no items are found
    //             'discount_available' => 'N', // Initialize discount flag to 'N' when no items are found
    //             'totalAmount' => 0 // Initialize total amount to 0 when no items are found
    //         );
    //     }

    //     echo json_encode($response);
    // }


    // public function get_cart()
    // {
    //     // Retrieve user ID from request
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];

    //     // Retrieve cart items from the database based on user ID
    //     $query = $this->db->query("
    // SELECT pc.*, p.*
    // FROM product_cart pc
    // JOIN products p ON pc.productID = p.productID
    // WHERE pc.userID = $userID AND pc.qty > 0
    // ORDER BY pc.added_on DESC");

    //     $cartData = $query->result_array();

    //     $path2 = base_url('uploads/products/');
    //     $totalAmount = 0; // Initialize total amount
    //     $billDetails = array(); // Initialize bill details array
    //     $pro_total = "0";
    //     foreach ($cartData as &$item) { // Use & to modify $item in place

    //         $item['subtotal'] = $item['price'] * $item['qty'];
    //         $pro_total += $item['subtotal']; // Calculate subtotal
    //         $totalAmount += $item['subtotal']; // Add subtotal to total amount
    //         $item['product_image'] = $path2 . $item['product_image'];
    //         $img[] = $item['product_image'];
    //         // Add product details to bill details array
    //         $billDetails[] = array(
    //             'product_name' => $item['product_name'],
    //             'quantity' => $item['qty'],
    //             'price' => $item['price'],
    //             'subtotal' => strval($item['subtotal']),

    //         );
    //     }

    //     $couponDiscount = 0.00; // Initialize coupon discount to 0
    //     $deliveryCharges = 0.00; // Initialize delivery charges to 0

    //     // Check if coupon_code and coupon_discount exist and apply them (you can add your logic here)
    //     if (isset($data['coupon_code']) && isset($data['coupon_discount'])) {
    //         // Apply the coupon discount
    //         $couponDiscount = floatval($data['coupon_discount']);
    //         $totalAmount -= $couponDiscount; // Deduct coupon discount from total amount
    //     }

    //     // Check if delivery_charges exist and add them (you can add your logic here)
    //     if (isset($data['delivery_charges'])) {
    //         // Add delivery charges
    //         $deliveryCharges = floatval($data['delivery_charges']);
    //         $totalAmount += $deliveryCharges; // Add delivery charges to total amount
    //     }

    //     $discountAvailable = 'N'; // Assume no discount by default

    //     // Check if a discount is available (you can add your logic here)
    //     if ($discountAvailable === 'Y') {
    //         // If a discount is available, set the flag to 'Y'
    //         $discountAvailable = 'Y';
    //     }

    //     if (!empty($cartData)) {
    //         $response = array(
    //             'result' => 'success',
    //             'message' => 'Cart items retrieved successfully',
    //             'cartData' => $cartData,
    //             'path' => $img,
    //             'bill_details' => $billDetails ?? 0,
    //             'product_total' => $pro_total, // Include bill details
    //             'discount_available' => $discountAvailable, // Include discount flag
    //             'coupon_discount' => strval($couponDiscount), // Include coupon discount
    //             'delivery_charges' => strval($deliveryCharges), // Include delivery charges
    //             'totalAmount' => strval($totalAmount) // Include total amount in response

    //         );
    //     } else {
    //         $response = array(
    //             'result' => 'failure',
    //             'message' => 'No cart items found',
    //             'cartData' => [],
    //             'path' => [],
    //             'bill_details' => [], // Initialize bill details array when no items are found
    //             'discount_available' => 'N', // Initialize discount flag to 'N' when no items are found
    //             // Initialize total amount to 0 when no items are found
    //             'coupon_discount' => strval($couponDiscount), // Include coupon discount
    //             'delivery_charges' => strval($deliveryCharges), // Include delivery charges
    //             'totalAmount' => "0"  // Include total amount in response
    //         );
    //     }

    //     echo json_encode($response);
    // }

    public function get_cart()
    {
        // Retrieve user ID from request
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = isset($data['userID']) ? $data['userID'] : null;

        // Check if $userID is null or empty
        if (empty($userID)) {
            $response = array(
                'result' => 'error',
                'message' => 'Invalid input data. userID is required.'
            );
            echo json_encode($response);
            return; // Exit the function
        }

        // Retrieve cart items from the database based on user ID
        $query = $this->db->query("
            SELECT pc.*, p.*
            FROM product_cart pc
            JOIN products p ON pc.productID = p.productID
            WHERE pc.userID = $userID AND pc.qty > 0
            ORDER BY pc.added_on DESC");

        $cartData = $query->result_array();


        $path2 = base_url('uploads/products/');
        $totalAmount = 0; // Initialize total amount
        $billDetails = array(); // Initialize bill details array
        $pro_total = 0;
        $img = array(); // Initialize image array

        foreach ($cartData as &$item) { // Use & to modify $item in place
            $item['subtotal'] = $item['price'] * $item['qty'];
            $pro_total += $item['subtotal']; // Calculate subtotal
            $totalAmount += $item['subtotal']; // Add subtotal to total amount
            $item['product_image'] = $path2 . $item['product_image'];
            $img[] = $item['product_image'];
            // Add product details to bill details array
            $billDetails[] = array(
                'product_name' => $item['product_name'],
                'quantity' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => strval($item['subtotal']),
            );
        }

        $couponDiscount = 0; // Initialize coupon discount to 0
        $deliveryCharges = 0; // Initialize delivery charges to 0

        // Check if coupon_code and coupon_discount exist and apply them
        if (isset($data['coupon_code']) || isset($data['coupon_discount'])) {
            // Retrieve coupon code and discount from request data
            $couponCode = $data['coupon_code'];
            $couponDiscount = intval($data['coupon_discount']) ?? 0;

            // Check if a valid coupon exists with the given code
            $coupon = $this->db->get_where('offers', array('offer_code' => $couponCode))->row();

            if ($coupon) {
                // Calculate the coupon discount based on the coupon type (percentage or fixed amount)
                if ($coupon->offer_type === 'PERCENTAGE') {
                    $couponDiscount = ($coupon->offer_value / 100) * $pro_total;
                } elseif ($coupon->offer_type === 'FIXED') {
                    $couponDiscount = min($couponDiscount, $coupon->offer_value); // Apply the smaller of the two values
                }
            }

            // Deduct the coupon amount from the total amount
            $totalAmount -= $couponDiscount;
        }

        // Retrieve delivery charges from settings
        $deliveryCharges = 0;
        $setting_data = "";
        $setting =  $this->db->get('settings');
        if ($setting->num_rows() > 0) {
            $setting_data = $setting->row();

            if ($pro_total > $setting_data->free_delivery_amount) {
                $deliveryCharges = 0;
            } else {
                $deliveryCharges = $setting_data->delivery_charge;
            }


            // Add delivery charges to total amount
            $totalAmount += $deliveryCharges;
        } else {
            $response = array(
                'result' => 'error',
                'message' => 'No data found for the given product ID.'
            );
            echo json_encode($response);
            return; // Exit the function
        }

        $discountAvailable = 'N'; // Assume no discount by default

        // Check if a discount is available (you can add your logic here)
        if ($discountAvailable === 'Y') {
            // If a discount is available, set the flag to 'Y'
            $discountAvailable = 'Y';
        }

        if (!empty($cartData)) {
            $response = array(
                'result' => 'success',
                'message' => 'Cart items retrieved successfully',
                'cartData' => $cartData,
                'path' => $img,
                'bill_details' => $billDetails ?? 0,
                'product_total' => strval($pro_total), // Include bill details
                'discount_available' => $discountAvailable, // Include discount flag
                'coupon_code' => $couponCode ?? "", // Include applied coupon code
                'coupon_discount' => strval($couponDiscount), // Include coupon discount
                'delivery_charges' => strval($deliveryCharges), // Include delivery charges
                'totalAmount' => strval($totalAmount),
                'min_order_amount' => $setting_data->min_order_amount // Include total amount in response
            );
        } else {
            $response = array(
                'result' => 'failure',
                'message' => 'No cart items found',
                'cartData' => [],
                'path' => [],
                'bill_details' => [], // Initialize bill details array when no items are found
                'discount_available' => 'N', // Initialize discount flag to 'N' when no items are found
                'coupon_code' => '' ?? "", // Include applied coupon code
                'coupon_discount' => strval($couponDiscount), // Include coupon discount
                'delivery_charges' => strval($deliveryCharges), // Include delivery charges
                'totalAmount' => "0"  // Include total amount in response
            );
        }

        echo json_encode($response);
    }





    public function remove_cart()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $productID = $data['productID'];
        $variantID = $data['variantID'];

        // Load the session library
        $this->load->library('session');

        // Retrieve cart data from session
        $cartData = $this->session->userdata('cart_data');

        if (!empty($cartData)) {
            // Iterate through the cart items to find and remove the specified item
            $filteredCart = array_filter($cartData, function ($item) use ($userID, $productID, $variantID) {
                return ($item['userID'] == $userID &&
                    $item['productID'] == $productID &&
                    $item['variantID'] == $variantID
                );
            });

            if (!empty($filteredCart)) {
                // Remove the item from the cart data
                $removedItem = array_shift($filteredCart);

                // Update the cart data in the session
                $this->session->set_userdata('cart_data', array_values($cartData));

                $response = array(
                    'result' => 'success',
                    'message' => 'Item removed from cart successfully',
                    'removedItem' => $removedItem,
                    'remainingCart' => array_values($cartData)
                );
            } else {
                $response = array(
                    'result' => 'failure',
                    'message' => 'Item not found in cart for the provided criteria'
                );
            }
        } else {
            $response = array(
                'result' => 'failure',
                'message' => 'Cart is empty'
            );
        }

        echo json_encode($response);
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

        // Fetch user records sorted by ID in descending order (latest first)
        // $users = $this->webservice_m->get_single_table('users', array('mobile' => $mobile), 'DESC');
        $this->db->order_by('ID', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get('users');
        $users = $query->row();

        if (!empty($users)) {
            $userID = $user->ID;
            $token = $users->token;
            $img = $path . $user->image;

            if ($users->status == 'Y') {
                $response[] = array(
                    'result' => 'success',
                    'message' => 'Successful Login',
                    'userID' => (string)$userID,
                    "name" => $user->name,
                    "mobile" => $user->mobile,
                    "email" => $user->email,
                    "token" => $token,
                    "image" => $img,
                    "wallet" => $user->wallet,
                    "referral_code" => $user->referral_code
                );
            } else {
                $response[] = array(
                    "result" => 'verify',
                    "message" => "Your Account is disabled. Please Contact Administrator.",

                );
            }
        } else {
            $response[] = array('result' => 'failure', 'message' => 'Invalid Login Credential..');
        }
        echo json_encode($response);
    }


    public function signup()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        // $name = $data['name'];
        // $email = $data['email'];
        // $mobile = $data['mobile'];
        // $deviceID = $data['deviceID'];
        // $device_token = $data['device_token'];
        // $device_type = $data['device_type'];
        $name = $data['name'];
        $email = $data['email'];
        $mobile = $data['mobile'];
        $deviceID = "5234535";
        $device_token = "u#$54345";
        $device_type = "4535434534";
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $img = base_url('uploads/user.png');
        $created_on = date('Y-m-d H:i:s');
        $referral_code = strtoupper(substr($name, 0, 2)) . $this->generate_random_password(6);

        $check_email = $this->webservice_m->get_single_table("users", array('email' => $email));
        if ($check_email) {
            $response[] = array('result' => 'failure', 'message' => 'Email ID Already Exist');
        } else {
            $referral_userID = '0';
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


            $userID = $this->webservice_m->table_insert('users', $array);


            $this->webservice_m->update_device($userID, $ip_address, $deviceID, $device_token, $device_type);



            //send email & sms
            // $this->signup_email($to,$message,$subject,$referral_code);
            $response[] = array('result' => 'success', 'message' => 'Successful Signup', 'userID' => (string)$userID, "name" => $name, "mobile" => $mobile, "email" => $email, "image" => $img, "referral_code" => $referral_code);
        }


        echo json_encode($response);
    }


    public function test_send_email($subject = 'Test Email', $referral_code = 'GTR45U', $message = 'test', $to = 'anisha@teknikoglobal.com')
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
        $get_user = $this->webservice_m->get_single_table("users", array('referral_code' => $code));
        if (count($get_user)) {
            $get_user_r = $this->webservice_m->get_single_table("users", array('referral_code' => $code));
            $referral_userID = $get_user_r->userID;
            $this->db->query("UPDATE `users` SET `referral_userID`='$referral_userID' WHERE `userID`='$userID'");
            $response[] = array('result' => 'success', 'message' => 'Valid Referral Code');
        } else {
            $response[] = array('result' => 'failure', 'message' => 'Invalid Referral Code');
        }
        echo json_encode($response);
    }

    // public function home()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];
    //     $path = base_url('uploads/banners/');
    //     $this->db->select('sum(qty) as count');
    //     $cart_item_count = $this->db->get_where('product_cart', array('userID' => $userID))->row();
    //     $user = $this->webservice_m->get_user(array('ID' => $userID));
    //     $banners = $this->webservice_m->get_all_data_where('app_banners', array('status' => 'Y'), 'priority', 'desc');

    //     foreach ($banners as $b) {
    //         $b->banner = $path . $b->banner;
    //     }
    //     $category  = $this->webservice_m->get_all_data_where('category', array('status' => 'Y'), 'priority', 'desc');
    //     $brand  = $this->db->get("brand")->result();

    //     $response = array('result' => 'success', 'banners' => $banners, 'category' => $category, 'brand' => $brand, 'cart_count' => $cart_item_count->count);
    //     echo json_encode($response);
    // }



    public function get_category()
    {

        $path3 = base_url('uploads/category/');

        $category  = $this->webservice_m->get_all_data_where('category', array('parent' => '0', 'status' => 'Y'), 'priority', 'desc');
        // $brand  = $this->db->get("brand")->result();


        foreach ($category as $cats) {
            $cats->image = $path3 . $cats->image;
        }
        $response = array('result' => 'success', 'category' => $category);
        echo json_encode($response);
    }


    public function home()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $brand_path = base_url('uploads/brand/');
        $path = base_url('uploads/banners/');
        $path3 = base_url('uploads/category/');
        $product_path = base_url('uploads/products/');
        $this->db->select('sum(qty) as count');
        $cart_item_count = $this->db->get_where('product_cart', array('userID' => $userID))->row();
        $user = $this->webservice_m->get_user(array('ID' => $userID));
        // $banners = $this->webservice_m->get_all_data_where('app_banners', array('status' => 'Y'), 'priority', 'desc');

        // foreach ($banners as $b) {
        //     $b->banner = $path . $b->banner;
        // }

        // $all_banners = $banners->map(function($item){
        //     $item->categoryID;
        //     print_r($item->categoryID);
        //     $item->bannner_name = $this->db->query("select * from category where categoryID =  $item->categoryID;");
        //     return $item;
        // });

        $banners = $this->webservice_m->get_all_data_where('app_banners', array('status' => 'Y'), 'priority', 'desc');

        foreach ($banners as $key => $b) {
            $banners[$key]->banner = $path . $b->banner;

            $categoryID = $b->categoryID;
            // print_r($categoryID);

            // Assuming $this->db is properly initialized earlier in your code
            $query = $this->db->query("SELECT title FROM category WHERE categoryID = $categoryID");
            $banners[$key]->bannner_name = $query->result();
        }

        // Now $banners contains the updated data


        $category  = $this->webservice_m->get_all_data_where('category', array('parent' => '0', 'status' => 'Y'), 'priority', 'desc');
        // $brand  = $this->db->get("brand")->result();


        foreach ($category as $cats) {
            $cats->image = $path3 . $cats->image;
        }
        $sub_cat = $this->webservice_m->get_all_table_query("SELECT `categoryID`, `title`,`image`  FROM `category` WHERE `parent` != '0' AND `status`='Y'");
        //   print_r($subcats);die;
        foreach ($sub_cat as $sc) {

            $sc->image = $path3 . $sc->image;
        }

        $brand = $this->webservice_m->get_all_table_query("SELECT * FROM `brand` ORDER BY added_on DESC LIMIT 6");
        foreach ($brand as $b_sc) {

            $b_sc->image = $brand_path . $b_sc->image;
        }




        try {
            $query = "SELECT * FROM products ORDER BY added_on DESC LIMIT 7";
            // Execute the query
            $products = $this->db->query($query);
            // print_r($products->num_rows);
            // die();

            // Check if any rows were returned
            if ($products) {
                // Fetch the results as an array
                $product_data = $products->result();
                foreach ($product_data as $p_sc) {

                    $p_sc->product_image = $product_path . $p_sc->product_image;
                }

                // Prepare the response
                $response = array('result' => 'success', 'new_arrival' => $product_data);
            } else {
                // No rows were returned
                $response = array('result' => 'success', 'new_arrival' => 'No products found.');
            }
        } catch (Exception $e) {
            // Handle any exceptions or database errors here
            $response = array('result' => 'error', 'message' => $e->getMessage());
        }


        $response = array('result' => 'success', 'banners' => $banners, 'category' => $category, 'sub_cat' => $sub_cat, 'brand' => $brand, 'cart_count' => $cart_item_count->count ?? "", 'new_arrival' => $product_data);
        echo json_encode($response);
        //print_r($response);die;
    }

    public function get_product($productID)
    {
        $product = $this->webservice_m->get_single_table('products', array('productID' => $productID));
        return $product;
    }

    // public function new_arrival($productID)
    // {
    //     $product = $this->db->query('products', array('productID' => $productID));
    //     $response[] = array('result' => 'success', 'new_arrival' => $product);
    //     echo json_encode($response);
    // }
    // public function new_arrival()
    // {
    //     // Modify the SQL query to retrieve the latest added products
    //     $query = "SELECT * FROM products ORDER BY added_on DESC ";


    //     // Execute the query with the parameters
    //     $products = $this->db->query($query);
    //     // Prepare the response
    //     $response = array('result' => 'success', 'new_arrival' => $products);

    //     // Encode the response as JSON and echo it
    //     echo json_encode($response);
    // }

    public function new_arrival()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $product_path = base_url('uploads/products/');

        if (!empty($userID)) {
            // Modify the SQL query to retrieve the latest added products
            $query = "SELECT * FROM products ORDER BY added_on DESC LIMIT 7";



            try {
                $query = "SELECT * FROM products ORDER BY added_on DESC LIMIT 7";
                // Execute the query
                $products = $this->db->query($query);
                // print_r($products->num_rows);
                // die();

                // Check if any rows were returned
                if ($products) {
                    // Fetch the results as an array
                    $product_data = $products->result();
                    foreach ($product_data as $p_sc) {

                        $p_sc->product_image = $product_path . $p_sc->product_image;
                    }

                    // Prepare the response
                    $response = array('result' => 'success', 'new_arrival' => $product_data);
                } else {
                    // No rows were returned
                    $response = array('result' => 'success', 'new_arrival' => 'No products found.');
                }
            } catch (Exception $e) {
                // Handle any exceptions or database errors here
                $response = array('result' => 'error', 'message' => $e->getMessage());
            }

            // Encode the response as JSON and echo it
            echo json_encode($response);
        } else {
            $response[] = array('result' => 'false', 'message' => "User Not Exist");
            echo json_encode($response);
        }
    }



    public function get_brand($brandID)
    {
        $brand = $this->webservice_m->get_single_table('brand', array('brandID' => $brandID));
        return $brand;
    }

    public function get_brand_home()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $brand_path = base_url('uploads/brand/');
        if (!empty($userID)) {
            $brand = $this->webservice_m->get_all_table_query("SELECT * FROM `brand` ORDER BY added_on DESC LIMIT 6");
            foreach ($brand as $b_sc) {

                $b_sc->image = $brand_path . $b_sc->image;
            }

            $response = array('result' => 'success', 'brand' => $brand);
            echo json_encode($response);
        } else {
            $response = array('result' => 'false', 'message' => "User Not Exist");
            echo json_encode($response);
        }
    }


    public function get_categories()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $path1 = base_url('admin/uploads/category/');
        $category = $this->webservice_m->get_all_data_where('category', array('parent' => '0', 'status' => 'Y'));
        foreach ($category as $c) {
            $c->icon = $path1 . $c->icon;
            $c->image = $path1 . $c->image;
            $c->subcategories = $this->subcategory($c->categoryID);
        }
        $response[] = array('result' => 'success', 'category' => $category);
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
        $subCategoryID = $data['subCategoryID'];
        $path1 = base_url('admin/uploads/category/');
        $subcategory = $this->webservice_m->get_all_data_where('category', array('parent' => $subCategoryID, 'status' => 'Y'));
        foreach ($subcategory as $c) {
            $c->icon = $path1 . $c->icon;
            $c->image = $path1 . $c->image;
        }

        print_r($subcategory);
        die();


        $products = $this->db->query("SELECT * FROM `products` WHERE `category_id`=$subcategory->productID AND in_stock = 'Y'")->result();

        if (!empty($products)) {
            foreach ($products as $p) {
                $brand = $this->get_brand($p->brand_id);
                $p->product_image = base_url('uploads/products/') . $p->product_image;
                $p->brand = $brand->brand;
                // Calculate the cart count for the product
                // Calculate the cart count for the product
                $p->cart_count = strval($this->product_cart_count($userID, $p->productID));

                $p->price = $this->check_deal($p->productID, $p->price);
            }
        }


        $response[] = array('result' => 'success', 'subcategory' => $subcategory, 'product ' => $products);
        echo json_encode($response);
    }

    public function get_category_subcategories()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $categoryID = $data['categoryID'];
        $path1 = base_url('admin/uploads/category/');
        $path2 = base_url('admin/uploads/product/');

        // Fetch subcategories based on category ID
        $subcategories = $this->webservice_m->get_all_data_where('category', array('parent' => $categoryID, 'status' => 'Y'));

        foreach ($subcategories as $subcategory) {
            $subcategory->icon = $path1 . $subcategory->icon;
            $subcategory->image = $path1 . $subcategory->image;

            // Fetch products for this subcategory
            $subcategory->products = $this->webservice_m->get_all_data_where('products', array('category_id' => $subcategory->subcategory_id));

            foreach ($subcategory->products as $product) {
                $product->product_image = $path2 . $product->product_image;
            }
        }

        $response[] = array('result' => 'success', 'subcategories' => $subcategories);
        echo json_encode($response);
    }

    public function feature_banners()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $path = base_url('uploads/banners/');
        $feature_banners = $this->webservice_m->get_all_data_where('featured_banner', array('status' => 'Y'), 'priority', 'desc');
        foreach ($feature_banners as $fb) {
            $fb->banner = $path . $fb->banner;
        }
        $response[] = array('result' => 'success', 'feature_banners' => $feature_banners);
        echo json_encode($response);
    }

    public function deals()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $d = date('Y-m-d');
        $products = array();
        $path2 = base_url('admin/uploads/products/');
        $deal_banner = $this->webservice_m->get_single_table("deal_banner", array("status" => "Y"));
        if (!empty($deal_banner)) {
            $deal_banner->banner = base_url('admin/uploads/banners/') . $deal_banner->banner;
        }
        $deals = $this->db->query("SELECT * FROM `deals` WHERE (`start_date` <= '$d' AND `end_date`>='$d') AND `status`='Y'")->result();
        foreach ($deals as $d) {
            $product = $this->get_product($d->productID);
            $brand = $this->get_brand($product->brand_id);
            $products[] = array(
                'productID' => $product->productID,
                'product_name' => $product->product_name,
                'product_image' => $path2 . $product->product_image,
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
        $response[] = array('result' => 'success', 'products' => $products, "deal_banner" => $deal_banner);
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
        foreach ($deals as $d) {
            $product = $this->get_product($d->productID);
            $brand = $this->get_brand($product->brand_id);
            $products[] = array(
                'productID' => $product->productID,
                'product_name' => $product->product_name,
                'product_image' => $path2 . $product->product_image,
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
        $response[] = array('result' => 'success', 'products' => $products);
        echo json_encode($response);
    }

    public function gift_banner()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $gift_banner = $this->webservice_m->get_single_table("gift_banner", array("status" => "Y"));
        if (!empty($gift_banner)) {
            $gift_banner->banner = base_url('admin/uploads/banners/') . $gift_banner->banner;
        }
        $response[] = array('result' => 'success', 'gift_banner' => $gift_banner);
        echo json_encode($response);
    }



    // Replace this code with the appropriate method in your Webservice.php controller
    // Replace this code with the appropriate method in your Webservice.php controller





    // function update_cart_order()
    // {
    //     $userID  = $data['userID'];
    //     $cart_item_count = $this->db->get_where('product_cart', array('userID' => $userID))->row();
    //     print_r($cart_item_count);
    //     //$orderCart = $this->db->update('oredrer',);
    // }



    private function check_deal($productID, $price)
    {
        $check = $this->webservice_m->get_single_table('deals', array('productID' => $productID), $select = '*');
        if (!empty($check) && strtotime($check->end_date) > time() && strtotime($check->start_date) < time()) {
            $price = $check->deal_price;
        }
        return $price;
    }



    public function coupons()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $d = date('Y-m-d');
        if (!empty($userID)) {
            $offers =  $this->db->get("offers")->result();


            $response = array('result' => 'success', 'offers' => $offers);
            echo json_encode($response);
        } else {
            $response = array('result' => 'false', 'offers' => []);
            echo json_encode($response);
        }
    }

    // public function search_product()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];
    //     $key = $data['key'];
    //     $products = $this->webservice_m->get_all_table_query("SELECT * FROM `products` WHERE `product_name` LIKE '%$key%'");
    //     if (!empty($products)) {
    //         foreach ($products as $p) {
    //             // print_r($p);
    //             $brand = $this->get_brand($p->brand_id);
    //             $p->product_image = base_url('uploads/products/') . $p->product_image;
    //             //$p->brand = $brand->brand;
    //             $p->brand = '';
    //             $p->cart_count = $this->product_cart_count($userID, $p->productID);
    //             $p->price = $this->check_deal($p->productID, $p->price);
    //         }
    //     }
    //     $response = array('result' => 'success', 'products' => $products);
    //     echo json_encode($response);
    // }

    public function get_brand_seeacrh($brandID)
    {
        $brand = $this->home_m->get_all_row_where('brand', array('brandID' => $brandID));
        return $brand;
    }

    public function search_product()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $key = $data['key'];

        // Get the last search query for the user
        $lastSearchQuery = $this->get_last_search_query($userID);

        if (empty($key) && !empty($lastSearchQuery)) {
            // If the user didn't provide a new search query but has a previous search query, use the last query
            $key = $lastSearchQuery;
        }

        // Store the current search query in the database
        // $this->store_search_query($userID, $key);

        // Perform the product search based on the search query
        $this->db->like('product_name', $key);
        $products = $this->db->get('products')->result();

        $uniqueBrands = []; // Create an array to store unique brand names

        if (!empty($products)) {
            foreach ($products as $p) {
                $brand = $this->get_brand_seeacrh($p->brand_id);
                if (!empty($brand)) {
                    foreach ($brand as $brd) {
                        $brd_name[] = $brd->title;
                        $uniqueBrands[] = $brd->title;
                        $brd_name_single = $brd->title; // Store the brand name in the uniqueBrands array
                    }
                }
                $p->cart_qty = $p->cart_qty ?? "0";
                $p->product_image = base_url('uploads/products/') . $p->product_image;
                $p->brand = $brd_name_single;
                $p->cart_count = $this->product_cart_count($userID, $p->productID);
                $p->price = $this->check_deal($p->productID, $p->price);
            }
        }

        // Remove duplicates from the brand names and convert to an indexed array
        $uniqueBrands = array_values(array_unique($uniqueBrands));
        $this->store_search_query($userID, $key,$uniqueBrands);
        $response = array('result' => 'success', 'products' => $products, 'brand' => $uniqueBrands);
        echo json_encode($response);
    }



    private function store_search_query($userID, $query,$uniqueBrands)
    {
        // Insert the search query into the search_history table
        $brandNameString = implode(', ', $uniqueBrands);
        $data = array(
            'userID' => $userID,
            'search_query' => $query,
            'brand_name' => $brandNameString,
            'search_timestamp' => date('Y-m-d H:i:s')
        );
        $this->db->insert('search_history', $data);
    }

    private function get_last_search_query($userID)
    {
        // Retrieve the last search query for the user from the search_history table
        $this->db->select('search_query');
        $this->db->from('search_history');
        $this->db->where('userID', $userID);
        $this->db->order_by('search_timestamp', 'desc');
        $this->db->limit(3);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->search_query;
        } else {
            return '';
        }
    }

    public function search()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $key = $data['key'];
        $products = $this->webservice_m->get_all_table_query("SELECT `productID`,`product_name` FROM `products` WHERE `product_name` LIKE '%$key%'");
        $response[] = array('result' => 'success', 'products' => $products);
        echo json_encode($response);
    }



    // public function product_detail()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = isset($data['userID']) ? $data['userID'] : "";
    //     $productID = isset($data['productID']) ? $data['productID'] : "";

    //     // Check if $userID or $productID is null or empty
    //     if (empty($userID) || empty($productID)) {
    //         $response = array(
    //             'result' => 'error',
    //             'message' => 'Invalid input data. Both userID and productID are required.'
    //         );
    //         echo json_encode($response);
    //         return; // Exit the function
    //     }

    //     $product = $this->webservice_m->get_single_table("products", array("productID" => $productID));
    //     $query = $this->db->get_where('products_variant', array('product_id' => $productID));

    //     if ($query->num_rows() > 0) {
    //         $product_variant = $query->result();
    //     } else {
    //         $response = array(
    //             'result' => 'error',
    //             'message' => 'No data found for the given product Vareint.'
    //         );
    //         echo json_encode($response);
    //         return; // Exit the function
    //     }

    //     $total_amount = $this->db->query("SELECT SUM(amount) as amount FROM `product_cart` where userID = $userID")->result();
    //     $total_amount = $total_amount ? $total_amount[0]->amount : "0";

    //     if (!empty($product)) {
    //         $brand = $this->get_brand($product->brand_id);

    //         $product->product_image = base_url('uploads/products/') . $product->product_image;
    //         $product->product_image = array($product->product_image);
    //         $product->brand = "Y";
    //         $product->cart_qty = $product->cart_qty ?? "0";
    //         $product->product_varient = $product_variant;
    //         if (!empty($brand)) {
    //             $product->brand_ID = $brand->brandID;
    //         }

    //         $query = $this->db->query("SELECT * FROM `brand` WHERE `brandID` = $product->brand_ID");
    //         $brands_name = $query->result();

    //         $product->cart_count = $this->product_cart_count($userID, $product->productID);
    //         $product->price = $this->check_deal($product->productID, $product->price);

    //         $total_cart = $this->db->query("SELECT COUNT(cartID) FROM product_cart WHERE userID = $userID")->result();
    //         $count = (!empty($total_cart)) ? $total_cart[0]->{'COUNT(cartID)'} : "0";
    //     } else {
    //         $response = array(
    //             'result' => 'error',
    //             'message' => 'Product not found.'
    //         );
    //         echo json_encode($response);
    //         return; // Exit the function
    //     }

    //     if (empty($brands_name)) {
    //         $response = array(
    //             'result' => 'error',
    //             'message' => 'Brand not found.'
    //         );
    //         echo json_encode($response);
    //         return; // Exit the function
    //     }

    //     if (empty($total_cart)) {
    //         $response = array(
    //             'result' => 'error',
    //             'message' => 'No cart items found.'
    //         );
    //         echo json_encode($response);
    //         return; // Exit the function
    //     }

    //     // If everything is successful, create the response
    //     $response = array(
    //         'result' => 'success',
    //         'product' => $product,
    //         "brand_name" => $brands_name[0]->title,
    //         'total_cart' => $count,
    //         'total_amount' => $total_amount
    //     );

    //     echo json_encode($response);
    // }

    public function get_variant_qty($userID, $variantID)
    {
        // Assuming you have a table named 'product_cart' containing user's cart data
        // You need to query this table to get the quantity of a specific variant for the given user

        $query = $this->db->query("SELECT qty FROM product_cart WHERE userID = $userID AND variantID = $variantID");

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return intval($result->qty);
        } else {
            return 0; // Variant not found in the user's cart, return 0 quantity
        }
    }


    public function product_detail()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = isset($data['userID']) ? $data['userID'] : "";
        $productID = isset($data['productID']) ? $data['productID'] : "";

        // Check if $userID or $productID is null or empty
        if (empty($userID) || empty($productID)) {
            $response = array(
                'result' => 'error',
                'message' => 'Invalid input data. Both userID and productID are required.'
            );
            echo json_encode($response);
            return; // Exit the function
        }

        $product = $this->webservice_m->get_single_table("products", array("productID" => $productID));

        // Check if the product exists in the database
        if (empty($product)) {
            $response = array(
                'result' => 'error',
                'message' => 'Product not found.'
            );
            echo json_encode($response);
            return; // Exit the function
        }

        // Fetch product variants for the given productID
        $query = $this->db->get_where('products_variant', array('product_id' => $productID));
        $product_variant = $query->result();

        $product_variants = array(); // Create an array for product variants

        if (!empty($product_variant)) {          // print_r($product_variant);



            foreach ($product_variant as $pv) {
                $variantID = $pv->id;
                $query = $this->db->get_where('product_cart', array('variantID' => $variantID));
                $product_cat_data = $query->result();

                if (empty($product_cat_data)) {
                    $product_cat_data = ""; // or $product_cat_data = array(); if you prefer an empty array
                } else {
                    // Calculate the total amount for this variant based on cart quantities and variant prices
                    $totalVariantAmount = 0;
                    foreach ($product_cat_data as $cartItem) {
                        $totalVariantAmount += ($cartItem->qty * $pv->price);
                    }
    
                    // Add the total amount to the product variant
                    $pv->total_amount = $totalVariantAmount;
                }
                // print_r($product_cat_data);

                // print_r($pv->id);


                $pv->variant_image = base_url('uploads/products/') . $pv->variant_image;
                $pv->variant_image = $pv->variant_image ?? [];
                $pv->qty = $this->get_variant_qty($userID, $pv->id);
                $product_variants[] = $pv; // Store each product variant in the $product_variants array
            }
        } else {
            $product_variants = array(); // If no variants, initialize an empty array
        }

        $brand = $this->get_brand($product->brand_id);

        $product->product_image = base_url('uploads/products/') . $product->product_image;
        $product->product_image = array($product->product_image);
        $product->brand = "Y";
        $product->cart_qty = $product->cart_qty ?? "0";

        if (!empty($brand)) {
            $product->brand_ID = $brand->brandID ?? "0";
            // Fetch brand details
            $query = $this->db->query("SELECT * FROM `brand` WHERE `brandID` = $product->brand_ID");
            $brands_name = $query->result();
        }

        // Calculate the cart count for the user and the price after checking for any deals
        $product->cart_count = $this->product_cart_count($userID, $product->productID);
        $product->price = $this->check_deal($product->productID, $product->price);

        // Calculate the total cart items count for the user
        $total_cart = $this->db->query("SELECT COUNT(cartID) FROM product_cart WHERE userID = $userID")->result();
        $count = (!empty($total_cart)) ? $total_cart[0]->{'COUNT(cartID)'} : "0";
        $total_amount = $this->db->query("SELECT SUM(amount) as amount FROM `product_cart` where userID = $userID")->result();
        $total_amount = $total_amount ? $total_amount[0]->amount : "0";

        // If everything is successful, create the response
        $response = array(
            'result' => 'success',
            'product' => $product,
            'product_variants' => $product_variants, // Include the product variants in the response
            "brand_name" => (!empty($brands_name)) ? $brands_name[0]->title : "Brand not found",
            'total_cart' => $count,
            'total_amount' => $total_amount ?? "0"
        );

        echo json_encode($response);
    }



    public function similar_products()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $productID = $data['productID'];
        $products = $this->webservice_m->get_all_data_where("products", array("productID !=" => $productID));
        $total_amount = $this->db->query("SELECT SUM(amount) as amount FROM `product_cart` where userID = $userID")->result();
        // print_r($total_amount['0']->amount);
        // die();
        $total_amount = $total_amount ? $total_amount[0]->amount : "0";
        if (!empty($products)) {
            foreach ($products as $product) {
                $brand = $this->get_brand($product->brand_id);
                $product->product_image = base_url('/uploads/products/') . $product->product_image;
                //$product->brand = $brand->brand;
                $product->brand = '';
                $product->cart_count = $this->product_cart_count($userID, $product->productID);
                $product->price = $this->check_deal($product->productID, $product->price);
                // $p->price = $this->calculate_product_price($p->productID, $p->price, $p->cart_count);
                // $total_amount += $p->price;
            }
            $total_cart = $this->db->query("SELECT COUNT(cartID) FROM product_cart WHERE userID = $userID")->result();

            // Check if the query returned any results
            if (!empty($total_cart)) {
                // Access the value using the key as an object property
                $count = $total_cart[0]->{'COUNT(cartID)'};
            } else {
                echo "No cart items found.";
            }
        }
        $response = array('result' => 'success', 'products' => $products, 'total_cart' => $count, 'total_amount' => $total_amount ?? "0");
        echo json_encode($response);
    }

    public function update_cart()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $productID = $data['productID'];
        $qty = $data['qty'];
        $check = $this->webservice_m->get_single_table("product_cart", array('userID' => $userID, 'productID' => $productID));

        //print_r($check);
        $a = array('userID' => $userID, 'productID' => $productID, 'qty' => $qty, 'added_on' => date('Y-m-d H:i:s'));
        if (!empty($check)) {
            //update
            if ($qty == '0') {
                $this->db->where(array('cartID' => $check->cartID));
                $this->db->delete('product_cart');
            } else {
                $this->db->where(array('cartID' => $check->cartID));
                $this->db->update('product_cart', $a);
            }
        } else {
            //insert

            $this->webservice_m->table_insert('product_cart', $a);
        }
        $this->db->select('sum(qty) as count');
        $cart_item_count = $this->db->get_where('product_cart', array('userID' => $userID))->row();
        //print_r( $cart_item_count);
        $response = array('result' => 'success', 'cart_count' => $cart_item_count->count);
        //print_r($response);
        echo json_encode($response);
    }

    public function list_user_cart()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $carts = $this->webservice_m->get_all_data_where('product_cart', array('userID' => $userID));
        $products = array();
        if (!empty($carts)) {
            foreach ($carts as $c) {
                $product = $this->webservice_m->get_single_table("products", array("productID" => $c->productID));
                if (!empty($product)) {
                    $brand = $this->get_brand($product->brand_id);
                    $product->product_image = base_url('admin/uploads/products/') . $product->product_image;
                    //$product->brand = $brand->brand;
                    $product->brand = '';
                    $product->qty = $c->qty;
                    $product->net_price = $c->qty * $product->price;
                    $product->price = $this->check_deal($product->productID, $product->price);
                }
                array_push($products, $product);
            }
            $response[] = array('result' => 'success', 'products' => $products);
        } else {
            $response[] = array('result' => 'success');
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
        $settings = $this->webservice_m->get_single_table('settings', array('ID' => 1), $select = '*');
        $user = $this->db->get_where('users', array('ID' => $userID))->row();
        $wallet_amount = $user->wallet;
        if (!empty($settings)) {
            $delivery_charges = $settings->delivery_charge;
            $min_order_amount = $settings->min_order_amount;
            $max_order_amount = $settings->max_order_amount;
            $free_delivery_amount = $settings->free_delivery_amount;
        }
        $response[] = array('result' => 'success', 'delivery_charges' => $delivery_charges, 'min_order_amount' => $min_order_amount, 'max_order_amount' => $max_order_amount, 'free_delivery_amount' => $free_delivery_amount, 'wallet_amount' => $wallet_amount, 'gst' => 0);
        echo json_encode($response);
    }



    public function my_order_data()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = isset($data['userID']) ? $data['userID'] : "";
        $status = isset($data['status']) ? $data['status'] : "";
        if ($userID != '') {
            $check_user_id = $this->db->get_where('users', array('id' => $userID))->result();
            if (!empty($check_user_id)) {
                $list = array();
                if (isset($status) && !empty($status)) {
                    $this->db->where(array('status' => $status));
                }
                $this->db->order_by("orderID", "desc");

                $order_data =  $this->db->get_where('orders', array('userID' => $userID))->result();

                foreach ($order_data as $key) {


                    $order_item = $this->db->get_where('order_items', array('orderID' => $key->orderID))->result();



                    $item = array();
                    foreach ($order_item as $key1) {
                        $product_data = $this->db->get_where('products', array('productID' => $key1->productID))->row();
                        $data_item = array(
                            'itemID'                        => $key1->itemID,
                            'productID'                     => $key1->productID,
                            'variantID'                     => $key1->variantID,
                            'qty'                           => $key1->qty,
                            'price'                         => $key1->price,
                            'net_price'                     => $key1->net_price,
                            'status'                        => $key1->status,
                            'added_on'                      => $key1->added_on,
                            'product_name'                  => $product_data->product_name,
                            'product_image'                 => base_url('uploads/variants/') . $product_data->product_image,
                            'product_description'           => $product_data->product_description,
                            'benefit'                       => $product_data->benefit,
                        );
                        array_push($item, $data_item);
                    }
                    $data = array(
                        'orderID'         => $key->orderID,
                        'cityID'          => $key->cityID,
                        'userID'          => $key->userID,
                        'vendorID'        => $key->vendorID,
                        'customer_name'   => $key->customer_name,
                        'contact_no'      => $key->contact_no,
                        'house_no'        => $key->house_no,
                        'apartment'       => $key->apartment,
                        'landmark'         => $key->landmark,
                        'location'         => $key->location,
                        'latitude'         => $key->latitude,
                        'longitude'        => $key->longitude,
                        'address_type'     => $key->address_type,
                        'agentID'          => $key->agentID,
                        'coupon_code'      => $key->coupon_code,
                        'type'             => $key->type,
                        'coupon_discount'  => $key->coupon_discount,
                        'delivery_charges' => $key->delivery_charges,
                        'order_amount'     => $key->order_amount,
                        'total_amount'     => $key->total_amount,
                        'cashback_amount'  => $key->cashback_amount,
                        'payment_method'   => $key->payment_method,
                        'instruction'      => $key->instruction,
                        'delivery_date'    => $key->delivery_date,
                        'delivery_slot'    => $key->delivery_slot,
                        'status'           => $key->status,
                        'rate_status'           => $key->rate_status,
                        'rate_value'           => $key->rate_value,
                        'order_from'       => $key->order_from,
                        'added_on'         => $key->added_on,
                        'updated_on'       => $key->updated_on,
                        'item'             => $item,
                    );
                    array_push($list, $data);
                }
                if ($list) {
                    $response = array('result' => 'success', 'message' => 'successfully', 'data' => $list);
                } else {
                    $response = array('result' => 'success', 'message' => 'No data', 'data' => []);
                }
            } else {
                $response = array('result' => 'failure', 'message' => 'userID Invalid', 'data' => []);
            }
        } else {
            $response = array('result' => 'failure', 'message' => 'userID Required', 'data' => []);
        }

        echo json_encode($response);
    }



    // public function rate_order()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = isset($data['userID']) ? $data['userID'] : "";
    //     $orderID = isset($data['orderID']) ? $data['orderID'] : "";
    //     $rate_value = isset($data['rate_value']) ? $data['rate_value'] : "";

    //     // Validate rate_value
    //     if (empty($rate_value)) {
    //         $response = array('message' => 'Rate value is required');
    //         echo json_encode($response);
    //         return; // Exit the function if rate_value is not provided
    //     }

    //     // Validate rate_value within the range of 0 to 5
    //     if ($rate_value < 0 || $rate_value > 5) {
    //         $response = array('message' => 'Rate value must be between 0 and 5');
    //         echo json_encode($response);
    //         return; // Exit the function if rate_value is out of range
    //     }

    //     // Load the database library


    //     // Check if the user and order exist (you may need to replace 'users' and 'orders' with your actual table names)
    //     $this->db->where('userID', $userID);
    //     $this->db->where('orderID', $orderID);
    //     $query_check = $this->db->get('orders');

    //     if ($query_check->num_rows() > 0) {
    //         // User and order exist, proceed to insert the rating

    //         // Prepare data for the 'rate' table
    //         $rate_data = array(
    //             'orderID' => $orderID,
    //             'userID' => $userID,
    //             'rate_value' => $rate_value,                
    //         );

    //         // Insert the rating data into the 'rate' table
    //         $this->db->insert('rate', $rate_data);



    //         // Check if the insertion was successful
    //         if ($this->db->affected_rows() > 0) {
    //             $this->db->where('orderID', $orderID);
    //             $this->db->update('orders', array('rate_status' => 'Y'));
    //             // Rating inserted successfully
    //             $response = array('message' => 'Rating added successfully');
    //             echo json_encode($response);
    //         } else {
    //             // Handle the case when the insertion fails
    //             $response = array('message' => 'Failed to add rating');
    //             echo json_encode($response);
    //         }
    //     } else {
    //         // Handle the case when the user or order does not exist
    //         $response = array('message' => 'User or order not found');
    //         echo json_encode($response);
    //     }
    // }


    public function rate_order()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = isset($data['userID']) ? $data['userID'] : "";
        $orderID = isset($data['orderID']) ? $data['orderID'] : "";
        $rate_value = isset($data['rate_value']) ? $data['rate_value'] : "";

        // Validate rate_value
        if (empty($rate_value)) {
            $response = array('message' => 'Rate value is required');
            echo json_encode($response);
            return; // Exit the function if rate_value is not provided
        }

        // Validate rate_value within the range of 0 to 5
        if ($rate_value < 0 || $rate_value > 5) {
            $response = array('message' => 'Rate value must be between 0 and 5');
            echo json_encode($response);
            return; // Exit the function if rate_value is out of range
        }

        // Load the database library
        $this->load->database();

        // Check if the user and order exist (you may need to replace 'users' and 'orders' with your actual table names)
        $this->db->where('userID', $userID);
        $this->db->where('orderID', $orderID);
        $query_check = $this->db->get('orders');

        if ($query_check->num_rows() > 0) {
            // User and order exist

            // Check if the order status is 'delivered'
            $order = $query_check->row();
            if ($order->status === 'DELIVERED') {
                // The order is delivered, proceed to insert the rating

                // Prepare data for the 'rate' table
                $rate_data = array(
                    'orderID' => $orderID,
                    'userID' => $userID,
                    'rate_value' => $rate_value,
                    // Current timestamp for 'add_on' field
                );

                // Insert the rating data into the 'rate' table
                $this->db->insert('rate', $rate_data);

                // Check if the insertion was successful
                if ($this->db->affected_rows() > 0) {
                    // Rating inserted successfully

                    // Update the rate_status in the 'orders' table to 'Y'
                    $this->db->where('orderID', $orderID);
                    $this->db->update('orders', array('rate_status' => 'Y', 'rate_value' => $rate_value));

                    $response = array('message' => 'Rating added successfully', 'orderID' => $orderID);
                    echo json_encode($response);
                } else {
                    // Handle the case when the insertion fails
                    $response = array('message' => 'Failed to add rating');
                    echo json_encode($response);
                }
            } else {
                // The order is not delivered, cannot rate it
                $response = array('message' => 'Order is not delivered yet');
                echo json_encode($response);
            }
        } else {
            // Handle the case when the user or order does not exist
            $response = array('message' => 'User or order not found');
            echo json_encode($response);
        }
    }




    public function my_order_cancel()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = isset($data['userID']) ? $data['userID'] : "";
        $orderID = isset($data['orderID']) ? $data['orderID'] : "";
        if ($userID != '') {
            if ($orderID != '') {
                $check_user_id = $this->db->get_where('users', array('id' => $userID))->result();
                if (!empty($check_user_id)) {

                    $this->db->where(array('orderID' => $orderID, 'userID' => $userID));
                    $update = $this->db->update('orders', array('status' => 'CANCEL'));

                    $orders = $this->db->get_where('orders', array('orderID' => $orderID))->row();
                    $status = $orders->status;
                    if ($status != 'CANCEL') {

                        $response[] = array('result' => 'failure', 'message' => 'Your Request is not complete', 'data' => []);
                    } else {

                        $this->db->where(array('orderID' => $orderID));
                        $this->db->update('order_items', array('status' => 'CANCEL'));
                        $this->db->where(array('orderID' => $orderID));
                        $this->db->update('order_status', array('status' => 'CANCEL'));

                        $response = array('result' => 'success', 'message' => 'Cancel successfully', 'data' => []);
                    }
                } else {
                    $response = array('result' => 'failure', 'message' => 'userID Invalid', 'data' => []);
                }
            } else {
                $response = array('result' => 'failure', 'message' => 'orderID Required', 'data' => []);
            }
        } else {
            $response = array('result' => 'failure', 'message' => 'userID Required', 'data' => []);
        }

        echo json_encode($response);
    }



    // public function place_order()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);

    //     $userID = $data['userID'];
    //     $addressID = $data['addressID'];
    //     $coupon_code = $data['coupon_code'];
    //     $coupon_amt = str_replace(',', '', $data['coupon_amt']);
    //     $order_amt = str_replace(',', '', $data['order_amt']);
    //     $total_amount = str_replace(',', '', $data['total_amount']);
    //     $payment_method = $data['payment_method']; //'cod' or 'online'
    //     $delivery_date = date('Y-m-d', strtotime($data['delivery_date']));
    //     $delivery_slot = $data['delivery_slot'];
    //     $instruction = $data['instruction'];
    //     $transactionID = $data['transactionID'];
    //     $delivery_charges = 0;
    //     $online_payment_amount = 0;
    //     $wallet_payment_amount = 0;
    //     $user = $this->db->get_where('users', array('ID' => $userID))->row();
    //     $user_wallet = $user->wallet;
    //     if (!empty($data['delivery_charges'])) {
    //         $delivery_charges = $data['delivery_charges'];
    //         $online_payment_amount = $data['online_amount'];
    //         $wallet_payment_amount = $data['wallet_amount'];
    //     }
    //     $items = $data['items'];
    //     // print_r($items);
    //     // die();
    //     $address = $this->webservice_m->get_single_table('user_address', array('addressID' => $addressID));
    //     $array = array(
    //         'userID' => $userID,
    //         'customer_name' => $address->contact_person_name ?? "",
    //         'contact_no' => $address->contact_person_mobile ?? "",
    //         'house_no' => $address->flat_no ?? "",
    //         'apartment' => $address->building_name ?? "",
    //         'landmark' => $address->landmark ?? "",
    //         'location' => $address->location ?? "",
    //         'latitude' => $address->latitude ?? "",
    //         'longitude' => $address->longitude ?? "",
    //         'address_type' => $address->address_type ?? "",
    //         'coupon_code' => $coupon_code ?? "",
    //         'coupon_discount' => $coupon_amt ?? "",
    //         'order_amount' => $order_amt ?? "",
    //         'total_amount' => $total_amount ?? "",
    //         'payment_method' => $payment_method ?? "",
    //         'delivery_date' => $delivery_date ?? "",
    //         'delivery_slot' => $delivery_slot ?? "",
    //         'delivery_charges' => $delivery_charges ?? "",
    //         'instruction' => $instruction ?? "",
    //         'status' => 'PLACED',
    //         'added_on' => date('Y-m-d H:i:s'),
    //         'updated_on' => date('Y-m-d H:i:s')
    //     );
    //     if ($payment_method == 'online') {
    //         if ($online_payment_amount > 0) {
    //             $success = false;
    //             $error = '';
    //             try {
    //                 $ch = $this->get_curl_handle($transactionID, $online_payment_amount * 100);
    //                 //execute post
    //                 $result = curl_exec($ch);
    //                 $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //                 if ($result === false) {
    //                     $success = false;
    //                     $error = 'Curl error: ' . curl_error($ch);
    //                 } else {
    //                     $txn_description = $result;
    //                     $response_array = json_decode($result, true);
    //                     if ($http_status === 200 and isset($response_array['error']) === false) {
    //                         $success = true;
    //                     } else {
    //                         $success = false;
    //                         if (!empty($response_array['error']['code'])) {
    //                             $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
    //                         } else {
    //                             $error = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
    //                         }
    //                     }
    //                 }
    //                 //close connection
    //                 curl_close($ch);
    //             } catch (Exception $e) {
    //                 $success = false;
    //                 $response = array('result' => 'failure', 'msg' => 'Something Went Wrong. If your Payment is deducted it will be rolled back within 12 days. ');
    //                 $error = 'OPENCART_ERROR:Request to Razorpay Failed';
    //             }
    //         } else {
    //             $success = true;
    //         }

    //         if ($success === true) {
    //             if (!empty($this->session->userdata('ci_subscription_keys'))) {
    //                 $this->session->unset_userdata('ci_subscription_keys');
    //             }
    //             if ($online_payment_amount > 0) {
    //                 $txn_array = array(
    //                     'userID' => $userID,
    //                     'txn_no' => $transactionID,
    //                     'amount' => $online_payment_amount,
    //                     'type' => 'CREDIT',
    //                     'note' => '',
    //                     'against_for' => 'order',
    //                     'paid_by' => 'online',
    //                     'orderID' => 0,
    //                     'transaction_at' => date("Y-m-d H:i:s")
    //                 );
    //                 $this->db->insert('transactions', $txn_array);
    //                 $user_wallet += $online_payment_amount;
    //                 $this->db->where(array('ID' => $userID));
    //                 $this->db->update('users', array('wallet' => $user_wallet));
    //             }
    //             $total_amount_order = $online_payment_amount + $wallet_payment_amount;
    //             $txn_array = array(
    //                 'userID' => $userID,
    //                 'txn_no' => $transactionID,
    //                 'amount' => $total_amount_order,
    //                 'type' => 'DEBIT',
    //                 'note' => '',
    //                 'against_for' => 'order',
    //                 'paid_by' => 'wallet',
    //                 'orderID' => 0,
    //                 'transaction_at' => date("Y-m-d H:i:s")
    //             );
    //             $this->db->insert('transactions', $txn_array);
    //             $txnID = $this->db->insert_id();
    //             $user_wallet -= $total_amount_order;
    //             $this->db->where(array('ID' => $userID));
    //             $this->db->update('users', array('wallet' => $user_wallet));
    //             $id = $this->webservice_m->table_insert('orders', $array);
    //             $this->db->delete('product_cart', array('userID' => $userID));
    //             $this->db->where(array('transactionID' => $txnID));
    //             $this->db->update('transactions', array('orderID' => $id));

    //             if (!empty($items)) {
    //                 foreach ($items as $i) {
    //                     $productID = $i['productID'];
    //                     $quantity = $i['quantity'];
    //                     $isVariant = false; // Initialize a flag to check if the product is a variant

    //                     // Check if the selected product is a variant
    //                     $p_variant_query = $this->db->get_where('products_variant', array('product_id' => $i["productID"]));
    //                     if ($p_variant_query && $p_variant_query->num_rows() > 0) {
    //                         $isVariant = true;
    //                         $p_varient = $p_variant_query->row();
    //                     }

    //                     // Fetch the main product if it's not a variant
    //                     if (!$isVariant) {
    //                         $p = $this->db->get_where('products', array('productID' => $i["productID"]))->row();
    //                     }

    //                     // Check if the product is found
    //                     if ($isVariant && $p_varient) {
    //                         // This is a variant, so update its stock count
    //                         $p_varient->price = $this->check_deal($p_varient->product_id, $p_varient->price);

    //                         // Check if the variant has enough stock
    //                         if ($p_varient->stock_count >= $quantity) {
    //                             // Calculate the new stock quantity for the variant
    //                             $newVariantStock = $p_varient->stock_count - $quantity;

    //                             // Update the product variant's stock quantity in the database
    //                             $this->db->where('id', $p_varient->id);
    //                             $this->db->update('products_variant', array('stock_count' => $newVariantStock));
    //                         } else {
    //                             // Handle the case where there is not enough stock for the variant
    //                             // You can add custom error handling or logging here.
    //                             $response = array('result' => 'false', 'message' => "Product variant is not available");
    //                         }
    //                     } elseif (!$isVariant && $p) {
    //                         // This is the main product (not a variant), do not update the stock in products table
    //                         $p->price = $this->check_deal($p->productID, $p->price);

    //                         // Check if the main product has enough stock
    //                         if ($p->stock_count >= $quantity) {
    //                             // Calculate the new stock quantity for the main product
    //                             $newStock = $p->stock_count - $quantity;

    //                             // Update the product's stock quantity in the database
    //                             $this->db->where('productID', $productID);
    //                             $this->db->update('products', array('stock_count' => $newStock));
    //                         } else {
    //                             // Handle the case where there is not enough stock for the main product
    //                             // You can add custom error handling or logging here.
    //                             $response = array('result' => 'false', 'message' => "Product is not available");
    //                         }
    //                     } else {
    //                         // Handle the case where the product is not found
    //                         $response = array('result' => 'false', 'message' => "Product not found");
    //                     }
    //                 }
    //             } else {
    //                 $response = array('result' => 'false', 'message' => "Please Select Some Items");
    //             }

    //             if ($id) {
    //                 $message = "Your order is successfully placed. Your can further track using order#" . $id;
    //                 $this->send_sms($user->mobile, $message);
    //             }
    //             $response = array('result' => 'success', 'orderID' => $id);
    //         } else {
    //             $response = array('result' => 'failure', 'orderID' => 0);
    //         }
    //     }
    //     // else {
    //     //     $id = $this->webservice_m->table_insert('orders', $array);
    //     //     $this->db->delete('product_cart', array('userID' => $userID));
    //     //     if (!empty($items)) {
    //     //         foreach ($items as $i) {
    //     //             $p = $this->db->get_where('products', array('productID' => $i->productID))->row();
    //     //             $p->price = $this->check_deal($p->productID, $p->price);
    //     //             $b = array(
    //     //                 'orderID' => $id,
    //     //                 'productID' => $i->productID,
    //     //                 'qty' => $i->quantity,
    //     //                 'price' => $p->price,
    //     //                 'net_price' => $p->price * $i->quantity,
    //     //                 'status' => 'PLACED',
    //     //                 'added_on' => date('Y-m-d H:i:s'),
    //     //                 'updated_on' => date('Y-m-d H:i:s')
    //     //             );
    //     //             $itemID = $this->webservice_m->table_insert('order_items', $b);
    //     //             $c = array(
    //     //                 'itemID' => $itemID,
    //     //                 'orderID' => $id,
    //     //                 'agentID' => 0,
    //     //                 'is_visible' => 'Y',
    //     //                 'status' => 'PLACED',
    //     //                 'added_on' => date('Y-m-d H:i:s')
    //     //             );
    //     //             $this->webservice_m->table_insert('order_status', $c);
    //     //         }
    //     //     }
    //     //     if ($id) {
    //     //         $message = "Your order is successfully placed. Your can further track using order#" . $id;
    //     //         $this->send_sms($user->mobile, $message);
    //     //     }
    //     //     $response = array('result' => 'success', 'orderID' => $id);
    //     // }

    //     else {
    //         // Handle offline payment logic
    //         $id = $this->webservice_m->table_insert('orders', $array);



    //         // Check if the order was placed successfully
    //         if ($id) {
    //             $message = "Your order is successfully placed. Your can further track using order#" . $id;
    //             $this->send_sms($user->mobile, $message);

    //             // Check if there are items in the order
    //             if (!empty($items)) {
    //                 foreach ($items as $i) {
    //                     $p = $this->db->get_where('products', array('productID' => $i['productID']))->row();
    //                     $p->price = $this->check_deal($p->productID, $p->price);
    //                     $b = array(
    //                         'orderID' => $id,
    //                         'productID' => $i['productID'],
    //                         'qty' => $i['quantity'],
    //                         'price' => $p->price,
    //                         'net_price' => $p->price * $i['quantity'],
    //                         'status' => 'PLACED',
    //                         'added_on' => date('Y-m-d H:i:s'),
    //                         'updated_on' => date('Y-m-d H:i:s')
    //                     );


    //                     $itemID = $this->webservice_m->table_insert('order_items', $b);
    //                     $c = array(
    //                         'itemID' => $itemID,
    //                         'orderID' => $id,
    //                         'agentID' => 0,
    //                         'is_visible' => 'Y',
    //                         'status' => 'PLACED',
    //                         'added_on' => date('Y-m-d H:i:s')
    //                     );
    //                     $this->webservice_m->table_insert('order_status', $c);
    //                 }
    //             } else {
    //                 $response = array('result' => 'false', 'message' => "Please Select Some Items");
    //             }
    //             $response = array('result' => 'success', 'orderID' => $id);
    //         } else {
    //             $response = array('result' => 'failure', 'orderID' => 0);
    //         }
    //     }

    //     echo json_encode($response);
    // }

    public function place_order()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $userID = $data['userID'];
        $addressID = $data['addressID'];
        $coupon_code = $data['coupon_code'];
        $coupon_amt = str_replace(',', '', $data['coupon_amt']);
        $order_amt = str_replace(',', '', $data['order_amt']);
        $total_amount = str_replace(',', '', $data['total_amount']);
        $payment_method = $data['payment_method']; //'cod' or 'online'
        $delivery_date = date('Y-m-d', strtotime($data['delivery_date']));
        $delivery_slot = $data['delivery_slot'];
        $instruction = $data['instruction'];
        $transactionID = $data['transactionID'];
        $delivery_charges = 0;
        $online_payment_amount = 0;
        $wallet_payment_amount = 0;
        $user = $this->db->get_where('users', array('ID' => $userID))->row();
        $setting_data = $this->db->get('settings')->row();


        $user_wallet = $user->wallet;
        if (!empty($data['delivery_charges'])) {
            $delivery_charges = $data['delivery_charges'];
            $online_payment_amount = $data['online_amount'];
            $wallet_payment_amount = $data['wallet_amount'];
        }
        $items = $data['items'];

        $order_amt = 0; // Initialize the order_amount
        $total_amount = 0;
        if (!empty($items)) {
            foreach ($items as $i) {
                $productID = $i['productID'];
                $quantity = $i['quantity'];

                // Fetch product information (you can fetch variants here as well)
                $product = $this->db->get_where('products', array('productID' => $productID))->row();

                if ($product) {
                    // Calculate the item price based on quantity
                    $item_price = $product->price * $quantity;
                    $order_amt += $item_price;

                    // Add item price to order_amount
                }
            }
        }



        if ($order_amt < $setting_data->min_order_amount) {
            $response = array('result' => 'false', 'message' => "Please add more product");
        } else {

            if ($order_amt > $setting_data->free_delivery_amount) {
                $delivery_charges = 0;
            } else {
                $delivery_charges = $setting_data->delivery_charge;
            }
            $total_amount = $order_amt + $delivery_charges;

            $address = $this->webservice_m->get_single_table('user_address', array('addressID' => $addressID));
            $array = array(
                'userID' => $userID,
                'customer_name' => $user->name ?? "",
                'contact_no' => $user->mobile ?? "",
                'house_no' => $address->flat_no ?? "",
                'apartment' => $address->building_name ?? "",
                'landmark' => $address->landmark ?? "",
                'location' => $address->location ?? "",
                'latitude' => $address->latitude ?? "",
                'longitude' => $address->longitude ?? "",
                'address_type' => $address->address_type ?? "",
                'coupon_code' => $coupon_code ?? "",
                'coupon_discount' => $coupon_amt ?? "",
                'order_amount' => $order_amt ?? "",
                'total_amount' => $total_amount ?? "",
                'payment_method' => $payment_method ?? "",
                'delivery_date' => $delivery_date ?? "",
                'delivery_slot' => $delivery_slot ?? "",
                'delivery_charges' => $delivery_charges ?? "",
                'instruction' => $instruction ?? "",
                'status' => 'PLACED',
                'added_on' => date('Y-m-d H:i:s'),
                'updated_on' => date('Y-m-d H:i:s')
            );
            // print_r($array);
            // die();
            if ($payment_method == 'online') {
                if ($online_payment_amount > 0) {
                    $success = false;
                    $error = '';
                    try {
                        $ch = $this->get_curl_handle($transactionID, $online_payment_amount * 100);
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
                        $response = array('result' => 'failure', 'msg' => 'Something Went Wrong. If your Payment is deducted it will be rolled back within 12 days. ');
                        $error = 'OPENCART_ERROR:Request to Razorpay Failed';
                    }
                } else {
                    $success = true;
                }

                if ($success === true) {
                    if (!empty($this->session->userdata('ci_subscription_keys'))) {
                        $this->session->unset_userdata('ci_subscription_keys');
                    }
                    if ($online_payment_amount > 0) {
                        $txn_array = array(
                            'userID' => $userID,
                            'txn_no' => $transactionID,
                            'amount' => $online_payment_amount,
                            'type' => 'CREDIT',
                            'note' => '',
                            'against_for' => 'order',
                            'paid_by' => 'online',
                            'orderID' => 0,
                            'transaction_at' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('transactions', $txn_array);
                        $user_wallet += $online_payment_amount;
                        $this->db->where(array('ID' => $userID));
                        $this->db->update('users', array('wallet' => $user_wallet));
                    }
                    $total_amount_order = $online_payment_amount + $wallet_payment_amount;
                    $txn_array = array(
                        'userID' => $userID,
                        'txn_no' => $transactionID,
                        'amount' => $total_amount_order,
                        'type' => 'DEBIT',
                        'note' => '',
                        'against_for' => 'order',
                        'paid_by' => 'wallet',
                        'orderID' => 0,
                        'transaction_at' => date("Y-m-d H:i:s")
                    );
                    $this->db->insert('transactions', $txn_array);
                    $txnID = $this->db->insert_id();
                    $user_wallet -= $total_amount_order;
                    $this->db->where(array('ID' => $userID));
                    $this->db->update('users', array('wallet' => $user_wallet));
                    $id = $this->webservice_m->table_insert('orders', $array);
                    $this->db->delete('product_cart', array('userID' => $userID));
                    $this->db->where(array('transactionID' => $txnID));
                    $this->db->update('transactions', array('orderID' => $id));

                    if (!empty($items)) {
                        foreach ($items as $i) {
                            $productID = $i['productID'];
                            $quantity = $i['quantity'];
                            $isVariant = false; // Initialize a flag to check if the product is a variant

                            // Check if the selected product is a variant
                            $p_variant_query = $this->db->get_where('products_variant', array('product_id' => $i["productID"]));
                            if ($p_variant_query && $p_variant_query->num_rows() > 0) {
                                $isVariant = true;
                                $p_varient = $p_variant_query->row();
                            }

                            // Fetch the main product if it's not a variant
                            if (!$isVariant) {
                                $p = $this->db->get_where('products', array('productID' => $i["productID"]))->row();
                            }

                            // Check if the product is found
                            if ($isVariant && $p_varient) {
                                // This is a variant, so update its stock count
                                $p_varient->price = $this->check_deal($p_varient->product_id, $p_varient->price);

                                // Check if the variant has enough stock
                                if ($p_varient->stock_count >= $quantity) {
                                    // Calculate the new stock quantity for the variant
                                    $newVariantStock = $p_varient->stock_count - $quantity;

                                    // Update the product variant's stock quantity in the database
                                    $this->db->where('id', $p_varient->id);
                                    $this->db->update('products_variant', array('stock_count' => $newVariantStock));
                                } else {
                                    // Handle the case where there is not enough stock for the variant
                                    // You can add custom error handling or logging here.
                                    $response = array('result' => 'false', 'message' => "Product variant is not available");
                                }
                            } elseif (!$isVariant && $p) {
                                // This is the main product (not a variant), do not update the stock in products table
                                $p->price = $this->check_deal($p->productID, $p->price);

                                // Check if the main product has enough stock
                                if ($p->stock_count >= $quantity) {
                                    // Calculate the new stock quantity for the main product
                                    $newStock = $p->stock_count - $quantity;

                                    // Update the product's stock quantity in the database
                                    $this->db->where('productID', $productID);
                                    $this->db->update('products', array('stock_count' => $newStock));
                                } else {
                                    // Handle the case where there is not enough stock for the main product
                                    // You can add custom error handling or logging here.
                                    $response = array('result' => 'false', 'message' => "Product is not available");
                                }
                            } else {
                                // Handle the case where the product is not found
                                $response = array('result' => 'false', 'message' => "Product not found");
                            }

                            // Insert the order item regardless of whether it's a variant or main product
                            $b = array(
                                'orderID' => $id,
                                'productID' => $i['productID'],
                                'qty' => $i['quantity'],
                                'price' => $p->price,
                                'net_price' => $p->price * $i['quantity'],
                                'status' => 'PLACED',
                                'added_on' => date('Y-m-d H:i:s'),
                                'updated_on' => date('Y-m-d H:i:s')
                            );
                            $itemID = $this->webservice_m->table_insert('order_items', $b);
                            $c = array(
                                'itemID' => $itemID,
                                'orderID' => $id,
                                'agentID' => 0,
                                'is_visible' => 'Y',
                                'status' => 'PLACED',
                                'added_on' => date('Y-m-d H:i:s')
                            );
                            $this->webservice_m->table_insert('order_status', $c);
                        }
                    } else {
                        $response = array('result' => 'false', 'message' => "Please Select Some Items");
                    }

                    if ($id) {
                        $message = "Your order is successfully placed. Your can further track using order#" . $id;
                        $this->send_sms($user->mobile, $message);
                    }
                    $response = array('result' => 'success', 'orderID' => $id);
                } else {
                    $response = array('result' => 'failure', 'orderID' => 0);
                }
            } else {
                // Handle offline payment logic
                $id = $this->webservice_m->table_insert('orders', $array);
                $this->db->delete('product_cart', array('userID' => $userID));
                // Check if the order was placed successfully
                if ($id) {
                    $message = "Your order is successfully placed. Your can further track using order#" . $id;
                    $this->send_sms($user->mobile, $message);

                    // Check if there are items in the order
                    if (!empty($items)) {
                        foreach ($items as $i) {
                            $productID = $i['productID'];
                            $quantity = $i['quantity'];
                            $isVariant = false; // Initialize a flag to check if the product is a variant

                            // Check if the selected product is a variant
                            $p_variant_query = $this->db->get_where('products_variant', array('product_id' => $i["productID"]));
                            if ($p_variant_query && $p_variant_query->num_rows() > 0) {
                                $isVariant = true;
                                $p_varient = $p_variant_query->row();
                            }

                            // Fetch the main product if it's not a variant
                            if (!$isVariant) {
                                $p = $this->db->get_where('products', array('productID' => $i["productID"]))->row();
                            }

                            // Check if the product is found
                            if ($isVariant && $p_varient) {
                                // This is a variant, so update its stock count
                                $p_varient->price = $this->check_deal($p_varient->product_id, $p_varient->price);

                                // Check if the variant has enough stock
                                if ($p_varient->stock_count >= $quantity) {
                                    // Calculate the new stock quantity for the variant
                                    $newVariantStock = $p_varient->stock_count - $quantity;

                                    // Update the product variant's stock quantity in the database
                                    $this->db->where('id', $p_varient->id);
                                    $this->db->update('products_variant', array('stock_count' => $newVariantStock));
                                } else {
                                    // Handle the case where there is not enough stock for the variant
                                    // You can add custom error handling or logging here.
                                    $response = array('result' => 'false', 'message' => "Product variant is not available");
                                }
                            } elseif (!$isVariant && $p) {
                                // This is the main product (not a variant), do not update the stock in products table
                                $p->price = $this->check_deal($p->productID, $p->price);

                                // Check if the main product has enough stock
                                if ($p->stock_count >= $quantity) {
                                    // Calculate the new stock quantity for the main product
                                    $newStock = $p->stock_count - $quantity;

                                    // Update the product's stock quantity in the database
                                    $this->db->where('productID', $productID);
                                    $this->db->update('products', array('stock_count' => $newStock));
                                } else {
                                    // Handle the case where there is not enough stock for the main product
                                    // You can add custom error handling or logging here.
                                    $response = array('result' => 'false', 'message' => "Product is not available");
                                }
                            } else {
                                // Handle the case where the product is not found
                                $response = array('result' => 'false', 'message' => "Product not found");
                            }

                            // Insert the order item regardless of whether it's a variant or main product
                            $b = array(
                                'orderID' => $id,
                                'productID' => $i['productID'],
                                'qty' => $i['quantity'],
                                'price' => $p->price,
                                'net_price' => $p->price * $i['quantity'],
                                'status' => 'PLACED',
                                'added_on' => date('Y-m-d H:i:s'),
                                'updated_on' => date('Y-m-d H:i:s')
                            );
                            $itemID = $this->webservice_m->table_insert('order_items', $b);
                            $c = array(
                                'itemID' => $itemID,
                                'orderID' => $id,
                                'agentID' => 0,
                                'is_visible' => 'Y',
                                'status' => 'PLACED',
                                'added_on' => date('Y-m-d H:i:s')
                            );
                            $this->webservice_m->table_insert('order_status', $c);
                        }
                    } else {
                        $response = array('result' => 'false', 'message' => "Please Select Some Items");
                    }
                    $response = array('result' => 'success', 'orderID' => $id);
                } else {
                    $response = array('result' => 'failure', 'orderID' => 0);
                }
            }
        }

        // Ensure that delivery_charges is numeric

        echo json_encode($response);
    }



    // public function updateAgentProfile() {
    //     $data = json_decode(file_get_contents('php://input'), true); // Retrieve POST data
    //     $delivery_agentID = $data['delivery_agentID'];
    //     $name = $data['name'];
    //     $email = $data['email'];
    //     $phone = $data['phone'];

    //     // Image Upload Configuration
    //     $config['upload_path'] = './uploads/agentImage'; // Define your upload directory
    //     $config['allowed_types'] = 'jpg|jpeg|png|gif'; // Allowed image types
    //     // $config['max_size'] = 2048; // Maximum file size in kilobytes
    //     $config['file_name'] = 'profile_image_' . $delivery_agentID; // Rename the uploaded file

    //     $this->load->library('upload', $config);

    //     if ($this->upload->do_upload('profile_image')) {
    //         // File uploaded successfully
    //         $image_data = $this->upload->data();
    //         $image_name = $image_data['file_name']; // Get the uploaded file name

    //         // Update the agent's profile in the database with the image name
    //         $this->db->set('name', $name);
    //         $this->db->set('email', $email);

    //         $this->db->set('agentImage', $image_name); // Insert the image name into the column
    //         $this->db->where('delivery_agentID', $delivery_agentID);
    //         $this->db->update('delivery_agent');

    //         if ($this->db->affected_rows() > 0) {
    //             // Update successful
    //             echo json_encode(['message' => 'Profile updated successfully']);
    //         } else {
    //             // Update failed
    //             echo json_encode(['error' => 'Profile update failed']);
    //         }
    //     } else {
    //         // File upload failed
    //         echo json_encode(['error' => $this->upload->display_errors()]);
    //     }
    // }



    public function updateAgentProfile()
    {
        $json_data = json_decode(file_get_contents('php://input'), true);

        // print_r($json_data);
        // die();

        // Retrieve form data from JSON
        $delivery_agentID = $this->input->post('delivery_agentID');
        $name = $this->input->post('name');
        $email = $this->input->post('email');


        // Check if a file was uploaded
        if (isset($_FILES['profile_image'])) {
            // Image Upload Configuration
            $config['upload_path'] = './uploads/agentImage'; // Define your upload directory
            $config['allowed_types'] = 'jpg|jpeg|png|gif'; // Allowed image types
            $config['file_name'] = 'profile_image_' . $delivery_agentID; // Rename the uploaded file

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('profile_image')) {
                // File uploaded successfully
                $image_data = $this->upload->data();
                $image_name = $image_data['file_name'];



                // Update the agent's profile in the database with the image name
                $this->db->set('name', $name);
                $this->db->set('email', $email);

                $this->db->set('agentImage', $image_name); // Insert the image name into the column
                $this->db->where('delivery_agentID', $delivery_agentID);
                $this->db->update('delivery_agent');

                if ($this->db->affected_rows() > 0) {
                    // Update successful
                    echo json_encode(['result' => true,  'message' => 'Profile updated successfully']);
                } else {
                    // Update failed
                    echo json_encode(['result' => true, 'message' => 'Profile update failed']);
                }
            } else {
                // File upload failed
                echo json_encode(['result' => false, 'message' => $this->upload->display_errors()]);
            }
        } else {
            // No file uploaded, update only form data
            $this->db->set('name', $name);
            $this->db->set('email', $email);

            $this->db->where('delivery_agentID', $delivery_agentID);
            $this->db->update('delivery_agent');

            if ($this->db->affected_rows() > 0) {
                // Update successful
                echo json_encode(['result' => true, 'message' => 'Profile updated successfully']);
            } else {
                // Update failed
                echo json_encode(['result' => false, 'message' => 'Profile update failed']);
            }
        }
    }







    public function test_pdf()

    {

        //echo "Hello1";

        $orderID = $this->uri->segment(3);



        $userID = $this->uri->segment(4);

        //echo $orderID.'-'.$userID;

        $url = base_url('pdfs/') . $orderID . '-invoice.pdf';

        if (!file_exists($url)) {

            $a = $this->generate_invoice_pdf($orderID, $userID);
        }



        redirect($url);





        //$this->send_invoice_on_mail(3,3);

    }

    public function generate_invoice_pdf($orderID, $userID)
    {



        $data1 = array();

        $items = '';

        $ordered_products = array();

        $orders = $this->webservice_m->get_single_table_query("SELECT *, DATE_FORMAT(added_on,'%d %M %Y') as added_on, DATE_FORMAT(delivery_date,'%d %M %Y') as delivery_date  FROM `orders` WHERE ORDERID= '$orderID' ORDER BY ORDERID DESC");

        $ordered_products = $this->webservice_m->get_all_table_query("SELECT `order_items`.`itemID`, `order_items`.`qty`, `order_items`.`price`, `order_items`.`net_price`, `order_items`.`status`,`product_name` FROM `order_items` LEFT JOIN products ON order_items.productID = products.productID WHERE `orderID`='$orders->orderID'");



        $get_user = $this->webservice_m->get_single_table_query("SELECT  `name`, `mobile`, `email`, `image`, `wallet`, `status`, `auth_type`, `referral_code`, `referral_userID`, `added_on`, `updated_on` FROM `users` WHERE `ID`='$orders->userID'");


        // print_r($get_user);
        $get_user->email = $get_user->email ? $get_user->email : "0";
        $get_user->image = $get_user->image ? $get_user->image : "0";


        $htmlContent = 'Invoice For OrderNum #' . $orderID;

        $data1['orders'] = $orders ?? "0";

        $data1['items'] = $ordered_products ?? "0";

        $data1['user'] = $get_user;




        $this->load->library('Pdf');

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);


        $pdf->SetCreator(PDF_CREATOR);

        $pdf->SetAuthor('Rapto');

        $pdf->SetTitle('Rapto');

        $pdf->SetSubject('Rapto');

        $pdf->SetKeywords('Email');



        // set default monospaced font

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



        // set margins

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);



        // set auto page breaks

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



        // set image scale factor

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



        // set some language-dependent strings (optional)

        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {

            require_once(dirname(__FILE__) . '/lang/eng.php');

            //$pdf->setLanguageArray($l);

        }





        $pdf->SetFont('dejavusans', '', 10);



        // add a page

        $pdf->AddPage();



        // output the HTML content

        $htmlcode = $this->load->view('webservices/invoice', $data1, TRUE);
        print_r($htmlcode); // Add this line to check the value of $htmlcode
        if (empty($htmlcode)) {
            die('Error: The HTML content is empty or null.');
        }

        // Add debugging output to see the HTML content
        file_put_contents(FCPATH . 'debug_invoice.html', $htmlcode);

        $pdf->writeHTML($htmlcode, true, false, true, false, '');





        $newFile  = FCPATH . "pdfs/" . $orderID . '-invoice.pdf';

        ob_clean();

        //Close and output PDF document

        //$file = $pdf->Output($newFile, 'F');

        $f = $orderID . '-invoice.pdf';



        $pdf->Output($newFile, 'F');


        return $newFile;
    }



    private function get_curl_handle($payment_id, $amount)
    {

        $url = 'https://api.razorpay.com/v1/payments/' . $payment_id . '/capture';
        $key_id = 'rzp_test_eMqq4gLU5x1gWa';
        $key_secret = 'z6sLP3TM0g0vGq5Ei1UvbGlZ';

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

    // public function add_user_location()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];
    //     $address_type = $data['address_type'];
    //     $location = $data['location'];
    //     $flat_no = $data['flat_no'];
    //     $building_name = $data['building_name'];
    //     $landmark = $data['landmark'];
    //     $contact_person_name = $data['contact_person_name'];
    //     $contact_person_mobile = $data['contact_person_mobile'];
    //     $note = $data['note'];
    //     $pincode = $data['pincode'];
    //     $latitude = $data['latitude'];
    //     $longitude = $data['longitude'];

    //     $array = array(
    //         'userID' => $userID,
    //         'location' => $location,
    //         'flat_no' => $flat_no,
    //         'building_name' => $building_name,
    //         'landmark' => $landmark,
    //         'address_type' => $address_type,
    //         'pincode' => $pincode,
    //         'latitude' => $latitude,
    //         'longitude' => $longitude,
    //         'contact_person_name' => $contact_person_name,
    //         'contact_person_mobile' => $contact_person_mobile,
    //         'note' => $note,
    //         'is_active' => 'Y',
    //         'is_default' => 'N',
    //         'added_on' => date('Y-m-d H:i:s')
    //     );

    //     $addressID = $this->webservice_m->table_insert('user_address', $array);

    //     $response = array('result' => 'success', 'addressID' => $addressID);
    //     echo json_encode($response);
    // }
    public function add_user_location()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $address_type = $data['address_type'];
        $location = $data['location'];
        $flat_no = $data['flat_no'] ?? "";
        $building_name = $data['building_name'];
        $landmark = $data['landmark'];
        $contact_person_name = $data['contact_person_name'];
        $contact_person_mobile = $data['contact_person_mobile'];
        $note = $data['note'];
        $pincode = $data['pincode'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];

        // Check if the user has any addresses
        $this->db->select('*');
        $this->db->from('user_address');
        $this->db->where('userID', $userID);
        $user_addresses = $this->db->get()->result();

        // If the user doesn't have any addresses, set the first address as default
        $is_default = empty($user_addresses) ? 'Y' : 'N';

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
            'is_default' => $is_default, // Set as default based on condition
            'added_on' => date('Y-m-d H:i:s')
        );

        $addressID = $this->webservice_m->table_insert('user_address', $array);

        $response = array('result' => 'success', 'addressID' => $addressID);
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

        $address = $this->webservice_m->table_update('user_address', $array, array('addressID' => $addressID));



        $response = array('result' => 'success', 'addressID' => $addressID);
        echo json_encode($response);
    }

    public function delete_address()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $addressID = $data['addressID'];
        $this->db->where(array('addressID' => $addressID));
        $this->db->delete('user_address');
        $response = array('result' => 'success', 'message' => 'Successfully Delete');
        echo json_encode($response);
    }

    public function list_location()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $address = $this->webservice_m->get_all_data_where('user_address', array('userID' => $userID, 'is_active' => 'Y'));
        $response = array('result' => 'success', 'address' => $address);
        echo json_encode($response);
    }

    public function applied_coupon()
    {
        $path = base_url() . 'uploads/';
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $offer_code = $data['offer_code'];
        $get_coupon = $this->webservice_m->get_single_table('offers', array('offer_code' => $offer_code));
        if ($get_coupon->allowed_user_times == 0) {
            $response[] = array('result' => 'success');
        } else {
            $check = $this->db->get_where('orders', array('userID' => $userID, 'coupon_code' => $offer_code))->result();
            if (sizeof($check) < $get_coupon->allowed_user_times) {

                $response[] = array('result' => 'success');
            } else {
                $response[] = array('result' => 'failure');
            }
        }

        echo json_encode($response);
    }

    public function slot()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        // $booking_date = date('Y-m-d',strtotime($data['booking_date']));


        //$delivery_type = $data['delivery_type'];
        $date = date("Y-m-d", strtotime($data['booking_date']));

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
        $response[] = array('result' => 'success', 'slot' => $slot);
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
            $response[] = array('result' => 'failure', 'msg' => 'Something Went Wrong. If your Payment is deducted it will be rolled back within 12 days. ');
            $error = 'OPENCART_ERROR:Request to Razorpay Failed';
        }

        if ($success == true) {
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
            $id = $this->webservice_m->table_insert('transactions', $array);
            $user = $this->webservice_m->get_user(array('ID' => $userID));
            $wallet = $amount + $user->wallet;

            $this->webservice_m->table_update('users', array('wallet' => $wallet), array('ID' => $userID));
            $response[] = array('result' => 'success', 'message' => 'successfully amount added to wallet', 'wallet' => $wallet, 'error' => $error);
        } else {
            $response[] = array('result' => 'failure', 'msg' => 'Something Went Wrong. If your Payment is deducted it will be rolled back within 12 days. ', 'error' => $error);
        }
        echo json_encode($response);
    }

    public function wallet_history()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $user = $this->webservice_m->get_user(array('ID' => $userID));
        $history = $this->webservice_m->get_all_data_where('transactions', array('userID' => $userID), 'transactionID', 'DESC');
        $response[] = array('result' => 'success', 'message' => 'successfully amount added to wallet', 'wallet' => $user->wallet, 'history' => $history);
        echo json_encode($response);
    }

    // public function my_orders()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $userID = $data['userID'];
    //     $ordered_products = array();
    //     $orders = $this->webservice_m->get_all_table_query("SELECT `orderID`, `location`, DATE_FORMAT(DATE(`delivery_date`),'%d-%M-%Y') as delivery_date, `delivery_slot`, `status`, DATE_FORMAT(`added_on`,'%d-%M-%Y') as order_at, `total_amount` FROM `orders` WHERE `userID`='$userID' order by `orderID` DESC");
    //     foreach ($orders as $o) {
    //         $order_products = $this->get_ordered_products($o->orderID, $o->total_amount, $o->status, $o->order_at);
    //         foreach ($order_products as $product) {
    //             $ordered_products[] = $product;
    //         }
    //     }

    //     $response[] = array("result" => "success", "ordered_products" => $ordered_products);
    //     echo json_encode($response);
    // }

    public function my_orders()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $userID = $data['userID'];


        $cityID = (!empty($data['cityID']) ? $data['cityID'] : 0);

        $ordered_products = array();

        $delivery_date = date('Y-m-d');

        $userDetail = $this->db->query("select * from users where ID='$userID'")->row();

        // print_r($userDetail);
        // die();

        if ($cityID == 0) {

            $cityID = $userDetail->cityID;
        }

        $orders = $this->webservice_m->get_all_table_query("SELECT `orderID`,`cityID`, `location`, DATE_FORMAT(DATE(`delivery_date`),'%d-%M-%Y') as delivery_date, `delivery_slot`, `status`, DATE_FORMAT(`added_on`,'%d-%M-%Y') as order_at, `total_amount` FROM `orders` WHERE `userID`='$userID' order by `orderID` DESC");


        foreach ($orders as $o) {


            $o->delivery_date = $delivery_date;

            $order_products = $this->get_ordered_products($o->orderID, $o->total_amount, $o->status, $o->delivery_date, $o->cityID);

            // $o->orderID = $o->orderID;

            foreach ($order_products as $product) {

                $ordered_products[] = $product;
            }
        }



        $response[] = array("result" => "success", "ordered_products" => $ordered_products);

        echo json_encode($response);
    }

    public function get_ordered_products($orderID, $total_amount, $status, $delivery_date, $cityID)

    {


        $query = $this->webservice_m->get_all_table_query("SELECT `itemID`, `productID`,`variantID`, `qty`, `price`, `net_price`, `status` FROM `order_items` WHERE `orderID`='$orderID'");

        $delivery_date = $this->webservice_m->get_single_table_query("SELECT `delivery_date` FROM `orders` WHERE `orderID`='$orderID'");

        if (!empty($query)) {

            foreach ($query as $q) {

                $p_detail = $this->get_product_name($q->productID, $q->variantID, $cityID);



                $q->product_name = $p_detail['name'];

                $q->product_description = $p_detail['description'];

                $q->use = $p_detail['use'];

                $q->benefit = $p_detail['benefit'];

                $q->storage = $p_detail['storage'];

                $q->product_image = base_url('admin/uploads/variants/') . $p_detail['image'];

                $q->category_id = $p_detail['category_id'];

                $q->brand_id = $p_detail['brand_id'];

                $q->in_stock = $p_detail['in_stock'];

                $q->cost_price = $p_detail['cost_price'];

                $q->stock_count = $p_detail['stock_count'];

                $q->retail_price = $p_detail['retail_price'];

                $q->unit_value = $p_detail['unit_value'];

                $q->unit = $p_detail['unit'];

                $q->weight = $p_detail['weight'];

                $q->featured = $p_detail['featured'];

                $q->vegtype = $p_detail['vegtype'];

                $q->special = $p_detail['special'];

                $q->trending = $p_detail['trending'];



                $q->total_order_amount = $total_amount;

                $q->orderID = $orderID;

                // $product_status = $this->get_order_status($q->itemID);

                // if (!empty($product_status)) {

                //     $q->status = $product_status->status;

                // }

                $q->delivery_date = $delivery_date->delivery_date;

                /*array_push($query, $delivery_date);*/
            }
        }

        return $query;
    }

    // public function get_ordered_products($orderID, $total_amount, $status, $date)
    // {
    //     $query = $this->webservice_m->get_all_table_query("SELECT `itemID`, `productID`, `qty`, `price`, `net_price` FROM `order_items` WHERE `orderID`='$orderID'");
    //     if (!empty($query)) {
    //         foreach ($query as $q) {
    //             $p_detail = $this->get_product_name($q->productID);
    //             $q->unit = $p_detail['unit'];
    //             $q->product_name = $p_detail['name'];
    //             $q->product_image = base_url('admin/uploads/products/') . $p_detail['image'];
    //             $q->total_order_amount = $total_amount;
    //             $q->status = $status;
    //             $q->orderID = $orderID;
    //             $product_status = $this->get_order_status($q->itemID);
    //             if (!empty($product_status)) {
    //                 $q->status = $product_status->status;
    //             }
    //             $q->order_date = $date;
    //         }
    //     }
    //     return $query;
    // }

    public function get_product_name($productID)
    {
        $query = $this->webservice_m->get_single_table('products', array('productID' => $productID));
        $name =  (!empty($query->product_name)) ? $query->product_name : '';
        $image = (!empty($query->product_image)) ? $query->product_image : 'product.png';
        $unit = (!empty($query->unit)) ? $query->unit : 'piece';
        return array('name' => $name, 'image' => $image, 'unit' => $unit);
    }

    public function get_product_name_varient()

    {

        $data = json_decode(file_get_contents('php://input'), true);

        $userID = $data['userID'];
        $productID = (!empty($data['productID']) ? $data['productID'] : "0");
        $variantID = (!empty($data['variantID']) ? $data['variantID'] : "0");
        $cityID = (!empty($data['cityID']) ? $data['cityID'] : "0");


        // $query = $this->webservice_m->get_single_table_query("select `products`.*,`products_variant`.`in_stock`,`products_variant`.`cost_price`,`products_variant`.`stock_count`,`products_variant`.`stock_count`,`products_variant`.`retail_price`,`products_variant`.`unit_value`,`products_variant`.`variant_image`,`products_variant`.`unit` from products inner join products_variant on `products`.`productID` =  `products_variant`.`product_id` where `products_variant`.`product_id`='$productID' and `products_variant`.`city_id`='$cityID' order by priority ASC");
        $query = $this->db->query("
        SELECT p.*, v.*
           
        FROM
            products p
        INNER JOIN
            products_variant v ON p.productID = v.product_id
        WHERE
            v.product_id = '$productID'
        AND
            v.city_id = '$cityID'
        ORDER BY
            v.product_id ASC
    ");

        if (!$query) {
            $error_message = $this->db->error()['message'];
            echo "Error: $error_message";
        } else {
            $result = $query->result();
        }


        echo  json_encode(array("product_varient" => $result));
    }

    public function get_order_status($itemID)
    {
        $status = $this->db->query("SELECT * FROM order_status WHERE itemID = '$itemID' ORDER BY statusID DESC LIMIT 1")->row();
        return $status;
    }

    public function change_user_image()
    {
        if ($_POST) {
            $userID = $this->input->post('userID');
            $path = base_url('uploads/');
            if (!empty($_FILES['image']['name'])) {
                $target_path = "uploads/";
                $extension = substr(strrchr($_FILES['image']['name'], '.'), 1);
                $actual_image_name = 'user_image' . time() . "." . $extension;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_path . $actual_image_name);
                $this->db->where(array('ID' => $userID));
                $this->db->update('users', array('image' => $actual_image_name, 'updated_on' => date("Y-m-d H:i:s")));
                $result[] = array("result" => "success", "message" => "Successfully Updated", "image" => $path . $actual_image_name);
            } else {
                $result[] = array("result" => "failure", "message" => "Please Upload a Valid Image", "image" => '');
            }
        } else {
            $result[] = array("result" => "failure", "message" => "Action Not Allowed", "image" => '');
        }
        echo json_encode($result);
    }

    public function my_profile()

    {

        $data = json_decode(file_get_contents('php://input'), true);

        $userID = $data['userID'];

        $path = base_url('uploads/');

        $user_info = $this->db->get_where('users', array('ID' => $userID))->row();

        if (!empty($user_info)) {

            $user_info->image = $path . $user_info->image;

            $result = array("result" => "success", "message" => "Successfully Retrieved", "profile" => $user_info, 'refer_text' => 'Hey user, Please use my referral code to register to gowisekart and get cashback on first order. Use My Code is ' . $user_info->referral_code . '. and to Download latest gowisekart App from play store using https://bit.ly/3EtEsEe.');
        } else {

            $result = array("result" => "failure", "message" => "User Not Found", "profile" => null, 'refer_text' => '');
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
            "name" => $name,
            "email" => $email,
            "updated_on" => date("Y-m-d H:i:s")
        );
        $this->db->where(array('ID' => $userID));
        $this->db->update('users', $update_array);
        $user_info = $this->db->get_where('users', array('ID' => $userID))->row();

        $user_info->pincode = $user_info->pincode ?? "0";

        // print_r($user_info);
        // die();
        if (!empty($user_info)) {
            $user_info->image = $path . $user_info->image;
            $result = array("result" => "success", "message" => "Successfully Updated", "profile" => $user_info);
        } else {
            $result = array("result" => "failure", "message" => "User Not Found", "profile" => null);
        }
        echo json_encode($result);
    }

    public function update_mobile()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $mobile = $data['mobile'];
        $check = $this->db->get_where('users', array('mobile' => $mobile))->row();

        if (empty($check)) {
            $update_array = array(
                "mobile" => $mobile,
                "updated_on" => date("Y-m-d H:i:s")
            );
            $this->db->where(array('ID' => $userID));
            $this->db->update('users', $update_array);
            $result[] = array("result" => "success", "message" => "Successfully Updated");
        } elseif ($check->ID == $userID) {
            $result = array("result" => "success", "message" => "Same Number");
        } else {
            $result = array("result" => "failure", "message" => "This Mobile Number is Already Registered with Use.");
        }
        echo json_encode($result);
    }

    public function cms_pages()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $type = $data['type']; //type = 'about_us','privacy_policy','terms_condition'
        $type_array = array('about_us', 'privacy_policy', 'terms_condition', 'faq');
        $page = "";
        if (in_array($type, $type_array)) {
            $this->db->select($type);
            $content = $this->db->get_where('settings', array('ID' => 1))->row();
            $page = $content->$type;
        }
        $result  = array("result" => "success", "message" => $type, "data" => $page);
        echo json_encode($result);
    }
    public function about_us()
    {
        $this->db->select('about_us');
        $data = $this->db->get_where('settings', array('ID' => 1))->row();
        $result[] = array("result" => "success", "message" => "", "data" => $data->about_us);
        echo json_encode($result);
    }

    public function privacy_policy()
    {
        $this->db->select('privacy_policy');
        $data = $this->db->get_where('settings', array('ID' => 1))->row();
        $result[] = array("result" => "success", "message" => "", "data" => $data->privacy_policy);
        echo json_encode($result);
    }

    public function terms_condition()
    {
        $this->db->select('terms_condition');
        $data = $this->db->get_where('settings', array('ID' => 1))->row();
        $result[] = array("result" => "success", "message" => "", "data" => $data->terms_condition);
        echo json_encode($result);
    }

    public function contact_us()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $array = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'message' => $data['message'],
            'status' => 'NEW',
            'added_on' => date("Y-m-d H:i:s"),
            'updated_on' => date("Y-m-d H:i:s")
        );
        $this->db->insert('enquiry', $array);
        $result[] = array("result" => "success", "message" => "Successfully Submitted.");
        echo json_encode($result);
    }

    public function cancel_order_item()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $itemID = $data['itemID'];
        $this->db->select('order_items.*,orders.userID');
        $this->db->join('orders', 'order_items.orderID = orders.orderID', 'LEFT');
        $check = $this->db->get_where('order_items', array('order_items.itemID' => $itemID, 'orders.userID' => $userID))->row();
        if (!empty($check)) {
            if ($check->status == 'PLACED' || $check->status == 'CONFIRM') {
                $this->db->where(array('itemID' => $check->itemID));
                $this->db->update('order_items', array('status' => 'CANCEL'));
                $this->db->insert('order_status', array(
                    'itemID' => $check->itemID,
                    'orderID' => $check->orderID,
                    'agentID' => 0,
                    'is_visible' => 'Y',
                    'status' => 'CANCEL',
                    'added_on' => date("Y-m-d H:i:s")
                ));
                $response[] = array('result' => 'success', 'msg' => 'Successfully Cancelled');
            } else {
                $response[] = array('result' => 'failure', 'msg' => 'You Cannot cancel this order.');
            }
        } else {
            $response[] = array('result' => 'failure', 'msg' => 'You Cannot cancel this order.');
        }
        echo json_encode($response);
    }

    private function hash($string)
    {
        return hash("sha512", $string . config_item("encryption_key"));
    }
    ///////////////////////////////////////////////////////////
    // public function agent_login()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     // $email = $data['email'];
    //     //$password = $this->hash($data['password']);
    //     $mobile = $data['mobile'];
    //     $deviceID = $data['deviceID'];
    //     $device_token = $data['device_token'];
    //     $device_type = $data['device_type'];
    //     $check = $this->db->get_where('delivery_agent', array('phone' => $mobile, 'is_active' => 'Y'))->row();
    //     if (!empty($check)) {
    //         $otp_massage =   $this->send_otp_delivery($check->phone);
    //         $result = array('result' => 'success', 'status' => true, "message" => "Message Send");
    //     } else {
    //         $result = array('result' => 'failure', 'status' => false, "message" => "Mobile Not Registered");
    //     }
    //     echo json_encode($result);
    // }

    public function agent_login()

    {

        $data = json_decode(file_get_contents('php://input'), true);

        $mobile = $data['mobile'];

        // $password = $this->hash($data['password']);

        $deviceID = $data['deviceID'];

        $device_token = $data['device_token'];

        $device_type = $data['device_type'];

        $check = $this->db->get_where('delivery_agent', array('phone' => $mobile, 'is_active' => 'Y'))->row();

        if (!empty($check)) {

            $this->send_otp_delivery($mobile);

            $result = array('result' => 'success', 'status' => 'true', 'agent' => $check);
        } else {

            $result = array('result' => 'failure', 'status' => 'false', 'agent' => NULL);
        }

        echo json_encode($result);
    }


    // public function send_otp_delivery($mobile)
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     // $mobile = $data['mobile'];
    //     $otp = "123456"; // You already have this OTP

    //     // Generate a random token for authorization
    //     // Generates a 32-character hexadecimal token

    //     $message = $otp . " is your authentication code to register.";
    //     $message = urlencode($message);

    //     $this->send_sms($mobile, $message);

    //     // $insert_data = array(
    //     //     'mobile' => $mobile,
    //     //     'otp' => $otp,
    //     //     'token' => $token, // Store the generated token in the database
    //     //     'added_on' => date("Y-m-d H:i:s"),
    //     //     'updated_on' => date("Y-m-d H:i:s")
    //     // );
    //     // // print_r($insert_data);
    //     // // die();

    //     // $userID = $this->webservice_m->table_insert('users', $insert_data);
    //     $check_mobile = $this->webservice_m->get_single_table("delivery_agent", array('phone' => $mobile));

    //     if (!empty($check_mobile)) {
    //         $response = array('result' => 'success', 'message' => 'SMS Sent Successfully');
    //     } else {
    //         $response = array('result' => 'new', 'message' => 'SMS Not Sent Successfully');
    //     }

    //     return $response;
    // }
    public function send_otp_delivery($mobile)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $otp = "123456"; // You already have this OTP

        // Generate a random token for authorization
        // Generates a 32-character hexadecimal token
        $token = bin2hex(random_bytes(16));

        $message = $otp . " is your authentication code to register.";
        $message = urlencode($message);

        $this->send_sms($mobile, $message);

        $update_data = array(
            'otp' => $otp
        );

        // Update the OTP and Token fields in the database
        $this->webservice_m->table_update('delivery_agent', $update_data, array('phone' => $mobile));

        $check_mobile = $this->webservice_m->get_single_table("delivery_agent", array('phone' => $mobile));

        if (!empty($check_mobile)) {
            $response = array('result' => 'success', 'message' => 'SMS Sent Successfully');
        } else {
            $response = array('result' => 'new', 'message' => 'SMS Not Sent Successfully');
        }

        return $response;
    }

    public function send_sms_delivery($mobile, $message)
    {
        $sender = "EZYTOM";
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


    public function verify_otp_agent()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $mobile = $data['mobile'];
        $inputOTP = $data['otp'];
        // Fetch user records sorted by a timestamp column in descending order
        $token = sha1(random_bytes(32));

        $this->db->order_by('delivery_agentID ', 'DESC');
        $query = $this->db->get_where('delivery_agent', array('phone' => $mobile));
        $user = $query->row();

        $update_data = array(
            'token' => $token
        );
        // print_r($update_data);
        // die();

        // Update the OTP and Token fields in the database
        $this->webservice_m->table_update('delivery_agent', $update_data, array('phone' => $mobile));

        if ($query->num_rows() > 0) {
            if ($user->otp == $inputOTP) {
                $response = array(
                    'result' => 'success',
                    'status' => true,

                    'message' => 'OTP verification successful',
                    'user' => $user,
                );
            } else {
                // OTP didn't match
                $response = array('result' => 'failure', 'status' => false, 'message' => 'OTP verification failed');
            }
        } else {
            // User not found
            $response = array('result' => 'failure', 'status' => false, 'message' => 'User not found');
        }

        echo json_encode($response);
    }




    // public function orderAllotListAgent()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $id = $data['id'];
    //     $query = $this->db->get_where('delivery_agent', array('delivery_agentID ' => $id));
    //     $user = $query->row();

    //     $query_order = $this->db->get_where('orderAllotsAgent', array('agent_id' => $user->delivery_agentID));
    //     $order = $query_order->result();

    //     foreach ($order as &$order_details_agent) { // Use & to modify the original array
    //         $query_order_details = $this->db->get_where('orders', array('orderID' => $order_details_agent->order_id));
    //         $agent_order_details = $query_order_details->result();

    //         // Append order details to the order object
    //         $order_details_agent->order_details = $agent_order_details;
    //     }

    //     // Clean up by removing the reference
    //     unset($order_details_agent);

    //     //  print_r($order);
    //     $response = array(
    //         'result' => 'success',
    //         'orders' => $order
    //     );
    //     echo json_encode($response);
    // }
    public function orderAllotListAgent()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];

        // Load the database library
        $this->load->database();

        // Get the delivery agent details
        $query = $this->db->get_where('delivery_agent', array('delivery_agentID ' => $id));
        $user = $query->row();

        // Get the order allotments for the agent
        $this->db->order_by('add_on', 'DESC'); // Order by add_on field in descending order
        $query_order = $this->db->get_where('orderAllotsAgent', array('agent_id' => $user->delivery_agentID));
        $order = $query_order->result();

        foreach ($order as &$order_details_agent) { // Use & to modify the original array
            // Get order details for each order allotment
            $query_order_details = $this->db->get_where('orders', array('orderID' => $order_details_agent->order_id));
            $agent_order_details = $query_order_details->result();

            // Append order details to the order object
            $order_details_agent->order_details = $agent_order_details;
        }

        // Clean up by removing the reference
        unset($order_details_agent);

        // Prepare the response
        $response = array(
            'result' => 'success',
            'orders' => $order
        );
        echo json_encode($response);
    }






    // public function update_order_accept()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $agentID = $data['agentID'];
    //     $orderID = $data['orderID'];
    //     $status = $data['status'];

    //     if (isset($status)) {
    //         $validStatuses = array('ACCEPT', 'DECLINED', 'SHIPPED', 'DELIVERED');

    //         if (in_array($status, $validStatuses)) {
    //             // Update the orderAllotsAgent table with the provided status and agentId (if 'ACCEPT' status)
    //             $updateData = array('order_complete_status' => $status);

    //             if ($status === 'ACCEPT') {
    //                 $updateData['agent_id'] = $agentID;

    //                 // You can also update the orders table if needed
    //                 $this->db->where('orderID', $orderID);
    //                 $this->db->update('orders', array('agentId' => $agentID, 'status' => $status));

    //                 // Update the delivery_agent table to mark the agent as not available
    //                 $this->db->where('delivery_agentID', $agentID);
    //                 $this->db->update('delivery_agent', array('is_available' => 'N'));
    //             }

    //             $this->db->where('order_id', $orderID);
    //             $this->db->update('orderAllotsAgent', $updateData);

    //             echo json_encode(array('status' => true, 'message' => "Order $status"));
    //         } else {
    //             echo json_encode(array('status' => false, 'message' => 'Invalid status'));
    //         }
    //     } else {
    //         echo json_encode(array('status' => false, 'message' => 'Status not provided'));
    //     }
    // }

    public function update_order_accept()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $agentID = $data['agentID'];
        $orderID = $data['orderID'];
        $status = $data['status'];

        if (isset($status)) {
            $validStatuses = array('ACCEPT', 'DECLINED', 'SHIPPED', 'DELIVERED');

            if (in_array($status, $validStatuses)) {
                // Update the orderAllotsAgent table with 'ACCEPT' status and associate the agent
                // Update the orders table with the provided status
                $updateData = array('order_complete_status' => 'ACCEPT');

                if ($status === 'SHIPPED') {
                    $this->db->where('orderID', $orderID);
                    $this->db->update('orders', array('status' => $status));
                } elseif ($status === 'DELIVERED') {
                    $updateData['order_complete_status'] = $status;
                    $this->db->where('orderID', $orderID);
                    $this->db->update('orders', array('status' => $status));

                    // Update the delivery_agent table to mark the agent as not available
                    $this->db->where('delivery_agentID', $agentID);
                    $this->db->update('delivery_agent', array('is_available' => 'N'));
                }

                $this->db->where('order_id', $orderID);
                $this->db->update('orderAllotsAgent', $updateData);

                echo json_encode(array('status' => true, 'message' => "Order $status"));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Invalid status'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => 'Status not provided'));
        }
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
        $result[] = array('result' => 'success', 'orders' => $orders, "query" => $this->db->last_query());
        echo json_encode($result);
    }

    public function get_completed_order_list()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $agentID = $data['agentID'];
        $status = array('DELIVERED'); // Status to filter by

        // Create an array of conditions
        $conditions = array(
            'agentID' => $agentID,
        );

        // Add the status condition if needed
        if (!empty($status)) {
            $this->db->where_in('status', $status); // Use where_in for an array of statuses
        }

        $orders = $this->db->get_where('orders', $conditions)->result();

        $result = array('result' => 'success', 'orders' => $orders);
        echo json_encode($result);
    }


    /*
        1. rapto admin panel allocate order work done
        2. get_completed_order_list api
        3. get_pending_order_list api
        4 update_order_accept api 
        5. get_order_details api
        6. orderAllotListAgent api
        7. 


    */


    public function get_accepted_order()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $agentID = $data['agentID'];
        $image_path = base_url('uploads/products/');

        // Get the latest accepted order ID for the agent from the orderAllotsAgent table
        $latestAcceptedOrderIDData = $this->db->select('order_id')
            ->where('agent_id', $agentID)
            ->where('order_complete_status', 'ACCEPT')
            ->order_by('add_on', 'DESC') // Order by the 'add_on' column in descending order
            ->limit(1) // Limit the result to 1 row (the latest accepted order)
            ->get('orderAllotsAgent')
            ->row();

        $result = array();

        if ($latestAcceptedOrderIDData) {
            $latestOrderID = $latestAcceptedOrderIDData->order_id;

            // Get the order details from the orders table for the latest accepted order
            $order = $this->db->get_where('orders', array('orderID' => $latestOrderID))->row();

            if ($order) {
                // Get the order items from the order_items table for the latest accepted order
                $orderItems = $this->db->select('order_items.*, products.product_name, products.product_image')
                    ->join('products', 'order_items.productID = products.productID', 'LEFT')
                    ->where('order_items.orderID', $latestOrderID)
                    ->get('order_items')
                    ->result();

                foreach ($orderItems as $i) {
                    $i->product_image = $image_path . $i->product_image;
                }

                $result = array(
                    'order' => $order,
                    'items' => $orderItems
                );
            }
            // print_r($result);


        }

        if (!empty($result)) {
            $response = array(
                'result' => 'success', 'orders' => $order,
                'items' => $orderItems
            );
        } else {
            $response = array('result' => 'failure', 'message' => 'No latest accepted order found for the agent');
        }

        echo json_encode($response);
    }



    public function get_order_details()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $image_path = base_url('uploads/products/');
        $agentID = $data['agentID'];
        $orderID = $data['orderID'];
        $order = $this->db->get_where('orders', array('agentID' => $agentID, 'orderID' => $orderID))->row();
        $this->db->select("order_items.*,products.product_name,products.product_image");
        $this->db->join('products', 'order_items.productID = products.productID', 'LEFT');
        $items = $this->db->get_where('order_items', array('order_items.orderID' => $orderID))->result();
        foreach ($items as $i) {
            $i->product_image = $image_path . $i->product_image;
        }
        $result = array('result' => 'success', 'orders' => $order, 'items' => $items);
        echo json_encode($result);
    }


    // public function insert_delivery_status()
    // {
    //     // Get JSON data from the app       
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $agentID = $data['delivery_id'];

    //     // Debugging: Print the received data
    //     error_log("Received data: " . print_r($data, true));

    //     $this->db->where('delivery_agentID ', $agentID);
    //     $this->db->update('delivery_agent', array('is_available' => "Y"));


    //     // Generate a random scan ID


    //     // Load the database library
    //     // $this->load->database();

    //     // // Prepare data for insertion
    //     // $insert_data = array(
    //     //     'scan_id' => $ran,
    //     //     'delivery_id' => $delivery_id ?? "1",
    //     //     'availabele' => "1",
    //     //     "device_id" => "1"
    //     // );

    //     // Insert data into the 'available_agent' table
    //     // $this->db->insert('available_agent', $insert_data);

    //     // if ($this->db->affected_rows() > 0) {
    //     //     $response = array('result' => 'success', 'message' => 'Data inserted successfully');
    //     // } else {
    //     //     $response = array('result' => 'error', 'message' => 'Data insertion failed');
    //     // }

    //     // echo json_encode($response);


    //     // Query the database to retrieve data for the given agent ID
    //     // $query = $this->db->get_where('available_agent', array('scan_id' => $ran));

    //     // // Check if the query was successful
    //     // if ($query->num_rows() > 0) {
    //     //     // Fetch the data and return it
    //     //     // return $query->row();
    //     //     echo json_encode($query->row());
    //     // } else {
    //     //     // No data found
    //     //     return null;
    //     // }

    //     // Return JSON response

    //     // Check if the necessary keys exist in the received data
    //     if (isset($data['delivery_id'])) {
    //         // $delivery_id = $data['delivery_id'];


    //         // // Generate a random scan ID
    //         // $min = 1000000000; // Minimum 10-digit number (10 zeros)
    //         // $max = 9999999999; // Maximum 10-digit number (all nines)
    //         // $random_number = mt_rand($min, $max);

    //         // // Load the database library
    //         // $this->load->database();

    //         // // Prepare data for insertion
    //         // $insert_data = array(
    //         //     'scan_id' => $ran,
    //         //     'delivery_id' => $delivery_id,
    //         //     'availabele' => "1",
    //         //     "device_id" => "1"
    //         // );

    //         // // Insert data into the 'available_agent' table
    //         // $this->db->insert('available_agent', $insert_data);

    //         // if ($this->db->affected_rows() > 0) {
    //         //     $response = array('result' => 'success', 'message' => 'Data inserted successfully');
    //         // } else {
    //         //     $response = array('result' => 'error', 'message' => 'Data insertion failed');
    //         // }

    //         // // Return JSON response
    //         // echo json_encode($response);
    //         // } else {
    //         //     $response = array('result' => 'error', 'message' => 'Invalid data format');
    //         //     echo json_encode($response);
    //     }
    // }




    // public function insert_delivery_status()
    // {
    //     // Get JSON data from the app
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $shop_id = $data['shop_id'];

    //     // Check if 'delivery_id' key exists in the received data
    //     if (isset($data['delivery_id'])) {
    //         $agentID = $data['delivery_id'];

    //         // Debugging: Print the received data
    //         error_log("Received data: " . print_r($data, true));

    //         // Update the 'is_available' field in the 'delivery_agent' table
    //         $this->db->where('delivery_agentID', $agentID);
    //         $this->db->update('delivery_agent', array('is_available' => "Y"));

    //         // Check if the update was successful
    //         if ($this->db->affected_rows() > 0) {
    //             $response = array('result' => 'success', 'message' => 'Data updated successfully');
    //         } else {
    //             $response = array('result' => 'error', 'message' => 'Data update failed');
    //         }
    //     } else {
    //         $response = array('result' => 'error', 'message' => 'Invalid data format');
    //     }

    //     // Return JSON response
    //     // echo json_encode($response);
    //     echo json_encode(array("store" => "2" , 'shop_id' => $shop_id, 'status' => true , 'message' => 'added in queue'));
    // }

    public function insert_delivery_status()
    {
        // Get JSON data from the app
        $data = json_decode(file_get_contents('php://input'), true);
        $cityID = $data['shop_id'];

        // Check if 'delivery_id' key exists in the received data
        if (isset($data['delivery_id'])) {
            $agentID = $data['delivery_id'];

            // Debugging: Print the received data
            error_log("Received data: " . print_r($data, true));

            // Update the 'is_available' and 'available_timestamp' fields in the 'delivery_agent' table
            $this->db->where('delivery_agentID', $agentID);
            $this->db->where('city_id', "2");
            $this->db->update('delivery_agent', array(
                'is_available' => "Y",
                'available_timestamp' => date('Y-m-d H:i:s') // Update the timestamp to the current time
            ));

            // Check if the update was successful
            if ($this->db->affected_rows() > 0) {
                $response = array('result' => 'success', 'message' => 'Add in Queue successfully');
            } else {
                $response = array('result' => 'error', 'message' => 'Add in Queue failed');
            }
        } else {
            $response = array('result' => 'error', 'message' => 'Invalid data format');
        }

        // Return JSON response
        echo json_encode($response);
    }



    public function is_avail_delivery()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $cityID = $data['cityID'];

        // Query the database to get all delivery agents for the specified city
        $this->db->select('*');
        $this->db->from('delivery_agent');
        $this->db->where('city_id', $cityID);
        $this->db->order_by('available_timestamp', 'DESC'); // Order by availability timestamp (assuming it's a datetime field)
        $query = $this->db->get();

        if ($query === false) {
            // Query failed, print the error
            echo $this->db->error()['message'];
        } else {
            // Continue processing the query result
            $agents = $query->result_array();
            if (!empty($agents)) {
                // Display the list of agents, with the agent who last scanned at the top
                echo json_encode(['result' => true, 'agents' => $agents]);
            } else {
                // No agents found for the specified city
                echo json_encode(['result' => false, 'message' => 'No delivery agents found for this city']);
            }
        }
    }







    public function generate_random()
    {
        $min = 1000000000; // Minimum 10-digit number (10 zeros)
        $max = 9999999999; // Maximum 10-digit number (all nines)
        $delivery_id = $data['delivery_id'];
        $random_number = mt_rand($min, $max);

        $this->insert_delivery_status($random_number, $delivery_id);

        // echo json_encode($random_number);
    }

    public function set_default_user_location()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $addressID = $data['addressID'];
        $userID = $data['userID'];

        // Set 'is_default' to 'N' for all records with the same 'addressID'
        $this->db->update('user_address', array('is_default' => 'N'), array('userID' => $userID));

        // Set 'is_default' to 'Y' for the specified 'addressID'
        $array = array(
            'is_default' => 'Y'
        );
        $this->db->where('addressID', $addressID);
        $this->db->update('user_address', $array);

        // Retrieve the updated record
        $query = $this->db->get_where('user_address', array('addressID' => $addressID, 'userID' => $userID));
        $address_data = $query->row();

        $response = array(
            'result' => 'success',
            'addressID' => $addressID,
            "default_address_data" => $address_data,
            'message' => 'Default Address set'
        );

        echo json_encode($response);
    }

    public function get_default_user_location()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $addressID = $data['addressID'];
        $userID = $data['userID'];

        // Check if the user already has a default address
        $query = $this->db->get_where('user_address', array('userID' => $userID, 'is_default' => 'Y'));
        $address_data = $query->row();



        // Replace null with "0" if addressID is null
        if ($addressID === null) {
            $addressID = "0";
        }

        $response = array(
            'result' => 'success',
            'addressID' => $address_data->addressID ?? "0",
            "default_address_data" => $address_data,
            'message' => 'Default Address set'
        );

        echo json_encode($response);
    }





    public function user_deliver_order()

    {

        $data = json_decode(file_get_contents('php://input'), true);


        $agentID = $data['agentID'] ?? "0";

        $orderID = $data['orderID'];

        $items = $this->db->get_where('order_items', array('orderID' => $orderID))->result();

        foreach ($items as $item) {

            if ($item->status != 'DELIVERED' || $item->status != 'CANCEL') {

                $status_insert = array(

                    'itemID' => $item->itemID,

                    'orderID' => $orderID,

                    'agentID' => $agentID,

                    'is_visible' => 'Y',

                    'status' => 'DELIVERED',

                    'added_on' => date("Y-m-d H:i:s")

                );

                $this->db->insert('order_status', $status_insert);

                $this->db->where(array('itemID' => $item->itemID));

                $this->db->update('order_items', array('status' => 'DELIVERED', 'updated_on' => date("Y-m-d H:i:s")));
            }

            $this->db->where(array('orderID' => $orderID));

            $this->db->update('orders', array('status' => 'DELIVERED', 'updated_on' => date("Y-m-d H:i:s")));
        }



        $order = $this->db->get_where('orders', array('orderID' => $orderID))->row();

        $user = $this->db->get_where('users', array('ID' => $order->userID))->row();

        $redeemable_pt = floor(($order->total_amount * 2) / 100);

        $other_pt = floor(($order->total_amount * 3) / 100);

        $reward_pt_txn_insert = array(

            'user_id' => $order->userID,

            'redeemable_pt' => $redeemable_pt,

            'other_pt' => $other_pt,

            'orderID' => $order->orderID,

            'reason' => 'Order with orderID #' . $order->orderID . ' delivered',

            'type' => 'credit',

            'created_at' => date('Y-m-d H:i:s'),

            'updated_at' => date('Y-m-d H:i:s')

        );

        // $this->db->insert('reward_pt_txn',$reward_pt_txn_insert);

        // $new_total_redeem_pt = $user->total_redeem_pt + $redeemable_pt;

        // $new_redeemable_pt = $user->redeemable_pt + $redeemable_pt;

        // $new_total_other_pt  = $user->total_other_pt + $other_pt;

        // $new_other_pt = $user->other_pt + $other_pt;

        // $user_pt_update_array = array(

        //     'total_redeem_pt'=>$new_total_redeem_pt,

        //     'redeemable_pt'=>$new_redeemable_pt,

        //     'total_other_pt'=>$new_total_other_pt,

        //     'other_pt'=>$new_other_pt

        // );

        // $this->db->where(array('ID'=>$order->userID));

        // $this->db->update('users',$user_pt_update_array);



        if ($order->status == 'DELIVERED') {

            //update cashback
            if (!empty($order)) {
                if ($order->type == 'CASHBACK') {
                    $this->db->where(array('ID' => $user->ID));
                    $this->db->update('users', array('cashback_wallet' => $user->cashback_wallet + $order->coupon_discount, 'updated_on' => date('Y-m-d H:i:s')));
                }
            }

            //referal amount update

            $totalOrder = $this->db->query("select * from orders where userID='$user->ID'")->result();

            if (!empty($totalOrder)) {

                if (count($totalOrder) == 1) {

                    if (!empty($user->referral_userID)) {

                        $settings = $this->db->get_where('settings', array('id' => 1))->row();
                        $refer_amount = isset($settings->refer_earn) ? $settings->refer_earn : 0;
                        //amount update referal user

                        //amount update referal user

                        $referalUser =  $this->db->query("select * from users where ID='$user->referral_userID'")->row();

                        $this->db->where(array('ID' => $referalUser->ID));

                        $this->db->update('users', array('wallet' => $referalUser->wallet + $refer_amount));



                        $txn_array = array(

                            'userID' => $referalUser->ID,

                            'txn_no' => 'RFR' . time() . rand(99, 999),

                            //'amount' => 10,
                            'amount' => $refer_amount,


                            'type' => 'CREDIT',

                            'note' => '',

                            'against_for' => 'order',

                            'paid_by' => $order->payment_method,

                            'orderID' => $orderID,

                            'transaction_at' => date("Y-m-d H:i:s")

                        );

                        $this->db->insert('transactions', $txn_array);
                        $today = date('Y-m-d H:i:s');
                        $txn_array1 = array(
                            'user_id' => $referalUser->ID,
                            'previous_wallet' => $referalUser->wallet,
                            'added_amount' => $refer_amount,
                            'created_at' => date("Y-m-d H:i:s"),
                            'expired_on' => date('Y-m-d H:i:s', strtotime($today . ' + 2 days')),

                        );

                        $this->db->insert('refer_earn_new', $txn_array1);

                        $this->db->where(array('ID' => $referalUser->ID));
                        $this->db->update('users', array('wallet' => $referalUser->wallet + $refer_amount));
                        $message = 'Gowisekart is delivering handpicked farm fresh fruits, vegetables, grocery & household items.Instant Cash Amount Rs' . $refer_amount . ' will be added in your Gowisekart Wallet due to Successful Referal and that will expire in 2 days.';

                        $notification_insert = array(

                            "title" => 'Refer & Earn',

                            "image" => '',

                            "text" => $message,

                            "userID" => $referalUser->ID,

                            "status" => 'sent',

                            "added_on" => date("Y-m-d H:i:s"),

                            "updated_on" => date("Y-m-d H:i:s"),

                        );

                        $this->db->insert('notifications', $notification_insert);



                        $user_login = $this->db->get_where('user_login', array('userID' => $referalUser->ID))->result();

                        foreach ($user_login as $login) {

                            if (strtolower($login->device_type) == 'android') {

                                $this->send_notification('Refer & Earn', $message, $login->device_token, '');
                            }
                        }
                    }
                }
            }



            $message = "Dear Customer,\nYour Order With orderID # $orderID has been delivered.\n\nThank you,\nGowisekart";

            $this->send_sms($user->mobile, $message);

            $message = "Dear Customer,Your Order With orderID # $orderID has been delivered.Thank you,GoWiseKart";

            $notification_insert = array(

                "title" => 'ORDER DELIVERED',

                "image" => '',

                "text" => $message,

                "userID" => $user->ID,

                "status" => 'sent',

                "added_on" => date("Y-m-d H:i:s"),

                "updated_on" => date("Y-m-d H:i:s"),

            );

            $this->db->insert('notifications', $notification_insert);



            $user_login = $this->db->get_where('user_login', array('userID' => $user->ID))->result();

            foreach ($user_login as $login) {

                if (strtolower($login->device_type) == 'android') {

                    $this->send_notification('ORDER DELIVERED', $message, $login->device_token, '');
                }
            }
        }

        $result[] = array('result' => 'success', 'message' => 'successfully updated');

        echo json_encode($result);
    }


    private function send_notification($title, $body, $deviceToken, $image)
    {

        $deviceToken = $deviceToken;



        if (empty($image)) {

            $image = 'https://rapto.teknikoglobal.com/admin/uploads/favicon1575713051.png';
        }

        $sendData = array(

            'body' => $body,

            'title' => $title,

            'sound' => 'Default',

            'image' => $image,

        );

        $this->fcmNotification($deviceToken, $sendData);
    }


    private function fcmNotification($device_id, $sendData)

    {

        #API access key from Google API's Console

        if (!defined('API_ACCESS_KEY')) {

            // define('API_ACCESS_KEY', 'AAAAz66t20U:APA91bHhgudWbmKK12QVORSXoFEdXDQclblg_SWD4skc419B_YNSqDSRbx-q8jm956o4sX7daTIChQS7hx3sg4wXT393of2MkoiD_v3K4Ii8OiQ5bg5xDJ_zRyxhqlBj03HIqUvhz5Hi');

            define('API_ACCESS_KEY', 'AAAA1HKDgQE:APA91bFGcpAMnemBJlCBYXP8Yo3aRz5f3iZaWsg4AHZR6uesM-I1MSIiVzyzbmiUZAWxbrkerqeOKvqY0daZZhLiHyWEJwXuSH8SqDdo_sUH33BXRzYeOfd9Z108OwOzKOcQmH5Ks4hL');
        }



        $fields = array(

            'to'    => $device_id,

            'data'  => $sendData,

            'notification'  => $sendData

        );





        $headers = array(

            'Authorization: key=' . API_ACCESS_KEY,

            'Content-Type: application/json'

        );

        #Send Reponse To FireBase Server

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);

        //$data = json_decode($result);

        if ($result === false)

            die('Curl failed ' . curl_error());



        curl_close($ch);

        return $result;
    }

    public function agent_profile()
    {
        // Retrieve agentID from request data
        $data = json_decode(file_get_contents('php://input'), true);
        $agentID = $data['agentID'];

        // Query the database to get agent details
        $agentDetails = $this->db->get_where('delivery_agent', array('delivery_agentID' => $agentID))->row();

        if ($agentDetails) {
            // Agent details found, return them as JSON response
            $agentDetails->agentImage = base_url('uploads/agentImage/') . $agentDetails->agentImage;
            $response = array(
                'result' => 'success',
                'message' => 'Agent details retrieved successfully',
                'agentDetails' => $agentDetails
            );
        } else {
            // Agent details not found
            $response = array(
                'result' => 'failure',
                'message' => 'Agent not found'
            );
        }

        echo json_encode($response);
    }


    public function deliver_order()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $agentID = $data['agentID'];
        $orderID = $data['orderID'];
        $items = $this->db->get_where('order_items', array('orderID' => $orderID))->result();
        foreach ($items as $item) {
            if ($item->status != 'DELIVERED' || $item->status != 'CANCEL') {
                $status_insert = array(
                    'itemID' => $item->itemID,
                    'orderID' => $orderID,
                    'agentID' => $agentID,
                    'is_visible' => 'Y',
                    'status' => 'DELIVERED',
                    'added_on' => date("Y-m-d H:i:s")
                );
                $this->db->insert('order_status', $status_insert);
                $this->db->where(array('itemID' => $item->itemID));
                $this->db->update('order_items', array('status' => 'DELIVERED', 'updated_on' => date("Y-m-d H:i:s")));
            }
            $this->db->where(array('orderID' => $orderID));
            $this->db->update('orders', array('status' => 'DELIVERED', 'updated_on' => date("Y-m-d H:i:s")));
        }
        $result[] = array('result' => 'success', 'message' => 'successfully updated');
        echo json_encode($result);
    }

    public function agent_logout()
    {
    }

    public function category()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userID = $data['userID'];
        $path3 = base_url('admin/uploads/category/');
        $category_path = $this->webservice_m->get_all_data_where('category', array('status' => 'Y'), 'priority', 'desc');

        foreach ($category as $cats) {
            $cats->image = $path3 . $cats->image;
        }

        $response[] = array('result' => 'success', 'category' => $category);
        echo json_encode($response);
    }
}
