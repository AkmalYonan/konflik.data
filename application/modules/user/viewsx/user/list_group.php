<div id="breadcrumbs" class="breadcrumbs-fixed">
<ul class="breadcrumb">
    <li><a href="admin/dashboard">Home</a> <span class="divider">/</span></li>
    <li><a href="admin/auth/">Account Manager</a> <span class="divider">/</span></li>
    <li class="active">Groups</li>
    </ul>
</div>
<div style="padding:40px 25px">
<div class="page-header">
	<h1>Group <small> List </small></h1>
</div>

<div class="row-fluid">
<div class="span12">

 <div class="toolbar">
        	<div class="pull-left">
            <div class="btn-group">
        	<a href="admin/auth/create_group" class="btn addData" title="Tambah Data"><i class="icon-plus-sign"></i> Tambah Data</a><a href="/admin/auth/group_delete/" class="btn btn-danger deleteData" title="Delete Data"><i class="icon-minus-sign"></i> Hapus Data</a>
            </div></div>
            
            <div class="pull-right">
             <form id="frm-search" action="<?=base_url()?><?=$this->module?>" method="get">
               <?
                	//load search box
					$this->load->view("widget/search_box_db");
				?>
                </form>
            </div>
           <div class="clearfix" style="height:28px"></div>
        </div>
        <br>
        <form id="frm" method="post">
<table class="table table-bordered table-condensed">
	<thead class="box_quote">
    <tr>
    	<th width="14"><input name="checkall" id="checkall" class="sOption" type="checkbox" /></th>
    	<th style="width:200px">Group Name</th>
        <th>Description</th>
        
    </tr>
    </thead>
	<?php foreach($arrData as $group):?>
    <tr>
    		<td style="width:10px"><input name="chk[]" class="cbsel sOption" type="checkbox" value="<?php echo $group["id"]?>" /></td>
    	<td>
        	<a href="admin/auth/edit_group/<?php echo $group['id']?>"><?php echo $group["name"];?></a>
        </td>
        <td><?php echo $group["description"];?></td>
    </tr>
    <?php endforeach;?>
</table>
</form>
</div></div>

</div>

<script>
	$(function(){
		$("#checkall").live("click",function(){
			$(".cbsel").attr("checked",$(this).attr('checked')?$(this).attr('checked'):false);
		});
		
		$(".cbsel").click(function(){
			var len1=$(".cbsel:checked").length;
			var len2=$(".cbsel").length;
			if(len1==len2){
				$("#checkall").attr("checked","checked");
			}else{
				$("#checkall").removeAttr("checked");
			}
		});
		
		$(".deleteData").click(function(e){
			e.preventDefault();
			//var url=$(this).attr("rel");
			var url="<?php echo base_url()?>admin/auth/group_delete";
			//var dataString=$("#frm").serialize()+"&time="+(new Date).getTime();
			if($(".cbsel:checked").length>0){
				$("#frm").attr("action",url);
				$("#frm").submit();
			}else{
				if (window.parent.location!=self.location){
					parent.Alert('Alert', 'Data harus di pilih.!!');
				}else{
					Alert('Alert', 'Data harus di pilih.!!');
				}
				return false;
			}
		});
		
	});
</script>