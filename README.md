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

./vendor/bin/sail artisan migrate

Execute o comando para criar o bucket:

mc alias set myminio https://127.0.0.1:9000 sail password

mc mb myminio/local

mc policy set public myminio/local

Para todas as requisições insira no cabeçalho:

Accept:application/json

Envie uma requisição POST 
http://0.0.0.0:80/api/auth/registra

->form-data

name:user
email:user@mail.com
password:12345678

Utilize a chave de 'acesso' para inserir uma nova unidade:

Envie um POST

http://0.0.0.0:80/api/unidade/novo

unid_nome:Unidade Exemplo

unid_sigla:UNID

end_tipo_logradouro:Avenida

end_logradouro:Logradouro

end_numero:222

end_bairro:Bairro

cid_nome:Cuiabá

cid_uf:MT


Caso necessite Renovar o token

Enviei uma solicitação Get

http://0.0.0.0:80/api/auth/renovarToken/{tokenId}
ou
http://0.0.0.0:80/api/auth/renovarToken/

Ultilize Autorização por token. e insira o token de 'admin' recebido no regitro.


curl --location 'http://0.0.0.0:80/api/servidorEfetivo/novo' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 15|DsWdlE9OtJIhfT0Cr00Vq5Kx7kMuc9UghdlvnngW6983a799' \
--form 'pes_nome="Rafael Morais da Silva"' \
--form 'pes_data_nascimento="02-12-1986"' \
--form 'pes_sexo="Masculino"' \
--form 'pes_mae="Sonia Morais da Silva"' \
--form 'pes_pai="Franscisco Carlos Brandão da Silva"' \
--form 'end_tipo_logradouro="Rua"' \
--form 'end_logradouro="Vital Brasil"' \
--form 'end_numero="12"' \
--form 'end_bairro="Vicente"' \
--form 'cid_nome="Itajubá"' \
--form 'cid_uf="MG"' \
--form 'lot_data_lotacao="01-02-2025"' \
--form 'lot_data_remocao="05-06-2030"' \
--form 'lot_portaria="portaria n23 inclui"' \
--form 'unid_id="1"' \
--form 'se_matricula="100002"' \
--form 'arq=@"/C:/Users/DevRafael/Downloads/foneInova.jpg"'
