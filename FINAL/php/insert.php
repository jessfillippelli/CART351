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




<!DOCTYPE html>
<html>
<head>
<title>Sample Insert into Gallery Form USING JQUERY AND AJAX </title>
<!-- get JQUERY -->
  <script src = "../libs/jquery/jquery-3.3.1.min.js"></script>
<!--set some style properties::: -->

</head>
<body>




<div class= "formContainer">
<!--form done using more current tags... -->
<form id="insertUser" action="" enctype ="multipart/form-data">
<!-- group the related elements in a form -->
<h3> SUBMIT AN ART WORK :) </h3>
<fieldset>
<p><label> user name </label><input type="text" size="24" maxlength = "40" name = "u_name" required></p>

<p class = "sub"><input type = "submit" name = "submit" value = "submit my info" id ="buttonS" /></p>
 </fieldset>
</form>
</div>
<script>
let user ="";
<!-- here we put our JQUERY -->
$("#insertUser").ready (function(){
    $("#insertUser").submit(function(event) {
       //stop submit the form, we will post it manually. PREVENT THE DEFAULT behaviour ...
      event.preventDefault();
     console.log("button clicked");
     let form = $('#insertUser')[0];
     let data = new FormData(form);
     $.ajax({
             type: "POST",
             enctype: 'multipart/form-data',
             url: "insert.php",
             data: data,
             processData: false,//prevents from converting into a query string
             contentType: false,
             cache: false,
             timeout: 600000,
             success: function (response) {
             console.log(response);
             user = response;
            },
            error:function(){
           console.log("error occurred");
         }
       });

      // validate and process form here
  function displayResponse(theResult){
    let container = $('<div>').addClass("outer");
    let title = $('<h3>');
    $(title).text("Results from user");
    $(title).appendTo(container);
    let contentContainer = $('<div>').addClass("content");
    for (let property in theResult) {
      console.log(property);
      if(property ==="fileName"){
        let img = $("<img>");
        $(img).attr('src','images/'+theResult[property]);

        $(img).appendTo(contentContainer);
      }
      else{
        let para = $('<p>');
        $(para).text(property+"::" +theResult[property]);
          $(para).appendTo(contentContainer);
      }

    }
    $(contentContainer).appendTo(container);
    $(container).appendTo("#result");
  }
   });
});
</script>
</body>
</html>
