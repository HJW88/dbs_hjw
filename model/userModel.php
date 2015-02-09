<?php
/**
 * Date: 09/02/15
 * Time: 17:44
 * Author: HJW88
 */

class userModel {

    protected $db;

    /**
     * Every model
     */
    public function __construct(){
        $this->db = new db();
    }


    /**
     * Get user information by username,
     * This query must left join on customer table.
     *
     * @param $username
     * @return array
     */
    static public function getUserByUsername($username){
        $user = new userModel();
        $sql = 'SELECT user.*, customernr FROM user LEFT JOIN customer on user.username = customer.username WHERE user.username = "'.$username.'"';
        $user->db->executeQuery($sql);
        if ($user->db->last){
            $row = $user->db->getRows();
            return $row;
        }
    }


    /**
     * Create a use/customer in db.
     * @param $data
     * @return array
     */
    static public function createUser($data){
        $user = new userModel();
        $stm = $user->db->getStamentObject('INSERT INTO user (username, firstname, lastname, email, gender, password) VALUE (?, ?, ?,?,?,?)');
        $stm->bind_param('ssssss', $data['username'], $data['firstname'], $data['lastname'], $data['email'], $data['gender'], $data['password1']);
        if ($stm->execute()) {
            if ($data['type'] == 'Customer') {
                $user->db->insertRecords('customer', array('username' => $data['username']));
            }
            return self::getUserByUsername($data['username']);
        } else {
            error_log(get_class(self) . ' Error createUser' . json_encode($data));
        }
    }

}