const INVALID_VALUE = -1.0;
const PAUSE_TIME_PERIOD = 10000;

var openPageTimestamp = INVALID_VALUE;
var firstCharTimestamp = INVALID_VALUE;

var textboxInfo = [];

class TextboxData {
    constructor(pCount, pTime, lastP, lastIn, delCount, wCount, senCount, isP) {
        this.firstInputTimestamp = 0;
        this.pauseCount = pCount;
        this.pauseTime = pTime;
        this.lastPauseTimestamp = lastP
        this.lastInputTimestamp = lastIn
        this.deleteCount = delCount;
        this.wordCount = wCount;
        this.sentenceCount = senCount;
        this.isPauseActive = isP;
    }
}

var pauseTimeouts = [];

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
    openPageTimestamp = getCurTime();
    console.log("Open Page: " + openPageTimestamp);
    logAction("Opened");

    $(window).focus(function() {
        logAction("focus");
    });

    $(window).blur(function() {
        logAction("blur");
    });
    
    /*$("#monitoredtext").keydown(function(e) {
        onInitTextKeyDown(e);
    });*/
    $('[id=monitoredtext]').each(function() {
        $(this).keydown(function(e) {
            onInitTextKeyDown(e);
        });
    });

    //$("#text").bind("keydown", function(){
    //    $('#fbk-div').removeClass("has-error");
    //});
});

function getCurTime() {
    return (new Date()).getTime();
}

(function ($, undefined) {
    $.fn.getCursorPosition = function() {
        var el = $(this).get(0);
        var pos = 0;
        if('selectionStart' in el) {
            pos = el.selectionStart;
        } else if('selection' in document) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }
        return pos;
    }
})(jQuery);

function onTextKeyUp(e) {
    var textfield = $( document.activeElement );
    var monitorID = extractMonitorID(textfield);
    
    pauseDelegateUp(monitorID);
}

function pauseDelegateUp(monitorID) {
    clearTimeout(pauseTimeouts[monitorID]);
    pauseTimeouts[monitorID] = setTimeout(function(){
            recordPause(monitorID)
        }, PAUSE_TIME_PERIOD);
}

function onInitTextKeyDown(e) {
    firstCharTimestamp = getCurTime();
    logAction("start");
        // Now don't call this function ever again!
    $('[id=monitoredtext]').each(function() {
        $(this).unbind();
        $(this).keydown(function(e) {
            onTextKeyDown(e);
        });
        $(this).keyup(function(e) {
            onTextKeyUp(e);
        });
    });
    /*$("#monitoredtext").unbind();
    $("#monitoredtext").keydown(function(e) {
        onTextKeyDown(e);
    });
    $("#monitoredtext").keyup(function(e) {
        onTextKeyUp(e);
    });*/
    onTextKeyDown(e);
}

    // Manage potential resizes to the textbox info array and timeout array
function arrayManager(curTextboxID) {
    var curLen = textboxInfo.length;
    
    var slotsToMake = (curTextboxID - curLen) + 1;
    for(var i = 0; i < slotsToMake; i++) {
        textboxInfo.push(new TextboxData(0, 0.0, 0.0, 0.0, 0, 0, 0, false));
        pauseTimeouts.push();
    }
}

function extractMonitorID(textfield) {
    return parseInt(textfield.attr("monitorid"));
}

function onTextKeyDown(e) {
    console.log(getCurTime());
    var textfield = $( document.activeElement );
    var monitorID = extractMonitorID(textfield);
    arrayManager(monitorID);
    
    clearTimeout(pauseTimeouts[monitorID]);
    
    var textboxData = textboxInfo[monitorID];
    
    if(textboxData.firstInputTimestamp == 0) {
        textboxData.firstInputTimestamp = getCurTime();
    }
    
    textboxData.lastInputTimestamp = getCurTime();
    
    var unicode = e.keyCode ? e.keyCode : e.charCode;
    
    if (unicode == 8) {
        deleteDelegate(textfield, textboxData);
    }
    pauseDelegateDown(monitorID);
}

function deleteDelegate(textfield, data) {    // TODO: touch up
    var textVal = $(textfield).val();
    var cursorOffset = textfield.getCursorPosition();
    if(textVal != "" && cursorOffset != 0) {
        data.deleteCount += 1;
        logAction("Delete");
    }
}

function pauseDelegateDown(monitorID) {
    if(textboxInfo[monitorID].isPauseActive) {
        var curTime = getCurTime();
        var addedTime = curTime - textboxInfo[monitorID].lastPauseTimestamp;
        textboxInfo[monitorID].pauseTime += addedTime + PAUSE_TIME_PERIOD;
        textboxInfo[monitorID].isPauseActive = false;
    }
}

function recordPause(monitorID) {
    textboxInfo[monitorID].lastPauseTimestamp = getCurTime();
    textboxInfo[monitorID].pauseCount += 1;
    textboxInfo[monitorID].isPauseActive = true;
    logAction("Pause "+monitorID);
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function hasMonitorIDBeenInitd(monitorID) {
    return monitorID < textboxInfo.length;
}

function countWords(text) {
    var words = text.split(/\n| /);
    var blankWordCount = 0;
    for(var i = 0; i < words.length; i++) {
        if(words[i] == "")
            blankWordCount++;
    }
    return words.length - blankWordCount;
}

function countSentences(text) {
    var sents = text.split('.');
    var blankSentCount = 0;
    for(var i = 0; i < sents.length; i++) {
        if(sents[i] == "" || /^ +$/.test(sents[i]))
            blankSentCount++;
    }
    return sents.length - blankSentCount;
}

function prepParseStats() {
    $('[id=monitoredtext]').each(function() {   // For each monitored text field...
        var text = $(this).val();
        var monitorID = extractMonitorID($(this));
        if(hasMonitorIDBeenInitd(monitorID)) {
            textboxInfo[monitorID].wordCount = countWords(text);
            textboxInfo[monitorID].sentenceCount = countSentences(text);
        }
    });
}

function outputJSON() {
    prepParseStats();
    var globalStr = JSON.stringify({openPageTimestamp:openPageTimestamp, firstCharTimestamp:firstCharTimestamp});
    var textboxStr = JSON.stringify(textboxInfo);
    console.log(globalStr)
    console.log(textboxStr);
    return [globalStr, textboxStr];
}

/*function submit() {
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
}*/
