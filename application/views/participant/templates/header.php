<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?php echo $title; ?></title>

        
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  
   <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/plugins/iCheck/minimal/_all.css">
   
    <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/bower_components/select2/dist/css/select2.min.css">
  
   <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">

<link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/plugins/lightbox/css/lightbox.min.css">

<link rel="stylesheet" href="<?php echo base_url() ?>asset/css/analyze.css">
  
<link rel="stylesheet" href="<?php echo base_url() ?>asset/userlte/dist/css/style.css">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  	<!-- jQuery 3 -->
	<script src="<?php echo base_url() ?>asset/userlte/bower_components/jquery/dist/jquery.min.js"></script>
    
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url() ?>asset/userlte/bower_components/jquery-ui/jquery-ui.min.js"></script>

</head>

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

    <header class="main-header">
    
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>admin/dashboard/" class="logo">
         
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
         
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b></b></span>
        
        </a>
    
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
         
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            
            <span class="sr-only">Toggle navigation</span>
            
          </a>
        
          <div class="navbar-custom-menu">
           
            <ul class="nav navbar-nav">
               
              <li class="dropdown notifications-menu">
                
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    
                        <i class="fa fa-bell"></i>
                        
                    
                    </a>
                
                    <ul class="dropdown-menu">
 
                    
                    </ul>
                
              </li>
                       
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
        		
               
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                
                  <!--<img src="<?php echo base_url() ?>asset/adminlte/dist/img/avatar.png" class="user-image" alt="User Image">-->
                  
                  <span class="hidden-xs dash-first-xtr">
				  
					  <?php 
						 
                        //echo ucfirst($this->session->userdata('firstname')).' '.ucfirst($this->session->userdata('lastname')); 
                      	$string				=	ucfirst($this->session->userdata('firstname'));
												
						$firstCharacter 	= 	$string[0];
						
						echo $firstCharacter;
						
                      ?>
                  
                  </span>
                
                </a>
        
                <ul class="dropdown-menu">
        
                  <!-- User image -->
                  <li class="user-header">
        
                    <img src="<?php echo base_url() ?>asset/adminlte/dist/img/avatar.png" class="img-circle" alt="User Image">
        
                    <p>
                      <?php
					  
					  	echo ucfirst($this->session->userdata('firstname')).' '.ucfirst($this->session->userdata('lastname'));
					  
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
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
        
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>participant/logout/" class="btn btn-default btn-flat">Sign out</a>
                    </div>
        
                  </li>
        
                </ul>
        
              </li>
        
              <!-- Control Sidebar Toggle Button -->
        
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
              
              <img src="<?php echo base_url() ?>asset/adminlte/dist/img/avatar.png" class="img-circle" alt="User Image">
            
            </div>
            
            <div class="pull-left info">
             
             <p>
			  <?php
			  
				echo ucfirst($this->session->userdata('firstname')).' '.ucfirst($this->session->userdata('lastname'));
			  
			  ?> 
             </p>
              
             <a href="#"></a>
           
            </div>
            
          </div>
    
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
           
            
            <li class="<?php if(!empty($menu_status)){ if($menu_status	== "dashboard"){ echo 'active';  } } ?>">
             
              <a href="<?php echo base_url(); ?>participant/dashboard/">
                
                <i class="fa  fa-home"></i> <span>Dashboard</span>

              </a>
              
            </li> 
            
            <li class="<?php if(!empty($menu_status)){ if($menu_status	== "program-calendar"){ echo 'active';  } } ?>">
            
              <a href="javascript:void(0);">
              
                <i class="fa fa-calendar"></i> <span>Program Calendar</span>
                             
              </a>
           
            </li>   
            
            <li class="<?php if(!empty($menu_status)){ if($menu_status	== "coaching"){ echo 'active';  } } ?>">
            
              <a href="javascript:void(0);">
              
                <i class="fa fa-user"></i> <span>Coaching</span>
                             
              </a>
           
            </li> 
            
            <li class="<?php if(!empty($menu_status)){ if($menu_status	== "my-surveys"){ echo 'active';  } } ?>">
            
              <a href="<?php echo base_url(); ?>participant/my-surveys/">
              
                <i class="fa fa-file-o"></i> <span>Surveys</span>
                             
              </a>
           
            </li>                      
         
          </ul>
			
          <div class="sidemenu-bottom-dv">
          	
            <div class="sidemenu-bottom-dv-hdr">
            	
                My Account
                
            </div>
            
            <div class="">
            	
                <ul class="sidebar-menu">
                	
                    <li>
                    	
                        <a href="javascript:void(0);">
                        
                        	<i class="fa fa-phone"></i> <span><?php echo $userDetails['phone_number']; ?></span>
                        
                        </a>
                        
                    </li>
                    
                    <li style="word-break: break-word;">
                    	
                        <a href="javascript:void(0);">
                        
                        <i class="fa fa-envelope"></i> <span><?php echo $userDetails['email']; ?></span>
                        
                        </a>
                        
                    </li>
                    
                </ul>
                
            </div>
            
            <div class="sidemenu-bottom-dv-btn">
            	
                <a href="<?php echo base_url(); ?>participant/">
                	
                    Update contact details
                    
                </a>
                
            </div>
            
          </div>
          
          <ul class="sidebar-menu" data-widget="tree">                       
            
            <li>
            
              <a href="<?php echo base_url(); ?>participant/logout/">
              
                <i class="fa fa-sign-out"></i> <span>Log Out</span>
                             
              </a>
           
            </li>
         
          </ul>
          
        </section>
    <!-- /.sidebar -->
    
    </aside>
    
    
    