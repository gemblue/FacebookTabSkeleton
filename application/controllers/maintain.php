<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check extends CI_Controller 
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('nyan_auth');
	}
	
	function reset_data()
	{
		# setting
		$table['user'] = 'tbl_users';
		$table['user_meta'] = 'tbl_usermetas';
		$table['posts'] = 'tbl_posts';
		$table['post_meta'] = 'tbl_postmeta';
		$table['terms'] = 'tbl_terms';
		$table['term_relationships'] = 'tbl_term_relationships';
		$table['term_taxonomy'] = 'tbl_term_taxonomy';
		$table['widget'] = 'tbl_widget';
		$table['widget_area'] = 'tbl_widget_area';
		$table['role_user'] = 'tbl_role_user';
		$table['entries'] = 'tbl_entries';
		$table['entry_metas'] = 'tbl_entrymetas';
		$table['comments'] = 'tbl_comments';
		
		# reset user
		$sql = "DELETE FROM $table[user] WHERE 1";
		$query = $this->db->query($sql);
		
		$sql = "DELETE FROM $table[user_meta] WHERE 1";
		$query = $this->db->query($sql);
		
		$sql = "DELETE FROM $table[role_user] WHERE 1";
		$query = $this->db->query($sql);
		
		# reset posts
		$sql = "DELETE FROM $table[posts] WHERE 1";
		$query = $this->db->query($sql);
		
		$sql = "DELETE FROM $table[post_meta] WHERE 1";
		$query = $this->db->query($sql);
		
		# reset terms
		$sql = "DELETE FROM $table[terms] WHERE 1";
		$query = $this->db->query($sql);
		
		$sql = "DELETE FROM $table[term_relationships] WHERE 1";
		$query = $this->db->query($sql);
		
		$sql = "DELETE FROM $table[term_taxonomy] WHERE 1";
		$query = $this->db->query($sql);
		
		# reset widget
		$sql = "DELETE FROM $table[widget] WHERE 1";
		$query = $this->db->query($sql);
		
		$sql = "DELETE FROM $table[widget_area] WHERE 1";
		$query = $this->db->query($sql);
		
		# reset entry
		$sql = "DELETE FROM $table[entries] WHERE 1";
		$query = $this->db->query($sql);
		
		$sql = "DELETE FROM $table[entry_metas] WHERE 1";
		$query = $this->db->query($sql);
		
		# reset comments
		$sql = "DELETE FROM $table[comments] WHERE 1";
		$query = $this->db->query($sql);
		
		# add administrator for back end access
		$data['email'] = 'oriza@ajita.co.id';
		$data['username'] = 'mimin';
		$data['password'] = $this->nyan_auth->hash_password('mimin12345');
		$data['type'] = 'default';
		$data['status'] = 'active';
		$data['created_at'] = date('Y-m-d H:i:s');
		
		$sql = "INSERT INTO $table[user] (id, email, username, password, type, status, created_at) VALUES ('1','$data[email]','$data[username]','$data[password]',
		       '$data[type]', '$data[status]', '$data[created_at]') ";
		$query = $this->db->query($sql);
		
		$sql = "INSERT INTO $table[role_user] (user_id, role_id, created_at) VALUES ('1','1','$data[created_at]') ";
		$query = $this->db->query($sql);
		
		echo 'Reset successfully..';
	}
	
	
	
}



