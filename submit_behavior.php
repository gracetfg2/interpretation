<?php
function Connect() {
    $servername = "localhost";
    $username = "root";
    $password = "1234567";
    $database = "crowdsight_interpretation";

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
    if (!($stmt = mysqli_prepare($conn, "INSERT INTO BehaviorGlobal (PageOpenedTime, FirstCharTime, DesignerID) VALUES (?, ?, ?)"))) {
        echo "SendData prepare failed: (" . $conn->errno . ") " . $conn->error;
    }
    $globalInfo = json_decode($jsonGlobals);
    $designerID = 1;
    $stmt->bind_param("iii", $globalInfo->openPageTimestamp, $globalInfo->firstCharTimestamp, $designerID);
    $stmt->execute();
    mysqli_stmt_close($stmt);
    
    $lastInsertIdx = $conn->insert_id;
    $textareaInfo = json_decode($jsonTextareas);
    //var_dump($textareaInfo);
    
    foreach($textareaInfo as &$textbox) {
        //echo "Iterating";
        //var_dump($textbox);
        if (!($stmt = mysqli_prepare($conn, "INSERT INTO BehaviorTextarea (BehaviorIndex, FirstCharTime, LastCharTime, PauseCount, PauseTime, WordCount, SentenceCount) VALUES (?, ?, ?, ?, ?, ?, ?)"))) {
            echo "SendData prepare failed: (" . $conn->errno . ") " . $conn->error;
        }
        $firstInput = $textbox->firstInputTimestamp;
        $lastInput = $textbox->lastInputTimestamp;
        $pauseCount = $textbox->pauseCount;
        $pauseTime = $textbox->pauseTime;
        $wordCount = $textbox->wordCount;
        $sentCount = $textbox->sentenceCount;
        $stmt->bind_param("iiiiiii", $lastInsertIdx, $firstInput, $lastInput, $pauseCount, $pauseTime, $wordCount, $sentCount);
        $stmt->execute();
        mysqli_stmt_close($stmt);
    }
}

function CommitToDatabase($jsonGlobals, $jsonTextareas) {
    $conn = Connect();
    SendData($jsonGlobals, $jsonTextareas, $conn);
    CloseConnection($conn);
    return true;
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