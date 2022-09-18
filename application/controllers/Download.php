<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Download extends CI_Controller {
	
  function __construct()
  {
		parent::__construct();
		//$this->load->helper(array('form', 'url'));
		$this->load->helper('download');
	}
  
  //index, just load the main page
	public function index() {


		//load the view/download.php
		//$this->load->view('templates/download');
		
	}
		//IF download/plaintext,
	public function plaintext() {
		//load the download helper
		$this->load->helper('download');
		//set the textfile's content 
		$data = 'Hello world! Codeigniter rocks!';
		//set the textfile's name
		$name = 'filedownload.txt';
		//use this function to force the session/browser to download the created file
		force_download($name, $data);
	}
		//IF download/upload,
	public function upload() {
		//load the download helper
		$this->load->helper('download');
		//Get the file from whatever the user uploaded (NOTE: Users needs to upload first), @See http://localhost/CI/index.php/upload
		$data = file_get_contents("./uploads/image_upload.jpg");
		//Read the file's contents
		$name = 'niceupload.jpg';

		//use this function to force the session/browser to download the file uploaded by the user 
		force_download($name, $data);
	}
	
	
	public function brochure($id) 
	{
		if(empty($id))
		{
			show_404();
			
		}else{
			
			
			$data['title']				=	'Download';
			$data['brochure']			=	$id;
			
			$this->load->model('site_model');
			
			$data['products_list']		=	$this->site_model->get_all_products();
			
			//load the download helper
			
			//Get the file from whatever the user uploaded (NOTE: Users needs to upload first), @See http://localhost/CI/index.php/upload
			//$data 			= 	file_get_contents("./uploads/brochure/".$id."");
			
			//Read the file's contents
			//$name 			= 	'Honda.pdf';
	
			//use this function to force the session/browser to download the file uploaded by the user 
			//force_download($name, $data);
			
			$this->load->view('templates/header', $data);
			$this->load->view('pages/brochure', $data);
			$this->load->view('templates/footer', $data);
		
		}
	}
	
	public function participant_template() 
	{
		
		$file				=	'participant-template.xlsx';
		
		if(empty($file))
		{
			show_404();
			
		}else{
			
			//load the download helper
			
			//Get the file from whatever the user uploaded (NOTE: Users needs to upload first), @See http://localhost/CI/index.php/upload
			$data 			= 	file_get_contents("./uploads/wysiwyg/template/".$file."");
			
			//Read the file's contents
			$name 			= 	$file;
	
			//use this function to force the session/browser to download the file uploaded by the user 
			force_download($name, $data);
		
		}
	}

}
