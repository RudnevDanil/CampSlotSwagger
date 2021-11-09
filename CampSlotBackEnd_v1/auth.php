<?php 
$props = json_decode(file_get_contents('php://input'), true);
include("dbconnect.php");
$login = $props['login'];
$pass = $props['pass'];
try {
    if($login == "" || $pass == "")
        throw new Exception('wrong params');
    
    $count = $mysqli->query("SELECT count(id) as count FROM `cs_users` where login='$login' and pass='$pass';");
    if(!$count)
        throw new Exception('sql error 1');
        
    $count = $count->fetch_array(MYSQLI_ASSOC)["count"];
    if ($count == 0)
        throw new Exception('denied');
    
    echo json_encode(array("error"=>"", "result"=>true));

} catch (Exception $e) {
    echo json_encode(array("error"=>$e->getMessage()));
} finally {
    mysqli_close($connection);
}
    
?>