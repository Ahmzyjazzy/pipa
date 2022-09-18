 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
        Loans
      
      </h1>
     
      <ol class="breadcrumb">
       
        <li>
            
            <?php
				
				if(!empty($userOpenLoan))
				{
					
					$existingLoan		=	'disabled';
					
				}else{
					
					$existingLoan		=	'';
				}
			?>
            <a class="btn btn-info <?php echo $existingLoan; ?>" href="<?php echo base_url(); ?>msme/apply-for-loan/" style="color:#fff;" title="Create Loan">
            
                <i class="fa fa-plus-circle "></i>
                
                Apply For Loan
                
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
            
              <h3 class="box-title">Loan Report</h3>
           
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
                        
                            <th>Loan ID</th>
                            
                            <th>Type of Loan</th>
                            
                            <th>Amount (&#x20A6;)</th>
                            
                            <th>Duration</th>
                            
                            <th>Date Created</th>
                            
                            <th>Loan Active</th>
                            
                            <th>Status</th>
                            
                            <th>View</th>
                             
                        </tr>
                    
                    </thead>
                    
                    <tbody>
                    
                        <?php 
                           
                           if(!empty($loans))
                           {
                               
                                $datatable = 0;
                                                            
                                foreach($loans as $loan):
                                    
                                    if(!empty($loan['loanStatus'])){
                                    
                                        if($loan['loanStatus'] == "1")
                                        {
											
                                            $loanStatus 				= 	'<span title="Application Processing" class="btn btn-info ">Processing</span>';
                                           
                                        
                                        }elseif($loan['loanStatus'] == "2"){
                                            
                                            //$txnStatus 				= 	'<span title="Transaction Declined" class="btn btn-danger "><i class="fa fa-times"></i></span>';
                                             $loanStatus 				= 	'<span title="Loan Application Approved" class="btn bg-olive"> Approved </span>';
                                            
                                        }elseif($loan['loanStatus'] == "3"){
                                            
                                            //$txnStatus 				= 	'<span title="Transaction Declined" class="btn btn-danger "><i class="fa fa-times"></i></span>';
                                            
                                            $loanStatus 				= 	'<span title="Loan Application Declined" class="btn btn-danger ">Declined</span>';
												
                                        }
                                        
                                    }else{
                                        
                                        $loanStatus 					= 	'<span title="Pending Approval" class="btn btn-warning ">Pending Review</span>';
                                        
                                    }
									
									
									if(!empty($loan['loanClosed'])){
                                    
                                        $loanClosed 					= 	'<span title="Loan Closed" class="btn bg-olive"> Closed </span>';
                                        
                                    }else{
                                        
                                        $loanClosed 					= 	'<span title="Loan Open" class="btn btn-warning ">Open</span>';
                                        
                                    }
                                    
                                    echo '
                                    <tr>
                                        
                                        <td class="center">'.$loan['loanID'].'</td>
                                        <td class="center">'.$loan['loanType']['loanType'].'</td>
                                        <td class="center">'.number_format($loan['loanAmount'], 2).'</td>
										<td class="center">'.$loan['loanTenure'].' Months</td>
										<td class="center" title="">'.date('M d,Y h:i A', strtotime($loan['dateCreated'])).'</td>                                        
                                        <td class="center">'.$loanClosed.'</td>
                                        <td class="center">'.$loanStatus.'</td>
										<td class="center">
												
											<a class="btn btn-info" href="'.base_url().'msme/view-loan-application/'.$loan['loanID'].'/" title="View Application">
											
												<i class="fa fa-eye"></i>
												
											</a>
										
										</td>
                                        
                                    </tr>';
                                    
                                    $datatable++;
                                
                                endforeach;
                                
                           }
                           else
                           {
                               echo '<tr>
                               
                                <td colspan="8">
                                    
                                    No data available in table
                                    
                                </td>
                                
                               </tr>';
                           }
                        ?>
                            
                    </tbody>
                    
                    <tfoot>
                    
                        <tr>
                        
                            <th>Loan ID</th>
                            
                            <th>Type of Loan</th>
                            
                            <th>Amount (&#x20A6;)</th>
                            
                            <th>Duration</th>
                            
                            <th>Date Created</th>
                            
                            <th>Loan Active</th>
                            
                            <th>Status</th>
                            
                            <th>View</th>
                            
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
