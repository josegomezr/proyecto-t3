STR='<div class="col-xs-12">\n\t<img src="http://lorempixel.com/1200/150" alt="membrete" id="membrete" class="img-responsive">\n</div>\n<p>&nbsp;</p>';

grep -ril 'membrete' "admin/" | xargs sed -i 's/${STR}//g' 