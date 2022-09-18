<?php
class Membership_model extends CI_Model {
	
	public function __construct()
	{
				
		if(base_url() == 'https://www.naama.io/' || base_url() == 'https://www.naama.io/sandbox/')
		{
			
			$this->site_email 			= 	'noreply@naama.io';
		
		}else{
			
			$this->site_email 			= 	'noreply@aeriksoftsolutions.com';
		}
		
		$this->company_name			=	'PIPA';
		
		$this->site_logo			= 	base_url().'asset/images/logo.png';
				
	}	
	
	function validate_login_otp($email, $otp)
	{
		
		$this->db->where('admin_email', $email);	
			
		$query 				= 	$this->db->get('admin');
		
		if($query->num_rows() > 0)
		{
			
			$ret_id 		= 	$query->row();
			
			$userID			=	$ret_id ->admin_id;
			
			$this->db->where('adminID', $userID);
			
			$this->db->where('otp', $otp);
			
			$otpQuery		=	$this->db->get('admin_login_otp');
			
			if($otpQuery->num_rows() > 0)
			{
				$result 				=	$otpQuery->row_array();
				
				$dateTime				=	time();
				
				$dateApplied			=	strtotime($result['dateCreated']);
				
				//first check if the time has elapsed 10mins
				if($dateTime - $dateApplied > 60 * 10) {
					
					$response	=	array(
					
						'status'	=>	'Error',
						'message'	=>	'OTP has expired, Please try again'
					);
				
				}else{
					
					//check if the otp has not been previously used
					if(!empty($result['otpUsed']))
					{
						
						$response	=	array(
						
							'status'	=>	'Error',
							'message'	=>	'This OTP has been used, Please try again'
						);
						
					}else{
						
						//means the user can proceed to login	
						$data 				= 	array(
						
							'admin_id' 		=> 	$ret_id->admin_id,
							'username' 		=> 	$ret_id->username,
							'is_logged_in' 	=> 	true,
							'firstname' 	=> 	$ret_id->firstname,
							'lastname' 		=> 	$ret_id->lastname,
						
						);
						
						$this->session->set_userdata($data);
						
						$tbl_name			=	"admin";
						
						$tbl_field 			= 	$tbl_name.'_id';
						
						$tbl_field2 		= 	$tbl_name.'_ip';
						
						$tbl_name_log 		= 	$tbl_name.'_login_details';
								
						//record the login time etc
						// keep track of the user ip and what medium they used to open the site i.e mobile or web
						
						$this->login_details($userID, $tbl_field, $tbl_field2, $tbl_name_log);
						
						//update the otp table
						$updtOtp['otpUsed']		=	'1';
						
						$updtOtp['dateUsed']	=	date('Y-m-d H:i:s');
						
						$this->db->where('otpID', $result['otpID']);
						
						$this->db->update('admin_login_otp', $updtOtp);
						
						
						$response			=	array(
						
							'status'		=>	'Success',
							
							'message'		=>	'Login Successful',
							
							'data'			=>	$ret_id
						
						);
					
					
					}
					
				}
					
			}
			
		}else{
			
			//this account does not exist			
			$response	=	array(
			
				'status'	=>	'Error',
				'message'	=>	'Username does not exist'
			);
			
		}
		
		return $response;
		
		
	}
	
	function validate_admin($username, $password)
	{
		
		$this->db->where('email', $username);
					
		$query 				= 	$this->db->get('user');
		
		if($query->num_rows() > 0)
		{
			$ret_id 		= 	$query->row();
			
			//now check if the user account is active
			//get the user trying to login
			
			if(!empty($ret_id->is_admin))
			{
				
				if(!empty($ret_id->is_admin_active))
				{
					//now check if the password matches what was provided
					
					if($ret_id ->password == md5($password))
					{
	
						$id 				= 	$ret_id ->user_id;
						
						$data 				= 	array(
						
							'user_id' 				=> 	$ret_id->user_id,
			
							'company_id' 			=> 	$ret_id->company_id,
			
							'username' 				=> 	$username,
			
							'is_admin_logged_in' 	=> 	true,
			
							'firstname' 			=> 	$ret_id->first_name,
			
							'lastname' 				=> 	$ret_id->last_name,
			
						);
						
						$this->session->set_userdata($data);
						
						$tbl_name		=	"user";
						
						$tbl_field 		= 	$tbl_name.'_id';
						
						$tbl_field2 	= 	$tbl_name.'_ip';
						
						$tbl_name_log 	= 	$tbl_name.'_login_details';
								
						//record the login time etc
						// keep track of the user ip and what medium they used to open the site i.e mobile or web
						$this->login_details($id, $tbl_field, $tbl_field2, $tbl_name_log);
						
						$response		=	array(
						
							'status'	=>	'Success',
							
							'message'	=>	'Login Successful',
							
							'data'		=>	$ret_id
						
						);
					
					}else{
						
						//invalid password provided
						$response	=	array(
						
							'status'	=>	'Error',
							'message'	=>	'Invalid Password'
						);
						
					}
				
				}else{
					
					//tell the user that their account is not active
					
					$response	=	array(
					
						'status'	=>	'Error',
						'message'	=>	'Your Account is not Active, Please contact the system administrator'
					);
				}
			
			}else{
				
				//user is stored in the table but is not an admin
				
				$response	=	array(
				
					'status'	=>	'Error',
					'message'	=>	'Account does not have admin priviledges'
				);
				
			}
		
		}else{
			
			//this account does not exist			
			$response	=	array(
			
				'status'	=>	'Error',
				'message'	=>	'Account does not exist'
			);
			
		}
		
		return $response;
	}
	
	public function check_confirm_admin_credentials($userID)
	{
		
		$response						=	array();
		
		$this->db->where('user_id', $userID);
		
		$query							=	$this->db->get('user');
		
		if($query->num_rows() > 0)
		{
			
			$user						=	$query->row_array();
				
			if(!empty($user['is_admin']))
			{
				
				if(!empty($user['is_admin_active']))
				{
					
					//check if the password for this account has been set
					if(!empty($user['password']))
					{
						
						//if this user has a password set previously means he was already a user on the platform automatically log them in and redirect to dashboard
						
						//check if this user has previously logged into the admin
						
						$checkAdminSession		=	$this->session->userdata('is_admin_logged_in');
						
						$checkAdminUserID		=	$this->session->userdata('user_id');
						
						if(!empty($checkAdminSession))
						{
							
							
						
						}else{
							
							//log the admin in	
							$id 					= 	$user['user_id'];
							
							$data 					= 	array(
							
								'user_id' 				=> 	$id,
				
								'company_id' 			=> 	$user['company_id'],
				
								'username' 				=> 	$username,
				
								'is_admin_logged_in' 	=> 	true,
				
								'firstname' 			=> 	$user['first_name'],
				
								'lastname' 				=> 	$user['last_name'],
				
							);
							
							$this->session->set_userdata($data);
							
							$tbl_name		=	"user";
							
							$tbl_field 		= 	$tbl_name.'_id';
							
							$tbl_field2 	= 	$tbl_name.'_ip';
							
							$tbl_name_log 	= 	$tbl_name.'_login_details';
									
							//record the login time etc
							// keep track of the user ip and what medium they used to open the site i.e mobile or web
							$this->login_details($id, $tbl_field, $tbl_field2, $tbl_name_log);
							
						}
						
						$response['status']		=	'Success';
							
						$response['data']		=	'Login Successful';
						
					}else{
						
						$response['status']		=	'Success';
							
						$response['data']		=	'';
						
						$response['email']		=	$user['email'];
					
					}
									
				}else{
					
					$response['status']		=	'Failed';
						
					$response['data']		=	'This account has not been activated, Please contact Administrator or Try again after a while';
				}
				
			}else{
				
				$response['status']		=	'Failed';
					
				$response['data']		=	'This credentials are not valid for an Admin on this platform';
				
			}
			
		}else{
			
			$response['status']		=	'Failed';
					
			$response['data']		=	'This credentials are not valid for an Admin on this platform';
			
		}
		
		return $response;
		
	}
	
	public function set_admin_credentials($email, $password)
	{
		
		$response		=	array();
		
		$this->db->where('email', $email);
		
		$query			=	$this->db->get('user');
		
		if($query->num_rows() > 0)
		{
			$user		=	$query->row_array();
			
			if(!empty($user['is_admin']))
			{
				
				if(!empty($user['is_admin_active']))
				{
					
					$this->db->where('user_id', $user['user_id']);
					
					$performQuery		=	$this->db->update('user', array('password'=>md5($password)));
					
					if($performQuery)
					{
						
						$id 				= 	$user['user_id'];
						
						$data 				= 	array(
						
							'user_id' 				=> 	$id,
			
							'company_id' 			=> 	$user['company_id'],
			
							'username' 				=> 	$user['username'],
			
							'is_admin_logged_in' 	=> 	true,
			
							'firstname' 			=> 	$user['first_name'],
			
							'lastname' 				=> 	$user['last_name'],
			
						);
						
						$this->session->set_userdata($data);
						
						$tbl_name		=	"user";
						
						$tbl_field 		= 	$tbl_name.'_id';
						
						$tbl_field2 	= 	$tbl_name.'_ip';
						
						$tbl_name_log 	= 	$tbl_name.'_login_details';
								
						//record the login time etc
						// keep track of the user ip and what medium they used to open the site i.e mobile or web
						$this->login_details($id, $tbl_field, $tbl_field2, $tbl_name_log);
						
						$response		=	array(
						
							'status'	=>	'Success',
							
							'message'	=>	'Login Successful',
							
							'data'		=>	$ret_id
						
						);
						
					}else{
						
						$response	=	array(
						
							'status'	=>	'Error',
							'message'	=>	'Password creation failed'
						);
					
					}
					
				}else{
					
					$response	=	array(
					
						'status'	=>	'Error',
						'message'	=>	'Your Account is not Active, Please contact the system administrator'
					);
					
				}
				
			}else{
				
				$response['status']		=	'Error';
			
				$response['message']	=	'This account does not exist';
			
			}
			
		}else{
			
			$response['status']		=	'Error';
			
			$response['message']	=	'This account does not exist';
				
		}
		
		return $response;
		
	}
	
