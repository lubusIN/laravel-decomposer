export function reportComponent() {
    return {
        showReport: false,
        copied: false,
        isDark: false,

        init() {
            this.isDark = document.documentElement.classList.contains('dark');

            const observer = new MutationObserver(() => {
                this.isDark = document.documentElement.classList.contains('dark');
            });
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

            const textArea = document.getElementById('txt-report');
            if (textArea) {
                let s = textArea.value.trim();
                s = s.replace(/[ ]{2,}/g, ' ');
                s = s.replace(/\n /g, '\n');
                textArea.value = s;
            }
        },

        toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('decomposer-theme', 'light');
                this.isDark = false;
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('decomposer-theme', 'dark');
                this.isDark = true;
            }
        },

        getReportContent() {
            const el = this.$refs.reportText || document.getElementById('txt-report');
            return el ? el.value : '';
        },

        copyReport() {
            const content = this.getReportContent();
            if (!content) return;

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(content)
                    .then(() => {
                        this.copied = true;
                        setTimeout(() => this.copied = false, 2500);
                    })
                    .catch(() => {
                        this.fallbackCopy();
                    });
            } else {
                this.fallbackCopy();
            }
        },

        fallbackCopy() {
            const el = this.$refs.reportText || document.getElementById('txt-report');
            if (el) {
                el.select();
                document.execCommand('copy');
                this.copied = true;
                setTimeout(() => this.copied = false, 2500);
            }
        },

        downloadReport() {
            const content = this.getReportContent();
            if (!content) return;

            const blob = new Blob([content], { type: 'text/markdown;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `decomposer-report-${new Date().toISOString().slice(0, 10)}.md`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    };
}
