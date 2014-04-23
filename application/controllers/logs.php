<?php
class logs extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect(base_url() . 'login', 'refresh');
		}
		$this->load->model('Log_model');
	}
	
	public function index(){
		$data = array(
				'content' => 'Logs_view',
				'contentData' => array(
					'logs_list' => $this->Log_model->get_all()
				)
		);
		$this->load->view('template/layout', $data);
	}
}