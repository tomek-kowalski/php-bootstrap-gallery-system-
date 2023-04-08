<?php

class User extends Db_object{

public static function verify_user($username, $password) {
global $database;

$username = $database->escape_string($username);
$password = $database->escape_string($password);

$sql  = "SELECT * FROM " .self::$db_table. " WHERE ";
$sql .= "username = '{$username}'";
$sql .= "AND password = '{$password}'";
$sql .= "LIMIT 1";

$the_result_array = self::find_by_query($sql);

return !empty($the_result_array) ? array_shift($the_result_array) : false;

}

public function ajax_save_user_image($user_image, $user_id) {

global $database;

$user_image = $database->escape_string($user_image);
$user_id    = $database->escape_string($user_id);

$this->user_image = $user_image;
$this->id = $user_id;

$sql = "UPDATE " . self::$db_table . " SET user_image = '{$this->user_image}' ";
$sql.= " WHERE id = {$this->id} ";

$update_image = $database->query($sql);

echo $this->image_path_and_placeholder();

}

public function delete_photo() {
    if($this->delete()) {
$target_path = SITE_ROOT.DS. 'admin' . DS . $this->upload_directory . DS . $this->user_image;
return unlink($target_path) ? true : false;
    } else  {
        return false;
    }
}

public function photos() {
    return Photo::find_by_query(" SELECT * FROM photos WHERE user_id = " . $this->id);
}

} // end of User Class

?>
