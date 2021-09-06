<?php 
include '../../../wp-load.php';

if(isset($_POST['send'])) {

	//only proceed if the honey trap is empty
	if($_POST['eyes'] == "" && $_POST['captcha'] == '') {
		

			$defaultmail = get_bloginfo('admin_email');

			$subject = 'Website enquiry from Find My Wedding';


			$htmlmessage = "<table border=0 cellspacing=10 cellpadding=10 align=center width=700>
			<tr><td  colspan=2><strong>". $subject . "</strong></td></tr>";

			foreach($_POST as $key => $value) {

				if($key == 'send' || $key == 'eyes' || $key == 'type' || $key == 'captcha') {
				} else {
					$htmlmessage .= "<tr><td width=80>" . $key . "</td><td><strong>" . $value . "</strong></td>";
				}

			}

			$htmlmessage .= "</table>";

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Find My Wedding <'.$defaultmail.'>' . "\n";
			$headers .= "Return-path: <" . $defaultmail . ">\r\n";

			if(mail($defaultmail, $_POST['subject'], $htmlmessage, $headers, '-f' . $defaultmail .'')) {

				echo json_encode('success');

			} else {
				echo json_encode('Failed');
			}

	} else {

		echo json_encode('Failed');
			
	}


}
