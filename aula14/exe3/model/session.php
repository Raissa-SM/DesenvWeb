<?php
    require_once "usuario.php";

    class Session {
        private $sessionId;
        private $status;
        private $usuario;
        private $dataHoraInicio;
        private $dataHoraUltimoAcesso;

        public function iniciaSessao() {
            session_start();
            $this -> sessionId = session_id();
            if ($this -> getDadoSessao('datahorainicio')) {
                $this -> dataHoraUltimoAcesso = new DateTime(date("Y-m-d H:i:s"));
                $this -> setDadoSessao('datahoraultimoacesso', $this -> dataHoraUltimoAcesso);
            }
            else {
                $this -> dataHoraInicio = new DateTime(date("Y-m-d H:i:s"));
                $this -> setDadoSessao('datahorainicio', $this -> dataHoraInicio);
            }
        }
        public function finalizaSessao() {
            session_destroy();
        }

        //GETTERS E SETTERS
        public function getUsuario($chave) {
            if (isset($_SESSION[$chave])) {
                
            }
        }

        public function setUsuario($nome) {
            $this -> nome = $nome;
        }
    }
?>