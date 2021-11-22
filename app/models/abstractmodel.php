<?php

namespace MYMVC\MODELS;


use Exception;
use MYMVC\LIB\Database\DatabaseHandler;
use PDO;
use PDOException;
use PDOStatement;

class AbstractModel
{

    const DATA_TYPE_STR = pdo::PARAM_STR;
    const DATA_TYPE_int = pdo::PARAM_INT;
    const DATA_TYPE_bool = pdo::PARAM_BOOL;
    const DATA_TYPE_float = 55;


    /**
     * يتم استكمال الاستعلام عن طريق اخذ الاسكيما الخاصه بالجدول ثم تجميعهم في استعلام واحد كل
     * name =:name , age=:age
     * ثم عمل ترم لحذف الفاصله في اخر الاستعلام
     * @return string
     */
    private static function sqlParam()
    {
        $sqlParam = '';
        foreach (static::$table_schema as $name => $type) {
            $sqlParam .= "{$name} = :{$name} , ";
        }
        return trim($sqlParam, ', ');
    }

    /**
     * ياخذ الاستعلام المكون عن طريق سكول بارام الداله السابقه ثم عمل لوب للاسكيما الخاصه بالجدول
     * نحصل علي القيمه حيث ان في كل موديل يجب ان يتم تعريف متغير لكل عنصر في الاسكيما الخاصه بالجدول
     * يتم استخدام باند بارام لكل عنصر في الجدول لالحاقه ولكن لالحاقه بالقيمه الخاصه به يجب ان يتواجد الاستعلام الاساسي
     *
     * @param PDOStatement $stmt
     */
    private function bindParams(PDOStatement $stmt)
    {
        foreach (static::$table_schema as $name => $type) {
            $value = $this->$name;

            if ($type == 55) {
                $float_value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $stmt->bindValue(":{$name}", $float_value);
            } else {
                $stmt->bindValue(":{$name}", $value, $type);
            }

        }

    }

    public static function getAll($sql = '')
    {
        if ($sql == '') {
            $sql = 'SELECT * FROM ' . static::$tableName;
        }

        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        if (method_exists(get_called_class(), '__construct')) {
            $result = $stmt->fetchAll(pdo::FETCH_CLASS | pdo::FETCH_PROPS_LATE, get_called_class(), static::$table_schema);
        } else {
            $result = $stmt->fetchAll(pdo::FETCH_CLASS, get_called_class());
        }

        if (is_array($result) && !empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @param array $array
     * @return $this | false
     */
    public static function getByPK($PK , $join = '')
    {
        if (!empty($PK) && trim($PK) != '') {

            $sql_join = '' ;
            if ($join != ''){
                $sql_join = ' ' . $join . ' ';
            }

            $sql = 'select * from ' . static::$tableName . $sql_join .  ' where ' . static::$primaryKey . "=:".static::$primaryKey;
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
            } else {
                return false;
            }

        }
        return false;
    }


    private function update()
    {
        $sql = 'update ' . static::$tableName . ' SET ' . self::sqlParam() . ' where ' . static::$primaryKey . '=:' . static::$primaryKey;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->bindParams($stmt);
        $stmt->bindValue(":" . static::$primaryKey, $this->{static::$primaryKey});
        if ($stmt->execute()){
            return true;
        }
        return false;
    }

    private function create()
    {
        $sql = 'insert into ' . static::$tableName . ' set ' . self::sqlParam();
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->bindParams($stmt);
        if ($stmt->execute()) {
            $this->{static::$primaryKey} = DatabaseHandler::factory()->lastInsertId();
            return true;
        }
        return false;
    }

    public function save($checkPrimaryKey = true)
    {
        if ($checkPrimaryKey == false ){
            return $this->create();
        }else{
            if ($this->{static::$primaryKey} == null) {
               return $this->create();
            } else {
                return $this->update();
            }
        }

    }

    public static function getWhere(array $array)
    {
        $whereCond = [];

        $column = array_keys($array);
        $value = array_values($array);

        for ($i = 0, $ii = count($column); $i < $ii; $i++) {
            $whereCond[] = $column[$i] . '=' . $value[$i];
        }
        $whereCond = implode(' And ', $whereCond);

        $sql = 'SELECT * FROM ' . static::$tableName . ' where ' . $whereCond;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->execute();
        if (method_exists(get_called_class(), '__construct')) {
            $result = $stmt->fetchAll(pdo::FETCH_CLASS | pdo::FETCH_PROPS_LATE, get_called_class(), static::$table_schema);
        } else {
            $result = $stmt->fetchAll(pdo::FETCH_CLASS, get_called_class());
        }

        if (!empty($result) && is_a($result[0], get_called_class())) {
            return new \ArrayIterator($result);
        } else {
            return false;
        }
    }

    /**
     * @param array $array
     * @return static
     */
    public static function getone(array $array)
    {
        $whereCond = [];

        $column = array_keys($array);
        $value = array_values($array);

        for ($i = 0, $ii = count($column); $i < $ii; $i++) {
            $whereCond[] = $column[$i] . '=' . "'" . $value[$i] . "'";
        }
        $whereCond = implode(' And ', $whereCond);

        $sql = 'SELECT * FROM ' . static::$tableName . ' where ' . $whereCond;


        $stmt = DatabaseHandler::factory()->prepare($sql);

        if (method_exists(get_called_class(), '__construct')) {
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_called_class(), static::$table_schema);
        } else {
            $stmt->setFetchMode(pdo::FETCH_CLASS, get_called_class());
        }

        $stmt->execute();
        $result = $stmt->fetch();

        if (is_a($result, get_called_class()) && !empty($result)) {
            return $result;;
        } else {
            return false;
        }
    }

