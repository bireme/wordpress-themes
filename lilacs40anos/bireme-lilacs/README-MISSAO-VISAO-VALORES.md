# Missão, Visão e Valores - LILACS

## Funcionalidade Implementada

Foi adicionada uma nova seção de **Missão, Visão e Valores** na página "Sobre LILACS", logo após as características principais. Esta seção é totalmente editável através do painel administrativo.

## Localização

- **Template**: `templates/parts/section-o-que-e-a-lilacs.php`
- **Metabox Admin**: `inc/admin/meta-templates/page-lilacs-sobre-fields.php`
- **Posição**: Entre as "Características principais" e "Revistas Indexadas"

## Como Usar no Admin

### 1. Acesso ao Painel
1. Acesse uma página que usa o template `page-lilacs-sobre.php`
2. Procure pela metabox **"LILACS Sobre – Campos Editáveis"**
3. Clique na aba **"Missão, Visão e Valores"**

### 2. Campos Disponíveis
Para cada um dos 3 itens (Missão, Visão, Valores):
- **Título**: Nome do item (padrão: "Missão", "Visão", "Valores")
- **Descrição**: Texto explicativo de cada conceito

### 3. Conteúdo Padrão
Se nenhum valor for inserido, serão usados os seguintes textos:

**Missão:**
> Democratizar o acesso à informação científica e técnica em saúde da América Latina e Caribe, promovendo a equidade e colaboração entre países para fortalecer os sistemas de saúde regionais.

**Visão:**
> Ser a principal fonte de referência em informação científica em saúde da região, reconhecida globalmente pela qualidade, abrangência e contribuição para o desenvolvimento da ciência e pesquisa em saúde.

**Valores:**
> Colaboração, transparência, equidade, excelência científica, acesso aberto ao conhecimento e compromisso com o desenvolvimento regional da saúde pública.

## Design e Layout

### Características Visuais
- **Layout**: Grid responsivo de 3 colunas (empilha no mobile)
- **Background**: Cor de fundo diferenciada (`#f8f9fa`)
- **Cards**: Fundo branco com bordas arredondadas e sombras
- **Ícones**: Emojis específicos para cada item:
  - 🎯 Missão
  - 👁️ Visão
  - 💎 Valores
- **Efeitos**: Hover com elevação dos cards
- **Borda superior**: Gradiente azul como destaque

### CSS Classes
```css
.mvv-section        /* Seção principal */
.mvv-container      /* Container do grid */
.mvv-card          /* Card individual */
.mvv-card h3       /* Título do card */
.mvv-card p        /* Descrição do card */
.mvv-icon          /* Ícone circular */
```

## Responsividade

### Desktop (>768px)
- Grid de 3 colunas
- Cards lado a lado
- Padding generoso

### Tablet (≤768px) 
- Grid de 1 coluna
- Cards empilhados
- Espaçamento reduzido

### Mobile (≤480px)
- Layout compacto
- Ícones menores
- Texto otimizado

## Campos Salvos no Banco

Os dados são salvos como meta_post com as seguintes chaves:

```php
// Missão (item 1)
'_lilacs_mvv_1_title' => 'Missão'
'_lilacs_mvv_1_text'  => 'Texto da missão...'

// Visão (item 2) 
'_lilacs_mvv_2_title' => 'Visão'
'_lilacs_mvv_2_text'  => 'Texto da visão...'

// Valores (item 3)
'_lilacs_mvv_3_title' => 'Valores'
'_lilacs_mvv_3_text'  => 'Texto dos valores...'
```

## Outras Abas do Painel Admin

O metabox "LILACS Sobre" também inclui controle de outros elementos da página:

### 1. **Introdução**
- Título da seção
- 3 parágrafos editáveis

### 2. **Características** 
- 3 características principais
- Título e descrição para cada

### 3. **Nuvem de Palavras**
- Lista de palavras (uma por linha ou separadas por vírgula)

### 4. **Estilo**
- Espaçamento superior/inferior
- Cor de fundo da seção

## Compatibilidade

- ✅ WordPress 5.0+
- ✅ PHP 7.4+
- ✅ Responsive design
- ✅ Acessibilidade
- ✅ SEO-friendly

## Personalização

Para personalizar os ícones dos cards, edite o array `$icons` em `section-o-que-e-a-lilacs.php`:

```php
$icons = [
    1 => '🎯', // Missão
    2 => '👁️', // Visão  
    3 => '💎'  // Valores
];
```

## Manutenção

- Os campos mantêm valores padrão mesmo se não preenchidos
- Cache não é utilizado (conteúdo dinâmico)
- Sanitização automática de dados
- Validação de nonce para segurança