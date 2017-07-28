<?php
function displayFK($currentv,$feedback){

	 echo "<table class='table table-hover table-nonfluid'>";
	 echo " <thead><td></td><td width='70%' align='left'><strong></strong></td><td width='25%' align='center'><strong>Perceived Quality</strong></td></thead>";
	  echo " <tbody>";
		$count_feedback=1;	  
		//echo count($fk_overall);
		 foreach($feedback as  $value)
	     {
	    	if($value['category']==$currentv)
	    	{
		   		echo "<tr id='div-".$value['FeedbackID']."' ";
				//if($value['designer_rating']==0) {echo "class='has-error'";} 
		   		echo ">";
//$content=$value['content'];
				
				//*****************Changed to edited_content!!
				//$content=htmlspecialchars($value['content']);
				$content=htmlspecialchars($value['edited_content']);
				$content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);
   			

       			echo "<td><strong>#".$count_feedback."</strong></td><td width='70%' style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".$content."</td>	
       		
       			<td width='25%'>
       			<table border='0' cellpadding='5' cellspacing='0'>
				<tr aria-hidden='true'>
					<td  class='radio-label'></td>
					<td><label class='radio-cell'>1</label></td> 
					<td><label class='radio-cell'>2</label></td> 
					<td><label class='radio-cell'>3</label></td> 
					<td><label class='radio-cell'>4</label></td>
					<td><label class='radio-cell'>5</label></td> 
					<td><label class='radio-cell'>6</label></td>
					<td><label class='radio-cell'>7</label></td> 
					<td  class='radio-label' ></td>
				</tr>
				
				<tr>
					<td class='radio-label' ><strong>Low</strong></td>
					<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."1'  value='1' "; if ($value['designer_rating']==1){echo "checked ";} echo "onclick='rate(this.name,1);'></td>
					<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."2'  value='2' "; if ($value['designer_rating']==2){echo "checked ";} echo "onclick='rate(this.name,2);'></td>
					<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."3'  value='3' "; if ($value['designer_rating']==3){echo "checked ";} echo "onclick='rate(this.name,3);'></td>
					<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."4'  value='4' "; if ($value['designer_rating']==4){echo "checked ";} echo "onclick='rate(this.name,4);'></td>
					<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."5'  value='5' "; if ($value['designer_rating']==5){echo "checked ";} echo "onclick='rate(this.name,5);'></td>
					<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."6'  value='6' "; if ($value['designer_rating']==6){echo "checked ";} echo "onclick='rate(this.name,6);'></td>
					<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."7'  value='7' "; if ($value['designer_rating']==7){echo "checked ";} echo "onclick='rate(this.name,7);'></td>
					<td class='radio-label'><strong>High</strong></td>		
				</tr>

				</table>
				</td>
				
		
				</tr>
			";
        	
		    	$count_feedback++;
			}
		}
	echo " </tbody></table>";

	

}


function justget($currentv,$feedback){

		$count_feedback=1;	  
		//echo count($fk_overall);
		 foreach($feedback as  $value)
	     {
	    	if($value['category']==$currentv)
	    	{
			
				$content=htmlspecialchars($value['edited_content']);
				$content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);
   		

       			echo "<strong>[ ".$count_feedback." ]</strong> ".$content."<br><br>";
        	
		    	$count_feedback++;
			}
		}

}
?>