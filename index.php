<?php

    // Define research and make default
    $search = empty($_GET['pokemon']) ? '' : $_GET['pokemon'];
    if (empty($_GET['pokemon'])) 
    {
        $searchState = 0;
    }
    else {
        $searchState = 1;
    }

    

    // Create API url
    $url = 'https://pokeapi.co/api/v2/pokemon/?';
    $url .= http_build_query([
        'offset' => 0,
        'limit' => 964,
    ]);

    // Create cache info
    $cacheKey = md5($url);
    $cachePath = './cache/'.$cacheKey;
    $cacheUsed = false;

    // Cache available
    if(file_exists($cachePath) && time() - filemtime($cachePath) < 1000)
    {
        $result = file_get_contents($cachePath);
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

        $result = curl_exec($curl);
        curl_close($curl);

        // Save in cache
        file_put_contents($cachePath, $result);
    }

    // Decode JSON
    $result = json_decode($result);
    $pokemon = $result->results;
    $count = $result->count;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pokemon</title>
</head>
<body>
    
    <!-- Form -->
    <form action="#" method="get">
        <input type="text" name="pokemon" placeholder="Pokemon" value="">
        <input type="submit">
    </form>

    <!-- Results -->
    <h3>Pokemon</h3>
    <ul>
        <?php for ($i = 0; $i < $count; $i++): ?>
            <?php if ($searchState == 1 && strpos($pokemon[$i]->name, $search) === 0){ ?>
                <li><?=  $pokemon[$i]->name ?></li>
            <?php }else if ($searchState == 0){ ?>
                <li><?=  $pokemon[$i]->name ?></li>
            <?php }; ?>
        <?php endfor;  ?>
    </ul>

</body>
</html>