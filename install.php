<?php

/**
 * Open a connection via PDO to create a
 * new database and table with structure.
 *
 */
/*

  Admin email :a@a.a
  Admin PWD   : admin123
*/
require "config.php";

try {
    $connection = new PDO("mysql:host=$host", $username, $password, $options);
    //$sqls = file_get_contents("data/init.sql");
	$sqls = [ 'DROP DATABASE IF EXISTS evaluation',

'CREATE DATABASE evaluation',

'use evaluation',

'CREATE TABLE typeUsers (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL
)',
'CREATE TABLE users (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(30),
	lastname VARCHAR(30),
	email VARCHAR(50) NOT NULL,
	password VARCHAR(60) NOT NULL,
	age INT(3),
	location VARCHAR(50),
	date TIMESTAMP,
	userTypeId int( 11 ) ,
	CONSTRAINT userTypeId  FOREIGN KEY (userTypeId) REFERENCES typeUsers (id)
)',
'CREATE TABLE filieres (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL
)',
'CREATE TABLE modules (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL
)',
'CREATE TABLE niveaux (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL
)',
'CREATE TABLE userModules (
	userId int( 11 ) NOT NULL ,
	CONSTRAINT userId  FOREIGN KEY (userId) REFERENCES users(id),
	moduleId int( 11 ) NOT NULL ,
	CONSTRAINT moduleId  FOREIGN KEY (moduleId) REFERENCES modules (id)
)',
'CREATE TABLE userNiveaux (
	userId int( 11 ) NOT NULL ,
	CONSTRAINT userId  FOREIGN KEY (userId) REFERENCES users(id),
	niveauId int( 11 ) NOT NULL ,
	CONSTRAINT niveauId  FOREIGN KEY (niveauId) REFERENCES niveaux (id)
)',
'CREATE TABLE userFilieres (
	userId int( 11 ) NOT NULL ,
	CONSTRAINT userId  FOREIGN KEY (userId) REFERENCES users(id),
	filiereId int( 11 ) NOT NULL ,
	CONSTRAINT filiereId  FOREIGN KEY (filiereId) REFERENCES filieres (id)
)',
'CREATE TABLE typeQuestion (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL
)',
'CREATE TABLE typeExam (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL
)',
'CREATE TABLE questions (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	contenue VARCHAR(255) NOT NULL,
	difficulte INT(3),
	rating INT(3),
	nbUtilisation INT(3),
	date TIMESTAMP,
	userId int( 11 ) NOT NULL ,
	CONSTRAINT userId  FOREIGN KEY (userId) REFERENCES users(id),
	typeQuestionId int( 11 ) NOT NULL ,
	CONSTRAINT typeQuestionId   FOREIGN KEY (typeQuestionId ) REFERENCES typeQuestion(id)
)',
'CREATE TABLE reponse (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	contenue VARCHAR(255) NOT NULL,
	correct BOOLEAN NOT NULL,
	questionId int( 11 ) NOT NULL ,
	CONSTRAINT questionId   FOREIGN KEY (questionId ) REFERENCES questions(id)
)',
'CREATE TABLE questionModules (
	moduleId int( 11 ) NOT NULL ,
	CONSTRAINT moduleId  FOREIGN KEY (moduleId) REFERENCES modules(id),
	questionId int( 11 ) NOT NULL ,
	CONSTRAINT questionId  FOREIGN KEY (questionId) REFERENCES questions(id)
)',
'CREATE TABLE questionNiveaux (
	niveauId int( 11 ) NOT NULL ,
	CONSTRAINT niveauId  FOREIGN KEY (niveauId) REFERENCES niveaux(id),
	questionId int( 11 ) NOT NULL ,
	CONSTRAINT questionId  FOREIGN KEY (questionId) REFERENCES questions(id)
)',
'CREATE TABLE questionFilieres (
	filiereId  int( 11 ) NOT NULL ,
	CONSTRAINT filiereId   FOREIGN KEY (filiereId ) REFERENCES filieres(id),
	questionId int( 11 ) NOT NULL ,
	CONSTRAINT questionId  FOREIGN KEY (questionId) REFERENCES questions(id)
)',
'CREATE TABLE exams (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	typeExamId  int( 11 ) NOT NULL ,
	date TIMESTAMP,
  duree int( 11 ),
	userId int( 11 ) NOT NULL ,
	CONSTRAINT userId  FOREIGN KEY (userId) REFERENCES users(id),
	CONSTRAINT typeExamId  FOREIGN KEY (typeExamId) REFERENCES typeExam(id)
)',
'CREATE TABLE examsModules (
  moduleId int( 11 ) NOT NULL ,
  CONSTRAINT moduleId  FOREIGN KEY (moduleId) REFERENCES modules(id),
  examId int( 11 ) NOT NULL ,
  CONSTRAINT examId  FOREIGN KEY (examId) REFERENCES exams(id)
)',
'CREATE TABLE examsNiveaux (
  niveauId int( 11 ) NOT NULL ,
  CONSTRAINT niveauId  FOREIGN KEY (niveauId) REFERENCES niveaux(id),
  examId int( 11 ) NOT NULL ,
  CONSTRAINT examId  FOREIGN KEY (examId) REFERENCES exams(id)
)',
'CREATE TABLE examsFilieres (
  filiereId  int( 11 ) NOT NULL ,
  CONSTRAINT filiereId   FOREIGN KEY (filiereId ) REFERENCES filieres(id),
  examId int( 11 ) NOT NULL ,
  CONSTRAINT examId  FOREIGN KEY (examId) REFERENCES exams(id)
)',
'CREATE TABLE examQuestions (
	examId int( 11 ) NOT NULL ,
	CONSTRAINT examId FOREIGN KEY (examId ) REFERENCES exams(id),
	questionId int( 11 ) NOT NULL ,
	CONSTRAINT questionId  FOREIGN KEY (questionId) REFERENCES questions(id)
)',
'CREATE TABLE etudExam (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	examId int( 11 ) NOT NULL ,
	CONSTRAINT examId FOREIGN KEY (examId ) REFERENCES exams(id),
	userId int( 11 ) NOT NULL ,
	CONSTRAINT userId  FOREIGN KEY (userId) REFERENCES users(id),
	date TIMESTAMP
)',
'CREATE TABLE etudExamReponse (
	etudexamId int( 11 ) NOT NULL ,
	CONSTRAINT etudexamId FOREIGN KEY (etudexamId) REFERENCES etudExam(id),
	questionId int( 11 ) NOT NULL ,
	CONSTRAINT questionId  FOREIGN KEY (questionId) REFERENCES questions(id),
	reponseId int( 11 ) NOT NULL ,
	CONSTRAINT reponseId  FOREIGN KEY (reponseId) REFERENCES reponse(id)
)',
'INSERT INTO typeusers VALUES (1, "Admin")',
'INSERT INTO typeusers VALUES (2, "Professeur")',
'INSERT INTO typeusers VALUES (3, "Etudient")',
'INSERT INTO users VALUES (1, "Admin", "Super", "a@a.a", "$2y$10$ruS/9.pQaqmmANuQd2i4YOsrMNswSw7BmZE8MHsxJnybXJJdCkCeK", NULL, NULL, NULL, 1)'
];
	foreach ($sqls as $sql) {
        $connection->exec($sql);
    }

    echo "Database and table users created successfully.";
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
