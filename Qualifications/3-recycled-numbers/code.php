<?php

// Here starts the magic
$fh = fopen('input', 'r');
$tests = fgets($fh);
$c = 1;

while (!feof($fh)) {
    $line = fgets($fh);

    if (empty($line)) {
        break;
    }

    $chunks = explode(" ", $line);
    $min = $chunks[0];
    $max = $chunks[1];
    
    $combs = generate_combs($min, $max);;
    $rc    = calculate_rc($combs);
    
    echo "Case #$c: " . count($rc) . "\n";
    $c++;
}

function calculate_rc($combs)
{
    $rc = array();
    foreach($combs as $number => $comb)
    {
        $max = count($comb);
        for($i=0; $i < $max - 1; $i++)
        {
            for($j= $i + 1; $j < $max; $j++ )
            {
                $n = $comb[$i];
                $m = $comb[$j];

                if(recycled_numbers($n, $m))
                {
                    $rc[] = array($n, $m);
                }
            }
        }
    }
    
    return $rc;
}

function generate_combs($min, $max)
{
   for($i=$min; $i <= $max; $i++)
    {
        $numbers[] = $i;
    }

    // Group the numbers
    foreach($numbers as $number)
    {
        $arr = str_split($number);
        sort($arr);
        $index = implode('', $arr) + 0;
        $combs[$index][] = str_split($number);
    }


    // Do some cleaning up
    foreach($combs as $key => $value)
    {
        if(count($value) == 1)
        {
            unset($combs[$key]);
        }
    }
    
    return $combs;
}

function recycled_numbers($n, $m)
{  
    $digits = count($n);
    for($i= 1; $i < $digits; $i++)
    {
        $first  = array_slice($n, -1 * $i , $i);
        $last   = array_slice($n,  0, $digits - $i);
        $fusion = array_merge($first, $last);
        if($fusion == $m)
        {
            return true;
        }
    }
    
    return false;
}
