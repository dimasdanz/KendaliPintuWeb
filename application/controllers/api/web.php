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