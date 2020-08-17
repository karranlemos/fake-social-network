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

var section_objects = {}
window.addEventListener('load', function() {
    section_objects.modals = Modal.getAllModals()
})