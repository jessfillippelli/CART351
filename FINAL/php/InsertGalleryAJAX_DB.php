<?php

  class MyDB extends SQLite3
{
   function __construct()
   {
      $this->open('../db/xmasart.db');
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

//check if there has been something posted to the server to be processed
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
// need to process
 $artist = $_POST['a_name'];
 $title = $_POST['a_title'];
 $description = $_POST['a_descript'];
 if($_FILES)
  {
    //echo "file name: ".$_FILES['filename']['name'] . "<br />";
    //echo "path to file uploaded: ".$_FILES['filename']['tmp_name']. "<br />";
   $fname = $_FILES['filename']['name'];
   move_uploaded_file($_FILES['filename']['tmp_name'], "images/".$fname);
    //echo "done";
    //package the data and echo back...
  //  $myPackagedData=new stdClass();
  //  $myPackagedData->artist = $artist ;
  //  $myPackagedData->title = $title ;
  //  $myPackagedData->location = $loc ;
  //  $myPackagedData->description = $description ;
  //  $myPackagedData->creation_Date = $creationDate ;
  //  $myPackagedData->fileName = $fname ;
     // Now we want to JSON encode these values to send them to $.ajax success.
  //  $myJSONObj = json_encode($myPackagedData);
  //  echo $myJSONObj;
    //exit;
    // NEW:: add into our db ....
  //The data from the text box is potentially unsafe; 'tainted'.
  //We use the sqlite_escape_string.
  //It escapes a string for use as a query parameter.
 //This is common practice to avoid malicious sql injection attacks.
 $artist_es =$db->escapeString($artist);
 $title_es = $db->escapeString($title);
 $description_es =$db->escapeString($description);
 // the file name with correct path
 $imageWithPath= "images/".$fname;
 // for the new column
 //$time = date("Y-m-d",time());
 $queryInsert ="INSERT INTO uploadArt(artist, title, descript, image)VALUES ('$artist_es', '$title_es','$description_es','$imageWithPath')";
 // again we do error checking when we try to execute our SQL statement on the db
 $ok1 = $db->exec($queryInsert);
 // NOTE:: error messages WILL be sent back to JQUERY success function .....
 if (!$ok1) {
   die("Cannot execute statement.");
   exit;
   }
   //send back success...
   echo "success";
   exit;

  }//FILES
}//POST
?>
