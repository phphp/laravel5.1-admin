<div class="footer" style="border-top:1px solid #CCC; margin-top:50px; text-align:center">
	<p></p>
	<p>SQL累计：<font color="#4e9a06">{{ Config::get('admin.COUNT') }}</font> 次，SQL总耗时：<font color="#f57900">{{ Config::get('admin.TIME') }}</font> ms</p>	
</div>

<div style="background-color:#D9E9C4;padding:15px">
	<p>SQL累计：<?php var_dump(Config::get('admin.COUNT')) ?></p>
	<pre>{{ Config::get('admin.SQL') }}</pre>
</div>

