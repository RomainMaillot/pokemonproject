<?php
    include 'urls.php';
    $current = empty($_GET['current']) ? 0 : $_GET['current'];
    if($searchState == 1)
    {
        $step = 964;
    }
    else 
    {
        $step = empty($_GET['step']) ? 10 : $_GET['step'];
    }
    function pokemonList()
    {
    global $pokemon,$searchState, $search, $current, $step;

    for ($i = $current; $i < $step; $i++):
?>
<?php if ($searchState == 1 && strpos($pokemon[$i]->name, $search) === 0){ ?>
    <li>
        <div class="pokemonButton">
            <span class="id" ><?=  createPokemonInfo($pokemon[$i]->name, $i, 'id'); ?></span>
            <img src="<?= createPokemonInfo($pokemon[$i]->name, $i,'sprite'); ?>" alt="">
            <span><?=  ucfirst($pokemon[$i]->name) ?></span>
        </div>
    </li>
<?php }else if ($searchState == 0){ ?>
    <li>
        <div class="pokemonButton">
            <span class="id" ><?=  createPokemonInfo($pokemon[$i]->name, $i, 'id'); ?></span>
            <img src="<?= createPokemonInfo($pokemon[$i]->name, $i,'sprite'); ?>" alt="">
            <span><?=  ucfirst($pokemon[$i]->name) ?></span>
        </div>
    </li>
<?php }; ?>
<?php 
    endfor;
    };
    echo pokemonList();
?>