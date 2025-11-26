CREATE DATABASE Sports;

USE Sports;

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL
);

CREATE TABLE mesas (
    id INT PRIMARY KEY
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mesa_id INT,
    produto_id INT,
    quantidade INT,
    FOREIGN KEY (mesa_id) REFERENCES mesas(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- Inserindo mesas
INSERT INTO mesas (id) VALUES (1), (2), (3), (4), (5), (6), (7), (8), (9), (10), (11), (12), (13), (14), (15), (16), (17), (18), (19), (20);

-- Inserindo produtos
INSERT INTO produtos (nome, preco) VALUES
('Hambúrguer', 10.00),
('X-Salada', 15.00),
('X-Egg', 17.00),
('X-Bacon', 18.00),
('X-Frango', 20.00),
('X-Tudo', 25.00),
('X-Tudo Duplo', 25.00),
('X-Contra-Filé', 30.00),
('Pizza de Calabresa', 50.00),
('Pizza de Frango com Catupiry', 50.00),
('Pizza de Presunto e Muçarela', 50.00),
('Pizza de Quatro Queijos', 50.00),
('Coca-Cola 350 ml', 6.00),
('Fanta Laranja 350 ml', 5.00),
('Fanta Uva 350 ml', 5.00),
('Sprite 350 ml', 5.00),
('Guaraná Antactica 350 ml', 5.00),
('Coca-Cola 1 litro', 10.00),
('Coca-Cola 2 litros', 15.00),
('Suco de Laranja 500 ml', 10.00),
('Suco de Uva 500 ml', 12.00),
('Suco de Maracujá 500 ml', 15.00),
('Cerveja Heineken Long Neck', 10.00),
('Cerveja Corona Long Neck', 8.00),
('Cerveja Budweiser Long Neck', 9.00),
('Porção de Batata Frita', 15.00),
('Porção de Frango à Passarinho', 25.00),
('Porção de Calabresa', 30.00),
('Porção de Contra-Filé', 40.00),
('Combo Família', 80.00),
('Dogão no Prato', 35.00),
('Combo Casal', 45.00),
('Combo Kids', 35.00),
('Combo Bacon', 55.00);
