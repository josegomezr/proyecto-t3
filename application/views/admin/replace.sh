STR="<div class='col-xs-12'>
	<img src='http://lorempixel.com/1200/150' alt='membrete' id='membrete' class='img-responsive'>
</div>
<p>&nbsp;</p>";

grep -ril 'membrete' "admin/" | xargs sed -i 's///g' 