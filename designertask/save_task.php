<?php


session_start();    
//************* Check Login ****************// 
$designerID= $_SESSION['designer_id'];

if(!$designerID) { header("Location: ../index.php"); die(); }

//************* Get Data****************// 
$designID= $_POST['designIdx'];
$_jsonGlobals= $_POST['jsonGlobals'];
$jsonTextareas= $_POST['jsonTextareas'];
$jsonRating= $_POST['jsonRating'];
/********************************************/

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();
    

/*****Save Global Info***********/
if (!($stmt = mysqli_prepare($conn, "INSERT INTO BehaviorGlobal (PageOpenedTime, FirstCharTime, DesignerID, total_task, total_interpretation, total_reflection) VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE
PageOpenedTime = VALUES(PageOpenedTime), FirstCharTime = VALUES(FirstCharTime)"))) {
    echo "SendData Global prepare failed: (" . $conn->errno . ") " . $conn->error;
}
$jsonGlobals = json_decode($_jsonGlobals);

$pageOpen = $jsonGlobals->openPageTimestamp;
$pageClose = $jsonGlobals->closePageTimestamp;
$zero = 0;

$stmt->bind_param("iiiiii", $pageOpen, $jsonGlobals->firstCharTimestamp, $designerID, $zero, $zero, $zero);
$stmt->execute();
mysqli_stmt_close($stmt);

$totalTime = ($pageClose - $pageOpen) / 1000;

if (!($stmt = mysqli_query($conn, "UPDATE BehaviorGlobal SET total_task=total_task+".$totalTime." WHERE `DesignerID`=".$designerID))) {
    echo "SendData global task query failed: (" . $conn->errno . ") " . $conn->error;
}

if($_POST['originPage'] == "reflection.php" || $_POST['originPage'] == "reflection_second.php") {
    if (!($stmt = mysqli_query($conn, "UPDATE BehaviorGlobal SET total_reflection=total_reflection+".$totalTime." WHERE `DesignerID`=".$designerID))) {
    echo "SendData Global reflection query failed: (" . $conn->errno . ") " . $conn->error;
    }
}
else if($_POST['originPage'] == "explain.php" || $_POST['originPage'] == "explain_initial.php") {
    if (!($stmt = mysqli_query($conn, "UPDATE BehaviorGlobal SET total_interpretation=total_interpretation+".$totalTime." WHERE `DesignerID`=".$designerID))) {
        echo "SendData Global interpretation query failed: (" . $conn->errno . ") " . $conn->error;
    }
}


/*****Save Text Data***********/
$textareaInfo = json_decode($jsonTextareas);
    
foreach($textareaInfo as $label => $textbox) {
    //echo "Iterating";
 
    if (!($stmt = mysqli_prepare($conn, "INSERT INTO BehaviorTextarea (DesignerID, Label, FirstCharTime, LastCharTime, PauseCount, PauseTime, DeleteCount, WordCount, SentenceCount, visible_time, writing_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
    FirstCharTime = VALUES(FirstCharTime), LastCharTime = VALUES(LastCharTime), 
    PauseCount = VALUES(PauseCount), PauseTime = VALUES(PauseTime), DeleteCount = VALUES(DeleteCount), 
    WordCount = VALUES(WordCount), SentenceCount = VALUES(SentenceCount),
    visible_time = visible_time + VALUES(visible_time),
    writing_time = writing_time + VALUES(writing_time)"))) {
        echo "SendData Textarea prepare failed: (" . $conn->errno . ") " . $conn->error;
    }

    $firstInput = $textbox->firstInputTimestamp;
    $lastInput = $textbox->lastInputTimestamp;
    $pauseCount = $textbox->pauseCount;
    $pauseTime = $textbox->pauseTime;
    $deleteCount = $textbox->deleteCount;
    $wordCount = $textbox->wordCount;
    $sentCount = $textbox->sentenceCount;
    $visibleTime = $textbox->visibleTime / 1000;
    $writingTime = $textbox->writingTime / 1000;

    $stmt->bind_param("isiiiiiiidd", $designerID, $label, $firstInput, $lastInput, $pauseCount, $pauseTime, $deleteCount, $wordCount, $sentCount, $visibleTime, $writingTime);
    $stmt->execute();
    mysqli_stmt_close($stmt);

    if( $label =="reflection")
    {
        if (!($stmt = mysqli_prepare($conn, "INSERT INTO Reflection (DesignerID, DesignID, content) VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE
        content = VALUES(content)"))) {
            echo "SendData Reflection prepare failed: (" . $conn->errno . ") " . $conn->error;
        }
        $content= $textbox->content;
        $stmt->bind_param("iis", $designerID, $designID, $content);
        $stmt->execute();
        mysqli_stmt_close($stmt);
   
    }
    else
    {

        $split = explode("-",  $label);
        $label=$split[0];
        $feedback_id=$split[1];
        $sql = "UPDATE `ExpertFeedback` SET `interpretation` =? WHERE `FeedbackID`=?";
        
         // echo $feedback_id. "=>".$textbox->content;
        if($stmt = mysqli_prepare($conn,$sql)){
            mysqli_stmt_bind_param($stmt, "si",$textbox->content, $feedback_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

    }

}

/*****Save Rating Data***********/
$ratingInfo = json_decode($jsonRating);
//var_dump($textareaInfo);

foreach($ratingInfo as $label => $textbox) {
   //echo  "feedbackid=".$label."=>".$textbox->rating;

    $sql = "UPDATE `ExpertFeedback` SET `designer_rating` =? WHERE `FeedbackID`=?";
    
    if($stmt = mysqli_prepare($conn,$sql)){
        mysqli_stmt_bind_param($stmt, "ii",$textbox->rating, $label);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

}

header('Location: '.$_POST['redirect']);


?>
