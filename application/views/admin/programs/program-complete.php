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
                    
                    echo form_open(base_url().'admin/program-complete/'.$program_id, $attr); 
                
                ?>
                
                    <div class="col-xs-12 col-md-12">
                        
                        <div class="setup-form-header-cont">
                            
                            <div class="setup-form-header-arrow-bck">
                            
                                <a href="<?php echo base_url(); ?>admin/program-survey/<?php echo $program_id; ?>/" class="text-blue fixed-backnav">
                                                               
                                    <i class="fa fa-arrow-left"></i>
                                
                                </a>
                            
                            </div> 
                        
                            <div class="setup-form-header">
                                
                               Well Done, You've created your first program
                                
                            </div>
                            
                            <div class="setup-form-header-sub-text">
                                
                                Great job, you've successfully created your first program
                                
                            </div>
                        
                        </div>
                    
                    </div>

                    <div class="col-xs-12 col-md-12 admin-form-row ">
                    	
                        <div class="col-xs-2 col-md-2">
                        
                        </div>
                        
                        <div class="col-xs-8 col-md-8 pipa-bx">
                        	
                            <div class="admin-form-program-complete-bx">
                            	
                                <div class="admin-form-program-complete-bx-cnt progsetup-complete-bx-line">
                                	
                                    <img src="<?php echo base_url(); ?>asset/images/completion-line.png" />
                                    
                                </div>
                                
                                <div class="admin-form-program-complete-bx-cnt">
                                	
                                    <img src="<?php echo base_url(); ?>asset/images/completion-check.png" />
                                    
                                </div>
                                
                                <div class="admin-form-program-complete-bx-cnt">
                                	
                                    <p>
                                    	Thank you for completing your Program Setup, <br />Click the Button below to proceed to Dashboard
                                        
                                    </p>
                                
                                </div>
                                
                                <div class="form-group admin-form-setup admin-form-program-complete-bx-cnt" style="border-bottom:none;">
                                     
                                     <a href="<?php echo base_url(); ?>admin/dashboard/" class="btn btn-primary">
                                        
                                        Proceed to Dashboard
                                        
                                    </a>
                                    
                                </div>
                            
                            </div>
                            
                        </div>
                        
                        <div class="col-xs-2 col-md-2">
                        
                        </div>
                        
                    </div>
                    
                </form>
            
            </div>
        
        </div>
    
    </section>
    
  </div>