var hitStartTime;

var annoStartTime;
var annoEndTime;

var opsCount = 0;
var typingTimer;
var doneTypingInterval = 1000;
var pauseCount = 0;
var delCount = 0;

var annotationFlag = false;
var delFlag = false;

var prevStroke;
var eventLogs = [];

function logAction(action, param) {
  console.log(action);
  if (typeof param === "undefined") {
    eventLogs.push([(new Date()).getTime(), action]);
  }
  else {
    eventLogs.push([(new Date()).getTime(), action, param])
  }
}

$(document).ready(function() {
  // var task_params = document.getElementById("survey").href.substring(56).toString();
  // (new Image).src = 'http://128.174.241.28:8080/?' + task_params;

  hitStartTime = (new Date()).getTime();
  logAction("init");

  $(window).focus(function() {
    logAction("focus");
  });

  $(window).blur(function() {
    logAction("blur");
  });

	$('input[type=radio][name=expertiseRadios]').change(function(){
		  logAction("expert");
	})

	$('input[type=radio][name=ageRadios]').change(function(){
		  logAction("age");
	})

	$('input[type=radio][name=genderRadios]').change(function(){
		  logAction("gender");
	})

	$("#text").bind("keydown", function(){
    	$('#fbk-div').removeClass("has-error");
}	);


/* Count Page Visit
	$.ajax({
		type: "POST",
		url: "countvisit.php",
		data: { starttime:  $.trim( $("#feedback_form [name=_starttime]").val()) },
		success: function(data){

		}
	});
*/
 
});






function onTextKeyUp() {

  clearTimeout(typingTimer);
  typingTimer = setTimeout(recordPause, doneTypingInterval);
  logAction("text_update", document.getElementById("text").value);
}

function onTextKeyDown(e) {

  if (annotationFlag == false) {
   	annoStartTime = (new Date()).getTime();
    annotationFlag = true;
    logAction("start");
  }

  clearTimeout(typingTimer);
  var unicode = e.keyCode ? e.keyCode : e.charCode;
  if (unicode == 8 || unicode == 46) {
    if (!delFlag) {
      delCount += 1;
      delFlag = true;
    }
  }
  else if (delFlag) {
    delFlag = false;
  }
}

function recordPause() {
  pauseCount += 1;
}

function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
  results = regex.exec(location.search);
  return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function submit() {

		var errorMsg='';
	  	$("#error_alert").hide();
		$(".has-error").removeClass("has-error");
		 var isOkay = true;

		var multiline= $('#text').val().replace(/\r?\n/g, '<br />');
	 	$('#text').val( $.trim( multiline ));

		if ($('#text').val() == "") {
			 $("#error_alert").show();
			 $('#fbk-div').addClass("has-error");
			 errorMsg += 'Please provide feedback on the design. ';
			 isOkay = false;
		}

		

		if(isOkay==true){
			logAction("submit");
			$("#feedback_form [name=_fbk-text]").val( $("#text").val() );
			$("#feedback_form [name=_age]").val($('input[name="ageRadios"]:checked').val() );
			$("#feedback_form [name=_expertL]").val($('input[name="expertiseRadios"]:checked').val() );
			$("#feedback_form [name=_gender]").val($('input[name="genderRadios"]:checked').val() );

			$("#feedback_form [name=_behavior]").val(JSON.stringify(eventLogs));
 			$("#feedback_form [name=prepareTime]").val( annoStartTime - hitStartTime);
 			$("#feedback_form [name=taskTime]").val( (new Date()).getTime() - annoStartTime );
 			$("#feedback_form [name=numberOfPause]").val(pauseCount);
 			$("#feedback_form [name=numberOfDel]").val(delCount);
 			$("#feedback_form [name=startTime]").val( annoStartTime );
 			$("#feedback_form [name=submitTime]").val((new Date()).getTime());
			$("#feedback_form").submit();
			
		}
		else
		{
			alert(errorMsg);
		}


}
