<style>
    .demo-button {
        position: fixed;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 0.5rem 0.5rem 0 0;
        z-index: 999;
        color: #fff;
        border: none;
        padding: 0.7rem 2.2rem;
        cursor: pointer;
        animation: demo-anim 2s ease-in-out infinite;
        background-image: linear-gradient(to right, #25aae1, #4481eb, #25aae1, #4481eb);
        background-size: 300% 100%;
    }

    .demo-button:hover {
        background: #f7931d;
    }

    @keyframes demo-anim {
        from {
            background-position: 0 0;
        }
        to {
            background-position: 100% 0;
        }
    }
</style>

<button class="demo-button js-init" data-mfp="inline" data-mfp-src="#popup-demo">Создать магазин</button>
<script>
	(function (selectors) {
		selectors["#demo-popup-form"] = {
			"params": {"durationAnimate": 1000, "focusOnError": false},
			"settings": {
				"rules": {
					"phone": {"laravelValidation": [["Required", [], "\u041f\u043e\u043b\u0435 \"\u041d\u043e\u043c\u0435\u0440 \u0442\u0435\u043b\u0435\u0444\u043e\u043d\u0430\" \u043e\u0431\u044f\u0437\u0430\u0442\u0435\u043b\u044c\u043d\u043e \u0434\u043b\u044f \u0437\u0430\u043f\u043e\u043b\u043d\u0435\u043d\u0438\u044f.", true], ["String", [], "\u0417\u043d\u0430\u0447\u0435\u043d\u0438\u0435 \u043f\u043e\u043b\u044f \"\u041d\u043e\u043c\u0435\u0440 \u0442\u0435\u043b\u0435\u0444\u043e\u043d\u0430\" \u0434\u043e\u043b\u0436\u043d\u043e \u0431\u044b\u0442\u044c \u0441\u0442\u0440\u043e\u043a\u043e\u0439.", false], ["Min", ["6"], "\u0417\u043d\u0430\u0447\u0435\u043d\u0438\u0435 \u043f\u043e\u043b\u044f \"\u041d\u043e\u043c\u0435\u0440 \u0442\u0435\u043b\u0435\u0444\u043e\u043d\u0430\" \u0434\u043e\u043b\u0436\u043d\u043e \u0431\u044b\u0442\u044c \u043d\u0435 \u043a\u043e\u0440\u043e\u0447\u0435 6 \u0441\u0438\u043c\u0432\u043e\u043b\u043e\u0432.", false], ["Max", ["191"], "\u0417\u043d\u0430\u0447\u0435\u043d\u0438\u0435 \u043f\u043e\u043b\u044f \"\u041d\u043e\u043c\u0435\u0440 \u0442\u0435\u043b\u0435\u0444\u043e\u043d\u0430\" \u043d\u0435 \u043c\u043e\u0436\u0435\u0442 \u0431\u044b\u0442\u044c \u0434\u043b\u0438\u043d\u043d\u0435\u0435 191 \u0441\u0438\u043c\u0432\u043e\u043b\u043e\u0432.", false]]},
				}, "ignore": "[type=hidden]"
			}
		};
	})(window.LOCO_DATA.validation.bySelector);
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-132855521-2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-132855521-2');
</script>
<script>
    (function(w, d, s, h, id) {
        w.roistatProjectId = id; w.roistatHost = h;
        var p = d.location.protocol == "https:" ? "https://" : "http://";
        var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init";
        var js = d.createElement(s); js.charset="UTF-8"; js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);
    })(window, document, 'script', 'cloud.roistat.com', '9e3cd854b790f624e07453c72e108355');
</script>

<div hidden>
    <div id="popup-demo" class="popup popup--demo">
        <div class="popup__container">
            <div class="popup__head">
                <div class="grid _flex-nowrap">
                    <div class="gcell gcell--auto _flex-noshrink _pr-sm">
                        <svg class="svg-icon svg-icon--icon-ask-doctor">
                            <use xlink:href="/assets/svg/spritemap.svg?v=1547035655#icon-shopping"></use>
                        </svg>
                    </div>
                    <div class="gcell gcell--auto _flex-grow">
                        <div class="popup__title">Cоздать магазин</div>
                        <div class="popup__desc">Наш менеджер свяжется с вами в кратчайшие сроки и
                            обсудит все детали.
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup__body">
                <div class="form form--consultation">
                    <form action="https://locotrade.com.ua/send.php" method="POST" class="js-init ajax-form" id="demo-popup-form">
                        <div class="form__body">
                            <div class="grid _nmtb-sm">
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="control control--input">
                                        <div class="control__inner">
                                            <input class="control__field" type="text" name="name" id="demo-name">
                                            <label class="control__label" for="demo-name">Ваше имя</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="control control--input">
                                        <div class="control__inner">
                                            <input class="control__field" type="tel" name="phone" id="demo-phone" required>
                                            <label class="control__label" for="demo-phone">Ваш номер
                                                телефона *</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="gcell gcell--12 _ptb-sm">
                                    <div class="control control--input">
                                        <div class="control__inner">
                                            <input class="control__field" type="tel" name="email" id="demo-email">
                                            <label class="control__label" for="demo-email">E-mail</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="roistat" value="{{isset($_COOKIE['roistat_visit']) ? $_COOKIE['roistat_visit'] : 'неизвестно'}}">
                        <div class="form__footer">
                            <div class="grid _justify-center">
                                <div class="gcell gcell--12 gcell--sm-10 gcell--md-8">
                                    <div class="control control--submit">
                                        <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                                                <span class="button__body">
                                                    <span class="button__text">Отправить заявку</span>
                                                </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
