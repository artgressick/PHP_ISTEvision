<?php
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	session_start();
	$verified = '';
	if(isset($_REQUEST['d']) && $_REQUEST['d'] != '') {
		$q = "SELECT * FROM lounge_presenters WHERE !verified AND verifycode='".$_REQUEST['d']."'";
		$result = mysql_fetch_assoc(@mysql_query ($q));
		if($result['id']!='') {
			if(@mysql_query ("UPDATE lounge_presenters SET verified=1 WHERE id='".$result['id']."'")) {
				$_SESSION['first_name'] = $result['first_name'];
				$_SESSION['last_name'] = $result['last_name'];
				$_SESSION['email_address'] = $result['email_address'];
				$_SESSION['id'] = $result['id'];
				$verified = 1;
			} else {
				$verified = "An Error occurred while verifying your account.";
			}
		} else {
			$verified = "Invalid Verify Code or Account is already Verified.";
		}
	}

	//include the header information
	include('includes/header.php');
	include('includes/top.php');
?>
	<tr>
		<td class="contents">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2">
						<div class="section_header" style="margin-bottom:10px;">Account Verification</div>
						<div style="margin:20px; font-weight:bold; text-align:center;">
		<?
					if($verified == '') {
		?>
							Verification URL is Invalid.
		<?			
					} else if($verified != 1) {
		?>
							<?=$verified?>
							<div><a href="index.php">Home</a></div>
		<?			
					} else if($verified == 1) {
		?>
							Your account is now verified and Active. To schedule an event click <a href="index.php">here</a>
		<?			
					}
		?>
		
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<?
	include('includes/bottom.php');
?>