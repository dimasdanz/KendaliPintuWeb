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

class ArduinoLib{
	public function open_door($user_id, $name, $info){
		if($this->send_command('o')){
			$CI = &get_instance();
			$CI->load->library('LoggerLib');
			$CI->loggerlib->insert_log($user_id, $name, $info);
			return true;
		}else{
			return false;
		}
	}
	
	public function activate(){
		if($this->send_command('s2')){
			$CI = &get_instance();
			$CI->load->library('LoggerLib');
			$CI->loggerlib->insert_log('sys', 'Perangkat Aktif', 'System Log');
			return true;
		}else{
			return false;
		}
	}
	
	public function deactivate(){
		if($this->send_command('s0')){
			$CI = &get_instance();
			$CI->load->library('LoggerLib');
			$CI->loggerlib->insert_log('sys', 'Perangkat Non-Aktif', 'System Log');
			return true;
		}else{
			return false;
		}
	}
	
	public function get_status(){
		return $this->send_command('c');
	}
	
	public function check(){
		return $this->send_command('a');
	}
	
	public function wrong_password($input){
		$CI = &get_instance();
		$CI->load->library('LoggerLib');
		$CI->loggerlib->insert_log('err', $input, 'Password Salah');
		return $this->send_command('f');
	}
	
	public function send_command($command){
		$url = 'http://192.168.1.73/command_'.$command;
		$headers = array(
			'Accept: application/json'
		);
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPGET,true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
		$reply = curl_exec($ch);
		if ($reply === false) {
			return false;
		}
		curl_close($ch);
		$decoded_data = json_decode($reply, true);
		return $reply;
	}
}