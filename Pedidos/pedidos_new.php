<?php 
$tabela = 'pedidos';
$mysql = new MYSQL($cfg);

?>
<form action="index.php?p=pedidos&a=list" method="post">
<label for="cliente">Cliente:<br />
<select name="id_cliente">
<?php 
$result = $mysql->SqlSelect(" SELECT nome, id
    FROM clientes
    ORDER BY nome ASC
    ");
while ($item = mysql_fetch_array($result, MYSQL_ASSOC)) {
    ?>
    <option value="<?php echo $item['id']?>"><?php echo $item['nome']?></option>
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
while ($item = mysql_fetch_array($result, MYSQL_ASSOC)) {
    ?>
    <option value="<?php echo $item['id']?>"><?php echo $item['nome']?></option>
    <?php 
}
?>
</select>
</label><br />
<input name="add" type="hidden" value="1"/>
  <input type="submit" value="Enviar">
</form>
