<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -----------------------------------------------------
| PRODUCT NAME: 	
| -----------------------------------------------------
| AUTHOR:			SUNIL THAKUR (http://sunilthakur.in)
| -----------------------------------------------------
| EMAIL:			
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY 
| -----------------------------------------------------
| WEBSITE:			http://
| -----------------------------------------------------
*/

class Webservice_m extends MY_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function hash($string)
	{
		return parent::hash($string);
	}

	public function get_user($array)
	{
		$query = $this->db->get_where('users', $array);
		return $query->row();
	}

	public function signup_user($array)
	{
		$query = $this->db->insert('users', $array);
		$id = $this->db->insert_id();
		return $id;
	}

	// public function update_device($userID,$ip_address,$deviceID,$deviceToken,$deviceType)
	// {
	//     $created_on = date('Y-m-d H:i:s');
	//     $query = $this->db->get_where('user_login',array('deviceID'=>$deviceID));
	//     if(count($query->row())>0)
	//     {
	//         $this->db->where(array('deviceID'=>$deviceID));
	//         $this->db->update('user_login',array("userID"=>$userID, "ip_address"=>$ip_address, "deviceID"=>$deviceID, "deviceToken"=>$deviceToken, "deviceType"=>$deviceType, "login_on"=>$created_on));
	//     } else {
	//         $this->db->insert('user_login',array("userID"=>$userID, "ip_address"=>$ip_address, "deviceID"=>$deviceID, "deviceToken"=>$deviceToken, "deviceType"=>$deviceType, "login_on"=>$created_on));
	//     }
	//     return TRUE;
	// }


	public function update_device($userID, $ip_address, $deviceID, $deviceToken, $deviceType)
	{

		$created_on = date('Y-m-d H:i:s');

		$query = $this->db->get_where('user_login', array('deviceID' => $deviceID));
		$existingRow = $query->row();

		if ($existingRow) {
			$this->db->where('deviceID', $deviceID);
			$this->db->update('user_login', array(
				'userID' => $userID,
				'ip_address' => $ip_address,
				'deviceToken' => $deviceToken,
				'deviceType' => $deviceType,
				'login_on' => $created_on
			));
		} else {
			$this->db->insert('user_login', array(
				'userID' => $userID,
				'ip_address' => $ip_address,
				'deviceID' => $deviceID,
				'deviceToken' => $deviceToken,
				'deviceType' => $deviceType,
				'login_on' => $created_on
			));
		}

		return true;
	}



	public function logout($array)
	{
		$this->db->where($array);
		$this->db->delete('user_login');
		return TRUE;
	}


	public function table_insert($table, $array)
	{
		$query = $this->db->insert($table, $array);
		if (!$query) {
			// If insertion failed, print the error message for debugging
			$error = $this->db->error();
			echo "Insertion Error: {$error['message']}";
			return false;
		}
		return $this->db->insert_id();
	}

	public function get_single_table($table, $array, $select = '*')
	{
		$this->db->select($select);
		$query = $this->db->get_where($table, $array);
		return $query->row();
	}

	public function table_update($table, $array, $where)
	{
		$query = $this->db->where($where);
		$this->db->update($table, $array);
		return TRUE;
	}

	public function get_all_data($table, $order_by = NULL, $order = "ASC")
	{
		if ($order_by != NULL) {
			$this->db->order_by($order_by, $order);
		}

		$query = $this->db->get($table);
		return $query->result();
	}

	public function get_all_data_where($table, $where, $order_by = NULL, $order = "ASC")
	{
		if ($order_by != NULL) {
			$this->db->order_by($order_by, $order);
		}
		$query = $this->db->get_where($table, $where);
		return $query->result();
	}

	public function get_single_table_query($query)
	{
		$query = $this->db->query($query);
		return $query->row();
	}

	public function get_all_table_query($query)
	{
		$query = $this->db->query($query);
		return $query->result();
	}
}
