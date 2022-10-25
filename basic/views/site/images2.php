<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\LinkPager;
use yii\helpers\Html;

echo Html::a("Add image", ["add"], ['class' => 'btn btn->info']);

echo GridView::widget(['dataProvider' => $dataProvider,
'layout'=> "{items}\n {pager}",
'columns' => ['id', 'name', 'caption',['class' => ActionColumn::class,
'template' => '{view} {update} {delete} {link}',]]]);

//echo LinkPager::widget(['pagination' => $pagination]);

?>
