<?php

class Facilitator_model extends CI_Model {

	
	public function __construct()
	{
		
		//$this->site_email 			= 	'noreply@1community.africa';
		
		$this->site_email 			= 	'noreply@aeriksoftsolutions.com';
		
		$this->company_name			=	'1Community';
		
		$this->site_logo			= 	base_url().'asset/images/logo.png';
	}
	
	public function validate_user($tbl_name, $username, $password, $device=false, $mobile_token=false)
	{	
		
		$this->db->where('email', $username);
		
		$query 					= 	$this->db->get($tbl_name);
		
		if($query->num_rows() > 0)
		{
			$ret_id 			= 	$query->row();
			
			if(!empty($ret_id ->confirmedStatus))
			{
				//now check if the account has been disable or suspended or blocked
				
				if(empty($ret_id ->status))
				{
					
					$response	=	array(
					
						'status'	=>	'Error',
						'message'	=>	'Account Disabled, Please contact Site Administrator'
					);
						
				}else{
					
					//if the account is enabled
					if($ret_id ->status == '1')
					{
							
						//now check if the password matches what was provided
						if($ret_id ->password == md5($password))
						{
		
							$data = array(
									
								'userID' 			=> 	$ret_id ->userID,
								'userFirstname' 	=> 	$ret_id ->firstName,
								'userLastname' 		=> 	$ret_id ->lastName,
							);
							
							$id 					= 	$ret_id ->userID;
							$tbl_field 				= 	'userID';
							$tbl_field2 			= 	'userIP';
							$tbl_name_log 			= 	'user_login_details';
				
							$this->session->set_userdata($data);
							
							//record the login time etc
							// keep track of the user ip and what medium they used to open the site i.e mobile or web
							$this->login_details($id, $tbl_field, $tbl_field2, $tbl_name_log, $device);
							
							$response					=	array(
							
								'status'				=>	'Success',
								'message'				=>	'Login Successful',
								'data'					=>	$data
							);
							
							//if the mobile token for android is supplied
							if(!empty($mobile_token))
							{
								
								$this->db->where($tbl_field, $id);
								
								$mobile_query	=	$this->db->update($tbl_name, array('app_token' => $mobile_token));
							}
						
						}else{
							
							//invalid password provided
							
							$response	=	array(
							
								'status'	=>	'Error',
								'message'	=>	'Invalid Password'
							);
							
						}
					
					}else{
						
						$response	=	array(
						
							'status'	=>	'Error',
							'message'	=>	'Account Suspended, Please contact Site Administrator'
						);
							
					}
				
				}
			
			}else{
				
				//tell the user to check their email for the account confirmation link or request for another
				
				$response	=	array(
				
					'status'	=>	'Error',
					'message'	=>	'Your Email has not been confirmed, Please check your email or <a href="'.base_url().'msme/account/resend-account-confirmation/">Click here</a> for another confirmation link'
				);
			}
		
		}else{
			
			//this account does not exist			
			$response	=	array(
			
				'status'	=>	'Error',
				'message'	=>	'Username/Email does not exist'
			);
			
		}
		
		return $response;
	}
	
	public function set_user($data, $page=false)
	{
		
		if(!empty($data['userID']))
		{			
			//if its an update
			$this->db->where('userID', $data['userID']);
					
			$query			=	$this->db->update('user', $data);
			
			if($query)
			{
				
				$response['status']		=	"Success";
				
				$response['message']	=	"Profile Update Successful";
					
			}else{
				
				$response['status']		=	"Error";
				
				$response['message']	=	"There was a problem updating your records";
				
			}
			
			
		}else{
		
			//check if this email account exist already
			$this->db->where('email', $data['email']);
			
			$query 				= 	$this->db->get('user');
			
			if($query->num_rows() > 0)
			{
				$response		=	array(
					
					'status'	=>	'Error',
					'message'	=>	'Email account Exist Already'
				);
			
			}else{
						
				//account does not exist
				$query 							= 	$this->db->insert('user', $data);
			
				$userID 						= 	$this->db->insert_id();
				
				if($query)
				{
					/*$data = array(
					
						'is_volunteer_logged_in' 	=> true,
						'volunteer_id' 				=> $volunteer_id,
						'volunteer_name' 			=> $firstname." ".$lastname
					);
								
					$this->session->set_userdata($data);
					
					// send the volunteer an email
					$this->send_registration_email($firstname, $lastname, $email);*/
					
					// load the security helper where the sha1 function is
					$this->load->helper('security');
					
					$time 						= 	date('Y-m-d H:i:s');
					
					$tim  						= 	strtotime($time);
					
					$token 						= 	do_hash($data['email'].$tim);
					
					if($page)
					{
						$url 					= 	'<a href="'.base_url().'msme/account/confirm-email/'.$userID.'/'.$token.'/">'.base_url().'msme/account/confirm-email/'.$userID.'/'.$token.'/</a>';
					
					}else{
						
						$url 					= 	'<a href="'.base_url().'msme/account/confirm-email/'.$userID.'/'.$token.'/">'.base_url().'msme/account/confirm-email/'.$userID.'/'.$token.'/</a>';
						
					}
					
					$name						= 	ucfirst($data['lastName']).' '.ucfirst($data['firstName']);
						
					$this->confirm_registration_email_token($token,$data['email'],$time,$url,$userID, $name);
					
					//return TRUE;
									
					$response					=	array(
						
						'status'				=>	'Success',
						'message'				=>	'An email has been sent to the address you provided, please check your inbox to Confirm your email.',
						'userID'				=>	$userID
					);
	
								
				}else{
					
					return FALSE;
						
				}
							
			}
		
		}
		
		return $response;
		
	}
	
