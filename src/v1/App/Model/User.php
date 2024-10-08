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
            "publicId"=>$payload["publicId"],
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
        $data["publicId"] = UUIDGenerator::generateUUID();
        $data["status"] = "ACTIVE";
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

    public function emailExist($email)
    {
        return count($this->select($this->table, 'email = :email', [':email' => $email])) > 0;
    }

    public function getByEmail($email)
    {
        return $this->select($this->table, 'email = :email', [':email' => $email])[0] ?? [];
    }

    public function set($publicId, $data)
    {   
        unset($data['publicId']);
        unset($data['email']);
        if(isset($data['pass'])){
            $data['pass'] = Crip::pass($data['pass']);
        }
        return $this->update($this->table, $data, 'publicId = :publicId', ['publicId' => $publicId]);
    }

    public function delete($publicId)
    {
        return $this->query("DELETE FROM {$this->table} WHERE publicId = :publicId", [':publicId' => $publicId]);
    }

    public function isLogin($email, $pass)
    {
        return count($this->select($this->table, 'email = :email AND pass = :pass', [':email' => $email, ':pass' => Crip::pass($pass) ])) > 0;
    }
}
