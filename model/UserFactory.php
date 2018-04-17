<?php
require_once('UserType.php');

class UserFactory
{
    public function getUserType($role)
    {
        $role_type = 'User_' . ucwords($role);
        // Generate UserType object based on given role
        if($role_type=="User_Standard")
            return new User_Standard();    
        else if($role_type=="User_Moderator")
            return new User_Moderator();
        else if($role_type=="User_Admin")
            return new User_Admin();
        return null;
    }
}
?>