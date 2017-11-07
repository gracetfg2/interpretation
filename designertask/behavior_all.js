const INVALID_VALUE = -1.0;
const PAUSE_TIME_PERIOD = 10000;

var openPageTimestamp = INVALID_VALUE;
var firstCharTimestamp = INVALID_VALUE;

var textboxInfo = {};



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


class TextboxData {
    constructor(pCount, pTime, lastP, lastIn, delCount, wCount, senCount, isP, cont) {
        this.firstInputTimestamp = 0;
        this.pauseCount = pCount;
        this.pauseTime = pTime;
        this.lastPauseTimestamp = lastP;
        this.lastInputTimestamp = lastIn;
        this.deleteCount = delCount;
        this.wordCount = wCount;
        this.sentenceCount = senCount;
        this.isPauseActive = isP;
        this.content = cont;
        this.visibleTime = 0.0;
        this.becameVisibleTimestamp = 0;
        this.isVisible = false;
        this.firstInputAfterRevealTimestamp = 0;
        this.isInputAfterRevealStale = true;
        this.writingTime = 0;
    }
}


var pauseTimeouts = {};




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
    openPageTimestamp = getCurTime();
    //console.log("Open Page: " + openPageTimestamp);
    
  hitStartTime = (new Date()).getTime();
  logAction("init");

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
    var monitorLabel = extractMonitorLabel(textfield);
    
    pauseDelegateUp(monitorLabel);
}

function pauseDelegateUp(monitorLabel) {
    clearTimeout(pauseTimeouts[monitorLabel]);
    pauseTimeouts[monitorLabel] = setTimeout(function(){
            recordPause(monitorLabel)
        }, PAUSE_TIME_PERIOD);
}

function onInitTextKeyDown(e) {
    firstCharTimestamp = getCurTime();

    if (annotationFlag == false) {
        annoStartTime = (new Date()).getTime();
        annotationFlag = true;
        logAction("start");
    }

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
    
    onTextKeyDown(e);
}


function arrayManager(curTextboxLabel) {
    if(!hasMonitorLabelBeenInitd(curTextboxLabel)) {
        textboxInfo[curTextboxLabel] = new TextboxData(0, 0.0, 0.0, 0.0, 0, 0, 0, false, null);
        pauseTimeouts[curTextboxLabel] = INVALID_VALUE;  // This will get overridden when we set timeouts
    }
}


function extractMonitorLabel(textfield) {
    return textfield.attr("monitorlabel");
}

function onTextKeyDown(e) {
    //console.log(getCurTime());
    var textfield = $( document.activeElement );
    //var monitorID = extractMonitorID(textfield);
    var monitorLabel = extractMonitorLabel(textfield);
    arrayManager(monitorLabel);
    
    clearTimeout(pauseTimeouts[monitorLabel]);
    
    var textboxData = textboxInfo[monitorLabel];
    
    if(textboxData.firstInputTimestamp == 0) {
        textboxData.firstInputTimestamp = getCurTime();
    }
    if(textboxData.isInputAfterRevealStale == true) {
        textboxData.isInputAfterRevealStale = false;
        textboxData.firstInputAfterRevealTimestamp = getCurTime();
    }
    
    textboxData.lastInputTimestamp = getCurTime();
    
    var unicode = e.keyCode ? e.keyCode : e.charCode;
    
    if (unicode == 8) {
        deleteDelegate(textfield, textboxData);
    }
    pauseDelegateDown(monitorLabel);
}

function deleteDelegate(textfield, data) {    // TODO: touch up
    var textVal = $(textfield).val();
    var cursorOffset = textfield.getCursorPosition();
    if(textVal != "" && cursorOffset != 0) {
        data.deleteCount += 1;
        logAction("Delete");
    }
}

function pauseDelegateDown(monitorLabel) {
    if(textboxInfo[monitorLabel].isPauseActive) {
        var curTime = getCurTime();
        var addedTime = curTime - textboxInfo[monitorLabel].lastPauseTimestamp;
        textboxInfo[monitorLabel].pauseTime += addedTime + PAUSE_TIME_PERIOD;
        textboxInfo[monitorLabel].isPauseActive = false;
    }
}

function recordPause(monitorLabel) {
    textboxInfo[monitorLabel].lastPauseTimestamp = getCurTime();
    textboxInfo[monitorLabel].pauseCount += 1;
    textboxInfo[monitorLabel].isPauseActive = true;
    logAction("Pause " + monitorLabel);
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function hasMonitorLabelBeenInitd(monitorLabel) {
    return monitorLabel in textboxInfo;
}

function notifyVisible(textLabel) {
    arrayManager(textLabel);
    var textbox = textboxInfo[textLabel];
    if(textbox.isVisible == true) {
        console.log("ERROR: visible textbox was notified of visibility: ".concat(textLabel));
        return;
    }
    textbox.isVisible = true;
    textbox.isInputAfterRevealStale = true;
    textbox.becameVisibleTimestamp = getCurTime();
}

function notifyHidden(textLabel) {
    var textbox = textboxInfo[textLabel];
    if(textbox.isVisible == false) {
        console.log("ERROR: hidden textbox was notified of being hidden: ".concat(textLabel));
        return;
    }
    textbox.visibleTime += getCurTime() - textbox.becameVisibleTimestamp;
    textbox.writingTime += getCurTime() - textbox.firstInputAfterRevealTimestamp;
    textbox.isVisible = false;
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
        var monitorLabel = extractMonitorLabel($(this));
        if(hasMonitorLabelBeenInitd(monitorLabel)) {
            textboxInfo[monitorLabel].wordCount = countWords(text);
            textboxInfo[monitorLabel].sentenceCount = countSentences(text);
            textboxInfo[monitorLabel].content = text;
            if(textboxInfo[monitorLabel].isVisible == true) {
                notifyHidden(monitorLabel);
            }
        }
    });
}

//Get Rating Value
var ratingInfo = {};


class RatingData {
    constructor(rating) {
        this.rating = rating;      
    }
}

function getRatings() {

    $('input[type=radio]').each(function() {
        name = $(this).attr('name');
        ratingInfo[name] = new RatingData(0);
        ratingInfo[name].rating = $("input[name='"+name +"']:checked").val();      
    });

}

function outputJSON() {
    prepParseStats();
    getRatings();


    var globalStr = JSON.stringify({openPageTimestamp:openPageTimestamp, firstCharTimestamp:firstCharTimestamp, closePageTimestamp:getCurTime()});
    var textboxStr = JSON.stringify(textboxInfo);
    var ratingStr = JSON.stringify(ratingInfo);

   // alert(ratingStr);
    //console.log(globalStr)
    //console.log(textboxStr);
    return [globalStr, textboxStr, ratingStr];
}

