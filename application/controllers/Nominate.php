<?php
class Nominate extends CI_Controller 
{
		
	public function __construct()
	{
		parent::__construct();
		
		//for users who have logged out and want to use the 
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		
		$this->output->set_header('Pragma: no-cache');
				
		$this->company_name			=	'PIPA';
		
		$this->site_logo			= 	base_url().'asset/images/logo.png';
		
		$this->load->model('nominate_model');
				
	}
	
	public function index($surveyID=false, $participantID=false)
	{
		
		$data['title']			= 	"Nominate :: Participant";
		
		if(!empty($surveyID))
		{
			
			$checkSurvey		=	$this->analyze_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{
			
				$this->load->view('nominate/home', $data);
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
				redirect(base_url().'nominate/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
			redirect(base_url().'nominate/error/', 'refresh');	
			
		}
		
	}
	
	public function get_started($surveyID=false, $participantID=false)
	{		

		$data['title']						= 	"Getting Started :: Nomination";

		if(!empty($surveyID))
		{
			
			$checkSurvey		=	$this->nominate_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->nominate_model->check_participant($surveyID, $participantID);
					
				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;
					
					
					$data['participantDetail']		=	$this->nominate_model->get_participant_details($checkParticipant['survey_participant_id']);
					
					
					$data['companyDetails']			=	$this->nominate_model->get_company_details($checkParticipant['company_id']);
					
					
					$this->load->view('nominate/home', $data);
		
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
			
					redirect(base_url().'nominate/error/', 'refresh');
				
				} 
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
				redirect(base_url().'nominate/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
			redirect(base_url().'nominate/error/', 'refresh');	
			
		} 
		
	}
	
	public function error()
	{
		
		$data['title']			= 	"Error";
		
		$this->load->view('nominate/error', $data);

	}

	public function evaluator_entry($surveyID=false, $participantID=false)
	{

		$data['title']						= 	"Evaluator Entry :: Nomination";

		if(!empty($surveyID))
		{
			
			$checkSurvey		=	$this->nominate_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->nominate_model->check_participant($surveyID, $participantID);

				json_encode(array(
					'success' => true,
					'message' => 'Nominees successfully saved',
					'data' => $checkParticipant
				));  
					
				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;
					
					
					$data['participantDetail']		=	$this->nominate_model->get_participant_details($checkParticipant['survey_participant_id']);
					
					
					$data['companyDetails']			=	$this->nominate_model->get_company_details($checkParticipant['company_id']);
					
					
					$this->load->view('nominate/evaluator-entry', $data);
		
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
			
					redirect(base_url().'nominate/error/', 'refresh');
				
				} 
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
				redirect(base_url().'nominate/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
			redirect(base_url().'nominate/error/', 'refresh');	
			
		}
	}

	public function save_nominees($surveyID=false, $participantID=false)
	{				 

		if(!empty($surveyID))
		{
			
			$checkSurvey		=	$this->nominate_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->nominate_model->check_participant($surveyID, $participantID);
					
				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;
					
					
					$data['participantDetail']		=	$this->nominate_model->get_participant_details($checkParticipant['survey_participant_id']);
					
					
					$data['companyDetails']			=	$this->nominate_model->get_company_details($checkParticipant['company_id']);
					
					// perform record insertion here
					$counter						= 	0;

					if(empty($this->input->post('nominees')) || count($this->input->post('nominees')) == 0 ){
						echo json_encode(array(
							'success' => false,
							'message' => 'Please add atleast 1 nominee',
							'data' => null
						));
						return;
					}

					foreach ($this->input->post('nominees') as $nominees)
					{ 
						
						$save['program_id']					= 	$checkSurvey['program_id']; 
						
						$save['survey_id']					= 	$surveyID;

						$save['name']						= 	$nominees['firstname'] . ' ' . $nominees['lastname'];
						
						$save['email']						= 	$nominees['email'];
						
						$save['phone_number']				= 	$nominees['phone'];

						$save['evaluator_type']				= 	$nominees['category'];

						$save['participant_id']				= 	$participantID;

						// $save['nominated_by_surveyor_id']	= 	'';

						// $save['approved_by_surveyor_id']	= 	'';	

						// $save['approved']					= 	'';						
						
						// $save['selected']					= 	'';	

						$save['date_created']				= 	date("Y-m-d H:i:s");

						$action_plan_id						= 	$this->nominate_model->save_nominee($save); 
		
						if(!empty($action_plan_id)) // if the user's credentials validated...
						{					
							
							$nominees['saved']				=	true;
							
						}
						else 
						{

							$nominees['saved']				=	false;
						
						} 
					
					}

					echo json_encode(array(
						'success' => true,
						'message' => 'Nominees successfully saved',
						'data' => $nominees
					));
		
				}else{
										
					echo json_encode(array(
						'success' => false,
						'message' => 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.',
						'data' => null
					));
					
				} 
			
			}else{ 

				echo json_encode(array(
					'success' => false,
					'message' => 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.',
					'data' => null
				));
				
			}
			
		}else{
						
			echo json_encode(array(
				'success' => false,
				'message' => 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.',
				'data' => null
			));
			
		}
		
	}

