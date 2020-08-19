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
                menuButton.addEventListener('click', function() {
                    location.reload(true)
                }.bind(this))
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



const _STATIC_POST_ELEMENT_FIELDS = {
    postElements: {},
}

class PostElement {
    constructor(post_id, title, username, created, text, parentNode, position='beforeend') {
        if (!['beforeend', 'afterbegin'].includes(position))
            throw "Position must be 'beforeend' or 'afterstart'."

        var html = this._createPostHTML(post_id, title, username, created, text)
        this.node = this._createPostNode(html, parentNode, position)

        this.post_id = post_id
        this.title = title
        this.username = username
        this.created = created

        this.textElement = this.node.querySelector('section p')

        this._set_buttons()
        
        _STATIC_POST_ELEMENT_FIELDS.postElements[post_id] = this
    }

    _createPostNode(html, parentNode, position) {
        parentNode.insertAdjacentHTML(position, html)
        if (position === 'afterbegin')
            return parentNode.querySelector('section.post:first-child')
        else
            return parentNode.querySelector('section.post:last-child')
    }

    _createPostHTML(post_id, title, username, created, text) {
        return `
            <section class="post" data-post-id="${post_id}" data-username="${username}">
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

    _set_buttons() {
        var footer = this.node.querySelector('footer')

        if (!footer)
            return
        if (this.username !== Helpers.getFromServer('username'))
            return

        var buttons = `
            <button type="button" class="js-edit primary modal-opener" data-modal-name="edit-post">Edit</button>
            <button type="button" class="js-delete secondary" data-post-id="${this.post_id}">Delete</button>
        `
        footer.insertAdjacentHTML(
            'beforeend',
            buttons
        )

        var buttonEdit = footer.querySelector('button.js-edit')
        
        Modal.addModalOpener(buttonEdit)
        buttonEdit.addEventListener('click', function() {
            Factories.updateEditForms(this.post_id, this.title, this.textElement.innerHTML)
        }.bind(this))

        var buttonDelete = footer.querySelector('button.js-delete')
        Factories.deletePostSingleFactory(buttonDelete)
    }



    getNode() {
        return this.node
    }



    static deletePostText(postId) {
        var post = _STATIC_POST_ELEMENT_FIELDS.postElements[postId]
        if (!post)
            return
        post.node.remove()
        delete _STATIC_POST_ELEMENT_FIELDS.postElements[postId]
    }

    static updatePostText(postId, newText) {
        var postElement = _STATIC_POST_ELEMENT_FIELDS.postElements[postId]
        if (!postElement)
            return
        postElement.textElement.innerText = newText
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
        
        this.postsElements = []

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
        this.postsElements.push(new PostElement(
            singleObj['id'], singleObj['title'], singleObj['username'],
            singleObj['created'], singleObj['post_text'],
            this.container, position
        ))
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
                callbackOnSuccess, callbackOnFailure, callbackOnResponse, callbackBeforeRequest,
                shouldBlockSubmit=false) {

        this.form = form

        this.callbackSetElements = callbackSetElements.bind(this)
        this.callbackGetParams = callbackGetParams.bind(this)
        this.callbackOnSuccess = callbackOnSuccess.bind(this)
        this.callbackOnFailure = callbackOnFailure.bind(this)
        this.callbackOnResponse = callbackOnResponse.bind(this)
        this.callbackBeforeRequest = callbackBeforeRequest.bind(this)
        this.callbackCheckSuccess = callbackCheckSuccess.bind(this)

        this.data = {}
        this.callbackSetElements()

        this.route = route
        this.method = method
        this.shouldBlockSubmit = shouldBlockSubmit

        this.blockedSubmit = false
        
        
        const addEventFunction = {
            FORM() {
                this.form.addEventListener('submit', function(e) {
                    e.preventDefault()
                    this.send()
                }.bind(this))
            },
            BUTTON() {
                this.form.addEventListener('click', function(e) {
                    e.preventDefault()
                    this.send()
                }.bind(this))
            }
        }[this.form.tagName] ?? function(){}

        addEventFunction.bind(this)()
    }

    send() {
        if (this.shouldBlockSubmit)
            this.blockSubmit()

        this.callbackBeforeRequest()
        Helpers.request(this.route, function(httpRequest) {
            if (this.callbackCheckSuccess(httpRequest.status))
                this.callbackOnSuccess()
            else
                this.callbackOnFailure()
            
            this.callbackOnResponse()
            
            this.unblockSubmit()
            if (typeof this.form.reset === 'function')
                this.form.reset()
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

    getDataKeys() {
        return Object.keys(this.data)
    }



    static getAllSenders(
            formQuery, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess, 
            callbackOnSuccess, callbackOnFailure, callbackOnResponse, callbackBeforeRequest,
            shouldBlockSubmit=false) {

        var formsElements = document.querySelectorAll(formQuery)
        var forms = []
        for (let formElement of formsElements) {
            try {
                forms.push(new GenericPostSender(
                    formElement, route, method,
                    callbackSetElements, callbackGetParams, callbackCheckSuccess, 
                    callbackOnSuccess, callbackOnFailure, callbackOnResponse, callbackBeforeRequest,
                    shouldBlockSubmit
                ))
            }
            catch (e) {
                console.log(formQuery+': '+e)
            }
        }
        return forms
    }
}



const _STATIC_FACTORIES_FIELDS = {
    editSenders: [],
    deleteSenders: [],
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
                    throw 'Item not found: '+dataKey
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
        var callbackBeforeRequest = function() {}

        var callbackCheckSuccess = function(statusCode) {
            return ([200, 201].includes(statusCode))
        }

        return GenericPostSender.getAllSenders(
            query, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess,
            callbackOnSuccess, callbackOnFailure, callbackOnResponse, callbackBeforeRequest,
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
                    throw 'Item not found: '+dataKey
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
        var callbackBeforeRequest = function() {}

        var callbackCheckSuccess = function(statusCode) {
            return (statusCode === 200)
        }

        var callbackOnResponse = function() {}

        return GenericPostSender.getAllSenders(
            query, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess,
            callbackOnSuccess, callbackOnFailure, callbackOnResponse, callbackBeforeRequest,
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
                    throw 'Item not found: '+dataKey
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
        var callbackBeforeRequest = function () {}

        var callbackCheckSuccess = function(statusCode) {
            return (statusCode === 201)
        }

        var callbackOnResponse = function() {}
        
        return GenericPostSender.getAllSenders(
            query, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess,
            callbackOnSuccess, callbackOnFailure, callbackOnResponse, callbackBeforeRequest,
            shouldBlockSubmit
        )
    }



    static editPostFactory() {

        var query = 'form.js-edit-post-form'

        var route = '/requests/posts/edit/'
        var method = 'post'
        var shouldBlockSubmit = true

        var callbackSetElements = function() {
            this
                .setData('id_element', this.form.querySelector('input[name="post-id"]'))
                .setData('title_element', this.form.querySelector('input[name="title"]'))
                .setData('post_text_element', this.form.querySelector('textarea[name="post-text"]'))
            
            for (let dataKey of ['id_element', 'title_element', 'post_text_element']) {
                if (!this.getData(dataKey))
                    throw 'Item not found: '+dataKey
            }
        }

        var callbackGetParams = function() {
            var id = this.getData('id_element').value
            var postText = this.getData('post_text_element').value
            var params = `id=${id}&post-text=${postText}`
            return params
        }

        var callbackOnSuccess = function () {
            PostElement.updatePostText(this.getData('id_element').value, this.getData('post_text_element').value)
            Modal.closeAllModals()
        }

        var callbackOnFailure = function () {}
        var callbackBeforeRequest = function () {}

        var callbackCheckSuccess = function(statusCode) {
            return (statusCode === 200)
        }

        var callbackOnResponse = function() {}
        
        var editSenders = GenericPostSender.getAllSenders(
            query, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess,
            callbackOnSuccess, callbackOnFailure, callbackOnResponse, callbackBeforeRequest,
            shouldBlockSubmit
        )

        _STATIC_FACTORIES_FIELDS.editSenders = [].concat(editSenders)
        return editSenders
    }

    static updateEditForms(id, title, postText) {
        for (let editSender of _STATIC_FACTORIES_FIELDS.editSenders) {
            editSender.getData('id_element').value = id
            editSender.getData('title_element').value = title
            editSender.getData('post_text_element').innerText = postText
        }
    }



    static deletePostFactory() {
        var query = 'button.js-delete'
        var formsElements = document.querySelectorAll(query)
        for (let formElement of formsElements) {
            Factories.deletePostSingleFactory(formElement)
        }
    }

    static deletePostSingleFactory(form) {

        var route = '/requests/posts/delete/'
        var method = 'post'
        var shouldBlockSubmit = true

        var callbackSetElements = function() {
            this.setData('post-id', this.form.getAttribute('data-post-id'))
            
            for (let dataKey of ['post-id']) {
                if (!this.getData(dataKey))
                    throw 'Item not found: '+dataKey
            }
        }

        var callbackGetParams = function() {
            var params = `post-id=${this.getData('post-id')}`
            return params
        }

        var callbackOnSuccess = function () {
            PostElement.deletePostText(this.getData('post-id'))
        }

        var callbackOnFailure = function () {}
        var callbackBeforeRequest = function () {}

        var callbackCheckSuccess = function(statusCode) {
            return (statusCode === 200)
        }

        var callbackOnResponse = function() {}
        
        var editSender = new GenericPostSender(
            form, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess,
            callbackOnSuccess, callbackOnFailure, callbackOnResponse, callbackBeforeRequest,
            shouldBlockSubmit
        )

        _STATIC_FACTORIES_FIELDS.deleteSenders.push(editSender)
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
                    throw 'Item not found: '+dataKey
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
        var callbackBeforeRequest = function () {}

        var callbackCheckSuccess = function(statusCode) {
            return (statusCode === 200)
        }

        var callbackOnResponse = function() {}
        
        return GenericPostSender.getAllSenders(
            query, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess,
            callbackOnSuccess, callbackOnFailure, callbackOnResponse, callbackBeforeRequest,
            shouldBlockSubmit
        )
    }



    static logoutUserFactory() {

        var query = 'button.js-logout'

        var route = '/requests/user/logout/'
        var method = 'post'
        var shouldBlockSubmit = false

        var callbackSetElements = function() {}

        var callbackGetParams = function() {
            var params = ''
            return params
        }

        var callbackOnSuccess = function () {
            location.reload('true')
        }

        var callbackOnFailure = function () {}
        var callbackBeforeRequest = function () {}

        var callbackCheckSuccess = function(statusCode) {
            return (statusCode === 200)
        }

        var callbackOnResponse = function() {}
        
        return GenericPostSender.getAllSenders(
            query, route, method,
            callbackSetElements, callbackGetParams, callbackCheckSuccess,
            callbackOnSuccess, callbackOnFailure, callbackOnResponse, callbackBeforeRequest,
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
    section_objects.editPostFactory = Factories.editPostFactory()
    section_objects.deletePostFactory = Factories.deletePostFactory()
    section_objects.deletePosts = Factories.deleteUserFactory()
    section_objects.logout = Factories.logoutUserFactory()
})