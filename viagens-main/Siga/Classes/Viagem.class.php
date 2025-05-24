<?php
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

    public function getId() { return $this->id; }
    public function getDestino() { return $this->destino; }
    public function getDataSaida() { return $this->data_saida; }
    public function getDataRetorno() { return $this->data_retorno; }
    public function getDescricao() { return $this->descricao; }

    public function inserir(): bool {
        $sql = "INSERT INTO viagem (destino, data_saida, data_retorno, descricao)
                VALUES (:destino, :data_saida, :data_retorno, :descricao)";
        $params = [
            ':destino' => $this->destino,
            ':data_saida' => $this->data_saida,
            ':data_retorno' => $this->data_retorno,
            ':descricao' => $this->descricao
        ];
        return Database::executar($sql, $params);
    }

    public function alterar(): bool {
        $sql = "UPDATE viagem SET destino = :destino, data_saida = :data_saida,
                data_retorno = :data_retorno, descricao = :descricao WHERE id = :id";
        $params = [
            ':id' => $this->id,
            ':destino' => $this->destino,
            ':data_saida' => $this->data_saida,
            ':data_retorno' => $this->data_retorno,
            ':descricao' => $this->descricao
        ];
        return Database::executar($sql, $params);
    }

    public function excluir(): bool {
        $sql = "DELETE FROM viagem WHERE id = :id";
        $params = [':id' => $this->id];
        return Database::executar($sql, $params);
    }

    public static function listar($tipo = 0, $info = ''): array {
        $sql = "SELECT * FROM viagem";
        $params = [];
        if ($tipo == 1) {
            $sql .= " WHERE id = :info";
            $params = [':info' => $info];
        }

        $comando = Database::executar($sql, $params);
        $viagens = [];
        while ($registro = $comando->fetch()) {
            $viagens[] = new Viagem(
                $registro['id'],
                $registro['destino'],
                $registro['data_saida'],
                $registro['data_retorno'],
                $registro['descricao']
            );
        }
        return $viagens;
    }
}

?>