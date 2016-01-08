<?php 

$tabela = 'clientes';
$mysql = new MYSQL($cfg);
$idde = trim($_POST['id']);

if(trim($_POST['edit'])){
    array_pop($_POST);
    $sql = $mysql->SqlUpdate($tabela,$_POST,"id = '$idde'");
    $request = $mysql->SqlSelect($sql);
    $request = $mysql->SqlSelect($sql,__FILE__,__LINE__);
    if (request)print "<h4>Registro Atualizado com sucesso!!!</h4>";
}
$result = $mysql->SqlSelect("SELECT * FROM $tabela WHERE id = '".$idde."'");
$item = mysql_fetch_array($result,MYSQL_ASSOC);

?>
<form action="index.php?p=clientes&a=edit" method="post">
<label for="nome">Nome:<br />
    <input name="nome" type="text" value="<?php echo $item['nome']?>" />
</label><br />
<label for="email">Email:<br />
    <input name="email" type="text" value="<?php echo $item['email']?>" />
</label><br />
<label for="telefone">Telefone:<br />
<input name="telefone" type="number" size="12" value="<?php echo $item['telefone']?>" />
</label><br />
<input name="id" type="hidden" value="<?php echo $item['id']?>"/>
<input name="edit" type="hidden" value="1"/>

  <input type="submit" value="Enviar">
</form>