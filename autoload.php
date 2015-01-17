<?php


/**
 * Autoload classes
 * @param string $className
 */
function gr_autoloader($className)
{
  $className = str_replace("\\", "/", $className);

  $fn = "classes/$className.php";
  if (file_exists($fn))
    include($fn);
}

spl_autoload_register('gr_autoloader');