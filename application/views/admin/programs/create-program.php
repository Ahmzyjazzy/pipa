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
                    
                    echo form_open(base_url().'admin/create-program/'.$program_id, $attr); 
                
                ?>
                
                    <div class="col-xs-12 col-md-12">
                        
                        <div class="setup-form-header-cont">
                            
                            <div class="setup-form-header">
                                
                                Now lets create your program
                                
                            </div>
                            
                            <div class="setup-form-header-sub-text">
                                
                                Provide basic information on this program
                                
                            </div>
                        
                        </div>
                    
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Program Name</label>
                                
                                <p class="help-block">
                                
                                    What would you like to call your project
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <fieldset>
                                    
                                    <legend>Program name</legend>
                                
                                     <?php
										
										$data	= array('placeholder'=>'Program Name', 'name'=>'program_name', 'value'=>set_value('program_name', $program_name), 'class'=>'form-control form-no-style', 'autocomplete'=>'off');
										
										echo form_input($data);
										
									?>
                                    
                                </fieldset>
                                           
                               
                                                           
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Category of participant</label>
                                
                                <p class="help-block">
                                
                                    Select the grade level of the leaders that will be participating in this program
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <?php
									
									//$options['0'] 	= 	'Select grade level';
									
									/*foreach($grades as $company_grades)
									{
										
										$options[$company_grades['grade_id']] 	= 	$company_grades['grade'];
											
										
									}*/
									
									echo '<select class="form-control select2" multiple="multiple" name="grade_id[]" data-placeholder="Select grade level" style="width: 100%;">';

									foreach($grades as $company_grades)
									{
										
										echo '<option value="'.$company_grades['grade_id'].'"'; 
										
										if(!empty($grade_id))
										{ 
										
											if(in_array($company_grades['grade_id'], $grade_id))
											{ 
											
												echo 'selected';  
											
											}
										
										}
										
										echo '>'.$company_grades['grade'].'</option>';
											
										
									}
									
									
									echo '</select>';
										
									//echo form_dropdown('grade_id[]', $options, set_value('grade_id[]',$grade_id[]), 'class="form-control select2" multiple="multiple" data-placeholder="Select grade level" style="width: 100%;"');
								
								?>

<!--                                <select class="form-control select2" multiple="multiple" name="grade_id[]" data-placeholder="Select grade level" style="width: 100%;">
-->                                  
                                  
                                 <!-- <option value="0">Select grade level</option>-->
                                  
                                  <?php
								  
								  /*	foreach($grades as $company_grades)
									{
										
										echo '<option value="'.$options[$company_grades['grade_id']].'">'.$company_grades['grade'].'</option>';
											
										
									}
									*/
								  ?>
                                  
                                  
                                 <!-- <option>Alabama</option>
                                  <option>Alaska</option>
                                  <option>California</option>
                                  <option>Delaware</option>
                                  <option>Tennessee</option>
                                  <option>Texas</option>
                                  <option>Washington</option>
                                  -->
                               <!-- </select>-->
              
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Program Objectives</label>
                                
                                <p class="help-block">
                                
                                    What do you hope to achieve with this program
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <?php
							   
/*								  $data = array(
										'name'        => 'vc_desc',
										'id'          => 'vc_desc',
										'value'       => set_value('vc_desc'),
										'rows'        => '50',
										'cols'        => '10',
										'style'       => 'width:50%',
										'class'       => 'form-control'
									);*/
									
									$data 				= 	array(
										'name'        	=> 'objectives',
										'id'          	=> 'objectives',
										'value'       	=> set_value('objectives', $objectives),
										'rows'        	=> '5',
										'cols'        	=> '10',
										'style'       	=> 'width:100%',
										'placeholder'	=>	'Type here',
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
                    
                                <label>Success measure</label>
                                
                                <p class="help-block">
                                
                                    How would you measure the success of this program
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <?php
									
									$data 				= 	array(
										'name'        	=> 'success_measure',
										'id'          	=> 'success_measure',
										'value'       	=> set_value('success_measure', $success_measure),
										'rows'        	=> '5',
										'cols'        	=> '10',
										'style'       	=> 'width:100%',
										'placeholder'	=>	'Type here',
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
                    
                                <label>Program duration</label>
                                
                                <p class="help-block">
                                
                                    How long would you like this program to run for
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-6 col-md-6 no-pad-left">

                                	<input id="start_top"  value="<?php echo set_value('start_date',$start_date); ?>" class="form-control datepicker" name="start_date"  type="text" placeholder="Start Date" autocomplete="off" />
                                
                                </div>
                            	
                                <div class="col-xs-6 col-md-6 no-pad-right">
                                	
                                      <input id="end_top" value="<?php echo set_value('end_date', $end_date); ?>" class="form-control datepicker" name="end_date"  type="text"  placeholder="End Date" autocomplete="off" />
                                
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Program Activation</label>
                                
                                <p class="help-block">
                                
                                    Do you want to activate this Program now
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                 <?php
				
									$statusoptions 		= 	array(
									
										'0'		=> 	'No',
										
										'1'		=> 	'Yes'
									
									);
													
									echo form_dropdown('program_status', $statusoptions, set_value('program_status',$program_status), 'class="form-control"');
								
								?>

                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <?php
					
					if(!empty($program_launched))
					{
						
						
					}else{
						
					?>
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Program Launch</label>
                                
                                <p class="help-block">
                                
                                    Do you want to launch this program now
                                    
                                </p>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                 <?php
				
									$options 		= 	array(
									
										'0'		=> 	'No',
										
										'1'		=> 	'Yes'
									
									);
													
									echo form_dropdown('program_launched', $options, set_value('program_launched',$program_launched), 'class="form-control"');
								
								?>

                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <?php
					
					}
					
					?>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">

                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-5 no-pad-left">
                        	
                            <div class="form-group admin-form-setup" style="border-bottom:none;">
                                 
                                <button type="submit" class="btn btn-primary">Continue</button>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </form>
            
            </div>
        
        </div>
    
    </section>
    
  </div>