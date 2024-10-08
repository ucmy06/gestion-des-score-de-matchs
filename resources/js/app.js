import './bootstrap';
import '../css/app.css'; // Assurez-vous que ce chemin est correct
import Echo from 'laravel-echo';


// Ajoutez une animation pour le message d'erreur
document.addEventListener("DOMContentLoaded", function() {
    const errorMessages = document.querySelectorAll('.text-danger');
    errorMessages.forEach(function(error) {
        error.style.opacity = 0;
        setTimeout(function() {
            error.style.opacity = 1;
            error.style.transition = "opacity 0.5s ease-in-out";
        }, 100);
    });
});

// Animation pour le bouton
const loginButton = document.querySelector('.btn-primary');
loginButton.addEventListener('mouseover', function() {
    this.style.transform = 'scale(1.05)';
    this.style.transition = 'transform 0.2s';
});
loginButton.addEventListener('mouseout', function() {
    this.style.transform = 'scale(1)';
});

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});
