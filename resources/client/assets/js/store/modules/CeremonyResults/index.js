function initialState() {
    return {
        results: null,
        relationships: {
        },
        query: {},
        loading: false
    }
}

const getters = {
    data: state => {
        return state.results;
    },
    loading:       state => state.loading,
    relationships: state => state.relationships
}

const actions = {
    fetchData({ commit, state }) {
        commit('setLoading', true)

        axios.get('/api/v1/ceremonyResults')
            .then(response => {
                commit('setResults', response.data)
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
            .finally(() => {
                commit('setLoading', false)
            })
    },
    setQuery({ commit }, value) {
        commit('setQuery', purify(value))
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setResults(state, results) {
        state.results = results
    },
    setLoading(state, loading) {
        state.loading = loading
    },
    setQuery(state, query) {
        state.query = query
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
