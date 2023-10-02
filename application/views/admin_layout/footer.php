	<footer class="hidden-print">Version 1.0</footer>
		
	<? $this->load->view("admin_layout/footer_js")?>
	<script>
	var plot1;
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
	$(function() {
	 
		var sparklineLogin = function() {
			$('.linechart2').each(function(){
				var sbox = $(this).closest('*[class^="stats"]');
				var scolor = sbox.css('color');
				var data = $(this).attr("data-values");
				$(this).sparkline(data.split(","), {
					width: "100%",
					height: 25,
					lineColor: "#777",
					fillColor: !1,
					spotColor: scolor,
					maxSpotColor: !1/*'#b9e672'*/,//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
					minSpotColor: !1/*'#FA5833'*/,//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
					spotRadius: 3,
					highlightLineColor: !1,
					lineWidth: 1.5
				});
			});
		}
		var sparkResize;
	 
		$(window).resize(function(e) {
			clearTimeout(sparkResize);
			sparkResize = setTimeout(sparklineLogin, 500);
		});
		sparklineLogin();
	});
	$(document).ready(function () {
		$("#search-reset").click(function(e){
			e.preventDefault();
			location=document.URL.split("?")[0];
		});
		$('#main-menu-toggle,.task-status').tooltip();
		$('#recent a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		})
		$('#tasks').sortable({
			revert:true,
			forceHelperSize:true,
			placeholder: 'tasklist-placeholder',
			forcePlaceholderSize:true,
			tolerance:'pointer',
			stop: function( event, ui ) {//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
				$(ui.item).css('z-index', 'auto');
			}
			}
		);
		$('#tasks').disableSelection();
				
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('.calendar-small').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'today,month,agendaWeek,agendaDay'
			},
			editable: true,
			events: [
				{
					title: 'All Day Event',
					start: new Date(y, m, 1)
				},
				{
					title: 'Long Event',
					start: new Date(y, m, d-5),
					end: new Date(y, m, d-2),
					color: 'red'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: new Date(y, m, d-3, 16, 0),
					allDay: false
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: new Date(y, m, d+4, 16, 0),
					allDay: false
				},
				{
					title: 'Meeting',
					start: new Date(y, m, d, 10, 30),
					allDay: false
				},
				{
					title: 'Lunch',
					start: new Date(y, m, d, 12, 0),
					end: new Date(y, m, d, 14, 0),
					allDay: false
				},
				{
					title: 'Birthday Party',
					start: new Date(y, m, d+1, 19, 0),
					end: new Date(y, m, d+1, 22, 30),
					allDay: false
				},
				{
					title: 'Click for Google',
					start: new Date(y, m, 28),
					end: new Date(y, m, 29),
					url: 'http://google.com/'
				}
			]
		});
		
		$('#daterange').daterangepicker(
			{opens:'left',format:'D/MM/YYYY'},
            function (start, end) {
                $('#daterange span').html(start.format('D/MM/YYYY') + ' - ' + end.format('D/MM/YYYY'));
			}
		);
		//$('#daterange span').html(moment().subtract('days', 29).format('MM/D/YYYY') + ' - ' + moment().format('MM/D/YYYY'));
        $('#daterange').show();
		
		$(".linechart").sparkline("html", {
			width: "100%",
			height: 25,
			lineColor: "#777",
			fillColor: !1,
			spotColor: !1,
			maxSpotColor: '#b9e672',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
			minSpotColor: '#FA5833',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
			spotRadius: 3,
			highlightLineColor: !1,
			lineWidth: 1.5
		});
		$('.linechart2s').each(function(){
			var sbox = $(this).closest('*[class^="stats"]');
			var scolor = sbox.css('color');
			$(this).sparkline('html', {
				width: "100%",
				height: 25,
				lineColor: "#777",
				fillColor: !1,
				spotColor: scolor,
				maxSpotColor: !1/*'#b9e672'*/,//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
				minSpotColor: !1/*'#FA5833'*/,//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
				spotRadius: 3,
				highlightLineColor: !1,
				lineWidth: 1.5
			});
		});
		$('.bulletchart').each(function(){
			var sbox = $(this).closest('*[class^="stats"]');
			var scolor = sbox.css('color');
			$(this).sparkline([1000,1100,1200,900,600], {
				width: "100%",
				height: 25,
				performanceColor: scolor,
				rangeColors: ['#eee','#ddd','#ccc'],
				type: 'bullet'
			});
		})
		$(".boxchart").each(function(){
			var sbox = $(this).closest('*[class^="stats"]');
			var scolor = sbox.css('color');
			var spl = $(this).html().split(",");
			var bWidth = ($(this).width()/(spl.length+1));
			$(this).sparkline("html", {
				width: "100%",
				height: 25,
				barWidth: bWidth,
				barColor: "#aaa",
				type:"bar"
			});
		});
		$(".piechart").easyPieChart({
			barColor: "#aaa",
			trackColor: "#ccc",
			scaleColor: false,
			lineCap: 'butt',
			lineWidth: parseInt(50/10),
			animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
			size: 50
		});
		//INFOBOX
		$(".iblinechart").sparkline("html", {
			width: 60,
			height: 30,
			lineColor: "#058DC7",
			fillColor: "#eee",
			spotColor: "#999",
			maxSpotColor: '#b9e672',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
			minSpotColor: '#FA5833',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
			spotRadius: 3,
			lineWidth: 1.5
		});
		$(".iblinechart2").sparkline("html", {
			width: 70,
			height: 25,
			lineColor: "#777",
			fillColor: "#ddd",
			spotColor: "#999",
			maxSpotColor: '#b9e672',//The CSS colour of the marker displayed for the maximum value. Set to false or an empty string to hide it
			minSpotColor: '#FA5833',//The CSS colour of the marker displayed for the mimum value. Set to false or an empty string to hide it
			spotRadius: 2,
			lineWidth: 1
		});
		$(".ibboxchart").sparkline("html", {
			width: 60,
			height: 30,
			barColor: "#aaa",
			type:"bar"
		});
		$(".ibpiechart").each(function(){
			var sbox = $(this).closest('.info-box');
			var scolor = sbox.css('color');
			$(this).easyPieChart({
				barColor: scolor,
				trackColor: "#ddd",
				scaleColor: false,
				lineCap: 'butt',
				lineWidth: parseInt(40/10),
				animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
				size: 40
			});
		})
		$('.dbpiechart').each(function(){
			var sbox = $(this).closest('.circle-stats');
			var scolor = sbox.css('color');
			$(this).easyPieChart({
				barColor: scolor,
				trackColor: "#ddd",
				lineCap: 'butt',
				lineWidth: parseInt(90/10),
				animate: /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000
			});
		})
		$('ul.nav-list a.dropdown-toggle').click(function (e) {
			e.preventDefault();
			var d = $(this).next().get(0);
			var u = $(this).closest("ul");
			
			if (!$(d).is(":visible")) {
				u.find("> .open > .submenu").each(function() {
					if (!$(d).parent().hasClass("active")) {
						$(this.parentNode).hasClass("active") || $(this).slideUp(200).parent().removeClass("open");
					}
				});
			}
			$(d).slideToggle(200).parent().toggleClass("open");
		})
	})
	</script>
    <!--<script type="text/javascript" src="assets/js/chart-example.js"></script>-->
</body>
</html>