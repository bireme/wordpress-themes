/*
 *
 	Instruções para configuração WP para clipping de notícias
 *
 */



/********** PASSO 1 **********/

Instalação de Plugins
Após a instalação do tema "Clipping BVS SP Brasil", instalar e ativar os seguintes plugins

	contact-form-7
	gd-taxonomies-tools
	more-fields
	more-taxonomies
	post-highlights
	printfriendly
	wp-paginate

Você encontra os plugins no site http://wordpress.org/plugins/



/********** PASSO 2 **********/

Configuração dos formulários de entrada
Após instalados e ativados os plugins, copiar os arquivos de configuração para criar os campos de programação de publicação, e a taxonomia de veículos e midias.


Na pasta "assets" do tema, vc vai encontrar os arquivos de configuração. 
Co
Copiar o arquivo
	assets/fields/publicacao.php
	
para
	/path_no_servidor/wp-content/plugins/more-fields/saved/

_______________

Copiar o arquivo
	assets/taxonomies/media.php
	
para
	/path_no_servidor/wp-content/plugins/more-taxonomies/saved/

_______________

Copiar o arquivo
	assets/taxonomies/veiculo.php
	
para
	/path_no_servidor/wp-content/plugins/more-taxonomies/saved/



/********** PASSO 3 **********/

Configuração do Post Highlights
No menu "Post Highlight/Configurações", defina o Tema "widget"
No menu "Post Highlight/Permissões", defina os tipos de usuários que poderão publicar notícias no slider da homepage



/********** PASSO 4 **********/

Configuração da interface
Habilitar o widget para exibição da lista de veículos (fonte das notícias)

Na área de administração do WordPress, em "Aparência/Widgets": 

Arrastar o widget "PostHighlights" para o "Featured Posts" e defina o tema "widget"
Arrastar o widget "Pesquisar" para o "1st Sidebar" 
Arrastar o widget "gdTT Terms List" para o "Main Sidebar" e realizar a configuração de acordo com as necessidades do site

