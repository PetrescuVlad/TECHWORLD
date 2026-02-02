<?php
// Procesarea autentificării dacă se trimite un request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectarea la baza de date
    $link = mysqli_connect("localhost", "root", "", "VladP");

    if (!$link) {
        die("Conexiunea la baza de date a eșuat: " . mysqli_connect_error());
    }

    // Preia datele trimise prin POST
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verifică dacă username-ul și parola au fost introduse
    if (empty($username) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Te rugăm să introduci atât username-ul cât și parola."]);
        exit;
    }

    // Pregătește și execută interogarea
    $sql = "SELECT * FROM test1 WHERE username = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username); // 's' pentru string
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Verifică dacă utilizatorul există
    if ($row = mysqli_fetch_assoc($result)) {
        // Dacă utilizatorul există, verifică parola
        if ($password == $row['password']) {
            echo json_encode(["success" => true, "message" => "Autentificare reușită"]);
        } else {
            echo json_encode(["success" => false, "message" => "Parolă incorectă."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Utilizatorul nu există."]);
    }

    // Închide conexiunea
    mysqli_stmt_close($stmt);
    mysqli_close($link);

    // Oprește execuția pentru a evita includerea HTML-ului
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Tech World</title>
</head>
<body>
    <header>
        <h1 class="title">TECHWORLD</h1>
        <div class="login">
            <button type="button" id="signupButton" onclick="redirectToPage()">Sign Up</button>
            <input type="text" placeholder="Username" id="username" />
            <input type="password" placeholder="Password" id="password" />
            <button type="button" id="loginButton">Login</button>
            <p id="errorMessage" style="color: red; display: none;">Datele introduse sunt incorecte. Vă rugăm să încercați din nou.</p>
        </div>
    </header>

    <div class="content">
        <div class="definition">
            <h2>Ce reprezintă tehnologia?</h2>
            <p>Tehnologia reprezintă aplicarea cunoștințelor științifice în scopuri practice, pentru a crea instrumente, mașini, tehnici și sisteme care îmbunătățesc viața oamenilor.</p>
        </div>
        <a href="AI.html">
            <div class="box">
                <h2>AI - Inteligență Artificială</h2>
                <p>Descoperă unii dintre cei mai cunoscuți creatori din domeniul AI.</p>
            </div>
        </a>
        <a href="Gadgets.html">
            <div class="box">
                <h2>Gadgets</h2>
                <p>Rămâi la curent cu cele mai noi gadget-uri.</p>
            </div>
        </a>
    </div>

    <script>
        function redirectToPage() {
            window.location.href = "Sign_up.php";
        }

        document.getElementById('loginButton').addEventListener('click', getNameAndPass);

        function getNameAndPass() {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const errorMessage = document.getElementById('errorMessage');

            // Trimite datele la server folosind metoda POST
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirecționează la o altă pagină dacă autentificarea reușește
                    window.location.href = `welcome.html?username=${encodeURIComponent(username)}`;
                } else {
                    // Afișează mesaj de eroare
                    errorMessage.style.display = 'block';
                    errorMessage.textContent = data.message;
                }
            })
            .catch(error => {
                console.error('Eroare la autentificare:', error);
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'A apărut o eroare. Încercați din nou.';
            });
        }
    </script>
</body>
<footer>
    <p class="copywrite">©copywrite. All rights reserved.</p>
</footer>
</html>
