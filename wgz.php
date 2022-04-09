<?php
$time = time();
//echo date("H:i:s",$time);

$infile = "out4.txt";

$fp = fopen($infile,"r");
$read_ex = fread($fp,filesize($infile));

$outfile = "out.txt";

touch($outfile);
unlink($outfile);

$zipfile = "zip.txt";

touch($zipfile);
unlink($zipfile);
$diff = time();
echo date("s",time()-$time)."\r\n";

$gsize = 0; 

$each = [];
$eaA = [];
$m = 0;
$time = 0;
$b = "";
$byte_saturation = 32;

function backFire($read_ex)
{
    global $outfile;
    global $byte_saturation;
    //echo $read_ex;
    $x = explode("0", $read_ex);
    $c = 0;
    $z = 0;
    $out = "";
    $t = [];
    foreach ($x as $y)
        $t[] = (strlen($y) == 0 || $y == "") ? 0 : strlen($y);
    foreach ($t as $y)
    {
        $z <<= 4;
        $z += ($y);
        if ($c%2 == 1) {
            $out .= chr($z%256);
            $z = 0; 
        }
        $c++;
        if (strlen($out) == $byte_saturation)
        {
            file_put_contents($outfile, $out, FILE_APPEND);
            return array_slice($x,$c);
        }
    }
    file_put_contents($outfile, $out, FILE_APPEND);
    return [];
}

function convert(string $m, int $insert, array $binarr)
{
    global $zipfile;
    global $outfile;
    // relegate to binary
    $x = 0;
    $f = "";
    $t = "";
    while (strlen($m) > $x)
    {
        $v = decbin(ord($m[$x]));
        $t .= str_repeat("0",8-strlen($v)) . ($v);
        //$t .= str_repeat("0",4-strlen(substr($v,4))) . substr($v,4);
        $x++;
    }
    while ($t != "")
    {
        $f_check = strlen($f);
        foreach ($binarr as $c)
        {
            if (bindec(substr($t,0,$insert)) == bindec($c))
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

    //$n = backFire($f);
    $b = "";
    $f = str_split($f,8);
    foreach ($f as $r)
    {
        $b .= chr(bindec($r));
    }
    file_put_contents($zipfile, $b, FILE_APPEND);
    return implode("",$n);
}

$readin = str_split($read_ex,$byte_saturation);

$i = 1;
$j = 0;
$insert = 4;

for ($d = 0 ; $d < pow(2,$insert) ; $d++)
{
    $binarr[] = str_repeat("0",4-strlen(decbin($d))) . decbin($d);
}
$b = "";
foreach ($readin as $m)
{
    $time++;
    do
    {
        $b = convert($m, $insert, $binarr);
        $m = $b;
    } while (strlen($b) > 0);

    $i += strlen($m);
    $j++;
    $gsize += strlen($b);
    file_put_contents($outfile, $b, FILE_APPEND);
    if ($time%1000 == 0) echo round($gsize/$i*100,4)."% Compressed | ".round($j/count($readin)*100,2)."% Complete\r";
}
$diff2 = time();

echo round($gsize/$i*100,4)."% Compressed | ".round($j/count($readin)*100,2)."% Complete\r";
echo "\r\n".date("i:s",time()-$time);
//print_r($records);
// use date/time to get differences

?> 
