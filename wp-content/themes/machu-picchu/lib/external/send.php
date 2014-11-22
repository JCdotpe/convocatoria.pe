<?php
if ((isset($_POST['name'])) && (strlen(trim($_POST['name'])) > 0)) {
	$name = stripslashes(strip_tags($_POST['name']));
} else {$name = 'No name entered';}
if ((isset($_POST['email'])) && (strlen(trim($_POST['email'])) > 0)) {
	$email = stripslashes(strip_tags($_POST['email']));
} else {$email = 'No email entered';}
if ((isset($_POST['text'])) && (strlen(trim($_POST['text'])) > 0)) {
	$text = stripslashes(strip_tags($_POST['text']));
} else {$text = 'No text entered';}
if ((isset($_POST['temail'])) && (strlen(trim($_POST['temail'])) > 0)) {
	$temail = stripslashes(strip_tags($_POST['temail']));
}else {$temail = 'No temail entered';}
ob_start();
?>
<html>
<head>
<style type="text/css">
</style>
</head>
<body>
<table width="550" border="1" cellspacing="0" cellpadding="0" bordercolor="#E6E6E6">
  <tr bgcolor="#ffffff">
    <td style="padding: 5px">Name</td>
    <td style="padding: 5px"><?=$name;?></td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="padding: 5px">Email</td>
    <td style="padding: 5px"><?=$email;?></td>
  </tr>
  <tr bgcolor="#ffffff">
    <td style="padding: 5px">Message</td>
    <td style="padding: 5px"><?=$text;?></td>
  </tr>
</table>
</body>
</html>
<?
$body = ob_get_contents();
require("phpmailer.php");

$mail = new PHPMailer();
$mail->From     = $temail;
$mail->FromName = "My Wordpress Site";
$mail->AddAddress($temail,"Wordpress Admin");
$mail->WordWrap = 50;
$mail->IsHTML(true);
$mail->Subject  =  "Contact form submitted";
$mail->Body     =  $body;

if(!$mail->Send()) {
	$recipient = $temail;
	$subject = 'Contact form failed';
	$content = $body;	
  mail($recipient, $subject, $content, "From: mail@yourdomain.com\r\nReply-To: $email\r\nX-Mailer: DT_formmail");
  exit;
}
?>
