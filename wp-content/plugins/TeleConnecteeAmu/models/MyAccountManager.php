<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 06/05/2019
 * Time: 10:09
 */

class MyAccountManager extends Model
{
    public function modifyMyPassword($pwd){
        $current_user = wp_get_current_user();
        return $this->modifyUser($current_user->ID, $current_user->user_login, $pwd, $current_user->code1, $current_user->code2, $current_user->code3, $current_user->user_email);
    }

    public function verifyMyPassword($pwd){
        $current_user = wp_get_current_user();
        if($pwd == $current_user->user_pass){
            return true;
        }
        else{
            return false;
        }
    }
}