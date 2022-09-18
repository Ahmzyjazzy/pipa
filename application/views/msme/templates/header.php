<!DOCTYPE html>
<html>
<head>
    <!-- Meta -->
    <meta charset="utf-8" />
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <meta name="keywords" content="1Community" />
    
    <meta name="description" content="1community">
        
    <!-- Title -->
    <title><?php echo $title; ?></title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>asset/images/favicon/favicon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>asset/images/favicon/favicon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>asset/images/favicon/favicon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>asset/images/favicon/favicon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>asset/images/favicon/favicon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>asset/images/favicon/favicon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>asset/images/favicon/favicon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>asset/images/favicon/favicon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>asset/images/favicon/favicon-180x180.png">
    
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo base_url(); ?>asset/images/favicon/favicon-192x192.png">
    
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>asset/images/favicon/favicon.png">
    
    
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>asset/images/favicon/favicon-144x144.png">
    
        
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">

<link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/plugins/lightbox/css/lightbox.min.css">

  
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/dist/css/style.css?v=2">
  
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/css/userstyle.css">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  	<!-- jQuery 3 -->
	<script src="<?php echo base_url() ?>asset/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
    
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url() ?>asset/adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>

</head>

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

    <header class="main-header">
    
        <!-- Logo -->
        <a href="<?php echo base_url() ?>msme/dashboard/" class="logo">
         
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
         
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
          	
            <img src="<?php echo base_url() ?>asset/images/logo-white.png" />
            
          </span>
        
        </a>
    
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
         
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
        
          <div class="navbar-custom-menu">
           
            <ul class="nav navbar-nav">
                
                <li class="dropdown messages-menu">
                
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    
                        <i class="fa fa-envelope-o"></i>
                        
                        <!--<span class="label label-success">4</span>-->
                    
                    </a>
                
                    <ul class="dropdown-menu">

                    
                    </ul>
                
                </li>
               
                <li class="dropdown notifications-menu">
                
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    
                        <i class="fa fa-bell-o"></i>
                        
                        
                        <?php
						
						$CI 						=& get_instance();
									
						$notifications				=	$CI->get_user_notification();
						
						$notificationsUnseen		=	$CI->get_user_notification_unseen();
						
						
						if(!empty($notificationsUnseen))
						{
							echo '<span class="label label-warning notfisze">'.sizeof($notificationsUnseen).'</span>';
							
						}else{
							
							echo '<span class="label label-warning notfisze" style="display:none;"></span>';
							
						}
						
						?>
                        
                        
                    
                    </a>
                
                    <ul class="dropdown-menu">
                    	
                        <?php
						
						if(!empty($notifications))
						{
						
							if(!empty($notificationsUnseen))
							{
						   	
								echo  '<li class="header notifyHeader">You have '.sizeof($notificationsUnseen).' New notifications</li>';
						   
							}else{
								
								echo  '<li class="header notifyHeader"></li>';
							}
						
							echo '<li>
							
								<ul class="menu notifybody">';
									
									$noti_count		=	1;
									
									foreach($notifications as $notification)
									{
										
										if($noti_count <= 10)
										{
											
											echo '<li>
											
												<a href="#">
												
													<i class="fa fa-warning text-yellow"></i> '.$notification['notification'].'
												
												</a>
											
											</li>';
										
										}
										
										$noti_count++;
										
									}
								
								echo '</ul>
							
							</li>
						
							<li class="footer">
							
								<a href="'.base_url().'msme/notification/">View all</a>
							
							</li>';
						
						}
						
						?>
                    
                    </ul>
                
                </li>
           
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
        
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  
                  <?php
				  	
					if(!empty($user['profilePicture']))
					{
						
						$imgProfile		=	base_url().'uploads/wysiwyg/images/profilepic/'.$user['profilePicture'];
						
						//$imgProfile		=	base_url().'asset/images/avatar.jpg';
						
					}else{
							
						if(!empty($user['gender']))
						{
							if($user['gender'] == 'Male')
							{
								
								$imgProfile		=	base_url().'asset/adminlte/dist/img/avatar.png';
								
							}else{
								
								$imgProfile		=	base_url().'asset/adminlte/dist/img/avatar3.png';
								
							}
							
						}else{
							
							$imgProfile			=	base_url().'asset/images/avatar.jpg';
							
						}
				  	
					}
					
				  ?>
                  
                  <img src="<?php echo $imgProfile;  ?>" class="user-image" alt="<?php echo ucfirst($this->session->userdata('firstname')).' '.ucfirst($this->session->userdata('lastname')); ?>">
                
                  <span class="hidden-xs">
				
                	  <?php echo ucfirst($this->session->userdata('firstname')).' '.ucfirst($this->session->userdata('lastname')); ?>
                  
                  </span>
                
                </a>
        
                <ul class="dropdown-menu">
        
                  <!-- User image -->
                  <li class="user-header">
        
                    <img src="<?php echo $imgProfile; ?>" class="img-circle" alt="User Image">
        
                    <p>
                      <?php
					  
					  	echo ucfirst($this->session->userdata('userFirstname')).' '.ucfirst($this->session->userdata('userLastname'));
					  
					  ?> 
                    </p>
        
                  </li>
        
                  <!-- Menu Body -->
                  <li class="user-body">
        
                    <div class="row">
        
                    </div>
                    <!-- /.row -->
        
                  </li>
        
                  <!-- Menu Footer-->
                  <li class="user-footer">
        
                    <div class="pull-left">
                      
                      <a href="<?php echo base_url(); ?>msme/account/profile/" class="btn btn-default btn-flat">
                      
                      	Profile
                      
                      </a>
                      
                    </div>
        
                    <div class="pull-right">
                    
                      <a href="<?php echo base_url(); ?>msme/account/logout/" class="btn btn-default btn-flat">
                      
                      	Sign out
                      
                      </a>
                    
                    </div>
        
                  </li>
        
                </ul>
        
              </li>
        
              <!-- Control Sidebar Toggle Button -->
              <!--<li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>-->
        
            </ul>
        
          </div>
        
        </nav>
    
    </header>
    
    <!-- Left side column. contains the logo and sidebar -->

    <aside class="main-sidebar">
        
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          
          <!-- Sidebar user panel -->
          <div class="user-panel">
            
            <div class="pull-left image">
              
              <img src="<?php echo $imgProfile;  ?>" class="img-circle" alt="User Image">
            
            </div>
            
            <div class="pull-left info">
             
             <p>
			  <?php
			  
				echo ucfirst($this->session->userdata('userFirstname')).' '.ucfirst($this->session->userdata('userLastname'));
			  
			  ?> 
             </p>
              
             <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
           
            </div>
            
          </div>
          
          <!-- search form -->
