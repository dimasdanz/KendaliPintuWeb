<?php

if(! defined('BASEPATH')) exit('No direct script access allowed');
class login extends CI_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		if($this->session->userdata('logged_in') != NULL){
			redirect(base_url());
		}
		$data = array(
			'content' => 'Login_view',
			'contentData' => array(
				'' 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function validate(){
		$this->load->library('PasswordHash');
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_login_check');
		
		if($this->form_validation->run() == FALSE){
			$msg = validation_errors();
			$this->session->set_flashdata('error', $msg);
			redirect('/login', 'refresh');
		}else{
			redirect('/', 'refresh');
		}
	}

	public function login_check($str){
		$this->load->model('Admin_model');
		
		$username = $this->Admin_model->get_single($this->input->post('username'));
		if($username){
			if($this->passwordhash->CheckPassword($str, $username->password)){
				$this->session->set_userdata('logged_in', $username->username);
				return true;
			}else{
				$this->form_validation->set_message('login_check', 'Invalid username or password');
				return false;
			}
		}else{
			$this->form_validation->set_message('login_check', 'No account associated with this username');
			return false;
		}
	}

	public function logout(){
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('/login', 'refresh');
	}
}
?>