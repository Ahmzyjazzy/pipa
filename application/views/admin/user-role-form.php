  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
        User Role
        <small>Control panel</small>
      
      </h1>
     
      <ol class="breadcrumb">
         
         <li>
        	
            <a class="btn btn-info" href="<?php echo base_url(); ?>admin/user-role/" style="color:#fff;" title="Back">
            
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
				if(!empty($roleID))
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
				
				if(!empty($roleID))
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
       
        <div class="col-lg-8 col-xs-12">
         
          <div class="box box-primary">
            
            <div class="box-header with-border">
            
              <h3 class="box-title">Add Role</h3>
           
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
				
				echo form_open(base_url().'admin/user-role/add/'.$roleID, $attr); 
			
			?>
             
              <div class="box-body">
            
                <div class="form-group">
                  	
                    <label>Role</label>
						
					<?php
                        
                        $data	= array('placeholder'=>'Role Name', 'name'=>'role', 'value'=>set_value('role', $role), 'class'=>'form-control');
                        
                        echo form_input($data);
                        
                    ?>
                    
                </div>                                
                
                <div class="form-group">
                    
					<label>Status</label>
					
					<?php
                    	
						$options 		= 	array(
							 	
								'0'		=> 	'Disabled',
                                '1'		=> 	'Enabled'
                        );
										
                    	echo form_dropdown('status', $options, set_value('status',$status), 'class="form-control"');
                    
					?>
                                               
                </div>
                
                <div class="form-group">
                	
                    <style>
						
						.box-body ul{
							padding-left:7px;
						}
						
						.box-body ul li{
							list-style:none;
							float:left;
							display:inline-block;
							width:50%;
						}
						
						.checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"], .radio input[type="radio"], .radio-inline input[type="radio"]
						{
							
							margin-left:0px;	
							
						}
						
					</style>
                    
					<?php
                    
                    if(!empty($adminPages))
                    {
                        
                        foreach($adminPages as $pageActions)
                        {
                            
                            echo '<div class="col-md-3">
                              
                              <div class="box box-warning">
                              
                                <div class="box-header with-border">
                              
                                  <h3 class="box-title">'.$pageActions['page'].'</h3>
                    
                                </div>
                              
                                <div class="box-body" style="min-height:180px;">';
                              	
							  	if(!empty($pageActions['actions']))
								{
									echo '<ul>';
									
									foreach($pageActions['actions'] as $actions)
									{
										
										$pgeActionHolder		=	'';
										
										if(!empty($rolePageActions))
										{
											
											foreach($rolePageActions as $rolePageAction)
											{
												
												if($rolePageAction['pageID'] == $pageActions['pageID'])
												{
												
													$pgeActionHolder	= 	$rolePageAction['pageActions'] ;
												
												}
												
											} 
																							
											$intr_skill_array			= 	explode(',', $pgeActionHolder);
											
										}
										
										echo '<li>
							
											<div class="checkbox checkbox-info checkbox-circle">
											
												<input class="role-select-action role-select-'.$pageActions['slug'].' intr-'.$actions['actionID'].'" lang="'.$pageActions['slug'].'" id="checkbox-action-'.$pageActions['slug'].'-'.$actions['actionID'].'" value="'.$actions['actionID'].'"  type="checkbox"'; if(!empty($intr_skill_array)){ if (in_array($actions['actionID'], $intr_skill_array)){ echo "checked"; }}	
											
												echo' lang="'.$actions['actionID'].'">
											
												<label for="checkbox-action-'.$pageActions['slug'].'-'.$actions['actionID'].'">'.$actions['action'].'</label>
											
											</div>
										 
										 <li>';
										
									}
									
									echo '</ul>';
									
								}
                              
                               echo '
							   
							   <input type="text" class="'.$pageActions['slug'].'" style="display:none;"  value="'.$pgeActionHolder.'" name="page['.$pageActions['pageID'].']"/>
							   
							   </div>
                              
                              </div>
                                                
                            </div>';
                        
                        }
                    
                    }
                    
                    ?>
                
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
          
          		<button type="submit" class="btn btn-primary" <?php echo $pageAddDisplay; ?> >Submit</button>
          
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
