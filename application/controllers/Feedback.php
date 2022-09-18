<?php
class Feedback extends CI_Controller 
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
		
		$this->load->model('analyze_model');
				
	}
		
	public function get_started($participantID=false, $surveyorID=false, $questionID=false)
	{		

		$data['title']			= 	"Annonymouse :: Feedback";
		
		$data['surveyorDetail']		=	$this->analyze_model->fetch_surveyor_detail($participantID, $surveyorID, $questionID);

		if(!empty($data['surveyorDetail']))
		{
			
			$surveyID			=	$data['surveyorDetail']['survey_id'];

			$checkSurvey		=	$this->analyze_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->analyze_model->check_participant($surveyID, $participantID);
					
				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;

					$data['surveyorID']				=	$surveyorID;					
					
					$data['participantDetail']		=	$this->analyze_model->get_participant_details($checkParticipant['survey_participant_id']);
										
					$data['companyDetails']			=	$this->analyze_model->get_company_details($checkParticipant['company_id']);

					$data['responseDetail']			=	$this->analyze_model->get_surveyor_question_response($surveyID, $participantID, $surveyorID);
									
					$this->load->view('feedback/home', $data);
		
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
			
					redirect(base_url().'feedback/error/', 'refresh');
				
				} 
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
				redirect(base_url().'feedback/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
			redirect(base_url().'feedback/error/', 'refresh');	
			
		} 
		
	}
	
	public function error()
	{
		
		$data['title']			= 	"Error";
		
		$this->load->view('feedback/error', $data);

	}

	public function feedback_entry($participantID=false, $surveyorID=false, $questionID=false)
	{

		$data['title']			= 	"Annonymouse :: Feedback Entry";

		$data['surveyorDetail']		=	$this->analyze_model->fetch_surveyor_detail($participantID, $surveyorID, $questionID);

		if(!empty($data['surveyorDetail']))
		{
			
			$surveyID			=	$data['surveyorDetail']['survey_id'];

			$checkSurvey		=	$this->analyze_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->analyze_model->check_participant($surveyID, $participantID);

				json_encode(array(
					'success' => true,
					'message' => 'Nominees successfully saved',
					'data' => $checkParticipant
				));  
					
				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;
					
					
					$data['participantDetail']		=	$this->analyze_model->get_participant_details($checkParticipant['survey_participant_id']);
					
					
					$data['companyDetails']			=	$this->analyze_model->get_company_details($checkParticipant['company_id']);
					
					
					$this->load->view('feedback/feedback-entry', $data);
		
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
			
					redirect(base_url().'feedback/error/', 'refresh');
				
				} 
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
				redirect(base_url().'feedback/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
			redirect(base_url().'feedback/error/', 'refresh');	
			
		}
	}

	public function post_feedback($participantID=false, $surveyorID=false, $questionID=false)
	{				 

		$data['surveyorDetail']		=	$this->analyze_model->fetch_surveyor_detail($participantID, $surveyorID, $questionID);
		
		if(!empty($data['surveyorDetail']))
		{
			
			$surveyID			=	$data['surveyorDetail']['survey_id'];

			$checkSurvey		=	$this->analyze_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->analyze_model->check_participant($surveyID, $participantID);
					
				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;
					
					
					$data['participantDetail']		=	$this->analyze_model->get_participant_details($checkParticipant['survey_participant_id']);
					
					
					$data['companyDetails']			=	$this->analyze_model->get_company_details($checkParticipant['company_id']);
					

					if(empty($this->input->post('feedback'))){
						echo json_encode(array(
							'success' => false,
							'message' => 'Please enter feedback',
							'data' => null
						));
						return;
					}

					$response					= 	$this->analyze_model->post_feedback($participantID, $surveyorID, $questionID, $this->input->post('feedback')); 
		
					if(!empty($response)) // if the user's credentials validated...
					{					
						echo json_encode(array(
							'success' => true,
							'message' => 'Feedback successfully posted',
							'data' => $response
						));
						
					}
					else 
					{
						echo json_encode(array(
							'success' => false,
							'message' => 'Feedback successfully posted',
							'data' => $this->input->post('feedback')
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
			
		}else{
						
			echo json_encode(array(
				'success' => false,
				'message' => 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.',
				'data' => null
			));
			
		}
		
	}

	public function thank_you($participantID=false, $surveyorID=false, $questionID=false)
	{

		$data['title']						= 	"Thank you :: Feedback";

		$data['surveyorDetail']		=	$this->analyze_model->fetch_surveyor_detail($participantID, $surveyorID, $questionID);

		if(!empty($data['surveyorDetail']))
		{
			
			$surveyID			=	$data['surveyorDetail']['survey_id'];
			
			$checkSurvey		=	$this->analyze_model->check_survey($surveyID);
			
			if(!empty($checkSurvey))
			{

				$checkParticipant		=	$this->analyze_model->check_participant($surveyID, $participantID);

				if(!empty($checkParticipant))
				{
					
					$data['surveyor']				=	$checkParticipant;
					
					
					$data['participantDetail']		=	$this->analyze_model->get_participant_details($checkParticipant['survey_participant_id']);
					
					
					$data['companyDetails']			=	$this->analyze_model->get_company_details($checkParticipant['company_id']);
					
					// send email to line manager
					if($this->analyze_model->send_feedback_reponse_email($data)){
						$this->load->view('feedback/thank-you', $data);
					}else{						
						$this->load->view('feedback/thank-you', $data);
					}									
		
				}else{
					
					$this->session->set_flashdata('message', 'Invalid Participant Reference, Please Provide the right Participant Reference to Proceed.');
			
					redirect(base_url().'feedback/error/', 'refresh');
				
				} 
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
				redirect(base_url().'feedback/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
			redirect(base_url().'feedback/error/', 'refresh');	
			
		}
	}


}

?>