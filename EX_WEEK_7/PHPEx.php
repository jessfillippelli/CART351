<?php
//check if there has been something posted to the server to be processed
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $sampleDataAsIfInAFile = array("smarties","twix","snickers","maltesers","flake","wunderbar","mars");
    $sampleDataAsIfInAFile2 = array("oranges","apples","peppers","carrots","grapes","grapefruits","kumquats");
    $sampleDataAsIfInAFile3 = array("batman","black widow","coffee","java","cake","mary","kevin");
    $sampleDataAsIfInAFile4 = array("superman","pink","nothing","montreal","habs","heartbreak","backstreet boys ");
// need to process -> we could save this data ...
 $xPos = $_POST['xpos'];
 $yPos = $_POST['ypos'];
 $action = $_POST['action'];
 //do some silly processing:
 $newPos = $xPos+$yPos;
 //lets choose a word from our "data file" based on the sum of the x and y pos...
 //there are 2 possible actions choose the word depending on action...
 if($action =="theButton"){
 $dataToSend =  $sampleDataAsIfInAFile[$newPos%count($sampleDataAsIfInAFile)];
}
else if($action =="theRect"){
  $dataToSend =$sampleDataAsIfInAFile2[$newPos%count($sampleDataAsIfInAFile2)];;
}

else if($action =="theArc"){
  $dataToSend =$sampleDataAsIfInAFile3[$newPos%count($sampleDataAsIfInAFile3)];;
}

else if($action =="theSquare"){
  $dataToSend =$sampleDataAsIfInAFile4[$newPos%count($sampleDataAsIfInAFile4)];;
}
    //package the data and echo back...
    $myPackagedData=new stdClass();
    $myPackagedData->word = $dataToSend;
     // Now we want to JSON encode these values to send them to $.ajax success.
    $myJSONObj = json_encode($myPackagedData);
    echo $myJSONObj;
    exit;
}//POST
?>

<!DOCTYPE html>
<html>
<head>
<title>EX 5 - WEEK 7 :p </title>
<!-- get JQUERY -->
  <script src = "libs/jquery-3.3.1.min.js"></script>
<style>
body{
  margin:0;
  padding:0;
}
canvas{
  background:black;
  margin:0;
  padding:0;
}
#b{
  background:purple;
  color:white;
  margin:5px;
  text-align: center;
  padding: 5px;
  width:10%;
}
</style>
</head>
<body>
<div id = "b"><p>CLICK BUTTON</p></div>


