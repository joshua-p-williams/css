<template>
    <div class="row">
        <div class="col-xs-12">

            <div class="box" v-if="!loading && !data">
                <div class="box-body">
                    No Results Submitted
                </div>
            </div>

            <div v-if="!loading && data">
                <div v-for="(eventName, eventSlug) in data.events">
                    <div v-for="(categoryName, categorySlug) in data.event_categories">
                        <div class="box">
                            <div class="box-header with-border box-header-emphasize">
                                <h3><strong>{{eventName}}</strong></h3>
                                <h3><em>{{categoryName}}</em></h3>
                            </div>
                        </div>

                        <div class="box">
                            <div v-for="(groupName, groupSlug) in data.event_groups">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>{{categoryName}}</strong> - <em>{{groupName}}</em></h3>
                                </div>
                                <div class="box-body">
                                    <span v-if="!data.event_results[eventSlug][categorySlug][groupSlug].length">No Results</span>
                                    <div class="has-ties" v-if="data.event_results[eventSlug][categorySlug][groupSlug + '_ties']">
                                        There are ties that still need to be broken!
                                    </div>
                                    <table class="table table-striped table-hover" v-if="data.event_results[eventSlug][categorySlug][groupSlug].length">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th v-for="(columnHeader, columnName) in (groupSlug == 'team' ? data.team_columns : data.individual_columns)">
                                                    {{columnHeader}}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(result, position) in data.event_results[eventSlug][categorySlug][groupSlug]">
                                                <td><span class='badge'>{{ordinalSuffix(result['ranking'])}}</span></td>
                                                <td v-for="(columnHeader, columnName) in (groupSlug == 'team' ? data.team_columns : data.individual_columns)">
                                                    {{result[columnName]}}
                                                    <ul class="participant-list" v-if="columnName == 'team_name'">
                                                        <li v-for="participant in result.participants">
                                                            {{participant.name}}
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <p style="page-break-before: always"></p>
                    </div>
                </div>

            </div>



            <div v-if="!loading && data">
                <div v-for="(categoryName, categorySlug) in data.overall_categories">
                    <div class="box">
                        <div class="box-header with-border box-header-emphasize">
                            <h3><strong>Overall</strong></h3>
                            <h3><em>{{categoryName}}</em></h3>
                        </div>
                    </div>

                    <div class="box">
                        <div v-for="(groupName, groupSlug) in data.overall_groups">
                            <div class="box-header with-border">
                                <h3 class="box-title"><strong>{{categoryName}}</strong> - <em>{{groupName}}</em></h3>
                            </div>
                            <div class="box-body">
                                <span v-if="!data.overall_results[categorySlug][groupSlug].length">No Results</span>
                                <div class="has-ties" v-if="data.overall_results[categorySlug][groupSlug + '_ties']">
                                    There are ties that still need to be broken!
                                </div>
                                <table class="table table-striped table-hover" v-if="data.overall_results[categorySlug][groupSlug].length">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th v-for="(columnHeader, columnName) in (groupSlug == 'team' ? data.team_columns : data.individual_columns)">
                                                {{columnHeader}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(result, position) in data.overall_results[categorySlug][groupSlug]">
                                            <td><span class='badge'>{{ordinalSuffix(result['ranking'])}}</span></td>
                                            <td v-for="(columnHeader, columnName) in (groupSlug == 'team' ? data.team_columns : data.individual_columns)">
                                                {{result[columnName]}}
                                                <ul class="participant-list" v-if="columnName == 'team_name'">
                                                    <li v-for="participant in result.participants">
                                                        {{participant.name}}
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <p style="page-break-before: always"></p>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            query: { sort: null, order: null },
            xprops: {
                module: 'CeremonyResultsIndex',
                route: 'ceremonyResults',
                permission_prefix: 'ceremonyResult_'
            }
        }
    },
    created() {
        this.refresh()
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('CeremonyResultsIndex', ['data', 'loading', 'relationships']),
    },
    watch: {
        query: {
            handler(query) {
                this.setQuery(query)
            },
            deep: true
        },
    },
    methods: {
        ...mapActions('CeremonyResultsIndex', ['fetchData', 'setQuery', 'resetState']),
        refresh: function () {
            this.fetchData();
        },
        ordinalSuffix: function (i) {
            var j = i % 10,
                k = i % 100;
            if (j == 1 && k != 11) {
                return i + "st";
            }
            if (j == 2 && k != 12) {
                return i + "nd";
            }
            if (j == 3 && k != 13) {
                return i + "rd";
            }
            return i + "th";
        }        
    }
}</script>

<style lang="css" scoped>
.box-header.box-header-emphasize {
    background-color: #222d32;
    font-weight: 900;
    color: white;
    text-align: center;
    font-size: 30px;
}
.has-ties {
    background-color: #d83006;
    color: white;
    font-weight: 900;
    text-align: center;
    font-size: 30px;
}
</style>
