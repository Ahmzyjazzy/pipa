<?php
if(sizeof($question_options) > 0){
	
}else{
	
	//session_start();
}

$_SESSION['option_value_count'] = 0;

?>

 <script type="text/javascript">
//<![CDATA[
	
	$(document).ready(function() {
				
		//if the image already exists (phpcheck) enable the selector
				
		<?php if($program_id) : ?>
				
		//options related
		var ct				= $('#option_list').children().size();
		// set initial count
		
		option_count = "<?php echo sizeof($question_options); ?>";
				
		<?php endif; ?>
	
	});


//]]>
</script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
  	   <!-- Content Header (Page header) -->
    <section class="content-header">

      
    </section>
    
    <!-- Main content -->
    <section class="content">
    	
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
                    
                    echo form_open(base_url().'admin/custom-survey-competency-questions/'.$program_id, $attr); 
                
                ?>
                
                    <div class="col-xs-12 col-md-12">
                        
                        <div class="setup-form-header-cont">
                            
                            <div class="setup-form-header-arrow-bck">
                            
                                <a href="<?php echo base_url(); ?>admin/leadership-assessment/<?php echo $program_id; ?>/" class="text-blue fixed-backnav">
                                                               
                                    <i class="fa fa-arrow-left"></i>
                                
                                </a>
                            
                            </div> 
                        
                            <div class="setup-form-header">
                                
                              Add Custom Questions
                                
                            </div>
                            
                            <div class="setup-form-header-sub-text">
                                
                                Click on the Add Question below to add more questions
                                
                            </div>
                        
                        </div>
                    
                    </div>
                 
                    <div class="col-xs-12 col-md-12 no-pad-left no-pad-right" id="hold-quest-div">
                    	
                        <?php
							
							if(sizeof($question_options2) > 0){
								
								//print_r($product_options2);
								foreach($question_options2 as $pr)
								{
								
									print_r($pr);
								
								}
								
							}
						
						?>
                    
                    </div>

                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">
                    
                                
                                                    
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup">
                                 
                                <div class="col-xs-12 col-md-12 no-pad-left">
                                    
                                    <div class="form-group" style="overflow:auto;">
                                        
                                        <div class="col-xs-6 col-md-6 no-pad-left">

                                            <select id="option_options" style="margin:0px; display:none;">
                                                <option value="">Select Option Type</option>
                                                <option value="checklist">Checklist</option>
                                                <option value="radiolist">Radiolist</option>
                                                <option value="droplist">Droplist</option>
                                                <option value="textfield" selected="selected">Textfield</option>
                                                <option value="textarea">Textarea</option>
                                            </select>
                                            
                                             <div class="dashb-trans-btn" id="add-custom-question">
                                                
                                                <span style="width:100%;">
                                                   
                                                    <i class="fa fa-plus"></i> Add Question
                                                    
                                                </span>
                                                
                                            </div>
                                        
                                        </div>
                                                                                
                                    </div>
                                    
                                </div>

                            </div>
                            
                        </div>
                        
                    </div>

                    <div class="col-xs-12 col-md-12 admin-form-row">
                    
                        <div class="col-xs-12 col-md-4 no-pad-left">
                        	
                            <div class="form-group">

                                                         
                            </div>
                
                        </div>
                        
                        <div class="col-xs-12 col-md-7 no-pad-left">
                        	
                            <div class="form-group admin-form-setup" style="border-bottom:none;">
                                 
                                <button type="submit" class="btn btn-primary">Done</button>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </form>
            
            </div>
        
        </div>
    
    </section>
    
  </div>
  
<script type="text/javascript">
//<![CDATA[
var option_count		= <?php echo $counter?>;

var option_value_count	= <?php echo $_SESSION['option_value_count'];//$GLOBALS['option_value_count'];?>

//]]>
</script>
<?php


function add_option($po, $count)
	{
		ob_start();
	
	echo '<tr id="option-'.$count.'">
		<td>
			<a class="handle btn btn-mini"><i class="icon-align-justify"></i></a>
			<strong><a class="option_title" href="#option-form-'.$count.'">'.$po->type.''; echo (!empty($po->name))?' : '.$po->name:'';
			echo '</a></strong>
			<button type="button" class="btn btn-mini btn-danger pull-right" onclick="remove_option('.$count.');"><i class="icon-trash icon-white"></i></button>
			<input type="hidden" name="option['.$count.'][type]" value="'.$po->type.'" />
			<div class="option-form" id="option-form-'.$count.'">
				<div class="row-fluid">
				
					<div class="span10">
						<input type="text" class="span10" placeholder="Option Name" name="option['.$count.'][name]" value="'.$po->name.'"/>
					</div>
					
					<div class="span2" style="text-align:right;">
						<input class="checkbox" type="checkbox" name="option['.$count.'][required]" value="1"';  echo ($po->required)?'checked="checked"':''; echo '/> Required
					</div>
				</div>';
				if($po->type!='textarea' && $po->type!='textfield'):
				echo '<div class="row-fluid">
					<div class="span12">
						<a class="btn" onclick="add_option_value('.$count.');">Add Option Item</a>
					</div>
				</div>';
				 endif;
				echo '<div style="margin-top:10px;">

					<div class="row-fluid">';
						if($po->type!='textarea' && $po->type!='textfield'):
						echo '<div class="span1">&nbsp;</div>';
					 endif;
					echo '<div class="span3"><strong>&nbsp;&nbsp;Name</strong></div>
						<div class="span2"><strong>&nbsp;Value</strong></div>
						<div class="span2"><strong>&nbsp;Weight</strong></div>
						<div class="span2"><strong>&nbsp;Price</strong></div>
						<div class="span2"><strong>&nbsp;'; echo ($po->type=='textfield')?'Limit':'';echo '</strong></div>
					</div>
					<div class="option-items" id="option-items-'.$count.'">';
					if($po->values):
						session_start();
						foreach($po->values as $value)
						{
							$value = (object)$value;
							$this->add_option_value($po, $count, $_SESSION['option_value_count'], $value);
							$_SESSION['option_value_count']++;
						}
					endif;
					echo '</div>
				</div>
			</div>
		</td>
	</tr>';
    
    	$stuff = ob_get_contents();
	
		ob_end_clean();
		
		echo $this->replace_newline($stuff);
	}

 ?>