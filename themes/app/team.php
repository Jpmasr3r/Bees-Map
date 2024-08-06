<?php
echo $this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url("themes/app/assets/css/styles-team.css") ?>">

<div id="div-area">
    <?php
    // Informações da equipe
    $team = [
        'name' => 'Nome da Equipe',
        'description' => 'Esta é uma descrição detalhada da equipe, que explica sua missão e objetivos.',
        'members' => ['Membro 1', 'Membro 2', 'Membro 3', 'Membro 4', 'Membro 5']
    ];
    ?>

    <div class="team-focus">
        <div class="div-team-info">
            <h1><?= $team['name']; ?></h1>
            <p><?= $team['description']; ?></p>
        </div>
        <div class="div-team-members">
            <h1>Membros da Equipe</h1>
            <?php
            foreach ($team['members'] as $member) {
                echo "
                    <div class='team-member'>
                        <img src='" . url('themes/_assets/imgs/bee-black.png') . "' alt='Foto do Membro'>
                        <div class='team-member-info'>
                            <h1>{$member}</h1>
                        </div>
                    </div>
                ";
            }
            ?>
        </div>
    </div>
</div>
