<?php

$this->title = Yii::t('hipanel:certificate', 'Issue certificate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:certificate', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_issueForm', compact('model', 'models', 'webserverTypes')) ?>