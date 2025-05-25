<?php
require_once("Atividade.class.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = isset($_POST['id'])?$_POST['id']:0;
    $descricao = isset($_POST['descricao'])?$_POST['descricao']:"";
    $peso = isset($_POST['peso'])?$_POST['peso']:0;
    $anexo = isset($_POST['anexo'])?$_POST['anexo']:"";
    $acao = isset($_POST['acao'])?$_POST['acao']:"";
   if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] == UPLOAD_ERR_OK) {
        $nomeArquivo = basename($_FILES['anexo']['name']);
        $destino_anexo = 'uploads/' . $nomeArquivo;

        if (move_uploaded_file($_FILES['anexo']['tmp_name'], $destino_anexo)) {
            $anexo = $destino_anexo;
        }
    }
    $atividade = new Atividade($id,$descricao,$peso,$destino_anexo);
    if ($acao == 'salvar')
        if ($id > 0)
            $resultado = $atividade->alterar();
        else
            $resultado = $atividade->inserir();
    elseif ($acao == 'excluir')
        $resultado = $atividade->excluir();

    if ($resultado)
        header("Location: index.php");
    else
        echo "Erro ao salvar dados: ". $atividade;
}elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
$formulario = file_get_contents('form_cad_atividades.html');

    $id = isset($_GET['id'])?$_GET['id']:0;
    $resultado = Atividade::listar(1,$id);
    if ($resultado){
        $atividade = $resultado[0];
        $formulario = str_replace('{id}', $atividade-> getId(), $formulario );
        $formulario = str_replace('{descricao}', $atividade-> getDescricao(), $formulario );
        $formulario = str_replace('{peso}', $atividade-> getPeso(), $formulario );
        $formulario = str_replace('{anexo}', $atividade-> getAnexo(), $formulario );
       }else{
        $formulario = str_replace('{id}','', $formulario );
        $formulario = str_replace('{descricao}','', $formulario );
        $formulario = str_replace('{peso}','', $formulario );
        $formulario = str_replace('{anexo}','', $formulario );
        }
        print($formulario);
    
    /*  $busca = isset($_GET['busca'])?$_GET['busca']:0;
    $tipo = isset($_GET['tipo'])?$_GET['tipo']:0;
   
    $lista = Atividade::listar($tipo, $busca);

   <?php
            foreach($lista as $atividade){
                echo "<tr><td><a href='index.php?id={$atividade->getId()}'>{$atividade->getId()}</a></td><td>{$atividade->getDescricao()}</td><td>{$atividade->getPeso()}</td><td>{$atividade->getAnexo()}</td></tr>";
            }
        ?>*/ 

}

?>