<?php
    require_once "../src/db.php";

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
            $this->dataHora = new DateTime(date('d-m-Y H:m:s'));
        }

        public function objetoParaDb() {
            setAvaliacaoDb($this);
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