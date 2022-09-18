  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
   <!-- Content Header (Page header) -->
    <section class="content-header">
      
      <h1>
        
        Hello <?php echo ucfirst($user['firstName']).' '.ucfirst($user['lastName']); ?> 
        
      </h1>
      
      <ol class="breadcrumb">
    
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    
        <li class="active">Dashboard</li>
    
      </ol>
    
    </section>

    <!-- Main content -->
    <section class="content">
          
      <!-- Small boxes (Stat box) -->
      <div class="row">
      
        <div class="col-lg-6 col-xs-12">            

            <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
            
            	<div class="box box-default">
            
                    <div class="box-header with-border">
                    
                      <!--<i class="fa fa-bullhorn"></i>-->
                    
                        <h3 class="box-title">Profile Information</h3>
                        
                        <div class="pull-right userDashb-edit">
                        
                            <a href="<?php echo base_url(); ?>msme/profile/">
                                
                                Edit
                                
                            </a>
                        
                        </div>
                  
                    </div>
                
                    <div class="box-body">
                        
                        <div class="col-md-12 userDashb-cnt">
                        
                            <div class="col-md-7 col-xs-7">
                                
                                <div class="userDashb-left">
                                
                                    <i class="fa fa-user"></i>
                                    
                                    Name
                                                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-md-5 col-xs-5">
                                
                                <div class="userDashb-right">
                                
                                    <?php
                                    
                                       echo ucfirst($user['firstName']).' '.ucfirst($user['lastName']);  
                                    
                                    ?>                                
                                    
                                </div>
                                
                            </div>
                        
                        </div>
                        
                        <div class="col-md-12 userDashb-cnt">
                        
                            <div class="col-md-7 col-xs-7">
                                
                                <div class="userDashb-left">
                                
                                    <i class="fa fa-envelope-o"></i>
                                    
                                    Email Address
                                                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-md-5 col-xs-5">
                                
                                <div class="userDashb-right" style="word-break: break-word;">
                                    
                                    <?php
                                    
                                        echo $user['email'];  
                                    
                                    ?> 
                                                                 
                                    
                                </div>
                                
                            </div>
                        
                        </div>
                        
                        <div class="col-md-12 userDashb-cnt">
                        
                            <div class="col-md-7 col-xs-7">
                                
                                <div class="userDashb-left">
                                
                                    <i class="fa fa-phone"></i>
                                    
                                    Phone Number
                                                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-md-5 col-xs-5">
                                
                                <div class="userDashb-right">
                                    
                                    <?php
                                    
                                        echo $user['mobile'];  
                                    
                                    ?>                              
                                    
                                </div>
                                
                            </div>
                        
                        </div>
                        
                        <div class="col-md-12 userDashb-cnt">
                        
                            <div class="col-md-7 col-xs-7">
                                
                                <div class="userDashb-left">
                                
                                    <i class="fa fa-flag-o"></i>
                                    
                                    Country
                                                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-md-5 col-xs-5">
                                
                                <div class="userDashb-right">
                                    
                                    <?php
                                    
                                        echo $country;  
                                    
                                    ?>                              
                                    
                                </div>
                                
                            </div>
                        
                        </div>
                        
                    </div>
                
                </div>
            
            </div>
            
            <div class="col-md-12" style="padding-left:0px; padding-right:0px;">
            
                <div class="box box-default" style="border-top-color:#3fdb1c;">
                
                    <div class="box-header with-border">
                    
                      <!--<i class="fa fa-bullhorn"></i>-->
                    
                        <h3 class="box-title">KYC Information</h3>
                        
                        <div class="pull-right userDashb-edit">
                        
                            <a href="<?php echo base_url(); ?>msme/account/kyc/">
                                
                                Edit
                                
                            </a>
                        
                        </div>
                  
                    </div>
                
                    <div class="box-body">
                        
                        <div class="col-md-12 userDashb-cnt">
                        
                            <div class="col-md-7 col-xs-7">
                                
                                <div class="userDashb-left">
                                
                                    <i class="fa fa-photo"></i>
                                    
                                   	ID Type
                                                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-md-5 col-xs-5">
                                
                                <div class="userDashb-right">
                                    
                                    <?php
                                    
                                    if(!empty($userKYC))
                                    {
                                        //check if this user has uploaded the front side
                                        
                                        if(!empty($userKYC->idType))
                                        {
                                           
										   if($userKYC->idType == 'Others')
										   {
											   
                                           		echo '<span title="Approved" class="btn bg-olive"> '.$userKYC->ifIDothers.' </span>';
										   
										   }else{
											   
											   echo '<span title="Approved" class="btn bg-olive"> '.$userKYC->idType.' </span>';
										   }
                                        
                                        }else{
                                            
                                            //echo '<span class="label label-warning">Pending Upload</span>'; 
                                            
                                        }
                                    
                                    }else{
                                        
                                        //echo '<span class="label label-warning">Pending Upload</span>';
                                        
                                    }
                                    
                                    ?>
                                    
                                </div>
                                
                            </div>
                        
                        </div>
                        
                        <div class="col-md-12 userDashb-cnt">
                        
                            <div class="col-md-7 col-xs-7">
                                
                                <div class="userDashb-left">
                                
                                    <i class="fa fa-pencil-square-o"></i>
                                    
                                     ID Number
                                                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-md-5 col-xs-5">
                                
                                <div class="userDashb-right">
                                                                    
                                	<?php
										
										if(!empty($userKYC->idNumber))
										{
											
											echo $userKYC->idNumber;
										
										}
										
									?>
                                    
                                </div>
                                
                            </div>
                        
                        </div>
                        
                        <div class="col-md-12 userDashb-cnt">
                        
                            <div class="col-md-7 col-xs-7">
                                
                                <div class="userDashb-left">
                                
                                    <i class="fa fa-photo"></i>
                                    
                                    Utility Bill Type
                                                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-md-5 col-xs-5">
                                
                                <div class="userDashb-right">
                                    
                                    <?php
                                    	
										if(!empty($userKYC->utilityType))
										{
											
											if($userKYC->utilityType == 'Others')
											{
												
												echo $userKYC->ifUtilityothers;
												
											}else{
												
												echo $userKYC->utilityType;
											
											}
										
										}else{
											
										}
                                    
                                    ?>                             
                                    
                                </div>
                                
                            </div>
                        
                        </div>
                        
                        <div class="col-md-12 userDashb-cnt">
                        
                            <div class="col-md-8 col-xs-8">
                                
                                <div class="userDashb-left">
                                
                                    <i class="fa fa-graduation-cap"></i>
                                    
                                    Highest Qualification
                                                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-md-4 col-xs-4">
                                
                                <div class="userDashb-right">
                                    
                                    <?php
                                    	
										if(!empty($userKYC->highestEducation))
										{
											
                                    		echo $userKYC->highestEducation;
										
										}else{
											
										}
                                    
                                    ?>                          
                                    
                                </div>
                                
                            </div>
                        
                        </div>
                        
                    </div>
                
                </div>
                  
            </div>
            
        </div>
        
        <div class="col-lg-6 col-xs-12">
            
            <div class="box box-default" style="border-top-color:#3fdb1c;">
        
                <div class="box-header with-border">
                
                  <!--<i class="fa fa-bullhorn"></i>-->
                
                    <h3 class="box-title">Business Information</h3>
                    
                    <div class="pull-right userDashb-edit">
                    
                        <a href="<?php echo base_url(); ?>msme/business-profile/">
                            
                            Edit
                            
                        </a>
                    
                    </div>
              
                </div>
            
                <div class="box-body">
                    
                    <div class="col-md-12 userDashb-cnt">
                    
                        <div class="col-md-7 col-xs-7">
                            
                            <div class="userDashb-left">
                            
                                <i class="fa fa-bank"></i>
                                
                               Business Name
                                                                
                            </div>
                            
                        </div>
                        
                        <div class="col-md-5 col-xs-5">
                            
                            <div class="userDashb-right" style="word-break: break-word;">
                            
                                <?php
                                
                                   echo ucfirst($business['businessName']);  
                                
                                ?>                                
                                
                            </div>
                            
                        </div>
                    
                    </div>
                    
                    <div class="col-md-12 userDashb-cnt">
                    
                        <div class="col-md-7 col-xs-7">
                            
                            <div class="userDashb-left">
                            
                                <i class="fa fa-registered"></i>
                                
                                Is your Company Registered?
                                                                
                            </div>
                            
                        </div>
                        
                        <div class="col-md-5 col-xs-5">
                            
                            <div class="userDashb-right" style="word-break: break-word;">
                                
                                <?php
                                
                                    echo $business['cacRegStatus'];  
                                
                                ?> 
                                                             
                                
                            </div>
                            
                        </div>
                    
                    </div>
                    
                    <div class="col-md-12 userDashb-cnt">
                    
                        <div class="col-md-7 col-xs-7">
                            
                            <div class="userDashb-left">
                            
                                <i class="fa fa-briefcase"></i>
                                
                                CAC Reg Number
                                                                
                            </div>
                            
                        </div>
                        
                        <div class="col-md-5 col-xs-5">
                            
                            <div class="userDashb-right">
                                
                                <?php
                                
                                    echo $business['cacRegNum'];  
                                
                                ?>                              
                                
                            </div>
                            
                        </div>
                    
                    </div>
                    
                    <div class="col-md-12 userDashb-cnt">
                    
                        <div class="col-md-7 col-xs-7">
                            
                            <div class="userDashb-left">
                            
                                <i class="fa fa-tag"></i>
                                
                                Tax Identification Number (TIN)
                                                                
                            </div>
                            
                        </div>
                        
                        <div class="col-md-5 col-xs-5">
                            
                            <div class="userDashb-right">
                                
                                <?php
                                
                                     echo $business['tin']; 
                                
                                ?>                              
                                
                            </div>
                            
                        </div>
                    
                    </div>
                    
                </div>
            
            </div>
        
        </div>
            
        <div class="col-lg-6 col-xs-12"> 
            
            <div class="box box-default">
            
                <div class="box-header with-border">
                
                  <!--<i class="fa fa-bullhorn"></i>-->
                
                    <h3 class="box-title">Investment Information</h3>

              
                </div>
            
                <div class="box-body">
                                            
                    
                </div>
            
            </div>
              
        </div>
        
      </div>

    </section>
    <!-- /.content -->
    
  </div>  
  <!-- /.content-wrapper -->
