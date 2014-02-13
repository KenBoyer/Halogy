<?php
// How to use Less PHP in a view(?):

$this->load->library('lessphp');

// Compile a string
$test = "body { a { color: red } }";
$css = $this->lessphp->object()->parse($test)

// Compile a file (has automatic cache functionality)
$this->lessphp->object()->compileFile('/static/css/site.less','/static/css/site.css');

// Latest documentation: TBD change to bootstrap.less
$less->compileFile("input.less");
