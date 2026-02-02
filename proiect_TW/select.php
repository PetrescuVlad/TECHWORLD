<?php
$link=mysqli_connect("localhost","root","","VladP");
if($link==false)
{
die("ERROR:Conexiunea nu a putut fi realizata".mysqli_connect_error());
}
$sql="SELECT * FROM test1";
if($result = mysqli_query($link,$sql)){
    if(mysqli_num_rows($result)>0){
        echo "<table>";
        echo "<tr>";
        echo "<th>id</th>";
        echo "<th>username</th>";
        echo "<th>password</th>";
        echo "<th>email</th>";
        echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['username']."</td>";
        echo "<td>".$row['password']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "</tr>";
        }echo "</table>";
        
   mysqli_free_result($result);
    }else{
        echo "ERROR:Nu au fost gasite inregistrari.";
    }
}else{
    echo "ERROR:Nu a putut fi pregatit: $sql" . mysqli_error($link);
}
mysqli_close($link);
?>
