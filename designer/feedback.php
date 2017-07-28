<?php

session_start();	
//************* Check Login ****************// 
$DESIGNER= $_SESSION['designer_id'];
$EXPERIMENT=$_SESSION["experimentID"]=1;
if(!$DESIGNER) { header("Location: ../index.php"); die(); }
//************* End Check Login ****************// 

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();

$filename="";  	
	$sql="SELECT * FROM u_Designer WHERE DesignerID=?";
	if($stmt=mysqli_prepare($conn,$sql))
	{
		mysqli_stmt_bind_param($stmt,"i",$DESIGNER);
		mysqli_stmt_execute($stmt);
		$result = $stmt->get_result();
		$designer=$result->fetch_assoc() ;		 	
	    mysqli_stmt_close($stmt);	

	}	


	if($designer['process']>5 ||$designer['process']<4)
	{ header("Location: ../index.php"); die(); }


	$sql="SELECT * FROM Design WHERE f_designerID=? AND version=?";
	if($stmt=mysqli_prepare($conn,$sql))
	{
		$version=1;
		mysqli_stmt_bind_param($stmt,"ii",$DESIGNER,$version);
		mysqli_stmt_execute($stmt);
		$result = $stmt->get_result();
		$design=$result->fetch_assoc() ;		 	
	    mysqli_stmt_close($stmt);	
	}
