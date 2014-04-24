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

class Log_model extends CI_Model{
	private $tableName = 'logs';
	private $id = 'id';
	private $user_id = 'user_id';
	private $name = 'name';
	private $input_source = 'input_source';
	private $time = 'time';
	
	function get_all(){
		$this->db->order_by($this->time, 'desc');
		$q = $this->db->get($this->tableName);
		return $q->result();
	}
	
	function get_date(){
		$this->db->distinct();
		$this->db->select("date($this->time) as date");
		$this->db->order_by($this->time, 'desc');
		$q = $this->db->get($this->tableName);
		return $q->result();
	}
	
	function get_date_detail($param){
		$this->db->where("date($this->time)", date('Y-m-d', strtotime($param)));
		$this->db->order_by($this->time, 'desc');
		$q = $this->db->get($this->tableName);
		return $q->result();
	}
	
	function get_today(){
		$this->db->where("date($this->time)", date('Y-m-d'));
		$this->db->order_by($this->time, 'desc');
		$q = $this->db->get($this->tableName, 20);
		return $q->result();
	}
	
	function insert($data){
		$this->db->insert($this->tableName, $data);
	}
}