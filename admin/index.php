<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Agência Prospecta">
    <title>Prospecta CMS</title>
    <link href="public/css/bootstrap.css" rel="stylesheet">
    <link href="public/css/signin.css" rel="stylesheet">
    <script src="public/js/jquery-1.10.2.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/jquery.validate.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="public/js/html5shiv"></script>
    <script src="public/js/respond.min"></script>
    <![endif]-->
  </head>
  <body>
     <form class="form-signin" action="vendor/_inc_valida" method="post">
                    <img src="logo-verm.png">
                    <h2 class="form-signin-heading">Administrador</h2>
                        <input type="text" class="form-control" name="usuario" placeholder="Usuário" autofocus>
                        <input type="password" class="form-control" placeholder="Senha" name="senha">
                        <a href="senha">Esqueceu a senha?</a>
                        <input class="btn btn-lg btn-primary btn-block" type="submit">
                        <?php
                        if (isset($_GET['erro'])) 
                        {

                            $erro = $_GET['erro'];
                            switch ($erro) 
                            {
                                case 1:
                                        echo '<p>Você fez logoff do sistema.</p>';
                                    break;
                                case 2:
                                        echo '<p>Dados incorretos ou usuário inativo.</p>';
                                    break;
                                case 3:
                                        echo '<p>Faça login antes de acessar a página solicitada</p>';
                                    break;
                                default:
                                    break;
                            }
                        
                        } ?>
                </form>
    <div class="container">
    </div>
  </body>
</html>
