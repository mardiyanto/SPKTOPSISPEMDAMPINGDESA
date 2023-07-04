  </div>
		 
</div><!-- #main -->
   <div id="footer">
    
        <div id="copyrights">
            Copyright, <a href="index.php">SPK <?=$r3['foto']?> <?=$saiki?></a>, Networks All Rights Reserved.</div>
    </div><!-- #footer -->
    
</div><!-- #container -->
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="tema1/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="tema1/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="tema1/assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="tema1/assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
    <script src="tema1/assets/libs/js/main-js.js"></script>
	<script src="tema1/js/bootstrap-datepicker.js"></script>
	<script src="tema1/css/colorpicker/bootstrap-colorpicker.min.js"></script>
	<script>
  $(function () {
    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();
	 //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
  });
</script>	
</body>

 
</html>

<?php
if(isset($pdo)) {
	// Tutup Koneksi
	$pdo = null;
}
?>