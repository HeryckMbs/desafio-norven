
## Sobre o Projeto
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

Feito com Laravel 9.x, php 8.0 e Admin LTE 3,
Utiliza banco de dados remoto do serviço de hospedagem elephant SQL
Caso queira utiliza-lo deixarei um .env de exemplo abaixo para a utilização

Laravel is accessible, powerful, and provides tools required for large, robust applications.
Vídeo de apresentação do projeto : [https://www.youtube.com/watch?v=zDiXs5Dyc6U]
## .env para Banco remoto

APP_NAME=MecânicaMBS
APP_ENV=local
APP_KEY=base64:ZxiKjZl4LMGa7PRc2joF86Bq+KmRHcJv4P8VGuK1Crs=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
DATABASE_URL=postgres://clvercbv:gUU3G6Suha80IE8I8VOB6iDQ5ZJOPoyL@floppy.db.elephantsql.com/clvercbv
DB_CONNECTION=pgsql

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