    public function delete()
    {
        $sql = 'DELETE FROM ' . static::$tableName . ' WHERE ' . static::$primaryKey . '=:' . static::$primaryKey;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $stmt->bindValue(":" . static::$primaryKey, $this->{static::$primaryKey});

        return $stmt->execute();
    }


    /**
     * @param array $array
     * @return $this | false
     */
    public static function getonetest(array $array , $join = '')
    {
        $whereCond = [];

        $column = array_keys($array);
        $values = array_values($array);

        for ($i = 0, $ii = count($column); $i < $ii; $i++) {
            $whereCond[] = $column[$i] . '=' . ":" . $column[$i] . "";
        }

        $whereCond = implode(' And ', $whereCond);

        $sql = 'SELECT * FROM ' . static::$tableName . ' ' . $join . ' where ' . $whereCond;


        $stmt = DatabaseHandler::factory()->prepare($sql);

        for ($i = 0, $ii = count($column); $i < $ii; $i++) {
            $stmt->bindValue(":{$column[$i]}", $values[$i]);
        }

        if (method_exists(get_called_class(), '__construct')) {
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_called_class(), static::$table_schema);
        } else {
            $stmt->setFetchMode(pdo::FETCH_CLASS, get_called_class());
        }

        $stmt->execute();
        $result = $stmt->fetch();

        if (is_a($result, get_called_class()) && !empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public static function getmore(array $array , $join = '')
    {
        $whereCond = [];

        $column = array_keys($array);
        $values = array_values($array);

        for ($i = 0, $ii = count($column); $i < $ii; $i++) {
            $whereCond[] = $column[$i] . '=' . ":" . $column[$i] . "";
        }

        $whereCond = implode(' And ', $whereCond);

        $sql = 'SELECT * FROM ' . static::$tableName . ' ' . $join . ' where ' . $whereCond;


        $stmt = DatabaseHandler::factory()->prepare($sql);

        for ($i = 0, $ii = count($column); $i < $ii; $i++) {
            $stmt->bindValue(":{$column[$i]}", $values[$i]);
        }

        if (method_exists(get_called_class(), '__construct')) {
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_called_class(), static::$table_schema);
        } else {
            $stmt->setFetchMode(pdo::FETCH_CLASS, get_called_class());
        }

        $stmt->execute();
        $result = $stmt->fetchAll();
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public static function getbySQL($sql)
    {

        $stmt = DatabaseHandler::factory()->prepare($sql);

        if (method_exists(get_called_class(), '__construct')) {
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, get_called_class(), static::$table_schema);
        } else {
            $stmt->setFetchMode(pdo::FETCH_CLASS, get_called_class());
        }
        $stmt->execute();
        $result = $stmt->fetch();

        if (is_a($result, get_called_class()) && !empty($result)) {
            return $result;
        } else {
            return false;
        }
    }


    public function foreach_object(){
        $array = [] ;
        foreach ($this as $key => $value){
            $array[$key] =  $value  ;
        }
        return $array;
    }

}