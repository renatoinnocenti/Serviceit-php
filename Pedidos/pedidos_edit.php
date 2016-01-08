<?php 
$tabela = 'pedidos';
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
<form action="index.php?p=pedidos&a=edit" method="post">
<label for="cliente">Cliente:<br />
<select name="id_cliente">
<?php 
$result = $mysql->SqlSelect(" SELECT nome, id
    FROM clientes
    ORDER BY nome ASC
    ");
while ($itema = mysql_fetch_array($result, MYSQL_ASSOC)) {
    if ($item['id_cliente'] == $itema['id']){$det = 'selected="selected"';}else{$det = '';}
    ?>
    <option <?php echo $det?> value="<?php echo $itema['id']?>"><?php echo $itema['nome']?></option>
    <?php 
}
?>
</select>
</label><br />
<label for="produto">Produtos:<br />
<select name="id_produto">
<?php 
$result = $mysql->SqlSelect(" SELECT nome, id
    FROM produtos
    ORDER BY nome ASC
    ");
while ($itema = mysql_fetch_array($result, MYSQL_ASSOC)) {
    
    if ($item['id_produto'] == $itema['id']){ $det = 'selected="selected"';}else{$det = '';}
    ?>
    <option <?php echo $det?> value="<?php echo $itema['id']?>"><?php echo $itema['nome']?></option>
    <?php 
}
?>
</select>
</label><br />
<input name="id" type="hidden" value="<?php echo $item['id']?>"/>
<input name="edit" type="hidden" value="1"/>

  <input type="submit" value="Enviar">
</form>