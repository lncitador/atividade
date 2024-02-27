CREATE DATABASE IF NOT EXISTS `churras` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `churras`;

DROP TABLE IF EXISTS items;
CREATE TABLE items (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(100) UNIQUE,
                       type ENUM('CARNE', 'BEBIDA'),
                       url VARCHAR(255)
);

INSERT INTO items (name, type, url) VALUES
                                   ('Picanha', 'CARNE', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIcoFLEJZO_UpsJK_0-N_FWbLvMjS548oyTf2rHdFgfQ&s'),
                                   ('Linguiça', 'CARNE', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDHsJJUgqUg-5FhoJCBWtZxdJzFmPXh1dvFYRLY_-FPA&s'),
                                   ('Refrigerante', 'BEBIDA', 'https://cdn.awsli.com.br/800x800/1345/1345272/produto/55984607/c8f16c7c59.jpg'),
                                   ('Alcatra', 'CARNE', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTnrcdnB2EcNUJmFcyghef0fj-2AtRmM7TrIc3GTMETYg&s'),
                                   ('Cerveja', 'BEBIDA', 'https://a-static.mlcdn.com.br/450x450/cerveja-heineken-puro-malte-pilsen-12-unidades-garrafa-600ml/magazineluiza/225338900/ab547a5ec23885c9c78abb2fe752b369.jpg'),
                                   ('Agua', 'BEBIDA', 'https://gizmodo.uol.com.br/wp-content/blogs.dir/8/files/2017/05/agua-alcalina.jpg'),
                                   ('Coração', 'CARNE', 'https://minervafoods.com/wp-content/uploads/2022/12/coracao_de_frango_-_blog_0-1.jpg');

DROP TABLE IF EXISTS guests;
CREATE TABLE guests (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(100) UNIQUE,
                        quantity INT
);

INSERT INTO guests (name, quantity) VALUES
                                        ('João e Filhos', 2),
                                        ('Maria', 1),
                                        ('José e Esposa', 2),
                                        ('Ana e Familia', 4),
                                        ('Pedro e Namorado', 2),
                                        ('Paula', 1);