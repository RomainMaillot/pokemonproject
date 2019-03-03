<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Pokedex</title>
    <link rel="icon" type="image/ico" href="images/favicon.ico">
</head>
<body>
    <header>
        <h1 class="title">POKEDEX</h1>
        <h1 class="title toggle">INFO</h1>
    </header>
    <div class="start top appear"></div>
    <div class="start bottom appear"></div>
    <div class="text"><h2>Open pokedex !</h2></div>
    <div class="pokedex">
        <div class="pokemonInfo">
            
        </div>
        <div class="pokemonPreview toggle">
            <span>Click to get info !</span>
            <img src="" alt="">
        </div>
        <div class="pokemonList toggle">
            <!-- Results -->
            <ul>
                <?php include 'pokemonList.php';?>
            </ul>
        </div>
    </div>
    <footer>
        <!-- Form -->
        <form class="search" action="#" method="get">
            <input type="text" name="searchPokemon" placeholder="Search pokemon" value="">
            <input type="submit" value="Rechercher">
        </form>
        <div class="buttons">
            <div class="change">
                <div class="next"><img src="images/chevron-up.png" alt=""></div>
                <div class="previous"><img src="images/chevron-down.png" alt=""></div>
            </div>
            <div class="return"><img src="images/back.png" alt=""></div>
        </div>
    </footer>
    <script>
        let $container = document.querySelector('.pokedex')
        let windowHeight = window.innerHeight
        let loadedPokemons = 20
        let $pokemonInfo = document.querySelector('.pokemonInfo')
        let $pokemonList = document.querySelector('.pokemonList')
        let $pokemonPreview = document.querySelector('.pokemonPreview')
        let $pokemonPreviewImg = $pokemonPreview.querySelector('img')
        let $searchBar = document.querySelector('.search')
        let $buttons = document.querySelector('.buttons')
        let $return = document.querySelector('.return')
        let $next = document.querySelector('.next')
        let $previous = document.querySelector('.previous')
        let previous = true
        let next = true
        let currentPokemon = 1
        let $titles = document.querySelectorAll('.title')
        let selectSound = new Audio("sound/select.mp3")
        let $pokemons
        let searchState = <?= $searchState; ?>

        const createPokemonLists = () =>
        {
            loadedPokemons += 10


            fetch(`http://localhost:8888/pokemonproject/pokemonList.php?step=${loadedPokemons}&current=${loadedPokemons - 10}`,
            {
                header: "Accept: text/html"
            })
            .then(res => res.text())
            .then(result => {$container.querySelector('.pokemonList ul').innerHTML += `${result}`; createPokemonActive()})
        }
        
        $container.addEventListener(
            'scroll',
            (e) =>
            {
                // document bottom
                let windowRelativeBottom = $container.querySelector('.pokemonList').getBoundingClientRect().bottom

                // We are looking for the bottom of the page in order to load new pokemon
                if (windowRelativeBottom < $container.clientHeight + 100 && loadedPokemons < 960 && searchState == 0)
                {
                    createPokemonLists()
                }
            }
        )
    </script>
    <script src="script/script.js"></script>
</body>
</html>