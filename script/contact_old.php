<?php
/*
Template Name: Auto Care - Car Services Template

Variable
	$recaptchaSecret : Recaptcha Secret Key
 
	$dzName : Contact Person Name
	$dzEmail : Contact Person Email
	$dzMessage : Contact Person Message
	$dzRes : response holder
	$dzOtherField : Form other additional fields
	
	
	$dzMailSubject : Mail Subject.
	$dzMailMessage : Mail Body
	$dzMailHeader : Mail Header
	$dzEmailReceiver : Contact receiver email address
	$dzEmailFrom : Mail Form title
	$dzEmailHeader : Mail headers
*/
/* require ReCaptcha class */
require('recaptcha-master/src/autoload.php');

/* ReCaptch Secret */
$recaptchaSecret = '6Lf-CnImAAAAABobEL4DoeRGGylIBlMa6PAG97zd';

$dzEmailTo 		= "degloirejeroen@gmail.com";   /* Receiver Email Address */
$dzEmailFrom    = "degloirejeroen@gmail.com";

function pr($value)
{
	echo "<pre>";
	print_r($value);
	echo "</pre>";
}

try {
    if (!empty($_POST)) {

		#### Contact Form Script ####
		if($_POST['dzToDo'] == 'Contact')
		{
			$dzName = trim(strip_tags($_POST['dzName']));
			$dzEmail = trim(strip_tags($_POST['dzEmail']));
			$dzMessage = strip_tags($_POST['dzMessage']);	
			$dzRes = "";
			if (!filter_var($dzEmail, FILTER_VALIDATE_EMAIL)) 
			{
				$dzRes['status'] = 0;
				$dzRes['msg'] = 'Verkeerd e-mailformaar.';
			}
			$dzMailSubject = 'Carrosserie Vandenbussche | Contact Formulier';
			$dzMailMessage	= 	"
								Naam: $dzName<br/>
								Email: $dzEmail<br/>
								Bericht: $dzMessage<br/>
								";
								
			$dzOtherField = "";
			if(!empty($_POST['dzOther']))
			{
				$dzOther = $_POST['dzOther'];
				$message = "";
				foreach($dzOther as $key => $value)
				{
					$fieldName = ucfirst(str_replace('_',' ',$key));
					$fieldValue = ucfirst(str_replace('_',' ',$value));
					$dzOtherField .= $fieldName." : ".$fieldValue."<br>";
				}
			}
			$dzMailMessage .= $dzOtherField; 
								
			$dzEmailHeader  	= "MIME-Version: 1.0\r\n";
			$dzEmailHeader 		.= "Content-type: text/html; charset=iso-8859-1\r\n";
			$dzEmailHeader 		.= "From:$dzEmailFrom <$dzEmail>";
			$dzEmailHeader 		.= "Reply-To: $dzEmail\r\n"."X-Mailer: PHP/".phpversion();
			if(mail($dzEmailTo, $dzMailSubject, $dzMailMessage, $dzEmailHeader))
			{
				$dzRes['status'] = 1;
				$dzRes['msg'] = 'We hebben je bericht successvol ontvangen.';
			}
			else
			{
				$dzRes['status'] = 0;
				$dzRes['msg'] = 'Er is een probleem opgetreden. Gelieve later opnieuw te proberen.';
			}
			echo json_encode($dzRes);
			exit;
		}
		#### Contact Form Script End ####
		
		#### Appointment Form Script ####
		if($_POST['dzToDo'] == 'Appointment')
		{
			$dzName = trim(strip_tags($_POST['dzName']));
			$dzEmail = trim(strip_tags($_POST['dzEmail']));
			$dzMessage = strip_tags($_POST['dzMessage']);	
			$dzRes = "";
			if(!filter_var($dzEmail, FILTER_VALIDATE_EMAIL)) 
			{
				$dzRes['status'] = 0;
				$dzRes['msg'] = 'Verkeerd e-mailformaat.';
				echo json_encode($dzRes);
				exit;
			}



      $dzMailSubject = 'Carrosserie Vandenbussche | Afspraak Formulier';
			$dzMailMessage	= 	"
								Naam: $dzName<br/>
								Email: $dzEmail<br/>
								Bericht: $dzMessage<br/>
								";
			$dzOtherField = "";
			if(!empty($_POST['dzOther']))
			{
				$dzOther = $_POST['dzOther'];
				$message = "";
				foreach($dzOther as $key => $value)
				{
					$fieldName = ucfirst(str_replace('_',' ',$key));
					$fieldValue = ucfirst(str_replace('_',' ',$value));
					$dzOtherField .= $fieldName." : ".$fieldValue."<br>";
				}
			}
			$dzMailMessage .= $dzOtherField; 
			
			$dzEmailHeader  	= "MIME-Version: 1.0\r\n";
			$dzEmailHeader 		.= "Content-type: text/html; charset=iso-8859-1\r\n";
			$dzEmailHeader 		.= "From:$dzEmailFrom <$dzEmail>";
			$dzEmailHeader 		.= "Reply-To: $dzEmail\r\n"."X-Mailer: PHP/".phpversion();
			if(mail($dzEmailTo, $dzMailSubject, $dzMailMessage, $dzEmailHeader))
			{
				$dzRes['status'] = 1;
        $dzRes['msg'] = 'We hebben je bericht successvol ontvangen.';
			}
			else
			{
				$dzRes['status'] = 0;
        $dzRes['msg'] = 'Er is een probleem opgetreden. Gelieve later opnieuw te proberen.';
			}
			echo json_encode($dzRes);
			exit;
		}	
		#### Appointment Form Script End ####
		
	}
} catch (\Exception $e) {
    $dzRes['status'] = 0;
	$dzRes['msg'] = $e->getMessage().'Er is een probleem opgetreden. Gelieve later opnieuw te proberen.';
	echo json_encode($dzRes);
	exit;
}

?>