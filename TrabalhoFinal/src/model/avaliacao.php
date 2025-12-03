<?php

    class Avaliacao {
        private $idAvaliacao;
        private $idDispositivo;
        private $feedback;
        private $dataHora;

        public function __construct($idDispositivo, $feedback) {
            $this->idDispositivo = $idDispositivo;
            $this->feedback = $feedback;
            $this->dataHora = new DateTime();
        }

        public function save(PDO $conn) {
            $sql = "INSERT INTO avaliacao (id_dispositivo, feedback_texto, data_hora) VALUES (:dispositivo, :feedback, :data_hora)";
            $stmt = $conn->prepare($sql);
            $ok = $stmt->execute([
                ':dispositivo' => $this->idDispositivo,
                ':feedback' => $this->feedback,
                ':data_hora' => $this->dataHora->format('Y-m-d H:i:s')
            ]);
            if ($ok) {
                $this->idAvaliacao = $conn->lastInsertId();
                return $this->idAvaliacao;
            }
            return false;
        }

        //GETTERS
        public function getIdAvaliacao () {
            return $this -> idAvaliacao;
        }

        public function getIdDispositivo () {
            return $this -> idDispositivo;
        }

        public function getFeedback () {
            return $this -> feedbacK;
        }

        
        public function getDataHora () {
            return $this -> dataHora;
        }
    }
?>