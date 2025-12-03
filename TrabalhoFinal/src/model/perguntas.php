<?php
    require_once __DIR__ . "/../db.php";

    class Perguntas {
        private $id_pergunta;
        private $id_setor;
        private $numero_pergunta;
        private $texto_pergunta;
        private $tipo_pergunta; // '1' nota | '0' texto
        private $status_pergunta; // '1' ativo | '0' inativo

        public function __construct($id_setor, $texto_pergunta, $numero_pergunta = null, $tipo_pergunta = '1', $status_pergunta = '1') {
            $this->id_setor = $id_setor;
            $this->texto_pergunta = $texto_pergunta;
            $this->numero_pergunta = $numero_pergunta;
            $this->tipo_pergunta = $tipo_pergunta;
            $this->status_pergunta = $status_pergunta;
        }

        /* =================== HELPERS PRIVADOS =================== */

        // Retorna último número usado (maior número) entre perguntas ativas do setor
        private static function getUltimoNumero(PDO $conn, $id_setor) {
            $q = $conn->prepare("SELECT COALESCE(MAX(numero_pergunta), 0) FROM pergunta WHERE id_setor = :setor AND status_pergunta = '1'");
            $q->execute([':setor' => $id_setor]);
            return (int)$q->fetchColumn();
        }

        // Retorna número da pergunta-texto ativa (se existir), senão null
        private static function getNumeroTexto(PDO $conn, $id_setor) {
            $q = $conn->prepare("SELECT numero_pergunta FROM pergunta WHERE id_setor = :setor AND tipo_pergunta = '0' AND status_pergunta = '1' LIMIT 1");
            $q->execute([':setor' => $id_setor]);
            $v = $q->fetchColumn();
            return $v === false ? null : (int)$v;
        }

        // Retorna true se já existe pergunta texto ativa (opcionalmente exclui um id)
        private static function existeTextoAtivo(PDO $conn, $id_setor, $excluirId = null) {
            if ($excluirId) {
                $q = $conn->prepare("SELECT COUNT(*) FROM pergunta WHERE id_setor = :setor AND tipo_pergunta = '0' AND status_pergunta = '1' AND id_pergunta <> :id");
                $q->execute([':setor' => $id_setor, ':id' => $excluirId]);
            } else {
                $q = $conn->prepare("SELECT COUNT(*) FROM pergunta WHERE id_setor = :setor AND tipo_pergunta = '0' AND status_pergunta = '1'");
                $q->execute([':setor' => $id_setor]);
            }
            return $q->fetchColumn() > 0;
        }

        // Move range de números: incrementa ou decrementa por faixa.
        // direction = +1 para empurrar para cima (incrementar), -1 para puxar para baixo (decrementar)
        private static function moverRange(PDO $conn, $id_setor, $minInclusive, $maxExclusive, $direction) {
            if ($direction === 1) {
                $sql = "UPDATE pergunta SET numero_pergunta = numero_pergunta + 1
                        WHERE id_setor = :setor
                        AND numero_pergunta >= :min
                        AND numero_pergunta < :max
                        AND status_pergunta = '1'";
            } else {
                // -1
                $sql = "UPDATE pergunta SET numero_pergunta = numero_pergunta - 1
                        WHERE id_setor = :setor
                        AND numero_pergunta >= :min
                        AND numero_pergunta < :max
                        AND status_pergunta = '1'";
            }
            $stmt = $conn->prepare($sql);
            return $stmt->execute([':setor' => $id_setor, ':min' => $minInclusive, ':max' => $maxExclusive]);
        }

        // Compacta numeracao ativa do setor (1..N sem gaps) - útil para sanidade
        private static function compactarNumeracao(PDO $conn, $id_setor) {
            // Obter IDs ordenados por numero_pergunta
            $q = $conn->prepare("SELECT id_pergunta FROM pergunta WHERE id_setor = :setor AND status_pergunta = '1' ORDER BY numero_pergunta");
            $q->execute([':setor' => $id_setor]);
            $rows = $q->fetchAll(PDO::FETCH_COLUMN);

            $num = 1;
            $upd = $conn->prepare("UPDATE pergunta SET numero_pergunta = :num WHERE id_pergunta = :id");
            foreach ($rows as $id) {
                $upd->execute([':num' => $num, ':id' => $id]);
                $num++;
            }
            return true;
        }

        /* =================== CRUD / REGRAS =================== */

        // SALVAR nova pergunta
        public function save(PDO $conn) {
            // Se for pergunta de texto (tipo = '0') -> sempre vai para final e deve ser única
            if ($this->tipo_pergunta === '0') {
                if (self::existeTextoAtivo($conn, $this->id_setor)) {
                    return "erro_tipo";
                }
                $ultimo = self::getUltimoNumero($conn, $this->id_setor);
                $this->numero_pergunta = $ultimo + 1; // texto sempre última
            } else {
                // valida numero
                if ($this->numero_pergunta === null || !is_numeric($this->numero_pergunta) || $this->numero_pergunta <= 0) {
                    return "erro_numero";
                }

                // Se existe pergunta-texto ativa, não permita número >= posição do texto
                $numTexto = self::getNumeroTexto($conn, $this->id_setor);
                if ($numTexto !== null && $this->numero_pergunta >= $numTexto) {
                    // ajusta para ficar antes da pergunta-texto
                    $this->numero_pergunta = $numTexto;
                }

                // Empurrar as perguntas a partir da posição escolhida (incl.)
                $ultimo = self::getUltimoNumero($conn, $this->id_setor);
                // moverRange com maxExclusive = ultimo+1
                self::moverRange($conn, $this->id_setor, $this->numero_pergunta, $ultimo + 1, 1);
            }

            // Inserir
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

            if ($ok) return $conn->lastInsertId();
            return false;
        }

        // LISTAR perguntas ativas (usado pelo tablet)
        public static function getAtivasSetor(PDO $conn, $id_setor) {
            $sql = "SELECT * FROM pergunta 
                    WHERE status_pergunta = '1' 
                    AND id_setor = :setor
                    ORDER BY numero_pergunta";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':setor' => $id_setor]);
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $perguntas = [];
            foreach ($dados as $p) {
                $obj = new self(
                    $p['id_setor'],
                    $p['texto_pergunta'],
                    $p['numero_pergunta'],
                    $p['tipo_pergunta'],
                    $p['status_pergunta']
                );
                $obj->id_pergunta = $p['id_pergunta'];
                $perguntas[] = $obj;
            }
            return $perguntas;
        }

        // LISTAR todas por setor (admin)
        public static function listarPorSetor(PDO $conn, $id_setor) {
            $sql = "SELECT * FROM pergunta WHERE id_setor = :setor ORDER BY numero_pergunta";
            $stm = $conn->prepare($sql);
            $stm->execute([':setor' => $id_setor]);
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }

        // EDITAR pergunta
        public static function editar(PDO $conn, $id, $texto, $numero, $tipo, $id_setor) {

            // Buscar dados atuais
            $old_q = $conn->prepare("SELECT numero_pergunta, tipo_pergunta, status_pergunta 
                                    FROM pergunta WHERE id_pergunta = :id");
            $old_q->execute([':id' => $id]);
            $old = $old_q->fetch(PDO::FETCH_ASSOC);

            if (!$old) return false;

            $old_num   = (int)$old['numero_pergunta'];
            $old_tipo  = (int)$old['tipo_pergunta'];
            $old_stat  = (int)$old['status_pergunta'];

            // ⚠️ SE A PERGUNTA ESTÁ INATIVA → NÃO REORDENA NADA
            if ($old_stat === 0) {

                // Se for mudar para TEXTO, verificar se já existe outra ativa
                if ($tipo == '0') {
                    if (self::existeTextoAtivo($conn, $id_setor, $id)) {
                        return "erro_tipo";
                    }
                }

                // Atualiza apenas o registro — sem mexer em outras perguntas
                $upd = $conn->prepare("
                    UPDATE pergunta
                    SET texto_pergunta = :texto,
                        numero_pergunta = :numero,
                        tipo_pergunta = :tipo
                    WHERE id_pergunta = :id
                ");
                return $upd->execute([
                    ':texto' => $texto,
                    ':numero' => $numero,
                    ':tipo' => $tipo,
                    ':id' => $id
                ]);
            }

            // ---------------- RELAÇÕES PARA PERGUNTAS ATIVAS ---------------- //

            $ultimo = self::getUltimoNumero($conn, $id_setor);
            $numTexto = self::getNumeroTexto($conn, $id_setor);

            // 1) Se mudar para tipo TEXTO
            if ($tipo == '0') {

                // já existe outra?
                if ($old_tipo != 0 && self::existeTextoAtivo($conn, $id_setor, $id)) {
                    return "erro_tipo";
                }

                // se já era texto e já está no final → só atualizar texto
                if ($old_tipo == 0 && $old_num == $numTexto) {
                    $upd = $conn->prepare("UPDATE pergunta SET texto_pergunta = :texto WHERE id_pergunta = :id");
                    return $upd->execute([':texto' => $texto, ':id' => $id]);
                }

                // empurrar para cima todas depois da antiga posição
                $conn->prepare("
                    UPDATE pergunta 
                    SET numero_pergunta = numero_pergunta - 1
                    WHERE id_setor = :setor AND numero_pergunta > :oldnum AND status_pergunta = '1'
                ")->execute([':setor' => $id_setor, ':oldnum' => $old_num]);

                // mover esta para o fim
                $novoNum = self::getUltimoNumero($conn, $id_setor) + 1;

                $upd = $conn->prepare("
                    UPDATE pergunta 
                    SET texto_pergunta = :texto, numero_pergunta = :num, tipo_pergunta = '0'
                    WHERE id_pergunta = :id
                ");
                return $upd->execute([':texto' => $texto, ':num' => $novoNum, ':id' => $id]);
            }

            // 2) Se NÃO é texto → validar numero
            if (!is_numeric($numero) || $numero <= 0) {
                return "erro_numero";
            }

            // Não pode ultrapassar pergunta-texto ativa
            if ($numTexto !== null && $numero >= $numTexto) {
                $numero = $numTexto - 1;
            }

            // REORDENAÇÃO
            if ($numero != $old_num) {
                if ($numero < $old_num) {
                    // move para cima
                    self::moverRange($conn, $id_setor, $numero, $old_num, 1);
                } else {
                    // move para baixo
                    self::moverRange($conn, $id_setor, $old_num + 1, $numero + 1, -1);
                }
            }

            // Atualiza final
            $upd = $conn->prepare("
                UPDATE pergunta
                SET texto_pergunta = :texto,
                    numero_pergunta = :numero,
                    tipo_pergunta = :tipo
                WHERE id_pergunta = :id
            ");
            return $upd->execute([
                ':texto' => $texto,
                ':numero' => $numero,
                ':tipo' => $tipo,
                ':id' => $id
            ]);
        }


        // DESATIVAR (mantém numero_pergunta para podermos restaurar depois)
        public static function desativar(PDO $conn, $id) {
            // pegar setor e ordem
            $q = $conn->prepare("SELECT id_setor, numero_pergunta FROM pergunta WHERE id_pergunta = :id");
            $q->execute([':id' => $id]);
            $row = $q->fetch(PDO::FETCH_ASSOC);
            if (!$row) return false;

            $setor = $row['id_setor'];
            $num = (int)$row['numero_pergunta'];

            // Puxar as outras para cima
            $conn->prepare("
                UPDATE pergunta
                SET numero_pergunta = numero_pergunta - 1
                WHERE id_setor = :setor
                AND numero_pergunta > :num
                AND status_pergunta = '1'
            ")->execute([':setor' => $setor, ':num' => $num]);

            // marcar como inativa (mantemos o numero_pergunta no registro para restauração futura)
            return $conn->prepare("UPDATE pergunta SET status_pergunta = '0' WHERE id_pergunta = :id")->execute([':id' => $id]);
        }

        // ALTERAR STATUS (0 = desativar, 1 = ativar) — comportamento B: tenta restaurar posição anterior
        public static function alterarStatus(PDO $conn, $id, $status) {
            if ($status == 0) {
                // delega ao desativar para manter lógica de reordenação
                return self::desativar($conn, $id);
            }

            // Ativar: restaurar a posição antiga (se possível), respeitando a pergunta-texto
            // Pegar registro (id, setor, numero_pergunta, tipo_pergunta)
            $q = $conn->prepare("SELECT id_setor, numero_pergunta, tipo_pergunta FROM pergunta WHERE id_pergunta = :id");
            $q->execute([':id' => $id]);
            $row = $q->fetch(PDO::FETCH_ASSOC);
            if (!$row) return false;

            $setor = $row['id_setor'];
            $desired = $row['numero_pergunta'] !== null ? (int)$row['numero_pergunta'] : null;
            $tipo = (int)$row['tipo_pergunta'];

            // Se é pergunta-texto -> precisa garantir que não exista outra pergunta-texto ativa
            if ($tipo === 0) {
                if (self::existeTextoAtivo($conn, $setor, $id)) {
                    return "erro_tipo";
                }
                // texto sempre fica no final
                $pos = self::getUltimoNumero($conn, $setor) + 1;
                $upd = $conn->prepare("UPDATE pergunta SET status_pergunta = '1', numero_pergunta = :num WHERE id_pergunta = :id");
                return $upd->execute([':num' => $pos, ':id' => $id]);
            }

            // Não é texto: tentar restaurar desired, se inválido, coloca no final
            $ultimo = self::getUltimoNumero($conn, $setor);

            // posição da pergunta-texto (se houver) - não pode ultrapassar
            $numTexto = self::getNumeroTexto($conn, $setor);

            // Se desired não definido ou <=0, definimos final (antes do texto)
            if ($desired === null || $desired <= 0) {
                $pos = ($numTexto !== null) ? $numTexto - 1 : $ultimo + 1;
            } else {
                // Se desired > ultimo+1 (por alguma razão), ajustar para final
                $maxPos = ($numTexto !== null) ? $numTexto - 1 : $ultimo + 1;
                if ($desired > $maxPos) $desired = $maxPos;

                // Se já existe uma pergunta ativa com esse número, empurrar (inserir)
                // Shift [desired, ultimo] +1
                self::moverRange($conn, $setor, $desired, $ultimo + 1, 1);
                $pos = $desired;
            }

            // Ativa e define numero_pergunta
            $upd = $conn->prepare("UPDATE pergunta SET status_pergunta = '1', numero_pergunta = :num WHERE id_pergunta = :id");
            $ok = $upd->execute([':num' => $pos, ':id' => $id]);

            // Sanidade: compactar (opcional, para evitar gaps/inconsistências)
            if ($ok) self::compactarNumeracao($conn, $setor);

            return $ok;
        }

        // GETTERS / SETTERS mínimos
        public function getId() { return $this->id_pergunta; }
        public function getNumero() { return $this->numero_pergunta; }
        public function setNumero($num) { $this->numero_pergunta = $num; }
        public function getTexto() { return $this->texto_pergunta; }
        public function setTexto($txt) { $this->texto_pergunta = $txt; }
        public function getTipo() { return $this->tipo_pergunta; }
        public function setTipo($tipo) { $this->tipo_pergunta = $tipo; }
        public function getStatus() { return $this->status_pergunta; }
        public function ativar_pergunta () { $this->status_pergunta = '1'; }
        public function desativar_pergunta () { $this->status_pergunta = '0'; }
    }
?>
