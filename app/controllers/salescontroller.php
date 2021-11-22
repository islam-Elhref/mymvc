<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\Messenger;
use MYMVC\MODELS\Productmodel;
use MYMVC\MODELS\ProductsCategorymodel;
use MYMVC\MODELS\salesBillsModel;
use MYMVC\MODELS\salesordersModel;
use MYMVC\MODELS\clientsmodel;

class salescontroller extends AbstractController
{


    private $rule_for_validation = [
        "client_id" => 'req|int',
        "payment_type" => 'req|int',
        "product_id_add" => 'req|int',
        "product_count_add" => 'req|int',
//        "payment_status" => 'req|int',
    ];

    public function defaultAction()
    {
        $this->getLang()->load('sales', 'default');
        $this->getLang()->load('sales', 'type');

        $this->_data['sales'] = salesBillsModel::getAll_sales();
        $this->view();
    }

    public function addAction()
    {

        $this->getLang()->load('sales', 'add');
        $this->getLang()->load('sales', 'label');
        $this->getLang()->load('sales', 'msgs');
        $this->getLang()->load('sales', 'type');
        $this->getLang()->load('validation', 'errors');

        $this->_data['clients'] = clientsmodel::getAll();
        $this->_data['products'] = Productmodel::getAllproduct();

        if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation, $_POST)) {
            $array_product = [];
            $id = [];
            $check = true;
            for ($i = 0, $ii = count($_POST['product_id_add']); $i < $ii; $i++) {
                if ($_POST['product_id_add'][$i] != '' && $_POST['product_count_add'][$i] != '' && !in_array($_POST['product_id_add'][$i], $id)) {

                    $product = Productmodel::getAllproduct(filter_var($_POST['product_id_add'][$i], FILTER_SANITIZE_NUMBER_INT))[0];

                    if ($product->count >= $_POST['product_count_add'][$i] ){
                        $array_product[] = [$_POST['product_count_add'][$i], $product];
                    }else{
                        $check = false ;
                        $this->getmsg()->addMsg($this->getLang()->feed_msg('msg_error_edit_product_count' , [$product->getproduct_name() , $product->count ]  ) , Messenger::Msg_error);
                    }
                        $id[] = $_POST['product_id_add'][$i];
                }
            }

            if (!empty($array_product) && $check == true ) {
                $sales_bill = new salesBillsModel($_POST['client_id'], $_POST['payment_type'], $this->getsession()->getuser()->getUserId());
                try {
                    if ($sales_bill->save() == true) {
                        foreach ($array_product as $onearray) {
                            $count = $onearray[0];
                            $product = $onearray[1];
                            $sales_orders = new salesordersModel($sales_bill->getbill_id(), $product->getproduct_id(), $count, $product->getBuyPrice());
                            $sales_orders->save();
                        }
                        $msg = $this->getLang()->feed_msg('msg_success_add', [$sales_bill->getbill_id()]);
                        $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                    }

                } catch (\PDOException $e) {
                    $this->getmsg()->addMsg($this->getLang()->get('msg_error_edit') . $e->getMessage(), Messenger::Msg_error);
                }
                $this->redirect('/sales');
            }
        }

        $this->view();
    }

    public function editAction()
    {

        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER'])) {
            $salesBills_id = $this->_params['0'];
            $oldsale = salesBillsModel::getByPK($salesBills_id);

            if (!empty($oldsale) && !is_a($oldsale, 'salesBillsModel')) {

// load every file language
                $this->getLang()->load('sales', 'edit');
                $this->getLang()->load('sales', 'label');
                $this->getLang()->load('sales', 'msgs');
                $this->getLang()->load('sales', 'type');
                $this->getLang()->load('validation', 'errors');
// load every file language

                $this->_data['sale'] = $oldsale; // make $sale to use in html edit.view
                $this->_data['clients'] = clientsmodel::getAll();
                $this->_data['products'] = Productmodel::getAll();
                $sale_orders = $this->_data['sale_orders'] = salesordersModel::getmore(['sales_bill_id' => $oldsale->getbill_id()],
                    'JOIN products ON products.product_id = sales_orders.product_id');

                $old_order_product = [];
                if (!empty($sale_orders)) {
                    foreach ($sale_orders as $order) {
                        $old_order_product[$order->getproduct_id()] = $order->getorder_quantity();
                    }
                }


                if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation, $_POST)) {
                    $orderproductIdToBeDeleted = array_diff(array_keys($old_order_product), $_POST['product_id_add']);
                    $orderproductIdToBecreated = array_diff($_POST['product_id_add'], array_keys($old_order_product));
                    $orderproductIdToBeedit = array_diff($_POST['product_id_add'], $orderproductIdToBecreated);

                    $tempcreated = [];
                    $tempedit = [];
                    $id = [];
                    $check = true ;
                    $price_receipt = [] ;

                    for ($i = 0, $ii = count($_POST['product_id_add']); $i < $ii; $i++) {
                        if ($_POST['product_id_add'][$i] != '' && $_POST['product_count_add'][$i] != '' && !in_array($_POST['product_id_add'][$i], $id)) {

                            $product = Productmodel::getAllproduct(filter_var($_POST['product_id_add'][$i], FILTER_SANITIZE_NUMBER_INT))[0];

                            if (in_array($_POST['product_id_add'][$i], $orderproductIdToBecreated)) {

                                if ($product->count >= $_POST['product_count_add'][$i] ){
                                    $tempcreated[] = [$_POST['product_count_add'][$i], $product];

                                }else{
                                    $check = false ;
                                    $this->getmsg()->addMsg($this->getLang()->feed_msg('msg_error_edit_product_count' , [$product->getproduct_name() , $product->count ]  ) , Messenger::Msg_error);
                                }
                                $price_receipt [] = $product->getsellPrice() * $_POST['product_count_add'][$i] ;
                                $id[] = $_POST['product_id_add'][$i];
                            }
                            if (in_array($_POST['product_id_add'][$i], $orderproductIdToBeedit)) {
                                if ($old_order_product[$_POST['product_id_add'][$i]] != $_POST['product_count_add'][$i]) {

                                    $max = $product->count + $old_order_product[$_POST['product_id_add'][$i]] ;

                                    if ($max >= $_POST['product_count_add'][$i] ){
                                        $tempedit[] = [$_POST['product_count_add'][$i], $product];
                                    }else{
                                        $check = false ;
                                        $this->getmsg()->addMsg($this->getLang()->feed_msg('msg_error_edit_product_count' , [$product->getproduct_name() , $max ]  ) , Messenger::Msg_error);
                                    }

                                }
                                $price_receipt [] = $product->getsellPrice() * $_POST['product_count_add'][$i] ;
                                $id[] = $_POST['product_id_add'][$i];
                            }
                        }
                    }
                    $orderproductIdToBecreated = $tempcreated;
                    $orderproductIdToBeedit = $tempedit;



                    if ($check == true){
                        try {
                            $sales_bill = new salesBillsModel($_POST['client_id'], $_POST['payment_type'], $this->getsession()->getuser()->getUserId());
                            $sales_bill->setbill_id($oldsale->getbill_id());

                            $sales_bill_receipt = salesBillsModel::getsales_bill($oldsale->getbill_id()) ;
                            $check_price_receipt = 0;
                            foreach ($price_receipt as $price) {
                                $check_price_receipt += $price;
                            }

                            if($check_price_receipt <=  $sales_bill_receipt->receiptpayprice  ){
                                $msg = $this->getLang()->get('invalid_msg_max_receipt_price') ;
                                throw new \PDOException($msg);
                            }
                            if($check_price_receipt >  $sales_bill_receipt->receiptpayprice  ){
                                $sales_bill->setPaymentStatus(0);
                            }

                            if ($sales_bill->save() == true) {
                                if (!empty($orderproductIdToBecreated)) {
                                    foreach ($orderproductIdToBecreated as $onearray) {
                                        $count = $onearray[0];
                                        $product = $onearray[1];
                                        $sales_orders = new salesordersModel($sales_bill->getbill_id(), $product->getproduct_id(), $count, $product->getBuyPrice());
                                        $sales_orders->save();
                                    }
                                }

                                if (!empty($orderproductIdToBeedit)) {
                                    foreach ($orderproductIdToBeedit as $onearray) {

                                        $count = $onearray[0];
                                        $product = $onearray[1];
                                        $sales_orders = salesordersModel::getonetest(['sales_bill_id' => $sales_bill->getbill_id(), 'product_id' => $product->getproduct_id()]);
                                        $sales_orders_edit = new salesordersModel($sales_bill->getbill_id(), $product->getproduct_id(), $count, $product->getBuyPrice());
                                        $sales_orders_edit->setorder_id($sales_orders->getorder_id());
                                        $sales_orders_edit->save();
                                    }
                                }

                                if (!empty($orderproductIdToBeDeleted)) {
                                    foreach ($orderproductIdToBeDeleted as $onearray) {
                                        $sales_orders = salesordersModel::getonetest(['sales_bill_id' => $sales_bill->getbill_id(), 'product_id' => $onearray]);
                                        $sales_orders->delete();
                                    }
                                }

                                $msg = $this->getLang()->feed_msg('msg_success_edit', [$sales_bill->getbill_id()]);
                                $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                            }
                            $this->redirect('/sales');
                        } catch (\PDOException $e) {
                            $this->getmsg()->addMsg($this->getLang()->get('msg_error_edit') . $e->getMessage(), Messenger::Msg_error);
                        }
                    }


                }

                $this->view();

            } else {
                $this->redirect('/sales');
            } /* is sales not found by id */

        } else {
            $this->redirect('/sales');
        } /*if not found param[0] /sales/edit/12*/
    }

    public function deleteAction()
    {
        /* اذا لم يكن يوجود بارام اي id في اللينك او لم يكن لينك جاء منه اي كتب اللينك بصوره مباشره يتم رجوعي الي صفحه الكاتيجوري الرئيسيه*/
        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) == '/sales') {

            $this->getLang()->load('sales', 'msgs'); /* استدعاء فايل اللغه الخاص بالرسائل النجاح او الخطأ */
            $sales_id = $this->_params['0'];
            $sales = salesBillsModel::getByPK($sales_id);
            if (!empty($sales)) {
                $sales_orders = salesordersModel::getWhere(['sales_bill_id' => $sales_id]);

                try {
                    $sales->delete();
                    $msg = $this->getLang()->feed_msg('msg_success_delete', [$sales->getbill_id()]);
                    $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                } catch (\PDOException $e) {
                    $msg = $this->getLang()->get('msg_error_delete');
                    $this->getmsg()->addMsg($e->getMessage(), Messenger::Msg_error);
                }
            }

        }
        $this->redirect('/sales');
    }

    public function printAction()
    {
        /* اذا لم يكن يوجود بارام اي id في اللينك او لم يكن لينك جاء منه اي كتب اللينك بصوره مباشره يتم رجوعي الي صفحه الكاتيجوري الرئيسيه*/
        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) == '/sales') {

            $this->getLang()->load('sales', 'msgs'); /* استدعاء فايل اللغه الخاص بالرسائل النجاح او الخطأ */
            $sales_id = $this->_params['0'];
            $sales = salesBillsModel::getAll_sales($sales_id)[0];
            if (!empty($sales)) {

                $view = array_intersect([':view' => 'view'], $this->_template->getTemplate());
                $this->_template->changeTemplate($view);

                // load every file language
                $this->getLang()->load('sales', 'print');
                $this->getLang()->load('sales', 'type');
// load every file language

                $this->_data['sale'] = $sales; // make $purchase to use in html edit.view
                $sales_orders = $this->_data['sales_orders'] = salesordersModel::getALLsalesOrders($sales->getbill_id());

                $this->view();

            }else{
                $this->redirect('/sales');
            }

        }else{
            $this->redirect('/sales');
        }
    }


}
