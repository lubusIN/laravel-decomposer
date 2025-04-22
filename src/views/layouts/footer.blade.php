<!-- Alpine JS -->
<script src="{{ asset('lubusin/laravel-decomposer/dist/app.js') }}" defer></script>
<script>
    //System report section handeling
    function reportComponent() {
        return {
            showReport: false,
            init() {

                const textArea = document.getElementById('txt-report');
                if (textArea) {
                    let s = textArea.value.trim();
                    s = s.replace(/[ ]{2,}/g, ' ');
                    s = s.replace(/\n /g, '\n');
                    textArea.value = s;
                }
            },
            copyReport() {
                const reportText = this.$refs.reportText;
                reportText.select();
                document.execCommand("copy");
            }
        };
    }

    //Apline JS Datatable
    function dataTable() {
        return {
            search: '',
            page: 1,
            perPage: 10,
            data: @json($formattedPackages),

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
</script>