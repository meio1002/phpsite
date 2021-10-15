DROP TABLE IF EXISTS item;
DROP TABLE IF EXISTS player;


CREATE TABLE item (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10) NOT NULL,
    value INT NOT NULL,
    gazou VARCHAR(30) NOT NULL
) charset=utf8;
CREATE TABLE player (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    point INT NOT NULL,
    item1 INT NOT NULL,
    item2 INT NOT NULL,
    item3 INT NOT NULL
) charset=utf8;

INSERT INTO item (name,value,gazou) VALUES ("バニッシュ",2000,"vanish.png"),("チェンジ",1500,"change.png"),("カット",1000,"cut.png");

GRANT select,update,insert ON teto.player To 'sample_user'@'%';
GRANT select ON teto.item To 'sample_user'@'%';