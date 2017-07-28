	<?php


	$sql="SELECT * FROM Design WHERE DesignID=?";
	if($stmt=mysqli_prepare($conn,$sql))
	{
		
		mysqli_stmt_bind_param($stmt,"i",$did);
		mysqli_stmt_execute($stmt);
		$result = $stmt->get_result();
		$design=$result->fetch_assoc() ;		 	
	    mysqli_stmt_close($stmt);	
	}




		include('feedback_list.php');
		$type=array("overall","aes","layout");
		if(count($feedback)>0){
			foreach ($type as $value)
			{
				switch ($value)
				{
					case 'overall': $cat='Direction';break;
					case 'aes': $cat='Aesthetics';break;
					case 'layout': $cat='Layout and Composition';break;
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