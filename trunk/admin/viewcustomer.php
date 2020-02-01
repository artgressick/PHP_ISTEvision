<?php
	include('includes/security.php');
	
	//Register the user in the database
	require_once ('istetube-conf.php'); //Map the Connection.
	
	//This is for the User Profile. We need to get the information and display it on the page below.
	$sql_query = "select *
	FROM customers
	WHERE customers.aid = '". $_REQUEST['aid'] . "'";
	
	$result = @mysql_query ($sql_query); //Run the query.
	$customer = mysql_fetch_array ($result, MYSQL_ASSOC);
	
	//video statuses
	$sql_query = "select id, status
	FROM customer_statuses
	ORDER BY id";
	
	$result2 = @mysql_query ($sql_query); //Run the query.
	
	//include the header information
	include('includes/head.php');
	include('includes/top.php');
?>
  		<tr>
			<td width="100%" colspan="2" valign="top">
				<form id="form1" name="approval" method="post" action="updatecustomer.php">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top" width="25%" align="left" style="background: #eee; padding: 5px; ">
							<div class="view_admin_fields">
								First Name
							</div>
							<div class="view_admin_fields">
								Last Name
							</div>
							<div class="view_admin_fields">
								Title
							</div>
							<div class="view_admin_fields">
								Affiliation
							</div>
							<div class="view_admin_fields">
								Email
							</div>
							<div class="view_admin_fields">
								Alt Email
							</div>
							<div class="view_admin_fields">
								Student Status
							</div>
							<div class="view_admin_fields">
								Ning URL
							</div>
							
						</td>
						<td valign="top" width="25%" align="left" style="padding: 5px;">
							<div class="view_admin_info">
								<?= $customer['first_name'] ?>
							</div>
							<div class="view_admin_info">
								<?= $customer['last_name'] ?>
							</div>
							<div class="view_admin_info">
								<?= $customer['title'] ?>
							</div>
							<div class="view_admin_info">
								<?= $customer['affiliation'] ?>
							</div>
							<div class="view_admin_info">
								<a href="mailto:<?= $customer['email'] ?>"><?= $customer['email'] ?></a>
							</div>
							<div class="view_admin_info">
								<a href="mailto:<?= $customer['alt_email'] ?>"><?= $customer['alt_email'] ?></a>
							</div>
							<div class="view_admin_info">
								<?= ($customer['student_status'] == '1' ? 'Yes' : 'No') ?>
							</div>
							<div class="view_admin_info">
								<?= $customer['ning_url'] ?>
							</div>
						</td>
						<td valign="top" width="25%" align="left" style="background: #eee; padding: 5px; ">
							<div class="view_admin_fields">
								Address
							</div>
							<div class="view_admin_fields">
								City
							</div>
							<div class="view_admin_fields">
								State
							</div>
							<div class="view_admin_fields">
								Zip
							</div>
							<div class="view_admin_fields">
								Country
							</div>
							<div class="view_admin_fields">
								Work Phone
							</div>
							<div class="view_admin_fields">
								Home Phone
							</div>
							<div class="view_admin_fields">
								Cell Phone
							</div>
							<div class="view_admin_fields">
								Fax
							</div>
						</td>
						<td valign="top" width="25%" align="left" style="padding: 5px;">
							<div class="view_admin_info">
								<?= $customer['address'] ?>
							</div>
							<div class="view_admin_info">
								<?= $customer['city'] ?>
							</div>
							<div class="view_admin_info">
								<?= $customer['state'] ?>
							</div>
							<div class="view_admin_info">
								<?= $customer['zip'] ?>
							</div>
							<div class="view_admin_info">
								<?= $customer['country'] ?>
							</div>
							<div class="view_admin_info">
								<?= $customer['work_phone'] ?>
							</div>
							<div class="view_admin_info">
								<?= $customer['home_phone'] ?>
							</div>
							<div class="view_admin_info">
								<?= $customer['cell_phone'] ?>
							</div>
						</td>
						
					</tr>
					<tr>
						<td colspan="4" align="left">		
							<div class="form_div" style="padding: 5px; background: #ccc;">
								<strong>Customer Status</strong>: <select name="customer_status_id" size="1" id="customer_status_id">
<?
	while ($statuses = mysql_fetch_array ($result2, MYSQL_ASSOC)) {
?>
                	  				<option value="<?= $statuses['id'] ?>" <?=($statuses['id']==$customer['customer_status_id']?'selected':'') ?>><?= $statuses['status'] ?></option>
<?
	}
?>
            					</select> <input type="submit" name="update" id="update" value="Update Status"><input type="hidden" name="aid" value="<?= $_REQUEST['aid'] ?>">
            				</div>
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
<?
	include('includes/footer.php');
?>