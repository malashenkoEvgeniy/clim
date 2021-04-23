import 'noty/src/noty.scss';
import 'assetsSite#/sass/vendors/noty/uzv-theme.scss';
import Noty from 'noty';

Noty.setMaxVisible(5);

Noty.overrideDefaults({
	theme: 'uzv',
	timeout: 3000,
	layout: 'bottomRight'
});

class Notifier extends Noty {
	static create (options) {
		return new Noty(options);
	}

	static prepareOptions (text = '', options = {}) {
		let opts;
		if (typeof text === 'object') {
			opts = text;
		} else if (typeof text === 'string' && typeof options === 'object') {
			opts = Object.assign(options, { text });
		} else {
			console.warn('[Notifier] => Incorrect types of arguments');
		}
		return opts;
	}

	static info (text, options) {
		this.create(Object.assign(this.prepareOptions(text, options), { type: 'info' })).show();
	}

	static alert (text, options) {
		this.create(Object.assign(this.prepareOptions(text, options), { type: 'alert' })).show();
	}

	static error (text, options) {
		this.create(Object.assign(this.prepareOptions(text, options), { type: 'error' })).show();
	}

	static success (text, options) {
		this.create(Object.assign(this.prepareOptions(text, options), { type: 'success' })).show();
	}

	static warning (text, options) {
		this.create(Object.assign(this.prepareOptions(text, options), { type: 'warning' })).show();
	}

	static echo (timeout = false) {
		Notifier.alert('alert', { timeout });
		Notifier.info('info', { timeout });
		Notifier.success('success', { timeout });
		Notifier.warning('warning', { timeout });
		Notifier.error('error', { timeout });
	}
}

export default Notifier;