	public function thank_you($surveyID=false, $participantID=false)
	{

		$data['title']						= 	"Thank you :: Nomination";

		if(!empty($surveyID))
		{
			
			$checkSurvey		=	$this->nominate_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->nominate_model->check_participant($surveyID, $participantID);

				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;
					
					
					$data['participantDetail']		=	$this->nominate_model->get_participant_details($checkParticipant['survey_participant_id']);
					
					
					$data['companyDetails']			=	$this->nominate_model->get_company_details($checkParticipant['company_id']);
					
					// send email to line manager
					if($this->nominate_model->request_nominee_approval_email($checkParticipant, $checkSurvey)){
						$this->load->view('nominate/thank-you', $data);
					}else{
						$data['error_msg'] 				= 	'Please contact your line manager';
						$this->load->view('nominate/thank-you', $data);
					}					
		
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
			
					redirect(base_url().'nominate/error/', 'refresh');
				
				} 
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
				redirect(base_url().'nominate/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
			redirect(base_url().'nominate/error/', 'refresh');	
			
		}
	}

	public function approve($surveyID=false, $participantID=false)
	{		

		$data['title']						= 	"Approve Nominees :: Nomination";

		if(!empty($surveyID))
		{
			
			$checkSurvey		=	$this->nominate_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->nominate_model->check_participant($surveyID, $participantID);
					
				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;
					
					
					$data['participantDetail']		=	$this->nominate_model->get_participant_details($checkParticipant['survey_participant_id']);
					
					
					$data['companyDetails']			=	$this->nominate_model->get_company_details($checkParticipant['company_id']);

					$data['lineManager']			= 	$this->nominate_model->get_line_manager($checkParticipant['survey_participant_id'], $checkParticipant['program_id']);
					
					
					$this->load->view('nominate/approve-nominees', $data);
		
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
			
					redirect(base_url().'nominate/error/', 'refresh');
				
				} 
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
				redirect(base_url().'nominate/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
			redirect(base_url().'nominate/error/', 'refresh');	
			
		} 
		
	}

	public function approve_confirm($surveyID=false, $participantID=false)
	{		

		$data['title']						= 	"Approve Confirm :: Nomination";

		if(!empty($surveyID))
		{
			
			$checkSurvey		=	$this->nominate_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->nominate_model->check_participant($surveyID, $participantID);
					
				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;
					
					
					$data['participantDetail']		=	$this->nominate_model->get_participant_details($checkParticipant['survey_participant_id']);
					
					
					$data['companyDetails']			=	$this->nominate_model->get_company_details($checkParticipant['company_id']);

					$data['lineManager']			= 	$this->nominate_model->get_line_manager($checkParticipant['survey_participant_id'], $checkParticipant['program_id']);
					
					$data['nominees']				= 	$this->nominate_model->get_participant_nominees($checkParticipant['survey_participant_id'], $checkParticipant['program_id'], $surveyID);					
					
					$this->load->view('nominate/approve-confirm', $data);
		
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
			
					redirect(base_url().'nominate/error/', 'refresh');
				
				} 
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
				redirect(base_url().'nominate/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
			redirect(base_url().'nominate/error/', 'refresh');	
			
		} 
		
	}

