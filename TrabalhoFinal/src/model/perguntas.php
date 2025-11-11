<?php
    require_once "../src/db.php";
    // require_once "../src/funcoes.php";
    // require_once "respostas.php";

    class Perguntas {
        private $id; //id da pergunta no banco
        private $numero; //Ordem de aparição da perguntas
        private $texto; //Texto que irá aparecer na tela
        private $tipo; //1 - Respostas de 0 a 10 | 0 - Resposta descritiva
        private $status; // 1 - ativo | 0 - inativo

        public function __construct($texto) {
            $this -> texto = $texto;
            $this -> tipo = 1;
            $this -> status = 1;
        }

        public static function dbAtivasParaObjeto() {
            $perguntas = getPerguntasDb();
            $objetos = array();
            foreach($perguntas as $p) {
                $i = new self($p['texto_pergunta']);
                $i -> id = $p['id_pergunta'];
                $i -> tipo = $p['tipo_pergunta'];
                array_push($objetos,$i);
            }
            return $objetos;
        }
        
        public function perguntaParaDb() {
            setPerguntaDb($this);
        }

        public function responderPergunta($valor) {
            return new Respostas($this-> numero, $this -> tipo, $valor);
        }


        //GETTERS E SETTERS
        public function getNumero() {
            return $this -> numero;
        }

        public function setNumero($numero) {
            $this -> numero = $numero;
        }

        public function getTexto() {
            return $this -> texto;
        }

        public function setTexto($texto) {
            $this -> texto = $texto;
        }

        public function getTipo() {
            return $this -> tipo;
        }

        public function setTipo($tipo) {
            $this -> tipo = $tipo;
        }

        public function getStatus() {
            return $this -> status;
        }

        public function setStatus($status) {
            $this -> status = $status;
        }
    }
?>