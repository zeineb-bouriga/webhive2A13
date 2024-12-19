<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/maghraoui/public/css/style.css">
    <title>Create Article</title>
    <style>
        .error {
            display: none; /* Par défaut, l'erreur est cachée */
            background-color: rgba(255, 0, 0, 0.9); /* Fond rouge pour l'erreur */
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 0.9em;
            margin-top: 5px;
            position: absolute;
            z-index: 100;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease-out;
        }

        /* Animation pour faire apparaître l'erreur en douceur */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .error-icon {
            margin-right: 5px;
            font-size: 1.2em;
        }

        /* Positionner les messages d'erreur juste en dessous des champs */
        .form-group {
            position: relative;
        }

        .form-group input, .form-group textarea{
            width: 100%;
        }
    </style>
    <script>
        // Fonction de validation pour chaque champ
        function validateField(fieldId, errorId, regex, minLength, maxLength, required, fileTypes) {
            const field = document.getElementById(fieldId);
            const value = field.value.trim();
            const errorElement = document.getElementById(errorId);
            let errorMessage = '';

            // Vérification de la présence
            if (required && !value) {
                errorMessage = `<span class="error-icon">⚠️</span> Le champ '${fieldId}' est requis.`;
            }
            // Vérification du format pour le titre
            else if (regex && !regex.test(value)) {
                errorMessage = `<span class="error-icon">⚠️</span> Le champ '${fieldId}' ne respecte pas le format requis.`;
            }
            // Vérification de la longueur du texte
            else if (minLength && value.length < minLength) {
                errorMessage = `<span class="error-icon">⚠️</span> Le champ '${fieldId}' doit comporter au moins ${minLength} caractères.`;
            } 
            // Vérification de la longueur maximale du texte
            else if (maxLength && value.length > maxLength) {
                errorMessage = `<span class="error-icon">⚠️</span> Le champ '${fieldId}' ne doit pas dépasser ${maxLength} caractères.`;
            }

            // Validation de l'image
            if (fileTypes && fieldId === 'articlePicture') {
                const file = field.files[0];
                if (!file) {
                    errorMessage = `<span class="error-icon">⚠️</span> Une image est obligatoire. Veuillez en sélectionner une.`;
                } else {
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    if (!fileTypes.includes(fileExtension)) {
                        errorMessage = `<span class="error-icon">⚠️</span> Seuls les fichiers JPG, JPEG, PNG, et GIF sont autorisés.`;
                    }
                }
            }

            // Affichage ou suppression du message d'erreur
            if (errorMessage) {
                errorElement.innerHTML = errorMessage;
                errorElement.style.display = 'flex'; // Afficher l'erreur
            } else {
                errorElement.style.display = 'none'; // Cacher l'erreur si aucun problème
            }

            // Activation ou désactivation du bouton de soumission
            toggleSubmitButton();
        }

        // Fonction pour activer/désactiver le bouton
        // function toggleSubmitButton() {
        //     const titleError = document.getElementById('titleError').innerHTML.trim();
        //     const descriptionError = document.getElementById('descriptionError').innerHTML.trim();
        //     const pictureError = document.getElementById('pictureError').innerHTML.trim();
        //     const submitButton = document.getElementById('submitButton');

        //     // Si toutes les erreurs sont vides, le bouton est activé
        //     if (!titleError && !descriptionError && !pictureError) {
        //         submitButton.disabled = false;
        //     } else {
        //         submitButton.disabled = true;
        //     }
        // }

        // Ajouter des gestionnaires d'événements pour chaque champ
        window.onload = function() {
            document.getElementById('title').addEventListener('blur', function() {
                validateField('title', 'titleError', /^[a-zA-Z0-9\s]{1,40}$/, 1, 40, true);
            });

            document.getElementById('description').addEventListener('blur', function() {
                validateField('description', 'descriptionError', null, 20, 300, true);
            });

            document.getElementById('articlePicture').addEventListener('change', function() {
                validateField('articlePicture', 'pictureError', null, null, null, true, ['jpg', 'jpeg', 'png', 'gif']);
            });
        };
    </script>
</head>
<body>

    <header>
        <h1>Create New Article</h1>
    </header>

    <div class="container">
        <form method="POST" action="/maghraoui/public/index.php?action=create" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" required>
                <div id="titleError" class="error"></div> <!-- Fenêtre d'erreur pour le titre -->
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" required></textarea>
                <div id="descriptionError" class="error"></div> <!-- Fenêtre d'erreur pour la description -->
            </div>
            
            <div class="form-group">
                <label for="articlePicture">Picture</label>
                <input type="file" name="articlePicture" id="articlePicture" required>
                <div id="pictureError" class="error"></div> <!-- Fenêtre d'erreur pour l'image -->
            </div>
            <br><br><br>            
            <div class="form-group">
                <button type="submit" id="submitButton">Save Article</button> <!-- Bouton désactivé par défaut -->
                <a href="/maghraoui/public" class="btn">Back to List</a>
            </div>
        </form>
    </div>
</body>
</html>
