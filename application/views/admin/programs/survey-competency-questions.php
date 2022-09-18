  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
  	   <!-- Content Header (Page header) -->
    <section class="content-header">

      
    </section>
    
    <!-- Main content -->
    <section class="content">
    	
        <div class="row">
        
            <div class="col-xs-12 col-md-12 minimum-content-margin">
                
                <?php
                         
                    echo validation_errors(); 
                
                    if ($this->session->flashdata('error')):
                    
                ?>
                    
                    <div class="alert alert-error">
                       
                        <a class="close" data-dismiss="alert">×</a>
                        
                        <?php echo $this->session->flashdata('error');?>
                        
                    </div>
                    
                <?php 
				
				endif;
				
				?>
                
                <?php 
				
				if ($this->session->flashdata('message')):
				
				?>
                                
                <div class="alert alert-info">
                   
                    <a class="close" data-dismiss="alert">×</a>
                   
                    <?php echo $this->session->flashdata('message');?>
                
                </div>
                                
                <?php 
				
				endif;
				
				?>
                            
                <?php 
                    
                    $attr 	= array('role'=> 'form');
                    
                    echo form_open(base_url().'admin/survey-competency-questions/'.$program_id, $attr); 
                
                ?>
                
                <div class="setup-form-header-arrow-bck">
                            
                    <a href="<?php echo base_url(); ?>admin/leadership-assessment/<?php echo $program_id; ?>/" class="text-blue fixed-backnav">
                                                   
                        <i class="fa fa-arrow-left"></i>
                    
                    </a>
                
                </div> 
                            
                <div class="nav-tabs-custom">
                
                    <ul class="nav nav-tabs">
                    
                      <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Standard Competencies</a></li>
                    
                      <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Optional Competencies</a></li>
        
                    </ul>
                
                    <div class="tab-content">
                    
                        <div class="tab-pane active" id="tab_1" style="overflow:auto;">
                          
                            <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                            
                                <div class="col-xs-12 col-md-3 no-pad-left no-pad-right-mob">
                                
                                	<?php
										
										$notifi_color		=	array(
											
											'0'				=>	'blue',
											
											'1'				=>	'green',
											
											'2'				=>	'red',
											
											'3'				=>	'purple',
											
											'4'				=>	'lightGreen',
											
											'5'				=>	'orange',
											
											'6'				=>	'lighBlue',
										
										);
										
									?>
                    				
                                    <div class="competency-upper-title-holder">
                                    	                                        
                                        Competencies
                                        
                                    </div>
                                    
                                    <div class="competency-holder">
                                    	
                                        <ul>
                                        	
                                            <?php
											
											if(!empty($standard_competency))
											{
												$competencyBorderCount		=	0;
												
												$first_main_count			=	1;
												
												foreach($standard_competency as $standard)
												{
													
													if($first_main_count	==	'1')
													{
														
														$first_main_container	=	'competency-list-active';
														
													}else{
													
														$first_main_container	=	'';
													
													}
													
													echo '<li class="competency-holder-list-color-'.$notifi_color[$competencyBorderCount].' '.$first_main_container.' competency-lst survey-standard-clicked-side-question surv-standard-general-'.$standard['competency_id'].'" lang="'.$standard['competency_id'].'">
														
														<div class="competency-holder-container">
															
															<div class="col-xs-9 col-md-9">
																
																<div class="competency-holder-question">
																	
																	<div class="competency-holder-question-title">
																	
																		'.$standard['competency'].'
																	
																	</div>
																	
																	<div class="competency-holder-question-num-question">
																	
																		<span>'.sizeof($standard['questions']).'</span> Questions
																		
																	</div>
																	
																</div>
																
															</div>
															
															<div class="col-xs-3 col-md-3">
																
																<div class="form-group competency-holder-check">
																	
																	<label>
																	
																	  <input type="checkbox" class="minimal surv-standardcheck-checkbox surv-stand-checkbox-'.$standard['competency_id'].'" value="'.$standard['competency_id'].'" lang="'.$standard['competency_id'].'">
																	
																	</label>
																	
																</div>
																
															</div>
															
														</div>
														
													</li>';
													
													$competencyBorderCount++;
												
													if($competencyBorderCount > 6)
													{
														
														$competencyBorderCount	=	0;
														
													}
													
													$first_main_count++;
												}
											
											}
                                            
											?>
                                        </ul>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-9 quest-container no-pad-left-mob" >
                                	
                                    <?php
									if (!$this->agent->is_mobile())
									{
										
									}else{
									
									?>
                                    
                                    <div class="competency-upper-title-holder">
                                    	
                                        Questions
                                        
                                    </div>
                                    
                                    <?php 
									}
									
									if(!empty($standard_competency))
									{
										
										$first_count		=	1;

										foreach($standard_competency as $quest)
										{
											if($first_count	==	'1')
											{
												
												$first_container	=	'';
												
											}else{
											
												$first_container	=	'display:none;';
											
											}
										
											echo '<div class="survey-main-questions-container surv-standard-cont survey-clicked-standard-main-question-'.$quest['competency_id'].'" style="'.$first_container.'">
												
												<div class="survey-main-questions-header">
													
													<div class="co-xs-12 col-md-12 no-pad-left ">
														
														<div class="col-xs-12 col-md-8 no-pad-left no-pad-right">
															
															<div class="surv-question-sect">
															
																'.$quest['competency'].'
															
															</div>
															
														</div>
														
														<div class="col-xs-12 col-md-4 no-pad-left no-pad-right">
														
															<span class="btn btn-primary surv-standard-btn-appr approve-standard-'.$quest['competency_id'].'" lang="'.$quest['competency_id'].'">
																
																Approve Competency
																
															</span>
														
															<span class="btn btn-primary surv-standard-btn-remove disapprove-standard-'.$quest['competency_id'].'" lang="'.$quest['competency_id'].'" style="display:none;">
																
																Remove Competency
																
															</span>
																			
														</div>
														
													</div>
												
												</div>
												
												<div class="survey-main-questions-list">
													
													<ul>';
													
													$count    =	1;
													
													foreach($quest['questions'] as $question)
													{
												
														echo '<li>
														
															<div class="col-xs-12 col-md-3 no-pad-left">
																
																<div class="survey-main-questions-list-question">
																	
																	Question '.$count.':
																	
																</div>
																
															</div>
															
															<div class="col-xs-12 col-md-9 no-pad-left">
																
																<div class="survey-main-questions-list-question-text">
																	
																	'.$question['question'].'
																	
																</div>
																
															</div>
														
														</li>';
														
														$count++;
													}
													
													echo '</ul>
													
												</div>

											</div>';
											
											$first_count++;
										}
										
									}
                                    
									?>
                                </div>
                            
                            </div>
                        
                        </div>
                        
                        <div class="tab-pane" id="tab_2" style="overflow:auto;">
                          
                            <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                            
                                <div class="col-xs-12 col-md-3 no-pad-left no-pad-right-mob">
                                
                                	<?php
										
										$notifi_color		=	array(
											
											'0'				=>	'blue',
											
											'1'				=>	'green',
											
											'2'				=>	'red',
											
											'3'				=>	'purple',
											
											'4'				=>	'lightGreen',
											
											'5'				=>	'orange',
											
											'6'				=>	'lighBlue',
										
										);
									?>
                    				
                                    <div class="competency-upper-title-holder">
                                    	
                                        Competencies
                                        
                                    </div>
                                    
                                    <div class="competency-holder">
                                    	
                                        <ul>
                                        	
                                            <?php
											
											if(!empty($optional_competency))
											{
												$competencyBorderOptionalCount			=	0;
												
												$first_main_optional_count				=	1;
												
												foreach($optional_competency as $optional)
												{
													
													if($first_main_optional_count	==	'1')
													{
														
														$first_main_optional_container	=	'competency-list-active';
														
													}else{
													
														$first_main_optional_container	=	'';
													
													}
													
													echo '<li class="competency-holder-list-color-'.$notifi_color[$competencyBorderOptionalCount].' '.$first_main_optional_container.' competency-opt-lst survey-optional-clicked-side-question surv-optional-general-'.$optional['competency_id'].'" lang="'.$optional['competency_id'].'">
														
														<div class="competency-holder-container">
															
															<div class="col-xs-9 col-md-9">
																
																<div class="competency-holder-question">
																	
																	<div class="competency-holder-question-title">
																	
																		'.$optional['competency'].'
																	
																	</div>
																	
																	<div class="competency-holder-question-num-question">
																	
																		<span>'.sizeof($optional['questions']).'</span> Questions
																		
																	</div>
																	
																</div>
																
															</div>
															
															<div class="col-xs-3 col-md-3">
																
																<div class="form-group competency-holder-check">
																	
																	<label>
																	
																	  <input type="checkbox" disabled="disabled" class="minimal surv-optionalcheck-checkbox surv-option-checkbox-'.$optional['competency_id'].'" value="'.$optional['competency_id'].'" lang="'.$optional['competency_id'].'">
																	
																	</label>
																	
																</div>
																
															</div>
															
														</div>
														
													</li>';
													
													$competencyBorderOptionalCount++;
												
													if($competencyBorderOptionalCount > 6)
													{
														
														$competencyBorderOptionalCount	=	0;
														
													}
													
													$first_main_optional_count++;
												}
											
											}
                                            
											?>
                                        </ul>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-9 quest-container no-pad-left-mob" >
                                	
                                     <?php
									if (!$this->agent->is_mobile())
									{
										
									}else{
									
									?>
                                    
                                    <div class="competency-upper-title-holder">
                                    	
                                        Questions
                                        
                                    </div>
                                    
                                    <?php 
									}
									
									if(!empty($optional_competency))
									{
										
										$first_optional_count		=	1;

										foreach($optional_competency as $quest)
										{
											if($first_optional_count	==	'1')
											{
												
												$first_optional_container	=	'';
												
											}else{
											
												$first_optional_container	=	'display:none;';
											
											}
										
											echo '<div class="survey-main-questions-container surv-optional-cont survey-clicked-optional-main-question-'.$quest['competency_id'].'" style="'.$first_optional_container.'">
												
												<div class="survey-main-questions-header">
													
													<div class="surv-question-sect">
													
														'.$quest['competency'].'
													
													</div>
													
												</div>
												
												<div class="survey-main-questions-list">
													
													<ul>';
													
													$count    =	1;
													
													foreach($quest['questions'] as $question)
													{
												
														echo '<li>
														
															<div class="col-xs-12 col-md-3 no-pad-left">
																
																<div class="survey-main-questions-list-question">
																	
																	Question '.$count.':
																	
																</div>
																
															</div>
															
															<div class="col-xs-12 col-md-9 no-pad-left">
																
																<div class="survey-main-questions-list-question-text">
																	
																	'.$question['question'].'
																	
																</div>
																
															</div>
															
															<div class="col-xs-12 col-md-12 no-pad-left">
																
																<div class="col-xs-12 col-md-3 no-pad-left">
																
																</div>
																
																<div class="col-xs-12 col-md-9 no-pad-left">
																	
																	<div class="surv-optional-btn">
																	
																		<span class="btn surv-optn-btn-appr surv-opt-appr-'.$question['question_template_id'].'" lang="'.$question['question_template_id'].'" dir="'.$quest['competency_id'].'">
																			
																			Approve
																			
																		</span>
																		
																		<span class="btn btn-danger surv-optn-btn-remove check-opt-rem-'.$quest['competency_id'].' surv-opt-remove-'.$question['question_template_id'].' surv-btn-appr-dull" lang="'.$question['question_template_id'].'" dir="'.$quest['competency_id'].'">
																			
																			Remove
																			
																		</span>
																	
																	</div>
																	
																</div>
																
															</div>
															
														</li>';
														
														$count++;
													}
													
													echo '</ul>
													
												</div>
											
											</div>';
											
											$first_optional_count++;
										}
										
									}
                                    
									?>
                                </div>
                            
                            </div>
                        
                        </div>
                    
                    </div>
                    
                </div>
                
            </div>
        	
            <div class="col-xs-12 col-md-12 admin-form-row">
                    
                <div class="col-xs-12 col-md-4 no-pad-left">
                    
                    <div class="form-group">
						
                        <input type="text" class="standard_hldr" name="standard_competencies" value="<?php if(!empty($standard_competency_selected)){  echo $standard_competency_selected; } ?>" style="display:none;" />
                        
                        <input type="text" class="optional_hldr" name="optional_competencies" value="<?php if(!empty($optional_competency_questions_selected)){  echo $optional_competency_questions_selected; } ?>" style="display:none;" />
                        
                        <script>
						
							
							$(document).ready(function(e) {
                            	
								if($('.standard_hldr').val() != '')
								{
									
									var standardhldLoad					=	$('.standard_hldr').val();
									
									var replaceLastVal					=	standardhldLoad.substring(0, standardhldLoad.length - 1);
												
									var pageloadres 					= 	replaceLastVal.split(",");
									
									$.each(pageloadres, function(index, value) {

										$('.surv-stand-checkbox-'+value+'').iCheck('toggle');
										
										$('.surv-standard-general-'+value+'').addClass('competency-list-selected');
			
										$('.disapprove-standard-'+value+'').show();
									
										$('.approve-standard-'+value+'').hide();
												
									});
										
		
								}else{
									
										
									
								}
								
								if($('.optional_hldr').val() != '')
								{
									
									var optionalhldLoad					=	$('.optional_hldr').val();
									
									var replaceOptLastVal				=	optionalhldLoad.substring(0, optionalhldLoad.length - 1);
												
									var pageOptionalloadres 			= 	replaceOptLastVal.split(",");
									
									$.each(pageOptionalloadres, function(indexs, values) {

										
										var load_competency_id 					= 	$('.surv-opt-appr-'+values+'').attr('dir');
			
										var load_competency_question_id 		= 	values;
			
										if($('.surv-option-checkbox-'+load_competency_id+'').is(':checked'))
										{
															
										}else{
											
											$('.surv-option-checkbox-'+load_competency_id+'').iCheck('toggle');
											
											$('.surv-optional-general-'+load_competency_id+'').addClass('competency-list-selected');
															
										}
											
											
										$('.surv-opt-appr-'+values+'').addClass('surv-btn-appr-dull');
			
										$('.surv-opt-remove-'+load_competency_question_id+'').removeClass('surv-btn-appr-dull');
										
										$('.surv-opt-remove-'+load_competency_question_id+'').addClass('check-opt-rem-approved-'+load_competency_id+'');
	
									});
										
		
								}else{
									
										
									
								}
								    
                            });
							
						</script>
                                           
                    </div>
        
                </div>
                
                <div class="col-xs-12 col-md-7 no-pad-left">
                    
                    <div class="form-group admin-form-setup" style="border-bottom:none;">
                         
                        <button type="submit" class="btn btn-primary">Done</button>
                        
                    </div>
                    
                </div>
                
            </div>
                    
            </form>
            
        </div>
      
    </section>
    
  </div>