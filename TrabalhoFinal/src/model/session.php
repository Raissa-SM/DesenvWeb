<?php

    class Session {
        private $sessionId;
        private $status;
        private $usuario;
        private $dataHoraInicio;
        private $dataHoraUltimoAcesso;

        public function iniciaSessao() {
            try {
                session_start();
                $this->sessionId = session_id();
                if($this->getDadoSessao('datahorainicio')) {
                    //Sessão já iniciada
                    //1 - Carrega data hora de início
                    $this->dataHoraInicio = $this->getDadoSessao('datahorainicio');
                    //2 - Carrega data hora de último acesso
                    $this->dataHoraUltimoAcesso = date("Y-m-d H:i:s");
                    $this->setDadoSessao('datahoraultimoacesso', $this->dataHoraUltimoAcesso);
                    
                    //3 - Carrega usuário da sessão
                    $this->usuario = $this->getDadoSessao('usuario'); 
                } else {
                    //Nova sessão
                    $this->dataHoraInicio = date("Y-m-d H:i:s");
                    $this->setDadoSessao('datahorainicio', $this->dataHoraInicio);
                }
                return true;
            } catch(Exception $e) {
                return false;
            }
        }
        public function finalizaSessao() {
            session_destroy();  
        }
        public function getUsuarioSessao() {
            return $this->usuario;
        }
        public function setUsuarioSessao($usuario) {
            $this->usuario = $usuario;
            $this->setDadoSessao('usuario', $usuario->getUserName());
        }
        public function getDadoSessao($chave) {
            if(isset($_SESSION[$chave])) {
                return $_SESSION[$chave];
            } else {
                return null;
            }
        }
        public function setDadoSessao($chave, $valor) {
            $_SESSION[$chave] = $valor;
        }

    }

?>