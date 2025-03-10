# Task Manager RESTful API Laravel

## Установка и запуск

1. **Сборка контейнеров**:
   ```bash
   ./vendor/bin/sail up
   ```

2. **Миграция базы данных**:
    ```bash
    php artisan migrate
    ```

3. **Наполнение базы данных**:
    ```bash
    php artisan db:seed
    ```

2. **Доступ к API**:
   После успешного запуска приложение будет доступно по адресу [http://localhost/api](http://localhost/api).

## Использование API

### Сотрудники

- **Создать сотрудника**: `POST /users`
- **Получить всех сотрудников**: `GET /users`
- **Обновить сотрудника**: `PUT /users/{id}`
- **Удалить сотрудника**: `DELETE /users/{id}`

### Задачи

- **Создать задачу**: `POST /tasks`
- **Получить все задачи**: `GET /tasks`
- **Обновить задачу**: `PUT /tasks/{id}`
- **Удалить задачу**: `DELETE /tasks/{id}`

### Дополнительная информация

- Для группировки по статусу и фильтрации используется [Abbasudo\Purity](https://github.com/abbasudo/laravel-purity).
- Для ролей используется [Spatie\LaravelPermission](https://spatie.be/docs/laravel-permission).
- Для DTO используется [Spatie\LaravelData](https://github.com/spatie/laravel-data).
- Для управления state в моделях используется [Spatie\ModelStates](https://spatie.be/docs/laravel-model-states).
