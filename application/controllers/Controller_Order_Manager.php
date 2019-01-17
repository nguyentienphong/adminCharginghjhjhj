<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Order_Manager extends Admin_Controller
{
    public function __construct()
    {

        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Total partner orders';

        // load Pagination library
        $this->load->library('pagination');

        // load URL helper
        $this->load->helper('url');

        $this->load->model('model_orders');
        $this->load->model('model_users');
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
        $limit_per_page = 50;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$where = array();
        if(isset($_POST['partner_id']) && $_POST['partner_id'] != '')
			$where['partner_id'] = $_POST['partner_id'];
		
		$fromDate = "";
        $toDate = "";
		
		if($this->input->post('fromDate') != null && $this->input->post('fromDate') != '')
			$fromDate = date("Y-m-d", strtotime($this->input->post('fromDate')));
		
		if($this->input->post('toDate') != null && $this->input->post('toDate') != '')
			$toDate = date("Y-m-d", strtotime($this->input->post('toDate')));
		

        $day_span_to_select = $this->calculateTwoDate($fromDate, $toDate);
        $orderStatus = '%';
        $enableSearch = true;

        if (200 < $day_span_to_select || $day_span_to_select < 0) {
            echo "<script>
			alert('Khoang thoi gian can check='+$day_span_to_select +' ,qua gioi han hoac khong hop le');
			</script>";
            $enableSearch = false;
        }

        if ($enableSearch) {
            //$total_records = $this->model_transactions->get_total_summary_rec($partner_username,$fromDate,$toDate);

        } else {
            $total_records = 0;
        }
        $config['base_url'] = base_url() . 'paging/config';

        //if ($total_records > 0) 
        //{
        // get current page records
        $arrResult = $this->model_orders->get_partner_orders_by_paging($fromDate, $toDate, $where);

        $params["results"] = $arrResult;
        $params["totalAmount"] = $this->calculateTotalAmount($arrResult);
        $config['base_url'] = base_url() . 'Controller_Order_Manager/index';
        $config['total_rows'] = $total_records;
        $config['per_page'] = $limit_per_page;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        // build paging links
        //$params["links"] = $this->pagination->create_links();
        //}
		$params['list_partner'] = $this->model_orders->get_list_partner();
		$params['page_title'] = 'Order Manage';
        $this->render_template('order_manager/index', $params);

    }


    public function calculateTotalAmount($arrResult)
    {
        $totalAmount = 0;
        foreach ($arrResult as $data) {
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
        if ($id) {
            $data = $this->model_brands->getBrandData($id);
            echo json_encode($data);
        }

        return false;
    }

    /*
    * Its checks the brand form validation
    * and if the validation is successfully then it inserts the data into the database
    * and returns the json format operation messages
    */
    public function create()
    {
        if (!in_array('createUser', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		//var_dump($_POST); die;
		if($_POST){
			
			$uploadCompleteFile = $this->uploadfile();

			
	//        var_dump($uploadCompleteFile);die;

	//		$this->form_validation->set_rules('order_name', 'Order name', 'trim|required|min_length[5]|max_length[12]|is_unique[tbl_orders.order_name]');
	//		$this->form_validation->set_rules('order_remark', 'Order remark', 'trim|required');
	//		$this->form_validation->set_rules('partner_name', 'Partner', 'trim|required|min_length[8]');
	//		$this->form_validation->set_rules('order_expire', 'Order expire', 'trim|required');
	//		$this->form_validation->set_rules('fname', 'First name', 'trim|required');

			$order_name = isset($_POST['order_name']) ? $_POST['order_name'] : '';
			$order_remark = isset($_POST['order_remark']) ? $_POST['order_remark'] : '';
			$partner_name = isset($_POST['partner_name']) ? $_POST['partner_name'] : '';
			$partner_id = isset($_POST['partner_id']) ? $_POST['partner_id'] : '';
			$telco = isset($_POST['telco']) ? $_POST['telco'] : '';
			$order_expire = isset($_POST['order_expire']) ? $_POST['order_expire'] : '';
			$order_quantity = isset($_POST['order_quantity']) ? $_POST['order_quantity'] : '';
			$order_total_amount = isset($_POST['order_total_amount']) ? $_POST['order_total_amount'] : '';
			$order_is_prioritize = isset($_POST['order_is_prioritize']) ? $_POST['order_is_prioritize'] : '';
			$order_detail_file = isset($_POST['order_detail_file']) ? $_POST['order_detail_file'] : '';
			if (isset($uploadCompleteFile) & $uploadCompleteFile != '') {
				$uploadSuc = $uploadCompleteFile;
				if ($_FILES['fileToUpload']['size'] > 0) {
					// check type file .xlsx
	//                var_dump($_FILES['fileToUpload']['size']);
					$extends = '#.+\.(xlsx)$#i';
					if (preg_match($extends, $_FILES['fileToUpload']['name']) == 1) {
						$this->load->file('phpExcel/Classes/PHPExcel.php');
						$this->load->file('phpExcel/Classes/PHPExcel/IOFactory.php');
	//                    $file = $_FILES['fileToUpload']['tmp_name'];
	//                    $file = FCPATH . '/uploads/ORDER_DETAILS.xlsx';
						$file = $uploadCompleteFile;
						// read file from path
						$inputFileType = 'Excel2007';
						$objReader = PHPExcel_IOFactory::createReader($inputFileType);

						// import for MC
						$objPHPExcel = $objReader->load($file);
						$sheet = $objPHPExcel->getActiveSheet(0);

						// validate format file excel
	//                    $validFile = $this->validFormatFile($sheet);
	//                    if ($validFile) {
						$cell_collection = $sheet->getCellCollection();
						$telco = $sheet->getCell('B2')->getCalculatedValue();
						
						if($telco == $_POST['telco']){
							foreach ($cell_collection as $cell) {
								$column = $sheet->getCell($cell)->getColumn();
								$row = $sheet->getCell($cell)->getRow();
								//log_message('error', 'row conlection: ' . $column . '-' . $row);
								$data_value = $sheet->getCell($cell)->getCalculatedValue();
								if ($row > 4) {
									$arr_data[$row][$column] = $data_value;
									array_filter($arr_data);
								}
							}
							
							$countTrans = 0;
							$sumAmount = 0;
							
							$date = date('Y-m-d H:i:s', time());
							$partner = explode(":", $partner_name);
							$insertOrder = array();
							$insertOrder['ordername']               = $order_name;
							
							$insertOrder['order_created_date']      = $date;
							$insertOrder['order_created_by']        = $this->session->userdata('partner_username');
							$insertOrder['order_remark']            = $order_remark;
							$insertOrder['order_by_sale']           = $this->session->userdata('partner_username');
							$insertOrder['admin_review_status']     = 'A';
							$insertOrder['admin_reivew_date']       = $date;
							$insertOrder['order_status']            = 'W';
							$insertOrder['order_expire_date']       = $order_expire;
							$insertOrder['partner_id']              = $partner[0];
							$insertOrder['partner_username']        = $partner[1];
							$insertOrder['provider_code']           = $telco;

							$order_id = $this->model_tbl_orders->insertOrder($insertOrder);
							
							foreach ($arr_data as $row) {
									$insert = array();
									if($row['C'] == 'KT'){
										$insert['type']         = '2';
									}else{
										$insert['type']         = '1';
									}

									$hedPhone = substr($row['A'], 0, 1);

									if($hedPhone == '0'){
										$insert['phoneNumber'] = $row['A'];
									}else{
										$hederPhone = substr($row['A'], 0, 2);
										if($hederPhone == '84'){
											$lasPhone = substr($row['A'], 2 , strlen($row['A']));
											$insert['phoneNumber']  = '0'.$lasPhone;
										}else {
											$insert['phoneNumber'] = '0' . $row['A'];
										}
									}
									$insert['amount']       = $row['B'];
									$insert['order_status'] = 'W';
									//$insert['total']        = $row['D'];
									$insert['tecol']        = $telco;
									$insert['order_id']     = $order_id;
									$insert['created_date'] = $date;
							// INSERT VAO DAY
								 $this->model_tbl_orders->insertOrderDetail($insert);
								 $sumAmount += $row['B'];
								 $countTrans += 1;
							}
							
							// update tbl_order
							$updateOrder = array();
							$updateOrder['order_total_amount'] = $sumAmount;
							$updateOrder['order_total_quantity']    = $countTrans;
							$this->model_tbl_orders->updateOrder($updateOrder);
							
							$this->session->set_flashdata('success', 'Thêm mới đợn hàng thành công');
							redirect('Controller_Order_Manager', 'refresh');
						} else {
							log_message('error', 'Chọn provider khác với file upload');
							
							$this->session->set_flashdata('error', 'Chọn provider khác với file upload');
							redirect('Controller_Order_Manager/create', 'refresh');
						}
					} else {
						log_message('error', 'File upload không đúng định dạng.');
						$this->session->set_flashdata('error', 'File upload không đúng định dạng.');
						redirect('Controller_Order_Manager/create', 'refresh');
					}
				} else {
					log_message('error', 'Chưa chọn File upload.');
					$this->session->set_flashdata('error', 'Chưa chọn File upload.');
					redirect('Controller_Order_Manager/create', 'refresh');
				}
			}
		}
			
        if ($this->form_validation->run() == TRUE) {
            // true case
            //$createdate = date('Y-m-d H:i:s');
            //$data = array(
            //    'order_name' => $order_name,
            //    'order_total_amount' => $order_total_amount,
            //    'order_total_quantity' => $order_quantity,
            //    'order_created_by' => 'admin',
            //    'order_remark' => $order_remark,
            //    'order_by_sale' => 'sale',
            //    'admin_review_status' => 'I',
            //    'admin_review_date' => $createdate,
            //    'provider_code' => $telco,
            //    'order_expire_date' => $this->convert_date($order_expire),
            //
            //);
            //
            //$create = $this->model_users->create($data, $this->input->post('groups'));
            //if ($create == true) {
            //    $this->session->set_flashdata('success', 'Successfully created');
            //    redirect('order_manager/', 'refresh');
            //} else {
            //    $this->session->set_flashdata('errors', 'Error occurred!!');
            //    redirect('order_manager/create', 'refresh');
            //}
        } else {
            // false case
            $group_data = $this->model_groups->getGroupData();
            $partners_data = $this->model_users->getAllPartner();
            $this->data['group_data'] = $group_data;
            $this->data['partners'] = $partners_data;
            $this->data['upload_file'] = $uploadSuc;
            $this->render_template('order_manager/create', $this->data);
        }

    }
	
	public function create_order_name($partner_name, $provider){
		
		$partner_name = str_replace(':', '_', $partner_name);
		
		$arrReturn = array('html' => 'ORDER_' . $partner_name . '_'  . $provider . '_' . date('hms') . uniqid());
		echo json_encode($arrReturn) ;
	}

    public function convert_date($strdate)
    {
        $s = strdate . ' 00:00:00';
        $date = strtotime($s);
        return date('d/M/Y H:i:s', $date);
    }

    public function uploadfile()
    {
        //if ($_POST['submit'] == 'Upload Order') {
            if (!empty($_FILES['fileToUpload']) && !file_exists($_FILES['fileToUpload']) && !is_uploaded_file($_FILES['fileToUpload'])) {
                $path = "uploads/";
                $path = $path . basename($_FILES['fileToUpload']['name']);
                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $path)) {
//                    echo "The file " . basename($_FILES['fileToUpload']['name']) .
//                        " has been uploaded";
                } else {
//                    echo "There was an error uploading the file, please try again!";
                }
            } else {
                echo "File da ton tai";
            }
            return getcwd() . '/' . $path;
        //}
        //return '';
    }

    /*
    * Its checks the brand form validation
    * and if the validation is successfully then it updates the data into the database
    * and returns the json format operation messages
    */
    public function update($id)
    {
        if (!in_array('updateBrand', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($id) {
            $this->form_validation->set_rules('edit_brand_name', 'Item name', 'trim|required');
            $this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('edit_brand_name'),
                    'active' => $this->input->post('edit_active'),
                );

                $update = $this->model_brands->update($data, $id);
                if ($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Succesfully updated';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while updated the brand information';
                }
            } else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        } else {
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
        if (!in_array('deleteBrand', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $brand_id = $this->input->post('brand_id');
        $response = array();
        if ($brand_id) {
            $delete = $this->model_brands->remove($brand_id);

            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the brand information";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
    }
	
	public function detail($id){
		$params = array();
		$params['page_title'] = 'Order Manage';
		
		$params['order_info'] = $this->model_orders->get_oder_info($id);
		if($params['order_info']){
			// get list order detail
			$params['list_order_detail'] = $this->model_orders->get_list_order_detail($id);
		} else {
			redirect('Controller_All_Order');
		}
		
		$this->render_template('order_manager/detail', $params);
	}
	
	public function stop_order($id){
		$params = array();
		$params['page_title'] = 'Order Manage';
		
		if($_POST){
			log_message('error', 'fuck');
			var_dump($_POST); die;
		}
		
		$params['order_info'] = $this->model_orders->get_oder_info($id);
		if($params['order_info']){
			// get list order detail
			$params['list_order_detail'] = $this->model_orders->get_list_order_detail($id);
		} else {
			redirect('Controller_All_Order');
		}
		
		$this->render_template('order_manager/stop', $params);
	}
}