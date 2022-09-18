<!--<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
-->
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
                        <a href="" class="text-blue fixed-backnav">  
                            <svg width="21" height="13" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 6.5H2M2 6.5L7.5 1M2 6.5L7.5 12" stroke="#0071F7" stroke-width="2"/>
                            </svg>
                        </a>                        
                        <ul class="border-bottom nav nav-tabs">
                          
                            <li class="active mr-3 pb-2"> 
                             
                                <a data-toggle="tab" href="#analyze" class="text-md header-title border-0">Analyze module</a>
                          
                            </li>
                         
                            <li class="mr-3 pb-2 hidden">
                            
                                <a data-toggle="tab" href="#option" class="text-md header-title border-0">Another option</a>
                         
                            </li>
                        
                        </ul>
                        <div class="program-dropdown">
                            <p class="card-date" style="margin-right: 1rem;">Select Program</p>  
                            <select class="bg-secondary-color text-md program-select" id="program-select">
                                <?php if (empty($programs)) { ?>
                                    <option value="">Select Program</option>                                                
                                <?php
                                    } else {
                                        foreach ($programs as $program) {
                                ?>
                                    <option value="<?php echo $program['program_id'] ?>"><?php echo $program['program_name'] ?></option>    
                                <?php
                                        } //end foreach
                                    } //end else
                                ?>                  
                            </select> 
                        </div> 
                    </section>                 
                </div>                
            </div> 

            <div class="row">                
                <div class="col-md-12" style="padding: 0">
                 
                    <div class="tab-content">

                        <div id="analyze" class="tab-pane fade in active">

                            <div class="disabled-report analyze-full-card engagement-container col-md-12">
                                <header class="border-bottom">
                                    <p class="text-primary card-title">Engagement surveys</p> 
                                    <div class="date-dropdown">
                                        <p class="card-date" style="margin-right: 1rem;">Survey dates</p>   
                                        <input type="text" id="surveydate-dropdown" class="bg-secondary-color text-md" />
                                    </div>
                                </header>
                                <div>
                                    <div class="col-md-5">
                                        <ul class="engagement-list-cont">
                                            <li class="engagement-liner">
                                                <h5>80% participation</h5>
                                                <div class="engagement-line-cont">
                                                    <div class="engagement-line-percent" style="width: 80%;"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <p>No of participants: 100</p>
                                            </li>
                                            <li>
                                                <p>No of  surveyors invited: 1020</p>
                                            </li>
                                            <li>
                                                <p>No of competencies: 12</p>
                                            </li>
                                            <li>
                                                <p>Date collected: 21, Dec 2020</p>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url() ?>admin/engagement-survey" rel="noopener noreferrer" class="enps-expand-action ">
                                                    Expand 
                                                    <svg width="21" height="10" viewBox="0 0 21 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0 5H19.5M19.5 5L15.5 1M19.5 5L15.5 9" stroke="#0071F7"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-7">
                                        <div id="engagement-line-chart" style="height:300px;"></div>
                                    </div>
                                </div>
                            </div> 

                            <div class="analyze-gray-card-parent">
                   
                                <div class="analyze-gray-card-child">                                
                                    <div class="analyze-gray-card">
                      
                                        <header class="border-bottom pb-3 flex justify-between">
                         
                                            <p class="text-primary card-title"> Assessment</p>  
                      
                                        </header>
                     
                                        <div class="card-content">
                                
                                            <img src="<?php echo base_url(); ?>asset/images/radar.png" alt="radar">
                        
                                            <ul class="mt-3 list-unstyled">
                                               
                                                <li>
                                                
                                                    <p class="text-secondary">Competency: <span class="competency_total"></span></p>
                                                
                                                </li>
                                                
                                                <li>
                                                
                                                    <p class="text-secondary">Participants accessed: <span class="participant_accessed"></span></p>
                                               
                                                </li>

                                                <li>
                                                
                                                    <p class="text-secondary">Number of Evaluators Invited: <span class="total_evaluator_invited"></span></p>
                                                
                                                </li>
                                                
                                                <li>
                                                
                                                    <p class="text-secondary">Number of Evaluators Responded: <span class="total_evaluator_responded"></span></p>
                                               
                                                </li>
                                                
                                                <li>
                                                
                                                    <p class="text-secondary">Date collected: <span class="date_collected"></span></p>
                                                
                                                </li>
                                                
                                                <li class="py-3">
                                                
                                                    <a href="<?php echo base_url(); ?>admin/assessment-360" class="btn analyze-btn">
                                                        
                                                        View assessment
                                                
                                                    </a>
                                                    
                                                </li>
                                                
                                            </ul>
                                            
                                        </div>
                                        
                                    </div>                                    
                                </div>
                                
                                <div class="analyze-gray-card-child">
                                    <div class="disabled-report analyze-gray-card">
                                        <header class="border-bottom pb-3 flex justify-between">                                            
                                            <p class="text-primary card-title"> eNPS/Pulse surveys</p>  
                                        </header>
                                        <div class="enps-action-section">
                                            <h2 class="enps-title">Total no of surveyors: 1020</h2>
                                            <a href="<?php echo base_url() ?>admin/pulse-survey" rel="noopener noreferrer" class="enps-expand-action ">
                                                Expand 
                                                <svg width="21" height="10" viewBox="0 0 21 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 5H19.5M19.5 5L15.5 1M19.5 5L15.5 9" stroke="#0071F7"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="enps-bar-section">
                                            <ul class="enps-bar-indicator">
                                                <li>
                                                    <span class="enps-indicator-balls enps-indicator-blue"></span>
                                                    <label for="enps-indicator-balls">Promoters</label>
                                                </li>
                                                <li>
                                                    <span class="enps-indicator-balls enps-indicator-pink"></span>
                                                    <label for="enps-indicator-balls">Passive</label>
                                                </li>
                                                <li>
                                                    <span class="enps-indicator-balls enps-indicator-gray"></span>
                                                    <label for="enps-indicator-balls">Detractors</label>
                                                </li>
                                            </ul>
                                            <div class="enps-bar-chart">
                                                <div style="width: 20%;" class="enps-bar enps-bar-gray">
                                                    <h5>20%</h5>
                                                </div>
                                                <div style="width: 50%;" class="enps-bar enps-bar-pink">
                                                    <h5>50%</h5>
                                                </div>
                                                <div style="width: 30%;" class="enps-bar enps-bar-blue">
                                                    <h5>30%</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>

                        <div id="option" class="tab-pane fade">
                        
                            <h3>Tab 2</h3>
                          
                            <p>Tab 2 content</p>
                        
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

<script src="<?php echo base_url() ?>asset/admin_asset/js/analyze.js"></script>