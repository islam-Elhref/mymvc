<?php

namespace MYMVC\LIB;


class Messenger
{

    const Msg_success = 'alert-success';
    const Msg_error = 'alert-danger';
    const Msg_info = 'alert-info';
    const Msg_warning = 'alert-warning';


    private static $instance;
    private $session;

    private function __construct($session)
    {
        $this->session = $session;
    }

    private function __clone()
    {
    }

    public static function getInstance($session)
    {
        if (self::$instance === null) {
            self::$instance = new self($session);
        }
        return self::$instance;
    }

    public function addMsg($msg, $type)
    {
        if (!isset($this->session->msg) || !is_array($this->session->msg)) {
            $this->session->msg = [];
        }
        $tempMsgs = $this->session->msg;
        $tempMsgs[] = [$msg, $type];
        $this->session->msg = $tempMsgs;
    }

    public function getMsg()
    {
        if (isset($this->session->msg)) {
            $tempMsg = $this->session->msg;
            unset($this->session->msg);
            return $tempMsg;
        } else {
            return null;
        }
    }

}