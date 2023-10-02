<?
$result = ($key)?"Keywords: <strong>".$key."</strong>":"&nbsp;"; 
?>
<div id="breadcrumbs" class="breadcrumbs-fixed">
    <ul class="breadcrumb">
    <li><a href="#">Home</a> <span class="divider">\</span></li>
    <li><a href="#">Content</a> <span class="divider">\</span></li>
    <li class="active">News</li>
    </ul>
</div>
                        
<div style="padding:40px 25px">
<div class="page-header">
	<h1>News <!--<small>&raquo; <?=$data['title'];?></small>--><div class="pull-right" style="font-size:small; font-weight:normal"><?=date("d/m/Y");?></div></h1>
</div>


<div style="padding:0px;">
    <div class="toolbar">
        <div class="pull-left">
            <div class="btn-group">
            <a href="admin/news/add" class="btn"><i class="icon-plus bc-icon"></i> Add</a>
            <a href="admin/news" class="btn"><i class="icon-refresh bc-icon"></i> Refresh</a>
            </div>
        </div>
        <div class="pull-right" style="margin-left:10px">
		<form method="get" class="input-append" action="admin/news">
                <input type="text" placeholder="Search..." size="16" class="search_query input-medium" name="q" autocomplete="off"><button class="btn" type="submit"><i class="icon-search"></i></button>
            </form>
        </div>
        <div class="clearfix" style="height:30px"></div>
    </div>
    <br>

<div id="tabs-0">
	<?php echo message_box();?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-condensed table-hover">
        <thead>
        <tr>
        <th width="80">&nbsp;</th>
        <th width="20">No.</th>
        <th width="20">&nbsp;</th>
        <th class="forder" width="100" rel="date">Date</th>
        <th class="forder" width="300" rel="title">Title/Judul</th>
        <th >News Clip</th>
        <!--<td class="tbldata_header forder">Alamat</td>-->
        <th width="100">Publish</th>
        </tr>
        </thead>
        <tbody>
  <? if (is_array($arrDB)) { foreach($arrDB as $k=>$v) {
  		$tr_color=($k%2)?"#fff":"#fafafa";
		
		$url_edit = $module."edit/".$v['idx'];
		$url_delete = $module."delete/".$v['idx'];
		
		$status_badges = ($v['status'])?'<span class="label label-info">Published</span>':'<span class="label label-warning">Draft</span>';
		
   ?>
            	<tr>
					<td>
                    	<!--<div class="btn-groupx">
                            <a href="<?=$url_edit;?>"><i class="icon-edit icon-white"></i></a>
                            <a href="<?=$url_delete;?>" ><i class="icon-trash icon-white"></i></a>
                        </div>-->
                            <ul class="actions">
                                <li>
                                    <a href="<?=$url_edit;?>"><i class="icon-pencil"></i></a>
                                </li>
                                <li>
                                    <a href="<?=$url_delete;?>"><i class="icon-remove icon-alert"></i></a>
                                </li>
                            </ul>
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
    <div class="table-nav table-nav-border-top">
			<div class="pull-left text">Displaying : <?=$data_start;?> - <?=$data_end;?> of <?=$total_rows;?> entries</div>            
            <div class="pull-right"><?=$paging;?></div>
            <div class="pull-right"><?=$perpage;?></div>
            <div class="pull-right">Rows/page: </div>
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