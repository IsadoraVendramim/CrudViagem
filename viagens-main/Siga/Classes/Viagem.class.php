<?php
require_once("Database.class.php");

class Viagem {
    private $id;
    private $destino;
    private $data_ida;
    private $data_retorno;
    private $motivo;
    private $documento;

    public function __construct($id, $destino, $data_ida, $data_retorno, $motivo, $documento) {
        $this->id = $id;
        $this->destino = $destino;
        $this->data_ida = $data_ida;
        $this->data_retorno = $data_retorno;
        $this->motivo = $motivo;
        $this->documento = $documento;
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

    public function setDataIda($data_ida) {
        $this->data_ida = $data_ida;
    }

    public function setDataRetorno($data_retorno) {
        $this->data_retorno = $data_retorno;
    }
     public function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

    public function setDocumento($documento) {
        if (empty($documento))
            throw new Exception("Erro:O documento não foi adicionado!");
        $this->documento = $documento;
    }

  
    public function getId(): int {
        return $this->id;
    }

    public function getDestino(): string {
        return $this->destino;
    }

    public function getDataIda(): string {
        return $this->data_ida;
    }

    public function getDataRetorno(): string {
        return $this->data_retorno;
    }
     public function getMotivo(): string {
        return $this->motivo;
    }
    public function getDocumento(): string {
        return $this->documento;
    }


    public function __toString(): string {
        return "Viagem: $this->id - $this->destino
                | Saída: $this->data_ida
                | Retorno: $this->data_retorno
                | Motivo: $this->motivo
                | Documento: $this->documento";
    }


    public function inserir(): bool {
        $sql = "INSERT INTO viagem (destino, data_ida, data_retorno, motivo, documento)
                VALUES (:destino, :data_ida, :data_retorno,:motivo, :documento)";
        $params = array(
            ':destino' => $this->getDestino(),
            ':data_ida' => $this->getDataIda(),
            ':data_retorno' => $this->getDataRetorno(),
            ':motivo' => $this->getMotivo(),
            ':documento' => $this->getDocumento()
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
                $registro['data_ida'],
                $registro['data_retorno'],
                $registro['motivo'],
                $registro['documento']
            );
            array_push($viagens, $viagem);
        }
        return $viagens;
    }

  
    public function alterar(): bool {
        $sql = "UPDATE viagem
                   SET destino = :destino,
                       data_ida = :data_ida,
                       data_retorno = :data_retorno,
                       motivo = :motivo,
                       documento = :documento
                 WHERE id = :id";
        $params = array(
            ':id' => $this->getId(),
            ':destino' => $this->getDestino(),
            ':data_ida' => $this->getDataIda(),
            ':data_retorno' => $this->getDataRetorno(),
            ':motivo' => $this ->getMotivo(),
            ':documento' => $this->getDocumento()
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
