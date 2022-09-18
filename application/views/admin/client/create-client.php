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
                    
                    echo form_open_multipart(base_url().'admin/create-client/'.$client_id, $attr); 
                
                ?>
                
                    <div class="col-xs-12 col-md-12">
                        
                        <div class="setup-form-header-cont">
                            
                            <div class="setup-form-header">
                                
                                Client
                                
                            </div>
                            
                            <div class="setup-form-header-sub-text">
                                
                                Provide basic information on this Client
                                
                            </div>
                        
                        </div>
                    
                    </div>
                    
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Client Type</label>
                                 
                                <p class="help-block">
                                
                                    Provide the Client Type this client belongs to
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">                                  
								
                                <?php
									
									$data	= array('placeholder'=>'Client Type', 'name'=>'client_type', 'value'=>set_value('client_type', $client_type), 'class'=>'form-control', 'autocomplete'=>'off');
									
									echo form_input($data);
									
								?>
              
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Client Name</label>
                                
                                <p class="help-block">
                                
                                    What would you like to call this client
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <fieldset>
                                    
                                    <legend>Client name</legend>
                                
                                     <?php
										
										$data	= array('placeholder'=>'Client Name', 'name'=>'company_name', 'value'=>set_value('company_name', $company_name), 'class'=>'form-control form-no-style', 'autocomplete'=>'off');
										
										echo form_input($data);
										
									?>
                                    
                                </fieldset>
                                           
                               
                                                           
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Company Size Range</label>
                                
                                <p class="help-block">
                                
                                    How many Employees does this client have
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                               <?php
	
									$options 		= 	array(
									
										'0'			=> 	'Number of Employees',
										'1'			=> 	'1',
										'2'			=> 	'2',
										'3'			=> 	'3',
										'4'			=> 	'4',
										'5'			=> 	'5',
										'6'			=> 	'6',
										'7'			=> 	'7',
										'8'			=> 	'8',
										'9'			=> 	'9',
										'10'		=> 	'10',
										'11'		=> 	'11',
										'12'		=> 	'12',
										'13'		=> 	'13',
										'14'		=> 	'14',
										'15'		=> 	'15',
										'16'		=> 	'16',
										'17'		=> 	'17',
										'18'		=> 	'18',
										'19'		=> 	'19',
										'20'		=> 	'20',
										'21'		=> 	'21',
										'22'		=> 	'22',
										'23'		=> 	'23',
										'24'		=> 	'24',
										'25+'		=> 	'25+'
									);
													
									echo form_dropdown('company_size_range', $options, set_value('company_size_range',$company_size_range), 'class="form-control"');
								
								?>
                                
                            </div>
                            
                        </div>
                        
                    </div>

                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Primary Contact</label>
								
                                 <p class="help-block">
                                
                                   Primary Contact for this Client
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
          
									   <?php
                                        
                                            $data	= array('placeholder'=>'Contact Name', 'name'=>'contact_name', 'value'=>set_value('contact_name', $contact_name), 'class'=>'form-control', 'autocomplete'=>'off');
                                    
                                            echo form_input($data);
                                    
                                        ?>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                                                                     
									   <?php
                                        
                                            $data	= array('placeholder'=>'Email', 'name'=>'contact_email', 'value'=>set_value('contact_email', $contact_email), 'class'=>'form-control', 'autocomplete'=>'off');
                                    
                                            echo form_input($data);
                                    
                                        ?>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">

										<?php
                                        
                                            $data	= array('placeholder'=>'Phone Number', 'name'=>'contact_phone_number', 'value'=>set_value('contact_phone_number', $contact_phone_number), 'class'=>'form-control', 'autocomplete'=>'off');
                                    
                                            echo form_input($data);
                                    
                                        ?>

                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>

                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Activate Client</label>
                                
                                 <p class="help-block">
                                
                                   This is where you activate the Client
                                    
                                </p>
                                                        
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <?php
                    	
											$statusoptions 		= 	array(
											
												'0'		=> 	'Disabled',
												'1'		=> 	'Activate'
											);
															
											echo form_dropdown('client_activated', $statusoptions, set_value('client_activated',$client_activated), 'class="form-control"');
										
										?>

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
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup" style="border-bottom:none;">
                                 
                                <button type="submit" class="btn btn-primary">Submit</button>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </form>
            
            </div>
        
        </div>
    
    </section>
    
  </div>