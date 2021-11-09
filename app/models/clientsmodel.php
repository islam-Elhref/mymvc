<?php
namespace MYMVC\MODELS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Messenger;
use MYMVC\LIB\Language;

class clientsmodel extends AbstractModel{
    use filter;

    protected static $tableName = 'clients' ;
    protected static $primaryKey = 'client_id';

    protected $client_id , $name , $phone , $email , $address ;

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

    public function getclientsId()
    {
        return $this->client_id;
    }

    public function setclientsId($client_id): void
    {
        $this->client_id = $this->filterInt($client_id);
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

    public function check_exist(){
        $email_client = clientsmodel::getone(['email' => $this->email]);
        $nameclient = clientsmodel::getone(['name' => $this->name]);

        $msg = [] ;
        if (!empty($email_client) && is_object($email_client) && $email_client->getclientsId() != $this->getclientsId() ){
            $msg[] ='msg_error_email_exist' ;
        }
        if (!empty($nameclient) && is_object($nameclient) && $nameclient->getclientsId() != $this->getclientsId() ){
            $msg[] ='msg_error_name_exist' ;
        }

        return !empty($msg) && is_array($msg) ? $msg : false ;

    }




}