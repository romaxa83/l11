### API документация
используется пакет [darkaonline/l5-swagger](https://github.com/DarkaOnLine/L5-Swagger), документация
описывается через атрибуты оберткой над которой использует этот пакет [Swagger-PHP](https://zircote.github.io/swagger-php/).
Описанная документация тестируется с помощью пакета [spectator](https://github.com/hotmeteor/spectator).
Дока находиться по пути ```/api/documentation```, обновляется автоматически при посещении данной страницы.

### Анализатор кода
Для проверки стиля кода и исправление синтаксических ошибок используется пакет [PHP Insights](https://phpinsights.com/)
```sh 
docker compose exec php php artisan insights --fix
```
для проверки когнитивной сложности кода - [cognitive-complexity](https://github.com/TomasVotruba/cognitive-complexity/?tab=readme-ov-file),
для своей работы он использует phpStan, конфиг находиться в файле - phpstan.neon
```sh 
docker compose exec php vendor/bin/phpstan
```
Эти команда запускаются перед коммитом

### Поиск не используемых зависимостей
используется пакет - [composer-unused](https://github.com/composer-unused/composer-unused/)
```sh
# запуск
docker compose exec php ./vendor/bin/composer-unused
```
если пакет нужно исключить из проверки, прописываем название пакета в файле - composer-unused.php

### Поиск секретов в гит истории
используется пакет - [gitleaks](https://github.com/gitleaks/gitleaks/)
```sh
# пулим последнюю актуальную версию
docker pull zricethezav/gitleaks:latest
# запускаем проверку
docker run -v ./:/path zricethezav/gitleaks:latest protect \
    --source="/path" \
    --config=/path/.gitleaks.toml \
    --report-path=/path/gitleaks-report.json \
    --staged
```
настройки в файле .gitleaks.toml, отчет в файле - gitleaks-report.json
вызывается на pre-commit

### Branch naming
Requirement described in the file
```
.validate-branch-namerc.json
```
branch name auto validate on pre-push hook using
[validate-branch-name](https://www.npmjs.com/package/validate-branch-name
) package

### Commit convention
Each commit message must follow the [commit convention](https://www.conventionalcommits.org/)

Automatic message validation on commit-msg git hook.
All setting described in the file
```
commitlint.config.js
```
### Commit WIP
когда что-то не сделано, а нужно коммитить а валидация не позволяет запушить,
тогда используем - WIP(work in progress) commit
алгоритм таков:
```sh
# commit 
git commit -m 'wip: some text' --no-verify # or just 'wip'  
git push --no-verify
```
```sh
# вернулись к работе
git reset HEAD~
```
Следующий пуш ОБЯЗАТЕЛЬНО з -f опцией - force push.
