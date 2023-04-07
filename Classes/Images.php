<?php
namespace Classes;

require_once('Classes/Dbh.php');
use Classes\Dbh as Dbh;

class Images extends Dbh {
    public function getImages ($userId) {
        $statement = $this->create_connection()->prepare("SELECT * FROM Images WHERE userId = ?");

        $statement->execute([$userId]);
        return $statement->fetchAll();
    }

    public function postImage ($userId, $image, $name){

        $statement = $this->create_connection()->prepare("SELECT count(*) FROM Images WHERE userId = ?");
        $statement->execute([$userId]);
        $rowsReturned = $statement->fetchColumn();
        
       if($rowsReturned >= 4) {
            echo "user already has this shti lol";
       } else {
        $statement =  $this->create_connection()->prepare("INSERT INTO Images (image, name, userId)
        VALUES (:image, :name, :userId)");
       $statement->bindValue('image', $image);
       $statement->bindValue('name', $name);
       $statement->bindValue('userId', $userId);

       
       return $statement->execute();
       }
 
    }

    public function getImageById ($id){
        $statement =  $this->create_connection()->prepare("SELECT * FROM Images WHERE id = ?");
        $statement->execute([$id]);

        //fetchAll returns a whole array where the first data is found by putting index 0...use fetch to not need [0] / only one result
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteImage ($id){
        $statement = $this->create_connection()->prepare("DELETE FROM Images WHERE id = ?");
        $statement->execute([$id]);
    }

}

?>