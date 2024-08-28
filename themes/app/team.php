<?php
echo $this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url("themes/app/assets/css/styles-team.css") ?>">
<script type="module" src="<?= url("themes/app/assets/js/script-team.js") ?>" async></script>

<div id="div-area">
    <div class="team-focus">
        <div class="div-team-info">
            <h1>Nome da Equipe</h1>
        </div>
        <div class="div-team-members">
            <h1>Membros da Equipe</h1>
        </div>
        <button id="btn-exit-team">Sair da equipe</button>
    </div>
</div>
