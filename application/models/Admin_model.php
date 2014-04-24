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

class Admin_model extends CI_Model{
	private $tableName = 'admins';
	private $id = 'id';
	private $username = 'username';
	private $password = 'password';
	
	function get_all(){
		$q = $this->db->get($this->tableName);
		return $q->result();
	}
	
	function get_single($username){
		$this->db->where('username', $username);
		$q = $this->db->get($this->tableName);
		return $q->row();
	}
	
	function insert($data){
		$this->db->insert($this->tableName, $data);
	}
	
	function reset_password($username, $data){
		$this->db->where('username', $username);
		$this->db->update($this->tableName, $data);
	}
	
	function delete($username){
		$this->db->where('username', $username);
		$this->db->delete($this->tableName);
	}
}
?>