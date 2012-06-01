<div class="marketing-menu">
	<div class="marketing-content">
			{foreach name=marketing from=$marketing_items item=item}
				<a href="{$item.link}">{$item.title}</a>
			{/foreach}

	</div>
</div>