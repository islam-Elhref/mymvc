<?php


namespace MYMVC\LIB;


class UploadFile
{

    private $name;
    private $type;
    private $tmp_name;
    private $error;
    private $size;
    private $maxFileSize = '40M';
    private $file_ext;
    private $fullFilename;
    private $length ;
    private $allow_ext = ['jpeg', 'jpg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls'];

    public function __construct(array $file)
    {
        if (is_array($file) && !empty($file) && $file['name'] != '' && $this->checkextention($file)) {
            $this->name = $this->changefilename($file['name']);
            $this->type = $file['type'];
            $this->tmp_name = $file['tmp_name'];
            $this->error = $file['error'];
            $this->size = $file['size'];
            if (!ini_get('upload_max_filesize') == $this->maxFileSize) {
                ini_set('upload_max_filesize', $this->maxFileSize);
            }
        }
    }

    public function checkextention($file){
        $ext = pathinfo($file['name'] , PATHINFO_EXTENSION) ;
        if (in_array( $ext ,  $this->allow_ext)){
            return true;
        }else{
            return false ;
        }

    }

    public function printAllow_extentions()
    {
        $string = '[ ';
        foreach ($this->allow_ext as $one) {
            $string .= $one . ' - ';
        }
        return $string . ']';
    }

    public function printfullfilename()
    {
        return $this->fullFilename;
    }

    public function printmaxFileSize()
    {
        return $this->maxFileSize;
    }

    private function changefilename($name)
    {
        $name = strtolower($name);
        preg_match('/([a-z]{1,4})$/i', $name, $m);
        $this->file_ext = $m[0];
        $this->length = 29 - strlen($this->file_ext);

        $password = md5(session_id() . $name . 'اسلام' . time());
        return substr(strtolower(base64_encode($password)), 0, $this->length);
    }

    private function checknamefileexist($folder_who_want_in)
    {
        $this->fullFilename = $this->name . '.' . $this->file_ext;
        if (strlen($this->fullFilename) < 30) {
            $this->fullFilename = substr(rand(0, 1000000) . '_' . $this->fullFilename, 0, $this->length);
            checknamefileexist($folder_who_want_in);
        }
        $file = $folder_who_want_in . $this->fullFilename;
        if (file_exists($file)) {
            $this->fullFilename = substr(rand(0, 1000000) . '_' . $this->fullFilename, 0, $this->length);
            checknamefileexist($folder_who_want_in);
        } else {
            return true;
        }
    }

    public function isallowedtype()
    {
        return in_array($this->file_ext, $this->allow_ext);
    }

    public function isSizeAcceptable()
    {
        $filesize = ceil(($this->size / 1024 / 1024));
        return (int)$filesize <= (int)$this->maxFileSize;
    }

    private function isimage(){
        if (in_array($this->file_ext , ['jpeg', 'jpg', 'png', 'gif'])){
            return true;
        }else{
            return false;
        }
    }

    public function checkfile($folder_who_want_in)
    {
        if ($this->error != 0) {
            throw new \PDOException('sorry file not upload successfully');
        } elseif (!$this->checknamefileexist($folder_who_want_in)) {
            throw new \PDOException('there is errors in file upload');
        } elseif (!$this->isallowedtype()) {
            throw new \PDOException('sorry file of type ' . $this->file_ext . ' are not allowed ');
        } elseif (!$this->isSizeAcceptable()) {
            throw new \PDOException('sorry file size is  should be less than ' . $this->maxFileSize);
        } else {
            if (is_writable($folder_who_want_in)) {
                move_uploaded_file($this->tmp_name, $folder_who_want_in . $this->fullFilename);
            } else {
                chmod($folder_who_want_in, 0755);
                move_uploaded_file($this->tmp_name, $folder_who_want_in . $this->fullFilename);
            }
        }
        return $this;
    }

    public static function getimageanddelete($file){
        if (file_exists($file)){
            if (is_writable($file)) {
                unlink($file);
            } else {
                chmod($file, 0755);
                unlink($file);
            }
        }
    }

    public function deleteimage()
    {
        if (file_exists(IMAGE_UPLOAD . $this->fullFilename)) {
            $file = IMAGE_UPLOAD . $this->fullFilename;
            if (is_writable($file)) {
                unlink($file);
            } else {
                chmod($file, 0755);
                unlink($file);
            }
        }
    }

}