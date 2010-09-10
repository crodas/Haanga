<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/trans.tpl */
function haanga_8d35b55be0c9b118eda2226b6b520297156d8d6d($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo _('Translation').'
'.sprintf(_('Translation by %s'), 'cesar').'
'.htmlspecialchars(_($text)).'
'.htmlspecialchars(ucfirst(_($text))).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}