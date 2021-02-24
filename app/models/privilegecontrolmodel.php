<?php


namespace MYMVC\MODELS;


use MYMVC\LIB\filter;

class privilegecontrolmodel extends AbstractModel
{

    use filter;

    public static $tableName = 'privilege_control';
    public static $primaryKey = 'id';

    public static $table_schema = [
        'group_id'              => self::DATA_TYPE_int,
        'privilege_id'              => self::DATA_TYPE_int,
    ];

    protected $id , $group_id , $privilege_id ;

    public function __construct( string $group_id , $privilege_id )
    {
        $this->group_id = $this->filterInt($group_id);
        $this->privilege_id = $this->filterInt($privilege_id);
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getGroupId()
    {
        return $this->group_id;
    }

    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;
    }

    public function getPrivilegeId()
    {
        return $this->privilege_id;
    }

    public function setPrivilegeId($privilege_id)
    {
        $this->privilege_id = $privilege_id;
    }





}