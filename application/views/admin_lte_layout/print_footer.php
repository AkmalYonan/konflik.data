	<!--<footer class="hidden-print">Version 1.0</footer>-->
	<? $this->load->view("admin_lte_layout/footer_js")?>
	<script>
		function resized() {
		var wh = $(window).width();
		$("#debug").html(wh);
		var mb = $("#main-menu-toggle").hasClass("sidebar-minified");
		var mc = $("#main-menu-toggle").hasClass("close");
		if (wh<992 && mb) { 
			$("body").removeClass("sidebar-minified");
			$("#main-menu-toggle").removeClass("sidebar-minified").addClass("open");
			$("#content").addClass("full");
			
			$("#content").removeClass("sidebar-minified"); 
			$("#sidebar-left").removeClass("minified").show();
			$("#sidebar-left > div > ul > li > a > .chevron").removeClass("opened").addClass("closed");
			$("#sidebar-left > div > ul > li > a").removeClass("open")
		};
		if (wh>767 && !mc) { 
			$("#content").removeClass("full");
		};

	}
	$(window).resize(function(){
		resized()
	});
	</script>
</body>
</html>