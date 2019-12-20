<?php

namespace Hcode\Model;

use Hcode\DB\Sql;
use Hcode\Model;

class User extends Model
{
    const SESSION = "User";

    public static function login($username, $password)
    {
        $sql = new Sql();
        $results = $sql->select("SELECT * FROM db_ecommerce.tb_users WHERE deslogin = :USERNAME", array(
            "USERNAME" => $username
        ));
        if (count($results) === 0) {
            throw new \Exception("User Not Found or Wrong Password");

        }

        $data = $results[0];

        if (password_verify($password, $data['despassword']) === true) {
            $user = new User();
            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getValues();

            return $user;
        } else {
            throw new \Exception("User Not Found or Wrong Password");
        }
    }

    public static function verifyLogin($admin = true){

        if (
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
            ||
            (bool)$_SESSION[User::SESSION]["inadmin"] !== $admin
        ){
            header("Location: /admin/login");
            exit();
        }
    }

    public static function logout(){
        $_SESSION[User::SESSION] = NULL;
    }

}