  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
        User
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
        	
            <a <?php echo $pageAddDisplay; ?> class="btn btn-info" href="<?php echo base_url(); ?>admin/user/add/" style="color:#fff;" title="Create User">
            
                <i class="fa fa-plus-circle "></i>
                
                Add User
                
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
            
              <h3 class="box-title">Users</h3>
           
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
                    	
                        <th>ID</th>
                        <th>Staff Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Online Status</th>
                        <th>Date Created</th>  
                        <th>Status</th>
                        <th>Actions</th>
                        
                    </tr>
                
                </thead>
                
                <tbody>
                
                    <?php 
					   
					   if(!empty($get_user))
					   {
						   
							$datatable = 0;
							
							$adminID	=	$this->session->userdata('admin_id');
							
							$showSuper	=	'style="display:none;"';
							
							foreach($get_user as $user):
								
								if($user['admin_id'] == 1)
								{
									if($adminID == 1)
									{
										$showSuper	=	'';
										
									}else{
										
										$showSuper	=	'style="display:none;"';
										
									}
									
								}else{
									
									$showSuper	=	'';
									
								}
														
								if($user['date_created'] == "0000-00-00 00:00:00"){
									
									$datecreated = "";
									
								}else{
									
									$datecreated = $user['date_created'];
								
								}
							
								if($user['admin_status'] == "1"){
									
									$message = '<span class="label label-success">Active</span>';	
								
								}else{
									
									$message = '<span class="label label-important">Disabled</span>';
								
								}
							
								echo '<tr '.$showSuper.'>
									<td class="center">'.$user['admin_id'].'</td>
									<td class="center">'.ucwords($user['firstname']." ".$user['lastname']).'</td>
									<td>'.$user['username'].'</td>
									<td>'.$user['admin_email'].'</td>
									<td>'.$user['role'].'</td>
									<td class="onlineStat-'.$user['admin_id'].'"></td>
									<td class="center">'.date('M d, Y h:i A',strtotime($datecreated)).'</td>
									<td class="center">'.$message.'</td>
									<td class="center">
										
										<a '.$pageEditDisplay.' class="btn btn-info" title="Edit" href="'.base_url().'admin/user/add/'.$user['admin_id'].'/">
											<i class="fa fa-edit"></i>   
										</a>
										
										<a '.$pageDeleteDisplay.' class="btn btn-danger del_user" title="Delete" rel="'.$user['admin_id'].'" lang="'.$datatable.'">
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
						   
						   	<td colspan="9">
								
								No data available in table
								
							</td>
							
						   </tr>';
					   }
					?>
                        
                </tbody>
                
                <tfoot>
                
                   	<tr>
                        
                        <th>ID</th>
                        <th>Staff Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Online Status</th>
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
