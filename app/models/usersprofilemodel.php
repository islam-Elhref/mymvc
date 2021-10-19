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
        $this->image = $image;
        $this->dob = isset($dob) && $dob != '' ? $dob : '';
    }

    public function uploadImage($image){
        $avtar_name = rand(0 , 1000000) . '_' . $image['name'] ;
        $file = 'img\usersImage\\' . $avtar_name ;
        if (file_exists($file)){
            $this->uploadImage($image);
        }else{
            move_uploaded_file($image   ['tmp_name'] , $file ) ;
            $this->image = $avtar_name;
        }

    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return mixed|string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed|string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getDob(): string
    {
        return $this->dob;
    }

    public function getMixName(){
        return sprintf("%s %s", $this->firstname , $this->lastname);
    }


}