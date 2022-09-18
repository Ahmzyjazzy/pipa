  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
   <!-- Content Header (Page header) -->
    <section class="content-header">

      
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="tab-page--container">

            <div class="row">
            
                <div class="col-md-12 analyze-header-wrapper">
            
                    <section class="analyze-header-tab">
                    
                        <ul class="border-bottom nav nav-tabs">
            
                            <li class="active mr-3 pb-2"> 
            
                                <a data-toggle="tab" href="#analyze" class="text-md header-title border-0">My Surveys</a>
            
                            </li>
            
                        </ul>                        
            
                    </section> 
            
                </div>
            
            </div> 

            <div class="row">
            
                <div class="col-md-12" style="padding: 0">
            
                    <div class="tab-content">

                        <div id="analyze" class="tab-pane fade in active">
                            
                            <section class="row table-wrapper">
            
                                <div class="col-md-12">

                                    <div class="table-responsive">
            
                                        <table class="table display nowrap" id="dt_evaluator" style="width:100%">
                                        
                                            <thead>
                                        
                                                <tr class="dark-text">
                                        
                                                    <th scope="col">Survey</th>
                                        
                                                    <th scope="col">Launch Date</th>
                                        
                                                    <th scope="col">Close Date</th>
                                        
                                                    <th scope="col">Status</th>
                                        
                                                    <th scope="col">Action</th>
													
                                                     <th scope="col"></th>
                                                     
                                                </tr>
                                        
                                            </thead>
                                        
                                            <tbody>
                                            	
                                                <?php
												
													if(!empty($surveys))
													{
														
														foreach($surveys as $survey)
														{
															
															if($survey['surveyQuestionSize'] == $survey['surveySelfResponse'])
															{
																
																$survStatus			= 	'<span class="btn btn-status-completed">Completed</span>';
																
																$takeSurveyBtn		=	'<a class="btn btn-participant-tkesurv-disabled" href="javascript:void(0);" >Take survey <i class="fa fa-long-arrow-right pull-right"></i></a>';
															
															}else if($survey['surveyQuestionSize'] > $survey['surveySelfResponse']){
																
																//it means the survey has not been completed
																
																if(!empty($survey['surveySelfResponse']))
																{
																	
																	$survStatus			= 	'<span class="btn btn-status-ongoing">Ongoing</span>';
																	
																	$takeSurveyBtn		=	'<a class="btn btn-participant-tkesurv" href="'.base_url().'survey/survey-questions/'.$survey['survey']['surveyDetails']['survey']['survey_id'].'/'.$survey['surveyorDetails']['survey_surveyor_id'].'/'.$survey['survey_participant_id'].'/" target="_blank">Complete survey <i class="fa fa-long-arrow-right pull-right"></i></a>';
																	
																}else{
																	
																	$survStatus			= 	'<span class="btn btn-status-pending">Not Started</span>';
																	
																	$takeSurveyBtn		=	'<a class="btn btn-participant-tkesurv" href="'.base_url().'survey/survey-questions/'.$survey['survey']['surveyDetails']['survey']['survey_id'].'/'.$survey['surveyorDetails']['survey_surveyor_id'].'/'.$survey['survey_participant_id'].'/" target="_blank">Take survey <i class="fa fa-long-arrow-right pull-right"></i></a>';
																	
																}
																																
															}
															
															$surveyAnalyzeBTN			=	'<a class="btn btn-participant-tkesurv" href="'.base_url().'participant/analyze-me/'.$survey['survey_participant_id'].'-'.$survey['surveyorDetails']['survey_id'].'" >Analyze</a>';
															
															echo '<tr>
															
																<td>
																	'.$survey['survey']['surveyDetails']['survey']['survey'].'
																</td>
																
																<td>
																	<span class="mysurv-dte">'.date('d/m/Y', strtotime($survey['survey']['surveyDetails']['surveySchedule']['start_date'])).'</span>
																</td>
																
																<td>
																	<span class="mysurv-dte">'.date('d/m/Y', strtotime($survey['survey']['surveyDetails']['surveySchedule']['end_date'])).'</span>
																</td>
																
																<td>
																	'.$survStatus.'
																</td>
																	
																<td>
																	'.$takeSurveyBtn.'
																</td>
																
																<td>
																	'.$surveyAnalyzeBTN.'
																</td>
															
															</tr>';
															
														}
														
													}else{
														
														echo '<tr>
														
															
															<td colspan="6">
																
																No record found
																
															</td>
															
														</tr>';	
														
													}
													
												?>
												
                                            </tbody>
                                        
                                        </table>
                                         
                                    </div>

                                    

                                </div>
                                
                            </section> 

                        </div>

                        <div id="option" class="tab-pane fade">

                        </div> 

                    </div> 
                
                </div>
                
            </div>

        </div> 

    </section>
    
  </div>  
  <!-- /.content-wrapper -->
