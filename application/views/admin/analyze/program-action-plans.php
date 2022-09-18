<div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">     
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="tab-page--container">

            <div class="row">
                <div class="col-md-12 analyze-header-wrapper">
                    <section class="analyze-header-tab">
                        <!-- <a href="assessment_360" class="text-blue fixed-backnav"> 
                            <svg width="21" height="13" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 6.5H2M2 6.5L7.5 1M2 6.5L7.5 12" stroke="#0071F7" stroke-width="2"/>
                            </svg>
                        </a>  -->
                        <ul class="border-bottom nav nav-tabs">
                            <li class="mr-3 pb-2"> 
                                <a data-toggle="tab" href="#engagement" class="text-md header-title border-0">Engagement surveys</a>
                            </li>
                            <li class="active mr-3 pb-2"> 
                                <a data-toggle="tab" href="#action_plans" class="text-md header-title border-0">Action plans</a>
                            </li>
                        </ul>               
                    </section> 
                </div>
            </div> 

            <div class="row">
                <div class="col-md-12" style="padding: 0">
                    <div class="tab-content">

                        <div id="engagement" class="tab-pane fade">

                        </div> 

                        <div id="action_plans" class="tab-pane fade in active">
                            
                            <section class="row table-wrapper">
                                <div class="col-md-12">
                                    <header>
                                        <p class="text-primary table-title" id="total_plans">
                                        <?php echo count($action_plans) ?> action plan(s)
                                        </p> 
                                        <div class="date-dropdown">
                                            <p class="card-date" style="margin-right: 1rem;">Showing:</p> 
                                            <select class="bg-secondary-color table text-sm paginate-select" style="margin-right: 1rem;">
                                                <option value="1-10">1-10</option>
                                            </select>
                                            <div style="position:relative;">
                                                <input type="text" placeholder="Search" class="search-input" />
                                                <svg class="input-icon" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14.2617 13.6626L10.6916 9.94962C11.6096 8.85844 12.1125 7.48552 12.1125 6.05624C12.1125 2.71688 9.3956 0 6.05624 0C2.71688 0 0 2.71688 0 6.05624C0 9.3956 2.71688 12.1125 6.05624 12.1125C7.30989 12.1125 8.50455 11.7344 9.52594 11.0166L13.1231 14.7578C13.2734 14.9139 13.4757 15 13.6924 15C13.8975 15 14.0921 14.9218 14.2398 14.7796C14.5537 14.4776 14.5637 13.9768 14.2617 13.6626ZM6.05624 1.57989C8.52456 1.57989 10.5326 3.58793 10.5326 6.05624C10.5326 8.52456 8.52456 10.5326 6.05624 10.5326C3.58793 10.5326 1.57989 8.52456 1.57989 6.05624C1.57989 3.58793 3.58793 1.57989 6.05624 1.57989Z" fill="#8FB7E7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </header>

                                    <div class="table-responsive">
                                        <table class="table display nowrap" id="dt_action_plans" style="width:100%">
                                            <thead>
                                                <tr class="dark-text">
                                                    <th scope="col"><b>S/N</b></th>
                                                    <th scope="col"><b>Specific Actions</b></th>
                                                    <th scope="col"><b>Enforcer</b></th>
                                                    <th scope="col"><b>Resources</b></th>
                                                    <th scope="col"><b>Status</b></th>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $count = 0;
                                            if (empty($action_plans)) { ?> 

                                            </tr>
                                                <?php
                                                    } else {
                                                        foreach ($action_plans as $action_plan) {
                                                ?>
                                                            <tr>                                               
                                                                <td class="text-left">
                                                                    <?php echo ++$count ?>
                                                                </td>
                                                                <td class="text-left">                                                                    
                                                                    <span class=""><?php echo $action_plan['specific_plans'] ?></span>                 
                                                                    <div class="hide more-info">
                                                                        <p><b>Desired outcome</b></p>
                                                                        <span><?php echo $action_plan['desired_outcome'] ?></span>
                                                                    </div>   
                                                                </td>
                                                                <td class="text-left">
                                                                    <?php echo $action_plan['first_name'] . ' ' . $action_plan['last_name'] ?>
                                                                </td>                                                                
                                                                <td class="text-left"> 
                                                                    <span class=""><?php echo $action_plan['resources_needed'] ?></span> 
                                                                    <div class="hide more-info">
                                                                        <p><b>Start date</b></p>
                                                                        <span><?php echo date('F d Y', strtotime($action_plan['start_date'])) ?></span>
                                                                    </div>                                     
                                                                </td>
                                                                <td class="text-left">
                                                                    <select class="table text-sm drop-status <?php 
                                                                        switch($action_plan['status']){ case 'Not Started': echo 'blue'; break; case 'Started': echo 'orange'; break; case 'Completed': echo 'green'; break; }?>" 
                                                                    style="margin-right: 1rem;" 
                                                                    data-startdate="<?php echo date('F d Y', strtotime($action_plan['start_date'])) ?>" 
                                                                    data-enddate="<?php echo date('F d Y', strtotime($action_plan['deadline_date'])) ?>"
                                                                    data-actionplanid="<?php echo $action_plan['action_plan_id'] ?>">
                                                                        <option value="Not Started" <?php if($action_plan['status'] == 'Not Started') echo 'selected' ?>>Not Started</option>
                                                                        <option value="Started" <?php if($action_plan['status'] == 'Started') echo 'selected' ?>>Started</option>
                                                                        <option value="Completed" <?php if($action_plan['status'] == 'Completed') echo 'selected' ?>>Completed</option>
                                                                    </select> 
                                                                    <div class="hide more-info">
                                                                        <p><b>Due date</b></p>
                                                                        <span><?php echo date('F d Y', strtotime($action_plan['deadline_date'])) ?></span>
                                                                    </div>                                     
                                                                </td>	
                                                                <td>    
                                                                    <a href="<?php echo base_url().'admin/action_plan/'. $action_plan['program_id'] .'/'. $action_plan['action_plan_id'] ?>" 
                                                                        role="button" aria-expanded="false" aria-controls="tr1"
                                                                        class="collapsed table-accordion">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>    
                                                                </td> 
                                                                <td>
                                                                    <span data-toggle="collapse" href="#tr${index}" role="button" aria-expanded="false" aria-controls="tr1"
                                                                        class="collapsed table-accordion">
                                                                        <svg class="arrow-down"
                                                                            width="14" height="9" viewBox="0 0 14 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M0.5 1.25L7 7.75L13.5 1.25" stroke="#7E9EC2"/>
                                                                        </svg>
                                                                        <svg class="arrow-right"
                                                                            width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M0.75 14L7.25 7.5L0.75 1" stroke="#7E9EC2"/>
                                                                        </svg>
                                                                    </span>
                                                                </td> 
                                                            </tr>
                                                <?php
                                                        } //end foreach
                                                    } //end else
                                                ?>
                                            </tbody>
                                        </table> 
                                    </div>
<!-- 
                                    <div class="card-skeleton">
                                        <div class="animated-background"> 
                                            <div class="card-skeleton-img"></div>
                                            <div class="skel-mask-container">
                                            <div class="skel-mask skel-mask-1"></div>
                                            <div class="skel-mask skel-mask-2"></div>
                                            <div class="skel-mask skel-mask-3"></div>
                                            <div class="skel-mask skel-mask-4"></div>
                                            <div class="skel-mask skel-mask-5"></div>
                                            <div class="skel-mask skel-mask-6"></div>
                                            </div>
                                        </div>
                                    </div> -->

                                </div>
                            </section> 

                        </div>

                        

                    </div> 
                </div>
            </div>

        </div> 

    </section>
</div>

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>

<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>

<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="<?php echo base_url() ?>asset/admin_asset/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>asset/admin_asset/js/dataTables.bootstrap4.min.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/handlebars.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.4/xlsx.core.min.js"></script>
<script src="<?php echo base_url() ?>asset/admin_asset/excel/FileSaver.js"></script>
<script src="<?php echo base_url() ?>asset/admin_asset/excel/jhxlsx.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/analyze.js"></script>