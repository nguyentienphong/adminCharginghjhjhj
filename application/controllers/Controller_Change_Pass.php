<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller_Change_Pass extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Change password';

		$this->load->model('model_users');
	}


	public function index()
	{
		$this->render_template('change_pass/index', $this->data);
	}

	public function change_password()
	{
		//$this->logged_in();
		echo("Start change passs");
		$this->form_validation->set_rules('oldpassword', 'Password', 'required');
		$this->form_validation->set_rules('newpassword', 'Password', 'required');
		$this->form_validation->set_rules('confnewpassword', 'Password', 'required');

		$userid = $this->session->userdata('id');
        if ($this->form_validation->run() == TRUE) {
			echo('Run here...');
			if (isset($_POST['submit'])) {
				$oldpass = $_POST['oldpassword'];
				$newpass = $_POST['newpassword'];
				$confnewpass = $_POST['confnewpassword'];

				if($newpass != $confnewpass)
				{
					//Password moi nhap khong dung
					$this->data['errors'] = 'Incorrect username/password combination';
           			$this->load->view('change_pass', $this->data);
				}else{
					echo('Run herer');
					$changePassRs = $this->model_users->change_pass($oldpass, $newpass, $userid);
					if($changePassRs > 0)
					{
						$this->data['errors'] = 'Change pass success';
           				$this->load->view('change_pass', $this->data);
					}else if($changePassRs = -1){
						$this->data['errors'] = 'Invalid old pass';
           				$this->load->view('change_pass', $this->data);
					}
					else{
						$this->data['errors'] = 'Change pass fail';
           				$this->load->view('change_pass', $this->data);
					}
				}
			}
            // true case
        }
        else {
			// false case
			echo("Run here");
			$this->data['errors'] = 'Valid param fail';
            $this->load->view('change_pass/index');
        }	
	}
}