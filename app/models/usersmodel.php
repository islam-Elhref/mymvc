<?php

namespace MYMVC\MODELS;

use MYMVC\LIB\filter;
use MYMVC\LIB\MySession;

class UsersModel extends AbstractModel
{

    use filter;


    protected static $tableName = 'users';
    protected static $primaryKey = 'user_id';

    protected $user_id, $username, $password, $email, $phone;
    protected $group_id, $subscription_date, $last_login, $status, $group_name;
    /**
     * @var UsersprofileModel
     */
    protected $profile;
    protected array $privileges;

    protected static $table_schema = [
        'username' => self::DATA_TYPE_STR,
        'password' => self::DATA_TYPE_STR,
        'email' => self::DATA_TYPE_STR,
        'phone' => self::DATA_TYPE_STR,
        'group_id' => self::DATA_TYPE_int,
        'subscription_date' => self::DATA_TYPE_STR,
        'last_login' => self::DATA_TYPE_STR,
        'status' => self::DATA_TYPE_int,
    ];

    public function __construct($username, $password, $email, $phone, $group_id)
    {
        $this->Add_action_construct($username, $password, $email, $phone, $group_id);
    }

    public function Add_action_construct($username, $password, $email, $phone, $group_id)
    {
        $this->username = $this->filterString($username);
        $this->password = $password;
        $this->email = $this->filterEmail($email);
        $this->phone = $this->filterString($phone);
        $this->group_id = $this->filterInt($group_id);
        $this->subscription_date = date('Y-m-d');
        $this->setStatus(3);
    }

    public function edit_action_construct($username, $password, $email, $phone, $group_id)
    {
        $this->username = $this->filterString($username);
        $this->password = $password;
        $this->email = $this->filterEmail($email);
        $this->phone = $this->filterString($phone);
        $this->group_id = $this->filterInt($group_id);

        return $this;
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

    public function setPrivileges($privileges)
    {
        if (!empty($privileges)) {
            $array_privileges_url = array();
            foreach ($privileges as $privilege) {
                $array_privileges_url[] = $privilege->privilege_url;
            }
            $this->privileges = $array_privileges_url;
        }
    }

    public function getPrivileges()
    {
        return $this->privileges;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getGroupName()
    {
        return $this->group_name;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile): void
    {
        $this->profile = $profile;
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    public function removePassword()
    {
        unset($this->password);
    }

    public function removestatues()
    {
        unset($this->status);
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

    public static function usersgetAll(UsersModel $user)
    {
        return UsersModel::getAll('SELECT u.* , ug.group_name as group_name FROM ' . self::$tableName . ' u inner JOIN users_group ug on u.group_id = ug.group_id where u.user_id != ' . "$user->user_id");
    }

    public static function getuser(array $array)
    {
        return UsersModel::getonetest($array, ' join users_group on users_group.group_id = users.group_id ');
    }

    public function user_save_in_session_wzout_pass(UsersModel $user, MySession $session)
    {
        $user_with_out_Pass = $user;  // save user in variable ;
        $user_with_out_Pass->removePassword(); // remove password from session

        if (isset($session->profile)) {
            unset($session->profile);
        }

        $profile = UsersprofileModel::getByPK($user->getUserId());
        $user_with_out_Pass->setProfile($profile); // add profile
        $privileges = privilegecontrolmodel::getAll('SELECT * FROM `privilege_control` JOIN users_privilege on privilege_control.privilege_id = users_privilege.privilege_id WHERE `group_id` = ' . $user->getGroupId());
        $user_with_out_Pass->setPrivileges($privileges); // add url privilege belongs to groups id of this account

        if (isset($session->u)) {
            $session->u->removePassword();
            if ($user_with_out_Pass == $session->u) {

            } else {
                $session->u = $user_with_out_Pass;
            }
        } else {
            $session->u = $user_with_out_Pass;
        }

    }


}