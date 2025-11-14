<?php

    class Setor {
        private $id_setor;
        private $nome_setor;
        private $status_setor; // 1 - ativo | 0 - inativo

        public function __construct($nome_setor) {
            $this -> nome_setor = $nome_setor;
            $this -> status_setor = '1';
        }

        public function save(PDO $conn) {
            $sql = "INSERT INTO setor (nome_setor) VALUES (:nome)";
            $stmt = $conn->prepare($sql);
            $ok = $stmt->execute([
                ':nome' => $this -> nome_setor,
            ]);
            if ($ok) {
                $this->id_setor = $conn->lastInsertId();
                return $this->id_setor;
            }
            return false;
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