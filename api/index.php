<?php

ob_start();

require  __DIR__ . "/../vendor/autoload.php";

use CoffeeCode\Router\Router;

$route = new Router(url(),":");

$route->namespace("Source\App\Api");

/* USERS */
$route->group("/users");

// get
$route->get("/", "Users:listUsers");

//post
$route->post("/","Users:createUser");
$route->post("/login","Users:loginUser");
$route->post("/loginOut","Users:loginOut");

//put
$route->put("/update","Users:updateUser");
$route->put("/set-password","Users:setPassword");

//delete
$route->delete("/delete","Users:deleteUser");

$route->group("null");

/* TEAMS */
$route->group("/teams");

//get
$route->get("/","Teams:listTeams");

//post
$route->post("/","Teams:createTeam");
$route->post("/join","Teams:joinTeam");
$route->post("/exit","Teams:exitTeam");

//put
$route->put("/update","Teams:updateTeam");

//delete
$route->delete("/delete","Teams:deleteTeam");

$route->group("null");
/* FAQS */
$route->group("/faqs");

//get
$route->get("/","Faqs:listFaqs");

$route->group("null");

$route->dispatch();

/** ERROR REDIRECT */
if ($route->error()) {
    header('Content-Type: application/json; charset=UTF-8');
    http_response_code(404);

    echo json_encode([
        "errors" => [
            "type " => "endpoint_not_found",
            "message" => "Não foi possível processar a requisição"
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

ob_end_flush();
