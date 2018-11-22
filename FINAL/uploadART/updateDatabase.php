<?php

class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('../db/graffitiGallery.db');
      }
   }
try
{
   $db = new MyDB();
}
catch(Exception $e)
{
   die($e);
}

?>
