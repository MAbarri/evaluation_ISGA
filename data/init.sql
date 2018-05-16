[ 'DROP DATABASE evaluation',

'CREATE DATABASE evaluation',

'use evaluation',

'CREATE TABLE typeUsers (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(30) NOT NULL
)',
'CREATE TABLE users (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50) NOT NULL,
	password VARCHAR(20) NOT NULL,
	age INT(3),
	location VARCHAR(50),
	date TIMESTAMP,
    userTypeId int FOREIGN KEY REFERENCES typeUsers(id)
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
    userId int FOREIGN KEY REFERENCES users(id),
    moduleId int FOREIGN KEY REFERENCES modules(id)
)',
'CREATE TABLE userNiveaux (
    userId int FOREIGN KEY REFERENCES users(id),
    niveauId int FOREIGN KEY REFERENCES niveaux(id)
)',
'CREATE TABLE userFilieres (
    userId int FOREIGN KEY REFERENCES users(id),
    filiereId int FOREIGN KEY REFERENCES filieres(id)
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
	solution VARCHAR(255) NOT NULL,
	difficulte INT(3),
	rating INT(3),
	nbUtilisation INT(3),
	date TIMESTAMP,
    userId int FOREIGN KEY REFERENCES users(id),
    questionId int FOREIGN KEY REFERENCES typeQuestion(id)
)',
'CREATE TABLE questionModules (
    questionId int FOREIGN KEY REFERENCES questions(id),
    moduleId int FOREIGN KEY REFERENCES modules(id)
)',
'CREATE TABLE questionNiveaux (
    questionId int FOREIGN KEY REFERENCES questions(id),
    niveauId int FOREIGN KEY REFERENCES niveaux(id)
)',
'CREATE TABLE questionFilieres (
    questionId int FOREIGN KEY REFERENCES questions(id),
    filiereId int FOREIGN KEY REFERENCES filieres(id)
)',
'CREATE TABLE exams (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    typeExamId int FOREIGN KEY REFERENCES typeExam(id),
	date TIMESTAMP
)',
'CREATE TABLE examQuestions (
    questionId int FOREIGN KEY REFERENCES questions(id),
    examId int FOREIGN KEY REFERENCES exams(id)
)'
]