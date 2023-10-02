<script>

	
	$(document).ready(function(){
		swapValues = [];
    	$(".swap_value").each(function(i){
        swapValues[i] = $(this).val();
        $(this).focus(function(){
            if ($(this).val() == swapValues[i]) {
                $(this).val("");
            }
        }).blur(function(){
            if ($.trim($(this).val()) == "") {
                $(this).val(swapValues[i]);
            }
        });
    	});
	
		$("#go").click(function(){
			$("#action1").val("search");
			$("#form1").attr("action","<?=$_SERVER['PHP_SELF']?>");
			$("#form1").submit();
		});
		
		
		$("#s").bind("keypress", function(e) {
             if (e.keyCode == 13) {
                 //alert("enter");
				 $("#action1").val("search");
				 $("#form1").attr("action","<?=$_SERVER['PHP_SELF']?>");
				$("#form1").submit();
            }
        });
		
		
		
		
	});
</script>
<div id="search_box">
    			<!--<form id="search_form" method="post" action="/">-->
        		<input id="s" name="s" style="font-size:12px" value="Search" class="swap_value" type="text">
        		<input src="<?=$homeUrl?>css/images/search2_02.gif" id="go" title="Search" type="image" value="" width="25" height="25">
    			<!--</form>-->
</div>
