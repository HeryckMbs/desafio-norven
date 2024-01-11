#!/bin/bash

# Passo 1: Copiar o arquivo de exemplo .env
cp .env.example .env

# Passo 2: Instalar as dependências do Composer
composer i

# Passo 3: Criar alias para Sail (se ainda não existir)


# Passo 4: Iniciar os containers Docker com Sail, gerar chave e realizar migrações
./vendor/bin/sail up -d
./vendor/bin/sail php artisan key:generate
./vendor/bin/sail php artisan storage:link
./vendor/bin/sail php artisan migrate:fresh --seed

# Passo 5: Instalar as dependências do npm, compilar e construir
./vendor/bin/sail npm i
./vendor/bin/sail npm run build
./vendor/bin/sail npm run dev
./vendor/bin/sail php artisan schedule:work
# Mensagem informativa
echo "Acesse a aplicação em http://localhost:8092/"
echo "Usuário padrão está na seeder FillBasicData"
