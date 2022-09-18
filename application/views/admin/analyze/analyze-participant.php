<div class="content-wrapper">
    
    <style>
    .pdf-cover {
        background-image: url(<?php echo base_url() ?>asset/admin_asset/images/pmf/mtn-naama.png); background-origin: border-box; background-size: cover;
    }
    </style>

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
                                <a data-toggle="tab" href="#analyze" class="text-md header-title border-0">Analyze <span class="participant_title"></span></a>
                            </li>
                            <li class="mr-3 pb-2" id="fetchpmf"> 
                                <a data-toggle="tab" href="#pmf" class="text-md header-title border-0">PMF Report</a>
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
                                    <div class="col-md-4 overall-wrapper">
                                        <ul class="overall-detail list-unstyled">
                                            <li>Leader name: <span class="participant_title"></span></li>
                                            <li>Role: <span id="participant_grade"></span></li>
                                            <li>No of surveyors: <span class="no_of_surveyors"></span></li>
                                            <li class="ball-content self">
                                                <span class="balls"></span>
                                                <span class="balls-label">Self (<span id="no_of_self"></span>)</span>
                                            </li>
                                            <li class="ball-content manager">
                                                <span class="balls"></span> 
                                                <span class="balls-label">Manager (<span id="no_of_manager"></span>)</span>
                                            </li>
                                            <li class="ball-content peers" id="use_peer">
                                                <span class="balls"></span>
                                                <span class="balls-label">Peers (<span id="no_of_peers"></span>)</span>
                                            </li>
                                            <li class="ball-content direct_report" id="use_direct_report">
                                                <span class="balls"></span>
                                                <span class="balls-label">Direct reports (<span id="no_of_dreport"></span>)</span>
                                            </li>
                                        </ul>
                                        <h3 class="overall-rating">Overall Rating: <span class="total_sresponse"></span> out of <span class="no_of_surveyors"></span></h3>
                                    </div>
                                    <div class="col-md-8">

                                        <div id="multiple_radar" class="w-100" style="height:400px;">
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
                                        <button class="btn button section-navigation-btn" style="background: var(--btn-blue-color);" data-href="#openended_cont">
                                            View open ended responses
                                        </button>
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
                                                    {{#if evaluator_categories}}
                                                        <ul class="list-unstyled">
                                                            {{#evaluator_categories}}
                                                            <li class="score-line">
                                                                <p class="score-title">{{label}}</p>
                                                                <div class="score-bar-wrapper">
                                                                    <div class="score-bar" style="width: {{ toPercentage percent }}; background-color: {{getColor actual_label}}"></div>
                                                                </div>
                                                            </li>  
                                                            {{/evaluator_categories}}   
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
                                                    {{#if evaluator_categories}}
                                                        {{#evaluator_categories}}
                                                        <div class="value-row">
                                                            <span>{{avg}}</span>
                                                            <span>{{high}}</span>
                                                            <span>{{low}}</span>
                                                        </div> 
                                                        {{/evaluator_categories}}
                                                    {{/if}}
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

                            <div class="analyze-full-card openended_responses" id="openended_cont" style="margin-top: 2rem;">
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
                                                <h2>Q{{inc @index}}: {{title}}</h2>
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
                                                    {{#useSettingName relationship}}
                                                    <div class="question-response-detail open-ended">
                                                        <b>{{getSettingName relationship}} <!--{{relationship_index}} -->:</b>
                                                        <div class="question-desc">
                                                            <p> 
                                                                <span>{{response}}</span>
                                                            </p>
                                                            {{#notLineManager relationship}}
                                                                
                                                                {{#notSelf relationship}}

                                                                    {{#if response_feedback}}
                                                                        <button class="btn button view-feedback load-button" style="background: green; border: green;"
                                                                            data-relationship="{{relationship}}" 
                                                                            data-surveyor="{{surveyor_id}}" 
                                                                            data-email="{{email}}" 
                                                                            data-name="{{name}}" 
                                                                            data-qid="{{survey_question_id}}" 
                                                                            data-question="{{../title}}"
                                                                            data-response="{{response}}"
                                                                            data-feedback="{{response_feedback}}"
                                                                            data-participant="{{survey_participant_id}}">
                                                                            <span>View Feedback</span>
                                                                            <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                width="20px" height="20px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                                                                                <path fill="#000" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                                                                                <animateTransform attributeType="xml"
                                                                                    attributeName="transform"
                                                                                    type="rotate"
                                                                                    from="0 25 25"
                                                                                    to="360 25 25"
                                                                                    dur="0.6s"
                                                                                    repeatCount="indefinite"/>
                                                                                </path>
                                                                            </svg>                                                                
                                                                        </button>
                                                                    {{else}}
                                                                        <button class="btn button request-feedback load-button" style="background: var(--btn-blue-color);"
                                                                            data-relationship="{{relationship}}" 
                                                                            data-surveyor="{{surveyor_id}}" 
                                                                            data-email="{{email}}" 
                                                                            data-name="{{name}}" 
                                                                            data-qid="{{survey_question_id}}" 
                                                                            data-question="{{../title}}"
                                                                            data-response="{{response}}"
                                                                            data-participant="{{survey_participant_id}}">
                                                                            <span>Request anonymous feedback</span>
                                                                            <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                width="20px" height="20px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                                                                                <path fill="#000" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                                                                                <animateTransform attributeType="xml"
                                                                                    attributeName="transform"
                                                                                    type="rotate"
                                                                                    from="0 25 25"
                                                                                    to="360 25 25"
                                                                                    dur="0.6s"
                                                                                    repeatCount="indefinite"/>
                                                                                </path>
                                                                            </svg>                                                                
                                                                        </button>
                                                                    {{/if}}
                                                                {{/notSelf}}

                                                            {{else}}
                                                            <button class="btn button request-feedback load-button" style="background: var(--btn-blue-color);"
                                                                data-relationship="{{relationship}}" 
                                                                data-surveyor="{{surveyor_id}}" 
                                                                data-email="{{email}}" 
                                                                data-name="{{name}}" 
                                                                data-qid="{{survey_question_id}}" 
                                                                data-question="{{../title}}"
                                                                data-response="{{response}}"
                                                                data-participant="{{survey_participant_id}}">                                                                
                                                                <span>Request feedback</span>
                                                                <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                    width="20px" height="20px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                                                                    <path fill="#000" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                                                                    <animateTransform attributeType="xml"
                                                                        attributeName="transform"
                                                                        type="rotate"
                                                                        from="0 25 25"
                                                                        to="360 25 25"
                                                                        dur="0.6s"
                                                                        repeatCount="indefinite"/>
                                                                    </path>
                                                                </svg>    
                                                            </button>
                                                            {{/notLineManager}}
                                                        </div>                                        
                                                    </div> 
                                                    {{/useSettingName}}
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

                        <div id="pmf" class="tab-pane fade">

                            <button href="#" class="btn button" id="download-report" disabled style="background: var(--btn-blue-color);">
                                Download
                            </button>
                            
                            <div class="analyze-full-card pdf pdf-cover" style=""> 
                                <img src="<?php echo base_url() ?>asset/admin_asset/images/pmf/mtn-naama.png" alt="mtn logo" class="pdf-image-logo">
                                <!-- <span class="dot dot-1"></span>
                                <span class="dot dot-2"></span>
                                <span class="dot dot-3"></span>
                                <span class="dot dot-4"></span>
                                <span class="dot dot-5"></span>
                                <span class="dot dot-6"></span> -->
                                <div class="description">
                                    <!-- <h1>naama</h1> -->
                                    <h4>180<sup>o</sup> ASSESSMENT REPORT</h4>
                                    <div style="display: flex;">
                                        <img src="<?php echo base_url() ?>asset/admin_asset/images/pmf/mtn-logo.png" alt="mtn logo" style="margin-right: 10px;">
                                        <div>
                                            <p>Generated for <span class="pmf-participant"><?php echo $participant['first_name'] . ' ' . $participant['last_name']; ?></span></p>
                                            <p>Printed on <span class="date-printed"></span></p>
                                        </div>
                                    </div>
                                </div>  
                            </div>

                            <div class="analyze-full-card pdf page-1">
                            
                                <header class="border-bottom">
                                    <p class="text-primary pdf-title">Understanding your Report</p> 
                                </header>
    
                                <p class="pdf-paragraph">This report was generated using information from your self evaluation as well as from your Line Manager, and Team Members.</p>
    
                                <p class="pdf-paragraph">The report is to aid your
                                development by providing you with multiple perspectives and highlighting your
                                strengths and possible areas for development.</p>
    
                                <p class="pdf-paragraph">The report is divided into 6 main sections:</p>
    
                                <ul class="pdf-list">
                                    <li>
                                        <div>
                                            <h6>1</h6>
                                            <p>An overview, highlighting your average scores across all competencies</p>
                                            <h6></h6>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <h6>2</h6>
                                            <p>A detailed analysis of individual competencies comparing your self-perception with feedback from your evaluators</p>
                                            <h6></h6>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <h6>3</h6>
                                            <p>Recommendations that you may consider to address developmental needs as highlighted in the report</p>
                                            <h6></h6>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <h6>4</h6>
                                            <p>A detailed summary of your evaluations in the context of the MTN People Management Framework</p>
                                            <h6></h6>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <h6>5</h6>
                                            <p>Responses from your evaluators to the open-ended questions</p>
                                            <h6></h6>
                                        </div>
                                    </li>
                                    <li>
                                        <div>
                                            <h6>6</h6>
                                            <p>An action planning template where you can translate all the insights gained from this assessment into actionable items</p>
                                            <h6></h6>
                                        </div>
                                    </li>
                                </ul>
    
                            </div>

                            <div class="analyze-full-card pdf page-2"> 

                                <header class="border-bottom">
                                    <p class="text-primary pdf-title">Understanding your Evaluators</p> 
                                </header>
    
                                <p class="pdf-paragraph">In addition to your self evaluation, we also invited your Line Manager as well as
                                your Team Members to evaluate you and provide you with feedback.
                                Below is an indication of the number of your evaluators and their colour
                                representation in this report.</p>
    
                                <table class="pdf-evaluator-table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Invited</th>
                                            <th>Responded</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="pmf_evaluator_body">
                                        <script id="pmf_evaluator_rows" type="text/x-handlebars-template">
                                            {{#each evaluators}}
                                            <tr>
                                                <td><span>{{label}}</span></td>
                                                <td><span>{{total_invited}}</span></td>
                                                <td><span>{{total_responded}}</span></td>
                                                <td><div class="score-bar" style="width: 100% !important; background-color: {{color}} !important;"></div></td>
                                            </tr>
                                            {{/each}}
                                        </script>
                                    </tbody>
                                </table>
    
                                <header class="border-bottom" style="margin-top: 4rem;">
                                    <p class="text-primary pdf-title">Understanding the Scoring System</p> 
                                </header>
    
                                <p class="pdf-paragraph">The questions in this assessment were all positive inclined and all evaluators
                                were asked to provide you with feedback using a 5-point scale - with 1 being
                                the least desirable option and 5 being the most desirable option.</p>
    
                                <p class="pdf-paragraph">The chart below shows the scale and weighting used for the assessment.</p>
    
                                <table class="pdf-scoring-table">
                                    <thead>
                                        <tr>
                                            <th>Score</th>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th> 
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <tr>
                                            <td>Frequency</td>
                                            <td>Never</td>
                                            <td>Seldom</td>
                                            <td>Sometimes</td>
                                            <td>Often</td>
                                            <td>Always</td> 
                                        </tr>
                                        <tr>
                                            <td>Ability</td>
                                            <td>Clear Weakness</td>
                                            <td>Not very good</td>
                                            <td>Good</td>
                                            <td>Very Good</td>
                                            <td>Clear Strength</td> 
                                        </tr>
                                    </tbody>
                                </table>
    
                                <ul class="pdf-list strength-icons" style="margin-top: 2rem;">
                                    <li>
                                        <div class="scoring-div">
                                            <img src="<?php echo base_url() ?>asset/admin_asset/images/pmf/blind-spot.png" alt="blind-spot">
                                            <p><b>Blind Spot</b> - This represents an area where your self perception is
                                            significantly higher (+1.0 points) than that of the average of your evaluators.
                                            It is an area that may offer a significant developmental opportunity</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="scoring-div">
                                            <img src="<?php echo base_url() ?>asset/admin_asset/images/pmf/hidden-strength.png" alt="hidden-strength">
                                            <p><b>Hidden Strength</b> - This is an area where your self perception is significantly
                                            lower (-1.0 points) than that of the average of your evaluators. It represents
                                            an area of strenght you can possibly leverage more often</p>
                                        </div>
                                    </li>
                                </ul> 
    
                            </div>

                            <div class="analyze-full-card pdf page-3"> 

                                <header class="border-bottom">
                                    <p class="text-primary pdf-title">Understanding your Report: Two Perspectives</p> 
                                </header>
                            
                                <p class="pdf-paragraph">This report was designed to help provide you with a rounded view of how well
                                your leadership profile aligns with the critical competencies we believe is
                                required for any leader in MTN to succeed.</p>

                                <p class="pdf-paragraph">The first view we provide highlights how you have been evaluated across our
                                Seven (7) core leadership competency groups. Below is an overview of how
                                you and your evaluators rated your leadership impact across the 7 areas.</p>

                                <div id="multiple_radar_2">
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

                                <p class="pdf-paragraph pmf-radar-view">The second view aligns your evaluation against the four pillars of our
                                People Management Framework (Know Me, Focus Me,
                                Guide Me and Recognize Me). Below is an overview of how you and your
                                evaluators rated your leadership impact across these four domains</p>

                                <div id="multiple_radar_pmf">
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

                            <div class="analyze-full-card pdf page-4"> 

                                <div class="pmf_competency_responses" id="pmf_competency_responses_cont" style="margin-top: 2rem;">
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
                                    <script id="pmf_competency_responses" type="text/x-handlebars-template">
                                        <header class="border-bottom">
                                            <p class="text-primary pdf-title">Assessment Overview: Summary of Competencies ({{ competency_summary.length }})</p> 
                                        </header> 
                                        {{#if competency_summary.length}}
                                            <section class="row"> 
                                                <table class="pmf-competencies-table">
                                                    <tbody>
                                                        {{#competency_summary}}
                                                        <tr>
                                                            <td>
                                                                <h2>{{ title }}</h2>
                                                                <p>{{description}}</p>
                                                            </td>
                                                            <td>
                                                                {{#if evaluator_categories}}
                                                                <ul class="list-unstyled">
                                                                    {{#evaluator_categories}}
                                                                    <li>
                                                                        <div class="score-line">
                                                                            <p class="score-title">{{label}}</p>                                                                    
                                                                        </div>  
                                                                        <div>
                                                                            <div class="score-bar-wrapper show-bar-value">
                                                                                <div class="score-bar score-bar-{{percent}} score-bar-{{actual_label}}" style="width: {{ toPercentage percent }}; background-color: {{getColor actual_label}}"></div>
                                                                                <span>{{avg}}</span>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    {{/evaluator_categories}}
                                                                </ul>                                                  
                                                                {{/if}}  
                                                            </td>
                                                        </tr>                              
                                                        {{/competency_summary}}
                                                    </tbody>
                                                </table> 
                                            </section>
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

                            <div class="analyze-full-card pdf page-5">
                                
                                <header class="border-bottom">
                                    <p class="text-primary pdf-title">Assessment Overview: <span>Top Strengths & Opportunities</span></p> 
                                </header>

                                <div class="strength-cont">
                                    <h2>Top Strengths</h2>
                                    <p class="pdf-paragraph">The following are the statements in which you received the highest evaluation and represent areas of strength</p>                                                                       
                                    <div class="top_strength_body">
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

                                <div class="strength-cont strength-cont-opportunity">
                                    <h2>Top Opportunities</h2>
                                    <p class="pdf-paragraph">The following are the statements in which you received the lowest evaluation and represent areas of opportunity.</p>                                    
                                    <div class="top_opportunity_body">
                                        <div class="card-skeleton">
                                            <!-- <div class="animated-background"> 
                                                <div class="card-skeleton-img"></div>
                                                <div class="skel-mask-container">
                                                <div class="skel-mask skel-mask-1"></div>
                                                <div class="skel-mask skel-mask-2"></div>
                                                <div class="skel-mask skel-mask-3"></div>
                                                <div class="skel-mask skel-mask-4"></div>
                                                <div class="skel-mask skel-mask-5"></div>
                                                <div class="skel-mask skel-mask-6"></div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="detail_competency_analysis"></div>
                            <!-- loop through competencies detail -->                            
                            <script id="detail_competency_analysis" type="text/x-handlebars-template">
                                {{#each competencies}}
                                <div class="analyze-full-card pdf page-{{@index}}-child"> 
                                    <div class="pmf_competency_responses" id="pmf_competency_responses_cont_{{@index}}" style="margin-top: 2rem;">
                                        <header class="border-bottom">
                                            <p class="text-primary pdf-title">Detailed Analysis: {{title}} ({{ detail.length }})</p> 
                                        </header> 
                                        {{#if detail.length}}
                                            <section class="row"> 
                                                <table class="pmf-competencies-table hidden_strength">
                                                    <tbody>
                                                        {{#detail}}
                                                        <tr>
                                                            <td>
                                                                {{#if is_blind}}<img src="<?php echo base_url() ?>asset/admin_asset/images/pmf/blind-spot.png" alt="blind-spot" style="height:45px;">{{/if}}
                                                                {{#if is_hidden}}<img src="<?php echo base_url() ?>asset/admin_asset/images/pmf/hidden-strength.png" alt="hidden-strength" style="height:45px;">{{/if}}
                                                            </td>
                                                            <td><p class="pdf-paragraph">{{ title }}</p></td>
                                                            <td>
                                                                {{#if evaluator_categories}}
                                                                <ul class="list-unstyled">
                                                                    {{#evaluator_categories}}
                                                                    <li>
                                                                        <div class="score-line">
                                                                            <p class="score-title">{{label}}</p>                                                                    
                                                                        </div>  
                                                                        <div>
                                                                            <div class="score-bar-wrapper show-bar-value">
                                                                                <div class="score-bar score-bar-{{percent}} score-bar-{{actual_label}}" style="width: {{ toPercentage percent }}; background-color: {{getColor actual_label}}"></div>
                                                                                <span>{{avg}}</span>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    {{/evaluator_categories}}
                                                                </ul>                                                  
                                                                {{/if}}  
                                                            </td>
                                                        </tr>                              
                                                        {{/detail}}
                                                    </tbody>
                                                </table> 
                                            </section>
                                        {{/if}}

                                        <br>
                                        {{#if recommendation.length}}
                                        <header class="border-bottom recommendations-section">
                                            <p class="text-primary pdf-title">Recommendations: <span> Hidden Strengths & Blind spots</span></p> 
                                        </header>

                                        <ul class="pdf-list strength-icons" style="margin-top: 2rem;">
                                            {{#each recommendation}}                                            
                                                {{#if is_blind}}
                                                <li> 
                                                    <div class="scoring-div">
                                                        <img src="<?php echo base_url() ?>asset/admin_asset/images/pmf/blind-spot.png" alt="blind-spot" style="height:45px;"> 
                                                        <div style="grid-template-columns: 100%;">
                                                            <p style="margin-bottom: 10px;"><b>Question:</b> {{title}}</p>
                                                            <p><b>Recommendation:</b> {{blind_spot}}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                {{/if}}
                                                {{#if is_hidden}}
                                                <li> 
                                                    <div class="scoring-div">
                                                        <img src="<?php echo base_url() ?>asset/admin_asset/images/pmf/hidden-strength.png" alt="hidden-strength" style="height:45px;">
                                                        <div style="grid-template-columns: 100%;">
                                                            <p style="margin-bottom: 10px;"><b>Question:</b> {{title}}</p>
                                                            <p><b>Recommendation:</b> {{hidden_strength}}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                {{/if}}
                                            {{/each}}
                                        </ul> 
                                        {{/if}}
                                        
                                        <!-- <header class="border-bottom">
                                            <p class="text-primary pdf-title">Recommendations</p> 
                                        </header>

                                        <ul class="pdf-list strength-icons" style="margin-top: 2rem;">
                                            <li>
                                                <div class="scoring-div"> 
                                                    <p>The success of any change project is tied to the quality of the
                                                    communication before, during and after implementation. You might
                                                    want to consider communicating with stakeholders more often.
                                                    However, make sure your communication is relevant to the
                                                    audience and clear.<br><br>
                                                    Don’t assume everyone knows; rather, assume they don’t and make sure you check for understanding<br>
                                                    Be intentional about following through on plan. However, maintain a
                                                    flexible attitude as changes to the plan are bound to occur.<br><br>
                                                    Be sure that you and your team are clear on the metrics for success    
                                                    </p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="scoring-div"> 
                                                    <p>Uncertain situations are stressful for most people but is also one
                                                    where team members require you take initiative. It does not mean
                                                    that you have all the answers, but they want you to see you leading
                                                    them towards a (few possible) right answer(s). <br>
                                                    Blind spot 2 if there is one. Each one will not exceed 4 lines (one statement and one question) <br>
                                                    Blind spot 3 if there is one. Each one will not exceed 4 lines (one statement and one question)
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>  -->
                                    </div>
                                </div>
                                {{/each}}
                            </script>

                            <div class="analyze-full-card pdf page-3a">
                                <header class="border-bottom">
                                    <p class="text-primary pdf-title">People Management Framework: Focus Me</p> 
                                </header>

                                <p class="pdf-paragraph">
                                    <b>FOCUS ME</b> refers to your ability to link human energy to organisational success. 
                                    It speaks to how well you are doing in helping each team member build greater self awareness and leverage their strengths, 
                                    in creating an environment that encourages  them to speak and be heard and in supporting each member in their 
                                    quest to be a contributing member of a cohesive team. 
                                </p>

                                <p class="pdf-paragraph">Below is the feedback from your evaluators on the how well you FOCUS ME</p>

                                <div class="pmf_detail_analysis focus_me">
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
                        
                            <div class="analyze-full-card pdf page-3b">
                                <header class="border-bottom">
                                    <p class="text-primary pdf-title">People Management Framework: Guide Me</p> 
                                </header>

                                <p class="pdf-paragraph">
                                    <b>GUIDE ME</b> refers to your ability to shape flow of effort (energy) towards goal achievement. 
                                    It speaks to your ability to influence the leadership skills of your team members in order to meet 
                                    organizational demands and achievement to produce the desired output. 
                                </p>

                                <p class="pdf-paragraph">Below is the feedback from your evaluators on the how well you GUIDE ME</p>

                                <div class="pmf_detail_analysis guide_me">
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

                            <div class="analyze-full-card pdf page-3c">
                                <header class="border-bottom">
                                    <p class="text-primary pdf-title">People Management Framework: Know Me</p> 
                                </header>

                                <p class="pdf-paragraph">
                                    <b>KNOW ME</b> refers to your ability to get maximum performance from a committed team. 
                                    It speaks to how well you as a leader is helping your team stay focused on their objectives 
                                    and identifying the organization’s prorities while aligning to the vision and the mission. 
                                </p>

                                <p class="pdf-paragraph">Below is the feedback from your evaluators on the how well you KNOW ME</p>

                                <div class="pmf_detail_analysis know_me">
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

                            <div class="analyze-full-card pdf page-3d">
                                <header class="border-bottom">
                                    <p class="text-primary pdf-title">People Management Framework: Recognize Me</p> 
                                </header>

                                <p class="pdf-paragraph">
                                    <b>RECOGNIZE ME</b> refers to your ability to use success to build confidence & commitment. 
                                    It speaks to how well you as a leader can raise the morale of your team and enabling the 
                                    see more of opportunities than risk while also leading by example. 
                                </p>

                                <p class="pdf-paragraph">Below is the feedback from your evaluators on the how well you RECOGNIZE ME</p>

                                <div class="pmf_detail_analysis recognize_me">
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
                            
                            <div class="analyze-full-card pdf page-5">

                                <header class="border-bottom">
                                    <p class="text-primary pdf-title">Open Ended Questions</p> 
                                </header>
                                
                                <div class="openended_responses_cont"></div>
                                <script id="openended_responses_cont" type="text/x-handlebars-template">
                                    <!-- generate questions below -->
                                    {{#if open_ended.length}}
                                        {{#open_ended}}
                                        <section class="row"> 
                                            <header class="competency-openended-header">
                                                <div class="title-wrapper open-ended">
                                                    <h2>Q{{inc @index}}: {{title}}</h2>
                                                </div> 
                                            </header>
                                            <div class="competency-response">
                                                {{#if responses.length }}
                                                    {{#responses}}
                                                        {{#useSettingName relationship}}
                                                        <div class="question-response-detail open-ended">
                                                            <b>{{getSettingName relationship}}:</b>
                                                            <div class="question-desc">
                                                                <p> 
                                                                    <span>{{response}}</span>
                                                                </p>
                                                            </div>                                        
                                                        </div> 
                                                        {{/useSettingName}}
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

                            </div>

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
                {{#if evaluator_categories}}
                    <ul class="list-unstyled">
                        {{#evaluator_categories}}
                        <li class="score-line">
                            <p class="score-title">{{label}}</p>
                            <div class="score-bar-wrapper">
                                <div class="score-bar" style="width: {{ toPercentage percent }}; background-color: {{getColor actual_label}};"></div>
                            </div>
                        </li>  
                        {{/evaluator_categories}}   
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

<script id="strength_tmp" type="text/x-handlebars-template">
<table>
    <thead>
        <tr>
            <th style="text-align:left"></th>
            <th style="text-align:left">Statement</th>
            <th style="text-align:center; padding-right: 10px;">Self</th>
            <th style="text-align:center">Others</th>
        </tr>
    </thead>
    <tbody>
        {{#each data}}                                            
        <tr>
            <td style="text-align:left"><span>{{inc @index}}</span></td>
            <td style="text-align:left"><span>{{question}}</span></td>
            <td style="text-align:center; padding-right: 10px;"><span>{{self}}</span></td>
            <td style="text-align:center"><span>{{others}}</span></td>
        </tr>
        {{/each}}
    </tbody>
</table>
</script>

<script id="pmf_detail_analysis" type="text/x-handlebars-template">
    <table class="pdf-scoring-table people-mf-table">
        <tbody> 
            <tr class="thead">
                <th></th>
                <th>Question</th>
                <th>Self</th>
                <th>Line Manager</th>
                <th>Team Members</th> 
            </tr>
            {{#each data}}
            <tr>
                <td>{{inc @index}}</td>
                <td>{{question}}</td>
                <td>{{to2DP self}}</td>
                <td>{{to2DP line_manager}}</td>
                <td>{{to2DP team_members}}</td>
            </tr>  
            {{/each}}            
            <tr>
                <td></td>
                <td style="justify-content:flex-end;">Total</td>
                <td>{{toSum data 'self'}}</td>
                <td>{{toSum data 'line_manager'}}</td>
                <td>{{toSum data 'team_members'}}</td>
            </tr>
        </tbody>
    </table>    
    <div class="people-mf-table summary-score">
        <p style="align-self: center;">Your <span class="pmf-type"></span> rating (an average of the scores from your Line Manager and Team Members) is</p>
        <p class="score-title-badge">{{toOverallSum data}}</p>
    </div>
</script>

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>

<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>

<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/handlebars.min.js"></script>
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url() ?>asset/js/bootbox.min.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/analyze.js"></script>
