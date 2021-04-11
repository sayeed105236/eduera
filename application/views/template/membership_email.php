<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Membership Badge Number</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/membership_email.css')?>" />

<style type="text/css">
	

	.m_-4357218434095269252cls_002{
		position: absolute;bottom: 49%;left: 46%;
	}
	.cls_002{
		position: absolute;bottom: 49%;left: 46%;
	}
	span.cls_002{font-family:Arial,serif;font-size:14.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
	td.cls_002{font-family:Arial,serif;font-size:14.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none;}

</style>
<script type="text/javascript" src="67834d74-ffb7-11ea-8b25-0cc47a792c0a_id_67834d74-ffb7-11ea-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>

</head>
<body>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="tab-data-one">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="650">
					<tr class="tab-row-one">
						<td align="center" class="tab-data-two"><img src="http://file.server.eduera.com.bd/logo/eduera-logo.png" height="50px">
						</td>
					</tr>
					<tr>
						<td class="tab-data-three" bgcolor="#ffffff">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr >
									<td class="tab-data-four">
										<b>Hi <?= $data['name']?>,</b>
									</td>
								</tr>
								<tr>
									<td class="tab-data-five">
										Welcome to eduera. Thanks for enrolled our membership offer. We are very much excited to have you with us. Eduera is offering you a life time journey towards professional learning in our mother tongue for enlighten your career. Stay connected with eduera and tell us if there is anything we can do for you.

									</td>


								</tr>
								<tr >
									<td class="cls_002"  style="text-align: center; color: #153643;" >
										Your Membership ID : <?=$data['badge_id']?>
									</td>
								</tr>
								<tr>
									<td class="tab-data-six">
											<img src="https://file.server.eduera.com.bd/membership/membership.jpg" style="margin-left:50px" width=500 height=250>
									</td>
								</tr>

								<br>
								
								<tr>
									<td>
										If you have any query, please call +880 01766343434 or send mail to info@eduera.com.bd
									</td>
								</tr>

								<tr>
									<tr>
										<td class="tab-data-seven">
										 Best Regards, <br/>
										<a style="text-decoration:none; color: #153643;" href="https://www.eduera.com.bd/">Eduera</a> Team
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