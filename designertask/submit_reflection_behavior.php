<?php

session_start();    
//************* Check Login ****************// 
if(!$_SESSION['designer_id']) { header("Location: ../index.php"); die(); }

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');

function CommitToDatabase() {
    $conn = connect_to_db();
    UploadReflection($_SESSION['designer_id'], $_POST['designIdx'], $_POST['content'], $conn);
    CloseConnection_Util($conn);
}

if(isset($_POST['content']) && isset($_POST['designIdx'])) {
    CommitToDatabase();
}

if (isset($_POST['jsonGlobals']) && isset($_POST['jsonTextareas'])) {
    
    if(isset($_POST['redirect'])) {
        $url = 'submit_behavior.php';
        $_SESSION['jsonGlobals'] = $_POST['jsonGlobals'];
        $_SESSION['jsonTextareas'] = $_POST['jsonTextareas'];
        $_SESSION['redirect'] = $_POST['redirect'];
        $_SESSION['jankPost'] = "reflection";
        header("Location: submit_behavior.php");
    }
    else {
        echo "Redirect not POSTed! Can't POST to submit_behavior.php!";
    }
}
else {
    echo "jsonGlobals and/or jsonTextareas not POSTed! Can't POST to submit_behavior.php!";
}