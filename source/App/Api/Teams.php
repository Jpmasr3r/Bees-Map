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
        if (!$this->userAuth) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }
    }

    public function createTeam(array $data): void
    {
        if (in_array("", $data) || in_array(null, $data)) {
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

        if (!$team->insert()) {
            $this->back([
                "type" => "error",
                "message" => $team->getMessage()
            ]);
            return;
        }

        $user = new User();
        $userSession = $user->selectById($this->userAuth->id);

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

        $team->setNumberMembers(1);

        if (!$team->update()) {
            $this->back([
                "type" => "error",
                "message" => $team->getMessage(),
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Equipe " . $data["name"] . " cadastrada com sucesso!"
        ]);
    }

    public function joinTeam(array $data): void
    {
        $user = new User();
        $userSession = $user->selectById($this->userAuth->id);
        if ($userSession["team_id"] != null) {
            $this->back([
                "type" => "error",
                "message" => "Você já pertence a um equipe"
            ]);
            return;
        }


        if (in_array("", $data) || in_array(null, $data)) {
            $this->back([
                "type" => "error",
                "message" => "Preencha todos os campos"
            ]);
            return;
        }

        $team = new Team();
        $teamSelect = $team->selectBy("name", $data["name"]);

        $user = new User(
            $this->userAuth->id,
            $userSession["name"],
            $userSession["email"],
            null,
            $teamSelect["id"],
            false
        );

        if (!$user->update()) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $team = new Team(
            $teamSelect["id"],
            $teamSelect["name"],
            $teamSelect["number_members"] + 1,
        );

        if (!$team->update()) {
            $this->back([
                "type" => "error",
                "message" => $team->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Parabéns você se juntou a equipe com sucesso"
        ]);
    }

    public function updateTeam(array $data): void
    {
        if (in_array("", $data)) {
            $this->back([
                "type" => "error",
                "message" => "Preencha todos os campos"
            ]);
            return;
        }

        $user = new User();
        $userSession = $user->selectById($this->userAuth["id"]);

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

    public function deleteTeam(): void
    {
        $user = new User();
        $userSession = $user->selectById($this->userAuth["id"]);
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

    public function exitTeam(): void
    {
        $user = new User();
        $userSession = $user->selectById($this->userAuth->id);
        $user = new User(
            $userSession["id"],
            $userSession["name"],
            $userSession["email"],
            null,
            null,
            false
        );

        if (!$user->update()) {
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

        if (!$team->update()) {
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

    public function getInfs(): void
    {
        $user = new User();
        $userSession = $user->selectById($this->userAuth->id);

        if ($userSession["team_id"] == null) {
            $this->back([
                "type" => "error",
                "message" => "Você não pertence a nenhuma equipe"
            ]);
            return;
        }

        $team = new Team();
        $teamSelect = $team->selectById($userSession["team_id"]);
        $userByTeamId = $user->selectBy("team_id", $teamSelect["id"], "name");

        $this->back([
            "type" => "success",
            "data" => [
                "name" => $teamSelect["name"],
                "members" => $userByTeamId
            ],
        ]);
    }

    public function getTeams(array $data): void
    {
        $team = new Team();
        $teamsSelect = $team->selectBy("name", "%" . $data["name"] . "%", "name", "like");

        $this->back([
            "type" => "success",
            "data" => $teamsSelect
        ]);
    }
}
