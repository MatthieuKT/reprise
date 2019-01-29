<?php
// 'Product_image' object
class ProductImages {
  // Database connexion and table name
  private $conn;
  private $table_name = "product_images";
  // Object properties
  public $id;
  public $images = array();
  public $product_id;
  // Constructor
  public function __construct($db) {
    $this->conn = $db;
  }

  function addImage() {
    $query = "INSERT INTO " . $this->table_name . "
              SET id_produit=:id_produit, image1=:image1, image2=:image2 ";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_produit', $this->id_produit);
    $stmt->bindParam(":image1", $this->images[0]);
    $stmt->bindParam(":image2", $this->images[1]);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // will upload image file to server
  function uploadPhoto($file) {
    $image = $file;
    $result_message = "";
    // sha1_file() function is used to make an unique file name
    $target_directory = "uploads/images/";
    $target_file = $target_directory . $image['name'];
    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
    // Error message is empty
    $file_upload_error_messages = "";

    // 1: Make sure that file is a real image
    $check = getimagesize($image['tmp_name']);
      if ($check == false) {
        // submited file is not an image
        $file_upload_error_messages = "Submitted file is not an image.";
      }

      // 2: Limit allowed file types
      $allowed_file_types = array("jpg", "jpeg", "png", "gif");
      if (!in_array($file_type, $allowed_file_types)) {
        $file_upload_error_messages.="<div>
                                        JPG, JPEG, PNG, GIF files are allowed.
                                      </div>";
      }

      // 3: Make sur files does not already exist
      if (file_exists($target_file)) {
        $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
      }

      // 4: make sure submitted file is not too large, can't be larger than 1 MB
      if($image['size'] > (1024000)){
        $file_upload_error_messages.="<div>L'image doit faire moins de 1 MB.</div>";
      }

      // 5: make sure the 'uploads' folder exists. If not, create it
      if(!is_dir($target_directory)){
        mkdir($target_directory, 0777, true);
      }
      // if $file_upload_error_messages is still empty
      if(empty($file_upload_error_messages)){
        // it means there are no errors, so try to upload the file
        if(move_uploaded_file($image["tmp_name"], $target_file)){
          // it means photo was uploaded
        }else{
          $result_message.="<div>Unable to upload photo.</div>";
          $result_message.="<div>Update the record to upload photo.</div>";
        }
      }
      // if $file_upload_error_messages is NOT empty
      else{
      // it means there are some errors, so show them to user
        $result_message.="{$file_upload_error_messages}";
        $result_message.="<div>Update the record to upload photo.</div>";
      }
      return $result_message;
  } // /function

  // read the first product image related to a product
  function readFirst(){
    // select query
    $query = "SELECT id, id_produit, image1
              FROM " . $this->table_name . "
              WHERE id_produit = ?
              LIMIT 0, 1";
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
    // bind prodcut id variable
    $stmt->bindParam(1, $this->product_id);
    // execute query
    $stmt->execute();
    // return values
    return $stmt;
  }

  // Lis toute les images associées à un produit
  function readAllImages() {
    $query = "SELECT image1, image2
              FROM " . $this->table_name . "
              WHERE id_produit = ? ";
    $stmt = $this->conn->prepare($query);
    // Sanitize
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(1, $this->product_id);
    $stmt->execute();
    return $stmt;
  }
}?>
