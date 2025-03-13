$(function () {
    $("#souscriptionForm").validate({
        rules: {
            nom: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                },
            },
            prenom: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                },
            },
            profession: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                },
            },
            dateNais: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                },
            },
            lieuNais: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                },
            },
            adresse: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                },
            },
            telephone: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                },
            },
            /*  nomPere: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            nomMere: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            residencePere: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            residenceMere: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            dateNaisPere: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            dateNaisMere: {
                required: true,
            }, */
            clientSelect: {
                required: true,
            },
            accNo: {
                required: true,
            },
            sexe: {
                required: true,
            },
            situation: {
                required: true,
            },
            beneficiaire: {
                required: true,
            },
            option: {
                required: true,
            },
            date_effet: {
                required: true,
            },
        },
        // Specify validation error messages
        messages: {
            nom: {
                required: "Merci de choisir le client",
                noSpace: "Merci de choisir le client",
            },
            prenom: {
                required: "Merci de choisir le client",
                noSpace: "Merci de choisir le client",
            },
            profession: {
                required: "Le champ profession est obligatoire",
                noSpace: "Le champ profession est obligatoire",
            },
            dateNais: {
                required: "Merci de choisir le client",
                noSpace: "Merci de choisir le client",
            },
            lieuNais: {
                required: "Le champ lieu de naissance est obligatoire",
                noSpace: "Le champ lieu de naissance est obligatoire",
            },
            adresse: {
                required: "Le champ adresse est obligatoire",
                noSpace: "Le champ adresse est obligatoire",
            },
            telephone: {
                required: "Le champ télephone est obligatoire",
                noSpace: "Le champ télephone est obligatoire",
            },
            /* nomPere: {
                required: "Le champ nom et prénom du père est obligatoire",
                noSpace: "Le champ nom et prénom du père est obligatoire"
            },
            nomMere: {
                required: "Le champ nom et prénom de la mère est obligatoire",
                noSpace: "Le champ nom et prénom de la mère est obligatoire"
            },
            residencePere: {
                required: "Le champ lieu de résidence du père est obligatoire",
                noSpace: "Le champ lieu de résidence du père est obligatoire"
            },
            residenceMere: {
                required: "Le champ lieu de résidence de la mère est obligatoire",
                noSpace: "Le champ lieu de résidence de la mère est obligatoire"
            },
            dateNaisPere: {
                required: "Merci de choisir une date valide",
            },
            dateNaisMere: {
                required: "Merci de choisir une date valide",
            }, */

            clientSelect: {
                required: "Merci de choisir le client",
            },
            accNo: {
                required: "Merci de choisir le client",
            },
            sexe: {
                required: "Merci de choisir le client",
            },
            situation: {
                required: "Le champ situation matrimoniale est obligatoire",
            },
            beneficiaire: {
                required: "Le champ béneficiaire est obligatoire",
            },
            option: {
                required: "Le champ option est obligatoire",
            },
            date_effet: {
                required: "Le champ date effet est obligatoire",
            },
        },

        submitHandler: function (form) {
            form.submit();
        },
    });

    //Assureur validation
    var nomPere = $("#nomPere").val();
    var nomMere = $("#nomMere").val();
    var residencePere = $("#residencePere").val();
    var residenceMere = $("#residenceMere").val();
    var dateNaisPere = $("#dateNaisPere").val();
    var dateNaisMere = $("#dateNaisMere").val();

    var message = "";
    $("souscriptionForm").submit(function (e) {
        e.preventDefault();
    });
    if (nomMere == "" || nomPere == "") {
        $("#nomPereMessage").text(
            "Merci de remplir le nom du père ou de la mère"
        );
        $("#nomMereMessage").text(
            "Merci de remplir le nom du père ou de la mère"
        );
        alert("Merci de remplir au moins un assuré associé");
        return false;
    }

    if (nomMere != "" && residenceMere == "") {
        $("#nomPereMessage").text("La résidence de la mère est obligatoire")
            .show;
        alert("Merci de remplir au moins un assuré associé");
        return false;
    }
    if (nomMere != "" && dateNaisMere == "") {
        message = "La date de naissance de la mère de la mère est obligatoire";
        alert("Merci de remplir au moins un assuré associé");
        return false;
    }

    if (nomPere != "" && residencePere == "") {
        message = "La résidence du pere est obligatoire";
        alert("Merci de remplir au moins un assuré associé");
        return false;
    }

    if (nomPere != "" && dateNaisPere == "") {
        message = "La date de naisssance du pere est obligatoire";
        alert("Merci de remplir au moins un assuré associé");
        return false;
    }

    if (nomMere != "" && dateNaisMere != "") {
        var age = calculate_age(dateNaisMere);
        if (age > 70 || age < 18) {
            message =
                "La date de naissance de la mère doit être compris entre 18 et 70 ans";
            alert("Merci de remplir au moins un assuré associé");
            return false;
        }
    }

    if (nomPere != "" && dateNaisPere != "") {
        var age = calculate_age(dateNaisPere);
        if (age > 70 || age < 18) {
            message =
                "La date de naissance de la mère doit être compris entre 18 et 70 ans";
            alert("Merci de remplir au moins un assuré associé");
            return false;
        }
    }
});

function calculate_age(dateSelected) {
    var years = moment().diff(new Date(dateSelected), "years", false);
}

console.log(calculate_age(new Date(1982, 11, 4)));

console.log(calculate_age(new Date(1962, 1, 1)));
