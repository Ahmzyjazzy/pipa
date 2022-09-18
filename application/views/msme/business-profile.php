  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
        Business Profile
              
      </h1>
     
      <ol class="breadcrumb">
      
        <li><a href="<?php echo base_url(); ?>msme/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">Business Profile</li>
      
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
				
				echo form_open(base_url().'msme/business-profile/'.$businessID.'/', $attr); 
			
			?>
             
              <div class="box-body">
            
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
										
                    	echo form_dropdown('country', $countryOptions, set_value('country',$businessCountry), 'class="form-control country"');
                    
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
							
							echo form_dropdown('state', $stateOptions, set_value('state',$businessState), 'class="form-control state statehold"');
							
						}else{
							
							echo form_dropdown('state', $stateOptions, set_value('state',$businessState), 'class="form-control state statehold" disabled="disabled"');
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
							
							echo form_dropdown('lga', $lgaOptions, set_value('lga',$businessLga), 'class="form-control lgahold"');
							
						}else{
							
							
							echo form_dropdown('lga', $lgaOptions, set_value('lga',$businessLga), 'class="form-control lgahold" disabled="disabled"');
							
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
