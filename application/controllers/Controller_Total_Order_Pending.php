<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Total_Order_Pending extends Admin_Controller 
{
	public function __construct()
	{
		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Total partner manager';

		// load Pagination library
		$this->load->library('pagination');
		
	   // load URL helper
	   $this->load->helper('url');

		$this->load->model('model_tbl_orders');
	}

	
	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		session_start();
		$this->set_current_page();
		//$result = $this->model_transactions->getTransactionData();
		$partner_username = $this->session->userdata('partner_username');
		//$this->data['results'] = $result;
        // init params
        $params = array();
		$params['page_title'] = 'Tổng hợp giao dịch';
        $limit_per_page = 50;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	
		$enableSearch = false;
		
		if ($_POST) {
			$this->form_validation->set_rules('fromDate', 'fromDate', 'trim');
			$this->form_validation->set_rules('toDate', 'toDate', 'trim');
			$this->form_validation->set_rules('Provider', 'Provider', 'trim|xss_clean');
			$this->form_validation->set_rules('partner_id', 'partner_id', 'trim|xss_clean');
			if ($this->form_validation->run()) {
				$enableSearch = true;
				$fromDate = "";
				$toDate = "";
				
				if($this->input->post('fromDate') != null && $this->input->post('fromDate') != '')
					$fromDate = date("Y-m-d", strtotime($this->input->post('fromDate')));
				
				if($this->input->post('toDate') != null && $this->input->post('toDate') != '')
					$toDate = date("Y-m-d", strtotime($this->input->post('toDate')));
				
				if($this->input->post('toDate') !== '' && $this->input->post('fromDate') !== '') {
					$day_span_to_select = $this->calculateTwoDate($fromDate,$toDate);
					$day_span_to_select = $this->calculateTwoDate($this->input->post('fromDate'),$this->input->post('toDate'));
					if(30 < $day_span_to_select || $day_span_to_select < 0) {
						echo "<script>
						alert('Khoang thoi gian can check='+$day_span_to_select +' ,qua gioi han hoac khong hop le');
						</script>";
						$enableSearch = false;
					}
				}
				
				$where = array();
				if($this->input->post('Provider') != '')
					$where['provider_code'] = $this->input->post('Provider');
				if($this->input->post('partner_id') != '')
					$where['partner_id'] = $this->input->post('partner_id');
				
			}
		}
		
		$enableSearch = true;
		if($enableSearch)
		{
			$params["results"]['TU'] = $this->model_tbl_orders->get_total_pending('1'); // TOPUP
			$params["results"]['KH'] = $this->model_tbl_orders->get_total_pending('2'); // Khop the
		
			//$config['base_url'] = base_url() . 'Controller_Partner_Transaction/index';
            //$config['total_rows'] = $total_records;
            //$config['per_page'] = $limit_per_page;
            //$config["uri_segment"] = 3;
			//$config['base_url'] = base_url() . 'paging/config';
            // 
            //$this->pagination->initialize($config);
             
            // build paging links
            //$params["links"] = $this->pagination->create_links();
        }
        
		//$params['list_provider'] = $this->model_transactions->get_list_providers();
		//$params['list_partner'] = $this->model_transactions->get_list_partner();
		$this->render_template('total_order_pending/index', $params);
		
	}


	public function calculateTotalAmount($arrResult)
	{
		$totalAmount = 0;
		foreach($arrResult as $data)
		{
			$totalAmount += $data->total_amount;
		}
		return $totalAmount;
	}

	/*
	* It checks if it gets the brand id and retreives
	* the brand information from the brand model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchBrandDataById($id)
	{
		if($id) {
			$data = $this->model_brands->getBrandData($id);
			echo json_encode($data);
		}

		return false;
	}

}