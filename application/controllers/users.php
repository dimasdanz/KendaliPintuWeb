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

class users extends CI_Controller{
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in') == NULL){
			redirect(base_url() . 'login', 'refresh');
		}
		$this->load->model('User_model');
	}
	
	public function index(){
		$data = array(
				'content' => 'Users_view',
				'contentData' => array(
					'users_list' => $this->User_model->get_all(),
					'form_data' => array(
						$this->User_model->get_id()
					)
				)
		);
		$this->load->view('template/layout', $data);
	}
	
	public function insert(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|numeric|max_length[5]|xss_clean');
	
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$password = $this->input->post('password');
	
		if($this->form_validation->run() == FALSE){
			$msg = array(
					$id,
					$name,
					$password,
					validation_errors(),
					'insert'
			);
			$this->session->set_flashdata('error', $msg);
			redirect('/users', 'refresh');
		}else{
			$data = array(
					'user_id' => $id,
					'name' => $name,
					'password' => $password
			);
			$this->User_model->insert($data);
			$this->session->set_flashdata('success', 'Pengguna baru telah ditambahkan');
			redirect('/users', 'refresh');
		}
	}
	
	public function update(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|numeric|max_length[5]|xss_clean');
	
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$password = $this->input->post('password');
	
		if($this->form_validation->run() == FALSE){
			$msg = array(
					$id,
					$name,
					$password,
					validation_errors(),
					'update'
			);
			$this->session->set_flashdata('error', $msg);
			redirect('/users', 'refresh');
		}else{
			$data = array(
					'name' => $name,
					'password' => $password
			);
			$this->User_model->update($id, $data);
			$this->session->set_flashdata('success', $name . ' telah diperbarui');
			redirect('/users', 'refresh');
		}
	}
	
	public function delete(){
		$this->User_model->delete($this->input->post('user_id'));
		$this->session->set_flashdata('success', 'Pengguna telah dihapus');
		redirect('/users', 'refresh');
	}
}