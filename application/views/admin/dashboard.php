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
            	
                <div class="col-xs-6 col-md-3">
                	
                    <div class="dashb-stats-cont-top dashb-stats-cont-top-bg-first">
                    	
                        <div class="dashb-stats-cont-top-color">
                        	
                             <div class="dashb-stats-cont-top-color-show-color dasb-color-blue">
                            
                            </div>
                                    
                        </div>
                        
                        <div class="dashb-stats-cont-top-info">
                        	
                            <div class="dashb-stats-cont-top-info-num">
                            
                            	 <?php
									
									echo sizeof($numPrograms);
								
								?>
                            
                            </div>
                            
                            <div class="dashb-stats-cont-top-info-txt">
                            	
                                Programs
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
                <div class="col-xs-6 col-md-3">
                	
                    <div class="dashb-stats-cont-top dashb-stats-cont-top-bg-second">
                    	
                        <div class="dashb-stats-cont-top-color">
                        	
                             <div class="dashb-stats-cont-top-color-show-color dasb-color-pink">
                            
                            </div>
                                    
                        </div>
                        
                        <div class="dashb-stats-cont-top-info">
                        	
                            <div class="dashb-stats-cont-top-info-num ">
                            
                            	<?php
									
									echo sizeof($numProgramOwners);
								
								?>
                            
                            </div>
                            
                            <div class="dashb-stats-cont-top-info-txt">
                            	
                                Program Owners
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
                <div class="col-xs-6 col-md-3">
                	
                    <div class="dashb-stats-cont-top dashb-stats-cont-top-bg-third">
                    	
                        <div class="dashb-stats-cont-top-color">
                        	
                             <div class="dashb-stats-cont-top-color-show-color dasb-color-green">
                            
                            </div>
                                    
                        </div>
                        
                        <div class="dashb-stats-cont-top-info">
                        	
                            <div class="dashb-stats-cont-top-info-num">
                            
                            	<?php
									
									echo sizeof($numFacilitators);
								
								?>
                            
                            </div>
                            
                            <div class="dashb-stats-cont-top-info-txt">
                            	
                                Facilitators
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
                <div class="col-xs-6 col-md-3">
                	
                    <div class="dashb-stats-cont-top dashb-stats-cont-top-bg-fourth">
                    	
                        <div class="dashb-stats-cont-top-color">
                        	
                             <div class="dashb-stats-cont-top-color-show-color dasb-color-light-blue">
                            
                            </div>
                                    
                        </div>
                        
                        <div class="dashb-stats-cont-top-info">
                        	
                            <div class="dashb-stats-cont-top-info-num">
                            
                            	<?php
									
									echo sizeof($numCoaches);
								
								?>
                            
                            </div>
                            
                            <div class="dashb-stats-cont-top-info-txt">
                            	
                                Coaches
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
                    
        </div>
        
      </div>
      
      <div class="row">
      	
        <div class="col-xs-12 col-md-12 dashb-layer">
        	
            <div class="col-md-12 ">
            	
                <div class="dash-hdrs">
                	
                    Active Programs
                    
                </div>
                
            </div>
            
            <div class="col-xs-12 col-md-12 no-pad-left no-pad-right dashb-layer">
            	
                <div class="col-xs-12 col-md-4 dashb-layer-column">
                	
                  <div class="pipa-bx">
                  	
                    <?php 
					
					if(!empty($company_details['company']['company_logo']))
					{
						
						$company_logo			=	base_url().'asset/images/company-logo/'.$company_details['company']['company_logo'];
						
					}else{
						
						
					}
					
					if(!empty($programs))
					{
						
						$prog_count		=	0;
					
						foreach($programs as $program)
						{
							
							if($prog_count < 1)
							{
							
								echo '<div class="col-xs-12 col-md-12 dashb-hradmin-act-prog no-pad-left no-pad-right">
			
									<div class="col-xs-10 col-md-10 no-pad-left no-pad-right">
										
										<div class="">
											
											<div class="dashb-actives-img">
												
												<img src="'.$company_logo.'" height="32px;" />
												
											</div>
											
											<div class="dashb-actives-name">
												
												<span>'.$program['program_name'].'</span>
												
											</div>
															
										</div>
										
									</div>
								
									<div class="col-xs-2 col-md-2 no-pad-left">
																
										<div class="dashb-actives-settings">
											
											<div class="dashb-actives-settings-gear" style="float:right; padding-top:20px;">
												
												<a href="#">
												
													<i class="fa fa-gear"></i>
												
												</a>
												
											</div>
				
										</div>
										
									</div>
			
								</div>
								
								<div class="col-xs-12 col-md-12 no-pad-left no-pad-right marg-bottom">
									
									<div class="col-xs-6 col-md-6 no-pad-left no-pad-right">
										
										<div class="dashb-actives-percent dashb-actives-percent-grey-light">
																
											<div class="dashb-actives-percent-inner dashb-actives-percent-grey-light">
											
												0%
											
											</div>
											
										</div>
										
									</div>
									
									<div class="col-xs-6 col-md-6 no-pad-left no-pad-right">
										
										<div class="dashb-actives-start-end-cont">
											
											<div class="dashb-actives-start-end">
												
												Start date: '.date('d/m/Y',strtotime($program['start_date'])).'
												
											</div>
											
											<div class="dashb-actives-start-end">
												
												  End date: &nbsp;&nbsp;'.date('d/m/Y',strtotime($program['end_date'])).'
												
											</div>
										
										</div>
										
									</div>
									
								</div>
								
								<div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
									
									<div class="dashb-actives-details-cont">
										
										<div class="dashb-actives-details-first dashb-actives-details-dv">
											
											<div class="col-xs-3 col-md-4 no-pad-left no-pad-right">
												
												<span>
													Program owner:
												</span>

											</div>
											
											<div class="col-xs-9 col-md-8 no-pad-left">';
											
												if(!empty($program['program_owner_details']))
												{
													
													$ownerdet_count		=	0;	
													
													foreach($program['program_owner_details'] as $owner_det)
													{
														
														if($ownerdet_count < 2)
														{
															
															echo '
															<div class="col-xs-12 col-md-12 no-pad-left no-pad-right" style="margin-bottom:8px;">
															
																<div class="col-xs-9 col-md-9 no-pad-left">
																	
																	'.ucfirst($owner_det['first_name']).' '.ucfirst($owner_det['last_name']).'
																
																</div>
																
																<div class="col-xs-3 col-md-3 no-pad-left no-pad-right">
																	
																   <div class="dashb-actives-details-ico">
																	
																		<i class="fa  fa-phone"></i>
																		
																		 |
																		
																		<i class="fa fa-envelope"></i>
																		
																   </div>
																	
																</div>
															
															</div>';
															
															$ownerdet_count++;
														
														}
													
													}
												
												}
											
											echo '</div>
											
										</div>
										
										<div class="dashb-actives-details-first dashb-actives-details-dv">
											
											<div class="col-xs-10 col-md-10 no-pad-left">
												
												<span>
													Number of participants:
												</span>
												
												'.sizeof($program['program_participants']).'
												
											</div>
											
										</div>
										
										<div class="dashb-actives-details-first dashb-actives-details-dv">
											
											<div class="col-xs-10 col-md-10 no-pad-left">
												
												<span>
													Grade Level:
												</span>';
												
												if(!empty($program['program_grade_levels']))
												{
													
													$gradeLevels		=	'';
													
													foreach($program['program_grade_levels'] as $grades)
													{
															
														$gradeLevels	.=	' '.$grades['grade'].',';
														
													}
													
													
													echo rtrim($gradeLevels, ',');
													
												}
												
											echo '</div>
											
										</div>
										
									</div>
									
								</div>
								
								<div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
									
									<div class="dashb-trans-btn">
										
										<a href="'.base_url().'admin/active-programs/">
											
											View more 
											
										</a>
										
									</div>
									
								</div>';

								$prog_count++;
							
							}
					
						}
							
				  	}else{
							
						echo '<div class="" style="text-align:center; min-height:350px; padding-top:40%; padding-bottom:40%; font-size:26px; font-weight:600;">
						
							No Program Found
							
						</div>';	
					}
					?>
                    
                    </div>
                    
                </div>
                
                <div class="col-xs-12 col-md-4 dashb-layer-column">
                	
                  <div class="pipa-bx dashb-add-new-prog">
                  	
                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                    	
                        <div class="dashb-new-prog-plus">
                        	
                            <a href="<?php echo base_url(); ?>admin/create-program/">
                            
                            	<img src="<?php echo base_url(); ?>asset/images/plus.png" />
                            
                            </a>
                            
                        </div>
                        
                        <div class="dashb-trans-btn-add-new-prog">
                        	
                            <a href="<?php echo base_url(); ?>admin/create-program/">
                            	
                               Add new program
                                
                            </a>
                            
                        </div>
                        
                    </div>
                    
                  </div>
                    
                </div>
                
                <div class="col-xs-12 col-md-4 dashb-layer-column">
                    
                    <div class="pipa-bx">
                    
                        <div class="" style="text-align:center; min-height:350px; padding-top:40%; padding-bottom:40%; font-size:26px; font-weight:600;">
                        
                            No Calendar Activity
                            
                        </div>
                    
                    </div>
                    <!--<div class="dashb-calender-sect">
                        
                        <div class="dashb-calender-sect-bg">
                            
                            <div class="dashb-calender-sect-bg-date">
                                
                                Monday 13th, 2020
                                
                            </div>
                            
                            <div class="dashb-calender-sect-bg-month">
                                
                                January
                                
                            </div>
                            
                            <div class="col-xs-12 no-pad-left">
                                
                                <div class="col-xs-2 no-pad-left">
                                    
                                    <div class="dashb-calender-sect-bg-icon">
                                    
                                        <i class="fa fa-calendar"></i>
                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-6 no-pad-left">
                                    
                                    <div class="dashb-calender-sect-bg-meet">
                                        
                                        <div class="dashb-calender-sect-bg-meet-hdr">
                                            
                                            Meeting with Seyi
                                            
                                        </div>
                                        
                                        <div class="dashb-calender-sect-bg-meet-lwr">
                                            
                                            Aspire-sterling
                                            
                                        </div>
                                        
                                        <div class="dashb-calender-sect-bg-meet-lnk">
                                            
                                            <a href="#">
                                                
                                                View in calendar <i class="fa fa-angle-right"></i>
                                                
                                            </a>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            
                        </div>
                        
                        <div class="pipa-bx dashb-calender-sect-dates">
                            
                            <div class="col-xs-3">
                                
                                <div class="dashb-calender-sect-dates-day">
                                    
                                    14th
                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-xs-7">
                            
                                <div class="dashb-calender-sect-month-cont">
                                    
                                    <div class="dashb-calender-sect-month">
                                        
                                        December 2020
                                        
                                    </div>
                                    
                                    <div class="dashb-calender-sect-month-day">
                                        
                                        Monday
                                        
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                            <div class="col-xs-2">
                                
                                <div class="dashb-calender-sect-month-num">
                                    
                                    0
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                        <div class="pipa-bx dashb-calender-sect-dates">
                            
                            <div class="col-xs-3">
                                
                                <div class="dashb-calender-sect-dates-day">
                                    
                                    15th
                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-xs-7">
                            
                                <div class="dashb-calender-sect-month-cont">
                                    
                                    <div class="dashb-calender-sect-month">
                                        
                                        December 2020
                                        
                                    </div>
                                    
                                    <div class="dashb-calender-sect-month-day">
                                        
                                        Tuesday
                                        
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                            <div class="col-xs-2">
                                
                                <div class="dashb-calender-sect-month-num">
                                    
                                    2
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                        <div class="pipa-bx dashb-calender-sect-dates">
                            
                            <div class="col-xs-3">
                                
                                <div class="dashb-calender-sect-dates-day">
                                    
                                    16th
                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-xs-7">
                            
                                <div class="dashb-calender-sect-month-cont">
                                    
                                    <div class="dashb-calender-sect-month">
                                        
                                        December 2020
                                        
                                    </div>
                                    
                                    <div class="dashb-calender-sect-month-day">
                                        
                                        Wednesday
                                        
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                            <div class="col-xs-2">
                                
                                <div class="dashb-calender-sect-month-num">
                                    
                                    5
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>-->
                    
                </div>
                
            </div>
            
        </div>
        
      </div>
      
      <div class="row">
      	
        <div class="col-xs-12 col-md-12 minimum-content-margin">
            
            <div class="col-xs-12 col-md-12">
            
                <div class="resp-table">
                    
                    <div class="resp-table-caption">
                    	
                        <div class="col-xs-12 col-md-12 no-pad-left">
                        	
                            <div class="col-xs-12 col-md-7 no-pad-left">
                            	
                                <div class="resp-table-caption-text">
                                	
                                    Programs
                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-xs-12 col-md-5">
                            	
                                <div class="col-xs-6 col-md-6 no-pad-left-mob">
                                	
                                    <div class="resp-table-caption-select-cont">
                                    	
                                        <p class="resp-table-caption-text" style="float:left; margin-right:20px;">Showing:</p> 
                                        
                                        <select class="bg-secondary-color text-sm paginate-select">
                                        
                                            <option value="1-10">1-10</option>
                                        
                                        </select>
                                            
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-6 col-md-6 no-pad-left-mob">
                                	
                                    <div class="resp-table-caption-search">
                                    	
                                        <input type="text" placeholder="Search" class="search-input searchbx" />
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                        
                        </div>	
                        
                    </div>
                    
                    <div class="resp-table-header">
                        
                        <div class="table-header-cell">
                            
                           S/N
                            
                        </div>
                        
                        <div class="table-header-cell">
                            
                            Program Name
                            
                        </div>
                        
                        <div class="table-header-cell">
                        
                            Program Owner
                        
                        </div>
                        
                        <div class="table-header-cell">
                            
                            Number of Participants
                            
                        </div>
                        
                        <div class="table-header-cell">
                            
                            Grade Level of Participants
                            
                        </div>
                        
                        <div class="table-header-cell">
                            
                            Status
                            
                        </div>
                        
                        <div class="table-header-cell">
                            
                            
                        </div>

                    </div>
                    
                    <div class="resp-table-body">
                        
                        <?php
						
						if(!empty($programs))
						{
							$snCount				=	1;
							
							$tbl_rowtype			=	'resp-table-row-odd';
							
							foreach($programs as $programDetails)
							{
								
							   if(empty($programDetails['program_status']))
								{										
									//means account has been disabled
									$status		=	'<span title="Account Disabled" class="btn btn-warning ">Pending</span>';
									
								}
								elseif($programDetails['program_status'] == '1')
								{
									
									//means account is active
									$status		=	'<span title="Active" class="btn bg-olive bg-positive"> Active </span>';
									
								}
									
							   echo '<div class="resp-table-row '.$tbl_rowtype.'">
									
									<div class="table-body-cell">
									
										'.$snCount.'.
									
									</div>
									
									<div class="table-body-cell">
									
										'.ucfirst($programDetails['program_name']).'
									
									</div>
									
									<div class="table-body-cell">';
										
										if(!empty($programDetails['program_owner_details']))
										{
											
											$ownerdetCount		=	0;	
											
											foreach($programDetails['program_owner_details'] as $owner_det)
											{
												
												if($ownerdetCount < 2)
												{
													
													echo '<div class="cell-colr-txt">'.ucfirst($owner_det['first_name']).' '.ucfirst($owner_det['last_name']).'</div>';
													
													$ownerdetCount++;
												
												}
											
											}
										
										}
										
										echo '</div>
									
									<div class="table-body-cell">
									
										'.sizeof($programDetails['program_participants']).'
									
									</div>
									
									<div class="table-body-cell">';
									
										if(!empty($programDetails['program_grade_levels']))
										{
											
											$grade_levels		=	'';
											
											foreach($programDetails['program_grade_levels'] as $grade)
											{
													
												$grade_levels	.=	' '.$grade['grade'].',';
												
											}
											
											
											echo rtrim($grade_levels, ',');
											
										}
									
									echo '</div>

									<div class="table-body-cell">
									
										'.$status.'
										
									</div>
									
									<div class="table-body-cell">
									
										<a class="btn btn-info" title="Edit/View Program Details" href="'.site_url('admin/create-program').'/'.$programDetails['program_id'].'/">
											<i class="fa fa-edit"></i> 
										</a>
										
										<span class="pull-right-container">
										  
										  <i class="fa fa-angle-down pull-right"></i>
										  
										</span>
										
									</div>
			
								</div>';
                        	
								$snCount++;
								
								if($tbl_rowtype == 'resp-table-row-odd')
								{
									
									$tbl_rowtype = 'resp-table-row-even';
									
								}else{
									
									$tbl_rowtype = 'resp-table-row-odd';
									
								}
								
							}
						
						}else{
							
							echo '<div class="resp-table-row">
							
								 <div class="table-body-cell" style="text-align:center; ">
                            
									No Record Found
								
								</div>
							
							</div>';	
						}
						
						?>

                    </div>
                    
                    <div class="resp-table-footer">
                        
                        <div class="table-footer-cell">
                        
                           S/N
                        
                        </div>
                        
                        <div class="table-footer-cell">
                        
                            Program Name
                        
                        </div>
                        
                        <div class="table-footer-cell">
                        
                            Program Owner
                        
                        </div>
                        
                        <div class="table-footer-cell">
                        
                            Number of Participants
                        
                        </div>
                        
                        <div class="table-footer-cell">
                        
                            Grade Level of Participants
                        
                        </div>
                        
                        <div class="table-footer-cell">
                        
                             Status
                        
                        </div>
    
                    </div>
    
                </div>
            
            </div>
  
        </div>
        
      </div>
      
    </section>
    
  </div>  
  <!-- /.content-wrapper -->
