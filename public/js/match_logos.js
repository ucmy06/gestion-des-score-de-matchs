function loadLogoGauche() {
    var logogauche = document.getElementById("logo_equipe_gauche").files;
    if (logogauche.length > 0) {
        var fileToLoad = logogauche[0];
        var fileReader = new FileReader();

        fileReader.onload = function(fileLoadedEvent) {
            var logoUrl = fileLoadedEvent.target.result;
            document.getElementById('af_logo_gauche').src = logoUrl;
            document.getElementById('CPlogoEquipeG_RM').src = logoUrl;
            document.getElementById('CPlogoEquipeG').src = logoUrl;
        };

        fileReader.readAsDataURL(fileToLoad);
    }

    flashSave(); // Si flashSave() est défini ailleurs dans votre code
}

function loadLogoDroite() {
    var logodroite = document.getElementById("logo_equipe_droite").files;
    if (logodroite.length > 0) {
        var fileToLoad = logodroite[0];
        var fileReader = new FileReader();

        fileReader.onload = function(fileLoadedEvent) {
            var logoUrl = fileLoadedEvent.target.result;
            document.getElementById('af_logo_droite').src = logoUrl;
            document.getElementById('CPlogoEquipeD_RM').src = logoUrl;
            document.getElementById('CPlogoEquipeD').src = logoUrl;
        };

        fileReader.readAsDataURL(fileToLoad);
    }

    flashSave(); // Si flashSave() est défini ailleurs dans votre code
}

function killLogoGauche() {
    document.getElementById('logo_equipe_gauche').value = '';
    document.getElementById('af_logo_gauche').src = '';
    document.getElementById('CPlogoEquipeG').src = '';
    document.getElementById('CPlogoEquipeG_RM').src = '';
    flashSave(); // Si flashSave() est défini ailleurs dans votre code
}

function killLogoDroite() {
    document.getElementById('logo_equipe_droite').value = '';
    document.getElementById('af_logo_droite').src = '';
    document.getElementById('CPlogoEquipeD').src = '';
    document.getElementById('CPlogoEquipeD_RM').src = '';
    flashSave(); // Si flashSave() est défini ailleurs dans votre code
}
