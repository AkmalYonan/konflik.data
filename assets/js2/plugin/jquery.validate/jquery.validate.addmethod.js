// JavaScript Document
/*
	jQuery.validator.setDefaults({
		debug: true,
		success: "valid"
	});;
	*/
	
	
$(document).ready(function(){
		 //validation for username with alpha numeric only
		 $.validator.addMethod("username", function(value, element) {  
         return this.optional(element) || /^[a-z0-9_]+$/i.test(value);  
     	 }, "Username must contain only letters, numbers, or underscore.");
		 
		 //validation for phone number
		 $.validator.addMethod("phoneNumber", function(value, element) {           return this.optional(element) || /^[0-9-+]+$/i.test(value);  
     	 }, "Phone must contain only numbers, + and -."); 
		 
		 $.validator.addMethod("mobileNumber", function(value, element) {           return this.optional(element) || /^[0-9+]+$/i.test(value);  
     	 }, "Mobile must contain only numbers, +."); 
		 
		 //Decimal Field
		 $.validator.addMethod("decimalOnly", function(value, element) {           return this.optional(element) || /^[0-9\.\,]+$/i.test(value);  
     	 }, "Decimal Field Value"); 
		 
		 //Numeric Field
		 $.validator.addMethod("numberOnly", function(value, element) {           return this.optional(element) || /^[0-9+-]+$/i.test(value);  
     	 }, "This Field must contain only numbers, + and -."); 
		  
		  //Alpha Numeric Field
		  $.validator.addMethod("alphanumeric", function(value, element) 		 {  
         	return this.optional(element) || /^[a-z0-9_\ ]+$/i.test(value);  
     	 }, "This Field must contain only letters, numbers, or underscore."); 
		 
		 $.validator.addMethod( 
	  		"selectNone", 
	  		function(value, element) { 
				
	    		if (element.value == "0") 
	   			 { 
	     			 return false; 
				} 
	   			 else return true; 
	  			}, 
	  			"Please select an option." 
			);
		 
		  $.validator.addMethod( 
	  		"file_check", 
	  		function(value, element) { 
				
	    		if (element.value == "") 
	   			 { 
	     			 return false; 
				} 
	   			 else return true; 
	  			}, 
	  			"Please Select file to upload." 
			);
		 
	});


/*
	Test Usage
	
	$("#frm").validate({
		rules: {
			user_id:{
				required:true,
				minlength: 3
			},
			username: {
				required:true,
				minlength: 3
			},
			password: {
				required: true,
				minlength: 5
			},
			cf_password: {
				required: true,
				minlength: 5,
			},
			email: {
				required: true,
				email: true
			},
			cf_email: {
				required: true,
				email: true,
				equalTo: "#email"
			}
		}
		
		
		,
		messages: {
			user_id: {
				required: "Isi User ID",
				minlength: "User ID minimal 2 karakter"
			},
			user_name: {
				required: "Isi Nama User",
				minlength: "Nama User minimal 2 karakter"
			},
			password: {
				required: "Isi Password",
				minlength: "Password Minimal 2 karakter"
			},
			cf_password: {
				required: "Isi Konfirmasi Password",
				minlength: "Minimal 2 karakter",
				equalTo: "Password dan konfirmasi password harus sama"
			},
			email: {
				required:"Isi Email",
				email:"Isi dengan alamat email yang valid"
			},
			cf_email: {
				required:"Isi Konfirmasi Email",
				email:"Isi dengan alamat email yang valid",
				equalTo:"Email dan konfirmasi email harus sama"
			}
		}
	});
	
	*/