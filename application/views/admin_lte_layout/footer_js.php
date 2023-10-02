<? //=loadFunction("validate");?>
<?=loadFunction("select2");?>
<?php echo js_asset("plugin/date.format.js");?>
<?php echo js_asset("plugin/json2/json2.js");?>
<?php echo js_asset("plugin/store/store.min.js");?>
<?php echo loadFunction("quicksearch");?>
<? $mnu = array("reg/","ver/","ser/","keberatan/"); ?>
<script>
	(function($) {

		$.ucfirst = function(str) {
	
			var text = str;
	
	
			var parts = text.split(' '),
				len = parts.length,
				i, words = [];
			for (i = 0; i < len; i++) {
				var part = parts[i];
				var first = part[0].toUpperCase();
				var rest = part.substring(1, part.length);
				var word = first + rest;
				words.push(word);
	
			}
	
			return words.join(' ');
		};

	})(jQuery);
</script>
<script>
	$(function(){
		var folder = <?=(in_array($this->folder,$mnu))?'"'.substr(trim($this->folder), 0, -1).'"':'false'?>;

		var act_link="<?=substr(trim($this->module), 0, -1);?>";
		//alert(act_link);
		var currLink=window.location.pathname;
		var removeStr=currLink.split("<?=$this->module?>")[1];
		currLink=act_link+"/"+removeStr;
		var arrCurrLink=currLink.split("/");
		currLink=arrCurrLink.join("/");
		currLink = currLink.replace(/^\/|\/$/g, '');
		//alert(currLink);
		var el=$(".sidebar-menu").find("a[href*='"+currLink+"']:first");
		if(el.length<1){
			var el=$(".sidebar-menu").find("a[href*='"+act_link+"']:first");
		}
		if (folder) {
			var el=$(".sidebar-menu").find("a[href~='"+folder+"']:first");
		}
		//console.log(el);
		$(".sidebar-menu").find("li.active").removeClass("active");
		$(".sidebar-menu").find("ul.treeview-menu").not(el.closest("ul.treeview-menu")).hide();
		
		el.closest("ul.treeview-menu").show();
		el.parents("li:last").addClass("active");
		el.closest("li").addClass("active");
		
		$(".sidebar-menu > li.active").addClass("active_state")
		
	});
	
	function set_active_menu_class(name){
		var el=$("."+name);
		
		//console.log(el);
		$(".sidebar-menu").find("li.active").removeClass("active");
		$(".sidebar-menu").find("ul.treeview-menu").not(el.closest("ul.treeview-menu")).hide();
		
		el.closest("ul.treeview-menu").show();
		el.parents("li:last").addClass("active");
		el.closest("li").addClass("active");
		
		$(".sidebar-menu > li.active").addClass("active_state")
	}
</script> 
<script>
	$(function(){
		$.validator.addMethod("endDate", function(value, element) {
            var startDate = $('.startDate').val();
            return Date.parse(startDate) <= Date.parse(value) || value == "";
        }, "* End date must be after start date");
		
		$("#frm").validate();
		$("#attachment-frm").validate({ignore: ""});
	
		$(".input-date").each(function(i){
			var mindate=$("#"+$(this).attr("id")).data("mindate");
			$("#"+$(this).attr("id")).datepicker({
				format:"dd/mm/yyyy",
				startDate:mindate||false
			});
		});
			
		$('.input-date').click(function(){
			$(this).datepicker('show');	
		});
			
		$('.input-date').datepicker().on("changeDate",function(ev){
			var isoDate=ev.date.format("isoDate");
			//$(this).datepicker("getDate").format("isoDate");
			$("#"+$(this).attr("id").replace("_selector","")).val(isoDate);
			$("#"+$(this).attr("id").replace("_selector","")).valid();
			//$(this).datepicker('hide');
			
			var selectorSame=$(this).data("same_date_selector") ||"";
			var selectorSameStartDate=$(this).data("same_start_date_selector")||"";
			
			if(selectorSame!=""){
				$("#"+selectorSameDate).datepicker("setDate",$(this).datepicker("getDate"));
			}
			if(selectorSameStartDate){
				$("#"+selectorSameStartDate).datepicker("setStartDate",$(this).datepicker("getDate"));
				$("#"+selectorSameStartDate).datepicker("setDate",$(this).datepicker("getDate"));
				
			}
			
			$(this).datepicker('hide');
		});
		
		
		$('.input-date').on("keyup",function(){
			//var dt=$("#"+$(this).attr("id")).data("datepicker").date.toLocaleFormat("%Y-%m-%d");
			var dt=$(this).datepicker("getDate").format("yyyy-mm-dd");
			$("#"+$(this).attr("id").replace("_selector","")).val(dt);
		});
		
		$('.input-date').blur(function(){
			//var dt=$("#"+$(this).attr("id")).data("datepicker").date.toLocaleFormat("%Y-%m-%d");
			var dt=$(this).datepicker("getDate").format("yyyy-mm-dd");
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
	
	$(".rb.disabled").prop("disabled","disabled");
});
</script>
<? endif;?>
