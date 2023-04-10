<?php

    require_once('Classes/Notes.php');
    require_once('Classes/Images.php');

    use Classes\Notes as Notes;
    use Classes\Images as Images;

    session_start();

    if(isset($_SESSION['username'])){
        $timeLoggedIn = time() - $_SESSION['loginTime'];
        if($timeLoggedIn > 600) {
            header('Location: logout.php');
        } 
       
    } else {
        header("Location: home.php");

    }

    $noteClass = new Notes();
    $imageClass = new Images();
    $username = $_SESSION['username'];
    $userId = $_SESSION['id'];
    $notes = $noteClass->getNotes($userId);
    $images = $imageClass->getImages($userId);

    $currentNote = array(
        "id"=>"",
        "title"=>"", 
        "note"=>""
    );

    $noteButton = "New Note";

    if(isset($_POST['imgSubmit']) && isset($_FILES['image'])){
        if($_FILES['image']['tmp_name']){
            $imgName = $_FILES['image']['name'];
            $img = file_get_contents($_FILES['image']['tmp_name']);
            $imgPosted = $imageClass->postImage($userId, $img, $imgName);
            
            header("Location: dashboard.php");
        }
       
    } 
    
    if(isset($_GET['imgId'])){
        $imageClass->deleteImage($_GET['imgId']);
        header("Location: dashboard.php");

    }

    if(isset($_GET['id'])){
        $currentNote = $noteClass->getNoteById($_GET['id']);
        $noteButton = "Update Note";
    }

   
    if(isset($_POST['noteSubmit'])) {
        //get input from user
        $note = $_POST['note'];
        $title = $_POST['title'];

        if($_POST['id'] !== "") {
            $id = $_POST['id'] ;
            $updateNote = $noteClass->updateNote($id, $title, $note);

        } else {
            $noteClass->postNote($userId, $note, $title);
        }
        
        unset($_POST);
        $currentNote = [
            'title' => '', 
            'note' => ''
        ];
      
        header("Location: dashboard.php");
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./public/app.css">
</head>
<body>
        <nav>
        <ul>
            <li><svg xmlns="http://www.w3.org/2000/svg" width="22px" fill="#DDD1EB" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg></li>
            <li><a href="./dashboard.php">dashboard</a></li>
            
        </ul>
        <ul>
        <li><a href="./logout.php">log out</a></li>
           <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="18px" fill="white"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
           <?php if (isset($_SESSION['username'])) { ?>
            <span>
        
        </span>
        <?php } ?>
            
        </li>
        
        </ul>
        </nav>
        <div>

            <form action="./dashboard.php" method="POST" class="addNote">
                <input type="hidden" name="id" value="<?php echo $currentNote['id']  ?>">
                <label for="title">Note Title:</label>
                <input type="text" name="title" id="title" value="<?php echo $currentNote['title'] ?>">
                <br>
                <label for="note">Note Description:</label>

                <textarea name="note" id="note" cols="30" rows="10"><?php echo $currentNote['note'] ?></textarea>
                <br>
                <button type="submit" name="noteSubmit"><?php echo $noteButton ?></button>


            </form>

            <form action="./dashboard.php" method="POST" enctype="multipart/form-data" class="chooseFile">
            <input type="file" name="image" accept="image/png, image/jpeg, image/*" >
            <br>
            <button type="submit" name='imgSubmit'> Upload Image</button>
            </form>


            <div class="imagesLeft">
                <?php
            foreach($images as $index => $image) {  ?>
                <?php
                    if($index > 1) {
                        break;
                    } 
                ?>
                <div >                
                    <?php echo '<img height="220px" src="data:image/jpeg;base64,'.base64_encode($image['image']).'"/>';?>

                    <a href= "?imgId=<?php echo $image['id']?>" >
                    <svg class="close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15px" fill="#95A4E9"><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>
                </a>

                </div>
                <?php }  ?>
            </div>

            <div class="imagesRight">
                <?php
            foreach($images as $index => $image) {  ?>
                <?php 
                if($index > 1) { 
                ?>
                     <div>                
                        <?php echo '<img height="220px" src="data:image/jpeg;base64,'.base64_encode($image['image']).'"/>';?>
                        <br>
                        <a href= "?imgId=<?php echo $image['id']?>" > 
                        <svg class="close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15px" fill="#95A4E9"><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm79 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>
                        </a>
                    </div>
                <?php } ?>
                <?php } ?>
                
            </div>

            <div class="notes">
                <?php
                foreach($notes as $note) {  ?>
                <div class="note">
                    <p>Title: </p>
                    <?php echo $note["title"];?>
                    <p>Description:</p> 
                    <?php echo $note["note"];?>
                    <br>
                    <br>
                    <br>
                    <svg xmlns="http://www.w3.org/2000/svg" height="15px" fill="#DDD1EB" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>
                    <br>
                    <a href= "?id=<?php echo $note['id']?>" >Edit Note </a>
                    <br>
                    <br>
                </div>
                <?php }  ?>
            </div>

    </div>
</body>
</html>