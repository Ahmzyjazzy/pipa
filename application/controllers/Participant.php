<?php
class Participant extends CI_Controller 
{
		
	public function __construct()
	{
		parent::__construct();
		
		//for users who have logged out and want to use the 
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
		
		//normal php version
		/*header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache');*/
		
		
		$this->load->model('participant_model');
		
		$this->load->model('analyzeparticipant_model');
				
	}
	
	public function index()
	{
		
		$is_logged_in 	= 	$this->session->userdata('is_participant_logged_in');

		if(!empty($is_logged_in))
		{
		
			redirect('participant/login/');

		}
		else
		{

			redirect('participant/dashboard');
			
		}
		
	}
	
	public function is_logged_in()
	{
		
		
		$is_logged_in 			=	$this->session->userdata('is_participant_logged_in');
		
		$user_id 				= 	$this->session->userdata('user_id');

		if(empty($is_logged_in) || empty($user_id))
		{

			//echo 'You don\'t have permission to access this page. <a href="index">Login</a>';	
			//die();

			redirect('participant/login/');

		}	

	}
		
	public function login()
	{
		
		$data['title']			= 	"Login :: User";
		
		$this->load->view('participant/login', $data);

	}
	
	public function setup_failure()
	{
		
		$data['title']			= 	"Setup Credentials";
		
		$this->load->view('participant/setup-participant-failure', $data);

	}
	
