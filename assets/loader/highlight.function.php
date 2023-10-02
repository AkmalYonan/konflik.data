<style>
	.static_div.fixed{
		background:white;
		position:fixed;
		left:0;
		top:40px;
		height:33px;
		width:100%;
		margin:auto;
		line-height:18px;
		padding-top:5px;
		padding-bottom:5px;
	}

	
</style>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/js/highlight/jquery_highlight.css">
<script src="<?=base_url()?>assets/js/highlight/jquery_highlight.js"></script>

<script>
	
	$(function(){
		var i=0;
		
		$(".goto_highlight").removeClass("btn-primary").addClass("disabled");
		$(".label.search_result").hide();
		$('.search_highlight').on('keyup change', function(ev) {
			// pull in the new value
			console.log($(this).val());
			var searchTerm = $(this).val();
	
			// remove any old highlighted terms
			$('table').removeHighlight();
	
			// disable highlighting if empty
			if ( searchTerm ) {
				// highlight the new term
				$('table').highlight( searchTerm );
			}
			i=0;
		});
		
		setInterval(function(){
			if($(".highlight").length>0){
				$(".goto_highlight").addClass("btn-primary").removeClass("disabled");
				if($(".label.search_result").is(":hidden")){
					$(".label.search_result").show();
				}
				
				$(".label.search_result").text("Hasil Pencarian:"+$(".highlight").size());
			}else{
				$(".goto_highlight").removeClass("btn-primary").addClass("disabled");
				$(".label.search_result").text("").hide();
			}
		},300);
		
		
		$(".goto_highlight").click(function(e){
			e.preventDefault();
			if($(".highlight").length>0){
				$('html, body').animate({
					scrollTop: $(".highlight").eq(i).offset().top-300
				}, 1000);
				i++;
			}
			
			
			return false;
		});	
	});
	
	
	$(function(){
 		  	var menuOffset = $('.static_div')[0].offsetTop; // replace #menu with the id or class of the target navigation
		 
		   $(document).bind('ready scroll',function(){
			   var docScroll = $(document).scrollTop()+40;
		 
			   if(docScroll >= menuOffset){
				   $('.static_div').addClass('fixed').addClass("box_quote").addClass("box_shadow");
				} else {
				   $('.static_div').removeClass('fixed').removeClass("box_quote").removeClass("box_shadow");
				}
			 
		   });
 
		});
</script>
