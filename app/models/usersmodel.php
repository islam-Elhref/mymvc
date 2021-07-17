<?php

namespace MYMVC\MODELS;

use MYMVC\LIB\filter;

class UsersModel extends AbstractModel
{

    use filter;


    protected static $tableName = 'users';
    protected static $primaryKey = 'user_id';

    protected $user_id, $username, $password, $email, $phone;
    protected $group_id, $subscription_date, $last_login , $status;

    protected static $table_schema = [
        'username' => self::DATA_TYPE_STR,
        'password' => self::DATA_TYPE_STR,
        'email' => self::DATA_TYPE_STR,
        'phone' => self::DATA_TYPE_STR,
        'group_id' => self::DATA_TYPE_int,
        'subscription_date' => self::DATA_TYPE_STR,
        'last_login' => self::DATA_TYPE_STR,
    ];

    public function __construct($username, $password, $email, $phone, $group_id )
    {
            $this->Add_action_construct($username, $password, $email, $phone, $group_id ) ;
    }

    public function Add_action_construct($username, $password, $email, $phone, $group_id){
        $this->username = $this->filterString($username);
        $this->password = $password;
        $this->email = $this->filterEmail($email);
        $this->phone = $this->filterString($phone);
        $this->group_id = $this->filterInt($group_id);
        $this->subscription_date = date('Y-m-d');
    }
    public function edit_action_construct($username, $password, $email, $phone, $group_id){
        $this->username = $this->filterString($username);
        $this->password = $password;
        $this->email = $this->filterEmail($email);
        $this->phone = $this->filterString($phone);
        $this->group_id = $this->filterInt($group_id);

        return $this ;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
    public function setUserId($user_id)
    {
        $this->user_id = $this->filterInt($user_id);
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getCEmail()
    {
        return $this->email;
    }
    public function getGroupId()
    {
        return $this->group_id;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function removePassword(){
        unset($this->password);
    }
    public function getGroupName()
    {
        return $this->group_name;
    }
    public function getSubscriptionDate()
    {
        return $this->subscription_date;
    }
    public function getLastLogin()
    {
        return $this->last_login;
    }
    public function setLastLogin($last_login)
    {
        $this->last_login = $last_login;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public static function cryptPassword($password)
    {
        $options = [
            'cost' => 10,
        ];
        $pwd_peppered = hash_hmac("sha256", $password, 'islamعليabasس');
        return password_hash($pwd_peppered, PASSWORD_BCRYPT, $options);
    }
    public function checkPassword($password)
    {
        $options = [
            'cost' => 10,
        ];
        $pwd_peppered = hash_hmac("sha256", $password, 'islamعليabasس');
        return password_verify($pwd_peppered, $this->password);
    }
    public static function usersgetAll()
    {
        return UsersModel::getAll('SELECT u.* , ug.group_name as group_name FROM ' . self::$tableName . ' u inner JOIN users_group ug on u.group_id = ug.group_id ');
    }


}