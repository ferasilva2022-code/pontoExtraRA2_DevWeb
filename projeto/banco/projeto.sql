-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS projeto
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
-- Selecionar o banco
USE projeto;
-- Criar a tabela cliente
CREATE TABLE IF NOT EXISTS cliente (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100) NOT NULL,
email VARCHAR(150) NOT NULL,
usuario VARCHAR(50) NOT NULL UNIQUE,
senha VARCHAR(255) NOT NULL,
instagram VARCHAR(100),
ativo TINYINT(1) DEFAULT 1
);

-- Inserir um cliente de teste (para o login funcionar)
INSERT INTO cliente (nome, email, usuario, senha, instagram, ativo)
VALUES ('Admin', 'admin@email.com', 'admin', '1234', '@admin', 1);

CREATE TABLE IF NOT EXISTS usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  ativo TINYINT(1) DEFAULT 1
);

 

CREATE TABLE IF NOT EXISTS produto (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  preco DECIMAL(10,2) NOT NULL,
  estoque INT NOT NULL DEFAULT 0,
  ativo TINYINT(1) DEFAULT 1
);

 

CREATE TABLE IF NOT EXISTS venda (
  id INT AUTO_INCREMENT PRIMARY KEY,
  produto_id INT NOT NULL,
  usuario_id INT NOT NULL,
  quantidade INT NOT NULL,
  valor_total DECIMAL(10,2) NOT NULL,
  data_venda DATETIME DEFAULT CURRENT_TIMESTAMP

);

 
INSERT INTO usuario (nome, usuario, senha) 
VALUES ('Admin', 'admin', '1234');
INSERT INTO produto (nome, preco, estoque) 
VALUES
  ('Caneta azul', 2.50, 100),
  ('Caderno 96 folhas', 18.90, 40),
  ('Mochila escolar', 129.00, 0);