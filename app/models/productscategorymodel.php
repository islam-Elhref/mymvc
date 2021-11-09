<?php
namespace MYMVC\MODELS;

use MYMVC\LIB\filter;
use MYMVC\LIB\Messenger;
use MYMVC\LIB\Language;

class ProductsCategorymodel extends AbstractModel{
    use filter;

    protected static $tableName = 'products_categories' ;
    protected static $primaryKey = 'category_id';

    protected $category_id , $category_name ;

    protected static $table_schema = [
        'category_name'  => self::DATA_TYPE_STR ,
    ];

    public function __construct( $category_name )
    {
        $this->category_name = $this->filterString($category_name);
    }

    public function getcategory_id()
    {
        return $this->category_id;
    }

    public function getcategory_name()
    {
        return $this->category_name;
    }

    public function setCategoryName($category_name): void
    {
        $this->category_name = $category_name;
    }


    public function deleteproductcategory($id){
        if ($id != null || $id != ''){
            $productcategoryexist = self::getByPK($id);
            if (!empty($productcategoryexist)){
                $productcategoryexist->delete();
            }
        }
    }

    public function productcategoryexist(){
        if ($this->category_name != null || $this->category_name != ''){
            $productcategoryexist = self::getone(['category_name' => $this->category_name]);
            if (!empty($productcategoryexist) && $this->category_id != $productcategoryexist->category_id  ){
                return true ;
            }
        }
    }


}