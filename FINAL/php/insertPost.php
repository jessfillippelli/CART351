<?php

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

//check if there has been something posted to the server to be processed
if($_SERVER['REQUEST_METHOD'] == 'POST') //THE USER HIT SBMIT
{
// need to process
$post = $_POST['userSearch'];
//echo($post);

// //asking it a question
$post_es =$db->escapeString($post);
$queryInsert ="INSERT INTO usersTable(searchtext)VALUES ('$post_es')";
// // again we do error checking when we try to execute our SQL statement on the db
$ok1 = $db->exec($queryInsert);
//  //:: error messages WILL be sent back to JQUERY success function .....
 if (!$ok1) {
 die("Cannot execute statement.");
 exit;
 }
echo("success");

}//POST
//use the JSON .parse function to convert the JSON string into a Javascript object
   //let parsedJSON = JSON.parse(response);
   //console.log(parsedJSON)
?>
