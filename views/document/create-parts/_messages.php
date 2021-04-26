<?php

use yii\bootstrap\Alert;

foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    if (Yii::$app->getSession()->hasFlash($key)) {
        echo Alert::widget([
            'options' => [
                'class' => (in_array($key, ['success', 'info', 'warning', 'danger']) ? 'alert-' . $key : 'alert-info'),
            ],
            'body' => $message,
        ]);
    }
}
?>