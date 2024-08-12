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

    public function listTeams ()
    {
        $team = new Team();
        $this->back($team->selectAll());
    }

    public function createTeam (array $data)
    {
        $userSession = $_SESSION["user"];
        $token = new TokenJWT();
        if(!$token->verify($userSession["token"])){
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }
        
        if(in_array("", $data)) {
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

        if(!$insertTeam){
            $this->back([
                "type" => "error",
                "message" => $team->getMessage()
            ]);
            return;
        }

        $sessionUser = $_SESSION["user"];

        $user = new User(
            $sessionUser["id"],
            $sessionUser["name"],
            $sessionUser["email"],
            null,
            $team->getId(),
            true
        );
        
        if(!$user->update()) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
        }
        
        $_SESSION["user"]["teamId"] = $user->getTeamId();

        $teamSelect = $team->selectById($user->getTeamId());

        $team->setNumberMembers($teamSelect["number_members"] + 1);
        
        if(!$team->update()) {
            $this->back([
                "type" => "error",
                "message" => $team->getMessage(),
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Equipe cadastrada com sucesso!"
        ]);
    }

    public function joinTeam(array $data) {
        $userSession = $_SESSION["user"];
        $token = new TokenJWT();
        if(!$token->verify($userSession["token"])){
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        if(in_array("", $data)) {
            $this->back([
                "type" => "error",
                "message" => "Preencha todos os campos"
            ]);
            return;
        }

        $team = new Team(
            $data["id"]
        );

        $user = new User(
            $userSession["id"],
            $userSession["name"],
            $userSession["email"],
            null,
            $data["id"],
            false
        );

        

        $userSelect = $user->selectById($user->getId());
        if($userSelect["team_id"] == $data["id"]) {
            $this->back([
                "type" => "error",
                "message" => "Você já pertence à essa equipe"
            ]);
            return;
        }

        if(!$user->update()){
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        
        $teamSelectOld = $team->selectById($userSession["teamId"]);
        
        if($teamSelectOld["id"] != null) {
            $teamOld = new Team(
                $teamSelectOld["id"]
            );
            $teamOld->setNumberMembers($teamSelectOld["number_members"] - 1);
        }
        
        if(!$teamOld->update()){
            $this->back([
                "type" => "error",
                "message" => $teamOld->getMessage()
            ]);
            return;
        }
        
        $teamSelectNew = $team->selectById($data["id"]);
        $team->setNumberMembers($teamSelectNew["number_members"] + 1);
        
        if(!$team->update()){
            $this->back([
                "type" => "error",
                "message" => $team->getMessage()
            ]);
            return;
        }
        
        $_SESSION["user"] = $userSession;

        $this->back([
            "type" => "success",
            "message" => "Você se juntou à equipe com sucesso"
        ]);


    }

    public function updateTeam(array $data)
    {
        $userSession = $_SESSION["user"];
        $token = new TokenJWT();
        if(!$token->verify($userSession["token"])){
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        if(in_array("", $data)) {
            $this->back([
                "type" => "error",
                "message" => "Preencha todos os campos"
            ]);
            return;
        }

        $team = new Team(
            $userSession["teamId"],
            $data["name"],
        );
        
        if(!$team->update()) {
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
}