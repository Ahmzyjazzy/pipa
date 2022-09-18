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
                            
                
                    <div class="col-xs-12 col-md-12">
                        
                        <div class="setup-form-header-cont">
                            
                            <div class="setup-form-header-arrow-bck">
                            
                                <a href="<?php echo base_url(); ?>admin/program-survey/" class="text-blue fixed-backnav">
                                                               
                                    <i class="fa fa-arrow-left"></i>
                                
                                </a>
                            
                            </div> 
                        
                            <div class="setup-form-header">
                                
                              Upload Program Response
                                
                            </div>
                            
                            <div class="setup-form-header-sub-text">
                                
                                Please select from the choices below and click continue
                                
                            </div>
                        
                        </div>
                    
                    </div>

					
                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                <label>Program Response </label>
                        
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left">
                                    
                                    <div class="form-group" style="overflow:auto;">
     
                                        <div class="col-xs-6 col-md-6 no-pad-right">
                                            


                                            <?php
												
												$attrs 	= array('role'=> 'form', 'class'=> 'upload-program-response');
												
												echo form_open_multipart(base_url().'admin/upload-program-response/', $attrs); 
											
											?>
                                            
                                                <div class="upload-btn-wrapper">
                                                
                                                  <div class="uploadbtn"><i class="fa fa-cloud-upload"></i> Upload CSV</div>
                                                  
                                                  <input type="file" name="participants" />
                                                  
                                                </div>
                                                
                                                <div class="loading-cnt" style="text-align:center; display:none;">
                                                
                                                	<img id="loader" src="<?php echo base_url() ?>asset/images/loadingx.gif" style="height: 30px;"> 
                                            		
                                                    Please wait
                                                    
                                                </div>
                                                
                                                <input type="submit" class="btnUpload" style="display:none;" value="Upload">
                                                
                                                <div class="" id="response">
                                         
                                        		</div>
                                         
                                            </form>
                                             
                                        </div>
                                        
                                    </div>
                                    
                                </div>

                            </div>
                            
                        </div>
                        
                    </div>
            
            </div>
        
        </div>
    
    </section>
    
  </div>
  
  <script>
                                    
	$(document).ready(function(e) {
	 
	 	$('input[type=file]').on('change', function(){
			
			$('.btnUpload').click();
			
		});
		
		$('.upload-program-response').ajaxForm({
		
			beforeSend: function() {
				
				$(".loading-cnt").show();
				
				$('#response').html('');
				
				$('.upload-btn-wrapper').hide();
			
			},
			complete: function(xhr) {
								
				var obj 		= JSON.parse(xhr.responseText); 
																
				if(obj.status  == 'Success')
				{
			
					$(".loading-cnt").hide();
					
					$('.upload-btn-wrapper').show();
										
					$('.upload-program-response').resetForm();
					
					$('#response').html(' <div class="alert alert-info"><a class="close" data-dismiss="alert">×</a>'+obj.data+'</div>');
					
				}else{
					
					$(".loading-cnt").hide();
					
					$('.upload-btn-wrapper').show();
				
					$('.upload-program-response').resetForm();
					
					$('#response').html('<div class="alert alert-error">'+obj.status+': '+obj.data+'</div>');
					
				}
						
			}
		
		}); 
	
	});
	</script>
  
 <script src="<?php echo base_url(); ?>asset/admin_asset/js/jquery.form.js"></script>