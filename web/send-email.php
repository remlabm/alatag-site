<?php

require_once '../vendor/autoload.php';

$config = parse_ini_file("../config.ini");

try{

    // Create the Transport
    $transport = Swift_SmtpTransport::newInstance( $config['smtp.hostname'], $config['smtp.port'], $config['smtp.encrypt'])
        ->setUsername( $config['smtp.user'] )
        ->setPassword( $config['smtp.pass'] )
    ;

    // Create the Mailer using your created Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a message
    $message = Swift_Message::newInstance( $_POST['subject'] )
        ->setFrom( array( $_POST['email'] => $_POST['name'] ))
        ->setTo( $config['email.sendTo'] )
        ->setBody( $_POST['message'] );

    // Send the message
    $result = $mailer->send($message);
    $return = ['status' => 'ok' ];

}catch( Exception $e ){
    $return = ['status' => 'err', 'message' => $e->getMessage() ];
}

header("Content-Type: application/json");
echo json_encode( $return );