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
if($_SERVER['REQUEST_METHOD'] == 'POST') //THE USER HIT SBMIT
{
      $sql_select='SELECT searchtext FROM uploadArt';
      $result = $db->query($sql_select);
      if (!$result) die("Cannot execute query.");

// get a row...
// MAKE AN ARRAY::
$res = array();
$i=0;
while($row = $result->fetchArray(SQLITE3_ASSOC))
{
  // note the result from SQL is ALREADy ASSOCIATIVE
 $res[$i] = $row;
 $i++;
}//end while
// endcode the resulting array as JSON
$myJSONObj = json_encode($res);
echo $myJSONObj;
 exit;

//  echo("retrieveing");

}//POST
//use the JSON .parse function to convert the JSON string into a Javascript object
   //let parsedJSON = JSON.parse(response);
   //console.log(parsedJSON)
?>
