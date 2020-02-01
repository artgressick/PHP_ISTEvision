<?
	function sith() {
?>
		<script type='text/javascript'>
			function checkEnter(e) {
			var characterCode //literal character code will be stored in this variable
			
			if(e && e.which){ //if which property of event object is supported (NN4)
			e = e
			characterCode = e.which //character code is contained in NN4's which property
			}
			else{
			e = event
			characterCode = e.keyCode //character code is contained in IE's keyCode property
			}
			
			if(characterCode == 13){ //if generated character code is equal to ascii 13 (if enter key)
			document.forms[0].submit() //submit the form
			return false
			}
			else{
			return true
			}
			
			}
		</script>
<?
	}
	function sitm() {
		//You have a total height of 1014px in this section to play with
?>
	<table cellpadding="0" cellspacing="0" style="width:100%;">
		<tr>
			<td style='vertical-align:top; text-align:center; padding-top:50px; padding-bottom:100px;'><img src="images/big-logo.png" alt="ISTE Vision"/></td>
		</tr>
		<tr>
			<td style='background: url(images/loginbg.gif); height:80px;'>
				<table cellpadding="0" cellspacing="0" style="width:100%;">
					<tr>
						<td style="width:150px;"></td>
						<td style="width:570px; text-align:right; vertical-align:middle;"><img src="images/createaccount.jpg" alt="Create account" style="border:0; cursor:pointer;" onclick="location.href='createaccount.php';" /></td>
						<td style="width:72px;height:80px;"><img src="images/or.png" alt="OR" /></td>
						<td style="width:134px; vertical-align:middle; padding-left:25px;"><img src="images/login.jpg" alt="Login" style="border:0; "/></td>
						<td>
							<table cellpadding="0" cellspacing="0" style="width:100%;">
								<form id="login" name="login" method="post" action="checklogin.php" style='margin:0;padding:0;'>
								<tr>
									<td style="width:185px;">
										username:<br />
										<input type="text" id='email' name='email' style='font-size:9px; width:150px; height:10px;' />
									</td>
									<td style="width:85px;">
										password:<br />
										<input type="password" id='password' name='password' style='font-size:9px; width:75px; height:10px;' onKeyPress="return checkEnter(event)" />
									</td>
									<td style="padding-left:10px;">
<?									
//									<img src="images/loginbutton.png" alt="Log In" onclick="document.getElementById('login').submit();" style="cursor:pointer;" />
?>									
									</td>
								</tr>
								</form>
							</table>
						</td>
						<td style="width:150px;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div style="position:absolute; bottom:250px; left:0px;"><img src="images/top-left.png" alt="ISTE Vision"/></div>
	<div style="position:absolute; bottom:250px; right:0px;"><img src="images/top-right.png" alt="ISTE Vision"/></div>
	<script type='text/javascript'>document.getElementById('email').value = '';document.getElementById('password').value = '';</script>
<?
	}
	include('includes/wrapper.php');
?>