<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
class admins extends CI_Controller{

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect('/login', 'refresh');
		}
		$this->load->model('Admin_model');
	}

	public function index(){
		$data = array(
			'content' => 'Admin_view',
			'contentData' => array(
				'admin' => $this->Admin_model->get_all()
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function insert(){
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha|xss_clean|callback_username_check');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirmation Password', 'trim|required|xss_clean');
		
		$username = $this->input->post('username');
		
		if($this->form_validation->run() == FALSE){
			$msg = array(
				$username,
				validation_errors() 
			);
			$this->session->set_flashdata('error', $msg);
			redirect('/admins', 'refresh');
		}else{
			$this->load->library('PasswordHash');
			
			$password = $this->passwordhash->HashPassword($this->input->post('password'));
			
			$data = array(
				'username' => $username,
				'password' => $password 
			);
			$this->Admin_model->insert($data);
			$this->session->set_flashdata('success', 'New Admin has been added');
			redirect('/admins', 'refresh');
		}
	}

	public function delete(){
		$username = $this->input->post('username');
		if($username == $this->session->userdata('logged_in')){
			$this->session->set_flashdata('delete_error', 'Deleting logged in account is restricted');
			redirect('/admins', 'refresh');
		}
		$this->Admin_model->delete($username);
		$this->session->set_flashdata('success', $username . ' has been deleted');
		redirect('/admins', 'refresh');
	}

	public function username_check($str){
		$username = $this->Admin_model->get_single($str);
		if($username != NULL){
			$this->form_validation->set_message('username_check', 'Username is not available');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function reset_password(){
		$this->load->library('PasswordHash');
		$username = $this->input->post('username');
		$password = $this->passwordhash->HashPassword('default');
		$data = array(
			'password' => $password
		);
		$this->Admin_model->reset_password($username, $data);
		$this->session->set_flashdata('success', $username . ' password has been reset to default');
		redirect('/admins', 'refresh');
	}
}
?>