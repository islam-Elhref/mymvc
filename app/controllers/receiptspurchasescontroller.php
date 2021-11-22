<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\Messenger;
use MYMVC\MODELS\Productmodel;
use MYMVC\MODELS\ProductsCategorymodel;
use MYMVC\MODELS\PurchasesBillsModel;
use MYMVC\MODELS\purchasesordersModel;
use MYMVC\MODELS\PurchasesReceiptModel;
use MYMVC\MODELS\suppliersmodel;

class receiptspurchasescontroller extends AbstractController
{


    private $rule_for_validation = [
        "bill_id" => 'req|int',
        "receipt_price" => 'req|num',
        "reciept_literal_price" => 'req|alpha',
        "reciept_type" => 'req|int',
    ];

    public function defaultAction()
    {
        $this->getLang()->load('receiptspurchases', 'default');

        $this->_data['receiptspurchases'] = PurchasesReceiptModel::getAll_receiptspurchases();
        $this->view();
    }

    public function addAction()
    {

        $this->getLang()->load('receiptspurchases', 'add');
        $this->getLang()->load('receiptspurchases', 'label');
        $this->getLang()->load('receiptspurchases', 'msgs');
        $this->getLang()->load('receiptspurchases', 'type');
        $this->getLang()->load('validation', 'errors');

        $purchases_bill = $this->_data['purchases'] = PurchasesBillsModel::getAll_purchases(false, true);

        if (isset($_POST['reciept_type']) && $_POST['reciept_type'] == '2') {
            $this->rule_for_validation = [
                "bill_id" => 'req|int',
                "receipt_price" => 'req|num',
                "reciept_literal_price" => 'req|alpha',
                "reciept_type" => 'req|int',
                "bank_name" => 'req|alpha',
                "bank_account_number" => 'req|num',
                "check_number" => 'req|num',
                "transferedto" => 'req|alphanum',
            ];
        }


        if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit']) && $this->is_valid($this->rule_for_validation, $_POST)) {
            $new_recept = new PurchasesReceiptModel($_POST['bill_id'], $this->getsession()->getuser()->getUserId(), $_POST['receipt_price'], $_POST['reciept_literal_price'], $_POST['reciept_type']);

            if ($new_recept->getreciept_type() == '2') {
                $new_recept->setreciept_bank($_POST['bank_name'], $_POST['bank_account_number'], $_POST['check_number'], $_POST['transferedto']);
            }

            try {
                $purchases_bill = PurchasesBillsModel::getAll_purchases($new_recept->getbill_id())[0];

                if ((int)$purchases_bill->finalorderprice - (int)$purchases_bill->receiptpayprice < (int)$new_recept->getreceipt_price()) {
                    $msg = $this->getLang()->feed_msg('msg_error_add_price_max', [$new_recept->getReceiptId()]);
                    $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                    throw new \PDOException('');
                }
                if ($new_recept->save()) {
                    if ((int)$purchases_bill->getfinalorderprice() == (int)$new_recept->getreceipt_price() + $purchases_bill->receiptpayprice) {
                        $purchases_bill->setPaymentStatus(1);
                        $purchases_bill->save();
                    }
                }
                $msg = $this->getLang()->feed_msg('msg_success_add', [$new_recept->getReceiptId()]);
                $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                $this->redirect('/receiptspurchases');
            } catch (\PDOException $e) {
                $this->getmsg()->addMsg($this->getLang()->get('msg_error_edit') . $e->getMessage(), Messenger::Msg_error);
            }
        }

        $this->view();
    }


    public function deleteAction()
    {
        /* اذا لم يكن يوجود بارام اي id في اللينك او لم يكن لينك جاء منه اي كتب اللينك بصوره مباشره يتم رجوعي الي صفحه الكاتيجوري الرئيسيه*/
        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) == '/receiptspurchases') {

            $this->getLang()->load('receiptspurchases', 'msgs'); /* استدعاء فايل اللغه الخاص بالرسائل النجاح او الخطأ */
            $Receipt_id = $this->_params['0'];
            $PurchasesReceipt = PurchasesReceiptModel::getByPK($Receipt_id);

            if (!empty($PurchasesReceipt)) {
                $purchases_bill = PurchasesBillsModel::getByPK($PurchasesReceipt->getbill_id());

                try {
                    if (!empty($purchases_bill)) {
                        if ($PurchasesReceipt->delete()) {
                            $purchases_bill->setPaymentStatus(0);
                            $purchases_bill->save();
                        }

                        $msg = $this->getLang()->feed_msg('msg_success_delete', [$PurchasesReceipt->getReceiptId()]);
                        $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                    }

                } catch (\PDOException $e) {
                    $msg = $this->getLang()->get('msg_error_delete');
                    $this->getmsg()->addMsg($e->getMessage(), Messenger::Msg_error);
                }
            }

        }
        $this->redirect('/receiptspurchases');
    }

    public function get_priceAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_REFERER'])) {
            $id = $this->filterInt($_POST['bill_id']);
            $PurchasesBills = PurchasesBillsModel::getpurchases_bill($id);
            if (!empty($PurchasesBills) && $PurchasesBills != false) {
                echo $PurchasesBills->getfinalorderprice() - $PurchasesBills->receiptpayprice;
            }
        }
    }

}
