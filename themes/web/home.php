<?php
echo $this->layout("_theme");
?>

<link rel="stylesheet" href="./themes/web/assets/css/style-home.css">
<script src="./vendor/leaflet/src/Leaflet.js" async></script>
<script src="./themes/web/assets/js/script-home.js" async type="module"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<h1 id="title">
    <i>
        <b style="animation: upDownLetters infinite 1000ms alternate linear;">B</b>
        <b style="animation: upDownLetters infinite 1200ms alternate linear;">e</b>
        <b style="animation: upDownLetters infinite 1400ms alternate linear;">e</b>
        <b style="animation: upDownLetters infinite 1600ms alternate linear;">s</b>
        <b style="animation: upDownLetters infinite 1800ms alternate linear;">M</b>
        <b style="animation: upDownLetters infinite 2000ms alternate linear;">a</b>
        <b style="animation: upDownLetters infinite 2200ms alternate linear;">p</b>
    </i>
</h1>

<?php 
for ($i = 1; $i <= 8; $i++) {
    $top = rand(50, 150) + rand(50, 150);
    $timeAni = rand(250, 1500) + rand(250, 1500);
    echo "<div class=\"divBee\" style=\"top: {$top}px; animation: flyBeesAnimation infinite {$timeAni}ms linear;\" >
        <img class=\"bee\" src=\"./themes/web/assets/imgs/bee-black.png\">
    </div>";
} 
?>

<div id="map" >
    <div id="interativeMap"></div>
</div>

<div id="text">
    <i>
        <b>
            <h1>BeesMap é um sistema de gerenciamento para apicultores <br> com mapas interativos</h1>
        </b>
    </i>
</div>