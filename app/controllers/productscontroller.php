<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\Messenger;
use MYMVC\MODELS\notificationmodel;
use MYMVC\MODELS\Productmodel;
use MYMVC\MODELS\ProductsCategorymodel;

class productscontroller extends AbstractController
{


    private $rule_for_validation = [
        "category_id" => 'req|int',
        "product_name" => 'req|alpha|smax(40)',
        "BuyPrice" => 'req|num',
        "SellPrice" => 'req|num',
        "unit" => 'req|int',
    ];

    public function defaultAction()
    {
        $this->getLang()->load('products', 'default');
        $this->getLang()->load('products', 'units');


        $this->_data['products'] = Productmodel::getAllproduct();
        $this->view();
    }

    public function addAction()
    {

        $this->getLang()->load('products', 'add');
        $this->getLang()->load('products', 'label');
        $this->getLang()->load('products', 'msgs');
        $this->getLang()->load('products', 'msgs');
        $this->getLang()->load('products', 'units');
        $this->getLang()->load('validation', 'errors');
        $this->getLang()->load('notification', 'default');

        $this->_data['categories'] = ProductsCategorymodel::getAll();

        if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation, $_POST)) {
            $product = new Productmodel($_POST['category_id'], $_POST['product_name'], $_POST['BuyPrice'], $_POST['SellPrice'], $_POST['unit']);
            try {
                $product->save();
                $notification = new notificationmodel('notif_product_title' , 'notif_product_content_add' , 'notif_type_0' ,
                    $this->getsession()->getuser()->getUserId() , '/products/edit/'.$product->getproduct_id() , $product->getproduct_name());
                $notification->save();
                $msg = $this->getLang()->feed_msg('msg_success_add', [$_POST['product_name']]);
                $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                $this->redirect('/products');
            } catch (\PDOException $e) {
                if ($product->productexist()) {
                    $msg = $this->getLang()->feed_msg('msg_error_exist', [$_POST['product_name']]);
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
            $product_id = $this->_params['0'];
            $oldproduct = Productmodel::getByPK($product_id , ' join products_categories on products_categories.category_id = products.category_id ');

            if (!empty($oldproduct) && !is_a($oldproduct, 'Productmodel')) {

// load every file language
                $this->getLang()->load('products', 'edit');
                $this->getLang()->load('products', 'label');
                $this->getLang()->load('products', 'msgs');
                $this->getLang()->load('products', 'units');
                $this->getLang()->load('validation', 'errors');
// load every file language

                $this->_data['product'] = $oldproduct; // make $productcategory to use in html edit.view
                $this->_data['categories'] = ProductsCategorymodel::getAll();

                if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation, $_POST)) {
                    try {
                        $opject_old = serialize($oldproduct);
                        $oldproduct->setobject($_POST['category_id'], $_POST['product_name'], $_POST['BuyPrice'], $_POST['SellPrice'], $_POST['unit']);
                        $oldproduct->save();

                        $notification = new notificationmodel('notif_product_title' , 'notif_product_content_edit' , 'notif_type_1' ,
                            $this->getsession()->getuser()->getUserId() , '/products/edit/'.$oldproduct->getproduct_id() , $oldproduct->getproduct_name());
                        $notification->setObject($opject_old);
                        $notification->save();

                        $msg = $this->getLang()->feed_msg('msg_success_edit', [$_POST['product_name']]);
                        $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                        $this->redirect('/products');
                    } catch (\PDOException $e) {

                        if ($oldproduct->productexist()) { // اذا كان اسم القسم هذا موجود وهذا سبب الخطا
                            $msg = $this->getLang()->feed_msg('msg_error_exist', [$_POST['product_name']]);
                            $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                        } else { // اذا كان الخطا شئ اخر
                            $this->getmsg()->addMsg($this->getLang()->get('msg_error_edit'), Messenger::Msg_error);
                        }
                        var_dump($e->getMessage());
                    }
                }

                $this->view();

            } else {
                $this->redirect('/products');
            } /* is product category not found by id */

        } else {
            $this->redirect('/products');
        } /*if not found param[0] /category/edit/12*/
    }

    public function deleteAction()
    {
        /* اذا لم يكن يوجود بارام اي id في اللينك او لم يكن لينك جاء منه اي كتب اللينك بصوره مباشره يتم رجوعي الي صفحه الكاتيجوري الرئيسيه*/
        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) == '/products') {

            $this->getLang()->load('products', 'msgs'); /* استدعاء فايل اللغه الخاص بالرسائل النجاح او الخطأ */
            $product_id = $this->_params['0'];
            $product = Productmodel::getByPK($product_id , ' join products_categories on products_categories.category_id = products.category_id ');
            if (!empty($product)) {
                try {
                    $opject_old = serialize($product);
                    $product->delete();

                    $notification = new notificationmodel('notif_product_title' , 'notif_product_content_delete' , 'notif_type_2' ,
                        $this->getsession()->getuser()->getUserId() , '' , $product->getproduct_name());
                    $notification->setObject($opject_old);
                    $notification->save();

                    $msg = $this->getLang()->feed_msg('msg_success_delete', [$product->getproduct_name()]);
                    $this->getmsg()->addMsg($msg, Messenger::Msg_success);

                } catch (\PDOException $e) {
                    $msg = $this->getLang()->get('msg_error_delete');
                    $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                }
            }

        }
        $this->redirect('/products');
    }

    public function getproductAction()
    {
        $this->getLang()->load('purchases', 'type');
        $this->getLang()->load('purchases', 'label');

        $count_good = $this->getLang()->get('valid_msg');
        $count_empty = $this->getLang()->get('Text_label_product_count_add');
        $count_error = $this->getLang()->get('invalid_msg_add_product_count');


        $product_name = $this->getLang()->get('Text_show_product_name');
        $product_quantity = $this->getLang()->get('Text_show_product_quantity');
        $product_allow_count = $this->getLang()->get('Text_show_allow_count');
        $product_price = $this->getLang()->get('Text_show_product_price');

        $class = '';
        $max = '';

        if (isset($_POST['product_id_add']) && is_numeric($_POST['product_id_add'])) {
            $product = Productmodel::getAllproduct(filter_var($_POST['product_id_add'], FILTER_SANITIZE_NUMBER_INT))[0];

            if (!empty($product)) {

                if (isset($_SERVER['HTTP_REFERER'])) {
                    $url = trim(parse_url($_SERVER['HTTP_REFERER'] , PHP_URL_PATH ) , '/');
                   $url = explode('/' , $url , '2');
                    if($url[0]  == 'sales'){
                        $max = "max = $product->count ";
                        $class = 'sales';
                    }
                }

                echo '<div class="row product_plus" data-id=' . $product->getproduct_id() . '>
                        <div class="form-group col-md-2"> <!-- product_name -->
                            <label for="payment_type"
                                   class="active" id="product_name">' . $product_name . '</label>
                            <input type="text" name="product_name_add" class="form-control" required readonly disabled value="' . $product->getproduct_name() . '">
                            <input type="text" name="product_id_add[]" class="form-control" required readonly hidden value="' . $product->getproduct_id() . '">
                        </div>
                        <div class="form-group flex-column col-md-3 "> <!-- count_add -->
                            <label for="payment_type"
                                   class="active" id="product_count">' . $product_quantity . '</label>
                            <input type="number" name="product_count_add[]" class=" product_count_add '.$class.' form-control" required min="1" '.$max.'  autocomplete="off"  >
                                    <div class="valid-feedback">' . $count_good . ' </div>
                                    <div class="invalid-feedback" data-temp="' . $count_error . '" data-old="' . $count_empty . '" ></div>
                        </div>
                        <div class="allow_count col-md-2">
                                    <label class="active">' . $product_allow_count . '</label>
                                   <p> ' . $product->count . ' </p>
                        </div>
                        <div class="form-group col-md-2 "> <!-- product_price -->
                            <label for="payment_type"
                                   class="active" id="product_price">' . $product_price . '</label>
                            <input type="text" name="product_price_add[]" class="form-control" required readonly disabled value="' . $product->getBuyPrice() . '">
                        </div>
                         <div class="btn btn-rounded closeproduct text-danger"><i class="fa fa-times"></i></div>
             </div>';

            }
        }


    }

}
