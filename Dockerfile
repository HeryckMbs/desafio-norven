# Use a imagem oficial do Laravel Sail
FROM sail-8.3/app

# Execute o comando npm run build durante a construção do contêiner
RUN npm install && npm run build

RUN php artisan migrate
RUN php artisan db:seed --class=FillBasicData
# Continue com o Dockerfile padrão do Laravel Sail
