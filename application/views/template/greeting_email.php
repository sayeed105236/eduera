<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/greeting_email.css')?>" />

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Demystifying Email Design</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/greeting_email.css')?>" />


</head>
<body>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="tab-data-one">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="650" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr class="tab-row">
						<td class="tab-data-two" align="center"><img src="http://file.server.eduera.com.bd/logo/eduera-logo.png" height="50px">

						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr >
									<td class="tab-data-three">
										<b>Hi <?=$user_data['first_name']?>,</b>
									</td>
								</tr>
								<tr>
									<td class="tab-data-four">
										Welcome to eduera. Thanks for signing up to eduera.com.bd. We are very much excited to have you with us. Eduera is offering you a life time journey towards professional learning in our mother tongue for enlighten your career. Stay connected with eduera and tell us if there is anything we can do for you.
									</td>

								</tr>
								<tr>
									<td class="tab-data-five">
										We are providing professional courses recognized internationally and also providing a course completion certificate. Here are our top courses:

									</td>

								</tr>

								<tr>
									<td class="tab-data-six">
										<!-- 1. <a href="https://www.eduera.com.bd/course/itil-4-foundation-training">ITIL 4 Foundation Training</a> - 1999Tk <br/><br/>

										2. <a href="https://www.eduera.com.bd/course/prince2-practitioner-certification-training"> PRINCE2 Practitioner Certification Training</a> - 9999Tk <br/><br/>

										3. <a href="https://www.eduera.com.bd/course/prince2-foundation-training"> PRINCE2 Foundation Training</a> - 1999Tk <br/><br/>

										4. <a href="https://www.eduera.com.bd/course/agile-scrum-master-training-amp-certification"> Agile Scrum Master Training & Certification</a> - 9999Tk <br/><br/>

										5. <a href="https://www.eduera.com.bd/course/certified-information-systems-auditor-cisa"> Certified Information Systems Auditor (CISA)</a> - 1999Tk <br/><br/>

										6. <a href="https://www.eduera.com.bd/course/ccc-big-data-foundation-training"> CCC Big Data Foundation training</a> - 999Tk <br/><br/>

										7. <a href="https://www.eduera.com.bd/course/amazon-web-services-aws-certified-solutions-architect-associate"> Amazon Web Services (AWS) Certified Solutions Architect Associate</a> - 1999Tk <br/><br/>

										8. <a href="https://www.eduera.com.bd/course/amazon-web-services-aws-certified-solutions-architect-associate"> COBIT 5 Foundation</a> - 1999Tk<br/><br/>

										9. <a href="https://www.eduera.com.bd/course/exin-agile-scrum-foundation"> EXIN Agile Scrum Foundation</a> - 1999TK <br/><br/>

										10. <a href="https://www.eduera.com.bd/course/project-management-professional-pmp"> Project Management Professional (PMP)</a> - 1999Tk -->

										<?php
										if(isset($courses)){
										foreach($courses as $key=>$course){?>

											<?=$key+1?>. <a href="https://www.eduera.com.bd/course/<?=$course->slug?>"><?= $course->title?></a> - <?= $course->price?>Tk <?php if($course->discount_flag == 1 && $course->discounted_price > 0){ echo '(Discounted Price : '.$course->discounted_price .')'; } ?> 

											 <br/><br/>

										<?php	}
										}
										?>


									</td>

								</tr>
								<tr>
									<td class="button">
										<a class="button" style="background-color: #1a6596" class="link" href="https://www.eduera.com.bd" target="_blank">
					                          See more
					                    </a>
									</td>
								</tr>
								<br>
								<!-- <tr>
									<td  style="font-size: 16px; font-weight:bold">
									 	Your password is: <?=$password?>
									</td>
								</tr> -->
								<tr>
									<td>
										If you have any query, please call +880 01766343434 or send mail to info@eduera.com.bd
									</td>
								</tr>

								<tr>

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
										息 <?=date('Y')?>  Eduera. All rights reserved.
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