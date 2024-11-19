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
        <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="responseModalLabel">Възможни въпроси</h5>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <div id="questionsContainer" class="d-none">
                        </div>
                        <div id="loadingSpinner" class="spinner-border" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#submitButton').click(function () {
                var title = $('#titleInput').val();

                // Show the modal with the loading animation
                $('#questionsContainer').addClass("d-none");
                $('#loadingSpinner').removeClass("d-none");
                $('#responseModal').modal('show');

                // Make the POST request
                $.post('include/genQuestions.php',
                    {
                        job_title: title
                    },
                    function (response) {
                        console.log(response);
                        var parsedResponse = JSON.parse(response);

                        $('#questionsContainer').html("").removeClass("d-none");
                        $('#loadingSpinner').addClass("d-none");

                        function typeTextSequentially(index) {
                            if (index < parsedResponse.length) {
                                var item = parsedResponse[index];
                                var paragraph = $("<p></p>");
                                $('#questionsContainer').append(paragraph);

                                function typeText(element, text, charIndex) {
                                    if (charIndex < text.length) {
                                        element.append(text.charAt(charIndex));
                                        setTimeout(function () {
                                            typeText(element, text, charIndex + 1);
                                        }, 15); // Adjust the speed of typing here
                                    } else {
                                        // Move to the next paragraph after the current one is finished
                                        setTimeout(function () {
                                            typeTextSequentially(index + 1);
                                        }, 100); // Adjust the delay between paragraphs here
                                    }
                                }
                                typeText(paragraph, item, 0);
                            }
                        }
                        typeTextSequentially(0);
                    }).fail(function () {
                        $('#modalBody').html('<p class="text-danger">Error handling request</p>');
                    });
            });
        });
    </script>
</body>

</html>