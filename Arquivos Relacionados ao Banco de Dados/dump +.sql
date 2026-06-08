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
    
    sexo varchar(5),
    # no site só vai ter a opção dele escolher entre M, F ou Prefiro Não Informar, aí o site vai entrar em um IF e com isso o próprio site 
    # vai preencher esse atributo... tipo desse jeito:
    /*
    
    if caixinhaDeSelecao == "M":
		Usuario.sexo = "M"
	elif caixinhaDeSelecao == "F":
		Usuario.Sexo = "F"
	else:
		Usuario.sexo = "Não Informado"
	
    */
    
    cpf char(20) unique NOT NULL,
    # cpf como atributo único por questões lógicas, não tem como ter duas pessoas com o mesmo CPF.
    # CPF não seria melhor como chave primária? Acho que não, afinal, o id tem todo o lance de auto_incremento e tudo mais, acho que vai facilitar
    # para o desenvolvimento do site do que se fosse usando cpf's.
    
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
INSERT INTO Usuario (id, nome, sexo, cpf, ativo, dataNascimento) VALUES
(1, 'Ana Souza', 'F', '11111111111', 1, '2004-03-18'),
(2, 'Bruno Lima', 'M', '22222222222', 1, '2002-11-07'),
(3, 'Carla Mendes', 'F', '33333333333', 0, '1999-06-25');

INSERT INTO Categoria (id, nome, ativo) VALUES
(1, 'Alimentacao', 1),
(2, 'Lazer', 1),
(3, 'Transporte', 1),
(4, 'Saude', 1),
(5, 'Educação', 1),
(6, 'Moradia', 1),
(7, 'Salario', 1),
(8, 'Investimento', 1),
(9, 'Imprevistos', 0),
(10, 'Outros', 1);

INSERT INTO TransacaoEsporadica (id, nome, descricao, dataDaTransacao, ativo, valor, tipo, categoria_id, usuario_id) VALUES
(1, 'Mercado da semana', 'Compras de alimentos e itens básicos', '2026-06-01', 1, 187.45, 'Gasto', 1, 1),
(2, 'Salario extra', 'Bico realizado no fim de semana', '2026-06-02', 1, 350.00, 'Ganho', 7, 1),
(3, 'Cinema', 'Saída com amigos', '2026-06-03', 1, 42.00, 'Gasto', 2, 2),
(4, 'Consulta medica', 'Consulta particular de rotina', '2026-06-04', 1, 180.00, 'Gasto', 4, 2),
(5, 'Venda usada', 'Venda de um fone antigo', '2026-06-05', 1, 90.00, 'Ganho', 10, 3),
(6, 'Uber aeroporto', 'Deslocamento urgente', '2026-06-06', 0, 63.80, 'Gasto', 3, 3),
(7, 'Curso online', 'Compra de acesso a curso', '2026-06-07', 1, 129.90, 'Gasto', 5, 1),
(8, 'Prêmio', 'Premiação de competição', '2026-06-08', 1, 500.00, 'Ganho', 10, 2);

INSERT INTO TransacaoRecorrente (id, nome, descricao, diaVencimento, ativo, valor, tipo, categoria_id, usuario_id) VALUES
(1, 'Mensalidade academia', 'Plano mensal da academia', 5, 1, 89.90, 'Gasto', 4, 1),
(2, 'Internet', 'Serviço de internet residencial', 10, 1, 119.99, 'Gasto', 6, 1),
(3, 'Salario fixo', 'Salario mensal do trabalho', 30, 1, 2500.00, 'Ganho', 7, 2),
(4, 'Streaming', 'Assinatura de plataforma de filmes', 15, 1, 24.90, 'Gasto', 2, 2),
(5, 'Poupanca', 'Transferencia mensal para reserva', 20, 1, 300.00, 'Gasto', 8, 3),
(6, 'Bolsa de estudos', 'Valor mensal recebido', 12, 1, 600.00, 'Ganho', 5, 3),
(7, 'Aluguel', 'Pagamento do aluguel', 31, 1, 950.00, 'Gasto', 6, 1),
(8, 'Assinatura app', 'Ferramenta de produtividade', 28, 0, 15.90, 'Gasto', 10, 2);