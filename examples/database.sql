DROP TABLE IF EXISTS identity;
CREATE TABLE identity ( 
    id int primary key auto_increment, 
    first_name varchar(128) unique, 
    last_name varchar(128) 
);
INSERT INTO identity (first_name, last_name) VALUES
    ('johny', 'walker'),
    ('jack', 'daniels'),
    ('glen', 'fiddich');
    