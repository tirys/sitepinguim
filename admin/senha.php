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
     <form class="form-signin" action="vendor/_inc_valida_email" method="post">
                    <h2 class="form-signin-heading">Prospecta CMS</h2>
                    <span style="font-size:12px; margin-top:4px;">Preencha com o seu e-mail e cheque a caixa de entrada do mesmo em alguns minutos</span>
                        <input type="text" class="form-control" name="email" placeholder="email" required autofocus>
                        <div style="margin:10px;"></div>
                        <a href='index' style="margin-left:2px;">Voltar para Login</a>
                        <span style="display: none;visibility: hidden;"><label for="name">Por favor, não preencha o campo abaixo. Caso preenchido qualquer valor, o formulário NÃO será enviado.</label><input name="name" type="text" id="name" size="50"/></span>
                        <input class="btn btn-lg btn-primary btn-block"  type="submit">
                        <?php
                        if (isset($_GET['msg'])) 
                        {
                            $erro = $_GET['msg'];
                            switch ($erro) 
                            {
                                case 1:
                                        echo '<p>E-mail enviado com sucesso, cheque sua caixa de mensagem.</p>';
                                    break;
                                case 2:
                                        echo '<p>E-mail inválido, ou inexistente nos cadastros.</p>';
                                    break;

                                case 3:
                                        echo '<p>Erro no envio de e-mail, por favor tente novamente.</p>';
                                    break;
                            }
                        } ?>
                </form>
    <div class="container">
    </div> <!-- /container -->
  </body>
</html>