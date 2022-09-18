<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analyze extends CI_Controller {
	
	public function __construct() {
		parent::__construct();  
        $this->load->model('analyze_model');
    }

	public function index()
	{
		//TODO: $program_id from session 
		$program_id = 1;
		$analyze_summary = $this->analyze_model->fetch_summary($program_id);
		$this->load->view('layout/header', $analyze_summary);
		$this->load->view('admin/analyze/analyze');
		$this->load->view('layout/footer');
	} 

	public function assessment_360($program_id = 1)
	{ 
		//TODO: $program_id from session  
		$data['all_participants'] = $this->analyze_model->fetch_participant($program_id); 
		// echo json_encode($data['all_participants']);
		
		$this->load->view('layout/header', $data);
		$this->load->view('admin/analyze/assessment_360');
		$this->load->view('layout/footer');
	} 

	public function fetch_chart_data($program_id)
	{   
		$response_category_aggregates = $this->analyze_model->fetch_response_aggregates($program_id);
 
		$total_leader = $response_category_aggregates ? $response_category_aggregates['leaders'] : 0;
		$total_peer = $response_category_aggregates ? $response_category_aggregates['peers'] : 0;
		$total_manager = $response_category_aggregates ? $response_category_aggregates['managers'] : 0;
		$total_direct_report = $response_category_aggregates ? $response_category_aggregates['direct_reports'] : 0;

		$pie_data = array(); 
		$total = $total_leader + $total_peer + $total_manager + $total_direct_report;

		array_push($pie_data, array("surveyor" => "Leaders", "total" => $total_leader));
		array_push($pie_data, array("surveyor" => "Peers", "total" => $total_peer));
		array_push($pie_data, array("surveyor" => "Managers", "total" => $total_manager));
		array_push($pie_data, array("surveyor" => "Direct reports", "total" => $total_direct_report));

		//total 
		echo json_encode(array(
			"pie_data" => $pie_data,
			"overall_total" => $total
		));
	} 

	public function fetch_radar_data($program_id)
	{
		$competency_aggregates = $this->analyze_model->fetch_competency_aggregates($program_id);
		echo json_encode(array(
			"data" => $competency_aggregates 
		));
	}
	
	public function evaluator($program_id = 1)
	{  
		$data['all_evaluators'] = $this->analyze_model->fetch_evaluators($program_id);  
		$this->load->view('layout/header', $data);
		$this->load->view('admin/analyze/evaluator');
		$this->load->view('layout/footer');
	} 

	public function analyze_participant($participant_id = "")
	{  
		$this->load->view('layout/header');
		$this->load->view('admin/analyze/analyze_participant');
		$this->load->view('layout/footer');
	} 

	
	
}
