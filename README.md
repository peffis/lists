lists
=====

A simple tool for managing online lists (such as todo lists, grocery
store lists etc) 



WHAT IS IT?
-----------
It is a very simple thing - a tool for handling lists online (such as
lists on what to buy in the store, todo lists etc). We use it at home
as we find it conveniant to be able to access it from anywhere and
avoid needing to write notes on paper that are exclusive to one person
in the house. The user interface is made small to be easy to use on even small
mobile devices. 

SCREEN SHOT
-----------
![screenshot](https://github.com/peffis/lists/blob/master/screenshot.png)


INSTALLING SOFTWARE
-------------------
1) Copy the content of the www folder to your php enabled web root (such
as /var/www) or to a subfolder under the web root (such as
/var/www/the_list)

2) If you want to keep others from pokeing/peeking at your list
you should password protect the folder (see your web server manual or
your web hosting company's control panel) because the software itself
does not care about authentication/authorization. 

3) Make sure the web server is php enabled. 



SETTING UP MYSQL DB
-------------------

1) Create a database in mysql called 'the_list' (use some admin tool or
"create database the_list;" in mysql - whatever you prefer)

2) Create a mysql user "list_user" with password and grant full access to 
'the_list' to this user (use some admin tool or "grant all on
the_list.* to 'list_user'@'%' identified by 'your password';" in mysql
- whatever you prefer)

3) Edit config.php so that the variable MYSQL_PWD matches whatever
password you used in step 2

4) Create a table in the list database you created in step 1 (use some
admin tool or do "CREATE TABLE 'lists' ('lists' text NOT NULL);" in
mysql) as the user you created in step 2. It is a simple table with
one column of type text. The name of the column should be 'lists'. No
other database schema is being used currently in this project. In
fact, since the JSON object is written in text into this field it
would be possible to replace the mysql dependency completely with a
write to a file in the file system. 


Acknowledgements
----------------
The icons found in the images folder are created by Deleket - 
http://www.deleket.com/ and released under CC license. 



Kind regards,
Stefan Hellkvist