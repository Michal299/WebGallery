<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Moje hobby</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="static/stylesheets/style.css"/>
    <script src="static/Scripts/jquery-3.4.1.js"></script>
    <script>
        function load_ajax() {
            $.ajax({
                url: "search",
                method:"POST",
                data: {
                    title: document.getElementById('text').value
                }

            }).done(function (data) {
                $('.photos').html(data);
            });
        }
    </script>
</head>
<body>
<div class="wrapper">
    <?php include 'partial/header.php' ?>
    <div class="page" id="searchPage">
        <div class="message">
            <div class="gallery">
                <form method='post' action="photos_clipboard">
                    <input type="submit" value="Zapamiętaj wybór">
                    <input id='text' type="text" onkeyup="load_ajax()">
                <div class="photos">
                    <div class="info">Brak zdjęć</div>
                </div>
                </form>
            </div>
        </div>
        <div id="dice">
            <a>
                <img id="clickable" src="static/Pictures/icon.png" alt="icon" />
            </a>
        </div>
    </div>
</div>
<script src="static/Scripts/script1.js" defer></script>
</body>
</html>
