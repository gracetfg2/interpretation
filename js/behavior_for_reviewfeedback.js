

var hitStartTime;
var annotationFlag = false;
var annoStartTime;
var eventLogs = [];

function logAction(action, param) {
  console.log(action);
  if (typeof param === "undefined") {
    eventLogs.push([(new Date()).getTime(), action]);
  }
  else {
    //eventLogs.push([(new Date()).getTime(), action, param]);
    eventLogs.push([ param, action]);
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

	$('input[type=radio]').change(function(){
		  if (annotationFlag == false) {
		   	annoStartTime = (new Date() ).getTime();
		    annotationFlag = true;
		    logAction("start");
		  }
		  logAction($(this).attr('name'));
	})
 
});
 function view(imgsrc) {
      viewwin = window.open(imgsrc.src,'viewwin', 'width=800,height=400px'); 
 }

function getval(_name, number)
{
	//var current_id=_name.substring(1);
	//$('#action_'+current_id).val(number);
	//alert($('#action_'+current_id).val());

}

function rate(_name, number){
	$('#div-'+_name).removeClass("has-error");

}


 function submit(){
 	
 	 $(':radio').each(function () {
        name = $(this).attr('name');
       
         $('#div-'+name).removeClass("has-error");
           
      
    });

 	var isOkay = true;
    $(':radio').each(function () {
        name = $(this).attr('name');
        if (  !$(':radio[name="' + name + '"]:checked').length) {
            $('#div-'+name).addClass("has-error");
           
            isOkay = false;
        }
    });


 	if(isOkay == true)  {
 		logAction("submit");

 		$("#rating-form [name=prepareTime]").val( annoStartTime - hitStartTime);
 		$("#rating-form [name=taskTime]").val( (new Date()).getTime() - annoStartTime );		
 		logAction("prepareTime",annoStartTime - hitStartTime);
 		logAction("taskTime",(new Date()).getTime() - annoStartTime );
    
 		$("#rating-form [name=_behavior]").val(JSON.stringify(eventLogs));
 		
 		$("#rating-form").submit();
 		//alert("Okay");
 	}
 	else{
 		alert("You have some feedback not been rated. (colored in red). Please rate them."); 	
 	}

 	
 }

