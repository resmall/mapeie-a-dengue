## Mapeie o Mosquito

O projeto se trata de uma aplicação colaborativa que permite os usuários marcarem no mapa a presença do mosquito da dengue, seja em suas residências ou locais que reconheçam a existência do mosquito. 

O projeto tem como objetivo:

- Ser uma ferramenta se auxílio ao combate a dengue (se possível ser utilizada pelos orgãos responsáveis)
- Permitir a população relatar e ver os focos de infestação, dando maior transparência sobre a real situação de cada local
- Auxiliar na conscientização sobre a dengue

## Estilo de código

Seguimos os padrões sugeridos pelo PHP-FIG, seguindo as recomendações:

* [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md)
* [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md).

## Tecnologia

As seguintes tecnologias estão sendo utilizadas no projeto:

* [PHP] - backend
* [Facebook JS API] - para autenticação
* [Composer] - gerenciador de pacotes PHP
* [Twitter Bootstrap] - interface de usuário
* [jQuery 2.1.3] - requisições ajax
* [Google Maps API v3] - para o mapa iterativo

## Instalação

1. Instale o [Composer](https://getcomposer.org/download/)
2. Após ter instalado git e o composer no seu ambiente, execute os comandos abaixo.

```sh
$ cd diretorio/dos/seus/projetos/
$ git clone https://github.com/resmall/mapeie-a-dengue.git
$ composer update
```
3. Crie um virtual host para a aplicação usando o endereço `dengue.local` -> `diretorio/do/projeto/public` [1]
4. Acesse o arquivo em `app/config/database.php` e insira as informações de conexão do banco de dados.
5. Execute o script para criação do esquema do banco de dados em `app/scripts/schema.sql`.

[1]: Se a URL do site não for a indicada, não será possível usar a Facebook App ID que está no projeto. Certifique-se de que o site é corretamente exibido ao acessar `http://dengue.local`

### Banco de dados 

A estrutura atual poderá mudar a qualquer momento, o projeto está em fase inicial e poderá ser alterado.

Tabela **marcacoes**

| Field            | Type          | Null | Key | Default           | Extra          |
|------------------|---------------|------|-----|-------------------|----------------|
| id               | int(11)       | NO   | PRI | NULL              | auto_increment |
| username         | varchar(50)   | NO   |     | NULL              |                |
| lng              | decimal(10,7) | NO   |     | NULL              |                |
| lat              | decimal(10,7) | NO   |     | NULL              |                |
| datetime_created | datetime      | YES  |     | CURRENT_TIMESTAMP |                |

## Tarefas

- Agrupar as marcações conforme o zoom do mapa, pra não sobrecarregar o navegador caso existam muitos marcadores.
- Carregar os marcadores seletivamente, dentro da área de zoom.
- O usuário deletar seus próprios marcadores.
- Criar marcadores differentes um para o foco do mosquito, outro para a dengue em si.
- Refatorar o código sempre para usar OO e torná-lo testavel e permitir reuso em outros projetos de natureza semelhante.
- Criar testes unitários com PHPUnit para manter a integridade do código ao longo das iterações.
- Criar uma forma automatizada para a criação das tabelas no banco de dados.
- ....e o que surgir.

**Outras propostas**

- Adicionar um formulário pequeno pra pessoa relatar a data da ocorrencia ou algum comentário talvez?
- Criar testes unitários pra parte JS?
- Permitir autenticação usando Google e Twitter?
- Criar um aplicativo Android?

## Licença

A aplicação é um software open-source licenciada sob a [licença MIT](http://opensource.org/licenses/MIT).

**Free Software!**