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
                        <a href="assessment-360" class="text-blue fixed-backnav">
                            <svg width="21" height="13" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 6.5H2M2 6.5L7.5 1M2 6.5L7.5 12" stroke="#0071F7" stroke-width="2"/>
                            </svg>
                        </a> 
                        <ul class="border-bottom nav nav-tabs">
                            <li class="active mr-3 pb-2"> 
                                <a data-toggle="tab" href="#analyze" class="text-md header-title border-0">Response Rate</a>
                            </li>
                        </ul>        
                    </section> 
                </div>
            </div> 

            <div class="row">
                <div class="col-md-12" style="padding: 0">
                    <div class="tab-content">

                        <div id="analyze" class="tab-pane fade in active">
                            
                            <div class="analyze-full-card">

                                <header class="border-top" style="margin-top: 30px; padding-top: 10px;">
                                    <p class="text-primary card-title">Response Rate</p> 
                                    <div class="date-dropdown">
                                        <p class="card-date" style="margin-right: 1rem; min-width: 0;">Filter</p>  
                                        <select class="bg-secondary-color text-md program-select" id="response-filter">
                                            <option value="company">Company</option> 
                                            <option value="department" selected>Department</option>  
                                            <option value="grade">Grade</option>  
                                            <option value="location">Location</option>               
                                        </select>
                                    </div>
                                </header>
                                
                                <section class="row">
                                    <div class="col-md-5 evaluator-wrapper">
                                        <div id="response_rate_pie" class="w-100" style="min-height: calc(100vh);">
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div id="response_rate_barline" class="w-100" style="min-height: calc(100vh);">
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
                                            </div>
                                        </div>  
                                    </div>
                                </section>
                            </div>

                        </div>

                        <div id="option" class="tab-pane fade">

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
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/analyze.js"></script>
