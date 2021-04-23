# Locotrade 1.0.0 #

---

Информацию по разарботке проекта можно смотреть на [Wiki E-commerce](https://bitbucket.org/wezom/e-commerce/wiki/Home)

---
[![Javascript Style Guide](https://img.shields.io/badge/Javascript_code_style-wezom_relax-red.svg)](https://github.com/WezomAgency/eslint-config-wezom-relax)
[![Happiness SCSS Style](https://img.shields.io/badge/SASS_code_style-happiness_scss-red.svg)](https://github.com/dutchenkoOleg/happiness-scss)

> :warning: _**Важно!!!**_  
> _Не удаляйте и не заменяйте этот файл_  
> _При необходимости дополните нужную информацию в конец файла_


> :warning: _**Важно!!!**_  
> _Не удаляйте `.gitignore`, который уже составлен для проекта верстки и программирования_  
> _Если нужно добавить пути для игнора - добавьте их вручную, не очищая имеющиеся записи_


> :page_facing_up: _**Wiki в процессе**_  
> https://bitbucket.org/wezom/e-commerce/wiki/Home


> :page_facing_up: _**Как подключить и работать с Git Flow**_  
> https://bitbucket.org/wezom/multi-ub/src/master/README.md

---

## Модель ветвления Git

Используем git flow, подробно:  
https://habr.com/post/106912/  
или на англ.  
http://nvie.com/posts/a-successful-git-branching-model/  
и еще здесь  
https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow
 
1. `master` - продакшн, здесь _**только итоговые релизы (спринты)**_. С нее пулим на продакшн сервак.
1. `develop` - разработка, здесь _**только слитые фичи, напрямую в ней никто не работает!!!**_. С нее пулим на тестовый сервак.
1. `feature/` - 1 задача - 1 фича.
1. `release/` - Подготовка релизов (спринтов)  




---

## Установка зависимостей

Установите или обновите, при необходимости, зависимости

```bash
# Packagist
$ composer update
```

```bash
# NPM
$ npm install
```

---

## Программирование. Получение assets файлов

`public/site/assets` в гит игноре!!! и от туда ее не убираем!!!

Чтобы получить актуальные итоговые файлы:

```bash
$ npm run build
# Сборка assets файлов
# Если предварительные тесты падают - возвращаете на верстальщика!
```

---

## Вёрстка. Разработка проекта

Список `npm` скриптов для работы:

- `npm run build` - итоговая сборка `public/site/assets` файлов 
- `npm run test` - выполнение тестов. Все тесты должны проходить!
- `npm run watch` - инкрементальная сборка, в дев режиме.
- `npm run watch-hot` - инкрементальная сборка, в дев режиме + [HMR](https://webpack.js.org/concepts/hot-module-replacement/).
- `npm run watch-production` - инкрементальная сборка, в продакш режиме.
- `npm run watch-production-hot` - инкрементальная сборка, в продакш режиме + [HMR](https://webpack.js.org/concepts/hot-module-replacement/).
- `npm run sass-lint` - линтинг sass файлов.
- `npm run eslint-assets` - линтинг js файлов разработки.
- `npm run eslint-webpack` - линтинг js файлов проекта сборки.
- `npm run development` - сборка `public/site/assets` файлов в дев режиме.
- `npm run production` - сборка `public/site/assets` файлов в продакш режиме.

---
##Настройка сервака
max_execution_time = 880
max_input_time = 880
upload_max_filesize = 500M
post_max_size = 500M 