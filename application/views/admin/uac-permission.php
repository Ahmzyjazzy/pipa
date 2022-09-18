 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <ol class="breadcrumb">
        
        <li><a href="<?php echo base_url(); ?>admin/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">UAC</li>
        
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">
    
      <div class="row">
       
        <div class="col-md-9 col-xs-12">
         
          <div class="box box-primary">
            
            <div class="box-header with-border">
            
              <h3 class="box-title">USER ACCESS CONTROL</h3>
           
            </div>
            <!-- /.box-header -->
            
             
              <div class="box-body">

                	<div class="table-responsive mailbox-messages">
	
                        <div class="alert alert-error">
                           
                            <a class="close" data-dismiss="alert">×</a>
                            
                           <?php
						   
							   if ($this->session->flashdata('error'))
							   {
								   echo $this->session->flashdata('error');
								   
							   }else{
							   
							   		echo 'You do not have the right permission to view this Page.';
							   
							   }
                           
						   ?>
                            
                        </div>
                      
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
