<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Activities_m extends CI_Model {

	# setting tabel
	var $activities = 'mod_activities';
	
	public function __construct()
	{		
		parent::__construct();	
	}
	
	public function get_stream($action = null, $result = null, $limit, $type)
	{
		/*
		model to get activities stream
		limit : how much to show
		type : latest or random
		result : array or total
		*/
		
		if ($result == 'total') {
			$this->db->select($this->activities.'.id');
		} else {
			$this->db->select('*');
		}
		
		$this->db->from($this->activities);
		
		# by action
		if (!empty($action))
		{
			$this->db->where($this->activities.'.action', $action);
		}
		
		if (!empty($limit)){
			$this->db->limit($limit);
		} 
		
		if ($type == 'latest') {
			$this->db->order_by($this->activities.'.created_at', 'desc');
		} else {
			# no type
		}
		
		if ($result == 'total') {
			return $this->db->get()->num_rows();
		} else {
			return $this->db->get()->result();
		}
		
		
	}
	
	public function get_activities($action, $object_id, $object, $result, $limit, $type)
	{
		/*
		model to get activities with filter
		limit : how much to show
		type : latest or random
		result : array or total
		
		use : get total share
		*/
		
		if ($result == 'total') {
			$this->db->select($this->activities.'.id');
		} else {
			$this->db->select('*');
		}
		
		$this->db->from($this->activities);
		
		$this->db->where($this->activities.'.action', $action);
		$this->db->where($this->activities.'.object_id', $object_id);
		$this->db->like($this->activities.'.object', 'post');
		
		if (!empty($limit)){
			$this->db->limit($limit);
		} 
		
		if ($type == 'latest') {
			$this->db->order_by($this->activities.'.created_at', 'desc');
		} else {
			# no type
		}
		
		if ($result == 'total') {
			return $this->db->get()->num_rows();
		} else {
			return $this->db->get()->result();
		}
		
		
	}
	
	function insert_activities($user_id,$object,$object_id,$action,$log,$campaign)
	{
		/*
		model to insert new activities
		true : success
		false : failed
		*/
		
		$ip = $_SERVER['REMOTE_ADDR'];
		$now = date('Y:m:d H:i:s');
		
		# if activities = checkin, validation first!
		if ($action == 'checkin')
		{
			$check = $this->activities_m->have_checked_in($object_id,$user_id);
			if ($check == true)
			{
				$continue = false;
			}
			else
			{
				$continue = true;
			}
		}
		else
		{
			$continue = true;
		}
		
		# continue activities logic
		if ($continue == true)
		{
			$sql = "INSERT INTO $this->activities (user_id, object, object_id, action, log, ip_address, campaign, created_at) VALUES 
				   ('$user_id','$object','$object_id','$action','$log','$ip','$campaign','$now')";
			$query = $this->db->query($sql);
			
			if ($query)
			{
				$sql = "SELECT id FROM $this->activities WHERE user_id = '$user_id' AND object = '$object' AND object_id = '$object_id' AND action = '$action' AND 
						log = '$log' AND ip_address = '$ip' AND campaign = '$campaign' AND created_at = '$now' ";
				$query = $this->db->query($sql);
				$data = $query->result();
				
				foreach ($data as $row)
				{
					$id = $row->id;
				}
				
				# here insert the point, control!
				switch ($action):
				case 'checkin':
					$point = 3;
					break;
				
				case 'comment':
					$point = 2;
					break;
				
				case 'login':
					$point = 2;
					break;
				
				case 'register':
					$point = 2;
					break;
				
				case 'share_facebook':
					$point = 2;
					break;
				
				case 'share_google':
					$point = 2;
					break;
					
				case 'share_mindtalk':
					$point = 2;
					break;
					
				case 'share_twitter':
					$point = 2;
					break;
					
				case 'Update_status':
					$point = 2;
					break;
				
				case 'Comment_status':
					$point = 2;
					break;
				
				case 'Like_status':
					$point = 1;
					break;
				
				case 'refferal':
					$point = 30;
					break;
				
				case 'poll':
					$point = 3;
					break;
						
				case 'claim_reward':
					$point = '-'.$log; # minus
					break;
				
				default:
					$point = 2;

				endswitch;
								
				return true;
			}
		}
		else
		{
			return false;
		}
	}
	
	function have_checked_in($object_id,$user_id)
	{
		/*
		Check in rule is one check in one article, so we have to check
		true : he has check in
		false : no he don't
		*/
		
		$sql = "SELECT id FROM $this->activities WHERE user_id = '$user_id' AND object_id = '$object_id' AND action = 'checkin' ";
		$query = $this->db->query($sql);
		$total = $query->num_rows();
		
		if ($total > 0) return true;	
	}
	
}
