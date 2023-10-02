/*
plugin buat export excel. 
note: copy both jquery.export2excel.js and export.xls.php to ur working directory before using it.
Author:
@email: whoget@gmail.com
*/
(function($){
    $.ExportXLS = function(urlsource,settings){
			var config = {
				'filename': 'test.xls',
				'urlAction': 'export/xls/',
				'debug':false
			};
			
			if (settings){$.extend(config, settings);}
	 
			//var filename="test111.xls";
				var filename=config.filename;
				var url=urlsource;
				var divStyle='';
				
				//var url="padi_komoditi_sub_komoditi_bulan.php?bulan=5&tahun=2011";
				//cek div for load content is exists
				if ( $('#divLoadTable').length > 0 ){
				}else{
					$('<div id="divLoadTable" name="divLoadTable">').appendTo('body');
				}
				
				if ( $('#frmExcel').length > 0 ){
				}else{
					$('<form id="frmExcel" name="frmExcel" method="post" target="ifrmExcel" action="'+ config.urlAction +'">').appendTo('body');
					
					$('<input>').attr({
						type: 'text',
						id: 'tbl',
						name: 'tbl',
						value:''
					}).appendTo('#frmExcel');
					
					$('<input>').attr({
						type: 'text',
						id: 'filename',
						name: 'filename',
						value: filename
					}).appendTo('#frmExcel');
				}
				
				if ( $('#ifrmExcel').length > 0 ){
				}else{
					$('<iframe id="ifrmExcel" name="ifrmExcel" src="" width="500px" height="400px">').appendTo('body');
				}
				
				if(config.debug==true){
					$("#iframeExcel").show();
					$("#divLoadTable").show();
					$("#frmExcel").show();
				}else{
					$("#iframeExcel").hide();
					$("#iframeExcel").css("display","none");
					$("#divLoadTable").hide();
					$("#frmExcel").hide();
				}
				
				//cek form is exist
				$('#divLoadTable').load(url,function(){
					$("#divLoadTable table").attr("border","1");	
					//$("#frmExcel > #tbl").val($("#divTable").html());
					$("#frmExcel > #tbl").val($("#divLoadTable").html());
					
					$("#frmExcel").submit();	
				});
				
	 
			return false;
		};
	})(jQuery);
	
	(function($){
    	$.fn.ExportXLS = function(urlsource,settings){
			var config = {
				'filename': 'test.xls',
				'urlAction': 'export.xls.php',
				'debug':false
			};
			
			if (settings){$.extend(config, settings);}
 			
			return this.each(function() {
			  	$(this).click(onClick);
			});

    		function onClick() {
      			//var filename="test111.xls";
				var filename=config.filename;
				var url=urlsource;
				//var url="padi_komoditi_sub_komoditi_bulan.php?bulan=5&tahun=2011";
				//cek div for load content is exists
				if ( $('#divLoadTable').length > 0 ){
				}else{
					$('<div id="divLoadTable" name="divLoadTable">').appendTo('body');
				}
				
				if ( $('#frmExcel').length > 0 ){
				}else{
					$('<form id="frmExcel" name="frmExcel" method="post" target="ifrmExcel" action="'+ config.urlAction +'">').appendTo('body');
					
					$('<input>').attr({
						type: 'text',
						id: 'tbl',
						name: 'tbl',
						value:''
					}).appendTo('#frmExcel');
					
					$('<input>').attr({
						type: 'text',
						id: 'filename',
						name: 'filename',
						value: filename
					}).appendTo('#frmExcel');
				}
				
				if ( $('#ifrmExcel').length > 0 ){
				}else{
					$('<iframe id="ifrmExcel" name="ifrmExcel" src="" width="500px" height="400px">').appendTo('body');
				}
				
				if(config.debug==true){
					$("#iframeExcel").show();
					$("#divLoadTable").show();
					$("#frmExcel").show();
				}else{
					$("#iframeExcel").hide();
					$("#divLoadTable").hide();
					$("#frmExcel").hide();
				}
				
				//cek form is exist
				$('#divLoadTable').load(url,function(){
					$("#divLoadTable table").attr("border","1");	
					//$("#frmExcel > #tbl").val($("#divTable").html());
					$("#frmExcel > #tbl").val($("#divLoadTable").html());
					
					$("#frmExcel").submit();	
				});
				
      			return this;
    		}
		
		};
	
	})(jQuery);
	
	
	
	(function($){
    	$.fn.Export2XLS = function(settings){
			var config = {
				'filename': 'test.xls',
				'urlAction': 'export/xls/',
				'content': ''
			};
			if (settings){$.extend(config, settings);}
			
			return this.each(function() {
				var filename=config.filename;
				var content=config.content;
				//alert(filename);
				if ( $('#frmExcel').length > 0 ){
				}else{
					$('<form id="frmExcel" name="frmExcel" method="post" target="ifrmExcel" action="'+ config.urlAction +'" style="display:none">').appendTo('body');
					
					$('<input>').attr({
						type: 'text',
						id: 'tbl',
						name: 'tbl',
						value:''
					}).appendTo('#frmExcel');
					
					$('<input>').attr({
						type: 'text',
						id: 'filename',
						name: 'filename',
						value: filename
					}).appendTo('#frmExcel');
				}
				
				$("#filename").val(filename);
				
				if ( $('#ifrmExcel').length > 0 ){
				}else{
					$('<iframe id="ifrmExcel" name="ifrmExcel" src="" width="500px" height="400px" style="display:none">').appendTo('body');
				}
				
				//$("#frmExcel > #tbl").val($("body",$(this)).html());
				//$("table",$(this)).attr("border","1");
				if(content.length>0){
					$("#frmExcel > #tbl").val(content);
				}else{
					$("#frmExcel > #tbl").val($(this).html());
				}
				
				$("#frmExcel").submit();
				
      			//return false;
			});

    		
		};
	
	})(jQuery);
	