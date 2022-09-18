<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Analyzeparticipant_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // analyze summary section below
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
	
    public function fetch_summary($program_id = null) 
    {
        $sql = "SELECT 
        (SELECT COUNT(program_id) FROM program_survey_competency C WHERE C.program_id = S.program_id
        AND EXISTS(SELECT 1 FROM program_survey S WHERE S.survey_id = C.survey_id)) total_competency,
        (SELECT COUNT(survey_participant_id) FROM program_survey_participant P WHERE P.program_id = S.program_id) total_participant,
        (SELECT date_created FROM program_survey_response R WHERE R.program_id = S.program_id ORDER BY date_created DESC LIMIT 1) date_collected
        FROM program_survey S
        WHERE program_id = ".$this->db->escape($program_id)."";
        $result = $this->db->query($sql); 
         
        return $result->row_array();	
	}

    // analyze participants section below
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

    public function fetch_competencies_radar_score($program_id, $survey_participant_id)
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
				$response[$count]['self']			        =	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Self', $res['survey_competency_id']);					
				$response[$count]['manager']    			=	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Line Manager', $res['survey_competency_id']);				
				$response[$count]['peers']    			    =	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Peer', $res['survey_competency_id']);				
                $response[$count]['direct_report']    		=	$this->get_evaluator_category_scores($program_id, $survey_participant_id, 'Direct Report', $res['survey_competency_id']);              
                $count++;
			}			
        }
        
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

        //get the current participant being analyze
        // $this->db->select('survey_participant_id');
        // $this->db->from('program_survey_participant');
        // $this->db->where('survey_participant_id', $survey_participant_id);
        // $this->db->where('program_id', $program_id); 
        // $query                          =   $this->db->get();
        // $result                         =   $query->row_array(); 
        // $survey_participant_id          =   $result ? $result['survey_participant_id'] : 0; 

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
        $sql = "SELECT COUNT(survey_surveyor_id) AS my_surveyors FROM program_survey_surveyor S 
            WHERE EXISTS(SELECT 1 FROM program_survey_response R 
                WHERE R.survey_surveyor_id = S.survey_surveyor_id AND R.program_id = ?
                AND R.survey_participant_id = ?)
            AND S.program_id = ? 
            AND S.relationship = ?
            AND S.survey_participant_id = ?";
        $query = $this->db->query($sql, array($program_id, $survey_participant_id, $program_id, $evaluator_category, $survey_participant_id));
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
        $this->db->select('response_text AS response, relationship, relationship_index, program_survey_response.survey_surveyor_id as surveyor_id');
        $this->db->from('program_survey_response'); 
        $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id');
        $this->db->where('program_survey_response.survey_participant_id', $survey_participant_id);
        $this->db->where('program_survey_response.survey_question_id', $question_id); 

        $query                          =   $this->db->get();
        $result                         =   $query->result_array();  

        return $result;
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
    
}