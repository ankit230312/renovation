<?php  
class Order_table extends CI_Model  
{  
  var $table = "orders";  
   var $select_column = '*';
  // var $select_column = array("ID","name","mobile","email","image","wallet","cashback_wallet","cityID","pincode","status","added_on","referral_code");  
  // var $order_column = array("ID","name","mobile","email","image","wallet","cashback_wallet","cityID","pincode","status","added_on","referral_code");  
  function make_query()  
  {  
   $this->db->select($this->select_column);  
   $this->db->from($this->table);  
   if(isset($_POST["search"]["value"]))  
   {  
    //$this->db->like("name", $_POST["search"]["value"]);  
    //$this->db->or_like("name", $_POST["search"]["value"]);  
  }  
  if(isset($_POST["order"]))  
  {  
    //$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
  }  
  else  
  {  
    $this->db->order_by('orderID', 'DESC');  
  }  
}  
function make_datatables(){  
 $this->make_query();  
 if($_POST["length"] != -1)  
 {  
  $this->db->limit($_POST['length'], $_POST['start']);  
}  
$query = $this->db->get();  


// echo $this->db->last_query();
// die;
return $query->result();  
}  
function get_filtered_data(){  
 $this->make_query();  
 $query = $this->db->get();  
 return $query->num_rows();  
}       
function get_all_data()  
{  
 $this->db->select("*");  
           //$this->db->where($st, 1);  
 $this->db->from($this->table);  
 return $this->db->count_all_results();  
}  
}  