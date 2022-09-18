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
                                <a data-toggle="tab" href="#analyze" class="text-md header-title border-0">Compare Participants</a>
                            </li>
                        </ul>                       
                                              
                        <a href="<?php echo base_url() .'admin/action_plan/'. $program_id ?>" class="btn button" style="background: var(--btn-blue-color);">
                            Create action plan
                        </a>
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
                                        <input type="text" id="surveydate-dropdown" class="bg-secondary-color text-md" />
                                    </div>
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
                                                <!-- <li>Leader name: <span class="participant_title"></span></li>
                                                <li>Role: <span id="participant_grade"></span></li> -->
                                                <li>No of surveyors: <span class="no_of_surveyors">{{total_sureyors}}</span></li>
                                                <li> 
                                                    <span class="balls-label">Participant (<span>Total responded / Total surveyors</span>)</span>
                                                </li>
                                                {{#if participants.length}}
                                                    {{#participants}}
                                                    <li class="ball-content">
                                                        <span class="balls {{getColorIndex index}}"></span>
                                                        <span class="balls-label">{{participant_name}} (<span>{{total_response}} / {{total_surveyors}}</span>)</span>
                                                    </li>
                                                    {{/participants}}
                                                {{else}}                                                
                                                    <li class="ball-content"> 
                                                        <span class="balls-label">No participant found</span>
                                                    </li>
                                                {{/if}}
                                            </ul>
                                            <h3 class="overall-rating">Overall Rating: <span class="total_sresponse">{{total_response}}</span> out of <span class="no_of_surveyors">{{total_sureyors}}</span></h3>
                                        </script>
                                    </div>
                                    <div class="col-md-8">

                                        <div id="multiple_compare_radar" class="w-100" style="height:400px;">
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
                                        <!-- <button class="btn button section-navigation-btn" style="background: var(--btn-blue-color);" data-href="#openended_cont">
                                            View open ended responses
                                        </button> -->
                                    </header> 
                                    {{#if competency_summary.length}}
                                        {{#competency_summary}}
                                        <section class="row"> 
                                            <header class="competency-response-header">
                                                <div class="title-wrapper">
                                                    <h2>{{ title }}</h2>
                                                    <a data-toggle="collapse" href="#competency_{{survey_competency_id}}" role="button" aria-expanded="false" aria-controls="communication"
                                                        class="collapsed view_questions_response" data-comid="{{survey_competency_id}}">
                                                        View questions
                                                        <svg class="arrow-down" width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1 1.5L6 6.5L11 1.5" stroke="#7E9EC2" stroke-width="2"/>
                                                        </svg>
                                                        <svg width="12" class="arrow-up" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1 6.5L6 1.5L11 6.5" stroke="#0071F7" stroke-width="2"/>
                                                        </svg>
                                                    </a> 
                                                </div>
                                                <div class="progress-wrapper">
                                                    {{#if participants}}
                                                        <ul class="list-unstyled">
                                                            {{#participants}}
                                                            <li class="score-line">
                                                                <p class="score-title">{{participant_name}}</p>
                                                                <div class="score-bar-wrapper">
                                                                    <div class="score-bar {{getColorIndex @index}}-bar" style="width: {{ toPercentage percent }};"></div>
                                                                </div>
                                                            </li>  
                                                            {{/participants}}   
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
                                                    {{/if}}
                                                </div>
                                                <div class="table-list-wrapper">
                                                    <div class="title-row">
                                                        <span>AVG</span>
                                                        <span>HI</span>
                                                        <span>LO</span>
                                                    </div> 
                                                    {{#if participants}}
                                                        {{#participants}}
                                                        <div class="value-row">
                                                            <span>{{avg}}</span>
                                                            <span>{{high}}</span>
                                                            <span>{{low}}</span>
                                                        </div> 
                                                        {{/participants}}
                                                    {{/if}}
                                                    <div class="value-row">
                                                        <span>{{manager.avg}}</span>
                                                        <span>{{manager.high}}</span>
                                                        <span>{{manager.low}}</span>
                                                    </div> 
                                                    <div class="value-row">
                                                        <span>{{peers.avg}}</span>
                                                        <span>{{peers.high}}</span>
                                                        <span>{{peers.low}}</span>
                                                    </div> 
                                                    <div class="value-row">
                                                        <span>{{direct_report.avg}}</span>
                                                        <span>{{direct_report.high}}</span>
                                                        <span>{{direct_report.low}}</span>
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

                            <div class="analyze-full-card openended_responses hide" id="openended_cont" style="margin-top: 2rem;">
                                <script id="openended_responses" type="text/x-handlebars-template">
                                    <header class="border-bottom">
                                        <p class="text-primary card-title">Open-ended Response</p>                                                         
                                        <button class="btn button section-navigation-btn" style="background: var(--btn-blue-color);"
                                            data-href="#competency_responses_cont">
                                            View competencies summary
                                        </button>
                                    </header>
                                    <!-- generate questions below -->
                                    {{#if open_ended.length}}
                                    {{#open_ended}}
                                    <section class="row"> 
                                        <header class="competency-openended-header">
                                            <div class="title-wrapper open-ended">
                                                <h2>Q{{inc @index}}: {{title}}?</h2>
                                                <a data-toggle="collapse" href="#q{{question_id}}" role="button" aria-expanded="false" aria-controls="q1"
                                                    class="collapsed">
                                                    View questions
                                                    <svg class="arrow-down" width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 1.5L6 6.5L11 1.5" stroke="#7E9EC2" stroke-width="2"/>
                                                    </svg>
                                                    <svg width="12" class="arrow-up" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M1 6.5L6 1.5L11 6.5" stroke="#0071F7" stroke-width="2"/>
                                                    </svg>
                                                </a> 
                                            </div> 
                                        </header>
                                        <div class="collapse competency-response" id="q{{question_id}}">
                                            {{#if responses.length }}
                                                {{#responses}}
                                                <div class="question-response-detail open-ended">
                                                    <b>{{relationship}} {{relationship_index}}:</b>
                                                    <div class="question-desc">
                                                        <p> 
                                                            <span>{{response}}</span>
                                                        </p>
                                                        <!-- <button class="btn button" style="background: var(--btn-blue-color);"
                                                            data-relationship="{{relationship}}" data-surveyor="{{surveyor_id}}">
                                                            Request anonymous feedback
                                                        </button> -->
                                                    </div>                                        
                                                </div> 
                                                {{/responses}}
                                            {{else}}
                                                <div class="question-response-detail open-ended">
                                                    <p>No response provided yet</p>                                     
                                                </div> 
                                            {{/if}}
                                        </div> 
                                    </section> 
                                    {{/open_ended}}
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

<script id="competency_questions_responses" type="text/x-handlebars-template">
    {{#if questions.length }}
        {{#each questions}}
        <div class="question-response-detail">
            <b>Question {{inc @index}}:</b>
            <div class="question-desc">
                <p> 
                    <span>{{ title }}</span>
                </p>
            </div>                                            
            <div class="progress-wrapper">
            {{#if participants}}
                <ul class="list-unstyled">
                    {{#participants}}
                    <li class="score-line">
                        <p class="score-title">{{participant_name}}</p>
                        <div class="score-bar-wrapper">
                            <div class="score-bar {{getColorIndex @index}}-bar" style="width: {{ toPercentage percent }};"></div>
                        </div>
                    </li>  
                    {{/participants}}   
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
            {{/if}} 
            </div>                                        
        </div>
        {{/each}}
    {{/if}} 
</script> 

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>

<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>

<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/handlebars.min.js"></script>
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/analyze.js"></script>
