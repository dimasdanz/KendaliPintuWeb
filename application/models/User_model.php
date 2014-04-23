<?php
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