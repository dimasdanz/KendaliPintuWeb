<?php
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