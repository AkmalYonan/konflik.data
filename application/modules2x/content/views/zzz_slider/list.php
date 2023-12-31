<?$result = ($key)?"Keywords: <strong>".$key."</strong>":"&nbsp;"; ?>

<div class="row">
    <div class="col-sm-12 col-lg-12">
        <!-- start: page header -->
        <div class="page-header">
            <div class="row"> 
                <div class="col-md-12">
                    <h1>Daftar<small> Carausel</small></h1>
                </div><!-- col -->
              </div><!-- row-->
        </div><!-- end: page-header -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
            <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li><a href="<?=base_url()?>admin/slider">Content</a> <span class="divider"></span></li>
			<li><a href="<?=base_url()?>admin/slider"><?=$this->module_title?></a> <span class="divider"></span></li>
            <li class="active">List</li>
         </ul>
        <!-- end: breadcrumbs -->
   </div><!-- cols -->
</div> <!-- row -->
<?php echo message_box();?>                      
<div style="padding:0px;">
    <div class="row topbar box_shadow">
		<div class="col-md-12">
			<div class="pull-left">
				<ul class="tab-bar grey-tab">
					<li class="active">
						<a href="<?php echo $this->module?>">
							<span class="block text-center">
								<i class="icon-list"></i> 
							</span>
							Daftar <?=$this->module_title?>
						</a>
					</li>
					<li>
						<a href="<?php echo $this->module?>add">
							<span class="block text-center">
								<i class="icon-plus"></i> 
							</span>
							Tambah <?=$this->module_title?>
						</a>
					</li>
					<li>
						<a href="<?php echo $this->module?>">
							<span class="block text-center">
								<i class="icon-refresh"></i> 
							</span>	
							Refresh
						</a>
					</li>
				</ul>
			</div>
			<form class="search_form col-md-3 pull-right" action="<?=$this->module?>" method="get">
				<?php $this->load->view("widget/search_box_db"); ?>
			</form>
		</div>
	</div>

<div id="tabs-0">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-condensed table-hover">
        <thead>
        <tr>
        <th width="50">&nbsp;</th>
        <th width="20">No.</th>
        <th width="20">&nbsp;</th>
        <th class="forder" width="100" rel="date">Tanggal</th>
        <th class="forder" width="300" rel="title">Caption</th>
        <th >Lead</th>
        <!--<td class="tbldata_header forder">Alamat</td>-->
        <th width="100">Publish</th>
        </tr>
        </thead>
        <tbody>
  <? if (is_array($arrDB)) { foreach($arrDB as $k=>$v) {
  		$tr_color=($k%2)?"#fff":"#fafafa";
		$id=$this->encrypt_status==TRUE?encrypt($v[$this->tbl_idx]):$v[$this->tbl_idx];
		$url_edit = $module."edit/".$id;
		$url_delete = $module."delete/".$id;
		
		$status_badges = ($v['status'])?'<span class="label label-info">Published</span>':'<span class="label label-warning">Draft</span>';
		
   ?>
            	<tr>
					<td>
                    	<!--<div class="btn-group">
                            <a href="<?=$url_edit;?>" class="btn"><i class="icon-edit icon-white"></i></a>
                            <a href="<?=$url_delete;?>" class="btn"><i class="icon-trash icon-white"></i></a>
                        </div>-->
                        <a href="<?=$url_edit;?>"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
                        <a onclick="return confirm('Anda yakin akan menghapus data ini?');" href="<?=$url_delete;?>"><i class="icon-remove icon-alert"></i></a>      
                    </td>               
                    <td><?=($data_start+$k);?></td> 	
                    <td></td> 	
                    <td rel="date_col" width="150"><?=$v['date_formatted'];?></td>
                    <td rel="title_col"><a href="<?=$url_edit;?>"><?=$v['title'];?></a></td>
                    <td><?=$v['news_clip2'];?></td>
                    <td><?=$status_badges;?></td>
            	</tr>
        <? } }?>
        </tbody>
        </table>

        </td>
      </tr>
    </table>
            <div class="row tables_info">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="displaying">Displaying : <?=$data_start;?> - <?=$data_end;?> of <?=$total_rows;?> entries,</div>
                        <div class="displaying">
                            Rows/page:   
                        </div>
                        <div class="displaying">
                            <?=$perpage;?>    
                        </div>
                    </div>
                </div>
            </div>
           <div class="col-md-4">
                <?=$paging;?>
            </div>
        </div>

</div>


<br />
<br />
</div>
<script>  
	var forder='<?=$forder;?>';
	var dorder='<?=$dorder;?>';
	var query ='<?=($key)?"?q=".$key:"";?>';
    $(document).ready(function () {
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
		
		$("#button_list").click(function(){
			var key=($("#key_list").val())?$("#key_list").val():'0';
			var prc=$("#page_record").val();
			var order=(forder!='' && dorder!='')?forder+':'+dorder:0;
			window.location.href='<?=$module;?>index/'+key+'/'+order+'/'+prc+'/1';
		});
		
		$(".page_record").change(function(){
			var order=(forder!='' && dorder!='')?forder+':'+dorder:0;
			var page_record = $(this).val();
			var url = '<?=$module;?>index/'+order+'/'+page_record+'/1'+query;
			window.location.href=url;
		});
		
    })
</script>