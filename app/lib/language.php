<?php
namespace MYMVC\LIB;


class Language
{
    private $Dictionary = [] ;



public function load($controller , $action){
    $lang = defaultLanguage;
    if (isset($_SESSION['lang'])){
        $lang = $_SESSION['lang'];
    }

    $lang_file = language_PATH . $lang . DS . $controller . DS . $action .'.lang.php';
    if (file_exists($lang_file)){
        require_once $lang_file;
        if (isset($_) && !empty($_)){
            foreach ($_ as $key => $value){
                if (!key_exists($key , $this->Dictionary )){
                    $this->Dictionary[$key] = $value;
                }
            }
            return $this->Dictionary;
        }
    }else{
        trigger_error('the language file does not exists', E_USER_ERROR);
    }
    return true;
}


    /**
     * @return array
     */
    public function getDictionary()
    {
       return $this->Dictionary ;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->Dictionary)){
            return $this->Dictionary[$key];
        }
    }

    public function setkey($key , $new_key)
    {
        if (array_key_exists($key, $this->Dictionary)){
            $this->Dictionary[$key] = $new_key;
        }
    }


    public function feed_msg($key , $data ){

        if (array_key_exists($key, $this->Dictionary)){
            if ($this->get($data[0]) !== null){
                $data[0] = $this->get($data[0]);
            }
            array_unshift($data , $this->get($key));
           return call_user_func_array('sprintf', $data);
        }
    }

    public function feed_only($key , $data ){

        if (array_key_exists($key, $this->Dictionary)){
            if ($this->get($data[0]) !== null){
                $data[0] = $this->get($data[0]);
            }
            array_unshift($data , $this->get($key));
           $new_key = call_user_func_array('sprintf', $data);
            var_dump($new_key);
           $this->setkey($key , $new_key );
        }
    }




}