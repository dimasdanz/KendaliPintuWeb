<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dcs extends CI_Controller{

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logged_in') == NULL){
			redirect(base_url() . 'login', 'refresh');
		}
		$this->load->model('User_model');
		$this->load->model('Log_model');
	}

	public function index(){
		$data = array(
			'content' => 'dcs/dcs_home',
			'contentData' => array(
				'' 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function users(){
		$data = array(
			'content' => 'dcs/dcs_user',
			'contentData' => array(
				'dcs_users' => $this->User_model->get_all(),
				'form_data' => array(
					$this->User_model->get_id()
				)
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function log(){
		$data = array(
			'content' => 'dcs/dcs_log',
			'contentData' => array(
				'dcs_log' => $this->Log_model->get_all() 
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function setting(){
		$data = array(
			'content' => 'dcs/dcs_setting',
			'contentData' => array(
				'status' => read_file("assets/device/dcs/status.txt"),
				'password_attempts' => read_file("assets/device/dcs/password_attempts.txt"),
				'condition' => read_file("assets/device/dcs/condition.txt")
			) 
		);
		$this->load->view('template/layout', $data);
	}

	public function insert(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|numeric|xss_clean');
		
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$password = $this->input->post('password');
		
		if($this->form_validation->run() == FALSE){
			$msg = array(
				$id,
				$name,
				$password,
				validation_errors(),
				'insert'
			);
			$this->session->set_flashdata('error', $msg);
			redirect('/dcs/users', 'refresh');
		}else{
			$data = array(
				'user_id' => $id,
				'name' => $name,
				'password' => $password 
			);
			$this->User_model->insert($data);
			$this->session->set_flashdata('success', 'Pengguna baru telah ditambahkan');
			redirect('/dcs/users', 'refresh');
		}
	}

	public function update(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|numeric|xss_clean');
		
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$password = $this->input->post('password');
		
		if($this->form_validation->run() == FALSE){
			$msg = array(
				$id,
				$name,
				$password,
				validation_errors(),
				'update'
			);
			$this->session->set_flashdata('error', $msg);
			redirect(base_url() . 'dcs/users', 'refresh');
		}else{
			$data = array(
				'name' => $name,
				'password' => $password 
			);
			$this->User_model->update($id, $data);
			$this->session->set_flashdata('success', $name . ' telah diperbarui');
			redirect('/dcs/users', 'refresh');
		}
	}

	public function delete(){
		$this->User_model->delete($this->input->post('user_id'));
		$this->session->set_flashdata('success', 'Pengguna telah dihapus');
		redirect('/dcs/users', 'refresh');
	}

	public function change_attempt(){
		if(read_file("assets/device/dcs/condition.txt") == 1){
			$this->session->set_flashdata('message', array(
				'danger',
				'Please unlock the device first' 
			));
			redirect('/dcs/setting', 'refresh');
			return;
		}
		
		$this->form_validation->set_rules('password_attempts', 'Password Attempts', 'trim|required|numeric|xss_clean');
		$password_attempts = $this->input->post('password_attempts');
		
		if($this->form_validation->run() == FALSE){
			$msg = array(
				'danger',
				validation_errors() 
			);
			$this->session->set_flashdata('message', $msg);
			redirect(base_url() . 'dcs/setting', 'refresh');
		}else{
			write_file("assets/device/dcs/password_attempts.txt", $password_attempts);
			$this->session->set_flashdata('message', array(
				'success',
				'Batas pengulangan kata sandi telah berubah' 
			));
			redirect('/dcs/setting', 'refresh');
		}
	}

	public function change_status(){
		if(read_file("assets/device/dcs/condition.txt") == 1){
			$this->session->set_flashdata('message', array(
				'danger',
				'Buka kunci perangkat terlebih dahulu' 
			));
			redirect(base_url() . 'dcs/setting', 'refresh');
			return;
		}
		if($this->input->post('status') == 'on'){
			$status = 1;
			$string = 'dihidupkan';
			$this->insert_log('Perangkat Dihidupkan');
		}else{
			$status = 0;
			$string = 'dimatikan';
			$this->insert_log('Perangkat Dimatikan');
		}
		write_file("assets/device/dcs/status.txt", $status);
		$this->session->set_flashdata('message', array(
			'success',
			'Perangkat telah '.$string 
		));
		redirect('/dcs/setting', 'refresh');
	}

	public function unlock(){
		write_file("assets/device/dcs/condition.txt", "0");
		$this->session->set_flashdata('message', array(
			'success',
			'Perangkat telah dibuka' 
		));
		$this->insert_log('Perangkat Terbuka');
		redirect('/dcs/setting', 'refresh');
	}
	
	public function insert_log($name){
		$data = array(
				'name' => $name
		);
		$this->Log_model->insert($data);
	}
}