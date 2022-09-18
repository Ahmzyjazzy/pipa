<style>  
    :root {
        --text-blue-color: #0071F7;
        --text-primary-color: #001E42;
        --text-secondary-color: #7E9EC2;
        --text-dark-color: #000000;
​
        --btn-blue-color: #005CC8;
​
        --bg-secondary-color: #F3F9FF;
​
        --font-small: 14px;
        --font-medium: 16px;
        --font-large: 18px;
    } 
​
    .text-blue {
        color: var(--text-blue-color);
    }
​
    .text-primary {
        color: var(--text-primary-color);
    }
​
    .text-secondary {
        color: var(--text-secondary-color);
    }
​
    .bg-secondary-color{
        background: var(--bg-secondary-color);
    }
​
    .border-secondary-color {
        border-color: var(--text-secondary-color);
    }
​
    .header-title {
        font-size: var(--font-medium);
        line-height: 24px;
        color: var(--text-secondary-color);
    }
​
    li.active { 
        border-bottom: 2px solid var(--text-blue-color);
    }
​
​
    li.active .header-title {
        font-size: var(--font-large);
        line-height: 27px;
        color: var(--text-blue-color);
        font-weight: bold;
    }
​
    .card-title {
        font-weight: 600;
        font-size: var(--font-medium);
        line-height: 24px;
    }
​
    .card-date {
        font-weight: bold;
        font-size: var(--font-small);
        line-height: 21px;
    }
​
    .button {
        font-size: var(--font-small);
        line-height: 21px;
    }
​
    .rounded-btn {
        border-radius: 54px;
        font-size: 14px;
        line-height: 21px;
    }
​
    select {
        color: var(--text-secondary-color);
    }
​
    .analyze {
        font-family: Poppins;         
        font-size: var(--font-small);
    }
​
    ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
       color: var(--text-secondary-color);
    }
    ::-moz-placeholder { /* Firefox 19+ */
        color: var(--text-secondary-color);
    }
    :-ms-input-placeholder { /* IE 10+ */
        color: var(--text-secondary-color);
    }
    :-moz-placeholder { /* Firefox 18- */
        color: var(--text-secondary-color);
    }
​
    .grid-box {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-column-gap: 2rem;
    }
​
    .grid-list {
        display: grid;
    }
    
    /* amchart override */
    tspan {
        font-size: 80%;
        fill: var(--text-secondary-color);
    }
​
    /* table */
    .analyze table td,
    .analyze table th {
        color: var(--text-blue-color);
        font-size: 14px;
    }
​
    .analyze table tr {
        height: 60px;        
    }
​
    .analyze table thead {
        background: var(--bg-secondary-color);
    }
​
    .analyze table th {
        border: 0px solid var(--bg-secondary-color);
    }
​
    .analyze table td:first-child {
        color: var(--text-secondary-color);
    } 
​
    .analyze table td:nth-child(2) {
        color: var(--text-dark-color);
    }
​
    .analyze table td:nth-child(3) {
        color: var(--text-blue-color);
    }
​
    .analyze table td:nth-child(4) {
        color: var(--text-secondary-color);
    }
​
    .dataTables_length label {
        display: grid;
        grid-template-columns: 20% 1fr 20%;
        grid-column-gap: 10px;
        width: 30%;
        align-items: center;
    }
​
    .dataTables_filter label {
        display: grid;
        grid-template-columns: 20% 1fr;
        width: 50%;
    }
​
​
</style>

  <div class="content-wrapper">
   
   <!-- Content Header (Page header) -->
    <section class="content-header">

      
    </section>

    <!-- Main content -->
    <section class="content">
    	
        <div class="analyze container mx-auto bg-white min-h-screen py-3 px-3">

    <section class="header-tab flex items-center">
        <a href="" class="mr-3 text-blue"><i class="material-icons">arrow_back</i></a>
        <ul class="flex flex-row w-full border-b pt-2">
            <li class="active mr-3 pb-2">
                <a href="" class="text-md header-title">Analyze module</a>
            </li>
            <li class="mr-3 pb-2">
                <!-- <a href="" class="text-md header-title">Test module</a> -->
            </li>
        </ul>
    </section> 

    <main class="my-3 md:py-5 md:pl-8">
        <section data-tab="analyze">

            <div class="h-64 rounded-lg shadow-md px-5 py-3 hidden">
                <header class="border-b w-full pb-3 flex flex-wrap justify-between border-secondary-color">
                    <p class="text-primary card-title">Engagement surveys</p> 
                    <div class="flex">
                        <p class="card-date mr-3">Surveys date</p> 
                        <input type="text" class="bg-secondary-color outline-none px-5 w-32 rounded text-sm py-1" placeholder="Dec 2020" />
                    </div>
                </header>
            </div>

            <div class="w-full">
                <div class="md:w-1/2 rounded-lg px-5 py-3 bg-secondary-color">
                    <header class="border-b w-full pb-3 flex justify-between border-secondary-color">
                        <p class="text-primary card-title"> Assessment</p>  
                    </header>
                    <div class="py-5 flex flex-wrap justify-around">
                        <img src="assets/img/radar.png" alt="radar">
                        <ul class="flex flex-col mt-3 md:mt-0 justify-around">
                            <li>
                                <p class="text-secondary">Competency: 12</p>
                            </li>
                            <li>
                                <p class="text-secondary">Participants accessed: 100</p>
                            </li>
                            <li>
                                <p class="text-secondary">Date collected: 21, Dec 2020</p>
                            </li>
                            <li class="py-3">
                                <a href="analyze/assessment_360" class="rounded border px-5 py-2 text-sm text-white bg-blue-500 font-normal button outline-none">
                                    View assessment
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="rounded-lg px-5 py-3 bg-secondary-color hidden">
                    <header class="border-b w-full pb-3 flex justify-between border-secondary-color">
                        <p class="text-primary card-title">eNPS/Pulse surveys</p> 
                    </header>
                </div>
            </div>
        </section>
    </main>
</div>

    </section>
    
  </div>