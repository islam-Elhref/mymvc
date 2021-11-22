<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Helper;
use MYMVC\LIB\Messenger;
use MYMVC\LIB\Validation;
use MYMVC\MODELS\AbstractModel;
use MYMVC\MODELS\notificationmodel;
use MYMVC\MODELS\privilegecontrolmodel;
use MYMVC\MODELS\privilegesmodel;
use MYMVC\MODELS\UsersGroupsModel;
use PDOException;

class UsersGroupsController extends AbstractController
{

    private $rules_to_valid = [
        'name' => 'req|alpha',
    ];

    use Validation;
    use filter;
    use Helper;

    private $called_class = 'MYMVC\MODELS\UsersGroupsModel';


    public function defaultAction()
    {
        $this->_language->load('usersgroups', 'default');
        $this->_data['usersgroups'] = UsersGroupsModel::getAll();
        $this->view();
    }

    public function editAction()
    {
        $this->_language->load('usersgroups', 'edit');
        $this->_language->load('usersgroups', 'msgs');
        $this->getLang()->load('validation' , 'errors');

        if (isset($this->_params[0])) {
            $usersGroupId = abs($this->filterInt($this->_params[0]));
            $usersGroup = UsersGroupsModel::getByPK($usersGroupId);
            $old_usersgroup = clone $usersGroup ;
            if ($usersGroup != false) {

                // this for get privilege_id old to do check if this privilege_id is exist before ;
                $array_privilege_id = privilegecontrolmodel::getByGroup($usersGroup);
                $array_privilege_name = privilegecontrolmodel::getnameByGroup($usersGroup);
                ksort($array_privilege_name);

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rules_to_valid , $_POST) == true) {
                    $groupnameBefore = $usersGroup->getGroupName();
                    $groupnameAfter = $_POST['name'];
                    $usersGroup->setGroupName($groupnameAfter);

                     try {
                            if (isset($_POST['privilege']) && !empty($_POST['privilege'])) {
                                $privilegeIdToBeDeleted = array_diff($array_privilege_id, $_POST['privilege']);
                                $privilegeIdToBecreated = array_diff($_POST['privilege'], $array_privilege_id);
                                $usersGroup->save();

                                foreach ($privilegeIdToBeDeleted as $privilegeId) {
                                    $UnWantedPrivilege = privilegecontrolmodel::getWhere(['group_id' => $usersGroup->getGroupId(), 'privilege_id' => $privilegeId]);
                                    $UnWantedPrivilege->current()->delete();
                                }

                                foreach ($privilegeIdToBecreated as $privilegeid) {
                                    $privilegecontrol = new privilegecontrolmodel($usersGroup->getGroupId(), $privilegeid);
                                    $privilegecontrol->save();
                                }
                                $array_privilege_after = privilegecontrolmodel::getByGroup($usersGroup);


                                if( ( $array_privilege_id != $array_privilege_after ) || ( $old_usersgroup !=  $usersGroup ) ) {
                                    $group = $old_usersgroup->foreach_object() ;
                                    foreach ($array_privilege_name as $key => $value){
                                        $group[$key] = $value ;
                                    }
                                    $opject_old = serialize($group);
                                    $notification = new notificationmodel('notif_usersgroups_title', 'notif_usersgroups_content_edit', 'notif_type_1',
                                        $this->getsession()->getuser()->getUserId(), '/usersgroups/edit/' . $usersGroup->getGroupId(), $usersGroup->getGroupName());
                                    $notification->setObject($opject_old);
                                    $notification->save();
                                }


                                $msg = $this->getLang()->feed_msg('msg_success_edit' , [$groupnameBefore , $groupnameAfter]);
                                $this->_msg->addMsg($msg, Messenger::Msg_success);

                            } else {
                                $this->getmsg()->addMsg('there\'s no privilege', Messenger::Msg_success);
                                throw new PDOException('there\'s no privilege');
                            }

                        } catch (PDOException $e) {
                            $this->getmsg()->addMsg($this->getLang()->get('msg_error_add'), Messenger::Msg_error);
                        }
                    $this->redirect('/usersgroups');
                }


                // write variable in $this->_data[''] and language ;
                $this->_data['privileges'] = privilegesmodel::getAll();
                $this->_data['privileges_old'] = $array_privilege_id;
                $this->_data['usergroup'] = $usersGroup;
                $this->view();

            } else {
                $this->redirect('/usersgroups');
            } // if usersgroup is empty == false
        } else {
            $this->redirect('/usersgroups');
        } // if usergroup id  not found as $this->_params[0]

    }

    public function addAction()
    {
        $this->_language->load('usersgroups', 'add');
        $this->_language->load('usersgroups', 'msgs');
        $this->getLang()->load('validation' , 'errors');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && $this->is_valid($this->rules_to_valid , $_POST) == true) {
            $new_users_group = new UsersGroupsModel($_POST['name']);

                try {
                    if (isset($_POST['privilege']) && !empty($_POST['privilege'])) {
                        $new_users_group->save();
                        foreach ($_POST['privilege'] as $privilegeid) {
                            $privilegecontrol = new privilegecontrolmodel($new_users_group->getGroupId(), $privilegeid);
                            $privilegecontrol->save();
                        }

                        $notification = new notificationmodel('notif_usersgroups_title' , 'notif_usersgroups_content_add' , 'notif_type_0' ,
                            $this->getsession()->getuser()->getUserId() , '/usersgroups/edit/'.$new_users_group->getGroupId() , $new_users_group->getGroupName());
                        $notification->save();

                        $user_group_name = $new_users_group->getGroupName();

                        $this->getmsg()->addMsg($this->getLang()->feed_msg('msg_success_add' , [$user_group_name]) , Messenger::Msg_success );
                    } else {
                        throw new PDOException('there\'s no privilege');
                    }

                } catch (PDOException $e) {
                    $this->_msg->addMsg($this->getLang()->get('msg_error_add'), Messenger::Msg_error);

                }
            $this->redirect('/usersgroups');
        }

        $this->_data['privileges'] = privilegesmodel::getAll();
        $this->view();
    }

    public function deleteAction()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $path = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
        } else {
            $path = '';
        }

        if (isset($this->_params[0]) && $path == '/usersgroups') {

            $usersGroupId = abs($this->filterInt($this->_params[0]));
            $usersGroup = UsersGroupsModel::getByPK($usersGroupId);

            if ($usersGroup !== false) {

                $this->_language->load('usersgroups', 'msgs');
                $msg = $this->_language->getDictionary();
                try {
                    $usersGroupName = $usersGroup->getGroupName();
                    $group = $usersGroup->foreach_object() ;
                    $array_privilege_name = privilegecontrolmodel::getnameByGroup($usersGroup);
                    if ($usersGroup->delete()) {


                        ksort($array_privilege_name);
                        foreach ($array_privilege_name as $key => $value){
                            $group[$key] = $value ;
                        }

                        $opject_old = serialize($group);
                        $notification = new notificationmodel('notif_usersgroups_title', 'notif_usersgroups_content_delete', 'notif_type_2',
                            $this->getsession()->getuser()->getUserId(), '', $usersGroup->getGroupName());
                        $notification->setObject($opject_old);
                        $notification->save();


                        $msg_success = str_replace('name', $usersGroupName, $msg['msg_success_delete']);
                        $this->_msg->addMsg($msg_success, Messenger::Msg_success);
                    }
                } catch (PDOException $e) {
                    $this->_msg->addMsg($msg['msg_error_add'], Messenger::Msg_error);
                }
                $this->redirect('/usersgroups');

            } else {
                $this->redirect('/usersgroups');
            }
        } else {
            $this->redirect('/usersgroups');
        }
    }


}