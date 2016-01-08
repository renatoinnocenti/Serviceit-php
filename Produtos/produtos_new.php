<?php 
$tabela = 'produtos';
$mysql = new MYSQL($cfg);

?>
<form action="index.php?p=produtos&a=list" method="post">
<label for="nome">Nome:<br />
    <input name="nome" type="text" />
</label><br />
<label for="descricao">Descrição:<br />
<textarea name="descricao"></textarea>
</label><br />
<label for="preco">Preço:<br />
<input name="preco" type="number" size="12" />
</label><br />
<input name="add" type="hidden" value="1"/>
  <input type="submit" value="Enviar">
</form>
