-- DROPS ALL TABLES IF NECCESSARY ----------------------------------------------
DROP TABLE likes;
DROP TABLE comments;
DROP TABLE savedposts;
DROP TABLE directmessages;
DROP TABLE followers;
DROP TABLE posts;
DROP TABLE users;




-- CREATION DES TYPES ----------------------------------------------------------

-- --------------------- !! EXECUTE ONE AT TIME !! -----------------------------

-- STORY TYPE
CREATE OR REPLACE TYPE story_type AS OBJECT (
    DATETIME_ADDED DATE,
    IMAGE_URL CLOB,
    CAPTION CLOB
);
CREATE OR REPLACE TYPE story_table AS TABLE OF story_type; --  NESTED TABLE (STORIES)

-- USER TYPE
CREATE OR REPLACE TYPE user_type AS OBJECT (
  USER_ID number(20),
  USERNAME VARCHAR2(40 CHAR),
  EMAIL VARCHAR2(50 CHAR),
  PASSWORD VARCHAR2(20 CHAR),
  BIO CLOB,
  CITY VARCHAR2(20 CHAR),
  PROFILE_PICTURE CLOB,
  STORIES story_table
);

-- HASHTAG TYPE
CREATE OR REPLACE TYPE hashtag_type AS OBJECT (hashtag CLOB);
CREATE OR REPLACE TYPE hashtag_table AS TABLE OF hashtag_type; -- NESTED TABLE (HASHTAGS)

-- POST TYPE
CREATE OR REPLACE TYPE post_type AS OBJECT (
    POST_ID VARCHAR2(40 CHAR),
    USER_ID number(20),
    DATETIME_ADDED DATE,
    IMAGE_URL CLOB,
    CAPTION CLOB,
    HASHTAGS hashtag_table
);

-- COMMENT TYPE
CREATE OR REPLACE TYPE comment_type AS OBJECT (
    COMMENTED_BY number(20),
    POST_ID VARCHAR2(40 CHAR),
    DATETIME_ADDED DATE,
    COMMENTS CLOB       
);

-- LIKE TYPE
CREATE OR REPLACE TYPE like_type AS OBJECT(
    LIKED_BY number(20),
    POST_ID VARCHAR2(40 CHAR),
    DATETIME_ADDED DATE
);

-- SAVEDPOST TYPE
CREATE OR REPLACE TYPE savedpost_type AS OBJECT(
    SAVED_BY number(20),
    POST_ID VARCHAR2(40 CHAR),
    DATETIME_ADDED DATE   
);

-- FOLLOWERS TYPE
CREATE OR REPLACE TYPE followers_type AS OBJECT(
    USER_ID number(20),
    FOLLOWING_USER_ID number(20),
    DATETIME_ADDED DATE   
);

-- DIRECT MESSAGE TYPE
CREATE OR REPLACE TYPE directmessage_type AS OBJECT (
    SENDER_ID number(20),
    RECEIVER_ID number(20),
    MESSAGE CLOB,       
    DATETIME_ADDED DATE
);




-- CREATION DES TABLES ---------------------------------------------------------

-- USERS TABLE
CREATE TABLE users OF user_type (
  USER_ID NOT NULL,
  USERNAME DEFAULT NULL,
  EMAIL DEFAULT NULL,
  PASSWORD DEFAULT NULL,
  BIO DEFAULT NULL,
  CITY NOT NULL,
  PROFILE_PICTURE DEFAULT NULL,
  STORIES DEFAULT NULL,
  PRIMARY KEY (USER_ID)
)
NESTED TABLE STORIES STORE AS tab_story;


-- POSTS TABLE
CREATE TABLE posts OF post_type (
    POST_ID NOT NULL,
    USER_ID NOT NULL,
    DATETIME_ADDED DEFAULT NULL,
    IMAGE_URL DEFAULT NULL,
    CAPTION DEFAULT NULL,
    HASHTAGS DEFAULT NULL,
    PRIMARY KEY (POST_ID)
)
NESTED TABLE HASHTAGS STORE AS tab_hashtag;

-- COMMENTS TABLE
CREATE TABLE comments OF comment_type (
    COMMENTED_BY NOT NULL,
    POST_ID NOT NULL,
    DATETIME_ADDED DEFAULT NULL,
    COMMENTS NOT NULL 
);

-- LIKES TABLE
CREATE TABLE likes OF like_type(
    LIKED_BY NOT NULL,
    POST_ID NOT NULL,
    DATETIME_ADDED DEFAULT NULL
);

-- SAVED POST TABLE
CREATE TABLE savedposts OF savedpost_type(
    SAVED_BY NOT NULL,
    POST_ID NOT NULL,
    DATETIME_ADDED DEFAULT NULL
);

-- FOLLOWERS TABLE
CREATE TABLE followers OF followers_type(
    USER_ID NOT NULL,
    FOLLOWING_USER_ID NOT NULL,
    DATETIME_ADDED DEFAULT NULL
);

-- DIRECT MESSAGE TABLE
CREATE TABLE directmessages OF directmessage_type(
    SENDER_ID NOT NULL,
    RECEIVER_ID NOT NULL,
    MESSAGE NOT NULL,       
    DATETIME_ADDED DEFAULT NULL
);



-- CONSTRAINTS:  ---------------------------------------------------------------

-- POSTS
alter table posts add CONSTRAINT fk_userpost FOREIGN KEY (user_id)
REFERENCES users(user_id);

-- COMMENTS
alter table comments add CONSTRAINT fk_usercomment FOREIGN KEY (commented_by)
REFERENCES users(user_id);
alter table comments add CONSTRAINT fk_postcomment FOREIGN KEY (post_id)
REFERENCES posts(post_id);

-- LIKES
alter table likes add CONSTRAINT fk_userlike FOREIGN KEY (liked_by)
REFERENCES users(user_id);
alter table likes add CONSTRAINT fk_postlike FOREIGN KEY (post_id)
REFERENCES posts(post_id);

-- SAVED POSTS
alter table savedposts add CONSTRAINT fk_usersaved FOREIGN KEY (saved_by)
REFERENCES users(user_id);
alter table savedposts add CONSTRAINT fk_postsaved FOREIGN KEY (post_id)
REFERENCES posts(post_id);

-- FOLLOWERS
alter table followers add CONSTRAINT fk_userfollowers1 FOREIGN KEY (user_id)
REFERENCES users(user_id);
alter table followers add CONSTRAINT fk_userfollowers2 FOREIGN KEY (FOLLOWING_USER_ID)
REFERENCES users(user_id);

-- DIRECT MESSAGE
alter table directmessages add CONSTRAINT fk_usermessage1 FOREIGN KEY (SENDER_ID)
REFERENCES users(user_id);
alter table directmessages add CONSTRAINT fk_usermessage2 FOREIGN KEY (RECEIVER_ID)
REFERENCES users(user_id);





