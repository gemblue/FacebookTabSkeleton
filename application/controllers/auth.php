<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	var $data = null;
	
	public function __construct()
	{
		parent::__construct();
		
		# load core
		$this->load->model('mdl_options');
		$this->load->library('nyan_auth');
	
		# set the current url data
		$ci =& get_instance();
		$this->data['current_url'] = $ci->config->site_url().$ci->uri->uri_string();
		$this->data['current_url_encode'] = urlencode(base64_encode($this->data['current_url']));
	}

	/*
	Admin door
	*/
	public function admin()
	{
		$this->data['site_title'] = $this->mdl_options->get_options('site_title');
		$this->data['logo_form_admin'] = $this->mdl_options->get_options('logo_form_admin');
		
		$this->load->view('template-admin/pages/vw_dash_login_admin', $this->data);
	}
	
	/*
	Simple login process
	*/
	public function login()
	{
		$input = array(
		    'param1' => $this->input->post('param1'),
			'param2' => $this->input->post('param2')
		);

		# try login to local database
		$check = $this->nyan_auth->login($input['param1'], $input['param2']);
			
		if ($check == true)
		{
			# role 1 - 4 to back end
			$role = $this->session->userdata('role_id');
			$allowed_role = array(1, 2, 3, 4);
		
			if (in_array($role, $allowed_role)) 
			{
				redirect('control/index');
			}
			else
			{
				$this->session->set_flashdata('message', '<div class="error">You have no permission.</div>');
				redirect('auth/admin');
			}
		}
		else
		{
			$this->session->set_flashdata('param1', $data['param1']);
			$this->session->set_flashdata('param1', $data['param2']);
			$this->session->set_flashdata('message', '<div class="error">Wrong username or password..</div>');
			redirect('auth/admin');
		}
	}
	
	/*
	Logout link
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect();
	}	
}