<canvas id="myCanvas" width=1000 height=1000></canvas>
<!-- here we put our JQUERY -->
<script>
$(document).ready (function(){
  //declare some global vars ...
  let x =10;
  let y =10;
  let xPos = 100;
  let yPos = 200;
  let x1 = 30;
  let y1 = 30;
  let radius  = 50;
  let startAngle = 0;
  let endAngle = Math.PI * 2 //full rotation
  let theWord = "";
  let theWord2 = "";
  let theWord3 = "";
  let theWord4 = "";
  //start ani
  goAni();
  // when we click on the canvas somewhere and the collision detection returns true ...

  $('#myCanvas').on("mousedown",function(event){
  //  console.log("mouseover on canvas");
    let truth = checkCollision(event);
    if(truth ===true){
      //our function for sending data
      sendData("theRect");
    }

    let truthArc = checkCollisionArc(event);
    if(truthArc ===true){
      //our function for sending data
      sendData("theArc");
    }
    let truthSquare = checkCollisionSquare(event);
    console.log("square")
    if(truthSquare ===true){
      //our function for sending data
      sendData("theSquare");
    }
});

  // if we click on the button other stuff happens ...
    $( "#b" ).click(function( event ) {
      //stop submit the form, we will post it manually. PREVENT THE DEFAULT behaviour ...
       event.preventDefault();
       console.log("button clicked");
       sendData("theButton");

     });

     function sendData(typeOfClick){

       let data = new FormData();
        if(typeOfClick ==="theRect")
       {
       data.append('action', typeOfClick);
       data.append('xpos', x);
       data.append('ypos', y);
     }
     if(typeOfClick ==="theArc")
     {
      data.append('action', typeOfClick);
      data.append('xpos', xPos);
      data.append('ypos', yPos);
    }

    if(typeOfClick ==="theSquare")
    {
     data.append('action', typeOfClick);
     data.append('xpos', x1);
     data.append('ypos', y1);
   }

       $.ajax({
             type: "POST",
             enctype: 'multipart/form-data',
             url: "PHPEx.php",
             data: data,
             processData: false,//prevents from converting into a query string
             contentType: false,
             cache: false,
             timeout: 600000,
             success: function (response) {
             //reponse is a STRING (not a JavaScript object -> so we need to convert)
             console.log(response);
             //use the JSON .parse function to convert the JSON string into a Javascript object
             let parsedJSON = JSON.parse(response);
             console.log(parsedJSON);
             if(typeOfClick ==="theButton"){
             theWord = parsedJSON.word;
           }
           else if(typeOfClick ==="theRect") {
              theWord2 = parsedJSON.word;
           }
           else if(typeOfClick ==="theArc") {
              theWord3 = parsedJSON.word;
           }

           else if(typeOfClick ==="theSquare") {
              theWord4 = parsedJSON.word;
           }

         },
         error:function(){
           console.log("error occured");
         }
       });
     } //end sendData

    function goAni(){
      let canvas = document.getElementById('myCanvas');
      let canvasContext = canvas.getContext('2d');
      requestAnimationFrame(runAni);


//DRAW THE
     function runAni(){
     //need to reset the background :)
     // clear the canvas ...


     canvasContext.clearRect(0, 0, canvas.width, canvas.height);

     x+=0.2;
     y+=0.2;
     yPos+= 0.2;
     xPos+= 0.2;
     x1+= 0.2;
     y1+=0.2;
     //START OF RECT #1
     canvasContext.fillStyle = "#33B2FF";
     canvasContext.fillRect(x,y,20,20);
     canvasContext.fillStyle = "#FFFFFF";
     canvasContext.fillRect(x,y,1,1);


     //START OF RECT #2
     canvasContext.lineWidth=2; //change stroke weight
     canvasContext.strokeStyle = "#FFFFFFs"; // change the color we are using
     //canvasContext.stroke(); // set the outline
    canvasContext.fillStyle = "#0000";
   canvasContext.strokeRect(x1,y1,30,30);




// arc
    canvasContext.fillStyle = "#FF0000";
    canvasContext.fillRect(xPos-50,yPos-50,radius*2,radius);

     //START OF arc
     canvasContext.beginPath();
     // arc (x,y,radius, startAngle,endAngle,isCounterClockwise)
     canvasContext.arc(xPos,yPos,radius,startAngle,endAngle - Math.PI, true);




     canvasContext.lineWidth=2; //change stroke weight
     canvasContext.strokeStyle = "#8ED6FF"; // change the color we are using
     canvasContext.stroke(); // set the outline

     canvasContext.closePath(); //close a path ...
     // end arc


//START OF TYPE
     canvasContext.font = "40px Arial";
     canvasContext.fillStyle = "#B533FF";
     canvasContext.fillText(theWord,canvas.width/2 - (theWord.length/2*20),canvas.height/2);


     canvasContext.fillStyle = "#333cff";
     canvasContext.fillText(theWord2,canvas.width/2 - (theWord2.length/2*20),canvas.height/4);

     canvasContext.fillStyle = "#ff333c";
     canvasContext.fillText(theWord3,canvas.width/2 - (theWord2.length/2*20),canvas.height/8);

     canvasContext.fillStyle = "#33fff6 ";
     canvasContext.fillText(theWord4,canvas.width/2 - (theWord2.length/2*20),canvas.height/2);

     requestAnimationFrame(runAni);
}

  }
//when you click on it
  function checkCollision(event){
    let domRect = document.getElementById("myCanvas").getBoundingClientRect();
     if(x>event.clientX-20 && x<event.clientX+20 && y >(event.clientY-domRect.top)-20 && y<((event.clientY-domRect.top)+20))
    {
      return true;
    }
    return false;
  }

  function checkCollisionArc(event){
    let domRect = document.getElementById("myCanvas").getBoundingClientRect();
     if(xPos>event.clientX-50 && xPos<event.clientX+50 && yPos >(event.clientY-domRect.top) && yPos<(event.clientY-domRect.top)+50){
      return true;
    }
    return false;
  }


    function checkCollisionSquare(event){
      let domRect = document.getElementById("myCanvas").getBoundingClientRect();
       if(x1>event.clientX-30 && x1<event.clientX+30 && y1 >(event.clientY-domRect.top)-30 && y1<((event.clientY-domRect.top)+30))
      {
        return true;
      }
      return false;
    }



}); //document ready
</script>
</body>
</html>
