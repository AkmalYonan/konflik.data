<script>
	/*
	$(function(){
		
		var windowHeight = document.documentElement.clientHeight;
		var menuHeight = 130+50+40;
		$('#frmtarget').closest(".box").css("padding-bottom",0);
		$('#frmtarget').closest("div").css("padding",5);
		if(navigator.appName == "Microsoft Internet Explorer"){
			$("body").css("max-height",windowHeight);
			
			$('#frmtarget').css('height', windowHeight);
		}
		else{
			$("body").css("max-height",windowHeight-menuHeight);
			$('#frmtarget').css('height',windowHeight-menuHeight);
		}
		
		//for resize of the window, recalculate the max-height available
		window.onresize = function(){
			windowHeight = document.documentElement.clientHeight;
			var menuHeight = 130+50+40;
			//menuHeight = document.getElementById("menu").clientHeight;
			$("body").css("max-height",windowHeight-menuHeight);
			$('#frmtarget').css('height',windowHeight-menuHeight);
		};
		
		
	});
	window.onresize = function(){
			windowHeight = document.documentElement.clientHeight;
			var menuHeight = 130+50+40;
			//menuHeight = document.getElementById("menu").clientHeight;
			$("body").css("max-height",windowHeight-menuHeight);
			$('#frmtarget').css('height',windowHeight-menuHeight);
		};
	*/
</script>
<style>
	* { margin: 0; padding: 0; }
	html{
		height:100%;
		
	}
	body {
		background:white none repeat scroll 0%;
		font-size: 12px;
		font-family:Arial,sans-serif;
		margin:0pt;
		height:100%;
		overflow:hidden;
	}
	
</style>

<? $id_mst=$this->encrypt_status==TRUE?encrypt($data["id_mst"]):$data["id_mst"];?>
<div class="row  no_print" >
	<div class="col-md-12">
    	<div class="pull-right">
        	<div class="btn-group">
            	<a href="/print" class="btn btn-default btn-xs a_print">Print HTML</a>
                <a href="javascript:void()" class="btn btn-primary btn-xs a_pdf">PDF</a>
                <a href="/print" class="btn btn-default btn-xs a_pdf_setting">PDF Setting</a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="formSep"></div>
<div style="display:none">
<form target="frmtarget" id="frmsetting" class="form-vertical" method="post" action="<?=base_url()?>export/proxy_pdf/">
<input type="hidden" id="filename" name="filename" class="input-xlarge" value="<?=$data["filename"]?>">
<input type="hidden" id="print_url" name="print_url" class="input-xlarge" value="<?=$data["print_url"]?>">
<input type="hidden" id="p" name="p" class="input-xlarge" value="<?=$data["p"]?>">
<input type="hidden" id="o" name="o" class="input-xlarge" value="<?=$data["o"]?>">


<input type="hidden" id="id_mst" name="id_mst" value="<?=$id_mst?>" />
<textarea id="tbl" name="tbl" style="width:100%;height:30%;display:none;" >
	<?=$data["tbl"]?>
</textarea>
</form>
</div>
<br>
<iframe id="frmtarget" name="frmtarget" src="" style="width:100%;height:100%;border:1px #CECECE solid;overflow:auto" >
</iframe>

<script>
	$(function(){
		var dim2 = windowDimensions();
		console.log(dim2);
	 	var frmtarget = $('#frmtarget'); // changed the code to use jQuery
    	frmtarget.height((dim2[1]-100) + "px");
		var frmheight=dim2[1]-50;
		
		function sizeIFrame() {
			var helpFrame = jQuery("#frmtarget");
			var innerDoc = (helpFrame.get(0).contentDocument) ? helpFrame.get(0).contentDocument : helpFrame.get(0).contentWindow.document;
			helpFrame.height(innerDoc.body.scrollHeight + 35);
		}
		
		
		
		setTimeout(function(){
			$("#frmsetting").submit();
			$("#frmtarget").load(function(){
				$(this).css("height",frmheight);
				//sizeIFrame();
				//alert($(this).prop("innerHeight"))
				//$(this).css("height", $(this).contents().height() + "px");
				//alert("loaded");	
			});	
			
		},100);
		$(".btn_set").click(function(){
			$("#frmsetting").submit();
			$("#frmtarget").load(function(){
				$(this).css("height",frmheight);
				//sizeIFrame();
				//$(this).css("height", $(this).contents().height() + "px");
				//alert("loaded");	
			});
		});
	});
</script>

<script>
	$(function(){
		/*
		$(".a_print").click(function(e){
			e.preventDefault();
			location="<?=$this->module?>print_preview"
		});
		*/
		/*
		$(".a_pdf").click(function(e){
			e.preventDefault();
			var base_url="<?=base_url()?>";
			var html=$("div#div_print").html();
			var file="surat_ijin_<?=preg_replace("/\s+/","_",strtolower($dataParent["judul"]))?><?="_".date("YmdHis").".html";?>";
			//UrlSubmit(base_url+"export/pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70});
			UrlSubmit(base_url+"export/proxy_pdf/",{target:'',filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70});
		});
		*/
		
		$(".a_print").click(function(e){
			e.preventDefault();
			var base_url="<?=base_url()?>";
			var module="<?=$this->module?>";
			var id_mst=$("#id_mst").val();
			var print_url=encodeURIComponent($("#print_url").val());
			var p=$("#p").val();
			var o=$("#o").val();
			var html=$("#tbl").val();
			var file="doc_<?=preg_replace("/\s+/","_",strtolower($dataParent["judul"]))?><?="_".date("YmdHis").".html";?>";
			//UrlSubmit(base_url+"export/pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70});
			UrlSubmit(base_url+module+"print_html/",{target:'',id_mst:id_mst,print_url:print_url,filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70,o:o,p:p});
		});
		
		$(".a_pdf_setting").click(function(e){
			e.preventDefault();
			var base_url="<?=base_url()?>";
			var module="<?=$this->module?>";
			var id_mst=$("#id_mst").val();
			var html=$("#tbl").val();
			var p=$("#p").val();
			var o=$("#o").val();
			
			
			var print_url=encodeURIComponent($("#print_url").val());
			var file="doc_<?=preg_replace("/\s+/","_",strtolower($dataParent["judul"]))?><?="_".date("YmdHis").".html";?>";
			UrlSubmit(base_url+module+"print_pdf_setting/",{id_mst:id_mst,print_url:print_url,filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70,o:o,p:p});
			//UrlSubmit(base_url+"export/pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70});
			/*UrlSubmit(base_url+"export/proxy_pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70});
			*/
		});
		
	});
	
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
	
	/*
	 var dim = windowDimensions();
    var iframTarget= $('#frmtarget'); // changed the code to use jQuery
    iframeTarget.height((dim[1]) + "px"); */
</script>

