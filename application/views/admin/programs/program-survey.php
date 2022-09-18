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
                            
                                <a href="<?php echo base_url(); ?>admin/program-owner/<?php echo $program_id; ?>/" class="text-blue fixed-backnav">
                                                               
                                    <i class="fa fa-arrow-left"></i>
                                
                                </a>
                            
                            </div> 
                        
                            <div class="setup-form-header">
                                
                               Build Assessments
                                
                            </div>
                            
                            <div class="setup-form-header-sub-text">
                                
                                Please select from the choices below and click continue
                                
                            </div>
                        
                        </div>
                    
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>360 Leadership Assessment </label>
                                
                                <p class="help-block">
                                
                                    This is a type of employee performance review in which subordinates. co-workers, and managers all anonymously rate the employee
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left">
                                    
                                    <div class="form-group">
                                         
                                        <a href="<?php echo base_url(); ?>admin/leadership-assessment/<?php echo $program_id; ?>" class="btn btn-primary">
                                            
                                            Setup 360 Leadership Assessment
                                            
                                        </a>
                                        
                                    </div>
                                    
                                </div>

                            </div>
                            
                        </div>
                        
                    </div>
					
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Engagement Surveys </label>
                                
                                <p class="help-block">
                                
                                    This measures the degree to which employees feel valaued at your company
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left">
                                    
                                    <div class="form-group">
                                         
                                        <a href="#" class="btn btn-primary">
                                            
                                            Setup Engagement Survey
                                            
                                        </a>
                                        
                                    </div>
                                    
                                </div>

                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>eNPS/Pulse Surveys</label>
                                
                                <p class="help-block">
                                
                                    This is used by companies to measure their operating climate and overall performance
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left">
                                    
                                    <div class="form-group">
                                         
                                        <a href="#" class="btn btn-primary">
                                            
                                            Setup eNPS/Pulse Surveys
                                            
                                        </a>
                                        
                                    </div>
                                    
                                </div>

                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Stretch Assignment </label>
                                
                                <p class="help-block">
                                
                                    This is a type of employee performance review in which subordinates. co-workers, and managers all anonymously rate the employee
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left">
                                    
                                    <div class="form-group">
                                         
                                        <a href="#" class="btn btn-primary">
                                            
                                            Setup Stretch Assignment
                                            
                                        </a>
                                        
                                    </div>
                                    
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
                                 
                                <a href="<?php echo base_url(); ?>admin/program-complete/4/" class="btn btn-primary">
                                    
                                    Continue
                                    
                                </a>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </form>
            
            </div>
        
        </div>
    
    </section>
    
  </div>