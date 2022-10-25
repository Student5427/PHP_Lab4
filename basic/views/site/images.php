<table class = "table">
<tr><th>ID</th><th>File_Name</th><th>Caption</th></th>
<?php
use yii\widgets\LinkPager;
foreach ($images as $img)
{
echo "<tr>";
    echo "<td>{$img['id']}</td>";
    echo "<td>{$img['name']}</td>";
    echo "<td>{$img['caption']}</td>";
echo "</tr>";
} 
?>
</table> 