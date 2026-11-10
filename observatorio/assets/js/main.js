/**
 * Theme scripts.
 */

// Copy a publication URL using the browser clipboard when available.
document.addEventListener('click', async function(event) {
 const button = event.target.closest('.publication-copy-link');
 if (!button) return;
 if (!navigator.clipboard || !window.isSecureContext) { window.prompt('Copie o link:', button.dataset.url); return; }
 try { await navigator.clipboard.writeText(button.dataset.url); button.textContent = 'Link copiado'; } catch (error) { window.prompt('Copie o link:', button.dataset.url); }
});
