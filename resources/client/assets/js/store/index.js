import Vue from 'vue'
import Vuex from 'vuex'
import Alert from './modules/alert'
import ChangePassword from './modules/change_password'
import Rules from './modules/rules'
import HomeIndex from './modules/Home'
import CategoryCompletionsIndex from './modules/CategoryCompletions'
import TeamCompletionsIndex from './modules/TeamCompletions'
import IndividualCompletionsIndex from './modules/IndividualCompletions'
import OverallResultsIndex from './modules/OverallResults'
import TeamResultsIndex from './modules/TeamResults'
import IndividualResultsIndex from './modules/IndividualResults'
import PermissionsIndex from './modules/Permissions'
import PermissionsSingle from './modules/Permissions/single'
import RolesIndex from './modules/Roles'
import RolesSingle from './modules/Roles/single'
import UsersIndex from './modules/Users'
import UsersSingle from './modules/Users/single'
import FaqCategoriesIndex from './modules/FaqCategories'
import FaqCategoriesSingle from './modules/FaqCategories/single'
import FaqQuestionsIndex from './modules/FaqQuestions'
import FaqQuestionsSingle from './modules/FaqQuestions/single'
import CategoriesIndex from './modules/Categories'
import CategoriesSingle from './modules/Categories/single'
import EventsIndex from './modules/Events'
import EventsSingle from './modules/Events/single'
import ParticipantTeamsIndex from './modules/ParticipantTeams'
import ParticipantTeamsSingle from './modules/ParticipantTeams/single'
import ParticipantsIndex from './modules/Participants'
import ParticipantsSingle from './modules/Participants/single'
import ScoresIndex from './modules/Scores'
import ScoresSingle from './modules/Scores/single'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        Alert,
        ChangePassword,
        Rules,
        HomeIndex,
        CategoryCompletionsIndex,
        TeamCompletionsIndex,
        IndividualCompletionsIndex,
        OverallResultsIndex,
        TeamResultsIndex,
        IndividualResultsIndex,
        PermissionsIndex,
        PermissionsSingle,
        RolesIndex,
        RolesSingle,
        UsersIndex,
        UsersSingle,
        FaqCategoriesIndex,
        FaqCategoriesSingle,
        FaqQuestionsIndex,
        FaqQuestionsSingle,
        CategoriesIndex,
        CategoriesSingle,
        EventsIndex,
        EventsSingle,
        ParticipantTeamsIndex,
        ParticipantTeamsSingle,
        ParticipantsIndex,
        ParticipantsSingle,
        ScoresIndex,
        ScoresSingle,
    },
    strict: debug,
})
