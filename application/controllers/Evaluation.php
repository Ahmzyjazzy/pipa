<?php
class Evaluation extends CI_Controller 
{
		
	public function __construct()
	{
		parent::__construct();
				
		$this->company_name			=	'PIPA';
		
		$this->site_logo			= 	base_url().'asset/images/logo.png';
		
		$this->load->model('analyze_model');
				
	} 


	public function reportx($participantID=false, $surveyID=false)
	{
		 
		$data['title']				= 	"Evaluation Report :: Participant";
		
		if(!empty($surveyID))
		{
			
			$checkSurvey			=	$this->analyze_model->check_survey($surveyID);
			$data['participant'] 	= 	$this->analyze_model->get_participant_details($participantID);

			if(!empty($checkSurvey))
			{
			
				$this->load->view('evaluation/header', $data);
				$this->load->view('evaluation/report', $data);	 
			
			}else{
				
				$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
				redirect(base_url().'evaluation/error/', 'refresh');
				
			}
			
		}else{
			
			$this->session->set_flashdata('message', 'Invalid Participant or Survey Reference, Please Provide the right Reference to Proceed.');
				
			redirect(base_url().'evaluation/error/', 'refresh');	
			
		}
		
	}

	public function error()
	{
		
		$data['title']			= 	"Error";
		
		$this->load->view('evaluation/error', $data);

	}

	public function set_program_id($surveyID)
	{ 
		$program_id				= 	$this->analyze_model->fetch_program_id_by_survey($surveyID); 	
		$company_setting		=	$this->analyze_model->get_company_setting_by_survey($surveyID);
		$competency_count		=	$this->analyze_model->get_competency_count($surveyID);

		$company_setting['competency_count'] = $competency_count;

		//adding data to session 
		$this->session->set_userdata('program_id',$program_id); 
		
		echo json_encode(array(
			"program_id" => $program_id,
			"company_setting" => $company_setting 
		));
	}	

	public function fetch_strength_and_opportunity($survey_participant_id = '')
	{
		$program_id 						= 	$this->session->userdata('program_id');  
		$survey 							= 	$this->analyze_model->fetch_surveys($program_id,'360 assessment','single');  
		$strength_and_opportunity 			= 	$this->analyze_model->fetch_strength_and_opportunity2($survey['survey_id'], $survey_participant_id); 

		echo json_encode(array(
			"data" => $strength_and_opportunity,
			"program_id" => $program_id,
			'survey_participant_id' => $survey_participant_id,
			"survey" => $survey 
		));
	}

	public function fetch_pmf_detail($survey_participant_id = '')
	{
		$program_id 			= 	$this->session->userdata('program_id');  
		$survey 				= 	$this->analyze_model->fetch_surveys($program_id,'360 assessment','single');  
		$pmf_detail 			= 	$this->analyze_model->fetch_pmf_detail($survey['survey_id'], $survey_participant_id); 

		echo json_encode(array(
			"data" => $pmf_detail,
			"program_id" => $program_id,
			'survey_participant_id' => $survey_participant_id,
			"survey" => $survey 
		));

	}
 

}

?>