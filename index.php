<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Примерна форма</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <main>
        <label for="titleInput">Заглавие:</label>
        <input type="text" id="titleInput" name="title">
        <button id="submitButton">Изпрати</button>

        <!-- Modal -->
        <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="responseModalLabel">Възможни въпроси</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <div id="questionsContainer" class="d-none">
                        </div>
                        <div id="loadingSpinner" class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Затвори</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#submitButton').click(function () {
                var title = $('#titleInput').val();

                // Show the modal with the loading animation
                $('#questionsContainer').addClass("d-none");
                $('#loadingSpinner').removeClass("d-none");
                var responseModal = new bootstrap.Modal($('#responseModal'));
                responseModal.show();

                // Make the AJAX request
                $.ajax({
                    type: 'POST',
                    url: 'include/genQuestions.php',
                    data: { job_title: title },
                    success: function (response) {
                        console.log(response);
                        var parsedResponse = JSON.parse(response);

                        // Format the array into HTML content
                        var formattedResponse = "";
                        parsedResponse.forEach(function (item) {
                            formattedResponse += "<p>" + item + "</p>";
                        });

                        //Show the questions 
                        $('#questionsContainer').removeClass("d-none");
                        $('#loadingSpinner').addClass("d-none");
                        $('#questionsContainer').html(formattedResponse);
                    },
                    error: function () {
                        $('#modalBody').html('<p class="text-danger">Error handling request</p>');
                    }
                });
            });
        });
    </script>
</body>

</html>
