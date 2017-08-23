<?php


session_start();    
//************* Check Login ****************// 
$DESIGNER= $_SESSION['designer_id'];
if(!$DESIGNER) { header("Location: ../index.php"); die(); }

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');

function Connect(){
    return connect_to_db();
}

function CloseConnection($conn) {
    mysqli_close($conn);
}

function SendData($jsonGlobals, $jsonTextareas, $ratings, $conn) {
    if (!($stmt = mysqli_prepare($conn, "INSERT INTO BehaviorGlobal (PageOpenedTime, FirstCharTime, DesignerID) VALUES (?, ?, ?)"))) {
        echo "SendData prepare failed: (" . $conn->errno . ") " . $conn->error;
    }
    $globalInfo = json_decode($jsonGlobals);
    $designerID = $DESIGNER;

    $stmt->bind_param("iii", $globalInfo->openPageTimestamp, $globalInfo->firstCharTimestamp, $designerID);
    $stmt->execute();
    mysqli_stmt_close($stmt);
    
    $lastInsertIdx = $conn->insert_id;
    $textareaInfo = json_decode($jsonTextareas);
    //var_dump($textareaInfo);
    
    foreach($textareaInfo as &$textbox) {
        //echo "Iterating";
        //var_dump($textbox);
        if (!($stmt = mysqli_prepare($conn, "INSERT INTO BehaviorTextarea (BehaviorIndex, FirstCharTime, LastCharTime, PauseCount, PauseTime, WordCount, SentenceCount, content) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"))) {
            echo "SendData prepare failed: (" . $conn->errno . ") " . $conn->error;
        }
        $firstInput = $textbox->firstInputTimestamp;
        $lastInput = $textbox->lastInputTimestamp;
        $pauseCount = $textbox->pauseCount;
        $pauseTime = $textbox->pauseTime;
        $wordCount = $textbox->wordCount;
        $sentCount = $textbox->sentenceCount;
        $content = $textbox->content;
        $stmt->bind_param("iiiiiiis", $lastInsertIdx, $firstInput, $lastInput, $pauseCount, $pauseTime, $wordCount, $sentCount, $content);
        $stmt->execute();
        mysqli_stmt_close($stmt);
    }
}

function CommitToDatabase($jsonGlobals, $jsonTextareas) {
    $conn = Connect();
    SendData($jsonGlobals, $jsonTextareas,  $conn);
    CloseConnection($conn);
    return true;
}

if (isset($_POST['jsonGlobals']) && isset($_POST['jsonTextareas']) ) {
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