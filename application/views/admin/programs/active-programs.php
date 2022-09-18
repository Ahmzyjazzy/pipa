  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
  	   <!-- Content Header (Page header) -->
    <section class="content-header">

      
    </section>
    
    <!-- Main content -->
    <section class="content">
    	
        <div class="row">
        
            <div class="col-xs-12 col-md-12 minimum-content-margin">
                
                <div class="nav-tabs-custom">
                
                    <ul class="nav nav-tabs">
                    
                      <li class="<?php if($page_tab == 'active'){ echo 'active'; } ?>"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Active Programs</a></li>
                    
                      <li class="<?php if($page_tab == 'pending'){ echo 'active'; } ?>"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Pending Programs</a></li>
        
                    </ul>
                
                    <div class="tab-content">
                    
                        <div class="tab-pane <?php if($page_tab == 'active'){ echo 'active'; } ?>" id="tab_1" style="overflow:auto;">
                          
                            <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                            
                                <div class="resp-table resp-table-no-border">
                                    
                                    <div class="resp-table-caption resp-table-caption-no-border">
                                        
                                        <div class="col-xs-12 col-md-12 no-pad-left">
                                            
                                            <div class="col-xs-12 col-md-7 no-pad-left">
                                                
                                                <div class="resp-table-caption-text">
                                                    
                                                    Active Programs
                                                    
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
                                            
                                           Grade Level
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Participants
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Duration
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Status
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Satisfaction Levels
                                            
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
												
												$date1					=	$programDetails['start_date'];
												
												$date2					=	$programDetails['end_date'];
												
												$difference_in_weeks 	= 	weeks_between($date1, $date2);
												
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
													
														'.sizeof($programDetails['program_participants']).'
													
													</div>
													
													<div class="table-body-cell">
													
														'.$difference_in_weeks.' Weeks
														
													</div>
													
													<div class="table-body-cell">
													
														'.$status.'
														
													</div>
													
													<div class="table-body-cell">
													
														
														
													</div>
													
													<div class="table-body-cell">
													
														<a class="btn btn-info" title="Edit/View Program Details" href="'.site_url('admin/create-program').'/'.$programDetails['program_id'].'/">
															<i class="fa fa-edit"></i> 
														</a>
														
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
                                        
                                        <!--<div class="resp-table-row resp-table-row-even">
                                            
                                            <div class="table-body-cell">
                                            
                                                2.
                                            
                                            </div>
                                            
                                            <div class="table-body-cell">
                                            
                                                Aspire
                                            
                                            </div>
                                            
                                            <div class="table-body-cell">
                                                
                                                <span class="cell-colr-txt">
                                                
                                                    Adenike Adetutu
                                                
                                                </span>
                                                
                                            </div>
                                            
                                            <div class="table-body-cell">
                                            
                                               Executives
                                            
                                            </div>
                                            
                                            <div class="table-body-cell">
                                            
                                                150
                                            
                                            </div>
                                            
                                            <div class="table-body-cell">
                                            
                                                8 Weeks
                                            
                                            </div>
                                            
                                            <div class="table-body-cell">
                                            
                                                <span title="Active" class="btn bg-olive bg-positive"> 80% </span>
                                                
                                            </div>
                                            
                                            <div class="table-body-cell">
                                            
                                                <img src="<?php echo base_url(); ?>asset/images/image11.png" />
                                                
                                                <span class="pull-right-container">
                                                  
                                                  <i class="fa fa-angle-right pull-right"></i>
                                                  
                                                </span>
                                                
                                            </div>
                        
                                        </div>-->
                        
                                    </div>
                                    
                                    <!--<div class="resp-table-footer">
                                        
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
                                        
                                            Grade Level
                                        
                                        </div>
                                        
                                        <div class="table-footer-cell">
                                        
                                            Participants
                                        
                                        </div>
                                        
                                        <div class="table-footer-cell">
                                        
                                           Duration
                                        
                                        </div>
                                        
                                        <div class="table-footer-cell">
                                        
                                             Status
                                        
                                        </div>
                                        
                                        <div class="table-footer-cell">
                                        
                                             Satisfaction levels
                                        
                                        </div>
                        
                                    </div>-->
                        
                                </div>
                            
                            </div>
                        
                        </div>
                        
                        <div class="tab-pane <?php if($page_tab == 'pending'){ echo 'active'; } ?>" id="tab_2" style="overflow:auto;">
                          
                            <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                            
                                <div class="resp-table resp-table-no-border">
                                    
                                    <div class="resp-table-caption resp-table-caption-no-border">
                                        
                                        <div class="col-xs-12 col-md-12 no-pad-left">
                                            
                                            <div class="col-xs-12 col-md-7 no-pad-left">
                                                
                                                <div class="resp-table-caption-text">
                                                    
                                                    Pending Programs
                                                    
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
                                            
                                           Grade Level
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Participants
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Duration
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Status
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            
                                            
                                        </div>
                        
                                    </div>
                                    
                                    <div class="resp-table-body">
                                        
                                        <?php
						
										if(!empty($pending_programs))
										{
											$pendsnCount				=	1;
											
											$pendtbl_rowtype			=	'resp-table-row-odd';
											
											foreach($pending_programs as $programDetails)
											{
												
												$date1					=	$programDetails['start_date'];
												
												$date2					=	$programDetails['end_date'];
												
												$difference_in_weeks 	= 	weeks_between($date1, $date2);
												
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
													
											   echo '<div class="resp-table-row '.$pendtbl_rowtype.'">
													
													<div class="table-body-cell">
													
														'.$pendsnCount.'.
													
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
													
														'.sizeof($programDetails['program_participants']).'
													
													</div>
													
													<div class="table-body-cell">
													
														'.$difference_in_weeks.' Weeks
														
													</div>
													
													<div class="table-body-cell">
													
														'.$status.'
														
													</div>
													
													<div class="table-body-cell">
													
														<a class="btn btn-info" title="Edit/View Program Details" href="'.site_url('admin/create-program').'/'.$programDetails['program_id'].'/">
															<i class="fa fa-edit"></i> 
														</a>
														
													</div>
							
												</div>';
											
												$pendsnCount++;
												
												if($pendtbl_rowtype == 'resp-table-row-odd')
												{
													
													$pendtbl_rowtype = 'resp-table-row-even';
													
												}else{
													
													$pendtbl_rowtype = 'resp-table-row-odd';
													
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
                                        
                                        <!--<div class="resp-table-row resp-table-row-even">
                                            
                                            <div class="table-body-cell">
                                            
                                                2.
                                            
                                            </div>
                                            
                                            <div class="table-body-cell">
                                            
                                                Aspire
                                            
                                            </div>
                                            
                                            <div class="table-body-cell">
                                                
                                                <span class="cell-colr-txt">
                                                
                                                    Adenike Adetutu
                                                
                                                </span>
                                                
                                            </div>
                                            
                                            <div class="table-body-cell">
                                            
                                               Executives
                                            
                                            </div>
                                            
                                            <div class="table-body-cell">
                                            
                                                150
                                            
                                            </div>
                                            
                                            <div class="table-body-cell">
                                            
                                                8 Weeks
                                            
                                            	<span class="pull-right-container">
                                                  
                                                  <i class="fa fa-angle-right pull-right"></i>
                                                  
                                                </span>
                                                
                                            </div>
                        
                                        </div>-->
                        
                                    </div>
                                    
                                    <!--<div class="resp-table-footer">
                                        
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
                                        
                                            Grade Level
                                        
                                        </div>
                                        
                                        <div class="table-footer-cell">
                                        
                                            Participants
                                        
                                        </div>
                                        
                                        <div class="table-footer-cell">
                                        
                                           Duration
                                        
                                        </div>
                                        
                                        <div class="table-footer-cell">
                                        
                                             Status
                                        
                                        </div>
                                        
                                        <div class="table-footer-cell">
                                        
                                             Satisfaction levels
                                        
                                        </div>
                        
                                    </div>-->
                        
                                </div>
                            
                            </div>
                        
                        </div>
                    
                    </div>
                    
                </div>
                
            </div>
        
        </div>
      
    </section>
    
  </div>