<?php
    // Define research and make default
    $search = empty($_GET['searchPokemon']) ? '' : $_GET['searchPokemon'];
    if (empty($_GET['searchPokemon'])) 
    {
        $searchState = 0;
    }
    else {
        $searchState = 1;
    };
    $path = './info';

    // Create API general url
    $generalUrl = 'https://pokeapi.co/api/v2/pokemon/?';
    $generalUrl .= http_build_query([
        'offset' => 0,
        'limit' => 964,
    ]);

    $results = [];

    // Function creating urls when needed
    function createUrl($url, $index)
    {
        global $results;

        // Create cache info
        $cacheKey = md5($url);
        $cachePath = './cache/'.$cacheKey;
        $cacheUsed = false;

        // Cache available
        if(file_exists($cachePath))
        {
            $results[$index] = file_get_contents($cachePath);
            $cacheUsed = true;
        }
        
        // Cache not available
        else
        {
            // Make request to API
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

            $results[$index] = curl_exec($curl);
            curl_close($curl);

            // Save in cache
            file_put_contents($cachePath, $results[$index]);
        }

        // Decode JSON
        $results[$index] = json_decode($results[$index]);
    };

    // Function created pokemon links
    function createPokemonUrl($pokemonName, $index)
    {
        global $results;
        // Create API pokemon url
        $pokemonUrl = 'https://pokeapi.co/api/v2/pokemon/';
        $pokemonUrl .= $pokemonName;

        createUrl($pokemonUrl, $index);
    }

    // Function created info pokemon links
    function createPokemonInfo($pokemonName, $index, $element)
    {
        global $results;

        createPokemonUrl($pokemonName, $index);

        // Created sprites pokemon
        if($element == 'sprite')
        {
            $pokemonSprite = $results[$index]->sprites->front_default;
            return $pokemonSprite;
        }
        // Creating id pokemon
        else if ($element == 'id') 
        {
            $pokemonId = $results[$index]->id;
            return $pokemonId;
        }
        // Creating abilities pokemon
        else if ($element == 'abilities') 
        {
            $pokemonAbilities = $results[$index]->abilities;
            return $pokemonAbilities;
        }
    }

    createUrl($generalUrl, 0);

    $pokemon = $results[0]->results;
    $count = $results[0]->count;
?>