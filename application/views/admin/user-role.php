  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
        User Role
        <small>Control panel</small>
      
      </h1>
     
      <ol class="breadcrumb">
        
          <?php
                    
            $pageAdd					=	'2';
			
			$pageEdit					=	'3';
			
			$pageDelete					=	'4';
			
			
			$pageAddDisplay				=	'';
			
			$pageEditDisplay			=	'';
			
			$pageDeleteDisplay			=	'';
            
			//check if this user has a right to add
            if(in_array($pageAdd, $userPageActions))
            {
        		$pageAddDisplay		=	'';
				
            }else{
				
				$pageAddDisplay			=	'style="display:none;"';
				
			}
			
			//check if this user has a right to edit
            if(in_array($pageEdit, $userPageActions))
            {
        
                $pageEditDisplay			=	'';
            
            }else{
				
				$pageEditDisplay			=	'style="display:none;"';
				
			}
			
			//check if this user has a right to delete
            if(in_array($pageDelete, $userPageActions))
            {
        
                $pageDeleteDisplay			=	'';
            
            }else{
				
				$pageDeleteDisplay			=	'style="display:none;"';
				
			}
            
        
        ?>
        
        <li>
        	
            <a <?php echo $pageAddDisplay; ?> class="btn btn-info" href="<?php echo base_url(); ?>admin/user-role/add/" style="color:#fff;" title="Add New Role">
            
                <i class="fa fa-plus-circle "></i>
                
                Add Role
                
            </a>
            
        </li>
        
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">
     
      <div class="row">
       
        <div class="col-xs-12">
         
          <div class="box">
           
            <div class="box-header">
            
              <h3 class="box-title">User Role</h3>
           
            </div>
           
            <?php if ($this->session->flashdata('message')):?>
                            
            <div class="alert alert-info">
               
                <a class="close" data-dismiss="alert">×</a>
               
                <?php echo $this->session->flashdata('message');?>
            
            </div>
                            
            <?php endif;?>
            
            <!-- /.box-header -->
            <div class="box-body">
             
              <table id="example1" class="table table-bordered table-striped">
                
                <thead>
                
                    <tr>
                        
                        <th>Ref</th>
                        <th>Role</th>
                        <th>No Users</th>
                        <th>Date Created</th>  
                        <th>Status</th>
                        <th>Actions</th>
                        
                    </tr>
                
                </thead>
                
                <tbody>
                
                    <?php 
					   
					   if(!empty($get_user_roles))
					   {
						   
							$datatable 		= 0;
							
							$adminID		=	$this->session->userdata('admin_id');
							
							$showSuper		=	'style="display:none;"';
							
							foreach($get_user_roles as $role):
								
								/*if($role['admin_id'] == 1)
								{
									if($adminID == 1)
									{
										$showSuper		=	'';
										
									}else{
										
										$showSuper		=	'style="display:none;"';
										
									}
									
								}else{
									
									$showSuper			=	'';
									
								}*/
														
								if($role['dateCreated'] == "0000-00-00 00:00:00"){
									
									$datecreated 		= 	"";
									
								}else{
									
									$datecreated 		= 	$role['dateCreated'];
								
								}
							
								if($role['status'] == "1"){
									
									$message 			= 	'<span class="label label-success">Active</span>';	
								
								}else{
									
									$message 			= 	'<span class="btn btn-danger">Disabled</span>';
								
								}
							
								echo '<tr>
									
									<td class="center">'.$role['roleID'].'</td>
									<td class="center">'.ucwords($role['role']).'</td>
									<td></td>
									<td class="center">'.date('M d, Y h:i A',strtotime($datecreated)).'</td>
									<td class="center">'.$message.'</td>
									<td class="center">
										
										<a '.$pageEditDisplay.' class="btn btn-info" title="Edit" href="'.base_url().'admin/user-role/add/'.$role['roleID'].'/">
											<i class="fa fa-edit"></i>   
										</a>
										
										<a '.$pageDeleteDisplay.' class="btn btn-danger del_userRole" title="Delete" rel="'.$role['roleID'].'" lang="'.$datatable.'">
											<i class="fa fa-trash"></i>
										</a>
										
									</td>
								</tr>';
							
								$datatable++;
							
							endforeach;

					   }
					   else
					   {
						   echo '<tr>
						   
						   	<td colspan="6">
								
								No data available in table
								
							</td>
							
						   </tr>';
					   }
					?>
                        
                </tbody>
                
                <tfoot>
                
                   	<tr>
                    
                        <th>Ref</th>
                        <th>Role</th>
                        <th>No Users</th>
                        <th>Date Created</th>  
                        <th>Status</th>
                        <th>Actions</th>
                        
                    </tr>
                    
                </tfoot>
                
              </table>
              

            </div>
            <!-- /.box-body -->
            
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
