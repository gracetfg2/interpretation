<?php
session_start();
$feedback_id= $_POST['feedbackid'];
$action= $_POST['action'];
$provider=  $_POST['provider'];
$rating=  $_POST['rating'];

echo 'feedbackid'.$_POST['feedbackid'].'action'.$action.'provider'.$provider;

?>  