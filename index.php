<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Pokemon</title>
</head>
<body>
    <header>
        <h1>POKEDEX</h1>
    </header>
    <div class="pokedex">
        <div class="pokemonInfo">
            <div class="return">Retour</div>
        </div>
        <div class="pokemonPreview toggle">
            <span>Click to get info !</span>
            <img src="" alt="">
        </div>
        <h3>Pokemon</h3>
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
        let $return = document.querySelector('.return')
        let selectSound = new Audio("sound/select.mp3")
        let $pokemons
        console.log($pokemons)
        let searchState = <?= $searchState; ?>
        
        $container.addEventListener(
            'scroll',
            (e) =>
            {
                // document bottom
                let windowRelativeBottom = $container.querySelector('.pokemonList').getBoundingClientRect().bottom

                // We are looking for the bottom of the page in order to load new pokemon
                if (windowRelativeBottom < $container.clientHeight + 100 && loadedPokemons < 960 && searchState == 0)
                {
                    loadedPokemons += 10


                    fetch(`http://localhost:8888/pokemonproject/pokemonList.php?step=${loadedPokemons}&current=${loadedPokemons - 10}`,
                    {
                        header: "Accept: text/html"
                    })
                    .then(res => res.text())
                    .then(result => {$container.querySelector('.pokemonList ul').innerHTML += `${result}`; createPokemonActive()})
                }
            }
        )
    </script>
    <script src="script/script.js"></script>
</body>
</html>