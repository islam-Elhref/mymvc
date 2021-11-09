<?php
namespace MYMVC\MODELS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Messenger;
use MYMVC\LIB\Language;

class purchasesordersModel extends AbstractModel{
    use filter;

    protected static $tableName = 'purchases_orders' ;
    protected static $primaryKey = 'order_id';

    protected $order_id  , $purchases_bill_id , $product_id , $order_quantity , $order_price ;

    protected static $table_schema = [
        'purchases_bill_id'  => self::DATA_TYPE_int ,
        'product_id'  => self::DATA_TYPE_int ,
        'order_quantity'  => self::DATA_TYPE_int ,
        'order_price'  => self::DATA_TYPE_float ,
    ];

    public function __construct( $purchases_bill_id , $product_id , $order_quantity , $buyprice  )
    {
        $this->purchases_bill_id     = $this->filterInt($purchases_bill_id);
        $this->product_id            = $this->filterInt($product_id);
        $this->order_quantity        = $this->filterInt($order_quantity);
        $this->order_price           = $order_quantity * $buyprice ;
    }


    public function getpurchases_bill_id()
    {
        return $this->purchases_bill_id;
    }
    public function getproduct_id()
    {
        return $this->product_id;
    }
    public function getorder_quantity()
    {
        return $this->order_quantity;
    }
    public function getorder_price()
    {
        return $this->order_price;
    }

    public function deleteproduct($id){
        if ($id != null || $id != ''){
            $productexist = self::getByPK($id);
            if (!empty($productexist)){
                $productexist->delete();
            }
        }
    }

    public function productexist(){
        if ($this->product_name != null || $this->product_name != ''){
            $productexist = self::getone(['product_name' => $this->product_name]);
            if (!empty($productexist) && $this->product_id != $productexist->product_id  ){
                return true ;
            }
        }
    }


}