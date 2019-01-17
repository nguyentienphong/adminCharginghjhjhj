<?php 

class Model_change_pass extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active brands information*/
	public function getAllTransactions()
	{
		$sql = "select request_id,partner_id,partner_username,card_pin,card_serial,provider_code,receive_date,
		response_date,final_status,response_amount from tbl_transactions where 1 = 1";
		//$query = $this->db->query($sql, array(1));
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get the brand data */
	public function getTransactionData($id = null)
	{
		$partner_username = $this->session->userdata('partner_username');
		
		//if($partner_username != null) {
			$sql = "select request_id,partner_id,partner_username,card_pin,card_serial,provider_code,receive_date,
			response_date,final_status,response_amount from tbl_transactions where partner_username = ?";
			$query = $this->db->query($sql, $partner_username);
			//return $query->row_array();
		// }
		// else{
		// 	$sql = "select request_id,partner_id,partner_username,card_pin,card_serial,provider_code,receive_date,
		// 	response_date,request_status,remark from tbl_transactions ";
		// 	$query = $this->db->query($sql);	
		// }
		
		return $query->result_array();
	}

	public function countTransactionData($id = null)
	{
		$partner_username = $this->session->userdata('partner_username');
		
		//if($partner_username != null) {
			$sql = "select * from tbl_transactions where partner_username = ?";
			$query = $this->db->query($sql, $partner_username);
			//return $query->row_array();
		// }
		// else{
		// 	$sql = "select request_id,partner_id,partner_username,card_pin,card_serial,provider_code,receive_date,
		// 	response_date,request_status,remark from tbl_transactions ";
		// 	$query = $this->db->query($sql);	
		// }
		
		return $query->num_rows();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('brands', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('brands', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('brands');
			return ($delete == true) ? true : false;
		}
	}

}