  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
       	Know Your Customer
      
      </h1>
     
      <ol class="breadcrumb">
        
        <li><a href="<?php echo base_url(); ?>msme/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li><a href="<?php echo base_url().'msme/kyc/'; ?>"> KYC</a></li>
        
        <li class="active">Know Your Customer</li>
        
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">
     
      <div class="row">
       
        <div class="col-lg-7 col-xs-12">
         
          <div class="box box-primary">
            
            <div class="box-header with-border">
            
              <h3 class="box-title">Know Your Customer</h3>
           	
            	<?php
						
					if(!empty($idNumber))
					{
						
						if(empty($kycStatus))
						{
							
							echo '<span class="label label-warning" style="float:right; font-size:20px;">Pending Approval</span>';
							
						}else{
							
							if($kycStatus == '1')
							{
								
								echo '<span title="Approved" class="btn bg-olive" style="float:right;"> Approved </span>';
									
							}else{
								
								echo '<span title="Transaction Declined" class="btn btn-danger" style="float:right;">Declined</span>';
							}
							
						}
						
					}
					
				?>
                        
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
				
				$attr 	= array('role'=> 'form', 'onsubmit'=>'return checkBeforeSubmit()');
				
				echo form_open_multipart(base_url().'msme/kyc/'.$kycID.'', $attr); 
			?>
             
              <div class="box-body">
            				                	
                <div class="tab-pane fade active in">
                
                	<?php
						
						if(!empty($kycStatus))
						{
							
							if($kycStatus == '2')
							{
								
								echo '<div class="alert alert-error">
								   
									<a class="close" data-dismiss="alert">×</a>Your KYC was declined. See reason and Re-Upload</div>';
								
							}
							
						}
				
					?>
                    
                    <div class="form-group">
                    	
                      <?php
					
						if($kycStatus == "2")
						{
							
							echo '<div class="form-group">
			
								   <label>Reason</label>
									
								   <div class="usersell-hold-cnt usersell-naira-amount">'.$reason.'</div>
																					
								</div>';
						
						}
						
					  ?>  
                        
                    </div>
                    
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
                                    
                </div>
                                                                        
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
          		
                <?php
				
				if(!empty($kycStatus))
				{
					if($kycStatus == '1')
					{
													
					}else{
						
						echo '<button type="submit" class="btn btn-primary">Submit</button>';
					}
					
				}else{
					
                	echo '<button type="submit" class="btn btn-primary">Submit</button>';
				
				}
				
				?>
          
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