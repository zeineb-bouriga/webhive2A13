<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/maghraoui/public/css/style.css">
    <title>Edit Article</title>
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

        .error-popup {
            display: flex;
            align-items: center;
        }

        .form-group input, .form-group textarea{
            width: 100%;
        }

    </style>
    <script>
    // Fonction de validation pour chaque champ
    function validateField(event, fieldId, errorId, regex, minLength, maxLength, required, fileTypes) {
        const field = document.getElementById(fieldId);
        const value = field.value.trim();
        const errorElement = document.getElementById(errorId);
        let errorMessage = '';

        // Validation pour les champs texte
        if (required && !value) {
            errorMessage = `<span class="error-icon">⚠️</span> Le champ '${fieldId}' est requis.`;
        } else if (regex && !regex.test(value)) {
            errorMessage = `<span class="error-icon">⚠️</span> Le champ '${fieldId}' ne respecte pas le format requis.`;
        } else if (minLength && value.length < minLength) {
            errorMessage = `<span class="error-icon">⚠️</span> Le champ '${fieldId}' doit comporter au moins ${minLength} caractères.`;
        } else if (maxLength && value.length > maxLength) {
            errorMessage = `<span class="error-icon">⚠️</span> Le champ '${fieldId}' ne doit pas dépasser ${maxLength} caractères.`;
        }

        // Validation de l'image (uniquement si un fichier est sélectionné)
        if (fileTypes && fieldId === 'articlePicture') {
            const file = field.files[0];
            if (file) {
                const fileExtension = file.name.split('.').pop().toLowerCase();
                if (!fileTypes.includes(fileExtension)) {
                    errorMessage = `<span class="error-icon">⚠️</span> Seuls les fichiers JPG, JPEG, PNG, et GIF sont autorisés.`;
                }
            }
        }

        // Afficher ou cacher le message d'erreur
        if (errorMessage) {
            errorElement.innerHTML = errorMessage;
            errorElement.style.display = 'flex';
        } else {
            errorElement.style.display = 'none';
        }

        // Activer ou désactiver le bouton en fonction de l'état de validation
        toggleSubmitButton();
    }

    // Fonction pour activer/désactiver le bouton de soumission
    function toggleSubmitButton() {
        const titleError = document.getElementById('titleError').innerHTML;
        const descriptionError = document.getElementById('descriptionError').innerHTML;
        const pictureError = document.getElementById('pictureError').innerHTML;
        const submitButton = document.getElementById('submitButton');

        // Si toutes les erreurs sont vides, activer le bouton de soumission
        if (!titleError && !descriptionError && !pictureError) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    // Fonction de validation globale lors de la soumission du formulaire
    function validateForm(event) {
        event.preventDefault();

        // Validation pour chaque champ
        validateField(event, 'title', 'titleError', /^[a-zA-Z0-9\s]{1,40}$/, 1, 40, true);
        validateField(event, 'description', 'descriptionError', null, 20, 300, true);
        validateField(event, 'articlePicture', 'pictureError', null, null, null, false, ['jpg', 'jpeg', 'png', 'gif']);

        // Si aucune erreur n'est détectée, soumettre le formulaire
        if (!document.getElementById('titleError').innerHTML &&
            !document.getElementById('descriptionError').innerHTML &&
            !document.getElementById('pictureError').innerHTML) {
            event.target.submit(); // Soumettre le formulaire
        }
    }

    // Ajouter des gestionnaires d'événements pour chaque champ
    window.onload = function() {
        document.getElementById('title').addEventListener('blur', function(event) {
            validateField(event, 'title', 'titleError', /^[a-zA-Z0-9\s]{1,40}$/, 1, 40, true);
        });

        document.getElementById('description').addEventListener('blur', function(event) {
            validateField(event, 'description', 'descriptionError', null, 20, 300, true);
        });

        document.getElementById('articlePicture').addEventListener('change', function(event) {
            validateField(event, 'articlePicture', 'pictureError', null, null, null, false, ['jpg', 'jpeg', 'png', 'gif']);
        });
    };
</script>

</head>
<body>
    <header>
        <h1>Edit Article</h1>
    </header>

    <div class="container">
        <form method="POST" action="/maghraoui/public/index.php?action=edit&id=<?= $article['id'] ?>" enctype="multipart/form-data" onsubmit="validateForm(event)">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($article['title']) ?>" required>
                <div id="titleError" class="error"></div> <!-- Message d'erreur pour le titre -->
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" required><?= htmlspecialchars($article['description']) ?></textarea>
                <div id="descriptionError" class="error"></div> <!-- Message d'erreur pour la description -->
            </div>
            
            <div class="form-group">
                <label for="articlePicture">Picture</label>
                <input type="file" name="articlePicture" id="articlePicture">
                <div id="pictureError" class="error"></div> <!-- Message d'erreur pour l'image -->
                
                <?php if (!empty($article['articlePicture'])): ?>
                    <div class="current-image">
                        <p>Current Image:</p>
                        <img src="/maghraoui/public/uploads/<?= htmlspecialchars($article['articlePicture']) ?>" alt="Current Article Picture" width="100">
                    </div>
                <?php endif; ?>
            </div>
            <br><br>
            <div class="form-group">
                <button type="submit" id="submitButton" >Update Article</button>
                <a href="/maghraoui/public" class="btn">Back to List</a>
            </div>
        </form>
    </div>
</body>
</html>
