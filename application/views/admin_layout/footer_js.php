<?=loadFunction("validate");?>
<?php echo js_asset("plugin/date.format.js");?>
<script>
	$(function(){
		$.validator.addMethod("endDate", function(value, element) {
            var startDate = $('.startDate').val();
            return Date.parse(startDate) <= Date.parse(value) || value == "";
        }, "* End date must be after start date");
		
		$("#frm").validate();
		$("#attachment-frm").validate({ignore: ""});
	
		
	
		$(".input-date").each(function(i){
					$("#"+$(this).attr("id")).datepicker({
						format:"dd/mm/yyyy",
					});
		});
			
		$('.input-date').click(function(){
			$(this).datepicker('show');	
		});
			
		$('.input-date').datepicker().on("changeDate",function(ev){
				var isoDate=ev.date.format("isoDate");
				$("#"+$(this).attr("id").replace("_selector","")).val(isoDate);
				$("#"+$(this).attr("id").replace("_selector","")).valid();
				$(this).datepicker('hide');
		});
		
		$('.input-date').on("keyup",function(){
			var dt=$("#"+$(this).attr("id")).data("datepicker").date.toLocaleFormat("%Y-%m-%d");
			$("#"+$(this).attr("id").replace("_selector","")).val(dt);
		});
		
		$('.input-date').blur(function(){
			var dt=$("#"+$(this).attr("id")).data("datepicker").date.toLocaleFormat("%Y-%m-%d");
			$("#"+$(this).attr("id").replace("_selector","")).val(dt);
		});
		
		
		
		$(".input-date").datepicker("update");
		
		//selector with relation text field
		$("select.with-target").change(function(){
				var id=$(this).data("target_text");
				var text=$(this).find("option:selected").text();
				$("#"+id).val(text);
		});
		
		$("select.with-target").change(function(){
				var id=$(this).data("target_key");
				var val=$(this).find("option:selected").val();
				$("#"+id).val(val);
		})
		
	});
	
	
	function resetForm($form)
	{
		$form.find('input:text, input:password, input:file, select, textarea').val('');
		$form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
	}

	function populateForm($form, data)
	{
		resetForm($form);
		$.each(data, function(key, value) {
			var $ctrl = $form.find('[name='+key+']').length>0?$form.find('[name='+key+']'):$form.find('#'+key+'');
			if ($ctrl.is('select')){
				$('option', $ctrl).each(function() {
					if (this.value == value)
						this.selected = true;
				});
			} else if ($ctrl.is('textarea')) {
				$ctrl.val(value);
			}else if($ctrl.is(".input-date")){
				$ctrl.datepicker('setValue', value);
				//or
				//$ctrl.val(value);
				//$ctrl.datepicker("update");
			} else {
				switch($ctrl.attr("type")) {
					case "text":
					case "hidden":
						$ctrl.val(value);   
						break;
					case "checkbox":
						if (value == '1')
							$ctrl.prop('checked', true);
						else
							$ctrl.prop('checked', false);
						break;
				} 
			}
		});
	};
	
	function GetDays(date1, date2) {
	
		// The number of milliseconds in one day
		var ONE_DAY = 1000 * 60 * 60 * 24
	
		// Convert both dates to milliseconds
		var date1_ms = date1.getTime()
		var date2_ms = date2.getTime()
	
		// Calculate the difference in milliseconds
		var difference_ms = Math.abs(date1_ms - date2_ms)
	
		// Convert back to days and return
		return Math.round(difference_ms/ONE_DAY)+1
	
	}
</script>

