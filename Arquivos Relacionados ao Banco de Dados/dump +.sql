DROP DATABASE IF EXISTS PI_III;
CREATE DATABASE PI_III;
USE PI_III;

/* ----------------  U S U A R I O  -------------------- */
CREATE TABLE Usuario(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(100) NOT NULL,
    saldo DECIMAL(65,2),
    sexo VARCHAR(15) DEFAULT 'Indefinido',
    ativo TINYINT(1) DEFAULT 1,
    dataNascimento DATE
);

/* ----------------  C A T E G O R I A  -------------------- */
CREATE TABLE Categoria(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    ativo TINYINT(1) DEFAULT 1
);

/* ----------------  T R A N S A C A O   E S P O R A D I C A  -------------------- */
CREATE TABLE TransacaoEsporadica(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(500),
    dataDaTransacao DATE,
    ativo TINYINT(1) DEFAULT 1,
    valor DECIMAL(65, 2),
    tipo VARCHAR(10),
    categoria_id INT NOT NULL,
    usuario_id INT NOT NULL,
    CONSTRAINT fk_CategoriaTransacaoEsporadica FOREIGN KEY (categoria_id) REFERENCES Categoria(id),
    CONSTRAINT fk_UsuarioTransacaoEsporadica FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);

/* ----------------  T R A N S A C A O   R E C O R R E N T E  -------------------- */
CREATE TABLE TransacaoRecorrente(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(500),
    diaVencimento INT,
    ativo TINYINT(1) DEFAULT 1,
    valor DECIMAL(65, 2),
    tipo VARCHAR(10),
    categoria_id INT NOT NULL,
    usuario_id INT NOT NULL,
    CONSTRAINT fk_CategoriaTransacaoRecorrente FOREIGN KEY (categoria_id) REFERENCES Categoria(id),
    CONSTRAINT fk_UsuarioTransacaoRecorrente FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);

/* ----------------  I N S E R T S  -------------------- */

-- Usuários
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

-- Categorias
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

-- Transações Esporádicas
INSERT INTO TransacaoEsporadica 
(nome, descricao, dataDaTransacao, ativo, valor, tipo, categoria_id, usuario_id) VALUES
-- Ana Clara (ID 1)
('Venda de apostilas', 'Venda de material didático antigo.', '2026-09-02', 1, 150.00, 'Ganho', 8, 1),
('Serviço de digitação', 'Trabalho de digitação de documentos.', '2026-09-12', 1, 300.00, 'Ganho', 8, 1),
('Lanche no shopping', 'Saída no fim de semana com amigas.', '2026-09-05', 1, 42.50, 'Gasto', 1, 1),
('Uber para o curso', 'Corrida em dia de chuva.', '2026-09-18', 1, 39.90, 'Gasto', 3, 1),
('Ingresso de Teatro', 'Peça cultural escolar.', '2026-09-22', 1, 25.00, 'Gasto', 6, 1),

-- Bruno Henrique (ID 2)
('Venda de jogo de videogame', 'Venda de jogo seminovo.', '2026-09-03', 1, 200.00, 'Ganho', 8, 2),
('Serviço de TI', 'Suporte técnico em computador de cliente.', '2026-09-15', 1, 300.00, 'Ganho', 8, 2),
('Supermercado', 'Compras de itens para a semana.', '2026-09-08', 1, 135.30, 'Gasto', 1, 2),
('Recarga de celular', 'Recarga de créditos pré-pago.', '2026-09-20', 1, 30.00, 'Gasto', 7, 2),
('Manutenção do fone', 'Troca de cabo do headphone.', '2026-09-24', 1, 45.00, 'Gasto', 6, 2),

-- Camila Rocha (ID 3)
('Projeto Freelancer UI', 'Desenvolvimento de telas para app.', '2026-09-04', 1, 850.00, 'Ganho', 8, 3),
('Cinema e pipoca', 'Ingresso e combo no cinema.', '2026-09-10', 1, 58.00, 'Gasto', 6, 3),
('Curso online', 'Compra de workshop de curta duração.', '2026-09-14', 1, 120.00, 'Gasto', 5, 3),
('Roupas', 'Compra de peças básicas.', '2026-09-21', 1, 100.00, 'Gasto', 6, 3),
('Livraria', 'Compra de romance infanto-juvenil.', '2026-09-26', 1, 42.00, 'Gasto', 5, 3),

-- Diego Santos (ID 4)
('Venda de bicicleta', 'Venda de bicicleta usada.', '2026-09-01', 1, 400.00, 'Ganho', 10, 4),
('Farmácia', 'Remédios para gripe e vitaminas.', '2026-09-06', 1, 74.80, 'Gasto', 4, 4),
('Almoço de domingo', 'Restaurante em família.', '2026-09-13', 1, 65.00, 'Gasto', 1, 4),
('Copiar chaves', 'Chave reserva da residência.', '2026-09-19', 1, 18.00, 'Gasto', 2, 4),

-- Eduarda Martins (ID 5)
('Aulas particulares', 'Reforço de matemática para alunos.', '2026-09-07', 1, 350.00, 'Ganho', 8, 5),
('Prêmio de sorteio', 'Sorteio em loja parceira.', '2026-09-19', 1, 250.00, 'Ganho', 10, 5),
('Feira do livro', 'Livros infantis e de literatura.', '2026-09-11', 1, 95.00, 'Gasto', 5, 5),
('Aporte em Investimento', 'Aplicação no Tesouro Direto.', '2026-09-22', 1, 200.00, 'Gasto', 9, 5),

