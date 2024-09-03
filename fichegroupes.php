<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Groupe</title>
    <link rel="icon" type="logo" href="img/logo.png">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .group-details {
            margin-bottom: 20px;
        }
        .group-details h2 {
            margin: 0 0 10px;
            font-size: 1.5em;
        }
        .group-details div {
            margin-bottom: 10px;
        }
        .participants, .events {
            margin-bottom: 20px;
        }
        .participants .card, .events .card {
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin-bottom: 10px;
        }
        .participants .card h3, .events .card h3 {
            margin: 0;
            font-size: 1.2em;
        }
        .button-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .button-container button {
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            color: white;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button-container .modify {
            background-color: #3498db;
        }
        .button-container .modify:hover {
            background-color: #2980b9;
        }
        .button-container .quit {
            background-color: #e67e22;
        }
        .button-container .quit:hover {
            background-color: #d35400;
        }
        .button-container .delete {
            background-color: #e74c3c;
        }
        .button-container .delete:hover {
            background-color: #c0392b;
        }
        @media (max-width: 768px) {
            .group-details, .participants, .events {
                margin-bottom: 10px;
            }
            .button-container {
                flex-direction: column;
                align-items: center;
            }
            .button-container button {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Détails du Groupe: Nom du Groupe</h1>
        <div class="group-details">
            <h2>Chef de Groupe: Alice Dupont</h2>
            <div>Participants: 15</div>
            <div>Évènements: 3</div>
        </div>
        <div class="participants">
            <h2>Participants</h2>
            <div class="card">
                <h3>Participant 1</h3>
            </div>
            <div class="card">
                <h3>Participant 2</h3>
            </div>
            <div class="card">
                <h3>Participant 3</h3>
            </div>
            <!-- Répétez pour tous les participants -->
        </div>
        <div class="events">
            <h2>Évènements</h2>
            <div class="card">
                <h3>Évènement 1</h3>
            </div>
            <div class="card">
                <h3>Évènement 2</h3>
            </div>
            <div class="card">
                <h3>Évènement 3</h3>
            </div>
            <!-- Répétez pour tous les évènements -->
        </div>
        <div class="button-container">
            <button class="modify" onclick="modifyGroup()">Modifier</button>
            <button class="quit" onclick="confirmQuit()">Quitter</button>
            <button class="delete" onclick="confirmDelete()">Supprimer le Groupe</button>
        </div>
    </div>

    <script>
        function modifyGroup() {
            // Logique pour modifier le groupe (rediriger ou afficher un formulaire)
            alert('Modification du groupe');
        }

        function confirmQuit() {
            if (confirm('Êtes-vous sûr de vouloir quitter ce groupe ?')) {
                // Logique pour quitter le groupe
                alert('Vous avez quitté le groupe.');
            }
        }

        function confirmDelete() {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce groupe ? Cette action est irréversible.')) {
                // Logique pour supprimer le groupe
                alert('Le groupe a été supprimé.');
            }
        }
    </script>
</body>
</html>
