<?php
namespace MYMVC\MODELS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Messenger;
use MYMVC\LIB\Language;

class notificationmodel extends AbstractModel{
    use filter;

    protected static $tableName = 'notification' ;
    protected static $primaryKey = 'notification_id';

    protected $notification_id , $title , $content , $type , $created , $user_id , $url , $name , $object  ;

    protected static $table_schema = [
        'title'  => self::DATA_TYPE_STR ,
        'content'  => self::DATA_TYPE_STR ,
        'type'  => self::DATA_TYPE_int ,
        'created'  => self::DATA_TYPE_STR ,
        'user_id'  => self::DATA_TYPE_int ,
        'url'  => self::DATA_TYPE_STR ,
        'name'  => self::DATA_TYPE_STR ,
        'object'  => self::DATA_TYPE_STR ,
    ];

    public function __construct( $title , $content , $type , $user_id , $url , $name )
    {
        $this->title = $this->filterString($title);
        $this->content = $this->filterString($content);
        $this->type = $this->filterInt($type);
        $this->created = date('Y-m-d');
        $this->user_id = $user_id;
        $this->url = $this->filterString($url);
        $this->name = $this->filterString($name);
    }

    /**
     * @param mixed $object
     */
    public function setObject($object): void
    {
        $this->object = $object;
    }

    public function getNotificationId()
    {
        return $this->notification_id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function showcontent($content){
        return $content . ' ' . $this->name;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        $object = unserialize($this->object);
        return $object;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getUserId()
    {
        return $this->user_id;
    }


    public static function getAllnotification()
    {
        $sql = 'select * from notification join users on users.user_id = notification.user_id' ;
        return parent::getAll($sql);
    }


}