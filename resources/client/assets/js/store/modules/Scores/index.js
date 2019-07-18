function initialState() {
    return {
        all: [],
        relationships: {
            'event': 'name',
            'team': 'name',
            'participant': 'name',
        },
        query: {},
        event: null,
        team: null,
        participant: null,
        eventsAll: [],
        teamsAll: [],
        participantsAll: [],
        loading: false
    }
}

const getters = {
    data: state => {
        let rows = state.all

        if (state.query.sort) {
            rows = _.orderBy(state.all, state.query.sort, state.query.order)
        }

        return rows.slice(state.query.offset, state.query.offset + state.query.limit)
    },
    total:              state => state.all.length,
    loading:            state => state.loading,
    relationships:      state => state.relationships,
    event:              state => state.event,
    team:               state => state.team,
    participant:        state => state.participant,
    eventsAll:          state => state.eventsAll,
    teamsAll:           state => state.teamsAll,
    participantsAll:    state => state.participantsAll
}

const actions = {
    fetchData({ commit, dispatch, state }, constraints) {
        commit('setLoading', true)

        axios.get('/api/v1/scores', { params: constraints})
            .then(response => {
                commit('setAll', response.data.data)
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
    destroyData({ commit, state }, id) {
        axios.delete('/api/v1/scores/' + id)
            .then(response => {
                commit('setAll', state.all.filter((item) => {
                    return item.id != id
                }))
            })
            .catch(error => {
                message = error.response.data.message || error.message
                commit('setError', message)
                console.log(message)
            })
    },
    setQuery({ commit }, value) {
        commit('setQuery', purify(value))
    },
    resetState({ commit }) {
        commit('resetState')
    },
    setEvent({ commit }, value) {
        commit('setEvent', value)
    },
    setTeam({ commit }, value) {
        commit('setTeam', value)
    },
    setParticipant({ commit }, value) {
        commit('setParticipant', value)
    },
    fetchEventsAll({ commit }) {
        axios.get('/api/v1/events')
            .then(response => {
                commit('setEventsAll', response.data.data)
            })
    },
    fetchTeamsAll({ commit }) {
        axios.get('/api/v1/teams')
            .then(response => {
                commit('setTeamsAll', response.data.data)
            })
    },
    fetchParticipantsAll({ commit }) {
        axios.get('/api/v1/participants')
            .then(response => {
                commit('setParticipantsAll', response.data.data)
            })
    }    
}

const mutations = {
    setAll(state, items) {
        state.all = items
    },
    setLoading(state, loading) {
        state.loading = loading
    },
    setQuery(state, query) {
        state.query = query
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    },

    setEvent(state, value) {
        state.event = value
    },
    setTeam(state, value) {
        state.team = value
    },
    setParticipant(state, value) {
        state.participant = value
    },

    setEventsAll(state, value) {
        state.eventsAll = value
    },
    setTeamsAll(state, value) {
        state.teamsAll = value
    },
    setParticipantsAll(state, value) {
        state.participantsAll = value
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
