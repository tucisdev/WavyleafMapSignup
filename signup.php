<?php
require __DIR__ . '/vendor/autoload.php';

if ( isset ( $_POST ['submit'] ) )
{
    $conf = parse_ini_file ( "conf.ini", true ); // mail config
                                                 
    // form info
    $name = filter_var ( trim ( $_POST ['name'] ), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH );
    $email = filter_var ( trim ( $_POST ['email'] ), FILTER_SANITIZE_EMAIL );
    $phone = filter_var ( trim ( $_POST ['phone'] ), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND );
    $contactPref = $_POST ['contactPref'];
    $message = filter_var ( trim ( $_POST ['message'] ), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_ENCODE_AMP );
    $area = $_POST ['area'];
    $mapName = $_POST ['mapName'];
    
    // send email
    $signup = new PHPMailer (); // send mail to sign up
                                
    // $signup->SMTPDebug = 3; // Enable verbose debug output
    
    $signup->isSMTP (); // Set mailer to use SMTP
    $signup->Host = $conf ['MAIL'] ['host'];
    $signup->SMTPAuth = true;
    $signup->Username = $conf ['MAIL'] ['username'];
    $signup->Password = $conf ['MAIL'] ['password'];
    $signup->SMTPSecure = $conf ['MAIL'] ['secure'];
    $signup->Port = $conf ['MAIL'] ['port'];
    $signup->From = $conf ['MAIL'] ['username'];
    $signup->FromName = $conf ['MAIL'] ['name'];
    
    $confirmation = clone $signup; // copy SMTP settings to mail to send to user who signed up
    
    $signup->addAddress ( $conf ['MAIL'] ['toEmail'], $conf ['MAIL'] ['name'] ); // send wavyleaf email
    $signup->addReplyTo ( $email, $name );
    
    $signup->isHTML ( false ); // Set email format to HTML
    
    $signup->Subject = '[WavyLeaf Map Signup] ' . $name . ': Area ' . $area;
    $signup->Body = $name . " has claimed area " . $area . ".\n\nEmail: " . $email . "\nPhone: " . $phone . "\nPreference: " . $contactPref . "\n\n" . $name . " included the following message:\n----------------------------------------\n" . $message;
    
    // send signup confirmation
    $confirmation->addAddress ( $email );
    $confirmation->addReplyTo ( $conf ['MAIL'] ['toEmail'], $conf ['MAIL'] ['name'] );
    
    $confirmation->isHTML ( true ); // Set email format to HTML
    
    $confirmation->Subject = '[WavyLeaf Map Signup] ' . $name . ': Area ' . $area;
    $confirmation->Body = "Thank you for signing up for Wavyleaf Area " . $area . "!<br><br>Area Map<br><img style=\"width:200px;height:200px;\" src=\"" . $conf ['websiteHome'] . "inc/images/maps/area" . $mapName . ".png\" alt=\"Wavyleaf Area " . $area . "\"><br><a href=\"" . $conf ['websiteHome'] . "inc/images/maps/area" . $mapName . ".png\">PNG</a> | <a href=\"" . $conf ['websiteHome'] . "inc/pdf/area" . $mapName . ".pdf\">PDF</a>";
    $confirmation->AltBody = "Thank you for signing up for Wavyleaf Area " . $area . "!\n\nYou can find maps of the area below:\n" . "PNG: " . $conf ['websiteHome'] . "inc/images/maps/area" . $mapName . ".png\nPDF: " . $conf ['websiteHome'] . "inc/pdf/area" . $mapName . ".pdf";
    
    // error sending mail
    if ( ! $signup->send () )
    {
        session_start ();
        
        $_SESSION ['error_title'] = 'Signup Message could not be sent.';
        $_SESSION ['error'] = $signup->ErrorInfo;
        
        header ( 'Location: error.php' );
    }
    elseif ( ! $confirmation->send () )
    {
        session_start ();
        
        $_SESSION ['error_title'] = 'Confirmation Message could not be sent.';
        $_SESSION ['error'] = $confirmation->ErrorInfo;
        
        header ( 'Location: error.php' );
    }
    
    // success!
    else
    {
        header ( 'Location: thankyou.html#area' . $area );
    }
}
?>
