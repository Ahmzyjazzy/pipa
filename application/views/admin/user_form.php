  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
        User
        <small>Control panel</small>
      
      </h1>
     
      <ol class="breadcrumb">
        
        <li>
        	
            <a class="btn btn-info" href="<?php echo base_url(); ?>admin/user/" style="color:#fff;" title="Back">
            
                <i class="fa fa-arrow-circle-left "></i>
                
                Back
                
            </a>
            
        </li>
        
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">
     
      <?php
                    
            $pageAdd					=	'2';
			
			$pageEdit					=	'3';
			
			$pageAddDisplay				=	'';
			
			$pageEditDisplay			=	'';
			
            
			//check if this user has a right to add
            if(in_array($pageAdd, $userPageActions))
            {
        		//check if this person is trying to edit
				if(!empty($admin_id))
				{
					//yes its an edit 
					
					//now also check if the current user has a right to edit
					if(in_array($pageEdit, $userPageActions))
					{
				
						$pageAddDisplay		=	'';
					
					}else{
						
						$pageAddDisplay		=	'style="display:none;"';
												
					}
					
				}else{
				
					//No its not an edit
					$pageAddDisplay			=	'';
				
				}
				
            
            }else{
				
				//first check if this is an edit
				
				if(!empty($admin_id))
				{
					//now also check if the current user has a right to edit
					if(in_array($pageEdit, $userPageActions))
					{
				
						$pageAddDisplay		=	'';
					
					}else{
						
						$pageAddDisplay		=	'style="display:none;"';
												
					}
					
				}else{
				
					$pageAddDisplay			=	'style="display:none;"';
				
				}
				
			}
            
        
        ?>
        
      <div class="row">
       
        <div class="col-lg-7 col-xs-12">
         
          <div class="box box-primary">
            
            <div class="box-header with-border">
            
              <h3 class="box-title">Add User</h3>
           
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
                
            <?php endif;?>
                        
            <?php 
				
				$attr 	= array('role'=> 'form');
				
				echo form_open(base_url().'admin/user/add/'.$admin_id, $attr); 
			
			?>
             
              <div class="box-body">
            
                <div class="form-group">
                  	
                    <label>UserName</label>
						
					<?php
                        
                        $data	= array('placeholder'=>'User Name', 'name'=>'username', 'value'=>set_value('username', $username), 'class'=>'form-control');
                        
                        echo form_input($data);
                        
                    ?>
                    
                </div>
                
                <div class="form-group">

                    <label>First Name</label>
					
					<?php
                    
						$data	= array('placeholder'=>'First Name', 'name'=>'firstname', 'value'=>set_value('firstname', $firstname), 'class'=>'form-control');
                    
						echo form_input($data);
					
                    ?>
                
                </div>
              
                <div class="form-group">
                    
					<label>Last Name</label>
					
					<?php
                    	
						$data	= array('placeholder'=>'Last Name', 'name'=>'lastname', 'value'=>set_value('lastname', $lastname), 'class'=>'form-control');
                    	
						echo form_input($data);
						
                    ?>
                                                           
                </div>
                
                <div class="form-group">
                    
					<label>Email</label>
					
					<?php
                   
						$data	= array('placeholder'=>'Email', 'name'=>'email', 'value'=>set_value('email', $admin_email), 'class'=>'form-control');
						
						echo form_input($data);
					
                    ?>
                                                           
                </div>
                
                <div class="form-group">
                    
					<label>Mobile Number</label>
					
					<?php
                   
						$data	= array('placeholder'=>'Phone Number', 'name'=>'mobile', 'value'=>set_value('mobile', $mobile), 'class'=>'form-control phone_n_');
						
						echo form_input($data);
					
                    ?>
                                                           
                </div>
                                
                <div class="form-group">
                    
					<?php 
					 
					if(!empty($admin_id))
					{ 
									 
						echo '<p class="help-block">If you do not wish to change password, leave both fields blank</p>';
					
					}
						
					?>
					
					<label>Password </label>
						
					<?php
						
						$data	= array('placeholder'=>'Password', 'name'=>'password', 'type'=>'password', 'class'=>'form-control');
						
						echo form_input($data);
					
					?>
                                                           
                </div>
                
                <div class="form-group">
                    
					<label>Confirm Password</label>
						
					<?php
                    	
						$data	= array('placeholder'=>'Confirm Password', 'name'=>'confirm_password', 'type'=>'password', 'class'=>'form-control');
                    	
						echo form_input($data);
                    ?>
                                                           
                </div>
                
                <div class="form-group">
                    
					<label>User Role</label>
					
					<?php
                    	
						$roleOptions['0']		=	'Select Role';
							
						if(!empty($roles))
						{
							
							foreach($roles as $role)
							{
								
								$roleOptions[$role['roleID']]		=	$role['role'];
								
							}
								
						}
										
                    	echo form_dropdown('roleID', $roleOptions, set_value('roleID',$roleID), 'class="form-control"');
                    
					?>
                                               
                </div>
                
                <div class="form-group">
                    
					<label>Status</label>
					
					<?php
                    	
						$options 		= 	array(
						
								'0'		=> 	'Disabled',
								'1'		=> 	'Enabled'
                        );
										
                    	echo form_dropdown('status', $options, set_value('status',$admin_status), 'class="form-control"');
                    
					?>
                                               
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
               
                <button type="submit" class="btn btn-primary" <?php echo $pageAddDisplay; ?>>Submit</button>
          
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
