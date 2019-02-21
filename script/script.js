const createPokemonActive = () =>
{
    console.log('event')
    $pokemons = document.querySelectorAll('.pokemonButton')
    for(const $pokemon of $pokemons)
    {
        $pokemon.addEventListener(
            'click',
            () =>
            {
                toggleInfo()
            }
        )
    }
}
createPokemonActive()

const toggleInfo = () =>
{
    $pokemonInfo.classList.toggle('toggle')
    $pokemonList.classList.toggle('toggle')
    $searchBar.classList.toggle('toggle')
}


$return.addEventListener(
    'click',
    () =>
    {
        toggleInfo()
    }
)