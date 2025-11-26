
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
    id_setor INT REFERENCES setor(id_setor),
    nome_dispositivo VARCHAR(100) NOT NULL,
    status_dispositivo CHAR(1) DEFAULT '1' CHECK (status_dispositivo IN ('0', '1')) -- '1' ATIVO / '0' INATIVO
);

-- TABELA DE PERGUNTAS
CREATE TABLE pergunta (
    id_pergunta SERIAL PRIMARY KEY,
    id_setor INT REFERENCES setor(id_setor),
    texto_pergunta TEXT NOT NULL,
    numero_pergunta INT NOT NULL, -- ordem das perguntas
    tipo_pergunta CHAR(1) DEFAULT '1' CHECK (tipo_pergunta IN ('0', '1')), 
    -- '1' NOTA (0 a 10) / '0' TEXTO 
    status_pergunta CHAR(1) DEFAULT '1' CHECK (status_pergunta IN ('0', '1')) -- '1' ATIVA / '0' INATIVA
);

-- TABELA DE AVALIAÇÕES
CREATE TABLE avaliacao (
    id_avaliacao SERIAL PRIMARY KEY,
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

-- TABELA DE USUÁRIOS TABLETS (somente senha)
CREATE TABLE usuario_tablet (
    id_usuario SERIAL PRIMARY KEY,
    senha VARCHAR(255) NOT NULL
);

-- Garantir que cada resposta seja de uma pergunta diferente
ALTER TABLE resposta
ADD CONSTRAINT unica_pergunta_por_avaliacao
UNIQUE (id_avaliacao, id_pergunta);


--------------------------------------------
------------ INSERTS PARA TESTE ------------
--------------------------------------------

INSERT INTO setor (nome_setor)
VALUES 
('Recepção'),
('Vendas'),
('Caixa'),
('Estacionamento'),
('Limpeza');

INSERT INTO dispositivo (nome_dispositivo, id_setor)
VALUES
('Tablet Recepção 01', '1'),
('Tablet Recepção 02', '1'),
('Tablet Vendas 01', '2'),
('Tablet Caixa 01', '3'),
('Tablet Estacionamento 01', '4'),
('Tablet Limpeza 01', '5');

INSERT INTO pergunta (texto_pergunta, numero_pergunta, id_setor)
VALUES
-- PERGUNTAS DA RECEPÇÃO
('Como você avalia o atendimento na recepção?', 1, 1),
('A infraestrutura da recepção está adequada?', 2, 1),
('Os funcionários foram atenciosos e educados?', 3, 1),
('O tempo de espera foi satisfatório?', 4, 1),
-- PERGUNTAS DO VENDAS
('Como você avalia o atendimento na venda?', 1, 2),
('A infraestrutura do local está adequada?', 2, 2),
('Os funcionários foram atenciosos e educados?', 3, 2),
('O tempo de espera foi satisfatório?', 4, 2),
-- PERGUNTAS DO CAIXA
('Como você avalia o atendimento no caixa?', 1, 3),
('A infraestrutura do caixa está adequada?', 2, 3),
('Os funcionários foram atenciosos e educados?', 3, 3),
('O tempo de espera foi satisfatório?', 4, 3),
-- PERGUNTAS DO ESTACIONAMENTO
('Como você avalia o atendimento do setor?', 1, 4),
('A infraestrutura do local está adequada?', 2, 4),
('Os funcionários foram atenciosos e educados?', 3, 4),
('O tempo de espera foi satisfatório?', 4, 4),
-- PERGUNTAS DA LIMPEZA
('Como você avalia o atendimento do setor?', 1, 5),
('A infraestrutura do local está adequada?', 2, 5),
('Os funcionários foram atenciosos e educados?', 3, 5),
('O tempo de espera foi satisfatório?', 4, 5);

INSERT INTO pergunta (texto_pergunta, numero_pergunta, tipo_pergunta, id_setor)
VALUES
('Deixe um comentário adicional sobre a recepção (opcional):', 5, '0', 1),
('Deixe um comentário adicional sobre o vendas (opcional):', 5, '0', 2),
('Deixe um comentário adicional sobre o caixa (opcional):', 5, '0', 3),
('Deixe um comentário adicional sobre o estacionamento (opcional):', 5, '0', 4),
('Deixe um comentário adicional sobre a limpeza (opcional):', 5, '0', 5);

INSERT INTO usuario_admin (login, senha)
VALUES 
('admin', '1234');

INSERT INTO usuario_tablet (senha)
VALUES 
('1234');