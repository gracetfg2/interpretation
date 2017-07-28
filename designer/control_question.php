<div class="sub_frame" id="div-process" name="div-process">			
		<h4 class="nquestion_text"><strong> 7. How useful was having two days off before being asked to revise your initial design?
				
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
					<td class="radio-cell"><input type="radio" class="radio-inline" name="control_useful" id="control_useful1" value="1" <?php if ($control_useful==1) echo 'checked'?> ></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="control_useful" id="control_useful2" value="2"<?php if ($control_useful==2) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="control_useful" id="control_useful3" value="3" <?php if ($control_useful==3) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="control_useful" id="control_useful4" value="4" <?php if ($control_useful==4) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="control_useful" id="control_useful5" value="5" <?php if ($control_useful==5) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="control_useful" id="control_useful6" value="6" <?php if ($control_useful==6) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="control_useful" id="control_useful7" value="7" <?php if ($control_useful==7) echo 'checked'?>></td>
					<td class="radio-label" style="width: 200px">Very Useful</td>		
					</tr>
					</table>
</div>


<div class="sub_frame" id="div-ex-process" name="div-ex-process"><h4 class="nquestion_text"><strong> 8. Please briefly explain your rating given to question 7. </strong> </h4>
	 <textarea id="explain_process" name="explain_process" rows="4" cols="52" style="width:100%;"><?php echo htmlspecialchars($explain_process, ENT_QUOTES); ?></textarea>	
</div>