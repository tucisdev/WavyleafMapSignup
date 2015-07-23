<?php
if (isset($_POST['submit']))
{
    $to = "someemail";
    
    // form info
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $contactPref = $_POST['contactPref'];
    $message = $_POST['message'];
    $area = $_POST['area'];
    
    // create message
    $subject = "[WavyLeaf Map Signup] " . $name . ": Area " . $area;
    
    $emailMessage = $name . " has claimed area " . $area . ".\n\nEmail: " . $email . "\nPhone: " . $phone . "\nPreference: " . $contactPref . "\n\n" . $name . " included the following message:\n----------------------------------------\n" . $message;
    $emailMessage2 = "You have claimed area " . $area . ".\n\nEmail: " . $email . "\nPhone: " . $phone . "\nPreference: " . $contactPref . "\n\nYou included the following message:\n----------------------------------------\n" . $message;
    
    $headers = "From: " . $email . "\r\nReply-to: " . $email;
    $headers2 = "From:" . $to;
    
    // send mail
    mail($to,$subject,$emailMessage,$headers);
    mail($email,$subject,$emailMessage2,$headers2);
    echo "Mail Sent. Thank you for participating!";
}
?>