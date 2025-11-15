<?php
    require_once "../src/db.php";

    class Perguntas {
        private $id_pergunta; //id da pergunta no banco
        private $id_setor; //id do setor da pergunta no banco
        private $numero_pergunta; //Ordem de aparição da perguntas
        private $texto_pergunta; //Texto que irá aparecer na tela
        private $tipo_pergunta; //1 - Respostas de 0 a 10 | 0 - Resposta descritiva
        private $status_pergunta; // 1 - ativo | 0 - inativo

        public function __construct($id_setor, $texto_pergunta, $numero_pergunta = null, $tipo_pergunta = 1, $status_pergunta = 1) {
            $this->id_setor = $id_setor;
            $this->texto_pergunta = $texto_pergunta;
            $this->numero_pergunta = $numero_pergunta;
            $this->tipo_pergunta = $tipo_pergunta;
            $this->status_pergunta = $status_pergunta;
        }

        public function save(PDO $conn) {
            $sql = "INSERT INTO pergunta (id_setor, texto_pergunta, numero_pergunta, tipo_pergunta, status_pergunta)
                    VALUES (:setor, :texto, :numero, :tipo, :status)";
            $stmt = $conn->prepare($sql);
            $ok = $stmt->execute([
                ':setor' => $this->id_setor,
                ':texto' => $this->texto_pergunta,
                ':numero' => $this->numero_pergunta,
                ':tipo' => $this->tipo_pergunta,
                ':status' => $this->status_pergunta
            ]);
            if ($ok) {
                $this->id_pergunta = $conn->lastInsertId();
                return $this->id_pergunta;
            }
            return false;
        }

        public static function getAtivasSetor(PDO $conn, $id_setor) {
            $sql = "SELECT * FROM pergunta WHERE status_pergunta = '1' AND id_setor = $id_setor ORDER BY numero_pergunta";
            $stmt = $conn->query($sql);
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $perguntas = [];
            foreach ($dados as $p) {
                $obj = new self($p['id_setor'], 
                               $p['texto_pergunta'], 
                               $p['numero_pergunta'], 
                               $p['tipo_pergunta'], 
                               $p['status_pergunta']);
                $obj->id_pergunta = $p['id_pergunta'];
                $perguntas[] = $obj;
            }
            return $perguntas;
        }

        //GETTERS E SETTERS
        public function getId() { 
            return $this->id_pergunta; 
        }

        public function getNumero() { 
            return $this->numero_pergunta; 
        }

        public function setNumero($num) { 
            $this->numero_pergunta = $num; 
        }

        public function getTexto() { 
            return $this->texto_pergunta; 
        }

        public function setTexto($txt) { 
            $this->texto_pergunta = $txt; 
        }

        public function getTipo() { 
            return $this->tipo_pergunta; 
        }

        public function setTipo($tipo) { 
            $this->tipo_pergunta = $tipo; 
        }

        public function getStatus() { 
            return $this->status_pergunta; 
        }

        public function ativar_pergunta () {
            $this -> status_pergunta = '1';
        }

        public function desativar_pergunta () {
            $this -> status_pergunta = '0';
        }        
    }
?>