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
 

  <footer class="main-footer">
    
    <div class="pull-right hidden-xs">
     
    </div>
    
    <strong>Copyright &copy;<?php echo date('Y') ?> <a target="_blank" href="#">PIPA</a>.</strong> All rights
    reserved.
    
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
  <div class="control-sidebar-bg">
  
  </div>
  
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
<script src="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Morris.js charts -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/raphael/raphael.min.js"></script>
<!--<script src="<?php echo base_url() ?>asset/adminlte/bower_components/morris.js/morris.min.js"></script>
-->
<!-- Sparkline -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jvectormap -->
<script src="<?php echo base_url() ?>asset/userlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url() ?>asset/userlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- jQuery Knob Chart -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>

<!-- daterangepicker -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- datepicker -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url() ?>asset/userlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- CK Editor -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/ckeditor/ckeditor.js"></script>

<!-- Slimscroll -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/fastclick/lib/fastclick.js"></script>

<script src="<?php echo base_url() ?>asset/userlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>asset/userlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- Select2 -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>asset/userlte/dist/js/adminlte.min.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url() ?>asset/userlte/dist/js/pages/dashboard.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>asset/userlte/dist/js/demo.js"></script>

<!-- iCheck 1.0.1 -->
<script src="<?php echo base_url() ?>asset/userlte/plugins/iCheck/icheck.min.js"></script>

<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script> 


<!--custom js file for admin -->
<script src="<?php echo base_url(); ?>asset/js/jquery-migrate-1.3.0.js"></script>

<!-- ChartJS -->
<script src="<?php echo base_url() ?>asset/userlte/bower_components/chart.js/Chart.js"></script>

<script>
  $(function () {
    $('#example1').DataTable();
	
	//$('#txnTBL1').DataTable();
	
	//Initialize Select2 Elements
    $('.select2').select2();
	
	//Date picker
    $('.datepicker').datepicker({
      autoclose: true
    })
	
	//iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
	
	$(".dismiss").click(function(){
		
		$("#notification").fadeOut("slow");
		
		$('#notificationhldr').html('');
		
	});
	
  })
</script>

<!-- Chat Script -->
<!--<script id="cid0020000245169924682" data-cfasync="false" async src="//st.chatango.com/js/gz/emb.js" style="width: 400px;height: 450px;">{"handle":"zickie-chatroom","arch":"js","styles":{"a":"33cc00","b":100,"c":"FFFFFF","d":"FFFFFF","k":"33cc00","l":"33cc00","m":"33cc00","n":"FFFFFF","p":"13.50","q":"33cc00","r":100,"pos":"br","cv":1,"cvfnt":"'Arial Rounded MT Bold', 'Helvetica Rounded', Arial, sans-serif, sans-serif","cvfntsz":"15px","cvfntw":"bold","cvbg":"33cc00","cvw":130,"cvh":30,"surl":0,"cnrs":"0.35","ticker":1}}</script>
-->

</body>
</html>
