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
                        <a href="<?php echo base_url() ?>admin/assessment_360" class="text-blue fixed-backnav"> 
                            <svg width="21" height="13" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 6.5H2M2 6.5L7.5 1M2 6.5L7.5 12" stroke="#0071F7" stroke-width="2"/>
                            </svg>
                        </a> 
                        <ul class="border-bottom nav nav-tabs">
                            <li class="active mr-3 pb-2"> 
                                <a data-toggle="tab" href="#analyze" class="text-md header-title border-0">Survey Benchmark</a>
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
                                <header class="border-bottom">
                                    <p class="text-primary card-title">Assessment Chart</p> 
                                    <!-- <div class="date-dropdown">
                                        <p class="card-date" style="margin-right: 1rem;">Survey dates</p>    
                                        <input type="text" id="surveydate-dropdown" class="bg-secondary-color text-md" />
                                    </div> -->
                                </header>
                                <section class="row">
                                    <div class="col-md-4 overall-wrapper compare_surveyors_cont"> 
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
                                        <script id="compare_surveyors_cont" type="text/x-handlebars-template">
                                            <ul class="overall-detail list-unstyled">
                                                <li>Current survey: <br><span class="participant_title">{{ current_survey.survey }}</span>
                                                <br><span class="participant_title">{{formatDate current_survey.survey_start_date }} - {{formatDate current_survey.survey_end_date }}</span>
                                                </li>
                                                <li>Past survey: <br><span id="participant_grade">{{ past_survey.survey }}</span>
                                                <br><span class="participant_grade">{{formatDate past_survey.survey_start_date }} - {{formatDate past_survey.survey_end_date }}</span>
                                                </li>  
                                                <li class="ball-content">
                                                    <span class="balls blue"></span>
                                                    <span class="balls-label">Average from current survey</span>
                                                </li>
                                                <li class="ball-content">
                                                    <span class="balls green"></span>
                                                    <span class="balls-label">Average of top participant from current survey</span>
                                                </li>
                                                <li class="ball-content">
                                                    <span class="balls pink"></span>
                                                    <span class="balls-label">Average from past survey</span>
                                                </li>
                                                <li class="ball-content">
                                                    <span class="balls yellow"></span>
                                                    <span class="balls-label">Average of top participant from past survey</span>
                                                </li>
                                                <li class="ball-content">
                                                    <span class="balls black"></span>
                                                    <span class="balls-label">Industry average</span>
                                                </li>
                                            </ul>
                                            <!-- <h3 class="overall-rating">Overall Rating: <span class="total_sresponse">{{total_response}}</span> out of <span class="no_of_surveyors">{{total_sureyors}}</span></h3> -->
                                        </script>
                                    </div>
                                    <div class="col-md-8">

                                        <div id="multiple_benchmark_radar" class="w-100" style="height:500px;">
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
                            
                            <div class="analyze-full-card competency_responses" id="competency_responses_cont" style="margin-top: 2rem;">
                                <script id="competency_responses" type="text/x-handlebars-template">
                                    <header class="border-bottom">
                                        <p class="text-primary card-title">Competency summary ({{ competency_summary.length }})</p>  
                                    </header> 
                                    {{#if competency_summary.length}}
                                        {{#competency_summary}}
                                        <section class="row"> 
                                            <header class="competency-response-header">
                                                <div class="title-wrapper">
                                                    <h2>{{ title }}</h2>
                                                    <!-- <a data-toggle="collapse" href="#competency_{{survey_competency_id}}" role="button" aria-expanded="false" aria-controls="communication"
                                                        class="collapsed view_questions_response" data-comid="{{survey_competency_id}}">
                                                        View questions
                                                        <svg class="arrow-down" width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1 1.5L6 6.5L11 1.5" stroke="#7E9EC2" stroke-width="2"/>
                                                        </svg>
                                                        <svg width="12" class="arrow-up" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1 6.5L6 1.5L11 6.5" stroke="#0071F7" stroke-width="2"/>
                                                        </svg>
                                                    </a>  -->
                                                </div>
                                                <div class="progress-wrapper">
                                                    <ul class="list-unstyled">
                                                        <li class="score-line">
                                                            <p class="score-title">Current Survey</p>
                                                            <div class="score-bar-wrapper">
                                                                <div class="score-bar blue-bar" style="width: {{ toPercentage p_current.percent }};"></div>
                                                            </div>
                                                        </li> 
                                                        <li class="score-line">
                                                            <p class="score-title">Top Current Participants</p>
                                                            <div class="score-bar-wrapper">
                                                                <div class="score-bar green-bar" style="width: {{ toPercentage p_current_participant.percent }};"></div>
                                                            </div>
                                                        </li> 
                                                        <li class="score-line">
                                                            <p class="score-title">Past Survey</p>
                                                            <div class="score-bar-wrapper">
                                                                <div class="score-bar pink-bar" style="width: {{ toPercentage p_past.percent }};"></div>
                                                            </div>
                                                        </li> 
                                                        <li class="score-line">
                                                            <p class="score-title">Top Past Participant</p>
                                                            <div class="score-bar-wrapper">
                                                                <div class="score-bar yellow-bar" style="width: {{ toPercentage p_past_participant.percent }};"></div>
                                                            </div>
                                                        </li>  
                                                        <li class="score-line">
                                                            <p class="score-title">Industry Average</p>
                                                            <div class="score-bar-wrapper">
                                                                <div class="score-bar black-bar" style="width: {{ toPercentage p_industry.percent }};"></div>
                                                            </div>
                                                        </li>  
                                                        <li class="score-line">
                                                            <p class=""></p>
                                                            <ul class="list-unstyled score-x-value">
                                                                <li>0</li>
                                                                <li>1</li>
                                                                <li>2</li>
                                                                <li>3</li>
                                                                <li>4</li>
                                                                <li>5</li>
                                                            </ul>
                                                        </li>  
                                                    </ul>
                                                </div>
                                                <div class="table-list-wrapper">
                                                    <div class="title-row">
                                                        <span>AVG</span>
                                                        <span>HI</span>
                                                        <span>LO</span>
                                                    </div> 
                                                    <div class="value-row">
                                                        <span>{{p_current.avg}}</span>
                                                        <span>{{p_current.high}}</span>
                                                        <span>{{p_current.low}}</span>
                                                    </div> 
                                                    <div class="value-row">
                                                        <span>{{p_current_participant.avg}}</span>
                                                        <span>{{p_current_participant.high}}</span>
                                                        <span>{{p_current_participant.low}}</span>
                                                    </div> 
                                                    <div class="value-row">
                                                        <span>{{p_past.avg}}</span>
                                                        <span>{{p_past.high}}</span>
                                                        <span>{{p_past.low}}</span>
                                                    </div> 
                                                    <div class="value-row">
                                                        <span>{{p_past_participant.avg}}</span>
                                                        <span>{{p_past_participant.high}}</span>
                                                        <span>{{p_past_participant.low}}</span>
                                                    </div> 
                                                    <div class="value-row">
                                                        <span>{{p_industry.avg}}</span>
                                                        <span>{{p_industry.high}}</span>
                                                        <span>{{p_industry.low}}</span>
                                                    </div> 
                                                </div>
                                            </header>
                                            <div class="collapse competency-response competency-response-detail" id="competency_{{survey_competency_id}}">
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
                                        </section>
                                        {{/competency_summary}}
                                    {{/if}}
                                </script> 
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

<script src="<?php echo base_url() ?>asset/admin_asset/js/handlebars.min.js"></script>
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/analyze.js"></script>
