<?php

session_start();
//************* Check Login ****************// 
$DESIGNER= $_SESSION['designer_id'];
if(!$DESIGNER) { header("Location: ../index.php"); die(); }
//************* End Check Login ****************// 

$currentVersion=$_POST['version'];
$design_id=$_POST['design_id'];
$project_id=$_POST['project_id'];

//$time_spent=$_POST['time'];
//echo "original project id=".$project_id;

function generateRandomString($length = 10) {
    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
	
    return $randomString;
}

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();
	
$isOkay=true;

//new project, create project first
if( $project_id==0)
{	
	//echo "existing project id=". $project_id."\n";
	$stmt = $conn->prepare("INSERT INTO Project (total_version,title,f_DesignerID) VALUES ( ?,?,?)");
	$total_version=0;
	$title="Flyer-NYC";
	$designer_id=$DESIGNER;
    $stmt->bind_param("isi", $total_version, $title,$designer_id);
    $success = $stmt->execute();
    if(!$success){
    	$isOkay=false;
	    echo "Error: " .$stmt->error; die();
    }
    else
    {
    	$project_id = $stmt->insert_id;
	  
    }
	
	
}
	
	//echo "The Project ID for creating design is = ".$project_id;

	if( $design_id==0)//new Design
	{
		//Add one version to the current project
		$sql3="SELECT * FROM Project WHERE ProjectID=".$project_id;
		$result= mysqli_query($conn,$sql3);
   		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
		}
		
		$update_version = "UPDATE Project SET total_version =?  WHERE ProjectID=?";
		if($stmt_update = mysqli_prepare($conn,$update_version))
		{		
				mysqli_stmt_bind_param($stmt_update, "ii", $currentVersion,$project_id);
				mysqli_stmt_execute($stmt_update);
		}




		//Insert Design 
		$stmt_insert_design = $conn->prepare(" INSERT INTO Design (f_DesignerID, f_ProjectID, time_spent, version, title ) VALUES ( ?,?,?,?,?)");
		$time_spent=$_POST['taskTime']+$_POST['prepareTime'];
		$title="Flyer-NYC";
	    $stmt_insert_design->bind_param("iiiis", $DESIGNER, $project_id,$time_spent, $currentVersion, $title );
	    $success = $stmt_insert_design->execute();
	    if(!$success){
	    	$isOkay=false;
		    echo "Error: " .$stmt_insert_design->error; die();
	    }
	    else
	    {
	    	$design_id = $stmt_insert_design->insert_id;

	    	$generated_mid= $design_id.generateRandomString();
			$generated_turk= $design_id.generateRandomString();
			$updatemid = "UPDATE `Design` SET `mid` = '".$generated_mid."', `mturk_code`='".$generated_turk."'  WHERE `DesignID`=".$design_id;
			if (mysqli_query($conn, $updatemid)) {
				
			} else {
				$isOkay=false;
			    echo "Update mid error : " . mysqli_error($conn); die();
			}

		    
	    }
		
		
	}
	else{
		if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Design` WHERE `DesignID`=?")) {
			mysqli_stmt_bind_param($stmt2, "i", $design_id);
			mysqli_stmt_execute($stmt2);
			$result = $stmt2->get_result();
			$design = $result->fetch_assoc();
			mysqli_stmt_close($stmt2);	
		}
	}



//Upload File
if($_POST['update_file']=="true"){

	if(!$_FILES['fileToUpload']['size'] == 0 && $_FILES['fileToUpload']['error'] == 0)
	{ 

		$target_dir = "../design/";
		$_upload_file = basename($_FILES["fileToUpload"]["name"]);
		$upload_file = (strlen($_upload_file) > 12) ? substr($_upload_file,0,4) : $_upload_file;
		$imageFileType = pathinfo($_upload_file,PATHINFO_EXTENSION);
		$target_file="s".$DESIGNER."_p".$project_id."_v".$currentVersion."_d".$design_id."_".$upload_file.".".$imageFileType;
		$newFilePath= $target_dir.$target_file;

		if(file_exists($newFilePath)) {
		   // echo "delete first";
		    chmod($newFilePath,0755); //Change the file permissions if allowed
		    unlink($newFilePath); //remove the file
		}

	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newFilePath)) {
	    	//echo "save image";
	   		

	    	$sql = "UPDATE Design SET file =? , time_spent=?  WHERE DesignID=?";
			if($stmt = mysqli_prepare($conn,$sql))
			{		
				$current_spent_time=$design['time_spent']+$_POST['taskTime']+$_POST['prepareTime'];
				mysqli_stmt_bind_param($stmt, "sii", $target_file,$current_spent_time, $design_id);
				mysqli_stmt_execute($stmt);
			}

	    } else {
	    
	        echo "Sorry, there was an error uploading your file.";
	    }
	}

}


if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `u_Designer` WHERE `DesignerID`=?")) {
		mysqli_stmt_bind_param($stmt2, "i", $DESIGNER);
		mysqli_stmt_execute($stmt2);
		$result = $stmt2->get_result();
		$designer = $result->fetch_assoc();
		mysqli_stmt_close($stmt2);	
}

$file_name="../behavior/".$designer['group']."/s".$designer['DesignerID']."_design_session_".$currentVersion.".txt"; 
$myfile = fopen($file_name, "a");
$txt = "\n New Record\n".$_POST['_behavior']."\n";
fwrite($myfile, $txt);
fclose($myfile);



if($_POST['action']=="save"){
	//echo "preview";
	if($currentVersion==1)	{
		$sql = "UPDATE `u_Designer` SET `process` =? WHERE `DesignerID`=?";
		if($stmt = mysqli_prepare($conn,$sql)){
			mysqli_stmt_bind_param($stmt, "ii", $process, $DESIGNER);
			$process=2;
			mysqli_stmt_execute($stmt);
		}

	}
	
	mysqli_close($conn);//""
	header( "Location: homepage.php");
}
else
{

	switch ($currentVersion){

		case 1:
			header( "Location: complete_phase1.php");
			break;
		case 2:
			header( "Location: complete_phase2.php");
			break;
		default:
			echo "Oops , something goes wrong.";
			break;
	}
	//header( "Location: complete_phase.php?stage=".$currentVersion);


/* now go to complete_stage_script.php
 	$sql = "UPDATE `u_Designer` SET `process` =? WHERE `DesignerID`=?";
	if($stmt = mysqli_prepare($conn,$sql)){
		if($currentVersion==1)	$process=3;
		else if ($currentVersion==2) $process=5;
		mysqli_stmt_bind_param($stmt, "ii", $process, $DESIGNER);
		mysqli_stmt_execute($stmt);
	}
	mysqli_stmt_close($stmt);

	mysqli_close($conn);//""
	header( "Location: homepage.php");

*/


	
}				 







?>