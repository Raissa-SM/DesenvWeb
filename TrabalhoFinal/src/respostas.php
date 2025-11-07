<?php
    require_once "db.php";

    class Respostas {
        private $numero; // número da pergunta
        private $tipo;   // 1 = nota, 0 = texto
        private $valor;  // número ou texto
        private $id_avaliacao;

        public function __construct($numero, $tipo, $valor, $id_avaliacao) {
            $this->numero = $numero;
            $this->tipo = $tipo;
            $this->valor = $valor;
            $this->id_avaliacao = $id_avaliacao;
        }

        public function setRespostaDb($conn) {
            try {
                if ($this->tipo == '1') {
                    // INSERE RESPOSTA NUMÉRICA
                    $sql = "INSERT INTO resposta (id_avaliacao, id_pergunta, nota)
                            VALUES (:avaliacao, :pergunta, :nota)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':avaliacao' => $this->id_avaliacao,
                        ':pergunta'  => $this->numero,
                        ':nota'      => $this->valor
                    ]);
                } else {
                    // ATUALIZA AVALIAÇÃO COM O FEEDBACK
                    $sql = "UPDATE avaliacao
                            SET feedback_texto = :texto
                            WHERE id_avaliacao = :avaliacao";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':texto'     => $this->valor,
                        ':avaliacao' => $this->id_avaliacao
                    ]);
                }
            } catch (PDOException $e) {
                echo "Erro ao inserir resposta: " . $e->getMessage();
            }
        }


        //GETTERS E SETTERS
        public function getNumero() {
            return $this -> numero;
        }

        public function setNumero($numero) {
            $this -> numero = $numero;
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

        public function getValor() {
            return $this -> valor;
        }

        public function setVarlor($valor) {
            $this -> valor = $valor;
        }

        public function getId_avaliacao() {
            return $this -> staid_avaliacaotus;
        }

        public function setId_avaliacao($id_avaliacao) {
            $this -> id_avaliacao = $id_avaliacao;
        }
    }
?>