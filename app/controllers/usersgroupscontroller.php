<?php
namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Helper;
use MYMVC\LIB\Messenger;
use MYMVC\MODELS\privilegecontrolmodel;
use MYMVC\MODELS\privilegesmodel;
use MYMVC\MODELS\UsersGroupsModel;
use PDOException;

class UsersGroupsController extends AbstractController
{

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
        $msgs = $this->_language->getDictionary();

        if (isset($this->_params[0])) {
            $usersGroupId = abs($this->filterInt($this->_params[0]));
            $usersGroup = UsersGroupsModel::getByPK($usersGroupId);
            if ($usersGroup != false) {

                // this for get privilege_id old to do check if this privilege_id is exist before ;
                $array_privilege_id = privilegecontrolmodel::getByGroup($usersGroup);


                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                    $groupnameBefore = $usersGroup->getGroupName();
                    $groupnameAfter = $_POST['name'];
                    $usersGroup->setGroupName($groupnameAfter);


                    if ($usersGroup->check_input_empty() === true) {
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
                                $msg_success = str_replace(array('name', 'other'), array($groupnameBefore, $groupnameAfter), $msgs['msg_success_edit']);
                                $this->_msg->addMsg($msg_success , Messenger::Msg_success);

                            } else {
                                $this->_msg->addMsg('there\'s no privilege' , Messenger::Msg_success);
                                throw new PDOException('there\'s no privilege' );
                            }

                        } catch (PDOException $e) {
                            $this->_msg->addMsg($msgs['msg_error_add'] , Messenger::Msg_error);
                        }
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
        $this->_language->load('usersgroups' , 'msgs' );
        $msgs = $this->_language->getDictionary();


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $new_users_group = new UsersGroupsModel($_POST['name']);

            if ($new_users_group->check_input_empty() === true) {
                try {
                    if (isset($_POST['privilege']) && !empty($_POST['privilege'])) {
                        $new_users_group->save();
                        foreach ($_POST['privilege'] as $privilegeid) {
                            $privilegecontrol = new privilegecontrolmodel($new_users_group->getGroupId(), $privilegeid);
                            $privilegecontrol->save();
                        }

                    } else {
                        throw new PDOException('there\'s no privilege');
                    }

                } catch (PDOException $e) {
                    $this->write_msg('. اسم المجموعة موجود مسبقا ؟ لم يتم الحفظ', 'Users Group name is exist ? Not saved .', Messenger::Msg_error);

                }
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
                try {
                    $usersGroupName = $usersGroup->getGroupName();
                    if ($usersGroup->delete()) {
                        $this->write_msg("تم حذف مجموعة المستخدمين <b>$usersGroupName</b> بنجاح", "A Users Group <b>$usersGroupName</b> has been successfully deleted" , Messenger::Msg_success);
                    }
                } catch (PDOException $e) {
                    $this->write_msg('. هناك خطأ ما ؟ لم يتم الحذف', 'There is an error? Not Delete .' , Messenger::Msg_error);
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