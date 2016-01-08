<?php
$tabela = 'produtos';
$mysql = new MYSQL($cfg);
if ($_POST['add']) {
    // adicionar registro.
    array_pop($_POST);
    $sql = $mysql->SqlInsert($tabela, $_POST);
    $request = $mysql->SqlSelect($sql, __FILE__, __LINE__);
    if ($request)
        print "<h4>Registro Realizado com sucesso!!!</h4>";
}
if ($_POST['del']) {
    // adicionar registro.
    $idde = trim($_POST['id']);
    $sql = $mysql->SqlDelete($tabela, "id = '$idde'");
    $request = $mysql->SqlSelect($sql, __FILE__, __LINE__);
    if ($request)
        print "<h4>Registro Deletado com sucesso!!!</h4>";
}

$result = $mysql->SqlSelect("SELECT id, nome, descricao, preco FROM $tabela");
if ($result) {
    ?>
<div class="col-md-6">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Nome</th>
				<th>Descrição</th>
				<th>Preço</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
            <?php
    while ($item = mysql_fetch_array($result, MYSQL_ASSOC)) {
        ?>
            <tbody>
			<tr>
				<td><?php echo $item['id']?></td>
				<td><?php echo $item['nome']?></td>
				<td><?php echo $item['descricao']?></td>
				<td><?php echo $item['preco']?></td>
				<td>
					<form name="edit" action="index.php" method="post">
						<button type="subimit" class="btn btn-sm btn-link">Editar</button>
						<input name="id" type="hidden" value="<?php echo $item['id']?>" />
						<input name="p" type="hidden" value="produtos" /> <input name="a"
							type="hidden" value="edit" />
					</form>
				</td>
				<td>
					<form name="del" action="index.php" method="post">
						<button type="subimit" class="btn btn-sm btn-danger">Remover</button>
						<input name="id" type="hidden" value="<?php echo $item['id']?>" />
						<input name="p" type="hidden" value="produtos" /> <input name="a"
							type="hidden" value="del" /> <input name="del" type="hidden"
							value="1" />
					</form>
			
			</tr>

		</tbody>
            <?php } ?>
          </table>
</div>
<?php } ?>