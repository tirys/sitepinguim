    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Agência Prospecta | Administrador</title>
        <base href="<?php echo URL_INSTALACAO . PASTA_ADMIN . '/' ?>">
        <link rel="stylesheet" type="text/css" href="public/css/datepicker.css">
        <link rel="stylesheet" type="text/css" href="public/css/navbar-fixed-top.css">
        <link rel="stylesheet" type="text/css" href="public/css/demo_table.css">
        <link rel="stylesheet" type="text/css" href="public/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="public/css/awesome-bootstrap-checkbox.css">
        <link rel="stylesheet" type="text/css" href="public/css/Font-Awesome/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="public/css/icones.css">
        <link rel="stylesheet" href="../fonts/themify-icons.css" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script type="text/javascript" src="public/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="public/js/jquery.meio.mask.js"></script>
        <script type="text/javascript" src="public/js/jquery.validate.js"></script>
        <script type="text/javascript" src="public/js/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="public/js/ckeditor/ckfinder/ckfinder.js"></script>
        <script type="text/javascript" src="public/js/scripts.js"></script>
        <script type="text/javascript" src="public/js/bootstrap.js"></script>
        <!--############################################################# JS FUNCTIONS #####################################-->
        <script type="text/javascript">
        function getValor(valor) {
            $("#txt_subcategoria").html("<option value='0'>Localizando...</option>");
            setTimeout(function() {
                document.getElementById('txt_subcategoria').style.display = 'block';
                $("#txt_subcategoria").load("tools/filtro_subcategoria.php", {id: valor})
            }, 100);
        }
        function getLocalidadeEstado(valor){
            $("#txt_estado").html("<option value='0'>Localizando...</option>");
            $("#txt_cidade").html("<option value='0'>Selecione um estado acima.</option>");
            setTimeout(function(){
                $("#txt_estado").load("tools/filtro_pais_estado.php",{id:valor})
            }, 100);
        }
        function getLocalidadeCidade(valor){
            $("#txt_cidade").html("<option value='0'>Localizando...</option>");
            setTimeout(function(){
                $("#txt_cidade").load("tools/filtro_cidade_estado.php", {id:valor})
            }, 500);
        }
        </script>
        <!--############################################################# JS FUNCTIONS #####################################-->
    </head>
    <body>
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Gestor</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="config-dados-cadastrais">Dados Cadastrais</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Estrutura <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="paginas-categorias">Categoria</a></li>
                                <li><a href="paginas-subcategorias">Sub-Categoria</a></li>
                        <?php
                            if($_SESSION['usuarioTipo'] == 1)
                                { ?>
                                <li><a href="paginas-tipos">Tipo de Página</a></li>
                            <?php }  ?>
                            </ul>
                        </li>
                        <?php
                        $conexao = new Conexao();
                        $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_tipo order by tb_conteudo_tipo_nome');
                        while ($consultaMenuAdmin = $conexao->busca($consulta))
                        {    ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php echo $consultaMenuAdmin['tb_conteudo_tipo_nome']; ?> <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                    $consultaNivel2 = $conexao->consulta('SELECT * FROM tb_conteudo_categoria WHERE tb_conteudo_categoria_id_tipo = "' . $consultaMenuAdmin['tb_conteudo_tipo_id'] . '" order by tb_conteudo_categoria_nome');

                                    while ($consultaMenuAdminNivel2 = $conexao->busca($consultaNivel2))

                                    {
                                        ?>
                                        <li>
                                            <a href="paginas/listar/<?php echo $consultaMenuAdminNivel2['tb_conteudo_categoria_id']; ?>">
                                        <?php echo $consultaMenuAdminNivel2['tb_conteudo_categoria_nome']; ?>
                                            </a>
                                        </li>
                                    <?php  } ?>
                                        <!--<li role="presentation" class="divider"></li>
                                        <li><a href="paginas-categorias">Adicionar Categorias</a></li>-->
                                    <!--<li role="presentation" class="divider"></li>-->
                                </ul>
                            </li>
                    <?php   } ?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Banners <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?php
                                $conexao = new Conexao();
                                $consulta = $conexao->consulta('SELECT * FROM tb_banner_tipo order by tb_banner_tipo_nome');
                                while ($consultaMenuAdmin = $conexao->busca($consulta)) {
                                    ?>
                                    <li><a href="banners/listar/<?php echo $consultaMenuAdmin['tb_banner_tipo_id']; ?>"><?php echo $consultaMenuAdmin['tb_banner_tipo_nome']; ?></a></li>
                                <?php } ?>

                                <li role="presentation" class="divider"></li>
                        <?php
                            if($_SESSION['usuarioTipo'] == 1) {
                        ?>
                                <li><a href="banners-tipos">Adicionar Novo Tipo de Banner</a></li>
                        <?php
                        }
                        ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="unidades">Unidades</a>
                        </li>
                        <li class="config-seo">
                            <a href="unidades">SEO</a>
                        </li>
                        <!--
                                                 <li class="dropdown">
                                                    <a href="blocos-estaticos">Blocos Estáticos</a>
                                                </li>
                                                 <li class="dropdown">
                                                    <a href="arquivos">Arquivos</a>
                                                </li>
                                                <li class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configurações <b class="caret"></b></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="usuarios">Usuários</a></li>
                                                        <li><a href="usuarios-tipos">Tipos de Usuários</a></li>
                                                        <li role="presentation" class="divider"></li>
                                                        <li><a href="unidades">Unidades</a></li>
                                                        <li role="presentation" class="divider"></li>
                                                        <li><a href="localidade-paises">Países</a></li>
                                                        <li><a href="localidade-estados">Estados</a></li>
                                                        <li><a href="localidade-cidades">Cidades</a></li>
                                                    </ul>
                                                </li>
                         -->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="vendor/_inc_logout.php?url=<?=URL_INSTALACAO?> ">Logout</a></li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="container">