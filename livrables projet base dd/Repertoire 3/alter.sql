use instagram;

create table FILES (
  file_id int primary key not null AUTO_INCREMENT,
  file_name VARCHAR(255) DEFAULT NULL,
  file_path VARCHAR(255) DEFAULT NULL,
  file LONGBLOB DEFAULT NULL
);



alter table POSTS drop image_url;
alter table POSTS add image_id int DEFAULT NULL;
alter table POSTS add constraint FK_FILEPOST foreign key (image_id) references FILES(file_id);

alter table STORIES drop image_url;
alter table STORIES add image_id int DEFAULT NULL;
alter table STORIES add constraint FK_FILESTORIES foreign key (IMAGE_ID) references FILES(FILE_ID);

alter table USER drop profile_picture;
alter table USER add  image_id int DEFAULT NULL;
alter table USER add constraint FK_FILEUSER foreign key (IMAGE_ID) references FILES(FILE_ID);




     


