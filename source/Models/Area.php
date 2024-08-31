<?php

namespace Source\Models;

use PDOException;
use Source\Core\Connect;
use Source\Core\Model;

class Area extends Model
{
    private $id;
    private $team_id;
    private $name;
    private $description;
    private $weathered;
    private $latitude;
    private $longitude;
    private $message;

    public function __construct(
        int $id = null,
        int $team_id = null,
        string $name = null,
        string $description = null,
        bool $weathered = false,
        float $latitude = null,
        float $longitude = null,
    ) {
        $this->id = $id;
        $this->team_id = $team_id;
        $this->name = $name;
        $this->description = $description;
        $this->weathered = $weathered;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->entity = "areas";
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamId(): ?int
    {
        return $this->team_id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getWeathered(): ?bool
    {
        return $this->weathered;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setTeamId(?int $team_id): void
    {
        $this->team_id = $team_id;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setWeathered(?bool $weathered): void
    {
        $this->weathered = $weathered;
    }

    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }


    public function insert(): ?int
    {
        $conn = Connect::getInstance();

        $query = "SELECT * FROM areas WHERE name = :name AND team_id = :team_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":team_id", $this->team_id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $this->message = "Area já cadastrada!";
            return false;
        }

        $query = "INSERT INTO areas (name, description, weathered, latitude, longitude, team_id) 
        VALUES (:name, :description, null, :latitude, :longitude, :team_id)";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);
        $stmt->bindParam(":team_id", $this->team_id);

        try {
            $stmt->execute();
            $this->setId($conn->lastInsertId());
            return $conn->lastInsertId();
        } catch (PDOException) {
            $this->message = "Por favor, informe todos os campos!";
            return false;
        }
    }
    public function update(): bool
    {
        $conn = Connect::getInstance();

        $query = "SELECT * FROM areas WHERE name = :name AND team_id = :team_id AND id != :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":team_id", $this->team_id);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $this->message = "Area já cadastrada!";
            return false;
        }

        $query = "UPDATE areas SET 
        name = :name, 
        description = :description, 
        weathered = :weathered, 
        latitude = :latitude, 
        longitude = :longitude, 
        team_id = :team_id 
        WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":weathered", $this->weathered);
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);
        $stmt->bindParam(":team_id", $this->team_id);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Area atualizada com sucesso!";
            return true;
        } catch (PDOException $exception) {
            $this->message = "Erro ao atualizar: {$exception->getMessage()}";
            return false;
        }
    }

    public function delete(): ?bool
    {
        $conn = Connect::getInstance();
        $query = "delete from areas where id = {$this->id}";
        $stmt = $conn->prepare($query);
        try {
            $stmt->execute();
            $this->message = "Area deletada com sucesso";
            return true;
        } catch (PDOException $exception) {
            $this->message = "Erro ao deletar: {$exception->getMessage()}";
            return false;
        }
    }
}
