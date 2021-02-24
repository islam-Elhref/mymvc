<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Helper;
use MYMVC\MODELS\privilegesmodel;
use PDOException;

class PrivilegesController extends AbstractController
{
    use filter;
    use Helper;

    private $called_class = 'MYMVC\MODELS\privilegesmodel';

    public function defaultAction()
    {
        $this->_language->load('privileges', 'default');
        $this->_data['privileges'] = privilegesmodel::getAll('', 'DESC');
        $this->view();
    }


    public function editAction()
    {
        if (isset($this->_params[0])) {
            $privilege_id = abs($this->filterInt($this->_params[0])); // param id privilege
            $privilege = privilegesmodel::getByPK($privilege_id); // object from privilege model
            if (!empty($privilege) && is_a($privilege, $this->called_class)) {

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                    $privilege_edit = new privilegesmodel($_POST['name'], $_POST['url']);
                    $privilege_edit->setPrivilegeId($this->_params[0]);

                    if ($privilege_edit->check_input_empty() === true) {
                        try {
                            $privilege_edit->save();
                            $this->write_msg('تم تعديل الصلاحيه بنجاح', 'A Privilege has been successfully Edit');

                        } catch (PDOException $e) {
                            $this->write_msg('. اسم الصلاحيه او الرابط موجود مسبقا ؟ لم يتم الحفظ', 'privilege name or privilege url is exist ? Not saved .');

                            $_SESSION['error'] = 'error';
                        }
                    }
                    $this->redirect('/privileges');
                }
                $this->_language->load('privileges', 'edit'); // language file edit
                $this->_data['privilege'] = $privilege;
                $this->view();
            } else {
                $this->redirect('/privileges');
            }
        } else {
            $this->redirect('/privileges');
        }
    }

    public function addAction()
    {
        $this->_language->load('privileges', 'add');

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $new_privilege = new privilegesmodel($_POST['name'], $_POST['url']);

            if ($new_privilege->check_input_empty() === true) {
                try {
                    $new_privilege->save();
                    $this->write_msg('تم حفظ الصلاحيه بنجاح', 'A New Privilege has been successfully added');

                } catch (PDOException $e) {
                    $this->write_msg('. اسم الصلاحيه او الرابط موجود مسبقا ؟ لم يتم الحفظ', 'privilege name or privilege url is exist ? Not saved .');

                    $_SESSION['error'] = 'error';
                }
            }
            $this->redirect('/privileges');
        }

        $this->view();
    }

    public function deleteAction()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $path = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
        } else {
            $path = '';
        }

        if (isset($this->_params[0]) && $path == '/privileges') {

            $privilege_id = abs($this->filterInt($this->_params[0]));
            $privilege = privilegesmodel::getByPK($privilege_id);
            if (!empty($privilege) && is_a($privilege, $this->called_class)) {

                try {
                    $privilege->delete();
                    $this->write_msg('تم حذف الصلاحيه بنجاح', 'A Privilege has been successfully deleted');

                } catch (PDOException $e) {
                    $this->write_msg('. هناك خطأ ما ؟ لم يتم الحذف', 'There is an error? Not Delete .');
                    $_SESSION['error'] = 'error';
                }
                $this->redirect('/privileges');

            } else {
                $this->redirect('/privileges');
            }
        } else {
            $this->redirect('/privileges');
        }
    }


}