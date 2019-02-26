<?php
    include 'urls.php';
    function pokemonInfo()
    {
        global $results, $pokemon;
        $index = empty($_GET['index']) ? 0 : $_GET['index'];
        createPokemonInfo($pokemon[$index]->name, $index, 'abilities');
        $abilities = $results[$index]->abilities;
        $types = $results[$index]->types;
        $height = $results[$index]->height;
        $weight = $results[$index]->weight;
?>

<h3>Pokemon info</h3>

<h2 class="pokemonName"><?= ucfirst($pokemon[$index]->name) ?></h2>

<div class="abilities">
    <ul>
    <?php foreach ($abilities as $ability): ?>
    <li>
        <span><?= $ability->ability->name; ?></span>
    </li>
    <?php endforeach; ?>
    </ul>
</div>

<div class="types">
    <ul>
    <?php foreach ($types as $type): ?>
    <li>
        <span><?= $type->type->name; ?></span>
    </li>
    <?php endforeach; ?>
    </ul>
</div>

<span>HEIGHT: <?= $height / 10 ?>m</span>
<br>
<span>WEIGHT: <?= $weight / 10 ?>kg</span>

<?php
    };
    echo pokemonInfo();
?>