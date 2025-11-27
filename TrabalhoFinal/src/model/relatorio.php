<?php
    class Relatorio {

        public static function totalHoje($conn){
            $sql = "SELECT COUNT(*) FROM avaliacao WHERE data_hora::date = CURRENT_DATE";
            return self::fetchValue($conn, $sql);
        }

        public static function totalMes($conn){
            $sql = "SELECT COUNT(*) FROM avaliacao WHERE date_trunc('month', data_hora) = date_trunc('month', CURRENT_DATE)";
            return self::fetchValue($conn, $sql);
        }

        public static function dispositivosAtivos($conn){
            $sql = "SELECT COUNT(*) FROM dispositivo WHERE status_dispositivo = '1'";
            return self::fetchValue($conn, $sql);
        }

        public static function perguntasAtivas($conn){
            $sql = "SELECT COUNT(*) FROM pergunta WHERE status_pergunta = '1'";
            return self::fetchValue($conn, $sql);
        }

        public static function mediaGeral($conn){
            $sql = "
                SELECT ROUND(AVG(r.nota)::numeric, 2)
                FROM resposta r
                JOIN avaliacao a ON r.id_avaliacao = a.id_avaliacao
            ";
            return self::fetchValue($conn, $sql);
        }

        public static function mediasPorSetor($conn){
            $sql = "
                SELECT s.nome_setor, ROUND(AVG(r.nota)::numeric,2) as media
                FROM resposta r
                JOIN avaliacao a ON r.id_avaliacao = a.id_avaliacao
                JOIN dispositivo d ON a.id_dispositivo = d.id_dispositivo
                JOIN setor s ON d.id_setor = s.id_setor
                GROUP BY s.id_setor, s.nome_setor
                ORDER BY media DESC
            ";
            return self::fetchAll($conn, $sql);
        }

        public static function ultimosFeedbacks($conn){
            $sql = "
                SELECT a.feedback_texto, a.data_hora, d.nome_dispositivo
                FROM avaliacao a
                JOIN dispositivo d ON a.id_dispositivo = d.id_dispositivo
                WHERE a.feedback_texto IS NOT NULL AND trim(a.feedback_texto) <> ''
                ORDER BY a.data_hora DESC
                LIMIT 6
            ";
            return self::fetchAll($conn, $sql);
        }

        public static function distNotas30dias($conn){
            $sql = "
                SELECT r.nota, COUNT(*) AS cnt
                FROM resposta r
                JOIN avaliacao a ON r.id_avaliacao = a.id_avaliacao
                WHERE a.data_hora >= (CURRENT_DATE - INTERVAL '30 days')
                GROUP BY r.nota
                ORDER BY r.nota
            ";
            return self::fetchPairs($conn, $sql);
        }

        public static function ult7dias($conn){
            $sql = "
                SELECT to_char(date_trunc('day', data_hora), 'YYYY-MM-DD') as dia, COUNT(*) AS cnt
                FROM avaliacao
                WHERE data_hora >= (CURRENT_DATE - INTERVAL '6 days')
                GROUP BY dia
                ORDER BY dia
            ";
            return self::fetchPairs($conn, $sql);
        }

        public static function porDispositivo($conn){
            $sql = "
                SELECT d.nome_dispositivo, COUNT(*) as cnt
                FROM avaliacao a
                JOIN dispositivo d ON a.id_dispositivo = d.id_dispositivo
                GROUP BY d.nome_dispositivo
                ORDER BY cnt DESC
                LIMIT 10
            ";
            return self::fetchAll($conn, $sql);
        }

        // Helpers
        private static function fetchValue($conn, $sql){
            return (float) $conn->query($sql)->fetchColumn();
        }
        private static function fetchAll($conn, $sql){
            return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }
        private static function fetchPairs($conn, $sql){
            return $conn->query($sql)->fetchAll(PDO::FETCH_KEY_PAIR);
        }
    }
?>