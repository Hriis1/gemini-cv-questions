<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Примерна форма</title>
</head>

<body>
    <label for="titleInput">Заглавие:</label>
    <input type="text" id="titleInput" name="title">
    <button id="submitButton">Изпрати</button>

    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        
    <script>
        $(document).ready(function () {
            $('#submitButton').click(function () {
                var title = $('#titleInput').val();

                $.ajax({
                    type: 'POST',
                    url: '/your-endpoint',
                    data: { job_title: title },
                    success: function (response) {
                        console.log("success");
                    },
                    error: function () {
                        alert('Error sending handling request');
                    }
                });
            });
        });
    </script>
</body>

</html>