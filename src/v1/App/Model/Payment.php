<?php

namespace App\Models;

use Core\Model;

class Payment extends Model
{
    protected $table = 'payment';

    public function list($page = 1, $itemsPerPage = 100)  {        
        return $this->paginate($this->table, $page, $itemsPerPage);
    }

    public function create($data)
    {
        return $this->insert($this->table, $data);
    }

    public function getById($id)
    {
        return $this->select($this->table, 'id = :id', [':id' => $id]);
    }

    public function set($id, $data)
    {
        return $this->update($this->table, $data, 'id = :id', [':id' => $id]);
    }

    public function delete($id)
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = :id", [':id' => $id]);
    }
}
