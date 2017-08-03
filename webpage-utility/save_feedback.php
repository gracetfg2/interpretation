<?php

session_start();

if(!$_GET['mid'] ){header('Location: ../feedback_error.php');}
$mid =$_GET['mid'];

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($stmt = mysqli_prepare($conn, "SELECT DesignID, mturk_code From Design WHERE mid = ?")) {
    /* bind parameters for markers*/ 
    mysqli_stmt_bind_param($stmt, "s", $mid);
    /* execute query */
    mysqli_stmt_execute($stmt);
    /* bind result variables*/ 
    mysqli_stmt_bind_result($stmt, $design_id, $mturk_code);
    /* fetch value */
    mysqli_stmt_fetch($stmt);
    /* close statement */
    mysqli_stmt_close($stmt);
}

/************ Save Provider Information***************/
if ($stmt = mysqli_prepare($conn, "SELECT ProviderID From u_Provider WHERE IP = ? AND PROXY = ?")) 
 {
    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "ss", $_POST['_ip'], $_POST['_proxy']);
    /* execute query */
    mysqli_stmt_execute($stmt);
    $stmt->store_result();
    
    
    /* bind result variables */
    if($stmt->num_rows > 0) 
    {
        //existing provider
        mysqli_stmt_bind_result($stmt, $current_provider);
        /* fetch value */
        mysqli_stmt_fetch($stmt);
        $_SESSION['c_provider']=$current_provider; 
        /* close statement */
        mysqli_stmt_close($stmt);
    } 
    else 
    {
        //new provider
        $stmt = $conn->prepare("INSERT INTO u_Provider (IP, PROXY) VALUES ( ?,?)");
                
        $stmt->bind_param("ss", $_ip,$_proxy);
        $success = $stmt->execute();
        if(!$success){
           
            $isOkay=false;
            echo "Error: " .$stmt->error;  mysqli_stmt_close($stmt);die();
        }
        else
        {
            $_SESSION['c_provider']= $stmt->insert_id; mysqli_stmt_close($stmt);
        }
         
    }
 }





$stmt = $conn->prepare("INSERT INTO Feedback (f_ProviderID,f_DesignID,category,content,preparedTime,taskTime,age,expertise,gender, countDel,numOfPause,turkerID,  design_quality) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?)");
    
    $stmt->bind_param("iissiisisiisi", $currentProvider, $design_id, $category,$fbktext, $preparedTime, $taskTime, $age, $expertise, $gender, $del, $pause, $turkerID,  $quality);
   
    $currentProvider=$_SESSION['c_provider']; 
    $category=$_POST['_type'];
    
    $preparedTime= $_POST['prepareTime'];
    $taskTime= $_POST['taskTime'];
    $age= $_POST['_age'];
    $expertise= $_POST['_expertL'];
    $gender= $_POST['_gender'];
    $fbktext=nl2br($_POST['_fbk-text']);
    $del=$_POST['numberOfDel'];
    $pause=$_POST['numberOfPause'];
    $turkerID=$_POST['_turkerID'];
    $quality=$_POST['_quality'];
 

    $success = $stmt->execute();
    if(!$success){
        $isOkay=false;
        echo "Error: " .$stmt->error; die();
    }
mysqli_close($conn);

echo "The submission code is <strong>".$mturk_code."</strong>. <br>Please copy the code and paste it to the HIT page to receive your compensation. ";

?>

