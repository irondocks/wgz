<?php
$time = time();
echo date("H:i:s",$time);

$infile = "out4.txt";

$fp = fopen($infile,"r");
$read_ex = fread($fp,filesize($infile));

$outfile = "out.txt";

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

function backFire($read_ex)
{
    global $outfile;
    //echo $read_ex;
    $x = explode("0", $read_ex);
    $c = 0;
    $z = 0;
    $out = "";
    foreach ($x as $y)
    {
        if (strlen($out) == 128)
        {
            file_put_contents($outfile, $out, FILE_APPEND);
            return $out;
        }
        $z += strlen($y);
        if ($c%2 == 1) {
            $out .= chr($z);
            $z = 0;
        }
        $z <<= 4;
        $c++;
    }
    file_put_contents($outfile, $out, FILE_APPEND);
    return $out;
}

function convert(string $m, int $insert, array $binarr)
{
    // relegate to binary
    $x = 0;
    $f = "";
    $t = "";
    while (strlen($m) > $x)
    {
        $v = decbin(ord($m[$x]));
        $t .= substr($v,0,4);//str_repeat("0",4-strlen(substr($v,0,4))) . substr($v,0,4);
        $t .= substr($v,4);//str_repeat("0",4-strlen(substr($v,4))) . substr($v,4);
        $x++;
    }
    while ($t != "")
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

    $n = backFire($f);
    echo ".";
    if ($m != $n)
    {
        echo "\r\n$m\r\n$n\r\n";
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

for ($d = 0 ; $d < pow(2,$insert) ; $d++)
{
    $binarr[] = ($d == 0) ? str_repeat("0",$insert) : str_repeat("0",4-strlen(decbin($d))) . decbin($d);
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
