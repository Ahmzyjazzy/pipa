<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Analyze_model extends CI_Model {

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

    // analyze summary section below
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

    public function fetch_employee_number($user_id, $company_id)
    {
        $this->db->select('employee_number');
        $this->db->from('program_survey_participant'); 
        $this->db->where('company_id', $company_id); 
        $this->db->where('user_id', $user_id);  

        $query              =   $this->db->get();
        $result             =   $query->row_array();  
        $employee_number     =   $result ? $result['employee_number'] : 0;
        return $employee_number;
    }

    public function fetch_program_id_by_survey($survey_id)
    {
        $this->db->select('program_id');
        $this->db->from('program_survey'); 
        $this->db->where('survey_id', $survey_id);  

        $query              =   $this->db->get();
        $result             =   $query->row_array();  
        $program_id     =   $result ? $result['program_id'] : 0;
        return $program_id;
    }

    public function fetch_program_id($company_id, $survey_id)
    {
        $this->db->select('program_id');
        $this->db->from('program_survey'); 
        $this->db->where('company_id', $company_id); 
        $this->db->where('survey_id', $survey_id);  

        $query              =   $this->db->get();
        $result             =   $query->row_array();  
        $program_id     =   $result ? $result['program_id'] : 0;
        return $program_id;
    }

    public function program_list($company_id, $survey_participant_id = '')
    {
        $this->db->select('program_name,program_name_slug,program.program_id as program_id');
        $this->db->from('program'); 

        if($company_id != 1){
            $this->db->where('program.company_id', $company_id); 
        }

        if($survey_participant_id){            
            $this->db->join('program_survey_participant', 'program.program_id = program_survey_participant.program_id');
            $this->db->where('program_survey_participant.survey_participant_id', $survey_participant_id);  
        }

        $query = $this->db->get();
        return $query->result_array(); 
    }

    public function fetch_program_surveys($company_id, $survey_participant_id, $survey_type)
    {
        $sql = "SELECT survey_id, survey, survey_slug, survey_type, program.program_id, program_name,        
        (SELECT start_date FROM program_survey_schedule S WHERE S.program_id = PS.program_id) survey_start_date,
        (SELECT end_date FROM program_survey_schedule S WHERE S.program_id = PS.program_id) survey_end_date,
        (SELECT frequency FROM program_survey_schedule S WHERE S.program_id = PS.program_id) frequency
        FROM program_survey PS LEFT JOIN program ON PS.program_id = program.program_id
        WHERE PS.survey_type = ".$this->db->escape($survey_type)." AND PS.company_id = ".$this->db->escape($company_id)." AND EXISTS(
            SELECT 1 FROM program_survey_participant P WHERE P.program_id = PS.program_id AND P.survey_id = PS.survey_id 
            AND P.survey_participant_id = ".$this->db->escape($survey_participant_id).")";
         
        $query = $this->db->query($sql); 

        return $query->result_array(); 
    }

    public function fetch_surveys($program_id, $survey_type, $record = 'multi')
    {
        $sql = "SELECT survey_id, survey, survey_slug, survey_type, program.program_id, program_name,        
        (SELECT start_date FROM program_survey_schedule S WHERE S.program_id = program_survey.program_id) survey_start_date,
        (SELECT end_date FROM program_survey_schedule S WHERE S.program_id = program_survey.program_id) survey_end_date,
        (SELECT frequency FROM program_survey_schedule S WHERE S.program_id = program_survey.program_id) frequency
        FROM program_survey LEFT JOIN program ON program_survey.program_id = program.program_id
        WHERE program_survey.survey_type = ".$this->db->escape($survey_type)." AND program_survey.program_id = ".$this->db->escape($program_id)."";
         
        $query = $this->db->query($sql); 

        return $record == 'multi' ? $query->result_array() : $query->row_array(); 
    }

    public function fetch_surveyor_detail($survey_participant_id, $survey_surveyor_id, $question_id)
    {
        $sql = "SELECT SS.survey_id, SS.survey_surveyor_id, SS.name, SS.email, SS.phone_number, SS.relationship,
        SR.survey_response_id, SR.response_text, SR.survey_question_id,
        (SELECT question FROM program_survey_question SQ WHERE SQ.survey_question_id = SR.survey_question_id) question
        FROM 
        `program_survey_surveyor` SS,
        `program_survey_response` SR
            WHERE SS.survey_surveyor_id = SR.survey_surveyor_id
            AND SS.survey_participant_id = SR.survey_participant_id  
            AND SS.survey_id = SR.survey_id       
            AND SR.survey_surveyor_id = ".$this->db->escape($survey_surveyor_id)."
            AND SR.survey_participant_id = ".$this->db->escape($survey_participant_id)."
            AND SR.survey_question_id = ".$this->db->escape($question_id)."";    

        $query              =   $this->db->query($sql); 
        $result             =   $query->row_array();  
        return $result;
    }

    public function get_surveyor_question_response($survey_participant_id, $survey_surveyor_id)
    {
        $sql = "SELECT * FROM `program_survey_surveyor` 
        WHERE survey_surveyor_id = ".$this->db->escape($survey_surveyor_id)."
        AND survey_participant_id = ".$this->db->escape($survey_participant_id)."";    

        $query              =   $this->db->query($sql); 
        $result             =   $query->row_array();  
        return $result;
    }    

    public function fetch_past_surveys($company_id, $survey_type, $record = 'multi')
    {	
        $program_id 						= 	$this->session->userdata('program_id'); 
        
        $sql = "SELECT survey_id, survey, survey_slug, survey_type, program.program_id, program_name,        
        (SELECT start_date FROM program_survey_schedule S WHERE S.program_id = program_survey.program_id) survey_start_date,
        (SELECT end_date FROM program_survey_schedule S WHERE S.program_id = program_survey.program_id) survey_end_date,
        (SELECT frequency FROM program_survey_schedule S WHERE S.program_id = program_survey.program_id) frequency
        FROM program_survey LEFT JOIN program ON program_survey.program_id = program.program_id 
        WHERE program_survey.survey_type = ".$this->db->escape($survey_type)."";

        if($company_id != 1){            
            $sql .= " AND program_survey.company_id = ".$this->db->escape($company_id).""; 
        }

        $sql .= " AND program_survey.program_id != ".$this->db->escape($program_id).""; 
         
        $query = $this->db->query($sql); 

        return $record == 'multi' ? $query->result_array() : $query->row_array(); 
    }

    public function fetch_summary($program_id = null) 
    {
        $sql = "SELECT 
        (SELECT COUNT(program_id) FROM program_survey_competency C WHERE C.program_id = S.program_id
        AND EXISTS(SELECT 1 FROM program_survey S WHERE S.survey_id = C.survey_id)) total_competency,
        (SELECT COUNT(survey_participant_id) FROM program_survey_participant P WHERE P.program_id = S.program_id) total_participant,
        (SELECT date_created FROM program_survey_response R WHERE R.program_id = S.program_id ORDER BY date_created DESC LIMIT 1) date_collected,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS WHERE SS.program_id = S.program_id AND SS.survey_id = S.survey_id 
        AND S.survey_type = '360 assessment') total_evaluator_invited,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS WHERE SS.program_id = S.program_id AND SS.survey_id = S.survey_id 
            AND S.survey_type = '360 assessment' AND EXISTS(SELECT survey_surveyor_id FROM program_survey_response R WHERE R.program_id = SS.program_id 
            AND R.survey_id = SS.survey_id AND R.survey_surveyor_id = SS.survey_surveyor_id )) total_evaluator_responded
        FROM program_survey S
        WHERE program_id = ".$this->db->escape($program_id)."";
        $result = $this->db->query($sql); 
         
        return $result->row_array();	
	}

    //analyze 360 section below
    public function fetch_participant($program_id = null) 
    {
        $this->db->select('survey_participant_id, program_survey_participant.user_id, first_name, last_name, employee_number, grade.grade, location.location');
        $this->db->from('program_survey_participant');
        $this->db->join('location', 'location.location_id = program_survey_participant.location_id');
        $this->db->join('grade', 'grade.grade_id = program_survey_participant.grade_id');
        $this->db->where('program_survey_participant.program_id', $program_id); 

        $query = $this->db->get();
        return $query->result_array(); 
    }  

    public function fetch_program_daterange($program_id = null) 
    {
        $this->db->select('start_date, end_date');
        $this->db->from('program_survey_schedule'); 
        $this->db->where('program_id', $program_id); 
        $query = $this->db->get();
        return $query->row_array(); 
    }   

    public function fetch_response_aggregates_old($program_id = null, $date_collected = null) 
    {
        //survey_response_id, survey_surveyor_id - LEADERS, MANAGERS, PEERS, DIRECT REPORTS 

        $sql = "SELECT 
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS
            WHERE EXISTS(SELECT 1 FROM program_survey_response SR WHERE SR.survey_surveyor_id = SS.survey_surveyor_id 
            AND SS.relationship = 'Self' AND SS.program_id = ".$this->db->escape($program_id).")) as leaders,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS 
            WHERE EXISTS(SELECT 1 FROM program_survey_response SR WHERE SR.survey_surveyor_id = SS.survey_surveyor_id 
            AND SS.relationship = 'Line Manager' AND SS.program_id = ".$this->db->escape($program_id).")) as managers,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS 
            WHERE EXISTS(SELECT 1 FROM program_survey_response SR WHERE SR.survey_surveyor_id = SS.survey_surveyor_id 
            AND SS.relationship = 'Peer' AND SS.program_id = ".$this->db->escape($program_id).")) as peers,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS 
            WHERE EXISTS(SELECT 1 FROM program_survey_response SR WHERE SR.survey_surveyor_id = SS.survey_surveyor_id 
            AND SS.relationship = 'Direct Report' AND SS.program_id = ".$this->db->escape($program_id).")) as direct_reports,

        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS WHERE SS.relationship = 'Self' 
            AND SS.program_id = PS.program_id) as total_leaders, 
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS WHERE SS.relationship = 'Line Manager' 
            AND SS.program_id = PS.program_id) as total_managers, 
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS WHERE SS.relationship = 'Peer' 
            AND SS.program_id = PS.program_id) as total_peers, 
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS WHERE SS.relationship = 'Direct Report' 
            AND SS.program_id = PS.program_id) as total_direct_reports 

        FROM program_survey PS
        WHERE PS.program_id = ".$this->db->escape($program_id)."
        AND PS.survey_type = '360 assessment'";
        $result = $this->db->query($sql); 
         
        return $result->row_array(); 	
    }  
    public function fetch_response_aggregates($program_id = null, $date_collected = null) 
    {
        $survey         =   $this->analyze_model->fetch_surveys($program_id,'360 assessment', 'single');

        $sql            =   "SELECT survey_surveyor_id, survey_id, program_id, relationship
                            FROM program_survey_surveyor SS
                            WHERE SS.program_id = ".$this->db->escape($survey['program_id'])."
                            AND SS.survey_id = ".$this->db->escape($survey['program_id'])."
                            AND SS.survey_surveyor_id IN (SELECT survey_surveyor_id FROM program_survey_response SR 
                                WHERE SR.program_id = ".$this->db->escape($survey['program_id'])." 
                                AND SR.survey_id = ".$this->db->escape($survey['survey_id']).")";
        
        $query                  =   $this->db->query($sql); 
        
        $leaders                =   0;

        $managers               =   0;

        $peers                  =   0;

        $direct_reports         =   0; 

        $total_peers            =   0;

        $total_direct_reports   =   0;

        if($query->num_rows() > 0)
		{		
            $count		=	0;			
            $result		=	$query->result_array();	 

			foreach($result as $res)
			{
                if($res['relationship'] == 'Self') $leaders += 1;
                if($res['relationship'] == 'Line Manager') $managers += 1;
                if($res['relationship'] == 'Peer') $peers += 1;
                if($res['relationship'] == 'Direct Report') $direct_reports += 1; 
            } 

        }

         // get overall totals

        $this->db->select('COUNT(survey_surveyor_id) total_leaders');
        $this->db->from('program_survey_surveyor');
        $this->db->where('program_survey_surveyor.relationship = "Self"'); 
        $this->db->where('program_survey_surveyor.program_id', $program_id);  
        $query              =   $this->db->get();
        $result             =   $query->row_array();  
        $total_leaders     =   $result ? $result['total_leaders'] : 0;

        $this->db->select('COUNT(survey_surveyor_id) total_managers');
        $this->db->from('program_survey_surveyor');
        $this->db->where('program_survey_surveyor.relationship = "Line Manager"'); 
        $this->db->where('program_survey_surveyor.program_id', $program_id);  
        $query              =   $this->db->get();
        $result             =   $query->row_array();  
        $total_managers     =   $result ? $result['total_managers'] : 0;

        $this->db->select('COUNT(survey_surveyor_id) total_peers');
        $this->db->from('program_survey_surveyor');
        $this->db->where('program_survey_surveyor.relationship = "Peer"'); 
        $this->db->where('program_survey_surveyor.program_id', $program_id);  
        $query              =   $this->db->get();
        $result             =   $query->row_array();  
        $total_peers        =   $result ? $result['total_peers'] : 0;

        $this->db->select('COUNT(survey_surveyor_id) total_direct_reports');
        $this->db->from('program_survey_surveyor');
        $this->db->where('program_survey_surveyor.relationship = "Direct Report"'); 
        $this->db->where('program_survey_surveyor.program_id', $program_id);  
        $query              =   $this->db->get();
        $result             =   $query->row_array();  
        $total_direct_reports        =   $result ? $result['total_direct_reports'] : 0;
         
        return array(
             'leaders'              =>  $leaders,
             'managers'             =>  $managers,
             'peers'                =>  $peers,
             'direct_reports'       =>  $direct_reports,
             'total_leaders'        =>  $total_leaders,
             'total_managers'       =>  $total_managers,
             'total_peers'          =>  $total_peers,
             'total_direct_reports' =>  $total_direct_reports
         );
        
    }
    
    public function fetch_competency_aggregates($program_id = null, $date_collected = null) 
    {
        //fetch competency aggregates average scores
        $sql = "SELECT C.competency_id, C.competency AS competency,
        (SELECT AVG(response_whole_number) FROM program_survey_response SR WHERE SR.survey_competency_id = SC.survey_competency_id) AS score
        FROM program_survey_competency as SC, competency C
        WHERE program_id = ?
        AND SC.competency_id = C.competency_id
        AND EXISTS(SELECT survey_id FROM program_survey WHERE program_id = SC.program_id AND survey_type = 360 AND survey_id = SC.survey_id)";         
        $result = $this->db->query($sql, array($program_id)); 
        
        return $result->result_array();
    }
     
    // analyze evaluator section below
    function fetch_evaluators($program_id)
	{		
		$response		=	array();		
		$this->db->where('program_id', $program_id);		
		$query			=	$this->db->get('program_survey_participant');	
        
		if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				
                $response[$count]['survey_participant_id']		    =	$res['survey_participant_id'];				
                $response[$count]['company_id']					    =	$res['company_id'];				
                $response[$count]['program_id']					    =	$res['program_id'];				
                $response[$count]['survey_id']					    =	$res['survey_id'];				
                $response[$count]['employee_number']			    =	$res['employee_number'];				
                $response[$count]['first_name']					    =	$res['first_name'];				
                $response[$count]['last_name']					    =	$res['last_name'];			
                $response[$count]['email']					        =	$res['email']; 			
                $response[$count]['phone']					        =	$res['phone_number'];   
                $response[$count]['line_manager_name']			    =	$res['line_manager_name'];
                $response[$count]['line_manager_employee_number']   =	$res['line_manager_employee_number'];		
				$response[$count]['participant_response']		    =	$this->get_participant_response($res['survey_participant_id'],$res['program_id'],'','Self'/*,$res['employee_number']*/);
				$response[$count]['surveyors']					    =	$this->get_participant_surveyors($res['survey_participant_id'], $res['program_id']);
                
                $count++;
			}
			
        }
        
        return $response;
		
	}
	
	public function get_participant_surveyors($participant_id,$program_id)
	{		 		
        $this->db->where('program_id', $program_id);
        $this->db->where('survey_participant_id', $participant_id); 
		$query			=	$this->db->get('program_survey_surveyor');

        $response		=	array(); 

        if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				
				$response[$count]['survey_surveyor_id']		    =	$res['survey_surveyor_id'];				
				$response[$count]['company_id']					=	$res['company_id'];				
				$response[$count]['program_id']					=	$res['program_id'];				
				$response[$count]['survey_id']					=	$res['survey_id'];				
				$response[$count]['employee_number']			=	$res['employee_number'];				
				$response[$count]['name']					    =	$res['name'];		 			
                $response[$count]['email']					    =	$res['email'];    		 			
                $response[$count]['phone']					    =	$res['phone_number'];             
                $response[$count]['relationship']				=	$res['relationship'];            
                $response[$count]['relationship_index']			=	($res['relationship'] == 'Self' || $res['relationship'] == 'Line Manager') ? '' : $res['relationship_index'];				
                $response[$count]['surveyors_response']			=	$this->get_participant_response($participant_id, $res['program_id'], $res['survey_surveyor_id']);                          
                $count++;
			}			
        }
        
        return $response;
    }

    public function get_participant_response($survey_participant_id, $program_id, $survey_surveyor_id = "", $relationship = "")
	{
        //get total questions
        $this->db->select("COUNT(survey_question_id) as total_question"); 
        $this->db->from('program_survey_question');
        $this->db->join('program_survey', 'program_survey.program_id = program_survey_question.program_id');
        $this->db->where('program_survey.program_id', $program_id);
        $query                          =   $this->db->get();
        $result                         =   $query->row_array(); 
        $total_question                 =   $result ? $result['total_question'] : 0;

        //get surveyor id
        $this->db->select("survey_surveyor_id"); 
        $this->db->from('program_survey_surveyor');
        $this->db->where('program_id', $program_id);
        // $this->db->where('employee_number', $employee_number);
        if($survey_surveyor_id){
            $this->db->where('survey_surveyor_id', $survey_surveyor_id);
        }
        if($relationship){
            $this->db->where('relationship', $relationship);//self
        }
        $this->db->where('survey_participant_id', $survey_participant_id);
        $query                          =   $this->db->get();
        $result                         =   $query->row_array(); 
        $survey_surveyor_id             =   $result ? $result['survey_surveyor_id'] : 0; 

        $this->db->select("COUNT(program_survey_response.survey_response_id) as total_response");
        $this->db->from('program_survey_response');
        $this->db->join('program_survey_question', 'program_survey_response.survey_question_id = program_survey_question.survey_question_id'); 
        $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id'); 
        // $this->db->where('survey_surveyor_id', $survey_surveyor_id);
        $this->db->where('program_survey_response.program_id', $program_id);
        $this->db->where('program_survey_surveyor.survey_surveyor_id', $survey_surveyor_id);
        $this->db->where('program_survey_response.survey_participant_id', $survey_participant_id);
		
		$query			                =	$this->db->get();
        $result                         =   $query->row_array(); 
        $total_response                 =   $result ? $result['total_response'] : 0;
		
		return array(
			"total_question" => $total_question, 
			"total_response" => $total_response 
        ); 
    }

    // analyze participants section below
    function fetch_analyze_surveyors_old($program_id, $survey_participant_id)
	{		
        $this->db->select('user_id, survey_participant_id, employee_number, email, phone_number, 
            first_name, last_name, gender, grade');
        $this->db->from('program_survey_participant');
        $this->db->where('program_id', $program_id);	
        $this->db->where('survey_participant_id', $survey_participant_id);	
        $this->db->join('grade', 'program_survey_participant.grade_id = grade.grade_id');
        $query			        =	$this->db->get();	
        $res                    =   $query->row_array();
        if($res){
            $res['surveyors']	=	$this->get_participant_surveyors($res['survey_participant_id'], $program_id);
            return $res;
        }		
        return '';
    }
    function fetch_analyze_surveyors($program_id, $survey_participant_id)
	{		
        $this->db->select('user_id, survey_participant_id, employee_number, email, phone_number, 
            first_name, last_name, gender, grade');
        $this->db->from('program_survey_participant');
        $this->db->where('program_id', $program_id);	
        $this->db->where('survey_participant_id', $survey_participant_id);	
        $this->db->join('grade', 'program_survey_participant.grade_id = grade.grade_id');
        $query			        =	$this->db->get();	
        $res                    =   $query->row_array();
        if($res){
            // $res['surveyors']	=	$this->get_participant_surveyors($res['survey_participant_id'], $program_id);            
            $res['surveyors']	=	$this->get_responded_surveyors_total($res['survey_participant_id'], $program_id);
            return $res;
        }		
        return '';
    }
    public function get_responded_surveyors_total($participant_id, $program_id) 
    {
        $survey         =   $this->analyze_model->fetch_surveys($program_id,'360 assessment', 'single');

        $sql            =   "SELECT survey_surveyor_id, survey_id, program_id, relationship
                            FROM program_survey_surveyor SS
                            WHERE SS.program_id = ".$this->db->escape($survey['program_id'])."
                            AND SS.survey_id = ".$this->db->escape($survey['program_id'])."
                            AND SS.survey_surveyor_id IN (SELECT survey_surveyor_id FROM program_survey_response SR 
                                WHERE SR.program_id = ".$this->db->escape($survey['program_id'])." 
                                AND SR.survey_id = ".$this->db->escape($survey['survey_id'])."
                                AND SR.survey_participant_id = ".$this->db->escape($participant_id).")";
        
        $query                  =   $this->db->query($sql); 
        
        $leaders                =   0;

        $managers               =   0;

        $peers                  =   0;

        $direct_reports         =   0;  

        $survey_id              =   0;

        if($query->num_rows() > 0)
		{		
            $count		=	0;			
            $result		=	$query->result_array();	 

			foreach($result as $res)
			{
                $survey_id            =     $res['survey_id'];

                if($res['relationship'] == 'Self') $leaders += 1;
                if($res['relationship'] == 'Line Manager') $managers += 1;
                if($res['relationship'] == 'Peer') $peers += 1;
                if($res['relationship'] == 'Direct Report') $direct_reports += 1; 
            } 

        }

        // get overall totals
        $this->db->select('COUNT(survey_surveyor_id) total_surveyors');
        $this->db->from('program_survey_surveyor'); 
        $this->db->where('program_survey_surveyor.program_id', $program_id); 
        $this->db->where('program_survey_surveyor.survey_id', $survey_id); 
        $this->db->where('program_survey_surveyor.survey_participant_id', $participant_id);  
        $query                      =   $this->db->get();
        $result                     =   $query->row_array();  
        $total_surveyors      =   $result ? $result['total_surveyors'] : 0; 
         
        return array(
             'survey_id'            =>  $survey_id,
             'program_id'           =>  $program_id,
             'participant_id'       =>  $participant_id,
             'leaders'              =>  $leaders,
             'managers'             =>  $managers,
             'peers'                =>  $peers,
             'direct_reports'       =>  $direct_reports,
             'total_surveyors'      =>  $total_surveyors
         );

    }

    public function fetch_competencies_radar_score($program_id, $survey_participant_id)
    {
        $sql = "SELECT competency, survey_competency_id, competency.description as description
            FROM program_survey_competency
            JOIN competency ON program_survey_competency.competency_id = competency.competency_id
            WHERE program_id = ".$this->db->escape($program_id)."
            AND survey_competency_id in (
                select survey_competency_id from program_survey_response 
                where program_id = ".$this->db->escape($program_id).")";
          
        $query = $this->db->query($sql); 

        // $this->db->select('competency, survey_competency_id, competency.description as description');
        // $this->db->from('program_survey_competency'); 
        // $this->db->join('competency', 'program_survey_competency.competency_id = competency.competency_id');
        // $this->db->where('program_id', $program_id);
		// $query			=	$this->db->get();

        $response		=	array(); 

        if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				 	
                $response[$count]['survey_competency_id']   =	$res['survey_competency_id'];				
				$response[$count]['competencies']			=	$res['competency'];					
				$response[$count]['title']      			=	$res['competency'];				
				$response[$count]['description']      		=	$res['description'];			
				$response[$count]['program_id']      		=	$program_id;					
				$response[$count]['self']			        =	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Self', $res['survey_competency_id']);					
				$response[$count]['manager']    			=	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Line Manager', $res['survey_competency_id']);				
				$response[$count]['peers']    			    =	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Peer', $res['survey_competency_id']);				
                $response[$count]['direct_report']    		=	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Direct Report', $res['survey_competency_id']);              
                $count++;
			}			
        }
        
        // print_r($response);
        return $response;

    }
    
    public function fetch_competencies_question_score($program_id, $survey_participant_id, $survey_competency_id)
    {
        $response = $this->get_evaluator_question_scores($program_id, $survey_participant_id, $survey_competency_id);        
        return $response;
    }

    public function get_evaluator_category_scores($program_id, $survey_participant_id, $evaluator_category, $competency_id, $question_id = null)
    {
        $response = array();

        //get avg_score of the $evaluator_category
        $this->db->select('SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low,  MAX(response_whole_number) AS high');
        $this->db->from('program_survey_response'); 
        $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id');
        $this->db->where('program_survey_response.survey_participant_id', $survey_participant_id);
        $this->db->where('program_survey_response.survey_competency_id', $competency_id);
        $this->db->where('program_survey_surveyor.relationship', $evaluator_category);//e.g Peer, Line Manager, Direct Report, Self   
        $this->db->where('program_survey_response.program_id', $program_id);  
        if($question_id){
            $this->db->where('program_survey_response.survey_question_id', $question_id); 
        }    
        $query                          =   $this->db->get();
        $result                         =   $query->row_array();  
        $total_score                    =   $result ? ($result['total_score'] ? $result['total_score'] : 0) : 0;
        $low                            =   $result ? ($result['low'] ? $result['low'] : 0) : 0;
        $high                           =   $result ? ($result['high'] ? $result['high'] : 0) : 0;

        //get surveyors per $evaluator_category
        $sql    =   "SELECT COUNT(survey_surveyor_id) AS my_surveyors FROM program_survey_surveyor S 
                   WHERE S.survey_surveyor_id IN (
                        SELECT survey_surveyor_id FROM program_survey_response R 
                        WHERE R.program_id = ".$this->db->escape($program_id)."
                        AND R.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                        AND R.survey_competency_id = ".$this->db->escape($competency_id).")
                    AND S.program_id = ".$this->db->escape($program_id)."
                    AND S.relationship = ".$this->db->escape($evaluator_category)."
                    AND S.survey_participant_id = ".$this->db->escape($survey_participant_id).""; 

        $query = $this->db->query($sql);
        $result                         =   $query->row_array();  
        $my_surveyors                   =   $result ? ($result['my_surveyors'] ? $result['my_surveyors'] : 0) : 0;

        $total_comp_questions = 1;
        if(!$question_id){
            //get total questions
            $this->db->select('COUNT(survey_question_id) AS question');  
            $this->db->from('program_survey_question');
            $this->db->where('survey_competency_id', $competency_id); 
            $this->db->where('program_id', $program_id);   
            $query                          =   $this->db->get();
            $result                         =   $query->row_array();  
            $total_comp_questions           =   $result ? ($result['question'] ? $result['question'] : 0) : 0;
        }

        //parse all value
        $my_surveyors                       =   floatval($my_surveyors);
        $total_comp_questions               =   floatval($total_comp_questions);
        $max_option_value                   =   5;
        // $avg_score                       =   round(floatval($total_score), 1);
        $high                               =   floatval($high);
        $low                                =   floatval($low);

        // return $avg_score
        $avg                                =   ($my_surveyors == 0) ? 0 : ($total_score / ($my_surveyors * $total_comp_questions));

        return array(
            "total_comp_questions" => $total_comp_questions,
            "total_score" => $total_score,
            "avg" => round($avg,1),
            "high" => $high,
            "low" => $low, 
            "my_surveyors" => $my_surveyors,
            "max_option_value" => $max_option_value
        ); 
    }

    public function get_evaluator_question_scores($program_id, $survey_participant_id, $competency_id)
    { 
        $response = array();

        //get the current participant being analyze
        // $this->db->select('survey_participant_id');
        // $this->db->from('program_survey_participant');
        // $this->db->where('survey_participant_id', $survey_participant_id);
        // $this->db->where('program_id', $program_id); 
        // $query                          =   $this->db->get();
        // $result                         =   $query->row_array(); 
        // $survey_participant_id          =   $result ? $result['survey_participant_id'] : 0; 

        //get all questions mapped to this competency
        $this->db->select('survey_question_id, question');
        $this->db->from('program_survey_question');
        $this->db->where('is_approved', 1);
        $this->db->where('program_id', $program_id); 
        $this->db->where('survey_competency_id', $competency_id); 
        $query                          =   $this->db->get();

        if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				
                $response[$count]['question_id']            =	$res['survey_question_id'];		 
                $response[$count]['title']		            =	$res['question'];					
				$response[$count]['self']			        =	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Self', $competency_id, $res['survey_question_id']);					
				$response[$count]['manager']    			=	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Line Manager', $competency_id, $res['survey_question_id']);				
				$response[$count]['peers']    			    =	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Peer', $competency_id, $res['survey_question_id']);				
                $response[$count]['direct_report']    		=	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Direct Report', $competency_id, $res['survey_question_id']);  	       
                $count++;
			}			
        }

        return $response;
    }

    public function open_ended_response($program_id, $survey_participant_id)
    {
        // NOTE: when question_template_id is null it is open ended question 
        $response = array();

        //get the current participant being analyze
        $this->db->select('survey_participant_id');
        $this->db->from('program_survey_participant');
        $this->db->where('survey_participant_id', $survey_participant_id);
        $this->db->where('program_id', $program_id); 
        $query                          =   $this->db->get();
        $result                         =   $query->row_array(); 
        $survey_participant_id          =   $result ? $result['survey_participant_id'] : 0; 

        //get all open ended questions mapped to this program survey
        $this->db->select('survey_question_id, question');
        $this->db->from('program_survey_question');
        $this->db->where('is_approved', 1);
        $this->db->where('program_id', $program_id); 
        $this->db->where('question_template_id', null);  
        $query                          =   $this->db->get();

        if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				
                $response[$count]['question_id']            =	$res['survey_question_id'];		 
                $response[$count]['title']		            =	$res['question'];					
				$response[$count]['responses']			    =	$this->get_open_ended_responses($program_id, $survey_participant_id, $res['survey_question_id']);			        
                $count++;
			}			
        }

        return $response;
    }

    public function get_open_ended_responses($program_id, $survey_participant_id, $question_id)
    { 
        //get the current participant being analyze
        // $this->db->select('survey_participant_id');
        // $this->db->from('program_survey_participant');
        // $this->db->where('survey_participant_id', $survey_participant_id);
        // $this->db->where('program_id', $program_id); 
        // $query                          =   $this->db->get();
        // $result                         =   $query->row_array(); 
        // $survey_participant_id          =   $result ? $result['survey_participant_id'] : 0; 

        //get all responses mapped to this question
        $this->db->select('response_text AS response, response_feedback, email, name, survey_question_id, program_survey_response.survey_participant_id, relationship, 
                    relationship_index, program_survey_response.survey_surveyor_id as surveyor_id');
        $this->db->from('program_survey_response'); 
        $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id');
        $this->db->where('program_survey_response.survey_participant_id', $survey_participant_id);
        $this->db->where('program_survey_response.survey_question_id', $question_id); 

        $query                          =   $this->db->get();
        $result                         =   $query->result_array();  

        return $result;
    }
    
    // compare participant logic
    function fetch_comparison_analyze_surveyors($program_id, $participants)
	{		        
        $response		=   array();

        $count              =   0;
        foreach($participants as $emp)
        {	
            $response[$count]['index']  = $count;  
            $response[$count]['participant_name']  = $emp['name'];
            $response[$count]['participant_'. ($count + 1)]  =	$this->fetch_analyze_surveyors($program_id, $emp['number']);
            $count++;
        }

        return $response;
    }

    public function fetch_comparison_radar_score($program_id, $participants)
    {
        $this->db->select('competency, survey_competency_id');
        $this->db->from('program_survey_competency'); 
        $this->db->join('competency', 'program_survey_competency.competency_id = competency.competency_id');
        $this->db->where('program_id', $program_id);
		$query			=	$this->db->get();
        $response		=	array(); 

        if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				 	
                $response[$count]['survey_competency_id']   =	$res['survey_competency_id'];				
				$response[$count]['competencies']			=	$res['competency'];					
                $response[$count]['title']      			=	$res['competency'];	

                $k  = 0;
                foreach($participants as $emp)
                {	
                    $response[$count]['index']                   = $k;    
                    $response[$count]['participant_'. ($k + 1)]  =	$this->get_comparison_radar_score($program_id, $emp['number'], $res['survey_competency_id']);
                    $k++;
                }

                $count++;
			}			
        }
        
        return $response;
    }

    public function get_comparison_radar_score($program_id, $survey_participant_id, $competency_id, $question_id = null)
    {
        $response = array();

        //get the current participant being analyze
        $this->db->select('survey_participant_id, CONCAT(first_name," ",last_name) AS participant_name');
        $this->db->from('program_survey_participant');
        $this->db->where('survey_participant_id', $survey_participant_id);
        $this->db->where('program_id', $program_id); 
        $query                          =   $this->db->get();
        $result                         =   $query->row_array(); 
        $survey_participant_id          =   $result ? $result['survey_participant_id'] : 0; 
        $participant_name               =   $result ? $result['participant_name'] : 0; 

        //get avg_score of the $evaluator_category
        $this->db->select('SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low, MAX(response_whole_number) AS high');
        $this->db->from('program_survey_response'); 
        $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id');
        $this->db->where('program_survey_response.survey_participant_id', $survey_participant_id);
        $this->db->where('program_survey_response.survey_competency_id', $competency_id); 
        $this->db->where('program_survey_response.program_id', $program_id);  
        if($question_id){
            $this->db->where('program_survey_response.survey_question_id', $question_id); 
        }    
        $query                          =   $this->db->get();
        $result                         =   $query->row_array();  
        $total_score                    =   $result ? ($result['total_score'] ? $result['total_score'] : 0) : 0;
        $low                            =   $result ? ($result['low'] ? $result['low'] : 0) : 0;
        $high                           =   $result ? ($result['high'] ? $result['high'] : 0) : 0;

        //get surveyors per $evaluator_category
        $sql = "SELECT COUNT(survey_surveyor_id) AS my_surveyors FROM program_survey_surveyor S 
            WHERE EXISTS(SELECT 1 FROM program_survey_response R 
                WHERE R.survey_surveyor_id = S.survey_surveyor_id AND R.program_id = ?
                AND R.survey_participant_id = ?)
            AND S.program_id = ? 
            AND S.survey_participant_id = ?";
        $query = $this->db->query($sql, array($program_id, $survey_participant_id, $program_id, $survey_participant_id));
        $result                         =   $query->row_array();  
        $my_surveyors                   =   $result ? ($result['my_surveyors'] ? $result['my_surveyors'] : 0) : 0;

        $total_comp_questions = 1;
        if(!$question_id){
            //get total questions
            $this->db->select('COUNT(survey_question_id) AS question');  
            $this->db->from('program_survey_question');
            $this->db->where('survey_competency_id', $competency_id); 
            $this->db->where('program_id', $program_id);   
            $query                          =   $this->db->get();
            $result                         =   $query->row_array();  
            $total_comp_questions           =   $result ? ($result['question'] ? $result['question'] : 0) : 0;
        }

        //parse all value
        $my_surveyors                       =   floatval($my_surveyors);
        $total_comp_questions               =   floatval($total_comp_questions);
        $max_option_value                   =   5;
        $avg_score                          =   round(floatval($total_score), 1);
        $high                               =   floatval($high);
        $low                                =   floatval($low);

        // $percent = $this->compute_percentage_avg($my_surveyors, $total_comp_questions, $max_option_value, $avg_score);

        // return $avg_score;
        $avg            = ($my_surveyors == 0) ? 0 : ($total_score / ($my_surveyors * $total_comp_questions));

        return array(
            "total_comp_questions" => $total_comp_questions,
            "total_score" => $total_score,
            "avg" => round($avg,1),
            "high" => $high,
            "low" => $low, 
            "my_surveyors" => $my_surveyors,
            "max_option_value" => $max_option_value,
            "participant_name" => $participant_name
        ); 
    }

    public function fetch_comparison_question_score($program_id, $participants, $competency_id)
    { 
        $response = array(); 

        //get all questions mapped to this competency
        $this->db->select('survey_question_id, question');
        $this->db->from('program_survey_question');
        $this->db->where('is_approved', 1);
        $this->db->where('program_id', $program_id); 
        $this->db->where('survey_competency_id', $competency_id); 
        $query                          =   $this->db->get();

        if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				
                $response[$count]['question_id']            =	$res['survey_question_id'];		 
                $response[$count]['title']		            =	$res['question'];
                
                $k  = 0;
                foreach($participants as $emp)
                {	
                    $response[$count]['index']                   = $k; 
                    $response[$count]['participant_name']        = $emp['name'];    
                    $response[$count]['participant_'. ($k + 1)]  =	$this->get_comparison_radar_score($program_id, $emp['number'], $competency_id, $res['survey_question_id']);
                    $k++;
                } 
                $count++;
			}			
        }

        return $response;
    }

    // benchmark logic 
    public function fetch_benchmark_radar_score($program_id, $past_program_id, $company_id)
    {
        
        $response		    =	array(); 
        
        $sql = "SELECT DISTINCT competency.competency_id, competency, is_standard
        FROM competency RIGHT JOIN program_survey_competency ON competency.competency_id = program_survey_competency.competency_id
        WHERE (program_survey_competency.program_id = ".$this->db->escape($program_id)." OR program_survey_competency.program_id = ".$this->db->escape($past_program_id).")
        AND competency.is_standard = 1";
        
        $query = $this->db->query($sql);  

        if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				 	
                $response[$count]['competency_id']              =	$res['competency_id'];				
				$response[$count]['competencies']			    =	$res['competency'];					
                $response[$count]['title']      			    =	$res['competency'];						
				$response[$count]['is_standard']			    =	$res['is_standard'];	
                				
                $response[$count]['p_current']      		    =	$this->get_benchmark_program_radar_score($res['competency_id'], $program_id);				
                $response[$count]['p_past']      			    =	$this->get_benchmark_program_radar_score($res['competency_id'], $past_program_id);	                				
                $response[$count]['p_current_participant']      =	$this->get_benchmark_participant_radar_score($res['competency_id'], $program_id);					
                $response[$count]['p_past_participant']         =	$this->get_benchmark_participant_radar_score($res['competency_id'], $past_program_id);				
                $response[$count]['p_industry']      		    =	$this->get_benchmark_industry_radar_score($res['competency_id'], $program_id);
                $count++;
			}			
        }

        // return $query->result_array();
        return $response;
    }

    public function get_benchmark_program_radar_score($competency_id, $program_id = '', $company_id = ''/** used by industry */)
    {
        $response = array(); 

        //get its survey_competency_id
        $this->db->select('survey_competency_id');
        $this->db->from('program_survey_competency');
        $this->db->where('program_id', $program_id);
        $this->db->where('competency_id', $competency_id);
        $query                          =   $this->db->get();
        $result                         =   $query->row_array();    
        $survey_competency_id           =   $result ? ($result['survey_competency_id'] ? $result['survey_competency_id'] : 0) : 0;
        
        //get total_score of survey_competency_id of the current program_survey 
        $this->db->select('SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low,  MAX(response_whole_number) AS high');
        $this->db->from('program_survey_response'); 
        $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id'); 
        $this->db->where('program_survey_response.survey_competency_id', $survey_competency_id); 
        if($program_id){
            $this->db->where('program_survey_response.program_id', $program_id);
        }  
        $query                          =   $this->db->get();
        $result                         =   $query->row_array();  
        $total_score                    =   $result ? ($result['total_score'] ? $result['total_score'] : 0) : 0;
        $low                            =   $result ? ($result['low'] ? $result['low'] : 0) : 0;
        $high                           =   $result ? ($result['high'] ? $result['high'] : 0) : 0;

        //get surveyors of competency
        $sql = "SELECT COUNT(survey_surveyor_id) AS my_surveyors FROM program_survey_surveyor S";
        if($program_id){
            $sql .= " WHERE EXISTS(SELECT 1 FROM program_survey_response R WHERE R.survey_surveyor_id = S.survey_surveyor_id 
            AND R.program_id = ".$this->db->escape($program_id).") AND S.program_id = ".$this->db->escape($program_id)."";
        }else{
            //for industry
            $sql .= " WHERE EXISTS(SELECT 1 FROM program_survey_response R WHERE R.survey_surveyor_id = S.survey_surveyor_id) 
            AND EXISTS(SELECT 1 FROM industry I WHERE I.industry_id = (SELECT industry_id FROM company 
                WHERE company.company_id = ".$this->db->escape($company_id).")";
        }                  

        $query = $this->db->query($sql);
        $result                         =   $query->row_array();  
        $my_surveyors                   =   $result ? ($result['my_surveyors'] ? $result['my_surveyors'] : 0) : 0;

        //get total questions
        $this->db->select('COUNT(survey_question_id) AS question');  
        $this->db->from('program_survey_question');
        $this->db->where('survey_competency_id', $survey_competency_id); 
        $this->db->where('program_id', $program_id);   
        $query                          =   $this->db->get();
        $result                         =   $query->row_array();  
        $total_comp_questions           =   $result ? ($result['question'] ? $result['question'] : 0) : 0;

        //parse all value
        $my_surveyors                       =   floatval($my_surveyors);
        $total_comp_questions               =   floatval($total_comp_questions);
        $max_option_value                   =   5; 
        $high                               =   floatval($high);
        $low                                =   floatval($low); 

        // return $avg_score;
        $avg            = ($my_surveyors == 0 || $total_comp_questions == 0) ? 0 : ($total_score / ($my_surveyors * $total_comp_questions));

        return array(
            "total_comp_questions" => $total_comp_questions,
            "total_score" => $total_score,
            "avg" => round($avg,1),
            "high" => $high,
            "low" => $low, 
            "my_surveyors" => $my_surveyors,
            "max_option_value" => $max_option_value
        ); 
    }

    public function get_benchmark_industry_radar_score($competency_id, $current_program_id = ''/** used by industry */)
    {
        $response = array(); 
        
        // get the current industry id
        $sql    = "SELECT industry_id FROM company WHERE company.company_id = (SELECT company_id FROM program WHERE program_id = ".$this->db->escape($current_program_id).")";
        $query  = $this->db->query($sql);
        $result                     =   $query->row_array();  
        $industry_id                =   $result ? ($result['industry_id'] ? $result['industry_id'] : 0) : 0;
        
        // get total_score of response submitted for the selected competency
        $sql = "SELECT SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low,  MAX(response_whole_number) AS high
                FROM program_survey_response R
                WHERE EXISTS(SELECT 1 FROM program_survey_competency SC WHERE SC.competency_id = ".$this->db->escape($competency_id)." 
                    AND SC.survey_competency_id = R.survey_competency_id)
                AND EXISTS(SELECT 1 FROM company C WHERE C.industry_id = ".$this->db->escape($industry_id)." 
                    AND C.company_id = R.company_id)";  
        $query = $this->db->query($sql);
        $result                     =   $query->row_array();    
        $total_score                =   $result ? ($result['total_score'] ? $result['total_score'] : 0) : 0;
        $low                        =   $result ? ($result['low'] ? $result['low'] : 0) : 0;
        $high                       =   $result ? ($result['high'] ? $result['high'] : 0) : 0;

        //get surveyors that responded on the selected competency
        $sql = "SELECT COUNT(survey_surveyor_id) AS my_surveyors 
                FROM program_survey_surveyor SS 
                WHERE EXISTS(SELECT 1 FROM program_survey_response SR WHERE SR.survey_surveyor_id = SS.survey_surveyor_id 
                    AND EXISTS(SELECT 1 FROM program_survey_competency SC WHERE SC.competency_id = ".$this->db->escape($competency_id)." 
                    AND SC.survey_competency_id = SR.survey_competency_id))
                AND EXISTS(SELECT 1 FROM company C WHERE C.industry_id = ".$this->db->escape($industry_id)." 
                    AND C.company_id = SS.company_id)";               

        $query = $this->db->query($sql);
        $result                         =   $query->row_array();  
        $my_surveyors                   =   $result ? ($result['my_surveyors'] ? $result['my_surveyors'] : 0) : 0;

        //get total questions of the selected competency
        $sql = "SELECT COUNT(survey_question_id) AS question 
                FROM program_survey_question SQ 
                WHERE EXISTS(SELECT 1 FROM program_survey_competency SC WHERE SC.competency_id = ".$this->db->escape($competency_id)." 
                    AND SC.survey_competency_id = SQ.survey_competency_id)
                AND EXISTS(SELECT 1 FROM company C WHERE C.industry_id = ".$this->db->escape($industry_id)." 
                    AND C.company_id = SQ.company_id)";   

        $query = $this->db->query($sql);
        $result                         =   $query->row_array();  
        $total_comp_questions           =   $result ? ($result['question'] ? $result['question'] : 0) : 0;

        //parse all value
        $my_surveyors                   =   floatval($my_surveyors);
        $total_comp_questions           =   floatval($total_comp_questions);
        $max_option_value               =   5; 
        $high                           =   floatval($high);
        $low                            =   floatval($low); 

        // return $avg_score;
        $avg            = ($my_surveyors == 0 || $total_comp_questions == 0) ? 0 : ($total_score / ($my_surveyors * $total_comp_questions));

        return array(
            "total_comp_questions" => $total_comp_questions,
            "total_score" => $total_score,
            "avg" => round($avg,1),
            "high" => $high,
            "low" => $low, 
            "my_surveyors" => $my_surveyors,
            "max_option_value" => $max_option_value
        ); 
    }

    public function get_benchmark_participant_radar_score($competency_id, $program_id)
    {
        $this->db->select('user_id, survey_participant_id, employee_number, email, phone_number, first_name, last_name');
        $this->db->from('program_survey_participant');
        $this->db->where('program_id', $program_id);	  
        $query			        =	$this->db->get();	
        $result                 =   $query->result_array();

        //store highest value here
        $highest_avg            =   0;
        $highest_participant    =   null;

        if($result){
            //      
            if($query->num_rows() > 0)
            {			
                $count		=	0;			 	
                foreach($result as $res)
                {						
                    
                    //get its survey_competency_id
                    $this->db->select('survey_competency_id');
                    $this->db->from('program_survey_competency');
                    $this->db->where('program_id', $program_id);
                    $this->db->where('competency_id', $competency_id);
                    $query                          =   $this->db->get();
                    $com_result                     =   $query->row_array();    
                    $survey_competency_id           =   $com_result ? ($com_result['survey_competency_id'] ? $com_result['survey_competency_id'] : 0) : 0;        
        
                    $calculated_score_obj	        =	$this->get_comparison_radar_score($program_id, $res['survey_participant_id'], $survey_competency_id);

                    if($calculated_score_obj['avg'] > $highest_avg){
                        $highest_avg                =   $calculated_score_obj['avg'];
                        $highest_participant        =   $calculated_score_obj;
                    }		 	       
                    $count++;
                }
            }			
        }                      
        return $highest_participant;         
    } 

    // download to excel
    public function download_pending_evaluators($base_url, $program_id){
        $sql = "SELECT name, email, phone_number, relationship,  (SELECT CONCAT(first_name,' ',last_name)  FROM program_survey_participant p 
                WHERE p.survey_id = s.survey_id AND p.survey_participant_id = s.survey_participant_id) participant, 
                CONCAT(". $this->db->escape($base_url).",survey_id,'/',survey_surveyor_id,'/', survey_participant_id) URL 
                FROM program_survey_surveyor s 
                WHERE s.program_id = ". $this->db->escape($program_id)."
                AND (relationship = 'Self' OR relationship = 'Line Manager' OR relationship = 'Peer' OR relationship = 'Direct Report') 
                    AND s.survey_surveyor_id NOT IN (SELECT survey_surveyor_id FROM program_survey_response r WHERE r.survey_id = s.survey_id 
                        AND s.survey_surveyor_id = r.survey_surveyor_id 
                        AND s.survey_participant_id = r.survey_participant_id)";
        
        $query = $this->db->query($sql); 

        return $query->result_array();      
    }

    // survey response rate section 
    public function participants_detail_criterias()
    {
        $sql = "SELECT (SELECT grade FROM grade G WHERE SP.grade_id = G.grade_id) grade, 
        (SELECT location FROM location L WHERE SP.grade_id = L.location_id) location, 
        (SELECT department FROM department D WHERE SP.grade_id = D.department_id) grade, 
        (SELECT company_name FROM company C WHERE SP.company_id = C.company_id) company, 
        survey_participant_id, user_id, first_name, last_name, email, phone_number, program_id, survey_id 
        FROM program_survey_participant SP ORDER BY `location` ASC";
        
        $query = $this->db->query($sql); 

        return $query->result_array(); 
    }

    public function response_rate_criteria_grade($program_id)
    {
        $sql    =   "SELECT grade_id, grade as title,
        (SELECT COUNT(survey_participant_id) FROM program_survey_participant SP WHERE SP.grade_id = G.grade_id 
            AND SP.program_id = ".$this->db->escape($program_id).") total_participants,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS 
             WHERE EXISTS(SELECT survey_participant_id FROM program_survey_participant SP WHERE SP.survey_participant_id = SS.survey_participant_id 
             AND G.grade_id = SP.grade_id AND SP.program_id = ".$this->db->escape($program_id).")) total_surveyor_invited,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS 
             WHERE SS.survey_participant_id IN (SELECT survey_participant_id FROM program_survey_participant SP WHERE SP.survey_participant_id = SS.survey_participant_id 
             AND G.grade_id = SP.grade_id AND SP.program_id = ".$this->db->escape($program_id).")
            AND SS.survey_surveyor_id IN (SELECT survey_surveyor_id FROM program_survey_response SR WHERE SR.survey_surveyor_id = SS.survey_surveyor_id AND SR.survey_participant_id = SS.survey_participant_id 
            AND SR.program_id = ".$this->db->escape($program_id).")) total_surveyor_responded
        FROM grade G
        WHERE grade_id IN (SELECT grade_id FROM program_survey_participant WHERE program_id = ".$this->db->escape($program_id).")";

        $query = $this->db->query($sql); 

        return $query->result_array(); 
    }
    public function response_rate_criteria_grade_refactor($program_id)
    {
        //get company id as dependency
        $sql    =   "SELECT grade_id, grade as title
                    FROM grade G 
                    WHERE grade_id IN (SELECT grade_id FROM program_survey_participant 
                    WHERE program_id = ".$this->db->escape($program_id).")";
        $query = $this->db->query($sql);  

        $result_response    =   [];

        if($query->num_rows() > 0)
		{		
            $count		=	0;			
            $result		=	$query->result_array();	 

			foreach($result as $res)
			{

                $grade_id             =   $res['grade_id'];
                
                //total_participants by department  
                $this->db->select('COUNT(survey_participant_id) total_participants');
                $this->db->from('program_survey_participant');
                $this->db->where('program_survey_participant.grade_id', $grade_id); 
                $this->db->where('program_survey_participant.program_id', $program_id);  
                $query                  =   $this->db->get();
                $result                 =   $query->row_array();  
                $total_participants     =   $result ? $result['total_participants'] : 0; 

                //total_surveyor_invited
                $sql    =   "SELECT COUNT(survey_surveyor_id) total_surveyor_invited 
                            FROM program_survey_surveyor SS
                            WHERE SS.program_id = ".$this->db->escape($program_id)."
                            AND SS.survey_participant_id IN (
                                SELECT survey_participant_id FROM program_survey_participant SP 
                                WHERE SP.grade_id = ".$this->db->escape($grade_id)." 
                                AND SP.program_id = ".$this->db->escape($program_id).")
                            ";
                $query                          =   $this->db->query($sql); 
                $result                         =   $query->row_array();  
                $total_surveyor_invited         =   $result ? $result['total_surveyor_invited'] : 0; 
                                
                //total_surveyor_responded  
                $sql    =   "SELECT COUNT(survey_surveyor_id) total_surveyor_responded 
                            FROM program_survey_surveyor SS
                            WHERE SS.program_id = ".$this->db->escape($program_id)."
                            AND SS.survey_participant_id IN (
                                SELECT survey_participant_id FROM program_survey_participant SP 
                                WHERE SP.grade_id = ".$this->db->escape($grade_id)." 
                                AND SP.program_id = ".$this->db->escape($program_id).")
                            AND SS.survey_surveyor_id IN (
                                SELECT survey_surveyor_id FROM program_survey_response SR 
                                WHERE SR.program_id = ".$this->db->escape($program_id)."
                            )";
                $query                          =   $this->db->query($sql); 
                $result                         =   $query->row_array();  
                $total_surveyor_responded         =   $result ? $result['total_surveyor_responded'] : 0; 

                $result_response[$count]        = array(
                    'grade_id'                  =>  $grade_id,
                    'title'                     =>  $res['title'],
                    'total_participants'        =>  $total_participants,
                    'total_surveyor_invited'    =>  $total_surveyor_invited,
                    'total_surveyor_responded'  =>  $total_surveyor_responded
                );

                $count++;

            } 

        } 

        return $result_response;
        
    }

    public function response_rate_criteria_location($program_id)
    {
        $sql    =   "SELECT location_id, location as title,
        (SELECT COUNT(survey_participant_id) FROM program_survey_participant SP WHERE SP.location_id = L.location_id 
            AND SP.program_id = ".$this->db->escape($program_id).") total_participants,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS 
             WHERE EXISTS(SELECT survey_participant_id FROM program_survey_participant SP WHERE SP.survey_participant_id = SS.survey_participant_id 
             AND SP.location_id = L.location_id AND SP.program_id = ".$this->db->escape($program_id).")) total_surveyor_invited,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS 
             WHERE SS.survey_participant_id IN (SELECT survey_participant_id FROM program_survey_participant SP WHERE SP.survey_participant_id = SS.survey_participant_id 
             AND SP.location_id = L.location_id AND SP.program_id = ".$this->db->escape($program_id).")
            AND SS.survey_surveyor_id IN (SELECT survey_surveyor_id FROM program_survey_response SR WHERE SR.survey_surveyor_id = SS.survey_surveyor_id AND SR.survey_participant_id = SS.survey_participant_id 
            AND SR.program_id = ".$this->db->escape($program_id).")) total_surveyor_responded
        FROM location L
        WHERE location_id IN (SELECT location_id FROM program_survey_participant WHERE program_id = ".$this->db->escape($program_id).")";

        $query = $this->db->query($sql); 

        return $query->result_array(); 
    }
    public function response_rate_criteria_location_refactor($program_id)
    {
        //get company id as dependency
        $sql    =   "SELECT location_id, location as title
                    FROM location L 
                    WHERE location_id IN (SELECT location_id FROM program_survey_participant 
                    WHERE program_id = ".$this->db->escape($program_id).")";
        $query = $this->db->query($sql); 
        $result             =   $query->row_array();   

        $result_response    =   [];

        if($query->num_rows() > 0)
		{		
            $count		=	0;			
            $result		=	$query->result_array();	 

			foreach($result as $res)
			{

                $location_id             =   $res['location_id'];
                
                //total_participants by department  
                $this->db->select('COUNT(survey_participant_id) total_participants');
                $this->db->from('program_survey_participant');
                $this->db->where('program_survey_participant.location_id', $location_id); 
                $this->db->where('program_survey_participant.program_id', $program_id);  
                $query                  =   $this->db->get();
                $result                 =   $query->row_array();  
                $total_participants     =   $result ? $result['total_participants'] : 0; 

                //total_surveyor_invited
                $sql    =   "SELECT COUNT(survey_surveyor_id) total_surveyor_invited 
                            FROM program_survey_surveyor SS
                            WHERE SS.program_id = ".$this->db->escape($program_id)."
                            AND SS.survey_participant_id IN (
                                SELECT survey_participant_id FROM program_survey_participant SP 
                                WHERE SP.location_id = ".$this->db->escape($location_id)." 
                                AND SP.program_id = ".$this->db->escape($program_id).")
                            ";
                $query                          =   $this->db->query($sql); 
                $result                         =   $query->row_array();  
                $total_surveyor_invited         =   $result ? $result['total_surveyor_invited'] : 0; 
                                
                //total_surveyor_responded  
                $sql    =   "SELECT COUNT(survey_surveyor_id) total_surveyor_responded 
                            FROM program_survey_surveyor SS
                            WHERE SS.program_id = ".$this->db->escape($program_id)."
                            AND SS.survey_participant_id IN (
                                SELECT survey_participant_id FROM program_survey_participant SP 
                                WHERE SP.location_id = ".$this->db->escape($location_id)." 
                                AND SP.program_id = ".$this->db->escape($program_id).")
                            AND SS.survey_surveyor_id IN (
                                SELECT survey_surveyor_id FROM program_survey_response SR 
                                WHERE SR.program_id = ".$this->db->escape($program_id)."
                            )";
                $query                          =   $this->db->query($sql); 
                $result                         =   $query->row_array();  
                $total_surveyor_responded         =   $result ? $result['total_surveyor_responded'] : 0; 

                $result_response[$count]        = array(
                    'location_id'             =>  $location_id,
                    'title'                     =>  $res['title'],
                    'total_participants'        =>  $total_participants,
                    'total_surveyor_invited'    =>  $total_surveyor_invited,
                    'total_surveyor_responded'  =>  $total_surveyor_responded
                );

                $count++;

            } 

        }
        
        // print_r($result_response);

        return $result_response;
        
    }

    public function response_rate_criteria_department($program_id)
    {
        $sql    =   "SELECT department_id, department as title,
        (SELECT COUNT(survey_participant_id) FROM program_survey_participant SP WHERE SP.department_id = D.department_id 
            AND SP.program_id = ".$this->db->escape($program_id).") total_participants,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS 
             WHERE EXISTS(SELECT survey_participant_id FROM program_survey_participant SP WHERE SP.survey_participant_id = SS.survey_participant_id 
             AND SP.department_id = D.department_id AND SP.program_id = ".$this->db->escape($program_id).")) total_surveyor_invited,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS 
             WHERE SS.survey_participant_id IN (SELECT survey_participant_id FROM program_survey_participant SP WHERE SP.survey_participant_id = SS.survey_participant_id 
             AND SP.department_id = D.department_id AND SP.program_id = ".$this->db->escape($program_id).")
            AND SS.survey_surveyor_id IN (SELECT survey_surveyor_id FROM program_survey_response SR WHERE SR.survey_surveyor_id = SS.survey_surveyor_id AND SR.survey_participant_id = SS.survey_participant_id 
            AND SR.program_id = ".$this->db->escape($program_id).")) total_surveyor_responded
        FROM department D
        WHERE department_id IN (SELECT department_id FROM program_survey_participant WHERE program_id = ".$this->db->escape($program_id).")";

        $query = $this->db->query($sql); 

        return $query->result_array(); 
    }
    public function response_rate_criteria_department_refactor($program_id)
    {
        //get company id as dependency
        $sql    =   "SELECT department_id, department as title
                    FROM department D
                    WHERE department_id IN (SELECT department_id FROM program_survey_participant 
                    WHERE program_id = ".$this->db->escape($program_id).")";        
        $query = $this->db->query($sql); 
        $result             =   $query->row_array();  
        $department_id      =   $result ? $result['department_id'] : 0;

        //get all survey that 

        $result_response    =   [];

        if($query->num_rows() > 0)
		{		
            $count		=	0;			
            $result		=	$query->result_array();	 

			foreach($result as $res)
			{

                $department_id             =   $res['department_id'];
                
                //total_participants by department  
                $this->db->select('COUNT(survey_participant_id) total_participants');
                $this->db->from('program_survey_participant');
                $this->db->where('program_survey_participant.department_id', $department_id); 
                $this->db->where('program_survey_participant.program_id', $program_id);  
                $query                  =   $this->db->get();
                $result                 =   $query->row_array();  
                $total_participants     =   $result ? $result['total_participants'] : 0; 

                //total_surveyor_invited
                $sql    =   "SELECT COUNT(survey_surveyor_id) total_surveyor_invited 
                            FROM program_survey_surveyor SS
                            WHERE SS.program_id = ".$this->db->escape($program_id)."
                            AND SS.survey_participant_id IN (
                                SELECT survey_participant_id FROM program_survey_participant SP 
                                WHERE SP.department_id = ".$this->db->escape($department_id)." 
                                AND SP.program_id = ".$this->db->escape($program_id).")
                            ";
                $query                          =   $this->db->query($sql); 
                $result                         =   $query->row_array();  
                $total_surveyor_invited         =   $result ? $result['total_surveyor_invited'] : 0; 
                                
                //total_surveyor_responded  
                $sql    =   "SELECT COUNT(survey_surveyor_id) total_surveyor_responded 
                            FROM program_survey_surveyor SS
                            WHERE SS.program_id = ".$this->db->escape($program_id)."
                            AND SS.survey_participant_id IN (
                                SELECT survey_participant_id FROM program_survey_participant SP 
                                WHERE SP.department_id = ".$this->db->escape($department_id)." 
                                AND SP.program_id = ".$this->db->escape($program_id).")
                            AND SS.survey_surveyor_id IN (
                                SELECT survey_surveyor_id FROM program_survey_response SR 
                                WHERE SR.program_id = ".$this->db->escape($program_id)."
                            )";
                $query                          =   $this->db->query($sql); 
                $result                         =   $query->row_array();  
                $total_surveyor_responded         =   $result ? $result['total_surveyor_responded'] : 0; 

                $result_response[$count]        = array(
                    'department_id'             =>  $department_id,
                    'title'                     =>  $res['title'],
                    'total_participants'        =>  $total_participants,
                    'total_surveyor_invited'    =>  $total_surveyor_invited,
                    'total_surveyor_responded'  =>  $total_surveyor_responded
                );

                $count++;

            } 

        }
        
        return $result_response;
        
    }

    public function response_rate_criteria_company($program_id)
    {
        $sql    =   "SELECT company_id, company_name as title,
        (SELECT COUNT(survey_participant_id) FROM program_survey_participant SP WHERE SP.company_id = C.company_id 
            AND SP.program_id = ".$this->db->escape($program_id).") total_participants,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS 
             WHERE EXISTS(SELECT survey_participant_id FROM program_survey_participant SP WHERE SP.survey_participant_id = SS.survey_participant_id 
             AND SP.company_id = C.company_id AND SP.program_id = ".$this->db->escape($program_id).")) total_surveyor_invited,
        (SELECT COUNT(survey_surveyor_id) FROM program_survey_surveyor SS 
             WHERE SS.survey_participant_id IN (SELECT survey_participant_id FROM program_survey_participant SP WHERE SP.survey_participant_id = SS.survey_participant_id 
             AND SP.company_id = C.company_id AND SP.program_id = ".$this->db->escape($program_id).")
            AND SS.survey_surveyor_id IN (SELECT survey_surveyor_id FROM program_survey_response SR WHERE SR.survey_surveyor_id = SS.survey_surveyor_id AND SR.survey_participant_id = SS.survey_participant_id 
            AND SR.program_id = ".$this->db->escape($program_id).")) total_surveyor_responded
        FROM company C
        WHERE company_id IN (SELECT company_id FROM program_survey_participant WHERE program_id = ".$this->db->escape($program_id).")";

        $query = $this->db->query($sql); 

        // echo json_encode($query->result_array()); 
        return $query->result_array(); 
    }
    public function response_rate_criteria_company_refactor($program_id)
    {
        //get company id as dependency
        $sql    =   "SELECT company_id, company_name as title
                    FROM company C
                    WHERE company_id IN (SELECT company_id FROM program_survey_participant 
                    WHERE program_id = ".$this->db->escape($program_id).")";        
        $query = $this->db->query($sql); 
        $result             =   $query->row_array();  
        $company_id         =   $result ? $result['company_id'] : 0;

        $result_response    =   [];

        if($query->num_rows() > 0)
		{		
            $count		=	0;			
            $result		=	$query->result_array();	 

			foreach($result as $res)
			{

                $company_id             =   $res['company_id'];
                
                //total_participants
                $this->db->select('COUNT(survey_participant_id) total_participants');
                $this->db->from('program_survey_participant');
                $this->db->where('program_survey_participant.company_id', $company_id); 
                $this->db->where('program_survey_participant.program_id', $program_id);  
                $query                  =   $this->db->get();
                $result                 =   $query->row_array();  
                $total_participants     =   $result ? $result['total_participants'] : 0;

                //total_surveyor_invited
                $this->db->select('COUNT(survey_surveyor_id) total_surveyor_invited');
                $this->db->from('program_survey_surveyor');
                $this->db->where('program_survey_surveyor.company_id', $company_id); 
                $this->db->where('program_survey_surveyor.program_id', $program_id);  
                $query                      =   $this->db->get();
                $result                     =   $query->row_array();  
                $total_surveyor_invited     =   $result ? $result['total_surveyor_invited'] : 0;     
                
                //total_surveyor_responded                
                $sql    =   "SELECT COUNT(survey_surveyor_id) total_surveyor_responded
                            FROM program_survey_surveyor SS
                            WHERE SS.company_id = ".$this->db->escape($company_id)."
                            AND SS.program_id = ".$this->db->escape($program_id)."
                            AND SS.survey_surveyor_id IN (
                                SELECT survey_surveyor_id FROM program_survey_response SR 
                                WHERE SR.company_id = ".$this->db->escape($company_id)." 
                                AND SR.program_id = ".$this->db->escape($program_id)."
                            )";
                $query                          =   $this->db->query($sql); 
                $result                         =   $query->row_array();  
                $total_surveyor_responded       =   $result ? $result['total_surveyor_responded'] : 0;

                $result_response[$count]        = array(
                    'company_id'                =>  $company_id,
                    'title'                     =>  $res['title'],
                    'total_participants'        =>  $total_participants,
                    'total_surveyor_invited'    =>  $total_surveyor_invited,
                    'total_surveyor_responded'  =>  $total_surveyor_responded
                );

                $count++;

            } 

        }
        
        return $result_response;
        
    }

    public function response_rate_criteria($program_id, $filter)
    {        
        $response = array();

        switch($filter){
            case "grade":       
                $response = $this->response_rate_criteria_grade_refactor($program_id);
            break;
            case "location":    
                $response = $this->response_rate_criteria_location_refactor($program_id); 
            break;
            case "department":  
                $response = $this->response_rate_criteria_department_refactor($program_id);
            break;
            case "company":     
                $response = $this->response_rate_criteria_company_refactor($program_id);
            break;
        }

        return $response;
    } 

    // action plan section

    public function fetch_enforcer($program_id)
    {
        $this->db->select('user.user_id, email, phone_number, first_name, last_name');
        $this->db->from('user');
        $this->db->join('program_owner', 'user.user_id = program_owner.owner_id');
        $this->db->where('program_owner.program_id', $program_id);	  
        $query			        =	$this->db->get();	
        $result                 =   $query->result_array();
        return $result;
    }

    public function save_action_plan($save)
	{ 		
		$table								=	'program_survey_action_plan';
		
		$id_field							=	'action_plan_id'; 
		
		if(!empty($save['action_plan_id']))
		{
			
			$this->db->where('action_plan_id', $save['action_plan_id']);
			
			$query							=	$this->db->update($table, $save);
			
			$id 							= 	$save['action_plan_id'];
			
		}else{			
			
			$this->db->insert($table, $save);
			
			$id 							= 	$this->db->insert_id();	
						
        } 
        
		return $id; 		
    }

    public function save_action_plan_status($action_plan_id, $status)
	{ 		
		$table								=	'program_survey_action_plan'; 
		
		if(!empty($action_plan_id))
		{              
            $this->db->set('status', $status);
            $this->db->where('action_plan_id', $action_plan_id);
            if($this->db->update($table)){
                return true;
            } else {
                return false;
            }
		}        
		return false; 		
    }
    
    public function fetch_action_plans($program_id, $action_plan_id = '')
    {
        $this->db->select('action_plan_id, program_survey_action_plan.survey_id, program_survey_action_plan.program_id, specific_plans, 
        desired_outcome, resources_needed, program_owner_id, first_name, last_name, program_survey_action_plan.status, start_date, deadline_date');
        $this->db->from('program_survey_action_plan');
        $this->db->join('program_survey_participant','program_survey_action_plan.program_owner_id = program_survey_participant.survey_participant_id');
        $this->db->where('program_survey_action_plan.program_id', $program_id);	 
        if(!empty($action_plan_id)) {
            $this->db->where('program_survey_action_plan.action_plan_id', $action_plan_id);	
        }
        $query			        =	$this->db->get();	
        return !empty($action_plan_id) ? $query->row_array() : $query->result_array();
    }

    public function get_company_setting($companyID)
	{
        
        $this->db->select('company_logo, company_name, company_setting.*');
        $this->db->from('company_setting');
        $this->db->join('company', 'company.company_id = company_setting.company_id');
        $this->db->where('company_setting.company_id', $companyID); 
		
		$query		=	$this->db->get(); //$this->db->get('company_setting');
		
		if($query->num_rows() > 0)
		{
			
			return $query->row_array();
				
		}else{
			
			return FALSE;
			
		}

    }

    public function get_company_setting_by_survey($surveyID)
	{

        $this->db->select('company_id');
        $this->db->from('program_survey'); 
        $this->db->where('survey_id', $surveyID);  

        $query              =   $this->db->get();
        $result             =   $query->row_array();  
        $companyID          =   $result ? $result['company_id'] : 0; 

		$this->db->select('company_logo, company_name, company_setting.*');
        $this->db->from('company_setting');
        $this->db->join('company', 'company.company_id = company_setting.company_id');
        $this->db->where('company_setting.company_id', $companyID);			

		$query		        =	$this->db->get(); //$this->db->get('company_setting');
		
		if($query->num_rows() > 0)
		{
			
			return $query->row_array();
				
		}else{
			
			return FALSE;
			
		}

    }

    public function get_competency_count($surveyID)
    {
        $this->db->select('company_id');
        $this->db->from('program_survey'); 
        $this->db->where('survey_id', $surveyID);  

        $query              =   $this->db->get();
        $result             =   $query->row_array();  
        $companyID          =   $result ? $result['company_id'] : 0; 

		$this->db->select('count(survey_competency_id) as count');
        $this->db->from('program_survey_competency');
        $this->db->where('company_id', $companyID);
        $this->db->where('survey_id', $surveyID);			

		$query              =   $this->db->get();
        $result             =   $query->row_array();  
        $count              =   $result ? $result['count'] : 0;

        return $count;
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

    // 
    public function fetch_pmf_radar_score($program_id, $survey_participant_id)
    {
        //get all pmf
        $sql    =   "SELECT (SELECT custom1 FROM question_template T 
                    WHERE T.question_template_id = SQ.question_template_id) pmf
                    FROM program_survey_question SQ
                    WHERE is_approved = 1
                    AND program_id = ".$this->db->escape($program_id)."
                    AND question_template_id IN (
                        SELECT question_template_id FROM question_template T 
                        WHERE T.question_template_id = SQ.question_template_id
                    )
                    GROUP BY pmf";
        
        $query          =   $this->db->query($sql);
        $response		=	array(); 

        if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				 	
                $response[$count]['pmf']                =	$res['pmf'];								
				$response[$count]['title']      		=	$res['pmf'];					
				$response[$count]['self']			    =	$this->get_pmf_category_scores($program_id, $survey_participant_id, 'Self', $res['pmf']);					
				$response[$count]['manager']    		=	$this->get_pmf_category_scores($program_id, $survey_participant_id, 'Line Manager', $res['pmf']);				
				$response[$count]['peers']    			=	$this->get_pmf_category_scores($program_id, $survey_participant_id, 'Peer', $res['pmf']);				
                $response[$count]['direct_report']    	=	$this->get_pmf_category_scores($program_id, $survey_participant_id, 'Direct Report', $res['pmf']);              
                $count++;
			}			
        }
        
        // print_r($response);
        return $response;
    }

    public function get_pmf_category_scores($program_id, $survey_participant_id, $evaluator_category, $pmf_category, $question_id = null)
    {
        $response = array();

        //get avg_score of the $evaluator_category
        $sql    =   "SELECT SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low, MAX(response_whole_number) AS high
                    FROM program_survey_response s
                    JOIN program_survey_surveyor ON s.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id
                    WHERE s.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                    AND program_survey_surveyor.relationship = ".$this->db->escape($evaluator_category)." 
                    AND s.program_id = ".$this->db->escape($program_id)."
                    AND survey_question_id IN (
                        SELECT survey_question_id FROM program_survey_question SQ WHERE is_approved = 1
                        AND program_id = ".$this->db->escape($program_id)."
                        AND question_template_id IN (
                            SELECT question_template_id 
                            FROM question_template T 
                            where T.question_template_id = SQ.question_template_id AND T.custom1 = ".$this->db->escape($pmf_category)."
                        )
                    )";

        $query                          =   $this->db->query($sql);
        $result                         =   $query->row_array();  
        $total_score                    =   $result ? ($result['total_score'] ? $result['total_score'] : 0) : 0;
        $low                            =   $result ? ($result['low'] ? $result['low'] : 0) : 0;
        $high                           =   $result ? ($result['high'] ? $result['high'] : 0) : 0;

        //get surveyors per $evaluator_category
        $sql    =   "SELECT COUNT(survey_surveyor_id) AS my_surveyors FROM program_survey_surveyor S 
                    WHERE S.survey_surveyor_id IN (
                        SELECT survey_surveyor_id FROM program_survey_response R 
                        WHERE R.program_id = ".$this->db->escape($program_id)."
                        AND R.survey_participant_id = ".$this->db->escape($survey_participant_id)." 
                        AND R.survey_question_id IN (
                            SELECT survey_question_id FROM program_survey_question SQ WHERE is_approved = 1
                            AND program_id = ".$this->db->escape($program_id)."
                            AND question_template_id IN (
                                SELECT question_template_id 
                                FROM question_template T 
                                where T.question_template_id = SQ.question_template_id AND T.custom1 = ".$this->db->escape($pmf_category)."
                            )
                        )
                    )
                    AND S.program_id = ".$this->db->escape($program_id)."
                    AND S.relationship = ".$this->db->escape($evaluator_category)."
                    AND S.survey_participant_id = ".$this->db->escape($survey_participant_id).""; 

        $query                          =   $this->db->query($sql);
        $result                         =   $query->row_array();  
        $my_surveyors                   =   $result ? ($result['my_surveyors'] ? $result['my_surveyors'] : 0) : 0;

        //get total questions
        $total_comp_questions = 1;
        if(!$question_id){
            $sql    =   "SELECT COUNT(survey_question_id) AS question
                        FROM `program_survey_question`
                        WHERE `program_id` = ".$this->db->escape($program_id)."
                        AND survey_question_id IN (
                            SELECT survey_question_id FROM program_survey_question SQ WHERE is_approved = 1
                            AND program_id = ".$this->db->escape($program_id)."
                            AND question_template_id IN (
                                SELECT question_template_id 
                                FROM question_template T 
                                where T.question_template_id = SQ.question_template_id AND T.custom1 = ".$this->db->escape($pmf_category)."
                            )
                        )";
            $query                          =   $this->db->query($sql);
            $result                         =   $query->row_array();   
            $total_comp_questions           =   $result ? ($result['question'] ? $result['question'] : 0) : 0;
        }

        //parse all value
        $my_surveyors                       =   floatval($my_surveyors);
        $total_comp_questions               =   floatval($total_comp_questions);
        $max_option_value                   =   5;
        // $avg_score                       =   round(floatval($total_score), 1);
        $high                               =   floatval($high);
        $low                                =   floatval($low);

        // return $avg_score
        $avg                                =   ($my_surveyors == 0) ? 0 : ($total_score / ($my_surveyors * $total_comp_questions));

        return array(
            "total_comp_questions" => $total_comp_questions,
            "total_score" => $total_score,
            "avg" => round($avg,1),
            "high" => $high,
            "low" => $low, 
            "my_surveyors" => $my_surveyors,
            "max_option_value" => $max_option_value
        ); 
    }

    public function fetch_pmf_competencies_radar_score($program_id, $survey_participant_id)
    {
        $this->db->select('competency, survey_competency_id, competency.description as description');
        $this->db->from('program_survey_competency'); 
        $this->db->join('competency', 'program_survey_competency.competency_id = competency.competency_id');
        $this->db->where('program_id', $program_id);
		$query			=	$this->db->get();
        $response		=	array(); 

        if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				 	
                $response[$count]['survey_competency_id']   =	$res['survey_competency_id'];				
				$response[$count]['competencies']			=	$res['competency'];					
				$response[$count]['title']      			=	$res['competency'];						
				$response[$count]['self']			        =	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Self', $res['survey_competency_id']);					
				$response[$count]['others']    			    =	$this->get_other_evaluator_category_scores($program_id, $survey_participant_id, $res['survey_competency_id']);		       
                $count++;
			}			
        }
        
        // print_r($response);
        return $response;
    }

    public function get_other_evaluator_category_scores($program_id, $survey_participant_id, $competency_id, $question_id = null)
    {
        $response = array();

        //get avg_score of the $evaluator_category
        $this->db->select('SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low,  MAX(response_whole_number) AS high');
        $this->db->from('program_survey_response'); 
        $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id');
        $this->db->where('program_survey_response.survey_participant_id', $survey_participant_id);
        $this->db->where('program_survey_response.survey_competency_id', $competency_id);
        $this->db->where('program_survey_surveyor.relationship !=','Self');//e.g (Peer, Line Manager, Direct Report) only  
        $this->db->where('program_survey_response.program_id', $program_id);  
        if($question_id){
            $this->db->where('program_survey_response.survey_question_id', $question_id); 
        }    
        $query                          =   $this->db->get();
        $result                         =   $query->row_array();  
        $total_score                    =   $result ? ($result['total_score'] ? $result['total_score'] : 0) : 0;
        $low                            =   $result ? ($result['low'] ? $result['low'] : 0) : 0;
        $high                           =   $result ? ($result['high'] ? $result['high'] : 0) : 0;

        //get surveyors per $evaluator_category
        $sql    =   "SELECT COUNT(survey_surveyor_id) AS my_surveyors FROM program_survey_surveyor S 
                   WHERE S.survey_surveyor_id IN (
                        SELECT survey_surveyor_id FROM program_survey_response R 
                        WHERE R.program_id = ".$this->db->escape($program_id)."
                        AND R.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                        AND R.survey_competency_id = ".$this->db->escape($competency_id).")
                    AND S.program_id = ".$this->db->escape($program_id)."
                    AND S.relationship != 'Self'
                    AND S.survey_participant_id = ".$this->db->escape($survey_participant_id).""; 

        $query = $this->db->query($sql);
        $result                         =   $query->row_array();  
        $my_surveyors                   =   $result ? ($result['my_surveyors'] ? $result['my_surveyors'] : 0) : 0;

        $total_comp_questions = 1;
        if(!$question_id){
            //get total questions
            $this->db->select('COUNT(survey_question_id) AS question');  
            $this->db->from('program_survey_question');
            $this->db->where('survey_competency_id', $competency_id); 
            $this->db->where('program_id', $program_id);   
            $query                          =   $this->db->get();
            $result                         =   $query->row_array();  
            $total_comp_questions           =   $result ? ($result['question'] ? $result['question'] : 0) : 0;
        }

        //parse all value
        $my_surveyors                       =   floatval($my_surveyors);
        $total_comp_questions               =   floatval($total_comp_questions);
        $max_option_value                   =   5;
        // $avg_score                       =   round(floatval($total_score), 1);
        $high                               =   floatval($high);
        $low                                =   floatval($low);

        // return $avg_score
        $avg                                =   ($my_surveyors == 0) ? 0 : ($total_score / ($my_surveyors * $total_comp_questions));

        return array(
            "total_comp_questions" => $total_comp_questions,
            "total_score" => $total_score,
            "avg" => round($avg,1),
            "high" => $high,
            "low" => $low, 
            "my_surveyors" => $my_surveyors,
            "max_option_value" => $max_option_value
        ); 
    }

    public function fetch_pmf_question_criteria_scores($program_id, $survey_participant_id)
    { 
        $response = array();

        //get total responded surveyors
        $sql    =   "SELECT COUNT(survey_surveyor_id) AS my_surveyors FROM program_survey_surveyor S 
                   WHERE S.survey_surveyor_id IN (
                        SELECT survey_surveyor_id FROM program_survey_response R 
                        WHERE R.program_id = ".$this->db->escape($program_id)."
                        AND R.survey_participant_id = ".$this->db->escape($survey_participant_id).")
                    AND S.program_id = ".$this->db->escape($program_id)."
                    AND S.survey_participant_id = ".$this->db->escape($survey_participant_id).""; 

        $query                   =  $this->db->query($sql);
        $result                  =   $query->row_array();  
        $my_surveyors            =   $result ? ($result['my_surveyors'] ? $result['my_surveyors'] : 0) : 0;

        //get all questions mapped to this competency
        $sql    =   "SELECT survey_question_id, question, survey_competency_id, 
                    (SELECT competency FROM competency C WHERE C.competency_id = (SELECT competency_id 
                        FROM program_survey_competency SC WHERE SC.survey_competency_id = SQ.survey_competency_id)) competency,
                    (SELECT hidden_strength FROM question_template T WHERE T.question_template_id = SQ.question_template_id) hidden_strength,
                    (SELECT blind_spot FROM question_template T WHERE T.question_template_id = SQ.question_template_id) blind_spot
                    FROM program_survey_question SQ
                    WHERE SQ.survey_competency_id IS NOT NULL
                    AND SQ.is_approved = 1 AND SQ.program_id = ".$this->db->escape($program_id)." 
                    AND survey_competency_id in (select survey_competency_id from program_survey_response where program_id = ".$this->db->escape($program_id).")";
        $query                   =  $this->db->query($sql); 
        if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				
                $response[$count]['question_id']            =	$res['survey_question_id'];		 
                $response[$count]['title']		            =	$res['question'];			 
                $response[$count]['survey_competency_id']	=	$res['survey_competency_id'];	
                $response[$count]['competency']		        =	$res['competency'];				
                $response[$count]['hidden_strength']		=	$res['hidden_strength'];				
                $response[$count]['blind_spot']		        =	$res['blind_spot'];							
				$response[$count]['self']    			    =	$this->get_pmf_question_criteria_scores($program_id, $survey_participant_id, $my_surveyors, $res['survey_question_id'], 'Self');
				$response[$count]['manager']    			=	$this->get_pmf_question_criteria_scores($program_id, $survey_participant_id, $my_surveyors, $res['survey_question_id'], 'Line Manager');
				$response[$count]['peers']    			    =	$this->get_pmf_question_criteria_scores($program_id, $survey_participant_id, $my_surveyors, $res['survey_question_id'], 'Peer');
				$response[$count]['direct_report']    	    =	$this->get_pmf_question_criteria_scores($program_id, $survey_participant_id, $my_surveyors, $res['survey_question_id'], 'Direct Report');
				$response[$count]['others']    			    =	$this->get_pmf_question_criteria_scores($program_id, $survey_participant_id, $my_surveyors, $res['survey_question_id'], 'others'); 	       
                $count++;
			}			
        }

        return $response;
    }

    public function get_pmf_question_criteria_scores($program_id, $survey_participant_id, $my_surveyors, $question_id, $evaluator_category)
    {
        $response = array();
        $total_score    =   0;
        $low            =   0;
        $high           =   0;

        //get avg_score of the $evaluator_category
        if($evaluator_category != 'others'){
            $this->db->select('SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low, MAX(response_whole_number) AS high');
            $this->db->from('program_survey_response'); 
            $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id');
            $this->db->where('program_survey_response.survey_participant_id', $survey_participant_id);
            $this->db->where('program_survey_surveyor.relationship', $evaluator_category);//e.g Peer, Line Manager, Direct Report, Self   
            $this->db->where('program_survey_response.program_id', $program_id); 
            $this->db->where('program_survey_response.survey_question_id', $question_id); 
            $query                          =   $this->db->get();
            $result                         =   $query->row_array();  
            $total_score                    =   $result ? ($result['total_score'] ? $result['total_score'] : 0) : 0;
            $low                            =   $result ? ($result['low'] ? $result['low'] : 0) : 0;
            $high                           =   $result ? ($result['high'] ? $result['high'] : 0) : 0;
        }else{
            $this->db->select('SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low, MAX(response_whole_number) AS high');
            $this->db->from('program_survey_response'); 
            $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id');
            $this->db->where('program_survey_response.survey_participant_id', $survey_participant_id);
            $this->db->where('program_survey_surveyor.relationship !=','Self');//e.g Peer, Line Manager, Direct Report, Self   
            $this->db->where('program_survey_response.program_id', $program_id);  
            if($question_id){
                $this->db->where('program_survey_response.survey_question_id', $question_id); 
            } 
            $query                          =   $this->db->get();
            $result                         =   $query->row_array();  
            $total_score                    =   $result ? ($result['total_score'] ? $result['total_score'] : 0) : 0;
            $low                            =   $result ? ($result['low'] ? $result['low'] : 0) : 0;
            $high                           =   $result ? ($result['high'] ? $result['high'] : 0) : 0;
        }
        //get surveyors per $evaluator_category
        
        if($evaluator_category != 'others'){
            $sql    =   "SELECT COUNT(survey_surveyor_id) AS my_surveyors FROM program_survey_surveyor S 
                        WHERE S.survey_surveyor_id IN (
                            SELECT survey_surveyor_id FROM program_survey_response R 
                            WHERE R.program_id = ".$this->db->escape($program_id)."
                            AND R.survey_participant_id = ".$this->db->escape($survey_participant_id).")
                        AND S.program_id = ".$this->db->escape($program_id)."
                        AND S.relationship = ".$this->db->escape($evaluator_category)."
                        AND S.survey_participant_id = ".$this->db->escape($survey_participant_id).""; 
                        
            $query = $this->db->query($sql);
            $result                         =   $query->row_array();  
            $my_surveyors                   =   $result ? ($result['my_surveyors'] ? $result['my_surveyors'] : 0) : 0;
        }

        $total_comp_questions = 1;

        //parse all value
        $my_surveyors                       =   floatval($my_surveyors);
        $total_comp_questions               =   floatval($total_comp_questions);
        $max_option_value                   =   5;
        $high                               =   floatval($high);
        $low                                =   floatval($low);

        // return $avg_score
        $avg                                =   ($my_surveyors == 0) ? 0 : ($total_score / ($my_surveyors * $total_comp_questions));

        return array(
            "total_comp_questions" => $total_comp_questions,
            "total_score" => $total_score,
            "avg" => round($avg,1),
            "high" => $high,
            "low" => $low, 
            "my_surveyors" => $my_surveyors,
            "max_option_value" => $max_option_value
        ); 
    }

    public function upload_hidden_tmp()
    { 
        $this->db->select('question_template_id, hidden_strengths, blind_spots');
        $this->db->from('hidden_tmp');   
		$query			=	$this->db->get();
        $response		=	array(); 

        if($query->num_rows() > 0)
		{			
			$count		=	0;			
			$result		=	$query->result_array();			
			foreach($result as $res)
			{				 

                $this->db->where('question_template_id', $res['question_template_id']);                    
                $query = $this->db->update('question_template', array(
                    'hidden_strength' => $res['hidden_strengths'],
                    'blind_spot' => $res['blind_spots']
                ));

                echo 'question_template_id: ' . $query .'<br>';

                if($query){
                    echo json_encode($res) .'<br>';
                } else {
                    echo 'Not updated <br>';
                }

                $count++; 
                echo $count .'<br><br>'; 
			}			
        }
        
        // print_r($response);
        return $response;
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

    public function fetch_strength_and_opportunity($survey_id, $survey_participant_id)
    {
        $sql = "select survey_id, survey_participant_id, survey_question_id, average others,
                (select response_whole_number from program_survey_response r 
                where r.survey_question_id = c.survey_question_id 
                and r.survey_id = c.survey_id 
                and r.survey_participant_id = c.survey_participant_id
                and r.survey_surveyor_id 
                            in (select survey_surveyor_id 
                                from program_survey_surveyor ps 
                                where ps.survey_surveyor_id = r.survey_surveyor_id
                                and ps.relationship = 'self')) self, question
                from
                (
                select survey_id, survey_participant_id, survey_question_id, avg(response) average, (select question from program_survey_question q where q.survey_question_id = b.survey_question_id) question
                    from
                    (
                        select survey_id, survey_participant_id, survey_question_id, relationship, response
                        from 
                        (
                            select survey_id, survey_participant_id, survey_question_id, 'direct reports' relationship, avg(response_whole_number) response
                            from program_survey_response sr 
                            where survey_surveyor_id 
                            in (select survey_surveyor_id 
                                from program_survey_surveyor ps 
                                where ps.survey_surveyor_id = sr.survey_surveyor_id
                                and ps.relationship = 'direct report')
                            and sr.survey_competency_id is not null
                            and sr.survey_id = ".$this->db->escape($survey_id)." and sr.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                            group by survey_id, survey_participant_id, survey_question_id
                            union 
                            select survey_id, survey_participant_id, survey_question_id, 'peers' relationship, avg(response_whole_number) response
                            from program_survey_response sr 
                            where survey_surveyor_id 
                            in (select survey_surveyor_id 
                                from program_survey_surveyor ps 
                                where ps.survey_surveyor_id = sr.survey_surveyor_id
                                and ps.relationship = 'peer')
                            and sr.survey_competency_id is not null
                            and sr.survey_id = ".$this->db->escape($survey_id)." and sr.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                            group by survey_id, survey_participant_id, survey_question_id
                            union 
                            select survey_id, survey_participant_id, survey_question_id, 'manager' relationship, avg(response_whole_number) response
                            from program_survey_response sr 
                            where survey_surveyor_id 
                            in (select survey_surveyor_id 
                                from program_survey_surveyor ps 
                                where ps.survey_surveyor_id = sr.survey_surveyor_id
                                and ps.relationship = 'line manager')
                            and sr.survey_competency_id is not null
                            and sr.survey_id = ".$this->db->escape($survey_id)." and sr.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                            group by survey_id, survey_participant_id, survey_question_id
                        ) as a
                    ) as b
                    group by survey_id, survey_participant_id, survey_question_id
                ) as c
            where survey_id = ".$this->db->escape($survey_id)." and survey_participant_id = ".$this->db->escape($survey_participant_id)."
            order by others desc, self desc";

        $query          =   $this->db->query($sql); 

        return $query->result_array();    
    }

    public function fetch_strength_and_opportunity2($survey_id, $survey_participant_id)
    {
        $sql = "select survey_id, survey_participant_id, survey_question_id, self, line_manager, 
        team_members, others, question, pmf_category, survey_competency_id, competency_id, competency, 
        CASE WHEN self-others > 1 THEN 'Blind Spot' WHEN self-others < -1 THEN 'Hidden Strength' ELSE '' END AS status, 
        CASE WHEN self-others > 1 THEN blind_spot WHEN self-others < -1 THEN hidden_strength END AS recommendation
        from
        (
            select survey_id, survey_participant_id, survey_question_id, 
            (select avg(response_whole_number) from program_survey_response r where r.survey_question_id = c.survey_question_id 
                 and r.survey_id = c.survey_id 
                 and r.survey_participant_id = c.survey_participant_id
                 and r.survey_surveyor_id 
                            in (select survey_surveyor_id 
                                from program_survey_surveyor ps 
                                where ps.survey_surveyor_id = r.survey_surveyor_id
                                and ps.relationship = 'self')) self, 
            (select avg(response_whole_number) from program_survey_response r where r.survey_question_id = c.survey_question_id 
                 and r.survey_id = c.survey_id 
                 and r.survey_participant_id = c.survey_participant_id
                 and r.survey_surveyor_id 
                            in (select survey_surveyor_id 
                                from program_survey_surveyor ps 
                                where ps.survey_surveyor_id = r.survey_surveyor_id
                                and ps.relationship = 'line manager')) line_manager, 
            (select avg(response_whole_number) from program_survey_response r where r.survey_question_id = c.survey_question_id 
                 and r.survey_id = c.survey_id 
                 and r.survey_participant_id = c.survey_participant_id
                 and r.survey_surveyor_id 
                            in (select survey_surveyor_id 
                                from program_survey_surveyor ps 
                                where ps.survey_surveyor_id = r.survey_surveyor_id
                                and ps.relationship = 'direct report')) team_members,
            average others, question, pmf_category, survey_competency_id, competency_id, competency, blind_spot, hidden_strength 
                from
                (
                select survey_id, survey_participant_id, survey_question_id, avg(response) average, 
                (select question from program_survey_question q where q.survey_question_id = b.survey_question_id) question,
                (select custom1 from question_template qt where qt.question_template_id in (select question_template_id from program_survey_question q where q.survey_question_id = b.survey_question_id)) pmf_category, 
                (select survey_competency_id from program_survey_question q where q.survey_question_id = b.survey_question_id) survey_competency_id, 
                (select competency_id from program_survey_competency psc where exists (select 1 from program_survey_question q where q.survey_question_id = b.survey_question_id and psc.survey_competency_id = q.survey_competency_id)) competency_id, 
                (select competency from competency cy where exists (select 1 from program_survey_competency psc where cy.competency_id = psc.competency_id 
                and exists (select 1 from program_survey_question q where q.survey_question_id = b.survey_question_id and psc.survey_competency_id = q.survey_competency_id))) competency, 
                (select blind_spot from question_template qt where qt.question_template_id in (select question_template_id from program_survey_question q where q.survey_question_id = b.survey_question_id)) blind_spot, 
                (select hidden_strength from question_template qt where qt.question_template_id in (select question_template_id from program_survey_question q where q.survey_question_id = b.survey_question_id)) hidden_strength 
                    from
                    (
                        select survey_id, survey_participant_id, survey_question_id, relationship, response
                        from 
                        (
                            select survey_id, survey_participant_id, survey_question_id, 'direct reports' relationship, avg(response_whole_number) response
                            from program_survey_response sr 
                            where survey_surveyor_id 
                            in (select survey_surveyor_id 
                                from program_survey_surveyor ps 
                                where ps.survey_surveyor_id = sr.survey_surveyor_id
                                and ps.relationship = 'direct report')
                            and sr.survey_competency_id is not null
                            and sr.survey_question_id in 
                            (select survey_question_id from program_survey_question sq where sq.question_template_id in 
                             (select sq.question_template_id from question_template where custom1 is not null))
                    and sr.survey_id in (".$this->db->escape($survey_id).") and sr.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                            group by survey_id, survey_participant_id, survey_question_id
                            union 
                            select survey_id, survey_participant_id, survey_question_id, 'peers' relationship, avg(response_whole_number) response
                            from program_survey_response sr 
                            where survey_surveyor_id 
                            in (select survey_surveyor_id 
                                from program_survey_surveyor ps 
                                where ps.survey_surveyor_id = sr.survey_surveyor_id
                                and ps.relationship = 'peer')
                            and sr.survey_competency_id is not null
                            and sr.survey_question_id in 
                            (select survey_question_id from program_survey_question sq where sq.question_template_id in 
                             (select sq.question_template_id from question_template where custom1 is not null))
                    and sr.survey_id in (".$this->db->escape($survey_id).")  and sr.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                            group by survey_id, survey_participant_id, survey_question_id
                            union 
                            select survey_id, survey_participant_id, survey_question_id, 'manager' relationship, avg(response_whole_number) response
                            from program_survey_response sr 
                            where survey_surveyor_id 
                            in (select survey_surveyor_id 
                                from program_survey_surveyor ps 
                                where ps.survey_surveyor_id = sr.survey_surveyor_id
                                and ps.relationship = 'line manager')
                            and sr.survey_competency_id is not null
                            and sr.survey_question_id in 
                            (select survey_question_id from program_survey_question sq where sq.question_template_id in 
                             (select sq.question_template_id from question_template where custom1 is not null))
                    and sr.survey_id in (".$this->db->escape($survey_id).")  and sr.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                            group by survey_id, survey_participant_id, survey_question_id
                        ) as a
                    ) as b
                    group by survey_id, survey_participant_id, survey_question_id
                ) as c
            where survey_id in (".$this->db->escape($survey_id).") and survey_participant_id = ".$this->db->escape($survey_participant_id)."
        ) as d
        order by others desc, self desc";

        $query          =   $this->db->query($sql); 

        return $query->result_array();    
    }

    public function fetch_pmf_detail($survey_id, $survey_participant_id)
    {
        $sql = "select survey_id, survey_participant_id, survey_question_id, 
        (select avg(response_whole_number) from program_survey_response r where r.survey_question_id = c.survey_question_id 
             and r.survey_id = c.survey_id 
             and r.survey_participant_id = c.survey_participant_id
             and r.survey_surveyor_id 
                        in (select survey_surveyor_id 
                            from program_survey_surveyor ps 
                            where ps.survey_surveyor_id = r.survey_surveyor_id
                            and ps.relationship = 'self')) self, 
        (select avg(response_whole_number) from program_survey_response r where r.survey_question_id = c.survey_question_id 
             and r.survey_id = c.survey_id 
             and r.survey_participant_id = c.survey_participant_id
             and r.survey_surveyor_id 
                        in (select survey_surveyor_id 
                            from program_survey_surveyor ps 
                            where ps.survey_surveyor_id = r.survey_surveyor_id
                            and ps.relationship = 'line manager')) line_manager, 
        (select avg(response_whole_number) from program_survey_response r where r.survey_question_id = c.survey_question_id 
             and r.survey_id = c.survey_id 
             and r.survey_participant_id = c.survey_participant_id
             and r.survey_surveyor_id 
                        in (select survey_surveyor_id 
                            from program_survey_surveyor ps 
                            where ps.survey_surveyor_id = r.survey_surveyor_id
                            and ps.relationship = 'direct report')) team_members,
        average others, question, pmf_category
            from
            (
            select survey_id, survey_participant_id, survey_question_id, avg(response) average, 
            (select question from program_survey_question q where q.survey_question_id = b.survey_question_id) question,
            (select custom1 from question_template qt where qt.question_template_id in (select question_template_id from program_survey_question q where q.survey_question_id = b.survey_question_id)) pmf_category
                from
                (
                    select survey_id, survey_participant_id, survey_question_id, relationship, response
                    from 
                    (
                        select survey_id, survey_participant_id, survey_question_id, 'direct reports' relationship, avg(response_whole_number) response
                        from program_survey_response sr 
                        where survey_surveyor_id 
                        in (select survey_surveyor_id 
                            from program_survey_surveyor ps 
                            where ps.survey_surveyor_id = sr.survey_surveyor_id
                            and ps.relationship = 'direct report')
                        and sr.survey_competency_id is not null
                        and sr.survey_question_id in 
                        (select survey_question_id from program_survey_question sq where sq.question_template_id in 
                         (select sq.question_template_id from question_template where custom1 is not null))
                and sr.survey_id = ".$this->db->escape($survey_id)." and sr.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                        group by survey_id, survey_participant_id, survey_question_id
                        union 
                        select survey_id, survey_participant_id, survey_question_id, 'peers' relationship, avg(response_whole_number) response
                        from program_survey_response sr 
                        where survey_surveyor_id 
                        in (select survey_surveyor_id 
                            from program_survey_surveyor ps 
                            where ps.survey_surveyor_id = sr.survey_surveyor_id
                            and ps.relationship = 'peer')
                        and sr.survey_competency_id is not null
                        and sr.survey_question_id in 
                        (select survey_question_id from program_survey_question sq where sq.question_template_id in 
                         (select sq.question_template_id from question_template where custom1 is not null))
                and sr.survey_id = ".$this->db->escape($survey_id)."  and sr.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                        group by survey_id, survey_participant_id, survey_question_id
                        union 
                        select survey_id, survey_participant_id, survey_question_id, 'manager' relationship, avg(response_whole_number) response
                        from program_survey_response sr 
                        where survey_surveyor_id 
                        in (select survey_surveyor_id 
                            from program_survey_surveyor ps 
                            where ps.survey_surveyor_id = sr.survey_surveyor_id
                            and ps.relationship = 'line manager')
                        and sr.survey_competency_id is not null
                        and sr.survey_question_id in 
                        (select survey_question_id from program_survey_question sq where sq.question_template_id in 
                         (select sq.question_template_id from question_template where custom1 is not null))
                and sr.survey_id = ".$this->db->escape($survey_id)."  and sr.survey_participant_id = ".$this->db->escape($survey_participant_id)."
                        group by survey_id, survey_participant_id, survey_question_id
                    ) as a
                ) as b
                group by survey_id, survey_participant_id, survey_question_id
            ) as c
        where survey_id = ".$this->db->escape($survey_id)." 
        and survey_participant_id = ".$this->db->escape($survey_participant_id)."
        order by others desc, self desc";

        $query          =   $this->db->query($sql); 

        return $query->result_array();  

    }

    //request_feedback_email
    public function send_request_feedback_email($email, $name, $question, $response, $survey_question_id, $surveyor_id, $participant_id)
	{
		$site_email 			    = 	$this->site_email;
		
		$company_name 			    = 	$this->company_name;
		
        $site_logo				    = 	$this->site_logo;
        
        $data['participantDetail']	=	$this->get_participant_details($participant_id);

        $data['companyDetail']	    =	$this->get_company_details($data['participantDetail']['company_id']);
        
        $data['surveyorDetail']	    =	array(
            'email'                 =>  $email, 
            'name'                  =>  $name, 
            'question'              =>  $question, 
            'response'              =>  $response,  
            'survey_question_id'    =>  $survey_question_id, 
            'surveyor_id'           =>  $surveyor_id, 
            'participant_id'        =>  $participant_id
        ); 

		// get email template 
		$mailBody				    =	$this->load->view('/feedback/emails/request-feedback-notice', $data, TRUE);

		$config['mailtype'] 	    = 	'html'; 

		$this->email->set_newline("\r\n");	
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
        $this->email->to($email);
        // $this->email->to('olanrewajuahmed095@yahoo.com');

		$this->email->subject('Feedback request from '. ucfirst($participantDetail['first_name']) . ' ' .ucfirst($participantDetail['last_name']));
		
        $this->email->message($mailBody);
        
        // echo json_encode($mailBody);
		
        if($this->email->send())
        {
            return true;
        }else{
            return false;
        }

    }

    public function send_feedback_reponse_email($data)
	{
		$site_email 			    = 	$this->site_email;
		
		$company_name 			    = 	$this->company_name;
		
        $site_logo				    = 	$this->site_logo;
        
		// get email template 
		$mailBody				    =	$this->load->view('/feedback/emails/request-feedback-response', $data, TRUE);

		$config['mailtype'] 	    = 	'html'; 

		$this->email->set_newline("\r\n");	
		
		$this->email->initialize($config);

		$this->email->from($site_email, $company_name);
		
        $this->email->to($data['participantDetail']['email']);
        // $this->email->to('olanrewajuahmed095@yahoo.com');

		$this->email->subject('Recommendation Feedback for '. ucfirst($data['participantDetail']['first_name']) . ' ' .ucfirst($data['participantDetail']['last_name']));
		
        $this->email->message($mailBody);
        
        // echo $mailBody;
		
        if($this->email->send())
        {
            return true;
        }else{
            return false;
        }

    }

    public function post_feedback($participantID, $surveyorID, $questionID, $feedback)
    {
        //insert feedback
        $table				=	'program_survey_response'; 
		
		$this->db->where('survey_participant_id', $participantID);
        $this->db->where('survey_surveyor_id', $surveyorID);
        $this->db->where('survey_question_id', $questionID);
        
        $query				=	$this->db->update($table, array('response_feedback' => $feedback));
        
		return $feedback;
    }

}
