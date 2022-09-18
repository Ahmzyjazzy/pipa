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

                      <li class="nav-tab-right" style="width:15%; float:right;">
                      	
                        <div class="dashb-trans-btn dashb-trans-btn-colored" style="padding-bottom:8px; padding-top:8px;">
                            
                            <a href="<?php echo base_url(); ?>admin/create-location/" style="width:100%;">
                               
                                Create Location
                                
                            </a>
                            
                        </div>
                                            
                      </li>
                      
                    </ul>
                
                    <div class="tab-content">
                    
                        <div class="tab-pane active" id="tab_1" style="overflow:auto;">
                          
                            <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                            
                                <div class="resp-table resp-table-no-border">
                                    
                                    <div class="resp-table-caption resp-table-caption-no-border">
                                        
                                        <div class="col-xs-12 col-md-12 no-pad-left">
                                            
                                            <div class="col-xs-12 col-md-7 no-pad-left">
                                                
                                                <div class="resp-table-caption-text">
                                                    
                                                   Locations
                                                    
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
                                        
                                        <?php
										
											if($company_id == '1')
											{
												
												echo '<div class="table-header-cell">
													
													Company Name
													
												</div>';
											
											}
                                        
										?>
                                        
                                        <div class="table-header-cell">
                                            
                                            Location
                                            
                                        </div>
                                        
                                        <div class="table-header-cell">
                                            
                                            
                                            
                                        </div>
                        
                                    </div>
                                    
                                    <div class="resp-table-body">
                                        
                                        <?php
										
                                        if(!empty($locations))
                                        {
											$CI =& get_instance();
											
                                            $snCount				=	1;
                                            
                                            $tbl_rowtype			=	'resp-table-row-odd';
                            				
											foreach($locations as $location)
											{
												
												$company					=	$CI->in_multiarray($location['company_id'], $companies, 'company_id');
													
												echo '<div class="resp-table-row '.$tbl_rowtype.'">
													
													<div class="table-body-cell">
													
														'.$snCount.'.
													
													</div>';
													
													if($company_id == '1')
													{
														
														echo '<div class="table-body-cell">
														
															'.ucfirst($company[0]['company_name']).'
														
														</div>';
													
													}
													
													echo '<div class="table-body-cell">
													
														'.$location['location'].'
													
													</div>

													
													<div class="table-body-cell">
													
														<a class="btn btn-info" title="Edit/View Location Details" href="'.site_url('admin/create-location').'/'.$location['location_id'].'/">
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
                        

                    </div>
                    
                </div>
                
            </div>
        
        </div>
      
    </section>
    
  </div>