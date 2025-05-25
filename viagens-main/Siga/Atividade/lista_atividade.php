 <?php   
 
 $busca = isset($_GET['busca'])?$_GET['busca']:0;
    $tipo = isset($_GET['tipo'])?$_GET['tipo']:0;
   
    $lista = Atividade::listar($tipo, $busca);
    $itens = '';
    $itens= file_get_contents('itens_listagem_atividades.html');
    foreach($lista as $atividade){
    $itens = str_replace('{id}', $atividade-> getId(), $itens );
    $itens = str_replace('{id}', $atividade-> getId(), $itens );
    $itens = str_replace('{id}', $atividade-> getId(), $itens );
    $itens = str_replace('{id}', $atividade-> getId(), $itens );
    $itens.= $itens;
         echo "<tr><td><a href='index.php?id={$atividade->getId()}'>{$atividade->getId()}</a></td><td>{$atividade->getDescricao()}</td><td>{$atividade->getPeso()}</td><td>{$atividade->getAnexo()}</td></tr>";
    }
    $listagem = file_get_contents('itens_listagem_atividades.html');
    $listagem = str_replace('{itens}', $itens, $listagem);~
    print($listagem);
    ?>
