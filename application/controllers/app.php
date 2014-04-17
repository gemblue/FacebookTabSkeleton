<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends CI_Controller 
{
	var $data = null;
	
	public function __construct()
	{
		parent::__construct();
		
		# load core
		$this->load->model('mdl_user');
		$this->load->model('mdl_app_like');
		$this->load->library('image_moo');
		
		# set the current url data
		$ci =& get_instance();
		$this->data['current_url'] = $ci->config->site_url().$ci->uri->uri_string();
		$this->data['current_url_encode'] = urlencode(base64_encode($this->data['current_url']));
		
		# setup template
		$this->data['template_name'] = 'template-default/';
		$this->data['template_path'] = base_url().'application/views/'.$this->data['template_name'];
		$this->data['upload_path'] = './assets/uploaded/img/post_thumb/';
		
		# init facebook api 
		$this->data['baseUrl'] = base_url();
		$this->data['appBaseUrl'] = 'http://www.facebook.com/KTBMitsubishiMotorsIndonesia/app_1407866746117011';
		
		$fb_config = array(
            'appId'  => '1407866746117011',
            'secret' => '470620b3deb7d9391050bb788d81d848',
			'baseUrl' => $this->data['baseUrl'],
			'appBaseUrl' => $this->data['appBaseUrl']
        );
       
		$this->load->library('Facebook/facebook', $fb_config);
	}
	
	
	/* 
	Function below, is for showing page.  	
	Please don't remove, because all of facebook tab need this.	(experience)
	If you need extra function for (ex : getting post) please make 
	new controller or new function. 
	
	Let the machine runs.
	*/
	
	/*
	Facebook App Engine First Load
	*/
	function index()
	{	
		/*
		# fb main start
		
		if (isset($_GET['code']))
		{	
			header("Location: " . $this->data['appBaseUrl']);
			exit;
		}
			
		if (isset($_GET['request_ids']))
		{
			# user comes from invitation
			# track them if you need
		}

		$signed_request = $this->facebook->getSignedRequest();
		
		# auth start
		$user = null;
		$user = $this->facebook->getUser();
	
		$loginUrl = $this->facebook->getLoginUrl(
			array(
				'scope' => 'email,publish_stream,user_location,user_about_me,user_hometown'
			)
		);

		if ($user) 
		{
			try 
			{
				$user_profile = $this->facebook->api('/me');
			} 
			catch (FacebookApiException $e) 
			{
				d($e);
				$user = null;
			}
		}

		if (!$user) 
		{
			echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
			exit;
		}
		
		$userInfo = $this->facebook->api("/$user");
		$access_token = $this->facebook->getAccessToken();
		
		function d($d)
		{
			echo '<pre>';
			print_r($d);
			echo '</pre>';
		}
	
		# check like
		if(!$signed_request['page']['liked'])
		{	
			# set not liked
			$this->session->set_userdata('is_liked', false);
		
			# like first
			$this->load->view($this->data['template_name'].'template-must-like', $this->data);
		}
		else
		{
			# insert into db, the user who have just liked
			if ($this->session->userdata('is_liked') == false)
			{
				$this->mdl_app_like->new_like($userInfo['id']);
				$this->session->set_userdata('is_liked', true);
			}
			
			# to home
			$this->load->view($this->data['template_name'].'template-home', $this->data);
		}
		*/
		
		# to home
		$this->load->view($this->data['template_name'].'template-home', $this->data);
	}

	/*
	Page : home, after user login with facebook. We registered or logged him. Save to our database
	*/
	function app_home()
	{
		/*
		# set csrf token
		$this->session->set_userdata('token_action', random_string('alnum', 10));
		
		# get user profile
		$user_profile = $this->facebook->api('/me');
		$this->data['user_profile'] = $user_profile;
			
		# check user
		$check =  $this->mdl_user->is_exist_username($user_profile['username']);
		
		if ($check == 1)
		{
			# redirect to app home
			$this->load->view($this->data['template_name'].'template-app-home', $this->data);
		}
		else
		{
			# register force if not registered
			$data['username'] = $user_profile['username'];
			$data['email'] = $user_profile['email'];
			$data['password'] = '';
			
			$op = $this->mdl_user->new_user($data, false, 5, 'active', false, false);
			
			if ($op == true)
			{
				$user_id = $this->mdl_user->get_user_id($data['email'], 'email');
				
				# update meta
				$this->mdl_user->update_user_meta('facebook_id', 'Facebook id', $user_profile['id'], $user_id);
				$this->mdl_user->update_user_meta('name', 'Name', $user_profile['name'], $user_id);
				
				# redirect to app home
				$this->load->view($this->data['template_name'].'template-app-home', $this->data);
			}
		}
		*/
		
		# redirect to app home
		$this->load->view($this->data['template_name'].'template-app-home', $this->data);
	}
	
	/*
	Page : Closing, apps/campaign has closed
	*/
	function closing()
	{
		$this->load->view($this->data['template_name'].'template-closing', $this->data);
	}
	
	/*
	Page : Term and Condition
	*/
	function term()
	{
		$this->load->view($this->data['template_name'].'template-tnc', $this->data);
	}
	
	/*
	Page : 404 Not Found
	*/
	function not_found()
	{
		$this->load->view($this->data['template_name'].'template-not-found', $this->data);
	}
}