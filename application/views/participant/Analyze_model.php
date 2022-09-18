<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Analyze_model extends CI_Model {

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

    public function program_list($company_id, $employee_number = '')
    {
        $this->db->select('program_name,program_name_slug,program_id');
        $this->db->from('program'); 

        if($company_id != 1){
            $this->db->where('program.company_id', $company_id); 
        }

        if($employee_number){            
            $this->db->join('program_survey_participant', 'program.program_id = program_survey_participant.program_id');
            $this->db->where('employee_number', $employee_number);  
        }

        $query = $this->db->get();
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

    //analyze 360 section below
    public function fetch_participant($program_id = null) 
    {
        $this->db->select('first_name, last_name, employee_number, grade.grade, location.location');
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

    public function fetch_response_aggregates($program_id = null, $date_collected = null) 
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
				$response[$count]['participant_response']		    =	$this->get_participant_response($res['survey_participant_id'], $res['employee_number'], $res['program_id']);
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
				$response[$count]['survey_surveyor_id']		    =	$res['survey_participant_id'];				
				$response[$count]['company_id']					=	$res['company_id'];				
				$response[$count]['program_id']					=	$res['program_id'];				
				$response[$count]['survey_id']					=	$res['survey_id'];				
				$response[$count]['employee_number']			=	$res['employee_number'];				
				$response[$count]['name']					    =	$res['name'];		 			
                $response[$count]['email']					    =	$res['email'];    		 			
                $response[$count]['phone']					    =	$res['phone_number'];             
                $response[$count]['relationship']				=	$res['relationship'];            
                $response[$count]['relationship_index']			=	($res['relationship'] == 'Self' || $res['relationship'] == 'Line Manager') ? '' : $res['relationship_index'];				
                $response[$count]['surveyors_response']			=	$this->get_participant_response($participant_id, $res['employee_number'], $res['program_id']);                          
                $count++;
			}			
        }
        
        return $response;
    }

    public function get_participant_response($survey_participant_id, $employee_number, $program_id)
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
        $this->db->where('employee_number', $employee_number);
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
    function fetch_analyze_surveyors($program_id, $employee_number)
	{		
        $this->db->select('user_id, survey_participant_id, employee_number, email, phone_number, 
            first_name, last_name, gender, grade');
        $this->db->from('program_survey_participant');
        $this->db->where('program_id', $program_id);	
        $this->db->where('employee_number', $employee_number);	
        $this->db->join('grade', 'program_survey_participant.grade_id = grade.grade_id');
        $query			        =	$this->db->get();	
        $res                    =   $query->row_array();
        if($res){
            $res['surveyors']	=	$this->get_participant_surveyors($res['survey_participant_id'], $program_id);
            return $res;
        }		
        return '';
    }

    public function fetch_competencies_radar_score($program_id, $employee_number)
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
				$response[$count]['self']			        =	$this->get_evaluator_category_scores($program_id, $employee_number, 'Self', $res['survey_competency_id']);					
				$response[$count]['manager']    			=	$this->get_evaluator_category_scores($program_id, $employee_number, 'Line Manager', $res['survey_competency_id']);				
				$response[$count]['peers']    			    =	$this->get_evaluator_category_scores($program_id, $employee_number, 'Peer', $res['survey_competency_id']);				
                $response[$count]['direct_report']    		=	$this->get_evaluator_category_scores($program_id, $employee_number, 'Direct Report', $res['survey_competency_id']);              
                $count++;
			}			
        }
        
        return $response;

    }
    
    public function fetch_competencies_question_score($program_id, $employee_number, $survey_competency_id)
    {
        $response = $this->get_evaluator_question_scores($program_id, $employee_number, $survey_competency_id);        
        return $response;
    }

    public function get_evaluator_category_scores($program_id, $employee_number, $evaluator_category, $competency_id, $question_id = null)
    {
        $response = array();

        //get the current participant being analyze
        $this->db->select('survey_participant_id');
        $this->db->from('program_survey_participant');
        $this->db->where('employee_number', $employee_number);
        $this->db->where('program_id', $program_id); 
        $query                          =   $this->db->get();
        $result                         =   $query->row_array(); 
        $survey_participant_id          =   $result ? $result['survey_participant_id'] : 0; 

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

    public function get_evaluator_question_scores($program_id, $employee_number, $competency_id)
    { 
        $response = array();

        //get the current participant being analyze
        $this->db->select('survey_participant_id');
        $this->db->from('program_survey_participant');
        $this->db->where('employee_number', $employee_number);
        $this->db->where('program_id', $program_id); 
        $query                          =   $this->db->get();
        $result                         =   $query->row_array(); 
        $survey_participant_id          =   $result ? $result['survey_participant_id'] : 0; 

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
				$response[$count]['self']			        =	$this->get_evaluator_category_scores($program_id, $employee_number, 'Self', $competency_id, $res['survey_question_id']);					
				$response[$count]['manager']    			=	$this->get_evaluator_category_scores($program_id, $employee_number, 'Line Manager', $competency_id, $res['survey_question_id']);				
				$response[$count]['peers']    			    =	$this->get_evaluator_category_scores($program_id, $employee_number, 'Peer', $competency_id, $res['survey_question_id']);				
                $response[$count]['direct_report']    		=	$this->get_evaluator_category_scores($program_id, $employee_number, 'Direct Report', $competency_id, $res['survey_question_id']);  	       
                $count++;
			}			
        }

        return $response;
    }

    public function open_ended_response($program_id, $employee_number)
    {
        // NOTE: when question_template_id is null it is open ended question 
        $response = array();

        //get the current participant being analyze
        $this->db->select('survey_participant_id');
        $this->db->from('program_survey_participant');
        $this->db->where('employee_number', $employee_number);
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
				$response[$count]['responses']			    =	$this->get_open_ended_responses($program_id, $employee_number, $res['survey_question_id']);			        
                $count++;
			}			
        }

        return $response;
    }

    public function get_open_ended_responses($program_id, $employee_number, $question_id)
    { 
        //get the current participant being analyze
        $this->db->select('survey_participant_id');
        $this->db->from('program_survey_participant');
        $this->db->where('employee_number', $employee_number);
        $this->db->where('program_id', $program_id); 
        $query                          =   $this->db->get();
        $result                         =   $query->row_array(); 
        $survey_participant_id          =   $result ? $result['survey_participant_id'] : 0; 

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

    public function get_comparison_radar_score($program_id, $employee_number, $competency_id, $question_id = null)
    {
        $response = array();

        //get the current participant being analyze
        $this->db->select('survey_participant_id, CONCAT(first_name," ",last_name) AS participant_name');
        $this->db->from('program_survey_participant');
        $this->db->where('employee_number', $employee_number);
        $this->db->where('program_id', $program_id); 
        $query                          =   $this->db->get();
        $result                         =   $query->row_array(); 
        $survey_participant_id          =   $result ? $result['survey_participant_id'] : 0; 
        $participant_name               =   $result ? $result['participant_name'] : 0; 

        //get avg_score of the $evaluator_category
        $this->db->select('SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low,  MAX(response_whole_number) AS high');
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
    function fetch_benchmark_surveyors($program_id, $past_program_id)
	{		
        //get average score of current program 
        $this->db->select('SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low,  MAX(response_whole_number) AS high');
        $this->db->from('program_survey_response'); 
        $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id');
        $this->db->where('program_survey_response.survey_participant_id', $survey_participant_id);
        $this->db->where('program_survey_response.survey_competency_id', $competency_id); 
        $this->db->where('program_survey_response.program_id', $program_id);  
        if($question_id){
            $this->db->where('program_survey_response.survey_question_id', $question_id); 
        }    

        $this->db->select('user_id, survey_participant_id, employee_number, email, phone_number, 
            first_name, last_name, gender, grade');
        $this->db->from('program_survey_participant');
        $this->db->where('program_id', $program_id);	
        $this->db->where('employee_number', $employee_number);	
        $this->db->join('grade', 'program_survey_participant.grade_id = grade.grade_id');
        $query			        =	$this->db->get();	
        $res                    =   $query->row_array();
        if($res){
            $res['surveyors']	=	$this->get_participant_surveyors($res['survey_participant_id'], $program_id);
            return $res;
        }		
        return '';
    } 

    public function fetch_benchmark_radar_score($program_id, $participants)
    {
        $this->db->select('competency, survey_competency_id');
        $this->db->from('program_survey_competency'); 
        $this->db->join('competency', 'program_survey_competency.competency_id = competency.competency_id');
        $this->db->where('program_id', $program_id);
        $this->db->where('competency.is_standard', 1);
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
                				
                $response[$count]['p_current']      		=	$this->get_benchmark_program_radar_score($program_id, $res['survey_competency_id']);				
                $response[$count]['p_past']      			=	$this->get_benchmark_program_radar_score($program_id, $res['survey_competency_id']);	                				
                $response[$count]['p_current_participant']  =	$this->get_benchmark_participant_radar_score($program_id, $res['survey_competency_id']);					
                $response[$count]['p_past_participant']     =	$this->get_benchmark_participant_radar_score($program_id, $res['survey_competency_id']);				
                $response[$count]['p_industry']      		=	$this->get_benchmark_industry_radar_score($program_id, $res['survey_competency_id']);

                $count++;
			}			
        }
        
        return $response;
    }

    public function get_benchmark_program_radar_score($program_id, $competency_id, $question_id = null)
    {
        $response = array(); 

        //get avg_score of the $evaluator_category
        $this->db->select('SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low,  MAX(response_whole_number) AS high');
        $this->db->from('program_survey_response'); 
        $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id'); 
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
                WHERE R.survey_surveyor_id = S.survey_surveyor_id AND R.program_id = ?)
            AND S.program_id = ? ";
        $query = $this->db->query($sql, array($program_id, $program_id));
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
        $high                               =   floatval($high);
        $low                                =   floatval($low); 

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

    public function get_benchmark_participant_radar_score($program_id, $competency_id, $question_id = null)
    {
        $response = array(); 

        $this->db->select('user_id, survey_participant_id, employee_number, email, phone_number, 
            first_name, last_name, gender, grade');
        $this->db->from('program_survey_participant');
        $this->db->where('program_id', $program_id);	
        $this->db->where('employee_number', $employee_number);	
        $this->db->join('grade', 'program_survey_participant.grade_id = grade.grade_id');
        $query			        =	$this->db->get();	
        $res                    =   $query->row_array();
        if($res){
            $res['surveyors']	=	$this->get_participant_surveyors($res['survey_participant_id'], $program_id);
            return $res;
        }		
        return '';

        //get avg_score of the $evaluator_category
        $this->db->select('SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low,  MAX(response_whole_number) AS high');
        $this->db->from('program_survey_response'); 
        $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id'); 
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
                WHERE R.survey_surveyor_id = S.survey_surveyor_id AND R.program_id = ?)
            AND S.program_id = ? ";
        $query = $this->db->query($sql, array($program_id, $program_id));
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
        $high                               =   floatval($high);
        $low                                =   floatval($low); 

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

    public function get_benchmark_industry_radar_score($program_id, $competency_id, $question_id = null)
    {
        $response = array(); 

        //get avg_score of the $evaluator_category
        $this->db->select('SUM(response_whole_number) AS total_score, MIN(response_whole_number) AS low,  MAX(response_whole_number) AS high');
        $this->db->from('program_survey_response'); 
        $this->db->join('program_survey_surveyor', 'program_survey_response.survey_surveyor_id = program_survey_surveyor.survey_surveyor_id'); 
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
                WHERE R.survey_surveyor_id = S.survey_surveyor_id AND R.program_id = ?)
            AND S.program_id = ? ";
        $query = $this->db->query($sql, array($program_id, $program_id));
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
        $high                               =   floatval($high);
        $low                                =   floatval($low); 

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

}