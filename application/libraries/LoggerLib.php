<?php if(!defined('BASEPATH'))	exit('No direct script access allowed');

class LoggerLib{
	public function insert_log($user_id, $name, $input_source){
		$CI = &get_instance();
		$CI->load->model('Log_model');
		$CI->load->library('AndroidLib');
		
		$data = array(
				'user_id' => $user_id,
				'name' => $name,
				'input_source' => $input_source
		);
		
		$CI->Log_model->insert($data);
		$CI->androidlib->send_notification($user_id, $name, $input_source);
	}
}