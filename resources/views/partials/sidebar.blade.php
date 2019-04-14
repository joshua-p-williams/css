@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li>
                <a href="{{ url('/') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">@lang('quickadmin.qa_dashboard')</span>
                </a>
            </li>

            <li class="treeview" v-if="$can('user_management_access')">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>@lang('quickadmin.user-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li v-if="$can('permission_access')">
                        <router-link :to="{ name: 'permissions.index' }">
                            <i class="fa fa-briefcase"></i>
                            <span>@lang('quickadmin.permissions.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('role_access')">
                        <router-link :to="{ name: 'roles.index' }">
                            <i class="fa fa-briefcase"></i>
                            <span>@lang('quickadmin.roles.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('user_access')">
                        <router-link :to="{ name: 'users.index' }">
                            <i class="fa fa-user"></i>
                            <span>@lang('quickadmin.users.title')</span>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="treeview" v-if="$can('faq_management_access')">
                <a href="#">
                    <i class="fa fa-question"></i>
                    <span>@lang('quickadmin.faq-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li v-if="$can('faq_category_access')">
                        <router-link :to="{ name: 'faq_categories.index' }">
                            <i class="fa fa-briefcase"></i>
                            <span>@lang('quickadmin.faq-categories.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('faq_question_access')">
                        <router-link :to="{ name: 'faq_questions.index' }">
                            <i class="fa fa-question"></i>
                            <span>@lang('quickadmin.faq-questions.title')</span>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="treeview" v-if="$can('competition_access')">
                <a href="#">
                    <i class="fa fa-flag-checkered"></i>
                    <span>@lang('quickadmin.competition.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li v-if="$can('category_access')">
                        <router-link :to="{ name: 'categories.index' }">
                            <i class="fa fa-university"></i>
                            <span>@lang('quickadmin.categories.title')</span>
                        </router-link>
                    </li>
                    <li v-if="$can('event_access')">
                        <router-link :to="{ name: 'events.index' }">
                            <i class="fa fa-bolt"></i>
                            <span>@lang('quickadmin.events.title')</span>
                        </router-link>
                    </li>
                    <li class="treeview" v-if="$can('team_management_access')">
                        <a href="#">
                            <i class="fa fa-address-card"></i>
                            <span>@lang('quickadmin.team-management.title')</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li v-if="$can('team_access')">
                                <router-link :to="{ name: 'teams.index' }">
                                    <i class="fa fa-users"></i>
                                    <span>@lang('quickadmin.participant-teams.title')</span>
                                </router-link>
                            </li>
                            <li v-if="$can('participant_access')">
                                <router-link :to="{ name: 'participants.index' }">
                                    <i class="fa fa-user-plus"></i>
                                    <span>@lang('quickadmin.participants.title')</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="$can('score_access')">
                        <router-link :to="{ name: 'scores.index' }">
                            <i class="fa fa-check-circle"></i>
                            <span>@lang('quickadmin.scores.title')</span>
                        </router-link>
                    </li>
                </ul>
            </li>

            <li>
                <router-link :to="{ name: 'auth.change_password' }">
                    <i class="fa fa-key"></i>
                    <span class="title">@lang('quickadmin.qa_change_password')</span>
                </router-link>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('quickadmin.qa_logout')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
