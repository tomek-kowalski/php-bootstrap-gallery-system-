<?php

class Db_object {
    
    
    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name','user_image');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $user_image;
    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/200x200&text=image";
    public $tmp_path;
    public $errors = array();
    public $upload_error_array = array (

        UPLOAD_ERR_OK           => "There is no error, the file uploaded with success.",
        UPLOAD_ERR_INI_SIZE     => "Value: 1; The uploaded file exceeds the upload_max_filesize directive in php.ini.",
        UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
        UPLOAD_ERR_PARTIAL      => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE      => "No file was uploaded. The profile was added",
        UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload. ",
    );

    public $upload_error_update = array (

        UPLOAD_ERR_OK           => "There is no error, the file uploaded with success.",
        UPLOAD_ERR_INI_SIZE     => "Value: 1; The uploaded file exceeds the upload_max_filesize directive in php.ini.",
        UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
        UPLOAD_ERR_PARTIAL      => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE      => "No file was uploaded. The profile was modified",
        UPLOAD_ERR_NO_TMP_DIR   => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload. ",
    );

public function image_path_and_placeholder() {

return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory.DS.$this->user_image;

}


public static function find_all() {

return static::find_by_query("SELECT * FROM " . static::$db_table . " ");
}

        
public static function find_by_id($id) {
    global $database;
    $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id=$id LIMIT 1 ");
        
        /* if(!empty($the_result_array)) {
        
        $first_item = array_shift($the_result_array);
        return $first_item;
        
        } else {
        return false;
        } */
        
    return !empty($the_result_array) ? array_shift($the_result_array) : false;
        
}

public static function find_by_query($sql) {
    global $database;
    $result_set = $database->query($sql);
    $the_object_array = array();
            
    while($row = mysqli_fetch_array($result_set)) {
            
    $the_object_array[] = static::instantation($row);
            
    }
            
    return $the_object_array;
}

public static function instantation($found_user) {

    $calling_class = get_called_class();

    $the_object = new $calling_class;
                
                /* $the_object ->id            =  $found_user['id'];
                $the_object ->username      =  $found_user['username'];
                $the_object ->password      =  $found_user['password'];
                $the_object ->first_name    =  $found_user['first_name'];
                $the_object ->last_name     =  $found_user['last_name']; */
                
    foreach($found_user as $the_propety => $value) {
    if($the_object->has_the_propety($the_propety)) {
    $the_object -> $the_propety = $value;
    }
    }
                
    return $the_object;
                
}

private function has_the_propety($the_propety ) {

    $object_propeties = get_object_vars($this);
    return array_key_exists($the_propety, $object_propeties);
                    
}

protected function properties() {

    //return get_object_vars($this);
    
    $properties = array();
    
    foreach(static::$db_table_fields as $db_field) {
    
        if(property_exists($this, $db_field)) {
    
            $properties[$db_field] = $this->$db_field;
    
        }
    }
    
    return $properties;
    
    }
    
    protected function clean_properties() {
        global $database;
    
        $clean_properties = array();
    
        foreach($this->properties() as $key => $value) { 
    
            $clean_properties[$key] = $database->escape_string($value);
    
        }
    return $clean_properties;
    
    }

public function save() {

    return isset($this->id) ? $this->update() : $this->create();

}

public function create() {
global $database;

$properties = $this->clean_properties();

$sql = "INSERT INTO " . static::$db_table . " (" . implode(",", array_keys($properties)) . ")";
$sql .= "VALUES('" . implode("','", array_values($properties)) . "')";


/* $sql .= $database->escape_string($this->username) .  "', '";
$sql .= $database->escape_string($this->password) .     "', '";
$sql .= $database->escape_string($this->first_name) .   "', '";
$sql .= $database->escape_string($this->last_name) .    "') ";    
 */
if($database->query($sql)) {

    $this->id = $database->the_insert_id();

    return true;

} else {

    return false;

}


} //create Method

public function update() {
    global $database;


    $properties = $this->clean_properties();

    $properties_pairs = array();

    foreach($properties as $key=>$value) {

        $properties_pairs[] = "{$key}='{$value}'";

    }

    $sql = "UPDATE ". static::$db_table . " SET ";
    $sql .=  implode(",", $properties_pairs);
/*  $sql .= "username   ='" . $database->escape_string($this->username)     . "', ";
    $sql .= "password   ='" . $database->escape_string($this->password)     . "', ";        
    $sql .= "first_name ='" . $database->escape_string($this->first_name)   . "', ";
    $sql .= "last_name  ='" . $database->escape_string($this->last_name)    . "' "; */
    $sql .= " WHERE id  =" . $database->escape_string($this->id);

    $database->query($sql);

    return (mysqli_affected_rows($database->connection) == 1) ? true : false;
}

public function delete() {
    global $database;


    $sql = "DELETE FROM ". static::$db_table . " ";
    $sql .= " WHERE id  =" . $database->escape_string($this->id);
    $sql .= " LIMIT 1";

    $database->query($sql);

    return (mysqli_affected_rows($database->connection) == 1) ? true : false;
}

public function set_file($file) {

    if(empty($file) || !$file || !is_array($file)) {
    
        $this->errors[] = "There was no file uploaded";
        if($this->create()) {
            return true;
        }

    } elseif($file['error'] != 0) {

        $this ->errors[] = $this->upload_error_array[$file['error']];
        if($this->create()) {
            return true;
        }

    } else {

        $this->user_image = basename($file['name']);
        $this->tmp_path   =          $file['tmp_name'];
    }

}

public function update_file($file) {

    if(empty($file) || !$file || !is_array($file)) {
    
        $this->errors[] = "There was no file uploaded";

        return false;
        

    } elseif($file['error'] != 0) {

        $this ->errors[] = $this->upload_error_update[$file['error']];
  
        return false;
        

    } else {

        $this->user_image = basename($file['name']);
        $this->tmp_path   =          $file['tmp_name'];
    }

}

public function picture_path() {
    return $this->upload_directory.DS.$this->user_image;
}

public function save_user_and_image() {

                if(!empty($this->errors)) {
                return false;
                }
                if(empty($this->user_image) || empty($this->tmp_path) ) {
        
                    $this->errors[] = "the file was not available";
                    return false;
                }
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
        
            if(file_exists($target_path)) {

                if($this->create()) {
                    return true;
                }
        
                $this->errors[] = "The file {$this->user_image} already exists. The profile was added";

                return false;
        
            }
        
            if(move_uploaded_file($this->tmp_path, $target_path)) {
                if($this->create()) {
                    unset($this->tmp_path);
                    return true;
                }
        
            } else {
                $this->errors[] = "The file folder is probably full ";
                return false;
            }
        
            
        } //save end

        public function upload_photo() {

            if(!empty($this->errors)) {
            return false;
            }
            if(empty($this->user_image) || empty($this->tmp_path) ) {
    
                $this->errors[] = "the file was not available";
                return false;
            }
        $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
    
        if(file_exists($target_path)) {

            return false;
                
            $this->errors[] = "The file {$this->user_image} already exists. The profile was added";

            return false;
    
        }
    
        if(move_uploaded_file($this->tmp_path, $target_path)) {

                unset($this->tmp_path);
                return true;
        
    
        } else {
            $this->errors[] = "The file folder is probably full ";
            return false;
        }
    
        
    } //save end

    public static function all_count () {
        global $database;
    
        $sql  = "SELECT COUNT(*) FROM " . static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);
    }



}


?>
