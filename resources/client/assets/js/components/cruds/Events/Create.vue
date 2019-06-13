<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Events</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Create</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            placeholder="Enter Name *"
                                            :value="item.name"
                                            @input="updateName"
                                            >
                                </div>
                            </div>

                            <div class="box-footer">
                                <vue-button-spinner
                                        class="btn btn-primary btn-sm"
                                        :isLoading="loading"
                                        :disabled="loading"
                                        >
                                    Save
                                </vue-button-spinner>
                            </div>
                        </div>
                    </form>
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
    computed: {
        ...mapGetters('EventsSingle', ['item', 'loading']),
        useInTb1: {
            get() {
                return this.$store.state.EventsSingle.item.use_in_tb_1;
            },
            set(value) {
                this.setUseInTb1(value);
            }
        },
        useInTb2: {
            get() {
                return this.$store.state.EventsSingle.item.use_in_tb_2;
            },
            set(value) {
                this.setUseInTb2(value);
            }
        },
        useInTb3: {
            get() {
                return this.$store.state.EventsSingle.item.use_in_tb_3;
            },
            set(value) {
                this.setUseInTb3(value);
            }
        },
        useInTb4: {
            get() {
                return this.$store.state.EventsSingle.item.use_in_tb_4;
            },
            set(value) {
                this.setUseInTb4(value);
            }
        },
    },
    created() {
        // Code ...
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('EventsSingle', ['storeData', 'resetState', 'setName', 'setUseInTb1', 'setUseInTb2', 'setUseInTb3', 'setUseInTb4']),
        updateName(e) {
            this.setName(e.target.value)
        },
        submitForm() {
            this.storeData()
                .then(() => {
                    this.$router.push({ name: 'events.index' })
                    this.$eventHub.$emit('create-success')
                })
                .catch((error) => {
                    console.error(error)
                })
        }
    }
}
</script>


<style scoped>

</style>
