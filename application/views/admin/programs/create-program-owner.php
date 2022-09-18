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
                    
                    echo form_open(base_url().'admin/create-program-owner/'.$program_id, $attr); 
                
                ?>
                
                    <div class="col-xs-12 col-md-12">
                        
                        <div class="setup-form-header-cont">
                            
                            <div class="setup-form-header-arrow-bck">
                            
                                <a href="<?php echo base_url(); ?>admin/program-owner/<?php echo $program_id; ?>/" class="text-blue fixed-backnav">
                                                               
                                    <i class="fa fa-arrow-left"></i>
                                
                                </a>
                            
                            </div> 
                        
                            <div class="setup-form-header">
                                
                                Create a program manager
                                
                            </div>
                            
                            <div class="setup-form-header-sub-text">
                                
                                Please provide the details below and click on continue
                                
                            </div>
                        
                        </div>
                    
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Program Owner's Name </label>
                                
                                <p class="help-block">
                                
                                   Who will be in charge of this program
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left">
                                    
                                    <div class="form-group">
                                         
                                        <div class="col-xs-6 col-md-6 no-pad-left">
                                        
                                            <?php
												
												$data	= array('placeholder'=>'First Name', 'name'=>'first_name', 'value'=>set_value('first_name', $first_name), 'class'=>'form-control', 'autocomplete'=>'off');
												
												echo form_input($data);
		
											?>
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-6 no-pad-right">
											
                                            <?php
												
												$data	= array('placeholder'=>'Last Name', 'name'=>'last_name', 'value'=>set_value('last_name', $last_name), 'class'=>'form-control', 'autocomplete'=>'off');
												
												echo form_input($data);
		
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
                    
                                <label>Contact Information </label>
                                
                                <p class="help-block">
                                
                                   Provide the program owner's contact details
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left">
                                    
                                    <div class="form-group">
                                         
                                        <div class="col-xs-6 col-md-6 no-pad-left">
                                        
                                            <?php
												
												$data	= array('placeholder'=>'Email', 'name'=>'email', 'value'=>set_value('email', $email), 'class'=>'form-control', 'autocomplete'=>'off');
												
												echo form_input($data);
		
											?>
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-6 no-pad-right">
											
                                            <?php
												
												$data	= array('placeholder'=>'Phone Number', 'name'=>'phone_number', 'value'=>set_value('phone_number', $phone_number), 'class'=>'form-control', 'autocomplete'=>'off');
												
												echo form_input($data);
		
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

                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup" style="border-bottom:none;">
                                 
                                <button type="submit" class="btn btn-primary">Save and Continue</button>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </form>
            
            </div>
        
        </div>
    
    </section>
    
  </div>