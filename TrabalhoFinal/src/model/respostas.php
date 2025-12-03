<?php
    class Respostas {
        private $idResposta;
        private $idPergunta;
        private $idAvaliacao;
        private $valor;  // número 0 a 10

        public function __construct($idPergunta, $idAvaliacao, $valor) {
            $this->idPergunta = $idPergunta;
            $this->idAvaliacao = $idAvaliacao;
            $this->valor = $valor;
        }

        public function save(PDO $conn) {
            try {
                $sql = "INSERT INTO resposta (id_avaliacao, id_pergunta, nota) VALUES (:avaliacao, :pergunta, :nota)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':avaliacao' => $this->idAvaliacao,
                    ':pergunta'  => $this->idPergunta,
                    ':nota'      => $this->valor
                ]);
                $this->idResposta = $conn->lastInsertId();
                return true;
            } catch (PDOException $e) {
                // logar erro
                return false;
            }
        }

        //GETTERS E SETTERS
        public function getValor() {
            return $this -> valor;
        }

        public function setValor($valor) {
            $this -> valor = $valor;
        }

        public function getIdResposta() {
            return $this -> idResposta;
        }

        public function setIdResposta($idResposta) {
            $this -> idResposta = $idResposta;
        }

        public function getIdPergunta() {
            return $this -> idPergunta;
        }

        public function setIdPergunta($idPergunta) {
            $this -> idPergunta = $idPergunta;
        }

        public function getIdAvaliacao() {
            return $this -> idAvaliacao;
        }

        public function setIdAvaliacao($idAvaliacao) {
            $this -> idAvaliacao = $idAvaliacao;
        }
    }
?>