<?php
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