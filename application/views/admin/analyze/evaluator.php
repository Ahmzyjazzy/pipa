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
                        <a href="assessment_360" class="text-blue fixed-backnav"> 
                            <svg width="21" height="13" viewBox="0 0 21 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 6.5H2M2 6.5L7.5 1M2 6.5L7.5 12" stroke="#0071F7" stroke-width="2"/>
                            </svg>
                        </a> 
                        <ul class="border-bottom nav nav-tabs">
                            <li class="active mr-3 pb-2"> 
                                <a data-toggle="tab" href="#analyze" class="text-md header-title border-0">360 appraisals</a>
                            </li>
                        </ul>                        
                        <!-- <form action="<?php echo base_url() ?>admin/evaluator" method="post"> -->
                            <button class="btn button download_pending_evaluator load-button" style="background: var(--btn-blue-color);"
                                type="submit" id="btnExport" name="export" value="Export to excel">
                                <span>Download Pending Evaluators</span> 
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
                        <!-- </form> -->
                    </section> 
                </div>
            </div> 

            <div class="row">
                <div class="col-md-12" style="padding: 0">
                    <div class="tab-content">

                        <div id="analyze" class="tab-pane fade in active">
                            
                            <section class="row table-wrapper">
                                <div class="col-md-12">
                                    <header>
                                        <p class="text-primary table-title" id="total_participants"></p> 
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
                                        <table class="table display nowrap" id="dt_evaluator" style="width:100%">
                                            <thead>
                                                <tr class="dark-text">
                                                    <th scope="col">
                                                        <input type="checkbox" />
                                                    </th>
                                                    <th scope="col">Participant</th>
                                                    <th scope="col">Self</th>
                                                    <th scope="col">Line manager</th>
                                                    <th scope="col">Peer 1</th>
                                                    <th scope="col">Peer 2</th>
                                                    <th scope="col">Direct report 1</th>
                                                    <th scope="col">Direct report 2</th>
                                                    <th scope="col">Direct report 3</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table> 
                                    </div>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.4/xlsx.core.min.js"></script>
<script src="<?php echo base_url() ?>asset/admin_asset/excel/FileSaver.js"></script>
<script src="<?php echo base_url() ?>asset/admin_asset/excel/jhxlsx.js"></script>

<script src="<?php echo base_url() ?>asset/admin_asset/js/analyze.js"></script>