<?php
    class UsuarioTablet {
        private $senha;

        public function __construct($senha) {
            $this->senha = $senha;
        }

        public function valida(PDO $conn) {

            $sql = "SELECT * 
                    FROM usuario_tablet
                    WHERE senha = :senha
                    LIMIT 1";

            $stmt = $conn->prepare($sql);
            $stmt->execute([':senha' => $this->senha]);

            return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
        }
    }
?>