<?php

//server.php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;

    require dirname(__DIR__) . '/vendor/autoload.php';

//    $server = IoServer::factory(
//        new HttpServer(
//            new WsServer(
//                new Chat()
//            )
//        ),
//       
//    );
//    $server->run();

 $loop   = \React\EventLoop\Factory::create(); 
    $webSock = new \React\Socket\SecureServer(
       new \React\Socket\Server ('0.0.0.0:8444', $loop),
        $loop,
        array(
            'local_cert'        => '/home/ubuntu/certificates/SSL/__onlinecampuslife_com.crt', // path to your cert
            'local_pk'          => '/home/ubuntu/certificates/Onlinecampuslife_PRIVATEKEY.key', // path to your server private key
            'allow_self_signed' => TRUE, // Allow self signed certs (should be false in production)
            'verify_peer' => FALSE
        )
    );
    // Ratchet magic
    $webServer = new IoServer(
        new HttpServer(
            new WsServer(
                new Chat()
            )
        ),
        $webSock
    );
    $loop->run();

?>
