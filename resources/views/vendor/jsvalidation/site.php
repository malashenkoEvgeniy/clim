<?php
	$_config = [
		'params' => [
			'durationAnimate' => Config::get('jsvalidation.duration_animate'),
			'focusOnError' => Config::get('jsvalidation.focus_on_error')
		],
		'settings' => [
			'rules' => $validator['rules'],
			'ignore' => (isset($validator['ignore']) && is_string($validator['ignore'])) ? $validator['ignore'] : '[type=hidden]'
		]
	];
?>
<script>
	(function(selectors) {
		selectors["<?= $validator['selector']; ?>"] = <?= json_encode($_config); ?>;
    })(window.LOCO_DATA.validation.bySelector);
</script>
