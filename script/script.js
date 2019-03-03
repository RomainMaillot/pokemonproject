const $starts = document.querySelectorAll('.start')
const $startTitle = document.querySelector('.text')

const start = () =>
{
    for(const $start of $starts)
    {
        $start.classList.toggle('appear')
    }
    $startTitle.classList.toggle('appear')
}

if (searchState == 1) 
{
    start()
    $back = document.createElement('img')
    $back.classList.add('back')
    $back.setAttribute('src','images/back.png')

    $searchBar.parentNode.appendChild($back)

    $back.addEventListener(
        'click',
        () =>
        {
            window.location.replace('http://localhost:8888/pokemonproject/')
        }
    )
}

const toggleInfo = () =>
{
    $pokemonInfo.classList.toggle('toggle')
    $pokemonList.classList.toggle('toggle')
    $searchBar.classList.toggle('toggle')
    $buttons.classList.toggle('toggle')
    $pokemonPreview.classList.toggle('toggle')
    if($pokemonInfo.querySelector('.pokemonInfoContainer'))
    {
        $pokemonInfo.removeChild($pokemonInfoContainer)
    }
    $pokemonInfoContainer = document.createElement('div')
    $pokemonInfoContainer.classList.add('pokemonInfoContainer')
    $pokemonInfo.appendChild($pokemonInfoContainer)
    for(const $title of $titles)
    {
        $title.classList.toggle('toggle')
    }
}

const getButtonsState = (id) =>
{
    if (id < 0) 
    {
        $previous.style.cursor = 'default'
        $previous.style.opacity = '0.5'
        previous = false
    }
    else if (id > 964)
    {
        $next.style.cursor = 'default'
        $next.style.opacity = '0.5'
        next = false
    }
    else
    {
        $previous.style.cursor = 'pointer'
        $previous.style.opacity = '1'
        previous = true
        $next.style.cursor = 'pointer'
        $next.style.opacity = '1'
        next = true
        currentPokemon = id
    }
    if (currentPokemon == loadedPokemons - 1) 
    {
        createPokemonLists()
    }
}

$startTitle.addEventListener(
    'click',
    () =>
    {
        start()
    }
)

$return.addEventListener(
    'click',
    () =>
    {
        toggleInfo()
    }
)

$next.addEventListener(
    'click',
    () =>
    {
        $pokemons = document.querySelectorAll('.pokemonButton')
        if(searchState == 0)
        {
            $id = $pokemonInfoContainer.querySelector('.id')
            id = parseInt($id.innerHTML)
            $sprite = $pokemons[id].querySelector('img').cloneNode(true)
        }
        else
        {
            $id = $pokemonInfoContainer.querySelector('.id')
            for(const $pokemon of $pokemons)
            {
                if($pokemon.querySelector('.id').innerHTML == $id.innerHTML)
                {
                    $id = $pokemon.parentNode.nextSibling.nextSibling.querySelector('.id')
                    id = parseInt($id.innerHTML)
                    break
                }
            }
            $sprite = $id.parentNode.parentNode.querySelector('img').cloneNode(true)
            id = id - 1
            if ($id == null) 
            {
                next = false
            }
        }

        getButtonsState(id)

        if(next == true)
        {
            $pokemonInfoContainer.classList.add('appear')
            setTimeout(() => 
            {     
                $pokemonInfo.removeChild($pokemonInfoContainer)
                $pokemonInfoContainer = document.createElement('div')
                $pokemonInfoContainer.classList.add('pokemonInfoContainer')
                $pokemonInfoContainer.classList.add('appear')
                $pokemonInfo.appendChild($pokemonInfoContainer)
        
                $pokemonInfoContainer.appendChild($sprite)
        
                fetch(`http://localhost:8888/pokemonproject/pokemonInfo.php?index=${id}`,
                {
                    header: "Accept: text/html"
                })
                .then(res => res.text())
                .then(result => {$pokemonInfoContainer.innerHTML += `${result}`})
                setTimeout(() => {$pokemonInfoContainer.classList.remove('appear')},200 )
            }, 200)
        }
    }
)
$previous.addEventListener(
    'click',
    () =>
    {
        $pokemons = document.querySelectorAll('.pokemonButton')
        if(searchState == 0)
        {
            $id = $pokemonInfoContainer.querySelector('.id')
            id = parseInt($id.innerHTML) - 2
            getButtonsState(id)
            if (previous == true)
            {
                $sprite = $pokemons[id].querySelector('img').cloneNode(true)
            }
        }
        else
        {
            $id = $pokemonInfoContainer.querySelector('.id')
            for(const $pokemon of $pokemons)
            {
                if($pokemon.querySelector('.id').innerHTML == $id.innerHTML)
                {
                    if($pokemon.parentNode.previousSibling.previousSibling == null)
                    {
                        getButtonsState(-1)
                    }
                    else
                    {
                        $id = $pokemon.parentNode.previousSibling.previousSibling.querySelector('.id')
                        $sprite = $id.parentNode.parentNode.querySelector('img').cloneNode(true)
                        getButtonsState(id)
                    }
                    id = parseInt($id.innerHTML) - 2
                    break
                }
            }
            id = id + 1
        }

        if (previous == true)
        {
            $pokemonInfoContainer.classList.add('appear')

            setTimeout(() => 
            {
                $pokemonInfo.removeChild($pokemonInfoContainer)
                $pokemonInfoContainer = document.createElement('div')
                $pokemonInfoContainer.classList.add('pokemonInfoContainer')
                $pokemonInfo.appendChild($pokemonInfoContainer)

                $pokemonInfoContainer.appendChild($sprite)

                fetch(`http://localhost:8888/pokemonproject/pokemonInfo.php?index=${id}`,
                {
                    header: "Accept: text/html"
                })
                .then(res => res.text())
                .then(result => {$pokemonInfoContainer.innerHTML += `${result}`})
                setTimeout(() => {$pokemonInfoContainer.classList.remove('appear')},200 )
            }, 200)
        }
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