<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends CI_Controller {



    function __construct() {

        parent::__construct();

        $this->load->model("home_m");
        $this->load->helper("common_helper");
        $skey   = "SuPerEncKey2010";
        $this->load->library('encryption');
        $this->load->model("webservice_m");

    }



    public function slot(){

        $data = json_decode(file_get_contents('php://input'), true);

        $app_version = (!empty($data['app_version']))?$data['app_version']:0;

        $this->db->insert('request_log',array('data'=>json_encode($data),'added_on'=>date('Y-m-d H:i:s')));

        $date = date("Y-m-d",strtotime($data['booking_date']));

        $cityID = $data['cityID'];

        $time = date("H:i:s");
        $this->load->model("time_model");
        $time_slot = $this->time_model->get_time_slot($cityID);
        $cloasing_hours =  $this->time_model->get_closing_hours($date);
        $begin = new DateTime($time_slot->opening_time);
        $end   = new DateTime($time_slot->closing_time);
        $interval = DateInterval::createFromDateString($time_slot->time_slot.' min');
        $times    = new DatePeriod($begin, $interval, $end);

        $time_array = array();

        $slot = array();

        $count_times = iterator_count($times);

        foreach ($times as $key=> $time) {

            $t1 ='';

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

                        'available' =>$this->check_slot_availabilty($t1,$cityID,$date,$time_slot->max_order),

                        "delivery_price" => '30'             

                    );             

                }

            }else{

                if(strtotime($date) == strtotime(date("Y-m-d"))){

                    if(strtotime($time->format('h:i A')) > strtotime(date("h:i A"))){

                        if(date('h:i A',strtotime($time_slot->closing_time)) < $time->format('h:i A')){

                            $t1 = $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

                            }else{

                                if($count_times-1 != $key){

                                    $t1 = $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

                                }else{

                                    $t1 = $time->format('h:i A'). ' - '. date('h:i A',strtotime($time_slot->closing_time));

                                }

                            }

                        

                        $time_array[] =  $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

                        $slot[] = array(

                            'period' => $t1,

                            'available' =>$this->check_slot_availabilty($t1,$cityID,$date,$time_slot->max_order),

                            "delivery_price" => '30'           

                        );  

                    } 

                }else{

                    if(date('h:i A',strtotime($time_slot->closing_time)) < $time->format('h:i A')){

                        $t1 = $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

                    }else{

                        if($count_times-1 != $key){

                            $t1 = $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');

                        }else{

                            $t1 = $time->format('h:i A'). ' - '. date('h:i A',strtotime($time_slot->closing_time));

                        }

                    }

                    

                   $time_array[] =  $time->format('h:i A'). ' - '. $time->add($interval)->format('h:i A');



                   $slot[] = array(

                    'period' => $t1,

                    'available' => $this->check_slot_availabilty($t1,$cityID,$date,$time_slot->max_order),

                    "delivery_price" => '30'              

                );  

                }

                



            }





        }




        $response[] = array('result'=>'success', 'slot'=>$slot);

        

        echo json_encode($response);

    }



    private function check_slot_availabilty($s,$cityID,$d,$max_order)

    {

    $sql = $this->db->query("SELECT COALESCE(COUNT(*),0) as order_count FROM `orders` WHERE `cityID`='$cityID' AND `delivery_slot`='$s' AND `delivery_date`='$d'")->row();



    return $max_order - $sql->order_count;

    }



}