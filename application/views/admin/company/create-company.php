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
                    
                    echo form_open_multipart(base_url().'admin/create-company/'.$company_id, $attr); 
                
                ?>
                
                    <div class="col-xs-12 col-md-12">
                        
                        <div class="setup-form-header-cont">
                            
                            <div class="setup-form-header">
                                
                                Company
                                
                            </div>
                            
                            <div class="setup-form-header-sub-text">
                                
                                Provide basic information on this Company
                                
                            </div>
                        
                        </div>
                    
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Company Name</label>
                                
                                <p class="help-block">
                                
                                    What would you like to call this company
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <fieldset>
                                    
                                    <legend>Company name</legend>
                                
                                     <?php
										
										$data	= array('placeholder'=>'Company Name', 'name'=>'company_name', 'value'=>set_value('company_name', $company_name), 'class'=>'form-control form-no-style', 'autocomplete'=>'off');
										
										echo form_input($data);
										
									?>
                                    
                                </fieldset>
                                           
                               
                                                           
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Client</label>
                                
                                <p class="help-block">
                                
                                    Select the Client this company belongs to
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">                                  
								
                                <?php
                                    
                                    $clientOptions['0']		=	'-- Client --';
                                    
                                    if(!empty($clients))
                                    {
                                        
                                        foreach($clients as $client)
                                        {
                                            
                                            $clientOptions[$client['client_id']]	=	$client['company_name'];
                                            
                                        }
                                        
                                    }
                                                    
                                    echo form_dropdown('client_id', $clientOptions, set_value('client_id',$client_id), 'class="form-control"');
                                
                                ?>
              
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Industry</label>
                                
                                <p class="help-block">
                                
                                    Select the industry this company belongs to
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">                                  
								
                                <?php
                                    
                                    $industryOptions['0']		=	'-- Industry --';
                                    
                                    if(!empty($industries))
                                    {
                                        
                                        foreach($industries as $industry)
                                        {
                                            
                                            $industryOptions[$industry['industry_id']]	=	$industry['industry'];
                                            
                                        }
                                        
                                    }
                                                    
                                    echo form_dropdown('industry_id', $industryOptions, set_value('industry_id',$industry_id), 'class="form-control"');
                                
                                ?>
              
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Company Address</label>
                                
                                <p class="help-block">
                                
                                    What's the address of this company
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <?php
							   

									$data 				= 	array(
										'name'        	=> 'company_address',
										'value'       	=> set_value('company_address', $company_address),
										'rows'        	=> '3',
										'cols'        	=> '5',
										'style'       	=> 'width:100%',
										'placeholder'	=>	'Company Address',
										'class'       	=> 'form-control'
									);
								
									echo form_textarea($data);
								
								?>
                            
                            </div>
                            
                        </div>
                        
                    </div>
                
                	<div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Country of Operation</label>
                                
                                <p class="help-block">
                                
                                    Which country is this company operating from
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <?php
                                    
                                    $countryOptions['0']	=	'-- Country of operation --';
                                    
                                    if(!empty($countries))
                                    {
                                        
                                        foreach($countries as $countri)
                                        {
                                            
                                            $countryOptions[$countri['country_id']]	=	$countri['country_name'];
                                            
                                        }
                                        
                                    }
                                                    
                                    echo form_dropdown('countries_of_operation', $countryOptions, set_value('countries_of_operation',$countries_of_operation), 'class="form-control"');
                                
                                ?>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Number of Employees</label>
                                
                                <p class="help-block">
                                
                                    How many Employees does this company have
                                    
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
													
									echo form_dropdown('number_of_employees', $options, set_value('number_of_employees',$number_of_employees), 'class="form-control"');
								
								?>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Company Logo</label>
                                
                                <p class="help-block">
                                
                                   Upload Company Logo
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
								<?php
								
                                if(!empty($company_logo)){
                                
                                ?>
                                
                                <div class="first-app" style="padding-top:10px;">
                                
                                    <div class="chnge-homebanner change-img" style="cursor:pointer; float:left;">
                                        
                                        Change Image
                                        
                                    </div>
                                
                                    <div class="" style="float:right;">
                                        
                                        <?php 
										
										if(!empty($company_logo))
										{
											
											echo '<img src="'.base_url().'asset/images/company-logo/'.$company_logo.'" width="100"/>';
											
										}
										
										
										?>

                                    </div>
                                
                                </div>
                                
                                <div class="banner-img" style="display:none;">
                                    
                                    <div class="upload-btn-wrapper">
                                    
                                      <div class="uploadbtn"><i class="fa fa-cloud-upload"></i> Upload Company Logo</div>
                                      
                                      <input name="company_logo_upl" type="file" id="InputFile" class="BSbtnsuccess" />
                                      
                                    </div>
                                
                                </div>
                                
                                <?php
                                
                                }else{
                                    
                                ?>

        						
                                <div class="upload-btn-wrapper">
                                
                                  <div class="uploadbtn"><i class="fa fa-cloud-upload"></i> Upload Company Logo</div>
                                  
                                  <input name="company_logo_upl" type="file" id="InputFile" class="BSbtnsuccess" />
                                  
                                </div>
                                
                                <?php
                                
                                }
                                
                                ?>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Image link', 'name'=>'companylogo_hldr', 'value'=>set_value('companylogo_hldr', $company_logo), 'style'=>'display:none', 'class'=>'form-control banner_link');
                                    
                                    echo form_input($data);
                                
                                ?>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Primary Contact</label>
								
                                 <p class="help-block">
                                
                                   Primary Contact for this Company
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <div class="col-xs-6 col-md-6 no-pad-left ">
                                            
                                           <?php
											
												$data	= array('placeholder'=>'First Name', 'name'=>'primary_contact_first_name', 'value'=>set_value('primary_contact_first_name', $primary_contact_first_name), 'class'=>'form-control', 'autocomplete'=>'off');
										
												echo form_input($data);
										
											?>
                                            
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-6">

											<?php
											
												$data	= array('placeholder'=>'Last Name', 'name'=>'primary_contact_last_name', 'value'=>set_value('primary_contact_last_name', $primary_contact_last_name), 'class'=>'form-control', 'autocomplete'=>'off');
										
												echo form_input($data);
										
											?>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <div class="col-xs-6 col-md-6 no-pad-left ">
                                            
                                           <?php
											
												$data	= array('placeholder'=>'Email', 'name'=>'primary_contact_email', 'value'=>set_value('primary_contact_email', $primary_contact_email), 'class'=>'form-control', 'autocomplete'=>'off');
										
												echo form_input($data);
										
											?>
                                            
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-6">

											<?php
											
												$data	= array('placeholder'=>'Phone Number', 'name'=>'primary_contact_phone_number', 'value'=>set_value('primary_contact_phone_number', $primary_contact_phone_number), 'class'=>'form-control', 'autocomplete'=>'off');
										
												echo form_input($data);
										
											?>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <div class="col-xs-12 col-md-12 no-pad-left ">
                                            
                                            
                                       		<?php
											
												$data	= array('placeholder'=>'Position / Role', 'name'=>'primary_contact_role', 'value'=>set_value('primary_contact_role', $primary_contact_role), 'class'=>'form-control', 'autocomplete'=>'off');
										
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
                    
                                <label>Secondary Contact</label>
								
                                 <p class="help-block">
                                
                                   Secondary Contact for this Company
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <div class="col-xs-6 col-md-6 no-pad-left ">
                                            
                                           <?php
											
												$data	= array('placeholder'=>'First Name', 'name'=>'secondary_contact_first_name', 'value'=>set_value('secondary_contact_first_name', $secondary_contact_first_name), 'class'=>'form-control', 'autocomplete'=>'off');
										
												echo form_input($data);
										
											?>
                                            
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-6">

											<?php
											
												$data	= array('placeholder'=>'Last Name', 'name'=>'secondary_contact_last_name', 'value'=>set_value('secondary_contact_last_name', $secondary_contact_last_name), 'class'=>'form-control', 'autocomplete'=>'off');
										
												echo form_input($data);
										
											?>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <div class="col-xs-6 col-md-6 no-pad-left ">
                                            
                                           <?php
											
												$data	= array('placeholder'=>'Email', 'name'=>'secondary_contact_email', 'value'=>set_value('secondary_contact_email', $secondary_contact_email), 'class'=>'form-control', 'autocomplete'=>'off');
										
												echo form_input($data);
										
											?>
                                            
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-6">

											<?php
											
												$data	= array('placeholder'=>'Phone Number', 'name'=>'secondary_contact_phone_number', 'value'=>set_value('secondary_contact_phone_number', $secondary_contact_phone_number), 'class'=>'form-control', 'autocomplete'=>'off');
										
												echo form_input($data);
										
											?>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <div class="col-xs-12 col-md-12 no-pad-left ">
                                            
                                            
                                       		<?php
											
												$data	= array('placeholder'=>'Position / Role', 'name'=>'secondary_contact_role', 'value'=>set_value('secondary_contact_role', $secondary_contact_role), 'class'=>'form-control', 'autocomplete'=>'off');
										
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
                    
                                <label>Activate Company</label>
                                
                                 <p class="help-block">
                                
                                   This is where you activate the company
                                    
                                </p>
                                                        
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <?php
                    	
											$statusoptions 		= 	array(
											
												'0'		=> 	'Disabled',
												'1'		=> 	'Activate'
											);
															
											echo form_dropdown('company_status', $statusoptions, set_value('company_status',$company_status), 'class="form-control"');
										
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