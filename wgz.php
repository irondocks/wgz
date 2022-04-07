<?php
$time = time();
echo date("H:i:s",$time);

$infile = "enwik9";

$fp = fopen($infile,"r");
$read_ex = fread($fp,filesize($infile));

$outfile = "out.wgz";

touch($outfile);
unlink($outfile);
$diff = time();
echo date("H:i:s",time()-$time)."\r\n";

$gsize = 0; 

$each = [];
$eaA = [];
$m = 0;
$time = 0;
$b = "";
function convert(string $m, int $insert, array $binarr)
{
    // relegate to binary
    $x = 0;
    $f = "";
    $t = "";
    while (strlen($m) > $x)
    {
        $v = decbin($m[$x]);
        $t .= $v;
        while (strlen($t) > $insert-1 || ($t != "" && strlen($t) < $insert-1 && $x + 1 == strlen($m)))
        {
            $f_check = strlen($f);
            foreach ($binarr as $c)
            {
                if (substr($t,0,$insert) == ($c))
                {
                    $f .= "0";
                    break;
                }
                else
                {
                    $f .= "1";
                }
            }
            if (strlen($f) == $f_check)
                exit();
            $t = substr($t,$insert);
        }
        $x++;
    }

    $b = "";
    $f = str_split($f,8);
    foreach ($f as $r)
    {
        $b .= chr(bindec($r));
    }
    return $b;
}

$readin = str_split($read_ex,128);
$i = 0;
$j = 0;
$insert = 4;

for ($d = 1 ; $d <= pow(2,$insert) ; $d++)
{
    $binarr[] = decbin($d-1);
}
$b = "";
foreach ($readin as $m)
{
    $time++;
    $b = convert($m, $insert, $binarr);
    $i += strlen($m);
    $j++;
    $gsize += strlen($b);
    file_put_contents($outfile, $b, FILE_APPEND);
    if ($time%1000 == 0) echo round($gsize/$i*100,4)."% Compressed | ".round($j/count($readin)*100,2)."% Complete\r";
}
$diff2 = time();

echo round($gsize/$i*100,4)."% Compressed | ".round($j/count($readin)*100,2)."% Complete\r";
echo "\r\n".date("i:s",time()-$time);
file_put_contents($outfile, $b, FILE_APPEND);
//print_r($records);
// use date/time to get differences

?> 
