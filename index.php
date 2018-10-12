<?php

## A model to generate random strings.
include('assets/models/random.php');
$rand     = new Random();

## Read the Simple English word list into an array.
global $words;
$words    = array_map('str_getcsv', file('assets/wordlist.csv'));
$words    = $words[0];

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
        $pos = rand(0, strLen($string) - 1);
        $str .= $string{$pos};
    }
    return $str;
}


#### META / HEADER (<head> element) DATA
## Create a couple of random keywords for the <head> tag.
$keywords = wordGenerator();
$keywords = str_replace(' ', ', ', $keywords);

## Create a random title.
$title = wordGenerator();

## Create a random description.
$description  = wordGenerator();
#### END META DATA


#### DATA FOR THE VIEW
## Create a couple of random looking hyperlinks.
$links      = "";
$linkCount  = rand(1, 10);
while ($linkCount--) {
    $links  .= '<a href="?'.randomString(rand(1, 100)).'='.randomString(rand(1, 100)).'"
                   title="'.wordGenerator().'">'.wordGenerator().'</a> <br>';
}

## Create random content
$content = wordGenerator(rand(100, 999));
#### END DATA FOR THE VEIW



#### START OF HTML DOCUMENT

echo'<!DOCTYPE html>';
echo'<html lang="da">';
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
