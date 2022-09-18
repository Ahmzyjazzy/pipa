  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
   <!-- Content Header (Page header) -->
    <section class="content-header">

      
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
      	
        <div class="col-xs-12 col-md-12">
        	
            <div class="dashb-actives">
            
                <div class="dashb-actives-welcme">
                    
                    <span>Hello <?php echo ucfirst($this->session->userdata('firstname')); ?>,</span>
                    
                </div>

            </div>
            
            <div class="col-xs-12 col-md-12 dashb-layer no-pad-left no-pad-right">
                
                
            </div>
                    
        </div>
        
      </div>
      
      <div class="row">
      	
        <div class="col-xs-12 col-md-12">
    
            <div class="col-xs-12 col-md-12 dashb-layer-column">
                
                <div class="pipa-bx">
        			
                    <?php
					
					if(!empty($surveys))
					{
						$userProgramCount	=	0;
						
						foreach($surveys as $userSurveyParticipated)
						{

							if($userProgramCount < 1)
							{
							/*	print_r($userSurveyParticipated['programDetails']['program_owner_details']);
								
								die();*/
								
								echo'<div class="col-md-4">
									
									<div class="participant-progdet">
										
										<div class="participant-progdet-top-cont">';
										
												if(!empty($company_details['company_logo']))
												{
													
													$company_logo			=	base_url().'asset/images/company-logo/'.$company_details['company_logo'];
													
												}else{
													
													
												}
								
										echo '<div class="participant-dashb-actives-img">
												
												<img src="'.$company_logo.'" height="32px;" />
												
											</div>
											
											<div class="participant-dashb-actives-name">
												
												<span>'.$userSurveyParticipated['programDetails']['program']['program_name'].'</span>
												
											</div>
																										
										</div>
										
										<div class="participant-progdet-bottom-cont">';
											
											
											if(!empty($userSurveyParticipated['programDetails']['program_owner_details']))
											{
												$ownerdet_count		=	0;
													
												echo '<span class="participant-progdet-bottom-cont-hdr">Program Owner :</span>';
												
												foreach($userSurveyParticipated['programDetails']['program_owner_details'] as $owner_det)
												{
														
													if($ownerdet_count < 1)
													{
															
														echo '<span style="color:#7E9EC2;">
															
															&nbsp;
															'.ucfirst($owner_det['first_name']).' '.ucfirst($owner_det['last_name']).'
														
														</span>
														
														<span class="pull-right">
															
															<i class="fa fa-phone"></i>
															
															&nbsp; | &nbsp;
															
															<i class="fa fa-envelope"></i>  
																	 
														</span>
														';
													
													}
													
													$ownerdet_count++;
												
												}
											
											}
											
										echo '</div>
										
									</div>
									
								</div>
								
								<div class="col-md-8">
									
									<div class="">
										
										<div class="participant-dashb-program-progress-hdr">
											
											Program Status
											
											<span class="pull-right">
												
												50% completed
												
											</span>
											
										</div>
										
										<div class="">
											
											
											<div class="progress" id="progress">
												 
												<div class="percent" id="program-percent"></div>
												
											</div>
											
											<input id="program-progressval" style="display:none;" type="number" value="50" min="0" max="100"/>';
											
											?>
											
											<script>
												
												
												const progress = document.getElementById('program-percent');
																						
												document.addEventListener('input', () => {
												  const percent = +document.querySelector('input').value;
												  if(percent >= 0 && percent <= 100) {
												  progress.style.width = 1 * percent + '%';
												  }
												});
												
												$(document).ready(function(e) {
													
													var program_progressval  = $('#program-progressval').val();
													
													if(program_progressval >= 0)
													{
														
														$('#program-percent').width(1 * program_progressval + '%');
														
													}
													
												});
			
											</script>
									  <?php   
											 
										echo '</div>
										
										<div class="participant-dashb-program-progress-date">
											
											<span>
												
												22/06/2020
												
											</span>
											
											<span class="pull-right">
												
												22/06/2020
												
											</span>
											
										</div>
										
									</div>
									
								</div>';
						
							}
							
							$userProgramCount++;
							
						}
						
					}else{
						
						//this users survey is empty which means he does not belong to any program	
						
					}
                    
                    ?>
                    
				</div>
                
            </div>
            
        </div>
        
      </div>
      
      <div class="row">
      	
        <div class="col-xs-12 col-md-12">
            
            <div class="col-xs-12 col-md-9 mike-col-9 no-pad-right no-pad-left">
            	
                <div class="col-xs-12 col-md-12">
                	
                    <div class="participant-dashb-upcom-hdr">
                    	
                        Upcoming Activity
                        
                    </div>
                    
                </div>
                
                <div class="col-xs-12 col-md-12 no-pad-right no-pad-left">
                	
                    <div class="participnt-upcom-cnt">
                    	
                        <div class="col-xs-12 col-md-3 no-pad-right participnt-upcom-cnt-img">
                        	
                            <img src="<?php echo base_url(); ?>asset/images/image-stepping.png" />
                            
                        </div>
                        
                        <div class="col-xs-12 col-md-9 no-pad-left no-pad-right no-pad-left participnt-upcom-cnt-others mike-no-pad-left">
                        	
                            <div class="upcom-main-cnt">
                            	
                                <div class="col-xs-12 col-md-4 mike-big-4 mike-no-pad-right">
                                	
                                    <div class="upcom-main-cnt-mini">
                                    	
                                        <div class="upcom-main-cnt-mini-level-1"  style="font-size:16px; font-weight:700;">
                                        	
                                            Strategic thinking class
                                            
                                        </div>
                                        
                                        <div class="upcom-main-cnt-mini-level-2">
                                        	
                                            <strong>Facilitator:</strong> &nbsp; Wale Adenuga
                                            
                                        </div>
                                        
                                        <div class="upcom-main-cnt-mini-level-3">
                                        	
                                            <div class="upcom-main-cnt-mini-level-3-left">
                                            	
                                                <a href="javascript:void(0);">
                                                	
                                                    View Bio
                                                    
                                                </a>
                                                
                                            </div>
                                            
                                            <div class="upcom-main-cnt-mini-level-3-right">
                                            	
                                                <i class="fa fa-envelope"></i>
                                                
                                                &nbsp; | &nbsp;
                                                
                                                <i class="fa fa-phone"></i>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-4 mike-small-4 mike-no-pad-right">
                                	
                                    <div class="upcom-main-cnt-mini">
                                    	
                                        <div class="upcom-main-cnt-mini-level-1">
                                        	
                                            <strong><i class="fa fa-map-marker"></i> &nbsp; Civic Center</strong>
                                            
                                        </div>
                                        
                                        <div class="upcom-main-cnt-mini-level-2">
                                        	
                                           <i class="fa fa-clock-o"></i> &nbsp; 12:30pm - 1:30pm;
                                            
                                        </div>
                                        
                                        <div class="upcom-main-cnt-mini-level-3">
                                        	
                                           <i class="fa fa-calendar"></i> &nbsp; 22/06/2020
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-4 mike-small-4 mike-no-pad-right">
                                	
                                    <div class="upcom-main-cnt-mini" style="border:none;">
                                    	
                                        <div class="upcom-main-cnt-mini-level-1">
                                        	
                                            <strong>View assignment &nbsp; <i class="fa fa-long-arrow-right"></i></strong>
                                            
                                        </div>
                                        
                                        <div class="upcom-main-cnt-mini-level-2">
                                        	
                                            
                                        </div>
                                        
                                        <div class="upcom-main-cnt-mini-level-3">
                                        	
                                           <strong> Class Chat &nbsp; &nbsp; <i class="fa fa-wechat"></i> </strong>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        		
                    </div>
                    
                </div>
                
                <div class="col-xs-12 col-md-12 no-pad-right no-pad-left">
                    
                    <div class="col-md-4">
                        
                        <div class="participant-dashb-dif-sectors-cont">
                            
                            <div class="participant-dashb-dif-sectors-cont-icon">
                                
                                <img src="<?php echo base_url(); ?>asset/images/icons/icon1.png" />
                                
                            </div>
                            
                            <div class="participant-dashb-dif-sectors-cont-rght">
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-top">
                                	
                                    Training Classes
                                    
                                     <i class="fa fa-long-arrow-right pull-right"></i>
                                     
                                </div>
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-bottom">
                                	
                                    <div>
                                     	
                                        <input id="progressval" style="display:none;" type="number" value="5" min="0" max="100"/>
                                        
                                    </div>
                                    
                                    <div class="participant-dashb-dif-sectors-cont-rght-bottom-sect">
                                    	
                                        0/4 completed
                                        
                                    </div>
                                    
                                    <div class="progress" id="progress">
                                         
                                    	<div class="percent" id="percent"></div>
                                        
                                    </div>
                                    
                                    <script>
										
										
										const progress = document.getElementById('percent');
																				
										document.addEventListener('input', () => {
										  const percent = +document.querySelector('input').value;
										  if(percent >= 0 && percent <= 100) {
										  progress.style.width = 2 * percent + 'px';
										  }
										});
										
										$(document).ready(function(e) {
                                            
											var progressval  = $('#progressval').val();
											
											if(progressval >= 0)
											{
												
												$('#percent').width(2 * progressval + 'px');
												
											}
											
                                        });

									</script>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-md-4">
                        
                        <div class="participant-dashb-dif-sectors-cont">
                            
                            <div class="participant-dashb-dif-sectors-cont-icon">
                                
                                <img src="<?php echo base_url(); ?>asset/images/icons/icon2.png" />
                                
                            </div>
                            
                            <div class="participant-dashb-dif-sectors-cont-rght">
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-top">
                                	
                                    Coaching Sessions
                                    
                                     <i class="fa fa-long-arrow-right pull-right"></i>
                                     
                                </div>
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-bottom">
                                	
                                    <div>
                                     	
                                        <input id="progressval" style="display:none;" type="number" value="5" min="0" max="100"/>
                                        
                                    </div>
                                    
                                    <div class="participant-dashb-dif-sectors-cont-rght-bottom-sect">
                                    	
                                        0/4 completed
                                        
                                    </div>
                                    
                                    <div id="progress" class="progress">
                                         
                                    	<div id="percent" class="percent"></div>
                                        
                                    </div>
                                    
                                    <script>
										
										
										const progress = document.getElementById('percent');
																				
										document.addEventListener('input', () => {
										  const percent = +document.querySelector('input').value;
										  if(percent >= 0 && percent <= 100) {
										  progress.style.width = 2 * percent + 'px';
										  }
										});
										
										$(document).ready(function(e) {
                                            
											var progressval  = $('#progressval').val();
											
											if(progressval >= 0)
											{
												
												$('#percent').width(2 * progressval + 'px');
												
											}
											
                                        });

									</script>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-md-4">
                        
                        <div class="participant-dashb-dif-sectors-cont">
                            
                            <div class="participant-dashb-dif-sectors-cont-icon">
                                
                                <img src="<?php echo base_url(); ?>asset/images/icons/icon3.png" />
                                
                            </div>
                            
                            <div class="participant-dashb-dif-sectors-cont-rght">
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-top">
                                	
                                    Field Trips
                                    
                                     <i class="fa fa-long-arrow-right pull-right"></i>
                                     
                                </div>
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-bottom">
                                	
                                    <div>
                                     	
                                        <input id="progressval" style="display:none;" type="number" value="5" min="0" max="100"/>
                                        
                                    </div>
                                    
                                    <div class="participant-dashb-dif-sectors-cont-rght-bottom-sect">
                                    	
                                        0/4 completed
                                        
                                    </div>
                                    
                                    <div id="progress" class="progress">
                                         
                                    	<div id="percent" class="percent"></div>
                                        
                                    </div>
                                    
                                    <script>
										
										
										const progress = document.getElementById('percent');
																				
										document.addEventListener('input', () => {
										  const percent = +document.querySelector('input').value;
										  if(percent >= 0 && percent <= 100) {
										  progress.style.width = 2 * percent + 'px';
										  }
										});
										
										$(document).ready(function(e) {
                                            
											var progressval  = $('#progressval').val();
											
											if(progressval >= 0)
											{
												
												$('#percent').width(2 * progressval + 'px');
												
											}
											
                                        });

									</script>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    
                    <div class="col-md-4">
                        
                        <div class="participant-dashb-dif-sectors-cont">
                            
                            <div class="participant-dashb-dif-sectors-cont-icon">
                                
                                <img src="<?php echo base_url(); ?>asset/images/icons/icon4.png" />
                                
                            </div>
                            
                            <div class="participant-dashb-dif-sectors-cont-rght">
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-top">
                                	
                                    360 assessment
                                    
                                     <i class="fa fa-long-arrow-right pull-right"></i>
                                     
                                </div>
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-bottom">
                                	
                                    <div>
                                     	
                                        <input id="progressval" style="display:none;" type="number" value="5" min="0" max="100"/>
                                        
                                    </div>
                                    
                                    <div class="participant-dashb-dif-sectors-cont-rght-bottom-sect">
                                    	
                                        0/4 completed
                                        
                                    </div>
                                    
                                    <div id="progress" class="progress">
                                         
                                    	<div id="percent" class="percent"></div>
                                        
                                    </div>
                                    
                                    <script>
										
										
										const progress = document.getElementById('percent');
																				
										document.addEventListener('input', () => {
										  const percent = +document.querySelector('input').value;
										  if(percent >= 0 && percent <= 100) {
										  progress.style.width = 2 * percent + 'px';
										  }
										});
										
										$(document).ready(function(e) {
                                            
											var progressval  = $('#progressval').val();
											
											if(progressval >= 0)
											{
												
												$('#percent').width(2 * progressval + 'px');
												
											}
											
                                        });

									</script>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-md-4">
                        
                        <div class="participant-dashb-dif-sectors-cont">
                            
                            <div class="participant-dashb-dif-sectors-cont-icon">
                                
                                <img src="<?php echo base_url(); ?>asset/images/icons/icon5.png" />
                                
                            </div>
                            
                            <div class="participant-dashb-dif-sectors-cont-rght">
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-top">
                                	
                                    Behavioral Survey
                                    
                                     <i class="fa fa-long-arrow-right pull-right"></i>
                                     
                                </div>
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-bottom">
                                	
                                    <div>
                                     	
                                        <input id="progressval" style="display:none;" type="number" value="5" min="0" max="100"/>
                                        
                                    </div>
                                    
                                    <div class="participant-dashb-dif-sectors-cont-rght-bottom-sect">
                                    	
                                        0/4 completed
                                        
                                    </div>
                                    
                                    <div id="progress" class="progress">
                                         
                                    	<div id="percent" class="percent"></div>
                                        
                                    </div>
                                    
                                    <script>
										
										
										const progress = document.getElementById('percent');
																				
										document.addEventListener('input', () => {
										  const percent = +document.querySelector('input').value;
										  if(percent >= 0 && percent <= 100) {
										  progress.style.width = 2 * percent + 'px';
										  }
										});
										
										$(document).ready(function(e) {
                                            
											var progressval  = $('#progressval').val();
											
											if(progressval >= 0)
											{
												
												$('#percent').width(2 * progressval + 'px');
												
											}
											
                                        });

									</script>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    
                    <div class="col-md-4">
                        
                        <div class="participant-dashb-dif-sectors-cont">
                            
                            <div class="participant-dashb-dif-sectors-cont-icon">
                                
                                <img src="<?php echo base_url(); ?>asset/images/icons/icon6.png" />
                                
                            </div>
                            
                            <div class="participant-dashb-dif-sectors-cont-rght">
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-top">
                                	
                                   eNPS/Pulse Survey
                                    
                                     <i class="fa fa-long-arrow-right pull-right"></i>
                                     
                                </div>
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-bottom">
                                	
                                    <div>
                                     	
                                        <input id="progressval" style="display:none;" type="number" value="5" min="0" max="100"/>
                                        
                                    </div>
                                    
                                    <div class="participant-dashb-dif-sectors-cont-rght-bottom-sect">
                                    	
                                        0/4 completed
                                        
                                    </div>
                                    
                                    <div id="progress" class="progress">
                                         
                                    	<div id="percent" class="percent"></div>
                                        
                                    </div>
                                    
                                    <script>
										
										
										const progress = document.getElementById('percent');
																				
										document.addEventListener('input', () => {
										  const percent = +document.querySelector('input').value;
										  if(percent >= 0 && percent <= 100) {
										  progress.style.width = 2 * percent + 'px';
										  }
										});
										
										$(document).ready(function(e) {
                                            
											var progressval  = $('#progressval').val();
											
											if(progressval >= 0)
											{
												
												$('#percent').width(2 * progressval + 'px');
												
											}
											
                                        });

									</script>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-md-4">
                        
                        <div class="participant-dashb-dif-sectors-cont">
                            
                            <div class="participant-dashb-dif-sectors-cont-icon">
                                
                                <img src="<?php echo base_url(); ?>asset/images/icons/icon7.png" />
                                
                            </div>
                            
                            <div class="participant-dashb-dif-sectors-cont-rght">
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-top">
                                	
                                    Engagement Survey
                                    
                                     <i class="fa fa-long-arrow-right pull-right"></i>
                                     
                                </div>
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-bottom">
                                	
                                    <div>
                                     	
                                        <input id="progressval" style="display:none;" type="number" value="5" min="0" max="100"/>
                                        
                                    </div>
                                    
                                    <div class="participant-dashb-dif-sectors-cont-rght-bottom-sect">
                                    	
                                        0/4 completed
                                        
                                    </div>
                                    
                                    <div id="progress" class="progress">
                                         
                                    	<div id="percent" class="percent"></div>
                                        
                                    </div>
                                    
                                    <script>
										
										
										const progress = document.getElementById('percent');
																				
										document.addEventListener('input', () => {
										  const percent = +document.querySelector('input').value;
										  if(percent >= 0 && percent <= 100) {
										  progress.style.width = 2 * percent + 'px';
										  }
										});
										
										$(document).ready(function(e) {
                                            
											var progressval  = $('#progressval').val();
											
											if(progressval >= 0)
											{
												
												$('#percent').width(2 * progressval + 'px');
												
											}
											
                                        });

									</script>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-md-4">
                        
                        <div class="participant-dashb-dif-sectors-cont">
                            
                            <div class="participant-dashb-dif-sectors-cont-icon">
                                
                                <img src="<?php echo base_url(); ?>asset/images/icons/icon5.png" />
                                
                            </div>
                            
                            <div class="participant-dashb-dif-sectors-cont-rght">
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-top">
                                	
                                   Fireside Chat
                                    
                                     <i class="fa fa-long-arrow-right pull-right"></i>
                                     
                                </div>
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-bottom">
                                	
                                    <div>
                                     	
                                        <input id="progressval" style="display:none;" type="number" value="5" min="0" max="100"/>
                                        
                                    </div>
                                    
                                    <div class="participant-dashb-dif-sectors-cont-rght-bottom-sect">
                                    	
                                        0/4 completed
                                        
                                    </div>
                                    
                                    <div id="progress" class="progress">
                                         
                                    	<div id="percent" class="percent"></div>
                                        
                                    </div>
                                    
                                    <script>
										
										
										const progress = document.getElementById('percent');
																				
										document.addEventListener('input', () => {
										  const percent = +document.querySelector('input').value;
										  if(percent >= 0 && percent <= 100) {
										  progress.style.width = 2 * percent + 'px';
										  }
										});
										
										$(document).ready(function(e) {
                                            
											var progressval  = $('#progressval').val();
											
											if(progressval >= 0)
											{
												
												$('#percent').width(2 * progressval + 'px');
												
											}
											
                                        });

									</script>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-md-4">
                        
                        <div class="participant-dashb-dif-sectors-cont">
                            
                            <div class="participant-dashb-dif-sectors-cont-icon">
                                
                                <img src="<?php echo base_url(); ?>asset/images/icons/icon6.png" />
                                
                            </div>
                            
                            <div class="participant-dashb-dif-sectors-cont-rght">
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-top">
                                	
                                    Book Reviews
                                    
                                     <i class="fa fa-long-arrow-right pull-right"></i>
                                     
                                </div>
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-bottom">
                                	
                                    <div>
                                     	
                                        <input id="progressval" style="display:none;" type="number" value="5" min="0" max="100"/>
                                        
                                    </div>
                                    
                                    <div class="participant-dashb-dif-sectors-cont-rght-bottom-sect">
                                    	
                                        0/4 completed
                                        
                                    </div>
                                    
                                    <div id="progress" class="progress">
                                         
                                    	<div id="percent" class="percent"></div>
                                        
                                    </div>
                                    
                                    <script>
										
										
										const progress = document.getElementById('percent');
																				
										document.addEventListener('input', () => {
										  const percent = +document.querySelector('input').value;
										  if(percent >= 0 && percent <= 100) {
										  progress.style.width = 2 * percent + 'px';
										  }
										});
										
										$(document).ready(function(e) {
                                            
											var progressval  = $('#progressval').val();
											
											if(progressval >= 0)
											{
												
												$('#percent').width(2 * progressval + 'px');
												
											}
											
                                        });

									</script>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-md-4">
                        
                        <div class="participant-dashb-dif-sectors-cont">
                            
                            <div class="participant-dashb-dif-sectors-cont-icon">
                                
                                <img src="<?php echo base_url(); ?>asset/images/icons/icon7.png" />
                                
                            </div>
                            
                            <div class="participant-dashb-dif-sectors-cont-rght">
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-top">
                                	
                                    Stretch Assessment
                                    
                                     <i class="fa fa-long-arrow-right pull-right"></i>
                                     
                                </div>
                                
                                <div class="participant-dashb-dif-sectors-cont-rght-bottom">
                                	
                                    <div>
                                     	
                                        <input id="progressval" style="display:none;" type="number" value="5" min="0" max="100"/>
                                        
                                    </div>
                                    
                                    <div class="participant-dashb-dif-sectors-cont-rght-bottom-sect">
                                    	
                                        0/4 completed
                                        
                                    </div>
                                    
                                    <div id="progress" class="progress">
                                         
                                    	<div id="percent" class="percent"></div>
                                        
                                    </div>
                                    
                                    <script>
										
										
										const progress = document.getElementById('percent');
																				
										document.addEventListener('input', () => {
										  const percent = +document.querySelector('input').value;
										  if(percent >= 0 && percent <= 100) {
										  progress.style.width = 2 * percent + 'px';
										  }
										});
										
										$(document).ready(function(e) {
                                            
											var progressval  = $('#progressval').val();
											
											if(progressval >= 0)
											{
												
												$('#percent').width(2 * progressval + 'px');
												
											}
											
                                        });

									</script>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
            
            </div>
        	
            <div class="col-xs-12 col-md-3">
            	
                <div class="participant-activity-timeline mike-hide">
                	
                    <div class="participant-activity-timeline-hdr">
                    	
                        Activity timelines
                        
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
      </div>
      
    </section>
    
  </div>  
  <!-- /.content-wrapper -->
