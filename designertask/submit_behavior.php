<?php


session_start();    
//************* Check Login ****************// 
$DESIGNER= $_SESSION['designer_id'];
$designID= $_POST['designIdx'];


if(!$DESIGNER) { header("Location: ../index.php"); die(); }

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();
    

function CloseConnection($conn) {
    mysqli_close($conn);
}

function SendData($jsonGlobals, $jsonTextareas, $feedbackRatings, $conn) {
    global $DESIGNER;

    /*****Save Global Info***********/
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
    
 /*
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



    $ratingInfo = json_decode($feedbackRatings);
    //var_dump($textareaInfo);
    
    foreach($ratingInfo as $label => $textbox) {
        echo $label . $textbox;
    }
*/

}


function CommitToDatabase($jsonGlobals, $jsonTextareas, $ratings) {

    //SendData($jsonGlobals, $jsonTextareas, $ratings,  $conn);
    SendData($jsonGlobals, $jsonTextareas, $ratings);
    CloseConnection($conn);
    return true;
}

 $send_succeed= CommitToDatabase($_POST['jsonGlobals'], $_POST['jsonTextareas'],  $_POST['jsonRating']);

 if( $send_succeed== true)
 {
    echo "complete saving data";
 }
 else
 {
    echo "Commit To Database fail";
 }





?>
