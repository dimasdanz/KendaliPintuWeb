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

class Device_model extends CI_Model{
	private $tableName = 'devices';
	private $user_id = 'user_id';
	private $gcm_id = 'gcm_id';
	
	function get_all(){
		$q = $this->db->get($this->tableName);
		return $q->result();
	}
	
	function get_single($id){
		$this->db->where('user_id', $id);
		$q = $this->db->get($this->tableName);
		if($q->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function get_exception($user_id){
		$this->db->where('user_id !=', $user_id);
		$q = $this->db->get($this->tableName);
		return $q->result();
	}
	
	function insert($data){
		$this->db->insert($this->tableName, $data);
	}
	
	function delete($id){
		$this->db->where('user_id', $id);
		$this->db->delete($this->tableName);
	}
}