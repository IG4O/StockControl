
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) DEFAULT 'vendedor'
);

CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL,
    valor_unitario NUMERIC(10,2) NOT NULL,
    atualizado_por INT REFERENCES usuarios(id),
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE vendas (
    id SERIAL PRIMARY KEY,
    produto_id INT REFERENCES produtos(id),
    quantidade INT NOT NULL,
    valor_total NUMERIC(10,2) NOT NULL,
    usuario_id INT REFERENCES usuarios(id),
    data_venda TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE logs (
    id SERIAL PRIMARY KEY,
    usuario_id INT REFERENCES usuarios(id),
    acao VARCHAR(255),
    data_log TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);