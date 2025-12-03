<?php
    class Setor {
        private $idSetor;
        private $nomeSetor;
        private $statusSetor; // 1 - ativo | 0 - inativo

        public function __construct($nomeSetor = null, $status = 1, $id = null) {
            $this->idSetor = $id;
            $this->nomeSetor = $nomeSetor;
            $this->statusSetor = $status;
        }

        public static function listar(PDO $conn) {
            $sql = "SELECT * FROM setor ORDER BY id_setor ASC";
            return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function buscar(PDO $conn, $id) {
            $sql = "SELECT * FROM setor WHERE id_setor = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function save(PDO $conn) {
            $sql = "INSERT INTO setor (nome_setor, status_setor)
                    VALUES (:nome, :status)";
            $stmt = $conn->prepare($sql);
            $ok = $stmt->execute([
                ':nome' => $this->nomeSetor,
                ':status' => $this->statusSetor
            ]);
            return $ok;
        }

        public static function atualizar(PDO $conn, $id, $nome) {
            $sql = "UPDATE setor SET nome_setor = :nome WHERE id_setor = :id";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([':nome' => $nome, ':id' => $id]);
        }

        public static function alterarStatus(PDO $conn, $id, $status) {
            $sql = "UPDATE setor SET status_setor = :s WHERE id_setor = :id";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([':s' => $status, ':id' => $id]);
        }

        //GETTERS
        public function getIdSetor () {
            return $this -> idSetor;
        }

        public function getNomeSetor () {
            return $this -> nomeSetor;
        }

        public function getStatus () {
            return $this -> statusSetor;
        }

        public function ativarSetor () {
            $this -> statusSetor = '1';
        }

        public function desativarSetor () {
            $this -> statusSetor = '0';
        }
    }
?>