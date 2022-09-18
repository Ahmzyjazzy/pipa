<?php
class Survey extends CI_Controller 
{
		
	public function __construct()
	{
		parent::__construct();
		
		//for users who have logged out and want to use the 
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		
		$this->output->set_header('Pragma: no-cache');
		
		if(base_url() == 'https://www.naama.io/' || base_url() == 'https://www.naama.io/sandbox/')
		{
			
			$this->site_email 			= 	'noreply@naama.io';
		
		}else{
			
			$this->site_email 			= 	'noreply@aeriksoftsolutions.com';
		}
		
		$this->company_name			=	'PIPA';
		
		$this->site_logo			= 	base_url().'asset/images/logo.png';
		
		$this->load->model('participant_model');
				
	}
	
	public function index($surveyID=false, $participantID=false, $surveyorID=false)
	{
		
		$data['title']			= 	"Login :: Admin";
		
		if(!empty($surveyID))
		{
			
			$checkSurvey		=	$this->participant_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{
			
				$this->load->view('survey/home', $data);
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Survey Reference, Please Provide the right Survey Reference to Proceed.');
				
				redirect(base_url().'survey/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Survey Reference, Please Provide the right Survey Reference to Proceed.');
				
			redirect(base_url().'survey/error/', 'refresh');	
			
		}
		
	}
	
	public function get_started($surveyID=false, $surveyorID=false, $participantID=false)
	{
		
		$data['title']						= 	"Get Started";
		
		if(!empty($surveyID))
		{
			
			$checkSurvey					=	$this->participant_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{
				
				//check the surveyor id and if it is assigned this survey
				
				$checkSurveyor				=	$this->participant_model->check_surveyor($surveyID, $surveyorID);
				
				if(!empty($checkSurveyor))
				{					
					
					$checkParticipant		=	$this->participant_model->check_participant($surveyID, $surveyorID, $participantID);
					
					if(!empty($checkParticipant))
					{
						
						$data['surveyor']				=	$checkParticipant;
						
						
						$data['participantDetails']		=	$this->participant_model->get_participant_details($checkParticipant['survey_participant_id']);
						
						
						$data['companyDetails']			=	$this->participant_model->get_company_details($checkParticipant['company_id']);
						
						
						$this->load->view('survey/home', $data);
			
					}else{
						
						$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
				
						redirect(base_url().'survey/error/', 'refresh');
					
					}
					
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Surveyor Reference, Please Provide the right Surveyor Reference to Proceed.');
				
					redirect(base_url().'survey/error/', 'refresh');
					
				}
				
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Survey Reference, Please Provide the right Survey Reference to Proceed.');
				
				redirect(base_url().'survey/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Survey Reference, Please Provide the right Survey Reference to Proceed.');
				
			redirect(base_url().'survey/error/', 'refresh');	
			
		}
		
	}
	
	public function error()
	{
		
		$data['title']			= 	"Error";
		
		$this->load->view('survey/error', $data);

	}
	
	public function survey_questions($surveyID=false, $surveyorID=false, $participantID=false)
	{
		
		$data['title']						= 	"Survey Questions";
		
		if(!empty($surveyID))
		{
			
			$checkSurvey					=	$this->participant_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{
				
				//check the surveyor id and if it is assigned this survey
				
				$checkSurveyor				=	$this->participant_model->check_surveyor($surveyID, $surveyorID);
				
				if(!empty($checkSurveyor))
				{					
					
					$checkParticipant		=	$this->participant_model->check_participant($surveyID, $surveyorID, $participantID);
					
					if(!empty($checkParticipant))
					{
						
						$data['surveyor']				=	$checkParticipant;
						
						$data['participantDetails']		=	$this->participant_model->get_participant_details($checkParticipant['survey_participant_id']);
						
						$data['companyDetails']			=	$this->participant_model->get_company_details($checkParticipant['company_id']);
						
						$competency_Questions			=	$this->participant_model->get_survey_participant_competency_questions($checkParticipant['survey_id'], $surveyorID, $participantID);
						
						$open_ended_Questions			=	$this->participant_model->get_survey_participant_open_ended_questions($checkParticipant['survey_id'], $surveyorID, $participantID);
						
						if(!empty($competency_Questions))
						{
							
							//if the standard competency questions is not empty
							
							$data['currentSection']		=	1;
							
							$data['totalSections']		=	1;
							
							$data['questions']			=	$competency_Questions;
							
							//now check if the open ended questions is also not empty
							
							if(!empty($open_ended_Questions))
							{
								
								$data['totalSections']		=	2;	
								
							}
							
							$this->load->view('survey/survey', $data);
							
						}elseif(!empty($open_ended_Questions)){
							
							//means its only open ended question that was supplied
							
							$data['currentSection']			=	0;
							
							if(!empty($open_ended_Questions))
							{
								
								$data['currentSection']		=	1;
								
								$data['totalSections']		=	1;	
								
								$data['questions']			=	$open_ended_Questions;
								
							}else{
								
								$data['totalSections']		=	0;
								
							}
						
							$this->load->view('survey/survey', $data);
							
						}else{
							
							//this means the user has answered all the survey questions	
							
							$this->load->view('survey/completed-link', $data);
							
						}
						
						
						
						//$this->load->view('survey/thank-you', $data);
			
					}else{
						
						$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
				
						redirect(base_url().'survey/error/', 'refresh');
					
					}
					
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Surveyor Reference, Please Provide the right Surveyor Reference to Proceed.');
				
					redirect(base_url().'survey/error/', 'refresh');
					
				}
				
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Survey Reference, Please Provide the right Survey Reference to Proceed.');
				
				redirect(base_url().'survey/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Survey Reference, Please Provide the right Survey Reference to Proceed.');
				
			redirect(base_url().'survey/error/', 'refresh');	
			
		}
		
	}
	
	public function submit_survey($surveyID=false, $surveyorID=false, $participantID=false)
	{
		
		$data['title']						= 	"Survey Questions";
		
		if(!empty($surveyID))
		{
			
			$checkSurvey					=	$this->participant_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{
				
				//check the surveyor id and if it is assigned this survey
				
				$checkSurveyor				=	$this->participant_model->check_surveyor($surveyID, $surveyorID);
				
				if(!empty($checkSurveyor))
				{					
					
					$checkParticipant		=	$this->participant_model->check_participant($surveyID, $surveyorID, $participantID);
					
					if(!empty($checkParticipant))
					{
						
						$data['surveyor']				=	$checkParticipant;
						
						
						$data['participantDetails']		=	$this->participant_model->get_participant_details($checkParticipant['survey_participant_id']);
						
						
						$data['companyDetails']			=	$this->participant_model->get_company_details($checkParticipant['company_id']);

						$competency_Questions			=	$this->participant_model->get_survey_participant_competency_questions($checkParticipant['survey_id'], $surveyorID, $participantID);
						
						$open_ended_Questions			=	$this->participant_model->get_survey_participant_open_ended_questions($checkParticipant['survey_id'], $surveyorID, $participantID);
						
						
						if(!empty($competency_Questions))
						{
							
							//if the standard competency questions is not empty
							
							$data['currentSection']		=	1;
							
							$data['totalSections']		=	1;
							
							//now check if the open ended questions is also not empty
							
							if(!empty($open_ended_Questions))
							{
								
								$data['totalSections']		=	2;	
								
							}
														
						}else{
							
							//means its only open ended question that was supplied
							
							$data['currentSection']			=	0;
							
							if(!empty($open_ended_Questions))
							{
								
								$data['currentSection']		=	1;
								
								$data['totalSections']		=	1;	
								
							}else{
								
								$data['totalSections']		=	0;
								
							}
						
						}
						
						
						$fieldName							=	$this->input->post('fieldName');
						
						$currentSection						=	$this->input->post('currentSection');
												
						//this means the page submitted was the first section
						
						$save['surveyQuestions']			=	$fieldName;
							
						$save['company_id']					=	$checkParticipant['company_id'];
						
						$save['survey_surveyor_id']			=	$surveyorID;
					
						$save['program_id']					=	$checkParticipant['program_id'];
					
						$save['survey_id']					=	$surveyID;
						
						$save['survey_participant_id']		=	$participantID;
						
						$query								=	$this->participant_model->save_survey_response($save);
						
						if($query['status'] == 'Success')
						{
						
							//check the current section and see if its all the questions that was answered
							
							//if yes then move to next question if no then still show the current section and tell the user his/her survey has been saved
							
							$sizeofQuestionsAnswered		=	$query['answeredCount'];

							if($currentSection < $data['totalSections'])
							{
							
								//now check if the size of the questions answered is equal to the size of the questions for that section
								
								$sizeofQuestions			=	sizeof($competency_Questions);

								if($sizeofQuestionsAnswered < $sizeofQuestions)
								{
									
									//redirect the user back to the main survey page and tell them their save was successful then they should continue	
									
									$this->session->set_flashdata('success-message', 'Survey Saved Successfully, You can continue from where you stopped');
				
									redirect(base_url().'survey/survey-questions/'.$surveyID.'/'.$surveyorID.'/'.$participantID.'/', 'refresh');
									
								}else{
								
									//do the submit response and return the user to the survey page to finish the last section of the survey
									
									$currentSection++;
									
									$data['currentSection']		=	$currentSection;
									
									$data['questions']			=	$open_ended_Questions;
	
									$this->load->view('survey/survey', $data);
								
								}
								
							}elseif($currentSection == $data['totalSections']){
								
								if(!empty($open_ended_Questions))
								{
									
									$sizeofQuestions			=	sizeof($open_ended_Questions);
								
								}elseif(!empty($competency_Questions))
								{
									
									$sizeofQuestions			=	sizeof($competency_Questions);
									
								}
		
								if($sizeofQuestionsAnswered < $sizeofQuestions)
								{
									
									//redirect the user back to the main survey page and tell them their save was successful then they should continue	
									
									$this->session->set_flashdata('success-message', 'Survey Saved Successfully, You can continue from where you stopped');
				
									redirect(base_url().'survey/survey-questions/'.$surveyID.'/'.$surveyorID.'/'.$participantID.'/', 'refresh');
									
								}else{
									
									//this means the page submitted was equal to the total section and is the last
									
									//do the submit and return the user to the completion page
									
																		
									$participantName			=	ucfirst($data['participantDetails']['first_name']).' '.ucfirst($data['participantDetails']['last_name']);;
									
									if($data['participantDetails']['gender'] == 'MALE' || $data['participantDetails']['gender'] == 'M')
									{
										
										$participantGender		=	'He';
										
									}elseif($data['participantDetails']['gender'] == 'FEMALE' || $data['participantDetails']['gender'] == 'F')
									{
										
										$participantGender		=	'She';
									
									}else{
										
										$participantGender		=	'He/She';
									}
									
									$surveyorName				=	$data['surveyor']['name'];
									
									$surveyorEmail				=	$data['surveyor']['email'];
									
									if($checkSurvey['survey_type'] == '360 assessment')
									{
										
										$assessmentType				=	'360';
									
									}else{
										
										$assessmentType				=	$checkSurvey['survey_type'];
										
									}
									
									$this->send_surveyor_thank_you_mail($surveyID, $participantName, $participantGender, $surveyorName, $surveyorEmail, $assessmentType);
									
									
									$this->load->view('survey/thank-you', $data);
								
								}
								
							}else{
								
								if(!empty($open_ended_Questions))
								{
									
									$sizeofQuestions			=	sizeof($open_ended_Questions);
								
								}elseif(!empty($competency_Questions))
								{
									
									$sizeofQuestions			=	sizeof($competency_Questions);
									
								}
		
								if($sizeofQuestionsAnswered < $sizeofQuestions)
								{
									
									//redirect the user back to the main survey page and tell them their save was successful then they should continue	
									
									$this->session->set_flashdata('success-message', 'Survey Saved Successfully, You can continue from where you stopped');
				
									redirect(base_url().'survey/survey-questions/'.$surveyID.'/'.$surveyorID.'/'.$participantID.'/', 'refresh');
									
								}else{
									
									//this means the page submitted was equal to the total section and is the last
									
									$participantName			=	ucfirst($data['participantDetails']['first_name']).' '.ucfirst($data['participantDetails']['last_name']);;
									
									if($data['participantDetails']['gender'] == 'MALE' || $data['participantDetails']['gender'] == 'M')
									{
										
										$participantGender		=	'He';
										
									}elseif($data['participantDetails']['gender'] == 'FEMALE' || $data['participantDetails']['gender'] == 'F')
									{
										
										$participantGender		=	'She';
									
									}else{
										
										$participantGender		=	'He/She';
									}
									
									$surveyorName				=	$data['surveyor']['name'];
									
									$surveyorEmail				=	$data['surveyor']['email'];
									
									if($checkSurvey['survey_type'] == '360 assessment')
									{
										
										$assessmentType				=	'360';
									
									}else{
										
										$assessmentType				=	$checkSurvey['survey_type'];
										
									}
									
									$this->send_surveyor_thank_you_mail($surveyID, $participantName, $participantGender, $surveyorName, $surveyorEmail, $assessmentType);
									
									//do the submit and return the user to the completion page
									
									$this->load->view('survey/thank-you', $data);
								
								}
								
							}
												
						}else{
							
							$this->session->set_flashdata('message', $query['reason']);
				
							redirect(base_url().'survey/survey-questions/'.$surveyID.'/'.$surveyorID.'/'.$participantID.'/', 'refresh');
							
						}
						
			
					}else{
						
						$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
				
						redirect(base_url().'survey/error/', 'refresh');
					
					}
					
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Surveyor Reference, Please Provide the right Surveyor Reference to Proceed.');
				
					redirect(base_url().'survey/error/', 'refresh');
					
				}
				
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Survey Reference, Please Provide the right Survey Reference to Proceed.');
				
				redirect(base_url().'survey/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Survey Reference, Please Provide the right Survey Reference to Proceed.');
				
			redirect(base_url().'survey/error/', 'refresh');	
			
		}	
		
	}
	
	
	public function is_logged_in()
	{
		
		$is_logged_in 			=	$this->session->userdata('is_logged_in');
		
		$user_id 				= 	$this->session->userdata('user_id');
		
		if(!isset($is_logged_in) || $is_logged_in != true || $user_id == 0 || $user_id == "")
		{
			//echo 'You don\'t have permission to access this page. <a href="index">Login</a>';	
			//die();

			redirect('admin');

		}	
		
		/*$this->session->sess_destroy();
		
		redirect('user/maintenance/');	*/
	}
		
	public function login()
	{
		
		$data['title']			= 	"Login :: Admin";
		
		$this->load->view('admin/login', $data);

	}

	
	public function validate_credentials()
	{		
		//validation begins 08078981609
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
			
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[128]');
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
				
		//$refer_from = $this->input->post('refer_from');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->login();
		}
		else
		{					
				
			$username		= 	$this->input->post('username');
			
			$password		= 	$this->input->post('password');
			
			$query 			= 	$this->membership_model->validate_admin($username, $password);
	
			
			if($query['status'] == 'Success') // if the user's credentials validated...
			{	
			
				/*$data['title']		=	'Login :: PIPA';
				
				$data['email']		=	$query['data']['email'];
				
				$data['message']	=	$query['message'];				
										
				$this->load->view('admin/login-otp', $data);*/
				
				redirect('admin/dashboard');
				
			}
			else // incorrect username or password
			{

				$this->session->set_flashdata('message', ''.$query['status'].': '.$query['message'].'');
		
				redirect(base_url().'admin/login/');

			}
				
		}
		
	}
	
	// send the user a token for confirmation of email
	public function send_surveyor_thank_you_mail($surveyID, $participantName, $participantGender, $surveyorName, $surveyorEmail, $assessmentType)
	{

		$site_email 			= 	$this->site_email; 
		
		$platform_name 			= 	$this->company_name;
		
		$site_logo				= 	$this->site_logo;
		
		$row 					= 	$this->participant_model->get_survey_message('Thank you Email', $surveyID);
		
		$row['content'] 		= 	html_entity_decode($row['content']);
		
		// set replacement values for subject & body
		// {customer_name}
		
		$row['content'] 		= 	str_replace('[Evaluator Name]',  $surveyorName, $row['content']);
		
		$row['content'] 		= 	str_replace("[Participant Name]",  $participantName, $row['content']);
		
		$row['content'] 		= 	str_replace('[He/She]',  $participantGender, $row['content']);
		
		$row['content'] 		= 	str_replace('[Assessment Name]',  $assessmentType, $row['content']);

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
            	
               Thank You
                
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

		$this->email->subject('Thank you');
		
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

?>