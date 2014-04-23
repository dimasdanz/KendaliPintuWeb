<?php if(!defined('BASEPATH'))	exit('No direct script access allowed');

class web extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function today_log(){
		$this->load->model('Log_model');
		$log = $this->Log_model->get_today();
		$data = array();
		foreach($log as $value){
			$val = array(
				'name' => $value->name, 
				'info' => $value->input_source, 
				'time' => date('H:i:s', strtotime($value->time))
			);
			array_push($data, $val);
		}
		echo json_encode($data);
	}
	
	public function open_door(){
		$this->load->library('ArduinoLib');
		$this->load->library('LoggerLib');
		$this->arduinolib->open_door('web', $this->session->userdata('logged_in'), 'Web');
	}
}