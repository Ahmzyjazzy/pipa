 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
        Loan Applications
        <small>Control panel</small>
      
      </h1>
     
      <ol class="breadcrumb">
        
        <li>
        
            <a href="<?php echo base_url(); ?>admin/">
                
                <i class="fa fa-dashboard"></i> 
                
                Home
                
            </a>
        
        </li>
        
        <li class="active">
        
        	Loan Applications
        
        </li>
        
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">
          
      <div class="row">
       
        <div class="col-xs-12">
         
          <div class="box">
           
            <div class="box-header">
            
              <h3 class="box-title">Loan Applications</h3>
           
            </div>
           
                      
			<?php if ($this->session->flashdata('message')):?>
                            
            <div class="alert alert-info">
               
                <a class="close" data-dismiss="alert">×</a>
               
                <?php echo $this->session->flashdata('message');?>
            
            </div>
                            
            <?php endif;?>
            
            <!-- /.box-header -->
            <div class="box-body">
                
                <!--<div class="col-md-12 col-xs-12" style="padding-left:0px; margin-bottom:15px; padding-right:0px;">
                
					<?php 
                    
                        echo form_open('admin/transactions', 'class="form-horizontal"');
                    
                    ?>
                    
                        <fieldset>
                        
                        	<style>
							
								.fld-td{
									margin-top:10px;
									margin-bottom:10px;
									text-align:right;
								}
							
							</style>
                            
                           <div class="col-md-4 col-xs-12 fld-td">
                               
                               <input id="top" style="display:none;" class="form-control" type="text" name="term" placeholder="<?php echo "Search Term"; ?>" /> 
                            
                           </div>
                            
                           <div class="col-md-3 col-xs-6 fld-td">
                            
                                <input id="start_top"  value="" class="form-control datepicker" name="start_date"  type="text" placeholder="Start Date"/>
                                                        
                            </div>
                            
                           <div class="col-md-3 col-xs-6 fld-td">
                                    
                                <input id="end_top" value="" class="form-control datepicker" name="end_date"  type="text"  placeholder="End Date"/>
                                                            
                            </div>
                        
                            <div class="col-md-2 col-xs-6 fld-td" style="padding-right:50px;">
                            	
                                <button class="btn bg-olive" name="submit" value="export"><i class="fa fa-file-excel-o"></i>  <?php echo "Excel Export"; ?></button>
                            
                            </div> 
                           
                        </fieldset>
                    
                    </form>
                
                </div>-->
                
                <table id="example1" class="table table-bordered table-striped">
                
                    <thead>
                    
                        <tr>
                        
                            <th>Ref</th>
                                
                            <th>Customer</th>
                                                            
                            <th>Type of Loan</th>
                            
                            <th>Amount (&#x20A6;)</th>
                                                            
                            <th>Date Created</th>
                            
                            <th>Status</th>
                            
                            <th>Approval Status</th>
                            
                            <th>View</th>
                             
                        </tr>
                    
                    </thead>
                    
                    <tbody>
                        
                         <?php 
                           
                           if(!empty($userLoans))
                           {
                                //$CI =& get_instance();
                               
                                //$userDetails					=	$CI->in_multiarray($txn['userID'], $customers, 'userID');
                                
                                $datatable = 0;
                                                            
                                foreach($userLoans as $loan):
									
                                    if(!empty($loan['loanStatus'])){
                                    
                                        if($loan['loanStatus'] == "1")
                                        {
                                            $loanStatus 				= 	'<span title="Application Processing" class="btn btn-info ">Processing</span>';
                                           
										   	$riskanalysisBTN			=	'<a class="btn btn-info btnColor2" href="'.base_url().'admin/risk-analysis/'.$loan['loanID'].'/" title="Risk Analysis">
                                            
                                                <i class="fa fa-money"></i>
                                                
                                            </a>';
                                        
                                        }elseif($loan['loanStatus'] == "2"){
                                            
                                            //$txnStatus 				= 	'<span title="Transaction Declined" class="btn btn-danger "><i class="fa fa-times"></i></span>';
                                            
                                            $loanStatus 				= 	'<span title="Loan Application Approved" class="btn bg-olive"> Approved </span>';
											
											$riskanalysisBTN			=	'<a class="btn btn-info btnColor2" href="'.base_url().'admin/risk-analysis/'.$loan['loanID'].'/" title="Risk Analysis">
                                            
                                                <i class="fa fa-money"></i>
                                                
                                            </a>';
                                                
                                        }elseif($loan['loanStatus'] == "3"){
                                            
                                            //$txnStatus 				= 	'<span title="Transaction Declined" class="btn btn-danger "><i class="fa fa-times"></i></span>';
                                            
                                            $loanStatus 				= 	'<span title="Loan Application Declined" class="btn btn-danger ">Declined</span>';
                                             
											$riskanalysisBTN			=	'<a class="btn btn-info btnColor2" href="'.base_url().'admin/risk-analysis/'.$loan['loanID'].'/" title="Risk Analysis">
                                            
                                                <i class="fa fa-money"></i>
                                                
                                            </a>';    
                                        }
                                        
                                    }else{
                                        
                                        $loanStatus 					= 	'<span title="Pending Approval" class="btn btn-warning ">Pending Review</span>';
                                        
										$riskanalysisBTN				=	'';
                                    }
                                    
                                    
                                    if(!empty($loan['loanClosed'])){
                                    
                                        $loanClosed 					= 	'<span title="Loan Closed" class="btn bg-olive"> Closed </span>';
                                        
                                    }else{
                                        
                                        $loanClosed 					= 	'<span title="Loan Open" class="btn btn-warning ">Open</span>';
                                        
                                    }
                                    
                                    echo '
                                    <tr>
                                        
                                        <td class="center">'.$loan['loanID'].'</td>
										<td class="center">'.ucfirst($loan['userLoanProfile']['lastName']).' '.ucfirst($loan['userLoanProfile']['firstName']).'<br />
									
											<span style="font-weight:600;">('.$loan['userLoanBusiness']['businessName'].')</span>
											
										</td>
										<td class="center">'.$loan['loanType']['loanType'].' <br />
										
											<span style="font-weight:600;">('.$loan['loanTenure'].' Months)</span>
										
										</td>
										
										<td class="center">'.number_format($loan['loanAmount'], 2).'</td>
										<td class="center" title="">'.date('M d,Y h:i A', strtotime($loan['dateCreated'])).'</td>                                        
										<td class="center">'.$loanClosed.'</td>
										<td class="center">'.$loanStatus.'</td>

                                        <td class="center">
                                                
                                            <a class="btn btn-info" href="'.base_url().'admin/view-loan-application/'.$loan['loanID'].'/" title="View Application">
                                            
                                                <i class="fa fa-eye"></i>
                                                
                                            </a>
											
											<a class="btn btn-info btnColor1" href="'.base_url().'admin/loan-application/'.$loan['loanID'].'/" title="Process Application">
                                            
                                                <i class="fa fa-cog"></i>
                                                
                                            </a>
											
											'.$riskanalysisBTN.'
                                        
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
                        
                            <th>Ref</th>
                            
                            <th>Customer</th>
                                                            
                            <th>Type of Loan</th>
                            
                            <th>Amount (&#x20A6;)</th>
                                                            
                            <th>Date Created</th>
                            
                            <th>Status</th>
                            
                            <th>Approval Status</th>
                            
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
