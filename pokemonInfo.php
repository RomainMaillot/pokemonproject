<?php
    include 'urls.php';
    function pokemonInfo()
    {
        global $results, $pokemon;
        $index = empty($_GET['index']) ? 0 : $_GET['index'];
        if($index < 964):
            createPokemonInfo($pokemon[$index]->name, $index, 'abilities');
            $abilities = $results[$index]->abilities;
            $types = $results[$index]->types;
            $height = $results[$index]->height;
            $weight = $results[$index]->weight;
            $description = createPokemonSpecies($index + 1, $index + 1, 'description');
            $genus = createPokemonSpecies($index + 1, $index + 1, 'genus');
        endif;
?>

<?php if($index < 964): ?>

<div class="infosContainer">
    <div class="infoHeader">
        <h2 class="pokemonId">N°<span class="id"><?= $index + 1; ?></span></h2>
        <h2 class="pokemonName"><?= ucfirst($pokemon[$index]->name); ?></h2>
    </div>

    <div class="genus">
        <p><?= $genus ?></p>
    </div>

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
        <?php foreach ($types as $type): ?>
            <span class="type <?= $type->type->name; ?>"><?= strtoupper($type->type->name); ?></span>
        <?php endforeach; ?>
    </div>
    <div class="physics">
        <span>HEIGHT:</span>
        <span><?= $height / 10 ?>m</span>
    </div>
    <div class="physics">
        <span>WEIGHT:</span>
        <span><?= $weight / 10 ?>kg</span>
    </div>
</div>
<div class="description">
    <p><?= $description ?></p>
</div>
<?php else: ?>
    <h1>No Info</h1>
<?php endif;?>

<?php
    };
    echo pokemonInfo();
?>