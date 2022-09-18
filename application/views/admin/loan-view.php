<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/loan-view.css">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
       	Loan Application
      
      </h1>
     
      <ol class="breadcrumb">
        
        <li>
        	
            <a class="btn btn-info" href="<?php echo base_url(); ?>admin/loans/" style="color:#fff;" title="Back">
            
                <i class="fa fa-arrow-circle-left "></i>
                
                Back
                
            </a>
            
        </li>
        
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">
     
      <div class="row">
       
        <div class="col-xs-12 col-md-12 col-lg-12 ">
         
          <div class="box box-primary">
            
            <div class="box-header with-border">
            
              <h3 class="box-title">View Application</h3>
                        
            </div>
            <!-- /.box-header -->
            
            <!-- form start -->
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
			
				if ($this->session->flashdata('success-message')):
			
			?>
               
               <div class="alert alert-info">
                    <a class="close" data-dismiss="alert">×
                    </a>
                    <?php echo $this->session->flashdata('success-message');?>
                </div>
                     
            <?php 
				
				endif; 
				
				//$attr 	= array('role'=> 'form', 'id'=>'msform', 'onsubmit'=>'return checkBeforeSubmit()');
				
				$attr 	= array('role'=> 'form', 'id'=>'msform');
				
				echo form_open_multipart(base_url().'admin/', $attr); 
			?>
             
              <div class="box-body">
            				                	
                <div class="tab-pane fade active in">
                
                	<div class="col-md-12" style="padding-top:20px;">

						<!-- progressbar -->
                        <ul id="progressbar">
                        
                            <li class="active">Personal Details</li>
                            
                            <li>Business Details</li>
                            
                            <li>Know your Customer</li>
                            
                            <li>Loan Details</li>
                            
                        </ul>
                        
                        <!-- fieldsets -->
                        <fieldset>
                           
                            <h2 class="fs-title">Personal Profile</h2>
                                                        
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>First Name</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php echo $userLoan->userLoanProfile['firstName']; ?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Last Name</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php echo $userLoan->userLoanProfile['lastName']; ?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Other Name</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php echo $userLoan->userLoanProfile['otherName']; ?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>

							<div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Mobile Number</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php echo $userLoan->userLoanProfile['mobile']; ?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Bank Verification Number (BVN)</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php echo $userLoan->userLoanProfile['bvn']; ?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>

                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Email</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php echo $userLoan->userLoanProfile['email']; ?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
							
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Gender</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php echo $userLoan->userLoanProfile['gender']; ?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Marital Status</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php echo $userLoan->userLoanProfile['maritalStatus']; ?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
							
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Date of Birth</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php echo $userLoan->userLoanProfile['dateOfBirth']; ?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Country</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
										
											$CI	 					=& get_instance();
											
											if(!empty($userLoan->userLoanProfile['country']))
											{
													
												$country				=	$CI->in_multiarray($userLoan->userLoanProfile['country'], $countries, 'gc_country_id');
												
												echo $country[0]['country_name']; 
											
											}
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>State</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											if(!empty($userLoan->userLoanProfile['state']))
											{
																					
												$state					=	$CI->in_multiarray($userLoan->userLoanProfile['state'], $country_states, 'gc_state_id');
												
												echo $state[0]['state_name']; 
											
											}
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>LGA</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											if(!empty($userLoan->userLoanProfile['lga']))
											{
																						
												$lga					=	$CI->in_multiarray($userLoan->userLoanProfile['lga'], $country_states_lga, 'lga_id');
												
												echo $lga[0]['lga_name'];
											
											}else{
												
												
											}
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Home Address</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php echo $userLoan->userLoanProfile['address']; ?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>

                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>State of Origin</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											if(!empty($userLoan->userLoanProfile['state_of_origin']))
											{
																					
												$stateoforigin				=	$CI->in_multiarray($userLoan->userLoanProfile['state_of_origin'], $country_states, 'gc_state_id');
												
												echo $stateoforigin[0]['state_name']; 
											
											}
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>

                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Religion</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userLoanProfile['religion'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>


							<div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Ethnicity</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userLoanProfile['ethnicity'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                                        
                            
                            <input type="button" name="next" class="next action-button" value="Next" />
                            
                        </fieldset>
                        
                        <fieldset>
                           
                            <h2 class="fs-title">Business Profile</h2>
                             
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Business Name</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userLoanBusiness['businessName'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Is your Company Registered?</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userLoanBusiness['cacRegStatus'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>CAC Reg Number</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userLoanBusiness['cacRegNum'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Number of Partners/Owners</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userLoanBusiness['no_of_owners'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>

                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Tax Identification Number (TIN)</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userLoanBusiness['tin'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Bank</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											if(!empty($userLoan->userLoanBusiness['corporateBankID']))
											{
																					
												$bank				=	$CI->in_multiarray($userLoan->userLoanBusiness['corporateBankID'], $banks, 'bank_id');
												
												echo $bank[0]['bank_name']; 
											
											}
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Account Number</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userLoanBusiness['corporateBankAccount'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Industry</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userLoanBusiness['industry'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Years in Business</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userLoanBusiness['yearsInBusiness'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Country</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
																					
											if(!empty($userLoan->userLoanBusiness['businessCountry']))
											{
													
												$countryBusiness				=	$CI->in_multiarray($userLoan->userLoanBusiness['businessCountry'], $countries, 'gc_country_id');
												
												echo $countryBusiness[0]['country_name']; 
											
											}
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>State</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											if(!empty($userLoan->userLoanBusiness['businessState']))
											{
																					
												$businessstate					=	$CI->in_multiarray($userLoan->userLoanBusiness['businessState'], $businessCountry_states, 'gc_state_id');
												
												echo $businessstate[0]['state_name']; 
											
											}
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>LGA</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											if(!empty($userLoan->userLoanBusiness['businessLga']))
											{
																						
												$businesslga					=	$CI->in_multiarray($userLoan->userLoanBusiness['businessLga'], $businesscountry_states_lga, 'lga_id');
												
												echo $businesslga[0]['lga_name'];
											
											}else{
												
												
											}
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Business Address</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userLoanBusiness['businessAddress'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            
                            <input type="button" name="previous" class="previous action-button" value="Previous" />
                            
                            <input type="button" name="next" class="next action-button" value="Next" />
                        
                        </fieldset>
                        
                        <fieldset>
                           
                            <h2 class="fs-title">Know Your Customer</h2>

							<div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Number of Children</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userKYCdoc->numChildren;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Number of Dependents</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userKYCdoc->numDependents;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Highest Educational Level</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userKYCdoc->highestEducation;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Number of Languages</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userKYCdoc->numLanguages;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>

                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Industry or Professional  Associations</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userKYCdoc->professionalAssoc;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>

                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Number of Employees</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userKYCdoc->numEmployees;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>ID Type</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userKYCdoc->idType;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <?php
							
							if($userLoan->userKYCdoc->idType == 'Others')
							{
								
								?>
                                
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>ID Type (Please Specify)</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userKYCdoc->ifIDothers;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <?php
							}
							
							?>

                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>ID Number</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	

                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userKYCdoc->idNumber;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>ID Image (Front)</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                		
                                        <div class="">
                                            
                                            <img src="<?php echo base_url().'uploads/wysiwyg/images/kycDocs/'.$userLoan->userKYCdoc->idImageFront; ?>" width="250"/>
                                                                        
                                        </div>
                                        
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>ID Image (Back)</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                		
                                        <div class="">
                                            
                                            <img src="<?php echo base_url().'uploads/wysiwyg/images/kycDocs/'.$userLoan->userKYCdoc->idImageBack; ?>" width="250"/>
                                                                        
                                        </div>
                                        
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Utility Bill</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userKYCdoc->utilityType;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <?php
							
							if($userLoan->userKYCdoc->utilityType == 'Others')
							{
								
								?>
                                
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Utility Type (Please Specify)</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->userKYCdoc->ifUtilityothers;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <?php
							}
							
							?>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Utility Image</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                		
                                        <div class="">
                                            
                                            <img src="<?php echo base_url().'uploads/wysiwyg/images/kycDocs/utility/'.$userLoan->userKYCdoc->utilityImage; ?>" width="250"/>
                                                                        
                                        </div>
                                        
                                	</div>
                                    
                                </div>
                                
                            </div>

                            <input type="button" name="previous" class="previous action-button" value="Previous" />
                            <input type="button" name="next" class="next action-button" value="Next" />
						</fieldset>
                        
                        <fieldset>
                        
                            <h2 class="fs-title">Loan Details</h2>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Loan Type</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->loanType['loanType'];
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>Amount you have invested in your business in the last 3 years (may require evidence)</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->amountInvestedInBusiness;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>How much money do you need?</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo '&#x20A6;'.number_format($userLoan->loanAmount, 2);
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
							
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>How long will you like to take to repay it?</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->loanTenure.' Months';
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>What will the funds be used for?</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->loanPurpose;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>
                            
                                 <div class="form-group">
                                
                                <div class="col-xs-4 col-md-4 no-padding-left">
                                	
                                    <div class="viewloan-hdr">
                                    
                                		<label>If approved, what impact will this loan have on your business?</label>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-8 col-md-8">
                                	
                                    <div class="viewloan-fld">
                                    
                                		<?php 
											
											echo $userLoan->businessImpact;
										
										?>
                                
                                	</div>
                                    
                                </div>
                                
                            </div>

                            
                            <input type="button" name="previous" class="previous action-button" value="Previous" />
                            
                            <?php 
							
								if(!empty($userLoan->loanStatus))
								{
									
									if($userLoan->loanStatus == '1')
									{
										
										echo '<a href="'.base_url().'admin/risk-analysis/'.$userLoan->loanID.'/" class="btn action-button viewbtnclr btnColor2">Finalize Loan</a>';
										
									}else{
										
										
									}
									
								}else{
									
									echo '<a href="'.base_url().'admin/loan-application/'.$userLoan->loanID.'/" class="btn action-button viewbtnclr btnColor1">Process Loan</a>';
										
								}
							
							?>
                            
                         
                        </fieldset>
    

						<!-- End Multi step form -->   
   
                    </div>
                
                </div>
                                                                        
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
          
              </div>
          
            </form>
          
          </div>
          
          <!-- /.box -->
          
        </div>
        <!-- /.col -->
        
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
    
  </div>  
  <!-- /.content-wrapper -->
  
  <script src="http://thecodeplayer.com/uploads/js/jquery.easing.min.js" type="text/javascript"></script>


<script src="<?php echo base_url(); ?>asset/js/loan.js"></script>