<?php

// Warming up the mapper 
$lang_go = "y qee ejp mysljylc kd kxveddknmc re jsicpdrysi rbcpc ypc rtcsra dkh wyfrepkym veddknkmkrkcd de kr kd eoya kw aej tysr re ujdr lkgc jv";
$lang_en = "a zoo our language is impossible to understand there are twenty six factorial possibilities so it is okay if you want to just give up";

$lang_go = str_replace(' ','',$lang_go);
$lang_en = str_replace(' ','',$lang_en);

$arr_go = str_split(strtolower($lang_go));
$arr_en = str_split(strtolower($lang_en));

$chars = array();
for ($i=97; $i<=122; $i++) {
 $chars[] = chr($i);
}

$mapper = array();
$mapper['z'] = 'q'; // This has to be hardcoded as it's the only one not present in the text.

foreach($arr_go as $key => $char_go)
{
  $char_en = $arr_en[$key];
  $mapper[$char_go] = $char_en;
}


// Here starts the magic
$output = '';

$fh    = fopen('input', 'r');
$tests = fgets($fh);
$j = 1;

while(!feof($fh))
{
  $txt = fgets($fh);
  $arr = str_split(strtolower($txt));

  if(empty($txt))
  {
    break;
  }

  $output .= "Case #$j: ";
  foreach($arr as $char)
  {
    if(in_array($char, $chars))
    {
      $output .= $mapper[$char];
    }else{
      $output .= $char;
    }
  }
  $j++;
}

echo $output;
