document.addEventListener('DOMContentLoaded', function() {
    const fullscreenButton = document.getElementById('fullscreen_button');
    
    if (fullscreenButton) {
        fullscreenButton.addEventListener('click', function(event) {
            event.preventDefault();

            // Ouvrir l'URL dans une nouvelle fenêtre
            const url = fullscreenButton.href;
            const newWindow = window.open(url, '_blank');

            // Attendre que la nouvelle fenêtre soit complètement chargée
            newWindow.onload = function() {
                if (newWindow.document.documentElement.requestFullscreen) {
                    newWindow.document.documentElement.requestFullscreen();
                } else if (newWindow.document.documentElement.mozRequestFullScreen) { // Firefox
                    newWindow.document.documentElement.mozRequestFullScreen();
                } else if (newWindow.document.documentElement.webkitRequestFullscreen) { // Chrome, Safari et Opera
                    newWindow.document.documentElement.webkitRequestFullscreen();
                } else if (newWindow.document.documentElement.msRequestFullscreen) { // IE/Edge
                    newWindow.document.documentElement.msRequestFullscreen();
                }
            };
        });
    }
});
