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
    $("#ajouter").click(function () {
        uploadImage();
        return;
        var name = $("#name").val();
        var lastName = $("#last_name").val();
        var classeId = $("#classe").val();
        var tel = $("#tel").val();
        var adresse = $("#adresse").val();

        if (isEmpty(name) || isEmpty(lastName) || isEmpty(classeId) || isEmpty(tel) || isEmpty(adresse))
            //TODO : notif
            alert("Merci de remplire tous les champs");
        else
            $.ajax({
                type: "POST",
                url: "ajouterEleve.php",
                data: {
                    name: name,
                    lastName: lastName,
                    classeId: classeId,
                    tel: tel,
                    adresse: adresse
                },
                dataType: "html",
                success: function (html) {
                    /*TODO : handle error base on index.php output*/
                    if (html == false) {
                        alert("can't process data !");
                    }
                    else {
                        alert("éleve ajouté");
                    }

                }

            })
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



    function uploadImage() {
        var pictureInput = $("#imgInput");
        var myFormData = new FormData();
        myFormData.append('pictureFile', pictureInput.files[0]);
        $.ajax({
            url: 'ppUpload.php',
            type: 'POST',
            processData: false, // important
            contentType: false, // important
            data: myFormData,
            success: function () {
                alert("uploaded");
            }
        })
    }
});