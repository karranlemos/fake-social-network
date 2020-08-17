class Modal {

    constructor(modal) {
        this.modal = modal
        this.buttonClose = this.modal.querySelector('.close')
        if (!this.buttonClose)
            throw 'Close button not found'
        
        var sectionElements = this.modal.querySelectorAll('.modal-content-container section')
        this.sections = {}
        for (let sectionElement of sectionElements) {
            let modalName = sectionElement.getAttribute('data-modal-name')
            if (!modalName)
                continue
            this.sections[modalName] = sectionElement
        }

        var modalOpenerElements = document.getElementsByClassName('modal-opener')
        for (let modalOpenerElement of modalOpenerElements) {
            let modalName = modalOpenerElement.getAttribute('data-modal-name')
            if (!modalName || !this.sections.hasOwnProperty(modalName))
                continue
            modalOpenerElement.addEventListener('click', function() {
                this.openModal(modalName)
            }.bind(this))
        }
        this.currentModalName = ''

        this.buttonClose.addEventListener('click', this.closeModal.bind(this))
        this.modal.addEventListener('click', function(e) {
            if (e.target === this.modal)
                this.closeModal()
        }.bind(this))
    }

    closeModal() {
        this.modal.classList.remove('show')
        this.sections[this.currentModalName].classList.remove('show')
        this.currentModalName = ''
    }

    openModal(modalName) {
        this.modal.classList.add('show')
        this.sections[modalName].classList.add('show')
        this.currentModalName = modalName
    }


    
    static getAllModals() {
        var modalDivs = document.querySelectorAll('div.modal')
        var modals = []
        for (let modalDiv of modalDivs) {
            try {
                modals.push(new Modal(modalDiv))
            }
            catch {
                continue
            }
        }
        return modals
    }
}



class NavMenu {

    constructor(nav) {
        this.nav = nav
        this.menuOpenerButtons = this.nav.querySelectorAll('.mobile-menu-button')
        if (this.menuOpenerButtons.length === 0)
            return
        for (let menuOpenerButton of this.menuOpenerButtons) {
            menuOpenerButton.addEventListener('click', this.toggleMenu.bind(this))
        }

        this.menuButtons = this.nav.querySelectorAll('.nav-button:not(.mobile-menu-button)')
        for (let menuButton of this.menuButtons) {
            menuButton.addEventListener('click', this.closeMenu.bind(this))
            if (menuButton.classList.contains('home-button')) {
                menuButton.addEventListener('click', this.goToTopOfPage.bind(this))
            }
        }
    }

    toggleMenu() {
        this.nav.classList.toggle('mobile-show')
    }

    closeMenu() {
        this.nav.classList.remove('mobile-show')
    }

    goToTopOfPage() {
        window.scrollTo(0, 0)
    }



    static getAllNavMenus() {
        var navMenuElements = document.getElementsByTagName('nav')
        var navMenus = []
        for (let navMenuElement of navMenuElements) 
            navMenus.push(new NavMenu(navMenuElement))
        return navMenus
    }
}



var section_objects = {}
window.addEventListener('load', function() {
    section_objects.modals = Modal.getAllModals()
    section_objects.navMenus = NavMenu.getAllNavMenus()
})