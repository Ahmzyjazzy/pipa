<?php include('header.php');?>

<script type="text/javascript">

<?php if( $this->input->post('submit') ):?>
$(window).ready(function(){
	$('#iframe-exterior', window.parent.document).height($('body').height());
});

<?php endif;?>

<?php if($file_name):?>
	parent.add_product_exterior_image('<?php echo $file_name;?>');
<?php endif;?>

</script>

<?php if (!empty($error)): ?>
	
    <div class="alert alert-error">
	
    	<a class="close" data-dismiss="alert">×</a>
	
    	<?php echo $error; ?>
	
    </div>
    
<?php endif; ?>
	
<div class="col-md-12">

    <?php 
		
		echo form_open_multipart(base_url().'admin/exterior-image-upload', 'class="form-inline"');
	
		echo form_upload(array('name'=>'userfile', 'id'=>'userfile', 'class'=>'input-file'));
		
	?> 
    
        <input class="btn" name="submit" type="submit" value="Upload" />
    
    </form>
    
</div>

<?php include('footer.php');