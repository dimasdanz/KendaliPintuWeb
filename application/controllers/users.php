<?php
class users extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect(base_url() . 'login', 'refresh');
		}
		$this->load->model('User_model');
	}
	
	public function index(){
		$data = array(
				'content' => 'Users_view',
				'contentData' => array(
					'users_list' => $this->User_model->get_all(),
					'form_data' => array(
						$this->User_model->get_id()
					)
				)
		);
		$this->load->view('template/layout', $data);
	}
	
	public function insert(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|numeric|max_length[5]|xss_clean');
	
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
			redirect('/users', 'refresh');
		}else{
			$data = array(
					'user_id' => $id,
					'name' => $name,
					'password' => $password
			);
			$this->User_model->insert($data);
			$this->session->set_flashdata('success', 'Pengguna baru telah ditambahkan');
			redirect('/users', 'refresh');
		}
	}
	
	public function update(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|numeric|max_length[5]|xss_clean');
	
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
			redirect('/users', 'refresh');
		}else{
			$data = array(
					'name' => $name,
					'password' => $password
			);
			$this->User_model->update($id, $data);
			$this->session->set_flashdata('success', $name . ' telah diperbarui');
			redirect('/users', 'refresh');
		}
	}
	
	public function delete(){
		$this->User_model->delete($this->input->post('user_id'));
		$this->session->set_flashdata('success', 'Pengguna telah dihapus');
		redirect('/users', 'refresh');
	}
}