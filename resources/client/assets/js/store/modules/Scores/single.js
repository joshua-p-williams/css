function initialState() {
    return {
        item: {
            id: null,
            event: null,
            team: null,
            participant: null,
            score: null,
        },
        eventsAll: [],
        participantteamsAll: [],
        participantsAll: [],
        
        loading: false,
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    eventsAll: state => state.eventsAll,
    participantteamsAll: state => state.participantteamsAll,
    participantsAll: state => state.participantsAll,
    
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
            if (_.isEmpty(state.item.team)) {
                params.set('team_id', '')
            } else {
                params.set('team_id', state.item.team.id)
            }
            if (_.isEmpty(state.item.participant)) {
                params.set('participant_id', '')
            } else {
                params.set('participant_id', state.item.participant.id)
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
            if (_.isEmpty(state.item.team)) {
                params.set('team_id', '')
            } else {
                params.set('team_id', state.item.team.id)
            }
            if (_.isEmpty(state.item.participant)) {
                params.set('participant_id', '')
            } else {
                params.set('participant_id', state.item.participant.id)
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
    dispatch('fetchParticipantteamsAll')
    dispatch('fetchParticipantsAll')
    },
    fetchEventsAll({ commit }) {
        axios.get('/api/v1/events')
            .then(response => {
                commit('setEventsAll', response.data.data)
            })
    },
    fetchParticipantteamsAll({ commit }) {
        axios.get('/api/v1/participant-teams')
            .then(response => {
                commit('setParticipantteamsAll', response.data.data)
            })
    },
    fetchParticipantsAll({ commit }) {
        axios.get('/api/v1/participants')
            .then(response => {
                commit('setParticipantsAll', response.data.data)
            })
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
    setTeam(state, value) {
        state.item.team = value
    },
    setParticipant(state, value) {
        state.item.participant = value
    },
    setScore(state, value) {
        state.item.score = value
    },
    setEventsAll(state, value) {
        state.eventsAll = value
    },
    setParticipantteamsAll(state, value) {
        state.participantteamsAll = value
    },
    setParticipantsAll(state, value) {
        state.participantsAll = value
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
