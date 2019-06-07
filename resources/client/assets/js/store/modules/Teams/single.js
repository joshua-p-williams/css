function initialState() {
    return {
        item: {
            id: null,
            name: null,
            category: null,
            primary_contact_name: null,
            primary_contact_phone: null,
            primary_contact_email: null,
            state: null,
            county: null,
            exclude_team_rank: null,
            exclude_ind_rank: null,
        },
        categoriesAll: [],
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
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

            if (_.isEmpty(state.item.category)) {
                params.set('category_id', '')
            } else {
                params.set('category_id', state.item.category.id)
            }

            axios.post('/api/v1/teams', params)
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

            if (_.isEmpty(state.item.category)) {
                params.set('category_id', '')
            } else {
                params.set('category_id', state.item.category.id)
            }

            axios.post('/api/v1/teams/' + state.item.id, params)
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
        axios.get('/api/v1/teams/' + id)
            .then(response => {
                commit('setItem', response.data.data)
            })

        dispatch('fetchCategoriesAll')
    },
    fetchCategoriesAll({ commit }) {
        axios.get('/api/v1/categories')
            .then(response => {
                commit('setCategoriesAll', response.data.data)
            })
    },
    setName({ commit }, value) {
        commit('setName', value)
    },
    setCategory({ commit }, value) {
        commit('setCategory', value)
    },
    setPrimary_participant_name({ commit }, value) {
        commit('setPrimary_participant_name', value)
    },
    setPrimary_participant_phone({ commit }, value) {
        commit('setPrimary_participant_phone', value)
    },
    setPrimary_participant_email({ commit }, value) {
        commit('setPrimary_participant_email', value)
    },
    setState({ commit }, value) {
        commit('setState', value)
    },
    setCounty({ commit }, value) {
        commit('setCounty', value)
    },
    setExcludeTeamRank({ commit }, value) {
        commit('setExcludeTeamRank', value)
    },
    setExcludeIndRank({ commit }, value) {
        commit('setExcludeIndRank', value)
    },
    resetState({ commit }) {
        commit('resetState')
    },
}

const mutations = {
    setItem(state, item) {
        state.item = item
    },
    setName(state, value) {
        state.item.name = value
    },
    setCategory(state, value) {
        state.item.category = value
    },
    setPrimary_participant_name(state, value) {
        state.item.primary_contact_name = value
    },
    setPrimary_participant_phone(state, value) {
        state.item.primary_contact_phone = value
    },
    setPrimary_participant_email(state, value) {
        state.item.primary_contact_email = value
    },
    setState(state, value) {
        state.item.state = value
    },
    setCounty(state, value) {
        state.item.county = value
    },
    setExcludeTeamRank(state, value) {
        state.item.exclude_team_rank = value
    },
    setExcludeIndRank(state, value) {
        state.item.exclude_ind_rank = value
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
