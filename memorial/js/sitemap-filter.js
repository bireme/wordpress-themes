(() => {
    const field = document.querySelector('#sitemap-query');
    const nav = document.querySelector('#sitemap-navigation');
    const status = document.querySelector('#sitemap-status');
    const clear = document.querySelector('#sitemap-clear');
    const root = nav?.querySelector(':scope > ul');
    if (!field || !root || !status || !clear) return;

    const normalize = (text) => text.normalize('NFD').replace(/\p{M}/gu, '').toLowerCase().trim();

    function readBranch(list) {
        return Array.from(list.children, (item) => {
            const label = item.querySelector(':scope > h2, :scope > a, :scope > span');
            const children = item.querySelector(':scope > ul');
            return {
                item,
                label: normalize(label?.textContent ?? ''),
                children: children ? readBranch(children) : [],
            };
        });
    }

    const tree = readBranch(root);
    function filter(branch, terms, parentMatches = false) {
        let any = false;
        for (const node of branch) {
            const matches = parentMatches || terms.every((term) => node.label.includes(term));
            const childMatches = filter(node.children, terms, matches);
            const visible = matches || childMatches;
            node.item.hidden = !visible;
            any = any || visible;
        }
        return any;
    }

    function update() {
        const query = normalize(field.value);
        const visible = filter(tree, query ? query.split(/\s+/) : []);
        clear.hidden = field.value.length === 0;
        status.classList.toggle('sitemap-no-results', !visible);
        status.textContent = query ? (visible ? status.dataset.found : status.dataset.empty) : '';
    }

    function reset() {
        field.value = '';
        field.focus();
        update();
    }

    field.addEventListener('input', update);
    field.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && field.value) {
            event.preventDefault();
            reset();
        }
    });
    clear.addEventListener('click', reset);
    update();
    field.closest('.sitemap-filter').hidden = false;
})();
