<?php

    class Dispositivo {
        private $idDispositivo;
        private $idSetor;
        private $nomeDispositivo;
        private $statusDispositivo; // 1 - ativo | 0 - inativo

    public function __construct($idSetor = null, $nomeDispositivo = null, $status = 1, $id = null) {
            $this->idDispositivo = $id;
            $this->idSetor = $idSetor;
            $this->nomeDispositivo = $nomeDispositivo;
            $this->statusDispositivo = $status;
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
                ':setor'  => $this->idSetor,
                ':nome'   => $this->nomeDispositivo,
                ':status' => $this->statusDispositivo
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

        public static function getDescricaoCompleta(PDO $conn, int $idDispositivo){
            $sql = "SELECT d.nome_dispositivo, s.nome_setor
                    FROM dispositivo d
                    JOIN setor s ON d.id_setor = s.id_setor
                    WHERE d.id_dispositivo = :id";

            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $idDispositivo]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                return $resultado['nome_dispositivo'] . " - " . $resultado['nome_setor'];
            }

            return null;
        }

        public static function getSetorByDispositivo(PDO $conn, $idDispositivo) {
            $sql = "SELECT id_setor FROM dispositivo WHERE id_dispositivo = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $idDispositivo]);
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
        public function getIdDispositivo () {
            return $this -> idDispositivo;
        }

        public function getIdSetor () {
            return $this -> idSetor;
        }

        public function getNomeDispositivo () {
            return $this -> nomeDispositivo;
        }

        public function getStatus () {
            return $this -> statusDispositivo;
        }

        public function ativarDispositivo () {
            $this -> statusDispositivo = '1';
        }

        public function desativarDispositivo () {
            $this -> statusDispositivo = '0';
        }
    }
?>