// JavaScript Document
$(document).ready(function(){
		jQuery.extend(jQuery.validator.messages, {
  			required: "Field ini harus di isi.",
			remote: "Data yang diisi tidak valid.",
			email: "Isi dengan alamat email yang valid.",
			url: "Alamat url tidak valid.",
			date: "Format tanggal tidak valid.",
			dateISO: "Format tanggal harus valid(ISO).",
			number: "Isi dengan angka.",
			digits: "Isi dengan digit",
			creditcard: "Format kartu kredit tidak valid.",
			equalTo: "Isi harus sama dengan field sebelumnya.",
			maxlength: $.validator.format("Maximum {0} karakter."),
			minlength: $.validator.format("Minimum {0} karakter."),
			rangelength: $.validator.format("Minimum {0} karakter and Maksimum {1} karakter."),
			range: $.validator.format("Isi nilai antara {0} dan {1}."),
			max: $.validator.format("Maximum nilai adalah {0}."),
			min: $.validator.format("Minimum nilai adalah {0}."),
			username: "Field hanya boleh diisi dengan alphanumeric (angka dan abjad) serta underscore",
			alphanumeric: "Field hanya boleh diisi dengan alphanumeric(angka dan abjad)",
			phoneNumber: "Field hanya boleh diisi dengan angka, + dan -",
			mobileNumber: "Field hanya boleh diisi dengan angka dan +",
			decimalOnly: "Field hanya boleh di isi desimal ',' untuk ribuan '.' untuk desimal",
			numberOnly: "Field hanya boleh diisi angka",
			selectNone: "Field ini harus di pilih",
			file_check: "Pilih Upload File"
		});
	});