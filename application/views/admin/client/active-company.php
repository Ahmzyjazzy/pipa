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
                    
                      <li class="<?php if($page_tab == 'active'){ echo 'active'; } ?>"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Active Companies</a></li>
                    
                      <li class="<?php if($page_tab == 'pending'){ echo 'active'; } ?>"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Pending Companies</a></li>
        			  
                      <li class="nav-tab-right" style="width:15%; float:right;">
                      	
                        <div class="dashb-trans-btn dashb-trans-btn-colored" style="padding-bottom:8px; padding-top:8px;">
                            
                            <a href="<?php echo base_url(); ?>admin/create-company/" style="width:100%;">
                               
                                Create new company
                                
                            </a>
                            
                        </div>
                                            
                      </li>
                      
                    </ul>
                
                    <div class="tab-content">
                    
                        <div class="tab-pane <?php if($page_tab == 'active'){ echo 'active'; } ?>" id="tab_1" style="overflow:auto;">
                          
                            <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                            
                                <div class="resp-table resp-table-no-border">
                                    
                                    <div class="resp-table-caption resp-table-caption-no-border">
                                        
                                        <div class="col-xs-12 col-md-12 no-pad-left">
                                            
                                            <div class="col-xs-12 col-md-7 no-pad-left">
                                                
                                                <div class="resp-table-caption-text">
                                                    
                                                    Active Companies
                                                    
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
                                            
                                            Company Name
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Organization Size
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                        
                                            Primary Contact
                                        
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                           Contact Email
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Contact Phone
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Date of Creation
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Status
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            
                                            
                                        </div>
                        
                                    </div>
                                    
                                    <div class="resp-table-body">
                                        
                                        <?php
										
                                        if(!empty($active_companies))
                                        {
                                            $snCount				=	1;
                                            
                                            $tbl_rowtype			=	'resp-table-row-odd';
                            				
											foreach($active_companies as $activeComp)
											{
													
												if(empty($activeComp['company_status']))
												{										
													//means account has been disabled
													$status		=	'<span title="Account Disabled" class="btn btn-danger ">Disabled</span>';
													
												}
												elseif($activeComp['company_status'] == '1')
												{
													
													//means account is active
													$status		=	'<span title="Account Active" class="btn bg-olive"> Active</span>';
													
												}
												elseif($activeComp['company_status'] == '2')
												{
													
													//means account has been suspended
													$status		=	'<span title="Account Suspended" class="btn btn-danger ">Suspended</span>';
												
												}else{
													
													//means account has been Blocked
													$status		=	'<span title="Account Blocked" class="btn btn-danger ">Blocked</span>';
													
												}
													
												echo '<div class="resp-table-row '.$tbl_rowtype.'">
													
													<div class="table-body-cell">
													
														'.$snCount.'.
													
													</div>
													
													<div class="table-body-cell">
													
														'.ucfirst($activeComp['company_name']).'
													
													</div>
													
													<div class="table-body-cell">
													
														'.$activeComp['number_of_employees'].'
													
													</div>
													
													<div class="table-body-cell">
														
														<span class="cell-colr-txt">
														
															'.ucfirst($activeComp['primaryContact']['first_name']).' '.ucfirst($activeComp['primaryContact']['first_name']).'
														
														</span>
													
													</div>
													
													<div class="table-body-cell">
													
													   '.$activeComp['primaryContact']['email'].'
													
													</div>
													
													<div class="table-body-cell">
													
														'.$activeComp['primaryContact']['phone_number'].'
													
													</div>
													
													<div class="table-body-cell">
													
														'.date('M d, Y h:i A', strtotime($activeComp['date_created'])).'
													
													</div>
													
													<div class="table-body-cell">
													
														'.$status.'
														
													</div>
													
													<div class="table-body-cell">
													
														<a class="btn btn-info" title="Edit/View Company Details" href="'.site_url('admin/create-company').'/'.$activeComp['company_id'].'/">
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
							
												 <div class="table-body-cell">
											
													No Record Found
												
												</div>
											
											</div>';	
											
										}
										
										?>
								
                                    </div>
                        
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
                                                    
                                                    Pending Companies
                                                    
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
                                            
                                            Company Name
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Organization Size
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                        
                                            Primary Contact
                                        
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                           Contact Email
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Contact Phone
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Date of Creation
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            Status
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                           
                                            
                                        </div>
                        
                                    </div>
                                    
                                    <div class="resp-table-body">
                                        
                                        <?php
										
                                        if(!empty($pending_companies))
                                        {
                                            $pend_snCount				=	1;
                                            
                                            $pend_tbl_rowtype			=	'resp-table-row-odd';
                            				
												
											foreach($pending_companies as $pendComp)
											{
												
												if(empty($pendComp['company_status']))
												{										
													//means account has been disabled
													$pendingCompstatus		=	'<span title="Account Disabled" class="btn btn-danger ">Disabled</span>';
													
												}
												elseif($pendComp['company_status'] == '1')
												{
													
													//means account is active
													$pendingCompstatus		=	'<span title="Account Active" class="btn bg-olive"> Active</span>';
													
												}
												elseif($pendComp['company_status'] == '2')
												{
													
													//means account has been suspended
													$pendingCompstatus		=	'<span title="Account Suspended" class="btn btn-danger ">Suspended</span>';
												
												}else{
													
													//means account has been Blocked
													$pendingCompstatus		=	'<span title="Account Blocked" class="btn btn-danger ">Blocked</span>';
													
												}


												echo '<div class="resp-table-row '.$pend_tbl_rowtype.'">
													
													<div class="table-body-cell">
													
														'.$pend_snCount.'.
													
													</div>
													
													<div class="table-body-cell">
													
														'.ucfirst( $pendComp['company_name']).'
													
													</div>
													
													<div class="table-body-cell">
													
														'. $pendComp['number_of_employees'].'
													
													</div>
													
													<div class="table-body-cell">
														
														<span class="cell-colr-txt">
														
															'.ucfirst($pendComp['primaryContact']['first_name']).' '.ucfirst($pendComp['primaryContact']['first_name']).'
														
														</span>
													
													</div>
													
													<div class="table-body-cell">
													
													   '.$pendComp['primaryContact']['email'].'
													
													</div>
													
													<div class="table-body-cell">
													
														'.$pendComp['primaryContact']['phone_number'].'
													
													</div>
													
													<div class="table-body-cell">
													
														'.date('M d, Y h:i A', strtotime($pendComp['date_created'])).'
													
													</div>
													
													<div class="table-body-cell">
													
														'.$pendingCompstatus.'
														
													</div>
													
													<div class="table-body-cell">
													
														<a class="btn btn-info" title="Edit/View Company Details" href="'.site_url('admin/create-company').'/'.$pendComp['company_id'].'/">
															<i class="fa fa-edit"></i> 
														</a>
										
													</div>
								
												</div>';
												
												$pend_snCount++;
												
												if($pend_tbl_rowtype == 'resp-table-row-odd')
												{
													
													$pend_tbl_rowtype = 'resp-table-row-even';
													
												}else{
													
													$pend_tbl_rowtype = 'resp-table-row-odd';
													
												}
												
											}
											
										}else{
											
											echo '<div class="resp-table-row">
							
												 <div class="table-body-cell">
											
													No Record Found
												
												</div>
											
											</div>';	
											
										}
										
										?>
                                        
                                    </div>
                        
                                </div>
                            
                            </div>
                        
                        </div>
                    
                    </div>
                    
                </div>
                
            </div>
        
        </div>
      
    </section>
    
  </div>