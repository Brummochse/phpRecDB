DROP TABLE IF EXISTS "job";
CREATE TABLE "job" ( "jid" INTEGER NOT NULL  , "jdesc" CHAR(50) , "jseq" INTEGER, PRIMARY KEY ( "jid" ) );
INSERT INTO "job" VALUES(101,'a-journalist',0);
INSERT INTO "job" VALUES(102,'b-doctor',1);
INSERT INTO "job" VALUES(103,'c-fireman',2);
INSERT INTO "job" VALUES(104,'d-Musician',3);
INSERT INTO "job" VALUES(105,'new',4);
DROP TABLE IF EXISTS "sqlite_sequence";
CREATE TABLE sqlite_sequence(name,seq);
INSERT INTO "sqlite_sequence" VALUES('tbl_user',21);
DROP TABLE IF EXISTS "tbl_user";
CREATE TABLE tbl_user (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(128) NOT NULL,
    password VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL
);
INSERT INTO "tbl_user" VALUES(1,'test1','pass1','test1@example.com');
INSERT INTO "tbl_user" VALUES(2,'test2','pass2','test2@example.com');
INSERT INTO "tbl_user" VALUES(3,'test3','pass3','test3@example.com');
INSERT INTO "tbl_user" VALUES(4,'test4','pass4','test4@example.com');
INSERT INTO "tbl_user" VALUES(5,'test5','pass5','test5@example.com');
INSERT INTO "tbl_user" VALUES(6,'test6','pass6','test6@example.com');
INSERT INTO "tbl_user" VALUES(7,'test7','pass7','test7@example.com');
INSERT INTO "tbl_user" VALUES(8,'test8','pass8','test8@example.com');
INSERT INTO "tbl_user" VALUES(9,'test9','pass9','test9@example.com');
INSERT INTO "tbl_user" VALUES(10,'test10','pass10','test10@example.com');
INSERT INTO "tbl_user" VALUES(11,'test11','pass11','test11@example.com');
INSERT INTO "tbl_user" VALUES(12,'test12','pass12','test12@example.com');
INSERT INTO "tbl_user" VALUES(13,'test13','pass13','test13@example.com');
INSERT INTO "tbl_user" VALUES(14,'test14','pass14','test14@example.com');
INSERT INTO "tbl_user" VALUES(15,'test15','pass15','test15@example.com');
INSERT INTO "tbl_user" VALUES(16,'test16','pass16','test16@example.com');
INSERT INTO "tbl_user" VALUES(17,'test17','pass17','test17@example.com');
INSERT INTO "tbl_user" VALUES(18,'test18','pass18','test18example.com');
INSERT INTO "tbl_user" VALUES(19,'test19','pass19','test19example.com');
INSERT INTO "tbl_user" VALUES(20,'test20','pass20','test20@example.com');
INSERT INTO "tbl_user" VALUES(21,'test21','pass21','test21@example.com');
