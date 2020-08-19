// Due to lack of support to static fields
const _STATIC_MODAL_FIELDS = {
    _modals: [],
}

class Modal {

    constructor(modal) {
        this.modal = modal
        this.buttonClose = this.modal.querySelector('.close')
        if (!this.buttonClose)
            throw 'Close button not found'
        
        var sectionElements = this.modal.querySelectorAll('.modal-content-container section')
        this.sections = {}
        for (let sectionElement of sectionElements) {
            this._set_modal_section(sectionElement)
        }

        var modalOpenerElements = document.getElementsByClassName('modal-opener')
        for (let modalOpenerElement of modalOpenerElements) {
            this._set_modal_opener(modalOpenerElement)
        }
        this.currentModalName = ''

        this.buttonClose.addEventListener('click', this.closeModal.bind(this))
        this.modal.addEventListener('click', function(e) {
            if (e.target === this.modal)
                this.closeModal()
        }.bind(this))

        _STATIC_MODAL_FIELDS._modals.push(this)
    }

    _set_modal_section(sectionElement) {
        var modalName = sectionElement.getAttribute('data-modal-name')
        if (!modalName)
            return false

        this.sections[modalName] = sectionElement
        return true
    }

    _set_modal_opener(modalOpenerElement) {
        var modalName = modalOpenerElement.getAttribute('data-modal-name')
        if (!modalName || !this.sections.hasOwnProperty(modalName))
            return false

        modalOpenerElement.addEventListener('click', function() {
            this.openModal(modalName)
        }.bind(this))

        return true
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


    
    static closeAllModals() {
        for (let modal of _STATIC_MODAL_FIELDS._modals) {
            modal.closeModal()
        }
    }
    
    static addModalOpener(modalOpenerElement) {
        for (let modal of _STATIC_MODAL_FIELDS._modals) {
            if (modal._set_modal_opener(modalOpenerElement))
                return true
        }
        return false
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


const _STATIC_POST_GETTER_FIELDS = {
    postGetters: [],
}
class PostsGetter {
    constructor() {
        this.PERIOD_BETWEEN_REQUESTS = 100

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

        _STATIC_POST_GETTER_FIELDS.postGetters.push(this)
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

    loadPost(singleObj, position='beforeend') {
        if (!PostsGetter._checkSingleObj(singleObj))
            return
        this.container.insertAdjacentHTML(
            position,
            this.createPost(singleObj['title'], singleObj['username'], singleObj['created'], singleObj['post_text'])
        )
        
        if (position == 'beforeend')
            var footer = this.container.querySelector('section:last-child footer')
        else
            var footer = this.container.querySelector('section:first-child footer')
        if (!footer)
            return
        if (singleObj['username'] === Helpers.getFromServer('username')) {
            var buttons = `
                <button type="button" class="edit primary">Edit</button>
                <button type="button" class="delete secondary">Delete</button>
            `
            footer.insertAdjacentHTML(
                'beforeend',
                buttons
            )
        }
    }

    createPost(title, username, created, text) {
        return `
            <section class="post" data-username="${username}">
                <header>
                <h2>${title}</h2>
                <div class="post-data">
                    <span class="post-username">Posted by <em>${username!==null ? username : '[deleted]'}</em></span>
                    <span class="post-created"> at ${created}.</span>
                </div>
                </header>
                <section>
                    <p>${text}</p>
                </section>
                <footer>
                    
                </footer>
            </section>
        `
    }

    toggleNoMorePostsMessage() {
        // TODO
    }


    static _checkSingleObj(singleObj) {
        for (let key of ['id', 'title', 'username', 'created', 'post_text']) {
            if (singleObj[key] === undefined)
                return false
        }
        return true
    }

    static addPostAll(singleObj, position='afterbegin') {
        if (!PostsGetter._checkSingleObj(singleObj))
            return
        for (let postsGetter of _STATIC_POST_GETTER_FIELDS.postGetters) {
            postsGetter.loadPost(singleObj, position)
        }
    }
}


/**
 * Holds a form, submits the form and does
 * something upon success or failure.
 */
class GenericPostSender {
    
    constructor(form, route, method,
                callbackSetElements, callbackGetParams, callbackCheckSuccess, 
                callbackOnSuccess, callbackOnFailure, callbackOnResponse,
                shouldBlockSubmit=false) {

        this.form = form

        this.callbackSetElements = callbackSetElements.bind(this)
        this.callbackGetParams = callbackGetParams.bind(this)
        this.callbackOnSuccess = callbackOnSuccess.bind(this)
        this.callbackOnFailure = callbackOnFailure.bind(this)
        this.callbackOnResponse = callbackOnResponse.bind(this)
        this.callbackCheckSuccess = callbackCheckSuccess.bind(this)

        this.data = {}
        this.callbackSetElements()

        this.route = route
        this.method = method
        this.shouldBlockSubmit = shouldBlockSubmit

        this.blockedSubmit = false
        
        this.form.addEventListener('submit', function(e) {
            e.preventDefault()
            this.send()
        }.bind(this))
    }

    send() {
        if (this.shouldBlockSubmit)
            this.blockSubmit()

        Helpers.request(this.route, function(httpRequest) {
            if (this.callbackCheckSuccess(httpRequest.status))
                this.callbackOnSuccess()
            else
                this.callbackOnFailure()
            
            this.unblockSubmit()
            this.form.reset()
            this.callbackOnResponse()
        }.bind(this), this.method, this.callbackGetParams())
    }

    blockSubmit() {
        this.blockedSubmit = true
    }

    unblockSubmit() {
        this.blockedSubmit = false
    }

    setData(key, value) {
        this.data[key] = value
        return this
    }

    getData(key) {
        return this.data[key]
    }



    static getAllSenders(
            formQuery, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess, 
            callbackOnSuccess, callbackOnFailure, callbackOnResponse,
            shouldBlockSubmit=false) {

        var formsElements = document.querySelectorAll(formQuery)
        var forms = []
        for (let formElement of formsElements) {
            try {
                forms.push(new GenericPostSender(
                    formElement, route, method,
                    callbackSetElements, callbackGetParams, callbackCheckSuccess, 
                    callbackOnSuccess, callbackOnFailure, callbackOnResponse,
                    shouldBlockSubmit
                ))
            }
            catch {
                continue
            }
        }
        return forms
    }
}



class Factories {
    constructor() {
        throw 'Cannot instantiate Factories class'
    }

    static registerFormsFactory() {

        var query = 'form.js-register-form'

        var route = '/requests/user/register/'
        var method = 'post'
        var shouldBlockSubmit = false

        var callbackSetElements = function() {
            this
                .setData('username', this.form.querySelector('input[name="username"]'))
                .setData('email', this.form.querySelector('input[name="email"]'))
                .setData('password', this.form.querySelector('input[name="password"]'))
                .setData('password_repeat', this.form.querySelector('input[name="password-repeat"]'))
            
            for (let dataKey of ['username', 'email', 'password', 'password_repeat']) {
                if (!this.getData(dataKey))
                    throw 'Items not found'
            }
        }

        var callbackGetParams = function() {
            var params = 
                `username=${this.getData('username').value}`
                +`&email=${this.getData('email').value}`
                +`&password=${this.getData('password').value}`
                +`&password-repeat=${this.getData('password_repeat').value}`
            return params
        }

        var callbackOnSuccess = function () {}
        var callbackOnFailure = function () {}
        var callbackOnResponse = function() {}

        var callbackCheckSuccess = function(statusCode) {
            return ([200, 201].includes(statusCode))
        }

        return GenericPostSender.getAllSenders(
            query, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess,
            callbackOnSuccess, callbackOnFailure, callbackOnResponse,
            shouldBlockSubmit
        )
    }

    static loginFormsFactory() {

        var query = 'form.js-login-form'

        var route = '/requests/user/login/'
        var method = 'post'
        var shouldBlockSubmit = false

        var callbackSetElements = function() {
            this
                .setData('username', this.form.querySelector('input[name="username"]'))
                .setData('password', this.form.querySelector('input[name="password"]'))
                .setData('remember', this.form.querySelector('input[name="remember"]'))
            
            for (let dataKey of ['username', 'password', 'remember']) {
                if (!this.getData(dataKey))
                    throw 'Items not found'
            }
        }

        var callbackGetParams = function() {
            var params = 
                `username=${this.getData('username').value}`
                +`&password=${this.getData('password').value}`
                +`${this.getData('remember').checked ? '&remember' : ''}`
            return params
        }

        var callbackOnSuccess = function() {
            location.reload(true)
        }

        var callbackOnFailure = function() {}

        var callbackCheckSuccess = function(statusCode) {
            return (statusCode === 200)
        }

        var callbackOnResponse = function() {}

        return GenericPostSender.getAllSenders(
            query, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess,
            callbackOnSuccess, callbackOnFailure, callbackOnResponse,
            shouldBlockSubmit
        )
    }

    static sendPostFactory() {

        var query = 'form.create-post-form'

        var route = '/requests/posts/post/'
        var method = 'post'
        var shouldBlockSubmit = true

        var callbackSetElements = function() {
            this
                .setData('title_element', this.form.querySelector('input[name="title"]'))
                .setData('post_text_element', this.form.querySelector('textarea[name="post-text"]'))
            
            for (let dataKey of ['title_element', 'post_text_element']) {
                if (!this.getData(dataKey))
                    throw 'Items not found'
            }
        }

        var callbackGetParams = function() {
            var title = this.getData('title_element').value
            var postText = this.getData('post_text_element').value
            var params = `title=${title}&post-text=${postText}`
            return params
        }

        var callbackOnSuccess = function () {
            PostsGetter.addPostAll({
                id: 0,
                username: Helpers.getFromServer('username'),
                title: this.getData('title_element').value,
                post_text: this.getData('post_text_element').value,
                created: 'now'
            }, 'afterbegin')
            Modal.closeAllModals()
        }

        var callbackOnFailure = function () {}

        var callbackCheckSuccess = function(statusCode) {
            return (statusCode === 201)
        }

        var callbackOnResponse = function() {}
        
        return GenericPostSender.getAllSenders(
            query, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess,
            callbackOnSuccess, callbackOnFailure, callbackOnResponse,
            shouldBlockSubmit
        )
    }

    static deleteUserFactory() {

        var query = 'form.js-delete-account-form'

        var route = '/requests/user/delete/'
        var method = 'post'
        var shouldBlockSubmit = false

        var callbackSetElements = function() {
            this
                .setData('username', this.form.querySelector('input[name="username"]'))
                .setData('password', this.form.querySelector('input[name="password"]'))
            
            for (let dataKey of ['username', 'password']) {
                if (!this.getData(dataKey))
                    throw 'Items not found'
            }
        }

        var callbackGetParams = function() {
            var username = this.getData('username').value
            var password = this.getData('password').value
            var params = `username=${username}&password=${password}`
            return params
        }

        var callbackOnSuccess = function () {
            location.reload('true')
        }

        var callbackOnFailure = function () {}

        var callbackCheckSuccess = function(statusCode) {
            return (statusCode === 200)
        }

        var callbackOnResponse = function() {}
        
        return GenericPostSender.getAllSenders(
            query, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess,
            callbackOnSuccess, callbackOnFailure, callbackOnResponse,
            shouldBlockSubmit
        )
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

    /**
     * Modified from:
     * https://stackoverflow.com/questions/10730362/get-cookie-by-name
     */
    static getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        
        if (parts.length !== 2)
            return undefined
        
        return parts.pop().split(';').shift();
    }

    static getFromServer(name) {
        if (fromServer === undefined)
            throw 'fromServer undefined'
        if (!fromServer.hasOwnProperty(name))
            undefined
        return fromServer[name]
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
    section_objects.postSender = Factories.sendPostFactory()
    section_objects.loginForms = Factories.loginFormsFactory()
    section_objects.registerForms = Factories.registerFormsFactory()
    section_objects.deletePosts = Factories.deleteUserFactory()
})