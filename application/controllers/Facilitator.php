<?php
class Facilitator extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		//for users who have logged out and want to use the 
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
		$this->output->set_header('Pragma: no-cache');
		
		//this is the live secret key
		//$this->paystack_sk 			= 	'sk_live_e75b131244ee0fc8088ff622b154aa9847e09360';
		
		//this is the test key
		//$this->paystack_sk 			= 	'sk_test_2fe38fc52a314062fc83459f9bc238b22cbe31b2';
		
		$this->load->model('facilitator_model');
	}

	public function index()
	{
		
		$is_user_logged_in 			= 	$this->session->userdata('is_user_logged_in');
		
		if(!isset($is_user_logged_in) || $is_user_logged_in != true)
		{

			redirect('msme/account/login/');

		}
		else
		{
			redirect('msme/account/dashboard/');
			
		}
		
		//$this->load->view('pages/maintenance');
		
	}
	
	
	public function maintenance()
	{
		
		//$this->load->view('pages/maintenance');
		
		redirect('msme/account/login/');
		
	}
	
	public function account($page = FALSE, $id = FALSE, $nxt = FALSE, $randm = FALSE )
	{
		
		//$this->is_user_logged_in();
		
		$is_user_logged_in 			= 	$this->session->userdata('is_user_logged_in');
		
		if($page === false)
		{

			// if no page was supplied after account then it checks if the person is logged in, if yes redirect to dashboard if not take user to login page
			if(!isset($is_user_logged_in) || $is_user_logged_in != true)
			{
				
				redirect('msme/account/login/');
	
			}
			else
			{
				redirect('msme/account/dashboard');
			}
				
		}else{

			// check if the method exist if yes redirect or load the method if not show the 404 page
			if(method_exists($this, $page))
			{
			
				//return call_user_func_array(array($this, $method), $params);
				if($id === FALSE){
					
					$this->$page();
					
				}elseif($randm != FALSE){
					
					$this->$page($id,$nxt,$randm);
					
				}elseif($nxt != FALSE){
					
					$this->$page($id,$nxt);
					
				}else{
					
					$this->$page($id);
				}
				
			}else{
				
				show_404();
			
			}
			
		}
		
	}
	
	public function is_user_logged_in()
	{
		$is_user_logged_in 			= 	$this->session->userdata('is_user_logged_in');
		
		if(!isset($is_user_logged_in) || $is_user_logged_in != true)
		{
			//echo 'You don\'t have permission to access this page. <a href="index">Login</a>';	
			//die();		
			redirect('msme/account');
			
		}	
		
		/*$this->session->sess_destroy();
		
		redirect('user/maintenance/');*/
			
	}	

	
	public function login()
	{		
		
		$data['title'] 			= 	"Login :: 1Community";
		
		$this->load->view('msme/account-creation/login', $data);
		
	}

	
	public function validate_user()
	{
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');	
		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[128]');
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
		//$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|callback_captcha_check');
		
		/*if(base_url() == 'http://localhost/1Community/')
		{
			
		}else{
			
			$this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required|callback_captcha_check_google');
		
		}*/

		//$refer_from = $this->input->post('refer_from');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->login();
			
			//redirect('login');
		}
		else
		{
			
			$tbl_name 			= 	'user';
			
			$username			= 	$this->input->post('username');
			
			$password			= 	$this->input->post('password');

			$query 				= 	$this->facilitator_model->validate_user($tbl_name, $username, $password);
			
			if($query['status'] == 'Success') // if the user's credentials validated...
			{					
				$data = array(
				
					'is_user_logged_in' 		=> 	true,
					'userDetails'				=>  $query['data'] 
				);
				
				$this->session->set_userdata($data);
					
				redirect(base_url().'msme/account/dashboard/');
					
									
			}
			else // incorrect username or password
			{

				$this->session->set_flashdata('message', ''.$query['status'].': '.$query['message'].'');
		
				redirect(base_url().'msme/account/login/');

			}
				
		}
	}
	
	public function captcha_check($str)
	{
		
		$captcha_chck 						= 	$this->facilitator_model->check_captcha($str);
		
		if($captcha_chck == TRUE)
		{
			
			return TRUE;
			
		}
		else
		{
			
			$this->form_validation->set_message('captcha_check', 'You must submit the word that appears in the image.');
			
			return FALSE;
		
		}
			
	}
	
	public function captcha_check_google($str)
	{
	
		if(!empty($str))
		{
		
			$verify			=	$this->verify_google_captcha($str);
			
			if(!empty($verify['success']))
			{
			
				return TRUE;
			
			}else{
				
				$this->form_validation->set_message('captcha_check_google', 'Unable to Log you in as we detect you may be a spammer.');
				
				return FALSE;
				
			}
			
		}
		else
		{
			
			$this->form_validation->set_message('captcha_check_google', 'Please check the the captcha form.');
			
			return FALSE;
		
		}
			
	}
	
	public function verify_google_captcha($captcha)
	{
				
		$response				=	array();

		$http_verb				= 	'POST';	
		
		$secretKey				=	'6LfdGdEUAAAAAKpx-0yFnALYyyDzffDgMjYjsmMS';

				//production parameters
		$url					= 	'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);

		$headers				= 	array(
			
			"Content-type:application/json",
			
		);
		
		$parameter				=	array(
		
			"secret"			=>	$secretKey, 
			"response"			=>	$captcha
			
		);  
		
		$data_string 			= json_encode($parameter);	

		$curl 					= 	curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL 				=> 	$url,
		  CURLOPT_RETURNTRANSFER 	=> 	true,
		  CURLOPT_ENCODING 			=> 	"",
		  CURLOPT_MAXREDIRS 		=> 	10,
		  CURLOPT_TIMEOUT 			=> 	30,
		  CURLOPT_HTTP_VERSION 		=> 	CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST 	=> 	"POST",
		  CURLOPT_POST				=> 	true,
		  CURLOPT_POSTFIELDS		=> 	$data_string,
		  CURLOPT_HTTPHEADER		=> 	$headers,
		));
		
		$response 				= 	curl_exec($curl);
		
		$err 					= 	curl_error($curl);
		
		curl_close($curl);
		
		
		if ($err) {
		  
		  //echo "cURL Error #:" . $err;
		  $response['error']  		= 	$err;
		  
		}else{
		
		  
		  $response					=	json_decode($response, true);

		}
			
		return $response;
	}
	
	public function register()
	{
		$data['title'] 			= 	"Register :: 1Community";
		
		//get the countries list for the dropdown
		$data['countries']		= 	$this->facilitator_model->select_country();
		
		$this->load->view('msme/account-creation/register', $data);		
	}
	
	public function create_account()
	{
		
		$data['title'] 				= 	"Register :: 1Community";
				
		//get the countries list for the dropdown
		$data['countries']			= 	$this->facilitator_model->select_country();
		
		// perform form validation first
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		
		//$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]|callback_username_check');
		
		$this->form_validation->set_rules('firstName', 'First Name', 'trim|required|callback_alpha_dash_space');
		
		$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required|alpha');
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
		
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|max_length[32]');
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]');
		
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required');
		
		//$this->form_validation->set_rules('term_n_cond', 'Terms and Condition', 'required');
		
		//$this->form_validation->set_rules('country', 'Country', 'trim|required|callback_select_validate');
		
		//$this->form_validation->set_rules('state', 'State', 'trim|required|xss_clean|callback_select_validate');
		//$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|xss_clean|numeric|min_length[10]|max_length[13]');
		//$this->form_validation->set_rules('address1', 'Address', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean|alpha');
		//$this->form_validation->set_rules('zip', 'Zip', 'trim|required|xss_clean|numeric|min_length[4]|max_length[5]');
		
		
		
		if ($this->form_validation->run() === FALSE)
		{
		
			$this->register();
		
		}
		else
		{	
						
			$save['firstName'] 						= 	$this->input->post('firstName');
			
			$save['lastName']						= 	$this->input->post('lastName');
			
			$save['email'] 							= 	$this->input->post('email');
			
			$save['mobile'] 						= 	$this->input->post('mobile');
			
			$save['password'] 						= 	md5($this->input->post('password'));
			
			$save['userCategoryReg'] 				= 	$this->input->post('userCategoryReg');
			
			$save['userRegRefMedium'] 				= 	$this->input->post('userRegRefMedium');
			
			$save['ifOthersExplain'] 				= 	$this->input->post('ifOthersExplain');
						
			//$save['country_id'] 					= 	$this->input->post('country');
			
			//$save['state_id'] 						= 	$this->input->post('state');		
						
			//$save['subscribe_newsletter'] 			= 	$this->input->post('news_letter');
			
			$save['dateRegistered'] 				= 	date('Y-m-d H:i:s');
			
		
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
			
			$save['registration_medium']			=	$medium;
				
			$save['registration_agent']				=	$agent;
			
			$save['registration_ip']				=	$this->input->ip_address();
				
			$query 									= 	$this->facilitator_model->set_user($save);
			
			if($query['status'] == 'Success') // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('success-message', ''.$query['status'].': '.$query['message'].'');
				
				redirect('msme/account/login/');
				
			}
			else // incorrect username or password
			{

				
				$data = array(
				
					'error_mssg' => ''.$query['status'].': '.$query['message'].''
				
				);
				
				$this->session->set_userdata($data);
				
				$this->register();

			}
			
		}
		
	}
	
	public function confirm_email($id=false,$token=false)
	{

		if(!empty($id) && !empty($token))
		{
			$data['title'] 			= 	"Confirm Email ";
			
			$data['id']				= 	$id;
			
			$data['token'] 			= 	$token;
			
			//check if the token and id exist in the database
			$chck 					= 	$this->facilitator_model->check_email_confirmation_token($id,$token);

			if($chck)
			{
				// check if the token has expired
				//if(time() <= strtotime($chck." + 1 day")){
			
					$query 			= 	$this->facilitator_model->confirm_registration_email($id);
					
					if($query)
					{
						$this->session->set_flashdata('success-message', 'Email Confirmed Successfully. You can proceed to <a href="'.base_url().'user/account/login/">Login</a>');
			
						redirect(base_url().'msme/account/email-confirmed/');
						
					}else{
						
						$this->session->set_flashdata('message', 'An Error occured while trying to Confirm your Email, please try again.');
						
						redirect(base_url().'msme/account/email-confirmed/');
					}
				
/*				}else{
					
					$this->session->set_flashdata('error', 'Your Password reset link has expired, Please request for another.');
				
					redirect(base_url().'volunteer/account/forgot-password/');
				}*/
				
			}else{
				
				//show_404();
				$this->session->set_flashdata('message', 'Confirmation link does not Exist. Register to proceed!!!');
				
				redirect(base_url().'msme/account/register/');
				
			}
			
		}else{
			
			//show_404();
			
			$this->session->set_flashdata('message', 'Provide a token Key to complete registration or Register to gain access to website.');
				
			redirect(base_url().'msme/account/register/');
			
		}
		
	}
	
	public function email_confirmed()
	{
		
		$data['title'] 			= 	"Confirm Email :: 1Community";
		
		$this->session->set_flashdata('success-message', 'Email Confirmed Successfully. You can proceed to <a href="'.base_url().'msme/account/login/">Login</a>');
		
		$this->load->view('msme/account-creation/email-confirmed', $data);
		
	}	
	
	// check if this email exist already
	public function email_check($str)
	{
		
		$username_chck 			= 	$this->facilitator_model->check_email($str, 'user');
		
		if($username_chck)
		{

			$this->form_validation->set_message('email_check', 'The %s is already Registered, Please select another.');
			
			return FALSE;
		}
		else
		{
			
			return TRUE;
			
		}
			
	}
	
	
	// check if this email exist already for password reset
	public function password_reset_email_check($str)
	{
		$username_chck 		= 	$this->facilitator_model->check_email($str, 'user');
		
		if($username_chck == TRUE)
		{
			
			return TRUE;
			
		}
		else
		{
			$this->form_validation->set_message('password_reset_email_check', 'The account for this %s does not exist.');
			
			return FALSE;
		
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
	
	public function confirmn_textbox_amount($selectValue)
	{
		// 'none' is the first option and the text says something like "-Choose one-"
		if($selectValue == '0' || $selectValue == '0.00' || $selectValue == '0.000000000')
		{
			$this->form_validation->set_message('confirmn_textbox_amount', 'Please Provide a %s.');
			
			return false;
		}
		else // user picked something
		{
			return true;
		}
	}
	
	function alpha_dash_space($fullname){
		
		if (!preg_match('/^[a-zA-Z\s]+$/', $fullname)) 
		{
		
			$this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters & White spaces');
		
			return FALSE;
		
		} else {
		
			return TRUE;
		
		}
		
	}
	
	public function username_check($str)
	{
		$username_chck 			= 	$this->facilitator_model->check_username($str);
		
		if($username_chck == TRUE)
		{
			
			$this->form_validation->set_message('username_check', 'The %s is already taken');
			
			return FALSE;
			
		}
		else
		{
			return TRUE;
		}
			
	}
	
	// check if this email exist already for password reset
	public function email_check_exist($str)
	{
		
		$username_chck 			= 	$this->facilitator_model->check_email_exist($str, 'user');
		
		if($username_chck['status'] == 'Success')
		{
			
			return TRUE;
			
		}
		else
		{
			$this->form_validation->set_message('password_reset_email_check', ''.$username_chck['status'].': '.$username_chck['message'].'');
			
			return FALSE;
		}
			
	}
	
	public function resend_account_confirmation()
	{
		
		$data['title'] 				= 	"Resend Confirmation :: 1Community";
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"> <a class="close" data-dismiss="alert">×</a>', '</div>');
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check_exist');
		
		if ($this->form_validation->run() == FALSE)
		{
						
			$this->load->view('msme/account-creation/resend-email-confirmation', $data);
			
				
		}else{
			
			// load the security helper where the sha1 function is
			$this->load->helper('security');
			
			$table			= 	'user';
			
			$email 			= 	$this->input->post('email');
			
			$user_id 		= 	$this->facilitator_model->get_user_id_by_email($email, $table);
			
			$userdet		= 	$this->facilitator_model->get_user_details($user_id, $table);
			
			$name			= 	ucfirst($userdet['firstName']).' '.ucfirst($userdet['lastName']);
			
			$time 			= 	date('Y-m-d H:i:s');
			
			$tim  			= 	strtotime($time);
			
			$token 			= 	do_hash($email.$tim);
			
			$token_field	= 	'userID';
			
			$url 			= 	'<a href="'.base_url().'msme/account/confirm-email/'.$user_id.'/'.$token.'/">'.base_url().'msme/account/confirm-email/'.$user_id.'/'.$token.'/</a>';
			
			$query 			= 	$this->facilitator_model->confirm_registration_email_token($token,$email,$time,$url,$user_id, $name);
			
			if($query)
			{
				
				$this->session->set_flashdata('success-message', 'An email has been sent to the address you provided, please check your inbox or spam to Confirm your email.');
				
				redirect(base_url().'msme/account/resend-account-confirmation/');
				
			}else{
				// generate error	
				
			}
		}

	}


	public function forgot_password()
	{
		
		$data['title'] 				= 	"Forgot Password :: 1Community";
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"> <a class="close" data-dismiss="alert">×</a>', '</div>');
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check_exist');
		
		if ($this->form_validation->run() == FALSE)
		{
						
			$this->load->view('msme/account-creation/forgot-password', $data);
			
				
		}else{
			
			// load the security helper where the sha1 function is
			$this->load->helper('security');
			
			$table			= 	'user';
			
			$email 			= 	$this->input->post('email');
			
			$user_id 		= 	$this->facilitator_model->get_user_id_by_email($email, $table);
			
			$userdet		= 	$this->facilitator_model->get_user_details($user_id, $table);
			
			$name			= 	ucfirst($userdet['firstName']).' '.ucfirst($userdet['lastName']);
			
			$time 			= 	date('Y-m-d H:i:s');
			
			$tim  			= 	strtotime($time);
			
			$token 			= 	do_hash($email.$tim);
			
			$token_field	= 	'userID';
			
			$url 			= 	'<a href="'.base_url().'msme/account/reset-password/'.$user_id.'/'.$token.'/">'.base_url().'msme/account/reset-password/'.$user_id.'/'.$token.'/</a>';
			
			$query 			= 	$this->facilitator_model->reset_password_email_token($token,$email,$time,$url,$user_id, $name);
			
			if($query)
			{
				
				$this->session->set_flashdata('success-message', 'An email has been sent to the address you provided, please check your inbox or spam to Reset Password.');
				
				redirect(base_url().'msme/account/forgot-password/');
				
			}else{
				// generate error	
				
			}
		}

	}

	public function reset_password($id=false,$token=false)
	{
		if(!empty($id) && !empty($token))
		{
			$data['title'] 		= 	"Reset Your Password :: 1Community";
			
			$data['id']			= 	$id;
			
			$data['token'] 		= 	$token;
			
			//check if the token and id exist in the database
			$chck 				= 	$this->facilitator_model->check_token($id,$token);
			
			if($chck['status'] == "Success")
			{
				// check if the token has expired
				if(time() <= strtotime($chck['message']." + 1 day")){
					
					$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
					
					$this->form_validation->set_rules('password', 'New Password', 'trim|required|matches[conf_password]');
					
					$this->form_validation->set_rules('conf_password', 'Confirm New Password', 'trim|required');
					
					if ($this->form_validation->run() == FALSE)
					{
						
						$this->load->view('msme/account-creation/reset-password', $data);
							
					}else{
						
						$new_password 			= 	$this->input->post('password');
						
						$query 					= 	$this->facilitator_model->resetpassword($id, $new_password, $token);
						
						if($query)
						{
							
							$this->session->set_flashdata('success-message', 'Password Reset Successful.');
				
							redirect(base_url().'msme/account/login/');
							
						}else{
							
							$this->session->set_flashdata('message', 'An Error occured while trying to reset your password, please try again.');
							
							redirect(base_url().'msme/account/reset-password/'.$id.'/'.$token.'/');
						}
						
					}
				
				}else{
					
					$this->session->set_flashdata('message', 'Your Password reset link has expired, Please request for another.');
				
					redirect(base_url().'msme/account/forgot-password/');
				}
				
			}else{
				
				//show_404();
				
				$this->session->set_flashdata('message', $chck['message']);
				
				redirect(base_url().'msme/account/forgot-password/');
			}
			
		}else{
			
			show_404();
		}
		
	}
	
	public function get_user_notification_unseen()
	{
		
		$user_id 					= 	$this->session->userdata('userID');
		
		$notifications				=	$this->facilitator_model->get_user_notifications_unseen($user_id);		
		
		return $notifications;
		
	}
	
	public function get_user_notification()
	{
		
		$user_id 					= 	$this->session->userdata('userID');
		
		$notifications				=	$this->facilitator_model->get_user_notifications($user_id);
		
		return $notifications;
		
	}
	
	
	public function notification()
	{
		$this->is_user_logged_in();
		
		$data['title'] 					= 	"Notifications :: 1Community";
		
		$data['menu_status']			=	'dashboard';
		
		$this->session->unset_userdata('notificationCounter');
		
		$seen							=	'1';
		
		$user_id 						= 	$this->session->userdata('userID');
		
		$data['notifications']			=	$this->facilitator_model->get_user_notifications($user_id, $seen);
		
		
		$this->load->view('msme/templates/header', $data);
		
		$this->load->view('msme/notification');
		
		$this->load->view('msme/templates/footer');
		
	}
	
	public function dashboard()
	{
		$this->is_user_logged_in();
		
		$data['title'] 				= 	"Dashboard :: 1Community";
		
		$data['menu_status']		=	'dashboard';
		
		$user_id 					= 	$this->session->userdata('userID');
		
		$data['user']				=	$this->facilitator_model->get_user_details($user_id, 'user');
		
		$data['business']			=	$this->facilitator_model->get_user_business_details($user_id, 'user_business');
		
		$data['country']			=	$this->facilitator_model->get_country_name($data['user']['country']);
				
		$data['userKYC']			=	$this->facilitator_model->get_user_kyc($user_id);
		
		$this->load->view('msme/templates/header', $data);
		
		$this->load->view('msme/dashboard');
		
		$this->load->view('msme/templates/footer');
		
	}	

	
	public function profile($id = false)
	{
		
		$this->is_user_logged_in();
		
		$data['title'] 						= 	"My Profile :: 1Community";
		
		$data['menu_status']				=	'profile';
		
		$user_id 							= 	$this->session->userdata('userID');
		
		$data['user']						=	$this->facilitator_model->get_user_details($user_id, 'user');	
				
		$data['firstName']					= 	$data['user']['firstName'];
		
		$data['lastName']					= 	$data['user']['lastName'];
		
		$data['otherName']					= 	$data['user']['otherName'];
		
		$data['email']						= 	$data['user']['email'];
		
		$data['mobile']						= 	$data['user']['mobile'];
		
		$data['profilePicture']				= 	$data['user']['profilePicture'];
		
		$data['address']					= 	$data['user']['address'];
		
		$data['country']					= 	$data['user']['country'];
		
		$data['state']						= 	$data['user']['state'];
		
		$data['lga']						= 	$data['user']['lga'];
		
		$data['state_of_origin']			= 	$data['user']['state_of_origin'];
		
		$data['lga_of_origin']				= 	$data['user']['lga_of_origin'];
		
		if($data['user']['dateOfBirth'] == '0000-00-00')
		{
			
			$data['dateOfBirth']			=	'';
		}else{
			
			$data['dateOfBirth']			= 	$data['user']['dateOfBirth'];
		
		}
		
		$data['gender']						= 	$data['user']['gender'];
		
		$data['bvn']						=	$data['user']['bvn'];
		
		$data['bvn_validated']				=	$data['user']['bvn_validated'];
		
		$data['maritalStatus']				=	$data['user']['maritalStatus'];
		
		$data['religion']					=	$data['user']['religion'];
		
		$data['ethnicity']					=	$data['user']['ethnicity'];
		
		$data['profile_complete']			=	$data['user']['profile_complete'];
		
		//get the countries list for the dropdown
		$data['countries']					= 	$this->facilitator_model->select_country();
		
		$data['country_states']				= 	$this->facilitator_model->get_country_states($data['country']);
		
		$data['country_states_lga']			= 	$this->facilitator_model->get_country_states_lga($data['state']);
		
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');

		$this->form_validation->set_rules('firstName', 'First Name', 'trim|required|callback_alpha_dash_space');
		
		$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required|alpha');
		
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required');
		
		//$this->form_validation->set_rules('bvn', 'Bank Verification Number(BVN)', 'trim|required');
		
		$this->form_validation->set_rules('address', 'Address', 'required|trim');
		
		$this->form_validation->set_rules('dateOfBirth', 'Date of Birth', 'trim|required');
		
		$this->form_validation->set_rules('religion', 'Religion', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('country', 'Country', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('state', 'State', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('lga', 'LGA', 'trim|required|callback_select_validate');	
		
		$this->form_validation->set_rules('state_of_origin', 'State of Origin', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('cur_password', 'Current Password', 'trim|required|callback_currentpswd_check');
		
		$newpassword 							= 	$this->input->post('new_password');	
		
		/*
		$this->form_validation->set_rules('state_id', 'State', 'trim|required|xss_clean|callback_select_validate');	*/
		
		if(!empty($newpassword)) // if the person wanted to change password validate the old password and new
		{
			
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|matches[conf_password]');
			
			$this->form_validation->set_rules('conf_password', 'Confirm New Password', 'trim|required');
			
		}

		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('msme/templates/header', $data);
			
			$this->load->view('msme/profile');
			
			$this->load->view('msme/templates/footer');
		
		}
		else
		{			
			
			if(isset($_FILES['photo1']['size']) && $_FILES['photo1']['size']>0)
			{
				
				$config['upload_path'] 			= 	'uploads/wysiwyg/images/profilepic/';
				
				$config['allowed_types'] 		= 	'jpg|jpeg|png';
				
				$config['max_size']				= 	'4400';
				
				$config['encrypt_name'] 		= 	true;
				
				$config['remove_spaces'] 		= 	true;

				$this->load->library('upload', $config);				
		
				if ( ! $this->upload->do_upload('photo1'))
				{
										
					$this->session->set_flashdata('error', 'Upload 1: '.$this->upload->display_errors());
					
					//go back to the article list
					redirect(base_url().'msme/profile/');

				}
				else
				{
					
					$upload_data					= 	$this->upload->data();
					
					$this->load->library('image_lib');
					
					//small image
					$config['image_library'] 		= 	'gd2';
					
					$config['source_image'] 		= 	'uploads/wysiwyg/images/profilepic/'.$upload_data['file_name'];
					
					$config['new_image']			= 	'uploads/wysiwyg/images/profilepic/small/'.$upload_data['file_name'];
					
					$config['maintain_ratio'] 		= 	TRUE;
					
					$config['width'] 				= 	215;
					
					$config['height'] 				= 	215;
					
					$this->image_lib->initialize($config); 
					
					$this->image_lib->resize();
					
					$this->image_lib->clear();
				
					/*$data 						= 	array('upload_data' => $this->upload->data());
					
					$save['profilePicture'] 	= 	$data['upload_data']['file_name'];*/
										
					$save['profilePicture'] 		= 	$upload_data['file_name'];
					
				}

				
			
			}else{
				
					$save['profilePicture']	    = 	$this->input->post('profilePicture');
					
			}
			
			$save['userID'] 					= 	$this->session->userdata('userID');
					
			$save['firstName']					= 	$this->input->post('firstName');
			
			$save['lastName']					= 	$this->input->post('lastName');
			
			$save['otherName']					= 	$this->input->post('otherName');
			
			$save['email']						= 	$this->input->post('email');
			
			$save['mobile']						= 	$this->input->post('mobile');
			
			$save['address']					= 	$this->input->post('address');
			
			$save['country']					=	$this->input->post('country');
			
			$save['state']						= 	$this->input->post('state');
			
			$save['lga']						= 	$this->input->post('lga');
			
			$save['state_of_origin']			= 	$this->input->post('state_of_origin');
		
			//$save['lga_of_origin']				= 	$this->input->post('lga_of_origin');
		
			$save['dateOfBirth']				= 	$this->input->post('dateOfBirth');
			
			$save['gender']						= 	$this->input->post('gender');
			
			$save['bvn']						=	$this->input->post('bvn');
						
			$save['maritalStatus']				=	$this->input->post('maritalStatus');
			
			$save['religion']					=	$this->input->post('religion');
			
			$save['ethnicity']					=	$this->input->post('ethnicity');
			
			$save['bvn_validated']				=	'';
			
			$save['profile_complete']			=	$data['user']['profile_complete'];
		
			
			
			if(!empty($newpassword))
			{
				
				$save['password']				= 	md5($this->input->post('new_password'));
					
			}
						
			$query 								= 	$this->facilitator_model->set_user($save);
			
			if($query['status'] == 'Success') // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('success-message', ''.$query['status'].': '.$query['message'].'');
				
				redirect(base_url().'msme/profile/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', ''.$query['status'].': '.$query['message'].'');
				
				redirect(base_url().'msme/profile/');

			}
			
		}
		
	}
	
	// this function is for when the customer wants to change their password make sure it s the owner of the account by cross checking the old password
	public function currentpswd_check($str)
	{
		/*$cust_id = $this->session->userdata('customer_id');
		$pswd_chck = $this->customer_model->check_pswd($str, $cust_id);*/
		
		$userID 						= 	$this->session->userdata('userID');

		$pswd_chck 						= 	$this->facilitator_model->check_pswd($str, $userID);
		
		if($pswd_chck == TRUE)
		{
			
			return TRUE;
			
		}
		else
		{
			
			$this->form_validation->set_message('currentpswd_check', 'The %s does not match our record, Please provide the correct password.');
			
			return FALSE;
		
		}
			
	}
	
	public function business_profile($id = false)
	{
		
		$this->is_user_logged_in();
		
		$data['title'] 						= 	"My Business :: 1Community";
		
		$data['menu_status']				=	'business-profile';
		
		$user_id 							= 	$this->session->userdata('userID');
		
		$data['user']						=	$this->facilitator_model->get_user_details($user_id, 'user');	
		
		$data['business']					=	$this->facilitator_model->get_user_business_details($user_id, 'user_business');
		
		$data['businessID']					= 	$data['business']['businessID'];
				
		$data['businessName']				= 	$data['business']['businessName'];
		
		$data['cacRegStatus']				= 	$data['business']['cacRegStatus'];
		
		$data['cacRegNum']					= 	$data['business']['cacRegNum'];
		
		if(!empty($data['business']['no_of_owners']))
		{
		
			$data['no_of_owners']			= 	$data['business']['no_of_owners'];
		
		}else{
			
			$data['no_of_owners']			=	'';
		}
		
		$data['tin']						= 	$data['business']['tin'];
		
		$data['industry']					= 	$data['business']['industry'];
		
		$data['yearsInBusiness']			= 	$data['business']['yearsInBusiness'];
		
		$data['businessCountry']			= 	$data['business']['businessCountry'];
		
		$data['businessState']				= 	$data['business']['businessState'];
		
		$data['businessLga']				= 	$data['business']['businessLga'];
		
		$data['businessAddress']			=	$data['business']['businessAddress'];
		
		$data['profileComplete']			=	$data['business']['profileComplete'];
		
		//get the countries list for the dropdown
		$data['countries']					= 	$this->facilitator_model->select_country();
		
		$data['country_states']				= 	$this->facilitator_model->get_country_states($data['businessCountry']);
		
		$data['country_states_lga']			= 	$this->facilitator_model->get_country_states_lga($data['businessState']);
		
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');

		$this->form_validation->set_rules('businessName', 'Business Name', 'trim|required|callback_alpha_dash_space');
		
		$this->form_validation->set_rules('cacRegStatus', 'Registration Status', 'trim|required');
		
		$this->form_validation->set_rules('cacRegNum', 'CAC Number', 'trim|required');
		
		$this->form_validation->set_rules('no_of_owners', 'Number of Owners', 'trim|required');
		
		$this->form_validation->set_rules('tin', 'TIN', 'trim|required');
		
		$this->form_validation->set_rules('businessAddress', 'Business Address', 'required|trim');
		
		$this->form_validation->set_rules('industry', 'Industry', 'trim|required');
		
		$this->form_validation->set_rules('yearsInBusiness', 'Years in Business', 'trim|required|callback_select_validate');
				
		$this->form_validation->set_rules('country', 'Country', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('state', 'State', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('lga', 'LGA', 'trim|required|callback_select_validate');	
		
		//$this->form_validation->set_rules('cur_password', 'Current Password', 'trim|required|callback_currentpswd_check');
		

		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('msme/templates/header', $data);
			
			$this->load->view('msme/business-profile');
			
			$this->load->view('msme/templates/footer');
		
		}
		else
		{			
			
			$save['userID'] 					= 	$this->session->userdata('userID');
			
			$save['businessID']					= 	$id;
								
			$save['businessName']				= 	$this->input->post('businessName');
			
			$slug 								= 	$this->input->post('businessName');
	
			$slug								= 	url_title(convert_accented_characters($slug), 'dash', TRUE);
			
			$save['businessNameSlug']			= 	$slug;
		
			$save['cacRegStatus']				= 	$this->input->post('cacRegStatus');
			
			$save['cacRegNum']					= 	$this->input->post('cacRegNum');
			
			$save['no_of_owners']				= 	$this->input->post('no_of_owners');
			
			$save['tin']						= 	$this->input->post('tin');
			
			$save['industry']					= 	$this->input->post('industry');
			
			$save['yearsInBusiness']			= 	$this->input->post('yearsInBusiness');
			
			$save['businessCountry']			= 	$this->input->post('country');
			
			$save['businessState']				= 	$this->input->post('state');
			
			$save['businessLga']				= 	$this->input->post('lga');
			
			$save['businessAddress']			=	$this->input->post('businessAddress');
						
			$save['profileComplete']			=	'0';
						
			$query 								= 	$this->facilitator_model->set_business($save);
			
			if($query['status'] == 'Success') // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('success-message', ''.$query['status'].': '.$query['message'].'');
				
				redirect(base_url().'msme/business-profile/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', ''.$query['status'].': '.$query['message'].'');
				
				redirect(base_url().'msme/business-profile/');

			}
			
		}
		
	}
				
	
	public function kyc($id=false)
	{
		$this->is_user_logged_in();
		
		$data['title'] 					= 	"Kyc :: 1Community";
		
		$data['menu_status']			=	'kyc';
		
		$user_id 						= 	$this->session->userdata('userID');
		
		$data['user']					=	$this->facilitator_model->get_user_details($user_id, 'user');
		
				
		//default values are empty if the article is new
		
		$data['kycID']					= 	'';
		
		$data['numChildren']			= 	'';
		
		$data['numDependents']			= 	'';
		
		$data['highestEducation']		= 	'';
		
		$data['numLanguages']			= 	'';
		
		$data['professionalAssoc']		= 	'';
		
		$data['numEmployees']			= 	'';
		
		$data['idType']					= 	'';
		
		$data['ifIDothers']				= 	'';
		
		$data['idNumber']				= 	'';

		$data['img_link_front']			= 	'';
		
		$data['img_link_back']			= 	'';
		
		$data['img_link_selfie']		= 	'';
		
		$data['kycStatus']				= 	'';
		
		$data['utilityType']			= 	'';
			
		$data['ifUtilityothers']		= 	'';
		
		$data['utilityImage']			= 	'';
		
		$data['reason']					= 	'';

		$userKYC						=	$this->facilitator_model->get_user_kyc($user_id);

		//if the brand does not exist, redirect them to the brands list with an error
		if(!empty($userKYC))
		{

			//set values to db values
		
			$data['kycID']						= 	$userKYC->kycID;
			
			$data['numChildren']				= 	$userKYC->numChildren;
		
			$data['numDependents']				= 	$userKYC->numDependents;
			
			$data['highestEducation']			= 	$userKYC->highestEducation;
			
			$data['numLanguages']				= 	$userKYC->numLanguages;
			
			$data['professionalAssoc']			= 	$userKYC->professionalAssoc;
			
			$data['numEmployees']				= 	$userKYC->numEmployees;
		
			$data['idType']						= 	$userKYC->idType;
			
			$data['ifIDothers']					= 	$userKYC->ifIDothers;
			
			$data['idNumber']					= 	$userKYC->idNumber;
	
			$data['img_link_front']				= 	$userKYC->idImageFront;
			
			$data['img_link_back']				= 	$userKYC->idImageBack;
						
			$data['utilityType']				= 	$userKYC->utilityType;
			
			$data['ifUtilityothers']			= 	$userKYC->ifUtilityothers;
			
			$data['utilityImage']				= 	$userKYC->utilityImage;
			
			$data['kycStatus']					= 	$userKYC->kycStatus;
			
			$chkstatus['kycStatus']				= 	$userKYC->kycStatus;
			
			$data['reason']						= 	$userKYC->reason;			
			
		}
		
		// perform form validation first
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('highestEducation', 'Highest Educational Level', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('numEmployees', 'Number of Employees', 'required|trim');
		
		$this->form_validation->set_rules('idType', 'ID Type', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('idNumber', 'ID Number', 'required|trim');
	
		if (empty($_FILES['photo1']['name']))
		{
			
			if(empty($this->input->post('img_link_front')))
			{
				
				$this->form_validation->set_rules('photo1', 'Upload Image (Front)', 'required');
			
			}
			
		}
		
		if (empty($_FILES['photo2']['name']))
		{
			
			if(empty($this->input->post('img_link_back')))
			{
				
				$this->form_validation->set_rules('photo2', 'Upload Image (Back)', 'required');
			
			}
			
		}
		
		if (empty($_FILES['photo3']['name']))
		{
			
			if(empty($this->input->post('utilityImage')))
			{
				
				$this->form_validation->set_rules('photo3', 'Utility Image', 'required');
			
			}
		}
					
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('msme/templates/header', $data);
		
			$this->load->view('msme/kyc');
			
			$this->load->view('msme/templates/footer');
		}
		else
		{
			
			if(isset($_FILES['photo1']['size']) && $_FILES['photo1']['size']>0)
			{
				
				$config['upload_path'] 			= 	'uploads/wysiwyg/images/kycDocs/';
				
				$config['allowed_types'] 		= 	'jpg|jpeg|png';
				
				$config['max_size']				= 	'4400';
				
				$config['encrypt_name'] 		= 	true;
				
				$config['remove_spaces'] 		= 	true;

				$this->load->library('upload', $config);
		
				if ( ! $this->upload->do_upload('photo1'))
				{
										
					$this->session->set_flashdata('error', 'Upload 1: '.$this->upload->display_errors());
					
					//go back to the article list
					redirect(base_url().'msme/kyc/');

				}
				else
				{
					
					$data 						= 	array('upload_data' => $this->upload->data());
					
					$save['idImageFront'] 		= 	$data['upload_data']['file_name'];
					
				}

				
			
			}else{
				
					$save['idImageFront']	    	= 	$this->input->post('img_link_front');
					
			}
			
			if(isset($_FILES['photo2']['size']) && $_FILES['photo2']['size']>0)
			{
				
				$config['upload_path'] 			= 	'uploads/wysiwyg/images/kycDocs/';
				
				$config['allowed_types'] 		= 	'jpg|jpeg|png';
				
				$config['max_size']				= 	'4400';
				
				$config['encrypt_name'] 		= 	true;
				
				$config['remove_spaces'] 		= 	true;
		
				$this->load->library('upload', $config);
		
				if ( ! $this->upload->do_upload('photo2'))
				{
										
					$this->session->set_flashdata('error', 'Upload 2: '.$this->upload->display_errors());
					
					//go back to the article list
					redirect(base_url().'msme/kyc/');

				}
				else
				{
					
					$data 						= 	array('upload_data' => $this->upload->data());
					
					$save['idImageBack'] 		= 	$data['upload_data']['file_name'];
					
				}

				
			
			}else{
				
					$save['idImageBack']	    	= 	$this->input->post('img_link_back');
					
			}
			
			if(isset($_FILES['photo3']['size']) && $_FILES['photo3']['size']>0)
			{
				
				$config['upload_path'] 			= 	'uploads/wysiwyg/images/kycDocs/utility/';
				
				$config['allowed_types'] 		= 	'jpg|jpeg|png';
				
				$config['max_size']				= 	'4400';
				
				$config['encrypt_name'] 		= 	true;
				
				$config['remove_spaces'] 		= 	true;
		
				$this->load->library('upload', $config);
		
				if ( ! $this->upload->do_upload('photo3'))
				{
										
					$this->session->set_flashdata('error', 'Upload 3: '.$this->upload->display_errors());
					
					//go back to the article list
					redirect(base_url().'msme/kyc/');

				}
				else
				{
					
					$data 						= 	array('upload_data' => $this->upload->data());
					
					$save['utilityImage'] 		= 	$data['upload_data']['file_name'];
					
				}

				
			
			}else{
				
					$save['utilityImage']	    	= 	$this->input->post('utilityImage');
					
			}

			if(!empty($chkstatus['kycStatus']))
			{
								
				if($chkstatus['kycStatus'] == '2')
				{
					
					//this users kyc was previously rejected so set this new one as a new record			
					$save['kycID']					= 	'';
					
				}
				
			}else{
				
				//it means admin has not acted on this document yet so user can still make changes as they see fit
				$save['kycID']						= 	$id;
			}
			
			$save['numChildren']					= 	$this->input->post('numChildren');
		
			$save['numDependents']					= 	$this->input->post('numDependents');
			
			$save['highestEducation']				= 	$this->input->post('highestEducation');
			
			$save['numLanguages']					= 	$this->input->post('numLanguages');
			
			$save['professionalAssoc']				= 	$this->input->post('professionalAssoc');
			
			$save['numEmployees']					= 	$this->input->post('numEmployees');
			
			$save['idType']							= 	$this->input->post('idType');
			
			$save['ifIDothers']						= 	$this->input->post('ifIDothers');
			
			$save['idNumber']						= 	$this->input->post('idNumber');
			
			$save['utilityType']					= 	$this->input->post('utilityType');
			
			$save['ifUtilityothers']				= 	$this->input->post('ifUtilityothers');
			
			// its a new complaint
			$save['dateUploaded']					= 	date('Y-m-d H:i:s');
			
			$save['userID']             			= 	$user_id;
			
			// save article
			$query 									= 	$this->facilitator_model->set_user_kyc($save);
			
			if($query['status'] == "Success")
			{
				$this->session->set_flashdata('success-message', $query['message']);
			
				//go back to the article list
				redirect(base_url().'msme/kyc/');
			}
			else
			{
				$this->session->set_flashdata('error', $query['message']);
				
				redirect(base_url().'msme/kyc/');
			}
			
		}			
		
	}
	
	public function loans($page = FALSE)
	{
		$this->is_user_logged_in();
		
		$data['title'] 					= 	"Loans :: 1Community";
		
		$data['menu_status']			=	'loans';
		
		$user_id 						= 	$this->session->userdata('userID');
		
		$data['user']					=	$this->facilitator_model->get_user_details($user_id, 'user');
		
		$data['loans']					= 	$this->facilitator_model->get_user_loans($user_id);
		
		$data['userOpenLoan']			=	$this->facilitator_model->get_user_existing_open_loan_details($user_id, '', '0');
		
		if($page === false){		
		
			$this->load->view('msme/templates/header', $data);
		
			$this->load->view('msme/loans');
			
			$this->load->view('msme/templates/footer');
		
		}else{
			
			//$page						= str_replace('_', '-',$page);
			
			$this->view_loan_application($page);

		}
		
	}
	
	
	function view_loan_application($loanID)
	{
		
		$this->is_user_logged_in();
		
		$data['title'] 					= 	"Loans :: 1Community";
		
		$data['menu_status']			=	'loans';		
		
		if(!empty($loanID))
		{
			
			//get the details of this loan
			
			$user_id 					= 	$this->session->userdata('userID');
		
			$data['user']				=	$this->facilitator_model->get_user_details($user_id, 'user');
			
			$data['loans']				= 	$this->facilitator_model->get_user_loans($user_id, $loanID);
			
			$data['countries']					= 	$this->facilitator_model->select_country();

			$data['country_states']				= 	$this->facilitator_model->get_country_states($data['loans']['userLoanProfile']['country']);
		
			$data['country_states_lga']			= 	$this->facilitator_model->get_country_states_lga($data['loans']['userLoanProfile']['state']);
			
			$data['banks']						=	$this->facilitator_model->get_banks();
			
			$data['businessCountry_states']		= 	$this->facilitator_model->get_country_states($data['loans']['userLoanBusiness']['businessCountry']);
		
			$data['businesscountry_states_lga']			= 	$this->facilitator_model->get_country_states_lga($data['loans']['userLoanBusiness']['businessState']);

			//print_r($data['loans']);
			$this->load->view('msme/templates/header', $data);
		
			$this->load->view('msme/loan-view');
			
			$this->load->view('msme/templates/footer');
			
		}else{
			
			show_404();
				
		}
		
		
	}
		
	
	public function apply_for_loan($page = FALSE)
	{
		$this->is_user_logged_in();
		
		$data['title'] 					= 	"Apply for Loan :: 1Community";
		
		$data['menu_status']			=	'loans';
		
		$user_id 						= 	$this->session->userdata('userID');
		
		$data['user']					=	$this->facilitator_model->get_user_details($user_id, 'user');
		
		//$data['loanTypes']				= 	$this->facilitator_model->get_subscription_plans();
		
		if($page === false){		
		
			$this->load->view('msme/templates/header', $data);
		
			$this->load->view('msme/apply-for-loan');
			
			$this->load->view('msme/templates/footer');
		
		}else{
			
			//$page						= str_replace('_', '-',$page);
			
			$this->loan_application($page);

		}
		
	}
	
	public function loan_application($page = FALSE)
	{
		
		$this->is_user_logged_in();
		
		$data['title'] 						= 	"Apply for Loan :: 1Community";
		
		$data['menu_status']				=	'loans';
		
		$user_id 							= 	$this->session->userdata('userID');
		
		$data['user']						=	$this->facilitator_model->get_user_details($user_id, 'user');
		
		$data['loanType']					=	$this->facilitator_model->get_loanTypeDetails_bySlug($page);
		
		$data['userBusiness']				=	$this->facilitator_model->get_user_business_details($user_id, 'user_business');
		
		$userKYC							=	$this->facilitator_model->get_user_kyc($user_id);
		
		$data['firstName']					= 	$data['user']['firstName'];
		
		$data['lastName']					= 	$data['user']['lastName'];
		
		$data['otherName']					= 	$data['user']['otherName'];
		
		$data['email']						= 	$data['user']['email'];
		
		$data['mobile']						= 	$data['user']['mobile'];
		
		$data['profilePicture']				= 	$data['user']['profilePicture'];
		
		$data['address']					= 	$data['user']['address'];
		
		$data['country']					= 	$data['user']['country'];
		
		$data['state']						= 	$data['user']['state'];
		
		$data['lga']						= 	$data['user']['lga'];
		
		$data['state_of_origin']			= 	$data['user']['state_of_origin'];
		
		$data['lga_of_origin']				= 	$data['user']['lga_of_origin'];
		
		if($data['user']['dateOfBirth'] == '0000-00-00')
		{
			
			$data['dateOfBirth']			=	'';
			
		}else{
			
			$data['dateOfBirth']			= 	$data['user']['dateOfBirth'];
		
		}
		
		$data['gender']						= 	$data['user']['gender'];
		
		$data['bvn']						=	$data['user']['bvn'];
		
		$data['bvn_validated']				=	$data['user']['bvn_validated'];
		
		$data['maritalStatus']				=	$data['user']['maritalStatus'];
		
		$data['religion']					=	$data['user']['religion'];
		
		$data['ethnicity']					=	$data['user']['ethnicity'];
				
		//get the countries list for the dropdown
		$data['countries']					= 	$this->facilitator_model->select_country();
		
		$data['country_states']				= 	$this->facilitator_model->get_country_states($data['country']);
		
		$data['country_states_lga']			= 	$this->facilitator_model->get_country_states_lga($data['state']);
		
		
		//now fill the business profile		
		$data['businessID']					= 	$data['userBusiness']['businessID'];
				
		$data['businessName']				= 	$data['userBusiness']['businessName'];
		
		$data['cacRegStatus']				= 	$data['userBusiness']['cacRegStatus'];
		
		$data['cacRegNum']					= 	$data['userBusiness']['cacRegNum'];
		
		if(!empty($data['userBusiness']['no_of_owners']))
		{
		
			$data['no_of_owners']			= 	$data['userBusiness']['no_of_owners'];
		
		}else{
			
			$data['no_of_owners']			=	'';
		}
		
		$data['tin']						= 	$data['userBusiness']['tin'];
		
		$data['industry']					= 	$data['userBusiness']['industry'];
		
		$data['yearsInBusiness']			= 	$data['userBusiness']['yearsInBusiness'];
		
		$data['businessCountry']			= 	$data['userBusiness']['businessCountry'];
		
		$data['businessState']				= 	$data['userBusiness']['businessState'];
		
		$data['businessLga']				= 	$data['userBusiness']['businessLga'];
		
		$data['businessAddress']			=	$data['userBusiness']['businessAddress'];
		
		$data['corporateBankID']			=	$data['userBusiness']['corporateBankID'];
		
		$data['corporateBankAccount']		=	$data['userBusiness']['corporateBankAccount'];
		
		$data['businessCountry_states']		= 	$this->facilitator_model->get_country_states($data['businessCountry']);
		
		$data['businesscountry_states_lga']			= 	$this->facilitator_model->get_country_states_lga($data['businessState']);
		
		$data['banks']						=	$this->facilitator_model->get_banks();
		
		
		//fill the kyc
		
		$data['kycID']						= 	'';
		
		$data['numChildren']				= 	'';
		
		$data['numDependents']				= 	'';
		
		$data['highestEducation']			= 	'';
		
		$data['numLanguages']				= 	'';
		
		$data['professionalAssoc']			= 	'';
		
		$data['numEmployees']				= 	'';
		
		$data['idType']						= 	'';
		
		$data['ifIDothers']					= 	'';
		
		$data['idNumber']					= 	'';

		$data['img_link_front']				= 	'';
		
		$data['img_link_back']				= 	'';
		
		$data['img_link_selfie']			= 	'';
		
		$data['kycStatus']					= 	'';
		
		$data['utilityType']				= 	'';
			
		$data['ifUtilityothers']			= 	'';
		
		$data['utilityImage']				= 	'';
		
		$data['reason']						= 	'';
		
		if(!empty($userKYC))
		{

			//set values to db values
		
			$data['kycID']						= 	$userKYC->kycID;
			
			$data['numChildren']				= 	$userKYC->numChildren;
		
			$data['numDependents']				= 	$userKYC->numDependents;
			
			$data['highestEducation']			= 	$userKYC->highestEducation;
			
			$data['numLanguages']				= 	$userKYC->numLanguages;
			
			$data['professionalAssoc']			= 	$userKYC->professionalAssoc;
			
			$data['numEmployees']				= 	$userKYC->numEmployees;
		
			$data['idType']						= 	$userKYC->idType;
			
			$data['ifIDothers']					= 	$userKYC->ifIDothers;
			
			$data['idNumber']					= 	$userKYC->idNumber;
	
			$data['img_link_front']				= 	$userKYC->idImageFront;
			
			$data['img_link_back']				= 	$userKYC->idImageBack;
						
			$data['utilityType']				= 	$userKYC->utilityType;
			
			$data['ifUtilityothers']			= 	$userKYC->ifUtilityothers;
			
			$data['utilityImage']				= 	$userKYC->utilityImage;
			
			$data['kycStatus']					= 	$userKYC->kycStatus;
			
			$chkstatus['kycStatus']				= 	$userKYC->kycStatus;
			
			$data['reason']						= 	$userKYC->reason;			
			
		}
		
		
		
		//set the loan details
		
		$data['dist_btwn_home_office']			=	'';
		
		$data['home_own_status']				=	'';
		
		$data['vehicle_own_status']				=	'';
		
		$data['loanAmount']						=	'';
		
		$data['loanTenure']						=	'';
		
		$data['loanPurpose']					=	'';
		
		$data['businessImpact']					=	'';
		
		$data['amountInvestedInBusiness']		=	'';
		
		$userOpenLoan							=	$this->facilitator_model->get_user_existing_open_loan_details($user_id, '', '0');
		
		//if not empty fill the data
		if(!empty($userOpenLoan))
		{
			
			$data['loanAmount']						=	$userOpenLoan['userLoan']['loanAmount'];
		
			$data['loanTenure']						=	$userOpenLoan['userLoan']['loanTenure'];
			
			$data['loanPurpose']					=	$userOpenLoan['userLoan']['loanPurpose'];
			
			$data['businessImpact']					=	$userOpenLoan['userLoan']['businessImpact'];
			
			$data['amountInvestedInBusiness']		=	$userOpenLoan['userLoan']['amountInvestedInBusiness'];
			
		}
		
		// perform form validation first
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a>', '</div>');
		
		$this->form_validation->set_rules('firstName', 'First Name', 'trim|required|alpha');
		
		$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required|alpha');
		
		//$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
		
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		
		$this->form_validation->set_rules('bvn', 'Bank Verification Number', 'trim|required');
		
		$this->form_validation->set_rules('homeAddress', 'Home Address', 'trim|required');
		
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('dateOfBirth', 'Date of Birth', 'trim|required');
		
		$this->form_validation->set_rules('maritalStatus', 'Marital Status', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('country', 'Country', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('state', 'State', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('lga', 'LGA', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('state_of_origin', 'State of Origin', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('religion', 'Religion', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('ethnicity', 'Ethnicity', 'trim|required');
		
			
		
		$this->form_validation->set_rules('businessName', 'Business Name', 'trim|required|callback_alpha_dash_space');
		
		$this->form_validation->set_rules('cacRegStatus', 'Registration Status', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('cacRegNum', 'CAC Number', 'trim|required');
		
		$this->form_validation->set_rules('no_of_owners', 'Number of Owners', 'trim|required');
		
		$this->form_validation->set_rules('tin', 'TIN', 'trim|required');
		
		$this->form_validation->set_rules('corporateBankID', 'Business Corporate Account Bank', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('corporateBankAccount', 'Business Corporate Account Number', 'trim|required');
		
		$this->form_validation->set_rules('businessAddress', 'Business Address', 'required|trim');
		
		$this->form_validation->set_rules('industry', 'Industry', 'trim|required');
		
		$this->form_validation->set_rules('yearsInBusiness', 'Years in Business', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('businessCountry', 'Country of your Business', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('businessState', 'State of your Business', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('businessLga', 'LGA of your Business', 'trim|required|callback_select_validate');
		
		
		
		$this->form_validation->set_rules('highestEducation', 'Highest Educational Level', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('numEmployees', 'Number of Employees', 'required|trim');
		
		$this->form_validation->set_rules('idType', 'ID Type', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('idNumber', 'ID Number', 'required|trim');
		
		$this->form_validation->set_rules('utilityType', 'Utility Bill', 'trim|required|callback_select_validate');
		
		if (empty($_FILES['photo1']['name']))
		{
			
			if(empty($this->input->post('img_link_front')))
			{
				
				$this->form_validation->set_rules('photo1', 'Upload Image (Front)', 'required');
			
			}
			
		}
		
		if (empty($_FILES['photo2']['name']))
		{
			
			if(empty($this->input->post('img_link_back')))
			{
				
				$this->form_validation->set_rules('photo2', 'Upload Image (Back)', 'required');
			
			}
			
		}
		
		if (empty($_FILES['photo3']['name']))
		{
			
			if(empty($this->input->post('utilityImage')))
			{
				
				$this->form_validation->set_rules('photo3', 'Utility Image', 'required');
			
			}
		}	
		
		
		$this->form_validation->set_rules('loanAmount', 'Loan Amount', 'required|trim');
		
		$this->form_validation->set_rules('loanTenure', 'Loan Tenure', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('loanPurpose', 'Purpose of Loan', 'required|trim');
		
		$this->form_validation->set_rules('businessImpact', 'Business Impact', 'required|trim');

		
		if ($this->form_validation->run() === FALSE)
		{
			
			$this->load->view('msme/templates/header', $data);
		
			$this->load->view('msme/loan-application');
			
			$this->load->view('msme/templates/footer');
			
		}
		else
		{
			
			$savePersonalProfile['userID'] 						= 	$user_id;
					
			$savePersonalProfile['firstName']					= 	$this->input->post('firstName');
			
			$savePersonalProfile['lastName']					= 	$this->input->post('lastName');
			
			$savePersonalProfile['otherName']					= 	$this->input->post('otherName');
			
			$savePersonalProfile['email']						= 	$this->input->post('email');
			
			$savePersonalProfile['mobile']						= 	$this->input->post('mobile');
			
			$savePersonalProfile['address']						= 	$this->input->post('homeAddress');
			
			$savePersonalProfile['country']						=	$this->input->post('country');
			
			$savePersonalProfile['state']						= 	$this->input->post('state');
			
			$savePersonalProfile['lga']							= 	$this->input->post('lga');
			
			$savePersonalProfile['state_of_origin']				= 	$this->input->post('state_of_origin');
		
			//$savePersonalProfile['lga_of_origin']				= 	$this->input->post('lga_of_origin');
		
			$savePersonalProfile['dateOfBirth']					= 	$this->input->post('dateOfBirth');
			
			$savePersonalProfile['gender']						= 	$this->input->post('gender');
			
			$savePersonalProfile['bvn']							=	$this->input->post('bvn');
						
			$savePersonalProfile['maritalStatus']				=	$this->input->post('maritalStatus');
			
			$savePersonalProfile['religion']					=	$this->input->post('religion');
			
			$savePersonalProfile['ethnicity']					=	$this->input->post('ethnicity');
			
			$savePersonalProfile['bvn_validated']				=	'';
						
			
			//get the business profile
			
			$saveBusinessProfile['userID'] 						= 	$user_id;
											
			$saveBusinessProfile['businessName']				= 	$this->input->post('businessName');
			
			$slug 												= 	$this->input->post('businessName');
	
			$slug												= 	url_title(convert_accented_characters($slug), 'dash', TRUE);
			
			$saveBusinessProfile['businessNameSlug']			= 	$slug;
		
			$saveBusinessProfile['cacRegStatus']				= 	$this->input->post('cacRegStatus');
			
			$saveBusinessProfile['cacRegNum']					= 	$this->input->post('cacRegNum');
			
			$saveBusinessProfile['no_of_owners']				= 	$this->input->post('no_of_owners');
			
			$saveBusinessProfile['tin']							= 	$this->input->post('tin');
			
			$saveBusinessProfile['corporateBankID']				= 	$this->input->post('corporateBankID');
			
			$saveBusinessProfile['corporateBankAccount']		= 	$this->input->post('corporateBankAccount');
			
			$saveBusinessProfile['industry']					= 	$this->input->post('industry');
			
			$saveBusinessProfile['yearsInBusiness']				= 	$this->input->post('yearsInBusiness');
			
			$saveBusinessProfile['businessCountry']				= 	$this->input->post('businessCountry');
			
			$saveBusinessProfile['businessState']				= 	$this->input->post('businessState');
			
			$saveBusinessProfile['businessLga']					= 	$this->input->post('businessLga');
			
			$saveBusinessProfile['businessAddress']				=	$this->input->post('businessAddress');
			
			
			//get the user kyc
			if(isset($_FILES['photo1']['size']) && $_FILES['photo1']['size']>0)
			{
				
				$config['upload_path'] 			= 	'uploads/wysiwyg/images/kycDocs/';
				
				$config['allowed_types'] 		= 	'jpg|jpeg|png';
				
				$config['max_size']				= 	'4400';
				
				$config['encrypt_name'] 		= 	true;
				
				$config['remove_spaces'] 		= 	true;

				$this->load->library('upload', $config);
		
				if ( ! $this->upload->do_upload('photo1'))
				{
										
					$this->session->set_flashdata('error', 'Upload 1: '.$this->upload->display_errors());
					
					//go back to the article list
					redirect(base_url().'msme/loan-application/'.$page.'/');

				}
				else
				{
					
					$data 								= 	array('upload_data' => $this->upload->data());
					
					$saveUserKYC['idImageFront'] 		= 	$data['upload_data']['file_name'];
					
				}

				
			
			}else{
				
					$saveUserKYC['idImageFront']	    = 	$this->input->post('img_link_front');
					
			}
			
			if(isset($_FILES['photo2']['size']) && $_FILES['photo2']['size']>0)
			{
				
				$config['upload_path'] 			= 	'uploads/wysiwyg/images/kycDocs/';
				
				$config['allowed_types'] 		= 	'jpg|jpeg|png';
				
				$config['max_size']				= 	'4400';
				
				$config['encrypt_name'] 		= 	true;
				
				$config['remove_spaces'] 		= 	true;
		
				$this->load->library('upload', $config);
		
				if ( ! $this->upload->do_upload('photo2'))
				{
										
					$this->session->set_flashdata('error', 'Upload 2: '.$this->upload->display_errors());
					
					//go back to the article list
					redirect(base_url().'msme/loan-application/'.$page.'/');

				}
				else
				{
					
					$data 							= 	array('upload_data' => $this->upload->data());
					
					$saveUserKYC['idImageBack'] 	= 	$data['upload_data']['file_name'];
					
				}

				
			
			}else{
				
					$saveUserKYC['idImageBack']	    = 	$this->input->post('img_link_back');
					
			}
			
			if(isset($_FILES['photo3']['size']) && $_FILES['photo3']['size']>0)
			{
				
				$config['upload_path'] 			= 	'uploads/wysiwyg/images/kycDocs/utility/';
				
				$config['allowed_types'] 		= 	'jpg|jpeg|png';
				
				$config['max_size']				= 	'4400';
				
				$config['encrypt_name'] 		= 	true;
				
				$config['remove_spaces'] 		= 	true;
		
				$this->load->library('upload', $config);
		
				if ( ! $this->upload->do_upload('photo3'))
				{
										
					$this->session->set_flashdata('error', 'Upload 3: '.$this->upload->display_errors());
					
					//go back to the article list
					redirect(base_url().'msme/loan-application/'.$page.'/');

				}
				else
				{
					
					$data 							= 	array('upload_data' => $this->upload->data());
					
					$saveUserKYC['utilityImage'] 	= 	$data['upload_data']['file_name'];
					
				}

				
			
			}else{
				
					$saveUserKYC['utilityImage']	 = 	$this->input->post('utilityImage');
					
			}

			/*if(!empty($chkstatus['kycStatus']))
			{
								
				if($chkstatus['kycStatus'] == '2')
				{
					
					//this users kyc was previously rejected so set this new one as a new record			
					$save['kycID']					= 	'';
					
				}
				
			}else{
				
				//it means admin has not acted on this document yet so user can still make changes as they see fit
				$save['kycID']						= 	$id;
			}*/
			
			$saveUserKYC['userID'] 							= 	$user_id;
			
			$saveUserKYC['numChildren']						= 	$this->input->post('numChildren');
		
			$saveUserKYC['numDependents']					= 	$this->input->post('numDependents');
			
			$saveUserKYC['highestEducation']				= 	$this->input->post('highestEducation');
			
			$saveUserKYC['numLanguages']					= 	$this->input->post('numLanguages');
			
			$saveUserKYC['professionalAssoc']				= 	$this->input->post('professionalAssoc');
			
			$saveUserKYC['numEmployees']					= 	$this->input->post('numEmployees');
			
			$saveUserKYC['idType']							= 	$this->input->post('idType');
			
			$saveUserKYC['ifIDothers']						= 	$this->input->post('ifIDothers');
			
			$saveUserKYC['idNumber']						= 	$this->input->post('idNumber');
			
			$saveUserKYC['utilityType']						= 	$this->input->post('utilityType');
			
			$saveUserKYC['ifUtilityothers']					= 	$this->input->post('ifUtilityothers');
			
			// its a new complaint
			$saveUserKYC['dateUploaded']					= 	date('Y-m-d H:i:s');
			
			
			//save other loan details
			
			$saveUserLoanApplication['userID'] 				= 	$user_id;
			
			$saveUserLoanApplication['loanTypeID'] 			= 	$data['loanType']['loanTypeID'];
			
			$saveUserLoanApplication['loanAmount'] 			= 	$this->input->post('loanAmount');
			
			$saveUserLoanApplication['loanTenure'] 			= 	$this->input->post('loanTenure');
			
			$saveUserLoanApplication['loanPurpose'] 		= 	$this->input->post('loanPurpose');
			
			$saveUserLoanApplication['businessImpact'] 		= 	$this->input->post('businessImpact');
			
			$saveUserLoanApplication['amountInvestedInBusiness']		=	$this->input->post('amountInvestedInBusiness');
			
			$saveUserLoanApplication['crcCreditScore']		=	'600';
			
			$saveUserLoanApplication['dateCreated']			= 	date('Y-m-d H:i:s');
			
			
			// save article
			$query 											= 	$this->facilitator_model->set_user_loan($savePersonalProfile, $saveBusinessProfile, $saveUserKYC, $saveUserLoanApplication);
			
			if($query['status'] == "Success")
			{
				$this->session->set_flashdata('message', $query['message']);
			
				//go back to the article list
				redirect(base_url().'msme/loans/');
			}
			else
			{
				$this->session->set_flashdata('error', $query['message']);
				
				redirect(base_url().'msme/loan-application/'.$page.'/');
			}		
						
			
		}
		
	}

	
	public function resetpassword($id=false,$token=false)
	{
		if(!empty($id) && !empty($token))
		{
			$data['title'] 		= 	"Reset Your Password :: 1Community";
			
			$data['id']			= 	$id;
			
			$data['token'] 		= 	$token;
			
			$table				= 	'user';
			
			//check if the token and id exist in the database
			$chck 				= 	$this->facilitator_model->check_token($id,$token, $table);
			
			if($chck)
			{
				// check if the token has expired
				if(time() <= strtotime($chck." + 1 day")){
					
					$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
					
					$this->form_validation->set_rules('new_pswd', 'New Password', 'trim|required|xss_clean|matches[conf_pswd]');
					
					$this->form_validation->set_rules('conf_pswd', 'Confirm New Password', 'trim|required|xss_clean');
					
					if ($this->form_validation->run() == FALSE)
					{
						
							$this->load->view('templates/header-login', $data);
							
							$this->load->view('msme/reset-password');
							
							$this->load->view('templates/footer-login');
							
					}else{
						
						$new_password 		= 	$this->input->post('new_pswd');
						
						$query 				= 	$this->facilitator_model->resetpassword($id, $new_password, $table);
						
						if($query)
						{
							$this->session->set_flashdata('success-message', 'Password Reset Successful.');
				
							redirect(base_url().'msme/account/login/');
							
						}else{
							
							$this->session->set_flashdata('error', 'An Error occured while trying to reset your password, please try again.');
							redirect(base_url().'msme/account/resetpassword/'.$id.'/'.$token.'/');
						}
					}
				
				}else{
					
					$this->session->set_flashdata('error', 'Your Password reset link has expired, Please request for another.');
				
					redirect(base_url().'msme/account/forgot-password/');
				}
				
			}else{
				
				show_404();
			}
			
		}else{
			
			show_404();
		}
	}
	
	public function get_country_state()
	{
		$country 			= 	$this->input->post('country_id');
		
		$drpdwn_state 		= 	$this->facilitator_model->get_country_states($country);
		
		echo '<option value="0">-- Select State--</option>';
		
		foreach($drpdwn_state as $state)
		{
		
			echo '<option value="'.$state['gc_state_id'].'"'; 
		
			echo set_select("state", $state['gc_state_id']); 
		
			echo '>'.ucfirst($state['state_name']).'</option>';
		
		}
		
	}
	
	public function get_state_lga()
	{
		$state 				= 	$this->input->post('state_id');
		
		$drpdwn_lga 		= 	$this->facilitator_model->get_country_states_lga($state);
				
		$totalVal			=	'<option value="0">-- Select LGA--</option>';
		
		foreach($drpdwn_lga as $lga)
		{
		
			$totalVal 		.=	'<option value="'.$lga['lga_id'].'"'; 
		
			$totalVal 		.=	set_select("lga", $lga['lga_id']); 
		
			$totalVal 		.=	'>'.ucfirst($lga['lga_name']).'</option>';
		
		}
		
		echo $totalVal;
		
	}
	
	
	public function logout()
	{
		$this->session->sess_destroy();
		//$this->index();
		redirect(base_url().'msme/account/');
	}	

	
	//this makes it easy to use the same code for initial generation of the form as well as javascript additions
	function replace_newline($string) 
	{
		
	  return trim((string)str_replace(array("\r", "\r\n", "\n", "\t"), ' ', $string));
	
	}

	
	function reference()
	{
		echo strtotime(date('Y-m-d h:i:s'));	
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
	
	
}
	

?>