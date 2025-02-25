<?php   
   function estAdmin() {
       global $connexion;

       $courriel = $_SESSION["courriel"];

       $sql = "SELECT CLI_EST_ADMIN FROM VIK_CLIENT WHERE CLI_COURRIEL = :courriel";       
       $stmt = $connexion->prepare($sql);
       $stmt->bindValue(':courriel', $courriel);
       $stmt->execute();
       foreach($stmt as $ligne){
            $admin = $ligne["CLI_EST_ADMIN"];
       }
        
       if($admin == 1){
        return true;
       }
       else{
        return false;
       }
   }
?>

