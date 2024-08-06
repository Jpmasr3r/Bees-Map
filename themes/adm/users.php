<?php
echo $this->layout("_theme");
?>
<link rel="stylesheet" href="<?= url("themes/adm/assets/css/styles-users.css") ?>">
<h1>Area de usuarios lista os usuarios para poder ser feita alguma alteração que nescessitaria de ser um ADM</h1>

<div id="div-area">
    <div class="team-container">
        <div class="div-team-info">
            <h1>Time A</h1>
            <p>Informações sobre o Time A.</p>
        </div>
        <div class="div-team-members">
            <h1>Membros do Time A</h1>
            <div class="team-member">
                <img src="<?= url('themes/_assets/imgs/bee-black.png') ?>" alt="Foto do Membro">
                <div class="team-member-info">
                    <h1>Nome do Membro A1</h1>
                </div>
            </div>
            <div class="team-member">
                <img src="<?= url('themes/_assets/imgs/bee-black.png') ?>" alt="Foto do Membro">
                <div class="team-member-info">
                    <h1>Nome do Membro A2</h1>
                </div>
            </div>
            <!-- Adicione mais membros do Time A aqui -->
        </div>
    </div>

    <!-- Estrutura para o segundo time -->
    <div class="team-container">
        <div class="div-team-info">
            <h1>Time B</h1>
            <p>Informações sobre o Time B.</p>
        </div>
        <div class="div-team-members">
            <h1>Membros do Time B</h1>
            <div class="team-member">
                <img src="<?= url('themes/_assets/imgs/bee-black.png') ?>" alt="Foto do Membro">
                <div class="team-member-info">
                    <h1>Nome do Membro B1</h1>
                </div>
            </div>
            <div class="team-member">
                <img src="<?= url('themes/_assets/imgs/bee-black.png') ?>" alt="Foto do Membro">
                <div class="team-member-info">
                    <h1>Nome do Membro B2</h1>
                </div>
            </div>
            <!-- Adicione mais membros do Time B aqui -->
        </div>
    </div>

    <!-- Adicione mais times seguindo a mesma estrutura -->
</div>
