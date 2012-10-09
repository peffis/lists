<?php
	include("config.php");
	header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Listan</title>
    <link rel="stylesheet" type="text/css" href="css/default.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script type="text/javascript" src="json.js"></script> 
    <script type="text/javascript" 
    	    src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js">
    </script>
    
    <script type="text/javascript">
            /* <[!CDATA[ */
	    <?php
		      $link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD)
                         or die("Could not connect to database");
                      mysql_select_db(MYSQL_DB) or die( "Could not select database" );  
                  
                      $query = "SELECT * FROM lists";
                      $result = mysql_query($query);
                      $line = mysql_fetch_row($result);
		      $json_string = $line[0];
		      if ($json_string == 'undefined') {
		          print("var lists = [];\n");
	              } else {
                          print("var lists = JSON.parse('$json_string');\n");
		      }
		    ?>
	          /* ]]> */
    </script>                      

    <script type="text/javascript" src="c.js"></script>
  </head>
  <body>
    <!-- <div id="frame"> -->
       <div id="lists">
       </div> 
       <div class="list_add">Add list<br/><input id="new_list" class="add_list" type="text"/>
       <img id="addlist" src="images/add.png" alt="add list" title="add list"/></div>
       
    <!-- </div> -->
    <!--
    <div class="footer">Copyright &#169; 2010, <a href="http://hellkvist.org">Stefan</a> <a href="http://standingonabeach.com">Hellkvist</a><br/>Icons used on this page are created by <a href="http://www.deleket.com/">Deleket</a> <br/>and released under CC license</div>    
    -->
  </body>
</html>
