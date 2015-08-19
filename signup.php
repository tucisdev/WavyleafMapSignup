
<?php
require __DIR__ . '/vendor/autoload.php';

if ( isset ( $_POST ['submit'] ) )
{
    $conf = parse_ini_file ( "conf.ini", true ); // mail config
                                                 
    // form info
    $name = $_POST ['name'];
    $email = $_POST ['email'];
    $phone = $_POST ['phone'];
    $contactPref = $_POST ['contactPref'];
    $message = $_POST ['message'];
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
    
    // TODO Does this work?
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
    
    if ( ! ($signup->send () && $confirmation->send ()) )
    {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $signup->ErrorInfo;
    }
    else
    {
        echo "Mail Sent. Thank you for participating!";
    }
}
?>