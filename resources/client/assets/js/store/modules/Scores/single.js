function initialState() {
    return {
        item: {
            id: null,
            event: null,
            company: null,
            contact: null,
            score: null,
        },
        eventsAll: [],
        contactcompaniesAll: [],
        contactsAll: [],
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    eventsAll: state => state.eventsAll,
    contactcompaniesAll: state => state.contactcompaniesAll,
    contactsAll: state => state.contactsAll,
    
}

const actions = {
    storeData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== 'object') {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(fieldName + '[' + index + ']', fieldValue[index]);
                        }
                    }
                }
            }

            if (_.isEmpty(state.item.event)) {
                params.set('event_id', '')
            } else {
                params.set('event_id', state.item.event.id)
            }
            if (_.isEmpty(state.item.company)) {
                params.set('company_id', '')
            } else {
                params.set('company_id', state.item.company.id)
            }
            if (_.isEmpty(state.item.contact)) {
                params.set('contact_id', '')
            } else {
                params.set('contact_id', state.item.contact.id)
            }

            axios.post('/api/v1/scores', params)
                .then(response => {
                    commit('resetState')
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors  = error.response.data.errors

                    dispatch(
                        'Alert/setAlert',
                        { message: message, errors: errors, color: 'danger' },
                        { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setLoading', false)
                })
        })
    },
    updateData({ commit, state, dispatch }) {
        commit('setLoading', true)
        dispatch('Alert/resetState', null, { root: true })

        return new Promise((resolve, reject) => {
            let params = new FormData();
            params.set('_method', 'PUT')

            for (let fieldName in state.item) {
                let fieldValue = state.item[fieldName];
                if (typeof fieldValue !== 'object') {
                    params.set(fieldName, fieldValue);
                } else {
                    if (fieldValue && typeof fieldValue[0] !== 'object') {
                        params.set(fieldName, fieldValue);
                    } else {
                        for (let index in fieldValue) {
                            params.set(fieldName + '[' + index + ']', fieldValue[index]);
                        }
                    }
                }
            }

            if (_.isEmpty(state.item.event)) {
                params.set('event_id', '')
            } else {
                params.set('event_id', state.item.event.id)
            }
            if (_.isEmpty(state.item.company)) {
                params.set('company_id', '')
            } else {
                params.set('company_id', state.item.company.id)
            }
            if (_.isEmpty(state.item.contact)) {
                params.set('contact_id', '')
            } else {
                params.set('contact_id', state.item.contact.id)
            }

            axios.post('/api/v1/scores/' + state.item.id, params)
                .then(response => {
                    commit('setItem', response.data.data)
                    resolve()
                })
                .catch(error => {
                    let message = error.response.data.message || error.message
                    let errors  = error.response.data.errors

                    dispatch(
                        'Alert/setAlert',
                        { message: message, errors: errors, color: 'danger' },
                        { root: true })

                    reject(error)
                })
                .finally(() => {
                    commit('setLoading', false)
                })
        })
    },
    fetchData({ commit, dispatch }, id) {
        axios.get('/api/v1/scores/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchEventsAll')
    dispatch('fetchContactcompaniesAll')
    dispatch('fetchContactsAll')
    },
    fetchEventsAll({ commit }) {
        axios.get('/api/v1/events')
            .then(response => {
                commit('setEventsAll', response.data.data)
            })
    },
    fetchContactcompaniesAll({ commit }) {
        axios.get('/api/v1/contact-companies')
            .then(response => {
                commit('setContactcompaniesAll', response.data.data)
            })
    },
    fetchContactsAll({ commit }) {
        axios.get('/api/v1/contacts')
            .then(response => {
                commit('setContactsAll', response.data.data)
            })
    },
    setEvent({ commit }, value) {
        commit('setEvent', value)
    },
    setCompany({ commit }, value) {
        commit('setCompany', value)
    },
    setContact({ commit }, value) {
        commit('setContact', value)
    },
    setScore({ commit }, value) {
        commit('setScore', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setEvent(state, value) {
        state.item.event = value
    },
    setCompany(state, value) {
        state.item.company = value
    },
    setContact(state, value) {
        state.item.contact = value
    },
    setScore(state, value) {
        state.item.score = value
    },
    setEventsAll(state, value) {
        state.eventsAll = value
    },
    setContactcompaniesAll(state, value) {
        state.contactcompaniesAll = value
    },
    setContactsAll(state, value) {
        state.contactsAll = value
    },
    
    setLoading(state, loading) {
        state.loading = loading
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
