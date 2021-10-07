<?php
namespace MYMVC\MODELS;

use MYMVC\LIB\filter;

class suppliersmodel extends AbstractModel{
    use filter;

    protected static $tableName = 'suppliers' ;
    protected static $primaryKey = 'suppliers_id';

    protected $suppliers_id , $name , $phone , $email , $address ;

    protected static $table_schema = [
        'name'  => self::DATA_TYPE_STR ,
        'phone'  => self::DATA_TYPE_STR ,
        'email'  => self::DATA_TYPE_STR ,
        'address'  => self::DATA_TYPE_STR ,
    ];

    public function __construct( $name , $phone , $email , $address )
    {
        $this->name = $this->filterString($name);
        $this->phone = $this->filterString($phone);
        $this->email = $this->filterEmail($email);
        $this->address = $this->filterString($address);
    }

    public function getSuppliersId()
    {
        return $this->suppliers_id;
    }

    public function setSuppliersId($suppliers_id): void
    {
        $this->suppliers_id = $this->filterInt($suppliers_id);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
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
    public function getAddress()
    {
        return $this->address;
    }



}