<script>
	function UrlSubmit(url, params) {
		params["target"]=params["target"]||'';
		var target=('target="'+params["target"])+'"'||'';
		var form = [ '<form id="flyfrm" name="flyfrm" method="POST" ',target,' action="', url, '">' ];
	
		for(var key in params) 
			form.push('<input type="hidden" name="', key, '" value="', params[key], '"/>');
	
		form.push('</form>');
	
		jQuery(form.join('')).appendTo('body')[0].submit();
	}
	
	function templateReplace(template,data){
		return template.replace(/{([^}]+)}/g,function(match,group){
			return data[group.toLowerCase()];
		});
	}
	
	function set_active_menu(currLink){
		var $el=$(".tab-pane").find(("a[href*='"+currLink+"']"));
		$(".tab-content .nav ").find("li.active").removeClass("active");
		$el.parents("li:last").addClass("active");
		$el.parents("li:last").find("a:first").addClass("active");
		
		var $tab_pane=$el.closest(".tab-pane");
		$("#tabber li").removeClass("active");
		$("#tabber li").removeClass("tabopen");
		$(".tab-pane.tabopen").removeClass("tabopen");
		$(".tab-pane.active").removeClass("active");
		var tab_pane_id=$tab_pane.attr("id");
		$("#tabber li a[href='#"+tab_pane_id+"']").closest("li").addClass("tabopen");
		$("#tabber li a[href='#"+tab_pane_id+"']").closest("li").addClass("active");
		$tab_pane.addClass("tabopen active");
		$tab_pane.find("a[href*='"+currLink+"']").not(".nav > li > a").prepend("<i class='icon-ok'></i>");
	}
</script>

<script>
	/* AJAX CHECK */
	/*
	$(function(){
		status_pelanggaran();
		setInterval(status_pelanggaran_harian(),60*1000);
	});
	*/
	
	function status_pelanggaran(){
			$.post("hrms_svc/update_status_pelanggaran",function(ret){
				if(ret=="ok"){
					setTimeout("status_pelanggaran()",5000);
				}
			});
	}
	
	function status_pelanggaran_harian(){
			$.post("hrms_svc/status_pelanggaran_harian",function(ret){
				if(ret=="ok"){
					//setTimeout("status_pelanggaran_harian()",1000*60);
				}
			});
	}
	
	
	/*
	(function poll(){
		$.ajax({ url: "server", success: function(data){
		//Update your dashboard gauge
		salesGauge.setValue(data.value);
		}, dataType: "json", complete: poll, timeout: 30000 });
	})();
	*/
	/*
	(function update_status_pelanggaran(){
		$.ajax({ url: "hrms_svc/update_status_pelanggaran", success: function(ret){
		}, complete: update_status_pelanggaran, timeout: 30000});
	})();
	*/
</script>

 <script>
				$(function(){
					$(".box-toolbar a").click(function(e){
						e.preventDefault();
						if($(this).closest(".box").find(".box-content").is(":visible")){
							$(this).find("i").removeClass("icon-chevron-up").addClass("icon-chevron-down");
						}else{
							$(this).find("i").removeClass("icon-chevron-down").addClass("icon-chevron-up");
						}
						$(this).closest(".box").find(".box-content").slideToggle();
						
					});
				});
			</script>
            
            
            
<? if($this->cms):?>
<script>
	var right=<?=$this->cms->get_module_right_max($this->module)?>||0;

	$(function(){
		if(right==1){
		$(".right_full").addClass("disabled");
		$(".right_read").addClass("disabled");
		$(".right_write").addClass("disabled");
		//$(".right_full").remove();
		//$(".right_read").remove();
		//$(".right_write").remove();
	}else if(right==2){
		$(".right_full").addClass("disabled");
		$(".right_write").addClass("disabled");
	}else if(right==3){
		$(".right_full").addClass("disabled");
	}else if(right==4){
			
	}else{
		$(".right_full").addClass("disabled");
		$(".right_read").addClass("disabled");
		$(".right_write").addClass("disabled");
		$(".right_view").addClass("disabled");
	}

	$(".tab-bar a,a").on("click", function(e) {
	  if ($(this).hasClass("disabled")){
	  	alert("Anda tidak mempunyai akses ke halaman ini!!")
		e.preventDefault();
		return false;
	  }
	});
});
</script>
<? endif;?>
