<?php

#### DATABASE COMMUNICATION & ADDITIONAL SETTINGS
#
#   In case you would like to register these hits to a database,
#   these below settings will quickly allow you to do just that.
#   It is an easy way to monitor and register crawlers, data that
#   can be used for a variety of cases.
#
#   This script will collect the IP address, user agent and a timestamp,
#   which is the data you can store in your database.
#


## DATABASE SETTINGS
# If you want this script to register the crawler and store the
# IP and timestamp data to a database, set below value to 'true'.
$use_database = false;
#
# If this script is using a database, define its credentials.
$host         = "server.com";
$username     = "John_Doe";
$password     = "Password123";
$database     = "Database_Name";
#
# If you are using a database, define the table name
# and the column names for both the IP and timestamp value.
$table_name       = "crawlers";
$ip_column        = "ip_address";
$timestamp_column = "time";
$userAgent_column = "user_agent";


## TIMESTAMP SETTINGS
# Set the timezone for the timestamp.
# https://secure.php.net/manual/en/timezones.php
$timezone  = "Europe/Copenhagen";
#
# The output of the timestamp value.
# https://secure.php.net/manual/en/function.date.php
$timestamp = "d-m-Y H:i";


## REDIRECT SETTINGS
# If you, instead of messing with the crawler as this script is intended,
# decide to redirect any hits away to a different URL, this is possible
# too. Set the below value to 'true' to use the redirect function.
#
# If you've defined the database communication above, this script
# will first register and create the database row, before redirecting
# the crawler/user away to the defined URL.
$use_redirect = false;
#
# The URL that the crawler will be redirected to:
$redirect_url = "https://duckduckgo.com";


#
#   Below this point is the actually script functionality.
#   Possible settings for this script is define above this point.
#
#### END OF DATABASE COMMUNICATION AND ADDITIONAL SETTINGS



## Read the Simple English word list into an array.
$words    = array_map('str_getcsv', file('wordlist.csv'));
$words    = $words[0];

## Additional setting when using the database option.
if ($use_database) {
    @session_start();
    date_default_timezone_set($timezone);
}

## A function that will generate a random sentence of words.
function wordGenerator(int $length = 10) {
    global $words;
    $wlLength = sizeof($words) - 1;
    $sentence = "";
    while ($length--) {
        $wordNum   = rand(0, $wlLength);
        $sentence .= $words[$wordNum];
        $sentence .= " ";
    }
    return $sentence;
}

## A function that will generate a random string (one continuous word).
function randomString(int $length = 8) {
    $string  = "abcdefghijklmnopqrstuvwxyz";
    $string .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $string .= "0123456789";

    $str = "";
    for($i = 0; $i < $length; $i++){
        $pos  = rand(0, strLen($string) - 1);
        $str .= $string{$pos};
    }
    return $str;
}

## A function to catch the crawlers IP address.
function getIp() {
    $ipaddress = null;
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    return $ipaddress;
}

## A function that will create a timestamp.
function getTime() {
    global $timestamp;
    $date = date($timestamp);

    return $date;
}

function getUserAgent() {
    $userAgent = null;
    if (isset($_SERVER['HTTP_USER_AGENT']))
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

    return $userAgent;
}

## Depending above settings, save data to database.
if ($use_database && !isset($_SESSION['registered'])) {
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error)
        die("Connection failed: ".$conn->connect_error);

    $sql = "INSERT INTO ".$table_name."
                        (".$timestamp_column.", ".$ip_column.", ".$userAgent_column.")
                        VALUES (?, ?, ?)";
    $bind = $conn->prepare($sql);
    $bind->bind_param("sss", $time, $ip, $userAgent);

    $ip        = getIp();
    $time      = getTime();
    $userAgent = getUserAgent();
    $bind->execute();

    $bind->close();
    $conn->close();

    $_SESSION['registered'] = true;
}

## Depending on above settings, redirect the user/crawler away.
if ($use_redirect)
    header("location:".$redirect_url);

## Generate random meta data.
$title       = wordGenerator(rand(1, 7));
$description = wordGenerator(rand(5, 25));
$keywords    = wordGenerator(rand(5, 25));
$keywords    = str_replace(' ', ', ', $keywords);

## Generate random data for the view
$content     = wordGenerator(rand(100, 999));

## Create a couple of random looking hyperlinks.
$links       = "";
$linkCount   = rand(1, 10);
while ($linkCount--) {
    $links  .= '<a href="?'.randomString(rand(1, 100)).'='.randomString(rand(1, 100)).'"
                   title="'.wordGenerator(rand(1, 10)).'">'.wordGenerator(rand(1, 15)).'</a> <br>';
}


## HTML
echo'<!DOCTYPE html>';
echo'<html>';
echo'<head>';
    echo'<title>'.$title.'</title>';
    echo'<meta name="description" content="'.$description.'" />';
    echo'<meta name="keywords" content="'.$keywords.'" />';
echo'</head>';
echo'<body>';

    echo $links;
    echo $content;

echo'</body>';
echo'</html>';
?>
