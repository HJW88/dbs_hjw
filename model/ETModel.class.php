<?php
/**
 * Date: 12/02/15
 * Time: 20:22
 * Author: HJW88
 */

/**
 * Class ETModel
 * Present the Event/Theme
 */
class ETModel
{


    public static function getETByTypeID($type, $id){

        $model = new DBModel();
        $model->selectRecords($type, 'id='.(int)$id);

        if ($model->result){
            return $model->getRow();
        } else {
            return null;
        }


    }

    /**
     * Add record into event or theme table depends on the given type
     * @param $type , event or theme
     * @param $name , name
     * @param $description , description
     * @return bool
     */
    public static function addETRecord($type, $name, $description)
    {

        $model = new DBModel();
        $model->insertRecords($type, array('name' => trim($name), 'description' => trim($description)));
        if ($model->result) {
            return true;
        } else {
            return false;
        }

    }

    public static function updateETRecord($type, $id, $name, $description){
        $model = new DBModel();
        $model->updateRecords($type, array('name' => trim(strip_tags($name)), 'description' => trim(strip_tags($description))), 'id='.(int)$id);
        if ($model->result){
            return true;
        } else {
            return false;
        }
    }


    /**
     * Do product related event or theme operations
     *
     * @param $type , event or theme
     * @param $id , record id
     * @param $productID , product id
     * @param $action , delete or add
     * @return bool
     */
    public static function doETProductRelated($type, $id, $productID, $action)
    {

        $model = new DBModel();

        switch ($action) {

            case 'add':
                $model->selectRecords('product_' . $type, 'product= ' . $productID . ' AND ' . $type . '=' . $id);
                if (!$model->getRow()) {
                    $model->insertRecords('product_' . $type, array('product' => $productID, $type => $id));
                }
                break;

            case 'delete':
                $model->deleteRecords('product_' . $type, 'product= ' . $productID . ' AND ' . $type . '=' . $id);
                break;
        }

        if ($model->result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Use type and name to test if this record already in db
     * @param $type
     * @param $name
     * @return mixed|null
     */
    public static function getETByTypeName($type, $name)
    {
        $model = new DBModel();
        $model->selectRecords($type, 'name="' . $name . '"');
        if ($model->result) {
            return $model->getRow();
        } else {
            return null;
        }
    }

    /**
     * @param $type
     * @param $productID
     * @return array|null
     */
    public static function getAllETByProductID($type, $productID)
    {

        switch ($type) {

            case 'theme':
                $slq = <<<EOD
SELECT DISTINCT id, name, description, IF(id IN ((SELECT theme as tid
                                                  FROM
                                                    product_theme
                                                  WHERE product= {$productID})),1,0) as isRelated
FROM theme LEFT JOIN product_theme ON theme.id = product_theme.theme
ORDER BY isRelated DESC;

EOD;
                break;

            case 'event':

                $slq = <<<EOD
SELECT DISTINCT id, name, description, IF(id IN ((SELECT event as tid
                                                  FROM
                                                    product_event
                                                  WHERE product= {$productID})),1,0) as isRelated
FROM event LEFT JOIN product_event ON event.id = product_event.event
ORDER BY isRelated DESC;

EOD;

                break;
        }

        $model = new DBModel();

        $model->executeQuery($slq);

        if ($model->result) {
            return $model->getRows();
        } else {
            return null;
        }

    }


}