<?php


namespace MYMVC\MODELS;


use MYMVC\LIB\filter;

class privilegesmodel extends AbstractModel
{

    use filter;

    public static $tableName = 'users_privilege';
    public static $primaryKey = 'privilege_id';

    public static $table_schema = [
        'privilege_name' => self::DATA_TYPE_STR,
        'privilege_url' => self::DATA_TYPE_STR
    ];

    protected $privilege_id, $privilege_name , $privilege_url;

    public function __construct(string $privilege_name , string $privilege_url)
    {

        if (!preg_match('|/.+|' , $privilege_url)){
            $lang = $_SESSION['lang'];
            if ($lang === 'ar') {
                $this->message[] = 'يجب كتابة الرابط الخاص بالصلاحيه مثل  clients/';
            } else {
                $this->message[] = 'Please Write a Valid Privilege Url Like /clients';
            }
        }

        $this->privilege_name = $this->filterString($privilege_name);
        $this->privilege_url = $this->filterString($privilege_url);

    }



    public function setPrivilegeId($privilege_id)
    {
        $this->privilege_id = $privilege_id;
    }

    public function getPrivilegeId()
    {
        return $this->privilege_id;
    }

    public function getPrivilegeName()
    {
        return $this->privilege_name;
    }

    public function getPrivilegeUrl()
    {
        return $this->privilege_url;
    }



}