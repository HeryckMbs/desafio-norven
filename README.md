Passos para executar o projeto

- cp .env.example .env
- composer i
- alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
- sail up -d
- sail php artisan key:generate
- sail php artisan migrate:fresh --seed
- sail npm i
- sail npm run dev

Usuário padrão está na seeder FillBasicData