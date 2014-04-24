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

class User_model extends CI_Model{
	private $tableName = 'users';
	private $id = 'id';
	private $user_id = 'user_id';
	private $name = 'name';
	private $password = 'password';
	
	function get_id(){
		$this->db->select($this->user_id);
		$this->db->order_by($this->user_id, 'desc');
		$q = $this->db->get($this->tableName);
		$id = $q->row();
		if(empty($id)){
			return '001';
		}else{
			$id = str_pad($id->user_id + 1, 3, 0, STR_PAD_LEFT);
			return $id;
		}
	}
	
	function get_all(){
		$q = $this->db->get($this->tableName);
		return $q->result();
	}

	function get_single($user_id){
		$this->db->where($this->user_id, $user_id);
		$q = $this->db->get($this->tableName);
		return $q->row();
	}
	
	function fetch_user($limit, $start){
		$this->db->limit($limit, $start);
		$this->db->order_by($this->name);
		$q = $this->db->get($this->tableName);
		if($q->num_rows() > 0){
			return $q->result();
		}
		return false;
	}
	
	function users_count(){
		return $this->db->count_all($this->tableName);
	}
	
	function insert($data){
		$this->db->insert($this->tableName, $data);
	}
	
	function update($user_id,$data){
		$this->db->where($this->user_id, $user_id);
		$this->db->update($this->tableName, $data);
	}
	
	function delete($user_id){
		$this->db->where($this->user_id, $user_id);
		$this->db->delete($this->tableName);
	}
}
?>