<?php

namespace MYMVC\CONTROLLERS;

use MYMVC\LIB\Messenger;
use MYMVC\MODELS\Productmodel;
use MYMVC\MODELS\ProductsCategorymodel;
use MYMVC\MODELS\SalesBillsModel;
use MYMVC\MODELS\salesordersModel;
use MYMVC\MODELS\SalesReceiptModel;
use MYMVC\MODELS\suppliersmodel;

class receiptssalescontroller extends AbstractController
{


    private $rule_for_validation = [
        "bill_id" => 'req|int',
        "receipt_price" => 'req|num',
        "reciept_literal_price" => 'req|alpha',
        "reciept_type" => 'req|int',
    ];

    public function defaultAction()
    {
        $this->getLang()->load('receiptssales', 'default');

        $this->_data['receiptssales'] = SalesReceiptModel::getAll_receiptssales();
        $this->view();
    }

    public function addAction()
    {

        $this->getLang()->load('receiptssales', 'add');
        $this->getLang()->load('receiptssales', 'label');
        $this->getLang()->load('receiptssales', 'msgs');
        $this->getLang()->load('receiptssales', 'type');
        $this->getLang()->load('validation', 'errors');

        $sales_bill = $this->_data['sales'] = SalesBillsModel::getAll_sales(false, true);

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
            $new_recept = new SalesReceiptModel($_POST['bill_id'], $this->getsession()->getuser()->getUserId(), $_POST['receipt_price'], $_POST['reciept_literal_price'], $_POST['reciept_type']);
            if ($new_recept->getreciept_type() == '2') {
                $new_recept->setreciept_bank($_POST['bank_name'], $_POST['bank_account_number'], $_POST['check_number'], $_POST['transferedto']);
            }
            try {
                $sales_bill = SalesBillsModel::getAll_sales($new_recept->getbill_id())[0];
                if ((int)$sales_bill->finalorderprice - (int)$sales_bill->receiptpayprice < (int)$new_recept->getreceipt_price()) {
                    $msg = $this->getLang()->feed_msg('msg_error_add_price_max', [$new_recept->getReceiptId()]);
                    $this->getmsg()->addMsg($msg, Messenger::Msg_error);
                    throw new \PDOException('');
                }

                if ($new_recept->save()) {
                    if ((int)$sales_bill->getfinalorderprice() == (int)$new_recept->getreceipt_price() + $sales_bill->receiptpayprice) {
                        $sales_bill->setPaymentStatus(1);
                        $sales_bill->save();
                    }
                }
                $msg = $this->getLang()->feed_msg('msg_success_add', [$new_recept->getReceiptId()]);
                $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                $this->redirect('/receiptssales');
            } catch (\PDOException $e) {
                $this->getmsg()->addMsg($this->getLang()->get('msg_error_edit') . $e->getMessage(), Messenger::Msg_error);
            }
        }

        $this->view();
    }


    public function deleteAction()
    {
        /* اذا لم يكن يوجود بارام اي id في اللينك او لم يكن لينك جاء منه اي كتب اللينك بصوره مباشره يتم رجوعي الي صفحه الكاتيجوري الرئيسيه*/
        if (isset($this->_params[0]) && is_numeric($this->_params[0]) && isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) == '/receiptssales') {

            $this->getLang()->load('receiptssales', 'msgs'); /* استدعاء فايل اللغه الخاص بالرسائل النجاح او الخطأ */
            $Receipt_id = $this->_params['0'];
            $SalesReceipt = SalesReceiptModel::getByPK($Receipt_id);

            if (!empty($SalesReceipt)) {
                $sales_bill = SalesBillsModel::getByPK($SalesReceipt->getbill_id());

                try {
                    if (!empty($sales_bill)) {
                        if ($SalesReceipt->delete()) {
                            $sales_bill->setPaymentStatus(0);
                            $sales_bill->save();
                        }

                        $msg = $this->getLang()->feed_msg('msg_success_delete', [$SalesReceipt->getReceiptId()]);
                        $this->getmsg()->addMsg($msg, Messenger::Msg_success);
                    }

                } catch (\PDOException $e) {
                    $msg = $this->getLang()->get('msg_error_delete');
                    $this->getmsg()->addMsg($e->getMessage(), Messenger::Msg_error);
                }
            }

        }
        $this->redirect('/receiptssales');
    }

    public function get_priceAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_REFERER'])) {
            $id = $this->filterInt($_POST['bill_id']);
            $SalesBills = SalesBillsModel::getsales_bill($id);
            if (!empty($SalesBills) && $SalesBills != false) {
                echo $SalesBills->getfinalorderprice() - $SalesBills->receiptpayprice;
            }
        }
    }

}
