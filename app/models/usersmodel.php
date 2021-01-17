<?php
namespace MYMVC\MODELS;

use MYMVC\LIB\filter;

class UsersModel extends AbstractModel {

    use filter;


    protected static $tableName = 'users';
    protected static $primaryKey = 'user_id';

    protected $user_id , $username , $password , $email , $phone ;
    protected $group_id , $subscription_date , $last_login;

    protected static $table_schema= [
        'username'              => self::DATA_TYPE_STR,
        'password'              => self::DATA_TYPE_STR,
        'email'                 => self::DATA_TYPE_STR,
        'phone'                 => self::DATA_TYPE_STR,
        'group_id'              => self::DATA_TYPE_int,
        'subscription_date'     => self::DATA_TYPE_STR,
        'last_login'            => self::DATA_TYPE_STR,
    ];

    public function __construct($username , $password , $email ,$phone , $group_id ,$subscription_date ,$last_login)
    {
        $this->username = $this->filterString($username);
        $this->password = $this->filterString($password);
        $this->email = $this->filterEmail($email);
        $this->phone = $this->filterString($phone);
        $this->group_id = $this->filterInt($group_id);
        $this->subscription_date = $this->filterString($subscription_date);
        $this->last_login = $this->filterString($last_login);
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $this->filterInt($user_id);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionDate()
    {
        return $this->subscription_date;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }


}