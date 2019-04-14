function initialState() {
    return {
        item: {
            id: null,
            team: null,
            category: null,
            name: null,
            phone: null,
            email: null,
            address: null,
        },
        TeamsAll: [],
        categoriesAll: [],
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    TeamsAll: state => state.TeamsAll,
    categoriesAll: state => state.categoriesAll,
    
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

            if (_.isEmpty(state.item.team)) {
                params.set('team_id', '')
            } else {
                params.set('team_id', state.item.team.id)
            }
            if (_.isEmpty(state.item.category)) {
                params.set('category_id', '')
            } else {
                params.set('category_id', state.item.category.id)
            }

            axios.post('/api/v1/participants', params)
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

            if (_.isEmpty(state.item.team)) {
                params.set('team_id', '')
            } else {
                params.set('team_id', state.item.team.id)
            }
            if (_.isEmpty(state.item.category)) {
                params.set('category_id', '')
            } else {
                params.set('category_id', state.item.category.id)
            }

            axios.post('/api/v1/participants/' + state.item.id, params)
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
        axios.get('/api/v1/participants/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchTeamsAll')
    dispatch('fetchCategoriesAll')
    },
    fetchTeamsAll({ commit }) {
        axios.get('/api/v1/participant-teams')
            .then(response => {
                commit('setTeamsAll', response.data.data)
            })
    },
    fetchCategoriesAll({ commit }) {
        axios.get('/api/v1/categories')
            .then(response => {
                commit('setCategoriesAll', response.data.data)
            })
    },
    setTeam({ commit }, value) {
        commit('setTeam', value)
    },
    setCategory({ commit }, value) {
        commit('setCategory', value)
    },
    setName({ commit }, value) {
        commit('setName', value)
    },
    setPhone({ commit }, value) {
        commit('setPhone', value)
    },
    setEmail({ commit }, value) {
        commit('setEmail', value)
    },
    setAddress({ commit }, value) {
        commit('setAddress', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setTeam(state, value) {
        state.item.team = value
    },
    setCategory(state, value) {
        state.item.category = value
    },
    setName(state, value) {
        state.item.name = value
    },
    setPhone(state, value) {
        state.item.phone = value
    },
    setEmail(state, value) {
        state.item.email = value
    },
    setAddress(state, value) {
        state.item.address = value
    },
    setTeamsAll(state, value) {
        state.TeamsAll = value
    },
    setCategoriesAll(state, value) {
        state.categoriesAll = value
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
