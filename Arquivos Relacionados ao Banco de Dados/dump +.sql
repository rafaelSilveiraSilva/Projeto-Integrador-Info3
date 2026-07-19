DROP DATABASE IF EXISTS PI_III; # se existir esse banco de dados, apague, isso garante que toda vez que se inicie esse arquivo
								# o banco de dados resete, bom pra testar e tudo mais.
CREATE DATABASE PI_III; # Cria o banco de dados nomeado de "PI_III"
USE PI_III; # Selecione o banco de dados nomeado de "PI_III"



/* ----------------  U S U A R I O  -------------------- */
# Criando a tabela Usuario com seus devidos atributos
CREATE TABLE Usuario(

	id int primary key auto_increment NOT NULL,
    # serve para identificar a entidade, possui auto incremento para ao decorrer que forem registrados novos registros já coloque uma chave
    # primária de forma automática
    
    nome varchar(100) NOT NULL,
    # o nome do usuário no sistema, recomenda-se que seja o nome verdadeiro dele, e não pode ser nulo.
    
    email varchar(100) NOT NULL,
    senha varchar(100) NOT NULL,
    
    saldo decimal(65,2),
    # o saldo indica a renda atual de determinado usuário que constantemente vai ser alterado com o uso do site.
    
    sexo varchar(15),
    # no site só vai ter a opção dele escolher entre M, F ou Prefiro Não Informar, aí o site vai entrar em um IF e com isso o próprio site 
    # vai preencher esse atributo... tipo desse jeito:
    /*
    
    if caixinhaDeSelecao == "M":
		Usuario.sexo = "M"
	elif caixinhaDeSelecao == "F":
		Usuario.Sexo = "F"
	else:
		Usuario.sexo = "Nao Informado"
	
    */
    
    
    
    ativo tinyint(1) default 1,
    # Acho uma boa usarmos esse lance de ativo pois vai ajudar na hora de querermos excluir um registro, para caso dê biziu é só colocar o ativo
    # como 0 mesmo e valeu.
    
    dataNascimento date
    # Vai ser usado para calcular a idade do usuário mesmo.
        
);



/* ----------------  C A T E G O R I A  -------------------- */
# Criando a tabela Categoria com seus devidos atributos
CREATE TABLE Categoria(

	id int primary key auto_increment NOT NULL,
    # serve para identificar a entidade, possui auto incremento para ao decorrer que forem registrados novos registros já coloque uma chave
    # primária de forma automática
    
    nome varchar(100) NOT NULL,
    # o nome da categoria no sistema.
    
    ativo tinyint(1) default 1
    # Acho uma boa usarmos esse lance de ativo pois vai ajudar na hora de querermos excluir um registro, para caso dê biziu é só 
    # colocar o ativo como 0 mesmo e valeu.
    
);



/* ----------------  T R A N S A C A O   E S P O R A D I C A  -------------------- */
# Criando a tabela TransacaoEsporadica com seus devidos atributos
CREATE TABLE TransacaoEsporadica(
/* Significado de Esporádica: adjetivo usado para qualificar algo que acontece com pouca frequência, de forma
irregular e sem um padrão ou rotina fixa */

	id int primary key auto_increment NOT NULL,
    # serve para identificar a entidade, possui auto incremento para ao decorrer que forem registrados novos 
    # registros já coloque uma chave primária de forma automática
    
    nome varchar(100) NOT NULL,
    # o nome da transacao esporádica no sistema, é obrigatório que o usuário insira um nome pelo próprio "bem" dele, afinal, como se ter organização
    # se nem o nome do gasto ou ganho que você teve tá registrado? Acredito eu que seja necessário ter justamente para ajudar.
    
    descricao varchar(500),
    # é mais sobre uma forma de descrever mais a fundo sobre essa transação, vai ser opcional pois vai depender mais da vontade do usuário querer 
    # dar o máximo de si para se organizar, mas deixemos sem ser obrigatório já que é algo mais "chatinho" de se preencher todas as vezes que ganhar
    # ou gastar dinheiro.
    
    dataDaTransacao date,
    # o prório site já pega a data do dia mesmo. Ou usamos alguma biblioteca ou alguma função nativa mesmo.
    
    ativo tinyint(1) default 1,
    # Acho uma boa usarmos esse lance de ativo pois vai ajudar na hora de querermos excluir um registro, para caso dê biziu é só colocar o ativo
    # como 0 mesmo e valeu.
    
    valor decimal(65, 2),
    # Qual o valor associado nessa transação, o número 100 indica que aceita números com até 100 casas decimais, e o número 2
    # para falar que aceita até dois números depois da vírgula.
    
    tipo varchar(10),
    # no site só vai ter a opção dele escolher entre "Gasto" ou "Ganho", aí o site vai entrar em um IF e com isso o próprio site 
    # vai preencher esse atributo... tipo desse jeito:
    /*
    
    if caixinhaDeSelecao == "Ganho":
		Usuario.saldo += valor
	elif caixinhaDeSelecao == "Gasto":
		Usuario.saldo -= valor
	else:
		print(ERRO! TEM QUE SELECIONAR UMA DAS OPÇÕES!)
        
    */
    
    categoria_id int NOT NULL,
    usuario_id int NOT NULL,
    
    CONSTRAINT fk_CategoriaTransacaoEsporadica FOREIGN KEY (categoria_id) REFERENCES Categoria(id),
    # Definido a chave estrangeira que vem de Categoria.
    
    CONSTRAINT fk_UsuarioTransacaoEsporadica FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
    # Definido a chave estrangeira que vem de Usuari
    
);



