<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Band Search</title>

        <script src="https://kit.fontawesome.com/fe0ca3f893.js" crossorigin="anonymous"></script>

        <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body>
        <header class="bs_header j_header">
            <div class="bs_header_content">
                <div class="bs_header_content_logo">
                    <a href="#">
                        <h1>Band Search</h1>
                        <img src="assets/images/logo_dark.png" alt="Band Search" class="j_theme_logo">
                    </a>
                </div>

                <div class="bs_header_content_switch_theme">
                    <div class="switch j_switch" title="Muito claro? Mude para o tema escuro."></div>
                    <div class="card">
                        <div class="card_img j_card_container" style="background-image: url(assets/images/my-eyes.gif)"></div>
                    </div>
                </div>
            </div>
        </header>

        <main class="bs_main j_main">
            <div class="bs_main_content j_main_content">
                <aside class="bs_main_content_form j_form">
                    <form action="" class="j_search">
                        <div class="label_area"><input type="text" name="search" id="search" required value="">
                            <label
                                for="search">Clique e digite o nome da banda aqui</label>                                
                            <i class="bottom_bar"></i>
                        </div>

                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Pesquisar</button>
                    </form>
                </aside>

                <section class="bs_main_content_results j_results" style="display: none"></section>
            </div>
        </main>

        <footer class="bs_footer j_footer">
            <p>Coded by <em><a href="https://github.com/giullianoth" target="_blank">Giulliano Guimarães</a></em></p>
        </footer>

        <script src="assets/js/jquery.js" type="module"></script>
        <script src="assets/js/script.js" type="module"></script>
    </body>

</html>