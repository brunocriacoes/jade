<?php

namespace App\Model;

use Core\Model;
use Core\Crip;
use Core\UUIDGenerator;

class User extends Model
{
    protected $table = 'users';

    public function list($page = 1, $itemsPerPage = 100)  {        
        return $this->paginate($this->table, $page, $itemsPerPage);
    }

    static function porter($payload){
        return [
            "public_id"=>$payload["public_id"],
            "name"=>$payload["name"],
            "gravata"=>User::get_gravatar_url($payload["email"]),
            "email"=>$payload["email"],
            "phone"=>$payload["phone"],
            "status"=>$payload["status"]
        ];
    }

    static function get_gravatar_url($email, $size = 80, $default = 'identicon', $rating = 'g') {
        $email = strtolower(trim($email));
        $hash = md5($email);
        $url = "https://www.gravatar.com/avatar/$hash?s=$size&d=$default&r=$rating";
        return $url;
    }
    

    public function create($data)
    {
        $data["pass"] = Crip::pass($data["pass"]);
        $data["public_id"] = UUIDGenerator::generateUUID();
        $data["status"] = "ACTIVE";
        return $this->insert($this->table, $data);
    }

    public function getById($id)
    {
        return $this->select($this->table, 'id = :id', [':id' => $id]);
    }

    public function emailExist($email)
    {
        return count($this->select($this->table, 'email = :email', [':email' => $email])) > 0;
    }

    public function set($id, $data)
    {
        return $this->update($this->table, $data, 'id = :id', [':id' => $id]);
    }

    public function delete($id)
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = :id", [':id' => $id]);
    }

    public function isLogin($email, $pass)
    {
        return count($this->select($this->table, 'email = :email AND pass = :pass', [':email' => $email, ':pass' => Crip::pass($pass) ])) > 0;
    }
}
