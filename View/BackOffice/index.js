document.getElementById('editForm').addEventListener('submit', function(event) {
    var nom = document.getElementById('nom').value;
    var prenom = document.getElementById('prenom').value;
    var email = document.getElementById('email').value;

    if (nom.length < 20) {
        alert("Le nom doit contenir au moins 20 caractères.");
        event.preventDefault(); // Prevent form submission
    }

    if (prenom.length < 20) {
        alert("Le prénom doit contenir au moins 20 caractères.");
        event.preventDefault(); // Prevent form submission
    }

    if (!email.includes('@')) {
        alert("Veuillez entrer un email valide.");
        event.preventDefault(); // Prevent form submission
    }
});