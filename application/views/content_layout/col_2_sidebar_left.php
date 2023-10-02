<style>
	#content{
		margin:0px;
		/*background:#FFF !important;*/
		padding-bottom:0px;
	}
	
	#breadcrumbs{
		border-bottom: 1px solid #E5E5E5 !important;
	}
	
	#page-sidebar-left{
		margin-top:-15px;
		height:100%;
		/*padding: 10px !important;*/
		padding-right:15px!important;
    	z-index: 2;
	}
	#page-sidebar-left.minified{
		/*display:none;*/
		/*margin-right: -40px;*/
   		width: 0px !important; /* icon close left */
		/*display:none;*/
	}
	
	#page-sidebar-left.minified .sidebar-content{
		/*display:none;*/
		display:none;
	}
	
	#page-sidebar-left .sb-toggle{
		position:absolute;
		/*right:-10px;*/
		right:-9px;
		/*top:10px;*/
		z-index:10;
	}
	
	#page-sidebar-left.minified .sb-toggle{
		/*margin-left:-60px;*/
		left:-10px;
		width:22px;
		/*width:30px;*/
	}
	
	#page-content{
		height:100%;
		min-height:380px;
		padding-left:30px;
	}
	
	#page-content:before {
		border-left: 1px solid #DBDEE0;
		content: "";
		height: 100%;
		left: 8px;
		position: absolute;
		top: 0;
		width: 1px;
		z-index: 1;
	}
	
	#page-content.minified{
		 /*border-left: 40px solid #E9EBEC;*/
		 width:100% ;
		 margin-right:1px!important;
		 padding-left:30px;
		 /*margin-left:-15px;*/
		 /*padding-left:0;*/
	}
</style>

<div class="row" style="padding-top:0;">
   <div class="col-md-2" id="page-sidebar-left" style="padding:0px">
   			<a class="sb-toggle btn btn-transparent btn-xs box_shadow" href="#"><i class="icon-double-angle-left"></i> </a>
            <div class="sidebar-content">
				<?=$page_sidebar_left?$page_sidebar_left:"SIDEBAR"?>
        	</div>
   </div>
   
   <div class="col-md-10" id="page-content">
   			<? if($page_content_header):?>
   			<div class="page-header">
                <div class="row"> 
                    <div class="col-md-9">
                      <h1><?=$page_content_title?$page_content_title:"Page Title"?><small><?=$page_content_title_small?$page_content_title_small:" >>> Small"?></small>
                      </h1>
                    </div><!-- col -->
                      <div class="col-md-3">
                      </div><!-- col -->
                  </div><!-- row-->
            </div>
            
   			<div class="breadcrumbs-fixed" id="breadcrumbs">
            	<?php if(!$page_content_bread):?>
                <?php  
					$page_content_bread[]=array("url"=>"#","title"=>"Dashboard","active"=>FALSE);
					$page_content_bread[]=array("url"=>"logistik/master","title"=>"Master","active"=>FALSE);
					$page_content_bread[]=array("url"=>"","title"=>"Asset Tetap","active"=>TRUE);
				?>
                <?php endif;?>
            	<?php 
					print "<ul class='breadcrumb'>";
					foreach($page_content_bread as $x=>$val):
						if($val["active"]):
							print "<li class='active'>".$val["title"]."</li>";
						else:
							print "<li><a href='".$val["url"]."'>".$val["title"]."</a><span class='divider'></span></li>";
						endif;
					endforeach;
					print "</ul>";
				?>
            </div>
            <? endif;?>
            <? if($page_content_header):?>
            <div style="padding:10px 10px 0px">
            <? endif;?>
   				<?=$page_content?$page_content:"CONTENT";?>
            <? if($page_content_header):?>
            </div>
            <? endif;?>
   </div>
</div>    

<script>
	$(function(){
		$(".sb-toggle").click(function(e){
			e.preventDefault();
			$("#page-content").toggleClass("minified");
			$("#page-sidebar-left").toggleClass("minified");
			if($(this).find(".icon-double-angle-left").length>0){
				$(this).find("i").removeClass("icon-double-angle-left").addClass("icon-double-angle-right");
			}else{
				$(this).find("i").removeClass("icon-double-angle-right").addClass("icon-double-angle-left");
			}
			
		});
	});
</script>