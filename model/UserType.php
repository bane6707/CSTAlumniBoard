<?php
require_once('User.php');

interface UserType
{
    public function getUser($firstName, $lastName, $pass, $email);
}

// standard user type
class User_Standard implements UserType
{
    public function getUser($firstName, $lastName, $pass, $email)
    {
        $user = new User($firstName, $lastName, $pass, $email, 1);
        if($user->save()!=0)
            return $user;
        return null;
    }
}

// moderator user type
class User_Moderator implements UserType
{
    public function getUser($firstName, $lastName, $pass, $email)
    {
        $user = new User($firstName, $lastName, $pass, $email, 2);
        if($user->save()!=0)
            return $user;
        return null;
    }
}

// admin user type
class User_Admin implements UserType
{
    public function getUser($firstName, $lastName, $pass, $email)
    {
        $user = new User($firstName, $lastName, $pass, $email, 3);
        if($user->save()!=0)
            return $user;
        return null;
    }
}
?>