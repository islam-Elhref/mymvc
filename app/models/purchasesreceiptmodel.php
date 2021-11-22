<?php

namespace MYMVC\MODELS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Messenger;
use MYMVC\LIB\Language;

class PurchasesReceiptModel extends AbstractModel
{
    use filter;

    protected static $tableName = 'purchases_receipt';
    protected static $primaryKey = 'receipt_id';

    protected $receipt_id, $bill_id, $user_id, $receipt_price, $reciept_literal_price, $reciept_type,
        $bank_name, $bank_account_number, $check_number, $transferedto, $date_of_receipt;

    protected static $table_schema = [
        'bill_id' => self::DATA_TYPE_int,
        'user_id' => self::DATA_TYPE_int,
        'receipt_price' => self::DATA_TYPE_float,
        'reciept_literal_price' => self::DATA_TYPE_STR,
        'reciept_type' => self::DATA_TYPE_int,
        'bank_name' => self::DATA_TYPE_STR,
        'bank_account_number' => self::DATA_TYPE_STR,
        'check_number' => self::DATA_TYPE_STR,
        'transferedto' => self::DATA_TYPE_STR,
        'date_of_receipt' => self::DATA_TYPE_STR,
    ];


    public function __construct($bill_id, $user_id, $receipt_price, $reciept_literal_price, $reciept_type)
    {
        $this->bill_id = $this->filterInt($bill_id);
        $this->user_id = $this->filterInt($user_id);
        $this->receipt_price = $this->filterInt($receipt_price);
        $this->reciept_literal_price = $this->filterString($reciept_literal_price);
        $this->reciept_type = $this->filterInt($reciept_type);
        $this->date_of_receipt = date('Y-m-d');
    }

    public function setreciept_bank($bank_name , $bank_account_number , $check_number , $transferedto)
    {
        $this->bank_name = $this->filterString($bank_name);
        $this->bank_account_number = $this->filterString($bank_account_number);
        $this->check_number = $this->filterString($check_number);
        $this->transferedto = $this->filterString($transferedto);
    }


    public function getReceiptId()
    {
        return $this->receipt_id;
    }
    public function setReceiptId($receipt_id)
    {
        $this->receipt_id = $receipt_id ;
    }

    public function getbill_id()
    {
        return $this->bill_id;
    }
    public function getuser_id()
    {
        return $this->user_id;
    }
    public function getreceipt_price()
    {
        return $this->receipt_price;
    }
    public function getreciept_literal_price()
    {
        return $this->reciept_literal_price;
    }
    public function getreciept_type()
    {
        return $this->reciept_type;
    }
    public function getdate_of_receipt()
    {
        return $this->date_of_receipt;
    }
    public function getfinalorderprice(){
        return $this->finalorderprice;
    }

    public static function getAll_receiptspurchases($id = false , $bill_id = false)
    {
        $where = '';
        $receipt_price = '';
        if ($id != false && is_numeric($id) ){
            $where = 'WHERE receipt_id = ' . $id ;
        }
        if ($bill_id != false && is_numeric($bill_id) ){
            $receipt_price = ',(SELECT SUM(purchases_receipt.receipt_price) FROM purchases_receipt WHERE purchases_receipt.bill_id = '.$receipt_id.' ) as oldreceipt';
        }

        return parent::getAll('SELECT purchases_receipt.* ,  users.username as username , 
        (SELECT SUM(purchases_orders.order_price) FROM purchases_orders WHERE purchases_orders.purchases_bill_id = purchases_receipt.bill_id ) as finalorderprice 
        '.$receipt_price.'
        FROM `purchases_receipt` 
        JOIN users ON users.user_id = purchases_receipt.user_id '.$where);
    }





}