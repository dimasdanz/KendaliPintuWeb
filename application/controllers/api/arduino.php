<?php if(!defined('BASEPATH'))	exit('No direct script access allowed');

class arduino extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('ArduinoLib');
	}
	
	public function auth_user($input = ''){
		$this->load->model('User_model');
		$this->load->library('LoggerLib');
		if($input == 'keluar'){
			$this->loggerlib->insert_log('sys', 'Keluar', 'Push-Button Keluar');
			return;
		}
		$user_id = substr($input, 0, 3);
		$password = substr($input, 3, (strlen($input) - 3));
		$data = $this->User_model->get_single($user_id);
		if($data != null){
			if($password == $data->password){
				$this->arduinolib->open_door($data->user_id, $data->name, 'Keypad Masuk');
			}else{
				$this->arduinolib->wrong_password($input);
			}
		}else{
			$this->arduinolib->wrong_password($input);
		}
	}

	/*
	 * Response
	 * active => Active
	 * inactive => Inactive
	 * offline => Offline
	 * */
	public function check_arduino(){
		header('Content-Type: text/json');
		$data = $this->arduinolib->get_status('c');
		if($data){
			echo $data;
		}else{
			echo '{"response":"offline"}';
		}
	}
	
	public function deactivate(){
		$response['result'] = $this->arduinolib->deactivate();
		echo json_encode($response);
	}
	
	public function activate(){
		$response['result'] = $this->arduinolib->activate();
		echo json_encode($response);
	}
}