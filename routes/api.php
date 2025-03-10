<?php

/**
 *  Преимущества:
 *  Можно точно указать, какой HTTP-метод (GET, POST, PUT, DELETE) соответствует какому методу контроллера и зарегистрировать только необходимые.
 *  Проще применять разные middleware к отдельным маршрутам и именовать их.
 *  Более ясный подход.
 */

require __DIR__ . '/api/users.php';
require __DIR__ . '/api/tasks.php';
