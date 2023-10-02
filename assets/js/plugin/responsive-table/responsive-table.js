$(document).ready(function() {
  var switched = false;
  var updateTables = function() {
    if (($(window).width() < 767) && !switched ){
      switched = true;
      $("table.responsive").each(function(i, element) {
        splitTable($(element));
      });
      return true;
    }
    else if (switched && ($(window).width() > 767)) {
      switched = false;
      $("table.responsive").each(function(i, element) {
        unsplitTable($(element));
      });
    }
  };
   
  $(window).load(updateTables);
  $(window).bind("resize", updateTables);
   
	
	function splitTable(original)
	{
		original.wrap("<div class='table-wrapper' />");
		var width=0;
		original.find("th.fixed-column").each(function(){
				var idx=$(this).index()+1;		
				original.find("td:nth-child("+idx+")").addClass("fixed-column");
				width+=original.find("td:nth-child("+idx+")").width();
		});
		
		var copy = original.clone();
		if(original.find(".fixed-column").length<=0){
			copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
		}else{
			copy.find("td:not('.fixed-column'), th:not(.fixed-column)").css("display", "none");
		}
		
		copy.removeClass("responsive");
		copy.find('tr').each(function (i, elem) {
			var original_height=original.find('tr:eq(' + i + ')').height();
			var copy_height=$(this).height();
			if(original_height>copy_height){
    			$(this).height(original_height);
			}else{
				original.find('tr:eq(' + i + ')').height(copy_height+2.25);
			}
			
		});
		
		
		
		original.closest(".table-wrapper").append(copy);
		copy.wrap("<div class='pinned' />");
		$(".pinned").css("overflow-x","visible");
		
		original.wrap("<div class='scrollable' />");
	}
	
	function unsplitTable(original) {
    original.closest(".table-wrapper").find(".pinned").remove();
    original.unwrap();
    original.unwrap();
	}

});
