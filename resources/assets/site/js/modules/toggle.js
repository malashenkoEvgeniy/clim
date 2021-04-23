import uuidv4 from 'uuid/v4';

const $document = $(document);

window.toggleInstance = null;

class Toggle {
	constructor ($root, moduleLoader) {
		let defaults = {
			closeOnClickOutSide: true,
			onlyOneOpened: false,
			focusInput: false,
			css: {
				active: 'is-active'
			}
		};

		this.$root = $root;
		this.$trigger = $root.find('[data-toggle-trigger]');
		this.params = $.extend(true, {}, defaults, $root.data('user-config') || {});
		this.moduleLoader = moduleLoader;

		this.ns = 'toggle';
		this.toggleEvent = `click.${this.ns}.${uuidv4()}`;

		this.init();
	}

	init () {
		this.$trigger.on(this.toggleEvent, (e) => {
			let allowToggle = !/^label$|^input$/.test(e.target.tagName.toLowerCase()) && !$(e.target).closest('[data-toggle-prevent]', this.$trigger).length;

			if (allowToggle) {
				this.$root.toggleClass(this.params.css.active);
				this.params.focusInput && this.focusInput();
				this.params.closeOnClickOutSide && this.closeOnClickOutSide();
				this.params.onlyOneOpened && this.switchInstanse();
			}
		});

		this.$root.find('[data-toggle-close]').on('click', () => {
			this.close();
		});
	}

	close () {
		this.$root.removeClass(this.params.css.active);
		this.params.closeOnClickOutSide && $document.off(this.toggleEvent);
	}

	focusInput () {
		window.setTimeout(() => { // Chrome BUG => https://fellowtuts.com/jquery/jquery-focus-not-working-in-chrome/
			this.$root.find('input').first().focus();
		}, 50);
	}

	closeOnClickOutSide () {
		$document.on(this.toggleEvent, (e) => {
			if (!$(e.target).closest(this.$root).length) {
				this.close();
			}
		});
	}

	switchInstanse () {
		if (window.toggleInstance && window.toggleInstance !== this) {
			window.toggleInstance.close();
		}
		window.toggleInstance = this;
	}
}

export default Toggle;
