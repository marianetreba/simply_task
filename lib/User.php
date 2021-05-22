<?php

class User
{

    private static $users = [
        '1' => [
            'id' => '1',
            'username' => 'admin',
            'password' => '123',
        ],
    ];

    public static $id = null;
    public static $data = [];

    public static function init()
    {
        session_name('s');
        session_start();

        if ($_SESSION['uid']) {
            $user = self::getById($_SESSION['uid']);
        }

        if ($user) {
            self::$id = $user['id'];
            self::$data = $user;
        }
    }

    public static function findByName($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return $user;
            }
        }

        return null;
    }

    public static function getById($id)
    {
        return self::$users[$id] ?? null;
    }

    public static function signIn($user)
    {
        $_SESSION['uid'] = self::$id = $user['id'];
        self::$data = $user;
    }

    public static function signOut()
    {
        session_destroy();
        Response::redirect('/');
    }

}
