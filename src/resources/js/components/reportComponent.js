export function reportComponent() {
    return {
        showReport: false,
        copied: false,

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
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(reportText.value)
                    .then(() => {
                        this.copied = true;
                        setTimeout(() => this.copied = false, 2000);
                    })
                    .catch(err => {
                        console.error('Failed to copy: ', err);
                    });
            } else {
                reportText.select();
                document.execCommand('copy');
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            }
        }
    };
}