<!--          <form action="#" method="get" class="sidebar-form">
           
            <div class="input-group">
             
              <input type="text" name="q" class="form-control" placeholder="Search...">
              
              <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
                  
            </div>
            
          </form>-->
          
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            
            <li class="header">MAIN NAVIGATION</li>
            
            <li>
             
              <a href="<?php echo base_url(); ?>">
                
                <i class="fa fa-home"></i> <span>Home</span>

              </a>
              
            </li>
            
            <li class="<?php if(!empty($menu_status)){ if($menu_status	== "dashboard"){ echo 'active';  } } ?>">
             
              <a href="<?php echo base_url(); ?>msme/account/dashboard/">
                
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>

              </a>
              
            </li>
            
            <li class="<?php if(!empty($menu_status)){ if($menu_status	== "profile"){ echo 'active';  } } ?>">
             
              <a href="<?php echo base_url(); ?>msme/account/profile/">
               
                <i class="fa fa-user"></i> <span>Profile</span>
                
              </a>
              
            </li>
            
            <li class="<?php if(!empty($menu_status)){ if($menu_status	== "business-profile"){ echo 'active';  } } ?>">
             
              <a href="<?php echo base_url(); ?>msme/business-profile/">
               
                <i class="fa fa-user"></i> <span>Business Profile</span>
                
              </a>
              
            </li>

            
            <li class="<?php if(!empty($menu_status)){ if($menu_status	== "kyc"){ echo 'active';  } } ?>">
             
              <a href="<?php echo base_url(); ?>msme/account/kyc/">
               
                <i class="fa fa-photo"></i> <span>KYC</span>
                
              </a>
              
            </li>
            
            <li class="<?php if(!empty($menu_status)){ if($menu_status	== "loans"){ echo 'active';  } } ?>">
             
              <a href="<?php echo base_url(); ?>msme/loans/">
               
                <i class="fa fa-photo"></i> <span>Loans</span>
                
              </a>
              
            </li>

            
            <li>
            
              <a href="<?php echo base_url(); ?>msme/account/logout/">
              
                <i class="fa fa-sign-out"></i> <span>Log Out</span>
                             
              </a>
           
            </li>
         
          </ul>
          
        </section>
    <!-- /.sidebar -->
    
    </aside>
    
    
    