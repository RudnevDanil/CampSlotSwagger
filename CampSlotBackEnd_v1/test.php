<?php 
if(/*isset($_POST['id_card'])&&isset($_POST['newDate'])*/true)
{
    //$newDate = $_POST['newDate'];
    //$id_card = $_POST['id_card'];
    include("dbconnect.php");
    $query = "SELECT * FROM `lm_auth`;";
    if ($result = $mysqli->query($query))
    {
        //$arr = $result->fetch_array(MYSQLI_ASSOC);// для одной строки
        $arr = $result->fetch_all();// для всего массива
        echo json_encode(array("error"=>"", "arr"=>$arr));
        $result->close();
    }
    else
    {
        echo json_encode(array("error"=>"query select error"));
    }
    
    mysqli_close($connection);
}
else
    echo json_encode(array("error"=>"wrong params"));
    
?>