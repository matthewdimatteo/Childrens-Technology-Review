<?php
require_once 'FileMaker.php';

$fmPDF = new FileMaker();
$fmPDF->setProperty('database', 'CSR');
$fmPDF->setProperty('username', 'webctr');
$fmPDF->setProperty('password', 'webctrpassword');
$fmPDF->setProperty('hostspec', 'http://fms5312.triple8.net');

if (isset($_GET['-url']))
{
	$url = $_GET['-url'];
	$url = substr($url, 0, strpos($url, "?"));
	$url = substr($url, strrpos($url, ".") + 1);
	header('Content-type: application/pdf');
	echo $fmPDF->getContainerData($_GET['-url']);
} // end if
if (FileMaker::isError ($fmPDF) ) { echo 'Error: '.$fmPDF->getMessage(); }
?>