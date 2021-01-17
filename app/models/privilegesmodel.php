<?php


namespace MYMVC\MODELS;


use MYMVC\LIB\filter;

class privilegesmodel extends AbstractModel
{

    use filter;

    public static $tableName = 'users_privilege';
    public static $primaryKey = 'privilege_id';

    public static $table_schema = [
        'privilege_name' => self::DATA_TYPE_STR
    ];

    protected $privilege_id, $privilege_name;

    public function __construct(string $privilege_name)
    {
        $this->privilege_name = $this->filterString($privilege_name);
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


}