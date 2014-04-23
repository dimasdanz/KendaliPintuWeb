<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class AndroidLib{
	public function send_notification($user_id = '', $message = '', $input_source = ''){
		$CI = &get_instance();
		$CI->load->model('Device_model');
		$url = 'https://android.googleapis.com/gcm/send';
	
		$device = $CI->Device_model->get_exception($user_id);
	
		$registration_ids = array();
	
		foreach($device as $device_id){
			array_push($registration_ids, $device_id->gcm_id);
		}
	
		$fields = array(
			'data' => array(
				'notification_message' => urldecode($message),
				'notification_time' => date('H:i:s')
			),
			'registration_ids' => $registration_ids
		);
	
		$headers = array(
			'Authorization: key=' . 'AIzaSyCNvec01uSRgGsz7IW9ei6zSfkfCcGXTwY',
			'Content-Type: application/json'
		);
	
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, $url);
	
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	
		$result = curl_exec($ch);
		if ($result === FALSE) {
			//die('Curl failed: ' . curl_error($ch));
			return false;
		}
	
		curl_close($ch);
		return true;
	}
}