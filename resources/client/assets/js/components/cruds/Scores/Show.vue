<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Scores</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">View</h3>
                        </div>

                        <div class="box-body">
                            <back-buttton></back-buttton>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                        <tr>
                                            <th>#</th>
                                            <td>{{ item.id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Event</th>
                                            <td>
                                                <span class="label label-info" v-if="item.event !== null">
                                                    {{ item.event.name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Team</th>
                                            <td>
                                                <span class="label label-info" v-if="item.company !== null">
                                                    {{ item.company.name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Participant</th>
                                            <td>
                                                <span class="label label-info" v-if="item.contact !== null">
                                                    {{ item.contact.name }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Score</th>
                                            <td>{{ item.score }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            // Code...
        }
    },
    created() {
        this.fetchData(this.$route.params.id)
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('ScoresSingle', ['item'])
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions('ScoresSingle', ['fetchData', 'resetState'])
    }
}
</script>


<style scoped>

</style>
