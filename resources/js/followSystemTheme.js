export default {
    mounted() {
        this.darkQuery = window.matchMedia('(prefers-color-scheme: dark)')
        this.applyDark = () => document.documentElement.classList.toggle('dark', this.darkQuery.matches)
        this.applyDark()
        this.darkQuery.addEventListener('change', this.applyDark)
    },

    unmounted() {
        this.darkQuery.removeEventListener('change', this.applyDark)
        document.documentElement.classList.remove('dark')
    },
}
