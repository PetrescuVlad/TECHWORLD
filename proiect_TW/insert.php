<?php
$link=mysqli_connect("localhost","root","","VladP");
if($link==false)
{
die("ERROR:Conexiunea nu a putut fi realizata".mysqli_connect_error());
}
$sql="INSERT INTO test1(username,password,email)VALUES(?,?,?)";
if($stmt = mysqli_prepare($link,$sql)){
    mysqli_stmt_bind_param($stmt,"sss",$username,$password,$email);
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $email = $_REQUEST['email'];
    
    if(mysqli_stmt_execute($stmt)){
        echo "Datele au fost salvate.";
        
    }else{
        echo "ERROR:Nu a putut fi executat:$sql.".mysqli_error($link);
    }
}else{
    echo "ERROR:Nu a putut fi pregatit: $sql" . mysqli_error($link);
}
mysqli_stmt_close($stmt);
mysqli_close($link);
?>
<html>
    <style>
        button{
            padding: 10px; 
            background-color: black;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            display: block;
        }
    </style>
    <body>
    <button type="button" id="signupButton" onclick="redirectToPage()">Log in</button>
    </body>
</html>
<script>
     function redirectToPage() {
            window.location.href = "proiect.php";
        }
</script>
