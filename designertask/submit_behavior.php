<?php


session_start();    
//************* Check Login ****************// 
$DESIGNER= $_SESSION['designer_id'];
if(!$DESIGNER) { header("Location: ../index.php"); die(); }

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');

function Connect(){
    $servername = "cpanel3.engr.illinois.edu";
    $username = "mouscho2_admin";
    $password = "AdminP@ss";
    $database = "mouscho2_DesignProxy";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function CloseConnection($conn) {
    mysqli_close($conn);
}

function SendData($jsonGlobals, $jsonTextareas, $conn) {
    global $DESIGNER;
    if (!($stmt = mysqli_prepare($conn, "INSERT INTO BehaviorGlobal (PageOpenedTime, FirstCharTime, DesignerID) VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE
    PageOpenedTime = VALUES(PageOpenedTime), FirstCharTime = VALUES(FirstCharTime)"))) {
        echo "SendData Global prepare failed: (" . $conn->errno . ") " . $conn->error;
    }
    $globalInfo = json_decode($jsonGlobals);
    $designerID = $DESIGNER;

    $stmt->bind_param("iii", $globalInfo->openPageTimestamp, $globalInfo->firstCharTimestamp, $designerID);
    $stmt->execute();
    mysqli_stmt_close($stmt);
    
    //$lastInsertIdx = $conn->insert_id;
    $textareaInfo = json_decode($jsonTextareas);
    //var_dump($textareaInfo);
    
    foreach($textareaInfo as $label => $textbox) {
        //echo "Iterating";
        //var_dump($textbox);
        if (!($stmt = mysqli_prepare($conn, "INSERT INTO BehaviorTextarea (DesignerID, Label, FirstCharTime, LastCharTime, PauseCount, PauseTime, DeleteCount, WordCount, SentenceCount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
        FirstCharTime = VALUES(FirstCharTime), LastCharTime = VALUES(LastCharTime), 
        PauseCount = VALUES(PauseCount), PauseTime = VALUES(PauseTime), DeleteCount = VALUES(DeleteCount), 
        WordCount = VALUES(WordCount), SentenceCount = VALUES(SentenceCount)"))) {
            echo "SendData Textarea prepare failed: (" . $conn->errno . ") " . $conn->error;
        }
        $firstInput = $textbox->firstInputTimestamp;
        $lastInput = $textbox->lastInputTimestamp;
        $pauseCount = $textbox->pauseCount;
        $pauseTime = $textbox->pauseTime;
        $deleteCount = $textbox->deleteCount;
        $wordCount = $textbox->wordCount;
        $sentCount = $textbox->sentenceCount;
        $stmt->bind_param("isiiiiiii", $DESIGNER, $label, $firstInput, $lastInput, $pauseCount, $pauseTime, $deleteCount, $wordCount, $sentCount);
        $stmt->execute();
        mysqli_stmt_close($stmt);
    }
}


function CommitToDatabase($jsonGlobals, $jsonTextareas) {
    $conn = Connect();
    //SendData($jsonGlobals, $jsonTextareas, $ratings,  $conn);
    SendData($jsonGlobals, $jsonTextareas, $conn);
    CloseConnection($conn);
    return true;
}


if($_SESSION['jankPost'] == "reflection") {
    $_POST['jsonGlobals'] = $_SESSION['jsonGlobals'];
    $_POST['jsonTextareas'] = $_SESSION['jsonTextareas'];
    $_POST['redirect'] = $_SESSION['redirect'];
    unset($_SESSION['jsonGlobals']);
    unset($_SESSION['jsonTextareas']);
    unset($_SESSION['redirect']);
    unset($_SESSION['jankPost']);
}

if (isset($_POST['jsonGlobals']) && isset($_POST['jsonTextareas'])) {
    CommitToDatabase($_POST['jsonGlobals'], $_POST['jsonTextareas']);
    if(isset($_POST['redirect'])) {

        header("Location: " . $_POST['redirect']);
    }
    else {
        echo "Redirect not POSTed!";
    }
}
else {
    echo "jsonGlobals and/or jsonTextareas not POSTed!";
}
?>
