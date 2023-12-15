<?php

class subs {

    public function delete_sub($id){
        require 'db_connect_front.php' ; 
        
        $query = $pdo->prepare('DELETE FROM sbscriptions WHERE id_subscription =:id') ;
        $query->bindParam(':id', $id) ;   
        $query->execute() ;   

    }

    public function modify_sub($id,$cin,$name){ 
        require 'db_connect_front.php' ; 
        
        $query = $pdo->prepare('UPDATE sbscriptions SET cin_user = :cin, offre_name = :name WHERE id_subscription = :id');
        $query->bindParam(':id', $id);
        $query->bindParam(':name', $name);
        $query->bindParam(':cin', $cin);
        $query->execute();
    }

    public function select_sub($id){
        require 'db_connect_front.php' ; 
            if ($id == -1) {
            $query = $pdo->prepare('SELECT * FROM sbscriptions ') ; 
            $query->execute() ; 
            return($query->fetchAll(PDO::FETCH_ASSOC)) ; 
        }
        else {
            $query = $pdo->prepare('SELECT * FROM sbscriptions WHERE  id_subscription = :id') ;
            $query->bindParam(':id',$name) ;
            $query->execute() ;
            return($query->fetchAll(PDO::FETCH_ASSOC)) ;    
        }

    }

    public function count_subs($plan_name) {
        require 'db_connect_front.php' ; 

        $query = $pdo->prepare('SELECT offre_name as name, COUNT(id_subscription) as subscription_count 
                                FROM sbscriptions WHERE offre_name = :name_ofr GROUP BY offre_name');
        $query->bindParam(':name_ofr', $plan_name);
        $query->execute();

        return($query->fetch(PDO::FETCH_ASSOC));
    }
}

class plans {

    public function delete_discount($id,$name,$old_price){

        require 'db_connect_front.php' ; 
        try{
            $q1 = $pdo->prepare('UPDATE plans SET price = :pr WHERE name = :nm ') ;
            $q1->bindParam(':pr',$old_price);  
            $q1->bindParam(':nm',$name);    
            $q1->execute() ; 
        
            $q = $pdo->prepare('DELETE FROM discounts WHERE name = :nm') ;
            $q->bindParam(':nm',$name) ;   
            $q->execute() ; 
        }catch(PDOException $e){
            echo 'error'.$e->getMessage() ; 
        }
    }
    public function set_discount($name,$discount,$duration){
        require 'db_connect_front.php' ; 

        $startDate = new DateTime();
        $p = $pdo->prepare('SELECT * FROM plans WHERE name = :n') ;
        $p->bindParam(':n',$name) ;
        $p->execute() ;  
        $r = $p->fetch(PDO::FETCH_ASSOC) ; 
        $old_price = $r['price'];
        $new_price = $old_price - ( $old_price * ($discount/100) )  ;  

        try{
            $q = $pdo->prepare('UPDATE plans SET price = :np WHERE name = :nm') ;
            $q->bindParam('np',$new_price) ;
            $q->bindParam('nm',$r['name']) ;
            $q->execute()  ;  
        }catch(PDOException $e) {
            echo 'error'.$e->getMessage() ; 
        }

        try{
            $q = $pdo->prepare('INSERT INTO discounts(name,discount,ending,old_price) VALUES(:name,:disc,:date,:old) ') ; 
            $q->bindParam(':name',$name) ; 
            $q->bindParam(':disc',$discount) ;
            $startDate->modify('+' . $duration);
            $end = $startDate->getTimestamp(); 
            $q->bindParam(':date',date('Y-m-d H:i:s',$end)) ;
            $q->bindParam(':old',$old_price) ; 
            $q->execute() ; 
        }catch(PDOExcption $e){
            echo 'error'.$e->getMessage() ; 
        }
    }
    public function add_plan($name,$price,$desc,$duration){
        require 'db_connect_front.php' ; 

            $query = $pdo->prepare('INSERT INTO plans (name, price, description, duration) VALUES (:name, :price, :desc, :duration)');
            $query->bindParam(':name', $name);
            $query->bindParam(':price', $price);
            $query->bindParam(':desc', $desc);
            $query->bindParam(':duration', $duration);
            $query->execute();
    }

    public function update_plan($name,$price,$desc,$duration){
        require 'db_connect_front.php' ; 

            $query = $pdo->prepare('UPDATE plans SET price = :price, description = :desc, duration = :duration WHERE name = :name');
            $query->bindParam(':name', $name);
            $query->bindParam(':price', $price);
            $query->bindParam(':desc', $desc);
            $query->bindParam(':duration', $duration);
            $query->execute();
    }

    public function delete_plan($rowname){
        require 'db_connect_front.php' ; 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $query = $pdo->prepare('DELETE FROM plans WHERE name = :name') ;
                $query->bindParam(':name', $rowname) ;   
                $query->execute() ; 
            }
        }

    public function modify_plan($name){

    }


    public function select_plans($name){
        require 'db_connect_front.php' ; 

        if($name == -1) {
            $query = $pdo->prepare('SELECT * FROM plans') ;
            $query->execute() ; 
            return($query->fetchAll(PDO::FETCH_ASSOC)) ; 
        }

        else {
            $query = $pdo->prepare('SELECT * FROM plans WHERE name = :name ') ;
            $query->bindParam(':name',$name) ; 
            $query->execute() ; 
            return($query->fetchAll(PDO::FETCH_ASSOC)) ; 
        } 
    }

    
}

?>