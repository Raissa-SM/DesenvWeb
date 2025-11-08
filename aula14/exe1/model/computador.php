<?php
    class Computador {
        private $status;
        
        public function ligar() {
            echo "Ligado<br>";
            $this -> status = 'Ligado';
        }

        public function desligar() {
            echo "Desligado<br>";
            $this -> status = 'Desligado';
        }

        //GETTERS E SETTERS
        public function getStatus () {
            return $this -> status;
        }

        public function setStatus ($status) {
            $this -> status = $status;
        }
    }
?>