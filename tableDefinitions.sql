SET foreign_key_checks = 0;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `location`;
DROP TABLE IF EXISTS `tag`;
DROP TABLE IF EXISTS `tag_restaurant`;
DROP TABLE IF EXISTS `restaurant`;
DROP TABLE IF EXISTS `review`;
SET foreign_key_checks = 1;

CREATE TABLE location
(
  id INT NOT NULL AUTO_INCREMENT,
  streetAddress VARCHAR(255) NOT NULL,
  city VARCHAR(255) NOT NULL,
  state VARCHAR(255) NOT NULL, 
  zip INT NOT NULL,
  PRIMARY KEY(id),
  UNIQUE(streetAddress, city, state, zip)
);

CREATE TABLE user
(
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  lid INT NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(lid) REFERENCES location(id),    
  UNIQUE(username)
);

CREATE TABLE tag
(
  id INT NOT NULL AUTO_INCREMENT,
  description VARCHAR(255) NOT NULL,
  PRIMARY KEY(id), 
  UNIQUE(description)
);

CREATE TABLE restaurant
(
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  website VARCHAR(255),
  phone VARCHAR(255),
  lid INT NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(lid) REFERENCES location(id)
);

CREATE TABLE tag_restaurant
(
   rid INT NOT NULL,
   tid INT NOT NULL,
   PRIMARY KEY(rid,tid),
   FOREIGN KEY(rid) REFERENCES restaurant(id) ON DELETE CASCADE, 
   FOREIGN KEY(tid) REFERENCES tag(id) ON DELETE CASCADE 
);

CREATE TABLE review
(
  id INT NOT NULL AUTO_INCREMENT,
  uid INT NOT NULL,
  rid INT NOT NULL,
  rating INT NOT NULL,
  reviewtxt TEXT,
  reviewDate DATETIME,
  PRIMARY KEY(id),
  FOREIGN KEY(uid) REFERENCES user(id), 
  FOREIGN KEY(rid) REFERENCES restaurant(id),
  CHECK(rating >=1 AND rating <= 5)
);