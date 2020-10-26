<?php  
  requiere  'cloudinary/autoload.php' ;
  requieren  'cloudinary/src/Helpers.php' ;

  \Cloudinary::config(array(
      "cloud_name" => "hfub7pce6",
      "api_key" => "513517168346165",
      "api_secret" => "tuWuIUas7rFLtZXOxQPkSJl-PG0"
  ));

  \Cloudinary\Uploader::upload("/C:/Users/kpalma/Pictures/Kevin.png")
 ?>
