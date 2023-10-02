<script>
	$(document).ready(function(){
		$(".addData").click(function(e){
			e.preventDefault();
			var url="<?php echo base_url()?><?php echo $this->module;?>user_add";
			location=url;
		});
		
		$(".editData").click(function(e){
			e.preventDefault();
			var id=$(this).attr("rel");
			var url="<?php echo base_url()?><?php echo $this->module;?>user_view/"+id;
			location=url;
		});
		
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
		
		
		
		$(".deleteData").live("click",function(e){
			e.preventDefault();
			//var url=$(this).attr("rel");
			var url="<?php echo base_url()?><?php echo $this->module;?>user_delete";
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
<div class="row-fluid">
<div class="span12">
<div id="breadcrumbs" class="breadcrumbs-fixed">
<ul class="breadcrumb">
    <li><a href="admin/dashboard">Home</a> <span class="divider">/</span></li>
    <li><a href="admin/account_manager/">Account Manager</a> <span class="divider">/</span></li>
    <li><a href="admin/account_manager/">Users</a> <span class="divider">/</span></li>
    <li class="active">List</li>
</ul>
</div>
<?php //echo portlet_simple_start();?>
<div style="padding:40px 25px">
<div class="page-header">
	<h1>User <!--<small>&raquo; <?=$data['title'];?></small>--><div class="pull-right" style="font-size:small; font-weight:normal"><?=date("d/m/Y");?></div></h1>
</div>	
        <div class="toolbar">
        	<div class="pull-left">
            <div class="btn-group">
        	<a href="/addData" class="btn addData" title="Tambah Data"><i class="icon-plus-sign"></i> Tambah Data</a><a href="/DeleteData" class="btn btn-danger deleteData" title="Delete Data"><i class="icon-minus-sign"></i> Hapus Data</a>
            </div></div>
             <div class="pull-right">
             <form id="frm-search" action="<?=base_url()?><?=$this->module?>" method="get">
               <?
                	//load search box
					$this->load->view("widget/search_box_db");
				?>
                </form>
            </div>
            <div class="clearfix" style="height:30px"></div>
        </div>
        <br>
		<form id="frm" method="post">
        <table class="table table-condensed" style="border-collapse:collapse;">
        	<thead class="box_quote">
            <tr style="height:24px">
           	  <th width="14"><input name="checkall" id="checkall" class="sOption" type="checkbox" /></th>
             		<th>User Name</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Groups</th>
                    <th>Active</th>
                    
            </tr>
            </thead>
            <tbody>
           
         <?php if(cek_array($arrData)==TRUE):?>
		<?php foreach($arrData  as $x=>$value): ?>
        	<tr>
            	<td style="width:10px"><input name="chk[]" class="cbsel sOption" type="checkbox" value="<?php echo $value["id"]?>" /></td>
                <td><a class="editData" href="/edit" rel="<?php echo $value["id"] ?>"><?php echo $value["username"]?></a></td>
                <td><?php echo $value["first_name"]?></td>
                <td><?php echo $value["last_name"]?></td>
                <td><?php echo $value["email"]?></td>
                <td>
				<?php foreach ($value["groups"] as $group):?>
                		<?php echo anchor("admin/auth/edit_group/".$group["id"], $group["name"]) ;?><br />
				<?php endforeach;?>
                 </td>
                <td>
                <? if($value["active"]):?>
                <a href="admin/auth/deactivate/<?php echo $value["id"]?>"><span class="label label-info"><?php echo lang('index_active_link')?></span></a>		<? else:?>
                <a href="admin/auth/activate/<?php echo $value["id"]?>"><span class="label label-info"><?php echo lang('index_inactive_link')?></span></a>	
                <? endif;?>
                </td>
			</tr>
       <? endforeach;?>
         <?php else:?>
        	<tr><td colspan="9" style="height:auto">
                <div class="alert" style="margin-bottom:0">
                  <a class="close" data-dismiss="alert">x</a>
                  Data belum ada!!!
                </div>
            </td>
            </tr>
        <?php endif;?>
        </tbody>
        </table>
        </form>
        <?php echo $this->pagination->create_links(); ?> 
<?php //echo portlet_simple_end();?>
</div>
</div><!-- /span-fluid-->
</div><!-- /row-field-->



   
