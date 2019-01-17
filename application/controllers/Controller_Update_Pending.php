<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Update_Pending extends Admin_Controller
{
    public function __construct()
    {

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        parent::__construct();

        $this->not_logged_in();

        // load Pagination library
        $this->load->library('pagination');

        // load URL helper
        $this->load->helper('url');

        $this->load->model('model_update_pending');
        
    }


    /*
    * It only redirects to the manage product page and
    */
    public function index()
    {
        session_start();
        $this->set_current_page();
       
        $params = array();
		$params['page_title'] = 'Update Pending';
        $limit_per_page = 50;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$enableSearch = false;
		
		if($_POST){
			$this->form_validation->set_rules('fromDate', 'fromDate', 'trim');
			$this->form_validation->set_rules('toDate', 'toDate', 'trim');
			$this->form_validation->set_rules('request_id', 'request id', 'trim|xss_clean');
			if ($this->form_validation->run()) {
				$enableSearch = true;
				$fromDate = "";
				$toDate = "";
				if($this->input->post('fromDate') != null && $this->input->post('fromDate') != '')
					$fromDate = date("Y-m-d", strtotime($this->input->post('fromDate')));
				
				if($this->input->post('toDate') != null && $this->input->post('toDate') != '')
					$toDate = date("Y-m-d", strtotime($this->input->post('toDate')));
				if($this->input->post('toDate') !== '' && $this->input->post('fromDate') !== '') {
					$day_span_to_select = $this->calculateTwoDate($fromDate, $toDate);
					 if (200 < $day_span_to_select || $day_span_to_select < 0) {
						echo "<script>
						alert('Khoang thoi gian can check='+$day_span_to_select +' ,qua gioi han hoac khong hop le');
						</script>";
						$enableSearch = false;
					}
				}
				
				$where = array();
				if($this->input->post('request_id') != '')
					$where['request_id'] = $this->input->post('request_id');
			}
		}
			
        if ($enableSearch) {
            $params["results"] = $this->model_update_pending->get_list_trans($fromDate,$toDate,$where);
        } 
		
        $config['base_url'] = base_url() . 'paging/config';
		
        $params["totalAmount"] = $this->calculateTotalAmount($arrResult);
        $config['base_url'] = base_url() . 'Controller_Update_Pending/index';
        //$config['total_rows'] = $total_records;
        $config['per_page'] = $limit_per_page;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        // build paging links
        $params["links"] = $this->pagination->create_links();
        

        $this->render_template('update_pending/index', $params);

    }

	public function Update_Pending($request_id){
		if(isset($request_id) && !empty($request_id)){
			$params = array();
			$params['page_title'] = 'Update Pending';
			$params['transaction_detail'] = $this->model_update_pending->get_detail_trans($request_id);
			if($params['transaction_detail']){
				if($_POST){
					if($this->model_update_pending->update_transaction($request_id, $_POST)){
						$this->session->set_flashdata('success', 'Update success');
						$this->load->library('redis');
						$redis = new CI_Redis();
						$redis->sRem('KEY1_HASH_ORDERS_PENDING', $params['transaction_detail']['order_id'] . '_' . $params['transaction_detail']['phone_number']);
						redirect('Controller_Update_Pending', 'refresh');
					}
				}
				
				$this->render_template('update_pending/detail', $params);
			} else {
				redirect('Controller_Update_Pending');
			}
		}
	}
	
	
    public function calculateTotalAmount($arrResult)
    {
        $totalAmount = 0;
        foreach ($arrResult as $data) {
            $totalAmount += $data->total_amount;
        }
        return $totalAmount;
    }





}