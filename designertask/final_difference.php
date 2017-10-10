
<div class="sub_frame" id="div-difference" name="div-difference">			
		<h4 class="nquestion_text"><strong> 
		11. How would you rate the difference between the two tasks, restating the meaning of the feedback versus reflecting on the feedback? 		
				
			 </strong> </h4>				
				<table border="0" cellpadding="5" cellspacing="0" id="entry_1519429516">
					<tr aria-hidden="true">
						<td  class="radio-label" style="width: 140px"></td>
						<td><label class="radio-cell">1</label></td> 
						<td><label class="radio-cell">2</label></td> 
						<td><label class="radio-cell">3</label></td> 
						<td><label class="radio-cell">4</label></td>
						<td><label class="radio-cell">5</label></td> 
						<td><label class="radio-cell">6</label></td>
						<td><label class="radio-cell">7</label></td>  
						<td  class="radio-label" style="width: 140px"></td>
					</tr>
					
					<tr>
					<td class="radio-label" style="width: 60px" >Almost the same</td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="difference" id="difference" value="1" <?php if ($difference_rating==1) echo 'checked'?> ></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="difference" id="difference" value="2"<?php if ($difference_rating==2) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="difference" id="difference" value="3" <?php if ($difference_rating==3) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="difference" id="difference" value="4" <?php if ($difference_rating==4) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="difference" id="difference" value="5" <?php if ($difference_rating==5) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="difference" id="difference" value="6" <?php if ($difference_rating==6) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="difference" id="difference" value="7" <?php if ($difference_rating==7) echo 'checked'?>></td>
					<td class="radio-label" style="width: 200px"> Completely different</td>		
					</tr>
					</table>
</div>

<div class="sub_frame" id="div-ex-reflection" name="div-ex-difference"><h4 class="nquestion_text"><strong> 12. Please briefly explain your rating given to question 11. </strong> </h4>
	 <textarea id="ex_difference" name="ex_difference" rows="4" cols="52" style="width:100%;"><?php echo htmlspecialchars($explain_difference, ENT_QUOTES); ?></textarea>	
</div>
