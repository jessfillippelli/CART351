<?php
// put required html mark up
echo"<html>\n";
echo"<head>\n";
echo"<title> Output from the Grafitti Gallery Database </title> \n";
//include CSS Style Sheet
echo "<link rel='stylesheet' type='text/css' href='css/galleryStyle.css'>";
echo"</head>\n";
// start the body ...
echo"<body>\n";
// place body content here ...
class MyDB extends SQLite3
   {
      function __construct()
      {
          $this->open('../db/users.db');
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

echo"</body>\n";
echo"</html>\n";
?>
