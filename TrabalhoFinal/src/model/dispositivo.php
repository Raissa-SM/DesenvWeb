<?php

    class Dispositivo {
        private $id_dispositivo;
        private $id_setor;
        private $nome_dispositivo;
        private $status_dispositivo; // 1 - ativo | 0 - inativo

    public function __construct($id_setor = null, $nome_dispositivo = null, $status = 1, $id = null) {
            $this->id_dispositivo = $id;
            $this->id_setor = $id_setor;
            $this->nome_dispositivo = $nome_dispositivo;
            $this->status_dispositivo = $status;
        }

        /* ===== LISTAR TODOS ===== */
        public static function listar(PDO $conn) {
            $sql = "SELECT d.*, s.nome_setor 
                    FROM dispositivo d
                    JOIN setor s ON d.id_setor = s.id_setor
                    ORDER BY d.id_dispositivo ASC";

            return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        /* ===== BUSCAR ===== */
        public static function buscar(PDO $conn, $id) {
            $sql = "SELECT * FROM dispositivo WHERE id_dispositivo = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /* ===== SALVAR ===== */
        public function save(PDO $conn) {
            $sql = "INSERT INTO dispositivo (id_setor, nome_dispositivo, status_dispositivo)
                    VALUES (:setor, :nome, :status)";

            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                ':setor'  => $this->id_setor,
                ':nome'   => $this->nome_dispositivo,
                ':status' => $this->status_dispositivo
            ]);
        }

        /* ===== EDITAR ===== */
        public static function atualizar(PDO $conn, $id, $nome, $setor) {
            $sql = "UPDATE dispositivo 
                    SET nome_dispositivo = :nome,
                        id_setor = :setor
                    WHERE id_dispositivo = :id";

            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                ':nome'  => $nome,
                ':setor' => $setor,
                ':id'    => $id
            ]);
        }

        /* ===== STATUS ===== */
        public static function alterarStatus(PDO $conn, $id, $status) {
            $sql = "UPDATE dispositivo 
                    SET status_dispositivo = :s 
                    WHERE id_dispositivo = :id";

            $stmt = $conn->prepare($sql);
            return $stmt->execute([':s' => $status, ':id' => $id]);
        }

        public static function getDescricaoCompleta(PDO $conn, int $id_dispositivo){
            $sql = "SELECT d.nome_dispositivo, s.nome_setor
                    FROM dispositivo d
                    JOIN setor s ON d.id_setor = s.id_setor
                    WHERE d.id_dispositivo = :id";

            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id_dispositivo]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                return $resultado['nome_dispositivo'] . " - " . $resultado['nome_setor'];
            }

            return null;
        }

        public static function getSetorByDispositivo(PDO $conn, $id_dispositivo) {
            $sql = "SELECT id_setor FROM dispositivo WHERE id_dispositivo = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id_dispositivo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public static function getPorSetor(PDO $conn) {
            $sql = "SELECT s.id_setor, s.nome_setor, d.id_dispositivo, d.nome_dispositivo
                    FROM setor s
                    JOIN dispositivo d ON d.id_setor = s.id_setor
                    WHERE s.status_setor = '1' AND d.status_dispositivo = '1'
                    ORDER BY s.nome_setor, d.nome_dispositivo";

            $stmt = $conn->query($sql);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $setores = [];
            foreach ($resultados as $r) {
                $setores[$r['nome_setor']][] = $r;
            }
            return $setores;
        }

        //GETTERS
        public function getId_dispositivo () {
            return $this -> id_dispositivo;
        }

        public function getId_setor () {
            return $this -> id_setor;
        }

        public function getNome_dispositivo () {
            return $this -> nome_dispositivo;
        }

        public function getStatus () {
            return $this -> status_dispositivo;
        }

        public function ativar_dispositivo () {
            $this -> status_dispositivo = '1';
        }

        public function desativar_dispositivo () {
            $this -> status_dispositivo = '0';
        }
    }
?>