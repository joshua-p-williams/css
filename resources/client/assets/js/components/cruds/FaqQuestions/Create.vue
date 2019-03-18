<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Questions</h1>
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
                                    <label for="category">Category *</label>
                                    <v-select
                                            name="category"
                                            label="title"
                                            @input="updateCategory"
                                            :value="item.category"
                                            :options="faqcategoriesAll"
                                            />
                                </div>
                                <div class="form-group">
                                    <label for="question_text">Question *</label>
                                    <textarea
                                            rows="3"
                                            class="form-control"
                                            name="question_text"
                                            placeholder="Enter Question *"
                                            :value="item.question_text"
                                            @input="updateQuestion_text"
                                            >
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="answer_text">Answer *</label>
                                    <textarea
                                            rows="3"
                                            class="form-control"
                                            name="answer_text"
                                            placeholder="Enter Answer *"
                                            :value="item.answer_text"
                                            @input="updateAnswer_text"
                                            >
                                    </textarea>
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
        ...mapGetters('FaqQuestionsSingle', ['item', 'loading', 'faqcategoriesAll'])
    },
    created() {
        this.fetchFaqcategoriesAll()
    },
    destroyed() {
        this.resetState()
    },
    methods: {
        ...mapActions('FaqQuestionsSingle', ['storeData', 'resetState', 'setCategory', 'setQuestion_text', 'setAnswer_text', 'fetchFaqcategoriesAll']),
        updateCategory(value) {
            this.setCategory(value)
        },
        updateQuestion_text(e) {
            this.setQuestion_text(e.target.value)
        },
        updateAnswer_text(e) {
            this.setAnswer_text(e.target.value)
        },
        submitForm() {
            this.storeData()
                .then(() => {
                    this.$router.push({ name: 'faq_questions.index' })
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
