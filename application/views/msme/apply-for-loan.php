  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
      <h1>
       
       	Apply for a Loan
      
      </h1>
     
      <ol class="breadcrumb">
        
        <li><a href="<?php echo base_url(); ?>msme/dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li><a href="<?php echo base_url().'msme/apply-for-loan/'; ?>"> Apply For Loan</a></li>
        
        <li class="active">Apply for a Loan</li>
        
      </ol>

    </section>

    <!-- Main content -->
    <section class="content">
     
      <div class="row">
       
        <div class="col-xs-12 col-md-11 col-lg-11 ">
         
          <div class="box box-primary">
            
            <div class="box-header with-border">
            
              <h3 class="box-title">Apply for a Loan</h3>
                        
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
                
            <?php 
			
				endif;
			
				if ($this->session->flashdata('success-message')):
			
			?>
               
               <div class="alert alert-info">
                    <a class="close" data-dismiss="alert">×
                    </a>
                    <?php echo $this->session->flashdata('success-message');?>
                </div>
                     
            <?php 
				
				endif; 
				
				$attr 	= array('role'=> 'form', 'onsubmit'=>'return checkBeforeSubmit()');
				
				echo form_open_multipart(base_url().'msme/kyc/', $attr); 
			?>
             
              <div class="box-body">
            				                	
                <div class="tab-pane fade active in">
                
                	<div class="col-md-12" style="padding-top:40px;">
                        
                        <div class="col-md-4 no-pad-right">
                            
                            <div class="applyfin-lst">
                                
                                <ul>
                                    
                                    <li class="applyfin-lst-hdr-first">
                                        
                                        <span>
                                            1
                                        </span>
                                        
                                        Loan Without A Sponsor 
                                    </li>
                                    
                                    <li>
                                        Collateral Free loans of upto US $10,000
                                    </li>
                                    
                                    <li>
                                        12% annual interest rate
            
                                    </li>
                                    
                                    <li>
                                        12  months Moratorium on Interest & Principal
                                    </li>
                                    
                                    <li>
                                    	
                                         <div class="finance-steps-cont-btn">
                                        
                                            <a href="<?php echo base_url(); ?>msme/apply-for-loan/loan-without-a-sponsor/" class="readon step1-btn">Select</a>
                                            
                                        </div>
                            
                                    </li>
                                    
                                </ul>
                                
                            </div>
                            
                        </div>
                        
                        <div class="col-md-4 no-pad-right">
                            
                            <div class="applyfin-lst">
                                
                                <ul>
                                    
                                    <li class="applyfin-lst-hdr-second">
                                    
                                        <span>
                                            2
                                        </span>
                                        
                                        Loan With A Sponsor 
                                    </li>
                                    
                                    <li>
                                        Collateral Free loans of upto US $10,000
                                    </li>
                                    
                                    <li>
                                        9% annual interest rate
            
                                    </li>
                                    
                                    <li>
                                        12  months Moratorium on Interest & Principal
                                    </li>
                                    
                                    <li>
                                    	
                                         <div class="finance-steps-cont-btn">
                                        
                                            <a href="<?php echo base_url(); ?>msme/apply-for-loan/loan-with-a-sponsor/" class="readon step2-btn">Select</a>
                                            
                                        </div>
                            
                                    </li>
                                    
                                </ul>
                                
                            </div>
                            
                        </div>
                        
                        <div class="col-md-4 no-pad-right">
                            
                            <div class="applyfin-lst">
                                
                                <ul>
                                    
                                    <li class="applyfin-lst-hdr-third">
                                    
                                        <span>
                                          3
                                        </span>
                                        
                                        Equity Investment
                                    </li>
                                    
                                    <li>
                                        Equity Investment of up to US $28,000 
                                    </li>
                                    
                                    <li>
                                        Dividend payment after 5 years
            
                                    </li>
                                    
                                    <li>
                                        Companies have the opportunity to buy back shares from 1C should they choose to.
                                    </li>
                                    
                                    <li>
                                    	
                                         <div class="finance-steps-cont-btn">
                                        
                                            <a href="<?php echo base_url(); ?>msme/apply-for-loan/equity-investment/" class="readon step3-btn">Select</a>
                                            
                                        </div>
                            
                                    </li>
                                    
                                </ul>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                
                </div>
                                                                        
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
          
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