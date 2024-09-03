<?php
session_start();
require_once('config.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'] ?? '';
$username = $_SESSION['username'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_name = $_POST['group_name'];
    $members = $_POST['members'];
    
    try {
        $pdo->beginTransaction(); // Démarre une transaction

        // Insérer le groupe dans la base de données
        $stmt = $pdo->prepare("INSERT INTO Groupe (name, created_by) VALUES (?, ?)");
        $stmt->execute([$group_name, $username]);
        $group_id = $pdo->lastInsertId();

        echo "Groupe créé avec ID: " . $group_id . "<br>";

        $membersArray = explode(',', $members);
        foreach ($membersArray as $member) {
            $stmt = $pdo->prepare("INSERT INTO GroupMembers (group_id, member_name) VALUES (?, ?)");
            $stmt->execute([$group_id, trim($member)]);
        }

        // Mettre à jour les rôles
        $stmt = $pdo->prepare("SELECT roles FROM User WHERE id = ?");
        $stmt->execute([$user_id]);
        $currentRolesJson = $stmt->fetchColumn();
        $currentRolesArray = json_decode($currentRolesJson, true) ?: [];

        if (!in_array("Chef de groupe", $currentRolesArray)) {
            $currentRolesArray[] = "Chef de groupe";
            $newRolesJson = json_encode($currentRolesArray);
            $stmt = $pdo->prepare("UPDATE User SET roles = ? WHERE id = ?");
            $stmt->execute([$newRolesJson, $user_id]);
        }

        // Mettre à jour les group_ids
        $stmt = $pdo->prepare("SELECT group_ids FROM User WHERE id = ?");
        $stmt->execute([$user_id]);
        $currentGroupIdsJson = $stmt->fetchColumn();
        $currentGroupIdsArray = json_decode($currentGroupIdsJson, true) ?: [];

        echo "Groupes actuels avant mise à jour: ";
        var_dump($currentGroupIdsArray);

        if (!in_array($group_id, $currentGroupIdsArray)) {
            $currentGroupIdsArray[] = $group_id;
            $newGroupIdsJson = json_encode($currentGroupIdsArray);
            $stmt = $pdo->prepare("UPDATE User SET group_ids = ? WHERE id = ?");
            $stmt->execute([$newGroupIdsJson, $user_id]);

            echo "Nouveaux groupes après mise à jour: ";
            var_dump($currentGroupIdsArray);
        } else {
            echo "Le groupe est déjà dans la liste des groupes.";
        }

        $pdo->commit(); // Valide la transaction

    } catch (PDOException $e) {
        $pdo->rollBack(); // Annule la transaction en cas d'erreur
        echo "Erreur SQL: " . $e->getMessage();
    }

    header("Location: group_success.php");
    exit;
}
?>
