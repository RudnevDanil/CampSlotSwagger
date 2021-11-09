<?php 
$props = json_decode(file_get_contents('php://input'), true);
include("dbconnect.php");
$login = $props['login'];
$pass = $props['pass'];
$postId = $props['postId'];
try {
    if($login == "" || $pass == "" || $postId == "")
        throw new Exception('wrong params');
    
    $count = $mysqli->query("SELECT count(id) as count, id FROM `cs_users` where login='$login' and pass='$pass';");
    if(!$count)
        throw new Exception('sql error 1');
        
    $user = $count->fetch_array(MYSQLI_ASSOC);
    if ($user["count"] == 0)
        throw new Exception('denied');
    $user = $user["id"];
    
    $count = $mysqli->query("SELECT count(id) as count FROM `cs_posts` where createdBy='$user' and id='$postId';");
    if(!$count)
        throw new Exception('sql error 2');
    $markCount = $count->fetch_array(MYSQLI_ASSOC)["count"];
    if ($markCount != 0){
        $result = $mysqli->query("DELETE FROM `cs_posts` where createdBy='$user' and id='$postId';");
        if($result == 0)
            throw new Exception('sql error 3');
        echo json_encode(array("error"=>"", "result"=>$result));
    } else
        throw new Exception('post already removed');

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>