<script>
	$(document).ready(function(){
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href$='"+act_link+"']").parent("li").addClass("active");
	
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
<div id="breadcrumbs" class="breadcrumbs-fixed">
<ul class="breadcrumb">
        <li><a href="admin/dashboard">Home</a> <span class="divider">/</span></li>
        <li><a href="admin/account_manager/">Account Manager</a> <span class="divider">/</span></li>
        <li><a href="admin/account_manager/">Users</a> <span class="divider">/</span></li>
        <li class="active">List</li>
    </ul>
    </div>

<div style="padding:40px 25px">
<div class="row-fluid">
<div class="span12">

<?php //echo portlet_simple_start();?>
	
      <div class="page-header">
			<h1>User List</h1>
		</div>
	<br>

        <div class="toolbar">
        	<div class="pull-left">
            <div class="btn-group">
        	<a href="/addData" class="btn addData" title="Tambah Data"><i class="icon-plus-sign"></i> Tambah Data</a><a href="/DeleteData" class="btn btn-danger deleteData" title="Delete Data"><i class="icon-minus-sign"></i> Hapus Data</a>
            </div></div>
			
			<div class="col-md-12">
				<a href="#" class="print-pdf" data-url="" title="Data Pendaftar"><i class="fam-page_white_acrobat"></i> PDF</a>
			</div>
			
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
		<div id="print_this">
		<form id="frm" method="post">
        <table class="table table-condensed" style="border-collapse:collapse;">
        	<thead class="box_quotex">
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
		</div>
        <?php echo $this->pagination->create_links(); ?> 
<?php //echo portlet_simple_end();?>
</div><!-- /span-fluid-->
</div><!-- /row-field-->
</div>
<script>
	var alm = "<?=$arrAlamat['value'];?>";
	var eml = "<?=$arrEmail['value'];?>";
	var ktk = "<?=$arrKontak['value'];?>";
	$(function(){
		var style = "<style>@page {footer:html_myfooter1;header: html_myHeader1;background:white url('assets/image/logo-trans.png') no-repeat center center;border:0px solid red;}@page :first {footer:html_myfooter1;header: html_myHeader1;}table {font-family:chelvetica, Arial;font-size:9px;margin:0;width:100%}table.section{margin-top:10px;}th {text-align:left!important;}h5 {font-family:chelvetica, Arial;}.val{font-weight:bold}</style>";
		var hd = '<htmlpageheader name=\'myHeader1\'><div style=\'text-align: right; border-bottom: 1px solid #000000; font-size: 10pt;\'><table cellspacing=\'0\' cellpadding=\'4\' width=\'100%\'><tr><td style=\'padding-left:25px;\'><img src=\'assets/image/logo-blank.png\' style=\'height:45px;\' /></td><td style=\'font-size:12px;\'><center><b>Badan Registrasi Wilayah Adat (BRWA)</b></center><p align=\'center\'>'+alm+'<br>Telp/Fax: '+ktk+' | Email: <span style=\'color:blue;text-decoration:underline;\'>'+eml+'</span> | Websie: <span style=\'color:blue;text-decoration:underline;\'>http://brwa.or.id</span></p></td></tr></table></div></htmlpageheader>';
		var footer = "<htmlpagefooter name='myfooter1'><table width='100%' style='vertical-align: bottom; font-family: serif; font-size: 8pt;color: #000000; font-weight: bold; font-style: italic;'><tr><td width='33%'><span style='font-weight: bold; font-style: italic;'>Sumber : http://brwa.or.id</span></td><td width='33%' align='center' style='font-weight: bold; font-style: italic;'>{PAGENO}/{nbpg}</td><td width='33%' style='text-align: right; '>{DATE j-m-Y}</td></tr></table></htmlpagefooter>";
		$("a.print-pdf").click(function(e){
			e.preventDefault();
			var base_url="<?=base_url()?>";
			var html=style+hd+footer+$("div#print_this").html();
			var file="wilayah_adat<?="_".date("YmdHis").".pdf";?>";
			UrlSubmit(base_url+"export/proxy_pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70,target:"_blank"});
		});
	});
</script>

   
