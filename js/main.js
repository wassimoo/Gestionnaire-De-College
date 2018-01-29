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



    $("#ajouter").click(function(){
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

        
        form_data.append("image",file_data) // Appending parameter named file with properties of file_field to form_data
        form_data.append("name",name ) // Adding extra parameters to form_data
        form_data.append("lastName",lastName )
        form_data.append("classeId",classeId )
        form_data.append("tel",tel )
        form_data.append("adresse",adresse )
        

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
});