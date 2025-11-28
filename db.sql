CREATE DATABASE IF NOT EXISTS `controle-de-gastos`;
USE `controle-de-gastos`;

DROP TABLE IF EXISTS `transacoes`;
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `usuario` VARCHAR(30) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `perfil` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `senha`, `perfil`) VALUES
(1, 'Usuario Teste da Silva', 'usuario_teste', '$2y$10$CkVnNZjdncRJRSTPJ7XslOnMKkuwpW6B8tBkR.JGlxdHanfinbQS2', 'usuario');

DROP TABLE IF EXISTS `tipos_transacao`;
CREATE TABLE `tipos_transacao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(120) NOT NULL,
  `tipo` ENUM('receita', 'despesa') NOT NULL,
  `descricao` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tipos_transacao` (`id`, `nome`, `tipo`, `descricao`) VALUES
(1, 'Aluguel / Moradia', 'despesa', 'Pagamento mensal do imóvel e condomínio'),
(2, 'Mercado', 'despesa', 'Compras de alimentação e higiene'),
(3, 'Salário', 'receita', 'Recebimento mensal do trabalho CLT'),
(4, 'Contas Fixas', 'despesa', 'Água, Luz, Internet, Telefone'),
(5, 'Transporte', 'despesa', 'Combustível, Uber, Ônibus, Manutenção'),
(6, 'Lazer', 'despesa', 'Cinema, Jantar fora, Viagens'),
(7, 'Saúde', 'despesa', 'Farmácia, Consultas, Convênio'),
(8, 'Educação', 'despesa', 'Faculdade, Cursos, Livros'),
(9, 'Freelance / Extra', 'receita', 'Trabalhos extras e bicos'),
(10, 'Investimentos', 'receita', 'Dividendos e rendimentos');


DROP TABLE IF EXISTS `formas_pagamento`;
CREATE TABLE `formas_pagamento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `formas_pagamento` (`id`, `nome`) VALUES
(1, 'Dinheiro'),
(2, 'PIX'),
(3, 'Cartão de Crédito'),
(4, 'Cartão de Débito'),
(5, 'Transferência Bancária'),
(6, 'Boleto');


CREATE TABLE `transacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `tipo_transacao_id` INT NOT NULL,
  `forma_pagamento_id` INT NOT NULL,
  `titulo` VARCHAR(150) NOT NULL,
  `valor` DECIMAL(10,2) NOT NULL,
  `data` DATE NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tipo_transacao_id`) REFERENCES `tipos_transacao`(`id`),
  FOREIGN KEY (`forma_pagamento_id`) REFERENCES `formas_pagamento`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DELIMITER $$

DROP PROCEDURE IF EXISTS PopulaBancoDados$$

CREATE PROCEDURE PopulaBancoDados()
BEGIN
    DECLARE ano INT DEFAULT 2021;
    DECLARE mes INT DEFAULT 1;
    DECLARE dia INT;
    DECLARE i INT;
    
    DECLARE renda_mensal DECIMAL(10,2);
    DECLARE gastos_fixos DECIMAL(10,2);
    DECLARE saldo_disponivel DECIMAL(10,2);
    DECLARE meta_gasto_variavel DECIMAL(10,2);
    DECLARE sorteio_humor FLOAT;

    TRUNCATE TABLE `transacoes`;

    WHILE ano <= 2025 DO
        SET mes = 1;

        WHILE mes <= 12 DO
            SET renda_mensal = 4000.00 + ((ano - 2021) * 350.00); 
            
            SET renda_mensal = renda_mensal + (RAND() * 200 - 50);

            INSERT INTO `transacoes` (usuario_id, tipo_transacao_id, forma_pagamento_id, titulo, valor, data) 
            VALUES (1, 3, 5, 'Salário Mensal', renda_mensal, DATE(CONCAT(ano, '-', mes, '-05')));

            IF (mes = 11 OR mes = 12) THEN
                 SET renda_mensal = renda_mensal + (renda_mensal * 0.5);
                 INSERT INTO `transacoes` VALUES (NULL, 1, 3, 5, '13º Salário', renda_mensal * 0.5, DATE(CONCAT(ano, '-', mes, '-06')));
            END IF;

            SET gastos_fixos = 1200.00 + (RAND() * 300);
            
            INSERT INTO `transacoes` VALUES (NULL, 1, 1, 6, 'Aluguel + Cond.', 1000 + (ano-2021)*50, DATE(CONCAT(ano, '-', mes, '-10')));
            INSERT INTO `transacoes` VALUES (NULL, 1, 4, 6, 'Contas (Luz/Net)', gastos_fixos - (1000 + (ano-2021)*50), DATE(CONCAT(ano, '-', mes, '-12')));

            SET saldo_disponivel = renda_mensal - gastos_fixos;

            SET sorteio_humor = RAND();

            IF (sorteio_humor < 0.70) THEN 
                SET meta_gasto_variavel = saldo_disponivel * (0.4 + RAND() * 0.3);
            
            ELSEIF (sorteio_humor < 0.90) THEN
                SET meta_gasto_variavel = saldo_disponivel * (0.9 + RAND() * 0.2);

            ELSE
                SET meta_gasto_variavel = saldo_disponivel * (1.5 + RAND() * 0.8);
                
                INSERT INTO `transacoes` (usuario_id, tipo_transacao_id, forma_pagamento_id, titulo, valor, data) 
                VALUES (1, 6, 3, 
                    ELT(FLOOR(1 + RAND()*4), 'Conserto Carro', 'Viagem', 'Emergência', 'Troca Notebook'), 
                    meta_gasto_variavel * 0.6,
                    DATE(CONCAT(ano, '-', mes, '-18'))
                );
                SET meta_gasto_variavel = meta_gasto_variavel * 0.4; 
            END IF;

            SET i = 0;
            WHILE meta_gasto_variavel > 50 AND i < 20 DO
                SET dia = FLOOR(1 + RAND() * 27);
                
                INSERT INTO `transacoes` (usuario_id, tipo_transacao_id, forma_pagamento_id, titulo, valor, data) 
                VALUES (1, 
                    ELT(FLOOR(1 + RAND()*3), 2, 5, 6),
                    ELT(FLOOR(1 + RAND()*3), 2, 3, 4), 
                    ELT(FLOOR(1 + RAND()*5), 'Uber/Transporte', 'Lanche/Restaurante', 'Supermercado', 'Farmácia', 'Streaming/Jogos'), 
                    LEAST(meta_gasto_variavel, 50 + RAND() * 250),
                    DATE(CONCAT(ano, '-', mes, '-', dia))
                );
                
                SET meta_gasto_variavel = meta_gasto_variavel - (SELECT valor FROM transacoes ORDER BY id DESC LIMIT 1);
                SET i = i + 1;
            END WHILE;

            SET mes = mes + 1;
        END WHILE;
        
        SET ano = ano + 1;
    END WHILE;
END$$

DELIMITER ;

CALL PopulaBancoDados();