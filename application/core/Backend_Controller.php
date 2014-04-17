<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Halaman admin extends dari controller inih
 * disini nanti dipasang kebutuhan dasar buat
 * setiap halaman admin
*/
class Backend_Controller extends MY_Controller
{
	
	function __construct()
	{
        parent::__construct();

		$this->load->model('mdl_user');
		$this->load->model('mdl_role');	
		$this->load->model('mdl_entries');
		
		$this->load->library('custom_template');
		$this->load->library('form_validation');
		$this->load->library('nyan_auth');

		# this page is only for administrator role 1 - 4
		$role = $this->session->userdata('role_id');
		$allowed_role = array(1, 2, 3, 4);
		if (!in_array($role, $allowed_role)) show_404();
	}
}