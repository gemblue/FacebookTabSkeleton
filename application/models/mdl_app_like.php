<?php
class Mdl_app_like extends CI_Model
{
	var $app_like = 'tbl_app_like';

	function __construct()
	{
		parent::__construct();
	}
	
	/*
	|
	| ---------------------------------------------------------------
	| GET / RETRIEVE
	| ---------------------------------------------------------------
	|
	*/
	
	function get_like($result = 'array')
	{
		/*
		model to get like data
		*/
		
		$this->db->select($this->app_like.'.facebook_id,'.$this->app_like.'.ip,'.$this->app_like.'.created_at');
		$this->db->from($this->app_like);
		$this->db->order_by($this->app_like.'.created_at','desc');
		$this->db->group_by($this->app_like.'.facebook_id'); 
		
		if ($result == 'total')
		{
			return $this->db->get()->num_rows();
		}
		else
		{
			return $this->db->get()->result();
		}
	}

	/*
	|
	| ---------------------------------------------------------------
	| CHECKER MODEL RETURN TRUE/FALSE IS_THIS
	| ---------------------------------------------------------------
	|
	*/
	
	function is_have_like($username)
	{
		/*
		model to check existing username
		*/
		$sql = "SELECT id FROM $this->app_like WHERE username = '$username'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	/*
	|
	| ---------------------------------------------------------------
	| CREATE
	| ---------------------------------------------------------------
	|
	*/
	
	function new_like($facebook_id)
	{
		/*
		model to save new like
		*/
		
		# insert 
		$now = date('Y:m:d H:i:s');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$sql = "INSERT INTO $this->app_like (facebook_id, ip, created_at) VALUES ('$facebook_id','$ip','$now')";
		$query = $this->db->query($sql);
		return true;
	}
}