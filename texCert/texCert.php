<?php
    include "latexFill.php";
            
   function texCert ($awardID){
         //connect to database - host, username, pass, db
        $db = new mysqli('localhost','root','','bolero_web3');
    
         if ($db ->connect_error){
               die (" ERROR Could not connect to database. Please try again later. ". $db->conenct_error());
         }
         echo "success"; 
         echo "</br>";
           
         //get award info from awardID
         $query= "SELECT id, first_name, last_name, user_id, class_id, award_date, email FROM award where id = ?";
         $stmt = $db->prepare($query);
         $stmt->bind_param("i", $awardID);
         $stmt->execute();
         $stmt-> bind_result($aID, $fname, $lname, $uID, $cID, $da, $email);
         $stmt-> fetch();
         printf("%d %s %s %d %d %s %s <br>", $aID, $fname, $lname, $uID,$cID, $da, $email);
         $stmt->close();
                  
        //get award_user from user_id
         $query2 = "SELECT first_name, last_name, sig FROM award_user WHERE id = ?";
         $stmt2 = $db->prepare($query2);
         $stmt2->bind_param("i", $uID);
         $stmt2->execute();
         $stmt2-> bind_result($fname2, $lname2, $sig);
         $stmt2-> fetch();
         printf("%s %s <br>", $fname2, $lname2);
         $stmt2->close();
         
        //save signature to a temp file
         $tmpsig = $aID . "sig.png";
         $file = fopen ($tmpsig, "w");
         fwrite($file, $sig);
         fclose($file);
                 
         //get award type
         $query3 = "SELECT title FROM class WHERE id = ?";
         $stmt3 = $db->prepare($query3);
         $stmt3->bind_param("i", $cID);
         $stmt3->execute();
         $stmt3-> bind_result($title);
         $stmt3-> fetch();
         printf("%s <br>", $title);
         $stmt3->close();
         
        //close db 
        $db->close();
        echo "</br>";
        echo "closed </br>";
         
       //seperate date by month, day ,year
        $year = substr($da, 0,4);
        $month = getMonth(substr($da, 5,2));
        $day = substr ($da, 8,2); 
        $date = $month ." ". $day . ", " . $year;
        printf("%s, %s, %s, %s <br>", $year, $month, $day, $date);
         
       //input data into .tex - data needs to be in an array - get back temp file name
        $recName = $fname . " " . $lname;
        $giveName = $fname2 . " " . $lname2;
        $tmpTex = $aID . "cert.tex";
        echo $tmpTex; 

        $data = [
           "recName" => $recName,
           "giveName" => $giveName,
           "dateAward" => $date,
           "titleAward" => $title,
           "sig" => $tmpsig
           ];
        
        latexFill($data, 'template.tex', $tmpTex);
        
        //create pdf
        
        //send pdf
       
        //delete temp files
        //unlink ($tmpsig);
        //unlink ($tmpTex);
   }
   
   function getMonth ($month){
     if ($month === "01"){
         return "January";
     }
      else if ($month === "02"){
         return "February";
     }
      else if ($month === "03"){
         return "March";
     }
     else if ($month === "04"){
         return "April";
     }
      else if ($month === "05"){
         return "May";
     }
      else if ($month === "06"){
         return "June";
     }
      else if ($month == "07"){
         return "July";
     }
     else if ($month === "08"){
         return "Augaust";
     } 
     else if ($month === "09"){
         return "September";
     }
      else if ($month === "10"){
         return "October";
     }
      else if ($month === "11"){
         return "November";
     }
      else {
         return "December";
     }
 }
   
?>
