<?php
    require_once "db.php";
    require_once "respostas.php";

    class Perguntas {
        private $numero; //Ordem de aparição da perguntas
        private $texto; //Texto que irá aparecer na tela
        private $tipo; //1 - Respostas de 0 a 10 | 0 - Resposta descritiva
        private $status; // 1 - ativo | 0 - inativo

        public function __construct($texto) {
            $this -> texto = $texto;
            $this -> tipo = 1;
            $this -> status = 1;
        }
        
        public function setPerguntaDb($conn) {
            try {
                $sql = "INSERT INTO pergunta (texto_pergunta, numero_pergunta, tipo_pergunta)
                        VALUES (:texto, :numero, :tipo)";

                $stmt = $conn->prepare($sql);

                $stmt->execute([
                    ':texto'  => $this -> texto,
                    ':numero' => $this -> numero,
                    ':tipo'   => $this -> tipo
                ]);

                echo "Pergunta inserida com sucesso!";

            } catch (PDOException $e) {
                echo "Erro ao inserir pergunta: " . $e->getMessage();
            }
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
            if ($tipo == false) {
                $this -> numero = 0;
            }
        }

        public function getStatus() {
            return $this -> status;
        }

        public function setStatus($status) {
            $this -> status = $status;
        }
    }
?>