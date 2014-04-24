<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
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

class android extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	}
		
   /*
	* Login Response
	* 0 = Login false
	* 1 = Login true
	* 2 = Login invalid (no username with that ID)
	*/
	public function login(){
		$this->load->model('User_model');
		$username = $this->User_model->get_single($this->input->post('user_id'));
		if($username){
			if($this->input->post('password') == $username->password){
				$response['response'] = 1;
				$response['user_id'] = $username->user_id;
			}else{
				$response['response'] = 0;
			}
		}else{
			$response['response'] = 2;
		}
		echo json_encode($response);
	}
	
	public function login_admin(){
		$this->load->model('Admin_model');
		$this->load->library('PasswordHash');
	
		$username = $this->Admin_model->get_single($this->input->post('username'));
		if($username){
			if($this->passwordhash->CheckPassword($this->input->post('password'), $username->password)){
				$response['response'] = 1;
				$response['username'] = $username->username;
			}else{
				$response['response'] = 0;
			}
		}else{
			$response['response'] = 2;
		}
		echo json_encode($response);
	}

	public function register_device(){
		$this->load->model('Device_model');
		$user_id = $this->input->post('user_id');
		$gcm_id = $this->input->post('gcm_id');
	
		$data = array(
			'user_id' => $user_id,
			'gcm_id' => $gcm_id
		);
		if($this->Device_model->get_single($user_id)){
			$this->Device_model->delete($user_id);
		}
		$this->Device_model->insert($data);
		$response['response'] = 1;
		echo json_encode($response);
	}
	
	public function open_door(){
		$this->load->model('User_model');
		$this->load->library('ArduinoLib');
		$this->load->library('LoggerLib');
		$user_id = $this->input->post('username_id');
		$input_source = $this->input->post('input_source');
		$data = $this->User_model->get_single($user_id);
		if($this->arduinolib->open_door($data->user_id, $data->name, $input_source)){
			$response['response'] = true;
			echo json_encode($response);
		}else{
			$response['response'] = false;
			echo json_encode($response);
		}
	}
	
	public function get_log_date(){
		$this->load->model('Log_model');
		$data = $this->Log_model->get_date();
		$response['date'] = array();
		foreach($data as $row){
			array_push($response['date'], date('d F Y', strtotime($row->date)));
		}
		echo json_encode($response);
	}
	
	public function get_log_detail(){
		$this->load->model('Log_model');
		$param = $this->input->post('date');
		$data = $this->Log_model->get_date_detail($param);
		$response['name'] = array();
		$response['time'] = array();
		$response['info'] = array();
		foreach($data as $row){
			array_push($response['name'], $row->name);
			array_push($response['time'], date('h:i:s', strtotime($row->time)));
			array_push($response['info'], $row->input_source);
		}
		echo json_encode($response);
	}
	
	public function get_users(){
		$this->load->model('User_model');
		$this->load->library('pagination');
		$config = array(
				'base_url' => base_url() . '/api/android/dcs_get_user', 
				'total_rows' => $this->User_model->users_count(),
				'per_page' => 5, 
				'uri_segment' => 4
		);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$offset = $page == 0 ? 0 : ($page - 1) * $config["per_page"];
		$data = $this->User_model->fetch_user($config['per_page'], $offset);
		$response['userid'] = array();
		$response['username'] = array();
		$response['userpass'] = array();
		if($data != null){
			$response['response'] = 1;
			foreach($data as $row){
				array_push($response['userid'], $row->user_id);
				array_push($response['username'], $row->name);
				array_push($response['userpass'], $row->password);
			}
		}else{
			$response['response'] = 0;
		}
		echo json_encode($response);
	}
	
	public function insert_user(){
		$this->load->model('User_model');
		$name = $this->input->post('name');
		$password = $this->input->post('password');
		if($name == "" or $password == ""){
			$response['response'] = 0;
			echo json_encode($response);
		}else{
			$data = array(
					'user_id' => $this->User_model->get_id(),
					'name' => $name,
					'password' => $password
			);
			$this->User_model->insert($data);
	
			$response['response'] = 1;
			echo json_encode($response);
		}
	}
	
	public function update_user(){
		$this->load->model('User_model');
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$password = $this->input->post('password');
		$data = array(
				'name' => $name,
				'password' => $password
		);
		$this->User_model->update($id, $data);
	
		$response['response'] = 1;
		echo json_encode($response);
	}
	
	public function delete_user(){
		$this->load->model('User_model');
		$id = $this->input->post('id');
		$this->User_model->delete($id);
	
		$response['response'] = 1;
		echo json_encode($response);
	}
}