<div class="modal fade" id="print_preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="myModalLabel">Print Preview</h4>

            </div>
            <div class="modal-body" style="height:100%">
                <div class="col" style="height:80%">
                	<iframe id="iframe_print_preview" name="iframe_print_preview" width="100%" height="100%" style="border:none" src=""></iframe>
                </div>
            </div>
            <div class="modal-footer hide">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
	$(function(){
		$('.div_id_print_modal').click(function(e){
			e.preventDefault();
			var base_url="<?=base_url()?>";
			//var url=$(this).attr("href");
			var divid=$(this).data("div_id")||"#div_print";
			var html=$(divid).html();
			var page_size=$(this).data("page_size")||'Folio';
			var page_orientation=$(this).data("page_orientation")||'P';
			
			
			var file="doc_<?=preg_replace("/\s+/","_",strtolower($dataParent["judul"]))?><?="_".date("YmdHis").".html";?>";
			$("#iframe_print_preview").attr("src","");
		    UrlSubmit(base_url+"common/print_html",{target:'iframe_print_preview',filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70,p:page_size,o:page_orientation});
			$('#print_preview').on('shown.bs.modal', function () {
				
			
				//$('iframe').attr("src",frameSrc);
				//$( ".modal" ).find( "iframe" )[ 0 ].src = url;
				//$("#iframe_print_preview").attr("src",url);
			});
			
			$('#print_preview').modal({show:true});
		});
	});
</script>

<script type="text/javascript">
        function windowDimensions() { // prototype/jQuery compatible
        var myWidth = 0, myHeight = 0;
        if( typeof( window.innerWidth ) == 'number' ) {
            //Non-IE or IE 9+ non-quirks
            myWidth = window.innerWidth;
            myHeight = window.innerHeight;
        } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
            //IE 6+ in 'standards compliant mode'
            myWidth = document.documentElement.clientWidth;
            myHeight = document.documentElement.clientHeight;
        } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
            //IE 5- (lol) compatible
            myWidth = document.body.clientWidth;
            myHeight = document.body.clientHeight;
        }
        if (myWidth < 1) myWidth = screen.width; // emergency fallback to prevent division by zero
        if (myHeight < 1) myHeight = screen.height; 
        return [myWidth,myHeight];
    }
    
	var dim = windowDimensions();
    myIframe = $('#iframe_print_preview'); // changed the code to use jQuery
    myIframe.height((dim[1]-100) + "px");
    
	
	</script>


	<? $this->load->view("admin_lte_layout/footer_js")?>
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
	 	$(".btn-save").click(function(e){
			e.preventDefault();
			$("#frm").submit();	
		});
		$("#tb_cancel").click(function(e){
			e.preventDefault();
			$(".tb_reset").trigger("click");	
		});
		
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
				
		$('#daterange').daterangepicker(
			{opens:'left',format:'D/MM/YYYY'},
            function (start, end) {
                $('#daterange span').html(start.format('D/MM/YYYY') + ' - ' + end.format('D/MM/YYYY'));
			}
		);
		//$('#daterange span').html(moment().subtract('days', 29).format('MM/D/YYYY') + ' - ' + moment().format('MM/D/YYYY'));
        $('#daterange').show();
		
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
</body>
</html>