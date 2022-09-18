<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nominate_model extends CI_Model {

    public function __construct() {
		parent::__construct();
		
		if(base_url() == 'https://www.naama.io/' || base_url() == 'https://www.naama.io/sandbox/')
			{
			
			$this->site_email 			= 	'noreply@naama.io';
		
		}else{
			
			$this->site_email 			= 	'noreply@aeriksoftsolutions.com';
		}
		
		$this->company_name			=	'PIPA';
		
		$this->site_logo			= 	base_url().'asset/images/logo.png';

    }
    
	// nomination
	public function get_all_company()
	{		
		$query		=	$this->db->get('company');
		
		if($query->num_rows() > 0)
		{
			
			return $query->result_array();
				
		}else{
			
			return FALSE;
			
		}

	}

	public function get_company_setting($companyID)
	{
		$this->db->where('company_id', $companyID);	
		
		$query		=	$this->db->get('company_setting');
		
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
    
    public function check_participant($surveyID, $participantID)
	{
		
		$this->db->where('survey_id', $surveyID);
				
		$this->db->where('survey_participant_id', $participantID);
		
		$query		=	$this->db->get('program_survey_participant');
		
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
    
    public function save_nominee($save)
	{ 		
		$table								=	'program_survey_nominee';
		
		$nominee_id							=	'nominee_id'; 
		
		if(!empty($save['nominee_id']))
		{
			
			$this->db->where('nominee_id', $save['nominee_id']);
			
			$query							=	$this->db->update($table, $save);
			
			$id 							= 	$save['nominee_id'];
			
		}else{			
			
			$this->db->insert($table, $save);
			
			$id 							= 	$this->db->insert_id();	
						
        } 
        
		return $id; 		
	}

	public function get_line_manager($participantID, $programID)
	{
		// get participant line manaer 
		$this->db->select('line_manager_name','line_manager_email','line_manager_phone_number');
		$this->db->from('program_survey_participant');
		$this->db->where('program_survey_participant.survey_participant_id', $participantID);
		$this->db->where('program_survey_participant.program_id', $programID);
			
        $query			        			=	$this->db->get();	
		$linemanagerDetail                  =   $query->row_array(); 
		
		return $linemanagerDetail;
	} 

	public function get_participant_nominees($participantID, $programID, $surveyID)
	{
		// get participant line manaer 
		$this->db->select('nominee_id, program_id, survey_id, name, email, phone_number, evaluator_type, participant_id, approved, selected');
		$this->db->from('program_survey_nominee');
		$this->db->where('program_survey_nominee.participant_id', $participantID);
		$this->db->where('program_survey_nominee.survey_id', $surveyID);
		$this->db->where('program_survey_nominee.program_id', $programID);
			
        $query			        	=	$this->db->get();	
		$nominees                  	=   $query->result_array(); 
		
		return $nominees;
	}

	// send emails
	public function request_nominee_approval_email($participantDetail, $surveyDetail)
	{ 
			
		$linemanagerDetail                  =   $this->get_line_manager($participantDetail['survey_participant_id'], $participantDetail['program_id']); 
		
		if($linemanagerDetail)
		{			
			// send the email
			$this->send_nominee_approval_notice_email($linemanagerDetail, $participantDetail, $surveyDetail);
			
			return TRUE;
			
		}else{
			
			return FALSE;
		
		}
		
	}

	public function thank_you_email($participantDetail, $surveyDetail)
	{ 
			
		$linemanagerDetail                  =   $this->get_line_manager($participantDetail['survey_participant_id'], $participantDetail['program_id']); 
		
		if($linemanagerDetail)
		{			
			// send the email
			$this->send_approval_success_email($linemanagerDetail, $participantDetail, $surveyDetail);
			
			return TRUE;
			
		}else{
			
			return FALSE;
		
		}
		
	}

	public function send_nominee_approval_notice_email($manager, $participantDetail, $survey)
	{
		$site_email 			= 	$this->site_email;
		
		$company_name 			= 	$this->company_name;
		
		$site_logo				= 	$this->site_logo;
		 		
		// get email template 
		$data['manager']		=	$manager;

		$data['participantDetail']	=	$participantDetail;

		$data['survey']			=	$survey;

		$mailBody				=	$this->load->view('/nominate/emails/nominee-approve-notice', $data, TRUE);

		$config['mailtype'] 	= 	'html'; 

		$this->email->set_newline("\r\n");	
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
		$this->email->to($manager['line_manager_email']);

		$this->email->subject('Nominee notice for '. ucfirst($participantDetail['first_name']) . ' ' .ucfirst($participantDetail['last_name']));
		
		$this->email->message($mailBody);
		
		$this->email->send();

	}

	public function send_nominee_approval_reminder_email($manager)
	{
		$site_email 			= 	$this->site_email;
		
		$company_name 			= 	$this->company_name;
		
		$site_logo				= 	$this->site_logo;
		 		
		// get email template 
		$data['managerDetail']		=	$manager;

		$mailBody				=	$this->load->view('/nominate/emails/nominee-approve-reminder-notice', $data, TRUE);

		$config['mailtype'] 	= 	'html'; 

		$this->email->set_newline("\r\n");	
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
		$this->email->to($manager['line_manager_email']);

		$this->email->subject('Nominee approval reminder notice for '. ucfirst($manager['survey_participant_name']));
		
		$this->email->message($mailBody);
		
		$this->email->send();

	}

	public function send_approval_success_email($manager, $participantDetail, $survey)
	{
		$site_email 				= 	$this->site_email; 
		
		$company_name 				= 	$this->company_name; 
		 		
		// get email template 
		$data['lineManager']		=	$manager;

		$data['participantDetail']	=	$participantDetail;

		$data['survey']				=	$survey;

		$mailBody					=	$this->load->view('/nominate/emails/nominee-approval-success', $data, TRUE);

		$config['mailtype'] 		= 	'html'; 

		$this->email->set_newline("\r\n");	
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
		$this->email->to($manager['line_manager_email']);

		$this->email->subject('Nominee notice for '. ucfirst($participantDetail['first_name']) . ' ' .ucfirst($participantDetail['last_name']));
		
		$this->email->message($mailBody);
		
		$this->email->send();

	}

	public function send_nominee_request_notice_email($participant_id, $survey_id)
	{

		$site_email 				= 	$this->site_email; 
		
		$company_name 				= 	$this->company_name;
		
		$site_logo					= 	$this->site_logo;
		 		
		// get email template 
		$data['manager']			=	$manager;

		$participantDetail			=	$this->get_participant_details($participant_id);

		$data['participantDetail']	= 	$participantDetail;

		$data['companyDetails']		= 	$this->get_company_details($participantDetail['company_id']);

		$data['survey_id']			= 	$survey_id;

		$mailBody					=	$this->load->view('/nominate/emails/nominee-entry-request', $data, TRUE);

		$config['mailtype'] 		= 	'html'; 

		$this->email->set_newline("\r\n");	
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
		$this->email->to($participantDetail['email']);

		$this->email->subject('Nominee request notice for '. ucfirst($participantDetail['first_name']) . ' ' . ucfirst($participantDetail['last_name']));
		
		$this->email->message($mailBody);
		
		if (!$this->email->send())
		{  			
			return FALSE;
		
		}else
		{
			return TRUE;		
		}

	}

	function get_survey_message($subject, $surveyID)
	{
		
		$this->db->where('survey_id', $surveyID);
		
		$this->db->where('subject', $subject);
		
		$res 			= 	$this->db->get('program_survey_communication');
		
		return $res->row_array();
		
	}

	public function send_surveyor_welcome_mail($surveyID, $participantName, $participantGender, $surveyorName, $surveyorEmail, $url)
	{

		// echo '<br/><br/> surveyID: '. $surveyID .'<br/>participantName: '. $participantName .'<br/>participantGender: '. $participantGender .'<br/>surveyorName: '. $surveyorName .'<br/>surveyorEmail: '. $surveyorEmail .'<br/>url: '. $url .'<br/><br/>';

		$site_email 			= 	$this->site_email; 
		
		$platform_name 			= 	$this->company_name;
		
		$site_logo				= 	$this->site_logo;
		
		$row 					= 	$this->get_survey_message('Welcome Email', $surveyID);
		
		$row['content'] 		= 	html_entity_decode($row['content']);
				
		$row['content'] 		= 	str_replace('[Evaluator Name]',  $surveyorName, $row['content']);
		
		$row['content'] 		= 	str_replace('[Leader Name]',  $participantName, $row['content']);
		
		$row['content'] 		= 	str_replace('[Him/Her]',  $participantGender, $row['content']);

		$row['site_logo']		=	$site_logo;
		
		// {url}
		$row['content'] 		= 	str_replace('[url]', $url, $row['content']); 		

		$mailBody				=	$this->load->view('/nominate/emails/nominee-evaluator-welcome', $row, TRUE); 

		// echo $mailBody .'<br/><br/>';
		
		$config['mailtype'] 	= 	'html';
		
		$this->email->initialize($config);

		$this->email->from($site_email, $platform_name);
		
		$this->email->to($surveyorEmail);

		$this->email->subject('Welcome to an assessment for '.$participantName.'');
		
		$this->email->message($mailBody);
		
				
		if (!$this->email->send())
		{ 
			// foreach ($this->email->get_debugger_messages() as $debugger_message)
			// {
				
			// 	echo $debugger_message;
			
			// }
		
			// $this->email->clear_debugger_messages();
			
			return FALSE;
		
		}else
		{
		
			return TRUE;
		
		}

	}

	
	//call by cron job or button click on participants survey page	

	public function send_nominee_request_mail_cron()
	{

		// get all company list 
		$companyList 					=		$this->get_all_company();

		if($companyList){

			$count						=		0;

			foreach($companyList as $company)
			{	
				
				$companySettings			=		$this->get_company_setting($company['company_id']); 

				if($companySettings){

					$usePeerDirect				=		$companySettings['use_peer'];

					$usedDirectReport			=		$companySettings['use_direct_report'];

					$peersName					=		$companySettings['peer_name'];

					$directReportName			=		$companySettings['direct_report_name'];

					$peersTotal					=		$companySettings['peer_total']; 

					$directReportTotal			=		$companySettings['direct_report_total'];
					
					$maxTotalForNomination		=		$companySettings['total_max_approved'];
					
					$enableNomination			=		$companySettings['enable_nomination'];


					// check enableNomination

					if($enableNomination == 1){
					
						// run query

						$sql = "SELECT *, (SELECT company_name FROM company C WHERE C.company_id = P.company_id) company 
						FROM program_survey_participant P
						WHERE P.request_email_sent = 0 
						AND P.survey_id IN (
							SELECT survey_id FROM program_survey S 
							WHERE survey_id IN (SELECT survey_id FROM program_survey_schedule WHERE end_date > NOW())
						)  AND  
						(  
							(SELECT COUNT(survey_participant_id) FROM program_survey_surveyor SS 
									WHERE SS.relationship = ".$this->db->escape($peersName)." AND SS.program_id = P.program_id AND SS.survey_id = P.survey_id 
									AND SS.survey_participant_id = P.survey_participant_id) < ".$this->db->escape($peersTotal)."";

						If($usedDirectReport){
							$sql .= " OR  
									(SELECT COUNT(survey_participant_id) FROM program_survey_surveyor SS 
										WHERE SS.relationship = ".$this->db->escape($directReportName)." AND SS.program_id = P.program_id AND SS.survey_id = P.survey_id 
										AND SS.survey_participant_id = P.survey_participant_id) < ".$this->db->escape($directReportTotal)."";
						}
						
						$sql .= ")"; 

						$query = $this->db->query($sql);   

						if($query->num_rows() > 0)
						{			
							$count						=	0;			

							$participants              	=   $query->result_array(); 

							foreach($participants as $participant)
							{	
								//send reminder email to participant				 
								$mailSent = $this->send_nominee_request_notice_email($participant['survey_participant_id'], $participant['survey_id']); 

								if($mailSent)
								{
									
									$this->db->where('survey_survey_participant', $participant['survey_participant_id']);
									
									$updateParticipant['request_email_sent']		=	1;
									
									$updateParticipant['request_email_date_sent']	=	date('Y-m-d H:i:s');
									
									$queryMailSent		=	$this->db->update('survey_survey_participant', $updateParticipant); 

								}

								$count++;
							}
						}
						// end query
					} 
					// end enableNomination
					
				}

				$count++;
			}		

		}
		// end company list
	} 

	public function send_nominee_approval_reminder_cron()
	{
		
		$sql = "SELECT line_manager_name, line_manager_email, line_manager_phone_number, 
		CONCAT(first_name, ' ', last_name) AS survey_participant_name, survey_participant_id, program_id, survey_id, 
		(SELECT company_name FROM company C WHERE C.company_id = P.company_id) company 
				FROM program_survey_participant P
				WHERE P.survey_participant_id NOT IN (
					SELECT survey_participant_id FROM program_survey_surveyor S 
					WHERE (S.relationship = 'Peer' OR S.relationship = 'Direct Report')
				) AND P.survey_id IN (
					SELECT survey_id FROM program_survey S 
					WHERE survey_id IN (SELECT survey_id FROM program_survey_schedule WHERE end_date > NOW())
				) AND EXISTS(SELECT survey_participant_id FROM program_survey_nominee N 
					WHERE N.program_id = P.program_id AND N.survey_id = P.survey_id AND N.participant_id = P.survey_participant_id 
					AND N.approved = 0 AND N.selected = 0)
		GROUP BY line_manager_name, line_manager_email, line_manager_phone_number, survey_participant_id, program_id, survey_id";

		$query = $this->db->query($sql);   

		if($query->num_rows() > 0)
		{			
			$count						=	0;			

			$managers              	=   $query->result_array(); 

			foreach($managers as $manager)
			{	
				//send reminder email to participant				 
				$this->send_nominee_approval_reminder_email($manager); 

				$count++;
			}
		} 

	} 

	// random allocation logic for nomineed => evaluators/surveyors

	public function get_approved_nominee_by_type($evaluator_type,$total_expected,$maxTotalForNomination)
	{
		//get settings

		// $maxTotalForNomination		=		3;

		$sql = "SELECT nominee_id, program_id, survey_id, name, email, phone_number, evaluator_type, participant_id, approved, selected,		
		(SELECT company_id FROM program_survey_participant SP WHERE SP.survey_participant_id = SN.participant_id) company_id,		
		(SELECT gender FROM program_survey_participant SP WHERE SP.survey_participant_id = SN.participant_id) participant_gender,		
		(SELECT CONCAT(first_name,' ',last_name) FROM program_survey_participant SP WHERE SP.survey_participant_id = SN.participant_id) participant_name
		FROM program_survey_nominee SN
		WHERE SN.evaluator_type = ".$this->db->escape($evaluator_type)."
		AND SN.approved = 1
        AND SN.selected = 0
		AND participant_id IN (
			SELECT survey_participant_id
			FROM program_survey_participant P WHERE 
				(SELECT COUNT(survey_participant_id) FROM program_survey_surveyor SS 
					WHERE SS.relationship = ".$this->db->escape($evaluator_type)." AND SS.program_id = P.program_id AND SS.survey_id = P.survey_id 
					AND SS.survey_participant_id = P.survey_participant_id
				) < ".$this->db->escape($total_expected)."
			) AND SN.survey_id IN (
				SELECT survey_id FROM program_survey S 
				WHERE survey_id IN (SELECT survey_id FROM program_survey_schedule WHERE end_date > NOW())
			) AND (
				(SELECT COUNT(nominee_id) FROM program_survey_nominee N 
				 WHERE N.evaluator_type = ".$this->db->escape($evaluator_type)." AND N.program_id = SN.program_id AND N.survey_id = SN.survey_id 
				AND N.participant_id = SN.participant_id AND N.approved = 1 and N.selected = 0) >= ".$this->db->escape($maxTotalForNomination)."
			)";

		$query = $this->db->query($sql); 

		if($query->num_rows() > 0)
		{			

			$nominees              	=   $query->result_array(); 

			return $nominees;
			
		} 

		return [];

	}

	public function group_by ($key, $data) 
	{
		$result = array();
	
		foreach($data as $val) {
			if(array_key_exists($key, $val)){
				$result[$val[$key]][] = $val;
			}else{
				$result[""][] = $val;
			}
		}
	
		return $result;
	}

	public function insert_random_selection($type, $count, $my_approved_nominees, $index)
	{
		
		// insert the selected 
		$save['company_id']   				=	$my_approved_nominees[$index]['company_id'];			
		
		$save['program_id']	  				=	$my_approved_nominees[$index]['program_id'];		 

		$save['survey_id']    				=	$my_approved_nominees[$index]['survey_id'];
		
		$save['survey_participant_id']    	=	$my_approved_nominees[$index]['participant_id'];
		
		$save['employee_number']	    	=	'N/A';
		
		$save['relationship']		    	=	$my_approved_nominees[$index]['evaluator_type'];
		
		$save['relationship_index']	    	=	$count;
		
		$save['name']				    	=	$my_approved_nominees[$index]['name'];
		
		$save['email']				    	=	$my_approved_nominees[$index]['email'];
		
		$save['phone_number']		    	=	$my_approved_nominees[$index]['phone_number'];
		
		$save['date_created']				= 	date("Y-m-d H:i:s");
		
		// echo 'Saved object ' . $type . ' - ' . $index . '<br/>';

		// echo json_encode(
		// 	$my_approved_nominees[$index]
		// ); 

		$this->db->insert('program_survey_surveyor', $save); 	

		$id 								= 	$this->db->insert_id();	

		// check if program has been launch

		$this->db->select('program_launched');
		$this->db->from('program');
		$this->db->where('program.program_id', $save['program_id']);
		$this->db->where('program.program_launched', 1);
		$query                          =   $this->db->get();				

		if($query->num_rows() > 0)
		{

			$program                =   $query->row_array();  
			
			//send email here 
			$surveyID				=	$save['survey_id'];

			$surveyorID				=	$id; //survey_surveyor_id

			$participantID			=	$save['survey_participant_id'];

			$participantName		=	$my_approved_nominees[$index]['participant_name'];

			$participantGender		=	$my_approved_nominees[$index]['participant_gender'];

			$surveyorName			= 	$save['name'];

			$surveyorEmail			=	$save['email'];

			$url				=	'<a href="'.base_url().'survey/get-started/'.$surveyID.'/'.$surveyorID.'/'.$participantID.'/">'.base_url().'survey/get-started/'.$surveyID.'/'.$surveyorID.'/'.$participantID.'/'.'</a>';
			
			$mailSent			=	$this->send_surveyor_welcome_mail($surveyID, $participantName, $participantGender, $surveyorName, $surveyorEmail, $url);

			if($mailSent)
			{
				
				$this->db->where('survey_surveyor_id', $surveyorID);
				
				$updateSurveyor['mail_sent']		=	1;
				
				$updateSurveyor['date_mail_sent']	=	date('Y-m-d H:i:s');
				
				$queryMailSent						=	$this->db->update('program_survey_surveyor', $updateSurveyor); 

			}
				
		}

	}

	public function random_evaluator_selection($type, $total, $maxTotalForNomination)
	{
		$approved_nominees 					=	$this->get_approved_nominee_by_type($type, $total, $maxTotalForNomination); //get from db

		$grouped_approved_nominees			=	$this->group_by('participant_id', $approved_nominees);

		foreach($grouped_approved_nominees as $participant_id => $my_approved_nominees){

			$participantDetail				=	$this->get_participant_details($participant_id);
			
			//check if there is already saved surveyor
			$this->db->select('COUNT(survey_participant_id) AS total_existing');
			$this->db->from('program_survey_surveyor');
			$this->db->where('program_survey_surveyor.survey_participant_id', $participantDetail['survey_participant_id']); 
			$this->db->where('program_survey_surveyor.program_id', $participantDetail['program_id']); 
			$this->db->where('program_survey_surveyor.survey_id', $participantDetail['survey_id']); 
			$this->db->where('program_survey_surveyor.company_id', $participantDetail['company_id']); 
			$this->db->where('program_survey_surveyor.relationship', $type); 

			$query                          =   $this->db->get();
			$result                         =   $query->row_array(); 
			$total_existing                 =   $result ? $result['total_existing'] : 0;
			
			$total							= 	$total - $total_existing;

			$random_selected_index			= 	array_rand($my_approved_nominees, $total); // randomly pick total
			
			// echo '<br>random_selected_index: '. gettype($random_selected_index) .'<br>';

			if(gettype($random_selected_index) == 'integer'){

				$this->insert_random_selection($type, $total_existing + 1, $my_approved_nominees, $random_selected_index);

			}else{

				$count 							=	($total_existing + 1);

				foreach($random_selected_index as $index){

					$this->insert_random_selection($type, $count, $my_approved_nominees, $index);

					// echo '<br/> ***** <br/><br/>';

					$count++;

				}
			}

		} 
		
	} 

	public function random_evaluator_selection_cron()
	{
		// get all company list 
		$companyList 					=		$this->get_all_company();

		if($companyList){

			$count						=		0;

			foreach($companyList as $company)
			{	
				
				$companySettings			=		$this->get_company_setting($company['company_id']); 

				if($companySettings){

					$usePeerDirect				=		$companySettings['use_peer'];

					$usedDirectReport			=		$companySettings['use_direct_report'];

					$peersName					=		$companySettings['peer_name'];

					$directReportName			=		$companySettings['direct_report_name'];

					$peersTotal					=		$companySettings['peer_total']; 

					$directReportTotal			=		$companySettings['direct_report_total'];
					
					$maxTotalForNomination		=		$companySettings['total_max_approved'];

					// Peers

					$this->random_evaluator_selection($peersName, $peersTotal, $maxTotalForNomination);

					// Direct report	

					if($usedDirectReport){

						$this->random_evaluator_selection($directReportName, $directReportTotal, $maxTotalForNomination);
					}

				}

				$count++;
			}		

		}
		// end if 

	} 
	
}
