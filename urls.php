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

    // Function to get string with out accent
    function str_to_noaccent($str)
    {
        $noAccent = $str;
        $noAccent = preg_replace('#Ç#', 'C', $noAccent);
        $noAccent = preg_replace('#ç#', 'c', $noAccent);
        $noAccent = preg_replace('#è|é|ê|ë#', 'e', $noAccent);
        $noAccent = preg_replace('#È|É|Ê|Ë#', 'E', $noAccent);
        $noAccent = preg_replace('#à|á|â|ã|ä|å#', 'a', $noAccent);
        $noAccent = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $noAccent);
        $noAccent = preg_replace('#ì|í|î|ï#', 'i', $noAccent);
        $noAccent = preg_replace('#Ì|Í|Î|Ï#', 'I', $noAccent);
        $noAccent = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $noAccent);
        $noAccent = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $noAccent);
        $noAccent = preg_replace('#ù|ú|û|ü#', 'u', $noAccent);
        $noAccent = preg_replace('#Ù|Ú|Û|Ü#', 'U', $noAccent);
        $noAccent = preg_replace('#ý|ÿ#', 'y', $noAccent);
        $noAccent = preg_replace('#Ý#', 'Y', $noAccent);
        
        return ($noAccent);
    }

    // Function created pokemon links
    function createPokemonUrl($pokemonName, $index)
    {
        global $results;
        // Create API pokemon url
        $pokemonUrl = 'https://pokeapi.co/api/v2/pokemon/';
        $pokemonUrl .= $pokemonName;

        createUrl($pokemonUrl, $index);
    }

    // Function created pokemon description
    function createPokemonSpecies($pokemonId, $index, $info)
    {
        global $results;
        // Create API pokemon url
        $pokemonUrl = 'https://pokeapi.co/api/v2/pokemon-species/';
        $pokemonUrl .= $pokemonId;

        createUrl($pokemonUrl, $index);
        if ($results[$index] !== null) 
        {
            if($info == 'description')
            {
                if ($results[$index]->flavor_text_entries[2]->language->name == 'en') 
                {
                    $pokemonDescription = $results[$index]->flavor_text_entries[2]->flavor_text;
                }
                else 
                {
                    $pokemonDescription = $results[$index]->flavor_text_entries[1]->flavor_text;
                }
                $pokemonDescription = str_to_noaccent($pokemonDescription);
                return $pokemonDescription;
            }
            elseif ($info == 'genus') 
            {
                if ($results[$index]->genera[2]->language->name == 'en') 
                {
                    $pokemonGenus = $results[$index]->genera[2]->genus;
                }
                else 
                {
                    $pokemonGenus = $results[$index]->genera[1]->genus;
                }
                $pokemonGenus = str_to_noaccent($pokemonGenus);
                return $pokemonGenus;
            }
        }
        else 
        {
            $pokemonDescription = 'No info';
            return $pokemonDescription;
        }
        
    }

    // Function created info pokemon info
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