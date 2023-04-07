<?php
namespace Classes;

require_once('Classes/Dbh.php');
use Classes\Dbh as Dbh;

class Notes extends Dbh {
    public function getNotes ($userId) {
        $statement = $this->create_connection()->prepare("SELECT * FROM Notes WHERE userId = ?");

        $statement->execute([$userId]);
        return $statement->fetchAll();
    }

    public function postNote ($userId, $note, $title){
        $statement =  $this->create_connection()->prepare("INSERT INTO Notes (note, title, userId)
         VALUES (:note, :title, :userId)");
        $statement->bindValue('title', $title);
        $statement->bindValue('note', $note);
        $statement->bindValue('userId', $userId);

        
        return $statement->execute();
    }

    public function getNoteById ($id){
        $statement =  $this->create_connection()->prepare("SELECT * FROM Notes WHERE id = ?");
        $statement->execute([$id]);

        //fetchAll returns a whole array where the first data is found by putting index 0...use fetch to not need [0] / only one result
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateNote ($id, $title, $note){
        $statement = $this->create_connection()->prepare("UPDATE  Notes SET note = :note, title = :title WHERE id = :id");
        $statement->bindValue('note', $note);
       $statement->bindValue('title', $title);
       $statement->bindValue('id', $id);
        $statement->execute();

    }

    public function deleteNote ($id){
        $statement = $this->create_connection()->prepare("DELETE FROM Notes WHERE id = ?");
        $statement->execute([$id]);
    }

}

?>