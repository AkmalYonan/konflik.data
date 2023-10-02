<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - English
* 
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  English language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful'] 	  	 = 'Akun Berhasil Dibuat';
$lang['account_creation_unsuccessful'] 	 	 = 'Tidak Dapat Membuat Akun';
$lang['account_creation_duplicate_email'] 	 = 'Email Telah Digunakan Atau Salah Email';
$lang['account_creation_duplicate_username'] = 'Akun Sudah Terdaftar Atau Salah';

// Password
$lang['password_change_successful'] 	 	 = 'Password Berhasil diubah';
$lang['password_change_unsuccessful'] 	  	 = 'Tidak dapat merubah Password';
$lang['forgot_password_successful'] 	 	 = 'Email Untuk Reset Password Telah Dikirim';
$lang['forgot_password_unsuccessful'] 	 	 = 'Tidak Dapat Mereset Password';

// Activation
$lang['activate_successful'] 		  	     = 'Akun Berhasil diaktifasi';
$lang['activate_unsuccessful'] 		 	     = 'Tidak dapat mengaktifasi Akun';
$lang['deactivate_successful'] 		  	     = 'Akun Telah Dinonaktifkan';
$lang['deactivate_unsuccessful'] 	  	     = 'Tidak Dapat Menonaktifkan Akun';
$lang['activation_email_successful'] 	  	 = 'Email Aktivasi Telah Dikirim';
$lang['activation_email_unsuccessful']   	 = 'Tidak Dapat Mengirim Email Aktivasi';

// Login / Logout
$lang['login_successful'] 		  	         = 'Login Sukses';
$lang['login_unsuccessful'] 		  	     = 'Login Salah';
$lang['login_unsuccessful_not_active'] 		 = 'Akun Belum/Tidak Aktif';
$lang['login_timeout']                       = 'Timeout!.  Coba untuk Login kembali.';
$lang['logout_successful'] 		 	         = 'Logout Berhasil';

// Account Changes
$lang['update_successful'] 		 	         = 'Informasi akun Berhasil Diperbaharui';
$lang['update_unsuccessful'] 		 	     = 'Tidak dapat Merubah Informasi Akun';
$lang['delete_successful']               = 'User Dihapus';
$lang['delete_unsuccessful']           = 'Tidak Dapat Menghapus User';

// Groups
$lang['group_creation_successful']  = 'Group created Successfully';
$lang['group_already_exists']       = 'Group name already taken';
$lang['group_update_successful']    = 'Group details updated';
$lang['group_delete_successful']    = 'Group deleted';
$lang['group_delete_unsuccessful'] 	= 'Unable to delete group';
$lang['group_name_required'] 		= 'Group name is a required field';

// Activation Email
$lang['email_activation_subject']            = 'Pendaftaran Member';
$lang['email_activate_heading']    = 'Aktifasi Akun: %s';
$lang['email_activate_subheading'] = 'Silahkan Klik Link ini untuk %s.';
$lang['email_activate_link']       = 'Aktifasi Akun!';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Forgotten Password Verification';
$lang['email_forgot_password_heading']    = 'Reset Password for %s';
$lang['email_forgot_password_subheading'] = 'Please click this link to %s.';
$lang['email_forgot_password_link']       = 'Reset Your Password';

// New Password Email
$lang['email_new_password_subject']          = 'New Password';
$lang['email_new_password_heading']    = 'New Password for %s';
$lang['email_new_password_subheading'] = 'Your password has been reset to: %s';
 