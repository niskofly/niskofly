<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $module dektrium\user\Module
 */

?>

<?php if ($module->enableFlashMessages): ?>
    <div class="row" style="margin-left: 0;margin-right: 0;">
        <div class="col-xs-12">
            <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
                <?php if (in_array($type, ['success', 'danger', 'warning', 'info'])): ?>
                    <div class="alert alert-<?= $type ?>">
                        <?= $message ?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>