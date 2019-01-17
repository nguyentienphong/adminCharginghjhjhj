<?php 

class model_update_pending extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	protected $_tblTransactions = 'tbl_transactions';
	
	public function get_list_trans($fromDate, $toDate, $search){
		$fromdate = $fromDate.' 00:00:00';
		$todate = $toDate.' 23:59:59';
		if(!empty($fromDate))
			$this->db->where("receive_date >=", $fromdate);
		if(!empty($toDate))
			$this->db->where("receive_date <=", $todate);
		
		if(!empty($search))
			$this->db->where($search);
		
		$this->db->where('final_status', '99');
        $this->db->from($this->_tblTransactions);
		$this->db->order_by('receive_date', 'ASC');
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->result();
		else
			return false;
	}

	public function get_detail_trans($request_id){
		$this->db->where("T.request_id", $request_id);
		$this->db->where('T.final_status', '99');
		//$this->db->join('tbl_order_details D', 'T.order_detail_id = D.order_id');
		$query = $this->db->get("$this->_tblTransactions T");
		
		if($query->num_rows() > 0) {
			$query = $query->result();
			return $query[0];
		} else {
			return false;
		}
	}
	
	public function update_transaction($request_id, $data_update){
		$this->db->where("request_id", $request_id);
		$this->db->update($this->_tblTransactions, $data_update);
		return true;
	}
}