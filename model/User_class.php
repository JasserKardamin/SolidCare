<?php 

class user {

    public function select_patient($cin) {
        include 'db_connect_front.php' ; 
        if($cin == -1){
            $q = $pdo->prepare('SELECT * FROM user WHERE typee = "patient" ');  
            $q->execute() ;
            return($q->fetchAll(PDO::FETCH_ASSOC));
        }
        else {
            $q = $pdo->prepare('SELECT * FROM user WHERE typee = "patient" AND CIN = :cin') ;
            $q->bindParam(':cin',$cin);
            $q->execute() ;
            return($q->fetchAll(PDO::FETCH_ASSOC));  
        }
    }
    
    public function select_nurse($cin){
        include 'db_connect_front.php' ; 
        if($cin == -1){
            $q = $pdo->prepare('SELECT * FROM user WHERE typee = "nurse" ');  
            $q->execute() ;
            return($q->fetchAll(PDO::FETCH_ASSOC));
        }
        else {
            $q = $pdo->prepare('SELECT * FROM user WHERE typee = "nurse" AND CIN = :cin') ;
            $q->bindParam(':cin',$cin);
            $q->execute() ;
            return($q->fetchAll(PDO::FETCH_ASSOC));  
        }
    }

}

?>