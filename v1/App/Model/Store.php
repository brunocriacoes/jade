<?php

namespace App\Model;

use Core\Model;
use Core\UUIDGenerator;

class Store extends Model
{
    protected $table = 'store';

    public function list($page = 1, $itemsPerPage = 100)
    {
        return $this->paginate($this->table, $page, $itemsPerPage);
    }

    public function create($data)
    {
        $data["status"] = "ACTIVE";
        $data["publicId"] = UUIDGenerator::generateUUID();
        return $this->insert($this->table, $data);
    }

    public function getById($id)
    {
        return $this->select($this->table, 'id = :id', [':id' => $id]);
    }
    public function getByPublicId($publicId)
    {
        return $this->select($this->table, 'publicId = :publicId', [':publicId' => $publicId]);
    }

    public function getByExternalId($externalId)
    {
        return $this->select($this->table, 'externalId = :externalId', [':externalId' => $externalId]);
    }

    public function set($publicID, $data)
    {
        return $this->update($this->table, $data, 'publicID = :publicID', [':publicID' => $publicID]);
    }

    public function delete($publicID)
    {
        return $this->query("DELETE FROM {$this->table} WHERE publicID = :publicID", [':publicID' => $publicID]);
    }

    static function porter($payload)
    {
        return [
            "publicId" => $payload["publicId"],
            "externalId" => $payload["externalId"],
            "name" => $payload["name"],
            "email" => $payload["email"],
            "status" => $payload["status"],
            "blingClientId" => $payload["blingClientId"],
            "blingClientSecret" => $payload["blingClientSecret"],
            "asaasApiKey" => $payload["asaasApiKey"],

        ];
    }
}