	public function confirm_registration_email_token($token,$email,$time,$url,$user_id, $name)
	{
		
		$data = array(
		
			'email_token' 		=> $token,
			'token_date' 		=> $time
		
		);
	
		$this->db->where('userID', $user_id);	
		
		$query 					= 	$this->db->update('user', $data);
		
		if($query)
		{
			
			// send the email
			$this->send_registration_mail_token($name, $url, $email);
			
			return TRUE;
			
		}else{
			
			return FALSE;
		
		}
		
	}
	
	// send the user a token for confirmation of email
	public function send_registration_mail_token($name, $url, $email)
	{
		$site_email 			= 	$this->site_email; 
		
		$company_name 			= 	$this->company_name;
		
		$site_logo				= 	$this->site_logo;
		
		// - get the email template
		
		$this->load->model('messages_model');
		
		$row 					= 	$this->messages_model->get_message(1);
		
		$row['content'] 		= 	html_entity_decode($row['content']);
		
		// set replacement values for subject & body
		// {customer_name}
		$row['subject']			= 	str_replace('{name}', $name, $row['subject']);
		
		$row['content'] 		= 	str_replace('{name}',  $name, $row['content']);
		
		// {url}
		$row['content'] 		= 	str_replace('{confirmation_link}', $url, $row['content']);
		
		// {site_name}
		$row['subject'] 		= 	str_replace('{site_name}', $company_name, $row['subject']);
		
		$row['content'] 		= 	str_replace('{site_name}', $company_name, $row['content']);
		
		// {site_logo}
		$row['content'] 		= 	str_replace('{site_logo}', $site_logo, $row['content']);
		
		$config['mailtype'] 	= 	'html';
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
		$this->email->to($email);

		$this->email->subject($row['subject']);
		
		$this->email->message($row['content']);
		
		$this->email->send();

	}
	
	public function reset_password_email_token($token,$email,$time,$url,$user_id, $name)
	{
		
		$data = array(
		
			'userID' 	=> 	$user_id,
			'token' 		=> 	$token,
			'email'			=>	$email,
			'date_created' 	=> 	$time
		
		);
			
		$query 					= 	$this->db->insert('password_reset', $data);
		
		if($query)
		{
			
			// send the email
			$this->send_password_reset_mail_token($name, $url, $email);
			
			return TRUE;
			
		}else{
			
			return FALSE;
		
		}
		
	}
	
	// send the user a token for confirmation of email
	public function send_password_reset_mail_token($name, $url, $email)
	{
		$site_email 			= 	$this->site_email; 
		
		$company_name 			= 	$this->company_name;
		
		$site_logo				= 	$this->site_logo;
		
		// - get the email template
		
		$this->load->model('messages_model');
		
		$row 					= 	$this->messages_model->get_message(2);
		
		$row['content'] 		= 	html_entity_decode($row['content']);
		
		// set replacement values for subject & body
		// {customer_name}
		$row['subject']			= 	str_replace('{name}', $name, $row['subject']);
		
		$row['content'] 		= 	str_replace('{name}',  $name, $row['content']);
		
		// {url}
		$row['content'] 		= 	str_replace('{reset_link}', $url, $row['content']);
		
		// {site_name}
		$row['subject'] 		= 	str_replace('{site_name}', $company_name, $row['subject']);
		
		$row['content'] 		= 	str_replace('{site_name}', $company_name, $row['content']);
		
		// {site_logo}
		$row['content'] 		= 	str_replace('{site_logo}', $site_logo, $row['content']);
		
		$config['mailtype'] 	= 	'html';
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
		$this->email->to($email);

		$this->email->subject($row['subject']);
		
		$this->email->message($row['content']);
		
		$this->email->send();

	}
	
