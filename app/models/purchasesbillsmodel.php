<?php
namespace MYMVC\MODELS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Messenger;
use MYMVC\LIB\Language;

class PurchasesBillsModel extends AbstractModel{
    use filter;

    protected static $tableName = 'purchases_bills' ;
    protected static $primaryKey = 'bill_id';

    protected $bill_id  , $supplier_id , $payment_type , $payment_status , $user_id , $created  ;

    protected static $table_schema = [
        'supplier_id'  => self::DATA_TYPE_int ,
        'payment_type'  => self::DATA_TYPE_int ,
        'payment_status'  => self::DATA_TYPE_int ,
        'user_id'  => self::DATA_TYPE_int ,
        'created'  => self::DATA_TYPE_STR ,
    ];

    public function __construct( $supplier_id , $payment_type  , $user_id  )
    {
        $this->supplier_id = $this->filterInt($supplier_id);
        $this->payment_type = $this->filterInt($payment_type);
        $this->payment_status = 0;
        $this->user_id = $this->filterInt($user_id);
        $this->created = date('Y-m-d') ;
    }

    public function getbill_id(){
        return $this->bill_id;
    }
        public function getsupplier_id(){
        return $this->supplier_id;
    }

        public function getsuppliername(){
        return $this->suppliername;
    }

        public function getcountproduct(){
        return $this->countproduct;
        }
        public function getfinalorderprice(){
        return $this->finalorderprice;
        }

        public function getpayment_type(){
        return $this->payment_type;
    }
        public function getpayment_status(){
        return $this->payment_status;
    }
        public function getuser_id(){
        return $this->user_id;
    }
        public function getcreated(){
        return $this->created;
    }

    public static function getAll_purchases()
    {
        return parent::getAll('SELECT purchases_bills.* , suppliers.name as suppliername , users.username as username , 
(SELECT COUNT(*) FROM purchases_orders WHERE purchases_orders.purchases_bill_id = purchases_bills.bill_id ) as countproduct , (SELECT SUM(purchases_orders.order_price) FROM purchases_orders WHERE purchases_orders.purchases_bill_id = purchases_bills.bill_id ) as finalorderprice 
FROM `purchases_bills` 
JOIN suppliers ON suppliers.suppliers_id = purchases_bills.supplier_id 
JOIN users ON users.user_id = purchases_bills.user_id');
    }

    public function deletePurchasesBills($id){
        if ($id != null || $id != ''){
            $PurchasesBillsexist = self::getByPK($id);
            if (!empty($PurchasesBillsexist)){
                $PurchasesBillsexist->delete();
            }
        }
    }



}