    <!-- Select2 -->
	<script src="assets/themes/lte2.3.0/plugins/select2/select2.full.min.js"></script>
    <!-- JQVM -->
	<script src="assets/themes/lte2.3.0/plugins/jqvm/jquery.vmap.min.js"></script>
    <!-- MomentJS: place above daterangepicker & fullcalendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <!-- daterangepicker -->
    <script src="assets/themes/plugins/daterangepicker-2.1.24/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="assets/themes/lte2.3.0/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- fullCalendar -->
    <script src='assets/themes/lte2.3.0/plugins/fullcalendar/fullcalendar.min.js'></script>
    <script src='assets/themes/lte2.3.0/plugins/fullcalendar/locale/id.js'></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="assets/themes/lte2.3.0/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="assets/themes/lte2.3.0/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="assets/themes/lte2.3.0/plugins/fastclick/fastclick.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="assets/themes/lte2.3.0/plugins/iCheck/icheck.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/themes/lte2.3.0/dist/js/app.min.js"></script>
    
<script>
	var api_server="<?//=get_server()?>";
      $(function () {
         //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
		$('input[type="checkbox"].flat-green, input[type="radio"].flat-green').iCheck({
		  checkboxClass: 'icheckbox_flat-green',
		  radioClass: 'iradio_flat-green'
		});
      })
</script>


