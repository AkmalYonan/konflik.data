<?php
	if(cek_array($arrGroup2Modules)):
		foreach($arrGroup2Modules as $x=>$val):
			$dataACL[$val["group_id"]][$val["module_id"]]=$val["rights"];
		endforeach;
	endif;
	
?>
<section class="content-header">
  <h1>
    Account Manager
    <small>Access Control List</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url()?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>Account Manager</li>
    <li class="active">ACL</li>
  </ol>
</section>
<section class="content">
	
	<div class="row">
		<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
			<div class="box ">
            	<div class="box-header with-border clearfix">
                	<a class="btn btn-default acl_save" href="#">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-default" href="<?php echo $this->module?>">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <!--<a id="filter_toggle" class="btn btn-default" >
                        <i class="fa fa-search"></i> Search
                    </a>-->
                    
                </div>
			<!-- form start -->
				<div class="box-body no-padding">
					<div class="row">
							<div class="col-md-12">
							<form id="frm" method="post" action="<?php echo $this->module?>acl_save/">
									<div class="box-group" id="accordion">
                                    	<?=($arr)?>
										
									</div>
							
							</form>
					</div>
			
				</div>
			</div><!-- /.box-body -->	
		  </div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->	

	
</section><!-- end div positioning -->
<script>
	//komeng added
	$(function(){
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	});
	
	$(".acl_save").click(function(e){
		e.preventDefault();
		$("#frm").submit();
	});
	
	$(".rb.all").click(function(){
		var group=$(this).data("group");
		var right=$(this).data("right");
		$(".g_"+group+".r_"+right).each(function(){
			$(this).trigger("click");
		});
	});
	$(".rb.child").click(function(){
		var group=$(this).data("group");
		var right=$(this).data("right");
		var parent=$(this).data("module");
		$(".g_"+group+".r_"+right+".p_"+parent).each(function(){
			$(this).trigger("click");
		});
	});
</script>