<?php

namespace Source\App\Api;

use Source\Core\TokenJWT;
use Source\Models\Team;
use Source\Models\User;

session_start();
class Teams extends Api
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listTeams()
    {
        $team = new Team();
        $this->back($team->selectAll());
    }

    public function createTeam(array $data)
    {
        $user = new User();
        $userSession = $user->selectById($_SESSION["user"]["id"]);
        $token = new TokenJWT();
        if (!$token->verify($_SESSION["user"]["token"]) || !isset($_SESSION["user"]["token"])) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        if (in_array("", $data)) {
            $this->back([
                "type" => "error",
                "message" => "Preencha todos os campos"
            ]);
            return;
        }

        $team = new Team(
            null,
            $data["name"],
        );

        $insertTeam = $team->insert();

        if (!$insertTeam) {
            $this->back([
                "type" => "error",
                "message" => $team->getMessage()
            ]);
            return;
        }

        $user = new User(
            $userSession["id"],
            $userSession["name"],
            $userSession["email"],
            null,
            $team->getId(),
            true
        );

        if (!$user->update()) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
        }

        $teamSelect = $team->selectById($user->getTeamId());

        $team->setNumberMembers($teamSelect["number_members"] + 1);

        if (!$team->update()) {
            $this->back([
                "type" => "error",
                "message" => $team->getMessage(),
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Equipe " . $teamSelect["name"] . " cadastrada com sucesso!"
        ]);
    }

    public function joinTeam(array $data)
    {
        $user = new User();
        $userSession = $user->selectById($_SESSION["user"]["id"]);
        $token = new TokenJWT();
        if (!$token->verify($_SESSION["user"]["token"]) || !isset($_SESSION["user"]["token"])) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }
        
        if($userSession["team_id"] == null) {
            $this->back([
                "type" => "error",
                "message" => "Você já pertence a um equipe"
            ]);
            return;
        }

        if (in_array("", $data)) {
            $this->back([
                "type" => "error",
                "message" => "Preencha todos os campos"
            ]);
            return;
        }

        $user = new User(
            $userSession["id"],
            $userSession["name"],
            $userSession["email"],
            null,
            $data["id"],
            false
        );

        if(!$user->update()) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $team = new Team();
        $teamSelect = $team->selectById($data["id"]);
        $team = new Team(
            $teamSelect["id"],
            $teamSelect["name"],
            $teamSelect["number_members"] + 1,
        );
        
        if(!$team->update()) {
            $this->back([
                "type" => "error",
                "message" => $team->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "error",
            "message" => "Parabens " . $userSession["name"] . " você se juntou a equipe " . $teamSelect["name"] . " com sucesso"
        ]);
    }

    public function updateTeam(array $data)
    {
        $user = new User();
        $userSession = $user->selectById($_SESSION["user"]["id"]);
        $token = new TokenJWT();
        if (!$token->verify($_SESSION["user"]["token"]) || !isset($_SESSION["user"]["token"])) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        if (in_array("", $data)) {
            $this->back([
                "type" => "error",
                "message" => "Preencha todos os campos"
            ]);
            return;
        }

        $team = new Team(
            $userSession["team_id"],
            $data["name"],
        );

        if (!$team->update()) {
            $this->back([
                "type" => "error",
                "message" => $team->getMessage(),
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => $team->getMessage(),
        ]);
    }

    public function deleteTeam()
    {
        $user = new User();
        $userSession = $user->selectById($_SESSION["user"]["id"]);
        $token = new TokenJWT();
        if (
            (!$token->verify($_SESSION["user"]["token"]) ||
                !isset($_SESSION["user"]["token"])) &&
            $userSession["team_leader"] == 1
        ) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        $usersByTeamId = $user->selectBy("team_id", $userSession["team_id"]);

        foreach ($usersByTeamId as $i => $e) {
            $member = new User(
                $e["id"],
                $e["name"],
                $e["email"],
                null,
                null,
                false,
            );

            if (!$member->update()) {
                $this->back([
                    "type" => "error",
                    "message" => $member->getMessage()
                ]);
                return;
            }
        }

        $team = new Team(
            $userSession["team_id"]
        );

        if (!$team->delete()) {
            $this->back([
                "type" => "error",
                "message" => $team->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Equipe deletada com sucesso"
        ]);
    }

    public function exitTeam() {
        $user = new User();
        $userSession = $user->selectById($_SESSION["user"]["id"]);
        $token = new TokenJWT();
        if (
            (!$token->verify($_SESSION["user"]["token"]) ||
                !isset($_SESSION["user"]["token"])) &&
            $userSession["team_leader"] == 1
        ) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        $user = new User(
            $userSession["id"],
            $userSession["name"],
            $userSession["email"],
            null,
            null,
            false
        );

        if(!$user->update()) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $team = new Team();
        $teamSelect = $team->selectById($userSession["team_id"]);
        $team = new Team(
            $teamSelect["id"],
            $teamSelect["name"],
            $teamSelect["number_members"] - 1,
        ); 

        if(!$team->update()) {
            $this->back([
                "type" => "error",
                "message" => $team->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "error",
            "message" => "Você saiu da equipe"
        ]);
    }
}
