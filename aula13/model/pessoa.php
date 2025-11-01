<?php

    class Pessoa {
        private $nome;
        private $sobrenome;
        private $dataNascimento;
        private $cpfcnpj;
        private $tipo;
        private $telefone;
        private $endereco;
        private $dataInstancia;

        public function __construct() {
            $this -> dataInstancia = date("d/m/y h:i:s");
            $this -> inicializaClasse();
        }

        private function inicializaClasse() {
            $this -> tipo = 1;
        }

        public function __call($method, $args) {
            echo "Método " . $method . " não implementado!";
        }

        public function getNomeCompleto() {
            return $this -> nome . " " . $this -> sobrenome;
        }

        public function getIdade() {
            $dataAtual = new DateTime();
            $idade = $dataAtual->diff($this -> dataNascimento);
            return $idade -> y;
        }

        public function getNome() {
            return $this -> nome;
        }

        public function getSobrenome() {
            return $this -> sobrenome;
        }

        public function getDataNascimento() {
            return $this -> dataNascimento;
        }

        public function getCpfCnpj() {
            return $this -> cpfcnpj;
        }

        public function getTipo() {
            return $this -> tipo;
        }

        public function getTelefone() {
            return $this -> telefone;
        }

        public function getEndereco() {
            return $this -> endereco;
        }

        public function getDataInstancia() {
            return $this -> dataInstancia;
        }

        public function setNome($nome) {
            $this -> nome = $nome;
        }

        public function setSobrenome($sobrenome) {
            $this -> sobrenome = $sobrenome;
        }

        public function setCpfCnpj($cpfcnpj) {
            $this -> cpfcnpj = $cpfcnpj;
        }

        public function setTipo($tipo) {
            $this -> tipo = $tipo;
        }

        public function setTelefone($telefone) {
            $this -> telefone = $telefone;
        }

        public function setEndereco($endereco) {
            $this -> endereco = $endereco;
        }

        public function setDataNascimento($dataNascimento) {
            $this -> dataNascimento = $dataNascimento;
        }

    }
?>