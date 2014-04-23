<?php
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