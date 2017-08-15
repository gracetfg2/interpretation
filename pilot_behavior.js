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


function submitresult() {

   isOkay=true;

    if(isOkay==true){
      logAction("submit");

 
      $("#response-form [name=_f1]").val( $("#f1").val() );
      $("#response-form [name=_f2]").val( $("#f2").val() );
      $("#response-form [name=_f3]").val( $("#f3").val() );
      $("#response-form [name=_mid]").val( $("#turkerID").val() );

     $("#response-form [name=prepareTime]").val( annoStartTime - hitStartTime);
      $("#response-form [name=taskTime]").val( (new Date()).getTime() - annoStartTime );
      $("#response-form [name=numberOfPause]").val(pauseCount);
      $("#response-form [name=numberOfDel]").val(delCount);
      $("#response-form [name=startTime]").val( annoStartTime );
      $("#response-form [name=submitTime]").val((new Date()).getTime());
      eventLogs.push(['prepareTime', annoStartTime - hitStartTime]);
      eventLogs.push(['taskTime',  (new Date()).getTime() - annoStartTime]);
      eventLogs.push(['numberOfPause', pauseCount ]);
      eventLogs.push(['numberOfDel', pauseCount ]);    
      
     
     $("#response-form").submit();
      
    }
    else
    {
       $("#error_alert").show();
    }


}
