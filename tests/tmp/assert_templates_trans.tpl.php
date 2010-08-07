<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/trans.tpl */
function haanga_aa7b9e1c49975e4203b4582c3d9e1367dc5fe05b($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo _("Translation")."\n".sprintf(_("Translation by %s"), "cesar")."\n".htmlentities(_($text))."\n".htmlentities(ucfirst(_($text)))."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}