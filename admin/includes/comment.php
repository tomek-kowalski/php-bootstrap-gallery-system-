<?php

class Comment extends Db_object{

    protected static $db_table = "comments"; 
    protected static $db_table_fields = array('id', 'photo_id', 'author','body');

    protected static $db_table_photos = "photos";
    protected static $db_table_fields_photos = array('id','filename');

    public $id;
    public $photo_id;
    public $author;
    public $body;
    public $filename;

public static function create_comment($photo_id, $author ="", $body ="") {

    if(!empty($photo_id) && !empty($author) && !empty($body)) {

        $comment = new Comment;
        $comment->photo_id = (int)$photo_id;
        $comment->author   = $author;
        $comment->body     = $body;

        return $comment;

    } else {
       
        return false;

    }

}

public static function find_the_comment($photo_id=0){

global $database;

$photo_id = $database->escape_string($photo_id);

$sql  = "SELECT * FROM " . self::$db_table . " WHERE ";
$sql .= "photo_id =  {$photo_id}";
$sql .= " ORDER BY photo_id ASC";

return self::find_by_query($sql);

}

/* public static function select_photo_for_comments() {

    global $database;
    
    $sql  = "SELECT c.*, p.id, p.filename FROM comments AS c";
    $sql .= " JOIN photos AS p";
    $sql .= " ON c.photo_id = p.id";
    $sql .= " ORDER BY photo_id ASC";
    
    return self::find_by_query($sql);
    
}  */

/* public static function edit_photo_for_comments($photo_id, $id) {

    global $database;
    
    $sql  = "SELECT c.*, p.id, p.filename FROM comments AS c";
    $sql .= " JOIN photos AS p";
    $sql .= " ON c.photo_id = p.id";
    $sql .= " WHERE c.photo_id = {$photo_id}";
    $sql .= " AND c.id = {$id}";
    $sql .= " ORDER BY photo_id ASC";
    
    return self::find_by_query($sql);
    
}
 


public function picture_path() {
    return $this->upload_directory.DS.$this->filename;
} */

} // End of Class

?>
