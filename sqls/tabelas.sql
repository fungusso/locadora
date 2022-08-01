CREATE TABLE categorias (
	cod INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nome VARCHAR(30) NOT NULL,
	UNIQUE (nome)
);

CREATE TABLE filmes (
	cod INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nome VARCHAR(45) NOT NULL,
	qtd INT NOT NULL DEFAULT 0,
	categoria1 INT,
	categoria2 INT,
	categoria3 INT,
	status CHAR(1) NOT NULL DEFAULT 'A',
	CONSTRAINT fk_filmes_categoria1_categorias_cod
	FOREIGN KEY(categoria1) REFERENCES categorias(cod),
	CONSTRAINT fk_filmes_categoria2_categorias_cod
	FOREIGN KEY(categoria2) REFERENCES categorias(cod),
	CONSTRAINT fk_filmes_categoria3_categorias_cod
	FOREIGN KEY(categoria3) REFERENCES categorias(cod)
);

CREATE TABLE clientes (
	cpf VARCHAR(14) NOT NULL PRIMARY KEY,
	nome VARCHAR(30) NOT NULL,
	data_nascimento DATE,
	endereco VARCHAR(100),
	telefone varchar(10)
);

CREATE TABLE locacoes (
	cod INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	cpf_cliente VARCHAR(14) NOT NULL,
	data_locacao TIMESTAMP NOT NULL,
	data_entrega_prevista DATE NOT NULL,
	data_entrega TIMESTAMP,
	qtd_filmes INT NOT NULL DEFAULT 1,
	valor DEC(10,2),
	CONSTRAINT fk_locacoes_cpf_cliente_clientes_cpf
	FOREIGN KEY(cpf_cliente) REFERENCES clientes(cpf)
);

CREATE TABLE filme_locado (
	cod_locacao INT NOT NULL,
	cod_filme INT NOT NULL,
	CONSTRAINT fk_filme_locado_cod_locacao_locacoes_cod
	FOREIGN KEY(cod_locacao) REFERENCES locacoes(cod),
	CONSTRAINT fk_filme_locado_cod_locacao_filmes_cod
	FOREIGN KEY(cod_filme) REFERENCES filmes(cod)
);

CREATE TABLE funcionario (
	cod_func INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	login VARCHAR(16) NOT NULL UNIQUE KEY,
	pass VARCHAR(16) NOT NULL,
	nome VARCHAR(45) NOT NULL
);

INSERT INTO funcionario(login, pass, nome) VALUES ('admin','admin','Administrador');