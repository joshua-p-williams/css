import Vue from 'vue'
import VueRouter from 'vue-router'

import ChangePassword from '../components/ChangePassword.vue'
import PermissionsIndex from '../components/cruds/Permissions/Index.vue'
import PermissionsCreate from '../components/cruds/Permissions/Create.vue'
import PermissionsShow from '../components/cruds/Permissions/Show.vue'
import PermissionsEdit from '../components/cruds/Permissions/Edit.vue'
import RolesIndex from '../components/cruds/Roles/Index.vue'
import RolesCreate from '../components/cruds/Roles/Create.vue'
import RolesShow from '../components/cruds/Roles/Show.vue'
import RolesEdit from '../components/cruds/Roles/Edit.vue'
import UsersIndex from '../components/cruds/Users/Index.vue'
import UsersCreate from '../components/cruds/Users/Create.vue'
import UsersShow from '../components/cruds/Users/Show.vue'
import UsersEdit from '../components/cruds/Users/Edit.vue'
import FaqCategoriesIndex from '../components/cruds/FaqCategories/Index.vue'
import FaqCategoriesCreate from '../components/cruds/FaqCategories/Create.vue'
import FaqCategoriesShow from '../components/cruds/FaqCategories/Show.vue'
import FaqCategoriesEdit from '../components/cruds/FaqCategories/Edit.vue'
import FaqQuestionsIndex from '../components/cruds/FaqQuestions/Index.vue'
import FaqQuestionsCreate from '../components/cruds/FaqQuestions/Create.vue'
import FaqQuestionsShow from '../components/cruds/FaqQuestions/Show.vue'
import FaqQuestionsEdit from '../components/cruds/FaqQuestions/Edit.vue'
import CategoriesIndex from '../components/cruds/Categories/Index.vue'
import CategoriesCreate from '../components/cruds/Categories/Create.vue'
import CategoriesShow from '../components/cruds/Categories/Show.vue'
import CategoriesEdit from '../components/cruds/Categories/Edit.vue'
import EventsIndex from '../components/cruds/Events/Index.vue'
import EventsCreate from '../components/cruds/Events/Create.vue'
import EventsShow from '../components/cruds/Events/Show.vue'
import EventsEdit from '../components/cruds/Events/Edit.vue'
import ContactCompaniesIndex from '../components/cruds/ContactCompanies/Index.vue'
import ContactCompaniesCreate from '../components/cruds/ContactCompanies/Create.vue'
import ContactCompaniesShow from '../components/cruds/ContactCompanies/Show.vue'
import ContactCompaniesEdit from '../components/cruds/ContactCompanies/Edit.vue'
import ContactsIndex from '../components/cruds/Contacts/Index.vue'
import ContactsCreate from '../components/cruds/Contacts/Create.vue'
import ContactsShow from '../components/cruds/Contacts/Show.vue'
import ContactsEdit from '../components/cruds/Contacts/Edit.vue'
import ScoresIndex from '../components/cruds/Scores/Index.vue'
import ScoresCreate from '../components/cruds/Scores/Create.vue'
import ScoresShow from '../components/cruds/Scores/Show.vue'
import ScoresEdit from '../components/cruds/Scores/Edit.vue'

Vue.use(VueRouter)

const routes = [
    { path: '/change-password', component: ChangePassword, name: 'auth.change_password' },
    { path: '/permissions', component: PermissionsIndex, name: 'permissions.index' },
    { path: '/permissions/create', component: PermissionsCreate, name: 'permissions.create' },
    { path: '/permissions/:id', component: PermissionsShow, name: 'permissions.show' },
    { path: '/permissions/:id/edit', component: PermissionsEdit, name: 'permissions.edit' },
    { path: '/roles', component: RolesIndex, name: 'roles.index' },
    { path: '/roles/create', component: RolesCreate, name: 'roles.create' },
    { path: '/roles/:id', component: RolesShow, name: 'roles.show' },
    { path: '/roles/:id/edit', component: RolesEdit, name: 'roles.edit' },
    { path: '/users', component: UsersIndex, name: 'users.index' },
    { path: '/users/create', component: UsersCreate, name: 'users.create' },
    { path: '/users/:id', component: UsersShow, name: 'users.show' },
    { path: '/users/:id/edit', component: UsersEdit, name: 'users.edit' },
    { path: '/faq-categories', component: FaqCategoriesIndex, name: 'faq_categories.index' },
    { path: '/faq-categories/create', component: FaqCategoriesCreate, name: 'faq_categories.create' },
    { path: '/faq-categories/:id', component: FaqCategoriesShow, name: 'faq_categories.show' },
    { path: '/faq-categories/:id/edit', component: FaqCategoriesEdit, name: 'faq_categories.edit' },
    { path: '/faq-questions', component: FaqQuestionsIndex, name: 'faq_questions.index' },
    { path: '/faq-questions/create', component: FaqQuestionsCreate, name: 'faq_questions.create' },
    { path: '/faq-questions/:id', component: FaqQuestionsShow, name: 'faq_questions.show' },
    { path: '/faq-questions/:id/edit', component: FaqQuestionsEdit, name: 'faq_questions.edit' },
    { path: '/categories', component: CategoriesIndex, name: 'categories.index' },
    { path: '/categories/create', component: CategoriesCreate, name: 'categories.create' },
    { path: '/categories/:id', component: CategoriesShow, name: 'categories.show' },
    { path: '/categories/:id/edit', component: CategoriesEdit, name: 'categories.edit' },
    { path: '/events', component: EventsIndex, name: 'events.index' },
    { path: '/events/create', component: EventsCreate, name: 'events.create' },
    { path: '/events/:id', component: EventsShow, name: 'events.show' },
    { path: '/events/:id/edit', component: EventsEdit, name: 'events.edit' },
    { path: '/contact-companies', component: ContactCompaniesIndex, name: 'contact_companies.index' },
    { path: '/contact-companies/create', component: ContactCompaniesCreate, name: 'contact_companies.create' },
    { path: '/contact-companies/:id', component: ContactCompaniesShow, name: 'contact_companies.show' },
    { path: '/contact-companies/:id/edit', component: ContactCompaniesEdit, name: 'contact_companies.edit' },
    { path: '/contacts', component: ContactsIndex, name: 'contacts.index' },
    { path: '/contacts/create', component: ContactsCreate, name: 'contacts.create' },
    { path: '/contacts/:id', component: ContactsShow, name: 'contacts.show' },
    { path: '/contacts/:id/edit', component: ContactsEdit, name: 'contacts.edit' },
    { path: '/scores', component: ScoresIndex, name: 'scores.index' },
    { path: '/scores/create', component: ScoresCreate, name: 'scores.create' },
    { path: '/scores/:id', component: ScoresShow, name: 'scores.show' },
    { path: '/scores/:id/edit', component: ScoresEdit, name: 'scores.edit' },
]

export default new VueRouter({
    mode: 'history',
    base: '/admin',
    routes
})
