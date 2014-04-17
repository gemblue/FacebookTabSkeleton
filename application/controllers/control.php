<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control extends Backend_Controller {

	# setting upload path global
	var $upload_path = 'uploads/img/post_images/';
	var $url_source; 
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		# title_page
		$this->data['title_page'] = 'Dashboard';
			
		# content_page
		$this->data['content_page'] = 'template-admin/pages/vw_dash_home';
			
		$this->load->view('template-admin/template-basic', $this->data); 
	}
	
	/*
	|
	| ---------------------------------------------------------------
	| MANAGEMENT CUSTOM POSTING
	| ---------------------------------------------------------------
	|
	| Custom posting master data free crud
	| Slide, Food, Band, People, Etc
	| 
	*/
	public function custom($post_type = null)
	{
		if (empty($post_type))
		{
			echo 'undefined custom post';
		}
		else
		{
			# title_page
			$this->data['title_page'] = str_replace('_',' ',ucfirst($post_type));
			$this->data['post_type'] = $post_type;
			
			# breadcrumb
			$this->data['breadcrumb'] = array(
				str_replace('_',' ',ucfirst($post_type)) => false
			);
		
			$this->data['pg_query'] = $this->mdl_entries->get_list_post($post_type,30);
		
			# content_page
			$this->data['content_page'] = 'template-admin/pages/vw_dash_entries_post';
			
			$this->load->view('template-admin/template-basic', $this->data);
		}
	}
	
	public function delete_custom($post_type = null, $id = null)
	{
		if (empty($id) || empty($post_type))
		{
			echo 'undefined id or post type, delete?';
		}
		else
		{
			$op = $this->mdl_entries->delete_post($id);
			if ($op == true)
			{
				$this->session->set_flashdata('message', '<div class="alert alert-success">Successfully deleted!</div>');
				redirect('control/custom/'.$post_type);
			}
		}
	}
	
	public function edit_custom($post_type = null,$id = null)
	{
		if (empty($post_type) || empty($id))
		{
			echo 'undefined custom post or undefined id';
		}
		else
		{	
			# title_page
			$this->data['title_page'] = 'Edit '.ucfirst($post_type);
			$this->data['post_type'] = $post_type;
			
			# breadcrumb
			$this->data['breadcrumb'] = array(
				ucfirst($post_type) => 'control/custom/'.$post_type,
				'Edit '.ucfirst($post_type) => false
			);
			
			$this->data['form_type'] = 'edit';
			
			# query
			$this->data['pg_query'] = $this->mdl_entries->get_entries_by_id($id);
		
			# content_page
			$this->data['content_page'] = 'template-admin/pages/vw_dash_entries_form';
			
			$this->load->view('template-admin/template-basic', $this->data);
		}
	}
	
	public function new_custom($post_type = null)
	{
		if (empty($post_type))
		{
			echo 'undefined custom post';
		}
		else
		{
			# title_page
			$this->data['title_page'] = 'New '.ucfirst($post_type);
			$this->data['post_type'] = $post_type;
			
			# breadcrumb
			$this->data['breadcrumb'] = array(
				ucfirst($post_type) => 'control/custom/'.$post_type,
				'New '.ucfirst($post_type) => false
			);
			
			$this->data['form_type'] = 'new';
			
			# content_page
			$this->data['content_page'] = 'template-admin/pages/vw_dash_entries_form';
			
			$this->load->view('template-admin/template-basic', $this->data);
		}
	}
	
	public function update_custom()
	{
		# master post
		$this->data['title'] = $this->input->post('title');
		$this->data['slug'] = $this->input->post('slug');
		$this->data['post_type'] = $this->input->post('post_type');
		$this->data['custom_id'] = $this->input->post('custom_id');
		$this->data['form_type'] = $this->input->post('form_type');
			
		# get the extra field information
		$meta_info = $this->mdl_entries->get_meta_information($this->data['post_type']);
			
		# validation
		$this->load->helper(array('form', 'url'));
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('slug', 'Slug', 'required');
			
		if ($this->form_validation->run() == false)
		{
			$this->session->set_flashdata('message', '<div class="alert alert-error">Please complete input!</div>');
			redirect('control/edit_custom/'.$this->data['post_type'].'/'.$this->data['custom_id']);
		}
		else
		{
			if ($this->data['form_type'] == 'edit')
			{
				# take and update extra post meta
				if (!empty($meta_info))
				{
					foreach ($meta_info as $row => $value)
					{
						# get post loop
						$meta_value_post =  $this->input->post($value['meta_key']);
							
						# update meta param(meta_key, meta_name, new_value, id_entries)
						$this->mdl_entries->update_post_meta($value['meta_key'], ucfirst(str_replace('_',' ',$value['meta_key'])), $meta_value_post, $this->data['custom_id']);
					}
				}
					
				# update post master
				$this->mdl_entries->update_post_master('title', $this->data['title'], $this->data['custom_id']);
					
				# slug checker, every custom post must have unique slug
				$check = $this->mdl_entries->is_exist_slug($this->data['slug']);
				if ($check == true)
				{
					# if old slug, permit
					$old_slug = $this->mdl_entries->get_post_slug($this->data['custom_id']);
					if ($old_slug == $this->data['slug']) {
						$continue = true;
					} else {
						$continue = false;
					}
				}
				else
				{
					$continue = true;	
				}
					
				if ($continue == true) 	
				{
					$this->mdl_entries->update_post_master('slug', $this->data['slug'], $this->data['custom_id']);
					$this->session->set_flashdata('message', '<div class="alert alert-success">Successfully updated!</div>');
					redirect('control/edit_custom/'.$this->data['post_type'].'/'.$this->data['custom_id']);
				} 
				else 
				{
					$this->session->set_flashdata('message', '<div class="alert alert-error">Slug is used by other custom post!</div>');
					redirect('control/edit_custom/'.$this->data['post_type'].'/'.$this->data['custom_id']);
				}
			}
			else
			{
				# slug checker, every custom post must have unique slug
				$check = $this->mdl_entries->is_exist_slug($this->data['slug']);
				if ($check == true)
				{
					$this->session->set_flashdata('message', '<div class="alert alert-error">Slug is used by other custom post!</div>');
					redirect('control/new_custom/'.$this->data['post_type']);
				}
				else
				{
					$data = array( 
							'title' => $this->data['title'], 
							'slug' => $this->data['slug'], 
							'post_type' => $this->data['post_type']
							);
							
					$op = $this->mdl_entries->new_entries($data);
						
					if ($op == true)
					{
						# get the id
						$custom_id = $this->mdl_entries->get_entries_id($this->data['slug'], 'slug');
							
						# take and update extra post meta that has been existing
						if (!empty($meta_info))
						{
							foreach ($meta_info as $row => $value)
							{
								# get post loop
								$meta_value_post =  $this->input->post($value['meta_key']);
								
								# update meta param(meta_key, meta_name, new_value, id_entries)
								$this->mdl_entries->update_post_meta($value['meta_key'], ucfirst(str_replace('_',' ',$value['meta_key'])), $meta_value_post, $custom_id);
							}
						}
							
						# take and update new field extra
						foreach ($_POST as $name => $val)
						{
							$name = htmlspecialchars($name);
							$val = htmlspecialchars($val);
								
							if ($name == 'title' || $name == 'slug' || $name == 'post_type' || $name == 'form_type' || $name == 'custom_id')
							{
								# don't update if its master data 
							}
							else
							{
								# update meta param(meta_key, meta_name, new_value, id_entries)
								$this->mdl_entries->update_post_meta($name, ucfirst(str_replace('_',' ',$name)), $val, $custom_id);
							}
						}
							
						$this->session->set_flashdata('message', '<div class="alert alert-success">Successfully add new post!</div>');
						redirect('control/custom/'.$this->data['post_type']);
					}
				}
					
			}
		}	 
	}
	
	public function add_field_custom()
	{
		$input = $this->input->post('data_post');
		$input = explode('|', $input);
		$meta_key = strtolower(str_replace(' ', '_', $input[1]));
		$this->mdl_entries->update_post_meta($meta_key, '', $input[2], $input[0]);
		echo 'success';
	}
	
	public function delete_field_custom($meta_key, $entry_id, $url_callback)
	{
		$this->mdl_entries->delete_meta($meta_key, $entry_id);
		$url_callback = base64_decode(urldecode($url_callback));
		redirect($url_callback);
	}
	
	/*
	| Close
	*/

	/*
	|
	| ---------------------------------------------------------------
	| MANAGEMENT USER
	| ---------------------------------------------------------------
	|
	*/
	
	/*
	Show user all role
	*/
	public function user($status = 'all')
	{
		# title_page
		$this->data['title_page'] = 'User';
			
		# breadcrumb
		$this->data['breadcrumb'] = array(
			'User' => false
		);

		if($status != 'all'){
			$this->data['breadcrumb']['User'] = base_url('control/user');
			$this->data['breadcrumb'][ucfirst($status)] = false;
		}
			
		$this->data['num_rows'] = $this->mdl_user->get_tot_user($status);
			
		$config['base_url'] = site_url('control/user/'.$status);
		$config['total_rows'] = $this->data['num_rows']; 
		$config['per_page'] = 15; 
		$config['uri_segment'] = 4; 
		$config['full_tag_open'] = '<div class="pagination pagination-small pagination-la"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = '<i class="icon-long-arrow-left"></i> First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last <i class="icon-long-arrow-right"></i>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config); # initialize pagination
		$this->data['pagination'] = $this->pagination->create_links();
			
		# query
		$this->data['pg_query'] = $this->mdl_user->get_list_user($status, $config['per_page'], $this->uri->segment(4));
			
		# content_page
		$this->data['content_page'] = 'template-admin/pages/vw_dash_user_list';
			
		$this->load->view('template-admin/template-basic', $this->data); 
	}
	
	/*
	Show form edit user
	*/
	public function user_edit($id_user)
	{
		# permission action check
		$allowed_role = array (1);
		$this->permission_action($allowed_role);
		
		# title_page
		$this->data['title_page'] = 'Edit User';
			
		# breadcrumb
		$this->data['breadcrumb'] = array(
			'User' => 'control/user',
			'Edit User' => false
		);
			
		$this->data['form_type'] = 'edit';
			
		# query
		$this->data['pg_query'] = $this->mdl_user->get_user($id_user, 'id'); # ambil data2 user by id
		$this->data['role_query'] = $this->mdl_role->get_list_role(); # ambil data2 role
		
		# content_page
		$this->data['content_page'] = 'template-admin/pages/vw_dash_user_form';
			
		$this->load->view('template-admin/template-basic', $this->data); 
	}
	
	/*
	Update user
	*/
	public function user_update()
	{
		# permission action check
		$allowed_role = array (1);
		$this->permission_action($allowed_role);
		
		# action
		$data = array (
					'id_user' => $this->input->post('id_user'),
					'f_name' => $this->input->post('f_name'),
					'l_name' =>$this->input->post('l_name'),
					'address' => $this->input->post('address'),
					'special_account' => $this->input->post('special_account'),
					'biography' => $this->input->post('biography'),
					'role' => $this->input->post('role'),
					'new_pass' => $this->input->post('new_pass'),
					'phone' => $this->input->post('phone')
		        );
				
		# role update		
		if (!empty($data['role']))
		{
			$this->mdl_role->update_user_role($data['id_user'], $data['role']);
		}
		
		# special acccount update		
		$this->mdl_user->update_user_meta('special_account', 'Special Account', $data['special_account'], $data['id_user']);
		
		/*
		# master update
		$this->mdl_user->update_user_master($data['id_user'], '','');
		*/
		
		# password update		
		if (!empty($data['new_pass']))
		{
			$password = $this->nyan_auth->hash_password($data['new_pass']);
			$this->mdl_user->update_user_password($password, $data['id_user']);
		}
		
		# meta update all
		$this->mdl_user->update_user_meta('biography', 'Biography', $data['biography'], $data['id_user']);
		$this->mdl_user->update_user_meta('first_name', 'First Name', $data['f_name'], $data['id_user']);
		$this->mdl_user->update_user_meta('last_name', 'Last Name', $data['l_name'], $data['id_user']);
		$this->mdl_user->update_user_meta('address', 'Address', $data['address'], $data['id_user']);
		$this->mdl_user->update_user_meta('phone', 'Phone', $data['phone'], $data['id_user']);
				
		$this->session->set_flashdata('message', '<div class="alert alert-success">Data has been updated!</div>');
		redirect('control/user_edit/'.$data['id_user']);	
		
	}
	
	/*
	Activate user
	*/
	public function user_activate($id, $url_callback)
	{
		# permission action check
		$allowed_role = array (1);
		$this->permission_action($allowed_role);
		
		$username = $this->mdl_user->get_username($id, 'id');
				
		$op = $this->mdl_user->activate_user($id);
		
		if ($op == true)
		{
			$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>'.$username.'</strong> is active now</div>');
			$url_callback = base64_decode(urldecode($url_callback));
			redirect($url_callback);
		}
	}
	
	/*
	Disactive user
	*/
	public function user_disactive($id, $url_callback)
	{
		# permission action check
		$allowed_role = array (1);
		$this->permission_action($allowed_role);
		
		$username = $this->mdl_user->get_username($id, 'id');
				
		$op = $this->mdl_user->inactive_user($id);
		
		if ($op == true)
		{
			$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>'.$username.'</strong> is inactive now</div>');
			$url_callback = base64_decode(urldecode($url_callback));
			redirect($url_callback);
		} 
	}
	
	/*
	Search user
	*/
	public function user_search()
	{
		# title_page
		$this->data['title_page'] = 'Search User';
			
		# breadcrumb
		$this->data['breadcrumb'] = array(
			'User' => 'control/user',
			'Search User' => false
		);
			
		# for label search
		$this->data['search_result'] = 'search';
		
		$username = $this->input->post('inp_search');
		$this->data['keyword'] = $username;
			
		$this->data['num_rows'] = $this->mdl_user->search_user_all($username,'total');
			
		# query
		$this->data['pg_query'] = $this->mdl_user->search_user_all($username,'');
			
		# content_page
		$this->data['content_page'] = 'template-admin/pages/vw_dash_user_list';
			
		$this->load->view('template-admin/template-basic', $this->data); 
	}
	
	/*
	Show new form
	*/
	public function user_new()
	{
		# permission action check
		$allowed_role = array (1);
		$this->permission_action($allowed_role);
		
		# title_page
		$this->data['title_page'] = 'New User';
			
		# breadcrumb
		$this->data['breadcrumb'] = array(
			'User' => 'control/user',
			'New User' => false
		);
			
		$this->data['form_type'] = 'new';
			
		# query
		$this->data['role_query'] = $this->mdl_role->get_list_role(); # ambil data2 role
		
		# content_page
		$this->data['content_page'] = 'template-admin/pages/vw_dash_user_new';
			
		$this->load->view('template-admin/template-basic', $this->data); 
	}
	
	/*
	Add user
	*/
	public function user_add()
	{
		# permission action check
		$allowed_role = array (1);
		$this->permission_action($allowed_role);
		
		# title_page
		$this->data['title_page'] = 'New User';
			
		# breadcrumb
		$this->data['breadcrumb'] = array(
			'User' => 'control/user',
			'New User' => false
		);
		
		# get post
		$param['username'] = $this->input->post('username');
		$param['email'] = $this->input->post('email');
		$param['first_name'] = $this->input->post('f_name');
		$param['last_name'] = $this->input->post('l_name');
		$param['role'] = $this->input->post('role');
		$param['password'] = $this->input->post('password');
		
		# check username
		$check = $this->mdl_user->is_exist_username($param['username']);
		if ($check == 1)
		{	
			$this->session->set_flashdata('message', '<div class="alert alert-error">Username "<strong>'.$param['username']. '</strong>" is already exist</div>');
			redirect('control/user_new');
			exit;
		}
		
		# check email
		$check = $this->mdl_user->is_exist_email($param['email']);
		if ($check == 1)
		{	
			$this->session->set_flashdata('message', '<div class="alert alert-error">Email "<strong>'.$param['email']. '</strong>" is already exist</div>');
			redirect('control/user_new');
			exit;
		}
		
		# validation
		$this->form_validation->set_rules('role', 'Role', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		
		if ($this->form_validation->run() == false) 
		{
			$this->session->set_flashdata('message', '<div class="alert alert-error">Username/password/email/role must be filled</div>');
			redirect('control/user_new');
			exit;
		} 
		
		# insert new user
		$this->mdl_user->new_user($param, false, $param['role'], 'active', false, false);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Successfully add "'.$param['username'].'"</div>');
		redirect('control/user_new');
	}
	
	/*
	Permanent delete
	*/
	public function user_delete($id)
	{
		# permission action check
		$allowed_role = array (1);
		$this->permission_action($allowed_role);
		
		# action
		$username = $this->mdl_user->get_username($id, 'id');
		$op = $this->mdl_user->permanent_delete($id);
		if ($op == true)
		{
			$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>'.$username.'</strong> successfully deleted!</div>');
			redirect('control/user');
		}  
	}
	/*
	| Close 
	*/
	
	/*
	|
	| ---------------------------------------------------------------
	| MANAGEMENT SETTING
	| ---------------------------------------------------------------
	|
	*/
	public function setting()
	{
	
		# title_page
		$this->data['title_page'] = 'Setting';
		
		# breadcrumb
		$this->data['breadcrumb']['Setting'] = false;
		
		# content_page
		$this->data['content_page'] = 'template-admin/pages/vw_dash_setting';
		
		$this->load->view('template-admin/template-basic', $this->data);
	}
	
	public function do_update_setting()
	{
		$site_title = $this->input->post('site_title');
		$site_background = $this->input->post('background');
		$template = $this->input->post('template');
		$logo_form_admin = $this->input->post('logo_form_admin');
		$facebook_url = $this->input->post('facebook_url');
		$twitter_url = $this->input->post('twitter_url');
				
		$this->mdl_options->update_options('site_title', $site_title);
		$this->mdl_options->update_options('template', $template);
		$this->mdl_options->update_options('logo_form_admin', $logo_form_admin);
		$this->mdl_options->update_options('facebook_url', $facebook_url);
		$this->mdl_options->update_options('twitter_url', $twitter_url);
		$this->mdl_options->update_options('background', $site_background);
			
		$this->session->set_flashdata('message', '<div class="alert alert-success">Your setting has been updated!</div>');
		$link_arah = site_url('control/setting');
		redirect($link_arah);
	}
	/*
	| Close 
	*/
	
	/*
	|
	| ---------------------------------------------------------------
	| MANAGEMENT DYNAMIC PAGE
	| ---------------------------------------------------------------
	|
	*/
	public function show($name = null, $url = null)
	{	
		if(isset($url))
		{
			$url_embed = $url;
			
			# title_page
			$this->data['title_page'] = ucfirst($name);
			
			# breadcrumb
			$this->data['breadcrumb'][ucfirst($name)] = false;
		} else {
			$url_embed = $name;
			
			# title_page
			$this->data['title_page'] = 'Show Iframe';
			
			# breadcrumb
			$this->data['breadcrumb']['Show Iframe'] = false;
		}
		
		# content_page
		$this->data['content_page'] = 'template-admin/pages/vw_dash_iframe';
		$this->data['url'] = base64_decode(urldecode($url_embed));
		
		$this->load->view('template-admin/template-basic', $this->data);
	}
	/*
	| Close
	*/
}