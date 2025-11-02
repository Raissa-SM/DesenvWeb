<?php   
    class Contato {
        private $tipo; // 1 - Email | 2 - Telefone | 3 - Celular
        private $nome;
        private $valor;

        public function __construct($tipo, $nome, $valor) {
            $this -> tipo = $tipo;
            $this -> nome = $nome;
            $this -> valor = $valor;
        }

        public function getDescricaoTipo() {
            switch($this -> tipo){
                case 1:
                    return "Email";
                case 2:
                    return "Telefone";
                case 3:
                    return "Celular";
                default:
                    return "Desconhecido";
            }
        }

        public function toArray() {
            return [
                "nome" => $this->nome,
                "valor" => $this->valor
            ];
        }


        // Getters and Setters
        public function getTipo() {
            return $this -> tipo;
        }   

        public function setTipo($tipo) {
            $this -> tipo = $tipo;
        }

        public function getNome() {
            return $this -> nome;
        }

        public function setNome($nome) {
            $this -> nome = $nome;
        }

        public function getValor() {
            return $this -> valor;
        }

        public function setValor($valor) {
            $this -> valor = $valor;
        }
    }
?>