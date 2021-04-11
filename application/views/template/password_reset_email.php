<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Demystifying Email Design</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/password_reset_email.css')?>" />

</head>
<body>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="tab-data-one">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr class="tab-row-one">
						<td class="tab-data-two" align="center"><img src="http://file.server.eduera.com.bd/logo/eduera-logo.png" height="50px">
						</td>
					</tr>
					<tr>
						<td class="tab-data-three" bgcolor="#ffffff">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr >
									<td class="tab-data-four">
										<b>Hi <?=$user_data->first_name?>,</b>
									</td>
								</tr>
								<tr>
									<td class="tab-data-five">
										You've recently asked to reset the password for this eduera account

									</td>


								</tr>
								<tr>
									Email: <?=$user_data->email?>
								</tr>
								<br>
								<tr>
									<td  style="font-size: 16px; font-weight:bold">
									 	Your password is: <?=$password?>
									</td>
								</tr>
								<tr>
									<td>
										<p>To login your account, click the button below:</p>
									</td>
								</tr>
								<tr>
									<td class="button" >
					                    <a style="background-color: #1a6596" class="link" href="https://www.eduera.com.bd/login" target="_blank">
					                          Login your account
					                    </a>
				                   </td>
								</tr>
								<tr>

									<tr>
										<td class="tab-data-six">
											 If this was a mistake, just ignore this email and nothing will happen.
										</td>
									</tr>
									<tr>

										<td class="tab-data-seven">
										 Best Regards, <br/>
										<a style="text-decoration:none; color: #153643;" href="#">Eduera</a> Team
									</td>

								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="tab-data-eight">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td class="tab-data-nine" width="75%">
										© <?=date('Y')?>  Eduera. All rights reserved.
										 &reg; Regards <br/>
										<a href="#" style="color: #ffffff;"><font color="#ffffff">Eduera</font></a> Team

										<br><a href="https://www.eduera.com.bd/" style="color: #ffffff;"><font color="#ffffff">eduera.com.bd</font></a>
									</td>

									<td align="right" width="25%">

									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>