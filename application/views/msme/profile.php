  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
        Profile
              
      </h1>
     
      <ol class="breadcrumb">
      
        <li><a href="<?php echo base_url(); ?>msme/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">My Profile</li>
      
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">
     
      <div class="row">
       
        <div class="col-lg-7 col-xs-12">
         
          <div class="box box-primary">
            
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
				
				$attr 	= array('role'=> 'form', 'onsubmit'=>'return checkBeforeSubmit()');
				
				echo form_open_multipart(base_url().'msme/profile/', $attr); 
			
			?>
             
              <div class="box-body">
            
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
                
                <div class="form-group" style="display:none;">
                    
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
                   
						$data	= array('placeholder'=>'Home Address', 'name'=>'address', 'value'=>set_value('address', $address), 'class'=>'form-control');
						
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
                
                <div class="form-group">
            
                    <label>Passport Photograph</label>
                    
                    <?php
                    if($profilePicture != ""){
                    
                    ?>
                    <div class="first-app" style="padding-top:10px;">

                        <div class="chnge-homebanner change-img" style="cursor:pointer; float:left;">
                            
                            Change Picture
                            
                        </div>

                    
                        <div class="" style=" float:right;">
                            
                            <img src="<?php echo base_url().'uploads/wysiwyg/images/profilepic/'.$profilePicture; ?>" width="150"/>
                                                        
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
                    
                        $data	= array('placeholder'=>'Image link', 'name'=>'profilePicture', 'value'=>set_value('profilePicture', $profilePicture), 'style'=>'display:none', 'class'=>'form-control banner_link');
                        
                        echo form_input($data);
                    
                    ?>
                     
                </div>

                
                <div class="form-group">

					<label>Password </label>
						
					<?php
						
						$data	= array('placeholder'=>'Current Password', 'name'=>'cur_password', 'type'=>'password', 'class'=>'form-control');
						
						echo form_input($data);
					
					?>
                    
                    <p class="help-block">
                    
                    	Supply your password to save changes
                        
                    </p>
                                                            
                </div>
                
                <div class="form-group">
                	
                    <p class="help-block">
                    
                    	If you do not wish to change password, leave both fields blank 
                        
                    </p>
                    
                </div>
                
                <div class="form-group">

					<label>New Password </label>
						
					<?php
						
						$data	= array('placeholder'=>'New Password', 'name'=>'new_password', 'type'=>'password', 'class'=>'form-control');
						
						echo form_input($data);
					
					?>
                                                           
                </div>
                
                <div class="form-group">
                    
					<label>Confirm Password</label>
						
					<?php
                    	
						$data	= array('placeholder'=>'Confirm Password', 'name'=>'conf_password', 'type'=>'password', 'class'=>'form-control');
                    	
						echo form_input($data);
                    ?>
                                                           
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
          
                <button type="submit" class="btn btn-primary">Submit</button>
          
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
