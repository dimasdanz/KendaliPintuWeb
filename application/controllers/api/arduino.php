<?php if(!defined('BASEPATH'))	exit('No direct script access allowed');
/*******************************************************************************
 * Copyright (c) 2014 Dimas Rullyan Danu.
 * 
 * This file is part of Kendali Pintu
 * 
 * Kendali Pintu is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Kendali Pintu is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Kendali Pintu. If not, see <http://www.gnu.org/licenses/>.
 ******************************************************************************/

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