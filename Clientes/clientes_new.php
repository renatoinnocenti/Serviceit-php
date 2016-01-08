<?php 

$tabela = 'clientes';
$mysql = new MYSQL($cfg);

?>
<form action="index.php?p=clientes&a=list" method="post">
<label for="nome">Nome:<br />
    <input name="nome" type="text" />
</label><br />
<label for="email">Email:<br />
    <input name="email" type="text" />
</label><br />
<label for="telefone">Telefone:<br />
<input name="telefone" type="number" size="12" />
</label><br />
<input name="add" type="hidden" value="1"/>
  <input type="submit" value="Enviar">
</form>
