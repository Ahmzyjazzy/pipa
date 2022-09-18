<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/loan.css">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
       	Loan Application
      
      </h1>
     
      <ol class="breadcrumb">
        
        <li><a href="<?php echo base_url(); ?>msme/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li><a href="<?php echo base_url().'msme/apply-for-loan/'; ?>"> Apply For Loan</a></li>
        
        <li class="active">Loan Application</li>
        
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">
     
      <div class="row">
       
        <div class="col-xs-12 col-md-12 col-lg-12 ">
         
          <div class="box box-primary">
            
            <div class="box-header with-border">
            
              <h3 class="box-title"><?php echo $loanType['loanType']; ?></h3>
                        
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
				
				echo form_open_multipart(base_url().'msme/loan-application/'.$loanType['loanTypeSlug'].'/', $attr); 
			?>
             
              <div class="box-body">
            				                	
                <div class="tab-pane fade active in">
                
                	<div class="col-md-12" style="padding-top:20px;">
                         
                 
   						<!-- Multi step form --> 
 
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
                                
                                <label>First Name</label>
                                    
                                <?php
                                    
                                    $data	= array('placeholder'=>'First Name', 'name'=>'firstName', 'value'=>set_value('firstName', $firstName), 'class'=>'form-control');
                                    
                                    echo form_input($data);
                                    
                                ?>
                                
                            </div>
                            
                            <div class="form-group">
            
                                <label>Last Name</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Last Name', 'name'=>'lastName', 'value'=>set_value('lastName', $lastName), 'class'=>'form-control');
                                
                                    echo form_input($data);
                                
                                ?>
                            
                            </div>
                            
                            <div class="form-group">
            
                                <label>Other Name</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Other Name', 'name'=>'otherName', 'value'=>set_value('otherName', $otherName), 'class'=>'form-control');
                                
                                    echo form_input($data);
                                
                                ?>
                            
                            </div>
                          
                            <div class="form-group">
                                
                                <label>Mobile Number</label>
                                
                                <?php
                                    
                                    $data	= array('placeholder'=>'Mobile', 'name'=>'mobile', 'value'=>set_value('mobile', $mobile), 'class'=>'form-control phone_n_');
                                    
                                    echo form_input($data);
                                    
                                ?>
                                                                       
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Bank Verification Number (BVN)</label>
                                
                                <?php
                                    
                                    $data	= array('placeholder'=>'Bank Verification Number', 'name'=>'bvn', 'value'=>set_value('bvn', $bvn), 'class'=>'form-control phone_n_');
                                    
                                    echo form_input($data);
                                    
                                ?>
                                                                       
                            </div>
                            
                            <div class="form-group">
                    
                                <label>Email</label>
                                
                                <?php
                               
                                    $data	= array('placeholder'=>'Email', 'name'=>'email', 'value'=>set_value('email', $email), 'class'=>'form-control', 'readonly'=>'readonly');
                                    
                                    echo form_input($data);
                                
                                ?>
                                                                       
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Gender</label>
                                
                                <?php
                                    
                                    $genderoptions 		= 	array(	 
                                    
                                            ''			=> 	'-- Select Gender --'
                                            ,'Male'		=> 	'Male'
                                            ,'Female'	=> 	'Female'
                                     );
                                                    
                                    echo form_dropdown('gender', $genderoptions, set_value('gender',$gender), 'class="form-control"');
                                
                                ?>
                                                           
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Marital Status</label>
                                
                                <?php
                                    
                                    $maritaloptions 		= 	array(	 
                                    
                                            ''				=> 	'-- Select Marital Status --'
                                            ,'Single'		=> 	'Single'
                                            ,'Married'		=> 	'Married'
                                            ,'Divorced'		=> 	'Divorced'
                                            ,'Widowed'		=> 	'Widowed'
                                            ,'Others'		=> 	'Others'
                                     );
                                                    
                                    echo form_dropdown('maritalStatus', $maritaloptions, set_value('maritalStatus',$maritalStatus), 'class="form-control"');
                                
                                ?>
                                                           
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Date of Birth</label>
                                
                                <?php
                                    
                                    $data	= array('placeholder'=>'Date of Birth', 'name'=>'dateOfBirth', 'value'=>set_value('dateOfBirth', $dateOfBirth), 'class'=>'form-control datepicker');
                                    
                                    echo form_input($data);
                                    
                                ?>
                                                                       
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Country</label>
                                
                                <?php
                                    
                                    $countryOptions['0']	=	'-- Select Country --';
                                    
                                    if(!empty($countries))
                                    {
                                        
                                        foreach($countries as $countri)
                                        {
                                            
                                            $countryOptions[$countri['gc_country_id']]	=	$countri['country_name'];
                                            
                                        }
                                        
                                    }
                                                    
                                    echo form_dropdown('country', $countryOptions, set_value('country',$country), 'class="form-control country"');
                                
                                ?>
                                                           
                            </div>
                            
                            <div class="form-group">
                                
                                <label>State</label>
                                
                                <?php
                                    
                                    $stateOptions['0']	=	'-- Select State --';
                                    
                                    if(!empty($country_states))
                                    {
                                        
                                        foreach($country_states as $states)
                                        {
                                            
                                            $stateOptions[$states['gc_state_id']]	=	$states['state_name'];
                                            
                                        }
                                        
                                        echo form_dropdown('state', $stateOptions, set_value('state',$state), 'class="form-control state statehold"');
                                        
                                    }else{
                                        
                                        echo form_dropdown('state', $stateOptions, set_value('state',$state), 'class="form-control state statehold" disabled="disabled"');
                                    }
                                                    
                                    
                                
                                ?>
                                                           
                            </div>
                            
                            <div class="form-group">
                                
                                <label>LGA</label>
                                
                                <?php
                                    
                                    $lgaOptions['0']	=	'-- Select LGA--';
                                    
                                    if(!empty($country_states_lga))
                                    {
                                        
                                        foreach($country_states_lga as $state_lga)
                                        {
                                            
                                            $lgaOptions[$state_lga['lga_id']]	=	$state_lga['lga_name'];
                                            
                                        }
                                        
                                        echo form_dropdown('lga', $lgaOptions, set_value('lga',$lga), 'class="form-control lgahold"');
                                        
                                    }else{
                                        
                                        
                                        echo form_dropdown('lga', $lgaOptions, set_value('lga',$lga), 'class="form-control lgahold" disabled="disabled"');
                                        
                                    }
                                                                        
                                ?>
                                                         
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Home Address</label>
                                
                                <?php
                               
                                    $data	= array('placeholder'=>'Home Address', 'name'=>'homeAddress', 'value'=>set_value('homeAddress', $address), 'class'=>'form-control');
                                    
                                    echo form_input($data);
                                
                                ?>
                                                                       
                            </div>
                            
                            <div class="form-group">
                                
                                <label>State of Origin</label>
                                
                                <?php
                                    
                                    $stateOptions['0']	=	'-- Select State of Origin --';
                                    
                                    if(!empty($country_states))
                                    {
                                        
                                        foreach($country_states as $states)
                                        {
                                            
                                            $stateOptions[$states['gc_state_id']]	=	$states['state_name'];
                                            
                                        }
                                        
                                        echo form_dropdown('state_of_origin', $stateOptions, set_value('state_of_origin',$state_of_origin), 'class="form-control stateoforigin statehold"');
                                        
                                    }else{
                                        
                                        echo form_dropdown('state_of_origin', $stateOptions, set_value('state_of_origin',$state_of_origin), 'class="form-control stateoforigin statehold" disabled="disabled"');
                                    }
                                                    
                                    
                                
                                ?>
                                                           
                            </div>
                                        
                            <div class="form-group">
                                
                                <label>Religion</label>
                                
                                <?php
                                    
                                    $religionoptions 			= 	array(	 
                                    
                                            ''					=> 	'-- Select Religion --'
                                            ,'Christianity'		=> 	'Christianity'
                                            ,'Islam'			=> 	'Islam'
                                            ,'Traditional'		=> 	'Traditional'
                                            ,'Others'			=> 	'Others'
                                     );
                                                    
                                    echo form_dropdown('religion', $religionoptions, set_value('religion',$religion), 'class="form-control"');
                                
                                ?>
                                                           
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Ethnicity</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Ethnicity', 'name'=>'ethnicity', 'value'=>set_value('ethnicity', $ethnicity), 'class'=>'form-control');
                                
                                    echo form_input($data);
                                
                                ?>
                                                           
                            </div>
                                        
                            
                            <input type="button" name="next" class="next action-button" value="Next" />
                            
                        </fieldset>
                        
                        <fieldset>
                           
                            <h2 class="fs-title">Business Profile</h2>
                                                       
                            <div class="form-group">
                  	
                                <label>Business Name</label>
                                    
                                <?php
                                    
                                    $data	= array('placeholder'=>'Business Name', 'name'=>'businessName', 'value'=>set_value('businessName', $businessName), 'class'=>'form-control');
                                    
                                    echo form_input($data);
                                    
                                ?>
                                
                            </div>
                            
                            <div class="form-group">
            
                                <label>Is your Company Registered?</label>
                                
                                <?php
                                    
                                    $cacoptions 		= 	array(	 
                                    
                                            ''			=> 	'-- Select Option --'
                                            ,'Yes'		=> 	'Yes'
                                            ,'No'		=> 	'No'
                                     );
                                                    
                                    echo form_dropdown('cacRegStatus', $cacoptions, set_value('cacRegStatus',$cacRegStatus), 'class="form-control"');
                                
                                ?>
                            
                            </div>
                          
                            <div class="form-group">
                                
                                <label>CAC Reg Number</label>
                                
                                <?php
                                    
                                    $data	= array('placeholder'=>'CAC Reg Number', 'name'=>'cacRegNum', 'value'=>set_value('cacRegNum', $cacRegNum), 'class'=>'form-control');
                                    
                                    echo form_input($data);
                                    
                                ?>
                                                                       
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Number of Partners/Owners</label>
                                
                                <?php
                                    
                                    $data	= array('placeholder'=>'Number of Owners', 'name'=>'no_of_owners', 'value'=>set_value('no_of_owners', $no_of_owners), 'class'=>'form-control phone_n_');
                                    
                                    echo form_input($data);
                                    
                                ?>
                                                                       
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Tax Identification Number (TIN)</label>
                                
                                <?php
                                    
                                    $data	= array('placeholder'=>'Tax Identification Number', 'name'=>'tin', 'value'=>set_value('tin', $tin), 'class'=>'form-control');
                                    
                                    echo form_input($data);
                                    
                                ?>
                                                                       
                            </div>
                            
                            <div class="form-group">
            
                               <label>Bank</label>
                                
                               <?php
                                    
                                    $bankOptions = array(	 
                                        
                                        '0'		=> 'Select Bank'
                                        
                                    );
                                    
                                    foreach($banks as $bank):
                                        
                                        $bankOptions[$bank['bank_id']]	=	$bank['bank_name'];
                                    
                                    endforeach;
                                    
                                                    
                                    echo form_dropdown('corporateBankID', $bankOptions, set_value('corporateBankID',$corporateBankID), 'class="form-control"');
                                    
                                    
                                ?>
                                                                                
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Account Number</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Your Corporate Account Number', 'name'=>'corporateBankAccount', 'value'=>set_value('corporateBankAccount', $corporateBankAccount), 'class'=>'form-control phone_n_');
                                
                                    echo form_input($data);
                                
                                ?>
                                    
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Industry</label>
                                
                                <?php
                               
                                    $data	= array('placeholder'=>'Industry', 'name'=>'industry', 'value'=>set_value('industry', $industry), 'class'=>'form-control');
                                    
                                    echo form_input($data);
                                
                                ?>
                                                                       
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Years in Business</label>
                                
                                <?php
                                    
                                    $yearsInBusinessOptions 		= 	array(	 
                                    
                                            ''			=> 	'-- Select Options --'
                                            ,'1'		=> 	'1'
                                            ,'2'	=> 	'2'
                                            ,'3'	=> 	'3'
                                            ,'4'	=> 	'4'
                                            ,'5+'	=> 	'5+'
                                     );
                                                    
                                    echo form_dropdown('yearsInBusiness', $yearsInBusinessOptions, set_value('yearsInBusiness',$yearsInBusiness), 'class="form-control"');
                                
                                ?>
                                                           
                            </div>
            
                                            
                            <div class="form-group">
                                
                                <label>Country</label>
                                
                                <?php
                                    
                                    $countryOptions['0']	=	'-- Select Country --';
                                    
                                    if(!empty($countries))
                                    {
                                        
                                        foreach($countries as $countri)
                                        {
                                            
                                            $countryOptions[$countri['gc_country_id']]	=	$countri['country_name'];
                                            
                                        }
                                        
                                    }
                                                    
                                    echo form_dropdown('businessCountry', $countryOptions, set_value('businessCountry',$businessCountry), 'class="form-control businesscountry"');
                                
                                ?>
                                                           
                            </div>
                            
                            <div class="form-group">
                                
                                <label>State</label>
                                
                                <?php
                                    
                                    $businessStateOptions['0']	=	'-- Select State --';
                                    
                                    if(!empty($businessCountry_states))
                                    {
                                        
                                        foreach($businessCountry_states as $businessStates)
                                        {
                                            
                                            $businessStateOptions[$businessStates['gc_state_id']]	=	$businessStates['state_name'];
                                            
                                        }
                                        
                                        echo form_dropdown('businessState', $businessStateOptions, set_value('businessState',$businessState), 'class="form-control businessstate businessStatehold"');
                                        
                                    }else{
                                        
                                        echo form_dropdown('businessState', $businessStateOptions, set_value('businessState',$businessState), 'class="form-control businessstate businessStatehold" disabled="disabled"');
                                    }
                                                    
                                    
                                
                                ?>
                                                           
                            </div>
                            
                            <div class="form-group">
                                
                                <label>LGA</label>
                                
                                <?php
                                    
                                    $businesslgaOptions['0']	=	'-- Select LGA--';
                                    
                                    if(!empty($businesscountry_states_lga))
                                    {
                                        
                                        foreach($businesscountry_states_lga as $business_state_lga)
                                        {
                                            
                                            $businesslgaOptions[$business_state_lga['lga_id']]	=	$business_state_lga['lga_name'];
                                            
                                        }
                                        
                                        echo form_dropdown('businessLga', $businesslgaOptions, set_value('businessLga',$businessLga), 'class="form-control businesslgahold"');
                                        
                                    }else{
                                        
                                        
                                        echo form_dropdown('businessLga', $businesslgaOptions, set_value('businessLga',$businessLga), 'class="form-control businesslgahold" disabled="disabled"');
                                        
                                    }
                                                                        
                                ?>
                                                         
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Business Address</label>
                                
                                <?php
                               
                                    $data	= array('placeholder'=>'Business Address', 'name'=>'businessAddress', 'value'=>set_value('businessAddress', $businessAddress), 'class'=>'form-control');
                                    
                                    echo form_input($data);
                                
                                ?>
                                                                       
                            </div>
                            
                            
                            <input type="button" name="previous" class="previous action-button" value="Previous" />
                            
                            <input type="button" name="next" class="next action-button" value="Next" />
                        
                        </fieldset>
                        
                        <fieldset>
                           
                            <h2 class="fs-title">Know Your Customer</h2>

                            <div class="form-group">
                        
                                <label>Number of Children</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Number of Children', 'name'=>'numChildren', 'value'=>set_value('numChildren', $numChildren), 'class'=>'form-control phone_n_');
                                
                                    echo form_input($data);
                                
                                ?>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Number of Dependents</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Number of Dependents', 'name'=>'numDependents', 'value'=>set_value('numDependents', $numDependents), 'class'=>'form-control phone_n_');
                                
                                    echo form_input($data);
                                
                                ?>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Highest Educational Level</label>
                                
                                <?php
                                    
                                    $educationOptions = array(	 
                                        
                                        ''					=>	'Select Highest Education',
                                        'Primary 6'			=> 	'Primary 6',
                                        'SSCE'				=>	'SSCE',
                                        'OND'				=>	'OND',
                                        'HND'				=>	'HND', 
                                        'Bachelors Degree'	=>	'Bachelors Degree',
                                        'Masters Degree'	=>	'Masters Degree',
                                        'PhD'				=>	'PhD'                                 
                                    );
                                    
                                                    
                                    echo form_dropdown('highestEducation', $educationOptions, set_value('highestEducation', $highestEducation), 'class="form-control"');
                                    
                                    
                                ?>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Number of Languages</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Number of Languages', 'name'=>'numLanguages', 'value'=>set_value('numLanguages', $numLanguages), 'class'=>'form-control phone_n_');
                                
                                    echo form_input($data);
                                
                                ?>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Industry or Professional  Associations</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Industry or Professional  Associations', 'name'=>'professionalAssoc', 'value'=>set_value('professionalAssoc', $professionalAssoc), 'class'=>'form-control');
                                
                                    echo form_input($data);
                                
                                ?>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Number of Employees</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Number of Employees', 'name'=>'numEmployees', 'value'=>set_value('numEmployees', $numEmployees), 'class'=>'form-control phone_n_');
                                
                                    echo form_input($data);
                                
                                ?>
                                
                            </div>
                            
                            
                            <div class="form-group">
                                
                                
                                <label>ID Type</label>
                                
                                <?php
                                        
                                    $options = array(	 
                                        
                                        ''							=>	'Select ID Type',
                                        'International Passport'	=> 	'International Passport',
                                        'Drivers license'			=>	'Driver\'s license',
                                        'Voters Identity Card'		=>	'Voter\'s Identity Card',
                                        'National ID Card'			=>	'National ID Card',
                                        'Others'					=>	'Others'                                
                                    );
                                    
                                                    
                                    echo form_dropdown('idType', $options, set_value('idType', $idType), 'class="form-control idType"');
                                    
                                    
                                ?>
                                
                            </div>
                            
                            <div class="form-group idothers" style="display:none;">
                                
                                <label>ID Type (Please Specify)</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'ID Type (Please Specify)', 'name'=>'ifIDothers', 'value'=>set_value('ifIDothers', $ifIDothers ), 'class'=>'form-control ifIDothers');
                                
                                    echo form_input($data);
                                
                                ?>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <label>ID Number</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'ID Number', 'name'=>'idNumber', 'value'=>set_value('idNumber', $idNumber), 'class'=>'form-control');
                                
                                    echo form_input($data);
                                
                                ?>
                                
                            </div>
                            
                            <div class="form-group">
                        
                                <label>ID Image (Front)</label>
                                
                                <?php
                                if($img_link_front != ""){
                                
                                ?>
                                <div class="first-app" style="padding-top:10px;">
                                
                                    <?php
                                    if($kycStatus == '1')
                                    {
                                        
                                        //if the kyc has been approved remove the change picture for the user
                                        
                                    }else{
                                        
                                        //still display the change picture so they can make changes
                                    
                                    ?>
                                    
                                        <div class="chnge-homebanner change-img" style="cursor:pointer; float:left;">
                                            
                                            Change Picture
                                            
                                        </div>
                                    
                                    <?php
                                    
                                    }
                                    
                                    ?>
                                
                                    <div class="" style="float:right;">
                                        
                                        <img src="<?php echo base_url().'uploads/wysiwyg/images/kycDocs/'.$img_link_front; ?>" width="250"/>
                                                                    
                                    </div>
                                
                                </div>
                                
                                <div class="banner-img" style="display:none;">
                                    
                                    <input name="photo1" type="file" id="InputFile" class="BSbtnsuccess" />
                                
                                </div>
                                
                                <?php
                                
                                }else{
                                    
                                ?>
                                
                                <input name="photo1" type="file" id="InputFile" class="BSbtnsuccess" />
        
                                <?php
                                
                                }
                                
                                ?>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Image link', 'name'=>'img_link_front', 'value'=>set_value('img_link_front', $img_link_front), 'style'=>'display:none', 'class'=>'form-control banner_link');
                                    
                                    echo form_input($data);
                                
                                ?>
                                 
                            </div> 
                            
                            <div class="form-group">
                        
                                <label>ID Image (Back)</label>
                                
                                <?php
                                if($img_link_back != ""){
                                
                                ?>
                                <div class="first-app2" style="padding-top:10px;">
                                
                                    <?php
                                    if($kycStatus == '1')
                                    {
                                        
                                        //if the kyc has been approved remove the change picture for the user
                                        
                                    }else{
                                        
                                        //still display the change picture so they can make changes
                                    
                                    ?>
                                    
                                    <div class="chnge-homebanner change-img2" style="cursor:pointer; float:left;">
                                        Change Picture
                                    </div>
                                    
                                    <?php
                                    
                                    }
                                    
                                    ?>
                                
                                    <div class="" style="float:right;">
                                        
                                        <img src="<?php echo base_url().'uploads/wysiwyg/images/kycDocs/'.$img_link_back; ?>" width="250"/>
                                    
                                         
                                         
                                    </div>
                                
                                </div>
                                
                                <div class="banner-img2" style="display:none;">
                                    
                                    <input name="photo2" type="file" id="InputFile" class="BSbtnsuccess" />
                                
                                </div>
                                
                                <?php
                                
                                }else{
                                    
                                ?>
                                
                                <input name="photo2" type="file" id="InputFile" class="BSbtnsuccess" />
                                
                                <?php
                                
                                }
                                
                                ?>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Image link', 'name'=>'img_link_back', 'value'=>set_value('img_link_back', $img_link_back), 'style'=>'display:none', 'class'=>'form-control banner_link2');
                                    
                                    echo form_input($data);
                                
                                ?>
                                 
                            </div>
                            
                            <div class="form-group">
                                
                                <label>Utility Bill</label>
                                
                                <?php
                                    
                                    $utilityOptions = array(	 
                                        
                                        ''					=>	'Select Utility Type',
                                        'PHCN'				=> 	'PHCN',
                                        'Water Bill'		=>	'Water Bill',
                                        'Others'			=>	'Others'                                
                                    );
                                    
                                                    
                                    echo form_dropdown('utilityType', $utilityOptions, set_value('utilityType', $utilityType), 'class="form-control utilityType"');
                                    
                                    
                                ?>
                                
                            </div>
                            
                            <div class="form-group utilityothers" style="display:none;">
                                
                                <label>Utility Type (Please Specify)</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Utility Type (Please Specify)', 'name'=>'ifUtilityothers', 'value'=>set_value('ifUtilityothers', $ifUtilityothers), 'class'=>'form-control ifUtilityothers');
                                
                                    echo form_input($data);
                                
                                ?>
                                
                            </div>
                            
                            <div class="form-group">
                        
                                <label>Upload Utility</label>
                                
                                <?php
                                if($utilityImage != ""){
                                
                                ?>
                                <div class="first-app3" style="padding-top:10px;">
                                
                                    <?php
                                    if($kycStatus == '1')
                                    {
                                        
                                        //if the kyc has been approved remove the change picture for the user
                                        
                                    }else{
                                        
                                        //still display the change picture so they can make changes
                                    
                                    ?>
                                        
                                    <div class="chnge-homebanner change-img3" style="cursor:pointer; float:left;">
                                        Change Picture
                                    </div>
                                    
                                    <?php
                                    
                                    }
                                    
                                    ?>
                                
                                    <div class="" style="float:right;">
                                        
                                        <img src="<?php echo base_url().'uploads/wysiwyg/images/kycDocs/utility/'.$utilityImage; ?>" width="250"/>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="banner-img3" style="display:none;">
                                    
                                    <input name="photo3" type="file" id="InputFile" class="BSbtnsuccess" />
                                
                                </div>
                                
                                <?php
                                
                                }else{
                                    
                                ?>
                                
                                <input name="photo3" type="file" id="InputFile" class="BSbtnsuccess" />
                                
                                <?php
                                
                                }
                                
                                ?>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Image link', 'name'=>'utilityImage', 'value'=>set_value('utilityImage', $utilityImage), 'style'=>'display:none', 'class'=>'form-control banner_link3');
                                    
                                    echo form_input($data);
                                
                                ?>
                                
                                 <script src="<?php echo base_url(); ?>asset/js/bootstrap-filestyle.min.js"></script>
                                
                                 <?php
                                if (!$this->agent->is_mobile())
                                {
        
                                }else{
                                    
                                }
                                    
                                ?>
                                 
                            </div>                     
                            
                            <input type="button" name="previous" class="previous action-button" value="Previous" />
                            <input type="button" name="next" class="next action-button" value="Next" />
						</fieldset>
                        
                        <fieldset>
                        
                            <h2 class="fs-title">Loan Details</h2>
                            
                            <div class="form-group">
                                
                                <label>Amount you have invested in your business in the last 3 years (may require evidence)</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Amount Invested in Business', 'name'=>'amountInvestedInBusiness', 'value'=>set_value('amountInvestedInBusiness', $amountInvestedInBusiness), 'class'=>'form-control phone_n_');
                                
                                    echo form_input($data);
                                
                                ?>
                                    
                            </div>
                            
                            <div class="form-group">
                                
                                <label>How much money do you need?</label>
                                
                                <?php
                                
                                    $data	= array('placeholder'=>'Loan Amount', 'name'=>'loanAmount', 'value'=>set_value('loanAmount', $loanAmount), 'class'=>'form-control phone_n_');
                                
                                    echo form_input($data);
                                
                                ?>
                                    
                            </div>
                            
                            <div class="form-group">
            
                               <label>How long will you like to take to repay it?</label>
                                
                               <?php
                                    
                                    $tenureOptions = array(	 
                                        
										'0'			=> 	'Select Loan Tenure',
                                        '12'		=> 	'12 Months',
										'24'		=>	'24 Months',
										'36'		=>	'36 Months'
                                        
                                    );
                                    
                                                    
                                    echo form_dropdown('loanTenure', $tenureOptions, set_value('loanTenure',$loanTenure), 'class="form-control"');
                                    
                                    
                                ?>
                                                                                
                            </div>
                            
                            <div class="form-group">
    
                              <label>What will the funds be used for?</label>
        
                                <textarea name="loanPurpose" id="loanPurpose" class="form-control loanPurpose"><?php echo $loanPurpose; ?></textarea>
                                
                                <script>
                                
                                    $(document).ready(function(e) {
                                        
                                        tinymce.init({ 
                                        
                                            selector:'#loanPurpose',
                                        
                                           
                                            height: 200,
                                            
                                            relative_urls: false,
                                            remove_script_host: false,
                                        
                                            /*toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent emoticons',
                                            
                                            plugins : 'advlist autolink link image lists charmap print preview emoticons'*/
                                            
                                            plugins: [
                                              'advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker',
                                              'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
                                              'save table contextmenu directionality emoticons template paste textcolor'
                                            ],
                                            
                                            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview fullpage | forecolor backcolor emoticons'
 
                                         });
                                    
                                    });
                                
                                </script>
                            
                            </div>
                            
                            
                            <div class="form-group">
    
                              <label>If approved, what impact will this loan have on your business?</label>
        
                                <textarea name="businessImpact" id="businessImpact" class="form-control businessImpact"><?php echo $businessImpact; ?></textarea>
                                
                                <script>
                                
                                    $(document).ready(function(e) {
                                        
                                        tinymce.init({ 
                                        
                                            selector:'#businessImpact',
                                        
                                           
                                            height: 200,
                                            
                                            relative_urls: false,
                                            remove_script_host: false,
                                        
                                            /*toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent emoticons',
                                            
                                            plugins : 'advlist autolink link image lists charmap print preview emoticons'*/
                                            
                                            plugins: [
                                              'advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker',
                                              'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
                                              'save table contextmenu directionality emoticons template paste textcolor'
                                            ],
                                            
                                            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview fullpage | forecolor backcolor emoticons'
 
                                         });
                                    
                                    });
                                
                                </script>
                            
                            </div>
                            
                            <input type="button" name="previous" class="previous action-button" value="Previous" />
                            
                            <input type="submit" name="submit" class="submit action-button" value="Submit" />
                            
<!--                            <button type="submit" class="submit action-button">Submit</button>
-->                            
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