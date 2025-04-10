Número da inscrição: 10004
CPF: 07993795656
Perfil: DESENVOLVEDOR PHP - SÊNIOR

Número da inscrição: 10020
CPF: 07993795656
Perfil: DESENVOLVEDOR PHP - PLENO

Número da inscrição: 10033
CPF: 07993795656
Perfil: DESENVOLVEDOR PHP - JÚNIOR

Inicie o Docker e abra o terminal Linux ou wsl.exe(Windows):

No terminal acesse o diretório do projeto ApiProva.

Execute o comando para iniciar a aplicação, banco de dados e servidor MinIO:

./vendor/bin/sail up -d

Execute o comando para gerar o banco de dados:

alter o arquivo copia.env.txt para .env

./vendor/bin/sail artisan migrate

Execute o comando para criar o bucket:

mc alias set myminio https://127.0.0.1:9000 sail password

mc mb myminio/local

mc policy set public myminio/local

No postman, faça as requisições:

curl --location 'http://0.0.0.0:80/api/auth/registra' \
--header 'Accept: application/json' \
--form 'name="usuario"' \
--form 'email="usuario@mail.com"' \
--form 'password="12345678"'

Utilize a chave de 'acesso' para inserir uma nova unidade:

curl --location 'http://0.0.0.0:80/api/unidade/novo' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 1|MgtNa6NbNODkQL148qrhVKw88j6gz2Y2NyTY56Ordad634ee' \
--form 'unid_nome="Secretaria"' \
--form 'unid_sigla="SEMT"' \
--form 'end_tipo_logradouro="Avenida"' \
--form 'end_logradouro="Miguel Sutil"' \
--form 'end_numero="122"' \
--form 'end_bairro="Quilombo"' \
--form 'cid_nome="Cuiabá"' \
--form 'cid_uf="MT"'

Caso necessite Renovar o token

curl --location 'http://0.0.0.0:80/api/auth/renovarToken/1' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 2|cxEX6JwfdiDRdmcodjU02wWDsdio75tlHX3ap9uucbf4a237'

Ultilize Autorização por token. e insira o token de 'admin' recebido no registro.

curl --location 'http://0.0.0.0:80/api/auth/renovarToken/' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 2|cxEX6JwfdiDRdmcodjU02wWDsdio75tlHX3ap9uucbf4a237'

curl --location 'http://0.0.0.0:80/api/servidorEfetivo/novo' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 15|DsWdlE9OtJIhfT0Cr00Vq5Kx7kMuc9UghdlvnngW6983a799' \
--form 'pes_nome="Rafael"' \
--form 'pes_data_nascimento="11-12-1990"' \
--form 'pes_sexo="Masculino"' \
--form 'pes_mae="Sonia"' \
--form 'pes_pai="Franscisco"' \
--form 'end_tipo_logradouro="Rua"' \
--form 'end_logradouro="Brasil"' \
--form 'end_numero=222"' \
--form 'end_bairro="Vicente"' \
--form 'cid_nome="Itajubá"' \
--form 'cid_uf="MG"' \
--form 'lot_data_lotacao="01-02-2025"' \
--form 'lot_data_remocao="05-06-2030"' \
--form 'lot_portaria="portaria n23 inclui"' \
--form 'unid_id="1"' \
--form 'se_matricula="100002"' \
--form 'arq=@"/C:/Users/DevRafael/Downloads/foneInova.jpg"'

BUSQUE SERVIDOR POR UNIDADE
curl --location 'http://0.0.0.0:80/api/servidorEfetivo/buscarPorUnidade/1' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 3|0vz8rjNk7qcuMi3kScZzJUrgu8LrzDNVvzTgUSKO76c0c123'

BUSQUE POR PARTE DO NOME
curl --location 'http://0.0.0.0:80/api/servidorEfetivo/enderecoFuncional/morais' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 1|Ch8pBnznyvu582PeHy4F5EmoUCutXWYLmj3cv9kD93a2b352'

CRIE SERVIDOR TEMPORÁRIO

curl --location 'http://0.0.0.0:80/api/servidorTemporario/novo' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 6|M5WD7egRoHoIyNv82zLVj9kqEpSWjMtIxNAldcOg9874e4ef' \
--form 'pes_nome="Felipe Morais da Silva"' \
--form 'pes_data_nascimento="01-12-1984"' \
--form 'pes_sexo="Masculino"' \
--form 'pes_mae="Sonia Morais da Silva"' \
--form 'pes_pai="Franscisco Carlos Brandão da Silva"' \
--form 'end_tipo_logradouro="Rua"' \
--form 'end_logradouro="Vital Brasil2"' \
--form 'end_numero="12"' \
--form 'end_bairro="Vicente2"' \
--form 'cid_nome="Itajubá2"' \
--form 'cid_uf="MG"' \
--form 'ft_data="07-04-2025"' \
--form 'ft_bucket="local"' \
--form 'ft_hash="dfgsdgdfgds"' \
--form 'lot_data_lotacao="01-03-2025"' \
--form 'lot_portaria="portaria n2"' \
--form 'unid_id="1"' \
--form 'st_data_admissao="09-04-2025"' \
--form 'arq=@"/C:/Users/DevRafael/Downloads/images.jpg"'


