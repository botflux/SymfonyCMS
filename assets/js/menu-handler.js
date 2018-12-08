export class MenuHandler {
    constructor (config) {
        this.menu = document.querySelector(config.menuSelector)
        this.navLinks = document.querySelectorAll(config.navLinkSelector)
        this.nav = document.querySelector(config.navSelector)
        this.navActive = config.navActive
        this.init()
    }

    init () {
        this.menu.addEventListener('click', () => {
            this.nav.classList.toggle(this.navActive)
        })
        this.navLinks.forEach(n => {
            n.addEventListener('click', () => {
                this.nav.classList.toggle(this.navActive)
            })
        })
    }
}

new MenuHandler({
    menuSelector: '[data-menu]',
    navLinkSelector: '.nav-link',
    navSelector: '[data-nav]',
    navActive: 'nav--active'
})
