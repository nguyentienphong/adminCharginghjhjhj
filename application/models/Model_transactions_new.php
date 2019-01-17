<?php 

class model_transactions_new extends CI_Model
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

	/* get the brand data */
	public function getAllTransactionData()
	{
		//$partner_username = $this->session->userdata('partner_username');
		
		//if($partner_username != null) {
			$sql = "select count(request_id) quantity,sum(response_amount) total_amount,partner_username
			from tbl_transactions where final_status = '00'
			group by partner_username";
			$query = $this->db->query($sql);
			//return $query->row_array();
		// }
		// else{
		// 	$sql = "select request_id,partner_id,partner_username,card_pin,card_serial,provider_code,receive_date,
		// 	response_date,request_status,remark from tbl_transactions ";
		// 	$query = $this->db->query($sql);	
		// }
		
		return $query->result_array();
	}

	// Lay tong so ban ghi theo du lieu dau vao de tinh toan phan trang
	public function get_current_page_records($limit, $start, $partner_username,$request_id, $serial, $pin)
	{
		$sql = "select * from tbl_transactions where partner_username = ? order by receive_date desc";
		$query = $this->db->query($sql, $partner_username, $limit, $start);
		//$query = $this->db->query($sql, $partner_username);
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			 
			return $data;
		}
	  
		return false;
	}

	// Lay tong so ban ghi theo du lieu dau vao de tinh toan phan trang
	public function get_total_summary_rec($partner_username, $fromDate, $toDate)
	{
		$fromdate = $fromdate.'-00-00-00';
		$toDate = $toDate.'-23-59-59';
		if(empty($partner_username))
		{
			$partner_username = '%';
		}
		$sql = "select count(request_id) quantity,sum(response_amount) total_amount,partner_username,partner_id,provider_code
		from tbl_transactions where final_status = '00'
		and receive_date >= STR_TO_DATE(?, '%d/%m/%Y-%H-%i-%s')
		and receive_date <= STR_TO_DATE(?, '%d/%m/%Y-%H-%i-%s')
		and partner_username like ?
		group by partner_username,partner_id,provider_code;";
		$query = $this->db->query($sql, array($fromDate,$toDate,$partner_username));
		//$query = $this->db->query($sql, $partner_username);
		log_message('error','get_total_summary_rec'.$partner_username.$fromDate.$toDate.$query->num_rows());
		return $query->num_rows();
		
	}

	public function get_current_summary_rep($limit, $start,$partner_username, $fromDate, $toDate)
	{	
		$fromDate = $fromDate.'-00-00-00';
		$toDate = $toDate.'-23-59-59';
		if(empty($partner_username))
		{
			$partner_username = '%';
		}
		$sql = "select count(request_id) quantity,sum(response_amount) total_amount,partner_username,partner_id,provider_code
		from tbl_transactions where final_status = '00'
		and receive_date >= STR_TO_DATE(?, '%d/%m/%Y-%H-%i-%s')
		and receive_date <= STR_TO_DATE(?, '%d/%m/%Y-%H-%i-%s')
		and partner_username like ? 
		
		group by partner_username,partner_id,provider_code";
		$query = $this->db->query($sql, array($fromDate,$toDate,$partner_username));
		
		log_message('error','get_current_summary_rep'.$query->num_rows());
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			 
			return $data;
		}
	  
		return false;
	}

	//Lay danh sach chi tiet cac ban ghi de hien thi dang phan trang
	public function get_current_page_record1s($limit, $start,$partner_username,$request_id, $serial, $pin)
	{
		log_message('error', 'get_current_page_record1s');
		if(!empty($partner_username))
		{
		$this->db->where("partner_username",$partner_username);//set filter 
		}
		$this->db->like('request_id', $request_id, 'both');
		$this->db->like('card_serial', $serial, 'both');
		$this->db->like('card_pin', $pin, 'both');
		$this->db->limit($limit, $start);
		$query = $this->db->get("tbl_transactions");
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			 
			return $data;
		}
	  
		return false;
	}


	public function countTransactionData($partner_username,$request_id, $serial, $pin, $fromdate, $todate,$status)
	{	
		if(empty($fromdate)||empty(todate))
		{return;}
		$fromdate = $fromdate.'-00-00-00';
		$todate = $todate.'-23-59-59';	
		
		$sql = "select * from tbl_transactions where 
		receive_date >= STR_TO_DATE(?, '%d/%m/%Y-%H-%i-%s')
		and receive_date <= STR_TO_DATE(?, '%d/%m/%Y-%H-%i-%s')
		and partner_username like ? and request_id like ? 
		and card_serial like ? and card_pin like ? and final_status like ?";
		
		if(empty($partner_username))
		{
			$partner_username = "%";
		}  if(empty($request_id))
		{
			$request_id = "%";
		}
		 if(empty($serial))
		{
			$serial = "%";
		}
		 if(empty($pin))
		{
			$pin = "%";
		}
		if(empty($status))
		{
			$status = "%";
		}
		$query = $this->db->query($sql, array( $fromdate,$todate,$partner_username,$request_id,$serial, $pin, $status));
		
		log_message('error','countTransactionData'.$partner_username.$fromdate.$todate.$request_id.$serial.$pin);
		return $query->num_rows();
	}

	public function selectTransactionPaging($limit_per_page, $start_index,$partner_username,$request_id, $serial, $pin, $fromdate, $todate,$status)
	{	
		$fromdate = $fromdate.'-00-00-00';
		$todate = $todate.'-23-59-59';
		
		
		$sql = "select * from tbl_transactions where 
		receive_date >= STR_TO_DATE(?, '%d/%m/%Y-%H-%i-%s')
		and receive_date <= STR_TO_DATE(?, '%d/%m/%Y-%H-%i-%s')
		and partner_username like ? and request_id like ? 
		and card_serial like ? and card_pin like ? and final_status like ?  order by receive_date asc limit ? offset ?";
		
		if(empty($partner_username))
		{
			$partner_username = "%";
		}  if(empty($request_id))
		{
			$request_id = "%";
		}
		 if(empty($serial))
		{
			$serial = "%";
		}
		 if(empty($pin))
		{
			$pin = "%";
		}
		if(empty($status))
		{
			$status = "%";
		}

		$query = $this->db->query($sql, array( $fromdate,$todate,$partner_username,$request_id,$serial, $pin, $status,$limit_per_page, (int)$start_index));
		
		log_message('error','countTransactionData'.$partner_username.$fromdate.$todate.$request_id.$serial.$pin);
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	public function reset_check_pending($fromdate, $todate)
	{	
		if(empty($fromdate)||empty($todate))
		{return;}
		$fromdate = $fromdate.'-00-00-00';
		$todate = $todate.'-23-59-59';	
		
		$sql = "update tbl_transactions set check_pending_time = 0 where final_status = '99' and request_id_telco is not null";
		
		
		$query = $this->db->query($sql);
		
		//log_message('error','reset_check_pending_time'.$partner_username.$fromdate.$todate.$request_id.$serial.$pin);
		try
		{
			$query->execute();
		}catch(Exception $e){

		}
		
		return 1;
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