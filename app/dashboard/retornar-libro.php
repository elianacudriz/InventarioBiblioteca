<?php
session_start();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Retornar Libro</title>
    <script>
        function checkTicketId() {
            var ticketId = document.getElementById("ticket_id").value;
            var submitButton = document.getElementById("submit_button");

            if (ticketId) {
                submitButton.name = "procesar-retorno-ticket";
            } else {
                submitButton.name = "procesar-retorno-noticket";
            }
        }
        $(document).ready(function(){
            $("form").on("submit", function(event){
                event.preventDefault();

                $.ajax({
                    url: "../../api/retorno-libro-prestado.php",
                    type: "post",
                    data: $(this).serialize(),
                    success: function(response) {
                        var data = JSON.parse(response);
                        $("#response").html("<p>ID del Ticket: " + data.ticket_id + "</p><p>ID del Libro: " + data.libro_id + "</p><p>ISBN del Libro: " + data.libro_isbn + "</p>");
                    }
                });
            });
        });
    </script>
</head>
<body>
<h1>Retornar Libro</h1>
    
    <form action="../../api/retorno-libro-prestado.php" method="POST" onsubmit="checkTicketId()">
        <label for="ticket_id">ID del Ticket:</label>
        <input type="text" id="ticket_id" name="ticket_id"><br><br>

        <label for="libro_id">ID del Libro:</label>
        <input type="text" id="libro_id" name="libro_id" ><br><br>

        <label for="libro_isbn">ISBN del Libro:</label>
        <input type="text" id="libro_isbn" name="libro_isbn" ><br><br>
        
        <input type="submit" id="submit_button" value="Enviar">
    </form>
</body>
</html>