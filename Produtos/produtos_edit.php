<?php 
$tabela = 'produtos';
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
<form action="index.php?p=produtos&a=edit" method="post">
<label for="nome">Nome:<br />
    <input name="nome" type="text" value="<?php echo $item['nome']?>" />
</label><br />
<label for="descricao">Descrição:<br />
<textarea name="descricao"><?php echo $item['descricao']?></textarea>
</label><br />
<label for="preco">Preço:<br />
<input name="preco" type="number" size="12" value="<?php echo $item['preco']?>" />
</label><br />
<input name="id" type="hidden" value="<?php echo $item['id']?>"/>
<input name="edit" type="hidden" value="1"/>

  <input type="submit" value="Enviar">
</form>