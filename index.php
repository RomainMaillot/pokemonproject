<?php

    // Define research and make default
    $search = empty($_GET['searchPokemon']) ? '' : $_GET['searchPokemon'];
    if (empty($_GET['searchPokemon'])) 
    {
        $searchState = 0;
    }
    else {
        $searchState = 1;
    }

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

    // Function created sprite pokemon links
    function createPokemonSprite($pokemonName, $index)
    {
        global $results;
        // Create API pokemon url
        $pokemonUrl = 'https://pokeapi.co/api/v2/pokemon/';
        $pokemonUrl .= $pokemonName;

        createUrl($pokemonUrl, $index);

        $pokemonSprite = $results[$index]->sprites->front_default;
        return $pokemonSprite;
    }

    createUrl($generalUrl, 0);

    $pokemon = $results[0]->results;
    $count = $results[0]->count;
?>

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
    
    <!-- Form -->
    <form action="#" method="get">
        <input type="text" name="searchPokemon" placeholder="Search pokemon" value="">
        <input type="submit" value="Rechercher">
    </form>

    <!-- Results -->
    <h3>Pokemon</h3>
    <ul>
        <?php for ($i = 0; $i < $count; $i++): ?>
            <?php if ($searchState == 1 && strpos($pokemon[$i]->name, $search) === 0){ ?>
                <li>
                    <div class="pokemonButton">
                    <img src="<?= createPokemonSprite($pokemon[$i]->name, $i); ?>" alt="">
                        <span><?=  $pokemon[$i]->name ?></span>
                    </div>
                </li>
            <?php }else if ($searchState == 0){ ?>
                <li>
                    <div class="pokemonButton">
                        <img src="<?= createPokemonSprite($pokemon[$i]->name, $i); ?>" alt="">
                        <span><?=  $pokemon[$i]->name ?></span>
                    </div>
                </li>
            <?php }; ?>
        <?php endfor;  ?>
    </ul>

</body>
</html>