<?php 
// This application is the interface to collect English sentences source
// modify.php is called to collect the resources from the source.

// Load XML file
$xml = new DOMDocument;
$xml->load('memo.xml');

// Load XSL file
$xsl = new DOMDocument;
$xsl->load('memo.xsl');

// Configure the transformer
$proc = new XSLTProcessor;

// Attach the xsl rules
$proc->importStyleSheet($xsl);

// Set parameter for xsl transform
$proc->setParameter('', 'modified', "Source collecting");

// The result
echo $proc->transformToXML($xml);
?>