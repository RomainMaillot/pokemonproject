const toggleInfo = () =>
{
    $pokemonInfo.classList.toggle('toggle')
    $pokemonList.classList.toggle('toggle')
    $searchBar.classList.toggle('toggle')
    $pokemonPreview.classList.toggle('toggle')
    if($pokemonInfo.querySelector('.pokemonInfoContainer'))
    {
        $pokemonInfo.removeChild($pokemonInfoContainer)
    }
    $pokemonInfoContainer = document.createElement('div')
    $pokemonInfoContainer.classList.add('pokemonInfoContainer')
    $pokemonInfo.appendChild($pokemonInfoContainer)
}


$return.addEventListener(
    'click',
    () =>
    {
        toggleInfo()
    }
)

const createPokemonActive = () =>
{
    $pokemons = document.querySelectorAll('.pokemonButton')
    for(const $pokemon of $pokemons)
    {
        $pokemon.addEventListener(
            'click',
            () =>
            {
                toggleInfo()
                $id = $pokemon.querySelector('.id').cloneNode(true)
                $pokemonInfoContainer.appendChild($id)
                $sprite = $pokemon.querySelector('img').cloneNode(true)
                $pokemonInfoContainer.appendChild($sprite)

                id = parseInt($id.innerHTML) - 1
                if ($pokemonInfoContainer.innerHTML !== '') 
                {
                    fetch(`http://localhost:8888/pokemonproject/pokemonInfo.php?index=${id}`,
                    {
                        header: "Accept: text/html"
                    })
                    .then(res => res.text())
                    .then(result => {$pokemonInfoContainer.innerHTML += `${result}`})
                }
            }
        )
        $pokemon.addEventListener(
            'mouseenter',
            () =>
            {
                $spriteUrl = $pokemon.querySelector('img').getAttribute('src')
                $pokemonPreviewImg.setAttribute('src', `${$spriteUrl}`)
                selectSound.play()
            }
        )
    }
}
createPokemonActive()