	// check if email is unique
	public function check_email_exist($email, $tbl_name)
	{
		
		$this->db->where('email', $email);
		
		$query = $this->db->get($tbl_name);
		
		if($query->num_rows() > 0)
		{
			
			$result 		=	$query->row_array();
			
			if(!empty($result['is_admin']))
			{
				
				if(!empty($result['is_admin_active']))
				{
						
					$response	=	array(
						
						'status'	=>	'Success',
						
						'message'	=>	'Email exist'
					
					);
				
				}else{
					
					$response	=	array(
					
						'status'	=>	'Error',
						
						'message'	=>	'Account not activated, Please contact System Administrator'
					
					);
				
				}
				
			}else{
				
				$response	=	array(
				
					'status'	=>	'Error',
					
					'message'	=>	'Account not found'
				
				);
				
			}
			
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
				
				return $row->user_id;
				
			}
		}
		
	}
	
	public function get_user_details($id, $table)
	{
		$this->db->where('user_id', $id);
		
		$chk_order 			= 	$this->db->get($table);
		
		if($chk_order->num_rows() > 0) // check if the customer has any order 
		{
		
			return $chk_order->row_array();
			
		}else{
			
		
		}	
		
	}
	
	public function reset_password_email_token($token,$email,$time,$url,$user_id, $name)
	{
		
		$data 				= 	array(
		
			'user_id' 		=> 	$user_id,
			'token' 		=> 	$token,
			'email'			=>	$email,
			'date_created' 	=> 	$time
		
		);
			
		$query 					= 	$this->db->insert('user_password_reset', $data);
		
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
		
		$row 					= 	$this->messages_model->get_message(5);
		
		$row['content'] 		= 	html_entity_decode($row['content']);
		
		// set replacement values for subject & body
		// {customer_name}
		
		$row['content'] 		= 	str_replace('{name}',  $name, $row['content']);
		
		// {url}
		$row['content'] 		= 	str_replace('{reset_link}', $url, $row['content']);
		
		// {site_name}
		$row['subject'] 		= 	str_replace('{site_name}', $company_name, $row['subject']);
		
		$row['content'] 		= 	str_replace('{site_name}', $company_name, $row['content']);
		
		// {site_logo}
		$row['content'] 		= 	str_replace('{site_logo}', $site_logo, $row['content']);
		
		
		$mailBody				=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>

<body>

<style>

.container {
  padding-right: 15px;
  padding-left: 15px;
   width:90%;
  margin-right: auto;
  margin-left: auto;
}

.col-md-12{
  padding-right: 15px;
  padding-left: 15px;
  
}

.mail-welcome-hdr{
	font-size:18px;
	padding-top:10px;
	padding-bottom:10px;
	margin-bottom:10px;
	margin-top:10px;
	background-color: #0071f6;
	text-transform: uppercase;
	font-family:Verdana, Geneva, sans-serif;
	font-weight: 700;
	color:#fff;
	text-align:center;
}

.mail-msg-usr-hdr{
	font-weight:600;
}

.mail-msg-cnt ul{
	padding-left:15px;
}

.mail-msg-cnt ul li{
	margin-top:10px;
	margin-bottom:10px;	
}

.msg-mail-cnct{
	color: #0071f6;
	font-weight:600;
}

.msg-mail-cnct a{
	text-decoration:none;
	color: #0071f6;
}

.mail-cust-name{
	font-weight:600;
}

.tp-contacts{
	padding-top:3px;
	overflow:auto;
	text-align:center;
}

.tp-contacts ul{
	padding-left:0px;
	display: inline-block;
}

.tp-contacts ul li{
	float:left;
	display:inline-block;
	margin-left:5px;
	margin-right:5px;	
	padding-right:15px;
	padding-left:10px;
	font-family: "AlegreyaSansSC-Thin";
	font-size:14px;
	font-weight:600;
	border-right:1px solid #000;
}

.tp-contacts ul li:last-child{
	border:none;
	padding-right:0px;
	margin-right:0px;
}

.top-logo{
	text-align:center;
}

</style>

<div class="" style="padding-bottom:30px; padding-top:30px; padding-left:0px; padding-right:0px; background-color:#cccccc; ">

	<div class="container" style="background-color:#fff; padding-bottom:20px; padding-top:20px;">
    
    	<div class="col-md-12">
            
            <div class="top-logo">
            	
                <img src="'.$site_logo.'" />
                                
            </div>

            
        </div>
        
        <div class="col-md-12">
        	
            <div class="mail-welcome-hdr">
            	
               Reset Password
                
            </div>
            
        </div>
        
        <div class="col-md-12">
        
        	<div class="" style="margin-bottom:10px; padding-left:10px; line-height:25px;">
			
			
				'.$row['content'].'
			
			</div>
            
        </div>
        
    </div>
    
</div>

</body>
</html>';	

		$config['mailtype'] 	= 	'html';
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
		$this->email->to($email);

		$this->email->subject($row['subject']);
		
		$this->email->message($mailBody);
		
		$this->email->send();

	}
	
		// check if the token exist
	public function check_token($id,$token)
	{
		$this->db->where('user_id', $id);
		
		$this->db->where('token', $token);
		
		$query = $this->db->get('user_password_reset');
		
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
		$this->db->where('user_id', $id);
		
		$query 					= 	$this->db->update('user', array('password' => md5($pswd)));
		
		if($query)
		{
			
			$data				= 		array(
			
				"token_used"	=> 	'1',
				
				"date_reset"	=>	date('Y-m-d H:i:s')
			
			);
			
			$this->db->where('user_id', $id);
			
			$this->db->where('token', $token);
			
			$update_token_tbl 	= 	$this->db->update('user_password_reset', $data);
		
			return TRUE;
			
		}else{
			
			return FALSE;
		
		}
		
	}
	
	public function get_admin_role_assigned($id)
	{
		
		$this->db->where('admin_id', $id);
		
		$query			=	$this->db->get('admin');
		
		if($query->num_rows() > 0)
		{
			$row		=	$query->row_array();
			
			return $row['roleID'];
			
		}else{
			
			return FALSE;
				
		}
		
	}

	public function login_details($id, $tbl_field, $tbl_field2, $tbl_name_log)
	{
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
		
		$ip 			= 	$this->input->ip_address(); //$this->session->userdata('ip_address');
		$date 			= 	date('Y-m-d H:i:s');
		
		$data = array(
			$tbl_field 			=> $id,
			'medium' 			=> $medium,
			'agent' 			=> $agent,
			$tbl_field2 		=> $ip,
			'login_date' 		=> $date	
		);
		
		$query 			= 	$this->db->insert($tbl_name_log, $data);
		
		if($query)
		{
			return TRUE;
		}
		
	}
	
	// get visitors
	public function get_visitors()
	{
		
		$chk_order = $this->db->query('select distinct(visitor_ip) from visitor_medium_agent');
		
		if($chk_order->num_rows() > 0) // check if the customer has any order 
		{

			return $chk_order->result_array();
			
		}else{
			
			return $chk_order->num_rows(); // return zero
		}
		
	}
	
	public function get_total_visitors()
	{
		
		$query 			= 	$this->db->get('visitor_medium_agent');
		
		return $query->num_rows(); // return zero
		
	}

	// get most viewed pages
	public function get_most_viewed_pages()
	{
		 $this->db->select('page, count(page) as visited');
		 $this->db->from('visitor_medium_agent');
		 $this->db->group_by('page');
		 $this->db->order_by('visited', 'DESC');
		 $this->db->limit('10');
		 $query = $this->db->get();
		 
		return $query->result_array();
		
	}
	
	// get device stats
	public function get_device_stats()
	{
		 $this->db->select('medium, count(medium) as device_count, count(medium) / (SELECT count(medium) FROM visitor_medium_agent)*100 as percent');
		 $this->db->from('visitor_medium_agent');
		 $this->db->group_by('medium');
		 $this->db->order_by('percent', 'DESC');
		 $query = $this->db->get();
		 
		return $query->result_array();
		
	}
	
	// get browser stats
	public function get_browser_stats()
	{
		 $this->db->select('SUBSTRING_INDEX(agent," ",1) as agent, count(SUBSTRING_INDEX(agent," ",1)) as browser_count, count(SUBSTRING_INDEX(agent," ",1)) / (SELECT count(SUBSTRING_INDEX(agent," ",1)) FROM visitor_medium_agent)*100 as percent');
		 $this->db->from('visitor_medium_agent');
		 $this->db->group_by('SUBSTRING_INDEX(agent," ",1)');
		 $this->db->order_by('percent', 'DESC');
		 $query = $this->db->get();
		 
		return $query->result_array();
		
	}


	
	// get all admin users
	public function get_admins()
	{
		
		$this->db->select('admin.*, admin_role.roleID, admin_role.role');
		
		$this->db->from('admin');
		
		$this->db->join('admin_role', 'admin_role.roleID = admin.roleID', 'left');
		
		$this->db->order_by('admin.date_created', 'DESC');
				
		$query 			= 	$this->db->get();
		
		return $query->result_array();
				
	}
	
	
	// return particular admin details for editing
	function get_admin($id)
	{
		$result				= 	$this->db->get_where('admin', array('admin_id'=>$id))->row();
		
		if(!$result)
		{
			return false;
		}

		return $result;
	}
	
	
	// save user
	function save_admin($user)
	{
		if ($user['admin_id'])
		{

			$this->db->where('admin_id', $user['admin_id']);
			
			$this->db->update('admin', $user);
			
			$id 		= 	$user['admin_id'];
		}
		else
		{

			$this->db->insert('admin', $user);
			
			$id 		= 	$this->db->insert_id();

		}
		
		//return the product id
		return $id;
	}
	
	// check if email is unique
	public function check_email($email, $id)
	{
		//$usrname = $this->input->post('username');
		if(!empty($id)){
			
			$query = $this->db->query('select admin_email FROM admin WHERE admin_email = "'.$email.'" AND admin_id != "'.$id.'"');
		
		}else{
			
			$this->db->where('admin_email', $email);
			$query = $this->db->get('admin');
		}
		
		if($query->num_rows > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	// check if username is unique
	public function check_username($username, $id)
	{
		//$usrname = $this->input->post('username');
		if(!empty($id)){
			
			$query = $this->db->query('select username FROM admin WHERE username = "'.$username.'" AND admin_id != "'.$id.'"');
		
		}else{
			
			$this->db->where('username', $username);
			$query = $this->db->get('admin');
		}
		
		if($query->num_rows > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	// check if old password is correct
	public function check_pswd($pswd, $admin_id)
	{
		//$usrname = $this->input->post('username');
		$this->db->where(array('password' => md5($pswd), 'admin_id' => $admin_id));
		
		$query 				= 	$this->db->get('admin');
		
		if($query->num_rows > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	// change password
	public function change_password($pswd, $admin_id)
	{
		$this->db->where('admin_id', $admin_id);
		
		$query 				= 	$this->db->update('admin', array('password' => md5($pswd)));
		
		if($query)
		{
			return TRUE;	
		}
		else
		{
			return FALSE;	
		}
		
	}
	
	public function get_user_role($id=false, $status=false)
	{
		
		if(!empty($status))
		{
			
			$this->db->where('status', $status);
			
		}
		
		$this->db->order_by('dateCreated', 'DESC');
		
		if(!empty($id))
		{
			
			$this->db->where('roleID', $id);
			
			$query					=	$this->db->get('admin_role')->row_array();
			
			if(!empty($query))
			{
				
				$pageActions['rolePageActions']		=	$this->get_role_page_actions($query['roleID']);
				
				$result								=	array_merge($query, $pageActions);
			
				return $result;
				
			}else{
				
			
				return $query;
			
			}
		
		}else{
		
			$query		=	$this->db->get('admin_role')->result_array();
			
			return $query;
		
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
		
		
	// check if username is unique
	public function check_rolename($role, $id)
	{

		if(!empty($id))
		{
			
			$query 				= 	$this->db->query('select role FROM admin_role WHERE role = "'.$role.'" AND roleID != "'.$id.'"');
		
		}else{
			
			$this->db->where('role', $role);
			
			$query 				= 	$this->db->get('admin_role');
		
		}
		
		if($query->num_rows > 0)
		{
			
			return TRUE;
	
		}
		else
		{
	
			return FALSE;
	
		}
	
	}
	
	public function get_admin_pages($id=false)
	{
		
		$result							=	array();
				
		if(!empty($id))
		{
			
			$this->db->where('pageID', $id);
			
			$query						=	$this->db->get('admin_pages');
			
			$queryResult				=	$query->row_array();
			
			$data['actions']			=	$this->get_admin_page_actions($queryResult['pageID']);
			
			$result						=	array_merge($queryResult, $data);
		
		}else{
		
			$this->db->order_by('page', 'ASC');
			
			$query						=	$this->db->get('admin_pages');
			
			$queryResult				=	$query->result_array();
					
			$counter					=	0;
			
			foreach($queryResult as $res)
			{
				
				$result[$counter]['pageID']			=	$res['pageID'];
				
				$result[$counter]['page']			=	$res['page'];
				
				$result[$counter]['slug']			=	$res['slug'];
				
				$result[$counter]['actions']		=	$this->get_admin_page_actions($res['pageID']);
				
				$counter++;
					
			}
		
		}
			
		return $result;	
	}
	
	// save user
	function save_admin_page($page, $actions=false)
	{
		
		$slug_field							=	'slug';
		
		$table								=	'admin_pages';
		
		$id_field							=	'pageID';
		
		$page[$slug_field]					= 	$this->validate_slug($page[$slug_field], $slug_field, $table, $id_field, $page[$id_field]);
		
		if($page['pageID'])
		{

			$this->db->where('pageID', $page['pageID']);
			
			$this->db->update('admin_pages', $page);
			
			
			$id 					= 	$page['pageID'];
			
			if(!empty($actions))
			{
				//first delete the old records and insert this new one
				
				$this->db->where('pageID', $page['pageID']);
				
				$actQuery			=	$this->db->get('admin_page_actions');
				
				if($actQuery->num_rows() > 0)
				{
					
					$this->db->where('pageID', $page['pageID']);
					
					$this->db->delete('admin_page_actions');
						
				}
				
				$intr_array		= 	explode(',', $actions);
				
				foreach($intr_array as $act=>$key)
				{
					$actionSave['pageID']		=	$page['pageID'];
					
					$actionSave['actionID']		=	$key;
					
					$this->db->insert('admin_page_actions', $actionSave);	
					
				}
				
			}
			
		}
		else
		{

			$this->db->insert('admin_pages', $page);
			
			$id 				= 	$this->db->insert_id();
			
			if(!empty($actions))
			{
				
				$intr_array		= 	explode(',', $actions);
				
				foreach($intr_array as $act=>$key)
				{
					$actionSave['pageID']		=	$id;
					
					$actionSave['actionID']		=	$key;
					
					$this->db->insert('admin_page_actions', $actionSave);	
					
				}
				
			}

		}
		
		//return the product id
		return $id;
		
	}
	
	function delete_admin_page($id)
	{
		
		$this->db->where('pageID', $id);
		
		$query			=	$this->db->delete('admin_pages');	
		
		if($query)
		{
			//now delete all the page actions attributed to this page
			
			$this->db->where('pageID', $id);
		
			$pageActionquery	=	$this->db->delete('admin_page_actions');
			
			if($pageActionquery)
			{
				//now delete all the roles attributed to this page
				
				$this->db->where('pageID', $id);
		
				$rolePageActionquery	=	$this->db->delete('admin_role_page_actions');
				
				if($rolePageActionquery)
				{
				
					return TRUE;	
				
				}else{
					
					return FALSE;
					
				}
				
			
			}
			
		}else{
			
			return FALSE;	
			
		}
		
	}
	
	public function get_role_actions($id=false)
	{
				
		if(!empty($id))
		{
			
			$this->db->where('actionID', $id);
			
			$query		=	$this->db->get('admin_role_actions')->row_array();
			
			return $query;
		
		}else{
		
			$query		=	$this->db->get('admin_role_actions')->result_array();
			
			return $query;
		
		}
				
	}
	
	public function get_admin_page_actions($id)
	{
		$this->db->select('admin_page_actions.*, admin_role_actions.*');
		
		$this->db->from('admin_page_actions');
		
		$this->db->join('admin_role_actions', 'admin_role_actions.actionID = admin_page_actions.actionID', 'left');
		
		$this->db->where('admin_page_actions.pageID', $id);
		
		$query 			= 	$this->db->get();
		
		return $query->result_array();
				
	}
	
	
	public function get_role_page_actions($id)
	{
		
		$this->db->where('roleID', $id);
		
		$query		=	$this->db->get('admin_role_page_actions');
		
		return $query->result_array();
		
	}
	
	//this function fetches a particular user role and the page supplied
	public function get_user_access_control($roleID)
	{

		$this->db->where('roleID', $roleID);
		
		$this->db->where('status', '1');
		
		$query					=	$this->db->get('admin_role')->row_array();
		
		if(!empty($query))
		{
			
			$this->db->where('roleID', $roleID);
						
			$pagequery							=	$this->db->get('admin_role_page_actions');
			
			if($pagequery->num_rows() > 0)
			{
				
				$pages							=	$pagequery->result_array();
				
				$pageActions					=	array();
				
				foreach($pages as $page)
				{
					
					$pageActions['rolePageActions'][$page['pageID']]['pageID']			=	$page['pageID'];
					
					$pageActions['rolePageActions'][$page['pageID']]['pageActions']		=	$page['pageActions'];
					
				}
				
				
				$result							=	array_merge($query, $pageActions);
			
				
				return $result;
			
			}else{
				
				return $query;
			
			}
			
		}else{
			
		
			return $query;
		
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


	// return particular admin details for editing
	function get_customer_details($id)
	{
		$result				= 	$this->db->get_where('user', array('userID'=>$id))->row_array();
		
		if(!$result)
		{
			return false;
		}

		return $result;
	}
	
	
	public function get_admin_notifications($seen=false)
	{
		
		$this->db->where('seen', '0');
							
		$this->db->order_by('dateCreated', 'DESC');
		
		$this->db->where('dateCreated BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND NOW()');
		
		$query 			= 	$this->db->get('admin_notification');
		
		if($query->num_rows() > 0)
		{
			if(!empty($seen))
			{
				
				$this->db->where('seen', '0');
				
				$this->db->update('admin_notification', array('seen' => $seen));
				
			}
			
			return $query->result_array();
			
		}else{
			
			return FALSE;
		
		}
		
	}
	
	function select_industry()
	{
		
		$this->db->order_by('industry', 'asc');
		
		$query 		= 	$this->db->get('industry');
		
		return $query->result_array();
		
	}

	function select_country()
	{
		
		$this->db->order_by('country_name', 'asc');
		
		$query 		= 	$this->db->get('country');
		
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
		
		$query 					= 	$this->db->get('state');
		
		return $query->result_array();
		
	}
	
	
	public function get_country_states_lga($stateID)
	{
		
		$this->db->where('state_id', $stateID);
				
		$query 					= 	$this->db->get('gc_country_zones_lga');
		
		return $query->result_array();
		
	}

	
	public function fetch_participant($program_id = null, $employee_id = null) 
    {
        
		$this->db->select('employee.*, grade.grade_level, location.location');
        
		$this->db->from('program_survey_participant');
        
		$this->db->join('employee', 'employee.employee_id = program_survey_participant.employee_id');
        
		$this->db->join('location', 'location.location_id = employee.location_id');
        
		$this->db->join('grade', 'grade.grade_id = employee.grade_id');
        
		$this->db->where('program_survey_participant.program_id', $program_id);
        
        if ($employee_id) {
        
		    $this->db->where('program_survey_participant.employee_id', $employee_id);
        
		}

        $query 			= 	$this->db->get();
        
		if ($employee_id) {
        
		    return $query->row_array();
        
		} else {
        
		    return $query->result_array();
        
		}
		
    }
	
	public function get_clients($clientID=false)
	{
		$response							=	array();
		
		if(!empty($clientID))
		{
			
			$this->db->where('client_id', $clientID);
			
			$query							=	$this->db->get('client');
			
			return $query->row_array();
		
		}else{
			
			$query						=	$this->db->get('client');
			
			$response					=	$query->result_array();
				
		}
		
		return $response;
		
	}
	
	public function get_users($userID=false, $companyID=false)
	{
		$response							=	array();
		
		if(!empty($userID))
		{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			$this->db->where('user_id', $userID);
			
			$query							=	$this->db->get('user');
			
			return $query->row_array();
		
		}else{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			$query						=	$this->db->get('user');
			
			$response					=	$query->result_array();
				
		}
		
		return $response;
		
	}
	
	public function get_coach($coachID=false, $companyID=false)
	{
		$response							=	array();
		
		if(!empty($coachID))
		{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			$this->db->where('coach_id', $coachID);
			
			$query							=	$this->db->get('coach');
			
			return $query->row_array();
		
		}else{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			$query						=	$this->db->get('coach');
			
			$response					=	$query->result_array();
				
		}
		
		return $response;
		
	}
	
	public function get_facilitator($facilitatorID=false, $companyID=false)
	{
		$response							=	array();
		
		if(!empty($facilitatorID))
		{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			$this->db->where('facilitator_id', $facilitatorID);
			
			$query							=	$this->db->get('facilitator');
			
			return $query->row_array();
		
		}else{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			$query						=	$this->db->get('facilitator');
			
			$response					=	$query->result_array();
				
		}
		
		return $response;
		
	}
	
	public function get_program($program_id=false, $companyID=false,$limit=0, $offset=0, $status=false)
	{
		$response		=	array();
		
		if(!empty($program_id))
		{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			$this->db->where('program_id', $program_id);
			
			$query									=	$this->db->get('program');
			
			$response['program']					=	$query->row_array();
			
			$response['program_owner']				=	$this->get_program_owner_id($program_id);
			
			$response['program_owner_details']		=	$this->get_program_owner_id_details($program_id);
			
			$response['program_participants']		=	$this->get_program_participants($program_id);
			
			$response['program_grade_levels']		=	$this->get_program_grade_level_details($program_id);

		
		}else{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			if(!empty($status))
			{
				
				if($status == 'Active')
				{
					
					$this->db->where('program_status', '1');
						
				}else{
					
					$this->db->where('program_status', '0');
					
				}
				
			}
			
			if($limit>0)
			{
				$this->db->limit($limit, $offset);
			}
			
			$this->db->order_by('date_created', 'DESC');
			
			$query						=	$this->db->get('program');
			
			$res						=	$query->result_array();
			
			$counter					=	0;
			
			foreach($res as $result)
			{
				
				$response[$counter]['program_id']				=	$result['program_id'];
				
				$response[$counter]['company_id']				=	$result['company_id'];
				
				$response[$counter]['program_name']				=	$result['program_name'];
				
				$response[$counter]['program_name_slug']		=	$result['program_name_slug'];
				
				$response[$counter]['grade_id']					=	$result['grade_id'];
				
				$response[$counter]['objectives']				=	$result['objectives'];
				
				$response[$counter]['success_measure']			=	$result['success_measure'];
				
				$response[$counter]['start_date']				=	$result['start_date'];
				
				$response[$counter]['end_date']					=	$result['end_date'];
				
				$response[$counter]['program_status']			=	$result['program_status'];
				
				$response[$counter]['modified_by_id']			=	$result['modified_by_id'];
				
				$response[$counter]['date_modified']			=	$result['date_modified'];
				
				$response[$counter]['created_by_id']			=	$result['created_by_id'];
				
				$response[$counter]['date_created']				=	$result['date_created'];
				
				$response[$counter]['program_owner_details']	=	$this->get_program_owner_id_details($result['program_id']);
				
				$response[$counter]['program_participants']		=	$this->get_program_participants($result['program_id']);
				
				$response[$counter]['program_grade_levels']		=	$this->get_program_grade_level_details($result['program_id']);
				
				$counter++;
				
			}
							
		}
		
		return $response;
		
	}
	
	public function save_program($save)
	{
		
		$slug_field							=	'program_name_slug';
		
		$table								=	'program';
		
		$id_field							=	'program_id';
		
		$save[$slug_field]					= 	$this->validate_slug($save[$slug_field], $slug_field, $table, $id_field, $save[$id_field]);
		
		if(!empty($save['program_id']))
		{
			
			$this->db->where('program_id', $save['program_id']);
			
			$query							=	$this->db->update('program', $save);
			
			$id 							= 	$save['program_id'];
			
		}else{
			
			
			$this->db->insert('program', $save);
			
			$id 							= 	$this->db->insert_id();	
			
			
		}
		
		
		if(!empty($save['program_id']))
		{
			
			$this->db->where('program_id', $save['program_id']);
			
			$actQuery			=	$this->db->get('program_grade');
			
			if($actQuery->num_rows() > 0)
			{
				
				$this->db->where('program_id', $save['program_id']);
				
				$this->db->delete('program_grade');
					
			}
			
			//check if the user provided new grades
			if(!empty($save['grade_id']))
			{
				
				$intr_array		= 	explode(',', $save['grade_id']);
				
				foreach($intr_array as $act=>$key)
				{
					$actionSave['program_id']		=	$id;
					
					$actionSave['grade_id']			=	$key;
					
					$this->db->insert('program_grade', $actionSave);	
					
				}
				
			}
		
		}else{
			
			if(!empty($save['grade_id']))
			{
				
				$intr_array		= 	explode(',', $save['grade_id']);
				
				foreach($intr_array as $act=>$key)
				{
					$actionSave['program_id']		=	$id;
					
					$actionSave['grade_id']			=	$key;
					
					$this->db->insert('program_grade', $actionSave);	
					
				}
				
			}
		
		}
		
		return $id;
		
		/*if(!empty($save['program_launched']))
		{
			
			//send out the emails for this program
			$this->send_participant_welcome_emails($id);	
			
			
		
		}else{
			
			return $id;
				
		}*/
		
	}
	
		
	public function get_company_grades($companyID)
	{
		
		$this->db->where('company_id', $companyID);
			
		$query		=	$this->db->get('grade');
		
		return $query->result_array();	
		
	}

	
	public function save_program_owner($save)
	{
		
		$this->db->where('program_id', $save['program_id']);
		
		$actQuery			=	$this->db->get('program_owner');
		
		if($actQuery->num_rows() > 0)
		{
			
			$this->db->where('program_id', $save['program_id']);
			
			$this->db->delete('program_owner');
				
		}
			
		if(!empty($save['owner_id']))
		{
			
			$intr_array		= 	explode(',', $save['owner_id']);
			
			$sizeOfOwner	=	sizeof($intr_array);
			
			$count			=	0;
			
			foreach($intr_array as $act=>$key)
			{
				$actionSave['program_id']		=	$save['program_id'];
				
				$actionSave['company_id']		=	$save['company_id'];
				
				$actionSave['owner_id']			=	$key;
				
				$this->db->insert('program_owner', $actionSave);	
				
				
				$count++;
			}
			
			
			if($count == $sizeOfOwner)
			{
				
				return TRUE;
				
			}else{
				
				return FALSE;	
			
			}
			
			
		}else{
			
			return FALSE;
				
		}
			
	}
	
	public function get_owner($ownerID=false, $companyID=false)
	{
	
		if(!empty($ownerID))
		{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			$this->db->where('owner_id', $ownerID);
			
			$query							=	$this->db->get('owner');
			
			return $query->row_array();
		
		}else{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			$query							=	$this->db->get('owner');
			
			return $query->result_array();
			
		}
		
			
	}
	
	//this function was created to enable dashboard stats
	public function get_program_owners($ownerID=false, $companyID=false)
	{
		$response							=	array();
		
		if(!empty($ownerID))
		{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			$this->db->where('program_owner_id', $ownerID);
			
			$query							=	$this->db->get('program_owner');
			
			return $query->row_array();
		
		}else{
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);
				
			}
			
			$query						=	$this->db->get('program_owner');
			
			$response					=	$query->result_array();
				
		}
		
		return $response;
		
	}
	
	function get_program_owner_id($program_id)
	{
		
		$response			=	array();
		
		$this->db->select('owner_id');
		
		$this->db->where('program_id', $program_id);
		
		$query				=	$this->db->get('program_owner');
		
		$res				= 	$query->result_array();	
		
		$count				=	0;
		
		foreach($res as $result)
		{
			
			$response[$count]		=	$result['owner_id'];
			
			$count++;
			
		}
		
		return $response;
		
	}
	
	function get_program_owner_id_details($program_id)
	{
				
		$this->db->where('program_id', $program_id);
		
		$this->db->select('program_owner.*, owner.*');
		
		$this->db->from('program_owner');

		$this->db->join('owner', 'owner.owner_id = program_owner.owner_id', 'left');
	
		$query				=	$this->db->get();
		
		return $query->result_array();	
		
	}
	
	function get_standard_competency_questions()
	{
		
		$response									=	array();
				
		$this->db->where('is_standard', '1');
		
		$query										=	$this->db->get('competency');
		
		$res										= 	$query->result_array();	
		
		$count										=	0;
		
		foreach($res as $result)
		{
			
			$response[$count]['competency_id']		=	$result['competency_id'];
			
			$response[$count]['competency']			=	$result['competency'];
			
			$response[$count]['is_standard']		=	$result['is_standard'];
			
			$response[$count]['date_created']		=	$result['date_created'];
			
			$response[$count]['modified_by_id']		=	$result['modified_by_id'];
			
			$response[$count]['date_modified']		=	$result['date_modified'];
			
			$response[$count]['created_by_id']		=	$result['created_by_id'];
			
			$response[$count]['questions']			=	$this->get_compentency_questions($result['competency_id']);
			
			$count++;

		}
		
		return $response;
		
	}
	
	function get_optional_competency_questions()
	{
		
		$response									=	array();
				
		$this->db->where('is_standard', '0');
		
		$query										=	$this->db->get('competency');
		
		$res										= 	$query->result_array();	
		
		$count										=	0;
		
		foreach($res as $result)
		{
			
			$response[$count]['competency_id']		=	$result['competency_id'];
			
			$response[$count]['competency']			=	$result['competency'];
			
			$response[$count]['is_standard']		=	$result['is_standard'];
			
			$response[$count]['date_created']		=	$result['date_created'];
			
			$response[$count]['modified_by_id']		=	$result['modified_by_id'];
			
			$response[$count]['date_modified']		=	$result['date_modified'];
			
			$response[$count]['created_by_id']		=	$result['created_by_id'];
			
			$response[$count]['questions']			=	$this->get_compentency_questions($result['competency_id']);
			
			$count++;

		}
		
		return $response;
		
	}
	
	function get_compentency_questions($competencyID)
	{
		
		$this->db->where('competency_id', $competencyID);
		
		$query				=	$this->db->get('question_template');	
		
		return $query->result_array();
		
	}
	
	function get_question_details($questionID)
	{
		
		$this->db->where('question_template_id', $questionID);
		
		$query				=	$this->db->get('question_template');	
		
		return $query->row_array();
		
	}
	
	function save_program_survey($save)
	{
			
		
	}
	
	function save_competency_questions($save)
	{
		
		$querySuccess				=	'True';
		
		$programID					=	$save['program_id'];
		
		$survey_id					=	'';
		
		$company_id					=	$save['company_id'];
		
		$created_by_id				=	$save['created_by_id'];
		
		$survey_ref					=	strtotime(date('Y-m-d H:i:s'));
		
		$standard_competency		=	$save['standard_competency'];
		
		$optional_competency		=	$save['optional_competency'];
		
		$data 						= 	array(
								
			'360_assessment_competency_survey_ref' 		=> 	$survey_ref
		);
		
		$this->session->set_userdata($data);
		
		if(!empty($standard_competency))
		{
			
			$standard_array			= 	explode(',',$standard_competency);
			
			$sizeOfStandard			=	sizeof($standard_array);
			
			$standardcount			=	0;
			
			foreach($standard_array as $act=>$key)
			{
				if(!empty($key))
				{
						
					$saveStandardCompetency['company_id']		=	$company_id;
					
					$saveStandardCompetency['program_id']		=	$programID;
					
					$saveStandardCompetency['survey_id']		=	$survey_id;
					
					$saveStandardCompetency['survey_ref']		=	$survey_ref;
					
					$saveStandardCompetency['competency_id']	=	$key;
					
					$saveStandardCompetency['created_by_id']	=	$created_by_id;
					
					$standardQuery								=	$this->db->insert('program_survey_competency', $saveStandardCompetency);
					
					$standardQuerySurveyCompetencyID			=	$this->db->insert_id();	
					
					if($standardQuery)
					{
						//now get the questions belonging to this standard competency and insert it into the program_survey_question	
						$standard_questions						=	$this->get_compentency_questions($key);
						
						if(!empty($standard_questions))
						{
							
							foreach($standard_questions as $standard_question)
							{
								
								$saveStandardCompetencyQuestion['company_id']				=	$company_id;	
								
								$saveStandardCompetencyQuestion['program_id']				=	$programID;	
								
								$saveStandardCompetencyQuestion['survey_id']				=	$survey_id;
								
								$saveStandardCompetencyQuestion['survey_ref']				=	$survey_ref;
								
								$saveStandardCompetencyQuestion['survey_competency_id']		=	$standardQuerySurveyCompetencyID;
								
								$saveStandardCompetencyQuestion['question_template_id']		=	$standard_question['question_template_id'];
															
								$saveStandardCompetencyQuestion['question']					=	$standard_question['question'];
								
								$saveStandardCompetencyQuestion['is_approved']				=	1;
								
								$saveStandardCompetencyQuestion['created_by_id']			=	$created_by_id;
								
								$this->db->insert('program_survey_question', $saveStandardCompetencyQuestion);
								
							}
							
						}
						
					}
					
					$standardcount++;
				
				}
				
			}
			
			if($standardcount == $sizeOfStandard)
			{
				
				$querySuccess				=	'True';
				
			}else{
				
				$querySuccess				=	'False';
			
			}
			
			
		}else{
			
			$querySuccess				=	'True';
				
		}	
		
		
		//for optional competency
		if(!empty($optional_competency))
		{
			
			$optional_array			= 	explode(',',$optional_competency);
			
			$sizeOfOptional			=	sizeof($optional_array);
			
			$optionalcount			=	0;
			
			foreach($optional_array as $acts=>$keys)
			{
				
				//for this get the questions details first
				$optional_questions									=	$this->get_question_details($keys);
				
				if(!empty($optional_questions))
				{
					
					//first check if the competency id this question belongs to can be found in the program_survey_competency table
					
					$this->db->where('competency_id', $optional_questions['competency_id']);
					
					$this->db->where('program_id', $programID);
					
					$this->db->where('company_id', $company_id);
					
					$checkCompetencyExist							=	$this->db->get('program_survey_competency');
					
					if($checkCompetencyExist->num_rows() > 0)
					{
						//it means this competency has been saved in this table previously
						//just returnt the survey_competency_id
						$survey_competency							=	$checkCompetencyExist->row_array();
						
						$survey_competency_id						=	$survey_competency['survey_competency_id'];
						
					}else{
						
						//do the insert of the competency and get the id	
						$saveOptionalCompetency['company_id']		=	$company_id;
						
						$saveOptionalCompetency['program_id']		=	$programID;
						
						$saveOptionalCompetency['survey_id']		=	$survey_id;
						
						$saveOptionalCompetency['survey_ref']		=	$survey_ref;
						
						$saveOptionalCompetency['competency_id']	=	$optional_questions['competency_id'];
						
						$saveOptionalCompetency['created_by_id']	=	$created_by_id;
						
						$this->db->insert('program_survey_competency', $saveOptionalCompetency);
						
						$survey_competency_id						=	$this->db->insert_id();
						
					}
					
					
					$saveOptionalCompetencyQuestion['company_id']				=	$company_id;	
								
					$saveOptionalCompetencyQuestion['program_id']				=	$programID;	
					
					$saveOptionalCompetencyQuestion['survey_id']				=	$survey_id;
					
					$saveOptionalCompetencyQuestion['survey_ref']				=	$survey_ref;
					
					$saveOptionalCompetencyQuestion['survey_competency_id']		=	$survey_competency_id;
					
					$saveOptionalCompetencyQuestion['question_template_id']		=	$optional_questions['question_template_id'];
												
					$saveOptionalCompetencyQuestion['question']					=	$optional_questions['question'];
					
					$saveOptionalCompetencyQuestion['is_approved']				=	1;
					
					$saveOptionalCompetencyQuestion['created_by_id']			=	$created_by_id;
					
					$this->db->insert('program_survey_question', $saveOptionalCompetencyQuestion);
				
				}

				$optionalcount++;
				
			}
			
			if($optionalcount == $sizeOfOptional)
			{
				
				$querySuccess				=	'True';
				
			}else{
				
				$querySuccess				=	'False';
			
			}
			
			
		}else{
			
			$querySuccess				=	'True';
				
		}
		
		
		if($querySuccess == 'True')
		{
			
			return TRUE;
				
		}else{
			
			return FALSE;
				
		}
		
	}
	
	function get_selected_competency_questions($programID)
	{
		
		$response		=	array();
		
		$this->db->where('program_id', $programID);
			
		$query			=	$this->db->get('program_survey_competency');
		
		if($query->num_rows() > 0)
		{
			
			$result		=	$query->result_array();
			
			foreach($result as $res)
			{
				
				
				$response[$res['survey_competency_id']]['survey_competency_id']		=	$res['survey_competency_id'];
				
				$response[$res['survey_competency_id']]['company_id']				=	$res['company_id'];
				
				$response[$res['survey_competency_id']]['program_id']				=	$res['program_id'];
				
				$response[$res['survey_competency_id']]['survey_id']				=	$res['survey_id'];
				
				$response[$res['survey_competency_id']]['competency_id']			=	$res['competency_id'];
				
				$response[$res['survey_competency_id']]['custom_competency']		=	$res['custom_competency'];
				
				$response[$res['survey_competency_id']]['created_by_id']			=	$res['created_by_id'];
				
				$response[$res['survey_competency_id']]['date_created']				=	$res['date_created'];
				
				$response[$res['survey_competency_id']]['is_standard']				=	$this->check_competency_is_standard($res['competency_id']);
				
				$response[$res['survey_competency_id']]['questions']				=	$this->get_program_survey_competency_questions($res['survey_competency_id']);
				
			}
			
		}
		
		return $response;
	}
	
	public function check_competency_is_standard($competencyID)
	{
		
		$this->db->where('competency_id', $competencyID);	
		
		$query				=	$this->db->get('competency');
		
		if($query->num_rows() > 0)
		{
			
			foreach($query->result() as $row)
			{
				
				return $row->is_standard;	
			
			}
			
		}
		
	}
	
	public function get_program_survey_competency_questions($surveyCompetencyID)
	{
		
		$this->db->where('survey_competency_id', $surveyCompetencyID);	
		
		$query		=	$this->db->get('program_survey_question');
		
		if($query->num_rows() > 0)
		{
			
			return $query->result_array();
			
		}else{
			
			return FALSE;
				
		}
		
	}
	
	function save_custom_competency_questions($save, $questions)
	{
		
		if($questions !== false)
		{
			
			$survey_ref					=	strtotime(date('Y-m-d H:i:s'));
			
			$data 						= 	array(
									
				'360_assessment_custom_competency_survey_ref' 		=> 	$survey_ref
			);
			
			$this->session->set_userdata($data);

			// wipe the slate
			$this->clear_custom_competency_questions($save['program_id']);

			// save edited values
			$count 							= 	0;
			
			$sizeCustom						=	sizeof($questions);
			
			foreach($questions as $question)
			{
				
				$saveCustomCompetencyQuestion['company_id']				=	$save['company_id'];	
								
				$saveCustomCompetencyQuestion['program_id']				=	$save['program_id'];
				
				$saveCustomCompetencyQuestion['survey_ref']				=	$survey_ref;	
																							
				$saveCustomCompetencyQuestion['question']				=	$question['question'];
				
				$saveCustomCompetencyQuestion['is_approved']			=	1;
				
				$saveCustomCompetencyQuestion['created_by_id']			=	$save['created_by_id'];
				
				$this->db->insert('program_survey_question', $saveCustomCompetencyQuestion);
				
				$count++;
						
			}
			
			if($count == $sizeCustom)
			{
				
				return TRUE;
				
			}else{
				
				return FALSE;
			
			}
			
		}
		
	}
	
	// for custom competency questions 
	function clear_custom_competency_questions($programID)
	{
		// get the list of options for this product
		
		$this->db->where('program_id', $programID);
				
		$this->db->where('survey_competency_id', NULL, FALSE);
		
		$list 			= 	$this->db->get('program_survey_question')->result();
		
		foreach($list as $opt)
		{
		
			$this->delete_custom_competency_question($opt->survey_question_id);
		
		}
		
	}
	
	// also deletes child records in option_values and product_option
	function delete_custom_competency_question($id)
	{
		$this->db->where('survey_question_id', $id);
		
		$this->db->delete('program_survey_question');
		
	}
	
	function get_program_custom_competency_questions($programID)
	{
		
		$this->db->where('program_id', $programID);
				
		$this->db->where('survey_competency_id', NULL, FALSE);
		
		$result						= 	$this->db->get('program_survey_question');
		
		$return 					= 	array();
		
		foreach($result->result() as $option)
		{
						
			$return[]	= $option;
		
		}

		return $return;
	}
	
	function get_message_template($id)
	{
		$res 			= 	$this->db->where('id', $id)->get('email_messages');
		
		return $res->row_array();
		
	}
	
	function save_message_template($data)
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
	
	function delete_message_template($id)
	{
		$this->db->where('id', $id)->delete('email_messages');
		
		return $id;
	}
	
	
	function get_survey_type($programID, $surveyType, $companyID=false)
	{
		
		if(!empty($companyID))
		{
			
			$this->db->where('company_id', $companyID);
			
		}
		
		$this->db->where('program_id', $programID);
		
		$this->db->where('survey_type', $surveyType);
		
		$query		=	$this->db->get('program_survey');
		
		if($query->num_rows() > 0)
		{
			
			$result								=	$query->row_array();
			
			$response['survey']					=	$result;
			
			$response['communication']			=	$this->get_program_survey_communication($result['survey_id']);
			
			$response['schedule']				=	$this->get_program_survey_schedule($result['survey_id']);
			
			return $response;
			
		}else{
			
			return FALSE;
		}
		
		
	}
	
	function save_leadership_assessment($save, $communication, $schedule, $participant)
	{
		
		$slug_field							=	'survey_slug';
		
		$table								=	'program_survey';
		
		$id_field							=	'survey_id';
		
		$save[$slug_field]					= 	$this->validate_slug($save[$slug_field], $slug_field, $table, $id_field, $save[$id_field]);
		
		if(!empty($save['survey_id']))
		{
			//its an edit	
			
			$this->db->where('survey_id', $save['survey_id']);
			
			$query							=	$this->db->update('program_survey', $save);
			
			if($query)
			{
				
				//now insert all the communications
				$saveCommunication			=	$this->save_program_communication($communication, $save['survey_id']);
				
				
				if($saveCommunication)
				{
					
					$saveSchedule			=	$this->save_program_survey_schedule($schedule, $save['survey_id']);
					
					if($saveSchedule)
					{
						
						//now check if the participant value is not empty
						if(!empty($participant))
						{
							
							$handleParticipant		=	$this->move_participant_temp_to_live($participant, $save['survey_id']);
							
							if($handleParticipant)
							{
								
								$this->update_competency_survey_ref($save['survey_id']);
								
								return TRUE;
								
							}else{
								
								return FALSE;
									
							}
							 
						}else{
							
							$this->update_competency_survey_ref($save['survey_id']);
							
							return TRUE;	
							
						}
						
					}else{
						
						return FALSE;
						
					}
			
				}else{
					
					return FALSE;
						
				}
				
			}else{
				
				return FALSE;
					
			}
			
		}else{
			
			//its a new record
			
			$query							=	$this->db->insert('program_survey', $save);
			
			$survey_id						=	$this->db->insert_id();
			
			if($query)
			{
				
				//now insert all the communications
				$saveCommunication			=	$this->save_program_communication($communication, $survey_id);
								
				if($saveCommunication)
				{
					
					$saveSchedule					=	$this->save_program_survey_schedule($schedule, $survey_id);
					
					if($saveSchedule)
					{
						//now check if the participant value is not empty
						if(!empty($participant))
						{
							
							$handleParticipant		=	$this->move_participant_temp_to_live($participant, $survey_id);
							
							if($handleParticipant)
							{
								
								$this->update_competency_survey_ref($survey_id);
								
								return TRUE;
								
							}else{
								
								return FALSE;
									
							}
							 
						}else{
							
							$this->update_competency_survey_ref($survey_id);
							
							return TRUE;	
							
						}
						
					}else{
						
						return FALSE;
						
					}	
			
				}else{
					
					return FALSE;
						
				}
				
			}else{
				
				return FALSE;
					
			}
			
		}
		
	}
	
	
	function update_competency_survey_ref($surveyID)
	{
		
		$competency_survey_ref				=	$this->session->userdata('360_assessment_competency_survey_ref');
		
		$custom_competency_survey_ref		=	$this->session->userdata('360_assessment_custom_competency_survey_ref');
		
		//check if the competency survey ref is empty
		if(!empty($competency_survey_ref))
		{
			//means its not empty so update the program survey competency with the survey id
			
			$this->db->where('survey_ref', $competency_survey_ref);
			
			$this->db->update('program_survey_competency', array('survey_id'=> $surveyID));
			
			
			//update the program survey competency questions with the survey id
			$this->db->where('survey_ref', $competency_survey_ref);
			
			$this->db->update('program_survey_question', array('survey_id'=> $surveyID));
			
			$this->session->unset_userdata('360_assessment_competency_survey_ref');
			
		}
		
		if(!empty($custom_competency_survey_ref))
		{
			
			//update the program survey competency questions with the survey id
			$this->db->where('survey_ref', $custom_competency_survey_ref);
			
			$this->db->update('program_survey_question', array('survey_id'=> $surveyID));
			
			$this->session->unset_userdata('360_assessment_custom_competency_survey_ref');
			
		}
		
		return TRUE;	
		
	}
	
	
	function get_program_survey_schedule($surveyID)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		$query				=	$this->db->get('program_survey_schedule');
		
		return $query->row_array();
		
	}
	
	function save_program_survey_schedule($schedule, $surveyID)
	{
		
		$schedule['survey_id']		=	$surveyID;
		
		if(!empty($schedule['survey_schedule_id']))
		{
			
			$this->db->where('survey_schedule_id', $schedule['survey_schedule_id']);
			
			$query		=	$this->db->update('program_survey_schedule', $schedule);
			
			if($query)
			{
				return TRUE;
				
			}else{
				
				return FALSE;
				
			}	
			
		}else{
			
			$query		=	$this->db->insert('program_survey_schedule', $schedule);
			
			if($query)
			{
				return TRUE;
				
			}else{
				
				return FALSE;
				
			}	
			
		}
		
	}
	
	function get_program_survey_communication($surveyID)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		$query				=	$this->db->get('program_survey_communication');
		
		return $query->result_array();
		
	}
	
	function save_program_communication($communication, $survey_id)
	{
		//first perform a check so we dont have multiple records
		
		$this->db->where('survey_id', $survey_id);
		
		$checkQuery					=	$this->db->get('program_survey_communication');
		
		if($checkQuery->num_rows() > 0)
		{
			//there are existing records here previously do an update
			$count						=	0;
			
			foreach($communication as $comm)
			{
				
				$this->db->where('survey_id', $survey_id);
				
				$this->db->where('subject', $comm['subject']);
								
				$query					=	$this->db->update('program_survey_communication', $comm);
			
				if($query)
				{
					
					$count++;
						
				}else{
						
					
				}
			
			}
			
			if($count == '4')
			{
				
				return TRUE;
					
			}else{
				
				return FALSE;
				
			}
			
		}else{
		
			//no record found so do the insert
			
			$count						=	0;
			
			foreach($communication as $comm)
			{
				
				$comm['survey_id']		=	$survey_id;
				
				$query					=	$this->db->insert('program_survey_communication', $comm);
			
				if($query)
				{
					
					$count++;
						
				}else{
						
					
				}
			
			}
			
			if($count == '4')
			{
				
				return TRUE;
					
			}else{
				
				return FALSE;
				
			}
		
		}
		
	}
	
	function upload_participants($participants)
	{
						
  		/*$query			=	$this->db->insert_batch('program_survey_participant_temp', $participant);	
		
		if($query)
		{
			return TRUE;
			
		}else{
			
			return FALSE;
				
		}*/
		
		$response							=	array();
		
		$sizofParticipant					=	sizeof($participants);
		
		$count								=	0;
		
		foreach($participants as $res)
		{
			
			//get all the variables into an array to hold
			
			$participant['company_id']  						= 	$res['company_id'];
			
			$participant['created_by_id']  						= 	$res['created_by_id'];
			
			$participant['upload_ref']  						= 	$res['upload_ref'];
			
			$participant['program_id']  						= 	$res['program_id'];
											
			$participant['department']  						= 	$res['department'];
			
			$participant['location']   							= 	$res['location'];
			
			$participant['grade']   							= 	$res['grade'];
			
			$participant['date_of_birth'] 						= 	$res['date_of_birth'];
			
			$participant['gender']   							= 	$res['gender'];
								
			$participant['employment_date']						=	$res['employment_date'];
			
			$participant['status']								=	$res['status'];
			
			$participant['employee_number']						=	$res['employee_number'];
			
			$participant['first_name']							=	$res['first_name'];
			
			$participant['last_name']							=	$res['last_name'];
			
			$participant['email']								=	$res['email'];
			
			$participant['phone_number']						=	$res['phone_number'];
			
			$participant['line_manager_employee_number']		=	$res['line_manager_employee_number'];
			
			$participant['line_manager_name']					=	$res['line_manager_name'];
										
			$participant['line_manager_email']					=	$res['line_manager_email'];
		
			$participant['line_manager_phone_number']			=	$res['line_manager_phone_number'];
		
			$participant['peer_1_employee_number']				=	$res['peer_1_employee_number'];	
		
			$participant['peer_1_name']							=	$res['peer_1_name'];
		
			$participant['peer_1_email']						=	$res['peer_1_email'];
		
			$participant['peer_1_phone_number']					=	$res['peer_1_phone_number'];				
		
			$participant['peer_2_employee_number']				=	$res['peer_2_employee_number'];				
		
			$participant['peer_2_name']							=	$res['peer_2_name'];						
		
			$participant['peer_2_email']						=	$res['peer_2_email'];						
		
			$participant['peer_2_phone_number']					=	$res['peer_2_phone_number'];				
		
			$participant['direct_report_1_employee_number']		=	$res['direct_report_1_employee_number']	;
		
			$participant['direct_report_1_name']				=	$res['direct_report_1_name'];			
		
			$participant['direct_report_1_email']				=	$res['direct_report_1_email'];			
		
			$participant['direct_report_1_phone_number']		=	$res['direct_report_1_phone_number'];		
			
			$participant['direct_report_2_employee_number']		=	$res['direct_report_2_employee_number'];	
			
			$participant['direct_report_2_name']				=	$res['direct_report_2_name'];				
			
			$participant['direct_report_2_email']				=	$res['direct_report_2_email'];		
			
			$participant['direct_report_2_phone_number']		=	$res['direct_report_2_phone_number'];		
			
			$participant['direct_report_3_employee_number']		=	$res['direct_report_3_employee_number'];	
			
			$participant['direct_report_3_name']				=	$res['direct_report_3_name'];				
			
			$participant['direct_report_3_email']				=	$res['direct_report_3_email'];			
			
			$participant['direct_report_3_phone_number']		=	$res['direct_report_3_phone_number'];	
					
			//first check if the department exist for this particular company
			$department											=	$this->get_department_by_name($res['department'], $res['company_id']);
			
			if(!empty($department))
			{
				
				$participant['department_id']					=	$department['department_id'];
				
			}else{
				
				$response['status']								=	'Failed';
				
				$response['reason']								=	'Department <strong>('.$res['department'].')</strong> cannot be found for this company';
				
				return $response;
				
			}
			
			//first check if the location exist for this particular company
			$location											=	$this->get_location_by_name($res['location'], $res['company_id']);
			
			//get the location details
			if(!empty($location))
			{
				
				$participant['location_id']						=	$location['location_id'];
				
			}else{
				
				$response['status']								=	'Failed';
				
				$response['reason']								=	'Location <strong>('.$res['location'].')</strong> cannot be found for this company';
				
				return $response;
				
			}
			
			//first check if the grade exist for this particular company
			$grade												=	$this->get_grade_by_name($res['grade'], $res['company_id']);
			
			//get the grade details
			if(!empty($grade))
			{
				
				$participant['grade_id']						=	$grade['grade_id'];
				
			}else{
				
				$response['status']								=	'Failed';
				
				$response['reason']								=	'Grade <strong>('.$res['grade'].')</strong> cannot be found for this company';
				
				return $response;
				
			}
			
			//now perform the insert if it meets all the criterias
			$query												=	$this->db->insert('program_survey_participant_temp', $participant);	
			
			if($query)
			{
				
				$count++;
					
			}else{
				
				$response['status']								=	'Failed';
				
				$response['reason']								=	'There was a problem uploading the profile of participant <strong>('.$res['first_name'].' '.$res['last_name'].')</strong>';
				
				return $response;
					
			}
			
		}
		
		if($sizofParticipant == $count)
		{
			
			$response['status']								=	'Success';
				
			$response['reason']								=	'Participants successfully uploaded';
			
		}else{
			
			$response['status']								=	'Failed';
				
			$response['reason']								=	'There was a problem uploading all records';
				
		}
		
		return $response;
			
	}
	
	function move_participant_temp_to_live($ref, $surveyID)
	{
		
		$this->db->where('upload_ref', $ref);
		
		$query				=	$this->db->get('program_survey_participant_temp');
		
		if($query->num_rows() > 0)
		{
			
			$result			=	$query->result_array();
			
			foreach($result as $res)
			{
				
				//get all the variables into an array to hold
				
				$participant['company_id']  						= 	$res['company_id'];
				
				$participant['created_by_id']  						= 	$res['created_by_id'];
				
				$participant['upload_ref']  						= 	$res['upload_ref'];
				
				$participant['program_id']  						= 	$res['program_id'];
				
				$participant['survey_id']  							= 	$surveyID;
												
				$participant['department_id']  						= 	$res['department_id'];
				
				$participant['location_id']   						= 	$res['location_id'];
				
				$participant['grade_id']   							= 	$res['grade_id'];
				
				$participant['date_of_birth'] 						= 	$res['date_of_birth'];
				
				$participant['gender']   							= 	$res['gender'];
									
				$participant['employment_date']						=	$res['employment_date'];
				
				$participant['status']								=	$res['status'];
				
				$participant['employee_number']						=	$res['employee_number'];
				
				$participant['first_name']							=	$res['first_name'];
				
				$participant['last_name']							=	$res['last_name'];
				
				$participant['email']								=	$res['email'];
				
				$participant['phone_number']						=	$res['phone_number'];
				
				$participant['line_manager_employee_number']		=	$res['line_manager_employee_number'];
				
				$participant['line_manager_name']					=	$res['line_manager_name'];
											
				$participant['line_manager_email']					=	$res['line_manager_email'];
			
				$participant['line_manager_phone_number']			=	$res['line_manager_phone_number'];
			
				$participant['peer_1_employee_number']				=	$res['peer_1_employee_number'];	
			
				$participant['peer_1_name']							=	$res['peer_1_name'];
			
				$participant['peer_1_email']						=	$res['peer_1_email'];
			
				$participant['peer_1_phone_number']					=	$res['peer_1_phone_number'];				
			
				$participant['peer_2_employee_number']				=	$res['peer_2_employee_number'];				
			
				$participant['peer_2_name']							=	$res['peer_2_name'];						
			
				$participant['peer_2_email']						=	$res['peer_2_email'];						
			
				$participant['peer_2_phone_number']					=	$res['peer_2_phone_number'];				
			
				$participant['direct_report_1_employee_number']		=	$res['direct_report_1_employee_number'];
			
				$participant['direct_report_1_name']				=	$res['direct_report_1_name'];			
			
				$participant['direct_report_1_email']				=	$res['direct_report_1_email'];			
			
				$participant['direct_report_1_phone_number']		=	$res['direct_report_1_phone_number'];		
				
				$participant['direct_report_2_employee_number']		=	$res['direct_report_2_employee_number'];	
				
				$participant['direct_report_2_name']				=	$res['direct_report_2_name'];				
				
				$participant['direct_report_2_email']				=	$res['direct_report_2_email'];		
				
				$participant['direct_report_2_phone_number']		=	$res['direct_report_2_phone_number'];		
				
				$participant['direct_report_3_employee_number']		=	$res['direct_report_3_employee_number'];	
				
				$participant['direct_report_3_name']				=	$res['direct_report_3_name'];				
				
				$participant['direct_report_3_email']				=	$res['direct_report_3_email'];			
				
				$participant['direct_report_3_phone_number']		=	$res['direct_report_3_phone_number'];
									
				
				//now check if this participant has been added to the user table previously
				
				$userDetails['company_id']							=	$res['company_id'];
				
				$userDetails['phone_number']						=	$res['phone_number'];
				
				$userDetails['first_name']							=	$res['first_name'];
				
				$userDetails['last_name']							=	$res['last_name'];
				
				$userDetails['email']								=	$res['email'];
				
				$userDetails['created_by_id']						=	$res['created_by_id'];
				
				//assign the id to the participant row
				$participant['user_id']								=	$this->add_participant_to_user_table($userDetails);	
				
				//perform a check on this particular participant if he/she has been uploaded for this same survey under this program
				
				$this->db->where('survey_id', $surveyID);
				
				$this->db->where('program_id', $res['program_id']);
				
				$this->db->where('user_id', $participant['user_id']);
				
				$doublecheck										=	$this->db->get('program_survey_participant');
				
				if($doublecheck->num_rows() > 0)
				{
					
					//it means this user record exist for this particular survey before
					//either update it or leave it blank
					
					
					
				}else{
				
					//now insert all the participant into the program_survey_participant table
					$insertQuery										=	$this->db->insert('program_survey_participant', $participant);
					
					$survey_participant_id								=	$this->db->insert_id();
					
					if($insertQuery)
					{
						
						//insert all the other records into the surveyor table
						$surveryor[0]['company_id']						=	$res['company_id'];
						
						$surveryor[0]['program_id']						=	$res['program_id'];
						
						$surveryor[0]['survey_id']						=	$surveyID;
						
						$surveryor[0]['survey_participant_id']			=	$survey_participant_id;
						
						$surveryor[0]['employee_number']				=	$res['employee_number'];
						
						$surveryor[0]['relationship']					=	'Self';
						
						$surveryor[0]['relationship_index']				=	'0';
						
						$surveryor[0]['name']							=	$res['first_name'].' '.$res['last_name'];
						
						$surveryor[0]['email']							=	$res['email'];
						
						$surveryor[0]['phone_number']					=	$res['phone_number'];
						
						$surveryor[0]['created_by_id']					=	$res['created_by_id'];
						
						
						//insert all the other records into the surveyor table
						$surveryor[1]['company_id']						=	$res['company_id'];
						
						$surveryor[1]['program_id']						=	$res['program_id'];
						
						$surveryor[1]['survey_id']						=	$surveyID;
						
						$surveryor[1]['survey_participant_id']			=	$survey_participant_id;
						
						$surveryor[1]['employee_number']				=	$res['line_manager_employee_number'];
						
						$surveryor[1]['relationship']					=	'Line Manager';
						
						$surveryor[1]['relationship_index']				=	'1';
						
						$surveryor[1]['name']							=	$res['line_manager_name'];
						
						$surveryor[1]['email']							=	$res['line_manager_email'];
						
						$surveryor[1]['phone_number']					=	$res['line_manager_phone_number'];
						
						$surveryor[1]['created_by_id']					=	$res['created_by_id'];
						
						
						//this is for peer 1
						$surveryor[2]['company_id']						=	$res['company_id'];
						
						$surveryor[2]['program_id']						=	$res['program_id'];
						
						$surveryor[2]['survey_id']						=	$surveyID;
						
						$surveryor[2]['survey_participant_id']			=	$survey_participant_id;
						
						$surveryor[2]['employee_number']				=	$res['peer_1_employee_number'];
						
						$surveryor[2]['relationship']					=	'Peer';
						
						$surveryor[2]['relationship_index']				=	'1';
						
						$surveryor[2]['name']							=	$res['peer_1_name'];
						
						$surveryor[2]['email']							=	$res['peer_1_email'];
						
						$surveryor[2]['phone_number']					=	$res['peer_1_phone_number'];
						
						$surveryor[2]['created_by_id']					=	$res['created_by_id'];
						
						
						//this is for peer 2
						$surveryor[3]['company_id']						=	$res['company_id'];
						
						$surveryor[3]['program_id']						=	$res['program_id'];
						
						$surveryor[3]['survey_id']						=	$surveyID;
						
						$surveryor[3]['survey_participant_id']			=	$survey_participant_id;
						
						$surveryor[3]['employee_number']				=	$res['peer_2_employee_number'];
						
						$surveryor[3]['relationship']					=	'Peer';
						
						$surveryor[3]['relationship_index']				=	'2';
						
						$surveryor[3]['name']							=	$res['peer_2_name'];
						
						$surveryor[3]['email']							=	$res['peer_2_email'];
						
						$surveryor[3]['phone_number']					=	$res['peer_2_phone_number'];
						
						$surveryor[3]['created_by_id']					=	$res['created_by_id'];
						
						
						//this is for direct report1
						$surveryor[4]['company_id']						=	$res['company_id'];
						
						$surveryor[4]['program_id']						=	$res['program_id'];
						
						$surveryor[4]['survey_id']						=	$surveyID;
						
						$surveryor[4]['survey_participant_id']			=	$survey_participant_id;
						
						$surveryor[4]['employee_number']				=	$res['direct_report_1_employee_number'];
						
						$surveryor[4]['relationship']					=	'Direct Report';
						
						$surveryor[4]['relationship_index']				=	'1';
						
						$surveryor[4]['name']							=	$res['direct_report_1_name'];
						
						$surveryor[4]['email']							=	$res['direct_report_1_email'];
						
						$surveryor[4]['phone_number']					=	$res['direct_report_1_phone_number'];
						
						$surveryor[4]['created_by_id']					=	$res['created_by_id'];
						
						
						//this is for direct report2
						$surveryor[5]['company_id']						=	$res['company_id'];
						
						$surveryor[5]['program_id']						=	$res['program_id'];
						
						$surveryor[5]['survey_id']						=	$surveyID;
						
						$surveryor[5]['survey_participant_id']			=	$survey_participant_id;
						
						$surveryor[5]['employee_number']				=	$res['direct_report_2_employee_number'];
						
						$surveryor[5]['relationship']					=	'Direct Report';
						
						$surveryor[5]['relationship_index']				=	'2';
						
						$surveryor[5]['name']							=	$res['direct_report_2_name'];
						
						$surveryor[5]['email']							=	$res['direct_report_2_email'];
						
						$surveryor[5]['phone_number']					=	$res['direct_report_2_phone_number'];
						
						$surveryor[5]['created_by_id']					=	$res['created_by_id'];
						
						
						//this is for direct report3
						$surveryor[6]['company_id']						=	$res['company_id'];
						
						$surveryor[6]['program_id']						=	$res['program_id'];
						
						$surveryor[6]['survey_id']						=	$surveyID;
						
						$surveryor[6]['survey_participant_id']			=	$survey_participant_id;
					
						$surveryor[6]['employee_number']				=	$res['direct_report_3_employee_number'];
						
						$surveryor[6]['relationship']					=	'Direct Report';
						
						$surveryor[6]['relationship_index']				=	'3';
						
						$surveryor[6]['name']							=	$res['direct_report_3_name'];
						
						$surveryor[6]['email']							=	$res['direct_report_3_email'];
						
						$surveryor[6]['phone_number']					=	$res['direct_report_3_phone_number'];
						
						$surveryor[6]['created_by_id']					=	$res['created_by_id'];
						
							
						foreach($surveryor as $surveyor)
						{
							
							$querySurveyor								=	$this->db->insert('program_survey_surveyor', $surveyor);
								
						}
						
						
					}else{
						
						
							
					}
				
				}

			}
			
			return TRUE;
				
		}else{
			
			return FALSE;
				
		}
		
	}
	
	public function get_department_by_name($department, $companyID)
	{
		
		$this->db->where('department', $department);
		
		$this->db->where('company_id', $companyID);
		
		$query			=	$this->db->get('department');
		
		return $query->row_array();
		
	}
	
	public function get_location_by_name($location, $companyID)
	{
		
		$this->db->where('location', $location);
		
		$this->db->where('company_id', $companyID);
		
		$query			=	$this->db->get('location');
		
		return $query->row_array();
		
	}
	
	public function get_grade_by_name($grade, $companyID)
	{
		
		$this->db->where('grade', $grade);
		
		$this->db->where('company_id', $companyID);
		
		$query			=	$this->db->get('grade');
		
		return $query->row_array();
		
	}
	
	public function add_participant_to_user_table($userDetails)
	{
		
		//first check if this user already exists in the user table
		
		$this->db->where('email', $userDetails['email']);
		
		$query		=	$this->db->get('user');
		
		if($query->num_rows() > 0)
		{
			
			$res			=	$query->row_array();
			
			$id				=	$res['user_id'];
			
		}else{
			
			//insert this record as a bew record	
			
			$this->db->insert('user', $userDetails);
			
			$id				=	$this->db->insert_id();
		}
		
		return $id;
		
	}
	
	// check if owner email is unique
	public function check_owner_email($email)
	{
	
		$this->db->where('email', $email);
		
		$query = $this->db->get('owner');
					
		if($query->num_rows > 0)
		{
			
			return TRUE;
			
		}
		else
		{
			
			return FALSE;
		
		}
		
	}
	
	public function check_current_user_as_program_owner($userID, $companyID)
	{
		
		$this->db->where('company_id', $companyID);
		
		$this->db->where('user_id', $userID);
		
		$query			=	$this->db->get('owner');
		
		if($query->num_rows() > 0)
		{
			//means this user already exist in the owner table so ignore and return true
			
			$res						=	$query->row_array();
			
			$ownerID					=	$res['owner_id'];
			
		}else{
			
			//user does not exist in the owner table so create one
			$userDetail					=	$this->get_users($userID, $companyID);
			
			$user['user_id']			=	$userID;
			
			$user['company_id']			=	$companyID;
			
			$user['first_name']			=	$userDetail['first_name'];
			
			$user['last_name']			=	$userDetail['last_name'];
			
			$user['email']				=	$userDetail['email'];
			
			$user['phone_number']		=	$userDetail['phone_number'];
			
			$user['created_by_id']		=	$userDetail['created_by_id'];
			
			$createQuery				=	$this->db->insert('owner', $user);
			
			$ownerID					=	$this->db->insert_id();
			
			if($createQuery)
			{
				//now update the user table with this owner id
								
				$upduser['owner_id']	=	$ownerID;
				
				$this->db->where('user_id', $userID);
				
				$this->db->update('user', $upduser);
				
			}
			
		}
		
		return $ownerID;
		
	}
	
	public function save_owner($save)
	{
		
		$userID						=	'';
		
		//just crosschek to make sure the user is not already been created
		
		$this->db->where('company_id', $save['company_id']);
		
		$this->db->where('email', $save['email']);
		
		$query						=	$this->db->get('owner');
		
		if($query->num_rows() > 0)
		{
			
			$ownerres				=	$query->row_array();
			
			$ownerID				=	$ownerres['owner_id'];

			if(!empty($ownerres['user_id']))
			{
				//if there is a user id assigned to this owner details it means the user has been created
				
				return TRUE;	
				
			}else{
				
				//means though this owner details exist its not on the user table so do something about that
				//first check if this user exists in the user table
				
				$this->db->where('email', $save['email']);
				
				$queryCheck			=	$this->db->get('user');
				
				if($queryCheck->num_rows() > 0)
				{
					//it means this user already exists, if so just update his/her owner id
					
					$userres		=	$queryCheck->row_array();
					
					
					//check if this particular user already has an owner id assigned
					if(!empty($userres['owner_id']))
					{
						
						return TRUE;
						
					}else{
						
						//update the owner id of user
						
						$this->db->where('user_id', $userres['user_id']);
						
						$this->db->update('user', array('owner_id' => $ownerID));
						
					}
					
					$userID				=	$userres['user_id'];
					
				}else{
					
					//means this owner record cannot be found under users, so create the owner as a user
					
					$save['owner_id']	=	$ownerID;
					
					$userInsert			=	$this->db->insert('user', $save);
					
					$userID				=	$this->db->insert_id();
					
				}
				
				if(!empty($userID))
				{
					//now update the owner table with the user id for this user
					
					$this->db->where('owner_id', $ownerID);
					
					$updateOwner		=	$this->db->update('owner', array('user_id' => $userID));	
					
					if($updateOwner)
					{
						
						return TRUE;
						
					}else{
						
						return FALSE;
							
					}
					
				}else{
					
					return FALSE;
						
				}
				
			}
			
		}else{
			
			//perform the insert
			
			$createOwner			=	$this->db->insert('owner', $save);
			
			$ownerID				=	$this->db->insert_id();
			
			if($createOwner)
			{
				
				//first check if this user exists in the user table
				
				$this->db->where('email', $save['email']);
				
				$queryCheck			=	$this->db->get('user');
				
				if($queryCheck->num_rows() > 0)
				{
					//it means this user already exists, if so just update his/her owner id
					
					$userres		=	$queryCheck->row_array();
					
					
					//check if this particular user already has an owner id assigned
					if(!empty($userres['owner_id']))
					{
						
					}else{
						
						//update the owner id of user
						
						$this->db->where('user_id', $userres['user_id']);
						
						$this->db->update('user', array('owner_id' => $ownerID));
						
					}
					
					$userID				=	$userres['user_id'];
					
				}else{
					
					//means this owner record cannot be found under users, so create the owner as a user
					
					$save['owner_id']	=	$ownerID;
					
					$userInsert			=	$this->db->insert('user', $save);
					
					$userID				=	$this->db->insert_id();
					
				}
				
				if(!empty($userID))
				{
					//now update the owner table with the user id for this user
					
					$this->db->where('owner_id', $ownerID);
					
					$updateOwner		=	$this->db->update('owner', array('user_id' => $userID));	
					
					if($updateOwner)
					{
						
						return TRUE;
						
					}else{
						
						return FALSE;
							
					}
					
				}else{
					
					return FALSE;
						
				}
				
			}
				
		}
		
	}
	
	function get_program_participants($programID)
	{
		
		$this->db->where('program_id', $programID);
		
		$query		=	$this->db->get('program_survey_participant');
		
		return $query->result_array();
		
	}
	
	function get_program_grade_level_details($program_id)
	{
				
		$this->db->where('program_id', $program_id);
		
		$this->db->select('program_grade.*, grade.*');
		
		$this->db->from('program_grade');

		$this->db->join('grade', 'grade.grade_id = program_grade.grade_id', 'left');
	
		$query				=	$this->db->get();
		
		return $query->result_array();	
		
	}
	
	function save_client($save)
	{
		
		$slug_field							=	'company_name_slug';
		
		$table								=	'client';
		
		$id_field							=	'client_id';
		
		$save[$slug_field]					= 	$this->validate_slug($save[$slug_field], $slug_field, $table, $id_field, $save[$id_field]);
		
		if(!empty($save['client_id']))
		{
			
			$this->db->where('client_id', $save['client_id']);
			
			$query							=	$this->db->update('client', $save);
						
			if($query)
			{
				
				return TRUE;
					
			}else{
				
				return FALSE;
					
			}
			
		}else{
			
			//insert new company into the company table
			$query				=	$this->db->insert('client', $save);
						
			if($query)
			{

				return TRUE;
					
			}else{
				
				return FALSE;
					
			}
				
		}
		
	}
	
	function get_company($companyID=false, $status=false, $limit=0, $offset=0)
	{
		
		$response							=	array();
		
		if(!empty($companyID))
		{
			
			$this->db->where('company_id', $companyID);
			
			$query							=	$this->db->get('company');
			
			$company						=	$query->row_array();
			
			$response['company']			=	$company;
			
			$response['primaryContact']		=	$this->get_company_contact($company['company_id'], 'is_primary_contact');
			
			$response['secondaryContact']	=	$this->get_company_contact($company['company_id'], 'is_secondary_contact');
							
		}else{
			
			if(!empty($status))
			{
				
				if($status == 'Active')
				{
					
					$this->db->where('company_status', '1');
				
				}else if($status == 'Pending'){
					
					$this->db->where('company_status', '0');
					
				}
					
				
			}
			
			if($limit>0)
			{
				$this->db->limit($limit, $offset);
			}
			
			$this->db->order_by('date_created', 'DESC');
			
			$query							=	$this->db->get('company');
			
			$result			 				=	$query->result_array();
			
			$count							=	0;
			
			foreach($result as $res)
			{
				
				$response[$count]['company_id']					=	$res['company_id'];
				
				$response[$count]['client_id']					=	$res['client_id'];
				
				$response[$count]['company_name']				=	$res['company_name'];
				
				$response[$count]['company_name_slug']			=	$res['company_name_slug'];
				
				$response[$count]['industry_id']				=	$res['industry_id'];
				
				$response[$count]['company_address']			=	$res['company_address'];
				
				$response[$count]['countries_of_operation']		=	$res['countries_of_operation'];
				
				$response[$count]['number_of_employees']		=	$res['number_of_employees'];
				
				$response[$count]['company_logo']				=	$res['company_logo'];
				
				$response[$count]['company_color_theme']		=	$res['company_color_theme'];
				
				$response[$count]['company_status']				=	$res['company_status'];
				
				$response[$count]['modified_by_id']				=	$res['modified_by_id'];
				
				$response[$count]['date_modified']				=	$res['date_modified'];
				
				$response[$count]['created_by_id']				=	$res['created_by_id'];
				
				$response[$count]['date_created']				=	$res['date_created'];
				
				$response[$count]['primaryContact']				=	$this->get_company_contact($res['company_id'], 'is_primary_contact');
			
				$response[$count]['secondaryContact']			=	$this->get_company_contact($res['company_id'], 'is_secondary_contact');
				
				$count++;
				
			}

		}
		
		return $response;
	}
	
	function get_company_contact($companyID, $typeOfContact)
	{
		
		$this->db->where('company_id', $companyID);
		
		$this->db->where($typeOfContact, '1');
		
		$query		=	$this->db->get('user');
		
		if($query->num_rows() > 0)
		{
			
			return $query->row_array();
			
		}else{
			
			return FALSE;
				
		}
		
	}
	
	function save_company($save, $primaryContact=false, $secondaryContact=false)
	{
		
		$slug_field							=	'company_name_slug';
		
		$table								=	'company';
		
		$id_field							=	'company_id';
		
		$save[$slug_field]					= 	$this->validate_slug($save[$slug_field], $slug_field, $table, $id_field, $save[$id_field]);
		
		if(!empty($save['company_id']))
		{
			
			$this->db->where('company_id', $save['company_id']);
			
			$query							=	$this->db->update('company', $save);
			
			$companyID						=	$save['company_id'];
			
			if($query)
			{
				
				if(!empty($primaryContact['email']))
				{
					
					$this->db->where('email', $primaryContact['email']);
						
					$queryPrimary			=	$this->db->get('user');
					
					if($queryPrimary->num_rows() > 0)
					{
						
						$primaryRes				=	$queryPrimary->row_array();
						
						//update the contact for this company
						
						if(empty($primaryRes['is_admin']))
						{
												
							$primaryContact['is_admin']					=	'1';
						
						}
						
						if(empty($primaryRes['is_primary_contact']))
						{
							
							$primaryContact['is_primary_contact']		=	'1';
						
						}
						
						
						$this->db->where('email', $primaryContact['email']);
						
						$this->db->update('user', $primaryContact);	
					
					}else{
						
						
						$primaryContact['company_id']				=	$companyID;
						
						$primaryContact['is_admin']					=	'1';
						
						$primaryContact['is_primary_contact']		=	'1';
						
						$this->db->insert('user', $primaryContact);	
						
					}
				
				}
				
				if(!empty($secondaryContact['email']))
				{
					
					$this->db->where('email', $secondaryContact['email']);
					
					$querySecondary			=	$this->db->get('user');
				
					if($querySecondary->num_rows() > 0)
					{
						
						$secondaryRes				=	$querySecondary->row_array();
						
						//update the contact for this company
						
						if(empty($secondaryRes['is_admin']))
						{
												
							$secondaryContact['is_admin']				=	'1';
						
						}
						
						if(empty($secondaryRes['is_secondary_contact']))
						{
							
							$secondaryContact['is_secondary_contact']	=	'1';
						
						}
						
						
						$this->db->where('email', $secondaryContact['email']);
						
						$this->db->update('user', $secondaryContact);	
					
					}else{
						
						
						$secondaryContact['company_id']					=	$companyID;
						
						$secondaryContact['is_admin']					=	'1';
						
						$secondaryContact['is_secondary_contact']		=	'1';
						
						$this->db->insert('user', $secondaryContact);	
						
					}
					
				}
				
				return TRUE;
					
			}else{
				
				return FALSE;
					
			}
			
		}else{
			
			//insert new company into the company table
			$query				=	$this->db->insert('company', $save);
			
			$companyID			=	$this->db->insert_id();
			
			if($query)
			{
				
				if(!empty($primaryContact['email']))
				{
					
					$primaryContact['company_id']				=	$companyID;
						
					$primaryContact['is_admin']					=	'1';
					
					$primaryContact['is_primary_contact']		=	'1';
					
					$primaryContact['contact_mail_sent']		=	'1';
					
					$primaryContact['date_contact_mail_sent']	=	date('Y-m-d H:i:s');
					
					$this->db->insert('user', $primaryContact);
					
					$userID			=	$this->db->insert_id();
						
					$name			=	ucfirst($primaryContact['first_name']).' '.ucfirst($primaryContact['last_name']);
					
					$email			=	$primaryContact['email'];
									
					$companyName	=	$save['company_name'];
					
					$url 			= 	'<a href="'.base_url().'admin/confirm-admin/'.$userID.'/">'.base_url().'admin/confirm-admin/'.$userID.'/</a>';
					
					$this->send_corporate_admin_creation_mail($name, $url, $email, $companyName);	
					
				}
				
				if(!empty($secondaryContact['email']))
				{
					//insert the contact for this company
					
					$secondaryContact['company_id']				=	$companyID;
					
					$secondaryContact['is_admin']				=	'1';
					
					$secondaryContact['is_secondary_contact']	=	'1';
					
					$secondaryContact['contact_mail_sent']		=	'1';
					
					$secondaryContact['date_contact_mail_sent']	=	date('Y-m-d H:i:s');
					
					$this->db->insert('user', $secondaryContact);
					
					$userID			=	$this->db->insert_id();
						
					$name			=	ucfirst($secondaryContact['first_name']).' '.ucfirst($secondaryContact['last_name']);
					
					$email			=	$secondaryContact['email'];
									
					$companyName	=	$save['company_name'];
					
					$url 			= 	'<a href="'.base_url().'admin/confirm-admin/'.$userID.'/">'.base_url().'admin/confirm-admin/'.$userID.'/</a>';
					
					$this->send_corporate_admin_creation_mail($name, $url, $email, $companyName);		
					
				}
				
				return TRUE;
					
			}else{
				
				return FALSE;
					
			}
				
		}
		
		
	}
	
	
	function get_corporate_admin($userID=false, $companyID, $status=false, $limit=0, $offset=0)
	{
		
		$response							=	array();
		
		if(!empty($userID))
		{
			
			$this->db->where('is_admin', 1);
			
			$this->db->where('user_id', $userID);
			
			$query							=	$this->db->get('user');
			
			$user							=	$query->row_array();
			
			$response['user']				=	$user;
			
			$response['company']			=	$this->get_company($user['company_id']);
										
		}else{
			
			if($companyID != '1')
			{
				
				$this->db->where('company_id', $companyID);
					
			}
			
			$this->db->where('is_admin', 1);
			
			if(!empty($status))
			{
				
				if($status == 'Active')
				{
					
					$this->db->where('is_admin_active', '1');
				
				}else if($status == 'Pending'){
					
					$this->db->where('is_admin_active', '0');
					
				}
					
				
			}
			
			if($limit>0)
			{
				$this->db->limit($limit, $offset);
			}
			
			$this->db->order_by('company_id', 'ASC');
			
			$this->db->order_by('date_created', 'DESC');
			
			$query							=	$this->db->get('user');
			
			$result			 				=	$query->result_array();
			
			$count							=	0;
			
			foreach($result as $res)
			{
				
				$response[$count]['user']				=	$res;
			
				$response[$count]['company']			=	$this->get_company($res['company_id']);
				
				$count++;

			}

		}
		
		return $response;
	}
	
	public function save_corporate_admin($save)
	{
		
		if(!empty($save['user_id']))
		{
			
			$this->db->where('user_id', $save['user_id']);
			
			$query		=	$this->db->update('user', $save);	
			
			if($query)
			{
				
				return TRUE;
					
			}else{
				
				return FALSE;
					
			}
			
		}else{
			
			//first check if the admin email exists
			
			$this->db->where('email', $save['email']);
			
			$checkQuery		=	$this->db->get('user');
			
			if($checkQuery->num_rows() > 0)	
			{
				//it means this user already exists
				
				$user		=	$checkQuery->row_array();
				
				//do the necessary checks then update this users details
				
				if(!empty($user['is_admin']))
				{
					
					$this->db->where('user_id', $user['user_id']);
					
					$updtQuery		=	$this->db->update('user', $save);
					
					if($updtQuery)
					{
						
						return TRUE;
							
					}else{
						
						return FALSE;
						
					}
					
				}else{
					
					$save['is_admin']	=	1;
					
					$this->db->where('user_id', $user['user_id']);
					
					$updtQuery		=	$this->db->update('user', $save);
					
					if($updtQuery)
					{
						
						$userID			=	$user['user_id'];
						
						$name			=	ucfirst($save['first_name']).' '.ucfirst($save['last_name']);
						
						$email			=	$save['email'];
						
						$company		=	$this->get_company($save['company_id']);
					
						$companyName	=	$company['company']['company_name'];
						
						$url 			= 	'<a href="'.base_url().'admin/confirm-admin/'.$userID.'/">'.base_url().'admin/confirm-admin/'.$userID.'/</a>';
						
						$this->send_corporate_admin_creation_mail($name, $url, $email, $companyName);
						
						return TRUE;
						
					}else{
						
						return FALSE;
							
					}
					
				}
				
			}else{
				
				//means this user does not exists
				
				$save['is_admin']	=	1;
				
				$query				=	$this->db->insert('user', $save);
				
				$userID				=	$this->db->insert_id();
				
				if($query)
				{
					
					$name			=	ucfirst($save['first_name']).' '.ucfirst($save['last_name']);
					
					$email			=	$save['email'];
					
					$company		=	$this->get_company($save['company_id']);
					
					$companyName	=	$company['company']['company_name'];
					
					$url 			= 	'<a href="'.base_url().'admin/confirm-admin/'.$userID.'/">'.base_url().'admin/confirm-admin/'.$userID.'/</a>';

					$this->send_corporate_admin_creation_mail($name, $url, $email, $companyName);
					
					return TRUE;
					
				}else{
					
					return FALSE;	
					
				}
				
			}
			
		}
		
	}
	
	// send the user a token for confirmation of email
	public function send_corporate_admin_creation_mail($name, $url, $email, $companyName)
	{
		$site_email 			= 	$this->site_email; 
		
		$platform_name 			= 	$this->company_name;
		
		$site_logo				= 	$this->site_logo;
		
		// - get the email template
		
		$this->load->model('messages_model');
		
		$row 					= 	$this->messages_model->get_message(4);
		
		$row['content'] 		= 	html_entity_decode($row['content']);
		
		// set replacement values for subject & body
		// {customer_name}
		$row['subject']			= 	str_replace('{name}', $name, $row['subject']);
		
		$row['content'] 		= 	str_replace('[Admin Name]',  $name, $row['content']);
		
		// {url}
		$row['content'] 		= 	str_replace('[link]', $url, $row['content']);
		
		$row['content'] 		= 	str_replace('[Platform Name]', $platform_name, $row['content']);
		
		$row['content'] 		= 	str_replace('[Company Name]', $companyName, $row['content']);
		
		// {site_logo}
		//$row['content'] 		= 	str_replace('{site_logo}', $site_logo, $row['content']);
		
		$mailBody				=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>

<body>

<style>

.container {
  padding-right: 15px;
  padding-left: 15px;
   width:90%;
  margin-right: auto;
  margin-left: auto;
}

.col-md-12{
  padding-right: 15px;
  padding-left: 15px;
  
}

.mail-welcome-hdr{
	font-size:18px;
	padding-top:10px;
	padding-bottom:10px;
	margin-bottom:10px;
	margin-top:10px;
	background-color: #0071f6;
	text-transform: uppercase;
	font-family:Verdana, Geneva, sans-serif;
	font-weight: 700;
	color:#fff;
	text-align:center;
}

.mail-msg-usr-hdr{
	font-weight:600;
}

.mail-msg-cnt ul{
	padding-left:15px;
}

.mail-msg-cnt ul li{
	margin-top:10px;
	margin-bottom:10px;	
}

.msg-mail-cnct{
	color: #0071f6;
	font-weight:600;
}

.msg-mail-cnct a{
	text-decoration:none;
	color: #0071f6;
}

.mail-cust-name{
	font-weight:600;
}

.tp-contacts{
	padding-top:3px;
	overflow:auto;
	text-align:center;
}

.tp-contacts ul{
	padding-left:0px;
	display: inline-block;
}

.tp-contacts ul li{
	float:left;
	display:inline-block;
	margin-left:5px;
	margin-right:5px;	
	padding-right:15px;
	padding-left:10px;
	font-family: "AlegreyaSansSC-Thin";
	font-size:14px;
	font-weight:600;
	border-right:1px solid #000;
}

.tp-contacts ul li:last-child{
	border:none;
	padding-right:0px;
	margin-right:0px;
}

.top-logo{
	text-align:center;
}

</style>

<div class="" style="padding-bottom:30px; padding-top:30px; padding-left:0px; padding-right:0px; background-color:#cccccc; ">

	<div class="container" style="background-color:#fff; padding-bottom:20px; padding-top:20px;">
    
    	<div class="col-md-12">
            
            <div class="top-logo">
            	
                <img src="'.$site_logo.'" />
                                
            </div>

            
        </div>
        
        <div class="col-md-12">
        	
            <div class="mail-welcome-hdr">
            	
               Welcome
                
            </div>
            
        </div>
        
        <div class="col-md-12">
        
        	<div class="" style="margin-bottom:10px; padding-left:10px; line-height:25px;">
			
			
				'.$row['content'].'
			
			</div>
            
        </div>
        
    </div>
    
</div>

</body>
</html>';
			

		$config['mailtype'] 	= 	'html';
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
		$this->email->to($email);

		$this->email->subject($row['subject']);
		
		$this->email->message($mailBody);
		
		$this->email->send();

	}
	
	
	public function get_departments($departmentID=false, $companyID=false, $limit=0, $offset=0)
	{
		
		if(!empty($departmentID))
		{
			//fetch the details of this department	
			
			$this->db->where('department_id', $departmentID);
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);	
				
			}
			
			$query			=	$this->db->get('department');
			
			return $query->row_array();
			
		}else{
			
			$this->db->order_by('date_created', 'DESC');
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);	

			}else{
				
				$this->db->order_by('company_id', 'DESC');	
			}
			
			$query			=	$this->db->get('department');
			
			return $query->result_array();
			
		}
		
	}
	
	public function save_department($save)
	{
		
		$slug_field							=	'department_slug';
		
		$table								=	'department';
		
		$id_field							=	'department_id';
		
		$save[$slug_field]					= 	$this->validate_slug($save[$slug_field], $slug_field, $table, $id_field, $save[$id_field]);
		
		if(!empty($save['department_id']))
		{
			
			$this->db->where('department_id', $save['department_id']);
			
			$query		=	$this->db->update('department', $save);	
			
			if($query)
			{
				
				return TRUE;
					
			}else{
				
				return FALSE;
					
			}
		
		}else{
			
			$query		=	$this->db->insert('department', $save);	
			
			if($query)
			{
				
				return TRUE;
					
			}else{
				
				return FALSE;
					
			}
			
		}
		
	}
	
	
	public function get_locations($locationID=false, $companyID=false, $limit=0, $offset=0)
	{
		
		if(!empty($locationID))
		{
			//fetch the details of this department	
			
			$this->db->where('location_id', $locationID);
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);	
				
			}
			
			$query			=	$this->db->get('location');
			
			return $query->row_array();
			
		}else{
			
			$this->db->order_by('date_created', 'DESC');
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);	

			}else{
				
				$this->db->order_by('company_id', 'DESC');	
			}
			
			$query			=	$this->db->get('location');
			
			return $query->result_array();
			
		}
		
	}
	
	public function save_location($save)
	{
		
		if(!empty($save['location_id']))
		{
			
			$this->db->where('location_id', $save['location_id']);
			
			$query		=	$this->db->update('location', $save);	
			
			if($query)
			{
				
				return TRUE;
					
			}else{
				
				return FALSE;
					
			}
		
		}else{
			
			$query		=	$this->db->insert('location', $save);	
			
			if($query)
			{
				
				return TRUE;
					
			}else{
				
				return FALSE;
					
			}
			
		}
		
	}
	
	public function get_grades($gradeID=false, $companyID=false, $limit=0, $offset=0)
	{
		
		if(!empty($gradeID))
		{
			//fetch the details of this department	
			
			$this->db->where('grade_id', $gradeID);
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);	
				
			}
			
			$query			=	$this->db->get('grade');
			
			return $query->row_array();
			
		}else{
			
			$this->db->order_by('date_created', 'DESC');
			
			if(!empty($companyID))
			{
				
				$this->db->where('company_id', $companyID);	

			}else{
				
				$this->db->order_by('company_id', 'DESC');	
			}
			
			$query			=	$this->db->get('grade');
			
			return $query->result_array();
			
		}
		
	}
	
	public function save_grade($save)
	{
		
		$slug_field							=	'grade_slug';
		
		$table								=	'grade';
		
		$id_field							=	'grade_id';
		
		$save[$slug_field]					= 	$this->validate_slug($save[$slug_field], $slug_field, $table, $id_field, $save[$id_field]);
		
		if(!empty($save['grade_id']))
		{
			
			$this->db->where('grade_id', $save['grade_id']);
			
			$query		=	$this->db->update('grade', $save);	
			
			if($query)
			{
				
				return TRUE;
					
			}else{
				
				return FALSE;
					
			}
		
		}else{
			
			$query		=	$this->db->insert('grade', $save);	
			
			if($query)
			{
				
				return TRUE;
					
			}else{
				
				return FALSE;
					
			}
			
		}
		
	}
	
	public function fetch_summary($program_id = null) 
    {
	    
		$this->db->select('COUNT(program_survey_competency.program_id) as total_competency,COUNT(program_survey_participant.survey_participant_id) as total_participant');
	    
		$this->db->from('program_survey_competency');
	    
		$this->db->join('program_survey_participant', 'program_survey_participant.program_id = program_survey_competency.program_id', 'left');
	    
		$this->db->join('program_survey_schedule', 'program_survey_schedule.program_id = program_survey_competency.program_id', 'left');
	    
		$this->db->where('program_survey_competency.program_id', $program_id);
        
		$query 							= 	$this->db->get(); 
        
		$result 						= 	$query->row_array();
        
		$total_competency 				= 	$result ? $result['total_competency'] : 0;
        
		$total_participant 				= 	$result ? $result['total_participant'] : 0;
		
		$this->db->select('end_date as date_collected');
        
		$this->db->from('program_survey_schedule');
        
		$this->db->where('program_id', $program_id);
        
		$query 							= 	$this->db->get(); 
        
		$result 						= 	$query->row_array();
        
		$date_collected 				= 	$result ? $result['date_collected'] : 'N/A';
		
        return array(
		
			"total_competency" 	=> $total_competency, 
		
			"total_participant" => $total_participant,
		
			"date_collected" 	=> $date_collected 
        
		); 
		
	}
	
	public function send_participant_welcome_emails($programID)
	{
		
		//check if a survey has been created for this program
		
		$this->db->where('program_id', $programID);
		
		$checkSurvey		=	$this->db->get('program_survey');
		
		if($checkSurvey->num_rows() > 0)
		{
			
			$surveys			=	$checkSurvey->result_array();
			
			foreach($surveys as $survey)
			{
				
				$surveyID		=	$survey['survey_id'];
				
				$this->db->where('survey_id', $surveyID);
				
				$checkParticipants		=	$this->db->get('program_survey_participant');

				if($checkParticipants->num_rows() > 0)
				{
					
					$participants					=	$checkParticipants->result_array();

					foreach($participants as $participant)
					{
						
						$participantID				=	$participant['survey_participant_id'];
						
						$participantName			=	ucfirst($participant['first_name']).' '.ucfirst($participant['last_name']);
						
						$participantUserID			=	$participant['user_id'];
						
						if($participant['gender'] == 'MALE' || $participant['gender'] == 'M')
						{
							
							$participantGender		=	'him';
							
						}elseif($participant['gender'] == 'FEMALE' || $participant['gender'] == 'F')
						{
							
							$participantGender		=	'her';
						
						}else{
							
							$participantGender		=	'him/her';
						}
						
						//now get the surveyors for this participant
						
						$this->db->where('survey_participant_id', $participantID);	
						
						$surveyorcheck				=	$this->db->get('program_survey_surveyor');
						
						if($surveyorcheck->num_rows() > 0)
						{
							
							$surveyors				=	$surveyorcheck->result_array();

							foreach($surveyors as $surveyor)
							{
								
								$surveyorID			=	$surveyor['survey_surveyor_id'];
								
								$surveyorName		=	ucfirst($surveyor['name']);
								
								$surveyorEmail		=	$surveyor['email'];
								
								$url				=	'<a href="'.base_url().'survey/get-started/'.$surveyID.'/'.$surveyorID.'/'.$participantID.'/">'.base_url().'survey/get-started/'.$surveyID.'/'.$surveyorID.'/'.$participantID.'/'.'</a>';
								
								if($surveyor['relationship'] == 'Self')
								{
									
									$url_participant_module		=	'<a href="'.base_url().'participant/confirm-participant/'.$participantUserID.'/">'.base_url().'participant/confirm-participant/'.$participantUserID.'/</a>';
									
									$mailSent			=	$this->send_surveyor_self_welcome_mail($surveyID, $participantName, $participantGender, $surveyorName, $surveyorEmail, $url, $url_participant_module);

								}else{
								
									$mailSent			=	$this->send_surveyor_welcome_mail($surveyID, $participantName, $participantGender, $surveyorName, $surveyorEmail, $url);
								
								}
								
								if($mailSent)
								{
									
									$this->db->where('survey_surveyor_id', $surveyorID);
									
									$updateSurveyor['mail_sent']		=	1;
									
									$updateSurveyor['date_mail_sent']	=	date('Y-m-d H:i:s');
									
									$queryMailSent						=	$this->db->update('program_survey_surveyor', $updateSurveyor);
									
									
									
								}else{
									
									/*echo 'Error sending out mails please try again';
									
									die();	*/
									
								}
								
							}
							
							/*echo 'Mail should have been sent';
							
							die();*/
							
						}else{
							

						}
						
					}
					
				}else{

				}
				
			}
			
		}else{
			
			
				
		}
		
	}

	function get_survey_message($subject, $surveyID)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		$this->db->where('subject', $subject);
		
		$res 			= 	$this->db->get('program_survey_communication');
		
		return $res->row_array();
		
	}
	
	// send the user a token for confirmation of email
	public function send_surveyor_welcome_mail($surveyID, $participantName, $participantGender, $surveyorName, $surveyorEmail, $url)
	{

		$site_email 			= 	$this->site_email; 
		
		$platform_name 			= 	$this->company_name;
		
		$site_logo				= 	$this->site_logo;
		
		$row 					= 	$this->get_survey_message('Welcome Email', $surveyID);
		
		$row['content'] 		= 	html_entity_decode($row['content']);
		
		// set replacement values for subject & body
		// {customer_name}
		
		$row['content'] 		= 	str_replace('[Evaluator Name]',  $surveyorName, $row['content']);
		
		$row['content'] 		= 	str_replace('[Leader Name]',  $participantName, $row['content']);
		
		$row['content'] 		= 	str_replace('[Him/Her]',  $participantGender, $row['content']);
		
		// {url}
		$row['content'] 		= 	str_replace('[url]', $url, $row['content']);
		
		// {site_logo}
		//$row['content'] 		= 	str_replace('{site_logo}', $site_logo, $row['content']);
		
		$mailBody				=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>

<body>

<style>

.container {
  padding-right: 15px;
  padding-left: 15px;
   width:90%;
  margin-right: auto;
  margin-left: auto;
}

.col-md-12{
  padding-right: 15px;
  padding-left: 15px;
  
}

.mail-welcome-hdr{
	font-size:18px;
	padding-top:10px;
	padding-bottom:10px;
	margin-bottom:10px;
	margin-top:10px;
	background-color: #0071f6;
	text-transform: uppercase;
	font-family:Verdana, Geneva, sans-serif;
	font-weight: 700;
	color:#fff;
	text-align:center;
}

.mail-msg-usr-hdr{
	font-weight:600;
}

.mail-msg-cnt ul{
	padding-left:15px;
}

.mail-msg-cnt ul li{
	margin-top:10px;
	margin-bottom:10px;	
}

.msg-mail-cnct{
	color: #0071f6;
	font-weight:600;
}

.msg-mail-cnct a{
	text-decoration:none;
	color: #0071f6;
}

.mail-cust-name{
	font-weight:600;
}

.tp-contacts{
	padding-top:3px;
	overflow:auto;
	text-align:center;
}

.tp-contacts ul{
	padding-left:0px;
	display: inline-block;
}

.tp-contacts ul li{
	float:left;
	display:inline-block;
	margin-left:5px;
	margin-right:5px;	
	padding-right:15px;
	padding-left:10px;
	font-family: "AlegreyaSansSC-Thin";
	font-size:14px;
	font-weight:600;
	border-right:1px solid #000;
}

.tp-contacts ul li:last-child{
	border:none;
	padding-right:0px;
	margin-right:0px;
}

.top-logo{
	text-align:center;
}

</style>

<div class="" style="padding-bottom:30px; padding-top:30px; padding-left:0px; padding-right:0px; background-color:#cccccc; ">

	<div class="container" style="background-color:#fff; padding-bottom:20px; padding-top:20px;">
    
    	<div class="col-md-12">
            
            <div class="top-logo">
            	
                <img src="'.$site_logo.'" />
                                
            </div>

            
        </div>
        
        <div class="col-md-12">
        	
            <div class="mail-welcome-hdr">
            	
               Welcome
                
            </div>
            
        </div>
        
        <div class="col-md-12">
        
        	<div class="" style="margin-bottom:10px; padding-left:10px; line-height:25px;">
			
			
				'.$row['content'].'
			
			</div>
            
        </div>
        
    </div>
    
</div>

</body>
</html>';	

		//$mailBody 		= 	html_entity_decode($mailBody);
		
		$config['mailtype'] 	= 	'html';
		
		$this->email->initialize($config);

		$this->email->from($site_email, $platform_name);
		
		$this->email->to($surveyorEmail);

		$this->email->subject('Welcome to an assessment for '.$participantName.'');
		
		$this->email->message($mailBody);
		
		//$this->email->send();
		
		if (!$this->email->send())
		{
		
			//echo 'Failed';
		
		// Loop through the debugger messages.
			foreach ($this->email->get_debugger_messages() as $debugger_message)
			{
		  	
				echo $debugger_message;
			
			}
		
			// Remove the debugger messages as they're not necessary for the next attempt.
			$this->email->clear_debugger_messages();
			
			return FALSE;
		
		}else
		{
		
			return TRUE;
		
		}

	}
	
	// send the user a token for confirmation of email
	public function send_surveyor_self_welcome_mail($surveyID, $participantName, $participantGender, $surveyorName, $surveyorEmail, $url, $participantUrl)
	{

		$site_email 			= 	$this->site_email; 
		
		$platform_name 			= 	$this->company_name;
		
		$site_logo				= 	$this->site_logo;
		
		$row 					= 	$this->get_survey_message('Welcome Email Self Participant', $surveyID);
		
		$row['content'] 		= 	html_entity_decode($row['content']);
		
		// set replacement values for subject & body
		// {customer_name}
		
		$row['content'] 		= 	str_replace('[Evaluator Name]',  $surveyorName, $row['content']);
		
		// {url}
		$row['content'] 		= 	str_replace('[url]', $url, $row['content']);
		
		// {url}
		$row['content'] 		= 	str_replace('[participant_url]', $participantUrl, $row['content']);
		// {site_logo}
		//$row['content'] 		= 	str_replace('{site_logo}', $site_logo, $row['content']);
		
		$mailBody				=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>

<body>

<style>

.container {
  padding-right: 15px;
  padding-left: 15px;
   width:90%;
  margin-right: auto;
  margin-left: auto;
}

.col-md-12{
  padding-right: 15px;
  padding-left: 15px;
  
}

.mail-welcome-hdr{
	font-size:18px;
	padding-top:10px;
	padding-bottom:10px;
	margin-bottom:10px;
	margin-top:10px;
	background-color: #0071f6;
	text-transform: uppercase;
	font-family:Verdana, Geneva, sans-serif;
	font-weight: 700;
	color:#fff;
	text-align:center;
}

.mail-msg-usr-hdr{
	font-weight:600;
}

.mail-msg-cnt ul{
	padding-left:15px;
}

.mail-msg-cnt ul li{
	margin-top:10px;
	margin-bottom:10px;	
}

.msg-mail-cnct{
	color: #0071f6;
	font-weight:600;
}

.msg-mail-cnct a{
	text-decoration:none;
	color: #0071f6;
}

.mail-cust-name{
	font-weight:600;
}

.tp-contacts{
	padding-top:3px;
	overflow:auto;
	text-align:center;
}

.tp-contacts ul{
	padding-left:0px;
	display: inline-block;
}

.tp-contacts ul li{
	float:left;
	display:inline-block;
	margin-left:5px;
	margin-right:5px;	
	padding-right:15px;
	padding-left:10px;
	font-family: "AlegreyaSansSC-Thin";
	font-size:14px;
	font-weight:600;
	border-right:1px solid #000;
}

.tp-contacts ul li:last-child{
	border:none;
	padding-right:0px;
	margin-right:0px;
}

.top-logo{
	text-align:center;
}

</style>

<div class="" style="padding-bottom:30px; padding-top:30px; padding-left:0px; padding-right:0px; background-color:#cccccc; ">

	<div class="container" style="background-color:#fff; padding-bottom:20px; padding-top:20px;">
    
    	<div class="col-md-12">
            
            <div class="top-logo">
            	
                <img src="'.$site_logo.'" />
                                
            </div>

            
        </div>
        
        <div class="col-md-12">
        	
            <div class="mail-welcome-hdr">
            	
               Welcome
                
            </div>
            
        </div>
        
        <div class="col-md-12">
        
        	<div class="" style="margin-bottom:10px; padding-left:10px; line-height:25px;">
			
			
				'.$row['content'].'
			
			</div>
            
        </div>
        
    </div>
    
</div>

</body>
</html>';	

		//$mailBody 		= 	html_entity_decode($mailBody);
		
		$config['mailtype'] 	= 	'html';
		
		$this->email->initialize($config);

		$this->email->from($site_email, $platform_name);
		
		$this->email->to($surveyorEmail);

		$this->email->subject('Welcome to your Self Evaluation');
		
		$this->email->message($mailBody);
		
		//$this->email->send();
		
		if (!$this->email->send())
		{
		
			//echo 'Failed';
		
		// Loop through the debugger messages.
			foreach ($this->email->get_debugger_messages() as $debugger_message)
			{
		  	
				echo $debugger_message;
			
			}
		
			// Remove the debugger messages as they're not necessary for the next attempt.
			$this->email->clear_debugger_messages();
			
			return FALSE;
		
		}else
		{
		
			return TRUE;
		
		}

	}
	
	
	function upload_program_response($participants)
	{
		
		
		$response							=	array();
		
		$sizofParticipant					=	sizeof($participants);
		
		$count								=	0;
		
		foreach($participants as $res)
		{
			
			//get all the variables into an array to hold
			
			$survey_surveyor_id  	 	= 	$res['survey_surveyor_id'];
			
			$company_id  				= 	$res['company_id'];
			
			$program_id  				=	$res['program_id'];
			
			$survey_id					= 	$res['survey_id'];
											
			$survey_participant_id 		= 	$res['survey_participant_id'];
			
			$participant['question']  					= 	$res['question'];
			
			if(!empty($participant['question']))
			{
				
				foreach($participant['question'] as $key=>$value)
				{
					$question_id							=	$key;
					
					$answer									=	$value;
					
					$save['company_id']						=	$company_id;
					
					$save['survey_surveyor_id']				=	$survey_surveyor_id;
					
					$save['program_id']						=	$program_id;
					
					$save['survey_id']						=	$survey_id;
					
					$save['survey_participant_id']			=	$survey_participant_id;
					
					$save['survey_question_id']				=	$question_id;
					
					$questionDetails						=	$this->upload_program_response_competency_id($question_id);
					
					if(!empty($questionDetails))
					{
						
						$save['survey_competency_id']		=	$questionDetails['survey_competency_id'];

						if(!empty($save['survey_competency_id']))
						{
							
							$save['response_whole_number']		=	$answer;
							
							$save['response_text']				=	'';
							
						}else{
							
							$save['response_whole_number']		=	'';
							
							$save['response_text']				=	$answer;
							
						}
					
					}else{
						
						
						$save['response_text']					=	$answer;
						
					}
					
					$this->db->insert('program_survey_response', $save);
					
					/*echo 'Question ID = '.$question_id.' Answer = '.$answer;
					
					echo '<br /><br />';*/
					
				}
				
			}
			
			$count++;
		}
		
		if($sizofParticipant == $count)
		{
			
			$response['status']								=	'Success';
				
			$response['reason']								=	'Surveyors Response successfully uploaded';
			
		}else{
			
			$response['status']								=	'Failed';
				
			$response['reason']								=	'There was a problem uploading all records';
				
		}
		
		return $response;
			
	}

	function upload_program_response_competency_id($questionID)
	{
		
		$this->db->where('survey_question_id', $questionID);
		
		$query		=	$this->db->get('program_survey_question');
		
		return $query->row_array();	
		
	}
	
	function launch_program_cron()
	{
		
		$this->db->where('program_launched', '0');
		
		$query		=	$this->db->get('program');
		
		if($query->num_rows() > 0)
		{
			
			$result					=	$query->result_array();
			
			$sizeResult				=	sizeof($result);
			
			$count					=	0;
			
			foreach($result as $res)
			{
				
				$programStartDate							=	strtotime($res['start_date']);
				
				$curDate									=	strtotime(date('Y-m-d H:i:s'));
				
				if($programStartDate <= $curDate)
				{
					//check if there are participants attached to this program then send out the emails
					
					$this->db->where('program_id', $res['program_id']);
					
					$participantQuery			=	$this->db->get('program_survey_participant');
					
					if($participantQuery->num_rows() > 0)
					{
						
						//echo 'The date is valid for launching';
						
						//check if the program has been activated before, if yes ignore else set the status to active
						if(empty($res['program_status']))
						{
							
							$updateProgram['program_status']		=	1;
							
						}
						
						
						$updateProgram['program_launched']			=	1;
						
						$this->db->where('program_id', $res['program_id']);
						
						$updateProgramQuery							=	$this->db->update('program', $updateProgram);
						
						if($updateProgramQuery)
						{
						
							$this->send_participant_welcome_emails($res['program_id']);	
						
						}
					
					}
					
				}else{
					
					//echo 'It is not yet time to Launch';
					
				}
				
				$count++;
				
			}
			
			if($count == $sizeResult)
			{
				
				$response['status']		=	'Success';
			
				$response['message']	=	'All records were dealt with';
				
			}else{
				
				$response['status']		=	'Failed';
			
				$response['message']	=	$sizeResult.' Records found '.$count.' Records actioned on';
			
			}
			
		}else{
			
			$response['status']		=	'Failed';
			
			$response['message']	=	'No program found';
				
		}
		
	}
	
	
	function daily_reminder_for_launched_program_cron()
	{
		
		$this->db->where('program_launched', '1');
		
		$query		=	$this->db->get('program');
		
		if($query->num_rows() > 0)
		{
			
			$programs				=	$query->result_array();
						
			$count					=	0;

			
			foreach($programs as $res)
			{

				
				$programEndDate								=	strtotime($res['end_date']);
				
				$curDate									=	strtotime(date('Y-m-d H:i:s'));
				
				$programID									=	$res['program_id'];
				
				//check if the program has ended
				if($programEndDate >= $curDate)
				{
					//now get the surveys that belong to this program
					
					$this->db->where('program_id', $programID);
					
					$survQuery			=	$this->db->get('program_survey');
					
					if($survQuery->num_rows() > 0)
					{
						
						//this program has surveys
						$surveys				=	$survQuery->result_array();
						
						$sizeResult				=	sizeof($surveys);
						
						foreach($surveys as $survey)
						{
							
							//get the start date and end date of this survey	
					
							$surveyID						=	$survey['survey_id'];
							
							$surveyName						=	$survey['survey'];
							
							//now get all the surveyors assigned to this survey
							
							$this->db->where('program_id', $programID);
							
							$this->db->where('survey_id', $surveyID);
							
							$surveyorsQuery			=	$this->db->get('program_survey_surveyor');
							
							if($surveyorsQuery->num_rows() > 0)
							{
								
								$surveyors					=	$surveyorsQuery->result_array();
								
								foreach($surveyors as $surveyor)
								{
									
									//get the surveyor details and check if he/she has supplied a response in the surveyor response table
									
									$surveyParticipantID		=	$surveyor['survey_participant_id'];
									
									$surveyorID					=	$surveyor['survey_surveyor_id'];
									
									$surveyorName				=	ucfirst($surveyor['name']);
									
									$surveyorEmail				=	$surveyor['email'];	
									
									$surveyorRelationship		=	$surveyor['relationship'];
									
									//check if this surveyor has a record in the response table
									
									$this->db->where('program_id', $programID);
									
									$this->db->where('survey_id', $surveyID);
									
									$this->db->where('survey_participant_id', $surveyParticipantID);
									
									$this->db->where('survey_surveyor_id', $surveyorID);
									
									$surveyorResponseQuery		=	$this->db->get('program_survey_response');
									
									if($surveyorResponseQuery->num_rows() > 0)
									{
										
										//means this user has answered the survey or parts of it
										
									}else{
										
										//means this user has not answered the survey so send them a reminder
										
										//check if this surveyor is the participant
										
										if($surveyorRelationship != 'Self')
										{
											
											$this->db->where('survey_participant_id', $surveyParticipantID);
										
											$participantDetails			=	$this->db->get('program_survey_participant')->row_array();
											
											$participantName			=	ucfirst($participantDetails['first_name']).' '.ucfirst($participantDetails['last_name']);
										
										}else{
											
											//means this surveyor is self evaluating
											
											$participantName			=	ucfirst($surveyorName);
											
										}
										
										
										$url					=	'<a href="'.base_url().'survey/get-started/'.$surveyID.'/'.$surveyorID.'/'.$surveyParticipantID.'/">'.base_url().'survey/get-started/'.$surveyID.'/'.$surveyorID.'/'.$surveyParticipantID.'/'.'</a>';
										
										$mailSent				=	$this->send_surveyor_reminder_mail($surveyID, $surveyName, $participantName, $surveyorName, $surveyorEmail, $url);
										
									}
									
								}
								
							}else{
								
								//means no surveyors can be found for this survey belonging to this program	
							}
							
						}
						
						$count++;						
						
					}else{
						
						//this program does not have surveys
						
					}

					
				}else{
					
					//echo 'The date is a past date, program has ended so do not send reminder';

				}
					
				
			}
			
			if($count == $sizeResult)
			{
				
				$response['status']		=	'Success';
			
				$response['message']	=	'All records were dealt with';
				
			}else{
				
				$response['status']		=	'Failed';
			
				$response['message']	=	$sizeResult.' Records found '.$count.' Records actioned on';
			
			}
			
		}else{
			
			$response['status']		=	'Failed';
			
			$response['message']	=	'No program found';
				
		}
		
		return $response;
		
	}
	
	
	// send the user a token for confirmation of email
	public function send_surveyor_reminder_mail($surveyID, $surveyName, $participantName, $surveyorName, $surveyorEmail, $url)
	{

		$site_email 			= 	$this->site_email; 
		
		$platform_name 			= 	$this->company_name;
		
		$site_logo				= 	$this->site_logo;
		
		$row 					= 	$this->get_survey_message('Reminder Email', $surveyID);
		
		$row['content'] 		= 	html_entity_decode($row['content']);
		
		// set replacement values for subject & body
		// {customer_name}
		
		$row['content'] 		= 	str_replace('[Evaluator Name]',  $surveyorName, $row['content']);
		
		$row['content'] 		= 	str_replace('[Assessment Name]',  $surveyName, $row['content']);
		
		$row['content'] 		= 	str_replace('[Participant Name]',  $participantName, $row['content']);
				
		// {url}
		$row['content'] 		= 	str_replace('[url]', $url, $row['content']);
		
		// {site_logo}
		//$row['content'] 		= 	str_replace('{site_logo}', $site_logo, $row['content']);
		
		$mailBody				=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>

<body>

<style>

.container {
  padding-right: 15px;
  padding-left: 15px;
   width:90%;
  margin-right: auto;
  margin-left: auto;
}

.col-md-12{
  padding-right: 15px;
  padding-left: 15px;
  
}

.mail-welcome-hdr{
	font-size:18px;
	padding-top:10px;
	padding-bottom:10px;
	margin-bottom:10px;
	margin-top:10px;
	background-color: #0071f6;
	text-transform: uppercase;
	font-family:Verdana, Geneva, sans-serif;
	font-weight: 700;
	color:#fff;
	text-align:center;
}

.mail-msg-usr-hdr{
	font-weight:600;
}

.mail-msg-cnt ul{
	padding-left:15px;
}

.mail-msg-cnt ul li{
	margin-top:10px;
	margin-bottom:10px;	
}

.msg-mail-cnct{
	color: #0071f6;
	font-weight:600;
}

.msg-mail-cnct a{
	text-decoration:none;
	color: #0071f6;
}

.mail-cust-name{
	font-weight:600;
}

.tp-contacts{
	padding-top:3px;
	overflow:auto;
	text-align:center;
}

.tp-contacts ul{
	padding-left:0px;
	display: inline-block;
}

.tp-contacts ul li{
	float:left;
	display:inline-block;
	margin-left:5px;
	margin-right:5px;	
	padding-right:15px;
	padding-left:10px;
	font-family: "AlegreyaSansSC-Thin";
	font-size:14px;
	font-weight:600;
	border-right:1px solid #000;
}

.tp-contacts ul li:last-child{
	border:none;
	padding-right:0px;
	margin-right:0px;
}

.top-logo{
	text-align:center;
}

</style>

<div class="" style="padding-bottom:30px; padding-top:30px; padding-left:0px; padding-right:0px; background-color:#cccccc; ">

	<div class="container" style="background-color:#fff; padding-bottom:20px; padding-top:20px;">
    
    	<div class="col-md-12">
            
            <div class="top-logo">
            	
                <img src="'.$site_logo.'" />
                                
            </div>

            
        </div>
        
        <div class="col-md-12">
        	
            <div class="mail-welcome-hdr">
            	
               Reminder
                
            </div>
            
        </div>
        
        <div class="col-md-12">
        
        	<div class="" style="margin-bottom:10px; padding-left:10px; line-height:25px;">
			
			
				'.$row['content'].'
			
			</div>
            
        </div>
        
    </div>
    
</div>

</body>
</html>';	

		//$mailBody 		= 	html_entity_decode($mailBody);
		
		$config['mailtype'] 	= 	'html';
		
		$this->email->initialize($config);

		$this->email->from($site_email, $platform_name);
		
		$this->email->to($surveyorEmail);

		$this->email->subject('Reminder of '.$surveyName.' for '.$participantName.'');
		
		$this->email->message($mailBody);
		
		//$this->email->send();
		
		if (!$this->email->send())
		{
		
			//echo 'Failed';
		
		// Loop through the debugger messages.
			foreach ($this->email->get_debugger_messages() as $debugger_message)
			{
		  	
				echo $debugger_message;
			
			}
		
			// Remove the debugger messages as they're not necessary for the next attempt.
			$this->email->clear_debugger_messages();
			
			return FALSE;
		
		}else
		{
		
			return TRUE;
		
		}

	}
	
}