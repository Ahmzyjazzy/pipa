<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?php echo $title; ?></title>

        
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
  
   <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/plugins/iCheck/minimal/_all.css">
   
    <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/bower_components/select2/dist/css/select2.min.css">
  
   <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">

<link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/plugins/lightbox/css/lightbox.min.css">

<link rel="stylesheet" href="<?php echo base_url() ?>asset/admin_asset/css/analyze/analyze.css">
  
<link rel="stylesheet" href="<?php echo base_url() ?>asset/adminlte/dist/css/style.css">
  
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
        <a href="<?php echo base_url(); ?>admin/dashboard/" class="logo">
         
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
         
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Administrator</b></span>
        
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
                      <a href="<?php echo base_url(); ?>admin/logout/" class="btn btn-default btn-flat">Sign out</a>
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
            
<!--            <li class="header">MAIN NAVIGATION</li>
-->            
 			
            <?php
				
				$user_company_id			=	$this->session->userdata('company_id');
			
			?>
            
            <li class="<?php if(!empty($menu_status)){ if($menu_status	== "dashboard"){ echo 'active';  } } ?>">
             
              <a href="<?php echo base_url(); ?>admin/dashboard/">
                
                <i class="fa  fa-home"></i> <span>Dashboard</span>

              </a>
              
            </li>                     
            
            <?php
			
			 if($user_company_id == '1')
			 {
				 
			?>
            <li class="treeview <?php if(!empty($menu_status)){ if($menu_status	== "demos"){ echo 'active';  } } ?>">
              
              <a href="#">
               
                <i class="fa  fa-calendar-check-o"></i> <span>Demos</span>
                
                <span class="pull-right-container">
                  
                  <i class="fa fa-angle-left pull-right"></i>
                  
                </span>
                
              </a>
              
              <ul class="treeview-menu">
              
                <li><a href="#"> Upcoming demos</a></li>
                
              	<li><a href="#">Demo requests</a></li>
                
                <li><a href="#">Approved requests</a></li>
                        
              </ul>
              
            </li>  
            
            <li class="treeview <?php if(!empty($menu_status)){ if($menu_status	== "client"){ echo 'active';  } } ?>">
             
              <a href="#">
              
                <i class="fa fa-building"></i> <span>Clients</span>
               
                <span class="pull-right-container">
                  
                  <i class="fa fa-angle-left pull-right"></i>
                  
                </span>
             
              </a>
              
              <ul class="treeview-menu">
              
                <li><a href="<?php echo base_url(); ?>admin/create-client/"> Create Client</a></li>
                
                <li><a href="<?php echo base_url(); ?>admin/active-companies/"> Active Client</a></li>
              
                <li><a href="<?php echo base_url(); ?>admin/pending-companies/"> Pending Client</a></li>
                          
              </ul>
              
            </li> 
            
            <li class="treeview <?php if(!empty($menu_status)){ if($menu_status	== "company"){ echo 'active';  } } ?>">
             
              <a href="#">
              
                <i class="fa fa-building"></i> <span>Company</span>
               
                <span class="pull-right-container">
                  
                  <i class="fa fa-angle-left pull-right"></i>
                  
                </span>
             
              </a>
              
              <ul class="treeview-menu">
              
                <li><a href="<?php echo base_url(); ?>admin/create-company/"> Create Company</a></li>
                
                <li><a href="<?php echo base_url(); ?>admin/active-companies/"> Active Company</a></li>
              
                <li><a href="<?php echo base_url(); ?>admin/pending-companies/"> Pending Company</a></li>
                          
              </ul>
              
            </li> 
            
            <?php
			
			 }
			 
			?>
             
            <li class="treeview <?php if(!empty($menu_status)){ if($menu_status	== "corporate-admin"){ echo 'active';  } } ?>">
             
              <a href="#">
              
                <i class="fa fa-building"></i> <span>Corporate Admins</span>
               
                <span class="pull-right-container">
                  
                  <i class="fa fa-angle-left pull-right"></i>
                  
                </span>
             
              </a>
              
              <ul class="treeview-menu">
              
                <li><a href="<?php echo base_url(); ?>admin/create-corporate-admin/"> Create Corporate Admin</a></li>
                
                <li><a href="<?php echo base_url(); ?>admin/active-corporate-admin/"> Active Corporate Admin</a></li>
              
                <li><a href="<?php echo base_url(); ?>admin/pending-corporate-admin/"> Pending Corporate Admin</a></li>
                          
              </ul>
              
            </li>
            
            <li class="treeview <?php if(!empty($menu_status)){ if($menu_status	== "corporate-location"){ echo 'active';  } } ?>">
             
              <a href="#">
              
                <i class="fa fa-building"></i> <span>Corporate Location</span>
               
                <span class="pull-right-container">
                  
                  <i class="fa fa-angle-left pull-right"></i>
                  
                </span>
             
              </a>
              
              <ul class="treeview-menu">
              
              	<li><a href="<?php echo base_url(); ?>admin/location/"> Locations</a></li>
                
                <li><a href="<?php echo base_url(); ?>admin/create-location/"> Create Locations</a></li>
                          
              </ul>
              
            </li> 
            
            <li class="treeview <?php if(!empty($menu_status)){ if($menu_status == "corporate-grades"){ echo 'active';  } } ?>">
             
              <a href="#">
              
                <i class="fa fa-building"></i> <span>Corporate Grades</span>
               
                <span class="pull-right-container">
                  
                  <i class="fa fa-angle-left pull-right"></i>
                  
                </span>
             
              </a>
              
              <ul class="treeview-menu">
              
              	<li><a href="<?php echo base_url(); ?>admin/grades/"> Grades</a></li>
                
                <li><a href="<?php echo base_url(); ?>admin/create-grades/"> Create Grades</a></li>
                          
              </ul>
              
            </li>   
            
            <li class="treeview <?php if(!empty($menu_status)){ if($menu_status	== "corporate-department"){ echo 'active';  } } ?>">
             
              <a href="#">
              
                <i class="fa fa-building"></i> <span>Corporate Department</span>
               
                <span class="pull-right-container">
                  
                  <i class="fa fa-angle-left pull-right"></i>
                  
                </span>
             
              </a>
              
              <ul class="treeview-menu">
              
              	<li><a href="<?php echo base_url(); ?>admin/departments/"> Departments</a></li>
                
                <li><a href="<?php echo base_url(); ?>admin/create-department/"> Create Department</a></li>
                          
              </ul>
              
            </li>

            <li class="treeview <?php if(!empty($menu_status)){ if($menu_status	== "users"){ echo 'active';  } } ?>" style="display:none;">
             
              <a href="#">
               
                <i class="fa  fa-user"></i> <span>Coaches</span>
               
                <span class="pull-right-container">
                
                  <i class="fa fa-angle-left pull-right"></i>
                  
                </span>
                
              </a>
              
              <ul class="treeview-menu">
               
                <li><a href="#">Active Coach</a></li>
                
                <li><a href="#">Pending Coach</a></li>
                           
              </ul>
              
            </li>
            
            <li class="treeview <?php if(!empty($menu_status)){ if($menu_status	== "programs"){ echo 'active';  } } ?>">
             
              <a href="#">
               
                <i class="fa  fa-file-text-o"></i> <span>Programs</span>
               
                <span class="pull-right-container">
                  
                  <i class="fa fa-angle-left pull-right"></i>
                  
                </span>
                
              </a>
              
              <ul class="treeview-menu">
                
              	
                <li><a href="<?php echo base_url(); ?>admin/create-program/">Create Program</a></li>
                
                <li><a href="<?php echo base_url(); ?>admin/active-programs/">Active Programs</a></li>
                
                <li><a href="<?php echo base_url(); ?>admin/pending-programs/">Pending Programs</a></li>
				
              </ul>
              
            </li>
            
            <li class="treeview <?php if(!empty($menu_status)){ if($menu_status	== "settings"){ echo 'active';  } } ?>" style="display:none;">
             
              <a href="#">
               
                <i class="fa fa-user"></i> <span>Program Owners</span>
               
                <span class="pull-right-container">
                  
                  <i class="fa fa-angle-left pull-right"></i>
                  
                </span>
                
              </a>
              
              <ul class="treeview-menu">
                
              	
                <li><a href="#">Create Program Owner</a></li>
                
                <li><a href="#">Active Program Owners</a></li>
                
                <li><a href="#">Pending Program Owners</a></li>
				
              </ul>
              
            </li>
            
            <li class="treeview <?php if(!empty($menu_status)){ if($menu_status	== "settings"){ echo 'active';  } } ?>" style="display:none;">
             
              <a href="#">
               
                <i class="fa fa-clipboard"></i> <span>Surveys</span>
               
                <span class="pull-right-container">
                  
                  <i class="fa fa-angle-left pull-right"></i>
                  
                </span>
                
              </a>
              
              <ul class="treeview-menu">
                
              	
                <li><a href="#">Create Survey</a></li>
                
                <li><a href="#">View Surveys</a></li>
				
              </ul>
              
            </li>
            
            <li class="<?php if(!empty($menu_status)){ if($menu_status	== "analyse"){ echo 'active';  } } ?>">
            
              <a href="<?php echo base_url(); ?>admin/analyze/">
              
                <i class="fa fa-line-chart"></i> <span>Analyze</span>
                             
              </a>
           
            </li>
            
            <li style="display:none;">
            
              <a href="#">
              
                <i class="fa fa-wechat"></i> <span>Support</span>
                             
              </a>
           
            </li>

            
            <li>
            
              <a href="<?php echo base_url(); ?>admin/logout/">
              
                <i class="fa fa-sign-out"></i> <span>Log Out</span>
                             
              </a>
           
            </li>
         
          </ul>
          
        </section>
    <!-- /.sidebar -->
    
    </aside>
    
    
    