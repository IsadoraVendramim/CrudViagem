<?php
require_once("Database.class.php");

class Viagem {
    private $id;
    private $destino;
    private $data_saida;
    private $data_retorno;
    private $descricao;

    public function __construct($id, $destino, $data_saida, $data_retorno, $descricao) {
        $this->id = $id;
        $this->destino = $destino;
        $this->data_saida = $data_saida;
        $this->data_retorno = $data_retorno;
        $this->descricao = $descricao;
    }

    
    public function setId($id) {
        if ($id < 0)
            throw new Exception("Erro: ID inválido!");
        $this->id = $id;
    }

    public function setDestino($destino) {
        if (empty($destino))
            throw new Exception("Erro: Destino deve ser informado!");
        $this->destino = $destino;
    }

    public function setDataSaida($data_saida) {
        $this->data_saida = $data_saida;
    }

    public function setDataRetorno($data_retorno) {
        $this->data_retorno = $data_retorno;
    }

    public function setDescricao($descricao) {
        if (empty($descricao))
            throw new Exception("Erro: Descrição deve ser informada!");
        $this->descricao = $descricao;
    }

  
    public function getId(): int {
        return $this->id;
    }

    public function getDestino(): string {
        return $this->destino;
    }

    public function getDataSaida(): string {
        return $this->data_saida;
    }

    public function getDataRetorno(): string {
        return $this->data_retorno;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }


    public function __toString(): string {
        return "Viagem: $this->id - $this->destino
                | Saída: $this->data_saida
                | Retorno: $this->data_retorno
                | Descrição: $this->descricao";
    }


    public function inserir(): bool {
        $sql = "INSERT INTO viagem (destino, data_saida, data_retorno, descricao)
                VALUES (:destino, :data_saida, :data_retorno, :descricao)";
        $params = array(
            ':destino' => $this->getDestino(),
            ':data_saida' => $this->getDataSaida(),
            ':data_retorno' => $this->getDataRetorno(),
            ':descricao' => $this->getDescricao()
        );
        return Database::executar($sql, $params) !== false;
    }

   
    public static function listar($tipo = 0, $info = ''): array {
        $sql = "SELECT * FROM viagem";
        switch ($tipo) {
            case 1:
                $sql .= " WHERE id = :info ORDER BY id";
                break;
            case 2:
                $sql .= " WHERE destino LIKE :info ORDER BY destino";
                $info = '%' . $info . '%';
                break;
        }

        $parametros = [];
        if ($tipo > 0) $parametros = [':info' => $info];

        $comando = Database::executar($sql, $parametros);
        $viagens = [];
        while ($registro = $comando->fetch()) {
            $viagem = new Viagem(
                $registro['id'],
                $registro['destino'],
                $registro['data_saida'],
                $registro['data_retorno'],
                $registro['descricao']
            );
            array_push($viagens, $viagem);
        }
        return $viagens;
    }

  
    public function alterar(): bool {
        $sql = "UPDATE viagem
                   SET destino = :destino,
                       data_saida = :data_saida,
                       data_retorno = :data_retorno,
                       descricao = :descricao
                 WHERE id = :id";
        $params = array(
            ':id' => $this->getId(),
            ':destino' => $this->getDestino(),
            ':data_saida' => $this->getDataSaida(),
            ':data_retorno' => $this->getDataRetorno(),
            ':descricao' => $this->getDescricao()
        );
        return Database::executar($sql, $params) !== false;
    }


    public function excluir(): bool {
        $sql = "DELETE FROM viagem WHERE id = :id";
        $params = array(':id' => $this->getId());
        return Database::executar($sql, $params) !== false;
    }
}
?>
