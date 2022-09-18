<?php
class Participant_model extends CI_Model {
	
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
	
	function validate_participant($username, $password)
	{
		
		$this->db->where('email', $username);
					
		$query 				= 	$this->db->get('user');
		
		if($query->num_rows() > 0)
		{
			$ret_id 		= 	$query->row();
			
			//now check if the user account is active
			//get the user trying to login

			
			//check if the password has been set for this user
			/*if($ret_id ->user_id != '1')
			{
				
				return FALSE;
					
			}else{*/
				
			if(!empty($ret_id ->password))
			{
				
				if($ret_id->password == md5($password))
				{
	
					$id 				= 	$ret_id ->user_id;
					
					$data 				= 	array(
					
						'user_id' 					=> 	$ret_id->user_id,
						
						'is_participant_logged_in' 	=> 	true,
		
						'firstname' 				=> 	$ret_id->first_name,
		
						'lastname' 					=> 	$ret_id->last_name,
						
						'company_id' 				=> 	$ret_id->company_id
		
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
				
				//a password has not been set for this account
			
				$data 					= 	array(
				
					'set_cred_email' 	=> 	$username,
		
				);
				
				$this->session->set_userdata($data);
					
				$response	=	array(
				
					'status'	=>	'No Password',
				
					'message'	=>	'Setup password for your account to continue'
				
				);
				
			}
			
			/*}*/
		
		}else{
			
			//this account does not exist			
			$response	=	array(
			
				'status'	=>	'Error',
				
				'message'	=>	'Account does not exist'
				
			);
			
		}
		
		return $response;
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
	
	public function set_participant_credentials($email, $password)
	{
				
		$response		=	array();
		
		$this->db->where('email', $email);
		
		$query			=	$this->db->get('user');
		
		if($query->num_rows() > 0)
		{
			
			$user		=	$query->row_array();
					
			$this->db->where('user_id', $user['user_id']);
			
			$performQuery		=	$this->db->update('user', array('password'=>md5($password)));
			
			if($performQuery)
			{
				
				$id 				= 	$user['user_id'];
				
				$data 				= 	array(
				
					'user_id' 				=> 	$id,
	
					'company_id' 			=> 	$user['company_id'],
	
					'username' 				=> 	$user['username'],
	
					'is_participant_logged_in' 	=> 	true,
	
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
					
					'data'		=>	$data
				
				);
				
			}else{
				
				$response	=	array(
				
					'status'	=>	'Error',
					'message'	=>	'Password creation failed'
				);
			
			}

		}else{
						
			$response['status']		=	'Error';
			
			$response['message']	=	'This account does not exist';
				
		}
				
		return $response;
		
	}
	
	public function check_confirm_participant_credentials($userID)
	{
		
		$response						=	array();
		
		$this->db->where('user_id', $userID);
		
		$query							=	$this->db->get('user');
		
		if($query->num_rows() > 0)
		{
			
			$user						=	$query->row_array();

			//check if the password for this account has been set
			if(!empty($user['password']))
			{
				
				//if this user has a password set previously means he was already a user on the platform automatically log them in and redirect to dashboard
				
				//check if this user has previously logged into the admin
				
				$checkUserSession		=	$this->session->userdata('is_participant_logged_in');
				
				$checkPartUserID		=	$this->session->userdata('user_id');
				
				if(!empty($checkUserSession))
				{
					
					
				
				}else{
					
					//log the admin in	
					$id 					= 	$user['user_id'];
					
					$data 					= 	array(
					
						'user_id' 				=> 	$id,
		
						'company_id' 			=> 	$user['company_id'],
		
						'username' 				=> 	$username,
		
						'is_participant_logged_in' 	=> 	true,
		
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
					
			$response['data']		=	'This credentials are not valid on this platform';
			
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
		
		$query 			= 	$this->db->get('user_password_reset');
		
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
	
	// check if email is unique
	public function check_email_exist($email, $tbl_name)
	{
		
		$this->db->where('email', $email);
		
		$query = $this->db->get($tbl_name);
		
		if($query->num_rows() > 0)
		{
			
			$result 		=	$query->row_array();

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
	
	public function get_user_surveys_participated($userID)
	{
				
		//first fetch all the records where this participant occurs in the survey participant table
		$this->db->where('user_id', $userID);	
		
		$query			=	$this->db->get('program_survey_participant');
		
		if($query->num_rows() > 0)
		{
			
			$result				=	$query->result_array();
			
			$count				=	0;
			
			foreach($result as $res)
			{
				
				$participant[$count]['survey_participant_id']		=	$res['survey_participant_id'];
				
				$participant[$count]['survey_id']					=	$res['survey_id'];
				
				$participant[$count]['survey']						=	$this->get_survey($res['survey_id']);
				
				$participant[$count]['programDetails']				=	$this->get_program($res['program_id']);
				
				$participant[$count]['surveyQuestionSize']			=	$this->get_survey_participant_self_questions_count($res['survey_id']);

				$surveyorDetails									=	$this->get_survey_participant_self_details($res['survey_id'], $res['survey_participant_id'], '0');
					
				$participant[$count]['surveyorDetails']				=	$surveyorDetails;
				
				$participant[$count]['surveySelfResponse']			=	$this->get_survey_participant_self_questions_response_count($res['survey_id'], $surveyorDetails['survey_surveyor_id']);
				
				//now check if this surveyor id has answered any quesion
				
				$count++;
				
			}
			
			return $participant;
			
		}else{
			
			return FALSE;
			
		}
		
	}
	
	public function get_program($program_id=false, $companyID=false)
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

			$response['program_owner_details']		=	$this->get_program_owner_id_details($program_id);
		
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
	
	public function get_survey_participant_self_questions_count($surveyID)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		$query			=	$this->db->get('program_survey_question');
		
		return $query->num_rows();
		
	}
	
	public function get_survey_participant_self_questions_response_count($surveyID, $survey_surveyor_id)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		$this->db->where('survey_surveyor_id', $survey_surveyor_id);
		
		$query			=	$this->db->get('program_survey_response');
		
		return $query->num_rows();
	}
	
	public function get_survey_participant_self_details($surveyID, $surveyParticipantID, $relationshipIndex)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		$this->db->where('survey_participant_id', $surveyParticipantID);
		
		$this->db->where('relationship_index', $relationshipIndex);
		
		$query			=	$this->db->get('program_survey_surveyor');	
		
		return $query->row_array();
		
	}
	
	public function get_survey($surveyID)
	{

		$this->db->where('survey_id', $surveyID);
		
		$query		=	$this->db->get('program_survey');
		
		if($query->num_rows() > 0)
		{
			
			$result['surveyDetails']['survey']				=	$query->row_array();
			
			$result['surveyDetails']['surveySchedule']		=	$this->get_survey_schedule($surveyID);
			
			return $result;
			
		}else{
						
			return FALSE;
				
		}
		
	}
	
	public function get_survey_schedule($surveyID)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		$query			=	$this->db->get('program_survey_schedule');
		
		if($query->num_rows() > 0)
		{
			
			return $query->row_array();
			
		}else{
			
			return FALSE;
			
		}
			
	}
	
	public function check_survey($surveyID)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		
		$query		=	$this->db->get('program_survey');
		
		if($query->num_rows() > 0)
		{
			
			return $query->row_array();
				
		}else{
			
			return FALSE;
			
		}
		
	}
	
	public function check_surveyor($surveyID, $surveyorID)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		$this->db->where('survey_surveyor_id', $surveyorID);
		
		$query		=	$this->db->get('program_survey_surveyor');
		
		if($query->num_rows() > 0)
		{
			
			return $query->row_array();
				
		}else{
			
			return FALSE;
			
		}
		
	}
	
	public function check_participant($surveyID, $surveyorID, $participantID)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		$this->db->where('survey_surveyor_id', $surveyorID);
		
		$this->db->where('survey_participant_id', $participantID);
		
		$query		=	$this->db->get('program_survey_surveyor');
		
		if($query->num_rows() > 0)
		{
			
			return $query->row_array();
				
		}else{
			
			return FALSE;
			
		}
		
	}
	
	public function get_participant_details($participantID)
	{
		
		$this->db->where('survey_participant_id', $participantID);	
		
		$query			=	$this->db->get('program_survey_participant');
		
		if($query->num_rows() > 0)
		{
			
			return $query->row_array();
			
		}else{
			
			return FALSE;
				
		}
		
	}
	
	public function get_company_details($companyID)
	{
		
		$this->db->where('company_id', $companyID);	
		
		$query			=	$this->db->get('company');
		
		if($query->num_rows() > 0)
		{
			
			return $query->row_array();
			
		}else{
			
			return FALSE;
				
		}
		
	}
	
	public function get_survey_participant_competency_questions($surveyID, $surveyorID, $participantID)
	{
		
		//first check if this user has filled anything for this survey
		
		$this->db->where('survey_id', $surveyID);
		
		$this->db->where('survey_surveyor_id', $surveyorID);
		
		$this->db->where('survey_participant_id', $participantID);
		
		$this->db->where('survey_competency_id IS NOT NULL', NULL, FALSE);	
		
		$checkFilled			=	$this->db->get('program_survey_response');
		
		if($checkFilled->num_rows() > 0)
		{
		
			//means the user has filled the survey now fetch what he/she has filled	
			
			$filledAnswers		=	$checkFilled->result_array();
			
			//now get the questions belonging to this particular type of survey
			
			$this->db->where('survey_id', $surveyID);
			
			$this->db->where('survey_competency_id IS NOT NULL', NULL, FALSE);
			
			$getQuestions		=	$this->db->get('program_survey_question');	
			
			if($getQuestions->num_rows() > 0)
			{
				
				$suppliedQuestions		=	$getQuestions->result_array();
				
				//compare the size of the questions and the answer
				
				if(sizeof($filledAnswers) < sizeof($suppliedQuestions))
				{
				
					$fillAnswerArr			=	array();
					
					$suppliedQuestArr		=	array();
					
					//now fetch all the ids of the filled answer into a table
					
					$fillCount				=	1;
					
					foreach($filledAnswers as $filledAnswer)
					{
						
						$fillAnswerArr[$fillCount] =	$filledAnswer['survey_question_id'];
						
						$fillCount++;
						
					}
					
					
					//now fetch all the ids of the supplied questions into a table
					
					$supplyCount				=	1;
					
					foreach($suppliedQuestions as $suppliedQuestion)
					{
						
						$suppliedQuestArr[$supplyCount] =	$suppliedQuestion['survey_question_id'];
						
						$supplyCount++;
						
					}
					
					
					//get the difference between the arrays
					
					$QuestionDiff						=	array_diff($suppliedQuestArr, $fillAnswerArr);
					
					
					if(!empty($QuestionDiff))
					{
							
						//now fetch the questions for the questions that have not been answered
						$this->db->where('survey_id', $surveyID);
				
						$this->db->where_in('survey_question_id', $QuestionDiff);	
						
						$this->db->order_by('survey_question_id','RANDOM');
						
						$unAnsweredQuestquery			=	$this->db->get('program_survey_question')->result_array();
					
					}else{
						
						$unAnsweredQuestquery			=	array();
							
					}
					
					//now get the questions and answer for the one the user supplied
					
					$this->db->select('*');
					
					$this->db->where('program_survey_question.survey_id', $surveyID);
				
					$this->db->where_in('program_survey_question.survey_question_id', $fillAnswerArr);
					
					$this->db->where('program_survey_response.survey_surveyor_id', $surveyorID);
					
					$this->db->where('program_survey_response.survey_participant_id', $participantID);
					
					$this->db->join('program_survey_response', 'program_survey_response.survey_question_id = program_survey_question.survey_question_id', 'left');
					
					$this->db->from('program_survey_question');	
					
					$answeredQuestquery 				= 	$this->db->get()->result_array();
					
					$result								=	array_merge($answeredQuestquery, $unAnsweredQuestquery);
			
					return $result;
									
				}else{
					
					return FALSE;
					
				}
				
			}else{
				
				return FALSE;
					
			}
			
		}else{
			
			//this surveyor has not filled anything yet
			
			$this->db->where('survey_id', $surveyID);
			
			$this->db->where('survey_competency_id IS NOT NULL', NULL, FALSE);	
			
			$this->db->order_by('survey_question_id','RANDOM');
			
			$query			=	$this->db->get('program_survey_question');
			
			if($query->num_rows() > 0)
			{
				/*echo sizeof($query->result_array());
				
				die();*/
				
				return $query->result_array();
				
			}else{
				
				return FALSE;
					
			}
		
		}
		
	}
	
	public function get_survey_participant_open_ended_questions($surveyID, $surveyorID, $participantID)
	{
		
		//first check if this user has filled anything for this survey
		
		$this->db->where('survey_id', $surveyID);
		
		$this->db->where('survey_surveyor_id', $surveyorID);
		
		$this->db->where('survey_participant_id', $participantID);
		
		$this->db->where('survey_competency_id', NULL, FALSE);		
		
		$checkFilled			=	$this->db->get('program_survey_response');
		
		if($checkFilled->num_rows() > 0)
		{
			
			//means the user has filled the survey now fetch what he/she has filled	
			
			$filledAnswers		=	$checkFilled->result_array();
			
			
			//now get the questions belonging to this particular type of survey
			
			$this->db->where('survey_id', $surveyID);
			
			$this->db->where('survey_competency_id', NULL, FALSE);	
			
			$getQuestions		=	$this->db->get('program_survey_question');	
			
			if($getQuestions->num_rows() > 0)
			{
				
				$suppliedQuestions		=	$getQuestions->result_array();
								
				//compare the size of the questions and the answer
				
				if(sizeof($filledAnswers) < sizeof($suppliedQuestions))
				{
					
					$fillAnswerArr			=	array();
					
					$suppliedQuestArr		=	array();
					
					//now fetch all the ids of the filled answer into a table
					
					$fillCount				=	1;
					
					foreach($filledAnswers as $filledAnswer)
					{
						
						$fillAnswerArr[$fillCount] =	$filledAnswer['survey_question_id'];
						
						$fillCount++;
						
					}
					
					
					//now fetch all the ids of the supplied questions into a table
					
					$supplyCount				=	1;
					
					foreach($suppliedQuestions as $suppliedQuestion)
					{
						
						$suppliedQuestArr[$supplyCount] =	$suppliedQuestion['survey_question_id'];
						
						$supplyCount++;
						
					}
					
					
					//get the difference between the arrays
					
					$QuestionDiff						=	array_diff($suppliedQuestArr, $fillAnswerArr);
					
					
					if(!empty($QuestionDiff))
					{
							
						//now fetch the questions for the questions that have not been answered
						$this->db->where('survey_id', $surveyID);
				
						$this->db->where_in('survey_question_id', $QuestionDiff);	
						
						$this->db->order_by('survey_question_id','RANDOM');
						
						$unAnsweredQuestquery			=	$this->db->get('program_survey_question')->result_array();
					
					}else{
						
						$unAnsweredQuestquery			=	array();
							
					}
					
					//now get the questions and answer for the one the user supplied
					
					$this->db->select('*');
					
					$this->db->where('program_survey_question.survey_id', $surveyID);
				
					$this->db->where_in('program_survey_question.survey_question_id', $fillAnswerArr);
					
					$this->db->where('program_survey_response.survey_surveyor_id', $surveyorID);
					
					$this->db->where('program_survey_response.survey_participant_id', $participantID);
					
					$this->db->join('program_survey_response', 'program_survey_response.survey_question_id = program_survey_question.survey_question_id', 'left');
					
					$this->db->from('program_survey_question');	
					
					$answeredQuestquery 				= 	$this->db->get()->result_array();
					
					$result								=	array_merge($answeredQuestquery, $unAnsweredQuestquery);
			
					return $result;
									
				}else{
					
					return FALSE;
					
				}
				
			}else{
				
				return FALSE;
					
			}
			
		}else{
			
			//this surveyor has not filled anything yet
			
			$this->db->where('survey_id', $surveyID);
			
			$this->db->where('survey_competency_id', NULL, FALSE);	
			
			$query			=	$this->db->get('program_survey_question`');
			
			if($query->num_rows() > 0)
			{
				
				return $query->result_array();
				
			}else{
				
				return FALSE;
					
			}
		
		}
		
	}
	
	public function save_survey_response($data)
	{
		
		$survey_surveyor_id  	 		= 	$data['survey_surveyor_id'];
			
		$company_id  					= 	$data['company_id'];
		
		$program_id  					=	$data['program_id'];
		
		$survey_id						= 	$data['survey_id'];
										
		$survey_participant_id 			= 	$data['survey_participant_id'];
		
		$participant['question']  		= 	$data['surveyQuestions'];
		
		if(!empty($participant['question']))
		{
			
			$sizofParticipant					=	sizeof($participant['question']);
		
			$count								=	0;
			
			$answeredQuestcount					=	0;
		
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
				
				$questionDetails						=	$this->get_program_response_competency_id($question_id);
				
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
				
				//check if the response is supplied
				
				//if yes perform the insert if not leave it
				
				if(!empty($save['response_whole_number']) || !empty($save['response_text']))
				{
						
					//perform a check to see if this record exists in the db, if yes just update it instead of inserting
					
					$this->db->where('survey_surveyor_id', $save['survey_surveyor_id']);
					
					$this->db->where('survey_id', $save['survey_id']);
					
					$this->db->where('survey_participant_id', $save['survey_participant_id']);
					
					$this->db->where('survey_question_id', $save['survey_question_id']);
					
					$checkResponse		=	$this->db->get('program_survey_response');
					
					if($checkResponse->num_rows() > 0)
					{
						
						//if this record exists already just update it
						$row			=	$checkResponse->row_array();
						
						$this->db->where('survey_response_id', $row['survey_response_id']);
						
						$this->db->update('program_survey_response', $save);
						
					}else{
					
						$this->db->insert('program_survey_response', $save);
					
					}
					
					$answeredQuestcount++;

				}
				
				$count++;
				
			}

			
			if($sizofParticipant == $count)
			{
					
				$response['status']								=	'Success';
					
				$response['reason']								=	'Surveyors Response successfully uploaded';
				
				$response['answeredCount']						=	$answeredQuestcount;
				
			}else{
				
				$response['status']								=	'Failed';
					
				$response['reason']								=	'There was a problem uploading all records';
				
				$response['answeredCount']						=	$answeredQuestcount;
					
			}
			
		}else{
			
			$response['status']								=	'Error';
					
			$response['reason']								=	'Please Fill Survey Questions to Proceed';
				
		}
		
		return $response;
		
	}
	
	
	function get_program_response_competency_id($questionID)
	{
		
		$this->db->where('survey_question_id', $questionID);
		
		$query		=	$this->db->get('program_survey_question');
		
		return $query->row_array();	
		
	}
	
	function get_survey_message($subject, $surveyID)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		$this->db->where('subject', $subject);
		
		$res 			= 	$this->db->get('program_survey_communication');
		
		return $res->row_array();
		
	}
	
	
}

?>