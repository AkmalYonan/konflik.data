(function( $ ){
	$.fn.latmenu = function( options ) {  
		var settings = {
			active:false,
			autoArrow: true
		};
		var o = $.extend( settings, options );
		
		//init
		/* menu with no child */
		var items = this.find("> li > a");
		$.each(items, function(i,val) {
			 /* menu with no child */
			if ($(this).parent().find(":has(li,div)").html()==null) { 
				items.eq(i).mouseenter(function() {
					items.eq(i).addClass("parent-selected"); 
				}).mouseleave(function() {
					items.eq(i).removeClass("parent-selected");
				})
			}
			/* menu with child */
			else { 
				if (o.autoArrow) items.eq(i).append('<span class="arrow"></span>');
				if(items.eq(i).parent().is("li")){
					items.eq(i).next().addClass("submenu");
				} else{
					items.eq(i).parent().find("ul").show();
				}
				items.eq(i).bind("mouseenter",hoverHandler).parent().bind("mouseleave",hoverHandler);
			}
		})
		/* menu with child 
		var items =this.find("> li > a");// this.find(":has(li,div) > a");
		$.each(items, function(i, val) {
			if (o.autoArrow) items.eq(i).append('<span class="arrow"></span>');
			if(items.eq(i).parent().is("li")){
				items.eq(i).next().addClass("submenu");
			} else{
				items.eq(i).parent().find("ul").show();
			}
		});
		items.bind("mouseenter",hoverHandler).parent().bind("mouseleave",hoverHandler);
		*/
		function hoverHandler(e){
			if(e.type == "mouseenter"){
				var c_submenu = $(e.target).parent().find(".submenu");
				if(c_submenu.html() == null){
					c_submenu = $(e.target).parent().next(".submenu");
				}
				if(c_submenu.html() != null){
					c_submenu.prev().addClass("parent-selected");
					c_submenu.css("z-index", "99");
				}
			}
			if(e.type == "mouseleave" || e.type == "mouseout"){
				c_submenu = $(e.target).parents();
				if(c_submenu.html() != null){
					c_submenu.parent().find("a").removeClass("parent-selected");
				}
			}
		}
		return this;
	}
})( jQuery );