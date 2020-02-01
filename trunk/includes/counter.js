/*
Author: Robert Hashemian
http://www.hashemian.com/

You can use this code in any manner so long as the author's
name, Web address and this disclaimer is kept intact.
********************************************************
Usage Sample:

<script language="JavaScript">
TargetDate = "12/31/2020 5:00 AM";
BackColor = "palegreen";
ForeColor = "navy";
CountActive = true;
CountStepper = -1;
LeadingZero = true;
DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
FinishMessage = "It is finally here!";
</script>
<script language="JavaScript" src="http://scripts.hashemian.com/js/countdown.js"></script>
*/

function calcage(secs, num1, num2) {
  s = ((Math.floor(secs/num1))%num2).toString();
  if (LeadingZero && s.length < 2)
    s = "0" + s;
  return "<b>" + s + "</b>";
}
var oldsec = 0;
var seconds0 = 0;
var seconds1 = 0;
var minutes0 = 0;
var minutes1 = 0;
var hours0 = 0;
var hours1 = 0;
var days0 = 0;
var days1 = 0;

function CountBack(secs) {
  if (secs < 0) {
    document.getElementById("cntdwn").innerHTML = FinishMessage;
    return;
  }
  DisplayStr = DisplayFormat.replace(/%%D%%/g, calcage(secs,86400,100000));
  DisplayStr = DisplayStr.replace(/%%H%%/g, calcage(secs,3600,24));
  DisplayStr = DisplayStr.replace(/%%M%%/g, calcage(secs,60,60));
  DisplayStr = DisplayStr.replace(/%%S%%/g, calcage(secs,1,60));
  seconds0 = calcage(secs,1,60).substring(3,4);
  seconds1 = calcage(secs,1,60).substring(4,5);
  minutes0 = calcage(secs,60,60).substring(3,4);
  minutes1 = calcage(secs,60,60).substring(4,5);
  hours0 = calcage(secs,3600,24).substring(3,4);
  hours1 = calcage(secs,3600,24).substring(4,5);
  days0 = calcage(secs,86400,100000).substring(3,4);
  days1 = calcage(secs,86400,100000).substring(4,5);

  
  //document.getElementById("cntdwn").innerHTML = DisplayStr;
  if (CountActive) {
    setTimeout("CountBack(" + (secs+CountStepper) + ")", SetTimeOutPeriod);
   	document.getElementById('time_seconds').innerHTML = "<img src='images/counter/"+seconds0+".gif' /><img src='images/counter/"+seconds1+".gif' />";    	document.getElementById('time_minutes').innerHTML = "<img src='images/counter/"+minutes0+".gif' /><img src='images/counter/"+minutes1+".gif' />";        	document.getElementById('time_hours').innerHTML = "<img src='images/counter/"+hours0+".gif' /><img src='images/counter/"+hours1+".gif' />";        		document.getElementById('time_days').innerHTML = "<img src='images/counter/"+days0+".gif' /><img src='images/counter/"+days1+".gif' />";    
    
  }
}

function putspan(backcolor, forecolor) {
 document.write("<span id='cntdwn' style='background-color:" + backcolor + 
                "; color:" + forecolor + "'></span>");
}

if (typeof(BackColor)=="undefined")
  BackColor = "white";
if (typeof(ForeColor)=="undefined")
  ForeColor= "black";
if (typeof(TargetDate)=="undefined")
  TargetDate = "06/28/2009 7:00 AM UTC-0500";
if (typeof(DisplayFormat)=="undefined")
  DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
if (typeof(CountActive)=="undefined")
  CountActive = true;
if (typeof(FinishMessage)=="undefined")
  FinishMessage = "";
if (typeof(CountStepper)!="number")
  CountStepper = -1;
if (typeof(LeadingZero)=="undefined")
  LeadingZero = true;


CountStepper = Math.ceil(CountStepper);
if (CountStepper == 0)
  CountActive = false;
var SetTimeOutPeriod = (Math.abs(CountStepper)-1)*1000 + 990;
putspan(BackColor, ForeColor);
var dthen = new Date(TargetDate);
var dnow = new Date();
if(CountStepper>0)
  ddiff = new Date(dnow-dthen);
else
  ddiff = new Date(dthen-dnow);
gsecs = Math.floor(ddiff.valueOf()/1000);
CountBack(gsecs);
