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

class dashboard extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect('/login','refresh');
		}
	}
	
	public function index(){
		$data = array(
			'content' => 'Dashboard_view',
			'contentData' => array(
				''
			)
		);
		$this->load->view('template/layout', $data);
	}
	
	public function error_404(){
		$this->load->view('template/error_404');
	}
}

?>