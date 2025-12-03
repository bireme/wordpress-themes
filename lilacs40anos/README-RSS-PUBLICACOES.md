# RSS Feed para Publicações Recentes - LILACS

## Funcionalidade Implementada

Na **Aba 8 - Publicações Recentes** do painel administrativo da página home LILACS, foi adicionada a possibilidade de consumir dados automaticamente de um RSS feed ou inserir conteúdo manualmente.

## Como Usar

### 1. Modo RSS Automático

1. Acesse a página que usa o template `page-lilacs-home.php`
2. Vá até a **Aba 8 - Publicações Recentes**
3. Selecione **"RSS Feed automático"**
4. Cole a URL do RSS feed no campo **"URL do RSS Feed"**
5. Defina o **número máximo de itens** (entre 1 e 20)
6. Clique em **"Testar RSS"** para verificar se o feed está funcionando
7. Salve a página

### 2. Modo Manual

1. Selecione **"Inserção manual (lista personalizada)"**
2. Use o repetidor para adicionar publicações manualmente
3. Para cada item, preencha:
   - **Título da publicação** (obrigatório)
   - **URL** (opcional)

## Formato RSS Suportado

O sistema foi otimizado para o formato RSS do Portal BVS/LILACS:

```xml
<rss version="2.0">
<channel>
<title>Portal Regional da BVS | (instance:"regional") AND ( db:("LILACS")) </title>
<link>http://pesquisa.bvsalud.org/portal/...</link>
<description>...</description>
<item>
<title><![CDATA[ Título da Publicação ]]></title>
<author><![CDATA[ Nome do Autor ]]></author>
<source><![CDATA[ Revista;Vol(Issue): páginas, data ]]></source>
<link>https://pesquisa.bvsalud.org/portal/resource/pt/biblio-123456</link>
<description><![CDATA[ Resumo da publicação... ]]></description>
</item>
</channel>
</rss>
```

## Cache

- Os dados RSS são armazenados em cache por **30 minutos**
- O cache é limpo automaticamente quando a URL ou limite de itens é alterado
- Para forçar atualização imediata, altere temporariamente o número de itens

## Campos Salvos

### RSS:
- `_bireme_rc_source_type`: 'rss' ou 'manual'
- `_bireme_rc_rss_url`: URL do feed RSS
- `_bireme_rc_rss_limit`: Número máximo de itens (1-20)

### Manual:
- `_bireme_rc_items`: Array com itens manuais

### Comuns:
- `_bireme_rc_title`: Título da seção
- `_bireme_rc_sub`: Subtítulo/descrição

## Função Helper

Use no template:

```php
$recent_data = bireme_get_lilacs_recent_meta(get_the_ID());
echo '<h2>' . $recent_data['title'] . '</h2>';
echo '<p>' . $recent_data['subtitle'] . '</p>';

foreach ($recent_data['items'] as $item) {
    echo '<div>';
    echo '<h3>' . $item['title'] . '</h3>';
    if (!empty($item['author'])) {
        echo '<p>Autor: ' . $item['author'] . '</p>';
    }
    if (!empty($item['source'])) {
        echo '<p>Fonte: ' . $item['source'] . '</p>';
    }
    if (!empty($item['url'])) {
        echo '<a href="' . $item['url'] . '">Ler mais</a>';
    }
    echo '</div>';
}
```

## Estrutura de Dados dos Items

### RSS:
```php
[
    'title' => 'Título da publicação',
    'url' => 'https://link-da-publicacao.com',
    'author' => 'Nome do Autor',
    'source' => 'Revista;Vol(Issue): páginas, data',
    'description' => 'Resumo truncado da publicação...'
]
```

### Manual:
```php
[
    'title' => 'Título da publicação',
    'url' => 'https://link-opcional.com'
]
```

## Logs de Erro

Erros de RSS são registrados no log do WordPress:
- Verifique `wp-content/debug.log` se habilitado
- Prefixo: "BIREME RSS Error:"

## Compatibilidade

- WordPress 5.0+
- PHP 7.4+
- Requer SimplePie (incluído no WordPress core)
- AJAX funciona apenas para usuários com permissão `edit_posts`
