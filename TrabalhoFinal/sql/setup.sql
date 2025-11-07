
-- Script para BANCO DE DADOS - PostgreSQL

-- TABELA DE SETORES
CREATE TABLE setor (
    id_setor SERIAL PRIMARY KEY,
    nome_setor VARCHAR(100) NOT NULL,
    status_setor CHAR(1) DEFAULT '1' CHECK (status_setor IN ('0', '1')) -- '1' ATIVA / '0' INATIVA
);

-- TABELA DE DISPOSITIVOS
CREATE TABLE dispositivo (
    id_dispositivo SERIAL PRIMARY KEY,
    nome_dispositivo VARCHAR(100) NOT NULL,
    status_dispositivo CHAR(1) DEFAULT '1' CHECK (status_dispositivo IN ('0', '1')) -- '1' ATIVO / '0' INATIVO
);

-- TABELA DE PERGUNTAS
CREATE TABLE pergunta (
    id_pergunta SERIAL PRIMARY KEY,
    texto_pergunta TEXT NOT NULL,
    numero_pergunta INT NOT NULL, -- ordem das perguntas
    tipo_pergunta CHAR(1) DEFAULT '1' CHECK (tipo_pergunta IN ('0', '1')), 
    -- '1' NOTA (0 a 10) / '0' TEXTO 
    status_pergunta CHAR(1) DEFAULT '1' CHECK (status_pergunta IN ('0', '1')) -- '1' ATIVA / '0' INATIVA
);

-- TABELA DE AVALIAÇÕES
CREATE TABLE avaliacao (
    id_avaliacao SERIAL PRIMARY KEY,
    id_setor INT REFERENCES setor(id_setor),
    id_dispositivo INT REFERENCES dispositivo(id_dispositivo),
    feedback_texto TEXT,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

-- TABELA DE RESPOSTAS
CREATE TABLE resposta (
    id_resposta SERIAL PRIMARY KEY,
    id_avaliacao INT REFERENCES avaliacao(id_avaliacao) ON DELETE CASCADE,
    id_pergunta INT REFERENCES pergunta(id_pergunta),
    nota SMALLINT NOT NULL CHECK (nota BETWEEN 0 AND 10)
);

-- TABELA DE USUÁRIOS ADMINISTRATIVOS
CREATE TABLE usuario_admin (
    id_usuario SERIAL PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Garantir que cada resposta seja de uma pergunta diferente
ALTER TABLE resposta
ADD CONSTRAINT unica_pergunta_por_avaliacao
UNIQUE (id_avaliacao, id_pergunta);


--------------------------------------------
------------ INSERTS PARA TESTE ------------
--------------------------------------------

INSERT INTO setor (nome_setor, status_setor)
VALUES 
('Recepção', '1'),
('Vendas', '1'),
('Caixa', '1'),
('Estacionamento', '1'),
('Limpeza', '1');

INSERT INTO dispositivo (nome_dispositivo, status_dispositivo)
VALUES
('Tablet Recepção', '1'),
('Tablet Vendas', '1'),
('Tablet Caixa', '1'),
('Tablet Estacionamento', '1');

INSERT INTO pergunta (texto_pergunta, numero_pergunta)
VALUES
('Como você avalia o atendimento do setor?', 1),
('A infraestrutura do local está adequada?', 2),
('Os funcionários foram atenciosos e educados?', 3),
('O tempo de espera foi satisfatório?', 4);

INSERT INTO pergunta (texto_pergunta, numero_pergunta, tipo_pergunta)
VALUES
('Deixe um comentário adicional (opcional):', 5, '0');

INSERT INTO usuario_admin (login, senha)
VALUES 
('admin', '1234');
