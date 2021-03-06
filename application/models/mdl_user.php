<?php
class Mdl_user extends CI_Model
{
	var $users = 'tbl_users';
	var $users_meta = 'tbl_usermetas';
	var $users_role = 'tbl_role_user';
	var $website = 'nyankod.com';
	
	function __construct()
	{
		parent::__construct();
		
		# load role model
		$this->load->model('mdl_role');	
	}
	
	/*
	|
	| ---------------------------------------------------------------
	| GET / RETRIEVE
	| ---------------------------------------------------------------
	|
	*/
	
	function get_all_user()
	{
		/*
		model to get all user
		*/
		$sql = "SELECT username AS name, id FROM $this->users";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function get_list_user($status, $num, $pg)
	{
		/*
		model to get all user list
		*/
		$this->db->select($this->users.'.status,'.$this->users.'.id,'.$this->users.'.username,'.$this->users.'.email');
		$this->db->from($this->users);
		
		if($status != 'all') {
			$this->db->where($this->users.'.status', $status);
		}
		
		$this->db->limit($num, $pg);
		$this->db->order_by($this->users.'.id','desc');
		return $this->db->get()->result();
	}

	function get_tot_user($status)
	{
		/*
		model to get total users
		*/
		if($status == 'all') {
			$sql = "SELECT id FROM $this->users";
		} else {
			$sql = "SELECT id FROM $this->users WHERE status = '$status'";
		}
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function get_user($field_value, $by_field)
	{
		/*
		model to get user data by field
		*/
		$sql = "SELECT * FROM $this->users WHERE $by_field = '$field_value'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_user_id($field_value, $by_field)
	{
		/*
		model to get user id by field
		*/
		$sql = "SELECT id FROM $this->users WHERE $by_field = '$field_value'";
		$query = $this->db->query($sql);
		$data =  $query->result();
		
		$id = null;
		
		foreach ($data as $row)
		{
			$id = $row->id;
		}
		
		return $id;
	}
	
	function get_username($field_value, $by_field)
	{
		/*
		model to get username by field
		*/
		$sql = "SELECT username FROM $this->users WHERE $by_field = '$field_value'";
		$query = $this->db->query($sql);
		$data =  $query->result();
		
		$username = null;
		
		foreach ($data as $row)
		{
			$username = $row->username;
		}
		
		return $username;
	}
	
	function get_user_mail($field_value, $by_field)
	{
		/*
		model to get user mail by field
		*/
		$sql = "SELECT email FROM $this->users WHERE $by_field = '$field_value'";
		$query = $this->db->query($sql);
		$data =  $query->result();
		
		foreach ($data as $row)
		{
			$email = $row->email;
		}
		
		return $email;
	}
	
	function get_field_value($field_name, $by_field, $field_value)
	{
		/*
		model to get field value by other field
		*/
		$sql = "SELECT $field_name AS result FROM $this->users WHERE $by_field = '$field_value'";
		$query = $this->db->query($sql);
		$data = $query->result();
		
		$result = null;
		
		foreach ($data as $row)
		{
			$result = $row->result;
		}
		
		return $result;
	}
	
	function get_avatar($user_id, $size = 'normal')
	{
		/*
		Model to get user avatar
		*/
		
		# if user register with facebook, display facebook avatar
		$user['facebook_id'] = $this->mdl_user->get_user_meta($user_id, 'fb_id');
		if (!empty($user['facebook_id']))
		{
			if ($size == 'medium')
			{
				$avatar = 'http://graph.facebook.com/'.$user['facebook_id'].'/picture?width=200&height=200';
			}
			else
			{
				$avatar = 'http://graph.facebook.com/'.$user['facebook_id'].'/picture?width=50&height=50';
			}
		}
		else
		{
			# maybe with twitter avatar
			$user['twitter_id'] = $this->mdl_user->get_user_meta($user_id, 'tw_id');
			if (!empty($user['twitter_id']))
			{
				$avatar = site_url('assets/img/user/small_croped_def.jpg');
			}
			else
			{
				# maybe original from our database
				$user['avatar'] = $this->mdl_user->get_user_meta($user_id, 'avatar');
				if (!empty($user['avatar']))
				{
					if ($size == 'medium')
					{
						$avatar = site_url('assets/img/user/medium_croped_').$user['avatar'];
					}
					else
					{
						$avatar = site_url('assets/img/user/small_croped_').$user['avatar'];
					}
				}
				else
				{
					if ($size == 'medium')
					{
						$avatar = site_url('assets/img/user/medium_croped_def.jpg');
					}
					else
					{
						$avatar = site_url('assets/img/user/small_croped_def.png');
					}
				}
			}
		}
		
		return $avatar;
	}
	
	/*
	|
	| ---------------------------------------------------------------
	| CHECKER MODEL RETURN TRUE/FALSE IS_THIS
	| ---------------------------------------------------------------
	|
	*/
	
	function is_exist_username($username)
	{
		/*
		model to check existing username
		*/
		$sql = "SELECT id FROM $this->users WHERE username = '$username'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function is_exist_password($user_id, $password)
	{
		/*
		model to check existing password
		*/
		$sql = "SELECT id FROM $this->users WHERE password = '$password' AND id = '$user_id' ";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	function is_exist_email($email)
	{
		/*
		model to check existing mail
		*/
		$sql = "SELECT id FROM $this->users WHERE email = '$email'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	
	/*
	|
	| ---------------------------------------------------------------
	| UPDATE
	| ---------------------------------------------------------------
	|
	*/
	
	function update_user_master($user_id, $field, $new_value)
	{
		/*
		model to update master user by id
		*/
		
		$sql = "UPDATE $this->users SET $field = '$new_value' WHERE id = '$user_id'";
		$this->db->query($sql);
		return true;
	}
	
	function update_user_token($user_id)
	{
		/*
		model to update user token
		*/
		
		# token generate
		$this->load->helper('string');
		$token = md5(random_string('alnum', 10).$user_id);
		
		# update token meta
		$this->mdl_user->update_user_meta('token', 'Token', $token, $user_id);
		return true;
	}
	
	function update_user_password($password, $user_id)
	{
		/*
		model to update user password
		*/
		$sql = "UPDATE $this->users SET password = '$password' WHERE id = '$user_id'";
		$query = $this->db->query($sql);
		return true;
	}
	
	/*
	|
	| ---------------------------------------------------------------
	| GET / RETRIEVE SEARCH
	| ---------------------------------------------------------------
	|
	*/
	
	function search_user_all($username,$result)
	{
		/*
		model to search user by username
		*/
		$sql = "SELECT * FROM $this->users WHERE username LIKE '%$username%'";
		$query = $this->db->query($sql);
		
		if ($result == 'total')
		{	
			return $query->num_rows();
		}
		else
		{
			return $query->result();
		}
	}
	
	/*
	|
	| ---------------------------------------------------------------
	| CREATE
	| ---------------------------------------------------------------
	|
	*/
	
	function new_user($param, $hash_password = false, $user_role = 5, $status_user = 'inactive', $email_confirmation = true, $hardcode_added = true)
	{
		/*
		model to save new user
		*/

		# control password hash!
		if ($hash_password == true)
		{
			$param['password'] = $this->nyan_auth->hash_password($param['password']);
		}
		
		# insert user master
		$now = date('Y:m:d H:i:s');
		$sql = "INSERT INTO $this->users (username,email,created_at,type,password,status) VALUES ('$param[username]','$param[email]','$now','default','$param[password]','$status_user')";
		$query = $this->db->query($sql);
		
		# get his id
		$user_id = $this->mdl_user->get_user_id($param['username'], 'username');
		
		# update meta with control
		foreach ($param as $variabel => $value)
		{
			# if its master data decline update meta
			$master = array('username', 'email', 'password');
			if (in_array($variabel, $master)) 
			{
				# do nothing
			} 
			else 
			{
				$this->mdl_user->update_user_meta($variabel, '', $value, $user_id);
			}
		}
		
		# give him role
		$this->mdl_role->insert_user_role($user_id, $user_role);
		
		# update user token meta
		$this->mdl_user->update_user_token($user_id);
		
		# send email token confirmation to user
		if ($email_confirmation == true)
		{
			$this->load->library('email');
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$token = $this->mdl_user->get_user_meta($user_id, 'token');
			
			$msg =  'Welcome to <b>'.$this->website.'</b>. Please follow this link below to complete your registration <br />
			<a href='.site_url('users/confirmation/'.$token).'>'.site_url('users/confirmation/'.$token).'</a>';
								
			$this->email->from('no-reply@'.$this->website, 'no-reply');
			$this->email->to($param['email']);
									
			$this->email->subject('Register Confirmation');
			$this->email->message($msg);
			$this->email->send();
						
			# referral point process
			if ($hardcode_added == true)
			{
				
				# added hardcode
				if (!empty($param['ref']))
				{
					# give point to the referrer, push activities
					$referrer_id = $this->mdl_user->get_user_id($param['ref'], 'username');
					if ($referrer_id != null)
					{	
						# load module activities
						$this->load->model('activities/activities_m');
						$this->activities_m->insert_activities($referrer_id,'Referral','','refferal','from-'.$user_id,'lalights');
						return true;
					}
					else
					{
						return true;
					}
				}
				else
				{
					return true;
				}
			}
			
			return true;
		}

		return true;
	}
	
	/*
	|
	| ---------------------------------------------------------------
	| DELETE
	| ---------------------------------------------------------------
	|
	*/
	
	function permanent_delete($id)
	{
		/*
		model to permanent delete the user
		*/
		$sql = "DELETE FROM $this->users WHERE id = '$id'";
		$this->db->query($sql);
		$sql = "DELETE FROM $this->users_meta WHERE user_id = '$id'";
		$this->db->query($sql);
		$sql = "DELETE FROM $this->users_role WHERE user_id = '$id'";
		$this->db->query($sql);
		return true;
	}

	/*
	|
	| ---------------------------------------------------------------
	| METADATA CRUD
	| ---------------------------------------------------------------
	|
	*/
	
	function get_list_user_by_meta($meta_key, $meta_value_text, $status, $result, $sort, $limit = null, $limit_order = null, $name = null, $extra = null)
	{
		/*
		model to get list user by meta value
		*/
		
		if ($result == 'total'){
			$this->db->select($this->users.'.id');
		} else {
			$this->db->select($this->users.'.status,'.$this->users.'.id,'.$this->users.'.username,'.$this->users.'.email');
		}
		
		$this->db->from($this->users);
		$this->db->join($this->users_meta, $this->users_meta.'.user_id'.'='.$this->users.'.id');
		
		if ($meta_key != null && $meta_value_text != null)
		{
			# control by metakey and metavalue
			$meta_key = explode('|',$meta_key);
			
			$this->db->where($this->users_meta.'.meta_key', $meta_key[0]);
			$this->db->where($this->users_meta.'.meta_value_text', $meta_value_text);
			$this->db->or_where($this->users_meta.'.meta_key', $meta_key[1]);
			$this->db->where($this->users_meta.'.meta_value_text', $meta_value_text);
		}
		
		if ($extra != null)
		{
			foreach ($extra as $var_name => $var_value)
			{
				$this->db->where($this->users_meta.'.meta_key', $var_name);
				$this->db->where($this->users_meta.'.meta_value_text', $var_value);
			}
		}
		
		if($status != null){
			$this->db->where($this->users.'.status', $status);
		}
		
		if($name != null){
			$this->db->like($this->users.'.username', $name);
		}
		
		$this->db->group_by($this->users.'.id');
		
		if ($limit != null && $limit_order != null)
		{
			$this->db->limit($limit, $limit_order);
		}
		
		if ($sort == 'latest')
		{
			$this->db->order_by($this->users.'.id','desc');
		}
		
		if ($result == 'total'){
			return $this->db->get()->num_rows();
		} else {
			return $this->db->get()->result();
		}
		
	}
	
	function get_user_id_by_meta($meta_key,$meta_value_text)
	{
		/*
		model to get the user id by user meta value and key
		true = exist
		false = not exist
		*/
		
		$sql = "SELECT user_id FROM $this->users_meta WHERE meta_key = '$meta_key' AND meta_value_text = '$meta_value_text'";
		$query = $this->db->query($sql);
		$data = $query->result();
		
		$user_id = null;
		
		foreach ($data as $row)
		{
			$user_id = $row->user_id;
		}
		
		return $user_id;
	}
	
	function insert_meta($user_id,$meta_name,$meta_key,$meta_value)
	{
		/*
		model to insert user meta
		*/
		$sql = "INSERT INTO $this->users_meta (user_id,meta_name,meta_key,meta_value_text) VALUES ('$user_id','$meta_name','$meta_key','$meta_value')";
		$query = $this->db->query($sql);
		return true;
	}
	
	function is_meta_exist($meta_key,$user_id)
	{
		/*
		model to check is meta exist  
		true = exist
		false = not exist
		*/
		$sql = "SELECT id FROM $this->users_meta WHERE meta_key = '$meta_key' AND user_id = '$user_id'";
		$query = $this->db->query($sql);
		$total = $query->num_rows();
		
		if ($total > 0)
		{
			return true;
		}
	}
	
	function is_meta_value_exist($meta_key,$meta_value_text)
	{
		/*
		model to check is meta value exist  
		true = exist
		false = not exist
		*/
		$sql = "SELECT id FROM $this->users_meta WHERE meta_value_text = '$meta_value_text' AND meta_key = '$meta_key'";
		$query = $this->db->query($sql);
		$total = $query->num_rows();
		
		if ($total > 0)
		{
			return true;
		}
	}
	
	function get_user_meta($user_id, $field_value)
	{
		/*
		model to get user meta
		*/
		$meta_value_text = null;
		
		$sql = "SELECT meta_value_text FROM $this->users_meta WHERE meta_key = '$field_value' AND user_id = '$user_id' ";
		$query = $this->db->query($sql);
		$data = $query->result();
		
		foreach ($data as $row)
		{
			$meta_value_text = $row->meta_value_text;
		}
		
		return $meta_value_text;
	}
	
	function update_user_meta($meta_key, $meta_name, $meta_value, $user_id)
	{
		/*
		model to update user meta
		*/
		
		# before edit the meta, check is meta exist ? if no insert new with null
		$check = $this->mdl_user->is_meta_exist($meta_key, $user_id);
		
		if ($check == true)
		{
			# meta is exist, update the meta
			$sql = "UPDATE $this->users_meta SET meta_value_text = '$meta_value' WHERE meta_key = '$meta_key' AND user_id = '$user_id'";
			$query = $this->db->query($sql);
			return true;
		}
		else
		{
			# create meta
			$this->mdl_user->insert_meta($user_id,$meta_name,$meta_key,$meta_value);
			return true;
		}
		
	}
	
	/*
	|
	| ---------------------------------------------------------------
	| UPDATE STATUS FIELD, 0/1 true/FALSE ON/OFF YES/NO
	| ---------------------------------------------------------------
	|
	*/
	
	function activate_user($id)
	{
		/*
		model activate user
		*/
		$sql = "UPDATE $this->users SET status = 'active' WHERE id = '$id'";
		$query = $this->db->query($sql);
		return true;
	}

	function inactive_user($id)
	{
		/*
		model disactive user
		*/
		$sql = "UPDATE $this->users SET status = 'inactive' WHERE id = '$id'";
		$query = $this->db->query($sql);
		return true;
	}
	
	/*
	|
	| ---------------------------------------------------------------
	| ADDITIONAL / FORCE MODE
	| ---------------------------------------------------------------
	|
	*/
	
	function force_register($username, $email, $id_role, $status)
	{
		/*
		model to register user with simple param
		*/

		$now = date('Y:m:d H:i:s');
		
		$sql = "INSERT INTO $this->users (username,created_at,type,status) VALUES ('$username','$now','default','$status')";
		$query = $this->db->query($sql);
		
		$user_id = $this->mdl_user->get_user_id($username, 'username');
		
		# set the role
		$this->mdl_role->insert_user_role($user_id, $id_role);
	
		return true;
	}
	
}