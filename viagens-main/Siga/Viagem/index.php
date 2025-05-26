<?php
require_once("../Classes/Viagem.class.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? 0;
    $destino = $_POST['destino'] ?? "";
    $data_saida = $_POST['data_saida'] ?? "";
    $data_retorno = $_POST['data_retorno'] ?? "";
    $descricao = ''; // Agora, descricao é o nome do arquivo enviado
if (isset($_FILES['descricao']) && $_FILES['descricao']['error'] == UPLOAD_ERR_OK) {
    $nomeArquivo = basename($_FILES['descricao']['name']);
    $descricao = $nomeArquivo;
    move_uploaded_file($_FILES['descricao']['tmp_name'], "../uploads/" . $nomeArquivo);
}

    $acao = $_POST['acao'] ?? "";

    $caminho_anexo = '';
    if (isset($_FILES['descricao']) && $_FILES['descricao']['error'] == UPLOAD_ERR_OK) {
    $nomeArquivo = basename($_FILES['descricao']['name']);
    $caminho_anexo = $nomeArquivo;
    move_uploaded_file($_FILES['descricao']['tmp_name'], "../uploads/" . $nomeArquivo);
}


    $viagem = new Viagem($id, $destino, $data_saida, $data_retorno, $descricao, $caminho_anexo);

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
    $formulario = str_replace('{data_saida}', $viagem?->getDataSaida() ?? '', $formulario);
    $formulario = str_replace('{data_retorno}', $viagem?->getDataRetorno() ?? '', $formulario);
    $formulario = str_replace('{descricao}', $viagem?->getDescricao() ?? '', $formulario);

    echo $formulario;
    include_once('lista_viagem.php');
}
?>
