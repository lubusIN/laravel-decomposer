export function dataTable(formattedPackages) {
    return {
        search: '',
        page: 1,
        perPage: 15,
        filter: 'all',
        data: formattedPackages || [],
        expandedRows: {},

        init() {
            // Hotkey '/' to focus search
            window.addEventListener('keydown', (e) => {
                if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
                    e.preventDefault();
                    const searchInput = document.getElementById('package-search-input');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }
            });
        },

        get hasDepsCount() {
            return this.data.filter(row => this.hasValidDependencies(row)).length;
        },

        get filteredData() {
            let list = this.data;

            if (this.filter === 'has-deps') {
                list = list.filter(row => this.hasValidDependencies(row));
            }

            if (!this.search.trim()) {
                return list;
            }

            const q = this.search.toLowerCase().trim();
            return list.filter(row =>
                (row.name && row.name.toLowerCase().includes(q)) ||
                (row.version && row.version.toLowerCase().includes(q)) ||
                (row.installed && row.installed.toLowerCase().includes(q)) ||
                (Array.isArray(row.dependencies) && row.dependencies.some(dep =>
                    (dep.name && dep.name.toLowerCase().includes(q)) ||
                    (dep.version && dep.version.toLowerCase().includes(q))
                ))
            );
        },

        paginatedData() {
            const start = (this.page - 1) * this.perPage;
            return this.filteredData.slice(start, start + this.perPage);
        },

        totalPages() {
            return Math.max(1, Math.ceil(this.filteredData.length / this.perPage));
        },

        setFilter(type) {
            this.filter = type;
            this.page = 1;
        },

        clearSearch() {
            this.search = '';
            this.page = 1;
        },

        toggleRow(name) {
            this.expandedRows[name] = !this.expandedRows[name];
        },

        isExpanded(name) {
            return !!this.expandedRows[name];
        },

        hasValidDependencies(row) {
            return Array.isArray(row.dependencies) &&
                row.dependencies.length > 0 &&
                row.dependencies[0].name !== 'N/A' &&
                row.dependencies[0].version !== 'No dependencies';
        },

        depCount(row) {
            if (!this.hasValidDependencies(row)) {
                return 0;
            }
            return row.dependencies.length;
        },

        vendorName(pkgName) {
            if (!pkgName || !pkgName.includes('/')) return '';
            return pkgName.split('/')[0] + '/';
        },

        packageName(pkgName) {
            if (!pkgName) return '';
            if (!pkgName.includes('/')) return pkgName;
            return pkgName.split('/')[1];
        }
    };
}
