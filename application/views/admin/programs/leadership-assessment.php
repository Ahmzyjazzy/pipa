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
                    
                    //echo form_open_multipart(base_url().'admin/leadership-assessment/'.$program_id, $attr); 
                
                ?>
                
                    <div class="col-xs-12 col-md-12">
                        
                        <div class="setup-form-header-cont">
                            
                            <div class="setup-form-header-arrow-bck">
                            
                                <a href="<?php echo base_url(); ?>admin/program-survey/<?php echo $program_id; ?>/" class="text-blue fixed-backnav">
                                                               
                                    <i class="fa fa-arrow-left"></i>
                                
                                </a>
                            
                            </div> 
                        
                            <div class="setup-form-header">
                                
                              360 Leadership Assessment
                                
                            </div>
                            
                            <div class="setup-form-header-sub-text">
                                
                                Please select from the choices below and click continue
                                
                            </div>
                        
                        </div>
                    
                    </div>
                    

                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Assessment Questions </label>
                                                    
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <div class="col-xs-6 col-md-6 no-pad-left">

                                        	<div class="dashb-trans-btn dashb-trans-btn-colored">
                                                
                                                <a href="<?php echo base_url(); ?>admin/survey-competency-questions/<?php echo $program_id; ?>/" style="width:100%;">
                                                   
                                                    View/Approve Questions
                                                    
                                                </a>
                                                
                                            </div>
                                                
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-6 no-pad-right">
                                            
                                             <div class="dashb-trans-btn">
                                                
                                                <a href="<?php echo base_url(); ?>admin/custom-survey-competency-questions/<?php echo $program_id; ?>/" style="width:100%;">
                                                   
                                                    <i class="fa fa-plus"></i> Add your Questions
                                                    
                                                </a>
                                                
                                            </div>
                                        
                                        </div>
                                        
                                    </div>
                                    
                                </div>

                            </div>
                            
                        </div>
                        
                    </div>
					
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Participants </label>
                        
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <div class="col-xs-6 col-md-6 no-pad-left">

                                        	<div class="dashb-trans-btn dashb-trans-btn-colored">
                                                
                                                <a href="<?php echo base_url(); ?>download/participant-template/" style="width:100%;">
                                                   
                                                    Download CSV Template
                                                    
                                                </a>
                                                
                                            </div>
                                                
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-6 no-pad-right">
                                            
                                             <!--<div class="dashb-trans-btn">
                                                
                                                <a href="#" style="width:100%; padding-left:30%; padding-right:30%;">
                                                   
                                                    <i class="fa fa-cloud-upload"></i> Upload CSV
                                                    
                                                </a>
                                                
                                            </div>-->

                                            <?php
												
												$attrs 	= array('role'=> 'form', 'class'=> 'upload-participant');
												
												echo form_open_multipart(base_url().'admin/upload-participant/'.$program_id, $attrs); 
											
											?>
                                            
                                                <div class="upload-btn-wrapper">
                                                
                                                  <div class="uploadbtn"><i class="fa fa-cloud-upload"></i> Upload CSV</div>
                                                  
                                                  <input type="file" name="participants" />
                                                  
                                                </div>
                                                
                                                <div class="loading-cnt" style="text-align:center; display:none;">
                                                
                                                	<img id="loader" src="<?php echo base_url() ?>asset/images/loadingx.gif" style="height: 30px;"> 
                                            		
                                                    Please wait
                                                    
                                                </div>
                                                
                                                <input type="submit" class="btnUpload" style=" display:none;" value="Upload">
                                                
                                                <div class="" id="response">
                                         
                                        		</div>
                                         
                                            </form>
                                             
                                        </div>
                                        
                                    </div>
                                    
                                </div>

                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <?php
					
					echo form_open_multipart(base_url().'admin/leadership-assessment/'.$program_id, $attr); 
					
					?>
                                        
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Survey Name </label>
                                
                                 <p class="help-block">
                                
                                    What would you like to call your project
                                    
                                </p>
                                                  
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup" style="padding-right:10px;">
                                 
                                <fieldset>
                                    
                                    <legend>Survey Name</legend>
                                
                                     <?php
										
										$data	= array('placeholder'=>'Survey Name', 'name'=>'survey', 'value'=>set_value('survey', $survey), 'class'=>'form-control form-no-style', 'autocomplete'=>'off');
										
										echo form_input($data);

									 ?>
                                    
                                </fieldset>
                                                                                                      
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Survey Dates</label>

                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <div class="col-xs-6 col-md-6 no-pad-left ">

                                        	<div class="col-xs-12 col-md-4 no-pad-left">
                                            	
                                                <div class="setup-surv-date-text">
                                                	
                                                    Launch Date
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-8 no-pad-left no-pad-right no-pad-right-mob">
                                            
                                            	<div class="">
                                                
                                                	<input id="start_top"  value="<?php if(!empty($start_date)){ echo $start_date; } ?>" class="form-control datepicker" name="start_date"  type="text" placeholder="Start Date" autocomplete="off" />
                                                    
                                                </div>
                                                
                                            	<?php
												
													$data	= array('placeholder'=>'participant', 'name'=>'participant', 'value'=>set_value('participant', $participant), 'class'=>'form-control form-no-style participant-hldr', 'autocomplete'=>'off', 'style'=>'display:none');
											
													echo form_input($data);
											
												?>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-6">

                                        	<div class="col-xs-12 col-md-4 no-pad-left no-pad-right-mob">
                                            	
                                                <div class="setup-surv-date-text">
                                                	
                                                    Close Date
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-8 no-pad-left no-pad-right no-pad-right-mob">
                                            
                                            	<div class="">
                                                
                                                	<input id="end_top" value="<?php if(!empty($end_date)){ echo $end_date; } ?>" class="form-control datepicker" name="end_date"  type="text"  placeholder="End Date" autocomplete="off" />
                                                    
                                                </div>
                                                
                                            
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
								
                                <!--<div class="col-xs-12 col-md-12 no-pad-left no-pad-right" style="margin-top:15px;">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <div class="col-xs-6 col-md-6 no-pad-left ">

                                        	<div class="col-xs-12 col-md-4 no-pad-left">
                                            	
                                                <div class="setup-surv-date-text">
                                                	
                                                    Lauch Date
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-8 no-pad-left no-pad-right no-pad-right-mob">
                                            
                                            	<div class="">
                                                
                                                	<input id="start_top"  value="" class="form-control datepicker" name="start_date"  type="text" placeholder="Start Date" autocomplete="off" />
                                                    
                                                </div>
                                                
                                            
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="col-xs-6 col-md-6">

                                        	<div class="col-xs-12 col-md-4 no-pad-left no-pad-right-mob">
                                            	
                                                <div class="setup-surv-date-text">
                                                	
                                                    Close Date
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-8 no-pad-left no-pad-right no-pad-right-mob">
                                            
                                            	<div class="">
                                                
                                                	<input id="end_top" value="" class="form-control datepicker" name="end_date"  type="text"  placeholder="End Date" autocomplete="off" />
                                                    
                                                </div>
                                                
                                            
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>-->
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Communications </label>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 survey-setup-email-format-container no-pad-left">
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    	
                                        <div class="survey-setup-email-format-hdr">
                                        	
                                            Welcome Email
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right welcomeEmail-actual" style="display:none;">
                                    	
                                        <textarea name="welcomeEmail" id="welcomeEmail" class="form-control welcomeEmail"><?php echo $welcomeEmail['content']; ?></textarea>
                                    	
                                        <script>
                        
											$(document).ready(function(e) {
												
												tinymce.init({ 
												
													selector:'#welcomeEmail',
												
													height: 200,
													
													relative_urls: false,
													remove_script_host: false,
												
													/*toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent emoticons',
													
													plugins : 'advlist autolink link image lists charmap print preview emoticons'*/
													
													plugins: [
													  'advlist autolink link responsivefilemanager image lists charmap print preview hr anchor pagebreak spellchecker',
													  'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
													  'save table contextmenu directionality emoticons template paste textcolor'
													],
													
													toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager | link image | print preview media fullpage | forecolor backcolor emoticons',
													
													image_advtab: true,
					
												   /*external_filemanager_path: link + "tinymce/filemanager/",
												   filemanager_title: "Filemanager" ,
												   external_plugins: { "filemanager" : link + "tinymce/filemanager/plugin.min.js"}*/
												   
													external_filemanager_path: link + "tinymce/filemanager/",
													filemanager_title: "Media Gallery",
													external_plugins: {"filemanager": link + "tinymce/filemanager/plugin.min.js"}
												   
												   //relative_urls : false,
												  // remove_script_host : false
												   /*convert_urls : true*/
												   /*document_base_url: 'http://www.example.com/path1/'*/
												
												 });
											
											});
										
										</script>
                        
                                    </div>
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right welcomeEmail-actual-viewhldr">
                                    	
                                        <div class="survey-setup-email-format-content">
                                        	
                                            <?php echo $welcomeEmail['content']; ?>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                        
                                        <div class="form-group" style="overflow:auto;">
                                             
                                            <div class="col-xs-6 col-md-6 no-pad-left">
    
                                                <div class="dashb-trans-btn editmail welcomeEmail-editbtn" lang="welcomeEmail">
                                                    
                                                    <!--<a href="#" style="width:100%; padding-left:30%; padding-right:30%;">
                                                       
                                                       Edit Email
                                                        
                                                    </a>-->
                                                    <span style="width:100%;">
                                                       
                                                         Edit Email
                                                        
                                                    </span>
                                                    
                                                </div>
                                                
                                                <div class="dashb-trans-btn dashb-trans-btn-colored savemail welcomeEmail-savebtn" lang="welcomeEmail" style="display:none;">
                                                    
                                                    <span style="width:100%;">
                                                       
                                                        Save
                                                        
                                                    </span>
                                                    
                                                </div> 
                                                    
                                            </div>
                                            
                                            <div class="col-xs-6 col-md-6 no-pad-right">
                                                
                                                
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                  
                                </div>
								
                                <div class="col-xs-12 col-md-12 survey-setup-email-format-container no-pad-left">
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    	
                                        <div class="survey-setup-email-format-hdr">
                                        	
                                            Reminder Email
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right reminderEmail-actual" style="display:none;">
                                    	
                                        <textarea name="reminderEmail" id="reminderEmail" class="form-control reminderEmail"><?php echo $reminderEmail['content']; ?></textarea>
                                    	
                                        <script>
                        
											$(document).ready(function(e) {
												
												tinymce.init({ 
												
													selector:'#reminderEmail',
												
													height: 200,
													
													relative_urls: false,
													remove_script_host: false,
												
													/*toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent emoticons',
													
													plugins : 'advlist autolink link image lists charmap print preview emoticons'*/
													
													plugins: [
													  'advlist autolink link responsivefilemanager image lists charmap print preview hr anchor pagebreak spellchecker',
													  'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
													  'save table contextmenu directionality emoticons template paste textcolor'
													],
													
													toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager | link image | print preview media fullpage | forecolor backcolor emoticons',
													
													image_advtab: true,
					
												   /*external_filemanager_path: link + "tinymce/filemanager/",
												   filemanager_title: "Filemanager" ,
												   external_plugins: { "filemanager" : link + "tinymce/filemanager/plugin.min.js"}*/
												   
													external_filemanager_path: link + "tinymce/filemanager/",
													filemanager_title: "Media Gallery",
													external_plugins: {"filemanager": link + "tinymce/filemanager/plugin.min.js"}
												   
												   //relative_urls : false,
												  // remove_script_host : false
												   /*convert_urls : true*/
												   /*document_base_url: 'http://www.example.com/path1/'*/
												
												 });
											
											});
										
										</script>
                        
                                    </div>
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right reminderEmail-actual-viewhldr">
                                    	
                                        <div class="survey-setup-email-format-content">
                                        	
                                            <?php echo $reminderEmail['content']; ?>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                        
                                        <div class="form-group" style="overflow:auto;">
                                             
                                            <div class="col-xs-6 col-md-6 no-pad-left">
    
                                               <div class="dashb-trans-btn editmail reminderEmail-editbtn" lang="reminderEmail">

                                                    <span style="width:100%;">
                                                       
                                                         Edit Email
                                                        
                                                    </span>
                                                    
                                                </div>
                                                
                                                <div class="dashb-trans-btn dashb-trans-btn-colored savemail reminderEmail-savebtn" lang="reminderEmail" style="display:none;">
                                                    
                                                    <span style="width:100%;">
                                                       
                                                        Save
                                                        
                                                    </span>
                                                    
                                                </div> 
                                                    
                                            </div>
                                            
                                            <div class="col-xs-6 col-md-6 no-pad-right">
 
                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                  
                                </div>
                                
                                <div class="col-xs-12 col-md-12 survey-setup-email-format-container no-pad-left">
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    	
                                        <div class="survey-setup-email-format-hdr">
                                        	
                                            Thank you Email
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right thankYouEmail-actual" style="display:none;">
                                    	
                                        <textarea name="thankYouEmail" id="thankYouEmail" class="form-control thankYouEmail"><?php echo $thankYouEmail['content']; ?></textarea>
                                    	
                                        <script>
                        
											$(document).ready(function(e) {
												
												tinymce.init({ 
												
													selector:'#thankYouEmail',
												
													height: 200,
													
													relative_urls: false,
													remove_script_host: false,
												
													/*toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent emoticons',
													
													plugins : 'advlist autolink link image lists charmap print preview emoticons'*/
													
													plugins: [
													  'advlist autolink link responsivefilemanager image lists charmap print preview hr anchor pagebreak spellchecker',
													  'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
													  'save table contextmenu directionality emoticons template paste textcolor'
													],
													
													toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager | link image | print preview media fullpage | forecolor backcolor emoticons',
													
													image_advtab: true,
					
												   /*external_filemanager_path: link + "tinymce/filemanager/",
												   filemanager_title: "Filemanager" ,
												   external_plugins: { "filemanager" : link + "tinymce/filemanager/plugin.min.js"}*/
												   
													external_filemanager_path: link + "tinymce/filemanager/",
													filemanager_title: "Media Gallery",
													external_plugins: {"filemanager": link + "tinymce/filemanager/plugin.min.js"}
												   
												   //relative_urls : false,
												  // remove_script_host : false
												   /*convert_urls : true*/
												   /*document_base_url: 'http://www.example.com/path1/'*/
												
												 });
											
											});
										
										</script>
                        
                                    </div>
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right thankYouEmail-actual-viewhldr">
                                    	
                                        <div class="survey-setup-email-format-content">
                                        	
                                            <?php echo $thankYouEmail['content']; ?>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                        
                                        <div class="form-group" style="overflow:auto;">
                                             
                                            <div class="col-xs-6 col-md-6 no-pad-left">
    
                                              <div class="dashb-trans-btn editmail thankYouEmail-editbtn" lang="thankYouEmail">
  
                                                    <span style="width:100%;">
                                                       
                                                         Edit Email
                                                        
                                                    </span>
                                                    
                                                </div>
                                                
                                                <div class="dashb-trans-btn dashb-trans-btn-colored savemail thankYouEmail-savebtn" lang="thankYouEmail" style="display:none;">
                                                    
                                                    <span style="width:100%;">
                                                       
                                                        Save
                                                        
                                                    </span>
                                                    
                                                </div> 
                                                    
                                            </div>
                                            
                                            <div class="col-xs-6 col-md-6 no-pad-right">

                                                
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                  
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
					
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Reminder Dates</label>
                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                         
                                        <div class="col-xs-6 col-md-6 no-pad-left ">

                                        	<div class="col-xs-12 col-md-6 no-pad-left">
                                            	
                                                <div class="setup-surv-date-text">
                                                	
                                                    Send Reminder
                                                    
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-6 no-pad-left no-pad-right no-pad-right-mob">
                                            
                                            	<div class="">
                                                
                                                	<?php
                    	
														$options 		= 	array(
														
															'Weekly'		=> 	'Weekly',
															'Monthly'		=> 	'Monthly'
														);
																		
														echo form_dropdown('frequency', $options, set_value('frequency',$frequency), 'class="form-control"');
													
													?>
                                                    
                                                </div>
                                                
                                            
                                            </div>
                                            
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
                                 
                                <button type="submit" class="btn btn-primary">Continue</button>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </form>
            
            </div>
        
        </div>
    
    </section>
    
  </div>
  
  <script>
                                    
	$(document).ready(function(e) {
	 
	 	$('input[type=file]').on('change', function(){
			
			$('.btnUpload').click();
			
		});
		
		$('.upload-participant').ajaxForm({
		
			beforeSend: function() {
				
				$(".loading-cnt").show();
				
				$('#response').html('');
				
				$('.upload-btn-wrapper').hide();
			
			},
			complete: function(xhr) {
								
				var obj 		= JSON.parse(xhr.responseText); 
																
				if(obj.status  == 'Success')
				{/**/
			
					$(".loading-cnt").hide();
					
					$('.upload-btn-wrapper').show();
					
					$('.participant-hldr').val(obj.ref);
					
					$('.upload-participant').resetForm();
					
					$('#response').html(' <div class="alert alert-info"><a class="close" data-dismiss="alert">×</a>'+obj.data+'</div>');
					
				}else{
					
					$(".loading-cnt").hide();
					
					$('.upload-btn-wrapper').show();
				
					$('.upload-participant').resetForm();
					
					$('#response').html('<div class="alert alert-error">'+obj.status+': '+obj.data+'</div>');
					
				}
						
			}
		
		}); 
	
	});
	</script>
  
 <script src="<?php echo base_url(); ?>asset/admin_asset/js/jquery.form.js"></script>