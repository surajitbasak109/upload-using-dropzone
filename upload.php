<?php

//include configuration
require_once 'config/config.php';

//$check = getimagesize($_FILES['file']['tmp_name']);
//echo $check;

if (! empty( $_POST['post_id'] ) && ! empty( $_FILES ) )
{
    $post_id = $_POST['post_id'];
    $temp = $_FILES['file']['tmp_name'];
    $sql = "insert into posts SET ";
    $i = 0;
    $params = array();
    foreach ($temp as $key)
    {
        $i++;
        $check = getimagesize($key);
        if ( $check )
        {
            if ($i == 7) break;
            $sql .= "image".$i." = :a_".$i.", ";
        }
    }

    $sql .= " post_id = :b";

    $query = $dbh->prepare($sql);

    $j = 0;
    foreach ($temp as $key)
    {
        $j++;
        $check = getimagesize($key);
        if ( $check )
        {
            if ($i == 7) break;
            $imgContents = addslashes(file_get_contents($key));
            $query->bindParam(":a_".$j, $imgContents);
        }
    }
    echo $sql;
    $query->bindParam(":b", $post_id);
    $query->execute();
}

?>