<?php
require_once("../Classes/Viagem.class.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? 0;
    $destino = $_POST['destino'] ?? "";
    $data_ida = $_POST['data_saida'] ?? "";
    $data_retorno = $_POST['data_retorno'] ?? "";
    $motivo = $_POST['motivo'] ?? "";
    $documento = '';

if (isset($_FILES['documuneto']) && $_FILES['documuneto']['error'] == UPLOAD_ERR_OK) {
    $nomeArquivo = basename($_FILES['documuneto']['name']);
    $documuneto = $nomeArquivo;
    move_uploaded_file($_FILES['documuneto']['tmp_name'], "../uploads/" . $nomeArquivo);
}

    $acao = $_POST['acao'] ?? "";

    $viagem = new Viagem($id, $destino, $data_ida, $data_retorno, $motivo, $documento );
    //cria obj viagem
    if ($acao == 'salvar') {
        $resultado = ($id > 0) ? $viagem->alterar() : $viagem->inserir();
    } elseif ($acao == 'excluir') {
        $resultado = $viagem->excluir();
    }

    header("Location: index.php");
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $formulario = file_get_contents('form_cad_viagem.html');

    $id = $_GET['id'] ?? 0;
    $viagem = Viagem::listar(1, $id)[0] ?? null;

    $formulario = str_replace('{id}', $viagem?->getId() ?? 0, $formulario);
    $formulario = str_replace('{destino}', $viagem?->getDestino() ?? '', $formulario);
    $formulario = str_replace('{data_ida}', $viagem?->getDataIda() ?? '', $formulario);
    $formulario = str_replace('{data_retorno}', $viagem?->getDataRetorno() ?? '', $formulario);
    $formulario = str_replace('{motivo}', $viagem?->getMotivo() ?? '', $formulario);
    $formulario = str_replace('{documento}', $viagem?->getDocumeto() ?? '', $formulario);

    echo $formulario;
    include_once('lista_viagem.php');
}
?>
