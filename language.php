<?php

		// IMPORTANT:
	// ==========
	// When translating, only translate the strings that are
	// TO THE RIGHT OF the equal sign (=).
	//
	// Do NOT translate the strings between square brackets ([])
	//
	// Also, leave the text between < and > untranslated.
	//
	// PLEASE NOTE:
	// ============
	// When a new version of AppGini is released, new strings
	// might be added to the "defaultLang.php" file. To translate
	// them, simply copy them to this file ("language.php") and 
	// translate them here. Do NOT translate them directly in 
	// the "defaultLang.php" file.
	// 
	// Tranaslated to Brasilian Portuguese (PT-BR) Marcelo Vitoria (marcelo.nasca@gmail.com)
	// AppGini 5.70 - 24/01/2018
	// =====================================================
		
	// datalist.php
	$Translation['quick search'] = "Busca Rápida";
	$Translation['records x to y of z'] = "Registros <FirstRecord> até <LastRecord> de <RecordCount>";
	$Translation['filters'] = "Filtros";
	$Translation['filter'] = "Filtro";
	$Translation['filtered field'] = "Campo filtrado";
	$Translation['comparison operator'] = "Operador de Comparação";
	$Translation['comparison value'] = "Valor de Comparação";
	$Translation['and'] = "E";
	$Translation['or'] = "Ou";
	$Translation['equal to'] = "Iqual a";
	$Translation['not equal to'] = "Diferente de";
	$Translation['greater than'] = "Maior que";
	$Translation['greater than or equal to'] = "Maior ou Igual a";
	$Translation['less than'] = "Inferior a";
	$Translation['less than or equal to'] = "Menor ou Igual a";
	$Translation['like'] = "Contém";
	$Translation['not like'] = "Não Contém";
	$Translation['is empty'] = "Vazio";
	$Translation['is not empty'] = "Não Vazio";
	$Translation['apply filters'] = "Aplicar Filtros";
	$Translation['save filters'] = "Salvar e Aplicar Filtros";
	$Translation['saved filters title'] = "Código HTML da Aplicação dos Filtros";
	$Translation['saved filters instructions'] = "Copie o código abaixo e cole-o em um arquivo HTML para salvar o filtro recém-definido para que possa voltar a ele em qualquer momento no futuro, sem ter de redefiní-lo. Você pode salvar o HTML no seu computador e acessar esta exibição de tabela pré-filtrada através dele.";
	$Translation['hide code'] = "Ocultar este código";
	$Translation['printer friendly view'] = "Impressão";
	$Translation['save as csv'] = "Salvar em formato CSV (valores separados por vírgulas)";
	$Translation['edit filters'] = "Editar Filtros";
	$Translation['clear filters'] = "Limpar Filtros";
	$Translation['order by'] = 'Ordenar por';
	$Translation['go to page'] = 'Ir à Página:';
	$Translation['none'] = 'Nenhum';
	$Translation['Select all records'] = 'Selecionar Todos os Registros';
	$Translation['With selected records'] = 'Com Registros Selecionados';
	$Translation['Print Preview Detail View'] = 'Visualização dos Detalhes';
	$Translation['Print Preview Table View'] = 'Visualização da Tabela';
	$Translation['Print'] = 'Imprimir';
	$Translation['Cancel Printing'] = 'Cancelar Impressão';
	$Translation['Cancel Selection'] = 'Cancelar seleção';
	$Translation['Maximum records allowed to enable this feature is'] = 'Quantidade máxima de registros permitida para habilitar este recurso é';
	$Translation['No matches found!'] = 'Nada encontrado!';
	$Translation['Start typing to get suggestions'] = 'Comece a digitar para obter sugestões.';

	// _dml.php
	$Translation['are you sure?'] = 'Você tem certeza que deseja Excluir este registro ?';
	$Translation['add new record'] = 'Adicionar';
	$Translation['update record'] = 'Atualizar';
	$Translation['delete record'] = 'Excluir';
	$Translation['deselect record'] = 'Desmarcar registro';
	$Translation["couldn't delete"] = 'Não foi possível remover o registro devido à existência de <RelatedRecords> registro(s) relacionado(s) na tabela [<TableName>]';
	$Translation['confirm delete'] = 'Este registro tem <RelatedRecords> registros relacionados na tabela [<TableName>]. Deseja remove-lo mesmo assim ? <Delete> &nbsp; <Cancel>';
	$Translation['yes'] = 'Sim';
	$Translation['no'] = 'Não';
	$Translation['pkfield empty'] = ' Este é um campo chave e não pode estar vazio.';
	$Translation['upload image'] = 'Enviar arquivo ';
	$Translation['select image'] = 'Selecionar ';
	$Translation['remove image'] = 'Remover ';
	$Translation['month names'] = 'Janeiro,Fevereiro,Março,Abril,Maio,Junho,Julho,Agosto,Setembro,Outubro,Novembro,Dezembro';
	$Translation['field not null'] = 'Você não pode deixar este campo em branco.';
	$Translation['*'] = '*';
	$Translation['today'] = 'Hoje';
	$Translation['Hold CTRL key to select multiple items from the above list.'] = 'Mantenha pressionada a tecla CTRL para selecionar vários elementos da lista acima.';
	$Translation['Save New'] = 'Salvar';
	$Translation['Save As Copy'] = 'Copia';
	$Translation['Deselect'] = 'Desmarcar';
	$Translation['Add New'] = 'Adicionar';
	$Translation['Delete'] = 'Excluir';
	$Translation['Cancel'] = 'Cancelar';
	$Translation['Print Preview'] = 'Impressão';
	$Translation['Save Changes'] = 'Salvar';
	$Translation['CSV'] = 'Salvar CSV';
	$Translation['Reset Filters'] = 'Limpar Filtros';
	$Translation['Find It'] = 'Procurar';
	$Translation['Previous'] = 'Anterior';
	$Translation['Next'] = 'Próximo';
	$Translation['Back'] = 'Voltar';

	// lib.php
	$Translation['select a table'] = "MENU";
	$Translation['homepage'] = "Página Inicial";
	$Translation['error:'] = "Erro:";
	$Translation['sql error:'] = "Erro de SQL:";
	$Translation['query:'] = "Instrução:";
	$Translation['< back'] = "Voltar";
	$Translation["if you haven't set up"] = "Se você ainda não configurou a base de dados, você pode fazer isto clicando <a href='setup.php'>aqui</a>.";
	$Translation['file too large']="Erro: O arquivo enviado excede o tamanho máximo permitido que é de <MaxSize> KB";
	$Translation['invalid file type']="Erro: Este tipo de arquivo não é permitido. Somente arquivos <FileTypes> podem ser enviados";

	// setup.php
	$Translation['goto start page'] = "Ir à página inicial";
	$Translation['no db connection'] = "Não foi possível estabelecer uma conexão à base de dados.";
	$Translation['no db name'] = "Não foi possível acessar o banco de dados '<dbname>' neste servidor.";
	$Translation['provide connection data'] = "Por favor, forneça as seguintes informações para se conectar à base de dados:";
	$Translation['mysql server'] = "Servidor (host) MySQL";
	$Translation['mysql username'] = "Usuário (username) do MySql";
	$Translation['mysql password'] = "Senha (password) do usuário do MySQL";
	$Translation['mysql db'] = "Nome da base de dados (database name)";
	$Translation['connect'] = "Conexão";
	$Translation['couldnt save config'] = "Não foi possível salvar os dados da conexão no 'config.php'.<br />Por favor, verifique se a pasta:<br />'".dirname(__FILE__)."'<br />é gravável (chmod 775 ou chmod 777).";
	$Translation['setup performed'] = "O programa de instalação ja foi executado";
	$Translation['delete md5'] = "Para executar a instalação novamente, você deve excluir o arquivo 'setup.md5'.";
	$Translation['table exists'] = "A tabela <b><TableName></b> já existe e contém <NumRecords> registros.";
	$Translation['failed'] = "Falhou";
	$Translation['ok'] = "Ok";
	$Translation['mysql said'] = "MySQL retornou a mensagem:";
	$Translation['table uptodate'] = "Tabela atualizada.";
	$Translation['couldnt count'] = "Não foi possível contar os registros da tabela <b><TableName></b>";
	$Translation['creating table'] = "Criando a tabela <b><TableName></b> ... ";

	// separateDVTV.php
	$Translation['please wait'] = "Por favor, aguarde.";

	// _view.php
	$Translation['tableAccessDenied']="Desculpe! Você não tem permissão para acessar esta tabela. Entre em contato com o administrador.";

	// incCommon.php
	$Translation['not signed in']="Você não está logado.";
	$Translation['sign in']="Entrar";
	$Translation['signed as']="Logado como";
	$Translation['sign out']="Desconectar";
	$Translation['admin setup needed']="Configuração pelo administrador é necessária. Por favor, faça o login no <a href=admin/>painel de administração</a> e configure o ambiente.";
	$Translation['db setup needed']="O módulo de instalação ainda não foi executado. Por favor, acesse a <a href=setup.php>página de configuração</a> primeiro.";
	$Translation['new record saved']="Novo registro foi salvo com sucesso.";
	$Translation['record updated']="Registro atualizado com sucesso.";

	// index.php
	$Translation['admin area']="Administração";
	$Translation['login failed']="Sua tentativa de login anterior falhou. Por favor, tente novamente.";
	$Translation['sign in here']="Efetue seu login aqui";
	$Translation['remember me']="Lembrar-me";
	$Translation['username']="Usuário";
	$Translation['password']="Senha";
	$Translation['go to signup']="Novo usuário ? <br />&nbsp; <a href=membership_signup.php>Cadastre-se aqui</a>";
	$Translation['forgot password']="Esqueceu sua senha ? <a href=membership_passwordReset.php>Clique aqui</a>";
	$Translation['browse as guest']="<a href=index.php>Continuar navegando como visitante</a>";
	$Translation['no table access']="Você não tem permissão para accessar a nenhuma pagina. Por favor faça seu login antes.";
	$Translation['signup']="Cadastre-se";

	// checkMemberID.php
	$Translation['user already exists']="Usuário '<MemberID>' já existe. Tente outro nome de usuário.";
	$Translation['user available']="Usuário '<MemberID>' está disponível e pode ser usado.";
	$Translation['empty user']="Por favor insira um nome de usuário na primeira caixa abaixo e depois clique no botão para 'verificar a disponibilidade'.";

	// membership_thankyou.php
	$Translation['thanks']="Obrigado por registrar-se!";
	$Translation['sign in no approval']="Se você escolheu um grupo que não requer aprovação do administrador, você pode logar-se agora acessando <a href=index.php?signIn=1>aqui</a>.";
	$Translation['sign in wait approval']="Se você escolheu um grupo que requer aprovação do administrador, por favor aguarde um e-mail de confirmação.";

	// membership_signup.php
	$Translation['username empty']="Você deve informar um nome de usuário. Por favor, volte e informe um nome de usuário";
	$Translation['password invalid']="Você deve fornecer uma senha válida de quatro caracteres ou mais e sem espaços. Por favor, volte e digite uma senha válida";
	$Translation['password no match']="Senha inexistente ! Volte e entre novamente com sua senha";
	$Translation['username exists']="Usuário (username) já existe. Por favor, retorne e escolha um diferente.";
	$Translation['email invalid']="Endereço de e-mail é inválido. Por favor, retorne e corrija-o.";
	$Translation['group invalid']="Grupo inválido. Por favor, retorne e selecione um.";
	$Translation['sign up here']="Registre-se aqui!";
	$Translation['registered? sign in']="Já é cadastrado? <a href=index.php?signIn=1>Clique aqui</a>.";
	$Translation['sign up disabled']="Desculpe! Novos registros foram desabilitados pelo administrador. Por favor, tente em outra ocasião.";
	$Translation['check availability']="Verificar se este nome de usuário está disponível";
	$Translation['confirm password']="Confirme a senha";
	$Translation['email']="E-mail";
	$Translation['group']="Grupo";
	$Translation['groups *']="Se você decidir participar de um grupo marcado com um asterisco(*), não poderá entrar até que o administrador aprove sua solicitação e o sistema lhe envie um e-mail automaticamente.";
	$Translation['sign up']="Registre-se aqui";

	// membership_passwordReset.php
	$Translation['password reset']="Resetar Senha";
	$Translation['password reset details']="Entre com seu usuario ou email. Iremos lhe enviar um link em seu email. Depois que você acessar este link, você poderá entrar com uma nova senha.";
	$Translation['password reset subject']="Instrucoes para resetar sua senha";
	$Translation['password reset message']="Caro Usuario, \n Se voce requisitou o reset/alteracao de sua senha, por favor click neste link: \n <ResetLink> \n\n Caso voce nao tenha requisitado o reset/alteração de sua senha, Ignore esta Mensagem. \n\n Saudacoes.";
	$Translation['password reset ready']="Um Email contendo instrucoes para efetuar o Reset de sua senha foi enviado ao seu email de registro. Siga as instrucoes contidas neste email.<br /><br />Se você não receber este email em até 5 minutos, tente resetar sua senha novamente, e tenha certeza que entrou com seu usuário ou email correto.";
	$Translation['password reset invalid']="Usuário ou senha inválido. <a href=membership_passwordReset.php>Tente novamente</a>, ou <a href=index.php>retorne a página inicial</a>.";
	$Translation['password change']="Trocar Senha";
	$Translation['new password']="Nova Senha";
	$Translation['password reset done']="Sua senha foi alterada com sucesso. Voce pode <a href=index.php?signOut=1>logar-se com a nova senha aqui</a>.";

    $Translation['Loading ...']='Carregando...';
    $Translation['No records found']='Nenhum registro encontrado';
    $Translation['You can add children records after saving the main record first']='Voce pode adicionar registros vinculados após gravar o registro principal primeiro';

    $Translation['ascending'] = 'Crescente';
    $Translation['descending'] = 'Decrescente';
    $Translation['then by'] = 'Em seguida por';

	// membership_profile
	$Translation['Legend'] = 'Legenda';
	$Translation['Table'] = 'Tabela';
	$Translation['Edit'] = 'Editar';
	$Translation['View'] = 'Visualizar';
	$Translation['Only your own records'] = 'Somente seus proprios registros';
	$Translation['All records owned by your group'] = 'Todos os registros pertencentes a seu grupo';
	$Translation['All records'] = 'Todos os registros';
	$Translation['Not allowed'] = 'Não permitido';
	$Translation['Your info'] = 'Sua Informação';
	$Translation['Hello user'] = 'Olá %s!';
	$Translation['Your access permissions'] = 'Suas permissões de acesso';
	$Translation['Update profile'] = 'Atualizar Perfil';
	$Translation['Update password'] = 'Atualizar senha';
	$Translation['Change your password'] = 'Alterar sua senha';
	$Translation['Old password'] = 'Senha anterior';
	$Translation['Password strength: weak'] = 'Força da senha: Fraca';
	$Translation['Password strength: good'] = 'Força da senha: Boa';
	$Translation['Password strength: strong'] = 'Força da senha: Forte';
	$Translation['Wrong password'] = 'Senha Incorreta';
	$Translation['Your profile was updated successfully'] = 'Seu perfil foi atualizado com sucesso';
	$Translation['Your password was changed successfully'] = 'Sua senha foi alterada com sucesso';
	$Translation['Your IP address'] = 'Seu endereço IP';
	
	/* Added in AppGini 4.90 */
	$Translation['Records to display'] = 'Registros para exibir';
	
	/* Added in AppGini 5.10 */
	$Translation['Setup Data'] = 'Informações de Setup';
	$Translation['Database Information'] = 'Nome do Banco de Dados';
	$Translation['Admin Information'] = 'Nome do Admin';
	$Translation['setup intro 1'] = 'Parece que não há um arquivo de configuração valido. Ele é necessário para que a aplicação funcione.<br><br>Este setup irá lhe ajudar a criar este arquivo. Mas em alguns servidores isto pode não funcionar. Neste caso, voce vai precisar ajustar as permissões de pastas manualmente, ou criar o arquivo de configuração manualmente.';	
	$Translation['setup intro 2'] = 'Bem-vindo ao sua nova aplicação AppGini ! Antes de começar, precisamos de algumas informações sobre seu Banco de Dados. Voce vai precisar saber do seguinte antes de prosseguirmos:<ol><li>Endereço do Servidor do Banco de Dados(host)</li><li>Nome do Banco de Dados</li><li>Nome do Usuário do Banco de Dados</li><li>Senha do Banco de Dados</li></ol>Os itens acima, provavelmente, foram fornecidos pelo seu provedor de hospedagem web. Se você não tiver essas informações, então você vai precisar entrar em contato com eles ou se referir a sua documentação de serviço antes de poder continuar. Se voce estiver pronto, vamos começar!';
	$Translation['setup finished'] = '<b>Successo!</b><br><br>Sua aplicação AppGini foi instalada. Aqui vão algumas sugestões para iniciar a utilização:';
	$Translation['setup next 1'] = 'Inicie sua aplicação adicionando registros, ou utilize os dados existentes se ouverem.';
	$Translation['setup next 2'] = 'Importe dados para a sua aplicação de um arquivo CSV.';
	$Translation['setup next 3'] = 'Vá para a pagina do Administrador sempre que voce modificar sua aplicação para ajusta-la as novas alterações.';
	$Translation['db_name help'] = 'O nome do Banco de Dados que voce ajustou em sua aplicação AppGini em ';
	$Translation['db_server help'] = '<i>localhost</i> funciona na maioria dos Servidores. Se não funcionar, você deverá obter informações a respeito com seu provedor de Hospedagem.';
	$Translation['db_username help'] = 'Nome de Usuário do MySQL';
	$Translation['db_password help'] = 'Senha do MySQL';
	$Translation['username help'] = 'Especifique o nome do usuário administrador que você gostaria de usar para acessar a área de administração. Deve ter quatro caracteres ou mais.';
	$Translation['password help'] = 'Especifique uma senha forte para o acesso a area Administrativa de sua aplicação.';
	$Translation['email help'] = 'Digite o endereço de e-mail onde você deseja que as notificações de administração sejam enviadas.';
	$Translation['Continue'] = 'Continue ...';
	$Translation['Lets go'] = 'Vamos começar!';
	$Translation['Submit'] = 'Enviar';
	$Translation['Hide'] = 'Ocultar Ajuda';
	$Translation['Database info is correct'] = '&#10003; Informações do Banco de Dados estão corretas !';
	$Translation['Database connection error'] = '&#10007; Erro ao conectar ao Banco de Dados !';
	$Translation['The following errors occured'] = 'Ocorreram os seguintes erros';
	$Translation['failed to create config instructions'] = 'Provavelmente as permissões de das pastas estão ajustadas para bloquear a criação de arquivos em seu servidor. Não se preocupe ! Voce ainda pode criar o arquivo de configuração manualmente.<br><br>Simplesmente cole o codigo a seguir em um editor de textos e salve o arquivo como "config.php", então faça o upload deste arquivo usando FTP ou qualquer outro meio na pasta %s em seu servidor.';
	$Translation['Only show records having filterer'] = 'Somente exibir registros quando %s for %s';
	
	/* Added in AppGini 5.20 */
	$Translation['You don\'t have enough permissions to delete this record'] = 'Voce não tem permissão para remover este registro';
	$Translation['Couldn\'t delete this record'] = 'Não pude remover este registro';
	$Translation['The record has been deleted successfully'] = 'O registro foi removido com sucesso';
	$Translation['Couldn\'t save changes to the record'] = 'Não pude gravar as alterações no registro';
	$Translation['Couldn\'t save the new record'] = 'Não pude salvar o novo registro';
	
	/* Added in AppGini 5.30 */
	$Translation['More'] = 'Mais';
	$Translation['Confirm deleting multiple records'] = 'Confirmação para remover varios registros';
	$Translation['<n> records will be deleted. Are you sure you want to do this?'] = '<n> registros serão removidos. Voce tem certeza que deseja fazer isso?';
	$Translation['Yes, delete them!'] = 'Sim, pode excluí-los!';
	$Translation['No, keep them.'] = 'Não, manter os registros.';
	$Translation['Deleting record <i> of <n>'] = 'Removendo registro <i> de <n>';
	$Translation['Delete progress'] = 'Progresso da Remoção';
	$Translation['Show/hide details'] = 'Exibir/Esconder detalhes';
	$Translation['Connection error'] = 'Erro de conexão';
	$Translation['Add more actions'] = 'Adicionar mais ações';
	$Translation['Update progress'] = 'Progresso da Atualização';
	$Translation['Change owner'] = 'Alterar o proprietário';
	$Translation['Updating record <i> of <n>'] = 'Atualizando registro <i> de <n>';
	$Translation['Change owner of <n> selected records to'] = 'Alterando o proprietario de <n> registros selecionados para';

	/* Added in AppGini 5.40 */
	$Translation['username invalid'] = 'Usuário <MemberID> já existe ou é invalido. Tenha certeza que voce entrou com um nome de usuário contendo de 4 a 20 caracteres válidos.';
	$Translation['permalink'] = 'Permalink';
	$Translation['invalid provider'] = 'Provedor inválido!';
	$Translation['invalid url'] = 'URL inválida!';
	$Translation['cant retrieve coordinates from url'] = 'Não pude obter informações desta URL!';
	
    /* Added in AppGini 5.51 */
    $Translation['maintenance mode admin notification'] = 'Modo de Manutenção Habilitado! Você pode desabilitá-lo da página de Administração.';		
    $Translation['unique field error'] = 'Esta valor ja existe ou é inválido. Por favor tenha certeza de especificar um valor válido e único.';
	
	/* Added in AppGini 5.60 */
    $Translation['show all user records from table'] = 'Exibir todos os registros deste usuário da tabela "<tablename>" ';	
	$Translation['show all group records from table'] = 'Exibir todos os registros deste grupo da tabela "<tablename>" ';	
	$Translation['email this user'] = 'Email para o usuário';
	$Translation['email this group'] = 'Email para o grupo';
	$Translation['owner'] = 'Proprietário';
	$Translation['created'] = 'Criado';
	$Translation['last modified'] = 'Última modificação';	
	$Translation['record has no owner'] = 'Este registro não pertence a nenhum usuário. Voce pode atribuir um usuário na área de Administração.';
	$Translation['admin-only info'] = 'A Informação abaixo esta sendo exibida porque voce esta logado como Super Admin. Outros usuários não podem ver isto.';
	$Translation['discard changes confirm'] = 'Descartar alterações para este registro?';

    /* Added in AppGini 5.70 */
	$Translation['hide/show columns'] = 'Esconder/Exibir colunas';
	$Translation['next column'] = 'Próxima coluna';
	$Translation['previous column'] = 'Coluna anterior';	