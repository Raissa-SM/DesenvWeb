<?php
    class Pessoa {
        private $nome;
        private $sobreNome;
        private $dataNascimento;
        private $cpfCnpj;
        private $tipo; // 1 - Fisica | 2 - Juridica
        private $contato;
        private $endereco;

        public function __construct() {
            $this -> inicializaClasse();
        }  

        private function inicializaClasse(){
            $this -> tipo = 1;
            $this -> contato = array();
        }
        
        public function getNomeCompleto() {
            return $this -> nome . " " . $this -> sobreNome;
        }

        public function getIdade() {
            $dataAtual = new DateTime();
            $idade = $dataAtual -> diff($this -> dataNascimento);
            return $idade -> y;
        }

        public function getDescricaoTipo() {
            switch($this -> tipo){
                case 1:
                    return "Física";
                case 2:
                    return "Jurídica";
                default:
                    return "Desconhecido";
            }
        }

        public function descricaoGeral() {
            echo "<h2>Dados da Pessoa</h2>";

            echo "Nome completo: " . $this->getNomeCompleto() . "<br>";

            if ($this->getDataNascimento() != null) {
                echo "Data de nascimento: " . $this->getDataNascimento() -> format('d/m/Y') . "<br>";
                echo "Idade: " . $this->getIdade() . "<br>";
            }

            echo "Tipo: " . $this->getDescricaoTipo() . "<br>";

            if ($this->getTipo() == 1) {
                echo "CPF: " . $this->getCpfCnpj() . "<br>";
            } else {
                echo "CNPJ: " . $this->getCpfCnpj() . "<br>";
            }

            if ($this->getEndereco() != null) {
                $end = $this->getEndereco();
                echo "<h3>Endereço</h3>";
                echo $end->getLogradouro() . ", " . $end->getBairro() . "<br>";
                echo $end->getCidade() . " - " . $end->getEstado();
                echo " | CEP: " . $end->getCep() . "<br>";
            }

            echo "<h3>Contatos</h3>";
            if (!empty($this->getContatos())) {
                foreach ($this->getContatos() as $c) {
                    echo "- " . $c->getNome() . ": " . $c->getValor() . "<br>";
                }
            } else {
                echo "Nenhum contato cadastrado.<br>";
            }
        }


        // Getters and Setters
        public function getNome() {
            return $this -> nome;
        }   

        public function setNome($nome) {
            $this -> nome = $nome;
        }

        public function getSobreNome() {
            return $this -> sobreNome;
        }

        public function setSobreNome($sobreNome) {
            $this -> sobreNome = $sobreNome;
        }

        public function getDataNascimento() {
            return $this -> dataNascimento;
        }

        public function setDataNascimento($dataNascimento) {
            $this -> dataNascimento = $dataNascimento;
        }

        public function getCpfCnpj() {
            return $this -> cpfCnpj;
        }

        public function setCpfCnpj($cpfCnpj) {
            $this -> cpfCnpj = $cpfCnpj;
        }

        public function getTipo() {
            return $this -> tipo;
        }

        public function setTipo($tipo) {
            if($tipo < 1 || $tipo > 2){
                throw new Exception("Tipo inválido. Use 1 para Física ou 2 para Jurídica.");
            }
            $this -> tipo = $tipo;
        }

        public function getContatos() {
            return $this -> contato;
        }

        public function addContato($contato) {
            array_push($this -> contato, $contato);
        }

        public function getEndereco() {
            return $this -> endereco;
        }   

        public function setEndereco($endereco) {
            $this -> endereco = $endereco;
        }
    }
?>