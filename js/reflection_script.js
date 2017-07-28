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
    eventLogs.push([(new Date()).getTime(), action, param]);
    //eventLogs.push([ param, action]);
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
 

$('textarea').bind('cut copy paste', function (e) {
    e.preventDefault(); //disable cut,copy,paste
});

//$('#word-designconcept').html(counting(document.getElementById('designconcept').value));
//$('#word-good').html(counting(document.getElementById('good').value));
//$('#word-bad').html(counting(document.getElementById('bad').value));
      
  $("#designconcept").bind("keydown", function(){
      $('#div-designconcept').removeClass("has-error");
} );

   $("#good").bind("keydown", function(){
      $('#div-good').removeClass("has-error");
} );

    $("#bad").bind("keydown", function(){
      $('#div-bad').removeClass("has-error");
} );


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

function counting(textvalue){
  // var value = $('#text').val();
  var value = textvalue;
    var regex = /\s+/gi;
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;
    var totalChars = value.length;
    var charCount = value.trim().length;
    var charCountNoSpace = value.replace(regex, '').length;
    return wordCount; 
}

function onTextKeyUp(name) {

  clearTimeout(typingTimer);
  typingTimer = setTimeout(recordPause, doneTypingInterval);
  $('#word-'+name).html(counting(document.getElementById(name).value));
  logAction(name, document.getElementById(name).value);
}

function onTextKeyDown(name,e) {

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
 
    $("#error_alert").hide();
    $(".has-error").removeClass("has-error");
    isOkay = true;
    console.log(counting("1 2 3"));

  
    $('#designconcept').val($.trim($('#designconcept').val() ) ); 
    if( $('#designconcept').val() == "" ){
       $('#designconcept').parents('.sub_frame:first').addClass("has-error");
        isOkay = false;

    }
    else
    {
      if( counting( $('#designconcept').val() )<20){
          $('#designconcept').parents('.sub_frame:first').addClass("has-error");
          $('#for-concept').show();
          isOkay = false;
      }
    
    }


    $('#good').val($.trim($('#good').val() ) ); 
    if( $('#good').val() == "" ){
       $('#good').parents('.sub_frame:first').addClass("has-error");
        isOkay = false;
    }
    else
    {
      if( counting( $('#good').val() )<20){
          $('#good').parents('.sub_frame:first').addClass("has-error");
           $('#for-good').show();
         isOkay = false;
      }
    
    }

    $('#bad').val($.trim($('#bad').val() ) ); 
    if( $('#bad').val() == "" ){
       $('#bad').parents('.sub_frame:first').addClass("has-error");
        isOkay = false;
    }
   else
    {
      if( counting( $('#bad').val() )<20){
          $('#bad').parents('.sub_frame:first').addClass("has-error");
            $('#for-bad').show();
          isOkay = false;
      }
    
    }

 
  
   
/*
    var multiline= $('#designconcept').val().replace(/\r?\n/g, '<br />');
    $('#designconcept').val( $.trim( multiline ));
    var multiline2= $('#good').val().replace(/\r?\n/g, '<br />');
    $('#good').val( $.trim( multiline2 ));
    var multiline3= $('#bad').val().replace(/\r?\n/g, '<br />');
    $('#bad').val( $.trim( multiline3 ));
*/
   

    if(isOkay==true){
      logAction("submit");
      $("#reflection-form [name=_designconcept]").val( $("#designconcept").val() );
      $("#reflection-form [name=_good]").val( $("#good").val() );
      $("#reflection-form [name=_bad]").val( $("#bad").val() );


     $("#reflection-form [name=prepareTime]").val( annoStartTime - hitStartTime);
      $("#reflection-form [name=taskTime]").val( (new Date()).getTime() - annoStartTime );
      $("#reflection-form [name=numberOfPause]").val(pauseCount);
      $("#reflection-form [name=numberOfDel]").val(delCount);
      $("#reflection-form [name=startTime]").val( annoStartTime );
      $("#reflection-form [name=submitTime]").val((new Date()).getTime());
      eventLogs.push(['prepareTime', annoStartTime - hitStartTime]);
      eventLogs.push(['taskTime',  (new Date()).getTime() - annoStartTime]);
      eventLogs.push(['numberOfPause', pauseCount ]);
      eventLogs.push(['numberOfDel', pauseCount ]);    
      $("#reflection-form [name=_behavior]").val(JSON.stringify(eventLogs));
      
     
     $("#reflection-form").submit();
      
    }
    else
    {
       $("#error_alert").show();
    }


}
