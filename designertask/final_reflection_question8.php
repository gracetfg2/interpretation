<div class="sub_frame" id="div-reflection" name="div-reflection">			
		<h4 class="nquestion_text"><strong> 
			9. How useful was the task that asked you to write your responses to your feeling, thoughts, and action plan?				
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
					<td class="radio-label" style="width: 60px" >Not Useful</td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="reflection" id="reflection1" value="1" <?php if ($reflection_useful==1) echo 'checked'?> ></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="reflection" id="reflection2" value="2"<?php if ($reflection_useful==2) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="reflection" id="reflection3" value="3" <?php if ($reflection_useful==3) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="reflection" id="reflection4" value="4" <?php if ($reflection_useful==4) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="reflection" id="reflection5" value="5" <?php if ($reflection_useful==5) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="reflection" id="reflection6" value="6" <?php if ($reflection_useful==6) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="reflection" id="reflection7" value="7" <?php if ($reflection_useful==7) echo 'checked'?>></td>
					<td class="radio-label" style="width: 200px">Very Useful</td>		
					</tr>
					</table>
			</div>


<div class="sub_frame" id="div-ex-reflection" name="div-ex-reflection"><h4 class="nquestion_text"><strong> 10. Please briefly explain your rating given to question 9.</strong> </h4>
	 <textarea id="ex_reflection" name="ex_reflection" rows="4" cols="52" style="width:100%;"><?php echo htmlspecialchars($explain_reflectionuse, ENT_QUOTES); ?></textarea>	
</div>
