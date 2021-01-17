<?php


namespace MYMVC\MODELS;


use MYMVC\LIB\filter;

class UsersGroupsModel extends AbstractModel
{

    use filter;

    public static $tableName = 'users_group';
    public static $primaryKey = 'group_id';

    public static $table_schema = [
        'group_name'              => self::DATA_TYPE_STR,
    ];

    protected $group_id , $group_name ;

    public function __construct( string $group_name )
    {
        $this->group_name = $this->filterString($group_name);
    }

    public function getGroupId()
    {
        return $this->group_id;
    }

    public function setGroupId($group_id)
    {
        $this->group_id = $this->filterInt($group_id);
    }

    public function getGroupName()
    {
        return $this->group_name;
    }



}