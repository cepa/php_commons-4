DROP TABLE IF EXISTS book;
CREATE TABLE book (
    id INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    create_time INT
) ENGINE=innodb CHARACTER SET utf8;

INSERT INTO book (title, description, create_time) VALUES
    ('The Master and Margarita', 'The Master and Margarita is a novel by Mikhail Bulgakov, written between 1928 and 1940 but not published until 1967, which is woven around a visit by the Devil to the fervently atheistic Soviet Union.', UNIX_TIMESTAMP());
