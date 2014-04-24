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
				'notification_message' => $message,
				'notification_info' => $input_source,
				'notification_time' => date('H:i:s')
			),
			'registration_ids' => $registration_ids
		);
	
		$headers = array(
			'Authorization: key=' . GOOGLE_PUBLIC_API_KEY,
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