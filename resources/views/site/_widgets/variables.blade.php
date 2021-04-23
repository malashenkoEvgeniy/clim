@php
/** @var string $main */
/** @var string $mainLighten */
/** @var string $mainDarken */
/** @var string $secondary */
/** @var string $secondaryLighten */
/** @var string $secondaryDarken */
@endphp

<style id="color-panel">
	:root {
		--color-main: {{ $main }};
		--color-main-lighten: {{ $mainLighten }};
		--color-main-darken: {{ $mainDarken }};
		--color-secondary: {{ $secondary }};
		--color-secondary-lighten: {{ $secondaryLighten }};
		--color-secondary-darken: {{ $secondaryDarken }};
	}
</style>
