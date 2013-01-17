<?php
include("config.php");



$link = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD)
                 or die("Could not connect to database");
mysql_select_db(MYSQL_DB) or die( "Could not select database" );	

mysql_query("LOCK TABLES lists WRITE;");


if (!function_exists('http_response_code')) {
        function http_response_code($code = NULL) {

            if ($code !== NULL) {

                switch ($code) {
                    case 100: $text = 'Continue'; break;
                    case 101: $text = 'Switching Protocols'; break;
                    case 200: $text = 'OK'; break;
                    case 201: $text = 'Created'; break;
                    case 202: $text = 'Accepted'; break;
                    case 203: $text = 'Non-Authoritative Information'; break;
                    case 204: $text = 'No Content'; break;
                    case 205: $text = 'Reset Content'; break;
                    case 206: $text = 'Partial Content'; break;
                    case 300: $text = 'Multiple Choices'; break;
                    case 301: $text = 'Moved Permanently'; break;
                    case 302: $text = 'Moved Temporarily'; break;
                    case 303: $text = 'See Other'; break;
                    case 304: $text = 'Not Modified'; break;
                    case 305: $text = 'Use Proxy'; break;
                    case 400: $text = 'Bad Request'; break;
                    case 401: $text = 'Unauthorized'; break;
                    case 402: $text = 'Payment Required'; break;
                    case 403: $text = 'Forbidden'; break;
                    case 404: $text = 'Not Found'; break;
                    case 405: $text = 'Method Not Allowed'; break;
                    case 406: $text = 'Not Acceptable'; break;
                    case 407: $text = 'Proxy Authentication Required'; break;
                    case 408: $text = 'Request Time-out'; break;
                    case 409: $text = 'Conflict'; break;
                    case 410: $text = 'Gone'; break;
                    case 411: $text = 'Length Required'; break;
                    case 412: $text = 'Precondition Failed'; break;
                    case 413: $text = 'Request Entity Too Large'; break;
                    case 414: $text = 'Request-URI Too Large'; break;
                    case 415: $text = 'Unsupported Media Type'; break;
                    case 500: $text = 'Internal Server Error'; break;
                    case 501: $text = 'Not Implemented'; break;
                    case 502: $text = 'Bad Gateway'; break;
                    case 503: $text = 'Service Unavailable'; break;
                    case 504: $text = 'Gateway Time-out'; break;
                    case 505: $text = 'HTTP Version not supported'; break;
                    default:
                        exit('Unknown http status code "' . htmlentities($code) . '"');
                    break;
                }

                $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

                header($protocol . ' ' . $code . ' ' . $text);

                $GLOBALS['http_response_code'] = $code;

            } else {

                $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

            }

            return $code;

        }
}


function get_latest() {
         $query = "SELECT * FROM lists ORDER BY updated DESC limit 1";
         $result = mysql_query($query);
         $line = mysql_fetch_row($result);
	 return $line[0];
}

function store_doc($doc) {
	$query = "INSERT INTO lists (lists, updated) VALUES('$doc', NOW())";
	mysql_query($query);
}


if (!isset($_POST['data'])) {
   mysql_query("UNLOCK TABLES;");
   exit("no variables set");
}


$data = strip_tags($_POST['data']);

$oldDoc = get_latest();
$newDoc = stripslashes($data);

if ($oldDoc != 'undefined') {
   $oldd = json_decode($oldDoc);
   $oldVersion = $oldd->version;
   $newd = json_decode($newDoc);
   $newVersion = $newd->version;  

   if ($oldVersion == ($newVersion - 1)) {
      store_doc($newDoc);
   } else {
      http_response_code(400);
   }
} else {
  store_doc($newDoc);
}

mysql_query("UNLOCK TABLES;");

?>
