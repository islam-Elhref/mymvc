<?php

namespace MYMVC\MODELS;


use MYMVC\LIB\Database\DatabaseHandler;
use \pdo;
use \PDOStatement;

class AbstractModel
{

    const DATA_TYPE_STR = pdo::PARAM_STR;
    const DATA_TYPE_int = pdo::PARAM_INT;
    const DATA_TYPE_bool = pdo::PARAM_BOOL;
    const DATA_TYPE_float = 55 ;


    /**
     * يتم استكمال الاستعلام عن طريق اخذ الاسكيما الخاصه بالجدول ثم تجميعهم في استعلام واحد كل
     * name =:name , age=:age
     * ثم عمل ترم لحذف الفاصله في اخر الاستعلام
     * @return string
     */
    private static function sqlParam(){
        $sqlParam = '';
        foreach (static::$table_schema as  $name => $type ){
            $sqlParam .= "{$name} = :{$name} , ";
        }
        return trim($sqlParam , ', ');
    }

    /**
     * ياخذ الاستعلام المكون عن طريق سكول بارام الداله السابقه ثم عمل لوب للاسكيما الخاصه بالجدول
     * نحصل علي القيمه حيث ان في كل موديل يجب ان يتم تعريف متغير لكل عنصر في الاسكيما الخاصه بالجدول
     * يتم استخدام باند بارام لكل عنصر في الجدول لالحاقه ولكن لالحاقه بالقيمه الخاصه به يجب ان يتواجد الاستعلام الاساسي
     *
     * @param PDOStatement $stmt
     */
    private function bindParams(PDOStatement $stmt){
        foreach (static::$table_schema as $name => $type){
            $value = $this->$name;

            if ($type == 55){
                $float_value = filter_var($value , FILTER_SANITIZE_NUMBER_FLOAT , FILTER_FLAG_ALLOW_FRACTION);
                $stmt->bindValue(":{$name}" , $float_value );
            }else{
                $stmt->bindValue(":{$name}" , $value , $type );
            }

        }

    }

    public static function getAll()
    {

        $sql = 'SELECT * FROM ' . static::$tableName;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        if (method_exists(get_called_class(), '__construct')) {
            $result = $stmt->fetchAll(pdo::FETCH_CLASS | pdo::FETCH_PROPS_LATE, get_called_class(), static::$table_schema);
        } else {
            $result = $stmt->fetchAll(pdo::FETCH_CLASS, get_called_class());
        }

        if (is_array($result) && !empty($result)) {
            return $result;
        }

    }

    public static function getByPK($PK)
    {
        if (!empty($PK) && trim($PK) != '') {

            $sql = 'select * from ' . static::$tableName . ' where ' . static::$primaryKey . "=:" . static::$primaryKey;
            $stmt = DatabaseHandler::factory()->prepare($sql);

            if (method_exists(get_called_class(), '__construct')) {
                $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_called_class(), static::$table_schema);
            } else {
                $stmt->setFetchMode(pdo::FETCH_CLASS, get_called_class());
            }

            $stmt->bindValue(':' . static::$primaryKey, $PK);
            $stmt->execute();
            $result = $stmt->fetch();
            if (is_a($result, get_called_class()) && !empty($result)) {
                return $result;
            }

        }
    }

    private function update(){
        $sql = 'update '.static::$tableName . ' SET ' . self::sqlParam() . ' where ' . static::$primaryKey . '=:'.static::$primaryKey;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->bindParams($stmt);
        $stmt->bindValue(":" . static::$primaryKey, $this->{static::$primaryKey});
        return $stmt->execute();
    }

    private function create()
    {

        $sql = 'insert into ' . static::$tableName . ' set ' . self::sqlParam() ;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->bindParams($stmt);
        return $stmt->execute();

    }

    public function save(){
        if ($this->{static::$primaryKey} == null){
            $this->create();
        }else{
            $this->update();
        }
    }

    public function delete(){
        $sql = 'DELETE FROM ' . static::$tableName . ' WHERE ' . static::$primaryKey .'=:'.static::$primaryKey;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->bindValue(":" . static::$primaryKey, $this->{static::$primaryKey});
        $stmt->execute();
    }


}