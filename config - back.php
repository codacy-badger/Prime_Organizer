<?php
	$dbServer = 'localhost';
	$dbUsername = 'root';
	$dbPassword = '';
	$dbDatabase = 'teste_organizer';
    
    $memberInfo = unserialize($_COOKIE['admin_user']);
    
	$adminConfig = array(
		'adminUsername' => $memberInfo['username'],
		'adminPassword' => $memberInfo['adminPassword'],
		'notifyAdminNewMembers' => "",
		'defaultSignUp' => "1",
		'anonymousGroup' => "anonymous",
		'anonymousMember' => "guest",
		'groupsPerPage' => "10",
		'membersPerPage' => "10",
		'recordsPerPage' => "10",
		'custom1' => "Full Name",
		'custom2' => "Address",
		'custom3' => "City",
		'custom4' => "State",
		'MySQLDateFormat' => "%d/%m/%Y",
		'PHPDateFormat' => "j/n/Y",
		'PHPDateTimeFormat' => "d/m/Y, h:i a",
		'senderName' => "Membership management",
		'senderEmail' => $memberInfo['email'],
		'approvalSubject' => "Your membership is now approved",
		'approvalMessage' => "Dear member,\n\nYour membership is now approved by the admin. You can log in to your account here:\nhttp://localhost/prime_organizer\n\nRegards,\nAdmin",
		'hide_twitter_feed' => "",
		'maintenance_mode_message' => "<b>Our website is currently down for maintenance</b><br>\r\nWe expect to be back in a couple hours. Thanks for your patience.",
		'mail_function' => "mail",
		'smtp_server' => "",
		'smtp_encryption' => "",
		'smtp_port' => "25",
		'smtp_user' => "",
		'smtp_pass' => ""
	);