<?php
    class Setor {
        private $id_setor;
        private $nome_setor;
        private $status_setor; // 1 - ativo | 0 - inativo

        public function __construct($nome_setor = null, $status = 1, $id = null) {
            $this->id_setor = $id;
            $this->nome_setor = $nome_setor;
            $this->status_setor = $status;
        }

        public static function listar(PDO $conn) {
            $sql = "SELECT * FROM setor ORDER BY id_setor DESC";
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
                ':nome' => $this->nome_setor,
                ':status' => $this->status_setor
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
        public function getId_setor () {
            return $this -> id_setor;
        }

        public function getNome_setor () {
            return $this -> nome_setor;
        }

        public function getStatus () {
            return $this -> status_setor;
        }

        public function ativar_setor () {
            $this -> status_setor = '1';
        }

        public function desativar_setor () {
            $this -> status_setor = '0';
        }
    }
?>