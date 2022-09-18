<div class="content-wrapper">
   
    <!-- Content Header (Page header) -->
    <section class="content-header">     
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="tab-page--container">

            <div class="row">
                <div class="col-xs-12 col-md-12"> 

                    <?php
                            
                        echo validation_errors(); 
                    
                        if ($this->session->flashdata('error')):
                        
                    ?>
                        
                        <div class="alert alert-error">
                        
                            <a class="close" data-dismiss="alert">×</a>
                            
                            <?php echo $this->session->flashdata('error');?>
                            
                        </div>
                        
                    <?php 
                    
                    endif;
                    
                    ?>
                    
                    <?php 
                    
                    if ($this->session->flashdata('message')):
                    
                    ?>
                                    
                        <div class="alert alert-info">
                        
                        <a class="close" data-dismiss="alert">×</a>
                        
                        <?php echo $this->session->flashdata('message');?>
                    
                    </div>
                                    
                    <?php 
                    
                    endif;
                    
                    ?>

                    <?php 
                        
                        $attr 	= array('role'=> 'form');
                        
                        echo form_open(base_url().'admin/action_plan/'.$program_id.'/'.$action_plan_id, $attr); 
                    
                    ?>
                    
                        <div class="col-xs-12 col-md-12">
                            
                            <div class="setup-form-header-cont">
                                
                                <div class="setup-form-header">
                                    
                                    Create action plan
                                    
                                </div>   

                                <p><a href="<?php echo base_url().'admin/program_action_plans/'. $program_id ?>">View action plans</a></p>
                            </div>
                        
                        </div>
                        
                        <div class="col-xs-12 col-md-12 admin-form-row"> 
                            
                            <div class="col-xs-12 col-md-8">
                                
                                <div class="form-group admin-form-setup">
                                    
                                    <fieldset>
                                        
                                        <legend style="width: 30%;">Specific actions to be taken </legend> 

                                        <?php
                                            
                                            $data	= array('placeholder'=>'Enter actions to be taken', 'name'=>'specific_plans', 'value'=>set_value('specific_plans', $specific_plans), 'class'=>'form-control form-no-style', 'autocomplete'=>'off');
                                            
                                            echo form_input($data);
                                            
                                        ?>
                                        
                                    </fieldset>
                                                  
                                </div>
                                
                            </div>
                            
                        </div>
                                                
                        <div class="col-xs-12 col-md-12 admin-form-row"> 
                            
                            <div class="col-xs-12 col-md-8">
                                
                                <div class="form-group admin-form-setup">

                                    <?php
                                        
                                        $data 				= 	array(
                                            'name'        	=> 'desired_outcome',
                                            'id'          	=> 'desired_outcome',
                                            'value'       	=> set_value('desired_outcome', $desired_outcome),
                                            'rows'        	=> '5',
                                            'cols'        	=> '10',
                                            'style'       	=> 'width:100%',
                                            'placeholder'	=>	'Please specify desired outcome',
                                            'class'       	=> 'form-control'
                                        );
                                    
                                        echo form_textarea($data);
                                    
                                    ?> 
                                
                                </div>
                                
                            </div>
                            
                        </div>

                        <div class="col-xs-12 col-md-12 admin-form-row"> 
                            
                            <div class="col-xs-12 col-md-8">
                                
                                <div class="form-group admin-form-setup">  
                                    
                                    <select name="program_owner_id" id="program_owner_id" class="form-control">
                                        <option value="">Select Enforcer</option> 
                                        <?php if (!empty($enforcers)){
                                                foreach ($enforcers as $enforcer) {
                                                    if($enforcer['user_id'] == $program_owner_id){
                                        ?>
                                            <option value="<?php echo $enforcer['user_id'] ?>" selected><?php echo $enforcer['first_name'] .' ' .  $enforcer['last_name'] ?></option>    
                                        <?php
                                                    } 
                                                    else {
                                        ?>
                                            <option value="<?php echo $enforcer['user_id'] ?>"><?php echo $enforcer['first_name'] .' ' .  $enforcer['last_name'] ?></option>    
                                        <?php
                                                    }
                                                } //end foreach
                                            } //end else
                                        ?>      
                                    </select>

                                </div>
                                
                            </div>
                            
                        </div>

                        <div class="col-xs-12 col-md-12 admin-form-row"> 
                            
                            <div class="col-xs-12 col-md-8">
                                
                                <div class="form-group admin-form-setup">

                                    <?php
                                        
                                        $data 				= 	array(
                                            'name'        	=> 'resources_needed',
                                            'id'          	=> 'resources_needed',
                                            'value'       	=> set_value('resources_needed', $desired_outcome),
                                            'rows'        	=> '5',
                                            'cols'        	=> '10',
                                            'style'       	=> 'width:100%',
                                            'placeholder'	=>	'Please entire the resources needed',
                                            'class'       	=> 'form-control'
                                        );
                                    
                                        echo form_textarea($data);
                                    
                                    ?>  
                                
                                </div>
                                
                            </div>
                            
                        </div> 
                        
                        <div class="col-xs-12 col-md-12 admin-form-row"> 
                            
                            <div class="col-xs-12 col-md-8">
                                
                                <div class="form-group admin-form-setup">
                                    
                                    <div class="col-xs-6 col-md-6 no-pad-left">

                                        <input id="start_top" value="<?php echo set_value('start_date',$start_date); ?>" class="form-control datepicker" 
                                            name="start_date" type="text" placeholder="Start Date" autocomplete="off">
                                    
                                    </div>
                                    
                                    <div class="col-xs-6 col-md-6 no-pad-right">
                                        
                                        <input id="end_top" value="<?php echo set_value('end_date',$end_date); ?>" class="form-control datepicker" 
                                            name="end_date" type="text" placeholder="End Date" autocomplete="off">
                                    
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                        </div>  
                        
                                            
                        <div class="col-xs-12 col-md-12 admin-form-row"> 
                            
                            <div class="col-xs-12 col-md-8">
                                
                                <div class="form-group admin-form-setup" style="border-bottom:none;">
                                    
                                    <button type="submit" class="btn btn-primary"><?php echo !empty($action_plan_id) ? 'Update' : 'Save' ?></button>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </form>
                
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
