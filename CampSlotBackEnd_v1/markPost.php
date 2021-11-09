<?php 
$props = json_decode(file_get_contents('php://input'), true);
include("dbconnect.php");
$login = $props['login'];
$pass = $props['pass'];
$postId = $props['postId'];
$doMark = $props['doMark'];
try {
    if($login == "" || $pass == "" || $postId == "" || $doMark == "")
        throw new Exception('wrong params');
    
    $count = $mysqli->query("SELECT count(id) as count, id FROM `cs_users` where login='$login' and pass='$pass';");
    if(!$count)
        throw new Exception('sql error 1');
        
    $user = $count->fetch_array(MYSQLI_ASSOC);
    if ($user["count"] == 0)
        throw new Exception('denied');
    $user = $user["id"];
    
    $count = $mysqli->query("SELECT count(id) as count FROM `cs_markedPosts` where userId='$user' and postId='$postId';");
    if(!$count)
        throw new Exception('sql error 2');
    $markCount = $count->fetch_array(MYSQLI_ASSOC)["count"];
    if($doMark == "true"){
        if ($markCount == 0){
            $result = $mysqli->query("insert into `cs_markedPosts` (id, userId, postId) values (NULL, '$user', '$postId');");
            if($result == 0)
                throw new Exception('sql error 3');
            echo json_encode(array("error"=>"", "result"=>$result));
        } else
            throw new Exception('post already marked');
    } else if($doMark == "false"){
        if ($markCount != 0){
            $result = $mysqli->query("DELETE FROM `cs_markedPosts` where userId='$user' and postId='$postId';");
            if($result == 0)
                throw new Exception('sql error 4');
            echo json_encode(array("error"=>"", "result"=>$result));
        } else
            throw new Exception('post already unmarked');
    } else
        throw new Exception('doMark param error');

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>