<?php

 ob_start(); 
 session_start(); //database details 
 define('DBHOST','localhost'); 
 define('DBUSER','root'); 
 define('DBPASS','root'); 
 define('DBNAME','blog-scratch'); 
// echo DBHOST;

/* 
1. Need To Clear Space Out of PDO Command*/
 
try {
   $db =new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   print "Error!: " . $e->getMessage() . "<br/>";
   die();
}

//set timezone- Asia Kolkata
// date_default_timezone_set('Asia/Kolkata');


// //load classes when needed
// function __autoload($class) {
   
//    // $class = strtolower($class);

//    //  //if call from within assets adjust the path
//    // $classpath = 'classes/class.'.$class . '.php';
//    // if ( file_exists($classpath)) {
//    //    require_once $classpath;
//    //  }   
    
//    //  //if call from within admin adjust the path
//    // $classpath = '../classes/class.'.$class . '.php';
//    // if ( file_exists($classpath)) {
//    //    require_once $classpath;
//    //  }
    
//    //  //if call from within admin adjust the path
//    // $classpath = '../../classes/class.'.$class . '.php';
//    // if ( file_exists($classpath)) {
//    //    require_once $classpath;
//    //  }       
     
// }
 $classpath = 'classes/class.users.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
    }  
    $classpath = '../classes/class.users.php';
    if ( file_exists($classpath)) {
       require_once $classpath;
     }     
$user = new User($db);

include("functions.php"); 
?>