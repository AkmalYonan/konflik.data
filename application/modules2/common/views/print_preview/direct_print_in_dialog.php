<? 
	$id_mst=$this->encrypt_status==TRUE?encrypt($data["idx"]):$data["idx"];
?>
<div class="row  no_print" >
	<div class="col-md-12">
    	<div class="pull-right">
        	<div class="btn-group">
            	<a href="/print" class="btn btn-primary btn-xs a_print">Print</a>
                <a href="/print" class="btn btn-default btn-xs a_pdf">PDF</a>
                <a href="/print" class="btn btn-default btn-xs a_pdf_setting">PDF Setting</a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="formSep"></div>
<input type="hidden" id="id_mst" name="id_mst" value="<?=$id_mst?>"/>
<input type="hidden" id="print_url" name="print_url" value="<?=$print_url?>"/>
<input type="hidden" id="p" name="p" class="input-xlarge" value="<?=$data["p"]?>">
<input type="hidden" id="o" name="o" class="input-xlarge" value="<?=$data["o"]?>">

<textarea id="tbl" name="tbl" cols="11" rows="11" style="display:none"><?=$data["tbl"]?></textarea>

<div id="div_print">
	<?php //echo $template;?>
    <?=$data["tbl"]?>
</div>

<iframe id="html_print" name="html_print" width="0" height="0" style="display:none">test</iframe>
<script>
	$(function(){
	 	//$("#div_print").html($("#tbl").val());
		/*
		$(".a_print").click(function(e){
			e.preventDefault();
			window.print();
		});
		*/
		
		$(".a_print").click(function(e){
			e.preventDefault();
			//window.print();
			var base_url="<?=base_url()?>";
			var module="<?=$this->module?>";
			var id_mst=$("#id_mst").val();
			var html=$("div#div_print").html();
			var p=$("#p").val();
			var o=$("o").val();
			
			var file="doc_<?=preg_replace("/\s+/","_",strtolower($dataParent["judul"]))?><?="_".date("YmdHis").".html";?>";
			UrlSubmit(base_url+"export/html_print/",{target:'html_print',filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70,o:o,p:p});
		});
		
		
		
		$(".a_pdf").click(function(e){
			e.preventDefault();
			var base_url="<?=base_url()?>";
			var module="<?=$this->module?>";
			var id_mst=$("#id_mst").val();
			var p=$("#p").val();
			var o=$("#o").val();
			
			var html=$("div#div_print").html();
			var print_url=encodeURIComponent($("#print_url").val());
			// var file="doc_<?=preg_replace("/\s+/","_",strtolower($dataParent["judul"]))?><?="_".date("YmdHis").".html";?>";
			var file="doc<?="_".date("YmdHis").".pdf";?>";
			//UrlSubmit(base_url+"export/pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70});
			UrlSubmit(base_url+module+"print_pdf",{target:'',id_mst:id_mst,print_url:print_url,filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70,o:o,p:p});
		});
		
		$(".a_pdf_setting").click(function(e){
			e.preventDefault();
			var base_url="<?=base_url()?>";
			var module="<?=$this->module?>";
			var id_mst=$("#id_mst").val();
			var p=$("#p").val();
			var o=$("#o").val();
			
			var html=$("div#div_print").html();
			var print_url=encodeURIComponent($("#print_url").val());
			// var file="doc_<?=preg_replace("/\s+/","_",strtolower($dataParent["judul"]))?><?="_".date("YmdHis").".html";?>";
			var file="doc<?="_".date("YmdHis").".pdf";?>";
			UrlSubmit(base_url+module+"print_pdf_setting/",{id_mst:id_mst,print_url:print_url,filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70,o:o,p:p});
			//UrlSubmit(base_url+"export/pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70});
			/*UrlSubmit(base_url+"export/proxy_pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70});
			*/
		});
		
	});
	
	
</script>