	// check if the token exist
	public function check_token($id,$token)
	{
		$this->db->where('userID', $id);
		
		$this->db->where('token', $token);
		
		$query = $this->db->get('password_reset');
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				//check if this token has been used previously
				if(!empty($row->token_used))
				{
					
					$response		=	array(
					
						'status'	=>	'Error',
						'message'	=>	'This Token has been used kindly request for another!!'
						
					);
				
				}else{
					
					$response		=	array(
					
						'status'	=>	'Success',
						'message'	=>	$row->date_created
						
					);
					
				}
		
			}
			
		}else{
			
			$response		=	array(
			
				'status'	=>	'Error',
				'message'	=>	'A problem occured while processing your request, Please try Again!!'
				
			);	
		
		}
		
		return $response;
	}
	
	public function resetpassword($id,$pswd, $token)
	{
		$this->db->where('userID', $id);
		
		$query 					= 	$this->db->update('user', array('password' => md5($pswd)));
		
		if($query)
		{
			
			$data				= 		array(
			
				"token_used"	=> 	'1',
				"date_reset"	=>	date('Y-m-d H:i:s')
			);
			
			$this->db->where('userID', $id);
			
			$this->db->where('token', $token);
			
			$update_token_tbl 	= 	$this->db->update('password_reset', $data);
		
			return TRUE;
			
		}else{
			
			return FALSE;
		
		}
		
	}
	
	// check if email is unique
	public function check_email($email, $tbl_name)
	{
		//$usrname = $this->input->post('username');
		$this->db->where('email', $email);
		
		$query 			= 	$this->db->get($tbl_name);
		
		if($query->num_rows() > 0)
		{
		
			return TRUE;
		
		}
		else
		{
			
			return FALSE;
		
		}
		
	}
	
	// check if the token exist
	function check_email_confirmation_token($id,$token)
	{
		$this->db->where('userID', $id);
		
		$this->db->where('email_token', $token);
		
		$this->db->where('confirmedStatus', '0');
		
		$query 				= 	$this->db->get('user');
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
			
				return $row->token_date;
			
			}
			
		}else{
			
			return FALSE;	
		}
		
	}
	
	public function confirm_registration_email($id)
	{
		
		$data['confirmedStatus']		= 	'1';
		
		$data['confirmDate']			=	date('Y-m-d H:i:s');
		
		$this->db->where('userID', $id);
		
		$query = $this->db->update('user', $data);
		
		if($query)
		{
			//$user_details	= $this->get_volunteer_details($volunteer_id);
			
			// send the volunteer an email
			//$this->send_registration_email($user_details['first_name'], $user_details['last_name'], $user_details['email']);
			
			return TRUE;
		
		}else{
			
			return FALSE;	
		
		}
	}
	
	// check if email is unique
	public function check_email_exist($email, $tbl_name)
	{
		
		$this->db->where('email', $email);
		
		$query = $this->db->get($tbl_name);
		
		if($query->num_rows() > 0)
		{
			
			$response	=	array(
				
				'status'	=>	'Success',
				'message'	=>	'Email exist'
			);
			
		}
		else
		{
			//this account does not exist			
			$response	=	array(
			
				'status'	=>	'Error',
				'message'	=>	'Email does not exist'
			);
		}
		
		return $response;
	}
	
	public function get_user_id_by_email($email, $table)
	{
		$this->db->where('email', $email);
		
		$query 			= 	$this->db->get($table);
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				
				return $row->userID;
				
			}
		}
		
	}
	
	public function get_user_details($id, $table)
	{
		$this->db->where('userID', $id);
		
		$chk_order 			= 	$this->db->get($table);
		
		if($chk_order->num_rows() > 0) // check if the customer has any order 
		{
		
			return $chk_order->row_array();
			
		}else{
			
		
		}	
		
	}
	
	public function login_details($id, $tbl_field, $tbl_field2, $tbl_name_log, $device=false)
	{
		//check if the login is originated from a mobile app
		if(!empty($device))
		{
			
			$medium 		= 	$device['medium'];
			
			$agent			=	$device['devplatform'];
			
		}else{ //else its from the website either mobile or web
			
			if ($this->agent->is_mobile())
			{
				$agent 		= 	$this->agent->mobile();
				
				$medium 	= 	"mobile";
			}
			
			elseif ($this->agent->is_browser())
			{
				$agent 		= 	$this->agent->browser().' '.$this->agent->version();
				
				$medium 	= 	"web";
			}
			else
			{
				$agent 		= 	'Unidentified User Agent';
				
				$medium 	= 	"";
			}
		
		}
		
		$ip 				= 	$this->input->ip_address();
		
		$date 				= 	date('Y-m-d H:i:s');
		
		$this->load->model('site_model');
		
		$this->site_model->visitor_medium($medium,$agent,$ip,$date, 'Login');

		$data 				= array(
		
			$tbl_field 			=> 	$id,
			'medium' 			=> 	$medium,
			'agent' 			=> 	$agent,
			$tbl_field2 		=> 	$ip,
			'login_date' 		=> 	$date	
		
		);
		
		$query = $this->db->insert($tbl_name_log, $data);
		
		if($query)
		{
			return TRUE;
		}
		
	}

		
	function select_country()
	{
		
		$this->db->order_by('country_name', 'asc');
		
		$query 		= 	$this->db->get('gc_countries');
		
		return $query->result_array();
		
	}
	
	public function get_state_name($id)
	{
		
		$this->db->where('gc_state_id', $id);
		
		$query 		= 	$this->db->get('gc_country_zones');
		
		if($query->num_rows() > 0)
		{
		
			foreach($query->result() as $row)
			{
		
				return $row->state_name;	
		
			}
		
		}
		
	}
	
	public function get_country_name($id)
	{
		
		$this->db->where('gc_country_id', $id);
		
		$query 			= 	$this->db->get('gc_countries');
		
		if($query->num_rows() > 0)
		{
			
			foreach($query->result() as $row)
			{
				
				return $row->country_name;	
			
			}
			
		}
		
	}
	
	public function get_country_states($country)
	{
		
		$this->db->where('country_id', $country);
		
		$this->db->where('status', '1');
		
		$query 					= 	$this->db->get('gc_country_zones');
		
		return $query->result_array();
		
	}
	
	
	public function get_country_states_lga($stateID)
	{
		
		$this->db->where('state_id', $stateID);
				
		$query 					= 	$this->db->get('gc_country_zones_lga');
		
		return $query->result_array();
		
	}
	
	public function check_username($usrname)
	{
		
		$this->db->where('username', $usrname);
		
		$query = $this->db->get('user');
		
		if($query->num_rows > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function validate_slug($slug, $slug_field, $table, $id_field, $id=false, $count=false)
	{
		
		if($this->check_slug($slug.$count, $slug_field, $table, $id_field, $id))
		{
			//echo "1-slug <br />";
			
			if(!$count)
			{
				$count	= 1;
			}
			else
			{
				$count++;
				
			}
			
			return $this->validate_slug($slug, $slug_field, $table, $id_field, $id, $count);
			
		}
		else
		{
			return $slug.$count;
		}
	}
	
	// check if a user with the same name and slug exist already if it does add a number to it
	function check_slug($slug, $slug_field, $table, $id_field, $id=false)
	{
		if($id)
		{
			$this->db->where($id_field.' !=', $id);
		}
		
		$this->db->where($slug_field, $slug);
				
		return (bool) $this->db->count_all_results($table);
	}
	
	function get_banks()
	{
		
		$this->db->where('bank_status', '1');
		
		$query 			=	$this->db->get('banks');
		
		return $query->result_array();	
		
	}
	
	public function admin_notification($notification)
	{
		
		$query				=	$this->db->insert('admin_notification', $notification);
		
		if($query)
		{
			
			return TRUE;
			
		}else{
			
			return FALSE;
						
		}
	}	
	
	public function get_user_business_details($id, $table)
	{
		$this->db->where('userID', $id);
		
		$chk_order 			= 	$this->db->get($table);
		
		if($chk_order->num_rows() > 0) // check if the customer has any order 
		{
		
			return $chk_order->row_array();
			
		}else{
			
		
		}	
		
	}
	
	public function set_business($save)
	{
		
		if(!empty($save['businessID']))
		{
			//this is an update request	
			$this->db->where('businessID', $save['businessID']);
					
			$query			=	$this->db->update('user_business', $save);
			
			if($query)
			{
				
				$response['status']		=	"Success";
				
				$response['message']	=	"Profile Update Successful";
					
			}else{
				
				$response['status']		=	"Error";
				
				$response['message']	=	"There was a problem updating your records";
				
			}
			
		}else{
			
			$slug_field						=	'businessNameSlug';
			
			$table							=	'user_business';
			
			$id_field						=	'businessID';
			
			//this is an insert request
			$save[$slug_field]				= 	$this->validate_slug($save[$slug_field], $slug_field, $table, $id_field);
			
			$query							=	$this->db->insert($table, $save);
			
			if($query)
			{
				
				$response['status']			=	"Success";
				
				$response['message']		=	"Record Successfully Updated";
				
				
			}else{
				
				$response['status']			=	"Error";
				
				$response['message']		=	"There was a problem creating this business";
				
			}
			
		}
		
		return $response;
		
	}
	
	public function get_user_kyc($userID)
	{		
		$this->db->where('userID', $userID);
		
		$this->db->order_by('kycID', 'ASC');
	
		$chk_order 			= 	$this->db->get('user_kyc_docs');
		
		if($chk_order->num_rows() > 0) // check if the customer has any order 
		{
		
			return $chk_order->last_row();
			
			
		}else{
			
			return FALSE;
			
		}
			
	}
	
	public function set_user_kyc($save)
	{
		if($save['kycID'])
		{
			
			$this->db->where('kycID', $save['kycID']);
			
			$query						=	$this->db->update('user_kyc_docs', $save);
			
			if($query)
			{
				
				$response['status']		=	"Success";
				
				$response['message']	=	"KYC Updated Successfully";
					
			}else{
				
				$response['status']		=	"Error";
				
				$response['message']	=	"Failed Updating KYC Please Try Again or Contact Admin";
				
			}
			
		}else{
			
				
			$query 			= 	$this->db->insert('user_kyc_docs', $save);
			
			if($query)
			{
				
				$response['status']		=	"Success";
				
				$response['message']	=	"Documents Submitted Successfully";
					
			}else{
				
				$response['status']		=	"Error";
				
				$response['message']	=	"Failed Submitting Documents Please Try Again or Contact Admin";
				
			}
			
		
		}
		
		return $response;
			
	}
	
	public function set_user_loan($savePersonalProfile, $saveBusinessProfile, $saveUserKYC, $saveUserLoanApplication)
	{
		
		//check if this user has an open loan in the system
		$this->db->where('userID', $saveUserLoanApplication['userID']);
		
		$this->db->where('loanClosed', '0');
		
		$checkOpenLoan					=	$this->db->get('user_loan');
		
		if($checkOpenLoan->num_rows() > 0)
		{
			
			//this user has a loan application still going
			//until rejected or end of tenure of loan user cannot apply for another
			
			$result						=	$checkOpenLoan->row_array();
			
			$response['status']			=	"Error";
			
			if(empty($result['loanStatus']))
			{
				
				//user has a loan still pending review from 1community	
				$response['message']		=	"You have an Existing loan Application awaiting a decision";
			
			}else{
				
				if($result['loanStatus'] == '1')
				{
					
					//user has a loan that has been approved running
						
					$response['message']		=	"You have an Existing loan Application running";
				
				}
					
			}
					
			
		}else{
			
			//means the user is free to create a new loan request
			
			$query					=	$this->db->insert('user_loan', $saveUserLoanApplication);
			
			$loanID					=	$this->db->insert_id();
			
			if($query)
			{
				//insert was successful

				$response['status']							=	"Success";
						
				$response['message']						=	"Loan Request Created Successfully";
			
				//update the user profile table
				
				$this->db->where('userID', $savePersonalProfile['userID']);
							
				$updateUserquery							=	$this->db->update('user', $savePersonalProfile);
				

				//now insert this userprofile into the loan profile
				$savePersonalProfile['loanID']				=	$loanID;
				
				$savePersonalProfile['created_by']			=	$savePersonalProfile['userID'];
				
				$savePersonalProfile['dateCreated']			=	$saveUserLoanApplication['dateCreated'];
				
				$this->db->insert('user_loan_profile', $savePersonalProfile);	
					
				
				
				//update user business profile
				
				$this->db->where('userID', $saveBusinessProfile['userID']);
				
				$checkBusinessQuery							=	$this->db->get('user_business');
				
				if($checkBusinessQuery->num_rows() > 0)
				{
		
					//this is an update request	
					$this->db->where('userID', $savePersonalProfile['userID']);
							
					$updateBusinessQuery					=	$this->db->update('user_business', $saveBusinessProfile);
					
					if($updateBusinessQuery)
					{
						
						$response['businessprofile']['status']		=	"Success";
						
						$response['businessprofile']['message']		=	"Profile Update Successful";
							
					}else{
						
						$response['businessprofile']['status']		=	"Error";
						
						$response['businessprofile']['message']		=	"There was a problem updating your records";
						
					}
					
				}else{
					
					$slug_field								=	'businessNameSlug';
					
					$table									=	'user_business';
					
					$id_field								=	'businessID';
					
					//this is an insert request
					$saveBusinessProfile[$slug_field]		= 	$this->validate_slug($saveBusinessProfile[$slug_field], $slug_field, $table, $id_field);
					
					$insertBusinessQuery					=	$this->db->insert($table, $saveBusinessProfile);
					
					if($insertBusinessQuery)
					{
						
						$response['businessprofile']['status']			=	"Success";
						
						$response['businessprofile']['message']			=	"Record Successfully Created";
						
						
					}else{
						
						$response['businessprofile']['status']			=	"Error";
						
						$response['businessprofile']['message']			=	"There was a problem creating this business";
						
					}
					
				}
				
				
				//insert the business record into the loan business profile
				
				$saveBusinessProfile['loanID']				=	$loanID;
				
				$this->db->insert('user_loan_business', $saveBusinessProfile);
				
				
				
				//update kyc
				$this->db->where('userID', $saveUserKYC['userID']);
				
				$this->db->order_by('kycID', 'ASC');
				
				$checkKycQuery						=	$this->db->get('user_kyc_docs');
				
				if($checkKycQuery->num_rows() > 0)
				{
					
					if($checkKycQuery->num_rows() > 1)
					{
						$getLastKYC					=	$checkKycQuery->row_array();
						
						$kycID						=	$getLastKYC->kycID;
						
						//check if it is more than one kyc this user has
						$this->db->where('kycID', $kycID);
						
						$updateKYCquery				=	$this->db->update('user_kyc_docs', $saveUserKYC);
						
						if($updateKYCqueryy)
						{
							
							$response['KYC']['status']		=	"Success";
							
							$response['KYC']['message']		=	"KYC Updated Successfully";
								
						}else{
							
							$response['KYC']['status']		=	"Error";
							
							$response['KYC']['message']		=	"Failed Updating KYC Please Try Again or Contact Admin";
							
						}
					
					}else{
						
						//its only one record thats found so just update it
						
						$this->db->where('userID', $saveUserKYC['userID']);
						
						$updateKYCquery						=	$this->db->update('user_kyc_docs', $saveUserKYC);
						
						if($updateKYCqueryy)
						{
							
							$response['KYC']['status']		=	"Success";
							
							$response['KYC']['message']		=	"KYC Updated Successfully";
								
						}else{
							
							$response['KYC']['status']		=	"Error";
							
							$response['KYC']['message']		=	"Failed Updating KYC Please Try Again or Contact Admin";
							
						}
						
					}
					
				}else{
					
					//this user has not supplied a kyc before
					
					$insertKYCquery 						= 	$this->db->insert('user_kyc_docs', $saveUserKYC);
					
					if($insertKYCquery)
					{
						
						$response['KYC']['status']			=	"Success";
						
						$response['KYC']['message']			=	"Documents Submitted Successfully";
							
					}else{
						
						$response['KYC']['status']			=	"Error";
						
						$response['KYC']['message']			=	"Failed Submitting Documents Please Try Again or Contact Admin";
						
					}
					
				
				}
			
			}else{
				
				$response['status']							=	"Error";
						
				$response['message']						=	"There was an Error Creating your Loan Request. Please try again later.";
				
				
			}
		
		}
		
		return $response;
		
	}
	
	public function get_user_loans($userID, $loanID=false)
	{
		
		$record			=	array();
		
		if(!empty($loanID))
		{
			
			$this->db->where('loanID', $loanID);	
			
			$this->db->where('userID', $userID);
			
			$query								=	$this->db->get('user_loan');
			
			if($query->num_rows() > 0)
			{
				
				$record['userLoan']				=	$query->row_array();
				
				$record['userLoanProfile']		=	$this->get_user_loan_profile_record($record['userLoan']['loanID']);
				
				$record['userLoanBusiness']		=	$this->get_user_loan_business_record($record['userLoan']['loanID']);
				
				$record['userLoanKYC']			=	$this->get_user_kyc($record['userLoan']['userID']);
				
				$record['userLoanAdmin']		=	$this->get_user_loan_admin_record($record['userLoan']['loanID']);
				
				$record['loanType']				=	$this->get_loanTypeDetails_byID($record['userLoan']['loanTypeID']);
				
				 
			}else{
				
				
					
			}
			
		}else{
		
			$this->db->where('userID', $userID);
			
			$query								=	$this->db->get('user_loan');
			
			if($query->num_rows() > 0)
			{
				
				$result							=	$query->result_array();
				
				foreach($result as $res)
				{
				
					$record[$res['loanID']]['loanID']						=	$res['loanID'];
					
					$record[$res['loanID']]['userID']						=	$res['userID'];
					
					$record[$res['loanID']]['loanTypeID']					=	$res['loanTypeID'];
					
					$record[$res['loanID']]['dist_btwn_home_office']		=	$res['dist_btwn_home_office'];
					
					$record[$res['loanID']]['home_own_status']				=	$res['home_own_status'];
					
					$record[$res['loanID']]['vehicle_own_status']			=	$res['vehicle_own_status'];
					
					$record[$res['loanID']]['no_of_times_borrowed']			=	$res['no_of_times_borrowed'];
					
					$record[$res['loanID']]['loanAmount']					=	$res['loanAmount'];
					
					$record[$res['loanID']]['loanPurpose']					=	$res['loanPurpose'];
					
					$record[$res['loanID']]['loanTenure']					=	$res['loanTenure'];
					
					$record[$res['loanID']]['businessImpact']				=	$res['businessImpact'];
					
					$record[$res['loanID']]['amountInvestedInBusiness']		=	$res['amountInvestedInBusiness'];
					
					$record[$res['loanID']]['cashInAccount']				=	$res['cashInAccount'];
					
					$record[$res['loanID']]['crcCreditScore']				=	$res['crcCreditScore'];
					
					$record[$res['loanID']]['crcNumberLoans']				=	$res['crcNumberLoans'];
					
					$record[$res['loanID']]['crcOutstandingLoansAmount']	=	$res['crcOutstandingLoansAmount'];
					
					$record[$res['loanID']]['crcCurrentLiability']			=	$res['crcCurrentLiability'];
					
					$record[$res['loanID']]['dateCreated']					=	$res['dateCreated'];
					
					$record[$res['loanID']]['loanClosed']					=	$res['loanClosed'];
					
					$record[$res['loanID']]['loanStatus']					=	$res['loanStatus'];
					
					$record[$res['loanID']]['actionBy']						=	$res['actionBy'];
					
					$record[$res['loanID']]['reasonIfDeclined']				=	$res['reasonIfDeclined'];
					
					$record[$res['loanID']]['dateOfAction']					=	$res['dateOfAction'];
					
					$record[$res['loanID']]['createdBy']					=	$res['createdBy'];
					
					$record[$res['loanID']]['ifCreatedByAdminID']			=	$res['ifCreatedByAdminID'];
					
					$record[$res['loanID']]['userLoanProfile']				=	$this->get_user_loan_profile_record($res['loanID']);
					
					$record[$res['loanID']]['userLoanBusiness']				=	$this->get_user_loan_business_record($res['loanID']);
					
					$record[$res['loanID']]['userLoanAdmin']				=	$this->get_user_loan_admin_record($res['loanID']);
					
					$record[$res['loanID']]['loanType']						=	$this->get_loanTypeDetails_byID($res['loanTypeID']);
				
				}
				
				 
			}else{
				
				
					
			}
		
		}
		
		return $record;
		
	}
	
	public function get_user_existing_open_loan_details($userID, $loanID = false, $loanClosed = 0)
	{
		
		$record			=	array();
		
		if(!empty($loanID))
		{
			
			$this->db->where('loanID', $loanID);	
			
		}
		
		$this->db->where('userID', $userID);
		
		$this->db->where('loanClosed', $loanClosed);
		
		$query			=	$this->db->get('user_loan');
		
		if($query->num_rows() > 0)
		{
			
			$record['userLoan']				=	$query->row_array();
			
			$record['userLoanProfile']		=	$this->get_user_loan_profile_record($record['userLoan']['loanID']);
			
			$record['userLoanBusiness']		=	$this->get_user_loan_business_record($record['userLoan']['loanID']);
			
			$record['userLoanAdmin']		=	$this->get_user_loan_admin_record($record['userLoan']['loanID']);
			
			 
		}else{
			
			
				
		}
		
		return $record;
		
	}
	
	public function get_user_loan_profile_record($loanID)
	{
		
		$this->db->where('loanID', $loanID);
		
		$query		=	$this->db->get('user_loan_profile');
		
		return $query->row_array();
		
	}
	
	public function get_user_loan_business_record($loanID)
	{
		
		$this->db->where('loanID', $loanID);
		
		$query		=	$this->db->get('user_loan_business');
		
		return $query->row_array();
		
	}
	
	public function get_user_loan_admin_record($loanID)
	{
		
		$this->db->where('loanID', $loanID);
		
		$query		=	$this->db->get('user_loan_admin_actions');
		
		return $query->row_array();
		
	}
	
	public function get_user_notifications($id, $seen=false)
	{
		$this->db->where('userID', $id);
						
		$this->db->where('dateCreated BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND NOW()');
		
		$this->db->order_by('dateCreated', 'DESC');
		
		$query 			= 	$this->db->get('user_notification');
		
		if($query->num_rows() > 0)
		{
			
			if(!empty($seen))
			{
				$this->db->where('userID', $id);
				
				$this->db->where('seen', '0');
				
				$this->db->update('user_notification', array('seen' => $seen));
				
			}
			
			return $query->result_array();
			
		}else{
			
			return FALSE;
		
		}
		
	}
	
	public function get_user_notifications_unseen($id, $seen=false)
	{
		$this->db->where('userID', $id);
		
		$this->db->where('seen', '0');
				
		$this->db->order_by('dateCreated', 'DESC');
		
		$query 			= 	$this->db->get('user_notification');
		
		if($query->num_rows() > 0)
		{
			
			return $query->result_array();
			
		}else{
			
			return FALSE;
		
		}
		
	}
	
	public function get_user_messages($userID)
	{
		
		$this->db->select('message_users.*, messages.*');
		
		$this->db->where('message_users.userID', $userID);
		
		$this->db->where('message_users.delStatus', '0');
		
		$this->db->from('message_users');
		
		$this->db->join('messages', 'messages.messageID = message_users.messageID', 'left');
		
		$this->db->order_by('message_users.dateCreated', 'DESC');
						
		$query 			= 	$this->db->get();
		
		return $query->result_array();
			
	}
	
	public function fetch_user_message($slug, $user_id)
	{
		
		$message						=	array();
		
		$this->db->where('subject_slug', $slug);
		
		$query							=	$this->db->get('messages');
		
		if($query->num_rows() > 0)
		{
			$message					=	$query->row_array();
						
			//now get the details of that message
			$messageID					=	$message['messageID'];
			
			$this->db->where('messageID', $messageID);
			
			$this->db->where('userID', $user_id);
			
			$checkUserMessageTbl			=	$this->db->get('message_users');
			
			if($checkUserMessageTbl->num_rows() > 0)
			{
				$userMessageDet				=	$checkUserMessageTbl->row_array();
				
				if(empty($userMessageDet['messageStatus']))
				{
				
					$save['messageID']			=	$messageID;
					
					$save['userID']				=	$user_id;
					
					$save['messageStatus']		=	'1';
					
					$save['dateRead']			=	date('Y-m-d H:i:s');
					
					$this->db->where('messageID', $save['messageID']);
					
					$this->db->where('userID', $save['userID']);
					
					$updtmessage				=	$this->db->update('message_users', $save);

				}
			
			}
			
		}
		
		return $message;
		
	}
	
	function delete_message($save)
	{
		
		$this->db->where('msgUserID', $save['msgUserID']);
		
		$query			=	$this->db->update('message_users', $save);	
		
		if($query)
		{
			
			return TRUE;
			
		}else{
			
			return FALSE;	
			
		}
		
	}
	
	function get_user_kyc_status($id)
	{
		$this->db->where('userID', $id);
		
		$query 				= 	$this->db->get('user_kyc_docs');
		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
			
				return $row->kycStatus;
			
			}
			
		}else{
			
			return FALSE;	
		}
		
	}
	
	public function get_loanTypeDetails_bySlug($slug)
	{
		
		$this->db->where('loanTypeSlug', $slug);
		
		$query 				= 	$this->db->get('user_loantypes');
		
		if($query->num_rows() > 0)
		{
			$row 			= 	$query->row_array();
			
			return $row;
			
		}
		
	}
	
	
	public function get_loanTypeDetails_byID($id)
	{
		
		$this->db->where('loanTypeID', $id);
		
		$query 				= 	$this->db->get('user_loantypes');
		
		if($query->num_rows() > 0)
		{
			$row 			= 	$query->row_array();
			
			return $row;
			
		}
		
	}
	
	// send the user a initiation email
	public function send_transaction_intiation_mail($name, $refNo, $btcAmount, $nairaAmount, $txnType, $email)
	{
		
		$site_email 			= 	"noreply@zickie.ng";
		
		//$site_email 			= 	"noreply@aeriksoftsolutions.com"; 
		
		$company_name 			= 	"Zickie.ng";
		
		$site_logo				= 	base_url().'asset/images/logo/logo2.png';
		
		// - get the email template
		
		$this->load->model('messages_model');
		
		$row 					= 	$this->messages_model->get_message(5);
		
		$row['content'] 		= 	html_entity_decode($row['content']);
		
		// set replacement values for subject & body
		// {customer_name}
		$row['subject']			= 	str_replace('{name}', $name, $row['subject']);
		
		$row['content'] 		= 	str_replace('{txnType}',  $txnType, $row['content']);
		
		$row['content'] 		= 	str_replace('{name}',  $name, $row['content']);
		
		$row['content'] 		= 	str_replace('{ref_num}',  $refNo, $row['content']);
		
		// {btc amount}
		$row['content'] 		= 	str_replace('{btc_amount}', $btcAmount, $row['content']);
		
		// {naira amount}
		$row['content'] 		= 	str_replace('{naira_amount}', $nairaAmount, $row['content']);
		
		// {site_name}
		$row['subject'] 		= 	str_replace('{site_name}', $company_name, $row['subject']);
		
		$row['content'] 		= 	str_replace('{site_name}', $company_name, $row['content']);
		
		// {site_logo}
		$row['content'] 		= 	str_replace('{site_logo}', $site_logo, $row['content']);
		
		$config['mailtype'] 	= 	'html';
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
		$this->email->to($email);

		$this->email->subject($row['subject']);
		
		$this->email->message($row['content']);
		
		$this->email->send();

	}
	
	// send the user a initiation email
	public function send_transaction_intiation_mail_admin($name, $refNo, $btcAmount, $nairaAmount, $txnType, $email)
	{
		
		$site_email 			= 	$this->site_email; 
		
		$company_name 			= 	$this->company_name;
		
		$site_logo				= 	$this->site_logo;
		
		$email_to				=	$this->get_admin_initiate_txn_email_address();
		
		// - get the email template
		
		$this->load->model('messages_model');
		
		$row 					= 	$this->messages_model->get_message(6);
		
		$row['content'] 		= 	html_entity_decode($row['content']);
		
		// set replacement values for subject & body
		// {customer_name}
		$row['subject']			= 	str_replace('{customer}', $name, $row['subject']);
		
		$row['content'] 		= 	str_replace('{txnType}',  $txnType, $row['content']);
		
		$row['content'] 		= 	str_replace('{customer}',  $name, $row['content']);
		
		$row['content'] 		= 	str_replace('{ref_num}',  $refNo, $row['content']);
		
		// {btc amount}
		$row['content'] 		= 	str_replace('{btc_amount}', $btcAmount, $row['content']);
		
		// {naira amount}
		$row['content'] 		= 	str_replace('{naira_amount}', $nairaAmount, $row['content']);
		
		// {site_name}
		$row['subject'] 		= 	str_replace('{site_name}', $company_name, $row['subject']);
		
		$row['content'] 		= 	str_replace('{site_name}', $company_name, $row['content']);
		
		// {site_logo}
		$row['content'] 		= 	str_replace('{site_logo}', $site_logo, $row['content']);
		
		$config['mailtype'] 	= 	'html';
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
		$this->email->to($email_to);

		$this->email->subject($row['subject']);
		
		$this->email->message($row['content']);
		
		$this->email->send();

	}
	
	public function get_admin_initiate_txn_email_address()
	{
		
		$this->db->where('page_id', '1');
		
		$query 				= 	$this->db->get('email_settings');
		
		if($query->num_rows() > 0)
		{
			$row 			= 	$query->row_array();
			
			return $row['email'];
			
		}
		
	}
	
	public function check_pswd($pswd, $id)
	{
		
		//$usrname = $this->input->post('username');
		
		$this->db->where('password', md5($pswd));
		
		$this->db->where('userID', $id);
		
		$query 				= 	$this->db->get('user');
		
		if($query->num_rows() > 0)
		{
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}

}