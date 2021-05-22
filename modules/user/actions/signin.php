<?php

Response::redirect_if(User::$id, '/');
if ($_POST['login'] && $_POST['password']) {
    $name = Str::clean($_POST['login']);
    $user = User::findByName($name);

    if ($user && $_POST['password'] === $user['password']) {
        User::signIn($user);
        Response::redirect('/tasks');
    } else {
        $failure = true;
    }
}
