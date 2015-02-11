<?php
/**
 * Date: 10/02/15
 * Time: 01:08
 * Author: HJW88
 */

/**
 * Class uploader
 * Upload image helper
 *
 *
 * Learn From W3C School : http://www.w3schools.com/php/php_file_upload.asp
 *
 */
class uploader
{

    /***
     * upload image To __UPLOADS directory
     *
     * @return null|string
     *
     */
    public static function getUploadImageUrl()
    {
        $target_dir = __UPLOADS;
        $url = strtolower(self::clean(basename($_FILES["image"]["name"])));
        $target_file = $target_dir . $url;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // Check if file already exists
        if (file_exists($target_file) && !is_dir($target_file)) {
            return __MEDIALOCATION. $url;
        }
        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $_SESSION['alert']['warning'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $_SESSION['alert']['warning'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            error_log('Error uploading image'.$url);
            return null;
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                return __MEDIALOCATION.$url;
            } else {
                return null;
            }
        }
    }

    /**
     * Remove all special characters.
     * Learned from
     * http://stackoverflow.com/questions/14114411/remove-all-special-characters-from-a-string
     *
     * @param $string
     * @return mixed
     */
    public static function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-\.]/', '', $string); // Removes special chars.
    }
}