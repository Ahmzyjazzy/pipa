<?php
class Pages extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: POST");
	
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

		$this->load->model('site_model');
	}
		
	public function view($page = 'home')
	{
		if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
		{
				// Whoops, we don't have a page for that!
				show_404();
		}
		
		$this->visitor_agent($page);

		$data['title'] 				= 	ucfirst($page)." :: Pipa"; // Capitalize the first letter
		
		
		$this->load->view('templates/header', $data);
		
		$this->load->view('pages/'.$page, $data);
		
		$this->load->view('templates/footer', $data);
	}

	
	public function visitor_agent($page = false)
	{

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
		elseif ($this->agent->is_robot())
		{
			$agent 		= 	$this->agent->robot();
			
			$medium 	= 	"robot";
		}
		else
		{
			$agent 		= 	'Unidentified User Agent';
			
			$medium 	= 	"";
		}
		
		$ip 			= 	$this->input->ip_address();
		
		$date 			= 	date('Y-m-d H:i:s');
		
		$this->site_model->visitor_medium($medium,$agent,$ip,$date,$page);
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
	
}