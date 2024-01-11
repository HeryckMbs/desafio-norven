Passos para executar o projeto

- cp .env.example .env
- composer i
- alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
- sail up -d
- sail php artisan key:generate
- sail php artisan storage:link
- sail php artisan migrate:fresh --seed
- sail npm i
- sail npm run build
- sail npm run dev

acessar a aplicação por http://localhost:8092/

Usuário padrão está na seeder FillBasicData