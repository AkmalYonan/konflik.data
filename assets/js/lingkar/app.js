$(document).ready(function(){
		$('#username').val($.cookie('username'));
		$('#password').val($.cookie('password'));
		if($.cookie('check')==1){
			$('#check').prop("checked","checked");
		}else{
			$('#check').prop("checked",false);
		}
		
		$("#a_login").click(function(e){
			e.preventDefault();
			var username= $('#username').val();
			var password = $('#password').val();
			var cook = $('#check').is(':checked');
			if(cook == true){
				$.cookie('username', username);
				$.cookie('check', 1);
				$.cookie('password', password);
			}else{
				//clear cookies
				$.cookie('check', 0);
				$.cookie('username', '');
				$.cookie('password', '');
			}
			
			$("#frmlogin").submit();
		});
		
		$('#password').keypress(function(e) {
			if(e.which == 13) {
            	$(this).blur();
            	setTimeout(function(){
					$('#a_login').focus().click()
				},500);
        	}
		});
	});// JavaScript Document