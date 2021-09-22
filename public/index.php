<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;


require __DIR__ . '/../vendor/autoload.php';
require '../src/config/db.php';

$app = new Slim\App();

$app->get(
    '/',
    function (Request $request, ResponseInterface $response) {
        $renderer = new PhpRenderer('./template');
        return $renderer->render($response, "dashboard.php");
    }
);

$app->get(
    '/data',
    function (Request $request, ResponseInterface $response) {
        $sqlquerydownhost  = "SELECT icinga_hosts.host_id, icinga_hosts.display_name , icinga_hoststatus.current_state FROM icinga_hosts INNER JOIN icinga_hoststatus on icinga_hosts.host_object_id = icinga_hoststatus.host_object_id WHERE icinga_hoststatus.current_state =1 ;";
        $sqlqueryuphost = "SELECT icinga_hosts.host_id, icinga_hosts.display_name , icinga_hoststatus.current_state FROM icinga_hosts INNER JOIN icinga_hoststatus on icinga_hosts.host_object_id = icinga_hoststatus.host_object_id WHERE icinga_hoststatus.current_state =0;";
       // $sqlhost = "SELECT host_id FROM icinga_hosts; ";
        $sqlhost = "SELECT icinga_hosts.host_id, icinga_hosts.display_name , icinga_hoststatus.current_state FROM icinga_hosts INNER JOIN icinga_hoststatus on icinga_hosts.host_object_id = icinga_hoststatus.host_object_id; ";


        $response = $response->withHeader('Content-type', 'application/json');

        try {
            $db = new db();
            $db = $db->connect();

            //datadown
            $stmt = $db->query($sqlquerydownhost);
            $datadown = $stmt->fetchAll(PDO::FETCH_OBJ);
            $downcount = $stmt->rowCount();


            //dataup
            $stmt1 = $db->query($sqlqueryuphost);
            $dataup = $stmt1->fetchAll(PDO::FETCH_OBJ);
            $upcount = $stmt1->rowCount();

            //host count
            $stmt3 = $db->prepare($sqlhost);
            $stmt3->execute();
            $totalhost = $stmt3->rowCount();

	    //all host list
            $stmt4 = $db->query($sqlhost);
            $totallist = $stmt4->fetchAll((PDO::FETCH_OBJ));

            // $serializer = JMS\Serializer\SerializerBuilder::create()->build();
            // $jsonContent = $serializer->serialize($data, 'json');
            // echo $stmt3;
        } catch (PDOException $e) {
            return $response->withJson($e->getMessage(), 200);
        }

        $data = [
            "datadown" => $datadown,
            "dataup" => $dataup,
            "downcount" => $downcount,
            "upcount" => $upcount,
            "totalhost" => $totalhost,
	    "hostlist" => $totallist
        ];



        return $response->withJson($data, 200);
    }
);




$app->get(
    '/phone',
    function (Request $request, ResponseInterface $response) {
        $sqlqueryphone  = "select * from fxo where last_changed=1 and patton in(1,2) order by fxo_line;";
      
        try {
            $db = new db();
            $db = $db->connect2();

            //datadown
            $stmt = $db->query($sqlqueryphone);
            $phone = $stmt->fetchAll(PDO::FETCH_OBJ);
            $phonecount = $stmt->rowCount();


          

            // $serializer = JMS\Serializer\SerializerBuilder::create()->build();
            // $jsonContent = $serializer->serialize($data, 'json');
            // echo $stmt3;
        } catch (PDOException $e) {
            return $response->withJson($e->getMessage(), 200);
        }

        $data = [
            "phone" => $phone,
            "phonecount" => $phonecount,         
        ];



        return $response->withJson($data, 200);
    }
);





$app->run();
