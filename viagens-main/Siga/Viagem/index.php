<?php
require_once("../Classes/Viagem.class.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? 0;
    $destino = $_POST['destino'] ?? "";
    $data_saida = $_POST['data_saida'] ?? "";
    $data_retorno = $_POST['data_retorno'] ?? "";
    $descricao = $_POST['descricao'] ?? "";
    $documento = "";
    $acao = $_POST['acao'] ?? "";

     // Upload usando o campo "descricao" como arquivo
    if (isset($_FILES['descricao']) && $_FILES['descricao']['error'] == UPLOAD_ERR_OK) {
        $nomeArquivo = basename($_FILES['descricao']['name']);
        $destino_documento = 'uploads/' . $nomeArquivo;

        if (move_uploaded_file($_FILES['descricao']['tmp_name'], $destino_documento)) {
            $documento = $destino_documento;
        }
    }
    $viagem = new Viagem($id, $destino, $data_saida, $data_retorno, $descricao);
    
    if ($acao == 'salvar') {
        $resultado = ($id > 0) ? $viagem->alterar() : $viagem->inserir();
    } elseif ($acao == 'excluir') {
        $resultado = $viagem->excluir();
    }

    if ($resultado)
        header("Location: index.php");
    else
        echo "Erro ao salvar dados: " . $viagem;
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $formulario = file_get_contents('form_cad_viagem.html');

    $id = $_GET['id'] ?? 0;
    $resultado = Viagem::listar(1, $id);

    if ($resultado) {
        $viagem = $resultado[0];
        $formulario = str_replace('{id}', $viagem->getId(), $formulario);
        $formulario = str_replace('{destino}', $viagem->getDestino(), $formulario);
        $formulario = str_replace('{data_saida}', $viagem->getDataSaida(), $formulario);
        $formulario = str_replace('{data_retorno}', $viagem->getDataRetorno(), $formulario);
        $formulario = str_replace('{descricao}', $viagem->getDescricao(), $formulario);
         $formulario = str_replace('{documento}', $viagem->getDocumento(), $formulario);
    } else {
        $formulario = str_replace('{id}', 0, $formulario);
        $formulario = str_replace('{destino}', '', $formulario);
        $formulario = str_replace('{data_saida}', '', $formulario);
        $formulario = str_replace('{data_retorno}', '', $formulario);
        $formulario = str_replace('{descricao}', '', $formulario);
        $formulario = str_replace('{documento}', '', $formulario);
    }

    echo $formulario;
    include('lista_viagem.php');
}

?>