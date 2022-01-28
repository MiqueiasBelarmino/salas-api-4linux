## API para gestão de agendamento de salas

**Instruções para rodar a aplicação**
## Comandos
- composer install
- composer update
## Configurações
- o banco de dados poder ser da escolha do dev
- criar um banco de dados e informar seu nome no arquivo .env
- informar o usuário do banco de dados e a senha no arquivo .env
- rodar o comando "php artisan migrate"

## endpoints
**Agendar uma sala**
- (POST) /api/agendamento  

**Lista todas as salas**
- (GET) /api/salas 

**Cria uma nova sala**
- (POST) /api/salas 

**Mostra uma sala por id**
- (GET) /api/salas/{id} 

**Atualiza uma sala**
- (PUT) /api/salas/{id} 

**Deleta uma sala**
- (DELETE) /api/salas/{id} 

Para vizualizar a DOC da API, após configurar o projeto acesse "/api/documentation", caso não apareca nada rodar o comando "php artisan l5-swagger:generate" 

