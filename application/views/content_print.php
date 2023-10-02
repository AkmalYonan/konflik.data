<?php echo $this->load->view("header_print");?>
<style>
	.no_print{
			display:none;
		}
	
	@media print {
   		.attcControls{ 
			display:none; 
		}
		.no_print{
			display:none;
		}
	}
</style>
<script>
	$(function(){
		$(".no_table").after("<hr>");
		$("hr").css("margin-bottom","20px").css("color","black").css("background-color","black").css("border","1px black solid");
	});
</script>
<?=$data?>
<script>
	$(function(){
		$(".attcControls").remove();
	});
</script>

 <script>
   $(function(){
        $(window).load(function(){
             window.print();   
        });
   });
</script>

<?php //echo $this->load->view("footer_print");?>
