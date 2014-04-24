<?php
class about extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect(base_url() . 'login', 'refresh');
		}
		$this->load->model('Log_model');
	}
	
	public function index(){
		$data = array(
			'content' => 'About_view',
			'contentData' => array(
				''
			)
		);
		$this->load->view('template/layout', $data);
	}
}