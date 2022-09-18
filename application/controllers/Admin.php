<?php
class Admin extends CI_Controller 
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
		
		
		$this->load->model('membership_model');
		
		$this->load->model('analyze_model');
				
	}
	
	public function index()
	{
		
		$is_logged_in 	= 	$this->session->userdata('is_admin_logged_in');

		if(!empty($is_logged_in))
		{
		
			redirect('admin/login/');

		}
		else
		{

			redirect('admin/dashboard');
			
		}
		
		/*$this->session->sess_destroy();
		
		redirect('user/maintenance/');	*/
		
	}
	
	public function is_logged_in()
	{
		
		
		$is_logged_in 			=	$this->session->userdata('is_admin_logged_in');
		
		$user_id 				= 	$this->session->userdata('user_id');

		if(empty($is_logged_in) || empty($user_id))
		{

			//echo 'You don\'t have permission to access this page. <a href="index">Login</a>';	
			//die();

			redirect('admin/login/');

		}	
			
		/*$this->session->sess_destroy();
		
		redirect('user/maintenance/');	*/
	}
		
	public function login()
	{
		
		$data['title']			= 	"Login :: Admin";
		
		$this->load->view('admin/login', $data);

	}
	
	public function setup_failure()
	{
		
		$data['title']			= 	"Setup Credentials";
		
		$this->load->view('admin/setup-admin-failure', $data);

	}
	
	public function confirm_admin($id=false)
	{

		if(!empty($id))
		{
			$data['title'] 			= 	"Setup Credentials";
			
			$data['id']				= 	$id;
			
			//check if the token and id exist in the database
			$chck 					= 	$this->membership_model->check_confirm_admin_credentials($id);

			if($chck['status'] == 'Success')
			{
				
				if($chck['data'] == 'Login Successful')
				{
					//means this user has been logged in just redirect to dashboard
					
					redirect(base_url().'admin/dashboard/');
					
				}else{
						
					$data['email']		=	$chck['email'];
					
					//if success allow user to set up password and login into platform
					
					$this->load->view('admin/setup-admin-credentials', $data);
				
				}
				
			}else{
				
				//show_404();
				$this->session->set_flashdata('message', $chck['data']);
				
				redirect(base_url().'admin/setup-failure/');
				
			}
			
		}else{
			
			//show_404();
			
			$this->session->set_flashdata('message', 'Provide a token Key to complete setup or contact administrator to gain access to website.');
				
			redirect(base_url().'admin/setup-failure/');
			
		}
		
	}
	
	public function set_admin_credentials()
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
										
			$this->load->view('admin/setup-admin-credentials', $data);
			
		}
		else
		{		
		
		
			$username		= 	$this->input->post('username');
			
			$password		= 	$this->input->post('password');
			
			$query 			= 	$this->membership_model->set_admin_credentials($username, $password);
			
			if($query['status'] == 'Success') // if the user's credentials validated...
			{	
				
				redirect('admin/dashboard');
				
			}
			else // incorrect username or password
			{

				$this->session->set_flashdata('message', ''.$query['status'].': '.$query['message'].'');
		
				redirect(base_url().'admin/confirm-admin/');

			}
			
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

	public function forgot_password()
	{
		
		$data['title'] 				= 	"Forgot Password :: PIPA";
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"> <a class="close" data-dismiss="alert">×</a>', '</div>');
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_password_email_check_exist');
		
		if ($this->form_validation->run() == FALSE)
		{
						
			$this->load->view('admin/forgot-password', $data);
			
				
		}else{
			
			// load the security helper where the sha1 function is
			$this->load->helper('security');
			
			$table					= 	'user';
			
			$email 					= 	$this->input->post('email');
			
			$user_id 				= 	$this->membership_model->get_user_id_by_email($email, $table);
			
			$userdet				= 	$this->membership_model->get_user_details($user_id, $table);
			
			$name					= 	ucfirst($userdet['first_name']).' '.ucfirst($userdet['last_name']);
			
			$time 					= 	date('Y-m-d H:i:s');
			
			$tim  					= 	strtotime($time);
			
			$token 					= 	do_hash($email.$tim);
			
			$token_field			= 	'user_id';
			
			$url 					= 	'<a href="'.base_url().'admin/reset-password/'.$user_id.'/'.$token.'/">'.base_url().'admin/reset-password/'.$user_id.'/'.$token.'/</a>';
			
			$query 					= 	$this->membership_model->reset_password_email_token($token,$email,$time,$url,$user_id, $name);
			
			if($query)
			{
				
				$this->session->set_flashdata('success-message', 'An email has been sent to the address you provided, please check your inbox or spam to Reset Password.');
				
				redirect(base_url().'admin/forgot-password/');
				
			}else{
				// generate error	
				
				$this->session->set_flashdata('message', 'An error occured creating a reset link. Please try again.');
				
				redirect(base_url().'admin/forgot-password/');
				
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
			$chck 				= 	$this->membership_model->check_token($id,$token);
			
			if($chck['status'] == "Success")
			{
				// check if the token has expired
				if(time() <= strtotime($chck['message']." + 1 day")){
					
					$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
					
					$this->form_validation->set_rules('password', 'New Password', 'trim|required|matches[conf_password]');
					
					$this->form_validation->set_rules('conf_password', 'Confirm New Password', 'trim|required');
					
					if ($this->form_validation->run() == FALSE)
					{
						
						$this->load->view('admin/reset-password', $data);
							
					}else{
						
						$new_password 			= 	$this->input->post('password');
						
						$query 					= 	$this->membership_model->resetpassword($id, $new_password, $token);
						
						if($query)
						{
							
							$this->session->set_flashdata('success-message', 'Password Reset Successful.');
				
							redirect(base_url().'admin/login/');
							
						}else{
							
							$this->session->set_flashdata('message', 'An Error occured while trying to reset your password, please try again.');
							
							redirect(base_url().'admin/reset-password/'.$id.'/'.$token.'/');
						}
						
					}
				
				}else{
					
					$this->session->set_flashdata('message', 'Your Password reset link has expired, Please request for another.');
				
					redirect(base_url().'admin/forgot-password/');
				}
				
			}else{
				
				//show_404();
				
				$this->session->set_flashdata('message', $chck['message']);
				
				redirect(base_url().'admin/forgot-password/');
			}
			
		}else{
			
			show_404();
		}
		
	}
	
	// check if this email exist already for password reset
	public function password_email_check_exist($str)
	{
		
		$username_chck 			= 	$this->membership_model->check_email_exist($str, 'user');
		
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
	
	public function dashboard()
	{
			
		$this->is_logged_in();

		//$user_id = $this->session->userdata('user_id');
		$data['title'] 							=	"Dashboard :: PIPA";
		
		$data['menu_status']					=	'dashboard';
		
		$company_id								=	$this->session->userdata('company_id');
		
		$data['company_details']				=	$this->membership_model->get_company($company_id);
		
		if($company_id == '1')
		{
							
			$data['numPrograms']				=	$this->membership_model->get_program();
			
			$data['programs']					=	$this->membership_model->get_program('', '', $limit=10, $offset=0);
			
			$data['numClients']					=	$this->membership_model->get_clients();
			
			$data['numUsers']					=	$this->membership_model->get_users();
			
			$data['numProgramOwners']			=	$this->membership_model->get_program_owners();
			
			$data['numCoaches']					=	$this->membership_model->get_coach();
			
			$data['numFacilitators']			=	$this->membership_model->get_facilitator();
		
		}else{
			
			$data['numPrograms']				=	$this->membership_model->get_program('', $company_id);
			
			$data['programs']					=	$this->membership_model->get_program('', $company_id, $limit=10, $offset=0);
									
			$data['numProgramOwners']			=	$this->membership_model->get_program_owners('', $company_id);
			
			$data['numCoaches']					=	$this->membership_model->get_coach('', $company_id);
			
			$data['numFacilitators']			=	$this->membership_model->get_facilitator('', $company_id);
			
		}
		
		$this->load->view('admin/templates/header', $data);
		
		if($company_id == '1')
		{
			
			$this->load->view('admin/pipa-admin/dashboard');
		
		}else{
				
			$this->load->view('admin/dashboard');
		
		}
		
		$this->load->view('admin/templates/footer');

	}
	
	public function create_client($id=false)
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 								=	"Client :: PIPA";
		
		$data['menu_status']						=	'client';
				
		$data['client_id']							= 	$id;
		
		$data['client_type']						= 	'';
		
		$data['company_name']						= 	'';
		
		$data['contact_name']						= 	'';
		
		$data['contact_email']						= 	'';
		
		$data['contact_phone_number']				= 	'';
		
		$data['company_size_range']					= 	'';
		
		$data['client_activated']					= 	'';
		
		$data['date_activated']						=	'';	
		
		$company_id									=	$this->session->userdata('company_id');
				
		if($id)
		{
			
			$client									= 	$this->membership_model->get_clients($id);

			//if the brand does not exist, redirect them to the brands list with an error
			if(!$client)
			{
				$this->session->set_flashdata('error', 'The requested Client could not be found.');
				
				redirect(base_url().'admin/create-client/');
			
			}
			
			$data['client_id']							= 	$client['client_id'];
	
			$data['client_type']						= 	$client['client_type'];
		
			$data['company_name']						= 	$client['company_name'];
			
			$data['contact_name']						= 	$client['contact_name'];
			
			$data['contact_email']						= 	$client['contact_email'];
			
			$data['contact_phone_number']				= 	$client['contact_phone_number'];
			
			$data['company_size_range']					= 	$client['company_size_range'];
			
			$data['client_activated']					= 	$client['client_activated'];
				
			$data['date_activated']						=	$client['date_activated'];	
			
		}
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('company_name', 'Client Name', 'trim|required');
		
		if($this->form_validation->run() == FALSE)
		{
							
			$this->load->view('admin/templates/header', $data);
					
			$this->load->view('admin/client/create-client');
			
			$this->load->view('admin/templates/footer');
		
		}else{
			
			$slug 										= 	$this->input->post('company_name');
		
			$slug										= 	url_title(convert_accented_characters($slug), 'dash', TRUE);
								
			$save['client_id']							= 	$id;
	
			$save['company_name']						= 	$this->input->post('company_name');
			
			$save['company_name_slug']					= 	$slug;
			
			$save['client_type']						= 	$this->input->post('client_type');
		
			$save['company_name']						= 	$this->input->post('company_name');
			
			$save['contact_name']						= 	$this->input->post('contact_name');
			
			$save['contact_email']						= 	$this->input->post('contact_email');
			
			$save['contact_phone_number']				= 	$this->input->post('contact_phone_number');
			
			$save['company_size_range']					= 	$this->input->post('company_size_range');
			
			$save['client_activated']					= 	$this->input->post('client_activated');	

			if(!empty($id))
			{
				// if its an update
				$save['date_modified']			= 	date('Y-m-d H:i:s');
				
				$save['modified_by_id']      	= 	$this->session->userdata('user_id');
				
			}else{
				
				// its a new article
				$save['date_created']			= 	date('Y-m-d H:i:s');
				
				$save['created_by_id']          = 	$this->session->userdata('user_id');

			}
			
			if(!empty($save['client_activated']))
			{
				
				if($data['date_activated'] == '0000-00-00 00:00:00' || empty($data['date_activated']))
				{
					
					// if its an update
					$save['date_activated']			= 	date('Y-m-d H:i:s');
					
				}
				
			}
					
			// save company 
			$company							= 	$this->membership_model->save_client($save);
			
			if($company) // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('message', 'Client operation successful');
				
				redirect(base_url().'admin/create-client/'.$id.'/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', 'An error occured while performing Client operation, Try Again.');
				
				//go back to the brand list
				redirect(base_url().'admin/create-client/');
			
			}
					
		}

	}
	
	public function active_companies()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Company :: PIPA";
		
		$data['menu_status']				=	'company';
		
		$data['page_tab']					=	'active';
		
		$data['pending_companies']			= 	$this->membership_model->get_company('', 'Pending');
		
		$data['active_companies']			= 	$this->membership_model->get_company('', 'Active');
		
		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/company/active-company');
		
		$this->load->view('admin/templates/footer');

	}
	
	public function pending_companies()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Company :: PIPA";
		
		$data['menu_status']				=	'company';
		
		$data['page_tab']					=	'pending';
		
		$company_id							=	$this->session->userdata('company_id');
		
		$data['pending_companies']			= 	$this->membership_model->get_company('', 'Pending');
		
		$data['active_companies']			= 	$this->membership_model->get_company('', 'Active');
		
		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/company/active-company');
		
		$this->load->view('admin/templates/footer');

	}
	
	public function create_company($id=false)
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 								=	"Company :: PIPA";
		
		$data['menu_status']						=	'company';
		
		$data['company_id']							= 	$id;
		
		$data['client_id']							= 	'';
		
		$data['company_name']						= 	'';
		
		$data['industry_id']						= 	'';
		
		$data['company_address']					= 	'';
		
		$data['countries_of_operation']				= 	'';
		
		$data['number_of_employees']				= 	'';
		
		$data['company_logo']						= 	'';
		
		$data['company_color_theme']				= 	'';
		
		$data['company_status']						= 	'';
		
		
		$data['primary_contact_first_name']			= 	'';
			
		$data['primary_contact_last_name']			= 	'';
		
		$data['primary_contact_email']				= 	'';
		
		$data['primary_contact_phone_number']		= 	'';
		
		$data['primary_contact_role']				= 	'';
		
		
		$data['secondary_contact_first_name']		= 	'';
		
		$data['secondary_contact_last_name']		= 	'';
		
		$data['secondary_contact_email']			= 	'';
		
		$data['secondary_contact_phone_number']		= 	'';
		
		$data['secondary_contact_role']				= 	'';
		
		
		$company_id									=	$this->session->userdata('company_id');
		
		$data['clients']							=	$this->membership_model->get_clients();
		
		$data['industries']							=	$this->membership_model->select_industry();
		
		$data['countries']							= 	$this->membership_model->select_country();
				
		if($id)
		{
			
			$company								= 	$this->membership_model->get_company($id);

			//if the brand does not exist, redirect them to the brands list with an error
			if(!$company)
			{
				$this->session->set_flashdata('error', 'The requested Company could not be found.');
				
				redirect(base_url().'admin/create-company/');
			
			}
			
			$data['client_id']							= 	$company['company']['client_id'];
	
			$data['company_name']						= 	$company['company']['company_name'];
			
			$data['industry_id']						= 	$company['company']['industry_id'];
			
			$data['company_address']					= 	$company['company']['company_address'];
			
			$data['countries_of_operation']				= 	$company['company']['countries_of_operation'];
			
			$data['number_of_employees']				= 	$company['company']['number_of_employees'];
			
			$data['company_logo']						= 	$company['company']['company_logo'];
			
			$data['company_color_theme']				= 	$company['company']['company_color_theme'];
			
			$data['company_status']						= 	$company['company']['company_status'];
			
			if(!empty($company['primaryContact']))
			{
				
				$data['primary_contact_first_name']			= 	$company['primaryContact']['first_name'];
				
				$data['primary_contact_last_name']			= 	$company['primaryContact']['last_name'];
				
				$data['primary_contact_email']				= 	$company['primaryContact']['email'];
				
				$data['primary_contact_phone_number']		= 	$company['primaryContact']['phone_number'];
				
				$data['primary_contact_role']				= 	$company['primaryContact']['contact_role'];
			
			}
			
			if(!empty($company['secondaryContact']))
			{
				
				$data['secondary_contact_first_name']		= 	$company['secondaryContact']['first_name'];
				
				$data['secondary_contact_last_name']		= 	$company['secondaryContact']['last_name'];
				
				$data['secondary_contact_email']			= 	$company['secondaryContact']['email'];
				
				$data['secondary_contact_phone_number']		= 	$company['secondaryContact']['phone_number'];
				
				$data['secondary_contact_role']				= 	$company['secondaryContact']['contact_role'];
			
			}
			
		}
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
		
		if($this->form_validation->run() == FALSE)
		{
							
			$this->load->view('admin/templates/header', $data);
					
			$this->load->view('admin/company/create-company');
			
			$this->load->view('admin/templates/footer');
		
		}else{
			
			//get the user business certificate of incorporation
			if(isset($_FILES['company_logo_upl']['size']) && $_FILES['company_logo_upl']['size']>0)
			{
 
				$config['upload_path'] 			= 	'asset/images/company-logo/';
				
				$config['allowed_types'] 		= 	'jpg|jpeg|png';
				
				$config['encrypt_name'] 		= 	true;
				
				$config['remove_spaces'] 		= 	true;

				$this->load->library('upload', $config);
		
				if ( ! $this->upload->do_upload('company_logo_upl'))
				{
										
					$this->session->set_flashdata('error', 'Company logo: '.$this->upload->display_errors());
					
					//go back to the article list
					redirect(base_url().'admin/create-company/'.$id.'/');

				}
				else
				{
					
					$data 								= 	array('upload_data' => $this->upload->data());
					
					$save['company_logo'] 				= 	$data['upload_data']['file_name'];
					
				}

				
			
			}else{
				
				$save['company_logo']	    		= 	$this->input->post('companylogo_hldr');
					
			}
			
			$slug 										= 	$this->input->post('company_name');
		
			$slug										= 	url_title(convert_accented_characters($slug), 'dash', TRUE);
					
			$save['company_id']							= 	$id;
			
			$save['client_id']							= 	$this->input->post('client_id');
	
			$save['company_name']						= 	$this->input->post('company_name');
			
			$save['company_name_slug']					= 	$slug;
			
			$save['industry_id']						= 	$this->input->post('industry_id');
			
			$save['company_address']					= 	$this->input->post('company_address');
			
			$save['countries_of_operation']				= 	$this->input->post('countries_of_operation');
			
			$save['number_of_employees']				= 	$this->input->post('number_of_employees');
						
			$save['company_color_theme']				= 	$this->input->post('company_color_theme');
			
			$save['company_status']						= 	$this->input->post('company_status');
			
			
			$primaryContact['first_name']				= 	$this->input->post('primary_contact_first_name');
			
			$primaryContact['last_name']				= 	$this->input->post('primary_contact_last_name');
			
			$primaryContact['email']					= 	$this->input->post('primary_contact_email');
			
			$primaryContact['phone_number']				= 	$this->input->post('primary_contact_phone_number');
			
			$primaryContact['contact_role']				= 	$this->input->post('primary_contact_role');
			
			
			$secondaryContact['first_name']				= 	$this->input->post('secondary_contact_first_name');
			
			$secondaryContact['last_name']				= 	$this->input->post('secondary_contact_last_name');
			
			$secondaryContact['email']					= 	$this->input->post('secondary_contact_email');
			
			$secondaryContact['phone_number']			= 	$this->input->post('secondary_contact_phone_number');
			
			$secondaryContact['contact_role']			= 	$this->input->post('secondary_contact_role');
			
			if(!empty($id))
			{
				// if its an update
				$save['date_modified']			= 	date('Y-m-d H:i:s');
				
				$save['modified_by_id']      	= 	$this->session->userdata('user_id');
				
			}else{
				
				// its a new article
				$save['date_created']			= 	date('Y-m-d H:i:s');
				
				$save['created_by_id']          = 	$this->session->userdata('user_id');

			}
					
			// save company 
			$company							= 	$this->membership_model->save_company($save, $primaryContact, $secondaryContact);
			
			if($company) // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('message', 'Company operation successful');
				
				redirect(base_url().'admin/create-company/'.$id.'/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', 'An error occured while performing Company operation, Try Again.');
				
				//go back to the brand list
				redirect(base_url().'admin/create-company/');
			
			}
					
		}

	}
	
	public function active_corporate_admin()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Corporate Admin :: PIPA";
		
		$data['menu_status']				=	'corporate-admin';
		
		$data['page_tab']					=	'active';
		
		$company_id							=	$this->session->userdata('company_id');
		
		$data['pending_corporate_admins']	= 	$this->membership_model->get_corporate_admin('', $company_id, 'Pending');
		
		$data['active_corporate_admins']	= 	$this->membership_model->get_corporate_admin('', $company_id, 'Active');
		
		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/corporate-admin/active-corporate-admin');
		
		$this->load->view('admin/templates/footer');

	}
	
	public function pending_corporate_admin()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Corporate Admin :: PIPA";
		
		$data['menu_status']				=	'corporate-admin';
		
		$data['page_tab']					=	'pending';
		
		$company_id							=	$this->session->userdata('company_id');
		
		$data['pending_corporate_admins']	= 	$this->membership_model->get_corporate_admin('', $company_id, 'Pending');
		
		$data['active_corporate_admins']	= 	$this->membership_model->get_corporate_admin('', $company_id, 'Active');
		
		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/corporate-admin/active-corporate-admin');
		
		$this->load->view('admin/templates/footer');

	}
	
	public function create_corporate_admin($id=false)
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 								=	"Corporate Admin :: PIPA";
		
		$data['menu_status']						=	'corporate-admin';
		
		$data['user_id']							= 	$id;
		
		$data['company_id']							= 	'';
				
		$data['email']								= 	'';
		
		$data['phone_number']						= 	'';
		
		$data['first_name']							= 	'';
		
		$data['last_name']							= 	'';
		
		$data['admin_role']							= 	'';
		
		$data['is_admin_active']					= 	'';
				
		$data['companies']							=	$this->membership_model->get_company();
				
		if($id)
		{
			
			$user									= 	$this->membership_model->get_corporate_admin($id);

			//if the brand does not exist, redirect them to the brands list with an error
			if(!$user)
			{
				$this->session->set_flashdata('error', 'The requested Corporate Admin could not be found.');
				
				redirect(base_url().'admin/create-corporate-admin/');
			
			}
			
			$data['company_id']							= 	$user['user']['company_id'];
				
			$data['email']								= 	$user['user']['email'];
			
			$data['phone_number']						= 	$user['user']['phone_number'];
			
			$data['first_name']							= 	$user['user']['first_name'];
			
			$data['last_name']							= 	$user['user']['last_name'];
			
			$data['admin_role']							= 	$user['user']['admin_role'];
			
			$data['is_admin_active']					= 	$user['user']['is_admin_active'];
			
		}
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|callback_alpha_dash_space');
				
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[64]');
		
		$this->form_validation->set_rules('company_id', 'User Company', 'trim|required|callback_select_validate');
		
		if($this->form_validation->run() == FALSE)
		{
							
			$this->load->view('admin/templates/header', $data);
					
			$this->load->view('admin/corporate-admin/create-corporate-admin');
			
			$this->load->view('admin/templates/footer');
		
		}else{
			
			$save['user_id']							= 	$id;
			
			$save['company_id']							= 	$this->input->post('company_id');
				
			$save['email']								= 	$this->input->post('email');
			
			$save['phone_number']						= 	$this->input->post('phone_number');
			
			$save['first_name']							= 	$this->input->post('first_name');
			
			$save['last_name']							= 	$this->input->post('last_name');
			
			$save['admin_role']							= 	$this->input->post('admin_role');
			
			$save['is_admin_active']					= 	$this->input->post('is_admin_active');
			
			if(!empty($id))
			{
				// if its an update
				$save['date_modified']			= 	date('Y-m-d H:i:s');
				
				$save['modified_by_id']      	= 	$this->session->userdata('user_id');
				
			}else{
				
				// its a new article
				$save['date_created']			= 	date('Y-m-d H:i:s');
				
				$save['created_by_id']          = 	$this->session->userdata('user_id');

			}
					
			// save company 
			$user								= 	$this->membership_model->save_corporate_admin($save);
			
			if($user['status'] == 'Success') // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('message', $user['message']);
				
				redirect(base_url().'admin/create-corporate-admin/'.$id.'/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', $user['message']);
				
				//go back to the brand list
				redirect(base_url().'admin/create-corporate-admin/');
			
			}
					
		}

	}
	
	public function departments()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Departments :: PIPA";
		
		$data['menu_status']				=	'corporate-department';
		
		$company_id							=	$this->session->userdata('company_id');
		
		$data['companies']					=	$this->membership_model->get_company();
		
		$data['company_id']					= 	$company_id;
		
		if($company_id == '1')
		{
				
			$data['departments']			= 	$this->membership_model->get_departments();
		
		}else{
			
			$data['departments']			= 	$this->membership_model->get_departments('', $company_id);
			
		}
		
		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/department/department');
		
		$this->load->view('admin/templates/footer');

	}
	
	public function create_department($id=false)
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 								=	"Departments :: PIPA";
		
		$data['menu_status']						=	'corporate-department';
		
		$data['department_id']						= 	$id;
		
		$data['company_id']							= 	'';
		
		$data['department']							= 	'';

		$company_id									=	$this->session->userdata('company_id');
		
		$data['user_company']						=	$company_id;
		
		$data['companies']							=	$this->membership_model->get_company();
				
		if($id)
		{
		
			if($company_id == '1')
			{
					
				$department							= 	$this->membership_model->get_departments($id);
			
			}else{
				
				$department							= 	$this->membership_model->get_departments($id, $company_id);
				
			}

			//if the brand does not exist, redirect them to the brands list with an error
			if(!$department)
			{
				$this->session->set_flashdata('error', 'The requested Department could not be found.');
				
				redirect(base_url().'admin/create-department/');
			
			}
			
			$data['department_id']						= 	$id;
			
			$data['company_id']							= 	$department['company_id'];
			
			$data['department']							= 	$department['department'];

			
		}
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('department', 'Department', 'trim|required');
		
		$this->form_validation->set_rules('company_id', 'Company', 'trim|required|callback_select_validate');
		
		if($this->form_validation->run() == FALSE)
		{
							
			$this->load->view('admin/templates/header', $data);
					
			$this->load->view('admin/department/create-department');
			
			$this->load->view('admin/templates/footer');
		
		}else{
			
			
			$slug 										= 	$this->input->post('department');
		
			$slug										= 	url_title(convert_accented_characters($slug), 'dash', TRUE);
					
			$save['department_id']						= 	$id;
			
			$save['company_id']							= 	$this->input->post('company_id');
	
			$save['department']							= 	$this->input->post('department');
				
			$save['department_slug']					= 	$slug;

			if(!empty($id))
			{
				// if its an update
				$save['date_modified']			= 	date('Y-m-d H:i:s');
				
				$save['modified_by_id']      	= 	$this->session->userdata('user_id');
				
			}else{
				
				// its a new article
				$save['date_created']			= 	date('Y-m-d H:i:s');
				
				$save['created_by_id']          = 	$this->session->userdata('user_id');

			}
					
			// save company 
			$company							= 	$this->membership_model->save_department($save);
			
			if($company) // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('message', 'Department operation successful');
				
				redirect(base_url().'admin/create-department/'.$id.'/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', 'An error occured while performing Department operation, Try Again.');
				
				//go back to the brand list
				redirect(base_url().'admin/create-department/');
			
			}
					
		}

	}
	
	public function location()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Locations :: PIPA";
		
		$data['menu_status']				=	'corporate-location';
		
		$company_id							=	$this->session->userdata('company_id');
		
		$data['companies']					=	$this->membership_model->get_company();
		
		$data['company_id']					= 	$company_id;
		
		if($company_id == '1')
		{
				
			$data['locations']			= 	$this->membership_model->get_locations();
		
		}else{
			
			$data['locations']			= 	$this->membership_model->get_locations('', $company_id);
			
		}
		
		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/location/location');
		
		$this->load->view('admin/templates/footer');

	}
	
	public function create_location($id=false)
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 								=	"Locations :: PIPA";
		
		$data['menu_status']						=	'corporate-location';
		
		$data['location_id']						= 	$id;
		
		$data['location']							= 	'';

		$data['state_id']							= 	'';
		
		$data['is_head_office']						= 	'';
			
		$data['company_id']							= 	'';
		
		$company_id									=	$this->session->userdata('company_id');
		
		$data['user_company']						=	$company_id;
		
		$data['companies']							=	$this->membership_model->get_company();
		
		$country									=	'156';
		
		$data['states'] 							= 	$this->membership_model->get_country_states($country);
				
		if($id)
		{
		
			if($company_id == '1')
			{
					
				$location							= 	$this->membership_model->get_locations($id);
			
			}else{
				
				$location							= 	$this->membership_model->get_locations($id, $company_id);
				
			}

			//if the brand does not exist, redirect them to the brands list with an error
			if(!$location)
			{
				$this->session->set_flashdata('error', 'The requested Location could not be found.');
				
				redirect(base_url().'admin/create-location/');
			
			}
			
			$data['location_id']						= 	$id;
			
			$data['company_id']							= 	$location['company_id'];
			
			$data['location']							= 	$location['location'];

			$data['state_id']							= 	$location['state_id'];
			
			$data['is_head_office']						= 	$location['is_head_office'];
			
		}
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('location', 'Department', 'trim|required');
		
		$this->form_validation->set_rules('company_id', 'Company', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('state_id', 'State', 'trim|required|callback_select_validate');
		
		if($this->form_validation->run() == FALSE)
		{
							
			$this->load->view('admin/templates/header', $data);
					
			$this->load->view('admin/location/create-location');
			
			$this->load->view('admin/templates/footer');
		
		}else{
				
			$save['location_id']						= 	$id;
			
			$save['company_id']							= 	$this->input->post('company_id');
	
			$save['location']							= 	$this->input->post('location');
				
			$save['state_id']							= 	$this->input->post('state_id');
			
			$save['is_head_office']						= 	$this->input->post('is_head_office');

			if(!empty($id))
			{
				// if its an update
				$save['date_modified']			= 	date('Y-m-d H:i:s');
				
				$save['modified_by_id']      	= 	$this->session->userdata('user_id');
				
			}else{
				
				// its a new article
				$save['date_created']			= 	date('Y-m-d H:i:s');
				
				$save['created_by_id']          = 	$this->session->userdata('user_id');

			}
					
			// save company 
			$companyLocation							= 	$this->membership_model->save_location($save);
			
			if($companyLocation) // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('message', 'Location operation successful');
				
				redirect(base_url().'admin/create-location/'.$id.'/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', 'An error occured while performing Location operation, Try Again.');
				
				//go back to the brand list
				redirect(base_url().'admin/create-location/');
			
			}
					
		}

	}
	
	public function grades()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Grades :: PIPA";
		
		$data['menu_status']				=	'corporate-grades';
		
		$company_id							=	$this->session->userdata('company_id');
		
		$data['companies']					=	$this->membership_model->get_company();
		
		$data['company_id']					= 	$company_id;
		
		if($company_id == '1')
		{
				
			$data['grades']					= 	$this->membership_model->get_grades();
		
		}else{
			
			$data['grades']					= 	$this->membership_model->get_grades('', $company_id);
			
		}
		
		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/grades/grades');
		
		$this->load->view('admin/templates/footer');

	}
	
	public function create_grades($id=false)
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 								=	"Grades :: PIPA";
		
		$data['menu_status']						=	'corporate-grades';
		
		$data['grade_id']							= 	$id;
		
		$data['company_id']							= 	'';
		
		$data['grade']								= 	'';
		
		$data['grade_level']						= 	'';

		$company_id									=	$this->session->userdata('company_id');
		
		$data['user_company']						=	$company_id;
		
		$data['companies']							=	$this->membership_model->get_company();
				
		if($id)
		{
		
			if($company_id == '1')
			{
					
				$grade								= 	$this->membership_model->get_grades($id);
			
			}else{
				
				$grade								= 	$this->membership_model->get_grades($id, $company_id);
				
			}

			//if the brand does not exist, redirect them to the brands list with an error
			if(!$grade)
			{
				$this->session->set_flashdata('error', 'The requested Grades could not be found.');
				
				redirect(base_url().'admin/create-grades/');
			
			}
			
			$data['grade_id']						= 	$id;
			
			$data['company_id']						= 	$grade['company_id'];
			
			$data['grade']							= 	$grade['grade'];
			
			$data['grade_level']					= 	$grade['grade_level'];
			
		}
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('grade', 'Grade', 'trim|required');
		
		$this->form_validation->set_rules('company_id', 'Company', 'trim|required|callback_select_validate');
		
		if($this->form_validation->run() == FALSE)
		{
							
			$this->load->view('admin/templates/header', $data);
					
			$this->load->view('admin/grades/create-grades');
			
			$this->load->view('admin/templates/footer');
		
		}else{
			
			
			$slug 										= 	$this->input->post('grade');
		
			$slug										= 	url_title(convert_accented_characters($slug), 'dash', TRUE);
					
			$save['grade_id']							= 	$id;
			
			$save['company_id']							= 	$this->input->post('company_id');
	
			$save['grade']								= 	$this->input->post('grade');
			
			$save['grade_level']						= 	$this->input->post('grade_level');
				
			$save['grade_slug']							= 	$slug;

			if(!empty($id))
			{
				// if its an update
				$save['date_modified']			= 	date('Y-m-d H:i:s');
				
				$save['modified_by_id']      	= 	$this->session->userdata('user_id');
				
			}else{
				
				// its a new article
				$save['date_created']			= 	date('Y-m-d H:i:s');
				
				$save['created_by_id']          = 	$this->session->userdata('user_id');

			}
					
			// save company 
			$gradeOperation							= 	$this->membership_model->save_grade($save);
			
			if($gradeOperation) // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('message', 'Grade operation successful');
				
				redirect(base_url().'admin/create-grades/'.$id.'/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', 'An error occured while performing Grade operation, Try Again.');
				
				//go back to the brand list
				redirect(base_url().'admin/create-grades/');
			
			}
					
		}

	}
	
	public function create_program($id=false)
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Program :: PIPA";
		
		$data['menu_status']				=	'programs';
		
		$data['program_id']					= 	'';
		
		$data['program_name']				= 	'';
		
		$data['grade_id']					= 	array();
		
		$data['objectives']					= 	'';
		
		$data['success_measure']			= 	'';
		
		$data['start_date']					= 	'';
		
		$data['end_date']					= 	'';
		
		$data['program_status']				= 	'';
		
		$data['program_launched']			= 	'';
		
		$data['company_id']					= 	'';
		
		$company_id							=	$this->session->userdata('company_id');
		
		$data['user_company']				=	$company_id;
		
		if($company_id == '1')
		{
			
			$data['grades']					=	'';
			
		}else{
			
			$data['grades']					=	$this->membership_model->get_company_grades($company_id);
		
		}
		
		$data['companies']					=	$this->membership_model->get_company();
				
		if($id)
		{
			if($company_id == '1')
			{
								
				$program_det				= 	$this->membership_model->get_program($id);
			
			}else{
				
				$program_det				= 	$this->membership_model->get_program($id, $company_id);
				
			}
			
			//if the brand does not exist, redirect them to the brands list with an error
			if (!$program_det)
			{
				$this->session->set_flashdata('error', 'The requested Program could not be found.');
				
				redirect(base_url().'admin/create-program/');
				
			}
			
			$program							=	$program_det['program'];
			
			//set values to db values
			
			$data['program_id']					= 	$id;
			
			$data['program_name']				= 	$program['program_name'];
			
			$data['company_id']					= 	$program['company_id'];
			
			//now fetch the grades that belong to the company of this program
			if($company_id == '1')
			{
				
				$data['grades']					=	$this->membership_model->get_company_grades($data['company_id']);
				
			}
		
			if(!empty($program['grade_id']))
			{
				
				$data['grade_id']					= 	explode(',', $program['grade_id']);
			
			}
			
			
			$data['objectives']					= 	$program['objectives'];
			
			$data['success_measure']			= 	$program['success_measure'];
			
			
			if($program['start_date'] == '0000-00-00 00:00:00')
			{
				
			}else{
				
				$data['start_date']					= 	date('Y-m-d',strtotime($program['start_date']));
			
			}
			
			if($data['end_date'] == '0000-00-00 00:00:00')
			{
				
			}else{
				
				$data['end_date']					= 	date('Y-m-d',strtotime($program['end_date']));
			
			}
			
			$data['program_status']				= 	$program['program_status'];
		
			$data['program_launched']			= 	$program['program_launched'];
			
		}
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('program_name', 'Program Name', 'trim|required');
		
		if($this->form_validation->run() == FALSE)
		{
							
			$this->load->view('admin/templates/header', $data);
					
			$this->load->view('admin/programs/create-program');
			
			$this->load->view('admin/templates/footer');
		
		}else{
			
			$slug 								= 	$this->input->post('program_name');
		
			$slug								= 	url_title(convert_accented_characters($slug), 'dash', TRUE);
		
			$save['program_id']					= 	$id;
			
			$save['company_id']					= 	$this->input->post('company_id');
			
			$save['program_name']				= 	$this->input->post('program_name');
			
			$save['program_name_slug']			= 	$slug;
			
			$save['grade_id']					= 	implode(', ', $this->input->post('grade_id'));
			
			$save['objectives']					= 	$this->input->post('objectives');
			
			$save['success_measure']			= 	$this->input->post('success_measure');
			
			$save['start_date']					= 	$this->input->post('start_date');
			
			$save['end_date']					= 	$this->input->post('end_date');
			
			$save['program_status']				= 	$this->input->post('program_status');
		
			if(!empty($data['program_launched']))
			{
				
			}else{
				
				$save['program_launched']		= 	$this->input->post('program_launched');
			
			}
			
			if(!empty($id))
			{
				// if its an update
				$save['date_modified']			= 	date('Y-m-d H:i:s');
				
				$save['modified_by_id']      	= 	$this->session->userdata('user_id');
				
			}else{
				
				// its a new article
				$save['date_created']			= 	date('Y-m-d H:i:s');
				
				$save['created_by_id']          = 	$this->session->userdata('user_id');

			}
				
			// save brand 
			$program_id							= 	$this->membership_model->save_program($save);
			
			if(!empty($program_id)) // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('message', 'Program operation successful');
				
				redirect(base_url().'admin/program-owner/'.$program_id.'/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', 'An error occured while performing Program operation, Try Again.');
				
				//go back to the brand list
				redirect(base_url().'admin/create-program/');
			
			}
					
		}

	}
	
	public function fetch_company_grades()
	{
		
		$company_id 			= 	$this->input->post('company_id');
		
		$grades 				= 	$this->membership_model->get_company_grades($company_id);
		
		foreach($grades as $company_grades)
		{
			
			echo '<option value="'.$company_grades['grade_id'].'">'.$company_grades['grade'].'</option>';
				
		}
		
	}
	
	public function program_owner($id)
	{
		
		$this->is_logged_in();
		
		if(!empty($id))
		{
			
			//$user_id = $this->session->userdata('user_id');
			$data['title'] 							=	"Program :: PIPA";
			
			$data['menu_status']					=	'programs';
			
			$data['program_id']						= 	$id;
			
			$data['owner_id']						=	array();
			
			$company_id								=	$this->session->userdata('company_id');
			
			$userID									=	$this->session->userdata('user_id');
			
			//first check if this user is already in the program table for this company
			$data['curr_ownerID']					=	$this->membership_model->check_current_user_as_program_owner($userID, $company_id);
			
			$data['owners']							=	$this->membership_model->get_owner('', $company_id);
								
			if($id)
			{	
				
				if($company_id == '1')
				{
									
					$program						= 	$this->membership_model->get_program($id);
				
				}else{
					
					$program						= 	$this->membership_model->get_program($id, $company_id);
					
				}
				
				//if the brand does not exist, redirect them to the brands list with an error
				if (!$program)
				{
					$this->session->set_flashdata('error', 'The requested Program could not be found.');
					
					redirect(base_url().'admin/create-program/');
					
				}

				if(!empty($program['program_owner']))
				{
					
					$data['owner_id']				=	$program['program_owner'];
					
				}
				
			}
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
			
			$this->form_validation->set_rules('owner_id[]', 'Program Owner', 'trim|required');
			
			if($this->form_validation->run() == FALSE)
			{
								
				$this->load->view('admin/templates/header', $data);
						
				$this->load->view('admin/programs/program-owner');
				
				$this->load->view('admin/templates/footer');
			
			}else{
				
				$save['program_id']				=	$id;
				
				$save['company_id']				=	$company_id;
				
				$save['owner_id']				= 	implode(', ', $this->input->post('owner_id'));
				
				$query							=	$this->membership_model->save_program_owner($save);
				
				if($query) // if the user's credentials validated...
				{	
			
					
					$this->session->set_flashdata('message', 'Program operation successful');
					
					redirect(base_url().'admin/program-survey/'.$id.'/');
					
				}
				else 
				{
	
					$this->session->set_flashdata('error', 'An error occured while performing Program operation, Try Again.');
					
					//go back to the brand list
					redirect(base_url().'admin/program-owner/'.$id.'/');
				
				}
			
			}
		
		}else{
		
			show_404();
			
		}

	}
	
	public function create_program_owner($id, $ownerID=false)
	{
		
		$this->is_logged_in();
		
		if(!empty($id))
		{
			
			//$user_id = $this->session->userdata('user_id');
			$data['title'] 						=	"Program :: PIPA";
			
			$data['menu_status']				=	'programs';
			
			$data['program_id']					= 	$id;
						
			$data['first_name']					= 	'';
			
			$data['last_name']					= 	'';
			
			$data['email']						= 	'';
			
			$data['phone_number']				= 	'';
			
			$company_id							=	$this->session->userdata('company_id');
			
			$userID								=	$this->session->userdata('user_id');
			
			$data['programs']					=	$this->membership_model->get_program('', $company_id);
			
						
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
			
			$this->form_validation->set_rules('first_name', 'Owner First Name', 'trim|required');
			
			$this->form_validation->set_rules('last_name', 'Owner Last Name', 'trim|required');
			
			$this->form_validation->set_rules('email', 'Owner Email', 'trim|required|valid_email|callback_owner_email_check');
			
			$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|max_length[32]');
			
			if($this->form_validation->run() == FALSE)
			{
								
				$this->load->view('admin/templates/header', $data);
						
				$this->load->view('admin/programs/create-program-owner');
				
				$this->load->view('admin/templates/footer');
			
			}else{
				
				$save['first_name']					= 	$this->input->post('first_name');
				
				$save['last_name']					= 	$this->input->post('last_name');
				
				$save['email']						= 	$this->input->post('email');
				
				$save['phone_number']				= 	$this->input->post('phone_number');
				
				$save['company_id']					= 	$company_id;
				
				if(!empty($ownerID))
				{
					
					$save['modified_by_id']      	= 	$userID;
					
				}else{
					
					$save['created_by_id']          = 	$userID;
	
				}
							
				// save brand 
				$query								= 	$this->membership_model->save_owner($save);
				
				if($query) // if the user's credentials validated...
				{					
					
					$this->session->set_flashdata('message', 'Program operation successful');
					
					redirect(base_url().'admin/program-owner/'.$id.'/');
					
				}
				else 
				{
	
					$this->session->set_flashdata('error', 'An error occured while performing Program operation, Try Again.');
					
					//go back to the brand list
					redirect(base_url().'admin/create-program-owner/'.$id.'/');
				
				}
						
			}
		
		}else{
		
			show_404();
			
		}

	}
	
	public function program_survey($id)
	{
		
		$this->is_logged_in();
		
		if(!empty($id))
		{
			
			//$user_id = $this->session->userdata('user_id');
			$data['title'] 							=	"Program :: PIPA";
			
			$data['menu_status']					=	'programs';
			
			$data['program_id']						= 	$id;
						
			$company_id								=	$this->session->userdata('company_id');
								
			if($id)
			{	
				if($company_id == '1')
				{
									
					$program						= 	$this->membership_model->get_program($id);
				
				}else{
					
					$program						= 	$this->membership_model->get_program($id, $company_id);
					
				}
				
				//if the brand does not exist, redirect them to the brands list with an error
				if (!$program)
				{
					$this->session->set_flashdata('error', 'The requested Program could not be found.');
					
					redirect(base_url().'admin/create-program/');
					
				}

			}
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
			
			$this->form_validation->set_rules('owner_id[]', 'Program Owner', 'trim|required');
			
			if($this->form_validation->run() == FALSE)
			{
								
				$this->load->view('admin/templates/header', $data);
						
				$this->load->view('admin/programs/program-survey');
				
				$this->load->view('admin/templates/footer');
			
			}else{
				
				
				$this->load->view('admin/templates/header', $data);
						
				$this->load->view('admin/programs/program-survey');
				
				$this->load->view('admin/templates/footer');
				
				/*$save['program_id']				=	$id;
				
				$save['owner_id']				= 	implode(', ', $this->input->post('owner_id'));
				
				$query							=	$this->membership_model->save_program_owner($save);
				
				if($query) // if the user's credentials validated...
				{	
			
					
					$this->session->set_flashdata('message', 'Program operation successful');
					
					redirect(base_url().'admin/program-survey/'.$id.'/');
					
				}
				else 
				{
	
					$this->session->set_flashdata('error', 'An error occured while performing Program operation, Try Again.');
					
					//go back to the brand list
					redirect(base_url().'admin/program-owner/'.$id.'/');
				
				}*/
			
			}
		
		}else{
		
			show_404();
			
		}

	}
	
	public function program_complete($id)
	{
		
		$this->is_logged_in();
		
		if(!empty($id))
		{
			
			//$user_id = $this->session->userdata('user_id');
			$data['title'] 							=	"Program :: PIPA";
			
			$data['menu_status']					=	'programs';
			
			$data['program_id']						= 	$id;
						
			$company_id								=	$this->session->userdata('company_id');
								
			if($id)
			{	
			
				if($company_id == '1')
				{
									
					$program						= 	$this->membership_model->get_program($id);
				
				}else{
					
					$program						= 	$this->membership_model->get_program($id, $company_id);
					
				}
				
				//if the brand does not exist, redirect them to the brands list with an error
				if (!$program)
				{
					$this->session->set_flashdata('error', 'The requested Program could not be found.');
					
					redirect(base_url().'admin/create-program/');
					
				}

			}
			
			$this->load->view('admin/templates/header', $data);
						
			$this->load->view('admin/programs/program-complete');
			
			$this->load->view('admin/templates/footer');
		
		}else{
		
			show_404();
			
		}

	}
	
	public function leadership_assessment($id)
	{
		
		$this->is_logged_in();
		
		if(!empty($id))
		{
			
			//$user_id = $this->session->userdata('user_id');
			$data['title'] 							=	"Program :: PIPA";
			
			$data['menu_status']					=	'programs';
			
			$data['program_id']						= 	$id;
			
			$program_det							= 	$this->membership_model->get_program($id);
			
			if(!empty($program_det['program']))
			{
				
				$company_id							=	$program_det['program']['company_id'];
				
			}else{
				
				show_404();	
			}
						
			
			$data['company_id']						=	$company_id;
			
			$survey_schedule_id						=	'';
			
			$data['frequency']						=	'';
			
			$data['start_date']						=	'';
			
			$data['end_date']						=	'';
			
			$data['survey_id']						=	'';
			
			$data['survey']							=	'';
			
			$data['participant']					=	'';
						
			//check if a session exist just for competency ref so we can use it to update the survey id in survey competency question
			
			$data['welcomeEmail']					=	$this->membership_model->get_message_template(1);
			
			$data['reminderEmail']					=	$this->membership_model->get_message_template(2);;
			
			$data['thankYouEmail']					=	$this->membership_model->get_message_template(3);
			
			$data['welcomeEmailSelf']				=	$this->membership_model->get_message_template(7);
								
			if($id)
			{	


				$assessment							= 	$this->membership_model->get_survey_type($id, '360 assessment', $company_id);

				
				if(!empty($assessment))
				{
					
					$data['survey_id']						=	$assessment['survey']['survey_id'];
					
					$data['survey']							=	$assessment['survey']['survey'];
					
					$survey_communication					=	$assessment['communication'];
					
					$getWelcomeEmail						=	$this->in_multiarray('Welcome Email', $survey_communication, 'subject');
					
					$getWelcomeEmailSelf					=	$this->in_multiarray('Welcome Email Self Participant', $survey_communication, 'subject');
					
					$getReminderEmail						=	$this->in_multiarray('Reminder Email', $survey_communication, 'subject');
					
					$getThankYouEmail						=	$this->in_multiarray('Thank you Email', $survey_communication, 'subject');
					
					$data['welcomeEmail']['content']		=	$getWelcomeEmail[0]['content'];
			
					$data['reminderEmail']['content']		=	$getReminderEmail[0]['content'];
					
					$data['thankYouEmail']['content']		=	$getThankYouEmail[0]['content'];
					
					$data['welcomeEmailSelf']['content']	=	$getWelcomeEmailSelf[0]['content'];
					
					
					$survey_schedule_id					=	$assessment['schedule']['survey_schedule_id'];
						
					$data['frequency']					=	$assessment['schedule']['frequency'];
			
					if($assessment['schedule']['start_date'] == '0000-00-00 00:00:00')
					{
						
						$data['start_date']				=	'';
					
					}else{
						
						$data['start_date']				=	$assessment['schedule']['start_date'];
					}
			
					if($assessment['schedule']['end_date'] == '0000-00-00 00:00:00')
					{
						
						$data['end_date']				=	'';
					
					}else{
						
						$data['end_date']				=	$assessment['schedule']['end_date'];
					}

				}else{
					
					
				}

			}
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
			
			$this->form_validation->set_rules('survey', 'Survey Name', 'trim|required');
			
			if($this->form_validation->run() == FALSE)
			{
								
				$this->load->view('admin/templates/header', $data);
						
				$this->load->view('admin/programs/leadership-assessment');
				
				$this->load->view('admin/templates/footer');
			
			}else{
				
				$save['program_id']						=	$id;
				
				$save['survey_id']						=	$data['survey_id'];
				
				$save['company_id']						=	$company_id;
				
				$save['survey_type']					=	'360 assessment';
				
				$save['survey']							=	$this->input->post('survey');
				
				$slug 									= 	$this->input->post('survey');
		
				$slug									= 	url_title(convert_accented_characters($slug), 'dash', TRUE);
				
				$save['survey_slug']					=	$slug;
				
				$save['created_by_id']					=	$this->session->userdata('user_id');
				
				
				//for welcome Email
				$communication[0]['company_id']			=	$company_id;
				
				$communication[0]['program_id']			=	$id;
				
				$communication[0]['communication_type']	=	'Email';
				
				$communication[0]['subject']			=	'Welcome Email';
				
				$communication[0]['content']			=	$this->input->post('welcomeEmail');
				
				$communication[0]['created_by_id']		=	$this->session->userdata('user_id');
				
				
				//for Reminder Email
				$communication[1]['company_id']			=	$company_id;
				
				$communication[1]['program_id']			=	$id;
				
				$communication[1]['communication_type']	=	'Email';
				
				$communication[1]['subject']			=	'Reminder Email';
				
				$communication[1]['content']			=	$this->input->post('reminderEmail');
				
				$communication[1]['created_by_id']		=	$this->session->userdata('user_id');
				
				
				//for Thank you Email
				$communication[2]['company_id']			=	$company_id;
				
				$communication[2]['program_id']			=	$id;
				
				$communication[2]['communication_type']	=	'Email';
				
				$communication[2]['subject']			=	'Thank you Email';
				
				$communication[2]['content']			=	$this->input->post('thankYouEmail');
				
				$communication[2]['created_by_id']		=	$this->session->userdata('user_id');
				
				
				//for welcome Email for the self evaluation
				$communication[3]['company_id']			=	$company_id;
				
				$communication[3]['program_id']			=	$id;
				
				$communication[3]['communication_type']	=	'Email';
				
				$communication[3]['subject']			=	'Welcome Email Self Participant';
				
				$communication[3]['content']			=	$this->input->post('welcomeEmailSelf');;
				
				$communication[3]['created_by_id']		=	$this->session->userdata('user_id');
				
				
				$schedule['survey_schedule_id']			=	$survey_schedule_id;
				
				$schedule['company_id']					=	$company_id;
				
				$schedule['program_id']					=	$id;
				
				$schedule['frequency']					=	$this->input->post('frequency');
			
				$schedule['start_date']					=	$this->input->post('start_date');
				
				$schedule['end_date']					=	$this->input->post('end_date');
				
				$schedule['created_by_id']				=	$this->session->userdata('user_id');
				
				$participant							=	$this->input->post('participant');
								
				$query									=	$this->membership_model->save_leadership_assessment($save, $communication, $schedule, $participant);
				
				if($query) // if the user's credentials validated...
				{	
					
					$this->session->set_flashdata('message', 'Program operation successful');
					
					redirect(base_url().'admin/program-survey/'.$id.'/');
					
				}
				else 
				{
					
					$this->session->set_flashdata('error', 'An error occured while performing Program operation, Try Again.');
					
					//go back to the brand list
					redirect(base_url().'admin/leadership-assessment/'.$id.'/');
				
				}
			
			}
		
		}else{
		
			show_404();
			
		}

	}
	
	public function upload_participant($id)
	{
		$response									=	array();
				
		if(!empty($id))
		{

			$ref									=	strtotime(date('Y-m-d H:i:s'));
			
			$program_det							= 	$this->membership_model->get_program($id);
			
			$company_id								=	$program_det['program']['company_id'];
			
			$created_by_id							=	$this->session->userdata('user_id');
			
			if(isset($_FILES['participants']["name"]))
			{

				$fileExt 							= 	pathinfo($_FILES['participants']["name"], PATHINFO_EXTENSION);
				
				if($fileExt == 'xlsx' || $fileExt == 'xls')
				{
				
					$this->load->library('excel');
					
					$path 								= 	$_FILES['participants']["tmp_name"];
				
					$object 							= 	PHPExcel_IOFactory::load($path);
				
					foreach($object->getWorksheetIterator() as $worksheet)
					{
						
						$highestRow 					= 	$worksheet->getHighestRow();
					
						$highestColumn 					= 	$worksheet->getHighestColumn();
					
						for($row=2; $row<=$highestRow; $row++)
						{
							
							$department 						= 	$worksheet->getCellByColumnAndRow(0, $row)->getValue();
						
							$location 							= 	$worksheet->getCellByColumnAndRow(1, $row)->getValue();
						
							$grade 								= 	$worksheet->getCellByColumnAndRow(2, $row)->getValue();
						
							$date_of_birth 						= 	$worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
						
							$gender 							= 	$worksheet->getCellByColumnAndRow(4, $row)->getValue();
							
							$employment_date 					= 	$worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue();
							
							$status 							= 	$worksheet->getCellByColumnAndRow(6, $row)->getValue();
							
							$employee_number 					= 	$worksheet->getCellByColumnAndRow(7, $row)->getValue();
							
							$first_name							= 	$worksheet->getCellByColumnAndRow(8, $row)->getValue();
							
							$last_name 							= 	$worksheet->getCellByColumnAndRow(9, $row)->getValue();
							
							$email 								= 	$worksheet->getCellByColumnAndRow(10, $row)->getValue();
							
							$phone_number 						= 	$worksheet->getCellByColumnAndRow(11, $row)->getValue();
							
							$line_manager_employee_number 		= 	$worksheet->getCellByColumnAndRow(12, $row)->getValue();
							
							$line_manager_name					=	$worksheet->getCellByColumnAndRow(13, $row)->getValue();
							
							$line_manager_email					=	$worksheet->getCellByColumnAndRow(14, $row)->getValue();
							
							$line_manager_phone_number			=	$worksheet->getCellByColumnAndRow(15, $row)->getValue();
							
							$peer_1_employee_number				=	$worksheet->getCellByColumnAndRow(16, $row)->getValue();
							
							$peer_1_name						=	$worksheet->getCellByColumnAndRow(17, $row)->getValue();
							
							$peer_1_email						=	$worksheet->getCellByColumnAndRow(18, $row)->getValue();
							
							$peer_1_phone_number				=	$worksheet->getCellByColumnAndRow(19, $row)->getValue();
							
							$peer_2_employee_number				=	$worksheet->getCellByColumnAndRow(20, $row)->getValue();
							
							$peer_2_name						=	$worksheet->getCellByColumnAndRow(21, $row)->getValue();
							
							$peer_2_email						=	$worksheet->getCellByColumnAndRow(22, $row)->getValue();
							
							$peer_2_phone_number				=	$worksheet->getCellByColumnAndRow(23, $row)->getValue();
							
							$direct_report_1_employee_number	=	$worksheet->getCellByColumnAndRow(24, $row)->getValue();
							
							$direct_report_1_name				=	$worksheet->getCellByColumnAndRow(25, $row)->getValue();
							
							$direct_report_1_email				=	$worksheet->getCellByColumnAndRow(26, $row)->getValue();
							
							$direct_report_1_phone_number		=	$worksheet->getCellByColumnAndRow(27, $row)->getValue();
							
							$direct_report_2_employee_number	=	$worksheet->getCellByColumnAndRow(28, $row)->getValue();
							
							$direct_report_2_name				=	$worksheet->getCellByColumnAndRow(29, $row)->getValue();
							
							$direct_report_2_email				=	$worksheet->getCellByColumnAndRow(30, $row)->getValue();
							
							$direct_report_2_phone_number		=	$worksheet->getCellByColumnAndRow(31, $row)->getValue();
							
							$direct_report_3_employee_number	=	$worksheet->getCellByColumnAndRow(32, $row)->getValue();
							
							$direct_report_3_name				=	$worksheet->getCellByColumnAndRow(33, $row)->getValue();
							
							$direct_report_3_email				=	$worksheet->getCellByColumnAndRow(34, $row)->getValue();
							
							$direct_report_3_phone_number		=	$worksheet->getCellByColumnAndRow(35, $row)->getValue();
						
							$participant[] 						= 	array(
								
								'company_id'  					=> 	$company_id,
								
								'created_by_id'  				=> 	$created_by_id,
								
								'upload_ref'  					=> 	$ref,
								
								'program_id'  					=> 	$id,
																
								'department'  					=> 	$department,
								
								'location'   					=> 	$location,
								
								'grade'    						=> 	$grade,
								
								'date_of_birth'  				=> 	date('Y-m-d',strtotime($date_of_birth)),
								//'date_of_birth'  				=> 	$date_of_birth,
								
								'gender'   						=> 	$gender,
								
								//'employment_date'				=>	$employment_date,
								
								'employment_date'				=>	date('Y-m-d',strtotime($employment_date)),
								
								'status'						=>	$status,
								
								'employee_number'				=>	$employee_number,
								
								'first_name'					=>	$first_name,
								
								'last_name'						=>	$last_name,
								
								'email'							=>	$email,
								
								'phone_number'					=>	$phone_number,
								
								'line_manager_employee_number'	=>	$line_manager_employee_number,
								
								'line_manager_name'				=>	$line_manager_name,
															
								'line_manager_email'			=>	$line_manager_email,
							
								'line_manager_phone_number'		=>	$line_manager_phone_number,
							
								'peer_1_employee_number'		=>	$peer_1_employee_number,	
							
								'peer_1_name'					=>	$peer_1_name,
							
								'peer_1_email'					=>	$peer_1_email,
							
								'peer_1_phone_number'			=>	$peer_1_phone_number,				
							
								'peer_2_employee_number'		=>	$peer_2_employee_number,				
							
								'peer_2_name'					=>	$peer_2_name,						
							
								'peer_2_email'					=>	$peer_2_email,						
							
								'peer_2_phone_number'			=>	$peer_2_phone_number,				
							
								'direct_report_1_employee_number'	=>	$direct_report_1_employee_number,	
							
								'direct_report_1_name'			=>	$direct_report_1_name,				
							
								'direct_report_1_email'			=>	$direct_report_1_email,				
							
								'direct_report_1_phone_number'	=>	$direct_report_1_phone_number,		
								
								'direct_report_2_employee_number'	=>	$direct_report_2_employee_number,	
								
								'direct_report_2_name'			=>	$direct_report_2_name,				
								
								'direct_report_2_email'			=>	$direct_report_2_email,			
								
								'direct_report_2_phone_number'	=>	$direct_report_2_phone_number,		
								
								'direct_report_3_employee_number'	=>	$direct_report_3_employee_number,	
								
								'direct_report_3_name'			=>	$direct_report_3_name,				
								
								'direct_report_3_email'			=>	$direct_report_3_email,				
								
								'direct_report_3_phone_number'	=>	$direct_report_3_phone_number		
								
								
							);
						
						}
					
					}
				
					$query							=	$this->membership_model->upload_participants($participant);
					
					if($query['status'] == 'Success')
					{
						
						$response['status']			=	'Success';
						
						$response['data']			=	$query['reason'];
						
						$response['ref']			=	$ref;
						
					}else{
						
						$response['status']			=	'Failed';
						
						$response['data']			=	$query['reason'];
											
					}
				
				}else{
					
					$response['status']			=	'Failed';
					
					$response['data']			=	'Wrong file format only Excel upload allowed';
				}
				
			}else{

				
				$response['status']			=	'Failed';
					
				$response['data']			=	'No file was selected';

			}

		
		}else{
						
			$response['status']			=	'Failed';
					
			$response['data']			=	'ID of Program not Provided';
								
		}
		
		echo json_encode($response, true);
				
		exit;
		
	}
	
	public function survey_competency_questions($id)
	{
		
		$this->is_logged_in();
		
		if(!empty($id))
		{
			
			//$user_id = $this->session->userdata('user_id');
			$data['title'] 							=	"Program :: PIPA";
			
			$data['menu_status']					=	'programs';
			
			$data['program_id']						= 	$id;
						
			$company_id								=	$this->session->userdata('company_id');
			
			$data['standard_competency']			=	$this->membership_model->get_standard_competency_questions();
			
			$data['optional_competency']			=	$this->membership_model->get_optional_competency_questions();
			
			$data['optional_competency_selected']	=	'';
			
			$data['optional_competency_questions_selected']	=	'';
			
			$data['standard_competency_selected']	=	'';
								
			if($id)
			{	
				
				if($company_id == '1')
				{
									
					$program						= 	$this->membership_model->get_program($id);
				
				}else{
					
					$program						= 	$this->membership_model->get_program($id, $company_id);
					
				}
				
				//if the brand does not exist, redirect them to the brands list with an error
				if(empty($program))
				{
					$this->session->set_flashdata('error', 'The requested Program could not be found.');
					
					redirect(base_url().'admin/create-program/');
					
				}
				

				$data['selected_competency']		= 	$this->membership_model->get_selected_competency_questions($id);
				
				$standardCompetency					=	'';
				
				$optionalCompetency					=	'';
				
				$optionalCompetencyQuestions		=	'';
				
				if(!empty($data['selected_competency']))
				{
					
					foreach($data['selected_competency'] as $keepComp)
					{
						
						if(!empty($keepComp['is_standard']))
						{
							//means its a standard competency	
							
							$standardCompetency		.=	$keepComp['competency_id'].',';
							
						}else{
							
							//means its an optional competency
							
							$optionalCompetency		.=	$keepComp['competency_id'].',';
							
							if(!empty($keepComp['questions']))
							{
								//keep the question template ids in a string to use on page
								
								foreach($keepComp['questions'] as $optQuestionsIDs)
								{
									
									$optionalCompetencyQuestions		.=	$optQuestionsIDs['question_template_id'].',';
									
								}
								
							}
							
						}
						
					}
					
					$data['optional_competency_selected']				=	$optionalCompetency;
			
					$data['standard_competency_selected']				=	$standardCompetency;
					
					$data['optional_competency_questions_selected']		=	$optionalCompetencyQuestions;
					
				}

			}
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
			
			if(!empty($this->input->post('optional_competencies')))
			{
				
				$this->form_validation->set_rules('optional_competencies', 'Optional Competency', 'trim|required');
				
			}else{
				
				$this->form_validation->set_rules('standard_competencies', 'Standard Competency', 'trim|required');
			
			}
			
			if($this->form_validation->run() == FALSE)
			{
								
				$this->load->view('admin/templates/header', $data);
						
				$this->load->view('admin/programs/survey-competency-questions');
				
				$this->load->view('admin/templates/footer');
			
			}else{
				
				$save['program_id']					=	$id;
				
				$save['company_id']					=	$company_id;
				
				$save['standard_competency']		= 	$this->input->post('standard_competencies');
				
				$save['optional_competency']		= 	$this->input->post('optional_competencies');
				
				$save['created_by_id']				=	$this->session->userdata('user_id');
				
				$query								=	$this->membership_model->save_competency_questions($save);
				
				if($query) // if the user's credentials validated...
				{	
					
					$this->session->set_flashdata('message', 'Program operation successful');
					
					redirect(base_url().'admin/leadership-assessment/'.$id.'/');
					
				}
				else 
				{
	
					$this->session->set_flashdata('error', 'An error occured while performing Program operation, Try Again.');
					
					//go back to the brand list
					redirect(base_url().'admin/survey-competency-questions/'.$id.'/');
				
				}
			
			}
		
		}else{
		
			show_404();
			
		}

	}
	
	public function custom_survey_competency_questions($id)
	{
		
		$this->is_logged_in();
		
		if(!empty($id))
		{
			
			//$user_id = $this->session->userdata('user_id');
			$data['title'] 							=	"Program :: PIPA";
			
			$data['menu_status']					=	'programs';
			
			$data['program_id']						= 	$id;
			
			$data['counter']						= 	0;
			
			$data['question_options']				=	array();
			
			$data['question_options2'] 				= 	array();
						
			$company_id								=	$this->session->userdata('company_id');
								
			if($id)
			{	
				
				if($company_id == '1')
				{
									
					$program						= 	$this->membership_model->get_program($id);
				
				}else{
					
					$program						= 	$this->membership_model->get_program($id, $company_id);
					
				}
				
				$data['question_options']			= 	$this->membership_model->get_program_custom_competency_questions($id);
				
				$counter							= 	1;
				
				if(!empty($data['question_options']))
				{
					
					$data['counter']				=	1;
					
					foreach($data['question_options'] as $po)
					{
						$po							= 	(object)$po;
						
						if(empty($po->required)){$po->required = false;}
						
						$inside 					= 	1;
						
						$data['question_options2'][$data['counter']] 	= 	$this->add_question($po, $data['counter'], $inside);
						
						$data['counter']++;
						
					}
					
				}
				
				//if the brand does not exist, redirect them to the brands list with an error
				if(empty($program))
				{
					
					$this->session->set_flashdata('error', 'The requested Program could not be found.');
					
					redirect(base_url().'admin/create-program/');
					
				}

			}
			
			if($this->input->post('submit'))
			{
				//reset the product options that were submitted in the post
				$data['question_options']			= 	$this->input->post('question');
				
			}
			
			$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
			
			$this->form_validation->set_rules('question[]', 'Question', 'trim|required');
			

			
			if($this->form_validation->run() == FALSE)
			{
								
				$this->load->view('admin/templates/header', $data);
						
				$this->load->view('admin/programs/custom-survey-competency-questions');
				
				$this->load->view('admin/templates/footer');
			
			}else{
				
				$save['program_id']					=	$id;
				
				$save['company_id']					=	$company_id;
								
				$save['created_by_id']				=	$this->session->userdata('user_id');
				
				$questions							= 	array();
				
				if($this->input->post('question'))
				{
					foreach ($this->input->post('question') as $question)
					{
						
						$questions[]				= 	$question;
					
					}
	
				}	
				
				$query								=	$this->membership_model->save_custom_competency_questions($save, $questions);
				
				if($query) // if the user's credentials validated...
				{	
					
					$this->session->set_flashdata('message', 'Program operation successful');
					
					redirect(base_url().'admin/leadership-assessment/'.$id.'/');
					
				}
				else 
				{
	
					$this->session->set_flashdata('error', 'An error occured while performing Program operation, Try Again.');
					
					//go back to the brand list
					redirect(base_url().'admin/custom-survey-competency-questions/'.$id.'/');
				
				}
			
			}
		
		}else{
		
			show_404();
			
		}

	}
	
	function create_custom_question()
	{
		
		$value				= 	array(array('name'=>'', 'value'=>'', 'weight'=>'', 'price'=>'', 'limit'=>''));
		
		$js_textfield		= 	(object)array('name'=>'', 'question'=>'', 'type'=>'textfield', 'required'=>false, 'values'=>$value);
		
		$js_textarea		= 	(object)array('name'=>'', 'type'=>'textarea', 'required'=>false, 'values'=>$value);
		
		$js_radiolist		= 	(object)array('name'=>'', 'type'=>'radiolist', 'required'=>false, 'values'=>$value);
		
		$js_checklist		= 	(object)array('name'=>'', 'type'=>'checklist', 'required'=>false, 'values'=>$value);
		
		$js_droplist		= 	(object)array('name'=>'', 'type'=>'droplist', 'required'=>false, 'values'=>$value);
		
		$type				= 	$this->input->post('type');
		
		$option_count 		= 	$this->input->post('count');
		
		if($type == 'textfield')
		{
		
			echo $this->add_question($js_textfield, $option_count);
		
		}
		else if($type == 'textarea')
		{
		
			echo $this->add_question($js_textarea, $option_count);
		
		}
		else if($type == 'radiolist')
		{
		
			echo $this->add_question($js_radiolist, $option_count);
		
		}
		else if($type == 'checklist')
		{
		
			echo $this->add_question($js_checklist, $option_count);
		
		}
		else if($type == 'droplist')
		{
		
			echo $this->add_question($js_droplist, $option_count);
		
		}
		
	}
	
	function add_question($po, $count, $mode=false)
	{
		
		/*print_r($po);
		
		echo '<br /><br />';
		
		print_r($po->question);
		
		die();*/
		
		ob_start();
		
		echo '<div class="col-xs-12 col-md-12 admin-form-row" id="option-'.$count.'">
			
			<div class="col-xs-12 col-md-4 no-pad-left">
				
				<div class="form-group">
		
					<label>Question '.$count.'</label>
										
				</div>
	
			</div>
			
			<div class="col-xs-12 col-md-7 no-pad-left">
                        	
				<div class="form-group admin-form-setup">
					 
					<div class="col-xs-9 col-md-9 no-pad-left">
						
						<div class="form-group" style="overflow:auto;">
							 
							<input class="form-control" name="question['.$count.'][question]" value="'.$po->question.'"  type="text" placeholder="Your Question" autocomplete="off" />
																					
						</div>
						
					</div>
					
					<div class="col-xs-3 col-md-3 no-pad-left no-pad-right">
						
						<div class="form-group" style="overflow:auto;">
							 
							<button type="button" class="btn btn-danger" onclick="remove_question('.$count.');" title="Delete Question">
							
								<i class="fa fa-trash"></i> Delete
								
							</button>
							
						</div>
						
					</div>

				</div>
				
			</div>

		</div>';
    
    	$stuff 		= 	ob_get_contents();
	
		ob_end_clean();
		
		if($mode === false){
			
			echo $this->replace_newline($stuff);
			
		}else{
			
			return $this->replace_newline($stuff);
			
		}
		
	}
	
	public function active_programs()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Program :: PIPA";
		
		$data['menu_status']				=	'programs';
		
		$data['page_tab']					=	'active';
		
		$company_id							=	$this->session->userdata('company_id');
		
		if($company_id == '1')
		{
			
			$data['programs']					=	$this->membership_model->get_program('', '', $limit=10, $offset=0, 'Active');
										
			$data['pending_programs']			=	$this->membership_model->get_program('', '', $limit=10, $offset=0, 'Pending');

		
		}else{
				
			$data['programs']					=	$this->membership_model->get_program('', $company_id, $limit=10, $offset=0, 'Active');
					
			$data['pending_programs']			=	$this->membership_model->get_program('', $company_id, $limit=10, $offset=0, 'Pending');
			
		}
		
		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/programs/active-programs');
		
		$this->load->view('admin/templates/footer');

	}
	
	public function pending_programs()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Program :: PIPA";
		
		$data['menu_status']				=	'programs';
		
		$data['page_tab']					=	'pending';
		
		$company_id							=	$this->session->userdata('company_id');
		
		if($company_id == '1')
		{
			
			$data['programs']					=	$this->membership_model->get_program('', '', $limit=10, $offset=0, 'Active');
										
			$data['pending_programs']			=	$this->membership_model->get_program('', '', $limit=10, $offset=0, 'Pending');

		
		}else{
				
			$data['programs']					=	$this->membership_model->get_program('', $company_id, $limit=10, $offset=0, 'Active');
					
			$data['pending_programs']			=	$this->membership_model->get_program('', $company_id, $limit=10, $offset=0, 'Pending');
			
		}
		
		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/programs/active-programs');
		
		$this->load->view('admin/templates/footer');

	}
	
	// check if email belongs to a specific user(customer)
	public function owner_email_check($str)
	{
		
		$email_chck 								= 	$this->membership_model->check_owner_email($str);
		
		if($email_chck == TRUE)
		{
			$this->form_validation->set_message('email_check', 'The %s is already Registered, Please select another.');
			
			return FALSE;
			
		}
		else
		{
			
			return TRUE;
		
		}
			
	}

	public function coaches()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Coaches :: PIPA";
		
		$data['menu_status']				=	'coaches';
		
		$data['page_tab']					=	'active';
		
		$company_id							=	$this->session->userdata('company_id');
				
		$data['coaches']					= 	$this->membership_model->get_coach('', $company_id);
		
		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/coaches/coach');
		
		$this->load->view('admin/templates/footer');

	}
	
	public function view_coach($id)
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Coaches :: PIPA";
		
		$data['menu_status']				=	'coaches';
		
		$data['page_tab']					=	'active';
		
		if(!empty($id))
		{
			
			$company_id						=	$this->session->userdata('company_id');
					
			$data['coach']					= 	$this->membership_model->get_coach($id, $company_id);
			
			$this->load->view('admin/templates/header', $data);
					
			$this->load->view('admin/coaches/coach-details');
			
			$this->load->view('admin/templates/footer');
		
		}else{
		
			show_404();
			
		}

	}
	

	public function create_coach($id=false)
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 								=	"Coaches :: PIPA";
		
		$data['menu_status']						=	'coaches';
		
		$data['user_id']							= 	$id;
		
		$data['company_id']							= 	'';
				
		$data['email']								= 	'';
		
		$data['phone_number']						= 	'';
		
		$data['first_name']							= 	'';
		
		$data['last_name']							= 	'';
		
		$data['biography']							= 	'';
		
		$data['coach_id']							= 	'';
		
		$company_id									=	$this->session->userdata('company_id');
		
		$data['user_company']						=	$company_id;
		
		$data['companies']							=	$this->membership_model->get_company();
				
		if($id)
		{
			
			$user									= 	$this->membership_model->get_coach($id);

			//if the brand does not exist, redirect them to the brands list with an error
			if(!$user)
			{
				$this->session->set_flashdata('error', 'The requested Coach could not be found.');
				
				redirect(base_url().'admin/create-coach/');
			
			}
			
			$data['company_id']							= 	$user['user']['company_id'];
				
			$data['email']								= 	$user['user']['email'];
			
			$data['phone_number']						= 	$user['user']['phone_number'];
			
			$data['first_name']							= 	$user['user']['first_name'];
			
			$data['last_name']							= 	$user['user']['last_name'];
			
			$data['coach_id']							= 	$user['user']['coach_id'];
			
			$data['biography']							= 	$user['user']['biography'];
			
		}
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|callback_alpha_dash_space');
				
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[64]');
		
		$this->form_validation->set_rules('company_id', 'User Company', 'trim|required|callback_select_validate');
		
		$this->form_validation->set_rules('biography', 'Biography', 'required|trim');
		
		if($this->form_validation->run() == FALSE)
		{
							
			$this->load->view('admin/templates/header', $data);
					
			$this->load->view('admin/coaches/create-coach');
			
			$this->load->view('admin/templates/footer');
		
		}else{
			
			$save['user_id']							= 	$id;
			
			$save['company_id']							= 	$this->input->post('company_id');
				
			$save['email']								= 	$this->input->post('email');
			
			$save['phone_number']						= 	$this->input->post('phone_number');
			
			$save['first_name']							= 	$this->input->post('first_name');
			
			$save['last_name']							= 	$this->input->post('last_name');
			
			$saveCoach['coach_id']						=	$data['coach_id'];
			
			$saveCoach['biography']						=	$this->input->post('biography');
			
			if(!empty($data['coach_id']))
			{
				// if its an update
				$saveCoach['date_modified']				= 	date('Y-m-d H:i:s');
				
				$saveCoach['modified_by_id']      		= 	$this->session->userdata('user_id');
				
			}else{
				
				// its a new article
				$saveCoach['date_created']				= 	date('Y-m-d H:i:s');
				
				$saveCoach['created_by_id']          	= 	$this->session->userdata('user_id');

			}
					
			// save company 
			$user										= 	$this->membership_model->save_coach($save, $saveCoach);
			
			if($user) // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('message', 'Coach operation successful');
				
				redirect(base_url().'admin/create-coach/'.$id.'/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', 'An error occured while performing Coach operation, Try Again.');
				
				//go back to the brand list
				redirect(base_url().'admin/create-coach/');
			
			}
					
		}

	}
	
	public function competencies()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Competencies :: PIPA";
		
		$data['menu_status']				=	'competencies';
		
		$data['page_tab']					=	'active';
		
		$company_id							=	$this->session->userdata('company_id');
				
		$data['competencies']				= 	$this->membership_model->get_competency();

		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/competency/competency');
		
		$this->load->view('admin/templates/footer');

	}
	
	public function create_competency($id=false)
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 								=	"Competencies :: PIPA";
		
		$data['menu_status']						=	'competencies';
		
		$data['competency_id']						= 	$id;
						
		$data['competency']							= 	'';
		
		$data['is_standard']						= 	'';
		
		$company_id									=	$this->session->userdata('company_id');
		
		$data['company_id']							=	$company_id;
		
		$data['user_company']						=	$company_id;
		
		$data['companies']							=	$this->membership_model->get_company();
				
		if($id)
		{
			
			$competency								= 	$this->membership_model->get_competency($id);

			//if the brand does not exist, redirect them to the brands list with an error
			if(!$competency)
			{
				$this->session->set_flashdata('error', 'The requested Competency could not be found.');
				
				redirect(base_url().'admin/create-competency/');
			
			}
			
			//$data['company_id']							= 	$user['user']['company_id'];
							
			$data['competency']							= 	$competency['competency']['competency'];
			
			$data['is_standard']						= 	$competency['competency']['is_standard'];
			
		}
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('competency', 'Competency', 'required|trim');
		
		if($this->form_validation->run() == FALSE)
		{
							
			$this->load->view('admin/templates/header', $data);
					
			$this->load->view('admin/competency/create-competency');
			
			$this->load->view('admin/templates/footer');
		
		}else{
			
			$save['competency_id']						= 	$id;
			
			//$save['company_id']							= 	$this->input->post('company_id');
				
			$save['competency']							= 	$this->input->post('competency');
			
			$save['is_standard']						= 	$this->input->post('is_standard');
			
			if(!empty($data['competency_id']))
			{
				// if its an update
				$save['date_modified']					= 	date('Y-m-d H:i:s');
				
				$save['modified_by_id']      			= 	$this->session->userdata('user_id');
				
			}else{
				
				// its a new article
				$save['date_created']					= 	date('Y-m-d H:i:s');
				
				$save['created_by_id']          		= 	$this->session->userdata('user_id');

			}
					
			// save company 
			$query										= 	$this->membership_model->save_competency($save);
			
			if($query) // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('message', 'Competency operation successful');
				
				redirect(base_url().'admin/competencies/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', 'An error occured while performing Competency operation, Try Again.');
				
				//go back to the brand list
				redirect(base_url().'admin/create-competency/');
			
			}
					
		}

	}
	
	public function questions()
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 						=	"Questions :: PIPA";
		
		$data['menu_status']				=	'questions';
		
		$data['page_tab']					=	'active';
		
		$company_id							=	$this->session->userdata('company_id');
				
		$data['questions']					= 	$this->membership_model->get_setup_question();
		
		$this->load->view('admin/templates/header', $data);
				
		$this->load->view('admin/competency/question');
		
		$this->load->view('admin/templates/footer');

	}
	
	public function create_question($id=false)
	{
		
		$this->is_logged_in();
		
		//$user_id = $this->session->userdata('user_id');
		$data['title'] 								=	"Question :: PIPA";
		
		$data['menu_status']						=	'competencies';
		
		$data['question_template_id']				= 	$id;
						
		$data['competency_id']						= 	'';
		
		$data['question']							= 	'';
		
		$data['Active']								= 	'';
		
		$data['competencies']						= 	$this->membership_model->get_competency();
		
		$company_id									=	$this->session->userdata('company_id');
		
		$data['company_id']							=	$company_id;
		
		$data['user_company']						=	$company_id;
		
		$data['companies']							=	$this->membership_model->get_company();
				
		if($id)
		{
			
			$question								= 	$this->membership_model->get_setup_question($id);

			//if the brand does not exist, redirect them to the brands list with an error
			if(!$question)
			{
				$this->session->set_flashdata('error', 'The requested Competency Question could not be found.');
				
				redirect(base_url().'admin/create-question/');
			
			}
			
			//$data['company_id']							= 	$user['user']['company_id'];
							
			$data['competency_id']						= 	$question['competency_id'];
		
			$data['question']							= 	$question['question'];
			
			$data['Active']								= 	$question['Active'];
			
		}
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('question', 'Question', 'required|trim');
		
		$this->form_validation->set_rules('competency_id', 'Competency', 'required|trim|callback_select_validate');
		
		if($this->form_validation->run() == FALSE)
		{
							
			$this->load->view('admin/templates/header', $data);
					
			$this->load->view('admin/competency/create-question');
			
			$this->load->view('admin/templates/footer');
		
		}else{
			
			$save['question_template_id']				= 	$id;
			
			//$save['company_id']							= 	$this->input->post('company_id');
				
			$save['competency_id']						= 	$this->input->post('competency_id');
			
			$save['Active']								= 	$this->input->post('Active');
			
			$save['question']							= 	$this->input->post('question');
			
			if(!empty($data['question_template_id']))
			{
				// if its an update
				$save['date_modified']					= 	date('Y-m-d H:i:s');
				
				$save['modified_by_id']      			= 	$this->session->userdata('user_id');
				
			}else{
				
				// its a new article
				$save['date_created']					= 	date('Y-m-d H:i:s');
				
				$save['created_by_id']          		= 	$this->session->userdata('user_id');

			}
					
			// save company 
			$query										= 	$this->membership_model->save_setup_question($save);
			
			if($query) // if the user's credentials validated...
			{					
				
				$this->session->set_flashdata('message', 'Competency Question operation successful');
				
				redirect(base_url().'admin/create-question/'.$id.'/');
				
			}
			else 
			{

				$this->session->set_flashdata('error', 'An error occured while performing Competency Question operation, Try Again.');
				
				//go back to the brand list
				redirect(base_url().'admin/create-question/');
			
			}
					
		}

	}
	
	public function send_sterling_participants()
	{
		
		$query			=	$this->membership_model->sterling_participants();
		
		if($query['status'] == 'Success')
		{
			
			echo $query['message'];
			
		}else{
			
			echo $query['message'];
				
		}
		
	}
	
	public function user($page = FALSE, $id = FALSE)
	{
		$this->is_logged_in();
		
		$data['title'] 						= 	"User :: PIPA";
			
		$data['menu_status'] 				= 	"users";
		
		$pageid								=	'9';
		
		$pageview							=	'1';
		
		$data['UAC']						=	$this->get_admin_role_credentials();
		
		//check if this page id exists in the role assigned to user
		if(!empty($data['UAC']['rolePageActions'][$pageid]))
		{
			
			$data['userPageActions']		=	explode(',', $data['UAC']['rolePageActions'][$pageid]['pageActions']);
									
			//1 is for view this particular page check if it exists in the array that was just exploded

			if(in_array($pageview, $data['userPageActions']))
			{
		
				if($page === false){
					
					$data['get_user'] 			= 	$this->membership_model->get_users();
					
					$this->load->view('admin/templates/header', $data);
					
					$this->load->view('admin/user');
					
					$this->load->view('admin/templates/footer');
					
				}else{
					
					$this->usersform($id);			
				
				}
		
			}else{
				
				
				$this->load->view('admin/templates/header', $data);
		
				$this->load->view('admin/uac-permission');
	
				$this->load->view('admin/templates/footer');
			
			}
		
		}else{
			
			
			$this->load->view('admin/templates/header', $data);
		
			$this->load->view('admin/uac-permission');

			$this->load->view('admin/templates/footer');
			
		}
		
	}
	
	public function usersform($id = false)
	{
		$this->is_logged_in();
				
		$data['title']						= 	"Users Form :: PIPA";
		
		$data['menu_status'] 				= 	"users";
		
		$pageid								=	'9';
		
		$pageview							=	'1';
		
		$data['UAC']						=	$this->get_admin_role_credentials();
		
		//check if this page id exists in the role assigned to user
		if(!empty($data['UAC']['rolePageActions'][$pageid]))
		{
			
			$data['userPageActions']				=	explode(',', $data['UAC']['rolePageActions'][$pageid]['pageActions']);
									
			//1 is for view this particular page check if it exists in the array that was just exploded

			if(in_array($pageview, $data['userPageActions']))
			{
		
				$this->user_id						= 	$id;	
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
				
				//default values are empty if the product is new
				$data['user_id']					= 	'';
				
				$data['firstname']					= 	'';
				
				$data['lastname']					= 	'';
				
				$data['username']					= 	'';
				
				$data['admin_email']				= 	'';
				
				$data['admin_status']				= 	'';
				
				$data['roleID']						= 	'';
				
				$data['mobile']						= 	'';
				
				$data['roles']						= 	$this->membership_model->get_user_role('', '1');
				
				if ($id)
				{	
					
					$user							= 	$this->membership_model->get_user($id);
					
					//if the brand does not exist, redirect them to the brands list with an error
					if (!$user)
					{
						$this->session->set_flashdata('error', 'The requested User could not be found.');
						
						redirect(base_url().'admin/users/add/');
						
					}
					
					//set values to db values
					$data['user_id']					= 	$id;
					
					$data['firstname']					= 	$user->firstname;
					
					$data['lastname']					= 	$user->lastname;
					
					$data['username']					= 	$user->username;
					
					$data['admin_email']				= 	$user->admin_email;
					
					$data['admin_status']				= 	$user->admin_status;
					
					$data['roleID']						= 	$user->roleID;
					
					$data['mobile']						= 	$user->mobile;
		
				}
				
				$this->form_validation->set_rules('username', 'User Name', 'trim|required|max_length[64]|callback_username_check['.$id.']');
				
				$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|max_length[64]');
				
				$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|max_length[64]');
				
				$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|max_length[32]');
				
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check['.$id.']|max_length[64]');
				
				if(empty($id))
				{
				
					$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirm_password]');
				
					$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
				
				}else{
					
					$new_psd 							= 	$this->input->post('password');
						// check if while updating the password was reset
					if(empty($new_psd)){
						
						
					}else{
						
						$this->form_validation->set_rules('password', 'Password', 'trim|matches[confirm_password]');
						
						$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
					
					}
				}
		
				if ($this->form_validation->run() == FALSE)
				{
					
					$this->load->view('admin/templates/header', $data);
					
					$this->load->view('admin/user_form');
					
					$this->load->view('admin/templates/footer');
				
				}
				else
				{			
					$save['user_id']					= 	$id;
					
					$save['firstname']					= 	$this->input->post('firstname');
					
					$save['lastname']					= 	$this->input->post('lastname');
					
					$save['username']					= 	$this->input->post('username');
					
					$save['admin_email']				= 	$this->input->post('email');
					
					$save['admin_status']				= 	$this->input->post('status');
					
					$save['roleID']						= 	$this->input->post('roleID');
					
					$save['mobile']						= 	$this->input->post('mobile');
		
			
					if(!empty($id))
					{
						// if its an update
						$save['last_modified']			= 	date('Y-m-d H:i:s');
						
						$save['last_modified_by']       = 	$this->session->userdata('user_id');
						
						$new_psd 						= 	$this->input->post('password');
						
						// check if while updating the password was reset
						if(empty($new_psd)){
							
						}else{
						 
						  $save['password']				= 	md5($this->input->post('password'));
						
						}
						
					}else{
					
						// its a new admin
						$save['password']				= 	md5($this->input->post('password'));
						
						$save['date_created']			= 	date('Y-m-d H:i:s');
						
						$save['created_by']             = 	$this->session->userdata('user_id');
					
					}
		
					// save brand 
					$user_id							= 	$this->membership_model->save_user($save);
		
					$this->session->set_flashdata('message', 'The User has been saved.');
					
					//go back to the brand list
					redirect(base_url().'admin/user/');
					
				}
		
			}else{
				
				
				$this->load->view('admin/templates/header', $data);
		
				$this->load->view('admin/uac-permission');
	
				$this->load->view('admin/templates/footer');
			
			}
		
		}else{
			
			
			$this->load->view('admin/templates/header', $data);
		
			$this->load->view('admin/uac-permission');

			$this->load->view('admin/templates/footer');
			
		}
		
	}
	
	public function user_role($page = FALSE, $id = FALSE)
	{
		$this->is_logged_in();
		
		$data['title'] 						= 	"User Role:: PIPA";
			
		$data['menu_status'] 				= 	"users";
		
		$pageid								=	'10';
		
		$pageview							=	'1';
		
		$data['UAC']						=	$this->get_admin_role_credentials();
		
		//check if this page id exists in the role assigned to user
		if(!empty($data['UAC']['rolePageActions'][$pageid]))
		{
			
			$data['userPageActions']					=	explode(',', $data['UAC']['rolePageActions'][$pageid]['pageActions']);
									
			//1 is for view this particular page check if it exists in the array that was just exploded

			if(in_array($pageview, $data['userPageActions']))
			{
		
				if($page === false){			
					
					$data['get_user_roles'] 	= 	$this->membership_model->get_user_role();
					
					$this->load->view('admin/templates/header', $data);
					
					$this->load->view('admin/user-role');
					
					$this->load->view('admin/templates/footer');
					
				}else{
					
					$this->userroleform($id);			
				
				}
		
			}else{
				
				
				$this->load->view('admin/templates/header', $data);
		
				$this->load->view('admin/uac-permission');
	
				$this->load->view('admin/templates/footer');
			
			}
		
		}else{
			
			
			$this->load->view('admin/templates/header', $data);
		
			$this->load->view('admin/uac-permission');

			$this->load->view('admin/templates/footer');
			
		}
		
	}
	
	public function userroleform($id = false)
	{
		$this->is_logged_in();
				
		$data['title']						= 	"User Role :: PIPA";
		
		$data['menu_status'] 				= 	"users";
		
		$pageid								=	'10';
		
		$pageview							=	'1';
		
		$data['UAC']						=	$this->get_admin_role_credentials();
		
		//check if this page id exists in the role assigned to user
		if(!empty($data['UAC']['rolePageActions'][$pageid]))
		{
			
			$data['userPageActions']				=	explode(',', $data['UAC']['rolePageActions'][$pageid]['pageActions']);
									
			//1 is for view this particular page check if it exists in the array that was just exploded

			if(in_array($pageview, $data['userPageActions']))
			{
		
				$this->user_id						= 	$id;	
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
				
				//default values are empty if the product is new
				$data['roleID']						= 	'';
				
				$data['role']						= 	'';
				
				$data['status']						= 	'';
				
				$data['adminPages']					=	$this->membership_model->get_admin_pages();
				
				if ($id)
				{	
					
					$role							= 	$this->membership_model->get_user_role($id);
					
					//if the brand does not exist, redirect them to the brands list with an error
					if (!$role)
					{
						$this->session->set_flashdata('error', 'The requested Role could not be found.');
						
						redirect(base_url().'admin/user-role/add/');
						
					}
					
					//set values to db values
					$data['roleID']					= 	$id;
					
					$data['role']					= 	$role['role'];
					
					$data['status']					= 	$role['status'];
					
					$data['rolePageActions']		= 	$role['rolePageActions'];
		
				}
				
				$this->form_validation->set_rules('role', 'Role Name', 'trim|required|callback_rolename_check['.$id.']');
		
		
				if ($this->form_validation->run() == FALSE)
				{
					
					$this->load->view('admin/templates/header', $data);
					
					$this->load->view('admin/user-role-form');
					
					$this->load->view('admin/templates/footer');
				
				}
				else
				{	
				
					$slug 							= 	$this->input->post('role');
		
					$slug							= 	url_title(convert_accented_characters($slug), 'dash', TRUE);
							
					$save['roleID']					= 	$id;
					
					$save['role']					= 	$this->input->post('role');
					
					$save['roleSlug']				= 	$slug;
					
					$save['status']					= 	$this->input->post('status');
					
					//get the pages and each action for those pages
					$uac							=	$this->input->post('page');
			
					if(!empty($id))
					{
						// if its an update
						/*$save['last_modified']			= 	date('Y-m-d H:i:s');
						
						$save['last_modified_by']       = 	$this->session->userdata('user_id');
						*/
					}else{
		
						
						$save['dateCreated']			= 	date('Y-m-d H:i:s');
						
						$save['createdBy']             	= 	$this->session->userdata('user_id');
					
					}
		
					// save brand 
					$user_id							= 	$this->membership_model->save_user_role($save, $uac);
		
					$this->session->set_flashdata('message', 'The User Role has been saved.');
					
					//go back to the brand list
					redirect(base_url().'admin/user-role/');
					
				}
		
			}else{
				
				
				$this->load->view('admin/templates/header', $data);
		
				$this->load->view('admin/uac-permission');
	
				$this->load->view('admin/templates/footer');
			
			}
		
		}else{
			
			
			$this->load->view('admin/templates/header', $data);
		
			$this->load->view('admin/uac-permission');

			$this->load->view('admin/templates/footer');
			
		}
		
	}
	
	public function admin_pages($page = FALSE, $id = FALSE)
	{
		$this->is_logged_in();
					
		$data['title'] 						= 	"Admin Pages:: PIPA";
			
		$data['menu_status'] 				= 	"settings";
		
		$pageid								=	'11';
		
		$pageview							=	'1';
		
		$data['UAC']						=	$this->get_admin_role_credentials();
		
		//check if this page id exists in the role assigned to user
		if(!empty($data['UAC']['rolePageActions'][$pageid]))
		{
			
			$data['userPageActions']			=	explode(',', $data['UAC']['rolePageActions'][$pageid]['pageActions']);
									
			//1 is for view this particular page check if it exists in the array that was just exploded

			if(in_array($pageview, $data['userPageActions']))
			{
			
				if($page === false){
					
					
					$data['admin_pages'] 		= 	$this->membership_model->get_admin_pages();
					
					$this->load->view('admin/templates/header', $data);
					
					$this->load->view('admin/admin-pages');
					
					$this->load->view('admin/templates/footer');
					
				}else{
					
					$this->adminpagesform($id);			
				
				}
		
			}else{
				
				
				$this->load->view('admin/templates/header', $data);
		
				$this->load->view('admin/uac-permission');
	
				$this->load->view('admin/templates/footer');
			
			}
		
		}else{
			
			
			$this->load->view('admin/templates/header', $data);
		
			$this->load->view('admin/uac-permission');

			$this->load->view('admin/templates/footer');
			
		}
		
	}
	
	public function adminpagesform($id = false)
	{
		$this->is_logged_in();
		
		
		$data['title']						= 	"Admin Pages :: PIPA";
		
		$data['menu_status'] 				= 	"settings";
		
		$pageid								=	'11';
		
		$pageview							=	'1';
		
		$data['UAC']						=	$this->get_admin_role_credentials();
		
		//check if this page id exists in the role assigned to user
		if(!empty($data['UAC']['rolePageActions'][$pageid]))
		{
			
			$data['userPageActions']				=	explode(',', $data['UAC']['rolePageActions'][$pageid]['pageActions']);
									
			//1 is for view this particular page check if it exists in the array that was just exploded

			if(in_array($pageview, $data['userPageActions']))
			{
		
				$this->user_id						= 	$id;	
				
				$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
				
				//default values are empty if the product is new
				$data['pageID']						= 	'';
				
				$data['page']						= 	'';
				
				$data['roleActions']				= 	$this->membership_model->get_role_actions();
						
				if ($id)
				{	
					
					$page							= 	$this->membership_model->get_admin_pages($id);
					
					//if the brand does not exist, redirect them to the brands list with an error
					if (!$page)
					{
						$this->session->set_flashdata('error', 'The requested Page could not be found.');
						
						redirect(base_url().'admin/admin-pages/add/');
						
					}
					
					//set values to db values
					$data['pageID']					= 	$id;
					
					$data['page']					= 	$page['page'];
					
					$data['pageactions']			= 	$page['actions'];
					
				}
				
				$this->form_validation->set_rules('page', 'Page Name', 'trim|required');
		
		
				if ($this->form_validation->run() == FALSE)
				{
					
					$this->load->view('admin/templates/header', $data);
					
					$this->load->view('admin/admin-pages-form');
					
					$this->load->view('admin/templates/footer');
				
				}
				else
				{	
							
					$save['pageID']					= 	$id;
					
					$slug 							= 	$this->input->post('page');
		
					$slug							= 	url_title(convert_accented_characters($slug), 'dash', TRUE);
					
					$save['page']					= 	$this->input->post('page');
					
					$save['slug']					= 	$slug;
					
					$actions						= 	rtrim($this->input->post('actionhlder'), ",");
		
					// save brand 
					$query							= 	$this->membership_model->save_admin_page($save, $actions);
					
					if($query)
					{
		
						$this->session->set_flashdata('message', 'The Admin Page has been saved.');
						
						//go back to the brand list
						redirect(base_url().'admin/admin-pages/');
					
					}else{
					
						$this->session->set_flashdata('error', 'An Error occurred trying to perform this operation.');
						
						//go back to the brand list
						redirect(base_url().'admin/admin-pages/');
		
			
					}
					
				}
		
			}else{
				
				
				$this->load->view('admin/templates/header', $data);
		
				$this->load->view('admin/uac-permission');
	
				$this->load->view('admin/templates/footer');
			
			}
		
		}else{
			
			
			$this->load->view('admin/templates/header', $data);
		
			$this->load->view('admin/uac-permission');

			$this->load->view('admin/templates/footer');
			
		}
		
	}
	
	public function delete_admin_page()
	{
		
		$id								=	$this->input->post('id');
		
		$adminID 						= 	$this->session->userdata('user_id');
		
		if(!empty($adminID))
		{
			
			$query						=	$this->membership_model->delete_admin_page($id);
			
			if($query)
			{
				
				$response['status']		=	"Success";
				
				$response['message']	=	"Page Deleted Successfully";
				
			}else{
				
				$response['status']		=	"Error";
				
				$response['message']	=	"There was an Error deleting this page";
				
			}
		
		}else{
			
			
				$response['status']		=	"Please Login";
				
				$response['message']	=	"Please Login to Perform this Task";
		}
		
		echo json_encode($response, true);
		
	}
	
	// check if email belongs to a specific user(admin)
	public function email_check($str, $id)
	{
		
		$email_chck 			= 	$this->membership_model->check_email($str, $id);
		
		if($email_chck == TRUE)
		{
			$this->form_validation->set_message('email_check', 'The %s is already Registered, Please select another.');
			
			return FALSE;
		}
		else
		{
			return TRUE;
		}
			
	}
	
		// check if email belongs to a specific user
	public function username_check($str, $id)
	{
		
		$email_chck 			= 	$this->membership_model->check_username($str, $id);
		
		if($email_chck == TRUE)
		{
			$this->form_validation->set_message('username_check', 'The %s is already Registered, Please select another.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
			
	}
	
	public function rolename_check($str, $id)
	{
		
		$email_chck 			= 	$this->membership_model->check_rolename($str, $id);
		
		if($email_chck == TRUE)
		{
			$this->form_validation->set_message('rolename_check', 'The %s is already Registered, Please select another.');
			
			return FALSE;
		
		}
		else
		{
			
			return TRUE;
			
		}
			
	}
	
	// this function is for when the customer wants to change their password make sure it s the owner of the account by cross checking the old password
	public function currentpswd_check($str)
	{
		$user_id 				= 	$this->session->userdata('user_id');
		
		$pswd_chck 				= 	$this->membership_model->check_pswd($str, $user_id);
		
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


	public function	get_admin_role_credentials()
	{
		$userID					=	$this->session->userdata('user_id');
		
		$roleID					=	$this->membership_model->get_admin_role_assigned($userID);
		
		if(!empty($roleID))
		{
			
			$role					=	$this->membership_model->get_user_access_control($roleID);
			
			return $role;
			
		}else{
			
			$this->session->set_flashdata('error', 'Please Contact Super Administrator to assign you a Role!!!');
			
			//go back to the brand list
			redirect(base_url().'admin/notification-settings/');
			
		}
		
	}
	
	
	public function logout()
	{
		$this->session->sess_destroy();
		//$this->index();
		redirect('admin');
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
	
	
	public function get_country_state()
	{
		$country 			= 	$this->input->post('country_id');
		
		$drpdwn_state 		= 	$this->membership_model->get_country_states($country);
		
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
		
		$drpdwn_lga 		= 	$this->membership_model->get_country_states_lga($state);
				
		$totalVal			=	'<option value="0">-- Select LGA--</option>';
		
		foreach($drpdwn_lga as $lga)
		{
		
			$totalVal 		.=	'<option value="'.$lga['lga_id'].'"'; 
		
			$totalVal 		.=	set_select("lga", $lga['lga_id']); 
		
			$totalVal 		.=	'>'.ucfirst($lga['lga_name']).'</option>';
		
		}
		
		echo $totalVal;
		
	}
	
	public function upload_response()
	{
		
		$this->is_logged_in();
		
		$data['title']		=	'Upload Response';	
		
		$this->load->view('admin/templates/header', $data);

		$this->load->view('admin/programs/upload-response');

		$this->load->view('admin/templates/footer');
		
	}
	
	public function upload_program_response()
	{
		
		$response								=	array();
		
		if(isset($_FILES['participants']["name"]))
		{
			
			$fileExt 							= 	pathinfo($_FILES['participants']["name"], PATHINFO_EXTENSION);
			
			if($fileExt == 'xlsx' || $fileExt == 'xls')
			{
			
				$this->load->library('excel');
				
				$path 								= 	$_FILES['participants']["tmp_name"];
			
				$object 							= 	PHPExcel_IOFactory::load($path);
			
				foreach($object->getWorksheetIterator() as $worksheet)
				{
					
					$highestRow 					= 	$worksheet->getHighestRow();
				
					$highestColumn 					= 	$worksheet->getHighestColumn();
					
					for($row=2; $row<=$highestRow; $row++)
					{
					
						$survey_surveyor_id 				= 	$worksheet->getCellByColumnAndRow(0, $row)->getValue();
						
						//check if the columns are empty by using the first value
						if(!empty($survey_surveyor_id))
						{
									
							$company_id 						= 	$worksheet->getCellByColumnAndRow(1, $row)->getValue();
						
							$program_id 						= 	$worksheet->getCellByColumnAndRow(2, $row)->getValue();
						
							$survey_id 							= 	$worksheet->getCellByColumnAndRow(3, $row)->getValue();
						
							$survey_participant_id				= 	$worksheet->getCellByColumnAndRow(4, $row)->getValue();
							
							$questCount							=	'98';
							
							$rowCount							=	15;
							
							$question							=	array();
							
							for($i=98; $i<=107; $i++)
							{
								
								$question[$i]					=	$worksheet->getCellByColumnAndRow($rowCount, $row)->getValue();
										
								$rowCount++;
	
							}
	
							$participant[] 						= 	array(
								
								'survey_surveyor_id'  			=> 	$survey_surveyor_id,
								
								'company_id'  					=> 	$company_id,
								
								'program_id'  					=> 	$program_id,
								
								'survey_id'  					=> 	$survey_id,
																
								'survey_participant_id'  		=> 	$survey_participant_id,
								
								'question'  					=> 	$question
								
							);
						
						}
					
					}
				
				}
			
				$query							=	$this->membership_model->upload_program_response($participant);
				
				if($query['status'] == 'Success')
				{
					
					$response['status']			=	'Success';
					
					$response['data']			=	$query['reason'];
					
					
				}else{
					
					$response['status']			=	'Failed';
					
					$response['data']			=	$query['reason'];
										
				}
			
			}else{
				
				$response['status']			=	'Failed';
				
				$response['data']			=	'Wrong file format only Excel upload allowed';
			}
			
		}else{

			
			$response['status']			=	'Failed';
				
			$response['data']			=	'No file was selected';

		}

		
		echo json_encode($response, true);
				
		exit;
		
	}
	
	
	public function launch_program_cron()
	{
		
		
		$query			=	$this->membership_model->launch_program_cron();
		
		echo $query['message'];
		
		//$query				=	$this->membership_model->send_me_email();
		
	}
	
	public function daily_reminder_for_launched_program_cron()
	{
		
		
		$query			=	$this->membership_model->daily_reminder_for_launched_program_cron();
		
		echo $query['message'];
		
	}
	
	public function get_repeated_questions_mtn()
	{
		
		//$query			=	$this->membership_model->get_repeated_mtn_questions();
		
		$query			=	$this->membership_model->mark_mtn_questions_duplicate_to_be_deleted();
		
		//$query			=	$this->membership_model->delete_mtn_questions_without_survey_id();
		
	}
	
	public function send_mtn_participants_module()
	{
		
		$program_id		=	'6';
		
		//$program_id		=	'6';
		
		$query			=	$this->membership_model->send_participant_welcome_emails_mtn($program_id);
		
		//$query			=	$this->membership_model->get_participant_emails_id_mtn($program_id);
		
			/*$data			=	'29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, , 158, 177, , , , 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222, 223, 224, 225, 252, 253, 254, 255, 256, 257, 258, 259, 260, 261, 262, 263, 264, 265, 26, 267, 268, 269, 270, 271, 272, 273, 274, 275, 276, 277, 278, 279, 280, 281, 282, 283, 284, 285, 286, 287, 288, 289, 290, 291, 292, 293, 294, 295, 296, 297, 298, 299, 300, 301, 302, 303, 304, 305, 306, 307, 308, 309, 310, 311, 312, 313, 314, 315, 316, 317, 318, 319, 320, 321, 322, 323, 324, 325, 326, 327, 328, 329, 330, 331, 332, 333, 334, 335, 336, 337, 338, 339, 340, 341, 342, 343, 344, 345, 346, 347, 348, 349, 350, 351, 352, 353, 354, 355, 356, 357, 358, 359, 360, 361, 362, 363, 364, 365, 366, 367, 368, 369, 370, 371, 372, 373, 374, 375, 376, 377, 378, 379, 380, 381, 382, 383, 384, 385, 386, 387, 388, 389, 390, 391, 392, 393, 394, 395, 396, 397, 398, 399, 400, 401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413, 414, 415, 416, 417, 418, 419, 420, 421, 422, 423, 424, 425, 426, 427, 428, 429, 430, 431, 432, 433, 434, 435, 436, 437, 438, 439, 440, 441, 442, 443, 444, 445, 446, 447, 448, 449, 450, 451, 452, 453, 454, 455, 456, 457';
		
		$res			=	explode(',', $data);
		
		print_r($res);
		
		$num			=	457;
		
		echo '<br /><br />';
		
		if(in_array($num, $res)) {
								
			echo "Found Number ".$num;
			
		}else{
			
			echo "Number not found ";
		}
		*/
	}
	
	public function send_mtn_participants_module_second()
	{
		
		//$program_id		=	'6';
		
		$program_id		=	'8';
		
		$query			=	$this->membership_model->send_participant_welcome_emails_mtn($program_id);
		
	}
	
	/* lanre's code begins here */
		
	// analyze module
	public function analyze()
	{		
		
		$this->is_logged_in();
		
		$data['title'] 						=	"Analyse :: PIPA";
		
		$data['menu_status']				=	'analyse';			
		
		$company_id 						= 	$this->session->userdata('company_id');
		
		$data['programs']					=	$this->analyze_model->program_list($company_id);
		
		$program_id 						= 	0; //default
		
		$data['analyze_summary']			= 	$this->analyze_model->fetch_summary($program_id); 	
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/analyze');
		$this->load->view('admin/templates/footer');
	} 
	 
	public function fetch_analyze_summary($program_id)
	{
		$analyze_summary					= 	$this->analyze_model->fetch_summary($program_id); 	
		//adding data to session 
		$this->session->set_userdata('program_id',$program_id); 
		echo json_encode(array(
			"competency" => $analyze_summary 
		));
	}	
	
	public function assessment_360()
	{ 
		$data['title'] 						=	"Analyse :: PIPA";
		$data['menu_status']				=	'analyse';	

		$company_id 						= 	$this->session->userdata('company_id');		
		$program_id 						= 	$this->session->userdata('program_id'); 

		$data['all_participants'] 			= 	$this->analyze_model->fetch_participant($program_id); 	 		
		$data['surveys']					=	$this->analyze_model->fetch_past_surveys($company_id,'360 assessment', 'multi');

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/assessment-360');
		$this->load->view('admin/templates/footer');
	} 

	public function fetch_daterange()
	{		
		$program_id 						= 	$this->session->userdata('program_id'); 
		$data 								= 	$this->analyze_model->fetch_program_daterange($program_id);
		echo json_encode(array(
			"date_range" => $data 
		));
	}
	
	public function fetch_chart_data($date_selected = '')
	{   
		$program_id 						= 	$this->session->userdata('program_id'); 
		$response_category_aggregates 		= 	$this->analyze_model->fetch_response_aggregates($program_id, $date_selected);
		$total_leader 						= 	$response_category_aggregates ? $response_category_aggregates['leaders'] : 0;
		$total_peer 						= 	$response_category_aggregates ? $response_category_aggregates['peers'] : 0;
		$total_manager 						= 	$response_category_aggregates ? $response_category_aggregates['managers'] : 0;
		$total_direct_report 				= 	$response_category_aggregates ? $response_category_aggregates['direct_reports'] : 0;
		
		$surveyor_leader 					= 	$response_category_aggregates ? $response_category_aggregates['total_leaders'] : 0;
		$surveyor_peer 						= 	$response_category_aggregates ? $response_category_aggregates['total_peers'] : 0;
		$surveyor_manager 					= 	$response_category_aggregates ? $response_category_aggregates['total_managers'] : 0;
		$surveyor_direct_report 			= 	$response_category_aggregates ? $response_category_aggregates['total_direct_reports'] : 0;

		$pie_data 							= 	array(); 
		$total 								= 	$total_leader + $total_peer + $total_manager + $total_direct_report;
		$total_surveyors 					= 	$surveyor_leader + $surveyor_peer + $surveyor_manager + $surveyor_direct_report;

		array_push($pie_data, array("surveyor" => "Leaders", "total" => $total_leader, "total_surveyors" => $surveyor_leader ));
		array_push($pie_data, array("surveyor" => "Peers", "total" => $total_peer, "total_surveyors" => $surveyor_peer ));
		array_push($pie_data, array("surveyor" => "Managers", "total" => $total_manager, "total_surveyors" => $surveyor_manager ));
		array_push($pie_data, array("surveyor" => "Direct reports", "total" => $total_direct_report, "total_surveyors" => $surveyor_direct_report ));
		//total 
		echo json_encode(array(
			"pie_data" => $pie_data,
			"overall_total" => $total,
			"total_surveyors" => $total_surveyors,
		));
	} 
	
	public function fetch_radar_data($date_selected = '')
	{		
		$program_id 						= 	$this->session->userdata('program_id'); 
		$competency_aggregates 				=	$this->analyze_model->fetch_competency_aggregates($program_id);
			
		echo json_encode(array(
			"data" => $competency_aggregates
		));
	}

	public function evaluator()
	{ 
		$data['title'] 						=	"Evaluator :: PIPA";
		
		$data['menu_status']				=	'analyse';	
			
		$this->load->view('admin/templates/header', $data);
		
		$this->load->view('admin/analyze/evaluator');
		
		$this->load->view('admin/templates/footer');
	}

	public function fetch_evaluator()
	{  		
		$program_id 						= 	$this->session->userdata('program_id'); 
		
		$data['all_evaluators'] 			= 	$this->analyze_model->fetch_evaluators($program_id); 
		
		echo json_encode(array(
		
			"data" => $data 
			
		));
		
	} 
 
	public function analyze_participant($survey_participant_id = '')
	{ 
		$data['title'] 						=	"Analyze Participant :: PIPA";
		$data['menu_status']				=	'analyse';	 
		$data['program_id']					=	$this->session->userdata('program_id'); 
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/analyze-participant');
		$this->load->view('admin/templates/footer');
	}   
	
	public function analyze_me($slug = '')
	{ 
		$data['title'] 						=	"Analyze Me :: PIPA";
		$data['menu_status']				=	'analyse';	

		$slug_chunk 						=	explode("-", $slug);
		$survey_participant_id 				=	$slug_chunk[0];
		$survey_id							=	$slug_chunk[1]; 
				
		$company_id 						= 	$this->session->userdata('company_id'); 
		$data['programs']					=	$this->analyze_model->fetch_program_surveys($company_id, $survey_participant_id, '360 assessment');
			
		//get program id and set it
		$program_id							=	$this->analyze_model->fetch_program_id($company_id, $survey_id);
		$this->session->set_userdata('program_id',$program_id);  		

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/analyze-me');
		$this->load->view('admin/templates/footer');
	}   
		
	public function fetch_analyze_surveyors($survey_participant_id = '')
	{  
		$program_id 						= 	$this->session->userdata('program_id'); 
		$data['surveyors'] 					= 	$this->analyze_model->fetch_analyze_surveyors($program_id, $survey_participant_id);
		echo json_encode(array(
			"data" => $data,
			"program_id" => $program_id,
			"employee_number" => $employee_number 
		));
	} 

	public function fetch_competencies_radar_score($survey_participant_id = '')
	{  
		$program_id 						= 	$this->session->userdata('program_id');  
		$data['competencies_radar_score'] 	= 	$this->analyze_model->fetch_competencies_radar_score($program_id, $survey_participant_id); 
		echo json_encode(array(
			"data" => $data,
			"program_id" => $program_id,
			"employee_number" => $employee_number 
		));
	} 
	
	public function fetch_competencies_question_score($survey_participant_id = '', $survey_competency_id = '')
	{   
		$program_id 							= 	$this->session->userdata('program_id');  
		$data['competencies_question_score'] 	= 	$this->analyze_model->fetch_competencies_question_score($program_id, $survey_participant_id, $survey_competency_id); 
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
		$data['open_ended_response'] 		= 	$this->analyze_model->open_ended_response($program_id, $survey_participant_id);
		echo json_encode(array(
			"data" => $data,
			"program_id" => $program_id,
			"employee_number" => $employee_number 
		));
	}  

	//compare participant
	public function compare_participants($survey_participant_id = '')
	{   
		$data['title'] 						=	"Compare Participant :: PIPA";
		$data['menu_status']				=	'analyse';	
		$data['program_id']					=	$this->session->userdata('program_id'); 
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/compare-participants');
		$this->load->view('admin/templates/footer');
	}   

	public function fetch_comparison_analyze_surveyors()
	{
		$program_id 					= 	$this->session->userdata('program_id');  
		$participants 					= 	$this->input->post('participants');

		$response						= 	$this->analyze_model->fetch_comparison_analyze_surveyors($program_id, $participants); 
						
		echo json_encode(array(
			"surveyors" => $response, 
			"program_id" => $program_id, 
			"participants" => $participants, 
		));
	}

	public function fetch_comparison_radar_score()
	{
		$program_id 					= 	$this->session->userdata('program_id');  
		$participants 					= 	$this->input->post('participants');

		$response						= 	$this->analyze_model->fetch_comparison_radar_score($program_id, $participants); 
						
		echo json_encode(array(
			"competencies_radar_score" => $response, 
			"participants" => $participants,  
		));
	}

	public function fetch_comparison_question_score()
	{   
		$program_id 							= 	$this->session->userdata('program_id');    
		$participants 							= 	$this->input->post('participants');   
		$survey_competency_id 					= 	$this->input->post('survey_competency_id');

		$competencies_question_score 	= 	$this->analyze_model->fetch_comparison_question_score($program_id, $participants, $survey_competency_id); 
		echo json_encode(array(
			"competencies_question_score" => $competencies_question_score,
			"program_id" => $program_id,
			"participants" => $participants,
			"survey_competency_id" => $survey_competency_id
		));
	}  

	// benchmark program
	public function benchmark_program()
	{ 
		$data['title'] 						=	"Benchmark Program :: PIPA";
		$data['menu_status']				=	'analyse';	
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/benchmark-program');
		$this->load->view('admin/templates/footer');
	}   

	public function fetch_benchmark_radar_score($past_program_id)
	{
		$company_id 					= 	$this->session->userdata('company_id');
		$program_id 					= 	$this->session->userdata('program_id');    

		$response						= 	$this->analyze_model->fetch_benchmark_radar_score($program_id, $past_program_id, $company_id); 
		$current_survey					= 	$this->analyze_model->fetch_surveys($program_id,'360 assessment', 'single'); 
		$past_survey					= 	$this->analyze_model->fetch_surveys($past_program_id,'360 assessment', 'single');
						
		echo json_encode(array(
			"competencies_radar_score" => $response, 
			"current_survey" => $current_survey, 
			"past_survey" => $past_survey, 
		));
	}

	public function download_pending_evaluators()
	{
		$program_id 				= 	$this->session->userdata('program_id'); 		
		$base_url 					= 	$this->input->post('base_url');
		$pending_evaluators			= 	$this->analyze_model->download_pending_evaluators($base_url, $program_id); 

		echo json_encode(array(
			"base_url" => $base_url, 
			"pending_evaluators" => $pending_evaluators
		)); 
	} 

	public function response_rate_criteria($filter = 'company')
	{
		$program_id 					= 	$this->session->userdata('program_id');    
		$response_rate_criteria			= 	$this->analyze_model->response_rate_criteria($program_id, $filter); 

		echo json_encode(array(
			"filter" => $filter, 
			"response_rate_criteria" => $response_rate_criteria
		)); 
	} 

	public function action_plan($program_id = '', $action_plan_id = '')
	{				
		$this->is_logged_in();
		
		$data['title'] 						=	"Action Plan :: PIPA";
		
		$data['menu_status']				=	'analyse';		 
		 		
		$program_id 						= 	$this->session->userdata('program_id');    
		$data['enforcers']					= 	$this->analyze_model->fetch_enforcer($program_id); 	
		$survey 							= 	$this->analyze_model->fetch_surveys($program_id,'360 assessment', 'single');
		$survey_id 							=	$survey['survey_id'];

		$this->form_validation->set_error_delimiters('<div class="alert alert-error">','</div>');
		
		$this->form_validation->set_rules('specific_plans', 'Specific Plans', 'trim|required');
		$this->form_validation->set_rules('desired_outcome', 'Desired Outcome', 'trim|required');
		$this->form_validation->set_rules('resources_needed', 'Resources Needed', 'trim|required');
		$this->form_validation->set_rules('program_owner_id', 'Program Owner', 'trim|required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');

		if($this->form_validation->run() == FALSE)
		{
			if(!empty($action_plan_id)){
				
				$edit_data 							=	$this->analyze_model->fetch_action_plans($program_id, $action_plan_id);

				$data['action_plan_id']				=	$edit_data['action_plan_id'];

				$data['specific_plans']				=	$edit_data['specific_plans'];

				$data['desired_outcome']			=	$edit_data['desired_outcome'];

				$data['resources_needed']			=	$edit_data['resources_needed'];

				$data['program_owner_id']			=	$edit_data['program_owner_id'];

				$data['start_date']					=	$edit_data['start_date'];

				$data['end_date']					=	$edit_data['deadline_date']; 

			}  

			$data['program_id']						= 	$program_id;
			$this->load->view('admin/templates/header', $data);
			$this->load->view('admin/analyze/action-plan');
			$this->load->view('admin/templates/footer');
		
		}else{
			if($this->input->server('REQUEST_METHOD') == 'POST'){

				//handle post or update here 				
				$save['program_id']					= 	$program_id; 
				
				$save['survey_id']					= 	$survey_id; //get survey_id

				$save['specific_plans']				= 	$this->input->post('specific_plans');
				
				$save['desired_outcome']			= 	$this->input->post('desired_outcome');
				
				$save['resources_needed']			= 	$this->input->post('resources_needed'); 

				$save['program_owner_id']			= 	$this->input->post('program_owner_id');

				$save['created_by_id']				= 	$this->session->userdata('user_id');		

				$save['date_created']				= 	date("Y-m-d H:i:s");

				$save['start_date']					= 	$this->input->post('start_date');

				$save['deadline_date']				= 	$this->input->post('end_date'); 

				$save['action_plan_id']				= 	$action_plan_id; //for update

				// save brand 

				// echo json_encode($save)
				if(empty($save['action_plan_id'])){ 
					$save['status']			= 	'Not Started'; 
				}
				
				if(!empty($save['survey_id'])){ 
					$action_plan_id					= 	$this->analyze_model->save_action_plan($save); 
				}

				if(!empty($action_plan_id)) // if the user's credentials validated...
				{					
					
					!empty($save['action_plan_id']) ? $this->session->set_flashdata('message', 'Action plan updated successfully') : $this->session->set_flashdata('message', 'Action plan created successfully');
					
					redirect(base_url().'admin/program_action_plans/'.$program_id.'/');
					
				}
				else 
				{

					$this->session->set_flashdata('error', 'An error occured while performing Program operation, Try Again.');
					
					//go back to the brand list
					// redirect(base_url().'admin/action_plan/');
				
				} 
			}
		};
	} 

	public function program_action_plans($program_id = '')
	{
		$this->is_logged_in();
		
		$data['title'] 						=	"Program Action Plans :: PIPA";
		
		$data['menu_status']				=	'analyse';	 

		$data['action_plans']				= 	$this->analyze_model->fetch_action_plans($program_id);  

		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/program-action-plans');
		$this->load->view('admin/templates/footer');
	} 

	public function update_action_status()
	{		
		$status					= 	$this->input->post('status');	

		$action_plan_id			= 	$this->input->post('action_plan_id'); 

		$action_plan_id			= 	$this->analyze_model->save_action_plan_status($action_plan_id, $status); 

		echo json_encode(array( 
			'status' => $status,
			'action_plan_id' => $action_plan_id,
			'message' => $action_plan_id ? 'success' : 'error'
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
		
	public function test($date_selected = '')
	{ 
		$this->analyze_model->fetch_competencies_radar_score(6, 339);
	}
	
	public function response_rate()
	{ 
		$data['title'] 						=	"Analyse :: PIPA";
		$data['menu_status']				=	'analyse';	
		$company_id 						= 	$this->session->userdata('company_id');		
		$program_id 						= 	$this->session->userdata('program_id'); 
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/response-rate');
		$this->load->view('admin/templates/footer');
	} 
	
	public function fetch_pmf_radar_score($survey_participant_id = '')
	{  
		$program_id 						= 	$this->session->userdata('program_id');  
		$data['competencies_radar_score'] 	= 	$this->analyze_model->fetch_pmf_radar_score($program_id, $survey_participant_id); 
		echo json_encode(array(
			"data" => $data,
			"program_id" => $program_id,
			"survey_participant_id" => $survey_participant_id 
		));
	}
	
	public function fetch_pmf_competencies_radar_score($survey_participant_id = '')
	{  
		$program_id 						= 	$this->session->userdata('program_id');  
		$data['competencies_radar_score'] 	= 	$this->analyze_model->fetch_pmf_competencies_radar_score($program_id, $survey_participant_id); 
		echo json_encode(array(
			"data" => $data,
			"program_id" => $program_id,
			"survey_participant_id" => $survey_participant_id 
		));
	}
	 
	public function request_feedback()
	{ 
		$email					= 	$this->input->post('email');
		$name					= 	$this->input->post('name');
		$relationship			= 	$this->input->post('relationship');
		$question				= 	$this->input->post('question');
		$response				= 	$this->input->post('response');
		$survey_question_id		= 	$this->input->post('qid');
		$surveyor_id			= 	$this->input->post('surveyor');
		$participant_id			= 	$this->input->post('participant');
		$request_feedback_sent	= 	$this->analyze_model->send_request_feedback_email($email, $name, $question, $response, $survey_question_id, $surveyor_id, $participant_id); 
		echo json_encode(array( 
			'status' => $status,
			'data' => array(
				'email' => $email,
				'name' => $name,
				'relationship' => $relationship,
				'question' => $question,
				'response' => $response,
				'survey_question_id' => $survey_question_id,
				'surveyor_id' => $surveyor_id,
				'participant_id' => $participant_id
			),
			'message' => $request_feedback_sent ? 'success' : 'error'
		));
	} 
	
	public function fetch_pmf_question_criteria_scores($survey_participant_id = '')
	{
		$program_id 						= 	$this->session->userdata('program_id');  
		$data['competencies_radar_score'] 	= 	$this->analyze_model->fetch_pmf_question_criteria_scores($program_id, $survey_participant_id); 
		echo json_encode(array(
			"data" => $data,
			"program_id" => $program_id,
			"survey_participant_id" => $survey_participant_id 
		));
	}
	
	public function upload_hidden_tmp()
	{
		$this->analyze_model->upload_hidden_tmp();
	}
	
	public function engagement_survey()
	{		
		
		$this->is_logged_in();
		
		$data['title'] 						=	"Analyse :: PIPA";
		
		$data['menu_status']				=	'analyse';			
		
		$company_id 						= 	$this->session->userdata('company_id');
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/engagement-survey');
		$this->load->view('admin/templates/footer');
	} 

	public function pulse_survey()
	{		
		
		$this->is_logged_in();
		
		$data['title'] 						=	"Pulse Survey:: PIPA";
		
		$data['menu_status']				=	'analyse';			
		
		$company_id 						= 	$this->session->userdata('company_id');
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/pulse-survey');
		$this->load->view('admin/templates/footer');
	} 

	public function stretch_assignment()
	{		
		
		$this->is_logged_in();
		
		$data['title'] 						=	"Pulse Survey:: PIPA";
		
		$data['menu_status']				=	'analyse';			
		
		$company_id 						= 	$this->session->userdata('company_id');
		
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/analyze/stretch-assignment');
		$this->load->view('admin/templates/footer');
	} 
	
	/* lanre's code ends here */
	
}

?>