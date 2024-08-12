<?php

namespace Source\App\Api;

use Source\Core\TokenJWT;
use Source\Models\User;

session_start();
class Users extends Api
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listUsers()
    {
        $users = new User();
        $this->back($users->selectAll());
    }

    public function createUser(array $data)
    {
        if (in_array("", $data)) {
            $this->back([
                "type" => "error",
                "message" => "Preencha todos os campos"
            ]);
            return;
        }

        if ($data["password"] != $data["confirmPassword"]) {
            $this->back([
                "type" => "error",
                "message" => "A senhas não correspondem"
            ]);
            return;
        }


        $user = new User(
            null,
            $data["name"],
            $data["email"],
            $data["password"]
        );

        $insertUser = $user->insert();

        if (!$insertUser) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Usuário cadastrodo com sucesso!"
        ]);
    }

    public function loginUser(array $data)
    {
        $user = new User();

        if (!$user->login($data["email"], $data["password"])) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $token = new TokenJWT();
        $tokenCreate = $token->create([
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail()
        ]);
        $this->userAuth = $token->verify($tokenCreate);

        $_SESSION["user"] = [
            "id" => $user->getId(),
            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "teamId" => $user->getTeamId(),
            "token" => $tokenCreate,
        ];

        $this->back([
            "type" => "success",
            "message" => $user->getMessage(),
            "user" => $_SESSION["user"],
            "verify" => $this->userAuth
        ]);
    }

    public function updateUser(array $data)
    {
        $userSession = $_SESSION["user"];
        $token = new TokenJWT();
        if (!$token->verify($userSession["token"])) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        foreach ($data as $key => $value) {
            if ($value == null) {
                $data[$key] = $userSession[$key];
            }
        }

        $user = new User(
            $userSession["id"],
            $data["name"],
            $data["email"],
            null,
            $data["teamId"],
            $data["teamLeader"],
        );

        if (!$user->update()) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => $user->getMessage(),
            "user" => [
                "id" => $user->getId(),
                "name" => $user->getName(),
                "email" => $user->getEmail()
            ]
        ]);
    }

    public function setPassword(array $data)
    {
        $userSession = $_SESSION["user"];
        $token = new TokenJWT();
        if (!$token->verify($userSession["token"])) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        $user = new User(
            $userSession["id"]
        );

        if (!$user->updatePassword($data["password"], $data["newPassword"], $data["confirmNewPassword"])) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => $user->getMessage()
        ]);
    }
}