	public function confirm_participant($id=false)
	{

		if(!empty($id))
		{
			$data['title'] 			= 	"Setup Credentials";
			
			$data['id']				= 	$id;
			
			//check if the token and id exist in the database
			$chck 					= 	$this->participant_model->check_confirm_participant_credentials($id);

			if($chck['status'] == 'Success')
			{
				
				if($chck['data'] == 'Login Successful')
				{
					//means this user has been logged in just redirect to dashboard
					
					redirect(base_url().'participant/dashboard/');
					
				}else{
						
					$data['email']		=	$chck['email'];
					
					//if success allow user to set up password and login into platform
					
					$this->load->view('participant/setup-participant-credentials', $data);
				
				}
				
			}else{
				
				//show_404();
				$this->session->set_flashdata('message', $chck['data']);
				
				redirect(base_url().'participant/setup-failure/');
				
			}
			
		}else{
			
			//show_404();
			
			$this->session->set_flashdata('message', 'Provide a token Key to complete setup or contact administrator to gain access to website.');
				
			redirect(base_url().'participant/setup-failure/');
			
		}
		
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
			
			$query 			= 	$this->participant_model->validate_participant($username, $password);
	
			
			if($query['status'] == 'Success') // if the user's credentials validated...
			{	
				
				redirect('participant/dashboard');
				
			}elseif($query['status'] == 'No Password')
			{
				
				//account exists but no password has been set for this user
				
				//redirect to create password page
				
				$this->session->set_flashdata('message', ''.$query['status'].': '.$query['message'].'');
		
				redirect(base_url().'participant/set-user-credentials/');
				
			}
			else // incorrect username or password
			{

				$this->session->set_flashdata('message', ''.$query['status'].': '.$query['message'].'');
		
				redirect(base_url().'participant/login/');

			}
				
		}
		
	}
	
	public function set_user_credentials()
	{
		
		//validation begins 08078981609
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
			
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[128]');
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirm_password]');
			
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
		
		if ($this->form_validation->run() === FALSE)
		{
			
			$data['title'] 		= 	"Setup Credentials";
			
			$data['email']		=	$this->input->post('username');
										
			$this->load->view('participant/setup-participant-credentials', $data);
			
		}
		else
		{		
		
			$username		= 	$this->input->post('username');
			
			$password		= 	$this->input->post('password');
			
			$query 			= 	$this->participant_model->set_participant_credentials($username, $password);
			
			if($query['status'] == 'Success') // if the user's credentials validated...
			{	
				
				redirect('participant/dashboard');
				
			}
			else // incorrect username or password
			{

				$this->session->set_flashdata('message', ''.$query['status'].': '.$query['message'].'');
				
				show_404();
				
				//redirect(base_url().'participant/confirm-participant/');

			}
			
		}
		
	}
	

	public function forgot_password()
	{
		
		$data['title'] 				= 	"Forgot Password :: PIPA";
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"> <a class="close" data-dismiss="alert">×</a>', '</div>');
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_password_email_check_exist');
		
		if ($this->form_validation->run() == FALSE)
		{
						
			$this->load->view('participant/forgot-password', $data);
			
				
		}else{
			
			// load the security helper where the sha1 function is
			$this->load->helper('security');
			
			$table					= 	'user';
			
			$email 					= 	$this->input->post('email');
			
			$user_id 				= 	$this->participant_model->get_user_id_by_email($email, $table);
			
			$userdet				= 	$this->participant_model->get_user_details($user_id, $table);
			
			$name					= 	ucfirst($userdet['first_name']).' '.ucfirst($userdet['last_name']);
			
			$time 					= 	date('Y-m-d H:i:s');
			
			$tim  					= 	strtotime($time);
			
			$token 					= 	do_hash($email.$tim);
			
			$token_field			= 	'user_id';
			
			$url 					= 	'<a href="'.base_url().'participant/reset-password/'.$user_id.'/'.$token.'/">'.base_url().'participant/reset-password/'.$user_id.'/'.$token.'/</a>';
			
			$query 					= 	$this->participant_model->reset_password_email_token($token,$email,$time,$url,$user_id, $name);
			
			if($query)
			{
				
				$this->session->set_flashdata('success-message', 'An email has been sent to the address you provided, please check your inbox or spam to Reset Password.');
				
				redirect(base_url().'participant/forgot-password/');
				
			}else{
				// generate error	
				
				$this->session->set_flashdata('message', 'An error occured creating a reset link. Please try again.');
				
				redirect(base_url().'participant/forgot-password/');
				
			}
		}

	}

	public function reset_password($id=false,$token=false)
	{
		if(!empty($id) && !empty($token))
		{
			$data['title'] 		= 	"Reset Your Password :: PIPA";
			
			$data['id']			= 	$id;
			
			$data['token'] 		= 	$token;
			
			//check if the token and id exist in the database
			$chck 				= 	$this->participant_model->check_token($id,$token);
			
			if($chck['status'] == "Success")
			{
				// check if the token has expired
				if(time() <= strtotime($chck['message']." + 1 day")){
					
					$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
					
					$this->form_validation->set_rules('password', 'New Password', 'trim|required|matches[conf_password]');
					
					$this->form_validation->set_rules('conf_password', 'Confirm New Password', 'trim|required');
					
					if ($this->form_validation->run() == FALSE)
					{
						
						$this->load->view('participant/reset-password', $data);
							
					}else{
						
						$new_password 			= 	$this->input->post('password');
						
						$query 					= 	$this->participant_model->resetpassword($id, $new_password, $token);
						
						if($query)
						{
							
							$this->session->set_flashdata('success-message', 'Password Reset Successful.');
				
							redirect(base_url().'participant/login/');
							
						}else{
							
							$this->session->set_flashdata('message', 'An Error occured while trying to reset your password, please try again.');
							
							redirect(base_url().'participant/reset-password/'.$id.'/'.$token.'/');
						}
						
					}
				
				}else{
					
					$this->session->set_flashdata('message', 'Your Password reset link has expired, Please request for another.');
				
					redirect(base_url().'participant/forgot-password/');
				}
				
			}else{
				
				//show_404();
				
				$this->session->set_flashdata('message', $chck['message']);
				
				redirect(base_url().'participant/forgot-password/');
			}
			
		}else{
			
			show_404();
		}
		
	}
	
	// check if this email exist already for password reset
	public function password_email_check_exist($str)
	{
		
		$username_chck 			= 	$this->participant_model->check_email_exist($str, 'user');
		
		if($username_chck['status'] == 'Success')
		{
			
			return TRUE;
			
		}
		else
		{
			$this->form_validation->set_message('password_email_check_exist', ''.$username_chck['status'].': '.$username_chck['message'].'');
			
			return FALSE;
		}
			
	}
	
	public function logout()
	{

		$this->session->sess_destroy();
		
		redirect('participant');
		
	}
	
	public function dashboard()
	{
			
		$this->is_logged_in();

		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Dashboard :: PIPA";
		
		$data['menu_status']				=	'dashboard';
		
		$userID								=	$this->session->userdata('user_id');
		
		$data['userDetails']				=	$this->participant_model->get_user_details($userID, 'user');
		
		$data['company_details']			=	$this->participant_model->get_company_details($data['userDetails']['company_id']);
		
		$data['surveys']					=	$this->participant_model->get_user_surveys_participated($userID);

		$this->load->view('participant/templates/header', $data);
		
		$this->load->view('participant/dashboard');

		$this->load->view('participant/templates/footer');

	}

	public function my_surveys()
	{
			
		$this->is_logged_in();

		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"My Surveys :: PIPA";
		
		$data['menu_status']				=	'my-surveys';
		
		$userID								=	$this->session->userdata('user_id');
		
		$data['userDetails']				=	$this->participant_model->get_user_details($userID, 'user');
		
		//$data['surveys']					=	$this->participant_model->get_user_surveys_participated('9');
		
		$data['surveys']					=	$this->participant_model->get_user_surveys_participated($userID);

		$this->load->view('participant/templates/header', $data);
		
		$this->load->view('participant/my-surveys');

		$this->load->view('participant/templates/footer');

	}
	
	// use this function to search a multidimensional array e.g return all the billers that belong to a category id
	public function in_multiarray($elem, $array,$field)
	{
		$top = sizeof($array) - 1;
		
		$bottom = 0;
		
		$result	= array();
		
		while($bottom <= $top)
		{
			
			if($array[$bottom][$field] == $elem)
			{	
				array_push($result,$array[$bottom]);
				
			}else{
				
				if(is_array($array[$bottom][$field]))
				{
					
					if($this->in_multiarray($elem, ($array[$bottom][$field])))
					{

					
					}else{
							
					}
					
				}else{
					
					
				}
			}
			
			$bottom++;
		}  
		
		return $result;    
	}
	
	function alpha_dash_space($fullname)
	{
		
		if (!preg_match('/^[a-zA-Z\s]+$/', $fullname)) 
		{
		
			$this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters & White spaces');
		
			return FALSE;
		
		} else {
		
			return TRUE;
		
		}
		
	}
	
	public function select_validate($selectValue)
	{
		// 'none' is the first option and the text says something like "-Choose one-"
		if($selectValue == '0' || $selectValue == '')
		{
			$this->form_validation->set_message('select_validate', 'Please Select a %s.');
			return false;
		}
		else // user picked something
		{
			return true;
		}
	}
	
	//this makes it easy to use the same code for initial generation of the form as well as javascript additions
	function replace_newline($string) {
	  return trim((string)str_replace(array("\r", "\r\n", "\n", "\t"), ' ', $string));
	}
	
	/*analyze part*/
	
	public function analyze_me($slug)
	{ 
		
		$data['title'] 						=	"Analyze Me :: PIPA";

		$data['menu_status']				=	'analyse';	

		$slug_chunk 						=	explode("-", $slug);

		$survey_participant_id 				=	!empty($slug_chunk) ? $slug_chunk[0] : 0;

		$survey_id							=	!empty($slug_chunk) ? $slug_chunk[1] : 0; 
				
		$company_id 						= 	$this->session->userdata('company_id'); 

		$data['programs']					=	$this->analyzeparticipant_model->fetch_program_surveys($company_id, $survey_participant_id, '360 assessment');

		//adding data to session 
		$program_id							=	$this->analyzeparticipant_model->fetch_program_id($company_id, $survey_id);

		$this->session->set_userdata('program_id', $program_id);
						 		
		$this->load->view('participant/templates/header', $data);
		
		$this->load->view('participant/analyze/analyze-me');
		
		$this->load->view('participant/templates/footer');
		
	} 
	
	// analyze module
	public function fetch_daterange()
	{		
		$program_id 						= 	$this->session->userdata('program_id'); 
		$data 								= 	$this->analyzeparticipant_model->fetch_program_daterange($program_id);
		echo json_encode(array(
			"date_range" => $data 
		));
	}
	
	public function fetch_analyze_summary($program_id)
	{
		$analyze_summary					= 	$this->analyzeparticipant_model->fetch_summary($program_id); 	
		//adding data to session 
		$this->session->set_userdata('program_id',$program_id); 
		echo json_encode(array(
			"competency" => $analyze_summary 
		));
	}
	
	public function fetch_evaluator()
	{  		
		$program_id 						= 	$this->session->userdata('program_id'); 
		$data['all_evaluators'] 			= 	$this->analyzeparticipant_model->fetch_evaluators($program_id); 
		echo json_encode(array(
			"data" => $data 
		));
	}
	  
	public function analyze_participant($survey_participant_id = '')
	{ 
		$data['title'] 						=	"Analyze Participant :: PIPA";
		$data['menu_status']				=	'analyse';	
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/analyze-participant');
		$this->load->view('admin/templates/footer');
	} 
	
	public function fetch_analyze($survey_participant_id = '')
	{  
		$program_id 						= 	$this->session->userdata('program_id'); 
		$data['surveyors'] 					= 	$this->analyzeparticipant_model->fetch_analyze_surveyors($program_id, $survey_participant_id);
		$data['competencies_score'] 		= 	$this->analyzeparticipant_model->fetch_competencies_score($program_id, $survey_participant_id);
		$data['open_ended_response'] 		= 	$this->analyzeparticipant_model->open_ended_response($program_id, $survey_participant_id);
		echo json_encode(array(
			"data" => $data,
			"program_id" => $program_id,
			"survey_participant_id" => $survey_participant_id 
		));
	}
		
	public function fetch_analyze_surveyors($survey_participant_id = '')
	{  
		$program_id 						= 	$this->session->userdata('program_id'); 
 
		$data['surveyors'] 					= 	$this->analyzeparticipant_model->fetch_analyze_surveyors($program_id, $survey_participant_id);

		echo json_encode(array(
			"data" => $data,
			"program_id" => $program_id,
			"survey_participant_id" => $survey_participant_id 
		));
	} 
	
	public function fetch_competencies_radar_score($survey_participant_id = '')
	{  
		$program_id 						= 	$this->session->userdata('program_id');  
		$data['competencies_radar_score'] 	= 	$this->analyzeparticipant_model->fetch_competencies_radar_score($program_id, $survey_participant_id); 
		echo json_encode(array(
			"data" => $data,
			"program_id" => $program_id,
			"survey_participant_id" => $survey_participant_id 
		));
	} 	
	
	public function fetch_competencies_question_score($survey_participant_id = '', $survey_competency_id = '')
	{   
		$program_id 							= 	$this->session->userdata('program_id');  
		$data['competencies_question_score'] 	= 	$this->analyzeparticipant_model->fetch_competencies_question_score($program_id, $survey_participant_id, $survey_competency_id); 
		echo json_encode(array(
			"data" => $data,
			"program_id" => $program_id,
			"survey_participant_id" => $survey_participant_id,
			"survey_competency_id" => $survey_competency_id
		));
	}  
	
	public function fetch_open_ended_response($survey_participant_id = '')
	{  
		$program_id 						= 	$this->session->userdata('program_id'); 
		 
		$data['open_ended_response'] 		= 	$this->analyzeparticipant_model->open_ended_response($program_id, $survey_participant_id);
		
		echo json_encode(array(
			"data" => $data,
			"program_id" => $program_id,
			"survey_participant_id" => $survey_participant_id 
		));
		
	} 

	public function get_company_setting()
	{
		
		$company_id				=	$this->session->userdata('company_id');

		$company_setting		= 	$this->analyze_model->get_company_setting($company_id); 

		echo json_encode(array(  
			'data' => $company_setting,
			'message' => !empty($company_setting) ? 'success' : 'error'
		)); 
	}
	
	/* analyze part ends */
	
}

?>