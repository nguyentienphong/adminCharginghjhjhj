<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_transaction extends Admin_Controller 
{
	public function __construct()
	{
		$this->clean_session();
		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Transaction manager';

		// load Pagination library
		$this->load->library('pagination');
		
	   // load URL helper
	   $this->load->helper('url');

		$this->load->model('model_transactions');
	}


	public function clean_session()
	{
		if (isset($_SESSION['previous'])) {
			if (basename($_SERVER['PHP_SELF']) != $_SESSION['previous']) {
				 //session_destroy();
				 unset($_SESSION['storeValues']);
				 ### or alternatively, you can use this for specific variables:
				 ### unset($_SESSION['varname']);
			}
		 }
	}
	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		session_start();
		$this->clean_session();
		$this->set_current_page();

		$partner_username = "";
		$requestId = "";
		$fromDate = "";
		$toDate = "";
		$serial = "";
		$pin = "";
		$finalStatus = "";
		
		$where = array();
		
		if (!isset($_SESSION['HasSearched'])) {
			$_SESSION['HasSearched'] = 0;
		}
		if(isset($_POST['submit_checkpending']))
		{
			$this->reset_check_pending_time();
			$this->render_template('transactions/index', null);
			return;
		}
		# start of page:
		if (isset($_POST['submit'])) {
			$_SESSION['HasSearched'] = 0;
		}
		# when you execute code for displaying search results
		# check first if the session has been set:
		if ($_SESSION['HasSearched'] == 0) {
			# proceed with search code
			# then set it to 1 since a search has been performed just now
			$_SESSION['HasSearched'] = 1;

			$where['partner_id'] = isset($_POST['partner_id']) ? $_POST['partner_id'] : '';
			$where['request_id'] =  isset($_POST['requestId']) ? $_POST['requestId'] : '';
			$fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
			$toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';
			$where['card_serial'] = isset($_POST['serial']) ? $_POST['serial'] : '';
			$where['final_status'] = isset($_POST['slFinalStatus']) ? $_POST['slFinalStatus'] : '';
			$_arrSearchValues = array($partner_username, $requestId, $fromDate,$toDate,$serial,$pin,$finalStatus);
    		$_SESSION['storeValues'] = $_arrSearchValues;
		} else {
			# this means a search had been previously made.
			# based on your requirement, no results should be displayed
			# since the assumption would be that a new search would be put in place

			# code to display fresh page with search form goes here
			# reset the session variable's value
			//$_SESSION['HasSearched'] = 0;
			$where['partner_id'] = $_SESSION['storeValues'][0];
			$where['request_id'] =  $_SESSION['storeValues'][1];
			$fromDate = $_SESSION['storeValues'][2];
			$toDate = $_SESSION['storeValues'][3];
			$where['card_serial'] = $_SESSION['storeValues'][4];
			$finalStatus = $_SESSION['storeValues'][6];
		}
		
		//$partner_username = $this->session->userdata('partner_username');
		//$this->data['results'] = $result;
        // init params
        $params = array();
		$limit_per_page = 50;
		
		$start_index =  (int)($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
        $total_records = $this->model_transactions->countTransactionData($fromDate, $toDate, $where);
		$config['base_url'] = base_url() . 'paging/config';
		
        if ($total_records > 0) 
        {
            // get current page records
            $params["results"] = $this->model_transactions->selectTransactionPaging($limit_per_page, $start_index,$partner_username,$requestId,$serial,$pin,$fromDate, $toDate,$finalStatus);
             
            $config['base_url'] = base_url() . 'Controller_transaction/index';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             
            $this->pagination->initialize($config);
             
            // build paging links
            $params["links"] = $this->pagination->create_links();
        }
        $params['page_title'] = 'Chi tiết giao dịch';
        $params['list_partner'] = $this->model_transactions->get_list_partner();
        $this->render_template('transactions/index', $params);
	}


	public function reset_check_pending_time()
	{
		$fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
		$toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';
		$this->model_transactions->reset_check_pending($fromDate, $toDate);

		echo "<script>
			alert('Reset check pending success');
			</script>";
	}

	/*
	* Its checks the brand form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{

		if(!in_array('createBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('brand_name', 'Item name', 'trim|required');
		$this->form_validation->set_rules('active', 'Active', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('brand_name'),
        		'active' => $this->input->post('active'),	
        	);

        	$create = $this->model_brands->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the brand information';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);

	}

	/*
	* Its checks the brand form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id)
	{
		if(!in_array('updateBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_brand_name', 'Item name', 'trim|required');
			$this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'name' => $this->input->post('edit_brand_name'),
	        		'active' => $this->input->post('edit_active'),	
	        	);

	        	$update = $this->model_brands->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the brand information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	/*
	* It removes the brand information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteBrand', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$brand_id = $this->input->post('brand_id');
		$response = array();
		if($brand_id) {
			$delete = $this->model_brands->remove($brand_id);

			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the brand information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

}