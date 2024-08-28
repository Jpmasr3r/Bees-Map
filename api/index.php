<?php

ob_start();

require  __DIR__ . "/../vendor/autoload.php";

use CoffeeCode\Router\Router;

$route = new Router(url(),":");

$route->namespace("Source\App\Api");

/* USERS */
$route->group("/users");
$route->get("/", "Users:listUsers");
$route->get("/logged","Users:logged");
$route->get("/getInfs","Users:getInfs");
$route->post("/","Users:createUser");
$route->post("/login","Users:loginUser");
$route->put("/update","Users:updateUser");
$route->put("/updatePassword","Users:setPassword");
$route->delete("/delete","Users:deleteUser");
$route->group("null");

/* TEAMS */
$route->group("/teams");
$route->get("/","Teams:listTeams");
$route->get("/getInfs","Teams:getInfs");
$route->get("/getTeams/{name}","Teams:getTeams");
$route->post("/","Teams:createTeam");
$route->post("/join","Teams:joinTeam");
$route->post("/exit","Teams:exitTeam");
$route->put("/update","Teams:updateTeam");
$route->delete("/delete","Teams:deleteTeam");
$route->group("null");

/* FAQS */
$route->group("/faqs");
$route->get("/","Faqs:listFaqs");
$route->post("/","Faqs:insert");
$route->put("/update","Faqs:update");
$route->delete("/delete","Faqs:delete");

/* PRODUTIONS */
$route->group("/produtions");
$route->get("/","Produtions:listByTeam");
$route->post("/","Produtions:insert");
$route->put("/update","Produtions:update");
$route->delete("/delete","Produtions:delete");

/* BOXES */
$route->group("/boxes");
$route->get("/{area_id}","Boxes:listByArea");
$route->post("/","Boxes:insert");
$route->put("/update","Boxes:update");
$route->delete("/delete","Boxes:delete");

/* AREAS */
$route->group("/areas");
$route->get("/","Areas:listByTeam");
$route->post("/","Areas:insert");
$route->put("/update","Areas:update");
$route->delete("/delete","Areas:delete");

/* SALES */
$route->group("/sales");
$route->get("/","Sales:listByTeam");
$route->post("/","Sales:insert");
$route->put("/update","Sales:update");
$route->delete("/delete","Sales:delete");

/* VEHICLES */
$route->group("/vehicles");
$route->get("/","Vehicles:listByTeam");
$route->post("/","Vehicles:insert");
$route->put("/update","Vehicles:update");
$route->delete("/delete","Vehicles:delete");

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
