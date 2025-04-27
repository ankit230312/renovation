<?php



/**



 * Created by PhpStorm.



 * User: kshit



 * Date: 2019-05-13



 * Time: 11:37:15



 */







class Deals extends CI_Controller



{



    function __construct() {



        parent::__construct();



        //$this->_check_auth();



        $this->load->model("home_m");



    }







    /*private function _check_auth(){



        if($this->session->userdata('role') != 'admin'){



            $this->session->sess_destroy();



            redirect(base_url("login"));



        }



    }
*/






    public function index()



    {



        $select = 'deals.*,products.product_name,products.product_image,products.price as mrp,products.retail_price,products.unit_value,products.unit';



        $join = array();



        $join[] = array(



            'table'=>'products',



            'parameter'=>'deals.productID = products.productID',



            'position'=>'LEFT'



        );



        $this->data['offers'] = $this->home_m->get_all_row_where_join ('deals',array(),$join,$select);



        $this->data['sub_view'] = 'deals/list';



        $this->data['title'] = 'Deals';



        $this->load->view("_layout",$this->data);



    }







    public function add()



    {



        if ($_POST){



            $insert_array = $_POST;



            $cityID ='';

            

            $insert_array['added_on'] = date("Y-m-d H:i:s");



            $insert_array['updated_on'] = date("Y-m-d H:i:s");



            if(sizeof($_POST['cityID']) > 0){



                foreach ($_POST['cityID'] as $row) {



                    $check = $this->home_m->get_single_row_where('deals',array('productID'=>$_POST['productID'],'cityID'=>$row),$select='*');



                    if ($row != "") {



                        if (empty($check)){



                            $insert_array['cityID']=$row;

                            $insert_array['variantID'] = $this->getdefaultVariant($_POST['productID'],$row);



                            $this->home_m->insert_data('deals',$insert_array);



                        }else{



                            $update_array['cityID']=$row;



                            $update_array['updated_on'] = date("Y-m-d H:i:s");



                            $this->home_m->update_data('deals',array('dealID'=>$check->dealID),$update_array);



                        }    



                    }



                }



            }



            redirect(base_url("deals"));



        }else{



            $join = array();



            $select = 'productID,product_name,price,unit_value,unit';



            $this->data['products'] = $this->db->query("SELECT productID,product_name,price,unit_value,unit FROM `products` WHERE `in_stock` = 'Y'")->result();



            $this->data['city'] = $this->home_m->get_all_row_where('city',array('status'=>'Y'));



            $this->data['sub_view'] = 'deals/add';



            $this->data['title'] = 'Add Deal';



            $this->load->view("_layout",$this->data);



        }



    }







    public function edit($param1 = '')



    {



        if ($param1 != ''){



            if ($_POST){



                $update_array = $_POST;



                $cityID ='';



                if(sizeof($_POST['cityID']) > 0){



                    foreach ($_POST['cityID'] as $row) {



                        $check = $this->home_m->get_single_row_where('deals',array('productID'=>$_POST['productID'],'cityID'=>$row),$select='*');



                        if ($row != "") {



                            if (empty($check)){



                                    $update_array['cityID']=$row;



                                    $this->home_m->insert_data('deals',$update_array);



                            }else{



                                $update_array['cityID']=$row;



                                $update_array['updated_on'] = date("Y-m-d H:i:s");



                                $this->home_m->update_data('deals',array('dealID'=>$param1),$update_array);



                            }



                        }



                    }



                }



            redirect(base_url("deals"));



            }else{



                $join = array();



                $select = 'productID,product_name,price,unit_value,unit';



                $this->data['products'] = $this->home_m->get_all_row_where_join ('products',array(),$join,$select);



                $this->data['deal'] = $this->home_m->get_single_row_where('deals',array('dealID'=>$param1),$select='*');



                $this->data['city'] = $this->home_m->get_all_row_where('city',array('status'=>'Y'));



                $this->data['sub_view'] = 'deals/edit';



                $this->data['title'] = 'Edit Deal';



                $this->load->view("_layout",$this->data);



            }



        }else{



            $this->index();



        }



    }



    //delete deals

    public function delete($param1 = '')



    {

        if ($param1 != ''){

          $result =  $this->home_m->delete_data('deals',array('dealID'=>$param1));

          if($result){

            redirect(base_url("deals"));

          }

        }

    }





    //default variant ID

    function getdefaultVariant($productID,$cityID){

     $variant =  $this->db->query("select * from products_variant where product_id='$productID' and city_id='$cityID' and is_default='1'")->row();

     return $variant->id;

    }



}