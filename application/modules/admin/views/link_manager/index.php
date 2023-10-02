<div id="breadcrumbs" class="breadcrumbs-fixed">
    <ul class="breadcrumb">
    <li><a href="#">Home</a> <span class="divider">\</span></li>
    <li><a href="<?=$this->module?>link_list">Link Directory</a> <span class="divider">\</span></li>
    <li class="active">Links</li>
    </ul>
</div>
<!-- div for positioning -->
<div style="padding:40px 25px">
<!--<div class="page-header">
	<h1>Links<small> </small></h1>
</div>
<br>-->
<div class="row-fluid">
            	<div class="span12">
	<h4 class="heading">Control Panel</h4>				
	<div class="shortcuts" style="text-align:left">
		<a class="quick-button-small a_shortcut" data-url="<?php echo $this->module?>link_add/">
			<i class="icon-columns"></i>
			<p>New Link</p>
		</a>
        <a class="quick-button-small a_shortcut" data-url="<?php echo $this->module?>link_list/">
			<i class="icon-list-alt"></i>
			<p>Link/Dir List</p>
		</a>
          
        <a class="quick-button-small a_shortcut" data-url="<?php echo $this->module?>category_list/">
			<i class="icon-list-alt"></i>
			<p>Category</p>
		</a>
        
	 </div>       
			
           </div>
            </div>
            
            <hr>
            
<!-- end Komeng Prepend -->
<!-- CATEGORY HEADER -->
<?php $this->load->view("v_cat_count");?>
<div class="clearfix"></div>

<?php $this->load->view("v_link_latest");?>


<!--<? foreach($arrData as $x=> $val):?>
	<?php $arrLink[$val["category"]][]=$val;?>
<? endforeach;?>
<ul>
<? foreach($arrCategory as $cat):?>
	
    	<li id="<?=$cat["idx"]?>">
			<h5><?=$cat["category"]?></h5>
        	<div class="child">
            	<? if(cek_array($arrLink[$cat["idx"]])):?>
                	<ul>
					<? foreach($arrLink[$cat["idx"]] as $x=>$val):?>
                    	<li><a href="<?=$val["link_url"];?>"><?=$val["name"]?></a></li>
                    <? endforeach;?>
                    </ul>
                <? endif;?>
            </div>
        </li>
    
<? endforeach;?>-->

</div>


<script>
	$(function(){
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href='"+act_link+"']").parent("li").addClass("active");
	})
</script>




