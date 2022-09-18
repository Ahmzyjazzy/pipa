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
                             
                                <a data-toggle="tab" href="#analyze" class="text-md header-title border-0">eNPS</a>
                          
                            </li>
                         
                            <li class="mr-3 pb-2 hidden">
                            
                                <a data-toggle="tab" href="#option" class="text-md header-title border-0">Another option</a>
                         
                            </li>
                        
                        </ul>
                    </section>                 
                </div>                
            </div> 

            <div class="row">                
                <div class="col-md-12" style="padding: 0">
                 
                    <div class="tab-content">

                        <div id="analyze" class="tab-pane fade in active">

                            <div class="analyze-full-card engagement-container col-md-12">
                                <header class="border-bottom">
                                    <p class="text-primary card-title">Net promoter score analysis</p> 
                                    <div class="date-dropdown">
                                        <p class="card-date" style="margin-right: 1rem;">Survey dates</p>   
                                        <input type="text" id="surveydate-dropdown" class="bg-secondary-color text-md" />
                                    </div>
                                </header>
                                <div>
                                    <div class="col-md-5 engagement-wrapper">
                                        <div id="assessment_pie" class="chart">
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
                                            <div class="engagement-bar">
                                                <div>
                                                    <span class="bar dark"></span>
                                                    <p>Participated</p>
                                                </div>
                                                <div>
                                                    <span class="bar green"></span>
                                                    <p>Awaiting response</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div id="engagement-line-chart" style="height:300px;"></div>
                                    </div>
                                </div>
                            </div> 

                            <div class="analyze-gray-card-parent">
                                <div class="analyze-gray-card-child">
                                    <div class="analyze-gray-card net-promoter">
                                        <header class="border-bottom pb-3 flex justify-between">                                            
                                            <p class="text-primary card-title"> eNPS/Pulse surveys</p>  
                                        </header>
                                        <div class="enps-action-section">
                                            <h2 class="enps-title">Total no of surveyors: 1020</h2>
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
                                <div class="analyze-gray-card-child">                                
                                    <div class="analyze-gray-card net-promoter">                      
                                        <header class="border-bottom pb-3 flex justify-between">                         
                                            <p class="text-primary card-title"> Net promoter score</p>                        
                                        </header>
                                        <div class="enps-action-section">
                                            <h2 class="enps-title">NPS Score: +37</h2>
                                        </div>
                                        <div class="enps-bar-section">
                                            <ul class="enps-bar-indicator">
                                                <li>
                                                    <label for="enps-indicator-balls">Promoters: <span>150 (20%)</span></label>
                                                </li>
                                                <li>
                                                    <label for="enps-indicator-balls">Passive: <span>750 (70%)</span></label>
                                                </li>
                                                <li>
                                                    <label for="enps-indicator-balls">Detractors: <span>120 (10%)</span></label>
                                                </li>
                                            </ul>
                                            <div class="enps-bar-chart gauge-chart" >
                                                <div id="gauge-chart"></div>
                                                <div class="promoter-detractor-value">
                                                    <p class="value-score">+37</p>
                                                    <p>%Promoters - %Detractors</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>   
                            </div>

                            <div class="analyze-gray-card-parent" style="margin-top: 20px;">
                                <div class="analyze-gray-card-child smile-container smiley">
                                    <p class="smile-title">Promoters</p>
                                    <div class="emoji smile">
                                        <figure class="face">
                                            <span class="eyes">
                                            <span class="eye"></span>
                                            <span class="eye"></span>
                                            </span>
                                            <span class="mouth">
                                            </span>
                                        </figure>
                                    </div>
                                    <p class="smile-value">150</p>
                                    <p class="smile-description">Respondant gave a score of <span>9</span> or <span>10</span></p>
                                </div>
                                <div class="analyze-gray-card-child speechless-container smiley">
                                    <p class="smile-title">Passive</p>
                                    <div class="emoji speechless">
                                        <figure class="face">
                                            <span class="eyes">
                                            <span class="eye"></span>
                                            <span class="eye"></span>
                                            </span>
                                            <span class="mouth">
                                            </span>
                                        </figure>
                                    </div>
                                    <p class="smile-value">750</p>
                                    <p class="smile-description">Respondant gave a score of <span>7</span> or <span>8</span></p>
                                </div>                                
                                <div class="analyze-gray-card-child sad-container smiley">
                                    <p class="smile-title">Detractors</p>
                                    <div class="emoji sad">
                                        <figure class="face">
                                            <span class="eyes">
                                            <span class="eye"></span>
                                            <span class="eye"></span>
                                            </span>
                                            <span class="mouth">
                                            </span>
                                        </figure>
                                    </div>
                                    <p class="smile-value">120</p>
                                    <p class="smile-description">Respondant gave a score of <span>0</span> or <span>6</span></p>
                                </div>
                            </div>

                            <div class="analyze-full-card engagement-container col-md-12" style="margin-top: 20px;">
                                <header class="border-bottom">
                                    <p class="text-primary card-title">eNPS graph</p> 
                                    <div class="date-dropdown">
                                        <p class="card-date" style="margin-right: 1rem;">Survey dates</p>   
                                        <input type="text" id="surveydate-dropdown" class="bg-secondary-color text-md" />
                                    </div>
                                </header>
                                <div>
                                    <div class="col-md-5">
                                        <header style="display: flex;justify-content: space-between;">  
                                            <div class="question-slide-controller">
                                                <span class="question-number">Q1</span>
                                                <div>
                                                    <span class="fa fa-caret-left question-slide-btn" title="prev" data-action="prev"></span>
                                                    <span class="fa fa-caret-right question-slide-btn" title="next" data-action="next"></span>
                                                </div>
                                            </div>                   
                                        </header>
                                        <div class="carousel slide">
                                            <div class="item active">
                                                <p class="text-primary word-cloud--content__title">How likely is that you'll recommend this organization to a friend?</p>
                                            </div> 
                                            <div class="item active">
                                                <p class="text-primary word-cloud--content__title">How likely is that you'll recommend this organization to a friend?</p>
                                            </div> 
                                            <div class="item active">
                                                <p class="text-primary word-cloud--content__title">How likely is that you'll recommend this organization to a friend?</p>
                                            </div> 
                                        </div>                                       
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
                                    </div>
                                    <div class="col-md-7">
                                        <div id="pulse_barchart" style="height:300px;">
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