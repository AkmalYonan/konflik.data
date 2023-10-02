<style>
	.tbl-link td{
		border-bottom:1px #DDDDE2 solid;
		padding-bottom:4px;
		padding-top:10px;
		padding-left:5px;
		
	}
	.link-title{
		font-size:1.1em;
		font-weight:bold;
	}
	.link-description{
		padding-top:3px;
		padding-bottom:5px;
	}
	.link-url{
		font-size:0.9em;
	}
	.link-title a{
		text-decoration:underline;
	}
	.link-info{
		font-size:0.8em;
	}
	.link-info span{
		padding-right:15px;
	}
	
</style>
<? 
$sql="select top 5 * from cms_link order by created desc";
$arrData=$this->conn->GetAll($sql);
?>

<div class="row-fluid">
<div class="span12">
<h4 class="heading">Latest Added Link</h4>
<table class="tbl-link" width="100%" cellspacing="0" style="border-collapse:collapse" cellpadding="0" border="0">
	<tbody>
	<?php foreach($arrData as $x=>$val):?>
	<tr valign="top">
    	<td width="10px"><i class="icon-globe icon-white"></i></td>
        <td style="padding-left:10px">
        	<span class="link-title">
            	<a href="<?=$val["link_url"];?>"><?=$val["name"]?></a></span>
            <div class="link-url">
            	<?=$val["link_url"];?>
            </div>    
            <div class="link-description">
			<?=$val["description"]?>
            </div>
            <div class="link-info">
            	<span class="time ">Created: <?=date("d M Y",strtotime($val["created"]))?></span>
                <span class="owner ">Owner: <?=$val["creator"]?$val["creator"]:"Administrator"?></span>
            </div>
            
        </td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
</div></div><!-- end row -->
