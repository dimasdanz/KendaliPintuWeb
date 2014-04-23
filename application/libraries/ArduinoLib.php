<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

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