-- Felipe Nogueira (ID 6)
('Monitoria acadêmica', 'Pagamento por auxílio em aulas.', '2026-09-05', 1, 350.00, 'Ganho', 8, 6),
('Venda de instrumento', 'Venda de pedal de guitarra.', '2026-09-16', 1, 200.00, 'Ganho', 8, 6),
('Ingresso para show', 'Festival de música local.', '2026-09-09', 1, 140.00, 'Gasto', 6, 6),
('Conserto da bicicleta', 'Troca de pneu e lubrificação.', '2026-09-23', 1, 85.00, 'Gasto', 3, 6),

-- Gabriela Ferreira (ID 7)
('Bico de fotografia', 'Ensaio fotográfico de aniversário.', '2026-09-08', 1, 350.00, 'Ganho', 8, 7),
('Lanche na escola', 'Salgado e suco na cantina.', '2026-09-02', 1, 12.50, 'Gasto', 1, 7),
('Presente de aniversário', 'Comprado para amiga.', '2026-09-17', 1, 60.00, 'Gasto', 6, 7),
('Material de artes', 'Tintas e pincéis.', '2026-09-24', 1, 27.90, 'Gasto', 6, 7),

-- Henrique Cardoso (ID 8)
('Consultoria simples', 'Análise de redes sociais para loja.', '2026-09-10', 1, 900.00, 'Ganho', 8, 8),
('Manutenção do carro', 'Troca de óleo e filtro.', '2026-09-18', 1, 280.00, 'Gasto', 3, 8),
('Alinhamento das rodas', 'Serviço em oficina mecânica.', '2026-09-27', 1, 120.00, 'Gasto', 3, 8),

-- Isabela Oliveira (ID 9)
('Venda de roupas seminovas', 'Desapego de itens em brechó.', '2026-09-04', 1, 350.00, 'Ganho', 10, 9),
('Serviço de tradução', 'Tradução de artigo acadêmico.', '2026-09-14', 1, 400.00, 'Ganho', 8, 9),
('Roupas e acessórios', 'Roupas básicas na promoção.', '2026-09-09', 1, 149.90, 'Gasto', 6, 9),
('Consulta dentista', 'Limpeza de rotina.', '2026-09-21', 1, 150.00, 'Gasto', 4, 9),

-- João Victor (ID 10)
('Formatação de computador', 'Manutenção preventiva de PCs.', '2026-09-06', 1, 500.00, 'Ganho', 8, 10),
('Jogos digitais', 'Compra na loja virtual de games.', '2026-09-03', 1, 89.90, 'Gasto', 6, 10),
('Serviço de entrega', 'Taxa de envio de documentos.', '2026-09-16', 1, 22.00, 'Gasto', 3, 10),
('Hamburgueria', 'Jantar de fim de semana.', '2026-09-26', 1, 50.00, 'Gasto', 1, 10);

-- Transações Recorrentes
INSERT INTO TransacaoRecorrente
(nome, descricao, diaVencimento, ativo, valor, tipo, categoria_id, usuario_id) VALUES
-- Ganhos Recorrentes
('Bolsa de Estudos/Estágio', 'Auxílio mensal de estudos.', 5, 1, 600.00, 'Ganho', 8, 1),
('Auxílio Transporte', 'Valor mensal para deslocamento.', 10, 1, 250.00, 'Ganho', 3, 2),
('Comissão Mensal', 'Comissão fixa por vendas online.', 15, 1, 400.00, 'Ganho', 8, 4),
('Mesada Familiar', 'Recebimento mensal fixo.', 1, 1, 350.00, 'Ganho', 10, 7),
('Rendimento de Estágio', 'Pagamento fixo por estágio técnico.', 5, 1, 800.00, 'Ganho', 8, 8),
('Dividendos', 'Rendimento mensal de investimentos.', 28, 1, 180.00, 'Ganho', 9, 10),

-- Gastos Recorrentes (Contas Fixas e Assinaturas)
('Plano de Celular', 'Plano controle mensal de telefonia.', 10, 1, 45.90, 'Gasto', 7, 1),
('Academia', 'Mensalidade da academia do bairro.', 15, 1, 89.90, 'Gasto', 4, 1),
('Assinatura Streaming Vídeo', 'Mensalidade da plataforma de filmes.', 12, 1, 39.90, 'Gasto', 7, 2),
('Curso de Inglês', 'Mensalidade da escola de idiomas.', 20, 1, 180.00, 'Gasto', 5, 3),
('Plano de Internet', 'Internet banda larga residencial.', 10, 1, 99.90, 'Gasto', 2, 4),
('Assinatura de Computação em Nuvem', 'Armazenamento de arquivos para projetos.', 18, 1, 14.90, 'Gasto', 7, 5),
('Passagem Estudantil (Passe)', 'Carregamento mensal do cartão de ônibus.', 1, 1, 110.00, 'Gasto', 3, 6),
('Assinatura de música', 'Serviço de streaming de áudio.', 25, 1, 49.90, 'Gasto', 7, 8),
('Plano de Saúde Familiar', 'Coparticipação mensal de saúde.', 5, 1, 210.00, 'Gasto', 4, 9),
('Plano Game Pass', 'Assinatura mensal para catálogo de jogos.', 15, 1, 44.99, 'Gasto', 7, 10);