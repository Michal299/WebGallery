<header>
    <h1>Kostka Rubika</h1>
    <nav>
        &equiv;
        <div>
            <ol>
                <li>
                    <a href="home">Strona głowna</a>
                </li>
                <li>
                    Historia
                    <ol>
                        <li><a href="mojahistoria">Moja</a></li>
                        <li><a href="rubikahistoria">Kostki Rubika</a></li>
                    </ol>
                </li>
                <li>
                    Rodzaje kostek
                    <ol>
                        <li><a href="szescienne">Sześcienne</a></li>
                        <li><a href="dwunastoscienne">Dwunastościenne</a></li>
                        <li><a href="czworoscienne">Czworościenne</a></li>
                    </ol>
                </li>
                <li>
                    <?php
                        if(empty($_SESSION['user_id'])){
                            echo '<a href="login">Zaloguj</a>';
                        }
                        else{
                            echo '<a href="logout">Wyloguj</a>';
                        }
                    ?>
                </li>
                <li>
                    <a href="add_photo">Dodaj zdjęcie</a>
                </li>
                <li>
                    <a href="gallery">Galeria</a>
                </li>
                <li>
                    <a href="photos_clipboard">Zapisane zdjęcia</a>
                </li>
                <li>
                    <a href="search">Wyszukiwarka</a>
                </li>
                <li>
                    <div id="DarkMode">Tryb nocny</div>
                </li>
            </ol>
        </div>
    </nav>
</header>