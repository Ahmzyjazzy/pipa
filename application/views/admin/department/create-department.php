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
                    
                    echo form_open_multipart(base_url().'admin/create-department/'.$department_id, $attr); 
                
                ?>
                
                    <div class="col-xs-12 col-md-12">
                        
                        <div class="setup-form-header-cont">
                            
                            <div class="setup-form-header">
                                
                                Department
                                
                            </div>
                            
                            <div class="setup-form-header-sub-text">
                                
                                Provide the departments of this Company
                                
                            </div>
                        
                        </div>
                    
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Department Name</label>
                                
                                <p class="help-block">
                                
                                    What would you like to call this department
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <fieldset>
                                    
                                    <legend>Department</legend>
                                
                                     <?php
										
										$data	= array('placeholder'=>'Department', 'name'=>'department', 'value'=>set_value('department', $department), 'class'=>'form-control form-no-style', 'autocomplete'=>'off');
										
										echo form_input($data);
										
									?>
                                    
                                </fieldset>
                                           
                               
                                                           
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <?php
					
						if($user_company == '1')
						{
							
							$style			=	'';
							
						}else{
							
							$company_id		=	$user_company;
							
							$style			=	'style="display:none;"';
							
						}
					
					?>
                    <div class="col-xs-12 col-md-12 admin-form-row" <?php echo $style; ?>>
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Company</label>
                                
                                <p class="help-block">
                                
                                    Select the Company this department belongs to
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">                                  
								
                                <?php
                                    
                                    $companyOptions['0']		=	'-- Company --';
                                    
                                    if(!empty($companies))
                                    {
                                        
                                        foreach($companies as $company)
                                        {
                                            
                                            $companyOptions[$company['company_id']]	=	$company['company_name'];
                                            
                                        }
                                        
                                    }
                                                    
                                    echo form_dropdown('company_id', $companyOptions, set_value('company_id',$company_id), 'class="form-control"');
                                
                                ?>
              
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