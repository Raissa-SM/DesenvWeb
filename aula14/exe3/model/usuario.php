<?php
    class Usuario {
        private $nome;
        private $login;
        private $pass;

        public function __construct($nome, $login, $pass) {
            $this -> nome = $nome;
            $this -> login = $login;
            $this -> pass = $pass;
        }

        //GETTERS E SETTERS
        public function getNome() {
            return $this -> nome;
        }

        public function setNome($nome) {
            $this -> nome = $nome;
        }

        public function getLogin() {
            return $this -> login;
        }

        public function setLogin($login) {
            $this -> login = $login;
        }

        public function getPass() {
            return $this -> pass;
        }

        public function setPass($pass) {
            $this -> pass = $pass;
        }
    }
?>