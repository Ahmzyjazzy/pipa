<?php
Class Messages_model extends CI_Model
{
	function __construct()
	{
			parent::__construct();
	}
	
	
	function get_list($type='')
	{
		if($type!='')
		{
		
			$this->db->where('type', $type);
		
		}
		
		$res = $this->db->get('email_messages');
		
		return $res->result_array();
	}
	
	function get_message($id)
	{
		$res 			= 	$this->db->where('id', $id)->get('email_messages');
		
		return $res->row_array();
		
	}
	
	function save_message($data)
	{
		if($data['id'])
		{
			
			$this->db->where('id', $data['id'])->update('email_messages', $data);
			
			return $data['id'];
			
		}
		else 
		{
			
			$this->db->insert('email_messages', $data);
		
			return $this->db->insert_id();
		
		}
	}
	
	function delete_message($id)
	{
		$this->db->where('id', $id)->delete('email_messages');
		
		return $id;
	}
	
	
}