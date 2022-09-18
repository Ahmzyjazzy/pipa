<?php

public function usersform($id = false)
	{
		$this->is_logged_in();
				
		$data['title']						= 	"Users Form :: PIPA";
		
		$data['menu_status'] 				= 	"users";
		
		$pageid								=	'9';
		
		$pageview							=	'1';
		
		$data['UAC']						=	$this->get_admin_role_credentials();
		
		//check if this page id exists in the role assigned to user
		if(!empty($data['UAC']['rolePageActions'][$pageid]))
		{
			
			$data['userPageActions']				=	explode(',', $data['UAC']['rolePageActions'][$pageid]['pageActions']);
									
			//1 is for view this particular page check if it exists in the array that was just exploded

			if(in_array($pageview, $data['userPageActions']))
			{
		
				$this->admin_id						= 	$id;	
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
				
				//default values are empty if the product is new
				$data['admin_id']					= 	'';
				
				$data['firstname']					= 	'';
				
				$data['lastname']					= 	'';
				
				$data['username']					= 	'';
				
				$data['admin_email']				= 	'';
				
				$data['admin_status']				= 	'';
				
				$data['roleID']						= 	'';
				
				$data['mobile']						= 	'';
				
				$data['roles']						= 	$this->membership_model->get_user_role('', '1');
				
				if ($id)
				{	
					
					$user							= 	$this->membership_model->get_user($id);
					
					//if the brand does not exist, redirect them to the brands list with an error
					if (!$user)
					{
						$this->session->set_flashdata('error', 'The requested User could not be found.');
						
						redirect(base_url().'admin/users/add/');
						
					}
					
					//set values to db values
					$data['admin_id']					= 	$id;
					
					$data['firstname']					= 	$user->firstname;
					
					$data['lastname']					= 	$user->lastname;
					
					$data['username']					= 	$user->username;
					
					$data['admin_email']				= 	$user->admin_email;
					
					$data['admin_status']				= 	$user->admin_status;
					
					$data['roleID']						= 	$user->roleID;
					
					$data['mobile']						= 	$user->mobile;
		
				}
				
				$this->form_validation->set_rules('username', 'User Name', 'trim|required|max_length[64]|callback_username_check['.$id.']');
				
				$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|max_length[64]');
				
				$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|max_length[64]');
				
				$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|max_length[32]');
				
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check['.$id.']|max_length[64]');
				
				if(empty($id))
				{
				
					$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirm_password]');
				
					$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
				
				}else{
					
					$new_psd 							= 	$this->input->post('password');
						// check if while updating the password was reset
					if(empty($new_psd)){
						
						
					}else{
						
						$this->form_validation->set_rules('password', 'Password', 'trim|matches[confirm_password]');
						
						$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
					
					}
				}
		
				if ($this->form_validation->run() == FALSE)
				{
					
					$this->load->view('admin/templates/header', $data);
					
					$this->load->view('admin/user_form');
					
					$this->load->view('admin/templates/footer');
				
				}
				else
				{
								
					$save['admin_id']					= 	$id;
					
					$save['firstname']					= 	$this->input->post('firstname');
					
					$save['lastname']					= 	$this->input->post('lastname');
					
					$save['username']					= 	$this->input->post('username');
					
					$save['admin_email']				= 	$this->input->post('email');
					
					$save['admin_status']				= 	$this->input->post('status');
					
					$save['roleID']						= 	$this->input->post('roleID');
					
					$save['mobile']						= 	$this->input->post('mobile');
		
			
					if(!empty($id))
					{
						// if its an update
						$save['last_modified']			= 	date('Y-m-d H:i:s');
						
						$save['last_modified_by']       = 	$this->session->userdata('admin_id');
						
						$new_psd 						= 	$this->input->post('password');
						
						// check if while updating the password was reset
						if(empty($new_psd)){
							
						}else{
						 
						  $save['password']				= 	md5($this->input->post('password'));
						
						}
						
					}else{
					
						// its a new admin
						$save['password']				= 	md5($this->input->post('password'));
						
						$save['date_created']			= 	date('Y-m-d H:i:s');
						
						$save['created_by']             = 	$this->session->userdata('admin_id');
					
					}
		
					// save brand 
					$admin_id							= 	$this->membership_model->save_user($save);
		
					$this->session->set_flashdata('message', 'The User has been saved.');
					
					//go back to the brand list
					redirect(base_url().'admin/user/');
					
				}
		
			}else{
				
				
				$this->load->view('admin/templates/header', $data);
		
				$this->load->view('admin/uac-permission');
	
				$this->load->view('admin/templates/footer');
			
			}
		
		}else{
			
			
			$this->load->view('admin/templates/header', $data);
		
			$this->load->view('admin/uac-permission');

			$this->load->view('admin/templates/footer');
			
		}
		
	}
	
	
		// save user
	function save_user_role($role, $uac)
	{
		
		$slug_field							=	'roleSlug';
		
		$table								=	'admin_role';
		
		$id_field							=	'roleID';
		
		$role[$slug_field]					= 	$this->validate_slug($role[$slug_field], $slug_field, $table, $id_field, $role[$id_field]);
		
		if($role['roleID'])
		{

			$this->db->where('roleID', $role['roleID']);
			
			$query							=	$this->db->update('admin_role', $role);
			
			$id 							= 	$role['roleID'];
			
			if($query)
			{
				//get the different page and their respective actions
				
				//check if that particular page and action exist in the db, if yes update it, if no add it	
				
				foreach($uac as $key=>$value)
				{
					
					$update['roleID']		=	$id;
					
					$update['pageID']		=	$key;
					
					//first check if the actions were empty i.e either the page actions have been edited or not supplied
					
					if(!empty($value))
					{
						
						$update['pageActions']		=	rtrim($value, ",");
						
						$this->db->where('roleID', $update['roleID']);
						
						$this->db->where('pageID', $update['pageID']);
						
						$checkRolePage				=	$this->db->get('admin_role_page_actions');
						
						if($checkRolePage->num_rows() > 0)
						{
							//means this page already exists for this rol
							
							//now just update its actions	
							
							$this->db->where('roleID', $update['roleID']);
						
							$this->db->where('pageID', $update['pageID']);
							
							$this->db->update('admin_role_page_actions', $update);
						
						}else{
							
							//means the record does not exist so add it
							
							$this->db->insert('admin_role_page_actions', $update);
							
						}
					
					}else{
						
						//means its either this page actions have been removed or they were not added at all
							
						$this->db->where('roleID', $update['roleID']);
						
						$this->db->where('pageID', $update['pageID']);
						
						$checkRolePage			=	$this->db->get('admin_role_page_actions');
						
						if($checkRolePage->num_rows() > 0)
						{
							//means this page already exists for this role but its actions have been removed so delete its record
							
							//now just update its actions	
							$this->db->where('roleID', $update['roleID']);
						
							$this->db->where('pageID', $update['pageID']);
							
							$this->db->delete('admin_role_page_actions');
							
						}
						
					}
					
				}
			
			}
			
		}
		else
		{

			$this->db->insert('admin_role', $role);
			
			$id 		= 	$this->db->insert_id();
			
			foreach($uac as $key=>$value)
			{
				
				$createRolePage['roleID']		=	$id;
				
				$createRolePage['pageID']		=	$key;
				
				//first check if the actions were empty i.e either the page actions have been edited or not supplied
				
				if(!empty($value))
				{
					
					$createRolePage['pageActions']		=	rtrim($value, ",");
					
					$this->db->insert('admin_role_page_actions', $createRolePage);
				
				}else{

					
				}
				
			}
			

		}
		
		//return the product id
		return $id;
		
	}
	
?>