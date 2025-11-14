<?php

    class Dispositivo {
        private $id_dispositivo;
        private $id_setor;
        private $nome_dispositivo;
        private $status_dispositivo; // 1 - ativo | 0 - inativo

        public function __construct($id_setor, $nome_dispositivo) {
            $this -> id_setor = $id_setor;
            $this -> nome_dispositivo = $nome_dispositivo;
            $this -> status_dispositivo = '1';
        }

        public function save(PDO $conn) {
            $sql = "INSERT INTO dispositivo (id_setor,nome_dispositivo) VALUES (:setor, :nome)";
            $stmt = $conn->prepare($sql);
            $ok = $stmt->execute([
                ':setor' => $this -> id_setor,
                ':nome' => $this -> nome_dispositivo,
            ]);
            if ($ok) {
                $this->id_dispositivo = $conn->lastInsertId();
                return $this->id_dispositivo;
            }
            return false;
        }

        //GETTERS
        public function getId_dispositivo () {
            return $this -> id_dispositivo;
        }

        public function getId_setor () {
            return $this -> id_setor;
        }

        public function getNome_dispositivo () {
            return $this -> nome_dispositivo;
        }

        public function getStatus () {
            return $this -> status_dispositivo;
        }

        public function ativar_dispositivo () {
            $this -> status_dispositivo = '1';
        }

        public function desativar_dispositivo () {
            $this -> status_dispositivo = '0';
        }
    }
?>