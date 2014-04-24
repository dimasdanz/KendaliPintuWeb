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