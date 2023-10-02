<?php 
	$q=$this->input->get_post("q",TRUE);
	$q=$q?$q:"";
?>

<div class="box-tools">
    <div class="has-feedback">
      <input id="q" name="q" class="form-control input-sms" value="<?=$q?>" placeholder="Search...">
      <span class="glyphicon glyphicon-search form-control-feedback text-muted"></span>
    </div>
</div>

<script>	
$(function(){
	$("#search-reset").click(function(){
		location=document.URL.split("?")[0];
	});
});
</script>