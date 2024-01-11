#!/bin/bash

# Passo 1: Copiar o arquivo de exemplo .env
cp .env.example .env

# Passo 2: Instalar as dependências do Composer
composer i

# Passo 3: Criar alias para Sail (se ainda não existir)
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

# Passo 4: Iniciar os containers Docker com Sail, gerar chave e realizar migrações
sail up -d
sail php artisan key:generate
sail php artisan storage:link
sail php artisan migrate:fresh --seed

# Passo 5: Instalar as dependências do npm, compilar e construir
sail npm i
sail npm run build
sail npm run dev

# Mensagem informativa
echo "Acesse a aplicação em http://localhost:8092/"
echo "Usuário padrão está na seeder FillBasicData"
