<?php 
$props = json_decode(file_get_contents('php://input'), true);
include("dbconnect.php");
$img = $props['avatar'];
$email = $props['email'];
$login = $props['login'];
$pass = $props['pass'];
$transportName = $props['transportName'];
$transportRating = $props['transportRating'];
try {
    if($img == "" || $email == "" || $login == "" || $pass == "" || $transportName == "" || $transportRating == "")
        throw new Exception('wrong params');
    
    $count = $mysqli->query("SELECT count(id) as count FROM `cs_users` where login='$login';");
    if(!$count)
        throw new Exception('sql error 1');
        
    $count = $count->fetch_array(MYSQLI_ASSOC)["count"];
    if ($count != 0)
        throw new Exception('login busy');
    
    
    $result = $mysqli->query("insert into `cs_users` (id, login, email, pass, transportRating, transportName) values (NULL, '$login', '$email', '$pass', '$transportRating', '$transportName');");
    $userId = $mysqli->query("SELECT LAST_INSERT_ID() as userId;")->fetch_array(MYSQLI_ASSOC)["userId"];
    
    $byf = $mysqli->query("insert into `cs_imgs` (img, userId, postId, commentId) values ('$img', '$userId', NULL, NULL);");
    
    echo json_encode(array("error"=>"", "result"=>$result));

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>