$design_id=$design['DesignID'];
$mid=$design['mid'];
$ok_to_use=1;
	if ($stmt1 = mysqli_prepare($conn, "SELECT file From Design WHERE  DesignID= ? AND f_DesignerID = ?")) {
	    mysqli_stmt_bind_param($stmt1, "ii", $design_id,$DESIGNER);
	    mysqli_stmt_execute($stmt1);
	    $stmt1->store_result();
		if($stmt1->num_rows > 0) {
		    mysqli_stmt_bind_result($stmt1, $filename);
		    mysqli_stmt_fetch($stmt1);
		    mysqli_stmt_close($stmt1);
		    //**************** Get Feedback ****************//
		    if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Feedback` WHERE `f_DesignID`=? AND `ok_to_use`=? ORDER BY FeedbackID ASC")) {
	    		mysqli_stmt_bind_param($stmt2, "ii", $design_id, $ok_to_use);
	    		mysqli_stmt_execute($stmt2);
	    		$result = $stmt2->get_result();
	    		while ($myrow = $result->fetch_assoc()) {
	    			$feedback[]=$myrow;
	    			switch ($myrow['category']){
	    				case "'overall'":
	    					$fk_overall[]=$myrow;break;
	    				case "layout":
	    					$fk_layout[]=$myrow;break;
	    				case "aes":
	    					$fk_aes[]=$myrow;break;
	    				default:
	    					$fk_overall[]=$myrow;break;

	    			}
	    		}  
	    		$feedback_text=json_encode($feedback);
	    		mysqli_stmt_close($stmt2);	
			}
			else {
		    //No Designs found
		    	echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
		    	mysqli_stmt_close($stmt2);
		    	die();
			}
	   		
		}
		else 
		{
			echo "You don't have the permission to view this page. If you have any questions, please contact Grace (design4uiuc@gmail.com) with error code: View-Feedback-GetDesign";die();
		}
	} 
	else
	{	
		//mysqli_stmt_close($stmt1);
		echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
		die();
	}


	mysqli_close($conn);

?>
 <html lang="en">
<head>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<?php include('../webpage-utility/ele_header.php');?>
     <script type="text/javascript" src="/reflection/js/behavior_for_reviewfeedback.js"></script>


    <title>Home </title>
    <!-- Custom styles for this template -->

 <style>
 body{
background-color: #F0F0F0 ;

}

 .project-description{
	text-align: justify;
	font-size:14px;
}

.img-div{
    float: left;
    padding-right: 30px;
    margin-left: 30px;
    text-align:right;
}
#head_frame{

	padding-right: 30px;
    padding-left: 30px;
	padding-top: 10px;
    padding-bottom: 20px;
    margin-top: 20px;
    border-radius: 20px;

}

#sub-frame{
	background-color: #FAFAFA;
	padding-right: 30px;
    padding-left: 30px;
	padding-top: 10px;
    padding-bottom: 20px;
    margin-top: 20px;
    border-radius: 20px;

}
#submit-bn{
	padding-top:"10px";
	width: "500px";
}
.rating{
	  float: left;
}
.table-head{
	font-weight: bold;
}


.radio-cell{
	width: 25px;
	text-align: center;
} 
.radio-label{
	width: 50px;
	text-align: center;
} 

.table-nonfluid {
   width: auto;
}

.btn-submit {
  background: #288a5c;
  background-image: -webkit-linear-gradient(top, #288a5c, #305242);
  background-image: -moz-linear-gradient(top, #288a5c, #305242);
  background-image: -ms-linear-gradient(top, #288a5c, #305242);
  background-image: -o-linear-gradient(top, #288a5c, #305242);
  background-image: linear-gradient(to bottom, #288a5c, #305242);
  -webkit-border-radius: 25;
  -moz-border-radius: 25;
  border-radius: 25px;
  -webkit-box-shadow: 1px 3px 5px #666666;
  -moz-box-shadow: 1px 3px 5px #666666;
  box-shadow: 1px 3px 5px #666666;
  font-family: Arial;
  color: #ffffff;
  font-size: 18px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}

.btn-submit:hover {
  background:  #a8e6bb;;
  text-decoration: none;

}
.table-text{
 font-size: 14px;

}

#help-text
{
	font-size: 14px;
}

.has-error
{
	background-color:#f2dede ;
}

.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
  background-color: #FFFFCC;
}
</style>
 </head>
 <body>
 <?php include($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/ele_nav.php');?>
<div class="main-section">

<div class="container" style="background-color:white; padding-top:20px;   border-radius: 15px; ">

<!--
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title"><span style="font-size:20px">Review Feedback</h1>
  </div>
  <div class="panel-body">
    <span style='font-size:16px'> 
		We collected three catogories of feedback on your initial design - <b>Overall/Thematic, Layout, Aesthetics </b>. In the task, please read each piece of feedback and rate its perceived quality. You may want to consider the degree to which the feedback is specific, actionable, and helpful for improving the design or the design process. We expect you to spend approximatly 10 minutes on this task. After reviewing all the feedback, please click "Submit", and we will lead you to the next steps.
	</span>
  </div>
</div>
-->
<div class="alert alert-info" style='width:80%; text-align:justify; ;height:auto ;margin:0px auto;padding-top: 0px; padding-left: 25px;padding-right: 15px; font-size:16px;color:black;' >
<h3>Review Feedback</h3>
	   <p>  To help you revise your design, we have collected feedback from independent reviewers on your initial design. Please review each piece of the feedback and rate its quality. You may want to consider the degree to which the feedback is helpful for improving the design or gaining insight. Also, you may disregard any feedback that is outside the scope of the design brief. The feedback spans three categories:</p>
	  <p >
	   	<li style="text-indent:20px"><b>Overall concept </b>  of the design.</li>
	   	<li style="text-indent:20px"><b>Layout and composition </b>of the visual elements in the design.</li>
	   	<li style="text-indent:20px"><b>Aesthetics</b> of the design such as the color, font, and imagery choices.</li>
	   </p>
	   <hr>
<p>
	    You should spend about<strong> 15 minutes reviewing the feedback. </strong> After rating the feedback, please click "Submit" to save the ratings and go to the next step. If you want to later reference the feedback, please <a href="#" data-toggle="modal" data-target="#feedbackModal" >copy </a> and save it to your computer.
	   </p>
	<p><br>
	<a href= 'view_initial.php?mid=<?php echo $mid;?>' target="_blanck"> See design description and my initial design</a>

</div>


<div class="row" style="padding-top: 20px">

<div class="col-md-12">

	<form name='rating-form' id='rating-form' action='save_rating.php?design_id=<?php echo $design_id;?>' method='post'>
	<?php
		include('feedback_list.php');
		$type=array("overall","aes","layout");
		if(count($feedback)>0){
			foreach ($type as $value)
			{
				switch ($value)
				{
					case 'overall': $cat='About overall concept';break;
					case 'aes': $cat='About aesthetics';break;
					case 'layout': $cat='About layout and composition';break;
					default: break;

				} 
				echo "	<div class='panel panel-default'>
	  						<div class='panel-heading'>
	    				   		<h1 class='panel-title'><span style='font-size:20px'>".$cat."</h1>
	 						</div>
	  				  		<div class='panel-body'>";  				  		
	  				  		displayFK($value,$feedback);   
	  				  							
	  					echo "</div></div>";
			}
		}else
		{
			echo "<div style='text-align:center'><p>Please contact Grace Yen at <em>design4uiuc@gmail.com</em> if your feedback does not show properly.</p></div>";
		}
		

	?>

				<input type="hidden" id="_behavior" name="_behavior" value=""/>

				<input type="hidden" id="startTime" name="startTime" value=""/>
				<input type="hidden" id="submitTime" name="submitTime" value=""/>
        		<input type="hidden" id="prepareTime" name="prepareTime" value=""/>
        		<input type="hidden" id="taskTime" name="taskTime" value=""/> 	
        		<input type="hidden" id="eventHistory" name="eventHistory" value=""/>
	

	</form>



<!-- Modal -->
<div id="feedbackModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body">
       
      		<?php
		$type=array("overall","aes","layout");
		if(count($feedback)>0){
			foreach ($type as $value)
			{
				switch ($value)
				{
					case 'overall': $cat='About overall concept';break;
					case 'aes': $cat='About aesthetics';break;
					case 'layout': $cat='About layout and composition';break;
					default: break;

				} 
				echo "	<h3>".$cat."</h3>";  				  		
	  				  		justget($value,$feedback);  
	  					echo "<br>";
			}
		}else
		{
			echo "<div style='text-align:center'><p>Please contact Grace Yen at <em>design4uiuc@gmail.com</em> if your feedback does not show properly.</p></div>";
		}
		

	?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


	<?php //If feedback are prepared, they will see the button
		if ( (count($fk_overall) > 0) && (count($fk_layout) > 0) &&(   count($fk_aes) > 0) )
		{
			echo "<div style='text-align:center;margin-top:20px;margin-bottom:20px'>";
			 echo "<button type='submit' class='btn-submit' id='submit-bn' onclick='submit();''>Submit</button> ";
			echo "</div>";
		}
		
	?>
	
</div><!--end of col-med-8-->


</div><!--end of row-->



</div><!-- ENd of container-->

</div><!-- ENd of main-section-->





 </body>



</html>