/* ----------------  T R A N S A C A O   R E C O R R E N T E  -------------------- */
# Criando a tabela TransacaoRecorrente com seus devidos atributos
CREATE TABLE TransacaoRecorrente(

	id int primary key auto_increment NOT NULL,
    # serve para identificar a entidade, possui auto incremento para ao decorrer que forem registrados novos 
    # registros já coloque uma chave primária de forma automática
    
    nome varchar(100) NOT NULL,
    # o nome da transacao recorrente no sistema, é obrigatório que o usuário insira um nome pelo próprio "bem" dele, afinal, como se ter organização
    # se nem o nome do gasto fixo ou ganho fixo que você teve tá registrado? Acredito eu que seja necessário ter justamente para ajudar.
    
    descricao varchar(500),
    # é mais sobre uma forma de descrever mais a fundo sobre essa transação recorrente, vai ser opcional pois vai depender mais da vontade do usuário querer 
    # dar o máximo de si para se organizar, mas deixemos sem ser obrigatório já que é algo mais "chatinho" de se preencher todas as vezes que ganhar
    # ou gastar dinheiro de forma recorrente.
    
    diaVencimento int,
    # o prório site irá sempre que bater o dia do vencimento descontar ou acrescentar o valor relacionado a determinado registro daqui no saldo do usuário de forma
    # automática, isto é, sempre que essa TransacaoRecorrente estiver ativa.
    /*
    
    Se o usuário definir o dia como 31 mas o mês não for até o dia 31, fazer que essa recorrência ocorra sempre no último dia do mês:
		Exemplos:
			- Junho -> sistema processa no dia 30

			- Fevereiro -> sistema processa no dia 28 (ou 29 se ano bissexto)

			- Julho, processa no dia 31.
    
    Para deixar avisado ao usuário, colocar esse texto próximo pra ele ficar sabendo:
		- Para meses com menos de 31 dias, será realizado no último dia do mês.
        
    */
    
    ativo tinyint(1) default 1,
    # Acho uma boa usarmos esse lance de ativo pois vai ajudar na hora de querermos excluir um registro, para caso dê biziu é só colocar o ativo
    # como 0 mesmo e valeu.
    
    valor decimal(65, 2),
    # Qual o valor associado nessa transação recorrente, o número 100 indica que aceita números com até 100 casas decimais, e o número 2
    # para falar que aceita até dois números depois da vírgula.
    
    tipo varchar(10),
    # no site só vai ter a opção dele escolher entre "Gasto" ou "Ganho", aí o site vai entrar em um IF e com isso o próprio site 
    # vai preencher esse atributo... claro que no dia do vencimento especificado, tipo desse jeito:
    /*
    if diaAtual = diaVencimento:
		if caixinhaDeSelecao == "Ganho":
			Usuario.saldo += valor
		elif caixinhaDeSelecao == "Gasto":
			Usuario.saldo -= valor
		else:
			print(ERRO! TEM QUE SELECIONAR UMA DAS OPÇÕES!)
	else:
		pass
    */
    
    categoria_id int NOT NULL,
    usuario_id int NOT NULL,
    
    CONSTRAINT fk_CategoriaTransacaoRecorrente FOREIGN KEY (categoria_id) REFERENCES Categoria(id),
    # Definido a chave estrangeira que vem de Categoria.
    
    CONSTRAINT fk_UsuarioTransacaoRecorrente FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
    # Definido a chave estrangeira que vem de Usuario
);



/* ----------------  I N S E R T S  -------------------- */


