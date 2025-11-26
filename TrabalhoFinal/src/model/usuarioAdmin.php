<?php
    class UsuarioAdmin {
        private $login;
        private $senha;
        private $nome;

        public function __construct($login, $senha) {
            $this->login = $login;
            $this->senha = $senha;
        }

        public function valida(PDO $conn) {

            $sql = "SELECT * 
                    FROM usuario_admin 
                    WHERE login = :login AND senha = :senha
                    LIMIT 1";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':login' => $this->login,
                ':senha' => $this->senha
            ]);

            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dados) {
                $this->nome = $dados['login']; 
                return true;
            }
            return false;
        }

        public function getNome() {
            return $this->nome;
        }
    }
?>
