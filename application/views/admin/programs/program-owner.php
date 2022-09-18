  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
  	   <!-- Content Header (Page header) -->
    <section class="content-header">

      
    </section>
    
    <!-- Main content -->
    <section class="content">
    	
        <div class="row">
        	
            <div class="col-xs-12 col-md-12">
            	
                
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
                    
                    echo form_open(base_url().'admin/program-owner/'.$program_id, $attr); 
                
                ?>
                
                    <div class="col-xs-12 col-md-12">
                        
                        <div class="setup-form-header-cont">
                            
                            <div class="setup-form-header-arrow-bck">
                            
                                <a href="<?php echo base_url(); ?>admin/create-program/<?php echo $program_id; ?>/" class="text-blue fixed-backnav">
                                                               
                                    <i class="fa fa-arrow-left"></i>
                                
                                </a>
                            
                            </div> 
                        
                            <div class="setup-form-header">
                                
                                Next you select a program owner
                                
                            </div>
                            
                            <div class="setup-form-header-sub-text">
                                
                                Provide basic information on the program
                                
                            </div>
                        
                        </div>
                    
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Who will be in charge of this program </label>
                                
                                <p class="help-block">
                                
                                    A Program owner is responsible for coordinating and organizing the program activities
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left">
                                    
                                    <div class="form-group">
                                         
                                        <!--<div class="col-xs-6 col-md-6 no-pad-left">
                                        
                                            <div class="btn btn-primary">
                                            	
                                                Self
                                                
                                            </div>
                                        
                                        </div>-->
                                        
                                        <div class="col-xs-12 col-md-12 no-pad-right">
                                            
                                             <?php
									
/*												$options['0'] 	= 	'Select program manager';
												
												foreach($employees as $employee)
												{
													
													$options[$employee['employee_id']] 	= 	ucfirst($employee['first_name']).' '.ucfirst($employee['last_name']);
														
													
												}

												echo form_dropdown('owner_id[]', $options, set_value('owner_id[]',$owner_id), 'class="form-control select2" multiple="multiple" data-placeholder="Select program manager" style="width: 100%; min-height:30px;"');
*/
												
												echo '<select class="form-control select2" multiple="multiple" name="owner_id[]" data-placeholder="Select program manager" style="width: 100%;">';
			
												foreach($owners as $owner)
												{
													
													echo '<option value="'.$owner['owner_id'].'"'; 
													
													if(!empty($owner_id))
													{ 
													
														if(in_array($owner['owner_id'], $owner_id))
														{ 
														
															echo 'selected';  
														
														}
													
													}else{
														
														if($owner['owner_id'] == $curr_ownerID)
														{
															
															echo 'selected';
															
														}
														
													}
													
													echo '>'.ucfirst($owner['first_name']).' '.ucfirst($owner['last_name']).'</option>';
														
													
												}
												
												
												echo '</select>';
									
											?>
                                        
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-12">
                                	
                                    <div class="" style="text-align:center;">
                                    	
                                        <h3>or</h3>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-12">
                                	
                                    
                                </div>
                                
                         
                            </div>
                            
                        </div>
                        
                    </div>
					
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">

                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="dashb-trans-btn">
                                    
                                    <a href="<?php echo base_url(); ?>admin/create-program-owner/<?php echo $program_id; ?>/" style="width:100%;">
                                   
                                        <i class="fa fa-plus"></i> Create new program owner 
                                        
                                    </a>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">

                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup" style="border-bottom:none;">
                                 
                                <button type="submit" class="btn btn-primary">Continue</button>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </form>
            
            </div>
        
        </div>
    
    </section>
    
  </div>