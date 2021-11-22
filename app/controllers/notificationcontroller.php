<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\Messenger;
use MYMVC\MODELS\notificationmodel;
use MYMVC\MODELS\suppliersmodel;

class notificationcontroller extends AbstractController
{

    public function defaultAction()
    {
        $this->getLang()->load('notification', 'default');

        $this->_data['notifications'] = notificationmodel::getAllnotification();
        $this->view();
    }

    public function showAction()
    {

        /* اذا لم يكن يوجود بارام اي id في اللينك او لم يكن لينك جاء منه اي كتب اللينك بصوره مباشره يتم رجوعي الي صفحه الكاتيجوري الرئيسيه*/
        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) == '/notification') {


            $notification_id = $this->_params['0'];
            $notification = notificationmodel::getonetest(['notification_id' => $notification_id] , 'join users on users.user_id = notification.user_id ');
            if (!empty($notification)) {

                $view = array_intersect([':view' => 'view'], $this->_template->getTemplate());
                $this->_template->changeTemplate($view);

                $this->getLang()->load('notification', 'show');


                $this->_data['notification'] = $notification;
                $object = $notification->getObject();
                if (is_object($object) ){
                    $this->_data['object'] = $object->foreach_object() ;
                }else{
                    $this->_data['object'] = $object ;
                }

                $this->view();

            }else{
                $this->redirect('/notification');
            }

        }else{
            $this->redirect('/notification');
        }

    }


}
