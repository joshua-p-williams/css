<template>
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Dashboard</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Scores Outstanding</h3><br />
                            <span>See what is still waiting to be scored</span>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm" @click="selectCategory">
                                    <i class="fa fa-university"></i> Category
                                </button>
                                <button type="button" class="btn btn-default btn-sm" @click="selectTeam">
                                    <i class="fa fa-users"></i> Team
                                </button>
                                <button type="button" class="btn btn-default btn-sm" @click="selectIndividual">
                                    <i class="fa fa-user-plus"></i> Individual
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <category-completion v-if="selection == 'category'"></category-completion>
            <team-completion v-if="selection == 'team'"></team-completion>
            <individual-completion v-if="selection == 'individual'"></individual-completion>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data() {
        return {
            selection: 'category',
        }
    },
    methods: {
        selectCategory: function () {
            this.selection = 'category';
        },
        selectTeam: function () {
            this.selection = 'team';
        },
        selectIndividual: function () {
            this.selection = 'individual';
        },
    }
}
</script>


<style scoped>

</style>
