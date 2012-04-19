<?php

function debug($txt) {
    $debug = false;
    if ($debug) {
        echo $txt . "\n\r";
    }
}

function generate_triplets() {
    $triplets = array();

    for ($i = 0; $i <= 10; $i++) {
        for ($j = 0; $j <= 10; $j++) {
            for ($k = 0; $k <= 10; $k++) {
                $score = $i + $j + $k;
                $triplet = array($i, $j, $k);

                $nmax = max($triplet);
                $nmin = min($triplet);

                if ($nmax - $nmin > 2) {
                    continue;
                }

                sort($triplet);

                if ($nmax - $nmin == 2) {
                    $triplets[$score]['max_surprise'] = $nmax;
                } else {
                    $triplets[$score]['max_regular'] = $nmax;
                }

                if (!isset($triplets[$score]['combs'])) {
                    $triplets[$score]['combs'][] = $triplet;
                } elseif (!in_array($triplet, $triplets[$score]['combs'])) {
                    $triplets[$score]['combs'][] = $triplet;
                }
            }
        }
    }
    
    return $triplets;
}

function number_of_googlers($line) {
    global $triplets;
    $arr = explode(" ", $line);

    $nels = $arr[0];
    $surp = $arr[1];
    $best = $arr[2];

    $scores = array_slice($arr, 3);

    // Eliminamos aquellos que pasan el criterio sin necesidad de una puntuacion sorpresa
    foreach ($scores as $key => $score) {
        $score = $score + 0;
        if (isset($triplets[$score]['max_regular']) && $triplets[$score]['max_regular'] >= $best) {
            debug("Sin sorpresa: Elimando $score");
            unset($scores[$key]);
        }
    }

    // Elimimanos tantos como podamos que permitan una puntuacion sorpresa
    if ($surp > 0) {
        $surp_used = 0;

        foreach ($scores as $key => $score) {
            $score = $score + 0;
            debug("Sorpresas $surp_used/$surp");
            if ($surp_used >= $surp) {
                break;
            }

            if (isset($triplets[$score]['max_surprise']) && $triplets[$score]['max_surprise'] >= $best) {
                debug("Con sorpresa: Elimando $score");
                unset($scores[$key]);
                $surp_used++;
            }
        }
    }

    return $nels - count($scores);
}

// Here starts the magic
$fh = fopen('input', 'r');
$tests = fgets($fh);
$c = 1;

$triplets = generate_triplets();
while (!feof($fh)) {
    $line = fgets($fh);

    if (empty($line)) {
        break;
    }

    echo "Case #$c: " . number_of_googlers($line) . "\n";
    $c++;
}