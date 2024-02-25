<?php
  libxml_disable_entity_loader (true);

  $xmlfile = file_get_contents('php://input');
  $dom = new DOMDocument();

  $dom->loadXML($xmlfile, LIBXML_NOENT);

echo $dom->textContent;

?>
