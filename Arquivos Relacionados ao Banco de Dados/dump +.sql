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
    
    sexo varchar(15) DEFAULT 'Indefinido',
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

USE PI_III;

/* ---------------- T R A N S A C A O   E S P O R A D I C A -------------------- */
INSERT INTO TransacaoEsporadica 
(nome, descricao, dataDaTransacao, ativo, valor, tipo, categoria_id, usuario_id) VALUES

-- Usuário 1 (Ana Clara) | Ganhos: 450.00 | Gastos: 82.40
('Venda de apostilas', 'Venda de material didático antigo.', '2026-09-02', 1, 150.00, 'Ganho', 8, 1),
('Serviço de digitação', 'Trabalho de digitação de documentos.', '2026-09-12', 1, 300.00, 'Ganho', 8, 1),
('Lanche no shopping', 'Saída no fim de semana com amigas.', '2026-09-05', 1, 42.50, 'Gasto', 1, 1),
('Uber para o curso', 'Corrida em dia de chuva.', '2026-09-18', 1, 39.90, 'Gasto', 3, 1),

-- Usuário 2 (Bruno Henrique) | Ganhos: 500.00 | Gastos: 165.30
('Venda de jogo de videogame', 'Venda de jogo seminovo.', '2026-09-03', 1, 200.00, 'Ganho', 8, 2),
('Serviço de TI', 'Suporte técnico em computador de cliente.', '2026-09-15', 1, 300.00, 'Ganho', 8, 2),
('Supermercado', 'Compras de itens para a semana.', '2026-09-08', 1, 135.30, 'Gasto', 1, 2),
('Recarga de celular', 'Recarga de créditos pré-pago.', '2026-09-20', 1, 30.00, 'Gasto', 7, 2),

-- Usuário 3 (Camila Rocha) | Ganhos: 850.00 | Gastos: 278.00
('Projeto Freelancer UI', 'Desenvolvimento de telas para app.', '2026-09-04', 1, 850.00, 'Ganho', 8, 3),
('Cinema e pipoca', 'Ingresso e combo no cinema.', '2026-09-10', 1, 58.00, 'Gasto', 6, 3),
('Curso online', 'Compra de workshop de curta duração.', '2026-09-14', 1, 120.00, 'Gasto', 5, 3),
('Roupas', 'Compra de peças básicas.', '2026-09-21', 1, 100.00, 'Gasto', 6, 3),

-- Usuário 4 (Diego Santos) | Ganhos: 400.00 | Gastos: 139.80
('Venda de bicicleta', 'Venda de bicicleta usada.', '2026-09-01', 1, 400.00, 'Ganho', 10, 4),
('Farmácia', 'Remédios para gripe e vitaminas.', '2026-09-06', 1, 74.80, 'Gasto', 4, 4),
('Almoço de domingo', 'Restaurante em família.', '2026-09-13', 1, 65.00, 'Gasto', 1, 4),

-- Usuário 5 (Eduarda Martins) | Ganhos: 600.00 | Gastos: 295.00
('Aulas particulares', 'Reforço de matemática para alunos.', '2026-09-07', 1, 350.00, 'Ganho', 8, 5),
('Prêmio de sorteio', 'Sorteio em loja parceira.', '2026-09-19', 1, 250.00, 'Ganho', 10, 5),
('Feira do livro', 'Livros infantis e de literatura.', '2026-09-11', 1, 95.00, 'Gasto', 5, 5),
('Aporte em Investimento', 'Aplicação no Tesouro Direto.', '2026-09-22', 1, 200.00, 'Gasto', 9, 5),

-- Usuário 6 (Felipe Nogueira) | Ganhos: 550.00 | Gastos: 225.00
('Monitoria acadêmica', 'Pagamento por auxílio em aulas.', '2026-09-05', 1, 350.00, 'Ganho', 8, 6),
('Venda de instrumento', 'Venda de pedal de guitarra.', '2026-09-16', 1, 200.00, 'Ganho', 8, 6),
('Ingresso para show', 'Festival de música local.', '2026-09-09', 1, 140.00, 'Gasto', 6, 6),
('Conserto da bicicleta', 'Troca de pneu e lubrificação.', '2026-09-23', 1, 85.00, 'Gasto', 3, 6),

-- Usuário 7 (Gabriela Ferreira) | Ganhos: 350.00 | Gastos: 100.40
('Bico de fotografia', 'Ensaio fotográfico de aniversário.', '2026-09-08', 1, 350.00, 'Ganho', 8, 7),
('Lanche na escola', 'Salgado e suco na cantina.', '2026-09-02', 1, 12.50, 'Gasto', 1, 7),
('Presente de aniversário', 'Comprado para amiga.', '2026-09-17', 1, 60.00, 'Gasto', 6, 7),
('Material de artes', 'Tintas e pincéis.', '2026-09-24', 1, 27.90, 'Gasto', 6, 7),

-- Usuário 8 (Henrique Cardoso) | Ganhos: 900.00 | Gastos: 329.90
('Consultoria simples', 'Análise de redes sociais para loja.', '2026-09-10', 1, 900.00, 'Ganho', 8, 8),
('Manutenção do carro', 'Troca de óleo e filtro.', '2026-09-18', 1, 280.00, 'Gasto', 3, 8),
('Assinatura de música', 'Serviço de streaming de áudio.', '2026-09-25', 1, 49.90, 'Gasto', 7, 8),

-- Usuário 9 (Isabela Oliveira) | Ganhos: 750.00 | Gastos: 299.90
('Venda de roupas seminovas', 'Desapego de itens em brechó.', '2026-09-04', 1, 350.00, 'Ganho', 10, 9),
('Serviço de tradução', 'Tradução de artigo acadêmico.', '2026-09-14', 1, 400.00, 'Ganho', 8, 9),
('Roupas e acessórios', 'Roupas básicas na promoção.', '2026-09-09', 1, 149.90, 'Gasto', 6, 9),
('Consulta dentista', 'Limpeza de rotina.', '2026-09-21', 1, 150.00, 'Gasto', 4, 9),

-- Usuário 10 (João Victor) | Ganhos: 500.00 | Gastos: 161.90
('Formatação de computador', 'Manutenção preventiva de PCs.', '2026-09-06', 1, 500.00, 'Ganho', 8, 10),
('Jogos digitais', 'Compra na loja virtual de games.', '2026-09-03', 1, 89.90, 'Gasto', 6, 10),
('Serviço de entrega', 'Taxa de envio de documentos.', '2026-09-16', 1, 22.00, 'Gasto', 3, 10),
('Hamburgueria', 'Jantar de fim de semana.', '2026-09-26', 1, 50.00, 'Gasto', 1, 10);


/* ---------------- T R A N S A C A O   R E C O R R E N T E -------------------- */
INSERT INTO TransacaoRecorrente
(nome, descricao, diaVencimento, ativo, valor, tipo, categoria_id, usuario_id) VALUES
('Bolsa de Estudos/Estágio', 'Auxílio mensal de estudos.', 5, 1, 600.00, 'Ganho', 8, 1),
('Auxílio Transporte', 'Valor mensal para deslocamento.', 10, 1, 250.00, 'Ganho', 3, 2),
('Comissão Mensal', 'Comissão fixa por vendas online.', 15, 1, 400.00, 'Ganho', 8, 4),
('Mesada Familiar', 'Recebimento mensal fixo.', 1, 1, 350.00, 'Ganho', 10, 7),
('Dividendos', 'Rendimento mensal de investimentos.', 28, 1, 180.00, 'Ganho', 9, 10);