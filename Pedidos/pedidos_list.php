<?php
$tabela = 'pedidos';

$mysql = new MYSQL($cfg);
if ($_POST['add']) {
    // adicionar registro.
    array_pop($_POST);
    print_r($_POST);
    $sql = $mysql->SqlInsert($tabela, $_POST);
    $request = $mysql->SqlSelect($sql, __FILE__, __LINE__);
    if ($request)
        print "<h4>Registro Realizado com sucesso!!!</h4>";
}
if ($_POST['del']) {
    // adicionar registro.
    print_r($_POST);
    $idde = trim($_POST['id']);
    $sql = $mysql->SqlDelete($tabela, "id = '$idde'");
    $request = $mysql->SqlSelect($sql, __FILE__, __LINE__);
    if ($request)
        print "<h4>Registro Deletado com sucesso!!!</h4>";
}

$result = $mysql->SqlSelect("
    SELECT B.nome as cliente , C.nome as produto, A.id as id
    FROM pedidos A INNER JOIN clientes B ON A.id_cliente = B.id INNER JOIN produtos C ON A.id_produto = C.id
    ORDER BY cliente ASC
    ");
if ($result) {
    ?>
<div class="col-md-6">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Cliente</th>
				<th>Produto</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
            <?php
    while ($item = mysql_fetch_array($result, MYSQL_ASSOC)) {
        ?>
            <tbody>
			<tr>
				<td><?php echo $item['cliente']?></td>
				<td><?php echo $item['produto']?></td>
				<td>
					<form name="edit" action="index.php" method="post">
						<button type="subimit" class="btn btn-sm btn-link">Editar</button>
						<input name="id" type="hidden" value="<?php echo $item['id']?>" />
						<input name="p" type="hidden" value="pedidos" /> <input name="a"
							type="hidden" value="edit" />
					</form>
				</td>
				<td>
					<form name="del" action="index.php" method="post">
						<button type="subimit" class="btn btn-sm btn-danger">Remover</button>
						<input name="id" type="hidden" value="<?php echo $item['id']?>" />
						<input name="p" type="hidden" value="pedidos" /> <input name="a"
							type="hidden" value="del" /> <input name="del" type="hidden"
							value="1" />
					</form>
			
			</tr>

		</tbody>
            <?php } ?>
          </table>
</div>
<?php } ?>