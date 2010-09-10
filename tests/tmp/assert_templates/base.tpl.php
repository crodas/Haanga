<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/base.tpl */
function haanga_d2f931b3242b3187b9a3d407f38c7d9d691df84f($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<html>
<head>
    <title>';
    $buffer1  = 'Default Title';
    echo (isset($blocks['title']) ? (strpos($blocks['title'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['title'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['title'])) : $buffer1).'</title>
</head>

<body>
    <h1>Menu</h1>
    ';
    $buffer1  = '
    <ul>
        ';
    foreach ($menu as  $item) {
        $buffer1 .= '
            <li><a href="'.$item['url'].'">'.htmlspecialchars($item['name']).'</a></li>
        ';
    }
    $buffer1 .= '
    </ul>
    ';
    echo (isset($blocks['main.menu']) ? (strpos($blocks['main.menu'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['main.menu'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['main.menu'])) : $buffer1).'
    ';
    $buffer1  = ''.Haanga::Load('assert_templates/partial.tpl', $vars, TRUE, $blocks);
    echo (isset($blocks['main.include-end']) ? (strpos($blocks['main.include-end'], '{{block.1b3231655cebb7a1f783eddf27d254ca}}') === FALSE ? $blocks['main.include-end'] : str_replace('{{block.1b3231655cebb7a1f783eddf27d254ca}}', $buffer1, $blocks['main.include-end'])) : $buffer1).'
</body>
</html>
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}