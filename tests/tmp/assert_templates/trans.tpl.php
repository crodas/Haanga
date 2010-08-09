<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/trans.tpl */
function haanga_8d35b55be0c9b118eda2226b6b520297156d8d6d($vars, $return=FALSE, $blocks=array())
{
    global $test_global;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo _('Translation').'
'.sprintf(_('Translation by %s'), 'cesar').'
'.htmlentities(_($text)).'
'.htmlentities(ucfirst(_($text))).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}