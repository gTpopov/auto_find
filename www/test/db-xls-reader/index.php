<?php


define('U_READ', 1 << 0);   // 0001 -1 0011 -3
define('U_CREATE', 1 << 1); // 0010 -2 0101 -5
define('U_EDIT', 1 << 2);   // 0100 -4 1001 -9
define('U_DELETE', 1 << 3); // 1000 -8 10001 -17

$user_perm =  U_READ | U_DELETE; // можно читать и удалять

print 1 | 2 << 3;

//$bin = pack("nvn*",0x5722,0x1148, 65, 66); // запаковываем, согласно формату
//$var = bin2hex($bin); // перекодируем из шестнадцатеричного формата
//echo($bin);

// 110010    -50
// 1100100   -100
// 11001000  -200
// 110010000 -400

// 50 - 110010 - 0x32
// 52 - 110100 - 0x34
// 56 - 111000 - 0x38


//$bin = pack("v",0x32); // C - беззнаковый символ (char) bin(11010000) dec(208) hex(0xd0)


//$bin = pack("nvc*", 0x1234, 0x5678, 65, 66);
//$bin = pack("nvn*",0x5722,0x1148, 65, 66); // запаковываем, согласно формату
//$var = bin2hex($bin); // перекодируем из шестнадцатеричного формата
//echo($var);

//print_r($bin);
//print_r(unpack("C",$bin));

/*
echo chr(61); //Возвращает строку из одного символа, код которого задан аргументом ascii.
echo "<br>";
echo ord("="); //return ASCII cod
*/


/*
$data = file_get_contents('123.xls');
print $data;
*/
/*
$str = 'папа fan';
$data = explode(' ',$str);

$result = '';
foreach ($data as $person ){

    $result .= pack('a*', $person);
}

file_put_contents( __DIR__ . '/str.bin', $result, FILE_BINARY );


$filename =__DIR__ . '/str.bin';
//print filesize($filename);
$handle = fopen($filename,"rb");
$persons = array();
while (!feof($handle))
{
    $persons[] = unpack('a*', fread($handle, filesize($filename)));
}
fclose($handle);

print '<pre>';
var_dump($persons);
print '</pre>';
*/




// 0x2710 - 10000
// 0x32   - 50
// 0x33   - 51

//$bin = pack('VC2A*', 0x2710, 0x32, 0x33, '123456');
//print $bin;

//file_put_contents( __DIR__ . '/t.bin', $bin, FILE_BINARY );

/*
$data = file_get_contents( __DIR__ . '/t.bin' );
$array =  unpack('c*', $data );
print_r($array);
*/




/*
$filename = 'search.png';
print filesize($filename);

$result = '';
$handle=fopen($filename,"rb");

while (!feof($handle))
{
    $result .= pack('a*', fread($handle, filesize($filename)));
}
fclose($handle);
file_put_contents( __DIR__ . '/img.bin', $result, FILE_BINARY );
*/


//$file = '456.xlsx';
/*
$file ='img.bin';

header('Content-Type:text/plain');
$bitmap_file_header = ''; # 14 байт
$bitmap_info_header = ''; # 40 байт

$f = fopen($file, 'r');
$bitmap_file_header = fread($f, 14);
$bitmap_info_header = fread($f, 40);

# Type = 424d
$u_file_header = 'H4Type/VSize/v2Reserved/VOffBits';
$u_info_header = 'VSize/VWidth/VHeight/vPlanes/vBitCount/'
    . 'VCompression/VSizeImage/VXPelsPerMeter/'
    . 'VYPelsPerMeter/VClrUsed/VClrImportant';

$file_header = unpack($u_file_header, $bitmap_file_header);
$info_header = unpack($u_info_header, $bitmap_info_header);

print_r($file_header);
print_r($info_header);
*/






?>