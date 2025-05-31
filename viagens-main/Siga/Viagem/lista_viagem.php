<?php
require_once("../Classes/Viagem.class.php");

$lista = Viagem::listar();
$tabela = file_get_contents('listagem_viagem.html');
$item = file_get_contents('itens_listagem_viagem.html');
$itens = '';

foreach ($lista as $viagem) {
    $linha = str_replace('{id}', $viagem->getId(), $item);
    $linha = str_replace('{destino}', $viagem->getDestino(), $linha);
    $linha = str_replace('{data_ida}', $viagem->getDataida(), $linha);
    $linha = str_replace('{data_retorno}', $viagem->getDataRetorno(), $linha);
     $linha = str_replace('{motivo}', $viagem->getMotivo(), $linha);
    $documento = $viagem->getDocumento();
    $link = '';

    if (!empty($documento)) {
    $link = "<a href='../uploads/" . htmlspecialchars($documento) . "' target='_blank'>" . htmlspecialchars($documento) . "</a>";
} else {
    $link = '';
}

    $linha = str_replace('{documento}', $link, $linha);
    $itens .= $linha;
}

$tabela = str_replace('{itens}', $itens, $tabela);
echo $tabela;
?>
