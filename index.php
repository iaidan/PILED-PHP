<?php

/*
 * Created by Aidan Taylor - www.aidantaylor.net
 *
 * Usage: PILED/<led number>
 * Returns: LED Status
 *
 * Usage: PILED/<led number>/<value (on/off)>
 * Returns: Output of setting the LED to value
 */

$path = str_replace("/", "", $_SERVER["SERVER_NAME"]);
$dir  = dirname($_SERVER["SCRIPT_NAME"]);
$dir  = (substr($dir, -1) == "/") ? substr($dir, 0, -1) : $dir;
$path = "//" . $path . $dir;

if (isset($_REQUEST["path"]) && !empty($_REQUEST["path"])) {
    $path = str_replace(".php", "", str_replace("./", "", $_REQUEST["path"]));
    $args = explode("/", path);
}

$leds = array(7, 0, 2, 1, 3, 4, 5, 6);

switch($args[0]) {
    case "led":
        if (!in_array($args[1], $leds)) {
            echo "LED does not exist.";
        }

        if (isset($args[2])) {
            if ($args[2] == "on" || $args[2] == true) {
                $value = 1;
            } else if ($args[2] == "off" || $args[2] == false) {
                $value = 0;
            } else {
                $value = $args[2];
            }

            exec("gpio mode {$args[1]} output");
            echo exec("gpio write {$args[1]} {$value}");
        } else {
            echo exec("gpio read {$args[1]}");
        }
        break;
    default:
        echo "PILED";
        break;
}
