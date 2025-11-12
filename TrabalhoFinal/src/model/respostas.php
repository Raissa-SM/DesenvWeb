<?php
    class Respostas {
        private $id_resposta;
        private $id_pergunta;
        private $id_avaliacao;
        private $valor;  // número 0 a 10

        public function __construct($id_pergunta, $id_avaliacao, $valor) {
            $this->id_pergunta = $id_pergunta;
            $this->id_avaliacao = $id_avaliacao;
            $this->valor = $valor;
        }

        public function save(PDO $conn) {
            try {
                $sql = "INSERT INTO resposta (id_avaliacao, id_pergunta, nota) VALUES (:avaliacao, :pergunta, :nota)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':avaliacao' => $this->id_avaliacao,
                    ':pergunta'  => $this->id_pergunta,
                    ':nota'      => $this->valor
                ]);
                $this->id_resposta = $conn->lastInsertId();
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

        public function getId_resposta() {
            return $this -> id_resposta;
        }

        public function setId_resposta($id_resposta) {
            $this -> id_resposta = $id_resposta;
        }

        public function getId_pergunta() {
            return $this -> id_pergunta;
        }

        public function setId_pergunta($id_pergunta) {
            $this -> id_pergunta = $id_pergunta;
        }

        public function getId_avaliacao() {
            return $this -> id_avaliacao;
        }

        public function setId_avaliacao($id_avaliacao) {
            $this -> id_avaliacao = $id_avaliacao;
        }
    }
?>