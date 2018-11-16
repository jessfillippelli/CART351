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
$user = $_POST['u_name'];

//asking it a question
$user_es =$db->escapeString($user);
$sql_select="SELECT COUNT(username) FROM usersTable WHERE username='$user_es'";
// the result set
$result = $db->query($sql_select);
if (!$result) die("Cannot execute query."); //count how many people have that user name
//echo($user_es); //test
while($row = $result->fetchArray(SQLITE3_ASSOC))
{ //start1
 foreach ($row as $entry){ //start2
   //echo($entry);
   if($entry == 0){ //if start
     $queryInsert ="INSERT INTO usersTable(username)VALUES ('$user_es')";
// again we do error checking when we try to execute our SQL statement on the db
$ok1 = $db->exec($queryInsert);
 //:: error messages WILL be sent back to JQUERY success function .....
if (!$ok1) {
 die("Cannot execute statement.");
exit;
}
 //send back success...
 echo ($user_es); // now we are enserting into the database
  exit;
} //if end
else{
  echo($user_es);
}

 }//end2
} //end1
 exit;

}//POST
//use the JSON .parse function to convert the JSON string into a Javascript object
   //let parsedJSON = JSON.parse(response);
   //console.log(parsedJSON)
?>
