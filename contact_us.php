<?php
//store the to address in a simple variable
$E_Addr=$_GET['mail'];
$To_Addr = "rc239898@dal.ca";
$subject = $_GET['subject'];
$message = $_GET['message'];
$name = $_GET['name'];
$headers = <<<_END
From: {$name} <{$E_Addr}>
Reply-To: {$To_Addr}
_END;
//send an email to the recipient
mail($To_Addr, $subject, $message, $headers);
//redirect to thank you page
header("Location: thanks.php");
?>