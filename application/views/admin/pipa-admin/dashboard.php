  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
   <!-- Content Header (Page header) -->
    <section class="content-header">

      
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
      	
        <div class="col-md-12">
        	
            <div class="col-md-12">
            
        	<div class="pipa-bx">
            	
                <div class="col-xs-12 col-md-8 no-pad-right">
                	
                    <div class="dashb-actives">
                    
                    	<div class="dashb-actives-welcme-admin">
                        	
                            <span>Hello <?php echo ucfirst($this->session->userdata('firstname')); ?>,</span>
                            
                            here are your dashboard stats
                            
                        </div>
                        
                        <div class="col-xs-12 col-md-12 dashb-layer no-pad-left no-pad-right">
                            
                            <div class="col-xs-6 col-md-4 cont-smaller no-pad-left-mob no-pad-right-mob">
                                
                                <div class="dashb-stats-cont-top dashb-stats-cont-top-bg-first">
                                    
                                    <div class="dashb-stats-cont-top-color">
                                        
                                         <div class="dashb-stats-cont-top-color-show-color dasb-color-blue">
                                        	
                                             <i class="fa fa-file-text-o"></i>
                                             
                                        </div>
                                                
                                    </div>
                                    
                                    <div class="dashb-stats-cont-top-info">
                                        
                                        <div class="dashb-stats-cont-top-info-num">
                                        
                                            <?php
												
												echo sizeof($numPrograms);
											
											?>
                                        
                                        </div>
                                        
                                        <div class="dashb-stats-cont-top-info-txt">
                                            
                                            Programs
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-xs-6 col-md-4 cont-smaller no-pad-left-mob no-pad-right-mob">
                                
                                <div class="dashb-stats-cont-top dashb-stats-cont-top-bg-first">
                                    
                                    <div class="dashb-stats-cont-top-color">
                                        
                                         <div class="dashb-stats-cont-top-color-show-color dasb-color-purple">
                                        	
                                            <i class="fa fa-building"></i>
                                            
                                        </div>
                                                
                                    </div>
                                    
                                    <div class="dashb-stats-cont-top-info">
                                        
                                        <div class="dashb-stats-cont-top-info-num ">
                                        
                                            <?php
												
												echo sizeof($numClients);
											
											?>
                                        
                                        </div>
                                        
                                        <div class="dashb-stats-cont-top-info-txt">
                                            
                                            Clients
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-xs-6 col-md-4 cont-smaller no-pad-left-mob no-pad-right-mob">
                                
                                <div class="dashb-stats-cont-top dashb-stats-cont-top-bg-first">
                                    
                                    <div class="dashb-stats-cont-top-color">
                                        
                                         <div class="dashb-stats-cont-top-color-show-color dasb-color-light-green">
                                        	
                                            <i class="fa fa-user"></i>
                                            
                                        </div>
                                                
                                    </div>
                                    
                                    <div class="dashb-stats-cont-top-info">
                                        
                                        <div class="dashb-stats-cont-top-info-num">
                                        
                                            <?php
												
												echo sizeof($numUsers);
											
											?>
                                        
                                        </div>
                                        
                                        <div class="dashb-stats-cont-top-info-txt">
                                            
                                            Individual Users
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-xs-6 col-md-4 cont-smaller no-pad-left-mob no-pad-right-mob">
                                
                                <div class="dashb-stats-cont-top dashb-stats-cont-top-bg-first">
                                    
                                    <div class="dashb-stats-cont-top-color">
                                        
                                         <div class="dashb-stats-cont-top-color-show-color dasb-color-light-blue">
                                        	
                                            <i class="fa fa-user"></i>
                                            
                                        </div>
                                                
                                    </div>
                                    
                                    <div class="dashb-stats-cont-top-info">
                                        
                                        <div class="dashb-stats-cont-top-info-num">
                                        
                                            <?php
												
												echo sizeof($numProgramOwners);
											
											?>
                                        
                                        </div>
                                        
                                        <div class="dashb-stats-cont-top-info-txt">
                                            
                                            Program Owners
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-xs-6 col-md-4 cont-smaller no-pad-left-mob no-pad-right-mob">
                                
                                <div class="dashb-stats-cont-top dashb-stats-cont-top-bg-first">
                                    
                                    <div class="dashb-stats-cont-top-color">
                                        
                                         <div class="dashb-stats-cont-top-color-show-color dasb-color-green">
                                        	
                                            <i class="fa fa-user"></i>
                                            
                                        </div>
                                                
                                    </div>
                                    
                                    <div class="dashb-stats-cont-top-info">
                                        
                                        <div class="dashb-stats-cont-top-info-num">
                                        
                                          	<?php
												
												echo sizeof($numCoaches);
											
											?>
                                        
                                        </div>
                                        
                                        <div class="dashb-stats-cont-top-info-txt">
                                            
                                            Coaches
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-xs-6 col-md-4 cont-smaller no-pad-left-mob no-pad-right-mob">
                                
                                <div class="dashb-stats-cont-top dashb-stats-cont-top-bg-first">
                                    
                                    <div class="dashb-stats-cont-top-color">
                                        
                                         <div class="dashb-stats-cont-top-color-show-color dasb-color-pink">
                                        
                                        	<i class="fa fa-user"></i>
                                            
                                        </div>
                                                
                                    </div>
                                    
                                    <div class="dashb-stats-cont-top-info">
                                        
                                        <div class="dashb-stats-cont-top-info-num">
                                        
                                           <?php
												
												echo sizeof($numFacilitators);
											
											?>
                                        
                                        </div>
                                        
                                        <div class="dashb-stats-cont-top-info-txt">
                                            
                                            Facilitators
                                            
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                                                
                    </div>
                    
                </div>
                
                <div class="col-xs-12 col-md-4 cont-smaller">
                	
                    <div class="dashb-active-users">
                    	
                        <div class="col-xs-8 col-md-7 cont-smaller">
                        	
                            <div class="dashb-active-users-mini-stat">
								
                                <span>
                                
									<?php
                                    
                                        echo sizeof($numUsers); 
                                    
                                    ?>
                                
                                </span>
                                 
                                active users
                                            
                            </div>
                            
                        </div>
                        
                        <div class="col-xs-4 col-md-5">
                        	
                            <div class="dashb-active-users-mini-stat-img">
                            
                       			<img src="<?php echo base_url(); ?>asset/images/group-204.png" />
                            
                            </div>
                        
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            
            </div>
            
        </div>
        
      </div>
      
      <div class="row">
      	
        <div class="col-md-12 minimum-content-margin">
        	
            <div class="col-xs-12 col-md-8">
            	
                <div class="dashb-table">
                	
                    <div class="dashb-table-hdr">
                    	
                        <div class="col-xs-5 col-md-8 no-pad-left">
                        
                        	<div class="dashb-table-hdr-txt">
                            	
                                Notifications
                                
                            </div>
                        
                        </div>
                        
                        <div class="col-xs-7 col-md-4">
                        	
                            <div class="col-xs-9 col-md-10 no-pad-left-mob no-pad-right-mob">
                            
                                <div class="dashb-table-form">
                                    
                                    <select name="" class="form-control">
                                    
                                        <option value="" selected="selected">This Week</option>
                                        
                                    </select>
                                    
                                </div>
                            
                            </div>
                            
                            <div class="col-xs-3 col-md-2">
                            	
                                <div class="dashb-table-gear">
                                	
                                    <a href="#">
                                    
                                    	<i class="fa fa-gear"></i>
                                    
                                    </a>
                                    
                                </div>
                                
                            </div>
                
                        </div>
                        
                    </div>
                    
                    
                    <?php
						
						$notifi_color		=	array(
							
							'0'				=>	'blue',
							
							'1'				=>	'green',
							
							'2'				=>	'purple',
							
							'3'				=>	'lighBlue',
							
							'4'				=>	'lightGreen',
						
						);
					?>
                    
                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                    	
                        <div class="dashb-table-row" style="border-bottom:none;">
                        	
                            <div class="col-xs-12 col-md-12 ">
                                                                    
                                <div class="dashb-table-row-notifi" style="text-align:center;">
                                
                                    <p>
                                        
                                        No Pending Notifications
                                        
                                    </p>
                                
                                </div>
                                                                
                            </div>                            
                            
                        </div>
                        
                    </div>
                    
                    <!--<div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                    	
                        <div class="dashb-table-row">
                        	
                            <div class="col-xs-8 col-md-7 ">
                            
                                <div class="col-xs-2 col-md-1">
                                    
                                    <div class="dashb-table-row-tick dashb-table-row-tick-<?php echo $notifi_color['0']; ?>">
                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-9 col-md-7 no-pad-left">
                                    
                                    <div class="dashb-table-row-notifi">
                                    
                                        <p>
                                            
                                            3 pending demo requests
                                            
                                        </p>
                                    
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                            <div class="col-xs-4 col-md-5 no-pad-left no-pad-right">
                            
                                <div class="col-xs-12 col-md-6 no-pad-left-mob no-pad-right-mob">
                                    
                                    <div class="dashb-table-row-view">
                                    
                                        <a href="#">
                                            
                                            View Requests
                                            
                                        </a>
                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-6 no-pad-left-mob no-pad-right-mob">
                                    
                                    <div class="dashb-table-row-approve">
                                    
                                        <a href="#">
                                            
                                            Approve all
                                            
                                        </a>
                                    
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                        </div>
                        
                    </div>-->
                    
                    <!--<div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                    	
                        <div class="dashb-table-row">
                        	
                            <div class="col-xs-8 col-md-7 ">
                            
                                <div class="col-xs-2 col-md-1">
                                    
                                    <div class="dashb-table-row-tick dashb-table-row-tick-<?php echo $notifi_color['1']; ?>">
                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-9 col-md-7 no-pad-left">
                                    
                                    <div class="dashb-table-row-notifi">
                                    
                                        <p>
                                            
                                            3 pending coach requests
                                            
                                        </p>
                                    
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                            <div class="col-xs-4 col-md-5 no-pad-left no-pad-right">
                            
                                <div class="col-xs-12 col-md-6 no-pad-left-mob no-pad-right-mob">
                                    
                                    <div class="dashb-table-row-view">
                                    
                                        <a href="#">
                                            
                                            View Requests
                                            
                                        </a>
                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-6 no-pad-left-mob no-pad-right-mob">
                                    
                                    <div class="dashb-table-row-approve">
                                    
                                        <a href="#">
                                            
                                            Approve all
                                            
                                        </a>
                                    
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                        </div>
                        
                    </div>-->
                    
                    <!--<div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                    	
                        <div class="dashb-table-row">
                        	
                            <div class="col-xs-8 col-md-7 ">
                            
                                <div class="col-xs-2 col-md-1">
                                    
                                    <div class="dashb-table-row-tick dashb-table-row-tick-<?php echo $notifi_color['2']; ?>">
                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-9 col-md-7 no-pad-left">
                                    
                                    <div class="dashb-table-row-notifi">
                                    
                                        <p>
                                            
                                           12 pending client requests approvals
                                            
                                        </p>
                                    
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                            <div class="col-xs-4 col-md-5 no-pad-left no-pad-right">
                            
                                <div class="col-xs-12 col-md-6 no-pad-left-mob no-pad-right-mob">
                                    
                                    <div class="dashb-table-row-view">
                                    
                                        <a href="#">
                                            
                                            View Requests
                                            
                                        </a>
                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-6 no-pad-left-mob no-pad-right-mob">
                                    
                                    <div class="dashb-table-row-approve">
                                    
                                        <a href="#">
                                            
                                            Approve all
                                            
                                        </a>
                                    
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                        </div>
                        
                    </div>-->
                    
                    <!--<div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                    	
                        <div class="dashb-table-row">
                        	
                            <div class="col-xs-8 col-md-7 ">
                            
                                <div class="col-xs-2 col-md-1">
                                    
                                    <div class="dashb-table-row-tick dashb-table-row-tick-<?php echo $notifi_color['3']; ?>">
                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-9 col-md-7 no-pad-left">
                                    
                                    <div class="dashb-table-row-notifi">
                                    
                                        <p>
                                            
                                           7 pending program owner requests
                                            
                                        </p>
                                    
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                            <div class="col-xs-4 col-md-5 no-pad-left no-pad-right">
                            
                                <div class="col-xs-12 col-md-6 no-pad-left-mob no-pad-right-mob">
                                    
                                    <div class="dashb-table-row-view">
                                    
                                        <a href="#">
                                            
                                            View Requests
                                            
                                        </a>
                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-6 no-pad-left-mob no-pad-right-mob">
                                    
                                    <div class="dashb-table-row-approve">
                                    
                                        <a href="#">
                                            
                                            Approve all
                                            
                                        </a>
                                    
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                        </div>
                        
                    </div>-->
                    
                    <!--<div class="col-xs-12 col-md-12 no-pad-left no-pad-right">
                    	
                        <div class="dashb-table-row dashb-table-row-last">
                        	
                            <div class="col-xs-8 col-md-7 ">
                            
                                <div class="col-xs-2 col-md-1">
                                    
                                    <div class="dashb-table-row-tick dashb-table-row-tick-<?php echo $notifi_color['4']; ?>">
                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-9 col-md-7 no-pad-left">
                                    
                                    <div class="dashb-table-row-notifi">
                                    
                                        <p>
                                            
                                           7 pending individual user requests
                                            
                                        </p>
                                    
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                            <div class="col-xs-4 col-md-5 no-pad-left no-pad-right">
                            
                                <div class="col-xs-12 col-md-6 no-pad-left-mob no-pad-right-mob">
                                    
                                    <div class="dashb-table-row-view">
                                    
                                        <a href="#">
                                            
                                            View Requests
                                            
                                        </a>
                                    
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-12 col-md-6 no-pad-left-mob no-pad-right-mob">
                                    
                                    <div class="dashb-table-row-approve">
                                    
                                        <a href="#">
                                            
                                            Approve all
                                            
                                        </a>
                                    
                                    </div>
                                    
                                </div>
                            
                            </div>
                            
                        </div>
                        
                    </div>-->                    
                    
                </div>
                
            </div>
            
            <div class="col-xs-12 col-md-4">
            	
                <div class="pipa-bx">
                    
                    <div class="" style="text-align:center; min-height:250px; padding-top:40%; padding-bottom:40%; font-size:26px; font-weight:600;">
                    
                        No Calendar Activity
                        
                    </div>
                
                </div>
                <!--<div class="dashb-calender-sect">
                	
                    <div class="dashb-calender-sect-bg">
                    	
                        <div class="dashb-calender-sect-bg-date">
                        	
                            Monday 13th, 2020
                            
                        </div>
                        
                        <div class="dashb-calender-sect-bg-month">
                        	
                            January
                            
                        </div>
                        
                        <div class="col-xs-12 no-pad-left">
                        	
                            <div class="col-xs-2 no-pad-left">
                            	
                                <div class="dashb-calender-sect-bg-icon">
                                
                                	<i class="fa fa-calendar"></i>
                                
                                </div>
                                
                            </div>
                            
                            <div class="col-xs-6 no-pad-left">
                            	
                                <div class="dashb-calender-sect-bg-meet">
                                	
                                    <div class="dashb-calender-sect-bg-meet-hdr">
                                    	
                                        Meeting with Seyi
                                        
                                    </div>
                                    
                                    <div class="dashb-calender-sect-bg-meet-lwr">
                                    	
                                        Aspire-sterling
                                        
                                    </div>
                                    
                                    <div class="dashb-calender-sect-bg-meet-lnk">
                                    	
                                        <a href="#">
                                        	
                                            View in calendar <i class="fa fa-angle-right"></i>
                                            
                                        </a>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                        
                    </div>
                    
                    <div class="pipa-bx dashb-calender-sect-dates">
                    	
                        <div class="col-xs-3">
                        	
                            <div class="dashb-calender-sect-dates-day">
                            	
                                14th
                                
                            </div>
                            
                        </div>
                        
                        <div class="col-xs-7">
                        
                        	<div class="dashb-calender-sect-month-cont">
                            	
                                <div class="dashb-calender-sect-month">
                                	
                                    December 2020
                                    
                                </div>
                                
                                <div class="dashb-calender-sect-month-day">
                                	
                                    Monday
                                    
                                </div>
                                
                            </div>
                        
                        </div>
                        
                        <div class="col-xs-2">
                        	
                            <div class="dashb-calender-sect-month-num">
                            	
                                0
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="pipa-bx dashb-calender-sect-dates">
                    	
                        <div class="col-xs-3">
                        	
                            <div class="dashb-calender-sect-dates-day">
                            	
                                15th
                                
                            </div>
                            
                        </div>
                        
                        <div class="col-xs-7">
                        
                        	<div class="dashb-calender-sect-month-cont">
                            	
                                <div class="dashb-calender-sect-month">
                                	
                                    December 2020
                                    
                                </div>
                                
                                <div class="dashb-calender-sect-month-day">
                                	
                                    Tuesday
                                    
                                </div>
                                
                            </div>
                        
                        </div>
                        
                        <div class="col-xs-2">
                        	
                            <div class="dashb-calender-sect-month-num">
                            	
                                2
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="pipa-bx dashb-calender-sect-dates">
                    	
                        <div class="col-xs-3">
                        	
                            <div class="dashb-calender-sect-dates-day">
                            	
                                16th
                                
                            </div>
                            
                        </div>
                        
                        <div class="col-xs-7">
                        
                        	<div class="dashb-calender-sect-month-cont">
                            	
                                <div class="dashb-calender-sect-month">
                                	
                                    December 2020
                                    
                                </div>
                                
                                <div class="dashb-calender-sect-month-day">
                                	
                                    Wednesday
                                    
                                </div>
                                
                            </div>
                        
                        </div>
                        
                        <div class="col-xs-2">
                        	
                            <div class="dashb-calender-sect-month-num">
                            	
                                5
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>-->
                
            </div>
            
        </div>
        
      </div>
      
      <div class="row">
      	
        <div class="col-xs-12 col-md-12 minimum-content-margin">
            
            <div class="col-xs-12 col-md-12">
            
                <div class="resp-table">
                    
                    <div class="resp-table-caption">
                    	
                        <div class="col-xs-12 col-md-12 no-pad-left">
                        	
                            <div class="col-xs-12 col-md-7 no-pad-left">
                            	
                                <div class="resp-table-caption-text">
                                	
                                    Programs
                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-xs-12 col-md-5">
                            	
                                <div class="col-xs-6 col-md-6 no-pad-left-mob">
                                	
                                    <div class="resp-table-caption-select-cont">
                                    	
                                        <p class="resp-table-caption-text" style="float:left; margin-right:20px;">Showing:</p> 
                                        
                                        <select class="bg-secondary-color text-sm paginate-select">
                                        
                                            <option value="1-10">1-10</option>
                                        
                                        </select>
                                            
                                    </div>
                                    
                                </div>
                                
                                <div class="col-xs-6 col-md-6 no-pad-left-mob">
                                	
                                    <div class="resp-table-caption-search">
                                    	
                                        <input type="text" placeholder="Search" class="search-input searchbx" />
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                        
                        </div>	
                        
                    </div>
                    
                    <div class="resp-table-header">
                        
                        <div class="table-header-cell">
                            
                           S/N
                            
                        </div>
                        
                        <div class="table-header-cell">
                            
                            Program Name
                            
                        </div>
                        
                        <div class="table-header-cell">
                        
                            Program Owner
                        
                        </div>
                        
                        <div class="table-header-cell">
                            
                            Number of Participants
                            
                        </div>
                        
                        <div class="table-header-cell">
                            
                            Grade Level of Participants
                            
                        </div>
                        
                        <div class="table-header-cell">
                            
                            Status
                            
                        </div>
                        
                        <div class="table-header-cell">
                            
                            
                        </div>

                    </div>
                    
                    <div class="resp-table-body">
                        
                        <?php
						
						if(!empty($programs))
						{
							$snCount				=	1;
							
							$tbl_rowtype			=	'resp-table-row-odd';
							
							foreach($programs as $programDetails)
							{
								
								if(empty($programDetails['program_status']))
								{										
									//means account has been disabled
									$status		=	'<span title="Account Disabled" class="btn btn-warning ">Pending</span>';
									
								}
								elseif($programDetails['program_status'] == '1')
								{
									
									//means account is active
									$status		=	'<span title="Active" class="btn bg-olive bg-positive"> Active </span>';
									
								}
													
							   echo '<div class="resp-table-row '.$tbl_rowtype.'">
									
									<div class="table-body-cell">
									
										'.$snCount.'.
									
									</div>
									
									<div class="table-body-cell">
									
										'.ucfirst($programDetails['program_name']).'
									
									</div>
									
									<div class="table-body-cell">';
										
										if(!empty($programDetails['program_owner_details']))
										{
											
											$ownerdetCount		=	0;	
											
											foreach($programDetails['program_owner_details'] as $owner_det)
											{
												
												if($ownerdetCount < 2)
												{
													
													echo '<div class="cell-colr-txt">'.ucfirst($owner_det['first_name']).' '.ucfirst($owner_det['last_name']).'</div>';
													
													$ownerdetCount++;
												
												}
											
											}
										
										}
										
										echo '</div>
									
									<div class="table-body-cell">
									
										'.sizeof($programDetails['program_participants']).'
									
									</div>
									
									<div class="table-body-cell">';
									
										if(!empty($programDetails['program_grade_levels']))
										{
											
											$grade_levels		=	'';
											
											foreach($programDetails['program_grade_levels'] as $grade)
											{
													
												$grade_levels	.=	' '.$grade['grade'].',';
												
											}
											
											
											echo rtrim($grade_levels, ',');
											
										}
									
									echo '</div>
									
									<div class="table-body-cell">
									
										'.$status.'
										
									</div>
									
									<div class="table-body-cell">
									
										<a class="btn btn-info" title="Edit/View Program Details" href="'.site_url('admin/create-program').'/'.$programDetails['program_id'].'/">
											<i class="fa fa-edit"></i> 
										</a>
										
										<span class="pull-right-container">
										  
										  <i class="fa fa-angle-down pull-right"></i>
										  
										</span>
										
									</div>
			
								</div>';
                        	
								$snCount++;
								
								if($tbl_rowtype == 'resp-table-row-odd')
								{
									
									$tbl_rowtype = 'resp-table-row-even';
									
								}else{
									
									$tbl_rowtype = 'resp-table-row-odd';
									
								}
								
							}
						
						}else{
							
							echo '<div class="resp-table-row">
							
								 <div class="table-body-cell">
                            
									No Record Found
								
								</div>
							
							</div>';	
						}
						
						?>

                    </div> 
                    
                    <div class="resp-table-footer">
                        
                        <div class="table-footer-cell">
                        
                           S/N
                        
                        </div>
                        
                        <div class="table-footer-cell">
                        
                            Program Name
                        
                        </div>
                        
                        <div class="table-footer-cell">
                        
                            Program Owner
                        
                        </div>
                        
                        <div class="table-footer-cell">
                        
                            Number of Participants
                        
                        </div>
                        
                        <div class="table-footer-cell">
                        
                            Grade Level of Participants
                        
                        </div>
                        
                        <div class="table-footer-cell">
                        
                             Status
                        
                        </div>
    
                    </div>
    
                </div>
            
            </div>
  
        </div>
        
      </div>
  
    </section>
    
  </div>  
  <!-- /.content-wrapper -->
