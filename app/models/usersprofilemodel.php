<?php

namespace MYMVC\MODELS;

use MYMVC\LIB\filter;
use MYMVC\LIB\MySession;

class UsersprofileModel extends AbstractModel
{

    use filter;


    protected static $tableName = 'users_profile';
    protected static $primaryKey = 'user_id';

    protected $user_id, $firstname, $lastname, $address, $image , $dob;

    protected static $table_schema = [
        'user_id'       => self::DATA_TYPE_int,
        'firstname'     => self::DATA_TYPE_STR,
        'lastname'      => self::DATA_TYPE_STR,
        'address'       => self::DATA_TYPE_STR,
        'image'         => self::DATA_TYPE_STR,
        'dob'           => self::DATA_TYPE_STR,
    ];

    public function __construct($user_id ,$firstname, $lastname, $address, $image, $dob )
    {
        $this->user_id = $this->filterInt($user_id);
        $this->firstname = $this->filterString($firstname);
        $this->lastname = $this->filterString($lastname);
        $this->address = isset($address) && $address != '' ?$this->filterString($address) : '';
        $this->image = isset($image) && $image != '' ?$this->filterString($image) : '';
        $this->dob = isset($dob) && $dob != '' ? $dob : '';
    }


    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

}