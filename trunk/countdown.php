<html>
	<head>
		<title>Countdown</title>
	</head>
	<body>
		<div>
		<script language="JavaScript">
			TargetDate = "04/22/2009 4:17 PM UTC-0400";
			BackColor = "white";
			ForeColor = "black";
			CountActive = true;
			CountStepper = -1;
			LeadingZero = true;
			DisplayFormat = "%%D%% Days, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
			FinishMessage = "NECC is Live!";
		</script>
		<script language="JavaScript" src="includes/counter.js"></script>
		</div>
		<table cellpadding="5" cellspacing="0">
			<tr>
				<td id='time_days'></td>
				<td>Days</td>
				<td id='time_hours'></td>
				<td>Hours</td>
				<td id='time_minutes'></td>
				<td>Minutes</td>
				<td id='time_seconds'></td>
				<td>Seconds</td>
			</tr>
		</table>
		<script language="Javascript">
		  	document.getElementById('time_seconds').innerHTML = "<img src='images/counter/"+seconds0+".gif' /><img src='images/counter/"+seconds1+".gif' />";
		  	document.getElementById('time_minutes').innerHTML = "<img src='images/counter/"+minutes0+".gif' /><img src='images/counter/"+minutes1+".gif' />";
		  	document.getElementById('time_hours').innerHTML = "<img src='images/counter/"+hours0+".gif' /><img src='images/counter/"+hours1+".gif' />";
		  	document.getElementById('time_days').innerHTML = "<img src='images/counter/"+days0+".gif' /><img src='images/counter/"+days1+".gif' />";    
		</script>
	</body>
</html>