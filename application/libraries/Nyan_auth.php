<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Nyan_auth {

	var $ci = null;

	# setting
	var $table = 'tbl_users';
	var $id_field = 'id';
	var $username_field = 'username';
	var $password_field = 'password';
	var $email_field = 'email';
	var $status = 'status';

	# if want login with username or email give true value!
	var $double_check = true;

	# hash method and salt
	var $hash = array(
					'use_hash' => true, 
					'use_salt' => true,
					'salt' => '$aJ1t4',
					'hash_method' => 'md5'
				);
				
	# constructor
	function Nyan_auth()
	{
		$this->ci =& get_instance();
		$this->ci->load->database();
		
		# load model
		$this->ci->load->model('mdl_role');
		$this->ci->load->model('mdl_user');
	}
	
	function login($param1 = null, $param2 = null)
	{
		/*
		Normal login to website 
		return true : success
		*/
		
		# hash control
		if ($this->hash['use_hash'] == true)
		{
			if ($this->hash['hash_method'] == 'md5')
			{
				if ($this->hash['use_salt'] == true) {
					$param2 = md5($param2.$this->hash['salt']);
				} else {
					$param2 = md5($param2);
				}
			}
		}
			
		# check
		$this->ci->db->from($this->table);
		$this->ci->db->where($this->email_field, $param1);
		$this->ci->db->where($this->password_field, $param2);
		$this->ci->db->where($this->status,'active');
		$query = $this->ci->db->get();
			
		# user is registered
		if ($query->num_rows() == 1)
		{
			# get user data
			foreach ($query->result() as $row)
			{
				$id = $row->id;
				$username = $row->username;
					
				# define the role
				$role_id = $this->ci->mdl_role->get_user_role($id);
			}
				
			# give session
			$newdata = array(
						 'username'  => $username,
						 'id' => $id,
						 'role_id' => $role_id,
						 'logged_in' => 'hore'
					   );
			$this->ci->session->set_userdata($newdata);
			
			# update last login
			$now = date('Y:m:d H:i:s');
			$this->ci->mdl_user->update_user_master($id, 'last_login', $now);
			
			return true;
		}  
		else 
		{
			if ($this->double_check == true)
			{
				# not valid, check from username
				$this->ci->db->from($this->table);
				$this->ci->db->where($this->username_field, $param1);
				$this->ci->db->where($this->password_field, $param2);
				$this->ci->db->where($this->status,'active');
				$query = $this->ci->db->get();
					
				# user is registered
				if ($query->num_rows() == 1)
				{
					# get user data
					foreach ($query->result() as $row)
					{
						$id = $row->id;
						$username = $row->username;
							
						# define the role
						$role_id = $this->ci->mdl_role->get_user_role($id);
					}
						
					# give session
					$newdata = array(
								 'username'  => $username,
								 'id' => $id,
								 'role_id' => $role_id,
								 'logged_in' => 'hore'
							   );
					$this->ci->session->set_userdata($newdata);
					
					# update last login
					$now = date('Y:m:d H:i:s');
					$this->ci->mdl_user->update_user_master($id, 'last_login', $now);
					
					return true;
				}  
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}		
	}
	
	function force_login($id_user)
	{
		/*
		Login to website with rock! 
		return true : success
		*/
	
		$username = $this->ci->mdl_user->get_username($id_user, 'id');
		$role_id = $this->ci->mdl_role->get_user_role($id_user);
		
		# give session
		$newdata = array(
						 'username'  => $username,
					 	 'id' => $id_user,
						 'role_id' => $role_id,
						 'logged_in' => 'hore'
					   );
					   
		$this->ci->session->set_userdata($newdata);
		
		# update last login
		$now = date('Y:m:d H:i:s');
		$this->ci->mdl_user->update_user_master($id_user, 'last_login', $now);
					
		return true;
	}
	
	function hash_password($password){
		
		/*
		Get hashed password from your password config
		return : string hashed password
		*/
		
		$password = md5($password.$this->hash['salt']);
		return $password;
	}
	
	function reset_password($id_user){
		
		/*
		Reset the user password
		return true : success
		*/
		
		$this->ci->load->helper('string');
		$password = random_string('alnum', 5);
		
		# hash control
		if ($this->hash['use_hash'] == true)
		{
			if ($this->hash['hash_method'] == 'md5')
			{
				if ($this->hash['use_salt'] == true) {
					$password = md5($password.$this->hash['salt']);
				} else {
					$password = md5($password);
				}
			}
		}
			
		$sql = "UPDATE $this->table SET $this->password_field = '$password' WHERE $this->id_field = '$id_user'";
		$this->ci->db->query($sql);
		
		$result = array ('message' => 'done', 'password' => $password);
		return $result;
	}
	
	function reset_password_confirmation($user_id, $email, $type = 'default', $password = null)
	{
		/*
		Send the user reset password confirmation
		*/
		
		# update token first for new request
		$this->ci->mdl_user->update_user_token($user_id);
		
		# load mail library
		$this->ci->load->library('email');
		
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$website = 'la-lights.com';
		$this->ci->email->initialize($config);
		
		if ($type == 'default')
		{
			$token = $this->ci->mdl_user->get_user_meta($user_id, 'token');
			
			$msg =  'You have requested to reset your password in <b>'.$website.'</b>. Please follow this link below to complete your request <br />
					 <a href='.site_url('users/confirmation/'.$token.'/reset-password').'>'.site_url('users/confirmation/'.$token.'/reset-password').'</a>';
				
			$subject = 'Password Reset Confirmation';
		}
		else if ($type == 'success-reset-password')
		{
			$msg =  'You have requested to reset your password in <b>'.$website.'</b>. Below, your new password <br />'.
					'Password :'.$password;
		
			$subject = 'Password Reset Success';
		}
		else
		{
			break;
			return false;
		}
		
		$this->ci->email->from('no-reply@'.$website, 'no-reply');
		$this->ci->email->to($email);
										
		$this->ci->email->subject($subject);
		$this->ci->email->message($msg);
		$this->ci->email->send();
		
		return true;
	}
}


