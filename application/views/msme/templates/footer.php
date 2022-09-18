 <style>
 
 #notification {
    position:fixed;
    bottom:0px;
    width:100%;
    z-index:105;
    text-align:center;
    font-weight:normal;
    font-size:14px;
    font-weight:bold;
    color:white;
    background-color:#FF7800;
    padding:5px;
}
#notification span.dismiss {
    border:2px solid #FFF;
    padding:0 5px;
    cursor:pointer;
    float:right;
    margin-right:10px;
}
#notification a {
    color:white;
    text-decoration:none;
    font-weight:bold
}


</style>
 
<!--<audio id="notifisound" src="<?php echo base_url(); ?>asset/audio/zickienotification.wav" preload="auto"></audio>
--> 
  <footer class="main-footer">
    
    
    <div class="pull-right hidden-xs">
     	
        <img src="<?php echo base_url(); ?>asset/images/logo-white.png" height="30px" />
        
    </div>
    
    <strong>Copyright &copy;<?php echo date('Y') ?> 1community</strong> All rights
    reserved. <!--| <span>Designed and Developed by <a href="https://www.aeriksoftsolutions.com/" target="_blank" style="color:#fff; font-weight:600; text-decoration:none;">Aerik-soft Solutions</a></span>-->
    
  </footer>

 <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
   
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
     
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
   
    </ul>
    
    <!-- Tab panes -->
    <div class="tab-content">
     
      
    </div>
    
  </aside>
  <!-- /.control-sidebar -->
  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  
    <div id="notification" style="display: none;">
    
      <span class="dismiss">
      	<a title="dismiss this notification">x</a>
      </span>
      
      <div id="notificationhldr" class="">
      	
      </div>
    
    </div>

</div>
<!-- ./wrapper -->

<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Morris.js charts -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/raphael/raphael.min.js"></script>
<!--<script src="<?php echo base_url() ?>asset/adminlte/bower_components/morris.js/morris.min.js"></script>
-->
<!-- Sparkline -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jvectormap -->
<script src="<?php echo base_url() ?>asset/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url() ?>asset/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- jQuery Knob Chart -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>

<!-- daterangepicker -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- datepicker -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url() ?>asset/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- CK Editor -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/ckeditor/ckeditor.js"></script>

<!-- Slimscroll -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/fastclick/lib/fastclick.js"></script>

<script src="<?php echo base_url() ?>asset/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

 


<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script> 

<!-- Select2 -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>asset/adminlte/dist/js/adminlte.min.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url() ?>asset/adminlte/dist/js/pages/dashboard.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>asset/adminlte/dist/js/demo.js"></script>

<!-- iCheck 1.0.1 -->
<script src="<?php echo base_url() ?>asset/adminlte/plugins/iCheck/icheck.min.js"></script>

<!--custom js file for admin -->
<script src="<?php echo base_url(); ?>asset/js/jquery-migrate-1.3.0.js"></script>

<script src="<?php echo base_url(); ?>asset/js/usercore.js"></script>

<!-- ChartJS -->
<script src="<?php echo base_url() ?>asset/adminlte/bower_components/chart.js/Chart.js"></script>


<script src="<?php echo base_url(); ?>tinymce/tinymce.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>asset/js/bootbox.min.js"></script>




<script>
  $(function () {
	  
	//Date picker
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	});
	
    //$('#example1').DataTable();
	
	//Initialize Select2 Elements
    $('.select2').select2();
	
	//iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });
	
	$(".dismiss").click(function(){
		
		$("#notification").fadeOut("slow");
		
		$('#notificationhldr').html('');
		
	});
	
  })
</script>


<?php
if(base_url() == 'http://localhost/1community/')
{
	
}else{
	
?>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-170462798-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	
	  gtag('config', 'UA-170462798-1');
	</script>



<?php

}

?>
        
</body>
</html>
