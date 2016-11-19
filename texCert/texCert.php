<?php
/*  bolero-web3 CS'419 F'16
** project group: Candis Pike, Shaun Sluman, Kyle Bedell
*/

	include_once "dbconfig.php";
    include "latexFill.php";
	include "sendPDF.php";
	ini_set('display_errors', 'On');
   
	//type is used as a switch to view the pdf or to send it depending on page user is on            
   function texCert ($awardID, $type = "e"){
         //connect to database - host, username, pass, db
        $db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DB);
    
         if ($db ->connect_error){
               die (" ERROR Could not connect to database. Please try again later. ". $db->conenct_error());
         }
                 
         //get award info from awardID
         $query= "SELECT id, first_name, last_name, user_id, class_id, proclamation, award_date, email FROM award where id = ?";
         $stmt = $db->prepare($query);
         $stmt->bind_param("i", $awardID);
         $stmt->execute();
         $stmt-> bind_result($aID, $fname, $lname, $uID, $cID, $proc, $da, $email);
         $stmt-> fetch();
         $stmt->close();
                  
        //get award_user from user_id
         $query2 = "SELECT first_name, last_name, sig FROM award_user WHERE id = ?";
         $stmt2 = $db->prepare($query2);
         $stmt2->bind_param("i", $uID);
         $stmt2->execute();
         $stmt2-> bind_result($fname2, $lname2, $sig);
         $stmt2-> fetch();
         $stmt2->close();
         
        //save signature to a temp file
         $tmpsig = $aID . "sig.png";
         $file = fopen ($tmpsig, "w");
         fwrite($file, $sig);
         fclose($file);
		 
		 //if file is empty use default
		 if (filesize($tmpsig) ==0)
		 {
			copy ("./img/csk.png", $tmpsig);
		 }
		 
	    //get award type
         $query3 = "SELECT title FROM class WHERE id = ?";
         $stmt3 = $db->prepare($query3);
         $stmt3->bind_param("i", $cID);
         $stmt3->execute();
         $stmt3-> bind_result($title);
         $stmt3-> fetch();
         $stmt3->close();
         
        //close db 
        $db->close();
             
       //seperate date by month, day ,year and restring
        $year = substr($da, 0,4);
        $month = getMonth(substr($da, 5,2));
        $day = substr ($da, 8,2); 
        $date = $month ." ". $day . ", " . $year;
               
       //input data into .tex - data needs to be in an array - also used to send pdf
        $recName = $fname . " " . $lname;
        $giveName = $fname2 . " " . $lname2;
        $tmpTex = $aID . "cert.tex";
        $tmpAux = $aID ."cert.aux";
        $tmpLog = $aID. "cert.log";
		$tmpPDF = $aID. "cert.pdf";
		      
        $data = [
           "recName" => $recName,
           "giveName" => $giveName,
           "dateAward" => $date,
           "titleAward" => $title,
		   "proclamation" => $proc,
           "sig" => $tmpsig
           ];
        
		//call function to create the filled tex
		$texTemplate = "./template/template.tex";
        latexFill($data, $texTemplate, $tmpTex);
        
        //create pdf
		$cmd = "/usr/bin/pdflatex ".$tmpTex;
	    exec($cmd, $output, $error);
		if ($error > 0){
			die ("Error creating PDF. Please try again later.");
		}

		//send or view
	   if ($type === "e"){
		   	//send pdf
			sendPDF ($email, $tmpPDF, $data);	  
	   }
	   else if ($type ==="v"){
			//view pdf
			header("Content-type:application/pdf");
			header('Content-Disposition:inline;filename="'. basename($tmpPDF) .'"');
			readfile($tmpPDF);
	   }
		
		//delete temp files
        unlink ($tmpsig);
        unlink ($tmpTex);
        unlink ($tmpAux);
        unlink ($tmpLog);
		unlink ($tmpPDF);
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
      else if ($month ==="12"){
         return "December";
     }
 }
?>
