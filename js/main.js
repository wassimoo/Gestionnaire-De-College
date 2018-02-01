function isEmpty(str) {
    return str.length == 0;
}

$(document).ready(function () {
    $("#login_btn").click(function () {
        var pseudo = $("#pseudo").val();
        var password = $("#password").val();
        var request =
            $.ajax({
                type: "POST",
                url: "login.php",
                data: {
                    id: pseudo,
                    pwd: password
                },
                dataType: "html",
                success: function (html) {
                    /*TODO : handle error base on index.php output*/
                    if (html == false)
                        alert("can't login");
                    else
                        window.location.href = "./index.php";
                }

            });
    });

    $("#u_link").click(function () {
        $("#imgInput").trigger('click');
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#uploadpp').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInput").change(function () {
        readURL(this);
    });



    $("#ajouter").click(function () {
        var name = $("#name").val();
        var lastName = $("#last_name").val();
        var classeId = $("#classe").val();
        var tel = $("#tel").val();
        var adresse = $("#adresse").val();
        var file_data = $("#imgInput").prop("files")[0]; // Getting the properties of file from file field
        var form_data = new FormData(); // Creating object of FormData class

        if (isEmpty(name) || isEmpty(lastName) || isEmpty(classeId) || isEmpty(tel) || isEmpty(adresse))
            //TODO : notif
            alert("Merci de remplire tous les champs");


        form_data.append("image", file_data) // Appending parameter named file with properties of file_field to form_data
        form_data.append("name", name) // Adding extra parameters to form_data
        form_data.append("lastName", lastName)
        form_data.append("classeId", classeId)
        form_data.append("tel", tel)
        form_data.append("adresse", adresse)


        $.ajax({
            url: '++eleve.php',
            type: 'POST',
            processData: false, // important
            contentType: false, // important
            data: form_data,
            success: function () {
                alert("uploaded");
            }
        })
    });

    $("#date_picker").on("change", function () {
        var date = $("#date_picker").val().substr(0, 14);
        date += "00:00";
        $.ajax({
            url: "availableProf.php",
            type: "GET",
            data: { hour: date },
            dataType: "html",
            success: function (html) {
                if (html != "false")
                    $("#enseignant").html(html);
                else
                    alert("error");
            }
        })
    });

    $('.class_search').on('change', function () {
        var classeId = $("#classe").val();
        var materiel = $("#materiel").val();
        var date = $("#date_picker").val();
        var idProf = $("#enseignant").val();

        if (idProf == null || idProf == 0 || classeId == 0)
            return;

        $.ajax({
            url: "httpEmptySalles.php",
            type: "POST",
            data: {
                classeId: classeId,
                materiel: materiel,
                date: date,
                idProf: idProf
            },
            dataType: "html",
            success: function (html) {
                if (html != "false")
                    $(".courses").html(html);
                else
                    alert("error");
            }
        })

    });

    $("#classe").on("change", function () {
        var classe = $("#classe").val();

        if (classe == 0 )
          return;

          $.ajax({
            url: "httpEleves.php",
            type: "POST",
            data: {
                classeId: classe
            },
            dataType: "html",
            success: function (html) {
                if (html != "false"){
                   $("#all_eleve").html(html);
                }
                else
                $("#all_eleve").html("<p style='margin-left:25px'>aucun élève dans cette classe</p>");
            }
        })
    });
});

$(document).on("click",".contacts__img", function () {
    var id = $(this).attr('id'); // or var clickedBtnID = this.id
    var seance = $("#seance").val().substr(0, 14);
    if(seance == ""){
        alert("heure d'absence est vide ");
    }
    seance += "00:00";

    $.ajax({
        url: "httpAddAbsence.php",
        type: "POST",
        data: {
            eleveId: id,
            heure : seance
        },
        dataType: "html",
        success: function (html) {
            if (html != "false"){
             
            }
            else
            
        }
    })
});
