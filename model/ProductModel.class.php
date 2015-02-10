<?php

/**
 * Date: 09/02/15
 * Time: 22:53
 * Author: HJW88
 */
class ProductModel extends BaseModel
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
    LIMIT 1
    ) pp_image
  ON p.id = pp_image.pipid

SQL;

        if ($condition) {
            /**
             * @TODO
             */
            $sql .= " WHERE " . $condition;
        }

        $model = new ProductModel();
        $model->db->executeQuery($sql);
        if ($model->db->numRows() > 0) {
            $products = array();
            while ($row = $model->db->getRows()) {
                $products[] = $row;
            }
            return $products;

        }

    }

    public static function getProductByID($id)
    {
        $model = new ProductModel();
        $model->db->selectRecords('product', 'id='.$id);
        if ($model->db->last){
            return $model->db->getRows();
        }
    }

    public static function addProduct($data, $url)
    {
        $model = new ProductModel();
        if ($model->db->insertRecords('product',$data)){
            $insetID = $model->db->getLastInsertID();
            $model->db->insertRecords('product_image', array('product'=>$insetID, 'url'=>$url));
            return true;
        } else{
            return false;
        }

    }

}