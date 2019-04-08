function initialState() {
    return {
        event: null,
        category: null,
        eventsAll: [],
        categoriesAll: [],
        outstandingSelection: 'category',
        loading: false,
    }
}

const getters = {
    event: state => state.event,
    category: state => state.category,
    outstandingSelection: state => state.outstandingSelection,
    loading: state => state.loading,
    eventsAll: state => state.eventsAll,
    categoriesAll: state => state.categoriesAll,
}

const actions = {
    fetchData({ commit, dispatch }, id) {
        dispatch('fetchEventsAll'),
        dispatch('fetchCategoriesAll')
    },
    fetchEventsAll({ commit }) {
        axios.get('/api/v1/events')
            .then(response => {
                commit('setEventsAll', response.data.data)
            })
    },
    fetchCategoriesAll({ commit }) {
        axios.get('/api/v1/categories')
            .then(response => {
                commit('setCategoriesAll', response.data.data)
            })
    },
    setOutstandingSelection({ commit }, value) {
        commit('setOutstandingSelection', value)
    },
    setEvent({ commit }, value) {
        commit('setEvent', value)
    },
    setCategory({ commit }, value) {
        commit('setCategory', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setOutstandingSelection(state, value) {
        state.outstandingSelection = value
    },

    setEvent(state, value) {
        state.event = value
    },
    setCategory(state, value) {
        state.category = value
    },

    setEventsAll(state, value) {
        state.eventsAll = value
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
