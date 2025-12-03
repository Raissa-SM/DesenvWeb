# Sistema de Avaliação de Qualidade – Trabalho Final Programação Web

Este projeto foi desenvolvido como Trabalho Final da disciplina **Programação Web**, seguindo os requisitos fornecidos pelo professor.  
O sistema permite que clientes avaliem setores de um estabelecimento de forma **rápida**, **anônima** e **intuitiva** através de um tablet.  
Também inclui um **Painel Administrativo** completo para gestão e visualização das avaliações.

---

## 📌 Funcionalidades Principais

### 📱 Interface do Tablet (Frontend Público)
- Formulário de avaliação dinâmico.
- Perguntas carregadas automaticamente do banco.
- Escala de notas (0 a 10).
- Pergunta opcional de texto para feedback.
- Garantia de **anonimato** ao usuário.
- Tela de agradecimento após envio.

### 🛠️ Painel Administrativo
- Autenticação de administrador.
- Gestão de:
  - Setores
  - Dispositivos
  - Perguntas
- Dashboards com:
  - Total de avaliações
  - Distribuição de notas
  - Avaliações por dispositivo
  - Média por setor
  - Últimos feedbacks
- Relatórios filtráveis (por data, setor e dispositivo).
- Exportação para PDF e Excel.

---

## 🧱 Tecnologias Utilizadas

### Frontend
- HTML5  
- CSS3 (styleTablet.css e styleAdmin.css)  
- JavaScript

### Backend
- PHP 8+  
- PostgreSQL  
- Arquitetura organizada em controllers e models  
- Requisições AJAX para operações do painel admin

---

## 📂 Estrutura de Pastas

```
TrabalhoFinal/
│
├── public/
│ ├── admin/ # Painel administrativo
│ ├── css/ # CSS (tablet + admin)
│ ├── imagens/ # Ícones e recursos visuais
│ ├── js/ # Scripts JS (tablet + admin + chart)
│ └── tablet/ # Formulário de avaliação
│
├── sql/
│ ├── controsetup.sql # Script de criação de banco de dados com inserts de teste
│
├── src/
│ ├── controller/ # Lógica principal do sistema
│ ├── lib/ # Arquivos do FPDF
│ ├── model/ # Classes
│ ├── auth.php/ # Autenticação de usuário
│ └── db.php # Conexão com PostgreSQL
│
├── config.php # Credenciais para banco de dados
└── README.md
```

---

## ▶️ Como Executar o Projeto

### 1. Requisitos
- XAMPP (ou outro servidor PHP)  
- PostgreSQL instalado  
- Extensão `pdo_pgsql` habilitada no PHP  

---

### 2. Instalação e Configuração

1. Coloque o projeto dentro da pasta:

C:\xampp\htdocs\DesenvWeb\TrabalhoFinal


2. Configure o arquivo:

/src/db.php

Ajuste:
- host  
- nome do banco  
- usuário  
- senha  

3. Importe as tabelas do banco conforme o script do projeto.

4. Inicie o Apache e o PostgreSQL.

---

## 3. Acesso ao Sistema

### Interface (Tablet)

http://localhost/DesenvWeb/TrabalhoFinal/public/index.php

### Painel Administrativo

http://localhost/DesenvWeb/TrabalhoFinal/public/admin/login.php


Use o usuário/senha configurados no banco.

---

## 👤 Raíssa Sofka Mazzi
Projeto desenvolvido como Trabalho Final da disciplina **Programação Web** – Curso de Sistemas de Informação.

---
