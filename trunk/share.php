<?php # Script 1.0 - Sending out the emails

	$to  = $_POST['to']; // note the comma
	// subject
	$subject = 'ISTE video';
			
	// message
	$message = '
<html>
<head>
  <title>ISTE storytelling corps</title>
</head>
<body>
<p>Here is the link for the iste video</p>
<P></P>
  <p>for more information about istevision</p>
  
  <table>
    <tr>
      <td><p>Here is message: '.$_POST['message'].'</p>
      <p>URL: '.$_POST['url'].'</p>
      <p><a href="http://www.istevision.org/">visit our website.</a></p></td>
    </tr>
  </table>
</body>
</html>
';

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
	// Additional headers
	//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
	$headers .= 'From: istevision  <webmaster@istevision.org>' . "\r\n";
	//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
	//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
	$headers .= 'Reply-To: noreply <noreply@istevision.org>' . "\r\n";
	$headers .= 'Return-Path: noreply <noreply@istevision.org>' . "\r\n";
			
	// Mail it
	mail($to, $subject, $message, $headers, '-fwebmaster@istevision.org');
?>