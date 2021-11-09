<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\Messenger;
use MYMVC\LIB\UploadFile;
use MYMVC\MODELS\ProductsCategorymodel;

class productscategorycontroller extends AbstractController
{


    private $rule_for_validation = [
        "category_name" => 'req|alpha|smax(30)',
    ];

    public function defaultAction()
    {
        $this->getLang()->load('productscategory', 'default');

        $this->_data['categories'] = ProductsCategorymodel::getAll();
        $this->view();
    }

    public function addAction()
    {

        $this->getLang()->load('productscategory', 'add');
        $this->getLang()->load('productscategory', 'label');
        $this->getLang()->load('productscategory', 'msgs');
        $this->getLang()->load('productscategory', 'msgs');
        $this->getLang()->load('validation', 'errors');


        if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation, $_POST)) {
            $productcategory = new productscategorymodel($_POST['category_name']);
            try {
                $productcategory->save();
                $msg = $this->getLang()->feed_msg('msg_success_add', [$_POST['category_name']]);
                $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                $this->redirect('/productscategory');
            } catch (\PDOException $e) {
                if ($productcategory->productcategoryexist()) {
                    $msg = $this->getLang()->feed_msg('msg_error_exist', [$_POST['category_name']]);
                    $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                } else {
                    $this->getmsg()->addMsg($this->getLang()->get('msg_error_edit') . $e->getMessage(), Messenger::Msg_error);
                }
            }
        }

        $this->view();
    }

    public function editAction()
    {

        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER'])) {
            $productcategory_id = $this->_params['0'];
            $oldproductcategory = productscategorymodel::getByPK($productcategory_id);

            if (!empty($oldproductcategory) && !is_a($oldproductcategory, 'ProductsCategorymodel')) {

// load every file language
                $this->getLang()->load('productscategory', 'edit');
                $this->getLang()->load('productscategory', 'label');
                $this->getLang()->load('productscategory', 'msgs');
                $this->getLang()->load('validation', 'errors');
// load every file language

                $this->_data['productcategory'] = $oldproductcategory; // make $productcategory to use in html edit.view
                $this->rule_for_validation = [
                    "category_name" => 'req|alpha|smax(30)',
                ]; // this rule for image and category_name

                if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation, $_POST)) {
                    try {
                        $oldproductcategory->setCategoryName($_POST['category_name']);
                        $oldproductcategory->save();

                        $msg = $this->getLang()->feed_msg('msg_success_edit', [$_POST['category_name']]);
                        $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                        $this->redirect('/productscategory');
                    } catch (\PDOException $e) {

                        if ($oldproductcategory->productcategoryexist()) { // اذا كان اسم القسم هذا موجود وهذا سبب الخطا
                            $msg = $this->getLang()->feed_msg('msg_error_exist', [$_POST['category_name']]);
                            $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                        } else { // اذا كان الخطا شئ اخر
                            $this->getmsg()->addMsg($this->getLang()->get('msg_error_edit'), Messenger::Msg_error);
                        }
                    }
                }

                $this->view();

            } else {
                $this->redirect('/productscategory');
            } /* is product category not found by id */

        } else {
            $this->redirect('/productscategory');
        } /*if not found param[0] /category/edit/12*/
    }

    public function deleteAction()
    {
        /* اذا لم يكن يوجود بارام اي id في اللينك او لم يكن لينك جاء منه اي كتب اللينك بصوره مباشره يتم رجوعي الي صفحه الكاتيجوري الرئيسيه*/
        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) == '/productscategory') {

            $this->getLang()->load('productscategory', 'msgs'); /* استدعاء فايل اللغه الخاص بالرسائل النجاح او الخطأ */
            $productcategory_id = $this->_params['0'];
            $productcategory = productscategorymodel::getByPK($productcategory_id);

            if (!empty($productcategory)) {
                try {
                    $productcategory->delete();
                    $msg = $this->getLang()->feed_msg('msg_success_delete', [$productcategory->getcategory_name()]);
                    $this->getmsg()->addMsg($msg, Messenger::Msg_success);

                } catch (\PDOException $e) {
                    $msg = $this->getLang()->get('msg_error_delete');
                    $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                }
            }

        }
        $this->redirect('/productscategory');
    }

}
