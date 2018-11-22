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
   //echo ("users table created successfully<br \>");
  // $theQuery = 'CREATE TABLE usersTable (userID INTEGER PRIMARY KEY NOT NULL, username TEXT, searchtext TEXT)';
  $theQuery = 'CREATE TABLE moviesTable (userID INTEGER PRIMARY KEY NOT NULL, username TEXT, searchtext TEXT)';

 $ok = $db ->exec($theQuery);
	// make sure the query executed
	if (!$ok)
	die($db->lastErrorMsg());
	// if everything executed error less we will arrive at this statement
	echo "users moviestable created successfully<br \>";
}
catch(Exception $e)
{
   die($e);
}
?>
