<?php

/**
 * Date: 09/02/15
 * Time: 22:53
 * Author: HJW88
 */
class ProductModel
{

    /**
     *
     * @param null $condition, String from WHERE
     * @return array
     */
    public static function getAllProducts($condition = null)
    {
        $sql = <<<SQL

SELECT p.id as id, p.name as name, p.description as description,
      p.price as price, p.shipping as shipping, p.gender as gender, p.type as type,
      p_comment.rating as rating, p_comment.count as reviews,
      pp_exemplar.exemplars as exemplars,
      pp_theme.themes as themes,
      pp_event.events as events,
      pp_image.url as url
FROM product p
  LEFT JOIN
  (
    SELECT product as pid, FORMAT(avg(rating),1) as rating, count('text') as count
    FROM comment GROUP BY product
    ) p_comment
  ON p.id = p_comment.pid

  LEFT JOIN
  (
    SELECT product_theme.product as ptpid, GROUP_CONCAT(theme.name) as themes
    FROM product_theme, theme
    WHERE product_theme.theme = theme.id
    GROUP BY ptpid
    ) pp_theme
  ON p.id = pp_theme.ptpid

  LEFT JOIN
  (
    SELECT product_event.product as pepid, GROUP_CONCAT(event.name) as events
    FROM product_event, event
    WHERE product_event.event = event.id
    GROUP BY pepid
    ) pp_event
  ON p.id = pp_event.pepid


  LEFT JOIN
  (
    SELECT product_image.product as pipid, product_image.url as url
    FROM  product_image
    GROUP BY pipid
    ) pp_image
  ON p.id = pp_image.pipid

  LEFT JOIN
  (
    SELECT exemplar.product as epid, group_concat(exemplar.size) as exemplars
    FROM exemplar
    GROUP BY epid
    ) pp_exemplar
  ON p.id = pp_exemplar.epid


SQL;

        if ($condition) {
            /**
             * @TODO
             */
            $sql .= " WHERE " . $condition;
        }

        $sql .= " ORDER BY rating DESC";

        $model = new DBModel();
        $model->executeQuery($sql);

        if ($model->result){
            return $model->getRows();
        }

    }

    /**
     * @param $id, product id
     * @return array
     */
    public static function getProductByID($id)
    {
        $model = new DBModel();
        $sql = <<<EOD
        SELECT *
FROM product
  LEFT JOIN (
    SELECT GROUP_CONCAT(size) as exemplar, product as epid
    FROM exemplar
    GROUP BY epid
    ) exemplar2
  ON product.id = exemplar2.epid
  WHERE id =
EOD;
        $sql .= (int)$id;

        $model->executeQuery($sql);
        if ($model->result){
            return $model->getRow();
        } else {
            return false;
        }

    }



    /**
     * @param $id1
     * @param $id2
     * @param $action, can be add / delete
     * @return bool
     */
    public static function doRelatedProduct($id1, $id2, $action){
        if ($id1 != $id2){
            $model = new DBModel();
            if ($action == 'add') {
                $model->insertRecords('recommend', array('product1' => $id1, 'product2' => $id2));
                $model->insertRecords('recommend', array('product1' => $id2, 'product2' => $id1));
            }
            if ($action == 'delete'){
                $model->deleteRecords('recommend', 'product1= '.$id1. ' AND product2='.$id2);
                $model->deleteRecords('recommend', 'product1= '.$id2. ' AND product2='.$id1);
            }
        }
    }

    /**
     * @param array $exemplar, an array of exemplars
     * @param $productID
     */
    public static function doUpdateProductExemplar($exemplar = array(), $productID){
        $model = new DBModel();
        $model->deleteRecords('exemplar', 'product='.(int)$productID);
        foreach($exemplar as $size){
            $size = trim(strtolower($size));
            $model->insertRecords('exemplar', array('size'=>$size, 'product'=>(int)$productID));
        }
    }



    public static function getAllRelatedProductByProductID($productID, $related=true){

        if ($related){
            // related product
            $sql = <<<EOD

SELECT DISTINCT *
FROM recommend LEFT JOIN product
  ON recommend.product2 = product.id
WHERE recommend.product1 = {$productID}


EOD;

        } else {
            // no-related product
            $sql = <<<EOD
SELECT DISTINCT *
FROM product
WHERE product.id NOT IN (
  SELECT DISTINCT product1
  FROM recommend LEFT JOIN product
      ON recommend.product1 = product.id
  WHERE recommend.product2 = {$productID})
AND product.id != {$productID}

EOD;

        }

        $model = new DBModel();
        $model->executeQuery($sql);
        if ($model->result){
            $products = array();
            while ($row = $model->getRow()){
                $products = array_merge($products, self::getAllProducts('id='.$row['id']));
            }
            return $products;
        } else {
            return null;
        }
    }


    /**
     * @param $productID
     * @param $url
     * @return bool
     */
    public static function addProductImage($productID, $url){

        $model = new DBModel();
        $model->insertRecords('product_image', array('product' => $productID, 'url' => $url));
        if ($model->result){
            return true;
        } else {
            return false;
        }
    }


    /**
     * @param $data
     * @param null $url
     * @return bool
     */
    public static function addProduct($data, $url=null)
    {
        $model = new DBModel();
        if ($model->insertRecords('product',$data)){
            $insetID = $model->getLastInsertID();
            if ($url) {
                self::addProductImage($insetID, $url);
            }
            return self::getProductByID($insetID);
        } else{
            return false;
        }

    }

    /**
     * @param $id, product id
     * @param $data, new data
     * @return bool
     */
    public static function updateProduct($id, $data){
        $model = new DBModel();
        $model->updateRecords('product', $data, 'id='.$id);
        if ($model->result){
            return true;
        } else {
            return false;
        }
    }


    public static function getOrderList($userID=null){
        $sql = <<<EOD

SELECT DISTINCT
  order_list.id as orderid,
  user.username as username,
      product.name as product,
      exemplar.size as size,
      startDate,
      endDate

FROM order_list , order_exemplar, exemplar, product, user
WHERE order_list.id =order_exemplar.orderid
      AND order_exemplar.exemplar = exemplar.id
      AND exemplar.product = product.id
      AND user.id = order_list.user

EOD;
        if ($userID){
            $sql .= ' AND user.id='.(int)$userID;
        }

        $sql .= ' ORDER BY orderid';

        $model = new DBModel();
        $model->executeQuery($sql);

        if ($model->result){
            $data = array();
            while($row = $model->getRow()){
                $data[] = $row;
            }
            return $data;
        } else {
            return null;
        }

    }

    public static function doOrder($userID, $productID, $size, $startDate, $endDate, $action){
        $model = new DBModel();
        // first get ExemplarID
        $model->selectRecords('exemplar', 'size="'.$size.'" AND product= '.(int)$productID);
        if ($model->result){
            $exemplarID = $model->getRow()['id'];
            switch ($action){

                case 'add':

                    $model->insertRecords('order_list',array('user'=>$userID, 'startDate'=>$startDate, 'endDate'=>$endDate));
                    if ($model->result){
                        $orderID = $model->getLastInsertID();
                        $model->insertRecords('order_exemplar',array('orderid'=>$orderID, 'exemplar'=>$exemplarID));
                        if ($model->result){
                            return true;
                        }
                    }

                    break;

            }
        }

    }

}