<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CRUD</title>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
        <style>
         @import "css/bootstrap.min.css";
         @import "css/custom.css";
        </style>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body>
     <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">CRUD - SERVICEIT</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="index.php?p=clientes">Clientes</a></li>
            <li><a href="index.php?p=produtos">Produtos</a></li>
            <li><a href="index.php?p=pedidos">Pedidos</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
        <?php 
        require_once 'class/ClassMysql.php';
    if($_POST || $_GET){
        $page = trim(($_POST['p'])? $_POST['p'] : $_GET['p']);
        $action = trim(($_POST['a'])? $_POST['a'] : $_GET['a']);
        
        switch ($page) {
           case 'clientes':
                 ?>
                 <h1>Clientes</h1>
                 <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="index.php?p=clientes&a=new">Novo</a></li>
                </ul>
                 <?php 
                 if ($action == 'new'){
                     include_once 'Clientes/clientes_new.php';
                 }elseif($action == 'edit'){
                     include_once 'Clientes/clientes_edit.php';
                 }else{
                     include_once 'Clientes/clientes_list.php';
                 }
                 break;
           case 'produtos':
                 ?>
                 <h1>Produtos</h1>
                 <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="index.php?p=produtos&a=new">Novo</a></li>
                </ul>
                 <?php 
                 if ($action == 'new'){
                     include_once 'Produtos/produtos_new.php';
                 }elseif($action == 'edit'){
                     include_once 'Produtos/produtos_edit.php';
                 }else{
                     include_once 'Produtos/produtos_list.php';
                     
                 }
                 break;
           case 'pedidos':
                ?>
                <h1>Pedidos</h1>
                <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="index.php?p=pedidos&a=new">Abrir Pedido</a></li>
                </ul>
                <?php 
                if ($action == 'new'){
                     include_once 'Pedidos/pedidos_new.php';
                 }elseif($action == 'edit'){
                     include_once 'Pedidos/pedidos_edit.php';
                 }else{
                     include_once 'Pedidos/pedidos_list.php';
                     
                 }
                 break;
               ?>
               <h1>index</h1>
               <?php 
        }
    }else{
        ?>
        <h1>index Hellow world</h1>
        <?php 
    }
    ?>
      </div>

    </div><!-- /.container -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>