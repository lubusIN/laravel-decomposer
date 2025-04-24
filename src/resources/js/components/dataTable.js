export function dataTable(formattedPackages) {
    return {
        search: '',
        page: 1,
        perPage: 10,
        data: formattedPackages,

        init() {
            // Optional initialization
        },
        
        get filteredData() {
            if (!this.search) return this.data;
            return this.data.filter(row =>
                row.name.toLowerCase().includes(this.search.toLowerCase()) ||
                row.version.toLowerCase().includes(this.search.toLowerCase()) ||
                row.dependencies.some(dep =>
                    dep.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    dep.version.toLowerCase().includes(this.search.toLowerCase())
                )
            );
        },

        paginatedData() {
            const start = (this.page - 1) * this.perPage;
            return this.filteredData.slice(start, start + this.perPage);
        },

        totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        }
    }
}