	public function approve_nominee($surveyID=false, $participantID=false)
	{				 

		if(!empty($surveyID))
		{
			
			$checkSurvey		=	$this->nominate_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->nominate_model->check_participant($surveyID, $participantID);
					
				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;
					
					
					$data['participantDetail']		=	$this->nominate_model->get_participant_details($checkParticipant['survey_participant_id']);
					
					
					$data['companyDetails']			=	$this->nominate_model->get_company_details($checkParticipant['company_id']);
					
					// perform record insertion here
					$counter						= 	0;

					if(empty($this->input->post('nominees')) || count($this->input->post('nominees')) == 0 ){
						echo json_encode(array(
							'success' => false,
							'message' => 'Please add atleast 1 nominee',
							'data' => null
						));
						return;
					}

					foreach ($this->input->post('nominees') as $nominees)
					{  

						$save['approved']					= 	$nominees['approved'];
						
						$save['nominee_id']					= 	$nominees['nominee_id'];  						

						$save['approval_email_sent']		= 	1;

						$nominee_id							= 	$this->nominate_model->save_nominee($save); 
		
						if(!empty($nominee_id))
						{					
							
							$nominees['updated']			=	true;
							
						}
						else 
						{

							$nominees['updated']			=	false;
						
						} 
					
					}

					echo json_encode(array(
						'success' => true,
						'message' => 'Nominees approval successfully submitted',
						'data' => $nominees
					));
		
				}else{
										
					echo json_encode(array(
						'success' => false,
						'message' => 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.',
						'data' => null
					));
					
				} 
			
			}else{ 

				echo json_encode(array(
					'success' => false,
					'message' => 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.',
					'data' => null
				));
				
			}
			
		}else{
						
			echo json_encode(array(
				'success' => false,
				'message' => 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.',
				'data' => null
			));
			
		}
		
	}

	public function approved_success($surveyID=false, $participantID=false)
	{

		$data['title']						= 	"Thank You :: Nomination";

		if(!empty($surveyID))
		{
			
			$checkSurvey		=	$this->nominate_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->nominate_model->check_participant($surveyID, $participantID);

				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;
					
					
					$data['participantDetail']		=	$this->nominate_model->get_participant_details($checkParticipant['survey_participant_id']);
					
					
					$data['companyDetails']			=	$this->nominate_model->get_company_details($checkParticipant['company_id']);
					
					$data['lineManager']			= 	$this->nominate_model->get_line_manager($checkParticipant['survey_participant_id'], $checkParticipant['program_id']);
					
					// send email to line manager
					if($this->nominate_model->thank_you_email($checkParticipant, $checkSurvey)){
						$this->load->view('nominate/thank-you-manager', $data);
					}else{
						$data['error_msg'] 				= 	'Please contact your direct report';
						$this->load->view('nominate/thank-you-manager', $data);
					}					
		
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
			
					redirect(base_url().'nominate/error/', 'refresh');
				
				} 
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
				redirect(base_url().'nominate/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
			redirect(base_url().'nominate/error/', 'refresh');	
			
		}
	}
 

	// cron for nominee request mail sent to participants
	public function send_nominee_request_mail_cron()
	{
		$this->nominate_model->send_nominee_request_mail_cron();
	}

	// cron for line manager nominee approval reminder
	public function send_nominee_approval_reminder_cron()
	{
		$this->nominate_model->send_nominee_approval_reminder_cron();
	}

	// cron for line evaluator random selection
	public function random_evaluator_selection_cron()
	{
		$this->nominate_model->random_evaluator_selection_cron();
	}

}

?>