<?php
    require_once "jogador.php";

    class Time {
        private $nome;
        private $anoFundacao;
        private $jogadores;

        public function __construct($nome, $anoFundacao) {
            $this -> nome = $nome;
            $this -> anoFundacao = $anoFundacao;
            $this -> jogadores = array();
        }

        //GETTERS E SETTERS
        public function getNome() {
            return $this -> nome;
        }

        public function setNome($nome) {
            $this -> nome = $nome;
        }

        public function getAnoFundacao() {
            return $this -> anoFundacao;
        }

        public function setAnoFundacao($anoFundacao) {
            $this -> anoFundacao = $anoFundacao;
        }

        public function getJogadores() {
            foreach($this -> jogadores as $j) {
                echo "<br>Nome: " . $j -> getNome();
                echo "<br>Posição: " . $j -> getPosicao();
                echo "<br>Data de Nascimento: " . $j -> getDataNascimento() -> format('d/m/Y');
            }
        }

        public function setjogadores($nome, $posicao, $dataNascimento) {
            $jogador = new Jogador($nome, $posicao, $dataNascimento);
            array_push($this -> jogadores, $jogador);
        }
    }
?>