<? 
$sql="select category,count(idx) as total from cms_link group by category";
$sql="select b.*,coalesce(a.total,0) as total from ($sql) a right join cms_link_category b on a.category=b.idx";
$arrData=$this->conn->GetAll($sql);
foreach($arrData as $x=>$val):
	$totalx[]=$val["total"];
endforeach;
$allCatTotal=array_sum($totalx);

?>

<h4 class="heading">Categories</h4>
<ul class="span12">
	<li style="display:inline-block;margin-left:10px;margin-bottom:20px;min-width:300px">
        	<div class="cat-heading" style="font-size:1.1em;font-weight:bold;">
            <a href="<?=$this->module?>"><i class="icon-folder-close icon-white"></i>   All Categories <span>( <?=$allCatTotal?> )</span></a>
            </div>
            <div class="cat-content">
            	All Categories
            </div>
    </li>
	<? foreach($arrData as $x=>$val):?>
    	<li style="display:inline-block;margin-left:10px;margin-bottom:20px;min-width:300px">
        	<div class="cat-heading" style="font-size:1.1em;font-weight:bold;">
            <a href="#"><i class="icon-folder-close icon-white"></i>  <?=$val["category"]?> <span>(<?=$val["total"]?>)</span></a>
            </div>
            <div class="cat-content" style="height:auto;">
            	<?=$val["description"]?>
            </div>
        </li>
    <? endforeach;?>
</ul>

