--TEST--
#79029 (Use After Free's in XMLReader / XMLWriter)
--EXTENSIONS--
xmlwriter
xmlreader
--FILE--
<?php
$x = array( new XMLWriter() );
$x[0]->openUri("bug79029_1.txt");
$x[0]->startComment();

$y = new XMLWriter();
$y->openUri("bug79029_2.txt");
fclose(@end(get_resources()));

file_put_contents("bug79029_3.txt", "a");
$z = new XMLReader();
$z->open("bug79029_3.txt");
fclose(@end(get_resources()));
?>
okey
--CLEAN--
<?php
@unlink("bug79029_1.txt");
@unlink("bug79029_2.txt");
@unlink("bug79029_3.txt");
?>
--EXPECTF--
Warning: fclose(): cannot close the provided stream, as it must not be manually closed in %sbug79029.php on line %d

Warning: fclose(): cannot close the provided stream, as it must not be manually closed in %sbug79029.php on line %d
okey
