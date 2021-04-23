<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Validation Language Lines
     |--------------------------------------------------------------------------
     |
     | The following language lines contain the default error messages used by
     | the validator class. Some of these rules have multiple versions such
     | as the size rules. Feel free to tweak each of these messages here.
     |
     */

    'accepted' => 'Поле ":attribute" должно быть отмечено.',
    'active_url' => 'Значение поля ":attribute" не является корректным URL адресом.',
    'after' => 'Значение поля ":attribute" должно быть датой больше чем :date.',
    'after_or_equal' => 'Значение поля ":attribute" должно быть датой больше или равной :date.',
    'alpha' => 'Значение поля ":attribute" может содержать в себе только буквы.',
    'alpha_dash' => 'Значение поля ":attribute" может содержать в себе только буквы, цифры и нижние подчеркивания.',
    'alpha_num' => 'Значение поля ":attribute" может содержать в себе только буквы и цифры.',
    'array' => 'Значение поля ":attribute" должно быть массивом.',
    'before' => 'Значение поля ":attribute" должно быть датой меньше :date.',
    'before_or_equal' => 'Значение поля ":attribute" должно быть датой меньше или равной :date.',
    'between' => [
        'numeric' => 'Значение должно быть в пределах :min и :max.',
        'file' => 'Размер файла должен быть в пределах :min и :max киллобайт.',
        'string' => 'Строка должна быть не короче :min и не длиннее :max символов.',
        'array' => 'Количество элементов массива должно быть в пределах между :min и :max.',
    ],
    'gt' => [
        'numeric' => 'Значение должно быть в больше чем :field.',
        'file' => 'Размер файла должен быть в больше чем :field',
        'string' => 'Значение должно быть в больше чем :field',
        'array' => 'Значение должно быть в больше чем :field',
    ],
    'boolean' => 'Значение поля ":attribute" должно быть булевым.',
    'confirmed' => 'Значение поля ":attribute" не подтверждено.',
    'date' => 'Значение поля ":attribute" не является датой.',
    'date_format' => 'Значение поля ":attribute" не совпадает с форматом :format.',
    'different' => 'Значение поля ":attribute" и :other должны отличаться.',
    'digits' => 'Значение поля ":attribute" должно содержать в себе :digits цифр.',
    'digits_between' => 'Значение поля ":attribute" должно содержать от :min до :max символов.',
    'dimensions' => 'Файл не является изображением.',
    'distinct' => 'Значение поля ":attribute" повторяющееся.',
    'email' => 'Значение поля ":attribute" должно быть email адресом.',
    'exists' => 'Выбранное значение некорректно.',
    'file' => 'Выберите файл.',
    'filled' => 'Поле ":attribute" не заполнено.',
    'image' => 'Выберите корректное изображение.',
    'in' => 'Выбранное поле ":attribute" некорректно.',
    'in_array' => 'Значение не существует в :other.',
    'integer' => 'Значение поля ":attribute" должно быть числом.',
    'ip' => 'Значение поля ":attribute" должно быть корректным IP адресом.',
    'ipv4' => 'Значение поля ":attribute" должно быть корректным IPv4 адресом.',
    'ipv6' => 'Значение поля ":attribute" должно быть корректным IPv6 адресом.',
    'json' => 'Значение поля ":attribute" должно быть корректной JSON строкой.',
    'max' => [
        'numeric' => 'Значение поля ":attribute" не может быть больше :max.',
        'file' => 'Файл не может весить больше :max киллобайт.',
        'string' => 'Значение поля ":attribute" не может быть длиннее :max символов.',
        'array' => 'Массив не может содержать больше :max элементов.',
    ],
    'mimes' => 'Значение поля ":attribute" должно быть файлом типа: :values.',
    'mimetypes' => 'Значение поля ":attribute" должно быть файлом типа: :values.',
    'min' => [
        'numeric' => 'Значение поля ":attribute" должно быть не меньше :min.',
        'file' => 'Размер файла должен быть не меньше :min киллобайт.',
        'string' => 'Значение поля ":attribute" должно быть не короче :min символов.',
        'array' => 'Массив должно содержать не меньше :min элементов.',
    ],
    'not_in' => 'Выбранное значение поля ":attribute" некорректно.',
    'numeric' => 'Значение поля ":attribute" должно быть числом.',
    'present' => ':attribute: Значение должно быть заполнено.',
    'regex' => ':attribute: Формат значения некорректен.',
    'required' => 'Поле ":attribute" обязательно для заполнения.',
    'required_if' => 'Поле обязательно для заполнения, когда :other = :value.',
    'required_unless' => 'Поле обязательно для заполнения, если :other является одним из значений: :values.',
    'required_with' => 'Поле обязательно для заполнения, если хотя бы одно из полей [:values] заполнено.',
    'required_with_all' => 'Поле обязательно для заполнения, если все поля [:values] заполнены.',
    'required_without' => 'Поле обязательно для заполнения, если поля [:values] не заполнены.',
    'required_without_all' => 'Поле обязательно для заполнения, если ниодно из полей [:values] не заполнено.',
    'same' => 'Значения этого поля и :other должны совпадать.',
    'size' => [
        'numeric' => 'Число должно быть длинной в :size цифр.',
        'file' => 'Размер файла должен быть равен :size киллобайт.',
        'string' => 'Строка должна быть длинной :size символов.',
        'array' => 'Массив должен содержать :size элементов.',
    ],
    'string' => 'Значение поля ":attribute" должно быть строкой.',
    'timezone' => 'Значение поля ":attribute" должно быть корректным часовым поясом.',
    'unique' => ':attribute: Введенное значение не уникально.',
    'uploaded' => 'Файл не был загружен.',
    'url' => 'Формат некорректен.',

    /**
     * Custom rules
     */
    'current_password' => 'Пожалуйста укажите корректный действующий пароль.',
    'slug' => 'Введенное значение для поля ":attribute" не уникально.',
    'domain' => 'Доменное имя некорректно.',

    /*
     |--------------------------------------------------------------------------
     | Custom Validation Language Lines
     |--------------------------------------------------------------------------
     |
     | Here you may specify custom validation messages for attributes using the
     | convention "attribute.rule" to name the lines. This makes it quick to
     | specify a specific custom language line for a given attribute rule.
     |
     */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Custom Validation Attributes
     |--------------------------------------------------------------------------
     |
     | The following language lines are used to swap attribute place-holders
     | with something more reader friendly such as E-Mail Address instead
     | of "email". This simply helps us make messages a little cleaner.
     |
     */

    'attributes' => [
        'password' => 'Пароль',
        'name' => 'Название',
        'user' => 'Пользователь',
        'slug' => 'Алиас',
        'default' => 'По-умолчанию',
        'first_name' => 'Имя',
        'last_name' => 'Фамилия',
        'middle_name' => 'Отчество',
        'email' => 'Электронная почта',
        'user_id' => 'Пользователь',
        'created_at' => 'Дата создания',
        'updated_at' => 'Последнее изменение',
        'published_at' => 'Дата публикации',
        'active' => 'Активность',
        'phone' => 'Номер телефона',
        'current_password' => 'Текущий пароль',
        'new_password' => 'Новый пароль',
        'new_password_confirmation' => 'Подтвердите пароль',
        'language' => 'Язык',
        'image' => 'Изображение',
        'parent_id' => 'Родитель',
        'date_from' => 'Дата от',
        'date_to' => 'Дата по',
        'content' => 'Описание',
        'short_content' => 'Краткое описание',
        'ip' => 'IP',
        'blocked_to' => 'Заблокирован до',
        'blocked_forever' => 'Заблокирован навсегда',
        'comment' => 'Комментарий',
        'commentable_id' => 'Связанная запись',
        'subject' => 'Тема',
        'text' => 'Контент',
        'publish_date' => 'Дата публикации',
        'identifier' => 'Идентификатор',
        'seo_text' => 'Seo текст',
        'album_id' => 'Альбом',
        'price' => 'Цена',
        'category' => 'Категория',
        'url' => 'Ссылка',
        'type' => 'Тип',
        'file' => 'Файл',
        'brand_id' => 'Производитель',
        'available' => 'Наличие',
        'old_price' => 'Старая цена',
        'color' => 'Цвет',
        'birthday' => 'Дата рождения',
        'sex' => 'Пол',
        'city' => 'Город',
        'vendor_code' => 'Артикул',
        'personal-data-processing' => 'Согласен на обработку данных',
        'mark' => 'Оценка',
        'answer' => 'Ответ',
        'answered_at' => 'Дата ответа',
        'microdata' => 'Значение для микроразметки',
        'delivery' => 'Способ доставки',
        'payment_method' => 'Способ оплаты',
        
        'h1' => 'Meta h1',
        'title' => 'Meta title',
        'keywords' => 'Meta keywords',
        'description' => 'Meta description',
        'per-page' => 'кол-во на странице',
        'roles-per-page' => 'кол-во ролей на странице',
        'per-page-client-side' => 'кол-во на странице на сайте',
        'auth' => '"запаролить сайт"',
        'history-per-page' => 'кол-во на странице',
        'autoplay' => 'автозапуск',
        'per-widget' => 'кол-во в виджете',
        'count-in-widget' => 'кол-во в виджете',
        'per-page-for-user' => 'кол-во в лк',
        'address_for_self_delivery' => 'адрес для самовывоза',
        'facebook-api-secret' => 'App Id Facebook',
        'facebook-api-key' => 'App Secret Facebook',
        'twitter-api-key' => 'App Secret Twitter',
        'twitter-api-secret' => 'App key Twitter',
        'instagram-api-secret' => 'Client Secret Instagram',
        'instagram-api-key' => 'App ID Instagram',
    ],
];
