<?php
require_once 'vendor/bundler.php';
$url = new UrlParser();
$url->outputMeta($data);
?>
<input id="toggle-nav" type="checkbox" class="hidden" />
<header id="topo" class="topo-normal display-flex flex-space-between">
    <div class="container display-flex flex-space-between">
        <a class="logo" href="<?=URL_INSTALACAO?>#banner" title="Hamburgueria Le Pingue - A melhor hamburgueria do Brasil">
            <img src="images/logo.png" alt="Hamburgueria Le Pingue - A melhor hamburgueria do Brasil" title="Hamburgueria Le Pingue - A melhor hamburgueria do Brasil">
            <h1 class="text-hide">Hamburgueria Le Pingue - A melhor hamburgueria do Brasil</h1>
        </a>
        <ul class="top-nav">
            <li>
                <a href="<?=URL_INSTALACAO?>quem-somos" title="Quem Somos" class="icon-item">
                    <span class="hidden-md">
                        <img src="images/icone-quem-somos.png" alt="Quem Somos" title="Quem Somos">
                        <img src="images/icone-quem-somos-hover.png" alt="Quem Somos" title="Quem Somos">
                    </span>
                    <span>Quem Somos</span>
                </a>
            </li>
            <li>
                <a href="<?=URL_INSTALACAO?>cardapio-listagem" title="Cardápio" class="icon-item">
                    <span class="hidden-md">
                        <img src="images/icone-cardapio.png" alt="Cardápio" title="Cardápio">
                        <img src="images/icone-cardapio-hover.png" alt="Cardápio" title="Cardápio">
                    </span>
                    <span>Cardápio</span>
                </a>
            </li>
            <li>
                <a href="<?=URL_INSTALACAO?>unidades-listagem" title="Unidades" class="icon-item">
                    <span class="hidden-md">
                        <img src="images/icone-unidades.png" alt="Unidades" title="Unidades">
                        <img src="images/icone-unidades-hover.png" alt="Unidades" title="Unidades">
                    </span>
                    <span>Unidades</span>
                </a>
            </li>
            <li>
                <a href="<?=URL_INSTALACAO?>promocoes" title="Promoções" class="icon-item">
                    <span class="hidden-md">
                        <img src="images/icone-promocoes.png" alt="Promoções" title="Promoções">
                        <img src="images/icone-promocoes-hover.png" alt="Promoções" title="Promoções">
                    </span>
                    <span>Promoções</span>
                </a>
            </li>
            <li>
                <a href="<?=$data['seja_franqueado_link']?>" target="_blank" title="Seja Franqueado" class="icon-item">
                    <span class="hidden-md">
                        <img src="images/icone-franqueado.png" alt="Seja Franqueado" title="Seja Franqueado">
                        <img src="images/icone-franqueado-hover.png" alt="Seja Franqueado" title="Seja Franqueado">
                    </span>
                    <span>Seja Franqueado</span>
                </a>
            </li>
            <li>
                <a href="<?=URL_INSTALACAO?>contato" title="Contato" class="icon-item">
                    <span class="hidden-md">
                        <img src="images/icone-contato.png" alt="Contato" title="Contato">
                        <img src="images/icone-contato-hover.png" alt="Contato" title="Contato">
                    </span>
                    <span>Contato</span>
                </a>
            </li>
        </ul>
        <label for="toggle-nav" class="toggle-menu hidden-lg hidden-md">
            <button></button>
        </label>
    </div>
</header>