/* ----------------  U S U A R I O  -------------------- */
INSERT INTO Usuario (nome, email, senha, saldo, sexo, ativo, dataNascimento) VALUES
('Ana Clara Souza', 'ana.clara@email.com', 'senha123', 2450.75, 'F', 1, '2007-04-18'),
('Bruno Henrique Lima', 'bruno.lima@email.com', 'senha123', 1320.40, 'M', 1, '2006-09-22'),
('Camila Rocha Alves', 'camila.alves@email.com', 'senha123', 3890.00, 'F', 1, '2008-01-10'),
('Diego Santos Pereira', 'diego.pereira@email.com', 'senha123', 980.15, 'M', 1, '2005-12-03'),
('Eduarda Martins Costa', 'eduarda.costa@email.com', 'senha123', 560.90, 'F', 1, '2007-07-27'),
('Felipe Nogueira Ramos', 'felipe.ramos@email.com', 'senha123', 2100.00, 'M', 1, '2006-03-14'),
('Gabriela Ferreira Silva', 'gabriela.silva@email.com', 'senha123', 745.30, 'F', 1, '2008-11-30'),
('Henrique Cardoso Melo', 'henrique.melo@email.com', 'senha123', 4150.60, 'M', 1, '2005-05-06'),
('Isabela Oliveira Dias', 'isabela.dias@email.com', 'senha123', 1785.25, 'F', 1, '2007-02-21'),
('João Victor Barbosa', 'joao.barbosa@email.com', 'senha123', 2999.99, 'M', 1, '2006-08-09');

/* ----------------  C A T E G O R I A  -------------------- */
INSERT INTO Categoria (nome, ativo) VALUES
('Alimentação', 1),
('Moradia', 1),
('Transporte', 1),
('Saúde', 1),
('Educação', 1),
('Lazer', 1),
('Assinaturas', 1),
('Trabalho', 1),
('Investimentos', 1),
('Emergência', 1);

/* ----------------  T R A N S A C A O   E S P O R A D I C A  -------------------- */
INSERT INTO TransacaoEsporadica
(nome, descricao, dataDaTransacao, ativo, valor, tipo, categoria_id, usuario_id) VALUES
('Venda de livro', 'Venda de um livro usado para um colega.', '2026-07-01', 1, 45.00, 'Ganho', 8, 1),
('Compra de lanche', 'Lanche da tarde na cantina.', '2026-07-02', 1, 18.50, 'Gasto', 1, 2),
('Freela de edição', 'Edição de vídeo para um projeto curto.', '2026-07-03', 1, 180.00, 'Ganho', 8, 3),
('Consulta médica', 'Consulta particular com clínico geral.', '2026-07-04', 1, 120.00, 'Gasto', 4, 4),
('Presente recebido', 'Dinheiro recebido em presente de aniversário.', '2026-07-05', 1, 200.00, 'Ganho', 10, 5),
('Material escolar', 'Compra de caderno e canetas.', '2026-07-06', 1, 67.90, 'Gasto', 5, 6),
('Ingresso cinema', 'Saída com amigos no cinema.', '2026-07-07', 1, 32.00, 'Gasto', 6, 7),
('Bico de evento', 'Trabalho rápido em evento escolar.', '2026-07-08', 1, 150.00, 'Ganho', 8, 8),
('Reembolso', 'Reembolso de compra cancelada.', '2026-07-09', 1, 89.99, 'Ganho', 10, 9),
('Conserto do fone', 'Troca de cabo e ajuste do fone.', '2026-07-10', 1, 55.00, 'Gasto', 4, 10);

/* ----------------  T R A N S A C A O   R E C O R R E N T E  -------------------- */
INSERT INTO TransacaoRecorrente
(nome, descricao, diaVencimento, ativo, valor, tipo, categoria_id, usuario_id) VALUES
('Mensalidade escolar', 'Pagamento fixo da mensalidade.', 5, 1, 450.00, 'Gasto', 5, 1),
('Internet', 'Plano de internet residencial.', 10, 1, 99.90, 'Gasto', 7, 2),
('Bolsa estágio', 'Valor mensal recebido pelo estágio.', 15, 1, 800.00, 'Ganho', 8, 3),
('Academia', 'Plano mensal da academia.', 12, 1, 79.90, 'Gasto', 4, 4),
('Aluguel', 'Pagamento do aluguel da casa.', 8, 1, 1200.00, 'Gasto', 2, 5),
('Mesada', 'Valor fixo recebido da família.', 20, 1, 300.00, 'Ganho', 10, 6),
('Streaming', 'Assinatura de serviço de streaming.', 18, 1, 27.90, 'Gasto', 7, 7),
('Transporte fixo', 'Gasto mensal com deslocamento.', 25, 1, 150.00, 'Gasto', 3, 8),
('Renda fixa', 'Valor mensal de renda por serviço.', 30, 1, 950.00, 'Ganho', 8, 9),
('Plano de saúde', 'Mensalidade do plano de saúde.', 3, 1, 210.00, 'Gasto', 4, 10);