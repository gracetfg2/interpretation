<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();

foreach ($_POST as $key => $value)
{
  // echo $key;
  // echo ' ';
  // echo $value;
  // echo '    ';
	// $sql = "UPDATE `exp1_Feedback` SET `designer_rating` =".htmlspecialchars($value)." WHERE `FeedbackID`=".htmlspecialchars($key);
	// if (mysqli_query($conn, $sql)) {
	//     //echo $sql."<br>" ;
	// } else {
	//     echo "Error updating record: " . mysqli_error($conn);
	// }

  if (strpos($key,'p') !== false) {// process
		$sql2 = "UPDATE u_Designer SET `process` ='".htmlspecialchars($value)."' WHERE DesignerID=".substr($key,1);
		if (mysqli_query($conn, $sql2)) {
		    //echo $sql2."</br>";
		} else {
		    echo "Error updating record: " . mysqli_error($conn);
		}
	}
  else if (strpos($key,'g') !== false) {// group
		$sql2 = "UPDATE u_Designer SET `group` ='".htmlspecialchars($value)."' WHERE DesignerID=".substr($key,1);
		if (mysqli_query($conn, $sql2)) {
		    //echo $sql2."</br>";
		} else {
		    echo "Error updating record: " . mysqli_error($conn);
		}
	}
	else if (strpos($key,'m') !== false) {// group
		$sql2 = "UPDATE u_Designer SET `1paid` ='".htmlspecialchars($value)."' WHERE DesignerID=".substr($key,1);
		if (mysqli_query($conn, $sql2)) {
		    //echo $sql2."</br>";
		} else {
		    echo "Error updating record: " . mysqli_error($conn);
		}
	}
	else if (strpos($key,'s') !== false) {// group
		$sql2 = "UPDATE u_Designer SET `2paid` ='".htmlspecialchars($value)."' WHERE DesignerID=".substr($key,1);
		if (mysqli_query($conn, $sql2)) {
		    //echo $sql2."</br>";
		} else {
		    echo "Error updating record: " . mysqli_error($conn);
		}
	}
	else if (strpos($key,'n') !== false) {// group
		$sql2 = "UPDATE u_Designer SET `backemail` ='".htmlspecialchars($value)."' WHERE DesignerID=".substr($key,1);
		if (mysqli_query($conn, $sql2)) {
		    //echo $sql2."</br>";
		} else {
		    echo "Error updating record: " . mysqli_error($conn);
		}
	}		
}

mysqli_close($conn);
header('Location: control_panel.php');

?>
