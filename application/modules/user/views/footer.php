<div id="ajax_loader" style="display:none"><span class="ajax_loader_content" style="padding-left:3px">&nbsp;</span><?=image_asset("ajax-loader-bar.gif")?></div>
<div class="loading xactive" style="display:none;">
    <span>Processing....</span>
</div>
<script>
	$(document)
		.ajaxStart(function(){
    			$(".ajax_progress").html($("#ajax_loader").html());
				$(".ajax_progress").show();
				$(".loading.xactive").fadeIn();
		})
		.ajaxStop(function(){
    			$(".loading.xactive").fadeOut();
				$(".ajax_progress").hide();
		});
	
	$(function(){
		$("#a_loading").click(function(e){
			e.preventDefault();
			loading_toggle();	
			
		});
	});
	
	function loading_enabled(){
		$(".loading").addClass("xactive");
	}
	
	function loading_disabled(){
		$(".loading.xactive").removeClass("xactive");
	}
	
	
	function loading_toggle(){
		if($(".loading.xactive").length>0){
				$(".loading.xactive").removeClass("xactive");
		}else{
				$(".loading").addClass("xactive");
		}
	}
</script>

<script>
	$(function(){
		   $(".asterix").remove();
		   
		   $(".required").each(function(i){
				$(this).parents(".control-group").find(".asterix").remove();
				$(this).parents(".control-group").find(".control-label").append("<span class='asterix'>&nbsp;*</span>");
		   });
	});
</script>
</body>
</html>
