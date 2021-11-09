<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\Messenger;
use MYMVC\MODELS\Productmodel;
use MYMVC\MODELS\ProductsCategorymodel;
use MYMVC\MODELS\PurchasesBillsModel;
use MYMVC\MODELS\purchasesordersModel;
use MYMVC\MODELS\suppliersmodel;

class purchasescontroller extends AbstractController
{


    private $rule_for_validation = [
        "supplier_id" => 'req|int',
        "payment_type" => 'req|int',
        "product_id_add" => 'req|int',
        "product_count_add" => 'req|int',
//        "payment_status" => 'req|int',
    ];

    public function defaultAction()
    {
        $this->getLang()->load('purchases', 'default');
        $this->getLang()->load('purchases', 'type');

        $this->_data['purchases'] = PurchasesBillsModel::getAll_purchases();
        $this->view();
    }

    public function addAction()
    {

        $this->getLang()->load('purchases', 'add');
        $this->getLang()->load('purchases', 'label');
        $this->getLang()->load('purchases', 'msgs');
        $this->getLang()->load('purchases', 'type');
        $this->getLang()->load('validation', 'errors');
        
        $this->_data['suppliers'] = suppliersmodel::getAll();
        $this->_data['products'] = Productmodel::getAll();

        if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation, $_POST)) {
        $array_product = [];
        $id = [];
        for ($i=0 , $ii =count($_POST['product_id_add']) ; $i < $ii ; $i++  ){

            if ( $_POST['product_id_add'][$i] != '' && $_POST['product_count_add'][$i] != '' && !in_array($_POST['product_id_add'][$i] , $id )  ){
                $product = Productmodel::getByPK($_POST['product_id_add'][$i]);
                $array_product[] = [ $_POST['product_count_add'][$i] , $product ];
                $id[] = $_POST['product_id_add'][$i] ;
            }
        }

         if (!empty($array_product)){
                $purchases_bill = new PurchasesBillsModel($_POST['supplier_id'] , $_POST['payment_type'] , $this->getsession()->getuser()->getUserId() );
                try {
                    if ($purchases_bill->save() == true){
                        foreach ($array_product as  $onearray  ){
                            $count = $onearray[0];
                            $product = $onearray[1];
                            $purchases_orders = new purchasesordersModel($purchases_bill->getbill_id() , $product->getproduct_id() , $count , $product->getBuyPrice()  );
                            $purchases_orders->save();
                        }
                        $msg = $this->getLang()->feed_msg('msg_success_add', [$purchases_bill->getbill_id()]);
                        $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                    }

                } catch (\PDOException $e) {
                        $purchases_bill->deletePurchasesBills();
                        $this->getmsg()->addMsg($this->getLang()->get('msg_error_edit') . $e->getMessage(), Messenger::Msg_error);
                }
                $this->redirect('/purchases');
            }
        }

        $this->view();
    }

    public function editAction()
    {

        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER'])) {
            $PurchasesBills_id = $this->_params['0'];
            $oldpurchase = PurchasesBillsModel::getByPK($PurchasesBills_id);

            if (!empty($oldpurchase) && !is_a($oldpurchase, 'PurchasesBillsModel')) {

// load every file language
                $this->getLang()->load('purchases', 'edit');
                $this->getLang()->load('purchases', 'label');
                $this->getLang()->load('purchases', 'msgs');
                $this->getLang()->load('purchases', 'type');
                $this->getLang()->load('validation', 'errors');
// load every file language

                $this->_data['purchase'] = $oldpurchase; // make $purchase to use in html edit.view
                $this->_data['suppliers'] = suppliersmodel::getAll();
                $this->_data['products'] = Productmodel::getAll();
                $this->_data['purchase_orders'] = purchasesordersModel::getmore(['purchases_bill_id' => $oldpurchase->getbill_id() ],
                'JOIN products ON products.product_id = purchases_orders.product_id');

                if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation, $_POST)) {
                    var_dump($_POST);
                }

                $this->view();

            } else {
                $this->redirect('/purchases');
            } /* is purchases not found by id */

        } else {
            $this->redirect('/purchases');
        } /*if not found param[0] /purchases/edit/12*/
    }

    public function deleteAction()
    {
        /* اذا لم يكن يوجود بارام اي id في اللينك او لم يكن لينك جاء منه اي كتب اللينك بصوره مباشره يتم رجوعي الي صفحه الكاتيجوري الرئيسيه*/
        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) == '/purchases') {

            $this->getLang()->load('purchases', 'msgs'); /* استدعاء فايل اللغه الخاص بالرسائل النجاح او الخطأ */
            $purchases_id = $this->_params['0'];
            $purchases = PurchasesBillsModel::getByPK($purchases_id);
            if (!empty($purchases)) {
                $purchases_orders = purchasesordersModel::getWhere(['purchases_bill_id' =>  $purchases_id ]);

                try {
                    if (!empty($purchases_orders)){
                        foreach ($purchases_orders as $purchases_order){
                            $purchases_order->delete();
                        }
                    }
                    $purchases->delete();
                    $msg = $this->getLang()->feed_msg('msg_success_delete', [$purchases->getbill_id()]);
                    $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                } catch (\PDOException $e) {
                    $msg = $this->getLang()->get('msg_error_delete');
                    $this->getmsg()->addMsg($e->getMessage(), Messenger::Msg_error);
                }
            }

        }
        $this->redirect('/purchases');
    }

}
