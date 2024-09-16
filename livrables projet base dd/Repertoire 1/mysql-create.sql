drop database instagram;
create database instagram;
use instagram ;

drop table if exists COMMENTS;

drop table if exists DIRECTMESSAGES;

drop table if exists FOLLOWERS;

drop table if exists HASHTAGMAPPINGS;

drop table if exists HASHTAGS;

drop table if exists LIKES;

drop table if exists POSTS;

drop table if exists SAVEDPOSTS;

drop table if exists STORIES;

drop table if exists USER;

/*==============================================================*/
/* Table : COMMENTS                                             */
/*==============================================================*/
create table COMMENTS
(
   USER_ID              bigint not null,
   POST_ID              CHAR(38) not null,
   DATETIME_ADDED       datetime,
   COMMENTS             text,
   primary key (USER_ID, POST_ID)
);

/*==============================================================*/
/* Table : DIRECTMESSAGES                                       */
/*==============================================================*/
create table DIRECTMESSAGES
(
   USER_ID              bigint not null,
   USE_USER_ID          bigint not null,
   MESSAGE              text,
   DATETIME_SENT        datetime,
   primary key (USER_ID, USE_USER_ID)
);

/*==============================================================*/
/* Table : FOLLOWERS                                            */
/*==============================================================*/
create table FOLLOWERS
(
   USER_ID              bigint not null,
   USE_USER_ID          bigint not null,
   DATETIME_ADDED       datetime,
   primary key (USER_ID, USE_USER_ID)
);

/*==============================================================*/
/* Table : HASHTAGMAPPINGS                                      */
/*==============================================================*/
create table HASHTAGMAPPINGS
(
   POST_ID              CHAR(38) not null,
   HASHTAG_ID           int not null,
   DATETIME_ADDED       datetime,
   primary key (POST_ID, HASHTAG_ID)
);

/*==============================================================*/
/* Table : HASHTAGS                                             */
/*==============================================================*/
create table HASHTAGS
(
   HASHTAG_ID           int not null AUTO_INCREMENT,
   HASHTAG              text,
   primary key (HASHTAG_ID)
);

/*==============================================================*/
/* Table : LIKES                                                */
/*==============================================================*/
create table LIKES
(
   USER_ID              bigint not null,
   POST_ID              CHAR(38) not null,
   DATETIME_ADDED       datetime,
   primary key (USER_ID, POST_ID)
);

/*==============================================================*/
/* Table : POSTS                                                */
/*==============================================================*/
create table POSTS
(
   POST_ID              CHAR(38) not null,
   USER_ID              bigint not null,
   DATETIME_ADDED       datetime,
   IMAGE_URL            text,
   CAPTION              text,
   primary key (POST_ID)
);

/*==============================================================*/
/* Table : SAVEDPOSTS                                           */
/*==============================================================*/
create table SAVEDPOSTS
(
   USER_ID              bigint not null,
   POST_ID              CHAR(38) not null,
   DATETIME_ADDED       datetime,
   primary key (USER_ID, POST_ID)
);

/*==============================================================*/
/* Table : STORIES                                              */
/*==============================================================*/
create table STORIES
(
   STORY_ID             CHAR(38) not null,
   USER_ID              bigint not null,
   DATATIME_ADDED       datetime,
   IMAGE_URL            text,
   CAPTION              text,
   primary key (STORY_ID)
);

/*==============================================================*/
/* Table : USER                                                 */
/*==============================================================*/
create table USER
(
   USER_ID              bigint not null AUTO_INCREMENT,
   USERNAME             varchar(50),
   EMAIL                varchar(50),
   PASSWORD             varchar(50),
   BIO                  text,
   CITY                 varchar(20), -- THIS ATTRIBUTE IS ONLY FOR TESTING PURPOSES
   PROFILE_PICTURE      text,
   primary key (USER_ID)
);

alter table COMMENTS add constraint FK_COMMENTS foreign key (POST_ID)
      references POSTS (POST_ID) on delete restrict on update restrict;

alter table COMMENTS add constraint FK_COMMENTS2 foreign key (USER_ID)
      references USER (USER_ID) on delete restrict on update restrict;

alter table DIRECTMESSAGES add constraint FK_DIRECTMESSAGES foreign key (USE_USER_ID)
      references USER (USER_ID) on delete restrict on update restrict;

alter table DIRECTMESSAGES add constraint FK_DIRECTMESSAGES2 foreign key (USER_ID)
      references USER (USER_ID) on delete restrict on update restrict;

alter table FOLLOWERS add constraint FK_FOLLOWERS foreign key (USE_USER_ID)
      references USER (USER_ID) on delete restrict on update restrict;

alter table FOLLOWERS add constraint FK_FOLLOWERS2 foreign key (USER_ID)
      references USER (USER_ID) on delete restrict on update restrict;

alter table HASHTAGMAPPINGS add constraint FK_HASHTAGMAPPINGS foreign key (HASHTAG_ID)
      references HASHTAGS (HASHTAG_ID) on delete restrict on update restrict;

alter table HASHTAGMAPPINGS add constraint FK_HASHTAGMAPPINGS2 foreign key (POST_ID)
      references POSTS (POST_ID) on delete restrict on update restrict;

alter table LIKES add constraint FK_LIKES foreign key (POST_ID)
      references POSTS (POST_ID) on delete restrict on update restrict;

alter table LIKES add constraint FK_LIKES2 foreign key (USER_ID)
      references USER (USER_ID) on delete restrict on update restrict;

alter table POSTS add constraint FK_USERPOST foreign key (USER_ID)
      references USER (USER_ID) on delete restrict on update restrict;

alter table SAVEDPOSTS add constraint FK_SAVEDPOSTS foreign key (POST_ID)
      references POSTS (POST_ID) on delete restrict on update restrict;

alter table SAVEDPOSTS add constraint FK_SAVEDPOSTS2 foreign key (USER_ID)
      references USER (USER_ID) on delete restrict on update restrict;

alter table STORIES add constraint FK_USERSTORY foreign key (USER_ID)
      references USER (USER_ID) on delete restrict on update restrict;