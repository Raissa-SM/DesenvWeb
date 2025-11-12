<?php

    class Avaliacao {
        private $id_avaliacao;
        private $id_setor;
        private $id_dispositivo;
        private $feedback_texto;
        private $data_hora;

        public function __construct($id_setor, $id_dispositivo, $feedback_texto) {
            $this->id_setor = $id_setor;
            $this->id_dispositivo = $id_dispositivo;
            $this->feedback_texto = $feedback_texto;
            $this->data_hora = new DateTime();
        }

        public function save(PDO $conn) {
            $sql = "INSERT INTO avaliacao (id_setor, id_dispositivo, feedback_texto, data_hora) VALUES (:setor, :dispositivo, :feedback, :data_hora)";
            $stmt = $conn->prepare($sql);
            $ok = $stmt->execute([
                ':setor' => $this->id_setor,
                ':dispositivo' => $this->id_dispositivo,
                ':feedback' => $this->feedback_texto,
                ':data_hora' => $this->data_hora->format('Y-m-d H:i:s')
            ]);
            if ($ok) {
                $this->id_avaliacao = $conn->lastInsertId();
                return $this->id_avaliacao;
            }
            return false;
        }

        //GETTERS
        public function getId_avaliacao () {
            return $this -> id_avaliacao;
        }
        public function getId_setor () {
            return $this -> id_setor;
        }

        public function getId_dispositivo () {
            return $this -> id_dispositivo;
        }

        public function getFeedback_texto () {
            return $this -> feedback_texto;
        }

        
        public function getData_hora () {
            return $this -> data_hora;
        }
    }
?>