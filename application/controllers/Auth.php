<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_auth');
	}

	/* 
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/
	public function login()
	{

		$this->logged_in();

		$this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
           	$email_exists = $this->model_auth->check_email($this->input->post('email'));

           	if($email_exists == TRUE) {
           		$login = $this->model_auth->login($this->input->post('email'), md5($this->input->post('password')));

           		if($login) {		
           			$logged_in_sess = array(
           				'id' => $login['id'],
				        'username'  => $login['username'],
						'email'     => $login['email'],
						'partner_username' => $login['partner_username'],
				        'logged_in' => TRUE
					);

					if($login['username']!='super admin')
					{
						$this->data['errors'] = 'Incorrect username/password combination';
           				$this->load->view('login', $this->data);
					}
					else
					{
						$this->session->set_userdata($logged_in_sess);
					   redirect('Controller_Total_Order_Pending');
					}
           		}
           		else {
           			$this->data['errors'] = 'Incorrect username/password combination';
           			$this->load->view('login', $this->data);
           		}
           	}
           	else {
				log_message('error', 'No Email found');
           		$this->data['errors'] = 'Email does not exists';

           		$this->load->view('login', $this->data);
           	}	
        }
        else {
            // false case
            $this->load->view('login');
        }	
	}

	/*
		clears the session and redirects to login page
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('index.php/auth/login', 'refresh');
	}

}
