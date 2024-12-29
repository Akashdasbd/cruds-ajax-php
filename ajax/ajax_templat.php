<?php 

if (file_exists(__DIR__.'/../autoload.php')) {
    require_once __DIR__.'/../autoload.php';
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {

    case 'status_change';
    $id = $_POST["status_id"];
    $status = $_POST["status"];
    if($status == 1){
        $update_status = 0;
    }else{
        $update_status = 1;
    }
    
    $sql = "UPDATE students SET status = ? WHERE id = ?";
    $statement = connection()->prepare($sql);
    $statement->execute([$update_status,$id]);
    return true;
     break;

    case 'student_delete':
        $id = $_POST['delet_id'];
        $delet_img =$_POST['delet_img'];

        if(isset($delet_img)){
            if (file_exists(__DIR__.'/../media/students/'.$delet_img)) {
                unlink(__DIR__.'/../media/students/'.$delet_img);
            }
        };

        $sql = "DELETE FROM students WHERE id = ?";
        $statement =connection()->prepare($sql);
        $statement->execute([$id]);
        break;
    case 'student_creat':
        $name = $_POST['name'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $location = $_POST['location'];
        $photo = fille_upload([
            "name" => $_FILES["photo"]["name"],
            "tmp_name" => $_FILES["photo"]["tmp_name"],
        ],"../media/students/");
        $sql = "INSERT INTO students(name,email,age,location,photo) VALUES(?,?,?,?,?)";
        $statement =  connection()->prepare($sql);
        $statement->execute([$name,$email,$age,$location,$photo]);
        echo $name;
        break;
    case 'student_update':
        $id = $_POST['edit_id'];
        $sql ="SELECT * FROM students WHERE id = ?";
        $statement = connection()->prepare($sql);
        $statement->execute([$id]);
        $data = $statement->fetch(PDO::FETCH_OBJ);
        echo json_encode($data);
        break;
    case 'student_update_submit':
        $id = $_POST['edit_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $location = $_POST['location'];
        $updat_photo = $_POST["photo_url"];
        if ($_FILES["new_photo"]["name"]) {
            $updat_photo= fille_upload([
                "name" => $_FILES["new_photo"]["name"],
                "tmp_name" => $_FILES["new_photo"]["tmp_name"],
            ],"../media/students/");
            if(file_exists("../media/students/".$_POST['photo_url'])){
                unlink("../media/students/".$_POST['photo_url']);
            }
        }
        echo $updat_photo;
        $sql = "UPDATE students SET name = ?, email = ?, age = ?, location = ?, photo = ? WHERE id = ?";
        $statement = connection()->prepare($sql);
        $statement->execute([$name,$email,$age,$location,$updat_photo,$id]);
        break;
    case 'student_view':
        $id = $_POST['view_id'];
        $sql ="SELECT * FROM students WHERE id = ?";
        $statement = connection()->prepare($sql);
        $statement->execute([$id]); 
        $data = $statement->fetch(PDO::FETCH_OBJ);
        echo json_encode($data);
        break;
    case 'all_student':
        $sql="SELECT * FROM students";
        $statement=connection()->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($data);
        break;
}