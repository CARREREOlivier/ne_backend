<?php
require_once 'repositories/UserRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];

    $userRepo = new UserRepository();  // Pas besoin de passer la connexion ici
    $created = $userRepo->createUser($username, $email, $password, $role_id);

    if ($created) {
        echo "Utilisateur créé avec succès";
    } else {
        echo "Erreur lors de la création de l'utilisateur";
    }
}

?>

<form method="POST" action="CreateUser.php">
    <label>Nom d'utilisateur:</label>
    <input type="text" name="username" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Mot de passe:</label>
    <input type="password" name="password" required><br>

    <label>Rôle:</label>
    <select name="role_id" required>
        <option value="1">Utilisateur</option>
        <option value="2">Modérateur</option>
        <option value="3">Administrateur</option>
    </select><br>

    <input type="submit" value="Créer l'utilisateur">
</form>
