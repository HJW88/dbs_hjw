<?php
/**
 * Date: 09/02/15
 * Time: 17:44
 * Author: HJW88
 */

class UserModel {

    /**
     * Get user information by username,
     * This query must left join on customer table.
     *
     * @param $username
     * @param $password
     * @return array
     */
    static public function getUserByUsername($username, $password=null){
        $model = new DBModel();
        $sql = 'SELECT * FROM user WHERE username =  "'.$username.'"';

        if ($password){
            $sql .= ' AND password = "' . $password . '"';
        }

        $model->executeQuery($sql);
        if ($model->result){
            $row = $model->getRows();
            return $row;
        }
    }


    static public function getUserByUserID($userID){
        $model = new DBModel();
        $sql = 'SELECT * FROM user WHERE id ='.(int)$userID;

        $model->executeQuery($sql);
        if ($model->result){
            $row = $model->getRows();
            return $row;
        }
    }



    /**
     * Create a use/customer in db.
     * @param $data
     * @return array
     */
    static public function createUser($data){
        $model = new DBModel();
        $stm = $model->getStamentObject('INSERT INTO user (username, firstname, lastname, email, gender, password, is_admin) VALUE (?, ?, ?,?,?,?,?)');
        $stm->bind_param('ssssssi', $data['username'], $data['firstname'], $data['lastname'], $data['email'], $data['gender'], $data['password1'], $data['is_admin']);
        if ($stm->execute()) {
            return self::getUserByUsername($data['username']);
        } else {
            error_log(get_class(self) . ' Error createUser' . json_encode($data));
        }
    }

    static public function updateUser($userID, $data){
        $model = new DBModel();
        $model->updateRecords('user', $data, ' id='.(int)$userID);
        if ($model->result){
            return self::getUserByUserID($userID);
        } else {
            return false;
        }
    }

}