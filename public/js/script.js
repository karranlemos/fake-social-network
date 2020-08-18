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
        this.PERIOD_BETWEEN_REQUESTS = 1000

        this.container = document.getElementById('dashboard-posts-container')

        if (!this.container)
            throw 'No container found'

        this.page = 0
        this.pageLength = 2
        this.noMorePosts = false
        this.lastRequest = Date.now()-this.PERIOD_BETWEEN_REQUESTS

        window.addEventListener('scroll', function() {
            if (Date.now()-this.lastRequest < this.PERIOD_BETWEEN_REQUESTS)
                return
            this.lastRequest = Date.now()
            if (window.outerHeight < this.container.getBoundingClientRect().bottom)
                return
            this.getAndLoadPosts()
            
        }.bind(this))

        this.getAndLoadPosts()
    }

    getAndLoadPosts() {
        if (this.noMorePosts)
            return

        var params = `page=${++this.page}&number-rows=${this.pageLength}`
        Helpers.request(`/requests/posts/get/?${params}`, function(httpRequest) {
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
        }.bind(this))
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



class PostSender {

    constructor(form) {
        this.form = form
        this.blockedSubmit = false

        this.titleElement = this.form.querySelector('input[name="title"]')
        this.postTextElement = this.form.querySelector('textarea[name="post-text"]')
        if (!this.titleElement || !this.postTextElement)
            throw 'Cannot find fields'

        this.form.addEventListener('submit', function(e) {
            e.preventDefault()
            this.sendPost()
        }.bind(this))


        this.getAndLoadPosts()
    }

    sendPost() {
        if (this.blockedSubmit)
            return
        this.blockSubmit()
        
        var title = this.titleElement.value
        var postText = this.postTextElement.value
        var params = `title=${title}&post-text=${postText}`
        
        Helpers.request('/requests/posts/post/', function(httpRequest) {
            if (httpRequest.status === 201)
                this.showSuccessMessage()
            else
                this.showFailureMessage()
            
            this.unblockSubmit()            
        }.bind(this), 'post', params)
    }

    showSuccessMessage() {
        
    }

    showFailureMessage() {

    }

    blockSubmit() {
        this.blockedSubmit = true
    }

    unblockSubmit() {
        this.blockedSubmit = false
    }



    static getAllPostSenders() {
        var formsElements = document.querySelectorAll('form.create-post-form')
        var forms = []
        for (let formElement of formsElements) {
            try {
                forms.push(new PostSender(formElement))
            }
            catch {
                continue
            }
        }
        return forms
    }
}



class LoginForm {

    constructor(loginForm) {
        this.loginForm = loginForm
        this.username = this.loginForm.querySelector('input[name="username"]')
        this.password = this.loginForm.querySelector('input[name="password"]')
        this.remember = this.loginForm.querySelector('input[name="remember"]')
        if (!this.username || !this.password || !this.remember)
            throw 'Items not found'
        this.loginForm.addEventListener('submit', function(e) {
            e.preventDefault()
            this.sendLoginCredentials()
        }.bind(this))
    }

    sendLoginCredentials() {
        var params = 
            `username=${this.username.value}`
            +`&password=${this.password.value}`
            +`${this.remember.checked ? '&remember' : ''}`
        
        Helpers.request('/requests/user/login/', function(httpRequest) {
            if (httpRequest.status === 200) {
                this.doLoginSuccess()
            }
            else if (httpRequest.status === 401) {
                this.doLoginFailure()
            }
        }.bind(this), 'post', params)
    }

    doLoginSuccess() {
        location.reload(true)
    }

    doLoginFailure() {

    }



    static getAllLoginForms() {
        var loginFormsElements = document.querySelectorAll('form.js-login-form')
        var loginForms = []
        for (let loginFormElement of loginFormsElements) {
            try {
                loginForms.push(new LoginForm(loginFormElement))
            }
            catch {
                continue
            }
        }
        return loginForms
    }
}



class RegisterForm {

    constructor(registerForm) {
        this.registerForm = registerForm
        this.username = this.registerForm.querySelector('input[name="username"]')
        this.email = this.registerForm.querySelector('input[name="email"]')
        this.password = this.registerForm.querySelector('input[name="password"]')
        this.password_repeat = this.registerForm.querySelector('input[name="password-repeat"]')
        if (!this.username || !this.email || !this.password || !this.password_repeat)
            throw 'Items not found'

        this.registerForm.addEventListener('submit', function(e) {
            e.preventDefault()
            this.sendRegistration()
        }.bind(this))
    }

    sendRegistration() {
        var params = 
            `username=${this.username.value}`
            +`&email=${this.email.value}`
            +`&password=${this.password.value}`
            +`&password-repeat=${this.password_repeat.value}`
        
        Helpers.request('/requests/user/register/', function(httpRequest) {
            if (httpRequest.status === 200) {
                this.doRegistrationSuccess()
            }
            else if (httpRequest.status === 401) {
                this.doRegistrationFailure()
            }
        }.bind(this), 'post', params)
    }

    doRegistrationSuccess() {
        
    }

    doRegistrationFailure() {

    }



    static getAllRegisterForms() {
        var registerFormsElements = document.querySelectorAll('form.js-register-form')
        var registerForms = []
        for (let registerFormElement of registerFormsElements) {
            try {
                registerForms.push(new RegisterForm(registerFormElement))
            }
            catch {
                continue
            }
        }
        return registerForms
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
    section_objects.postSender = PostSender.getAllPostSenders()
    section_objects.loginForms = LoginForm.getAllLoginForms()
    section_objects.registerForms = RegisterForm.getAllRegisterForms()
})