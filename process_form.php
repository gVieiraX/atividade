<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $age = trim($_POST['age']);
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $description = trim($_POST['description']);

    $errors = [];

    if (empty($fullName)) {
        $errors[] = "O nome completo é obrigatório.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Um e-mail válido é obrigatório.";
    }
    if (empty($age) || !is_numeric($age)) {
        $errors[] = "A idade é obrigatória e deve ser um número.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        echo "<a href='index.html'>Voltar</a>";
    } else {
        require 'db_connection.php';
        $stmt = $conn->prepare("INSERT INTO users (fullName, email, age, gender, country, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisss", $fullName, $email, $age, $gender, $country, $description);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Dados registrados com sucesso!</p>";
            echo "<a href='index.html'>Voltar</a>";
        } else {
            echo "<p style='color:red;'>Erro ao registrar dados.</p>";
            echo "<a href='index.html'>Voltar</a>";
        }
        $stmt->close();
        $conn->close();
    }
}
?>
