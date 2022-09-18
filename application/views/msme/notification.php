 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
        Notifications
      
      </h1>
     
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>user/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Notifications</li>
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">
    
      <div class="row">
       
        <div class="col-md-9 col-xs-12">
         
          <div class="box box-primary">
            
            <div class="box-header with-border">
            
              <h3 class="box-title">NOTIFICATIONS</h3>
           
            </div>
            <!-- /.box-header -->
            
             
              <div class="box-body">

                	<div class="table-responsive mailbox-messages">
                     
                        <table class="table table-hover table-striped">
                          
                          <tbody>
                          	
                            <?php
							
							if(!empty($notifications))
							{
								
								foreach($notifications as $notification)
								{
									
								  echo '<tr>
																
									<td class="mailbox-name">
									
										<a href="'.$notification['link'].'">'.$notification['notification'].'</a>
									
									</td>
																	
									<td class="mailbox-date">'.time_ago_in_php($notification['dateCreated']).'</td>
									
								  </tr>';
							  
								}
							  
							}else{
								
								echo '<tr>
									
									<td colspan="2" style="text-align:center;">
										No new Notification
									</td>
									
								</tr>';
							}
							
							?>
                          
                          </tbody>
                          
                        </table>
                        <!-- /.table -->
                      
                      </div>
                 
              </div>
              
              <!-- /.box-body -->

              <div class="box-footer" style="text-align:right;">

              </div>
                    
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
