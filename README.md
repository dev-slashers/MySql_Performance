## Example Project  to test MySQL Performance 


##### How to setup  

## create table on Database
```
CREATE TABLE prova(
 id int not null PRIMARY KEY AUTO_INCREMENT,
 name varchar(50) DEFAULT null,
 surname varchar(50) DEFAULT null
);
```

### Configure DB Param in 
```
lib/queryHelper.php
```