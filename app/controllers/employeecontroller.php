<?php

namespace MYMVC\CONTROLLERS;


use MYMVC\LIB\filter;
use MYMVC\LIB\Helper;
use MYMVC\MODELS\EmployeeModel;
use PDOException;

class EmployeeController extends AbstractController
{
    use filter;
    use Helper;

    private $called_class = 'MYMVC\MODELS\EmployeeModel';

    public function defaultAction(){
        $this->_language->load('Employee','default');
        $this->_data['employees'] = EmployeeModel::getAll();
        $this->view();
    }

    public function editAction(){
        $this->_language->load('Employee','edit');

        if (isset($this->_params[0])) {
            $id = abs($this->filterInt($this->_params[0]));
            $emp = EmployeeModel::getByPK($id);
            if (is_a($emp, $this->called_class) && !empty($emp)) {
                $this->_data['employee'] = $emp;
                if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                    $afterUpdate = new EmployeeModel($_POST['name'], $_POST['age'], $_POST['address'], $_POST['salary'], $_POST['tax']);
                    $afterUpdate->setId($id);
                    try {
                        $afterUpdate->save();
                        $_SESSION['message'] = 'تم حفظ الموظف بنجاح';
                    } catch (PDOException $e) {
                        $_SESSION['message'] = '. هناك خطأ ما ؟ لم يتم الحفظ';
                        $_SESSION['error'] = 'error';
                    }
                    $this->redirect('/employee');
                }
                $this->view();
            } else {
                $this->redirect('/employee');
            }
        } else {
            $this->redirect('/employee');
        }
    }

    public function addAction(){

        if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $newEmp = new EmployeeModel($_POST['name'], $_POST['age'], $_POST['address'], $_POST['salary'], $_POST['tax']);
            try {
                $newEmp->save();
                $_SESSION['message'] = 'تم حفظ الموظف بنجاح';
            } catch (PDOException $e) {
                $_SESSION['message'] = '. هناك خطأ ما ؟ لم يتم الحفظ';
                $_SESSION['error'] = 'error';
            }
            $this->redirect('/employee');
        }

        $this->_language->load('Employee','add');
        $this->view();
    }

    public function deleteAction(){
        if (isset($this->_params[0]) && !empty($this->_params[0]) ){
            $id = abs($this->filterInt($this->_params[0]));
            $emp_delete = EmployeeModel::getByPK($id);
            if (is_a($emp_delete , $this->called_class) && !empty($emp_delete)){
                if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == 'http://mymvc.com/employee') {
                    try {
                        $emp_delete->delete();
                        $_SESSION['message'] = 'تم حذف الموظف بنجاح';
                    } catch (PDOException $e) {
                        $_SESSION['message'] = '. هناك خطأ ما ؟ لم يتم الحذف';
                        $_SESSION['error'] = 'error';
                    }
                    $this->redirect('/employee');
                }else{
                    $this->redirect('/employee');
                }
            }else{
                $this->redirect('/employee');
            }
        }else{
            $this->redirect('/employee');
        }
    }

}