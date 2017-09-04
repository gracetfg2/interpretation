<?php
// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = "ttesttest ";

// send email
mail("gracetfg2@gmail.com","My subject",$msg);
?>