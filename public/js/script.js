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
        var modalDivs = document.querySelectorAll('div.js-modal')
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



class PostsGetter {
    constructor() {
        this.container = document.getElementById('dashboard-posts-container')

        if (!this.container)
            throw 'No container found'

        this.page = 0
        this.pageLength = 10
        this.noMorePosts = false

        window.addEventListener('scroll', function() {
            if (window.outerHeight < this.container.getBoundingClientRect().bottom)
                return
            this.getAndLoadPosts()
            
        }.bind(this))

        this.getAndLoadPosts()
    }

    getAndLoadPosts() {
        if (this.noMorePosts)
            return

        var params = `ajax&ajax-posts-page=${++this.page}&ajax-posts-number=${this.pageLength}`
        Helpers.request('/dashboard.php', function(httpRequest) {
            if (httpRequest.status !== 200)
                return
            if (httpRequest.responseText === '')
                return
                
            try {
                var jsonObj = JSON.parse(httpRequest.responseText)
            }
            catch (e) {
                return
            }

            this.loadPosts(jsonObj)
        }.bind(this), 'post', params)
    }

    loadPosts(jsonObj) {
        if (jsonObj.length === 0) {
            this.noMorePosts = true
            this.toggleNoMorePostsMessage()
            return
        }
        for (let singleObj of jsonObj) {
            this.loadPost(singleObj)                
        }
    }

    loadPost(singleObj) {
        for (let key of ['title', 'username', 'created', 'post_text']) {
            if (singleObj[key] === undefined)
                return       
        }
        this.container.insertAdjacentHTML(
            'beforeend',
            this.createPost(singleObj['title'], singleObj['username'], singleObj['created'], singleObj['post_text'])
        )
    }

    createPost(title, username, created, text) {
        return `
            <section class="post">
                <header>
                <h2>${title}</h2>
                <div class="post-data">
                    <span class="post-username">Posted by <em>${username}</em></span>
                    <span class="post-created"> at ${created}.</span>
                </div>
                </header>
                <section>
                    <p>${text}</p>
                </section>
            </section>
        `
    }

    toggleNoMorePostsMessage() {
        // TODO
    }
}



class Helpers {
    constructor() {
        throw 'Cannot instantiate Helpers class'
    }

    static request(url, callback, method='get', params='') {
        var httpRequest = new XMLHttpRequest()
        if (!httpRequest)
            return false
        
        httpRequest.onload = function() {
            callback(httpRequest)
        }
        
        httpRequest.open(method, url)
        httpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        httpRequest.send(params)
    }
}



var section_objects = {}
window.addEventListener('load', function() {
    section_objects.modals = Modal.getAllModals()
    section_objects.navMenus = NavMenu.getAllNavMenus()
    try {
        section_objects.postGetter = new PostsGetter()
    }
    catch {
        // Do nothing
    }
})