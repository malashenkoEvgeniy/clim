'use strict';

/**
 * Флаг production версии.
 * Передается посредством webpack плагина DefinePlugin
 *
 * @name IS_PRODUCTION
 * @type {boolean}
 * @default при сборке в продакшн версии - равен `true`, иначе - `false`
 */

/**
 * Флаг при сборке для выгрузки на фтп инкубатора.
 * Передается посредством webpack плагина DefinePlugin
 * @name IS_BUILD
 * @type {boolean}
 * @default при сборке для выгрузки на фтп инкубатора - равен `true`, иначе - `false`
 */

/**
 * Флаг develop версии.
 * Передается посредством webpack плагина DefinePlugin.
 *
 * Используется для работы с кодом, который не должен попасть в продакшн сборку
 *
 * @name IS_DEVELOPMENT
 * @type {boolean}
 * @default при сборке в продакшн версии - равен `false`, иначе - `true`
 *
 * @example
 * if (IS_DEVELOPMENT) {
 *  console.log(myValue); // консоль будет видна (существовать) только при разработке
 * }
 */
