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
                        <a href="analyze" class="text-blue fixed-backnav">
                            <svg width="21" height="13" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 6.5H2M2 6.5L7.5 1M2 6.5L7.5 12" stroke="#0071F7" stroke-width="2"/>
                            </svg>
                        </a> 
                        <ul class="border-bottom nav nav-tabs">
                            <li class="active mr-3 pb-2"> 
                                <a data-toggle="tab" href="#analyze" class="text-md header-title border-0">Assessment</a>
                            </li>
                        </ul>                        
                        
                        <div style="margin-bottom: 10px;">
                            <a href="response-rate" class="btn blue-btn rounded-btn" style="margin-top: 1rem;">View Response Rate</a>
                        </div>
                    </section> 
                </div>
            </div> 

            <div class="row">
                <div class="col-md-12" style="padding: 0">
                    <div class="tab-content">

                        <div id="analyze" class="tab-pane fade in active">
                            
                            <div class="analyze-full-card">
                                <header class="border-bottom">
                                    <p class="text-primary card-title">Assessment Chart</p> 
                                    <div class="date-dropdown">
                                        <p class="card-date" style="margin-right: 1rem;">Survey dates</p>  
                                        <input type="text" id="surveydate-dropdown-360" class="bg-secondary-color text-md" />
                                    </div>
                                </header>
                                <section class="row">
                                    <div class="col-md-5 evaluator-wrapper">
                                        <div id="assessment_pie" class="w-100" style="height:400px;">
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
                                        <a href="evaluator" class="btn blue-btn rounded-btn" style="margin-top: 1rem;">View evaluator</a>
                                    </div>
                                    <div class="col-md-7">
                                        <div id="assessment_radar" class="w-100" style="height:400px;">
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
                                        <div class="program-dropdown">
                                            <p class="card-date" style="margin-right: 1rem;">Benchmark Survey</p>  
                                            <select class="bg-secondary-color text-md benchmark-program" id="benchmark-program">
                                                <?php if (empty($surveys)) { ?>
                                                    <option value="">Select Another Survey</option>                                                
                                                <?php
                                                    } else {?>                                    
                                                    <option value="">Select Another Survey</option>   
                                                    <?php
                                                        foreach ($surveys as $survey) {
                                                ?>
                                                    <option value="<?php echo $survey['program_id'] ?>"><?php echo $survey['survey'] ?></option>    
                                                <?php
                                                        } //end foreach
                                                    } //end else
                                                ?>                  
                                            </select> 
                                        </div> 
                                    </div>
                                </section>
                                
                            </div>
                            
                            <section class="row table-wrapper">
                                <div class="col-md-12">
                                    <header>
                                        <p class="text-primary table-title">All participants</p>                           
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
                                        <table class="table w-full" id="dt_allparticipant">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-left">Name</th>
                                                    <!-- <th scope="col">Role</th> -->
                                                    <th scope="col" class="text-left">Grade level</th>
                                                    <th scope="col" class="text-left">Location</th>
                                                    <th scope="col" class="text-center">Analyze</th>
                                                    <th scope="col" class="text-center">Compare</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <?php if (empty($all_participants)) { ?>
                                                
                                                <?php
                                                    } else {
                                                        foreach ($all_participants as $participant) {
                                                ?>
                                                            <tr>                                               
                                                                <td class="text-left">
                                                                    <?php echo $participant['first_name'] . ' ' . $participant['last_name'] ?>
                                                                </td>
                                                                <td class="text-left">
                                                                    <?php echo $participant['grade'] ?>
                                                                </td>
                                                                <td class="text-left">
                                                                    <?php echo $participant['location'] ?>
                                                                </td>													
                                                                <td class="text-center"> 
                                                                    <a href="analyze_participant/<?php echo $participant['survey_participant_id'] ?>" class="btn blue-btn border text-white rounded-btn mr-3 px-4"
                                                                        style="width: inherit !important">
                                                                    Analyze participant</a> 
                                                                </td>
                                                                <td class="text-center">  
                                                                    <?php echo '<button data-number="'.$participant['survey_participant_id'].'" 
                                                                            data-name="'.$participant['first_name'].' '.$participant['last_name'].'" 
                                                                            class="btn btn-default border rounded-btn outline compare-btn" style="width: inherit !important">
                                                                        Select participant
                                                                    </button>';
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                <?php
                                                        } //end foreach
                                                    } //end else
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                                  
                                    <a href="compare_participants" class="btn blue-btn rounded-btn goto-compare-btn hide">Goto Compare</a>

                                </div>
                            </section>

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
