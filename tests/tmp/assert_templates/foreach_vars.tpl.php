<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/foreach_vars.tpl */
function haanga_a6632e6016b7fd6dac1f8c9fdbeb007fa154dfb9($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo '<div class=\'container\'>
';
    foreach ($categoriesArray as  $category) {
        echo '
        <div class=\'mainCategoryList\'>'.htmlspecialchars($category['cat']['categoria']).'
                <ul>
                ';
        $forcounter1_2  = 1;
        $psize_2  = count($category['subCategories']);
        $islast_2  = ($forcounter1_2 == $psize_2);
        foreach ($category['subCategories'] as  $secondaryCategory) {
            echo '
                        <li class=\'secondaryCategoryList\'>
                        ';
            if (empty($islast_2) === FALSE) {
                echo '
                                '.htmlspecialchars($secondaryCategory['categoria']).'</li>
                        ';
            } else {
                echo '
                                '.htmlspecialchars($secondaryCategory['categoria']).',</li>
                        ';
            }
            echo '
                ';
            $forcounter1_2  = ($forcounter1_2 + 1);
            $islast_2  = ($forcounter1_2 == $psize_2);
        }
        echo '
                </ul>
        </div>
';
    }
    echo '
</div>
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}