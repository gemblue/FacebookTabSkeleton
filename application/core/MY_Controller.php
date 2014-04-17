<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Semua kebutuhan umum yang pasti dipakai semua controller diload disini
 */
class MY_Controller extends CI_Controller
{
	var $data = null;
	var $template;

	public function __construct()
	{
		parent::__construct();

		# load core
		$this->load->library('nyan_auth');
		$this->load->library('custom_template');
		$this->load->model('mdl_options');
		
		# template
		$template_name = $this->mdl_options->get_options('template');
		$this->data['template_name'] = $template_name.'/';
		$this->data['template_path'] = base_url('application/views').'/'.$template_name.'/';
		
		# url
		$this->data['current_url'] = current_url();
		$this->data['current_url_encode'] = urlencode(base64_encode(current_url()));
		
		# setting
		$this->data['site_title'] = $this->mdl_options->get_options('site_title');
		$this->data['facebook_url'] = $this->mdl_options->get_options('facebook_url');
		$this->data['twitter_url'] = $this->mdl_options->get_options('twitter_url');
		
		# user login status
		$this->data['logged_in'] = $this->session->userdata('logged_in');
		
		if ($this->data['logged_in'] == 'hore')
		{
			$this->data['logged_in'] = true;
		}
		
		# load from other module
		$this->load->model('activities/activities_m');		
	}

}