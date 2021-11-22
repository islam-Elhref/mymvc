<?php
namespace MYMVC\MODELS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Messenger;
use MYMVC\LIB\Language;

class Productmodel extends AbstractModel{
    use filter;

    protected static $tableName = 'products' ;
    protected static $primaryKey = 'product_id';

    protected $product_id  , $category_id , $category_name , $product_name , $BuyPrice , $SellPrice  , $unit ;

    protected static $table_schema = [
        'category_id'  => self::DATA_TYPE_int ,
        'product_name'  => self::DATA_TYPE_STR ,
        'BuyPrice'  => self::DATA_TYPE_float ,
        'SellPrice'  => self::DATA_TYPE_float ,
        'unit'  => self::DATA_TYPE_int ,
    ];

    public function __construct( $category_id , $product_name , $BuyPrice , $SellPrice  , $unit )
    {
        $this->category_id = $this->filterInt($category_id);
        $this->product_name = $this->filterString($product_name);
        $this->BuyPrice = $this->filterFloat($BuyPrice);
        $this->SellPrice = $this->filterFloat($SellPrice);
        $this->unit = $this->filterInt($unit);
    }
    public function setobject ($category_id , $product_name , $BuyPrice , $SellPrice  , $unit){
        $this->category_id = $this->filterInt($category_id);
        $this->product_name = $this->filterString($product_name);
        $this->BuyPrice = $this->filterFloat($BuyPrice);
        $this->SellPrice = $this->filterFloat($SellPrice);
        $this->unit = $this->filterInt($unit);
    }

    /**
     * @return int
     */
    public function getproduct_id()
    {
        return $this->product_id;
    }

    public function getproduct_name()
    {
        return $this->product_name;
    }


    public function getCategoryName()
    {
        return $this->category_name;
    }

    public function getcategory_id()
    {
        return $this->category_id;
    }
    

    public function getBuyPrice()
    {
        return $this->BuyPrice;
    }

    public function getSellPrice()
    {
        return $this->SellPrice;
    }

    public function getunit()
    {
        return $this->unit;
    }

    public static function getAllproduct($one_id = false)
    {
        $product_id = '';
        $where = '';
        if ($one_id != false && is_numeric($one_id)){
            $product_id = $one_id ;
            $where = 'WHERE P.product_id = '.$product_id;
        }else{
            $product_id = 'P.product_id' ;
        }

        return parent::getAll('SELECT p.* , pc.category_name , 
                                (
                                ( SELECT IFNULL( (SELECT SUM( purchases_orders.order_quantity )FROM purchases_orders WHERE purchases_orders.product_id = '.$product_id.')
                                 , 0 ) ) - 
                                ( SELECT IFNULL( (SELECT SUM( sales_orders.order_quantity )FROM sales_orders WHERE sales_orders.product_id = '.$product_id.' )
                                 , 0 ) )
                                ) AS count
                                FROM products p JOIN products_categories pc ON pc.category_id = p.category_id ' .$where);
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