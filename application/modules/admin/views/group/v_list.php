<?php 
if ($_POST['uo'] || $_POST['sort'] || $_POST['q']) {
	$class_toggle=" active";
	$class_content="";
}
else {
	$class_toggle="";
	$class_content="none";
}

?>
<section class="content-header">
  <h1 class="hidden-xs">
    GROUP
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
  </ol>
</section>
<section class="content">
    <div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
            <!-- TOOLBAR -->
            <div class="content-toolbar">
                <a class="btn btn-white active" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="List">
                    <i class="fa fa-list"></i>
                </a>
                <a class="btn btn-white" href="<?php echo $this->module?>add<?=$query_str?>" data-toggle='tooltip' data-original-title="Tambah Data">
                    <i class="fa fa-plus"></i>
                </a>	  
                <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="Refresh">
                    <i class="fa fa-refresh"></i>
                </a>
            </div>
            <!-- END: TOOLBAR -->
        	<div class="box box-widget">
            	<div class="box-header with-borders">
                	<div class="row">
                        <div class="col-md-11 col-xs-9">
                        <form class="form-inline" action="<?=$this->module?>" method="get">
                        <div class="form-group">
                            <input type="hidden" name="t" id="t" value="<?=$tab_active?>">
                            <button type="reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-circle-o-notch"></i></button>
                          </div>
                          <div class="form-group">
                            <?php $this->load->view("widget/search_box_db"); ?>
                          </div>
                          <button type="submit" class="btn btn-white">Search</button>
                        </form>
                        </div>
                        <div class="col-md-1 hidden">
                            <div class="btn-group pull-right">
                            	<a class="btn btn-transparent" href=""> <i class="fa fa-question"></i> Help</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <?php 
					/* 
					   ditaro diatas supaya tabel dapet offset dr pagination, 
					   digunakan untuk penomoran tabel 
					*/
					$page_link=$this->pagination->create_links(); 
					$offset=$this->pagination->cur_page>0?($this->pagination->cur_page-1) * $this->pagination->per_page:0;
				?>
                <div class="box-body table-responsive">
                <table class="table table-bordered table-condensed small-font">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Group</th>
                            <th>Deskripsi</th>
                            <th style="width:70px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$value):
                                    $id=$this->encrypt_status==TRUE?encrypt($value[$this->tbl_idx]):$value[$this->tbl_idx];
                            ?>
                                <tr>
                                    <td><?php echo $offset+$x+1?>.</td>
                                    <td><?php echo $value["name"]?></td>
                                    <td><?php echo $value["description"]?></td>
                                    <td>
										<div class="btn-group btn-group-xs">
                                        <a class="btn btn-xs btn-default" href="<?=$this->module?>edit/<?=$id?>"><i class="fa fa-pencil green"></i></a> 
                                        <a class="btn btn-xs btn-default" onclick="dF('<?=$id?>','<?php echo $value["name"]?>');"><i class="fa fa-remove red"></i></a>
										</div>
									</td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
                </div>
                <!--end: box body-->
                <div class="box-footer clearfix">
                    <div class="row">
                        <div class="col-md-8 col-xs-12">
                            <div style="vertical-align:middle;line-height:25px">
							<?php 
								$to_page=$this->pagination->cur_page * $this->pagination->per_page;
								$from_page=($to_page-$this->pagination->per_page+1);
                                if($from_page>$to_page):
                                    $from_page=1;
                                    $to_page=$from_page;
                                endif;
                                $total_rows=$this->pagination->total_rows;
                                if($to_page>1):
                                    echo "Displaying : ".$from_page." - ".$to_page." of ". 
                                            $this->pagination->total_rows." entries";
                                endif;
                                if($to_page<=1):
                                    echo "Displaying : 1 of ". 
                                            $this->pagination->total_rows." entries";		
                                endif;		
                            ?>,
                            <?php
                        $arrPerPageSelect=array(
                                5=>5,
                                10=>10,
                                25=>25,
                                50=>50,
                                -1=>"All"
                            );
                            $pp=$perPage;
                        ?>
                        Rows/page: <label><?=form_dropdown("pp_select",$arrPerPageSelect,$pp,"id='pp_select' class='form-control input-sm'")?></label>
                        <input type="hidden" id="pp" name="pp" value="" />
                            
                             </div>
                        </div><!-- end span 6-->
                        <div class="col-md-4 col-xs-12">
            
                                <?php echo $page_link; ?>
            
                        </div><!-- end span 6-->
                    </div>
                    <!-- end class well -->
                </div>
            </div>
        </div>
    </div>
</section>
<form id="delfrm" name="delfrm" method="post" action="<?=$this->module?>del/">
<input type="hidden" name="act" value="delete" />
<input type="hidden" name="id" id="idx" />
</form>
<script>
function dF(id,nm) {
    var r = confirm("Hapus Group \""+nm+"\" ?!!");
    if (r == true) {
		$("#idx").val(id);
        $("#delfrm").attr("action",$("#delfrm").attr("action")+id).submit();
    } else {
        return false
    }
}
</script>
<script>
	$(function(){
		$(".pagination .active a").click(function(e){
			e.preventDefault();
		});
		
		$("#pp_select").change(function(){
			var pp=parseInt($(this).find("option:selected").val());
			if(pp<0){
				location=document.URL.split("?")[0];
				return false;
			}
			get_query();
		});
		
		$("#frm-search").submit(function(e){
			e.preventDefault();
			get_query();
		});
		$("#filter_toggle").click(function(){
			$(this).toggleClass("active");
			$("#filter_content").slideToggle();
		});
		
		$("#propinsi").change(function(){
			$("#kabupaten").html('<option>--loading--<option>');
			var kd_prop=$("#propinsi option:selected").val()||$("#propinsi").val();
	
			kd_prop=kd_prop?kd_prop:'x';
			$.get("common/service/lookup_kota/"+kd_prop,function(ret){
				$("#kabupaten").html(ret);
			});
		});
	});
	
	
	function get_query(){
			var q =$("#q").val()||"";
			var perPage=$("#pp_select option:selected").val();
			$("#pp").val(perPage);
			var pp =$("#pp").val()||"";
			
			
			var data=[];
			if(q){
				data.push("q="+q);
			}
			
			if((pp)&&(pp!=25)){
				data.push("pp="+pp);
			}
			var param='';
			if(data){
				param="?"+data.join("&");
			}
			var url=document.URL.split("?")[0];
			location=url+param;
	}
</script>
